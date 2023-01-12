<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Services\CreateTempTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class WORelease extends Controller
{
    //

    public function browse(Request $request)
    {

        // dd(Session::get('role'));

        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        if(Session::get('role') == 'ADMIN'){
            $data = DB::table('wo_mstr')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
                ->whereIn('wo_status', ['open', 'Released', 'whsconfirm', 'plan', 'started'])
                ->orderby('wo_created_at', 'desc')
                ->orderBy('wo_mstr.wo_id', 'desc');
        }else{
            $data = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->whereIn('wo_status', ['open', 'Released', 'whsconfirm', 'plan', 'started'])
            ->where(function ($query) {
                $query->where('wo_engineer1', '=', Session()->get('username'))
                    ->orwhere('wo_engineer2', '=', Session()->get('username'))
                    ->orwhere('wo_engineer3', '=', Session()->get('username'))
                    ->orwhere('wo_engineer4', '=', Session()->get('username'))
                    ->orwhere('wo_engineer5', '=', Session()->get('username'));
            })
            ->orderby('wo_created_at', 'desc')
            ->orderBy('wo_mstr.wo_id', 'desc');
        }

        

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
        // $data = $data->get();

        return view('workorder.worelease-browse', ['asset1' => $asset1, 'data' => $data]);
    }

    public function detailrelease($id)
    {
        // dd('test?');
        $data = DB::table('wo_mstr')
            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            ->where('wo_id', '=', $id)
            ->first();

        $getwonbr = DB::table('wo_mstr')
            ->where('wo_id', '=', $id)
            ->first();

        $rpdata = DB::table('wo_mstr')
            ->select(
                'wo_repair_code1',
                'wo_repair_code2',
                'wo_repair_code3',
                'rep1.repm_desc as rc1',
                'rep2.repm_desc as rc2',
                'rep3.repm_desc as rc3'
            )
            ->leftJoin('rep_master as rep1', 'wo_mstr.wo_repair_code1', 'rep1.repm_code')
            ->leftJoin('rep_master as rep2', 'wo_mstr.wo_repair_code2', 'rep2.repm_code')
            ->leftJoin('rep_master as rep3', 'wo_mstr.wo_repair_code3', 'rep3.repm_code')
            ->where('wo_id', '=', $id)
            ->first();

        // dd($rpdata);

        $insdata = DB::table('rep_det')
            ->join('rep_master', 'repm_code', 'repdet_code')
            ->join('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
            ->select('repm_code', 'repdet_ins', 'repm_desc', 'ins_code', 'ins_desc')
            ->orderby('repdet_code')
            ->get();

        // dd($insdata);

        $spdata = DB::table('sp_mstr')
            ->orderBy('spm_code')
            ->get();

        $wodetdata = DB::table('wo_dets')
            ->whereWo_dets_nbr($data->wo_nbr)
            ->get();

        if ($data->wo_status == 'plan') {

            if ($data->wo_repair_code1 != "") {

                $sparepart1 = DB::table('wo_mstr')
                    ->select('wo_repair_code1 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc', 'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code1', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc1 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code1', 'rep_master.repm_code')
                    ->where('wo_id', '=', $id)
                    ->get();

                // $tempSP1 = (new CreateTempTable())->createSparePartUsed($sparepart1);

                $combineSP = $sparepart1;
                $rc = $rc1;
            }

            if ($data->wo_repair_code2 != "") {
                // dump('repaircode2');
                $sparepart2 = DB::table('wo_mstr')
                    ->select('wo_repair_code2 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc', 'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code2', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc2 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code2', 'rep_master.repm_code')
                    ->where('wo_id', '=', $id)
                    ->get();

                // $tempSP2 = (new CreateTempTable())->createSparePartUsed($sparepart2);

                $combineSP = $sparepart1->merge($sparepart2);
                $rc = $rc1->merge($rc2);
            }

            if ($data->wo_repair_code3 != "") {
                // dump('repaircode3');
                $sparepart3 = DB::table('wo_mstr')
                    ->select('wo_repair_code3 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc', 'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc3 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                    ->where('wo_id', '=', $id)
                    ->get();

                // $tempSP3 = (new CreateTempTable())->createSparePartUsed($sparepart3);

                $combineSP = $sparepart1->merge($sparepart2)->merge($sparepart3);
                $rc = $rc1->merge($rc2)->merge($rc3);
            }

            // dd($rc);

            if ($data->wo_repair_code1 == "" && $data->wo_repair_code2 == "" && $data->wo_repair_code3 == "") {
                // dd('aa');
                $combineSP = DB::table('xxrepgroup_mstr')
                    ->select('repm_code as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc', 
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status')
                    ->leftjoin('rep_master', 'xxrepgroup_mstr.xxrepgroup_rep_code', 'rep_master.repm_code')
                    ->leftjoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftjoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->leftJoin('wo_mstr','wo_repair_group','xxrepgroup_mstr.xxrepgroup_nbr')
                    ->where('xxrepgroup_mstr.xxrepgroup_nbr', '=', $getwonbr->wo_repair_group)
                    ->where('wo_id', '=', $id)
                    ->orderBy('repair_code', 'asc')
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                // dd($combineSP);

                $rc = DB::table('xxrepgroup_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->leftjoin('rep_master', 'xxrepgroup_mstr.xxrepgroup_rep_code', 'rep_master.repm_code')
                    ->get();
            }
        } /* if($data->wo_status == 'plan') */ else {
            $combineSP = DB::table('wo_mstr')
                ->select(
                    'wo_dets_rc as repair_code',
                    'wo_dets_id as repdet_step',
                    'wo_dets_ins as ins_code',
                    'insd_part_desc',
                    'wo_dets_sp as insd_part',
                    'insd_det.insd_um',
                    'insd_qty',
                    'wo_status',
                    'wo_dets_line'
                )
                ->leftJoin('wo_dets', 'wo_mstr.wo_nbr', 'wo_dets.wo_dets_nbr')
                ->leftJoin('insd_det', function ($join) {
                    $join->on('wo_dets.wo_dets_ins', '=', 'insd_det.insd_code');
                    $join->on('wo_dets.wo_dets_sp', '=', 'insd_det.insd_part');
                })
                ->where('wo_id', '=', $id)
                ->orderBy('wo_dets_line')
                ->orderBy('ins_code', 'asc')
                ->orderBy('repdet_step', 'asc')
                ->get();

            // dd($combineSP);


            $rc = DB::table('wo_mstr')
                ->select('repm_code', 'repm_desc')
                ->join('wo_dets', 'wo_mstr.wo_nbr', 'wo_dets.wo_dets_nbr')
                ->join('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
                ->where('wo_id', '=', $id)
                ->distinct('wo_dets_rc')
                ->get();
        } /*  else ($data->wo_status == 'open') */

        // dd($combineSP);

        return view('workorder.worelease-detail', compact('data', 'spdata', 'combineSP', 'rpdata', 'insdata', 'rc', 'wodetdata'));
    }

    public function submitrelease(Request $req)
    {
        // dd($req->all());

        DB::beginTransaction();

        try {
            foreach ($req->partneed as $a => $key) {
                /* Mencaari line terakhir */
                if($req->line[$a] == "") {
                    $cekline = DB::table('wo_dets')
                    ->where('Wo_dets_nbr', '=', $req->hide_wonum)
                    ->max('wo_dets_line');

                    $dline = $cekline + 1;
                } else {
                    $dline = $req->line[$a];
                }
                
                $cek = DB::table('wo_dets')
                    ->where('Wo_dets_nbr', '=', $req->hide_wonum)
                    ->where('wo_dets_line', '=', $dline)
                    ->count();

                /* Insert jika line baru, update jika line sudah ada */
                if ($cek == 0) {
                    DB::table('wo_dets')->insert([
                        'wo_dets_nbr' => $req->hide_wonum,
                        'wo_dets_line' => $dline,
                        'wo_dets_rc' => $req->repcode[$a],
                        'wo_dets_sp' => $req->partneed[$a],
                        'wo_dets_sp_qty' => $req->qtyrequest[$a],
                        'wo_dets_ins' => $req->inscode[$a] ?? null,
                        'wo_dets_worelease_note' => $req->note_release[$a],
                        'wo_dets_rlsuser' => Session()->get('username'),
                        'wo_dets_created_at' => Carbon::now()->toDateTimeString(),
                    ]);
                } else {
                    if ($req->tick[$a] == 0) {
                        DB::table('wo_dets')
                            ->where('Wo_dets_nbr', '=', $req->hide_wonum)
                            ->where('wo_dets_line', '=', $dline)
                            ->update(
                                [
                                    'wo_dets_rc' => $req->repcode[$a],
                                    'wo_dets_sp' => $req->partneed[$a],
                                    'wo_dets_ins' => $req->inscode[$a] ?? null,
                                    'wo_dets_sp_qty' => $req->qtyrequest[$a],
                                    'wo_dets_worelease_note' => $req->note_release[$a],
                                    'wo_dets_rlsuser' => Session()->get('username'),
                                    'wo_dets_created_at' => Carbon::now()->toDateTimeString(),
                                ]
                            );
                    } else {
                        DB::table('wo_dets')
                            ->where('Wo_dets_nbr', '=', $req->hide_wonum)
                            ->where('wo_dets_line', '=', $dline)
                            ->delete(); 
                    }
                }
            }

            DB::table('wo_mstr')
                ->where('wo_nbr', '=', $req->hide_wonum)
                ->update([
                    'wo_status' => 'Released',
                    'wo_updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            /* cek status jika terdapat item yang belum diconfirm whs*/
            $cekstatus = DB::table('wo_dets')
                ->where('wo_dets_nbr', '=', $req->hide_wonum)
                ->where(function ($query) {
                    $query->where('wo_dets_wh_conf', '', 0)
                          ->orWhere('wo_dets_wh_conf', '=', null);
                })
                ->count();
        // dd($a);  
            /* jika WO tidak ada spare part, status akan menjadi open */
            $ceksp = DB::table('wo_dets')
                ->where('wo_dets_nbr','=',$req->hide_wonum)
                ->where('wo_dets_sp','<>',null)
                ->count();

            if($cekstatus == 0 || $ceksp == 0) {
                DB::table('wo_mstr')
                ->where('wo_nbr', '=', $req->hide_wonum)
                ->update([
                    'wo_status' => 'open',
                    'wo_updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            DB::commit();

            toast('WO Successfuly Released !', 'success');
            return redirect()->route('browseRelease');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('WO Release Failed', 'error');
            return redirect()->route('browseRelease');
        }
    }
}
