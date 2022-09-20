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
                    $table->string('stok_qty');
                    $table->temporary();
                });

                foreach ($stokdata[0] as $datas) {
                    DB::table('temp_stok')->insert([
                        'stok_site' => $datas->t_site,
                        'stok_loc' => $datas->t_loc,
                        'stok_part' => $datas->t_part,
                        'stok_qty' => $datas->t_qty,
                    ]);
                }

                $qstok = DB::table('temp_stok')
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
            
            foreach($req->partneed as $a => $key){
                if ($req->tick[$a] == 0) {
                    $qty = 0;
                } else {
                    $qty = $req->qtyconf[$a];
                }
                DB::table('wo_dets')
                    ->where('wo_dets_nbr', $req->hide_wonum)
                    ->where('wo_dets_rc', $req->repcode[$a])
                    ->where('wo_dets_ins', $req->inscode[$a])
                    ->where('wo_dets_sp', $req->partneed[$a])
                    ->update([
                    'wo_dets_wh_site' => $req->t_site[$a],
                    'wo_dets_wh_loc' => $req->t_loc[$a],
                    'wo_dets_wh_qty' => $qty,
                    'wo_dets_wh_conf' => $req->tick[$a],
                    'wo_dets_wh_date' => Carbon::now()->toDateTimeString(),
                ]);
            }    

            /* DB::table('wo_mstr')
                ->where('wo_nbr',$req->hide_wonum)
                ->update([
                    'wo_status' => 'whsconfirm',
                ]); */
            
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
}
