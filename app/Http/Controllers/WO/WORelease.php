<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Jobs\SendWorkOrderWarehouseNotification;
use App\Services\CreateTempTable;
use App\Services\WSAServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Models\Qxwsa as ModelsQxwsa;

class WORelease extends Controller
{
    //

    public function browse(Request $request)
    {

        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        if(Session::get('role') == 'ADMIN'){
            $data = DB::table('wo_mstr')
                ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                ->where('wo_status','=','firm')
                ->orderby('wo_system_create', 'desc');
        }else{

            $username = Session::get('username');

            // dd($username);

            $data = DB::table('wo_mstr')
            ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->where('wo_status','=','firm')
            ->where(function ($query) use ($username){
                $query->where('wo_list_engineer', '=', $username.';')
                ->orWhere('wo_list_engineer', 'LIKE', $username.';%')
                ->orWhere('wo_list_engineer', 'LIKE', '%;'.$username.';%')
                ->orWhere('wo_list_engineer', 'LIKE', '%;'.$username)
                ->orWhere('wo_list_engineer', '=', $username);
            })
            ->orderby('wo_system_create', 'desc');
            
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

        return view('workorder.worelease-browse', ['asset1' => $asset1, 'data' => $data]);
    }

    public function detailrelease($id)
    {

        $data = DB::table('wo_mstr')
            // ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
            ->join('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
            ->where('wo_mstr.id', '=', $id)
            ->first();

        //ambil data failure type 
        if ($data->wo_failure_type !== null) {
            $getFailTypeDesc = DB::table('wotyp_mstr')
                ->select('wotyp_desc')
                ->where('wotyp_code', '=', $data->wo_failure_type)
                ->first();
        } else {
            $getFailTypeDesc = '';
        }

        //ambil data failure code
        $listFailDesc = [];

        if ($data->wo_failure_code !== null) {
            $listFailCode = explode(';', $data->wo_failure_code);



            foreach ($listFailCode as $failcode) {
                $getFailDesc = DB::table('fn_mstr')
                    ->select('fn_desc')
                    ->where('fn_code', '=', $failcode)
                    ->first();

                $failure = array('fn_code' => $failcode, 'fn_desc' => $getFailDesc->fn_desc);

                array_push($listFailDesc, $failure);
            }
        } else {
            $getFailDesc = '';
        }

        $sp_all = DB::table('sp_mstr')
                ->select('spm_code','spm_desc', 'spm_um','spm_site','spm_loc','spm_lot')
                ->where('spm_active','=', 'Yes')
                ->get();

            // dd($data->wo_sp_code);

        if ($data->wo_sp_code !== null) {
            // melakukan sesuatu jika nilai dari $data->wo_sp_code tidak null

            $wo_sp = DB::table('spg_list')
                    ->join('sp_mstr','sp_mstr.spm_code','spg_list.spg_spcode')
                    ->where('spg_code','=', $data->wo_sp_code)
                    ->get();
            
        } else {
            // melakukan sesuatu jika nilai dari $data->wo_sp_code null
            $wo_sp = collect([]);
        }

        return view('workorder.worelease-detail', compact('data','sp_all', 'wo_sp', 'getFailTypeDesc', 'listFailDesc'));
    }

    public function submitrelease(Request $req)
    {
        DB::beginTransaction();

        try {

            //mengelompokan data dari request depan
            $requestData = $req->all(); // mengambil data dari request

            if(!empty($requestData['spreq'])){ //jika di released dengan adanya spare part

                $data = [
                    "spreq" => $requestData['spreq'],
                    "qtystandard" => $requestData['qtystandard'],
                    "qtyrequired" => $requestData['qtyrequired'],
                ];
                
                $groupedData = collect($data['spreq'])->map(function ($spreq, $key) use ($data) {
                    return [
                        'spreq' => $spreq,
                        'qtystandard' => $data['qtystandard'][$key],
                        'qtyrequired' => $data['qtyrequired'][$key],
                    ];
                })->groupBy('spreq')->map(function ($group) {
                    $totalQtyRequired = $group->sum('qtyrequired');
                    $totalQtyStandard = $group->sum('qtystandard');
                
                    return [
                        'spreq' => $group[0]['spreq'],
                        'qtystandard' => $totalQtyStandard,
                        'qtyrequired' => $totalQtyRequired,
                    ];
                })->values();

                $data = [];

                //cari dan simpan ke dalam inv_required kemudian ambil data dari QAD berdasarkan table inp_supply yang kondisinya inp_asset_site sama dengan asset site wo yang di release
                foreach($groupedData as $loopsp){
                    $getAssetSite = DB::table('asset_mstr')
                                    ->where('asset_code', '=', $req->assetcode)
                                    ->first();

                    $ir = DB::table('inv_required')
                        ->where('ir_spare_part', $loopsp['spreq'])
                        ->where('ir_site', $req->assetsite)
                        ->first();
                    if ($ir) {
                        // jika data sudah ada, update record table inv_required
                        DB::table('inv_required')
                            ->where('ir_spare_part', $loopsp['spreq'])
                            ->where('ir_site', $req->assetsite)
                            ->update([
                                'inv_qty_required' => DB::raw('inv_qty_required + '.$loopsp['qtyrequired']), //inv_qty_required yang lama + inv_qty_required dari wo yang baru di release
                                'ir_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                    } else {
                        // jika data belum ada, buat data baru
                        DB::table('inv_required')->insert([
                            'ir_spare_part' => $loopsp['spreq'],
                            'ir_site' => $req->assetsite,
                            'inv_qty_required' => $loopsp['qtyrequired'],
                            'ir_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'ir_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                    }

                    //simpan lsit spare part yang di released ke table wo_det
                    DB::table('wo_dets_sp')
                            ->insert([
                                'wd_sp_wonumber' => $requestData['hide_wonum'],
                                'wd_sp_spcode' => $loopsp['spreq'],
                                'wd_sp_required' => $loopsp['qtyrequired'],
                                'wd_sp_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                'wd_sp_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);


                    //harus ada datanya. ambil data dari table inp_supply untuk kemudian dicheck ke QAD untuk qty on hand yang ada di QAD
                    $supplydata = DB::table('inp_supply')
                                ->where('inp_asset_site','=', $req->assetsite)
                                ->where('inp_avail','=', 'Yes')
                                ->get();

                    // dd($supplydata);

                    //looping wsa ke qad berdasarkan dari table inventory dengan kondisi inp_asset_site adalah request dari asset wo dan inp_avail nya yes
                    foreach($supplydata as $invsupply){
                        //wsa ambil data ke qad
                        $qadsupplydata = (new WSAServices())->wsagetsupply($loopsp['spreq'],$invsupply->inp_supply_site,$invsupply->inp_loc);

                        if ($qadsupplydata === false) {

                            DB::rollBack();
                            toast('WSA Connection Failed', 'error')->persistent('Dismiss');
                            return redirect()->back();
                        } else {

                            // jika hasil WSA ke QAD tidak ditemukan
                            if ($qadsupplydata[1] !== "false") {
                                // jika hasil WSA ditemukan di QAD, ambil dari QAD kemudian disimpan dalam array untuk nantinya dikelompokan lagi data QAD tersebut berdasarkan part dan site
                            
                                $resultWSA = $qadsupplydata[0];
                                
                                $t_domain = (string) $resultWSA[0]->t_domain;
                                $t_part = (string) $resultWSA[0]->t_part;
                                $t_site = (string) $resultWSA[0]->t_site;
                                $t_loc = (string) $resultWSA[0]->t_loc;
                                $t_qtyoh = (string) $resultWSA[0]->t_qtyoh;

                                array_push($data, [
                                    't_domain' => $t_domain,
                                    't_part' => $t_part,
                                    't_site' => $t_site,
                                    't_loc' => $t_loc,
                                    't_qtyoh' => $t_qtyoh,
                                ]);
                            }else{
                                $wsa = ModelsQxwsa::first();
                                $domain = $wsa->wsas_domain;

                                array_push($data, [
                                    't_domain' => $domain,
                                    't_part' => $loopsp['spreq'],
                                    't_site' => $invsupply->inp_supply_site,
                                    't_loc' => $invsupply->inp_loc,
                                    't_qtyoh' => 0,
                                ]);

                            }
                        }

                        //tampung didalam array


                    }

                }


                //proses pengelompokan berdasarkan part dan site sehingga didapat total qty onhand untuk part per site nya data QAD
                foreach ($data as $item) {
                    $part = $item['t_part'];
                    $site = $item['t_site'];
                    $qtyoh = $item['t_qtyoh'];
                
                    if (!isset($result[$part][$site])) {
                        $result[$part][$site] = [
                            'part' => $part,
                            'site' => $site,
                            'qtyoh' => 0,
                        ];
                    }
                
                    $result[$part][$site]['qtyoh'] += $qtyoh;
                }

                // dd($result);
                

                //hasil pengelompokan/grouping by part dan site data QAD kemudian ditampung dalam $output
                $output = [];

                foreach ($result as $part => $sites) {
                    foreach ($sites as $site => $qtyoh) {
                        $output[] = $qtyoh;
                    }
                }

                // dd($output);

                //mulai membandingkan data antara data di table inv_required (web) dengan qty tersedia dari data QAD ($output)

                //ambil data dari table inv_required
                foreach($output as $qadData){
                    $getAssetSite2 = DB::table('asset_mstr')
                                ->where('asset_code', '=', $req->assetcode)
                                ->first();

                    $getInvRequired = DB::table('inv_required')
                                            ->where('ir_spare_part', '=', $qadData['part'])
                                            ->where('ir_site','=', $req->assetsite)
                                            ->first();

                    if($getInvRequired->inv_qty_required > $qadData['qtyoh']){


                        $datasFilter[] = [
                            'sp_code' => $qadData['part'],
                            'not_enough' => true,
                        ]; 
                   

                    }else{

                        $datasFilter[] = [
                            'sp_code' => $qadData['part'],
                            'not_enough' => false,
                        ]; 


                    }
                    
                }

                // dd($datasFilter);

                // Mengubah data array menjadi koleksi Laravel
                $collection = new Collection($datasFilter);

                // Mengelompokkan data berdasarkan SP code
                $groupedData = $collection->groupBy('sp_code');

                //Filter dengan prioritas adalah lokasi yang cukup stoknya
                $outputResultFilter = $groupedData->map(function ($group) {
                    $hasFalseCondition = $group->contains('not_enough', false);

                    if ($hasFalseCondition) {
                        return [
                            'sp_code' => $group->first()['sp_code'],
                            'not_enough' => false,
                        ];
                    } else {
                        return [
                            'sp_code' => $group->first()['sp_code'],
                            'not_enough' => true,
                        ];
                    }
                })->values()->all();

                foreach($outputResultFilter as $thisResult){
                    DB::table('wo_dets_sp')
                            ->where('wd_sp_wonumber','=', $requestData['hide_wonum'])
                            ->where('wd_sp_spcode','=', $thisResult['sp_code'])
                            ->update([
                                'wd_sp_flag' => $thisResult['not_enough'],
                                'wd_sp_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);   
                }



                //perubahaan status dan kirim email harus diluar looping diatas atau ga bisa dobel kirim email
                DB::table('wo_mstr')
                            ->where('wo_number','=', $requestData['hide_wonum'])
                            ->update([
                                'wo_status' => 'released',
                                'wo_system_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);


                $checkTidakCukup = DB::table('wo_dets_sp')
                            ->where('wd_sp_wonumber', '=', $requestData['hide_wonum'])
                            ->where('wd_sp_flag','=', true)
                            ->exists();

                if ($checkTidakCukup) {
                    // Ada spare part yang tidak cukup
                    $wonumber_email = $requestData['hide_wonum'];


                    //kirim notifikasi ke warehouse bahwa ada stock yang diperlukan untuk WO namun tidak cukup di inventory supply    
                    SendWorkOrderWarehouseNotification::dispatch($wonumber_email);
                    
                    //ambil detail data kode instruction list dan kode qcspec dari table wo_mstr
                    $dataWO = DB::table('wo_mstr')
                    ->where('wo_number','=', $requestData['hide_wonum'])
                    ->first();


                    if($dataWO->wo_ins_code !== null){
                        $dataIns = DB::table('ins_list')
                            ->where('ins_code','=', $dataWO->wo_ins_code)
                            ->get();

                        foreach($dataIns as $ins){
                            DB::table('wo_dets_ins')
                                ->insert([
                                    'wd_ins_wonumber' => $requestData['hide_wonum'],
                                    'wd_ins_step' => $ins->ins_step,
                                    'wd_ins_code' => $ins->ins_code,
                                    'wd_ins_stepdesc' => $ins->ins_stepdesc,
                                    'wd_ins_duration' => $ins->ins_duration,
                                    'wd_ins_durationum' => $ins->ins_durationum,
                                    'wd_ins_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                    'wd_ins_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                        }

                    }

                    if($dataWO->wo_qcspec_code !== null){
                        $dataQC = DB::table('qcs_list')
                                ->where('qcs_code','=', $dataWO->wo_qcspec_code)
                                ->get();

                    
                        foreach($dataQC as $qcspec){
                            DB::table('wo_dets_qc')
                                ->insert([
                                    'wd_qc_wonumber' => $requestData['hide_wonum'],
                                    'wd_qc_qcparam' => $qcspec->qcs_spec,
                                    'wd_qc_qcoperator' => $qcspec->qcs_op,
                                    'wd_qc_qcum' => $qcspec->qcs_um,
                                    'wd_qc_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                    'wd_qc_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                        }
                    }

                    DB::table('wo_trans_history')
                            ->insert([
                                'wo_number' => $requestData['hide_wonum'],
                                'wo_action' => 'released',
                            ]);


                    // dd('stop here');

                    DB::commit();

                    toast('Work order released successfully, work order transfer is required for '.$requestData['hide_wonum'].'', 'success')->autoClose(10000);
                    return redirect()->route('browseRelease');
                    
                }else{

                    //ambil detail data kode instruction list dan kode qcspec dari table wo_mstr
                    $dataWO = DB::table('wo_mstr')
                    ->where('wo_number','=', $requestData['hide_wonum'])
                    ->first();


                    if($dataWO->wo_ins_code !== null){
                        $dataIns = DB::table('ins_list')
                            ->where('ins_code','=', $dataWO->wo_ins_code)
                            ->get();

                        foreach($dataIns as $ins){
                            DB::table('wo_dets_ins')
                                ->insert([
                                    'wd_ins_wonumber' => $requestData['hide_wonum'],
                                    'wd_ins_step' => $ins->ins_step,
                                    'wd_ins_code' => $ins->ins_code,
                                    'wd_ins_stepdesc' => $ins->ins_stepdesc,
                                    'wd_ins_duration' => $ins->ins_duration,
                                    'wd_ins_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                    'wd_ins_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                        }

                    }

                    if($dataWO->wo_qcspec_code !== null){
                        $dataQC = DB::table('qcs_list')
                                ->where('qcs_code','=', $dataWO->wo_qcspec_code)
                                ->get();

                    
                        foreach($dataQC as $qcspec){
                            DB::table('wo_dets_qc')
                                ->insert([
                                    'wd_qc_wonumber' => $requestData['hide_wonum'],
                                    'wd_qc_qcparam' => $qcspec->qcs_spec,
                                    'wd_qc_qcoperator' => $qcspec->qcs_op,
                                    'wd_qc_qcum' => $qcspec->qcs_um,
                                    'wd_qc_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                    'wd_qc_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                        }
                    }

                    DB::table('wo_trans_history')
                            ->insert([
                                'wo_number' => $requestData['hide_wonum'],
                                'wo_action' => 'released',
                            ]);


                    // dd('stop here');

                    DB::commit();

                    toast('WO Successfuly Released for '.$requestData['hide_wonum'].' !', 'success')->autoClose(10000);
                    return redirect()->route('browseRelease');

                }


            }else{ //jika di release tanpa spare part
                DB::table('wo_mstr')
                    ->where('wo_number','=', $requestData['hide_wonum'])
                    ->update([
                        'wo_status' => 'released',
                        'wo_system_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);


                //ambil detail data kode instruction list dan kode qcspec dari table wo_mstr
                $dataWO = DB::table('wo_mstr')
                ->where('wo_number','=', $requestData['hide_wonum'])
                ->first();


                if($dataWO->wo_ins_code !== null){
                    $dataIns = DB::table('ins_list')
                        ->where('ins_code','=', $dataWO->wo_ins_code)
                        ->get();

                    foreach($dataIns as $ins){
                        DB::table('wo_dets_ins')
                            ->insert([
                                'wd_ins_wonumber' => $requestData['hide_wonum'],
                                'wd_ins_step' => $ins->ins_step,
                                'wd_ins_code' => $ins->ins_code,
                                'wd_ins_stepdesc' => $ins->ins_stepdesc,
                                'wd_ins_duration' => $ins->ins_duration,
                                'wd_ins_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                'wd_ins_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                    }

                }

                if($dataWO->wo_qcspec_code !== null){
                    $dataQC = DB::table('qcs_list')
                            ->where('qcs_code','=', $dataWO->wo_qcspec_code)
                            ->get();

                
                    foreach($dataQC as $qcspec){
                        DB::table('wo_dets_qc')
                            ->insert([
                                'wd_qc_wonumber' => $requestData['hide_wonum'],
                                'wd_qc_qcparam' => $qcspec->qcs_spec,
                                'wd_qc_qcoperator' => $qcspec->qcs_op,
                                'wd_qc_qcum' => $qcspec->qcs_um,
                                'wd_qc_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                'wd_qc_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                    }
                }

                DB::table('wo_trans_history')
                        ->insert([
                            'wo_number' => $requestData['hide_wonum'],
                            'wo_action' => 'released',
                        ]);


                // dd('stop here');

                DB::commit();

                toast('WO Successfuly Released for '.$requestData['hide_wonum'].' !', 'success')->autoClose(10000);
                return redirect()->route('browseRelease');

                
            }
            
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('WO Release Failed', 'error');
            return redirect()->route('browseRelease');
        }
    }
}
