<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConfirmEng extends Controller
{
    //

    public function index(Request $request){
        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        $data = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->where('wo_status', '=', 'whsconfirm')
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


        return view('workorder.confirmeng-browse', ['asset1' => $asset1, 'data' => $data]);
    }

    public function detailconfirm($id)
    {
        // dd($id);
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
            ->get();

        if ($data->wo_repair_code1 != "") {
            $sparepart1 = DB::table('wo_mstr')
                ->select('wo_repair_code1 as repair_code','ins_code','insd_part_desc','insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
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
                ->select('wo_repair_code2 as repair_code','ins_code','insd_part_desc','insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
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
                ->select('wo_repair_code3 as repair_code','ins_code','insd_part_desc','insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
                ->leftJoin('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                ->where('wo_id', '=', $id)
                ->orderBy('insd_det.insd_part')
                ->get();

            $combineSP = $sparepart1->merge($sparepart2)->merge($sparepart3);
        }

        return view('workorder.engconf-detail', compact('data', 'spdata','combineSP','rpdata','insdata',
        'locdata','sitedata','wodetdata'));
    }

    public function engsubmit(Request $req){
        // dd($req->all());
        DB::beginTransaction();

        try{
            
            foreach($req->partneed as $a => $key){
                DB::table('wo_dets')
                    ->where('wo_dets_nbr',$req->hide_wonum)
                    ->where('wo_dets_rc',$req->repcode[$a])
                    ->where('wo_dets_ins',$req->inscode[$a])
                    ->where('wo_dets_sp',$req->partneed[$a])
                    ->update([
                    'wo_dets_eng_qty' => $req->qtyconf[$a],
                    'wo_dets_eng_conf' => $req->tick[$a],
                    'wo_dets_eng_date' => Carbon::now()->toDateTimeString(),
                ]);
            }    

            DB::table('wo_mstr')
                ->where('wo_nbr',$req->hide_wonum)
                ->update([
                    'wo_status' => 'engconfirm',
                ]);
            
            DB::commit();
    
            toast('Confirm Successfuly !','success');
            return redirect()->route('browseConfEng');

        } catch (Exception $e){
            // dd($e);
            DB::rollBack();
            toast('Confirm Failed','error');
            return redirect()->route('browseConfEng');
        }

        
    }
}
