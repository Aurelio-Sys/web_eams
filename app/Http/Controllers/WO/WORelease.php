<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Jobs\EmailScheduleJobs;
use App\Jobs\SendNotifWOReleaseApproval;
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
use App\Models\User;
use App\WOMaster;
use Illuminate\Support\Facades\Auth;

class WORelease extends Controller
{
    //

    public function browse(Request $request)
    {

        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        if (Session::get('role') == 'ADMIN') {
            $data = DB::table('wo_mstr')
                ->select('wo_mstr.id as wo_id', 'wo_number', 'asset_code', 'asset_desc', 'wo_status', 'wo_start_date', 'wo_due_date', 'wo_priority')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                ->where('wo_status', '=', 'firm')
                ->orderby('wo_system_create', 'desc');
        } elseif (Session::get('role') == 'SPVSR' || Session::get('role') == 'SKSSR') {
            $data = DB::table('wo_mstr')
                ->select('wo_mstr.id as wo_id', 'wo_number', 'asset_code', 'asset_desc', 'wo_status', 'wo_start_date', 'wo_due_date', 'wo_priority')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                ->where('wo_status', '=', 'firm')
                ->where('wo_department', '=', Session::get('department'))
                ->orderby('wo_system_create', 'desc');
        } else {

            $username = Session::get('username');

            // dd($username);

            $data = DB::table('wo_mstr')
                ->select('wo_mstr.id as wo_id', 'wo_number', 'asset_code', 'asset_desc', 'wo_status', 'wo_start_date', 'wo_due_date', 'wo_priority')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                ->where('wo_status', '=', 'firm')
                ->where(function ($query) use ($username) {
                    $query->where('wo_list_engineer', '=', $username . ';')
                        ->orWhere('wo_list_engineer', 'LIKE', $username . ';%')
                        ->orWhere('wo_list_engineer', 'LIKE', '%;' . $username . ';%')
                        ->orWhere('wo_list_engineer', 'LIKE', '%;' . $username)
                        ->orWhere('wo_list_engineer', '=', $username);
                })
                ->orderby('wo_system_create', 'desc');
        }

        if ($request->s_nomorwo) {
            $data->where('wo_number', 'like', '%' . $request->s_nomorwo . '%');
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
            ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
            ->where('spm_active', '=', 'Yes')
            ->get();

        // dd($data->wo_sp_code);

        if ($data->wo_sp_code !== null) {
            // melakukan sesuatu jika nilai dari $data->wo_sp_code tidak null

            $wo_sp = DB::table('spg_list')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'spg_list.spg_spcode')
                ->where('spg_code', '=', $data->wo_sp_code)
                ->get();
        } else {
            // melakukan sesuatu jika nilai dari $data->wo_sp_code null
            $wo_sp = collect([]);
        }

        return view('workorder.worelease-detail', compact('data', 'sp_all', 'wo_sp', 'getFailTypeDesc', 'listFailDesc'));
    }

