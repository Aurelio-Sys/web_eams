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

        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        if(Session::get('role') == 'ADMIN'){
            $data = DB::table('wo_mstr')
                ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                ->whereIn('wo_status', ['firm'])
                ->orderby('wo_system_create', 'desc');
        }else{

            $username = Session::get('username');

            // dd($username);

            $data = DB::table('wo_mstr')
            ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->whereIn('wo_status', ['firm'])
            ->where('wo_list_engineer', 'like', '%'.$username.'%')
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
        // $data = $data->get();

        return view('workorder.worelease-browse', ['asset1' => $asset1, 'data' => $data]);
    }

    public function detailrelease($id)
    {

        $data = DB::table('wo_mstr')
            // ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
            ->join('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
            ->where('wo_mstr.id', '=', $id)
            ->first();

        $sp_all = DB::table('sp_mstr')
                ->select('spm_code','spm_desc', 'spm_um','spm_site','spm_loc','spm_lot')
                //->where('spm_site','=', $data->wo_site) //ambil yng site nya sama dengan site asset
                ->where('spm_active','=', 'Yes')
                ->get();

        if ($data->wo_sp_code !== null) {
            // melakukan sesuatu jika nilai dari $data->wo_sp_code tidak null

            $wo_sp = DB::table('spg_list')
                    ->join('sp_mstr','sp_mstr.spm_code','sp_mstr.spm_site','spg_list.spg_spcode')
                    ->where('spg_code','=', $data->wo_sp_code)
                    ->get();
            
        } else {
            // melakukan sesuatu jika nilai dari $data->wo_sp_code null
            $wo_sp = collect([]);
        }

        return view('workorder.worelease-detail', compact('data','sp_all', 'wo_sp'));
    }

    public function submitrelease(Request $req)
    {

        // dd($req->all());
        

        DB::beginTransaction();

        try {

            //mengelompokan data dari request depan
            $requestData = $req->all(); // mengambil data dari request
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


            foreach ($req->partneed as $a => $key) {
                /* Mencaari line terakhir */
                if($req->line[$a] == "") {
                    $cekline = DB::table('wo_dets')
                    ->where('wo_dets_nbr', '=', $req->hide_wonum)
                    ->max('wo_dets_line');

                    $dline = $cekline + 1;
                } else {
                    $dline = $req->line[$a];
                }
                
                $cek = DB::table('wo_dets')
                    ->where('wo_dets_nbr', '=', $req->hide_wonum)
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
                    'wo_user_input' => Session::get('username'),
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
                    'wo_user_input' => Session::get('username'),
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
