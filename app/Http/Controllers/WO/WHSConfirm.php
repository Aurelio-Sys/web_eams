<?php

namespace App\Http\Controllers\WO;

use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotifWarehousetoEng;
use App\Services\CreateTempTable;
use App\Services\QxtendServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Psy\Command\DumpCommand;

class WHSConfirm extends Controller
{
    private function httpHeader($req)
    {
        return array(
            'Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SOAPAction: ""',        // jika tidak pakai SOAPAction, isinya harus ada tanda petik 2 --> ""
            'Content-length: ' . strlen(preg_replace("/\s+/", " ", $req))
        );
    }

    public function browse(Request $request)
    {
        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

            if(Session::get('role') == 'ADMIN' || Session::get('role') == 'WHS'){
                $data = DB::table('wo_mstr')
                    ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority','wd_sp_flag')
                    ->join('wo_dets_sp', 'wo_dets_sp.wd_sp_wonumber','wo_mstr.wo_number')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                    ->where('wo_status', 'released')
                    ->where('wd_sp_flag','=', 1)
                    ->groupBy('wo_number')
                    ->orderby('wo_system_create', 'desc');
                
            }else{
                return view('errors.401');
            }
    
            
    
            if ($request->s_nomorwo) {
                $data->where('wo_number', 'like', '%'.$request->s_nomorwo.'%');
            }
    
            if ($request->s_asset) {
                $data->where('wo_asset_code', '=', $request->s_asset);
            }
    
            if ($request->s_priority) {
                $data->where('wo_priority', '=', $request->s_priority);
            }
    
            $data = $data->paginate(10);

            // dd($data,Session::get('role'));

        return view('workorder.whsconfirm-browse', ['asset1' => $asset1, 'data' => $data]);
    }

    public function detailwhs($id)
    {

        // dd($id);
        $data = DB::table('wo_mstr')
            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
            ->where('wo_number', '=', $id)
            ->first();

        $sparepart_detail = DB::table('wo_dets_sp')
                            ->join('sp_mstr','sp_mstr.spm_code','wo_dets_sp.wd_sp_spcode')
                            ->where('wd_sp_wonumber','=',$id)
                            ->get();



        $datalocsupply = DB::table('inp_supply')
                        ->where('inp_asset_site', '=', $data->wo_site)
                        ->get();

        
        


        return view('workorder.whsconf-detail', compact(
            'data',
            'sparepart_detail',
            'datalocsupply'
        ));
    }

