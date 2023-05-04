<?php

namespace App\Http\Controllers\WO;

use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;

use App\Http\Controllers\Controller;
use App\Services\CreateTempTable;
use App\Services\QxtendServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

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
                        ->where('inp_asset_site', '=', $data->asset_site)
                        ->get();

        
        


        return view('workorder.whsconf-detail', compact(
            'data',
            'sparepart_detail',
            'datalocsupply'
        ));
    }

    public function whssubmit(Request $req){
        dd($req->all());
        DB::beginTransaction();

        try{
            // cek qty
            foreach($req->partneed as $a => $key){
                if($req->tick[$a] == 1) {
                    if($req->qtyconf[$a] > $req->qtystok[$a]) {
                        toast('Quantity Error !', 'error');
                        return redirect()->route('browseWhconfirm');
                    }
                }
            }

            $cekstatus = "";  //digunakan untuk melakukan cek apakah semua line sudah dikonfirm atau belum
            $cekqty = ""; //digunakan untuk melakukan cek apakah qty yang diconfirm setiap line sudah sesuai dengan qty request
            foreach($req->partneed as $a => $key){
                if ($req->tick[$a] == 1) {

                    $vlot = explode(",", $req->t_lot[$a]);

                    /* Input histori transfer, agar bisa menyimpan qty confirm jika partial */
                    if ($req->whsconf[$a] == 0) {
                        DB::table('wowh_det')
                        ->insert([
                            'wowh_wonbr' => $req->hide_wonum,
                            'wowh_line' => $req->line[$a],
                            'wowh_spcode' => $req->partneed[$a],
                            'wowh_spdesc' => $req->partdesc[$a],
                            'wowh_sitefrom' => $req->t_site[$a],
                            'wowh_locfrom' => $req->t_loc[$a],
                            'wowh_siteto' => $req->rlssite[$a],
                            'wowh_locto' => $req->rlsloc[$a],
                            'wowh_lot' => $vlot[0],
                            'wowh_qty_req' => $req->qtyrequest[$a],
                            'wowh_qty_conf' => $req->qtyconf[$a],
                            'wowh_qx' => 'no',
                            'wowh_user' => $req->session()->get('username'),
                            'wowh_created_at' => Carbon::now()->toDateTimeString(),
                            'wowh_updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                    }

                    /* Jika qty yang diconfirm hanya sebagian, maka belum ada tanggal dan qty conf di tabel wo_dets */
                    if($req->qtyrequest[$a] == $req->qtyconf[$a] + $req->qtymove[$a]) {
                        $vconf = 1;
                        $vdate = Carbon::now()->toDateTimeString();
                    } else {
                        $vconf = 0;
                        $vdate = "";
                        $cekqty = "nol"; 
                    }

                    DB::table('wo_dets')
                        ->where('wo_dets_nbr', $req->hide_wonum)
                        ->where('wo_dets_rc', $req->repcode[$a])
                        ->where('wo_dets_line', $req->line[$a])
                        ->where('wo_dets_ins', $req->inscode[$a])
                        ->where('wo_dets_sp', $req->partneed[$a])
                        ->update([
                        'wo_dets_wh_site' => $req->t_site[$a],
                        'wo_dets_wh_loc' => $req->t_loc[$a],
                        'wo_dets_wh_lot' => $vlot[0],
                        'wo_dets_wh_qty' => $req->qtyconf[$a] + $req->qtymove[$a],
                        'wo_dets_wh_conf' => $vconf,
                        'wo_dets_wh_tosite' => $req->rlssite[$a],
                        'wo_dets_wh_toloc' => $req->rlsloc[$a],
                        'wo_dets_wh_date' =>$vdate,
                        'wo_dets_wh_user' => $req->session()->get('username'),
                    ]); 

                } else {
                    $cekstatus = "nol";
                }
                
            }    
            
            if ($cekstatus == "" && $cekqty == "") {
                DB::table('wo_mstr')
                    ->where('wo_nbr',$req->hide_wonum)
                    ->update([
                        'wo_status' => 'open',
                    ]);
            }
            
            /* cek apakah semua qty 0 atau tidak, jika semua qty 0, maka tetap bisa di confirm. mungkin tidak ada item numbernya */
            /* $qx = DB::table('wo_dets')
                ->where('wo_dets_nbr','=',$req->hide_wonum)
                ->where('wo_dets_wh_conf','=',1)
                ->where('wo_dets_wh_qx','=','no')
                ->where('wo_dets_wh_qty','<>',0); */
            $qx = DB::table('wowh_det')
                ->where('wowh_wonbr','=',$req->hide_wonum)
                ->where('wowh_qx','=','no');

            // dd($qx);

            if($qx->count() > 0) {
                /* ini qxtend transfer single item */

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
                
                foreach($qx->get() as $dqx) {
                    /* $qdocBody .= '<item>
                                    <part>'.$dqx->wo_dets_sp.'</part>
                                    <itemDetail>
                                        <lotserialQty>'.$dqx->wo_dets_wh_qty.'</lotserialQty>
                                        <nbr>'.$dqx->wo_dets_nbr.'</nbr>
                                        <siteFrom>'.$dqx->wo_dets_wh_site.'</siteFrom>
                                        <locFrom>'.$dqx->wo_dets_wh_loc.'</locFrom>
                                        <lotserFrom>'.$dqx->wo_dets_wh_lot.'</lotserFrom>
                                        <siteTo>'.$dqx->wo_dets_wh_tosite.'</siteTo>
                                        <locTo>'.$dqx->wo_dets_wh_toloc.'</locTo>
                                    </itemDetail>
                                </item>'; */
                    $qdocBody .= '<item>
                                <part>'.$dqx->wowh_spcode.'</part>
                                <itemDetail>
                                    <lotserialQty>'.$dqx->wowh_qty_conf.'</lotserialQty>
                                    <nbr>'.$dqx->wowh_wonbr.'</nbr>
                                    <siteFrom>'.$dqx->wowh_sitefrom.'</siteFrom>
                                    <locFrom>'.$dqx->wowh_locfrom.'</locFrom>
                                    <lotserFrom>'.$dqx->wowh_lot.'</lotserFrom>
                                    <siteTo>'.$dqx->wowh_siteto.'</siteTo>
                                    <locTo>'.$dqx->wowh_locto.'</locTo>
                                </itemDetail>
                            </item>';
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
                    /* DB::table('wo_dets')
                        ->where('wo_dets_nbr',$req->hide_wonum)
                        ->where('wo_dets_wh_conf','=',1)
                        ->where('wo_dets_wh_qx','=','no')
                        ->update([
                            'wo_dets_wh_qx' => 'yes',
                    ]); */
                    DB::table('wowh_det')
                        ->where('wowh_wonbr','=',$req->hide_wonum)
                        ->where('wowh_qx','=','no')
                        ->update([
                            'wowh_qx' => 'yes'
                        ]);
                } else {

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
                    return redirect()->route('browseWhconfirm');
                    /* jika qxtend response error */
                }
            } /* endif($qx->count()) */ 

            $cekpartial = DB::table('wo_dets')
                        ->where('wo_dets_nbr', $req->hide_wonum)
                        ->where('wo_dets_wh_qx', 'no')
                        ->get();

            /* jika masih ada yang no berarti pop up message partial/ jika sudah diconfirm semua berarti pop up message complete */
            $thisstatus = "";
            if($cekpartial->count() > 0){
                $thisstatus = "Partial";
            }else{
                $thisstatus = "Complete";
            }

            DB::commit();

            toast('Confirm '.$thisstatus.' Successfuly !', 'success');
            return redirect()->route('browseWhconfirm');
            
        } catch (Exception $e) {
            // dd($e);
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
                if ($qadsourcedata[1] == "false") {
                    toast('Something went wrong with the data', 'error')->persistent('Dismiss');
                    return redirect()->back();
                }


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

        return response()->json($data);
    }
}
