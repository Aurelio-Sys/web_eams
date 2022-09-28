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
    public function browse(Request $request)
    {
        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        $data = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->where('wo_status', '=', 'Released')
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

        $data = $data->paginate(2);

        return view('workorder.whsconfirm-browse', ['asset1' => $asset1, 'data' => $data]);
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
            ->orderBy('loc_code')
            ->get();

        $sitedata = DB::table('site_mstrs')
            ->orderBy('site_code')
            ->get();

        $wodetdata = DB::table('wo_dets')
            ->whereWo_dets_nbr($data->wo_nbr)
            ->get();

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
            ->select('wo_dets_rc as repair_code', 'wo_dets_id as repdet_step', 'wo_dets_ins as ins_code', 'insd_part_desc', 'wo_dets_sp as insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_dets_wh_conf as whconf' , 'wo_dets_sp_qty')
            ->leftJoin('wo_dets','wo_mstr.wo_nbr','wo_dets.wo_dets_nbr')
            ->leftJoin('insd_det', function($join)
            {
                $join->on('wo_dets.wo_dets_ins', '=', 'insd_det.insd_code');
                $join->on('wo_dets.wo_dets_sp', '=', 'insd_det.insd_part');
            })
            ->where('wo_id', '=', $id)
            ->orderBy('ins_code', 'asc')
            ->orderBy('repdet_step', 'asc')
            ->get();

        // load stock
        $domain = ModelsQxwsa::first();

        $stokdata = (new WSAServices())->wsastok($domain->wsas_domain);

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
                    ->orderBy('stok_date')
                    ->get();

                Schema::dropIfExists('temp_stok');
            }
        }

        return view('workorder.whsconf-detail', compact(
            'data',
            'spdata',
            'combineSP',
            'rpdata',
            'insdata',
            'locdata',
            'sitedata',
            'qstok',
            'wodetdata'
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
                        toast('Quantity  !', 'error');
                        return redirect()->route('browseWhconfirm');
                    }
                }
            }

            $cekstatus = "";
            foreach($req->partneed as $a => $key){
                if ($req->tick[$a] == 1) {
                    DB::table('wo_dets')
                        ->where('wo_dets_nbr', $req->hide_wonum)
                        ->where('wo_dets_rc', $req->repcode[$a])
                        ->where('wo_dets_ins', $req->inscode[$a])
                        ->where('wo_dets_sp', $req->partneed[$a])
                        ->update([
                        'wo_dets_wh_site' => $req->t_site[$a],
                        'wo_dets_wh_loc' => $req->t_loc[$a],
                        'wo_dets_wh_qty' => $req->qtyconf[$a],
                        'wo_dets_wh_conf' => $req->tick[$a],
                        'wo_dets_wh_date' => Carbon::now()->toDateTimeString(),
                        'wo_dets_wh_user' => $req->session()->get('username'),
                    ]);
                } else {
                    $cekstatus = "nol";
                }
                
            }    

            if ($cekstatus == "") {
                DB::table('wo_mstr')
                    ->where('wo_nbr',$req->hide_wonum)
                    ->update([
                        'wo_status' => 'open',
                    ]);
            }

            /* ini qxtend transfer single item */

            $qxwsa = ModelsQxwsa::first();

            // Var Qxtend
            $qxUrl          = $qxwsa->qx_url; // Edit Here

            $qxRcv          = $qxwsa->qx_rcv;

            $timeout        = 0;

            $domain         = $qxwsa->wsas_domain;

            // XML Qextend ** Edit Here

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
                    <qcom:propertyValue>.$domain</qcom:propertyValue>
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

                $qdocBody .= '<item>
                                <part>text</part>
                                <itemDetail>
                                    <lotserialQty>999.99</lotserialQty>
                                    <rmks>text</rmks>
                                    <siteFrom>text</siteFrom>
                                    <locFrom>text</locFrom>
                                    <lotserFrom>text</lotserFrom>
                                    <siteTo>text</siteTo>
                                    <locTo>text</locTo>
                                </itemDetail>
                            </item>';
            
            /* endforeach disini */
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
            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



            if ($qdocResult == "success" or $qdocResult == "warning") {
                /* jika response sukses atau warning */


            } else {

                DB::rollBack();
                toast('Qxtend Response Error', 'error');
                /* jika qxtend response error */
            }
            
            DB::commit();

            toast('Confirm Successfuly !', 'success');
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

            $stokdata = (new WSAServices())->wsastok($domain->wsas_domain);

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
                        ->orderBy('stok_date')
                        ->get();

                    Schema::dropIfExists('temp_stok');
                }
            }
//    dd($req->t_part)       ;  
            $qlot = $qstok->where('stok_site','=',$req->t_site)->where('stok_part','=',$req->t_part);

            $output = '<option value="" >Select</option>';
            foreach($qlot as $qlot){
                $output .= '<option value="'.$qlot->stok_lot.'" >'.$qlot->stok_lot.'</option>';
            }
            dd($output);
            return response($output);
        }
    }
}