    public function whssubmit(Request $req){
        // dd($req->all()); 

        //ambil data dari qad untuk pengecekan kembali stock inventory source di QAD
        Schema::dropIfExists('temp_table');
        Schema::create('temp_table', function ($table) {
            $table->string('t_part');
            $table->string('t_site');
            $table->string('t_loc')->nullable();
            $table->string('t_lot')->nullable();
            $table->decimal('t_qtyoh', 10, 2);
            $table->temporary();
        });

        foreach($req->hidden_spcode as $index => $spcode){
            $getActualStockSource = (new WSAServices())->wsacekstoksource($spcode,$req->hidden_sitefrom[$index],$req->hidden_locfrom[$index],$req->hidden_lotfrom[$index]);

            if ($getActualStockSource === false) {
                toast('WSA Connection Failed', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {

                // jika hasil WSA ke QAD tidak ditemukan
                if ($getActualStockSource[1] == "false") {
                    toast('Something went wrong with the data', 'error')->persistent('Dismiss');
                    return redirect()->back();
                }


                // jika hasil WSA ditemukan di QAD, ambil dari QAD kemudian disimpan dalam array untuk nantinya dikelompokan lagi data QAD tersebut berdasarkan part dan site
                
                $resultWSA = $getActualStockSource[0];
 
                //kumpulkan hasilnya ke dalam 1 array sebagai penampung list location dan lot from
                foreach($resultWSA as $thisresult){
                    DB::table('temp_table')
                        ->insert([
                            't_part' => $thisresult->t_part,
                            't_site' => $thisresult->t_site,
                            't_loc' => $thisresult->t_loc,
                            't_lot' => $thisresult->t_lot,
                            't_qtyoh' => $thisresult->t_qtyoh,
                        ]);
                }
                
            }

        }

        $dataStockQAD = DB::table('temp_table')
                    ->get();


        Schema::dropIfExists('temp_table');

        DB::beginTransaction();

        try{

            $notEnough = "";
            foreach($req->qtytotransfer as $index => $qtytotransfer){
                foreach($dataStockQAD as $source){
                    if($req->hidden_spcode[$index] == $source->t_part && $req->hidden_sitefrom[$index] == $source->t_site && $req->hidden_locfrom[$index] == $source->t_loc && $req->hidden_lotfrom[$index] == $source->t_lot){
                        if(floatval($req->qtytotransfer[$index]) > floatval($source->t_qtyoh)){
                            //jika tidak cukup berikan alert
                            // dump($source->t_qtyoh);
                            $notEnough .= $req->hidden_spcode[$index] . ", ";
                        }
                    }
                }
            }
            
            if ($notEnough != "") {
                $notEnough = rtrim($notEnough, ", "); // hapus koma terakhir
                alert()->html('<u><b>Alert!</b></u>',"<b>The qty to be transferred does not have sufficient stock for the following spare part code :</b><br>".$notEnough."",'error')->persistent('Dismiss');
                return redirect()->back();
            }

            /* Qxtend Transfer Single Item */
            $qxwsa = ModelsQxwsa::first();

            // Var Qxtend
            $qxUrl          = $qxwsa->qx_url; // Edit Here

            $qxRcv          = $qxwsa->qx_rcv;

            $timeout        = 0;

            $domain         = $qxwsa->wsas_domain;

            // XML Qextend ** Edit Here

            // dd($qxRcv);

            $qdocHead = '  
            <soapenv:Envelope xmlns="urn:schemas-qad-com:xml-services"
            xmlns:qcom="urn:schemas-qad-com:xml-services:common"
            xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsa="http://www.w3.org/2005/08/addressing">
            <soapenv:Header>
                <wsa:Action/>
                <wsa:To>urn:services-qad-com:'.$qxRcv.'</wsa:To>
                <wsa:MessageID>urn:services-qad-com::'.$qxRcv.'</wsa:MessageID>
                <wsa:ReferenceParameters>
                <qcom:suppressResponseDetail>true</qcom:suppressResponseDetail>
                </wsa:ReferenceParameters>
                <wsa:ReplyTo>
                <wsa:Address>urn:services-qad-com:</wsa:Address>
                </wsa:ReplyTo>
            </soapenv:Header>
            <soapenv:Body>
                <transferInvSingleItem>
                <qcom:dsSessionContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>domain</qcom:propertyName>
                    <qcom:propertyValue>'.$domain.'</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>scopeTransaction</qcom:propertyName>
                    <qcom:propertyValue>true</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>version</qcom:propertyName>
                    <qcom:propertyValue>ERP3_1</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>mnemonicsRaw</qcom:propertyName>
                    <qcom:propertyValue>false</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>username</qcom:propertyName>
                    <qcom:propertyValue>mfg</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>password</qcom:propertyName>
                    <qcom:propertyValue></qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>action</qcom:propertyName>
                    <qcom:propertyValue/>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>entity</qcom:propertyName>
                    <qcom:propertyValue/>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>email</qcom:propertyName>
                    <qcom:propertyValue/>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>emailLevel</qcom:propertyName>
                    <qcom:propertyValue/>
                    </qcom:ttContext>
                </qcom:dsSessionContext>
                <dsItem>';

            $qdocBody = '';
            
            /* bisa foreach per item dari sini */

            foreach($req->qtytotransfer as $index => $qtyfromweb){
                if($qtyfromweb > 0 ){ //jika qty to transfer yang diisi user dari menu wo transfer lebih dari 0, baru lakukan qxtend transfer single item
                    $qdocBody .= '<item>
                            <part>'.$req->hidden_spcode[$index].'</part>
                            <itemDetail>
                                <lotserialQty>'.$qtyfromweb.'</lotserialQty>
                                <nbr>'.$req->hide_wonum.'</nbr>
                                <siteFrom>'.$req->hidden_sitefrom[$index].'</siteFrom>
                                <locFrom>'.$req->hidden_locfrom[$index].'</locFrom>
                                <lotserFrom>'.$req->hidden_lotfrom[$index].'</lotserFrom>
                                <siteTo>'.$req->hidden_siteto[$index].'</siteTo>
                                <locTo>'.$req->hidden_locto[$index].'</locTo>
                            </itemDetail>
                        </item>';


                    DB::table('wo_dets_sp')
                        ->where('wd_sp_wonumber','=', $req->hide_wonum)
                        ->where('wd_sp_spcode', '=', $req->hidden_spcode[$index])
                        ->update([
                            'wd_sp_flag' => false,
                            'wd_sp_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                }
            }
            
            // <rmks>'.$dqx->wo_dets_nbr.'</rmks>
            /* endforeach disini */
            // dd($qdocBody);
            $qdocfooter =   '</dsItem>
                            </transferInvSingleItem>
                        </soapenv:Body>
                    </soapenv:Envelope>';

            $qdocRequest = $qdocHead . $qdocBody . $qdocfooter;

            // dd($qdocRequest);
            
            $curlOptions = array(
                CURLOPT_URL => $qxUrl,
                CURLOPT_CONNECTTIMEOUT => $timeout,        // in seconds, 0 = unlimited / wait indefinitely.
                CURLOPT_TIMEOUT => $timeout + 120, // The maximum number of seconds to allow cURL functions to execute. must be greater than CURLOPT_CONNECTTIMEOUT
                CURLOPT_HTTPHEADER => $this->httpHeader($qdocRequest),
                CURLOPT_POSTFIELDS => preg_replace("/\s+/", " ", $qdocRequest),
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            );

            $getInfo = '';
            $httpCode = 0;
            $curlErrno = 0;
            $curlError = '';


            $qdocResponse = '';

            $curl = curl_init();
            if ($curl) {
                curl_setopt_array($curl, $curlOptions);
                $qdocResponse = curl_exec($curl);           // sending qdocRequest here, the result is qdocResponse.
                //
                $curlErrno = curl_errno($curl);
                $curlError = curl_error($curl);
                $first = true;
                foreach (curl_getinfo($curl) as $key => $value) {
                    if (gettype($value) != 'array') {
                        if (!$first) $getInfo .= ", ";
                        $getInfo = $getInfo . $key . '=>' . $value;
                        $first = false;
                        if ($key == 'http_code') $httpCode = $value;
                    }
                }
                curl_close($curl);
            }

            if (is_bool($qdocResponse)) {

                DB::rollBack();
                toast('Something Wrong with Qxtend', 'error');
                /* jika qxtend servicenya mati */
            }
            $xmlResp = simplexml_load_string($qdocResponse);
            $xmlResp->registerXPathNamespace('soapenv', 'urn:schemas-qad-com:xml-services:common');
            $qdocFault = '';
            $qdocFault = $xmlResp->xpath('//soapenv:faultstring');
            // dd($qdocFault);

            if(!empty($qdocFault)){
                DB::rollBack();

                $qdocFault = (string) $xmlResp->xpath('//soapenv:faultstring')[0];

                alert()->html('<u><b>Error Response Qxtend</b></u>',"<b>Detail Response Qxtend :</b><br>".$qdocFault."",'error')->persistent('Dismiss');
                return redirect()->back();
            }

            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



            if ($qdocResult == "success" or $qdocResult == "warning") {
                /* jika response sukses atau warning maka menyimpan data jika sudah di transferr ke qad*/
                $wonumber = $req->hide_wonum;
                //kirim notifikasi kepada para engineer yg mengerjakan wo tersebut bahwa spare part yg tidak cukup sudah ditransfer ke inventory supply
                SendNotifWarehousetoEng::dispatch($wonumber);
            } else {

                //jika qtend mengembalikan pesan error 

                DB::rollBack();
                $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                $outputerror = '';
                foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                    $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                    $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                    $outputerror .= "&bull;  ".$context . " - " . $desc . "<br>";
                }

                // dd('stop');
                // $qdocMsgDesc = $xmlResp->xpath('//ns3:tt_msg_desc');
                // $output = '';

                // foreach($qdocMsgDesc as $datas){
                // 	if(str_contains($datas, 'ERROR:')){
                // 		$output .= $datas. ' <br> ';
                // 	}
                // }

                // $output = substr($output, 0, -6);

                alert()->html('<u><b>Error Response Qxtend</b></u>',"<b>Detail Response Qxtend :</b><br>".$outputerror."",'error')->persistent('Dismiss');
                return redirect()->back();
                /* jika qxtend response error */
            }

            DB::commit();

            toast('Work Order Spare Part Transfer for '.$req->hide_wonum.' Successfuly !', 'success');
            return redirect()->route('browseWhconfirm');
            
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Confirm Failed', 'error');
            return redirect()->route('browseWhconfirm');
        }
    }

    public function searchlot(Request $req) {
        // dd($req->all());
        // load stock

        if ($req->ajax()) {

            $domain = ModelsQxwsa::first();

            $stokdata = (new WSAServices())->wsastok($domain->wsas_domain,$req->t_site);

            if ($stokdata === false) {
                toast('WSA Failed', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {

                if ($stokdata[1] == "false") {
                    toast('Stok tidak ditemukan', 'error')->persistent('Dismiss');
                    return redirect()->back();
                } else {

                    Schema::create('temp_stok', function ($table) {
                        $table->increments('id');
                        $table->string('stok_site');
                        $table->string('stok_loc');
                        $table->string('stok_part');
                        $table->decimal('stok_qty',13,2);
                        $table->string('stok_lot');
                        $table->string('stok_exp');
                        $table->string('stok_date');
                        $table->temporary();
                    });

                    foreach ($stokdata[0] as $datas) {
                        DB::table('temp_stok')->insert([
                            'stok_site' => $datas->t_site,
                            'stok_loc' => $datas->t_loc,
                            'stok_part' => $datas->t_part,
                            'stok_qty' => $datas->t_qty,
                            'stok_lot' => $datas->t_lot,
                            'stok_exp' => $datas->t_exp,
                            'stok_date' => $datas->t_date,
                        ]);
                    }

                    $qstok = DB::table('temp_stok')
                        ->where('stok_site','=',$req->t_site)
                        ->where('stok_part','=',$req->t_part)
                        ->orderBy('stok_date')
                        ->get();

                    $output = '<option value="" >Select</option>';
                    foreach($qstok as $data){
                        dump($data->stok_site);
                        $output .= '<option value="'.$data->stok_lot.','.$data->stok_loc.'" >'.$data->stok_lot.'-- Loc : '.$data->stok_loc.'</option>';
                    }

                    Schema::dropIfExists('temp_stok');
                }
            }
            dump($output);
            return response($output);
        }
    }

    public function getwsastockfrom(Request $req){
        $assetsite = $req->get('assetsite');
        $spcode = $req->get('spcode');

        //ambil data dari tabel inc_source berdasarkan asset site nya
        $getSource = DB::table('inc_source')
                        ->where('inc_asset_site','=', $assetsite)
                        ->get();

        $data = [];

        foreach($getSource as $invsource){
            $qadsourcedata = (new WSAServices())->wsagetsource($spcode,$invsource->inc_source_site,$invsource->inc_loc);

            if ($qadsourcedata === false) {
                toast('WSA Connection Failed', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {

                // jika hasil WSA ke QAD tidak ditemukan
                if ($qadsourcedata[1] !== "false") {

                     // jika hasil WSA ditemukan di QAD, ambil dari QAD kemudian disimpan dalam array untuk nantinya dikelompokan lagi data QAD tersebut berdasarkan part dan site
                
                    $resultWSA = $qadsourcedata[0];
    
                    //kumpulkan hasilnya ke dalam 1 array sebagai penampung list location dan lot from
                    foreach($resultWSA as $thisresult){
                        array_push($data, [
                            't_domain' => (string) $thisresult->t_domain,
                            't_part' => (string) $thisresult->t_part,
                            't_site' => (string) $thisresult->t_site,
                            't_loc' => (string) $thisresult->t_loc,
                            't_lot' => (string) $thisresult->t_lot,
                            't_qtyoh' => number_format((float) $thisresult->t_qtyoh, 2),
                        ]);
                    }

                }


               
                
            }
        }

        return response()->json($data);
    }
}
