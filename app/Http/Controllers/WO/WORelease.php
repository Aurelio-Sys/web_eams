<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Services\CreateTempTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WORelease extends Controller
{
    //

    public function browse(Request $request)
    {

        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        $data = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->where('wo_status', '=', 'open')
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


        return view('workorder.worelease-browse', ['asset1' => $asset1, 'data' => $data]);
    }

    public function detailrelease($id)
    {

        $data = DB::table('wo_mstr')
            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            ->where('wo_id', '=', $id)
            ->first();

        $spdata = DB::table('sp_mstr')
            ->orderBy('spm_code')
            ->get();

        if ($data->wo_repair_code1 != "") {

            $sparepart1 = DB::table('wo_mstr')
                ->select('wo_repair_code1 as repair_code','insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
                ->leftJoin('rep_master', 'wo_mstr.wo_repair_code1', 'rep_master.repm_code')
                ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                ->where('wo_id', '=', $id)
                ->get();

            // $tempSP1 = (new CreateTempTable())->createSparePartUsed($sparepart1);

            $combineSP = $sparepart1;

        }

        if ($data->wo_repair_code2 != "") {
            // dump('repaircode2');
            $sparepart2 = DB::table('wo_mstr')
                ->select('wo_repair_code2 as repair_code','insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
                ->leftJoin('rep_master', 'wo_mstr.wo_repair_code2', 'rep_master.repm_code')
                ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                ->where('wo_id', '=', $id)
                ->get();

            // $tempSP2 = (new CreateTempTable())->createSparePartUsed($sparepart2);

            $combineSP = $sparepart1->merge($sparepart2);

        }

        if ($data->wo_repair_code3 != "") {
            // dump('repaircode3');
            $sparepart3 = DB::table('wo_mstr')
                ->select('wo_repair_code3 as repair_code','insd_det.insd_part', 'insd_det.insd_um', 'insd_qty')
                ->leftJoin('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                ->where('wo_id', '=', $id)
                ->get();
            
            // $tempSP3 = (new CreateTempTable())->createSparePartUsed($sparepart3);

            $combineSP = $sparepart1->merge($sparepart2)->merge($sparepart3);

        }

        // dd($combineSP);

        return view('workorder.worelease-detail', compact('data', 'spdata','combineSP'));
    }

    public function submitrelease(Request $req){
        dd($req->all());
    }
}
