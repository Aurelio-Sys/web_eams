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

        $data = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->where('wo_status', '=', 'Released')
            /* ->where(function ($query) {
                $query->where('wo_engineer1', '=', Session()->get('username'))
                    ->orwhere('wo_engineer2', '=', Session()->get('username'))
                    ->orwhere('wo_engineer3', '=', Session()->get('username'))
                    ->orwhere('wo_engineer4', '=', Session()->get('username'))
                    ->orwhere('wo_engineer5', '=', Session()->get('username'));
            }) */
            ->orderby('wo_created_at', 'desc')
            ->orderBy('wo_mstr.wo_id', 'desc');

        if ($request->s_nomorwo) {
            $data->where('wo_nbr', '=', $request->s_nomorwo);
        }

        if ($request->s_asset) {
            $data->where('asset_code', '=', $request->s_asset);
        }

        if ($request->s_priority) {
            $data->where('wo_priority', '=', $request->s_priority);
        }

        $data = $data->paginate(10);

        $data2 = DB::table('wo_mstr')
                        ->join('wo_dets','wo_dets.wo_dets_nbr','wo_mstr.wo_nbr')
                        ->where('wo_status','=','Released')
                        ->get();

        return view('workorder.whsconfirm-browse', ['asset1' => $asset1, 'data' => $data, 'data2' => $data2]);
    }

    public function detailwhs($id)
    {
        $data = DB::table('wo_mstr')
            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            ->where('wo_id', '=', $id)
            ->first();

        $rpdata = DB::table('rep_master')
            ->orderBy('repm_code')
            ->get();

        $insdata = DB::table('ins_mstr')
            ->orderBy('ins_code')
            ->get();

        $spdata = DB::table('sp_mstr')
            ->orderBy('spm_code')
            ->get();

        $locdata = DB::table('loc_mstr')
            ->join('site_mstrs','site_code','=','loc_site')
            ->where('site_flag','=','yes')
            ->orderBy('loc_code')
            ->get();

        $sitedata = DB::table('site_mstrs')
            ->where('site_flag','=','yes')
            ->orderBy('site_code')
            ->get();

        $wodetdata = DB::table('wo_dets')
            ->whereWo_dets_nbr($data->wo_nbr)
            ->get();

        /* Mencari daata lokasi eng */
        $dataloceng = DB::table('eng_mstr')
            ->join('wo_dets','wo_dets_rlsuser','=','eng_code')
            ->first();

        /* Semua data release sudah masuk di wo_dets 
        if ($data->wo_repair_code1 != "") {
            $sparepart1 = DB::table('wo_mstr')
                ->select('wo_repair_code1 as repair_code', 'ins_code', 'insd_part_desc', 'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
                ->leftJoin('rep_master', 'wo_mstr.wo_repair_code1', 'rep_master.repm_code')
                ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                ->where('wo_id', '=', $id)
                ->orderBy('insd_det.insd_part')
                ->get();

            $combineSP = $sparepart1;
        }

        if ($data->wo_repair_code2 != "") {
            $sparepart2 = DB::table('wo_mstr')
                ->select('wo_repair_code2 as repair_code', 'ins_code', 'insd_part_desc', 'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
                ->leftJoin('rep_master', 'wo_mstr.wo_repair_code2', 'rep_master.repm_code')
                ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                ->where('wo_id', '=', $id)
                ->orderBy('insd_det.insd_part')
                ->get();

            $combineSP = $sparepart1->merge($sparepart2);
        }

        if ($data->wo_repair_code3 != "") {
            $sparepart3 = DB::table('wo_mstr')
                ->select('wo_repair_code3 as repair_code', 'ins_code', 'insd_part_desc', 'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
                ->leftJoin('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                ->where('wo_id', '=', $id)
                ->orderBy('insd_det.insd_part')
                ->get();

            $combineSP = $sparepart1->merge($sparepart2)->merge($sparepart3);
        }
        */

        $combineSP = DB::table('wo_mstr')
            ->select('wo_dets_rc as repair_code', 'wo_dets_id as repdet_step', 'wo_dets_ins as ins_code', 'insd_part_desc', 'wo_dets_sp as insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_dets_wh_conf as whconf' , 'wo_dets_sp_qty','wo_dets_line')
            ->leftJoin('wo_dets','wo_mstr.wo_nbr','wo_dets.wo_dets_nbr')
            ->leftJoin('insd_det', function($join)
            {
                $join->on('wo_dets.wo_dets_ins', '=', 'insd_det.insd_code');
                $join->on('wo_dets.wo_dets_sp', '=', 'insd_det.insd_part');
            })
            ->where('wo_id', '=', $id)
            ->orderBy('wo_dets_line')
            ->orderBy('ins_code', 'asc')
            ->orderBy('repdet_step', 'asc')
            ->get();

        // load stock
        $siteactive = DB::table('site_mstrs')
            ->where('site_flag','=','yes')
            ->get();

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

        foreach($siteactive as $qsite) {
            $domain = ModelsQxwsa::first();

            $stokdata = (new WSAServices())->wsastok($domain->wsas_domain,$qsite->site_code);

            if ($stokdata === false) {
                toast('WSA Failed', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {

                if ($stokdata[1] == "false") {
                    toast('Stok tidak ditemukan', 'error')->persistent('Dismiss');
                    return redirect()->back();
                } else {
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
                }
            }
        }

        $qstok = DB::table('temp_stok')
            ->orderBy('stok_date')
            ->orderBy('stok_site')
            ->orderBy('stok_lot')
            ->orderBy('stok_loc')
            ->get();  

        Schema::dropIfExists('temp_stok');
        
        return view('workorder.whsconf-detail', compact(
            'data',
            'spdata',
            'combineSP',
            'rpdata',
            'insdata',
            'locdata',
            'sitedata',
            'qstok',
            'wodetdata',
            'dataloceng'
        ));
    }

    public function whssubmit(Request $req){
        // dd($req->all());
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

            DB::commit();

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
}