    public function approvalbrowse(Request $req)
    {
        if (strpos(Session::get('menu_access'), 'WO10') !== false) {
            $usernow = DB::table('users')
                ->join('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                ->where('eng_code', '=', session()->get('username'))
                ->where('active', '=', 'Yes')
                ->where('approver', '=', 1)
                ->first();
            // dd($usernow);

            $data = WOMaster::query()
                ->with(['getCurrentApproverRelease'])
                ->whereHas('getWOReleaseTransAppr', function ($q) {
                    $q->where('retr_status', '=', 'waiting for approval');
                    $q->orWhere('retr_status', '=', 'approved');
                    $q->orWhere('retr_status', '=', 'revision');
                    $q->where('wo_status', '=', 'released');
                });
            $data = $data
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                ->selectRaw('wo_mstr.*, asset_mstr.asset_code, asset_mstr.asset_desc, retr_status, retr_reason, retr_dept_approval')
                ->orderby('wo_system_create', 'desc')
                ->orderBy('wo_mstr.id', 'desc')
                ->groupBy('wo_mstr.wo_number');

            if ($usernow != null) {
                if (Session::get('role') <> 'ADMIN' && Session::get('role') <> 'WHS') {
                    $data = $data->join('release_trans_approval', function ($join) {
                        $join->on('wo_mstr.id', '=', 'release_trans_approval.retr_mstr_id')
                            ->where('retr_dept_approval', '=', Session::get('department'))
                            ->where('retr_role_approval', '=', Session::get('role'))
                            ->where('wo_department', Session::get('department'));
                    });
                } else {
                    $data = $data->join('release_trans_approval', 'release_trans_approval.retr_mstr_id', 'wo_mstr.id');
                }
            } else {
                toast('Anda tidak memiliki akses menu untuk melakukan approval, silahkan kontak admin', 'error');
                return back();
            }


            $data = $data->paginate(10);
            // dd($data);

            $engineer = DB::table('users')
                ->join('roles', 'users.role_user', 'roles.role_code')
                ->where('role_desc', '=', 'Engineer')
                ->get();
            $asset = DB::table('wo_mstr')
                ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                ->join('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                ->where(function ($status) {
                    $status->where('wo_status', '=', 'released'); //status finished --> setelah selesai melakukan wo reporting
                })
                ->groupBy('asset_code')
                ->orderBy('asset_code')
                ->get();
            if ($req->ajax()) {
                return view('workorder.table-woreleaseapproval', ['data' => $data]);
            } else {
                return view('workorder.worelease-approval', ['data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset]);
            }
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    public function approvalsearch(Request $req)
    {
        // dd('aaa');
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            // $period    = $req->get('woperiod');
            // dd($req->all());

            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();

            // dd($usernow);

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '') {
                $data = WOMaster::query()
                    ->with(['getCurrentApproverRelease'])
                    // ->where('wo_status', '=', 'finished')
                    // ->orWhere('wo_status', '=', 'started')
                    ->whereHas('getWOReleaseTransAppr', function ($q) {
                        $q->where('retr_status', '=', 'waiting for approval');
                        $q->orWhere('retr_status', '=', 'approved');
                        $q->orWhere('retr_status', '=', 'revision');
                        $q->where('wo_status', '=', 'released');
                        // $q->orWhere('wo_status', '=', 'started');
                    });
                $data = $data
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                    // ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    // ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    // ->where(function ($status) {
                    //     //status finished --> setelah selesai melakukan wo reporting
                    //     $status->where('wo_status', '=', 'finished');
                    //     //hal ini dilakukan sementara karena wo trans sudah mulai terbuat saat proses SR convert to WO (finalizenya wo trans approval akan terbuat saat wo reporting)
                    //     //kalo statusnya null berarti belum bisa approve (perubahan status null -> waiting for approval pada saat wo reporting)
                    //     $status->orWhere('retr_status', '=', 'waiting for approval');
                    // })
                    ->selectRaw('wo_mstr.*, asset_mstr.asset_code, asset_mstr.asset_desc, retr_status, retr_reason, retr_dept_approval')
                    ->orderby('wo_system_create', 'desc')
                    ->orderBy('wo_mstr.id', 'desc')
                    ->groupBy('wo_mstr.wo_number');

                if (Session::get('role') <> 'ADMIN' && Session::get('role') <> 'WHS') {
                    $data = $data->join('release_trans_approval', function ($join) {
                        $join->on('wo_mstr.id', '=', 'release_trans_approval.retr_mstr_id')
                            ->where('retr_dept_approval', '=', Session::get('department'))
                            ->where('retr_role_approval', '=', Session::get('role'))
                            ->where('wo_department', Session::get('department'));
                    });
                    // dd(1);
                } else {
                    $data = $data->join('release_trans_approval', 'release_trans_approval.retr_mstr_id', 'wo_mstr.id');
                    // dd(2);
                }

                $data = $data->paginate(10);
                // dd($data);

                return view('workorder.table-woreleaseapproval', ['data' => $data, 'usernow' => $usernow]);
            } else {
                $kondisi = "wo_mstr.id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_number LIKE '%" . $wonumber . "%'";
                    // dd($kondisi);
                }
                if ($asset != '') {
                    // $kondisi .= " and asset_code LIKE '%" . $asset . "%'";
                    $kondisi .= " AND (asset_code LIKE '%" . $asset . "%' OR asset_desc LIKE '%" . $asset . "%')";
                }
                if ($status != '') {
                    $kondisi .= " and retr_status ='" . $status . "'";
                }
                if ($priority != '') {
                    $kondisi .= " and wo_priority = '" . $priority . "'";
                }

                $data = WOMaster::query()
                    ->with(['getCurrentApproverRelease'])
                    // ->where('wo_status', '=', 'finished')
                    // ->where('wo_status', '=', 'started')
                    ->whereHas('getWOReleaseTransAppr', function ($q) {
                        $q->where('retr_status', '=', 'waiting for approval');
                        $q->orWhere('retr_status', '=', 'approved');
                        $q->orWhere('retr_status', '=', 'revision');
                        $q->where('wo_status', '=', 'released');
                        // $q->orWhere('wo_status', '=', 'started');
                    });
                $data = $data
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->selectRaw('wo_mstr.*, asset_mstr.asset_code, asset_mstr.asset_desc, retr_status, retr_reason, retr_dept_approval')
                    ->whereRaw($kondisi)
                    ->orderby('wo_system_create', 'desc')
                    ->orderBy('wo_mstr.id', 'desc')
                    ->groupBy('wo_mstr.wo_number');

                if (Session::get('role') <> 'ADMIN' && Session::get('role') <> 'WHS') {
                    $data = $data->join('release_trans_approval', function ($join) {
                        $join->on('wo_mstr.id', '=', 'release_trans_approval.retr_mstr_id')
                            ->where('retr_dept_approval', '=', Session::get('department'))
                            ->where('retr_role_approval', '=', Session::get('role'))
                            ->where('wo_department', Session::get('department'));
                    });

                    // dd(1);
                } else {
                    $data = $data->join('release_trans_approval', 'release_trans_approval.retr_mstr_id', 'wo_mstr.id');
                    // dd(4);
                }

                $data = $data->paginate(10);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                return view('workorder.table-woreleaseapproval', ['data' => $data, 'usernow' => $usernow]);
            }
        }
    }

    public function approvaldetail($wonumber)
    {
        //ambil data untuk header wo report detail
        $dataheader = DB::table('wo_mstr')
            ->leftJoin('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->where('wo_number', '=', $wonumber)
            ->first();

        // dd($dataheader);

        $idwo = DB::table('wo_mstr')->where('wo_number', '=', $wonumber)
            ->selectRaw('id')
            ->first();

        // dd($idwo);

        //ambil data failure code
        $asfn_det = DB::table('asfn_det')
            ->where('asfn_asset', '=', $dataheader->asset_group)
            ->where('asfn_fntype', '=', $dataheader->asset_type)
            ->count();

        if ($asfn_det > 0) {
            //jika ada

            $failure = DB::table('fn_mstr')
                ->leftJoin('asfn_det', 'asfn_det.asfn_fncode', 'fn_mstr.fn_code')
                ->where('asfn_asset', '=', $dataheader->asset_group)
                ->where('asfn_fntype', '=', $dataheader->asset_type)
                ->groupBy('asfn_fncode')
                ->get();
        } else {
            //jika tidak ada

            $failure = DB::table('fn_mstr')
                ->get();
        }

        // ambil UM
        $um = DB::table('um_mstr')
            ->get();

        // ambil data deskripsi engineer
        $listeng_wo = $dataheader->wo_list_engineer;

        $listeng_wo = explode(';', $listeng_wo);

        $engData = array();

        foreach ($listeng_wo as $datalisteng) {

            $engdesc = DB::table('eng_mstr')
                ->where('eng_code', '=', $datalisteng)
                ->first()->eng_desc;

            $engData[] = array('eng_code' => $datalisteng, 'eng_desc' => $engdesc);
        }


        //ambil data spare part dari wo_dets_sp
        $datasparepart = DB::table('wo_dets_sp')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'wo_dets_sp.wd_sp_spcode')
            ->where('wd_sp_wonumber', '=', $wonumber)
            ->groupBy('wd_sp_wonumber', 'wd_sp_spcode')
            ->select('*', DB::raw('SUM(wo_dets_sp.wd_sp_required) as wd_sp_required'), DB::raw('SUM(wo_dets_sp.wd_sp_issued) as wd_sp_issued'))
            ->get();

        // dd($datasparepart);

        // ambil semua data spare part
        $sp_all = DB::table('sp_mstr')
            ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
            ->where('spm_active', '=', 'Yes')
            ->get();

        // ambil data instruction step dari wo_dets_ins
        $datainstruction = DB::table('wo_dets_ins')
            ->leftJoin('um_mstr', 'um_mstr.um_code', 'wo_dets_ins.wd_ins_durationum')
            ->where('wd_ins_wonumber', '=', $wonumber)
            ->get();

        // dd($datainstruction);

        // ambil semua step instruction dari ins_list
        $ins_all = DB::table('ins_list')
            ->select('ins_code', 'ins_desc', 'ins_duration', 'ins_durationum', 'ins_manpower', 'ins_step', 'ins_stepdesc', 'ins_ref')
            ->get();


        $dataqcparam = DB::table('wo_dets_qc')
            ->where('wd_qc_wonumber', '=', $wonumber)
            ->get();

        return view('workorder.worelease-approvaldetail', [
            'header' => $dataheader, 'sparepart' => $datasparepart, 'newsparepart' => $sp_all,
            'instruction' => $datainstruction, 'inslist' => $ins_all, 'um' => $um, 'idwo' => $idwo,
            'engineers' => $engData, 'qcparam' => $dataqcparam, 'failure' => $failure
        ]);
    }

    public function approvaldetailinfo($wonumber)
    {
        //ambil data untuk header wo report detail
        $dataheader = DB::table('wo_mstr')
            ->leftJoin('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->where('wo_number', '=', $wonumber)
            ->first();

        // dd($dataheader);

        $idwo = DB::table('wo_mstr')->where('wo_number', '=', $wonumber)
            ->selectRaw('id')
            ->first();

        $wo = DB::table('wo_mstr')->where('wo_number', '=', $wonumber)
            // ->selectRaw('id')
            ->first();

        // dd($idwo);

        //ambil data failure code
        $asfn_det = DB::table('asfn_det')
            ->where('asfn_asset', '=', $dataheader->asset_group)
            ->where('asfn_fntype', '=', $dataheader->asset_type)
            ->count();

        if ($asfn_det > 0) {
            //jika ada

            $failure = DB::table('fn_mstr')
                ->leftJoin('asfn_det', 'asfn_det.asfn_fncode', 'fn_mstr.fn_code')
                ->where('asfn_asset', '=', $dataheader->asset_group)
                ->where('asfn_fntype', '=', $dataheader->asset_type)
                ->groupBy('asfn_fncode')
                ->get();
        } else {
            //jika tidak ada

            $failure = DB::table('fn_mstr')
                ->get();
        }

        // ambil UM
        $um = DB::table('um_mstr')
            ->get();

        // ambil data deskripsi engineer
        $listeng_wo = $dataheader->wo_list_engineer;

        $listeng_wo = explode(';', $listeng_wo);

        $engData = array();

        foreach ($listeng_wo as $datalisteng) {

            $engdesc = DB::table('eng_mstr')
                ->where('eng_code', '=', $datalisteng)
                ->first()->eng_desc;

            $engData[] = array('eng_code' => $datalisteng, 'eng_desc' => $engdesc);
        }


        //ambil data spare part dari wo_dets_sp
        $datasparepart = DB::table('wo_dets_sp')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'wo_dets_sp.wd_sp_spcode')
            ->where('wd_sp_wonumber', '=', $wonumber)
            ->groupBy('wd_sp_wonumber', 'wd_sp_spcode')
            ->select('*', DB::raw('SUM(wo_dets_sp.wd_sp_required) as wd_sp_required'), DB::raw('SUM(wo_dets_sp.wd_sp_issued) as wd_sp_issued'))
            ->get();

        // dd($datasparepart);

        // ambil semua data spare part
        $sp_all = DB::table('sp_mstr')
            ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
            ->where('spm_active', '=', 'Yes')
            ->get();

        // ambil data instruction step dari wo_dets_ins
        $datainstruction = DB::table('wo_dets_ins')
            ->leftJoin('um_mstr', 'um_mstr.um_code', 'wo_dets_ins.wd_ins_durationum')
            ->where('wd_ins_wonumber', '=', $wonumber)
            ->get();

        // dd($datainstruction);

        // ambil semua step instruction dari ins_list
        $ins_all = DB::table('ins_list')
            ->select('ins_code', 'ins_desc', 'ins_duration', 'ins_durationum', 'ins_manpower', 'ins_step', 'ins_stepdesc', 'ins_ref')
            ->get();


        $dataqcparam = DB::table('wo_dets_qc')
            ->where('wd_qc_wonumber', '=', $wonumber)
            ->get();


        if (session()->get('role') <> 'ADMIN') {
            //jika approver bukan admin
            $approver = DB::table('release_trans_approval')
                ->leftJoin('users', 'users.id', 'release_trans_approval.retr_approved_by')
                ->where('retr_mstr_id', $wo->id)
                ->where('retr_role_approval', session()->get('role'))
                ->first();
        } else {
            $approver = DB::table('release_trans_approval')
                ->leftJoin('users', 'users.id', 'release_trans_approval.retr_approved_by')
                ->where('retr_mstr_id', $wo->id)
                ->first();
        }

        // dd($approver);

        return view('workorder.worelease-approvaldetail-info', [
            'header' => $dataheader, 'sparepart' => $datasparepart, 'newsparepart' => $sp_all,
            'instruction' => $datainstruction, 'inslist' => $ins_all, 'um' => $um, 'idwo' => $idwo,
            'engineers' => $engData, 'qcparam' => $dataqcparam, 'failure' => $failure, 'approver' => $approver
        ]);
    }

    public function approval(Request $req)
    {
        $idwo = $req->idwo;
        $reason = $req->v_reason;

        // dd($idwo, $reason);

        $user = Auth::user();

        //ambil data WO
        $womstr = DB::table('wo_mstr')
            ->where('wo_mstr.id', $idwo)
            ->join('asset_mstr', 'asset_mstr.asset_code', '=', 'wo_mstr.wo_asset_code')
            ->leftJoin('service_req_mstr', 'service_req_mstr.sr_number', '=', 'wo_mstr.wo_sr_number')
            ->selectRaw('wo_mstr.*, asset_mstr.asset_code, asset_mstr.asset_desc, service_req_mstr.sr_req_by')
            ->first();

        $srmstr = DB::table('service_req_mstr')->where('wo_number', $womstr->wo_number)->first();

        $asset = $womstr->asset_code . ' -- ' . $womstr->asset_desc;
        $srnumber = $womstr->wo_number;

        $roleapprover = $user->role_user;

        $woapprovermstr = DB::table('sp_approver_mstr')->get();

        $countwoapprover = count($woapprovermstr);
        // dd($countwoapprover);

        //cek role user yg login
        if (Session::get('role') <> 'ADMIN') {
            //jika user bukan admin
            $woapprover = DB::table('release_trans_approval')
                ->where('retr_mstr_id', $idwo)
                ->where('retr_role_approval', $user->role_user)
                ->first();
        } else {
            //jika user adalah admin
            $woapprover = DB::table('release_trans_approval')
                ->where('retr_mstr_id', $idwo)
                ->first();
        }

        //cek next approver
        $nextapprover = DB::table('release_trans_approval')->where('retr_mstr_id', $woapprover->retr_mstr_id)
            ->where('retr_sequence', '>', $woapprover->retr_sequence)
            ->first();

        // dd($nextapprover);

        //cek previous approver
        $prevapprover = DB::table('release_trans_approval')->where('retr_mstr_id', $woapprover->retr_mstr_id)
            ->where('retr_sequence', '<', $woapprover->retr_sequence)
            ->first();
        // dd(is_null($prevapprover));

        //wo approved
        $retransapproved = [
            // 'retr_dept_approval' => $user->dept_user,
            'retr_status'      => 'approved',
            'retr_reason'      => $reason,
            'retr_approved_by' => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        $retransapprovedhist = [
            'retrh_wo_number'        => $womstr->wo_number,
            'retrh_sr_number'        => $womstr->wo_sr_number,
            'retrh_dept_approval'    => $user->dept_user,
            'retrh_role_approval'    => $user->role_user,
            'retrh_status'           => 'WO Approved',
            'retrh_reason'           => $reason,
            // 'retrh_sequence'         => $woapprover->retr_sequence,
            'retrh_approved_by'      => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        //wo rejected
        $retransreject = [
            // 'retr_dept_approval' => $user->dept_user,
            'retr_status'      => 'revision',
            'retr_reason'      => $reason,
            'retr_approved_by' => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        $retransrejecthist = [
            'retrh_wo_number'        => $womstr->wo_number,
            'retrh_sr_number'        => $womstr->wo_sr_number,
            'retrh_dept_approval'    => $user->dept_user,
            'retrh_status'           => 'WO Rejected',
            'retrh_reason'           => $reason,
            'retrh_sequence'         => $woapprover->retr_sequence,
            'retrh_approved_by'      => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        if ($req->action == 'approve') {

            $srnumber = $womstr->wo_sr_number ? $womstr->wo_sr_number : $womstr->wo_number;
            $requestor = $womstr->wo_releasedby;

            if ($countwoapprover != 0) {
                //jika next approver null
                if (is_null($nextapprover)) {
                    // dd(1);
                    //cek apakah approver admin atau bukan
                    if (Session::get('role') <> 'ADMIN') {
                        //jika user bukan admin, hanya tingkatan yang rolenya sama yang akan menjadi approved
                        DB::table('release_trans_approval')
                            ->where('retr_mstr_id', '=', $idwo)
                            ->where('retr_role_approval', '=', $user->role_user)
                            ->update($retransapproved);

                        DB::table('release_trans_approval_hist')
                            ->insert($retransapprovedhist);

                        DB::table('wo_trans_history')
                            ->insert([
                                'wo_number' => $womstr->wo_number,
                                'wo_action' => 'wo released approved by ' . $user->role_user,
                                'system_update' => Carbon::now()->toDateTimeString(),
                            ]);
                    } else {
                        //jika user adalah admin, maka semua approval (approval bertingkat) akan menjadi approved
                        DB::table('release_trans_approval')
                            ->where('retr_mstr_id', '=', $idwo)
                            ->update($retransapproved);

                        DB::table('release_trans_approval_hist')
                            ->insert($retransapprovedhist);

                        DB::table('wo_trans_history')
                            ->insert([
                                'wo_number' => $womstr->wo_number,
                                'wo_action' => 'wo released approved by ' . $user->role_user,
                                'system_update' => Carbon::now()->toDateTimeString(),
                            ]);
                    }
                    //email terikirm ke engineer yg melakukan released
                    EmailScheduleJobs::dispatch('', $asset, '16', '', $requestor, $srnumber, '');
                } else {
                    // dd(2);
                    //jika next approval not null

                    $tampungarray = $nextapprover;
                    // $requestor = $womstr->sr_req_by;

                    //cek apakah approver admin atau bukan
                    if (Session::get('role') <> 'ADMIN') {
                        //jika user bukan admin, hanya tingkatan yang rolenya sama yang akan menjadi approved
                        DB::table('release_trans_approval')
                            ->where('retr_mstr_id', '=', $idwo)
                            ->where('retr_role_approval', '=', $user->role_user)
                            ->update($retransapproved);

                        DB::table('release_trans_approval_hist')
                            ->insert($retransapprovedhist);

                        DB::table('wo_trans_history')
                            ->insert([
                                'wo_number' => $womstr->wo_number,
                                'wo_action' => 'wo released approved by ' . $user->role_user,
                                'system_update' => Carbon::now()->toDateTimeString(),
                            ]);

                        //email terikirm ke approver selanjutnya
                        EmailScheduleJobs::dispatch('', $asset, '15', $tampungarray, '', $srnumber, $roleapprover);
                    } else {
                        // dd(2);
                        //jika user adalah admin, maka semua approval (approval bertingkat) akan menjadi approved
                        DB::table('release_trans_approval')
                            ->where('retr_mstr_id', '=', $idwo)
                            ->update($retransapproved);

                        DB::table('release_trans_approval_hist')
                            ->insert($retransapprovedhist);

                        DB::table('wo_trans_history')
                            ->insert([
                                'wo_number' => $womstr->wo_number,
                                'wo_action' => 'wo released approved by ' . $user->role_user,
                                'system_update' => Carbon::now()->toDateTimeString(),
                            ]);

                        //email terikirm ke engineer yg melakukan released
                        EmailScheduleJobs::dispatch('', $asset, '16', '', $requestor, $srnumber, '');
                    }
                }
            }
            // else {
            //     if ($womstr->wo_sr_number == "") {
            //         //jika wo tidak memiliki sr number 
            //         DB::table('wo_mstr')
            //             ->where('id', '=', $idwo)
            //             ->update([
            //                 'wo_status' => 'closed',
            //                 'wo_system_update' => Carbon::now()->toDateTimeString(),
            //             ]);

            //         DB::table('wo_trans_history')
            //             ->insert([
            //                 'wo_number' => $womstr->wo_number,
            //                 'wo_action' => 'closed',
            //                 'system_update' => Carbon::now()->toDateTimeString(),
            //             ]);
            //     } else {
            //         //jika wo memiliki sr number akan kembali ke user acceptance dan wo di close oleh user
            //         DB::table('wo_mstr')
            //             ->where('id', '=', $idwo)
            //             ->update([
            //                 'wo_status' => 'acceptance',
            //                 'wo_system_update' => Carbon::now()->toDateTimeString(),
            //             ]);

            //         DB::table('wo_trans_history')
            //             ->insert([
            //                 'wo_number' => $womstr->wo_number,
            //                 'wo_action' => 'acceptance',
            //                 'system_update' => Carbon::now()->toDateTimeString(),
            //             ]);

            //         DB::table('service_req_mstr')
            //             ->where('sr_number', '=', $womstr->wo_sr_number)
            //             ->update($srupdate);

            //         DB::table('service_req_mstr_hist')
            //             ->insert($srupdatehist);

            //         //email terikirm ke user yang membuat SR
            //         // EmailScheduleJobs::dispatch('', $asset, '12', '', $requestor, $srnumber, '');
            //     }
            // }

            // DB::commit();
            toast('WO Released ' . $womstr->wo_number . ' approved successfuly', 'success');
            return redirect()->route('approvalBrowseRelease');
        }
        // else {
        //     //REJECT
        //     $requestor = $womstr->wo_list_engineer;

        //     DB::table('wo_mstr')
        //         ->where('id', '=', $idwo)
        //         ->update([
        //             'wo_status' => 'started', //status berganti jadi started supaya bisa di edit
        //             'wo_system_update' => Carbon::now()->toDateTimeString(),
        //         ]);

        //     DB::table('wo_trans_history')
        //         ->insert([
        //             'wo_number' => $womstr->wo_number,
        //             'wo_action' => 'rejected',
        //             'system_update' => Carbon::now()->toDateTimeString(),
        //         ]);

        //     if (is_null($nextapprover)) {
        //         //kondisi hanya 1 approver atau approver terakhir

        //         //jika user bukan admin dan hanya 1 approver
        //         if (is_null($prevapprover) && Session::get('role') <> 'ADMIN') {
        //             // dd('1 approver');
        //             DB::table('release_trans_approval')
        //                 ->where('retr_mstr_id', '=', $idwo)
        //                 ->where('retr_role_approval', '=', $user->role_user)
        //                 ->update($retransreject);

        //             DB::table('release_trans_approval_hist')
        //                 ->insert($retransrejecthist);
        //         } else {
        //             // dd('approver terakhir');
        //             DB::table('release_trans_approval')
        //                 ->where('retr_mstr_id', '=', $idwo)
        //                 // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
        //                 ->update($retransreject);

        //             DB::table('release_trans_approval_hist')
        //                 ->insert($retransrejecthist);
        //         }
        //     } else {
        //         //kondisi approver pertama atau approver tengah
        //         DB::table('release_trans_approval')
        //             ->where('retr_mstr_id', '=', $idwo)
        //             // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
        //             ->update($retransreject);

        //         DB::table('release_trans_approval_hist')
        //             ->insert($retransrejecthist);
        //     }

        //     //email terkirim ke wo list engineer
        //     // EmailScheduleJobs::dispatch('', $asset, '11', '', $requestor, $srnumber, '');

        //     // DB::commit();
        //     toast('Work order ' . $womstr->wo_number . ' has been rejected', 'success');
        //     return redirect()->route('approvalBrowseRelease');
        // }
    }

    public function route(Request $request)
    {
        $wo_number = $request->wo_number;
        $datawo = DB::table('wo_mstr')
            ->where('wo_number', '=', $wo_number)
            ->first();

        $dataApprover = DB::table('release_trans_approval')
            ->leftJoin('users', 'release_trans_approval.retr_approved_by', '=', 'users.id')
            ->leftJoin('dept_mstr', 'release_trans_approval.retr_dept_approval', '=', 'dept_mstr.dept_code')
            ->selectRaw('release_trans_approval.*, users.username, users.dept_user, dept_desc')
            ->where('retr_mstr_id', '=', $datawo->id)
            ->orderBy('retr_sequence', 'asc')
            ->get();
        // dd($dataApprover);
        $output = '';

        if ($dataApprover->count() != 0) {
            foreach ($dataApprover as $key => $approver) {

                // foreach($userApprover as $user){
                $output .= '<tr>';
                $output .= '<td>';
                $output .= $key + 1;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->retr_dept_approval ? $approver->retr_dept_approval . ' - ' . $approver->dept_desc : '';
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->retr_role_approval;
                $output .= '</td>';
                // $output .= '<td>';
                // $output .= $approver->retr_reason;
                // $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->retr_status;
                $output .= '</td>';
                $output .= '<td>';
                $output .= is_null($approver->username) ? '' : $approver->username;
                $output .= '</td>';
                $output .= '<td>';
                $output .= is_null($approver->updated_at) ? '' : $approver->updated_at;
                $output .= '</td>';
                $output .= '</tr>';
                // }
            }
        } else {
            $output .= '<tr>';
            $output .= '<td colspan="12" style="color:red">';
            $output .= '<center> No approval in work order </center>';
            $output .= '</td>';
            $output .= '</tr>';
        }



        return response($output);
    }

    public function submitrelease(Request $req)
    {
        DB::beginTransaction();

        try {

            //mengelompokan data dari request depan
            $requestData = $req->all(); // mengambil data dari request

            if (!empty($requestData['spreq'])) { //jika di released dengan adanya spare part

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
                foreach ($groupedData as $loopsp) {
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
                                'inv_qty_required' => DB::raw('inv_qty_required + ' . $loopsp['qtyrequired']), //inv_qty_required yang lama + inv_qty_required dari wo yang baru di release
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
                            'wd_sp_standard' => $loopsp['qtystandard'],
                            'wd_sp_required' => $loopsp['qtyrequired'],
                            'wd_sp_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wd_sp_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);


                    //harus ada datanya. ambil data dari table inp_supply untuk kemudian dicheck ke QAD untuk qty on hand yang ada di QAD
                    $supplydata = DB::table('inp_supply')
                        ->where('inp_asset_site', '=', $req->assetsite)
                        ->where('inp_avail', '=', 'Yes')
                        ->get();

                    // dd($supplydata);

                    //looping wsa ke qad berdasarkan dari table inventory dengan kondisi inp_asset_site adalah request dari asset wo dan inp_avail nya yes
                    foreach ($supplydata as $invsupply) {
                        //wsa ambil data ke qad
                        $qadsupplydata = (new WSAServices())->wsagetsupply($loopsp['spreq'], $invsupply->inp_supply_site, $invsupply->inp_loc);

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
                            } else {
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
                foreach ($output as $qadData) {
                    $getAssetSite2 = DB::table('asset_mstr')
                        ->where('asset_code', '=', $req->assetcode)
                        ->first();

                    $getInvRequired = DB::table('inv_required')
                        ->where('ir_spare_part', '=', $qadData['part'])
                        ->where('ir_site', '=', $req->assetsite)
                        ->first();

                    if ($getInvRequired->inv_qty_required > $qadData['qtyoh']) {


                        $datasFilter[] = [
                            'sp_code' => $qadData['part'],
                            'not_enough' => true,
                        ];
                    } else {

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

                foreach ($outputResultFilter as $thisResult) {
                    DB::table('wo_dets_sp')
                        ->where('wd_sp_wonumber', '=', $requestData['hide_wonum'])
                        ->where('wd_sp_spcode', '=', $thisResult['sp_code'])
                        ->update([
                            'wd_sp_flag' => $thisResult['not_enough'],
                            'wd_sp_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                }

                //perubahaan status dan kirim email harus diluar looping diatas atau ga bisa dobel kirim email
                DB::table('wo_mstr')
                    ->where('wo_number', '=', $requestData['hide_wonum'])
                    ->update([
                        'wo_status' => 'released',
                        'wo_released_date' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                        'wo_released_time' => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                        'wo_releasedby' => Session::get('username'),
                        'wo_system_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);

                //tambahkan data ke table approval wo release
                //cek apakah approval release sudah di setting atau belum
                $checkApprover = DB::table('sp_approver_mstr')
                    ->count();

                // dd($checkApprover);

                if ($checkApprover > 0) {
                    //jika ada settingan approver

                    //ambil role approver order paling pertama untuk dikirimkan email notifikasi
                    $getFirstApprover = DB::table('sp_approver_mstr')
                        ->orderBy('sp_approver_order', 'ASC')
                        ->first();

                    // dd($getFirstApprover);

                    //get wo dan sr mstr
                    $womstr = DB::table('wo_mstr')->where('wo_number', $requestData['hide_wonum'])->first();

                    //cek wo release approval master
                    $woapprover = DB::table('sp_approver_mstr')->where('id', '>', 0)->get();

                    if (count($woapprover) > 0) {
                        for ($i = 0; $i < count($woapprover); $i++) {
                            $nextroleapprover = $woapprover[$i]->sp_approver_role;
                            $nextseqapprover = $woapprover[$i]->sp_approver_order;

                            if ($woapprover[$i]->sp_approver_role == 'WHS') {
                                //jika user rolenya warehouse maka department dikosongkan
                                //update status wo approval
                                DB::table('release_trans_approval')
                                    ->insert([
                                        'retr_mstr_id' => $womstr->id,
                                        'retr_sr_number' => $womstr->wo_sr_number,
                                        // 'retr_dept_approval' => 'WHS',
                                        'retr_role_approval' => $nextroleapprover,
                                        'retr_sequence' => $nextseqapprover,
                                        'retr_status' => 'waiting for approval',
                                        'retr_reason' => null,
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                    ]);

                                //input ke wo trans approval hist jika ada approval department
                                DB::table('release_trans_approval_hist')
                                    ->insert([
                                        'retrh_wo_number' => $womstr->wo_number,
                                        'retrh_sr_number' => $womstr->wo_sr_number,
                                        // 'retrh_dept_approval' => 'WHS',
                                        'retrh_role_approval' => $nextroleapprover,
                                        'retrh_sequence' => $nextseqapprover,
                                        'retrh_status' => 'WO Release ready for approval',
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                        'updated_at' => Carbon::now()->toDateTimeString(),
                                    ]);
                            } else {
                                //update status wo approval
                                DB::table('release_trans_approval')
                                    ->insert([
                                        'retr_mstr_id' => $womstr->id,
                                        'retr_sr_number' => $womstr->wo_sr_number,
                                        'retr_dept_approval' => session()->get('department'),
                                        'retr_role_approval' => $nextroleapprover,
                                        'retr_sequence' => $nextseqapprover,
                                        'retr_status' => 'waiting for approval',
                                        'retr_reason' => null,
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                    ]);

                                //input ke wo trans approval hist jika ada approval department
                                DB::table('release_trans_approval_hist')
                                    ->insert([
                                        'retrh_wo_number' => $womstr->wo_number,
                                        'retrh_sr_number' => $womstr->wo_sr_number,
                                        'retrh_dept_approval' => session()->get('department'),
                                        'retrh_role_approval' => $nextroleapprover,
                                        'retrh_sequence' => $nextseqapprover,
                                        'retrh_status' => 'WO Release ready for approval',
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                        'updated_at' => Carbon::now()->toDateTimeString(),
                                    ]);
                            }
                        }
                    }

                    $checkTidakCukup = DB::table('wo_dets_sp')
                        ->where('wd_sp_wonumber', '=', $requestData['hide_wonum'])
                        ->where('wd_sp_flag', '=', true)
                        ->exists();

                    if ($checkTidakCukup) {
                        // Ada spare part yang tidak cukup
                        $wonumber_email = $requestData['hide_wonum'];


                        //kirim notifikasi ke warehouse bahwa ada stock yang diperlukan untuk WO namun tidak cukup di inventory supply    
                        SendWorkOrderWarehouseNotification::dispatch($wonumber_email);

                        //ambil detail data kode instruction list dan kode qcspec dari table wo_mstr
                        $dataWO = DB::table('wo_mstr')
                            ->where('wo_number', '=', $requestData['hide_wonum'])
                            ->first();


                        if ($dataWO->wo_ins_code !== null) {
                            $dataIns = DB::table('ins_list')
                                ->where('ins_code', '=', $dataWO->wo_ins_code)
                                ->get();

                            foreach ($dataIns as $ins) {
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

                        if ($dataWO->wo_qcspec_code !== null) {
                            $dataQC = DB::table('qcs_list')
                                ->where('qcs_code', '=', $dataWO->wo_qcspec_code)
                                ->get();


                            foreach ($dataQC as $qcspec) {
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

                        toast('Work order released successfully, work order transfer is required for ' . $requestData['hide_wonum'] . '', 'success')->autoClose(10000);
                        return redirect()->route('browseRelease');
                    } else {

                        //ambil detail data kode instruction list dan kode qcspec dari table wo_mstr
                        $dataWO = DB::table('wo_mstr')
                            ->where('wo_number', '=', $requestData['hide_wonum'])
                            ->first();


                        if ($dataWO->wo_ins_code !== null) {
                            $dataIns = DB::table('ins_list')
                                ->where('ins_code', '=', $dataWO->wo_ins_code)
                                ->get();

                            foreach ($dataIns as $ins) {
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

                        if ($dataWO->wo_qcspec_code !== null) {
                            $dataQC = DB::table('qcs_list')
                                ->where('qcs_code', '=', $dataWO->wo_qcspec_code)
                                ->get();


                            foreach ($dataQC as $qcspec) {
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

                        toast('WO Successfuly Released for ' . $requestData['hide_wonum'] . ' !', 'success')->autoClose(10000);
                        return redirect()->route('browseRelease');
                    }

                    //send notifikasi ke approver pertama
                    SendNotifWOReleaseApproval::dispatch($requestData['hide_wonum'], $getFirstApprover->sp_approver_role, Session::get('department'));
                } else {
                    //jika wo release approval belum di setting

                    toast('You need to set up the approver for WO Release!', 'error')->autoClose(10000);
                    return redirect()->back();
                }
            } else { //jika di release tanpa spare part
                DB::table('wo_mstr')
                    ->where('wo_number', '=', $requestData['hide_wonum'])
                    ->update([
                        'wo_status' => 'released',
                        'wo_releasedby' => Session::get('username'),
                        'wo_system_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);


                //ambil detail data kode instruction list dan kode qcspec dari table wo_mstr
                $dataWO = DB::table('wo_mstr')
                    ->where('wo_number', '=', $requestData['hide_wonum'])
                    ->first();


                if ($dataWO->wo_ins_code !== null) {
                    $dataIns = DB::table('ins_list')
                        ->where('ins_code', '=', $dataWO->wo_ins_code)
                        ->get();

                    foreach ($dataIns as $ins) {
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

                if ($dataWO->wo_qcspec_code !== null) {
                    $dataQC = DB::table('qcs_list')
                        ->where('qcs_code', '=', $dataWO->wo_qcspec_code)
                        ->get();


                    foreach ($dataQC as $qcspec) {
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

                toast('WO Successfuly Released for ' . $requestData['hide_wonum'] . ' !', 'success')->autoClose(10000);
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
