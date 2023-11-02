<?php

namespace App\Http\Controllers;

use App\Jobs\EmailScheduleJobs;
use App\Jobs\SendNotifReqSparepart;
use App\Jobs\SendNotifReqSparepartApproval;
use App\Jobs\SendNotifRetSparepart;
use App\Jobs\SendNotifRetSpWarehousetoEng;
use App\Jobs\SendNotifWarehouseToUser;
use App\Services\WSAServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Qxwsa as ModelsQxwsa;
use App\ReqSPMstr;
use App\Services\CreateTempTable;
use App\WOMaster;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class SparepartController extends Controller
{
    //REQUEST SPAREPART BROWSE
    public function reqspbrowse(Request $request)
    {
        $data = ReqSPMstr::query()
            ->with(['getCurrentApprover'])
            ->whereHas('getReqSPTransAppr', function ($q) {
                $q->where('rqtr_status', '=', 'waiting for approval');
                $q->orWhere('rqtr_status', '=', 'approved');
                $q->orWhere('rqtr_status', '=', 'revision');
            });

        $data = DB::table('req_sparepart')
            ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
            ->join('reqsp_trans_approval', 'reqsp_trans_approval.rqtr_mstr_id', 'req_sparepart.id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
            ->join('users', 'users.username', 'req_sparepart.req_sp_requested_by')
            ->groupBy('req_sp_number')
            ->orderBy('req_sp_due_date', 'DESC');

        $sp_all = DB::table('sp_mstr')
            ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
            ->where('spm_active', '=', 'Yes')
            ->get();

        $loc_to = DB::table('inp_supply')->get();

        $requestby = DB::table('req_sparepart')
            ->join('users', 'users.username', 'req_sparepart.req_sp_requested_by')
            ->groupBy('req_sp_requested_by')
            ->get();

        $datefrom = $request->get('s_datefrom') == '' ? '2000-01-01' : date($request->get('s_datefrom'));
        $dateto = $request->get('s_dateto') == '' ? '3000-01-01' : date($request->get('s_dateto'));

        if ($request->s_nomorrs) {
            $data->where('req_sp_number', 'like', '%' . $request->s_nomorrs . '%')
                ->orWhere('req_sp_wonumber', 'like', '%' . $request->s_nomorrs . '%');
        }

        if ($request->s_reqby) {
            $data->where('req_sp_requested_by', '=', $request->s_reqby);
        }

        if ($request->s_status) {
            $data->where('req_sp_status', '=', $request->s_status);
        }

        if ($datefrom != '' || $dateto != '') {
            $data->where('req_sp_due_date', '>=', $datefrom);
            $data->where('req_sp_due_date', '<=', $dateto);
        }

        if (Session::get('role') <> 'ADMIN') {
            $data = $data->where('req_sp_dept', Session::get('department'));
        }

        $data = $data->paginate(10);

        return view('sparepart.reqsparepart-browse', ['data' => $data, 'sp_all' => $sp_all, 'loc_to' => $loc_to, 'requestby' => $requestby,]);
    }

    //REQUEST SPAREPART CREATE
    public function reqspcreate()
    {
        $sp_all = DB::table('sp_mstr')
            ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
            ->where('spm_active', '=', 'Yes')
            ->get();

        $wo_sp = collect([]);

        $data = DB::table('req_sparepart')
            ->join('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
            ->get();

        $loc_to = DB::table('inp_supply')->get();

        //nomor wo akan di filter berdasarkan teknisi yang di assign pada wo tersebut, kecuali admin dapat mengakses semua nomor wo
        $username = Session::get('username');

        $womstr = WOMaster::where(function ($status) {
            $status->where('wo_status', '=', 'firm')
                ->orWhere('wo_status', '=', 'released')
                ->orWhere('wo_status', '=', 'started');
        })
            ->when(Session::get('role') <> 'ADMIN', function ($q) use ($username) {
                return $q
                    ->where(function ($q) use ($username) {
                        $q->where('wo_list_engineer', '=', $username . ';')
                            ->orWhere('wo_list_engineer', 'LIKE', $username . ';%')
                            ->orWhere('wo_list_engineer', 'LIKE', '%;' . $username . ';%')
                            ->orWhere('wo_list_engineer', 'LIKE', '%;' . $username)
                            ->orWhere('wo_list_engineer', '=', $username);
                    });
                // ->where('wo_department', Session::get('department'));
            })
            ->get();

        // dd($womstr);

        return view('sparepart.reqsparepart-detail', compact('data', 'wo_sp', 'sp_all', 'loc_to', 'womstr'));
    }

    //REQUEST SPAREPART CREATE (WO NUMBER)
    public function reqspwonbr()
    {
        //nomor wo akan di filter berdasarkan teknisi yang di assign pada wo tersebut, kecuali admin dapat mengakses semua nomor wo
        $username = Session::get('username');

        $data = WOMaster::where(function ($status) {
            $status->where('wo_status', '=', 'firm')
                ->orWhere('wo_status', '=', 'released')
                ->orWhere('wo_status', '=', 'started');
        })
            ->when(Session::get('role') <> 'ADMIN', function ($q) use ($username) {
                return $q
                    ->where(function ($q) use ($username) {
                        $q->where('wo_list_engineer', '=', $username . ';')
                            ->orWhere('wo_list_engineer', 'LIKE', $username . ';%')
                            ->orWhere('wo_list_engineer', 'LIKE', '%;' . $username . ';%')
                            ->orWhere('wo_list_engineer', 'LIKE', '%;' . $username)
                            ->orWhere('wo_list_engineer', '=', $username);
                    });
                // ->where('wo_department', Session::get('department'));
            })
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->select(DB::raw('wo_number,wo_sr_number,CONCAT(asset_code, " - ", asset_desc) as wo_asset,wo_note'))
            ->get();

        // dd($womstr);
        return response()->json($data);
    }

    //REQUEST SPAREPART CREATE (WO NUMBER) UNTUK FILTER LOKASI SUPPLY
    public function reqspwonbrsupp(Request $req)
    {
        $wonbr = $req->code;

        $data = WOMaster::where('wo_number', $wonbr)
            ->join('dept_mstr', 'dept_mstr.dept_code', 'wo_mstr.wo_department')
            ->join('inp_supply', 'inp_supply.inp_loc', 'dept_mstr.dept_inv')
            // ->select(DB::raw('wo_number,wo_sr_number,CONCAT(asset_code, " - ", asset_desc) as wo_asset,wo_note'))
            ->first();

        // dd($womstr);
        return response()->json($data);
    }
    //REQUEST SPAREPART ROUTE
    public function reqsproute(Request $request)
    {
        $rsnumber = $request->code;
        $datars = DB::table('req_sparepart')
            ->where('req_sp_number', '=', $rsnumber)
            ->first();

        $dataApprover = DB::table('reqsp_trans_approval')
            ->leftJoin('users', 'reqsp_trans_approval.rqtr_approved_by', '=', 'users.id')
            ->selectRaw('reqsp_trans_approval.*, users.username, users.dept_user')
            ->where('rqtr_mstr_id', '=', $datars->id)
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
                $output .= $approver->rqtr_dept_approval != null ? $approver->rqtr_dept_approval : $approver->dept_user;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->rqtr_role_approval;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->rqtr_reason;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->rqtr_status;
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
            $output .= '<td colspan="7" style="color:red">';
            $output .= '<center>You have not setup the approver, please cancel this request sparepart,<br>setup the approver first and create new request sparepart! </center>';
            $output .= '</td>';
            $output .= '</tr>';
        }



        return response($output);
    }

    //REQUEST SPAREPART SUBMIT AFTER CREATE
    public function reqspsubmit(Request $req)
    {
        DB::beginTransaction();

        try {

            //mengelompokan data dari request depan
            $requestData = $req->all(); // mengambil data dari request
            // dd($requestData);

            if (!empty($requestData['spreq'])) { //jika di released dengan adanya spare part

                $data = [
                    "spreq" => $requestData['spreq'],
                    "locto" => $requestData['locto'],
                    "qtyrequest" => $requestData['qtyrequest'],
                    "reqnote" => $requestData['reqnote'],
                    "siteto" => $requestData['siteto'],
                ];

                $groupedData = collect($data['spreq'])->map(function ($spreq, $key) use ($data) {
                    return [
                        'spreq' => $spreq,
                        'locto' => $data['locto'][$key],
                        'siteto' => $data['siteto'][$key],
                        'qtyrequest' => $data['qtyrequest'][$key],
                        'reqnote' => $data['reqnote'][$key],
                    ];
                })->groupBy('spreq')->map(function ($group) {
                    $totalqtyrequest = $group->sum('qtyrequest');

                    return [
                        'spreq' => $group[0]['spreq'],
                        'locto' => $group[0]['locto'],
                        'siteto' => $group[0]['siteto'],
                        'reqnote' => $group[0]['reqnote'],
                        'qtyrequest' => $totalqtyrequest,
                    ];
                })->values();

                $data = [];

                $user = Auth::user();
                // dd($user);

                $tablern = DB::table('running_mstr')->first();
                $newyear = Carbon::now()->format('y');

                // dd($tablern);

                if ($tablern->year == $newyear) {
                    $tempnewrunnbr = strval(intval($tablern->rs_nbr) + 1);
                    $newtemprunnbr = '';

                    // dd($tempnewrunnbr);

                    if (strlen($tempnewrunnbr) < 6) {
                        $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                    }
                } else {
                    $newtemprunnbr = "0001";
                }

                $runningnbr = $tablern->rs_prefix . '-' . $newyear . '-' . $newtemprunnbr;
                // dd($runningnbr);

                //simpan ke dalam req_sparepart
                $reqspmstrid = DB::table('req_sparepart')
                    ->insertGetId([
                        'req_sp_number' => $runningnbr,
                        'req_sp_wonumber' => $requestData['wonbr'] ? $requestData['wonbr'] : null,
                        'req_sp_dept' => $user->dept_user,
                        'req_sp_requested_by' => $user->username,
                        'req_sp_due_date' => $req->due_date,
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);

                DB::table('running_mstr')
                    ->where('rs_nbr', '=', $tablern->rs_nbr)
                    ->update([
                        'year' => $newyear,
                        'rs_nbr' => $newtemprunnbr
                    ]);

                //simpan ke dalam req_sparepart_det
                foreach ($groupedData as $loopsp) {

                    DB::table('req_sparepart_det')
                        ->insert([
                            'req_spd_mstr_id' => $reqspmstrid,
                            'req_spd_sparepart_code' => $loopsp['spreq'],
                            'req_spd_qty_request' => $loopsp['qtyrequest'],
                            'req_spd_loc_to' => $loopsp['locto'],
                            'req_spd_site_to' => $loopsp['siteto'],
                            'req_spd_reqnote' => $loopsp['reqnote'],
                            'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);

                    // simpan history created
                    DB::table('req_sparepart_hist')
                        ->insert([
                            'req_sph_number' => $runningnbr,
                            'req_sph_wonumber' => $requestData['wonbr'] ? $requestData['wonbr'] : null,
                            'req_sph_dept' => $user->dept_user,
                            'req_sph_reqby' => $user->username,
                            'req_sph_spcode' => $loopsp['spreq'],
                            'req_sph_qtyreq' => $loopsp['qtyrequest'],
                            'req_sph_siteto' => $loopsp['siteto'],
                            'req_sph_locto' => $loopsp['locto'],
                            'req_sph_reqnote' => $loopsp['reqnote'],
                            'req_sph_duedate' => $req->due_date,
                            'req_sph_action' => 'request sparepart created',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }

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
                    $womstr = DB::table('wo_mstr')->where('wo_number', $requestData['wonbr'])->first();
                    $rsmstr = DB::table('req_sparepart')->where('req_sp_number', $runningnbr)->first();

                    if ($womstr == null) {
                        $wonbr = null;
                    } else {
                        $wonbr = $womstr->wo_number;
                    }

                    //cek wo release approval master
                    $woapprover = DB::table('sp_approver_mstr')->where('id', '>', 0)->get();

                    if (count($woapprover) > 0) {
                        for ($i = 0; $i < count($woapprover); $i++) {
                            $nextroleapprover = $woapprover[$i]->sp_approver_role;
                            $nextseqapprover = $woapprover[$i]->sp_approver_order;

                            if ($woapprover[$i]->sp_approver_role == 'WHS') {
                                //jika user rolenya warehouse maka department dikosongkan
                                //update status wo approval
                                DB::table('reqsp_trans_approval')
                                    ->insert([
                                        'rqtr_mstr_id' => $rsmstr->id,
                                        'rqtr_wo_number' => $wonbr,
                                        // 'rqtr_dept_approval' => 'WHS',
                                        'rqtr_role_approval' => $nextroleapprover,
                                        'rqtr_sequence' => $nextseqapprover,
                                        'rqtr_status' => 'waiting for approval',
                                        'rqtr_reason' => null,
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                    ]);

                                //input ke wo trans approval hist jika ada approval department
                                DB::table('reqsp_trans_approval_hist')
                                    ->insert([
                                        'rqtrh_rs_number' => $rsmstr->req_sp_number,
                                        'rqtrh_wo_number' => $wonbr,
                                        // 'rqtrh_dept_approval' => 'WHS',
                                        'rqtrh_role_approval' => $nextroleapprover,
                                        'rqtrh_sequence' => $nextseqapprover,
                                        'rqtrh_status' => 'Request SP ready for approval',
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                        'updated_at' => Carbon::now()->toDateTimeString(),
                                    ]);
                            } else {
                                //update status wo approval
                                DB::table('reqsp_trans_approval')
                                    ->insert([
                                        'rqtr_mstr_id' => $rsmstr->id,
                                        'rqtr_wo_number' => $wonbr,
                                        'rqtr_dept_approval' => session()->get('department'),
                                        'rqtr_role_approval' => $nextroleapprover,
                                        'rqtr_sequence' => $nextseqapprover,
                                        'rqtr_status' => 'waiting for approval',
                                        'rqtr_reason' => null,
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                    ]);

                                //input ke wo trans approval hist jika ada approval department
                                DB::table('reqsp_trans_approval_hist')
                                    ->insert([
                                        'rqtrh_rs_number' => $rsmstr->req_sp_number,
                                        'rqtrh_wo_number' => $wonbr,
                                        'rqtrh_dept_approval' => session()->get('department'),
                                        'rqtrh_role_approval' => $nextroleapprover,
                                        'rqtrh_sequence' => $nextseqapprover,
                                        'rqtrh_status' => 'Request SP ready for approval',
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                        'updated_at' => Carbon::now()->toDateTimeString(),
                                    ]);
                            }
                        }
                    }

                    //send notifikasi ke approver pertama
                    //SendNotifReqSparepartApproval::dispatch($runningnbr, $requestData['wonbr'], $getFirstApprover->sp_approver_role, Session::get('department'));
                } else {
                    //jika tidak ada approver maka langsung kirim email ke warehouse
                    SendNotifReqSparepart::dispatch($runningnbr);
                }

                DB::commit();

                toast('Sparepart Requested ' . $runningnbr . ' Number Successfully !', 'success')->autoClose(10000);
                return redirect()->route('reqspbrowse');
            } else {
                toast('You have not request any sparepart yet !', 'error')->autoClose(10000);
                return redirect()->back();
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Sparepart Requested Failed', 'error');
            return redirect()->route('reqspbrowse');
        }
    }

    //REQUEST SPAREPART EDIT
    public function reqspeditdet(Request $req)
    {
        $rsnumber = $req->code;
        if ($req->ajax()) {

            $datas = DB::table('req_sparepart')
                ->join('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
                ->join('inp_supply', 'inp_supply.inp_loc', 'req_sparepart_det.req_spd_loc_to')
                ->where('req_sp_number', $rsnumber)
                // ->groupBy('req_sp_number')
                ->get();

            $sp_all = DB::table('sp_mstr')
                ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
                ->where('spm_active', '=', 'Yes')
                ->get();

            $loc_to = DB::table('inp_supply')->get();

            $output = '';
            foreach ($datas as $data) {
                $output .= '<tr>';
                $output .= '<td>';
                $output .= '<select name="te_spreq[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" required>';
                $output .= '<option value = ""> -- Select Sparepart -- </option>';
                foreach ($sp_all as $dat) {
                    $selected = ($dat->spm_code === $data->spm_code) ? 'selected' : '';
                    $output .= '<option value="' . $dat->spm_code . '" ' . $selected . '> ' . $dat->spm_code . ' -- ' . $dat->spm_desc . ' </option>';
                }
                $output .= '</select>';
                $output .= '</td>';
                $output .= '<td><input type="number" class="form-control" step=".01" min="0" name="te_qtyreq[]" value="' . $data->req_spd_qty_request . '"></td>';
                $output .= '<td>';
                $output .= '<select name="te_locto[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" required>';
                $output .= '<option value = ""> -- Select Location To -- </option>';
                foreach ($loc_to as $dat) {
                    $selected = ($dat->inp_loc === $data->inp_loc) ? 'selected' : '';
                    $output .= '<option value="' . $dat->inp_loc . '" ' . $selected . '> ' . $dat->inp_loc . ' </option>';
                }
                $output .= '</select>';
                $output .= '</td>';
                $output .= '<td>';
                $output .= '<textarea type="text" id="te_reqnote" class="form-control te_reqnote" name="te_reqnote[]" rows="2" >' . $data->req_spd_reqnote . '</textarea>';
                $output .= '</td>';
                $output .= '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">';
                $output .= '<input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>';
                $output .= '</tr>';
            }

            // dd($datas);

            return response($output);
        }
    }

    //REQUEST SPAREPART VIEW
    public function reqspviewdet(Request $req)
    {
        $rsnumber = $req->code;
        // dd($req->code);
        if ($req->ajax()) {

            $data = DB::table('req_sparepart')
                ->join('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
                ->join('inp_supply', 'inp_supply.inp_loc', 'req_sparepart_det.req_spd_loc_to')
                ->where('req_sp_number', $rsnumber)
                // ->groupBy('req_sp_number')
                ->get();
            // dd($data);

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>';
                $output .= '<td><input type="hidden" name="te_spreq[]" readonly>' . $data->req_spd_sparepart_code . ' -- ' . $data->spm_desc . '</td>';
                $output .= '</td>';
                $output .= '<td><input type="hidden" name="te_qtyreq[]" readonly>' . $data->req_spd_qty_request . '</td>';
                $output .= '<td><input type="hidden" name="te_qtyreq[]" readonly>' . $data->req_spd_qty_transfer . '</td>';
                $output .= '<td><input type="hidden" name="te_locto[]" readonly>' . $data->req_spd_loc_to . '</td>';
                $output .= '<td><input type="hidden" name="te_reqnote[]" readonly>' . $data->req_spd_reqnote . '</td>';
                $output .= '</td>';
                $output .= '</tr>';
            }

            // dd($output);

            return response($output);
        }
    }

    //REQUEST SPAREPART VIEW EAMS MESSAGE
    public function reqspviewdetappr(Request $req)
    {
        $rsnumber = $req->code;
        $rs = DB::table('req_sparepart')->where('req_sp_number', '=', $rsnumber)
            // ->selectRaw('id')
            ->first();

        if (session()->get('role') <> 'ADMIN') {
            //jika approver bukan admin
            $approver = DB::table('reqsp_trans_approval')
                ->leftJoin('users', 'users.id', 'reqsp_trans_approval.rqtr_approved_by')
                ->where('rqtr_mstr_id', $rs->id)
                ->where('rqtr_role_approval', session()->get('role'))
                ->first();
        } else {
            $approver = DB::table('reqsp_trans_approval')
                ->leftJoin('users', 'users.id', 'reqsp_trans_approval.rqtr_approved_by')
                ->where('rqtr_mstr_id', $rs->id)
                ->first();
        }
        // dd($approver);
        if ($req->ajax()) {

            $output = '';
            if ($approver->rqtr_status == 'approved') {
                $output .= '<label class="col-form-label" style="color:green;">this request sparepart has been approved by ' . $approver->username . '</label>';
            } elseif ($approver->rqtr_status == 'revision') {
                $output .= '<label class="col-form-label" style="color:red;">this request sparepart has been rejected by ' . $approver->username . '</label>';
            } else {
                $output .= '<label class="col-form-label" style="color:navy;">please wait the previous approver to do approval</label>';
            }
            // dd($output);

            return response($output);
        }
    }

    //REQUEST SPAREPART VIEW APPROVAL STATUS
    public function reqsprouteappr(Request $req)
    {
        $rs_number = $req->rs_number;
        $datawo = DB::table('req_sparepart')
            ->where('req_sp_number', '=', $rs_number)
            ->first();

        $dataApprover = DB::table('reqsp_trans_approval')
            ->leftJoin('users', 'reqsp_trans_approval.rqtr_approved_by', '=', 'users.id')
            ->leftJoin('dept_mstr', 'reqsp_trans_approval.rqtr_dept_approval', '=', 'dept_mstr.dept_code')
            ->selectRaw('reqsp_trans_approval.*, users.username, users.dept_user, dept_desc')
            ->where('rqtr_mstr_id', '=', $datawo->id)
            ->orderBy('rqtr_sequence', 'asc')
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
                $output .= $approver->rqtr_dept_approval ? $approver->rqtr_dept_approval . ' - ' . $approver->dept_desc : '';
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->rqtr_role_approval;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->rqtr_reason;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->rqtr_status;
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

    //REQUEST SPAREPART UPDATE AFTER EDIT
    public function reqspupdate(Request $req)
    {
        $newData = $req->all();
        // dd($newData);

        if ($req->te_spreq) {
            // cek apakah ada duplikat sparepart
            if (count(array_unique($req->te_spreq)) < count($req->te_spreq)) {
                toast('Duplicate Sparepart!!!', 'error');
                return back();
            }

            $reqspmstr = DB::table('req_sparepart')->where('req_sp_number', $req->e_rsnumber)->first();

            //jika due date diubah
            if ($reqspmstr->req_sp_due_date != $req->e_duedate) {
                DB::table('req_sparepart')
                    ->where('req_sp_number', $req->e_rsnumber)
                    ->update([
                        'req_sp_due_date' => $req->e_duedate,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
            }

            // delete data yg lama lalu insert request sparepart det jika tidak di delete

            $data = [
                "spreq" => $newData['te_spreq'],
                "locto" => $newData['te_locto'],
                "qtyrequest" => $newData['te_qtyreq'],
                "reqnote" => $newData['te_reqnote'],
                "tick" => $newData['tick'],
            ];

            $groupedData = collect($data['spreq'])->map(function ($spreq, $key) use ($data) {
                return [
                    'spreq' => $spreq,
                    'locto' => $data['locto'][$key],
                    'qtyrequest' => $data['qtyrequest'][$key],
                    'reqnote' => $data['reqnote'][$key],
                    "tick" => $data['tick'][$key],
                ];
            })->groupBy('spreq')->map(function ($group) {
                $totalqtyrequest = $group->sum('qtyrequest');

                return [
                    'spreq' => $group[0]['spreq'],
                    'locto' => $group[0]['locto'],
                    'reqnote' => $group[0]['reqnote'],
                    'qtyrequest' => $totalqtyrequest,
                    'tick' => $group[0]['tick'],
                ];
            })->values();

            //hapus data detail yg lama
            DB::table('req_sparepart_det')
                ->where('req_spd_mstr_id', $reqspmstr->id)
                ->delete();

            foreach ($groupedData as $data) {
                if ($data['tick'] == 0) {
                    DB::table('req_sparepart_det')
                        ->insert([
                            'req_spd_mstr_id' => $reqspmstr->id,
                            'req_spd_sparepart_code' => $data['spreq'],
                            'req_spd_qty_request' => $data['qtyrequest'],
                            'req_spd_loc_to' => $data['locto'],
                            'req_spd_reqnote' => $data['reqnote'],
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    if ($data['tick'] == 0 && $reqspmstr->req_sp_due_date == $req->e_duedate) {
                        //input history updated
                        DB::table('req_sparepart_hist')
                            ->insert([
                                'req_sph_number' => $req->e_rsnumber,
                                'req_sph_spcode' => $data['spreq'],
                                'req_sph_qtyreq' => $data['qtyrequest'],
                                'req_sph_siteto' => $data['siteto'],
                                'req_sph_locto' => $data['locto'],
                                'req_sph_reqnote' => $data['reqnote'],
                                'req_sph_action' => 'sparepart updated',
                                'created_at' => Carbon::now()->toDateTimeString(),
                            ]);
                    } else {
                        DB::table('req_sparepart_hist')
                            ->insert([
                                'req_sph_number' => $req->e_rsnumber,
                                'req_sph_spcode' => $data['spreq'],
                                'req_sph_qtyreq' => $data['qtyrequest'],
                                'req_sph_siteto' => $data['siteto'],
                                'req_sph_locto' => $data['locto'],
                                'req_sph_reqnote' => $data['reqnote'],
                                'req_sph_duedate' => $req->e_duedate,
                                'req_sph_action' => 'due date and sparepart updated',
                                'created_at' => Carbon::now()->toDateTimeString(),
                            ]);
                    }
                } else {
                    //input history deleted 1 sparepart
                    DB::table('req_sparepart_hist')
                        ->insert([
                            'req_sph_number' => $req->e_rsnumber,
                            'req_sph_spcode' => $data['spreq'],
                            'req_sph_qtyreq' => $data['qtyrequest'],
                            'req_sph_siteto' => $data['siteto'],
                            'req_sph_locto' => $data['locto'],
                            'req_sph_reqnote' => $data['reqnote'],
                            'req_sph_action' => 'sparepart deleted',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }
            }
        }

        $reqspapproval = DB::table('reqsp_trans_approval')->where('rqtr_mstr_id', $reqspmstr->id)->first();

        $reqspapprovalrole = DB::table('reqsp_trans_approval')
            ->where('rqtr_mstr_id', $reqspmstr->id)
            ->orderBy('rqtr_sequence', 'asc')
            ->first();
        // dd($reqspapproval);
        if ($reqspapproval->rqtr_status == 'revision') {

            DB::table('reqsp_trans_approval')
                ->where('rqtr_mstr_id', $reqspmstr->id)
                ->update([
                    'rqtr_status' => 'waiting for approval',
                    'rqtr_reason' => null,
                    'rqtr_approved_by' => null,
                    'updated_at' => null,
                ]);

            DB::table('reqsp_trans_approval_hist')
                ->insert([
                    'rqtrh_rs_number' => $reqspmstr->req_sp_number,
                    'rqtrh_wo_number' => $reqspmstr->req_sp_wonumber,
                    'rqtrh_dept_approval' => $reqspmstr->req_sp_dept,
                    'rqtrh_role_approval' => 'SPVSR',
                    'rqtrh_sequence' => 1,
                    'rqtrh_status' => 'waiting for approval',
                    'rqtrh_reason' => 'Request SP ready for approval again',
                    'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                ]);


            //email terkirim ke spv approval level 1
            SendNotifReqSparepartApproval::dispatch($reqspmstr->req_sp_number, $reqspmstr->req_sp_wonumber, $reqspapprovalrole->rqtr_role_approval, $reqspapprovalrole->rqtr_dept_approval);
        }

        $reqspdet = DB::table('req_sparepart_det')->where('req_spd_mstr_id', $reqspmstr->id)->get();

        if (count($reqspdet) == 0) {

            //delete masternya
            DB::table('req_sparepart')
                ->where('req_sp_number', $req->e_rsnumber)
                ->delete();

            //input history delete all sparepart
            DB::table('req_sparepart_hist')
                ->insert([
                    'req_sph_number' => $req->e_rsnumber,
                    'req_sph_action' => 'all sparepart deleted',
                    'created_at' => Carbon::now()->toDateTimeString(),
                ]);


            toast('Request Sparepart Updated Successfully!', 'success');
            return back();
        } else {
            return back();
        }
    }

    //REQUEST SPAREPART CANCEL
    public function reqspcancel(Request $req)
    {
        $rsnumber = $req->c_rsnumber;
        $reason = $req->c_reason;

        DB::table('req_sparepart')
            ->where('req_sp_number', $rsnumber)
            ->update([
                'req_sp_status' => 'canceled',
                'req_sp_cancel_note' => $reason,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        DB::table('req_sparepart_hist')
            ->insert([
                'req_sph_number' => $rsnumber,
                'req_sph_action' => 'canceled by user',
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);

        DB::commit();
        toast('Request Sparepart ' . $rsnumber . ' successfully canceled !', 'success');
        return back();
    }

    //REQUEST SPAREPART APPROVAL BROWSE
    public function reqspapprovalbrowse(Request $request)
    {
        // if (strpos(Session::get('menu_access'), 'BO06') !== false) {
        $usernow = DB::table('users')
            ->join('eng_mstr', 'users.username', 'eng_mstr.eng_code')
            ->where('eng_code', '=', session()->get('username'))
            ->where('active', '=', 'Yes')
            ->where('approver', '=', 1)
            ->first();
        // dd($engineer);

        $data = ReqSPMstr::query()
            ->with(['getCurrentApprover'])
            ->whereHas('getReqSPTransAppr', function ($q) {
                $q->where('rqtr_status', '=', 'waiting for approval');
                $q->orWhere('rqtr_status', '=', 'approved');
                $q->orWhere('rqtr_status', '=', 'revision');
            });

        $data = $data
            ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
            ->join('users', 'req_sparepart.req_sp_requested_by', 'users.username')
            ->where('req_sp_status', '!=', 'canceled')
            ->groupBy('req_sp_number')
            ->orderBy('req_sp_due_date', 'ASC');

        //pengecekan apakah user yg login adalah approver atau tidak
        if ($usernow != null) {
            //jika approver bukan admin
            if (Session::get('role') <> 'ADMIN') {
                $data = $data->join('reqsp_trans_approval', function ($join) {
                    $join->on('req_sparepart.id', '=', 'reqsp_trans_approval.rqtr_mstr_id')
                        ->where('rqtr_dept_approval', '=', Session::get('department'))
                        ->where('rqtr_role_approval', '=', Session::get('role'));
                });
            } else {
                $data = $data->join('reqsp_trans_approval', 'reqsp_trans_approval.rqtr_mstr_id', 'req_sparepart.id');
            }
        } else {
            toast('Anda tidak memiliki akses menu untuk melakukan approval, silahkan kontak admin', 'error');
            return back();
        }


        $sp_all = DB::table('sp_mstr')
            ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
            ->where('spm_active', '=', 'Yes')
            ->get();

        $loc_to = DB::table('inp_supply')->get();

        $requestby = DB::table('req_sparepart')
            ->join('users', 'users.username', 'req_sparepart.req_sp_requested_by')
            ->groupBy('req_sp_requested_by')
            ->get();

        $datefrom = $request->get('s_datefrom') == '' ? '2000-01-01' : date($request->get('s_datefrom'));
        $dateto = $request->get('s_dateto') == '' ? '3000-01-01' : date($request->get('s_dateto'));

        if ($request->s_nomorrs) {
            $data->where('req_sp_number', 'like', '%' . $request->s_nomorrs . '%')
                ->orWhere('req_sp_wonumber', 'like', '%' . $request->s_nomorrs . '%');
        }

        if ($request->s_reqby) {
            $data->where('req_sp_requested_by', '=', $request->s_reqby);
        }

        if ($request->s_status) {
            $data->where('rqtr_status', '=', $request->s_status);
        }

        if ($datefrom != '' || $dateto != '') {
            $data->where('req_sp_due_date', '>=', $datefrom);
            $data->where('req_sp_due_date', '<=', $dateto);
        }

        $data = $data
            ->selectRaw('req_sparepart.*, sp_mstr.*, users.username, rqtr_status, rqtr_dept_approval, rqtr_role_approval, rqtr_reason, rqtr_approved_by, reqsp_trans_approval.updated_at')
            ->paginate(10);

        // dd($data);

        return view('sparepart.reqsparepartappr-browse', ['data' => $data, 'sp_all' => $sp_all, 'loc_to' => $loc_to, 'requestby' => $requestby,]);
        // } 

    }

    //REQUEST SPAREPART APPROVAL
    public function reqspapproval(Request $req)
    {
        $rsnbr = $req->e_rsnumber;
        $reason = $req->v_reason;

        // dd($req->all());

        $user = Auth::user();

        $idrs = ReqSPMstr::where('req_sp_number', $rsnbr)->pluck('id')->first();

        //ambil data Req SP
        $reqspmstr = DB::table('req_sparepart')
            ->where('req_sp_number', $rsnbr)
            ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
            ->Join('users', 'req_sparepart.req_sp_requested_by', 'users.username')
            ->first();

        $srmstr = DB::table('service_req_mstr')->where('wo_number', $reqspmstr->req_sp_wonumber)->first();

        $wo = $reqspmstr->req_sp_wonumber;

        // $asset = $reqspmstr->asset_code . ' -- ' . $reqspmstr->asset_desc;
        $srnumber = $reqspmstr->req_sp_wonumber;

        $roleapprover = $user->role_user;

        $woapprovermstr = DB::table('sp_approver_mstr')->get();

        $countwoapprover = count($woapprovermstr);
        // dd($countwoapprover);

        //cek role user yg login
        if (Session::get('role') <> 'ADMIN') {
            //jika user bukan admin
            $woapprover = DB::table('reqsp_trans_approval')
                ->where('rqtr_mstr_id', $idrs)
                ->where('rqtr_role_approval', $user->role_user)
                ->first();
        } else {
            //jika user adalah admin
            $woapprover = DB::table('reqsp_trans_approval')
                ->where('rqtr_mstr_id', $idrs)
                ->first();
        }

        //cek next approver
        $nextapprover = DB::table('reqsp_trans_approval')->where('rqtr_mstr_id', $woapprover->rqtr_mstr_id)
            ->where('rqtr_sequence', '>', $woapprover->rqtr_sequence)
            ->first();

        // dd($nextapprover);

        //cek previous approver
        $prevapprover = DB::table('reqsp_trans_approval')->where('rqtr_mstr_id', $woapprover->rqtr_mstr_id)
            ->where('rqtr_sequence', '<', $woapprover->rqtr_sequence)
            ->first();
        // dd(is_null($prevapprover));

        //wo approved
        $rqtransapproved = [
            // 'rqtr_dept_approval' => $user->dept_user,
            'rqtr_status'      => 'approved',
            'rqtr_reason'      => $reason,
            'rqtr_approved_by' => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        $rqtransapprovedhist = [
            'rqtrh_rs_number'        => $reqspmstr->req_sp_number,
            'rqtrh_wo_number'        => $reqspmstr->req_sp_wonumber,
            'rqtrh_dept_approval'    => $user->dept_user,
            'rqtrh_role_approval'    => $user->role_user,
            'rqtrh_status'           => 'Request SP Approved',
            'rqtrh_reason'           => $reason,
            'rqtrh_sequence'         => $woapprover->rqtr_sequence,
            'rqtrh_approved_by'      => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        //wo approved setelah direject
        $rqtranswaiting = [
            // 'rqtr_dept_approval' => $user->dept_user,
            'rqtr_status'      => 'waiting for approval',
            'rqtr_reason'      => '',
            'rqtr_approved_by' => '',
            'updated_at' => '',
        ];

        $rqtranswaitinghist = [
            'rqtrh_rs_number'        => $reqspmstr->req_sp_number,
            'rqtrh_wo_number'        => $reqspmstr->req_sp_wonumber,
            'rqtrh_dept_approval'    => $user->dept_user,
            'rqtrh_role_approval'    => $user->role_user,
            'rqtrh_status'           => 'Request SP waiting for approval again',
            // 'rqtrh_reason'           => $reason,
            // 'rqtrh_sequence'         => $woapprover->rqtr_sequence,
            // 'rqtrh_approved_by'      => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        //wo rejected
        $rqtransreject = [
            // 'rqtr_dept_approval' => $user->dept_user,
            'rqtr_status'      => 'revision',
            'rqtr_reason'      => $reason,
            'rqtr_approved_by' => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        $rqtransrejecthist = [
            'rqtrh_rs_number'        => $reqspmstr->req_sp_number,
            'rqtrh_wo_number'        => $reqspmstr->req_sp_wonumber,
            'rqtrh_dept_approval'    => $user->dept_user,
            'rqtrh_status'           => 'Request SP Rejected',
            'rqtrh_reason'           => $reason,
            'rqtrh_sequence'         => $woapprover->rqtr_sequence,
            'rqtrh_approved_by'      => $user->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        if ($req->action == 'approve') {

            $srnumber = $reqspmstr->req_sp_number;
            $requestor = $reqspmstr->req_sp_requested_by;

            if ($countwoapprover != 0) {
                //jika next approver null
                if (is_null($nextapprover)) {
                    //cek apakah approver admin atau bukan
                    if (Session::get('role') <> 'ADMIN') {
                        //jika user bukan admin, hanya tingkatan yang rolenya sama yang akan menjadi approved
                        DB::table('reqsp_trans_approval')
                            ->where('rqtr_mstr_id', '=', $idrs)
                            ->where('rqtr_role_approval', '=', $user->role_user)
                            ->update($rqtransapproved);

                        DB::table('reqsp_trans_approval_hist')
                            ->insert($rqtransapprovedhist);
                    } else {
                        //jika user adalah admin, maka semua approval (approval bertingkat) akan menjadi approved
                        DB::table('reqsp_trans_approval')
                            ->where('rqtr_mstr_id', '=', $idrs)
                            ->update($rqtransapproved);

                        DB::table('reqsp_trans_approval_hist')
                            ->insert($rqtransapprovedhist);
                    }
                    //email terikirm ke engineer yg melakukan request sparepart
                    EmailScheduleJobs::dispatch('', '', '18', '', $requestor, $srnumber, '');

                    //email terkirim ke warehouse
                    SendNotifReqSparepart::dispatch($srnumber);
                } else {
                    // dd(2);
                    //jika next approval not null

                    $tampungarray = $nextapprover;
                    // $requestor = $reqspmstr->sr_req_by;

                    //cek apakah approver admin atau bukan
                    if (Session::get('role') <> 'ADMIN') {
                        //jika user bukan admin, hanya tingkatan yang rolenya sama yang akan menjadi approved
                        if ($nextapprover->rqtr_status == 'revision') {
                            //melakukan update data approval selain role approval supaya kembali menjadi waiting list
                            DB::table('reqsp_trans_approval')
                                ->where('rqtr_mstr_id', '=', $idrs)
                                ->where('rqtr_role_approval', '!=', $user->role_user)
                                ->update($rqtranswaiting);

                            DB::table('reqsp_trans_approval_hist')
                                ->insert($rqtranswaitinghist);

                            //melakukan update data sesuai role approval menjadi approved
                            DB::table('reqsp_trans_approval')
                                ->where('rqtr_mstr_id', '=', $idrs)
                                ->where('rqtr_role_approval', '=', $user->role_user)
                                ->update($rqtransapproved);

                            DB::table('reqsp_trans_approval_hist')
                                ->insert($rqtransapprovedhist);
                        } else {
                            DB::table('reqsp_trans_approval')
                                ->where('rqtr_mstr_id', '=', $idrs)
                                ->where('rqtr_role_approval', '=', $user->role_user)
                                ->update($rqtransapproved);

                            DB::table('reqsp_trans_approval_hist')
                                ->insert($rqtransapprovedhist);
                        }

                        //email terikirm ke approver selanjutnya
                        EmailScheduleJobs::dispatch($wo, '', '17', $tampungarray, '', $srnumber, $roleapprover);
                    } else {
                        // dd(2);
                        //jika user adalah admin, maka semua approval (approval bertingkat) akan menjadi approved
                        DB::table('reqsp_trans_approval')
                            ->where('rqtr_mstr_id', '=', $idrs)
                            ->update($rqtransapproved);

                        DB::table('reqsp_trans_approval_hist')
                            ->insert($rqtransapprovedhist);

                        //email terikirm ke engineer yg melakukan request sparepart
                        EmailScheduleJobs::dispatch('', '', '18', '', $requestor, $srnumber, '');

                        //email terkirim ke warehouse
                        SendNotifReqSparepart::dispatch($srnumber);
                    }
                }
            }

            DB::commit();
            toast('Request Sparepart ' . $reqspmstr->req_sp_number . ' approved successfuly', 'success');
            return redirect()->route('approvalBrowseSP');
        } else {
            //REJECT
            $srnumber = $reqspmstr->req_sp_number;
            $requestor = $reqspmstr->req_sp_requested_by;
            if (is_null($nextapprover)) {
                //kondisi hanya 1 approver atau approver terakhir

                //jika user bukan admin dan hanya 1 approver
                if (is_null($prevapprover) && Session::get('role') <> 'ADMIN') {
                    // dd('1 approver');
                    DB::table('reqsp_trans_approval')
                        ->where('rqtr_mstr_id', '=', $idrs)
                        ->where('rqtr_role_approval', '=', $user->role_user)
                        ->update($rqtransreject);

                    DB::table('reqsp_trans_approval_hist')
                        ->insert($rqtransrejecthist);
                } else {
                    // dd('approver terakhir');
                    DB::table('reqsp_trans_approval')
                        ->where('rqtr_mstr_id', '=', $idrs)
                        // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
                        ->update($rqtransreject);

                    DB::table('reqsp_trans_approval_hist')
                        ->insert($rqtransrejecthist);
                }
            } else {
                //kondisi approver pertama atau approver tengah
                DB::table('reqsp_trans_approval')
                    ->where('rqtr_mstr_id', '=', $idrs)
                    // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
                    ->update($rqtransreject);

                DB::table('reqsp_trans_approval_hist')
                    ->insert($rqtransrejecthist);
            }

            //email terkirim ke engineer yg melakukan request sparepart
            EmailScheduleJobs::dispatch($wo, '', '19', '', $requestor, $srnumber, '');

            // DB::commit();
            toast('Request Sparepart' . $reqspmstr->req_sp_number . ' has been rejected', 'success');
            return redirect()->route('approvalBrowseSP');
        }
    }

    //TRANSFER SPAREPART BROWSE
    public function trfspbrowse(Request $request)
    {
        if (Session::get('role') == 'ADMIN' || Session::get('role') == 'WHS') {

            $count_reqapprover = DB::table('sp_approver_mstr')->count();
            $data = DB::table('req_sparepart')
                ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
                // ->when($count_reqapprover <> 0, function ($q) use ($count_reqapprover) {
                //     return $q->where(function ($query) use ($count_reqapprover) { //kondisi untuk menampilkan request sparepart yang sudah di approved all level
                //         $query->whereIn('req_sparepart.id', function ($subquery) use ($count_reqapprover) {
                //             $subquery->select('rqtr_mstr_id')
                //                 ->from('reqsp_trans_approval')
                //                 ->whereIn('rqtr_status', ['approved'])
                //                 ->groupBy('rqtr_mstr_id')
                //                 ->havingRaw("COUNT(*) = $count_reqapprover"); // Menentukan jumlah level approval yang statusnya harus approved
                //         });
                //     });
                // })
                ->where(function ($query) use ($count_reqapprover) { //kondisi untuk menampilkan request sparepart yang sudah di approved all level
                    $query->whereIn('req_sparepart.id', function ($subquery) use ($count_reqapprover) {
                        $subquery->select('rqtr_mstr_id')
                            ->from('reqsp_trans_approval')
                            ->whereIn('rqtr_status', ['approved'])
                            ->groupBy('rqtr_mstr_id')
                            ->havingRaw("COUNT(*) = $count_reqapprover"); // Menentukan jumlah level approval yang statusnya harus approved
                    });
                })
                ->where('req_sp_status', '<>', 'canceled')
                ->groupBy('req_sp_number')
                ->orderBy('req_sp_due_date', 'ASC');
            // dd($data);

            $sp_all = DB::table('sp_mstr')
                ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
                ->where('spm_active', '=', 'Yes')
                ->get();

            $loc_to = DB::table('inp_supply')->get();

            $requestby = DB::table('req_sparepart')
                ->join('users', 'users.username', 'req_sparepart.req_sp_requested_by')
                ->groupBy('req_sp_requested_by')
                ->get();
        } else {
            return view('errors.401');
        }

        $datefrom = $request->get('s_datefrom') == '' ? '2000-01-01' : date($request->get('s_datefrom'));
        $dateto = $request->get('s_dateto') == '' ? '3000-01-01' : date($request->get('s_dateto'));

        if ($request->s_nomorrs) {
            $data->where('req_sp_number', 'like', '%' . $request->s_nomorrs . '%')
                ->orWhere('req_sp_wonumber', 'like', '%' . $request->s_nomorrs . '%');
        }

        if ($request->s_reqby) {
            $data->where('req_sp_requested_by', '=', $request->s_reqby);
        }

        if ($request->s_status) {
            $data->where('req_sp_status', '=', $request->s_status);
        }

        if ($datefrom != '' || $dateto != '') {
            $data->where('req_sp_due_date', '>=', $datefrom);
            $data->where('req_sp_due_date', '<=', $dateto);
        }

        $data = $data->paginate(10);
        // dd($data);

        return view('sparepart.trfsparepart-browse', ['data' => $data, 'sp_all' => $sp_all, 'loc_to' => $loc_to, 'requestby' => $requestby,]);
    }

    //TRANSFER SPAREPART CONFIRM
    public function trfspdet($id)
    {
        // dd($id);
        $data = DB::table('req_sparepart')
            ->where('req_sp_number', $id)
            ->where('req_sp_status', '!=', 'canceled')
            ->first();

        $sparepart_detail = DB::table('req_sparepart_det')
            ->join('req_sparepart', 'req_sparepart.id', 'req_sparepart_det.req_spd_mstr_id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
            ->join('inp_supply', 'inp_supply.inp_loc', 'req_sparepart_det.req_spd_loc_to')
            ->where('req_spd_mstr_id', $data->id)
            // ->groupBy('req_spd_mstr_id')
            ->get();

        // dd($sparepart_detail);
        $datalocsupply = DB::table('inp_supply')
            ->get();

        $sumqtytransferred = DB::table('req_sparepart_det')
            ->join('req_sparepart', 'req_sparepart.id', 'req_sparepart_det.req_spd_mstr_id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
            ->where('req_spd_mstr_id', $data->id)
            // ->get();
            ->sum('req_spd_qty_transfer');

        // dd($sumqtytransferred);
        return view('sparepart.trfsparepart-detail', compact(
            'data',
            'sparepart_detail',
            'datalocsupply',
            'sumqtytransferred',
        ));
    }

    //TRANSFER SPAREPART VIEW DETAIL
    public function trfspviewdet(Request $req)
    {
        $rsnumber = $req->code;
        // dd($req->code);
        if ($req->ajax()) {

            $data = DB::table('req_sparepart')
                ->join('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
                ->join('inp_supply', 'inp_supply.inp_loc', 'req_sparepart_det.req_spd_loc_to')
                ->where('req_sp_number', $rsnumber)
                ->get();
            // $data = DB::table('req_sparepart_hist')
            //     ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_hist.req_sph_spcode')
            //     ->join('req_sparepart', 'req_sparepart.req_sp_number', 'req_sparepart_hist.req_sph_number')
            //     ->join('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
            //     ->selectRaw('req_sparepart_hist.*,spm_desc,req_spd_reqnote,req_spd_note')
            //     ->where(function ($query) use ($rsnumber) {
            //         $query->where('req_sph_action', '=', 'request sparepart partial transferred')
            //               ->orWhere('req_sph_action', '=', 'request sparepart closed');
            //     })
            //     ->where('req_sph_number', $rsnumber)
            //     ->get();
            // dd($data);

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>';
                $output .= '<td><input type="hidden" name="te_spreq[]" readonly>' . $data->req_spd_sparepart_code . ' -- ' . $data->spm_desc . '</td>';
                $output .= '</td>';
                $output .= '<td><input type="hidden" name="te_qtyreq[]" readonly>' . $data->req_spd_qty_request . '</td>';
                // $output .= '<td><input type="hidden" name="te_sitefrom[]" readonly>' . $data->req_spd_site_from . '</td>';
                $output .= '<td><input type="hidden" name="te_locnlotfrom[]" readonly>' . $data->req_spd_site_from . ' & ' . $data->req_spd_loc_from . ' & ' . $data->req_spd_lot_from . '</td>';
                $output .= '<td><input type="hidden" name="te_reqnote[]" readonly>' . $data->req_spd_reqnote . '</td>';
                $output .= '<td><input type="hidden" name="te_qtytrf[]" readonly>' . $data->req_spd_qty_transfer . '</td>';
                // $output .= '<td><input type="hidden" name="te_siteto[]" readonly>' . $data->req_spd_site_to . '</td>';
                $output .= '<td><input type="hidden" name="te_locto[]" readonly>' . $data->req_spd_site_to . ' & ' . $data->req_spd_loc_to . '</td>';
                $output .= '<td><input type="hidden" name="te_note[]" readonly>' . $data->req_spd_note . '</td>';
                $output .= '</tr>';
            }

            // dd($output);

            return response($output);
        }
    }

    //TRANSFER SPAREPART VIEW HISTORY DETAIL
    public function trfspviewhist(Request $req)
    {
        $rsnumber = $req->code;
        // dd($req->code);
        if ($req->ajax()) {

            $data = DB::table('req_sparepart_hist')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_hist.req_sph_spcode')
                // ->join('req_sparepart', 'req_sparepart.req_sp_number', 'req_sparepart_hist.req_sph_number')
                // ->join('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
                ->selectRaw('req_sparepart_hist.*,spm_desc')
                ->where(function ($query) use ($rsnumber) {
                    $query->where('req_sph_action', '=', 'request sparepart partial transferred')
                        ->orWhere('req_sph_action', '=', 'request sparepart closed');
                })
                ->where('req_sph_number', $rsnumber)
                ->orderByDesc('created_at')
                ->get();
            // dd($data);

            $output = '';
            if ($data->count() > 0) {
                foreach ($data as $data) {
                    $output .= '<tr>';
                    $output .= '<td><input type="hidden" name="te_spreq[]" readonly>' . $data->req_sph_spcode . ' -- ' . $data->spm_desc . '</td>';
                    $output .= '</td>';
                    $output .= '<td><input type="hidden" name="te_qtyreq[]" readonly>' . $data->req_sph_qtyreq . '</td>';
                    // $output .= '<td><input type="hidden" name="te_sitefrom[]" readonly>' . $data->req_spd_site_from . '</td>';
                    $output .= '<td><input type="hidden" name="te_locnlotfrom[]" readonly>' . $data->req_sph_sitefrom . ' & ' . $data->req_sph_locfrom . ' & ' . $data->req_sph_lotfrom . '</td>';
                    // $output .= '<td><input type="hidden" name="te_reqnote[]" readonly>' . $data->req_sph_reqnote . '</td>';
                    $output .= '<td><input type="hidden" name="te_qtytrf[]" readonly>' . $data->req_sph_qtytrf . '</td>';
                    // $output .= '<td><input type="hidden" name="te_siteto[]" readonly>' . $data->req_spd_site_to . '</td>';
                    $output .= '<td><input type="hidden" name="te_locto[]" readonly>' . $data->req_sph_siteto . ' & ' . $data->req_sph_locto . '</td>';
                    $output .= '<td><input type="hidden" name="te_note[]" readonly>' . $data->req_sph_note . '</td>';
                    $output .= '<td><input type="hidden" name="te_note[]" readonly>' . $data->req_sph_trfby . '</td>';
                    $output .= '</td>';
                    $output .= '<td><input type="hidden" name="te_note[]" readonly>' . $data->created_at . '</td>';
                    $output .= '</td>';
                    $output .= '</tr>';
                }
            } else {
                $output .= '<tr>';
                $output .= '<td colspan="12" style="color:red">';
                $output .= '<center> No sparepart transaction yet </center>';
                $output .= '</td>';
                $output .= '</tr>';
            }

            // dd($output);

            return response($output);
        }
    }

    //RETURN SPAREPART BROWSE
    public function retspbrowse(Request $request)
    {
        $data = DB::table('ret_sparepart')
            ->leftJoin('ret_sparepart_det', 'ret_sparepart_det.ret_spd_mstr_id', 'ret_sparepart.id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'ret_sparepart_det.ret_spd_sparepart_code')
            ->join('users', 'users.username', 'ret_sparepart.ret_sp_return_by')
            ->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_desc, 
            DATE_FORMAT(ret_sparepart.created_at, "%Y-%m-%d") AS formatted_created_at')
            ->groupBy('ret_sp_number')
            ->orderByDesc('ret_sp_number');
        // dd($data);
        $sp_all = DB::table('sp_mstr')
            ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
            ->where('spm_active', '=', 'Yes')
            ->get();

        $loc_to = DB::table('inc_source')->get();

        $requestby = DB::table('ret_sparepart')
            ->join('users', 'users.username', 'ret_sparepart.ret_sp_return_by')
            ->groupBy('ret_sp_return_by')
            ->get();
        // dd($request->get('s_datefrom'));

        $datefrom = $request->get('s_datefrom') == '' ? '2000-01-01' : date($request->get('s_datefrom'));
        $dateto = $request->get('s_dateto') == '' ? '3000-01-01' : date($request->get('s_dateto'));

        if ($request->s_nomorrs) {
            $data->where('ret_sp_number', 'like', '%' . $request->s_nomorrs . '%')
                ->orWhere('ret_sp_wonumber', 'like', '%' . $request->s_nomorrs . '%');
        }

        if ($request->s_reqby) {
            $data->where('ret_sp_return_by', '=', $request->s_reqby);
        }

        if ($request->s_status) {
            $data->where('ret_sp_status', '=', $request->s_status);
        }

        if ($datefrom != '' || $dateto != '') {
            $data->whereRaw('DATE_FORMAT(ret_sparepart.created_at, "%Y-%m-%d") >= ?', [$datefrom]);
            $data->whereRaw('DATE_FORMAT(ret_sparepart.created_at, "%Y-%m-%d") <= ?', [$dateto]);
        }

        if (Session::get('role') <> 'ADMIN') {
            $data = $data->where('ret_sp_dept', Session::get('department'));
        }

        $data = $data->paginate(10);
        // dd($data);

        return view('sparepart.returnsparepart', ['data' => $data, 'sp_all' => $sp_all, 'loc_to' => $loc_to, 'requestby' => $requestby,]);
        // return view('sparepart.returnsparepart-mtc'); 
    }

    //RETURN SPAREPART CREATE
    public function retspcreate()
    {
        $sp_all = DB::table('sp_mstr')
            ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
            ->where('spm_active', '=', 'Yes')
            ->get();

        $wo_sp = collect([]);

        $data = DB::table('ret_sparepart')
            ->join('ret_sparepart_det', 'ret_sparepart_det.ret_spd_mstr_id', 'ret_sparepart.id')
            ->get();

        $loc_from = DB::table('inp_supply')->get();

        //nomor wo akan di filter berdasarkan departmen user yang login harus sama dengan departmen wo, kecuali admin dapat mengakses semua nomor wo
        $womstr = DB::table('wo_dets_sp')
            ->join('wo_mstr', 'wo_mstr.wo_number', 'wo_dets_sp.wd_sp_wonumber')
            ->leftJoin('ret_sparepart_det', 'ret_sparepart_det.ret_spd_wonumber', 'wo_dets_sp.wd_sp_wonumber')
            ->where('wo_status', '=', 'closed')
            ->when(Session::get('role') <> 'ADMIN', function ($q) {
                return $q->where('wo_department', Session::get('department'));
            })
            ->whereColumn('wd_sp_whtf', '>', 'wd_sp_issued') //untuk validasi bahwa qty yg mau dikembalikan sudah pernah di issued namun tidak full issued
            ->where('wd_already_returned', 0) //untuk validasi bahwa sp pada nomor tersebut belum pernah dikembalikan
            ->groupBy('wd_sp_wonumber')
            ->get();

        // dd($womstr);

        return view('sparepart.returnsparepart-detail', compact('data', 'wo_sp', 'sp_all', 'loc_from', 'womstr'));
    }

    //RETURN SPAREPART CREATE (WO NUMBER)
    public function retspwonbr()
    {
        //nomor wo akan di filter berdasarkan departmen user yang login harus sama dengan departmen wo, kecuali admin dapat mengakses semua nomor wo
        $username = Session::get('username');

        $data = DB::table('wo_dets_sp')
            ->join('wo_mstr', 'wo_mstr.wo_number', 'wo_dets_sp.wd_sp_wonumber')
            ->leftJoin('ret_sparepart_det', 'ret_sparepart_det.ret_spd_wonumber', 'wo_dets_sp.wd_sp_wonumber')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->where('wo_status', '=', 'closed')
            ->when(Session::get('role') <> 'ADMIN', function ($q) {
                return $q->where('wo_department', Session::get('department'));
            })
            ->whereColumn('wd_sp_required', '>', 'wd_sp_issued') //untuk validasi bahwa qty yg mau dikembalikan sudah pernah di issued namun tidak full issued
            ->where('wd_already_returned', 0) //untuk validasi bahwa sp pada nomor tersebut belum pernah dikembalikan
            ->groupBy('wd_sp_wonumber')
            ->select(DB::raw('wo_number,wo_sr_number,CONCAT(asset_code, " - ", asset_desc) as wo_asset,wo_note'))
            ->get();

        // dd($womstr);
        return response()->json($data);
    }

    //RETURN SPAREPART TO VIEW SPAREPART FROM WO
    public function retsplistwo(Request $req)
    {
        $wo_number = $req->wonumber;
        // dd($wo_number);
        $splistwo = WOMaster::join('wo_dets_sp', 'wo_dets_sp.wd_sp_wonumber', 'wo_mstr.wo_number')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'wo_dets_sp.wd_sp_spcode')
            ->leftJoin('inp_supply', 'inp_supply.inp_loc', 'wo_dets_sp.wd_sp_loc_issued')
            ->leftjoin('dept_mstr as u1', 'wo_mstr.wo_department', 'u1.dept_code')
            ->whereColumn('wd_sp_required', '>', 'wd_sp_issued') //untuk validasi bahwa qty yg mau dikembalikan sudah pernah di issued namun tidak full issued
            ->where('wo_number', $wo_number)
            ->select(DB::raw('wd_sp_spcode,spm_desc,wd_sp_required,wd_sp_issued,inp_loc,u1.dept_inv as dept_inp_loc'))
            ->get();

        $loc_from = DB::table('inp_supply')->get();

        $output = '';

        if ($splistwo->count() != 0) {
            foreach ($splistwo as $key => $data) {

                $output .= '<tr>';
                // $output .= '<td>';
                // $output .= $key + 1;
                // $output .= '</td>';
                $output .= '<td>';
                $output .= '<input type="text" class="form-control spretdesc" name="spretdesc[]" value="' . $data->wd_sp_spcode . ' -- ' . $data->spm_desc . '" readonly/>';
                $output .= '<input type="hidden" class="form-control spret" name="spret[]" value="' . $data->wd_sp_spcode . '" readonly/>';
                $output .= '</td>';
                $output .= '<td>';
                $output .= '<input type="number" class="form-control qtyreturn" name="qtyreturn[]" step=".01" max="' . ($data->wd_sp_required - $data->wd_sp_issued) . '"  min="0.01" value="' . ($data->wd_sp_required - $data->wd_sp_issued) . '" required />';
                $output .= '</td>';
                $output .= '<td>';
                $output .= '<select name="locto[]" style="display: inline-block !important;" class="form-control selectpicker locto" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="350px" autofocus required>';
                $output .= '<option value = ""> -- Select Location From -- </option>';
                foreach ($loc_from as $loc) {
                    if ($data->inp_loc == null) {
                        //jika dia belum pernah issued maka lokasi supplynya null dan akan disamakan dengan lokasi supply sesuai dengan wo departemen
                        $selected = ($loc->inp_loc === $data->dept_inp_loc) ? 'selected' : '';
                    }else{
                        //jika dia sudah pernah issued maka lokasi supplynya mengikuti lokasi issued
                        $selected = ($loc->inp_loc === $data->inp_loc) ? 'selected' : '';
                    }
                    $output .= '<option data-siteto="' . $loc->inp_supply_site . '" value="' . $loc->inp_loc . '"' . $selected . '>' . $loc->inp_loc . '</option>';
                }
                $output .= '</select>';
                $output .= '<input type="hidden" class="siteto" name="siteto[]" value="' . $loc->inp_supply_site . '"/>';
                $output .= '</td>';
                $output .= '<td>';
                $output .= '<textarea type="text" id="retnote" class="form-control retnote" name="retnote[]" rows="2" ></textarea>';
                $output .= '</td>';
                $output .= '<td data-title="Action" style="vertical-align:middle;text-align:center;">';
                $output .= '<input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete">';
                $output .= '<input type="hidden" class="op" name="op[]" value="A"/>';
                $output .= '</td>';
                $output .= '</tr>';
            }
        }

        return response($output);
    }

    //RETURN TRANSFER SPAREPART VIEW HISTORY DETAIL
    public function retspviewhist(Request $req)
    {
        $rsnumber = $req->code;
        // dd($req->code);
        if ($req->ajax()) {

            $data = DB::table('ret_sparepart_hist')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'ret_sparepart_hist.ret_sph_spcode')
                // ->join('req_sparepart', 'req_sparepart.req_sp_number', 'req_sparepart_hist.req_sph_number')
                // ->join('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
                ->selectRaw('ret_sparepart_hist.*,spm_desc')
                ->where(function ($query) use ($rsnumber) {
                    $query->where('ret_sph_action', '=', 'return sparepart partial transferred')
                        ->orWhere('ret_sph_action', '=', 'return sparepart closed');
                })
                ->where('ret_sph_number', $rsnumber)
                ->orderByDesc('created_at')
                ->get();
            // dd($data);

            $output = '';
            if ($data->count() > 0) {
                foreach ($data as $data) {
                    $output .= '<tr>';
                    $output .= '<td><input type="hidden" name="te_spreq[]" readonly>' . $data->ret_sph_spcode . ' -- ' . $data->spm_desc . '</td>';
                    $output .= '</td>';
                    $output .= '<td><input type="hidden" name="te_qtyreq[]" readonly>' . $data->ret_sph_qtyret . '</td>';
                    // $output .= '<td><input type="hidden" name="te_sitefrom[]" readonly>' . $data->req_spd_site_from . '</td>';
                    $output .= '<td><input type="hidden" name="te_locnlotfrom[]" readonly>' . $data->ret_sph_sitefrom . ' & ' . $data->ret_sph_locfrom . '</td>';
                    // $output .= '<td><input type="hidden" name="te_reqnote[]" readonly>' . $data->req_sph_reqnote . '</td>';
                    $output .= '<td><input type="hidden" name="te_qtytrf[]" readonly>' . $data->ret_sph_qtytrf . '</td>';
                    // $output .= '<td><input type="hidden" name="te_siteto[]" readonly>' . $data->req_spd_site_to . '</td>';
                    $output .= '<td><input type="hidden" name="te_locto[]" readonly>' . $data->ret_sph_siteto . ' & ' . $data->ret_sph_locto . ' & ' . $data->ret_sph_lotto . '</td>';
                    $output .= '<td><input type="hidden" name="te_note[]" readonly>' . $data->ret_sph_whsnote . '</td>';
                    $output .= '<td><input type="hidden" name="te_note[]" readonly>' . $data->ret_sph_trfby . '</td>';
                    $output .= '</td>';
                    $output .= '<td><input type="hidden" name="te_note[]" readonly>' . $data->created_at . '</td>';
                    $output .= '</td>';
                    $output .= '</tr>';
                }
            } else {
                $output .= '<tr>';
                $output .= '<td colspan="12" style="color:red">';
                $output .= '<center> No sparepart transaction yet </center>';
                $output .= '</td>';
                $output .= '</tr>';
            }

            // dd($output);

            return response($output);
        }
    }

    //RETURN SPAREPART SUBMIT AFTER CREATE
    public function retspsubmit(Request $req)
    {
        DB::beginTransaction();

        try {

            //mengelompokan data dari request depan
            $requestData = $req->all(); // mengambil data dari request
            // dd($requestData);

            if (!empty($requestData['spret'])) { //jika di released dengan adanya spare part

                $data = [
                    "spret" => $requestData['spret'],
                    "locto" => $requestData['locto'],
                    "qtyreturn" => $requestData['qtyreturn'],
                    "retnote" => $requestData['retnote'],
                    "siteto" => $requestData['siteto'],
                ];

                $groupedData = collect($data['spret'])->map(function ($spret, $key) use ($data) {
                    return [
                        'spret' => $spret,
                        'locto' => $data['locto'][$key],
                        'siteto' => $data['siteto'][$key],
                        'qtyreturn' => $data['qtyreturn'][$key],
                        'retnote' => $data['retnote'][$key],
                    ];
                })->groupBy('spret')->map(function ($group) {
                    $totalqtyreturn = $group->sum('qtyreturn');

                    return [
                        'spret' => $group[0]['spret'],
                        'locto' => $group[0]['locto'],
                        'siteto' => $group[0]['siteto'],
                        'retnote' => $group[0]['retnote'],
                        'qtyreturn' => $totalqtyreturn,
                    ];
                })->values();

                $data = [];
                $wonbr = $requestData['wonbr'] ? $requestData['wonbr'] : null;

                $user = Auth::user();
                // dd($user);

                $tablern = DB::table('running_mstr')->first();
                $newyear = Carbon::now()->format('y');

                // dd($tablern);

                if ($tablern->year == $newyear) {
                    $tempnewrunnbr = strval(intval($tablern->rt_nbr) + 1);
                    $newtemprunnbr = '';

                    // dd($tempnewrunnbr);

                    if (strlen($tempnewrunnbr) < 6) {
                        $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                    }
                } else {
                    $newtemprunnbr = "0001";
                }

                $runningnbr = $tablern->rt_prefix . '-' . $newyear . '-' . $newtemprunnbr;
                // dd($runningnbr);

                //simpan ke dalam ret_sparepart
                $reqspmstrid = DB::table('ret_sparepart')
                    ->insertGetId([
                        'ret_sp_number' => $runningnbr,
                        'ret_sp_wonumber' => $wonbr,
                        'ret_sp_dept' => $user->dept_user,
                        'ret_sp_return_by' => $user->username,
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);

                DB::table('running_mstr')
                    ->where('rt_nbr', '=', $tablern->rt_nbr)
                    ->update([
                        'year' => $newyear,
                        'rt_nbr' => $newtemprunnbr
                    ]);

                //simpan ke dalam ret_sparepart_det
                foreach ($groupedData as $loopsp) {

                    DB::table('ret_sparepart_det')
                        ->insert([
                            'ret_spd_mstr_id' => $reqspmstrid,
                            'ret_spd_wonumber' => $wonbr,
                            'ret_spd_sparepart_code' => $loopsp['spret'],
                            'ret_spd_qty_return' => $loopsp['qtyreturn'],
                            'ret_spd_loc_from' => $loopsp['locto'],
                            'ret_spd_site_from' => $loopsp['siteto'],
                            'ret_spd_engnote' => $loopsp['retnote'],
                            'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);

                    // simpan history created
                    DB::table('ret_sparepart_hist')
                        ->insert([
                            'ret_sph_number' => $runningnbr,
                            'ret_sph_wonumber' => $wonbr,
                            'ret_sph_dept' => $user->dept_user,
                            'ret_sph_retby' => $user->username,
                            'ret_sph_spcode' => $loopsp['spret'],
                            'ret_sph_qtyret' => $loopsp['qtyreturn'],
                            'ret_sph_locfrom' => $loopsp['locto'],
                            'ret_sph_sitefrom' => $loopsp['siteto'],
                            // 'ret_sph_duedate' => $req->due_date,
                            'ret_sph_action' => 'return sparepart created',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }

                //tambahkan data ke table approval wo release
                //cek apakah approval release sudah di setting atau belum
                // $checkApprover = DB::table('sp_approver_mstr')
                //     ->count();

                // // dd($checkApprover);

                // if ($checkApprover > 0) {
                //     //jika ada settingan approver

                //     //ambil role approver order paling pertama untuk dikirimkan email notifikasi
                //     $getFirstApprover = DB::table('sp_approver_mstr')
                //         ->orderBy('sp_approver_order', 'ASC')
                //         ->first();

                //     // dd($getFirstApprover);

                //     //send notifikasi ke approver pertama
                //     SendNotifReqSparepartApproval::dispatch($runningnbr, $requestData['wonbr'], $getFirstApprover->sp_approver_role, Session::get('department'));

                //     //get wo dan sr mstr
                //     $womstr = DB::table('wo_mstr')->where('wo_number', $requestData['wonbr'])->first();
                //     $rsmstr = DB::table('req_sparepart')->where('req_sp_number', $runningnbr)->first();

                //     //cek wo release approval master
                //     $woapprover = DB::table('sp_approver_mstr')->where('id', '>', 0)->get();

                //     if (count($woapprover) > 0) {
                //         for ($i = 0; $i < count($woapprover); $i++) {
                //             $nextroleapprover = $woapprover[$i]->sp_approver_role;
                //             $nextseqapprover = $woapprover[$i]->sp_approver_order;

                //             if ($woapprover[$i]->sp_approver_role == 'WHS') {
                //                 //jika user rolenya warehouse maka department dikosongkan
                //                 //update status wo approval
                //                 DB::table('reqsp_trans_approval')
                //                     ->insert([
                //                         'rqtr_mstr_id' => $rsmstr->id,
                //                         'rqtr_wo_number' => $womstr->wo_number,
                //                         // 'rqtr_dept_approval' => 'WHS',
                //                         'rqtr_role_approval' => $nextroleapprover,
                //                         'rqtr_sequence' => $nextseqapprover,
                //                         'rqtr_status' => 'waiting for approval',
                //                         'rqtr_reason' => null,
                //                         'created_at' => Carbon::now()->toDateTimeString(),
                //                     ]);

                //                 //input ke wo trans approval hist jika ada approval department
                //                 DB::table('reqsp_trans_approval_hist')
                //                     ->insert([
                //                         'rqtrh_rs_number' => $rsmstr->req_sp_number,
                //                         'rqtrh_wo_number' => $womstr->wo_number,
                //                         // 'rqtrh_dept_approval' => 'WHS',
                //                         'rqtrh_role_approval' => $nextroleapprover,
                //                         'rqtrh_sequence' => $nextseqapprover,
                //                         'rqtrh_status' => 'Request SP ready for approval',
                //                         'created_at' => Carbon::now()->toDateTimeString(),
                //                         'updated_at' => Carbon::now()->toDateTimeString(),
                //                     ]);
                //             } else {
                //                 //update status wo approval
                //                 DB::table('reqsp_trans_approval')
                //                     ->insert([
                //                         'rqtr_mstr_id' => $rsmstr->id,
                //                         'rqtr_wo_number' => $womstr->wo_number,
                //                         'rqtr_dept_approval' => session()->get('department'),
                //                         'rqtr_role_approval' => $nextroleapprover,
                //                         'rqtr_sequence' => $nextseqapprover,
                //                         'rqtr_status' => 'waiting for approval',
                //                         'rqtr_reason' => null,
                //                         'created_at' => Carbon::now()->toDateTimeString(),
                //                     ]);

                //                 //input ke wo trans approval hist jika ada approval department
                //                 DB::table('reqsp_trans_approval_hist')
                //                     ->insert([
                //                         'rqtrh_rs_number' => $rsmstr->req_sp_number,
                //                         'rqtrh_wo_number' => $womstr->wo_number,
                //                         'rqtrh_dept_approval' => session()->get('department'),
                //                         'rqtrh_role_approval' => $nextroleapprover,
                //                         'rqtrh_sequence' => $nextseqapprover,
                //                         'rqtrh_status' => 'Request SP ready for approval',
                //                         'created_at' => Carbon::now()->toDateTimeString(),
                //                         'updated_at' => Carbon::now()->toDateTimeString(),
                //                     ]);
                //             }
                //         }
                //     }
                // }

                //kirim email ke warehouse
                SendNotifRetSparepart::dispatch($runningnbr);

                DB::commit();

                toast('Sparepart Return ' . $runningnbr . ' Number Successfully !', 'success')->autoClose(10000);
                return redirect()->route('retspbrowse');
            } else {
                toast('You have not return any sparepart yet !', 'error')->autoClose(10000);
                return redirect()->back();
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Sparepart Return Failed', 'error');
            return redirect()->route('retspbrowse');
        }
    }

    //RETURN SPAREPART EDIT
    public function retspeditdet(Request $req)
    {
        $rsnumber = $req->code;
        $wonumber = $req->wonbr;
        // dd($wonumber <> null);
        if ($req->ajax()) {

            $datas = DB::table('ret_sparepart')
                ->leftJoin('ret_sparepart_det', 'ret_sparepart_det.ret_spd_mstr_id', 'ret_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'ret_sparepart_det.ret_spd_sparepart_code')
                ->join('users', 'users.username', 'ret_sparepart.ret_sp_return_by')
                ->join('inp_supply', 'inp_supply.inp_loc', 'ret_sparepart_det.ret_spd_loc_from')
                // ->when($wonumber != null, function ($q) {
                //     return $q->join('wo_dets_sp', 'wo_dets_sp.wd_sp_wonumber', 'ret_sparepart.ret_sp_wonumber')
                //         ->whereColumn('wd_sp_required', '>', 'wd_sp_issued')
                //         ->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_code, spm_desc, inp_loc, wd_sp_spcode');
                // }, 
                // function ($q) {
                //     return $q->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_code, spm_desc, inp_loc');
                // })
                ->where('ret_sp_number', $rsnumber)
                ->get();

            // if ($wonumber != null) {
            //     // dd(1);
            //     $datas = $datas->join('wo_dets_sp', 'wo_dets_sp.wd_sp_wonumber', 'ret_sparepart.ret_sp_wonumber')
            //         // ->whereColumn('wd_sp_required', '>', 'wd_sp_issued')
            //         ->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_code, spm_desc, inp_loc');
            // }else{
            //     dd(2);
            //     $datas = $datas->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_code, spm_desc, inp_loc');
            // }

            // $datas = $datas->get();

            $sp_all = DB::table('sp_mstr')
                ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
                ->where('spm_active', '=', 'Yes')
                ->get();

            $loc_to = DB::table('inp_supply')->get();

            // dd($datas);

            $output = '';
            foreach ($datas as $data) {
                if ($wonumber != null) {
                    $output .= '<tr>';
                    $output .= '<td>';
                    $output .= '<input type="text" class="form-control spretdesc" name="spretdesc[]" value="' . $data->spm_code . ' -- ' . $data->spm_desc . '" readonly/>';
                    $output .= '<input type="hidden" class="form-control spret" name="te_spret[]" value="' . $data->spm_code . '" readonly/>';
                    $output .= '</td>';
                    $output .= '<td><input type="number" class="form-control" step=".01" min="0.01" max="' . $data->ret_spd_qty_return . '" name="te_qtyret[]" value="' . $data->ret_spd_qty_return . '"></td>';
                    $output .= '<td>';
                    $output .= '<select name="te_locto[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" required>';
                    $output .= '<option value = ""> -- Select Location To -- </option>';
                    foreach ($loc_to as $dat) {
                        $selected = ($dat->inp_loc === $data->inp_loc) ? 'selected' : '';
                        $output .= '<option value="' . $dat->inp_loc . '" ' . $selected . '> ' . $dat->inp_loc . ' </option>';
                    }
                    $output .= '</select>';
                    $output .= '</td>';
                    $output .= '<td>';
                    $output .= '<textarea type="text" id="te_retnote" class="form-control te_retnote" name="te_retnote[]" rows="2" >' . $data->ret_spd_engnote . '</textarea>';
                    $output .= '</td>';
                    $output .= '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">';
                    $output .= '<input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>';
                    $output .= '</tr>';
                } else {
                    $output .= '<tr>';
                    $output .= '<td>';
                    $output .= '<select name="te_spret[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" required>';
                    $output .= '<option value = ""> -- Select Sparepart -- </option>';
                    foreach ($sp_all as $dat) {
                        $selected = ($dat->spm_code === $data->spm_code) ? 'selected' : '';
                        $output .= '<option value="' . $dat->spm_code . '" ' . $selected . '> ' . $dat->spm_code . ' -- ' . $dat->spm_desc . ' </option>';
                    }
                    $output .= '</select>';
                    $output .= '</td>';
                    $output .= '<td><input type="number" class="form-control" step=".01" min="0.01" max="' . $data->ret_spd_qty_return . '" name="te_qtyret[]" value="' . $data->ret_spd_qty_return . '"></td>';
                    $output .= '<td>';
                    $output .= '<select name="te_locto[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" required>';
                    $output .= '<option value = ""> -- Select Location To -- </option>';
                    foreach ($loc_to as $dat) {
                        $selected = ($dat->inp_loc === $data->inp_loc) ? 'selected' : '';
                        $output .= '<option value="' . $dat->inp_loc . '" ' . $selected . '> ' . $dat->inp_loc . ' </option>';
                    }
                    $output .= '</select>';
                    $output .= '</td>';
                    $output .= '<td>';
                    $output .= '<textarea type="text" id="te_retnote" class="form-control te_retnote" name="te_retnote[]" rows="2" >' . $data->ret_spd_engnote . '</textarea>';
                    $output .= '</td>';
                    $output .= '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">';
                    $output .= '<input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>';
                    $output .= '</tr>';
                }
            }

            // dd($datas);

            return response($output);
        }
    }

    //RETURN SPAREPART VIEW
    public function retspviewdet(Request $req)
    {
        $rsnumber = $req->code;
        // dd($req->code);
        if ($req->ajax()) {

            $data = DB::table('ret_sparepart')
                ->leftJoin('ret_sparepart_det', 'ret_sparepart_det.ret_spd_mstr_id', 'ret_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'ret_sparepart_det.ret_spd_sparepart_code')
                ->join('users', 'users.username', 'ret_sparepart.ret_sp_return_by')
                ->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_desc')
                ->where('ret_sp_number', $rsnumber)
                // ->groupBy('req_sp_number')
                ->get();
            // dd($data);

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>';
                $output .= '<td><input type="hidden" name="te_spreq[]" readonly>' . $data->ret_spd_sparepart_code . ' -- ' . $data->spm_desc . '</td>';
                $output .= '</td>';
                $output .= '<td><input type="hidden" name="te_qtyreq[]" readonly>' . $data->ret_spd_qty_return . '</td>';
                $output .= '<td><input type="hidden" name="te_locto[]" readonly>' . $data->ret_spd_loc_from . '</td>';
                $output .= '<td><input type="hidden" name="te_reqnote[]" readonly>' . $data->ret_spd_engnote . '</td>';
                $output .= '</td>';
                $output .= '</tr>';
            }

            // dd($output);

            return response($output);
        }
    }

    //RETURN SPAREPART UPDATE AFTER EDIT
    public function retspupdate(Request $req)
    {
        $newData = $req->all();
        $wonbr = $req->e_wonumber;
        if ($req->te_spret) {
            // cek apakah ada duplikat sparepart
            if (count(array_unique($req->te_spret)) < count($req->te_spret)) {
                toast('Duplicate Sparepart!!!', 'error');
                return back();
            }

            $retspmstr = DB::table('ret_sparepart')->where('ret_sp_number', $req->e_rsnumber)->first();

            // delete data yg lama lalu insert request sparepart det jika tidak di delete

            $data = [
                "spret" => $newData['te_spret'],
                "locto" => $newData['te_locto'],
                "qtyreturn" => $newData['te_qtyret'],
                "retnote" => $newData['te_retnote'],
                "tick" => $newData['tick'],
            ];

            $groupedData = collect($data['spret'])->map(function ($spret, $key) use ($data) {
                return [
                    'spret' => $spret,
                    'locto' => $data['locto'][$key],
                    'qtyreturn' => $data['qtyreturn'][$key],
                    'retnote' => $data['retnote'][$key],
                    "tick" => $data['tick'][$key],
                ];
            })->groupBy('spret')->map(function ($group) {
                $totalqtyreturn = $group->sum('qtyreturn');

                return [
                    'spret' => $group[0]['spret'],
                    'locto' => $group[0]['locto'],
                    'retnote' => $group[0]['retnote'],
                    'qtyreturn' => $totalqtyreturn,
                    'tick' => $group[0]['tick'],
                ];
            })->values();

            //hapus data detail yg lama
            DB::table('ret_sparepart_det')
                ->where('ret_spd_mstr_id', $retspmstr->id)
                ->delete();

            foreach ($groupedData as $data) {
                if ($data['tick'] == 0) {
                    DB::table('ret_sparepart_det')
                        ->insert([
                            'ret_spd_mstr_id' => $retspmstr->id,
                            'ret_spd_sparepart_code' => $data['spret'],
                            'ret_spd_qty_return' => $data['qtyreturn'],
                            'ret_spd_loc_to' => $data['locto'],
                            'ret_spd_engnote' => $data['retnote'],
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    //input history updated
                    DB::table('ret_sparepart_hist')
                        ->insert([
                            'ret_sph_number' => $req->e_rsnumber,
                            'ret_sph_wonumber' => $wonbr,
                            'ret_sph_spcode' => $data['spret'],
                            'ret_sph_qtyret' => $data['qtyreturn'],
                            'ret_sph_locto' => $data['locto'],
                            'ret_sph_action' => 'sparepart updated',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);
                } else {
                    //input history deleted 1 sparepart
                    DB::table('ret_sparepart_hist')
                        ->insert([
                            'ret_sph_number' => $req->e_rsnumber,
                            'ret_sph_spcode' => $data['spret'],
                            'ret_sph_qtyret' => $data['qtyreturn'],
                            'ret_sph_locto' => $data['locto'],
                            'ret_sph_action' => 'sparepart deleted',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }
            }

            toast('Return Sparepart Updated Successfully!', 'success')->autoClose(10000);
        }

        $retspdet = DB::table('ret_sparepart_det')->where('ret_spd_mstr_id', $retspmstr->id)->get();

        if (count($retspdet) == 0) {

            //delete masternya
            DB::table('ret_sparepart')
                ->where('ret_sp_number', $req->e_rsnumber)
                ->delete();

            //input history delete all sparepart
            DB::table('ret_sparepart_hist')
                ->insert([
                    'ret_sph_number' => $req->e_rsnumber,
                    'ret_sph_action' => 'all sparepart deleted',
                    'created_at' => Carbon::now()->toDateTimeString(),
                ]);


            toast('Return Sparepart Updated Successfully!', 'success')->autoClose(1000);
            return back();
        } else {
            return back();
        }
    }

    //RETURN SPAREPART CANCEL
    public function retspcancel(Request $req)
    {
        $rsnumber = $req->c_rsnumber;
        $reason = $req->c_reason;

        DB::table('ret_sparepart')
            ->where('ret_sp_number', $rsnumber)
            ->update([
                'ret_sp_status' => 'canceled',
                'ret_sp_cancelnote' => $reason,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        DB::table('ret_sparepart_hist')
            ->insert([
                'ret_sph_number' => $rsnumber,
                'ret_sph_action' => 'canceled by user',
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);

        DB::commit();
        toast('Return Sparepart ' . $rsnumber . ' successfully canceled !', 'success');
        return back();
    }

    //CHECKING STOCK SPAREPART IN INVENTORY SOURCE FOR TRANSFER SPAREPART
    public function gettrfspwsastockfrom(Request $req)
    {
        // $assetsite = $req->get('assetsite');
        $spcode = $req->get('spcode');

        //ambil data dari tabel inc_source berdasarkan asset site nya
        $getSource = DB::table('inc_source')
            ->get();

        $data = [];

        foreach ($getSource as $invsource) {
            $qadsourcedata = (new WSAServices())->wsagetsource($spcode, $invsource->inc_source_site, $invsource->inc_loc);

            if ($qadsourcedata === false) {
                toast('WSA Connection Failed', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {
                // jika hasil WSA ke QAD tidak ditemukan
                if ($qadsourcedata[1] !== "false") {

                    // jika hasil WSA ditemukan di QAD, ambil dari QAD kemudian disimpan dalam array untuk nantinya dikelompokan lagi data QAD tersebut berdasarkan part dan site

                    $resultWSA = $qadsourcedata[0];

                    //kumpulkan hasilnya ke dalam 1 array sebagai penampung list location dan lot from
                    foreach ($resultWSA as $thisresult) {
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
        }

        return response()->json($data);
    }

    //CHECKING STOCK SPAREPART IN INVENTORY SOURCE FOR RETURN SPAREPART
    public function getretspwsastockfrom(Request $req)
    {
        // $assetsite = $req->get('assetsite');
        $spcode = $req->get('spcode');

        //ambil data dari tabel inc_source berdasarkan asset site nya
        $getSource = DB::table('inc_source')
            ->get();

        $data = [];

        Schema::dropIfExists('temp_table');
        Schema::create('temp_table', function ($table) {
            $table->string('t_domain');
            $table->string('t_part');
            $table->string('t_site');
            $table->string('t_loc')->nullable();
            $table->string('t_lot')->nullable();
            $table->decimal('t_qtyoh', 10, 2);
            $table->temporary();
        });

        foreach ($getSource as $invsource) {
            $qadsourcedata = (new WSAServices())->wsagetsource($spcode, $invsource->inc_source_site, $invsource->inc_loc);

            if ($qadsourcedata === false) {
                toast('WSA Connection Failed', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {
                // jika hasil WSA ke QAD tidak ditemukan
                if ($qadsourcedata[1] !== "false") {

                    // jika hasil WSA ditemukan di QAD, ambil dari QAD kemudian disimpan dalam array untuk nantinya dikelompokan lagi data QAD tersebut berdasarkan part dan site

                    $resultWSA = $qadsourcedata[0];
                    // dd($resultWSA);

                    //kumpulkan hasilnya ke dalam 1 array sebagai penampung list location dan lot from
                    foreach ($resultWSA as $thisresult) {

                        DB::table('temp_table')
                            ->insert([
                                't_domain' => (string) $thisresult->t_domain,
                                't_part' => (string) $thisresult->t_part,
                                't_site' => (string) $thisresult->t_site,
                                't_loc' => (string) $thisresult->t_loc,
                                // 't_lot' => (string) $thisresult->t_lot,
                                't_qtyoh' => number_format((float) $thisresult->t_qtyoh, 2),
                            ]);
                    }

                    $data = DB::table('temp_table')
                        ->select(DB::raw('temp_table.*, sum(t_qtyoh) as totalqty'))
                        ->groupBy(['t_site', 't_loc'])
                        ->get();

                    // dd($temp_table);
                }
            }
        }

        return response()->json($data);
    }

    //WSA SETTING
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

    //TRANSFER SPAREPART SUBMIT
    public function trfspsubmit(Request $req)
    {
        // dd($req->all());

        //ambil data dari qad untuk pengecekan kembali stock inventory source di QAD
        Schema::dropIfExists('temp_table');
        Schema::create('temp_table', function ($table) {
            $table->string('t_part');
            $table->string('t_site');
            $table->string('t_loc')->nullable();
            $table->string('t_lot')->nullable();
            $table->decimal('t_qtyoh', 10, 2);
            $table->temporary();
        });

        foreach ($req->hidden_spcode as $index => $spcode) {
            // dd($req->loclotfrom[$index], $req->locto[$index], $req->qtytotransfer[$index]);
            if ($req->loclotfrom[$index] != null && $req->hidden_locto[$index] != null && $req->qtytotransfer[$index] > 0) {
                $getActualStockSource = (new WSAServices())->wsacekstoksource($spcode, $req->hidden_sitefrom[$index], $req->hidden_locfrom[$index], $req->hidden_lotfrom[$index]);

                if ($getActualStockSource === false) {
                    toast('WSA Connection Failed', 'error')->persistent('Dismiss');
                    return redirect()->back();
                } else {

                    // jika hasil WSA ke QAD tidak ditemukan
                    if ($getActualStockSource[1] == "false") {
                        toast('Something went wrong with the data', 'error')->persistent('Dismiss');
                        return redirect()->back();
                    }


                    // jika hasil WSA ditemukan di QAD, ambil dari QAD kemudian disimpan dalam array untuk nantinya dikelompokan lagi data QAD tersebut berdasarkan part dan site

                    $resultWSA = $getActualStockSource[0];

                    //kumpulkan hasilnya ke dalam 1 array sebagai penampung list location dan lot from
                    foreach ($resultWSA as $thisresult) {
                        DB::table('temp_table')
                            ->insert([
                                't_part' => $thisresult->t_part,
                                't_site' => $thisresult->t_site,
                                't_loc' => $thisresult->t_loc,
                                't_lot' => $thisresult->t_lot,
                                't_qtyoh' => $thisresult->t_qtyoh,
                            ]);
                    }
                }
            }
        }

        $dataStockQAD = DB::table('temp_table')
            ->get();


        Schema::dropIfExists('temp_table');

        DB::beginTransaction();

        try {

            $notEnough = "";
            foreach ($req->qtytotransfer as $index => $qtytotransfer) {
                if ($req->loclotfrom[$index] != null && $req->hidden_locto[$index] != null && $qtytotransfer > 0) {
                    foreach ($dataStockQAD as $source) {
                        if ($req->hidden_spcode[$index] == $source->t_part && $req->hidden_sitefrom[$index] == $source->t_site && $req->hidden_locfrom[$index] == $source->t_loc && $req->hidden_lotfrom[$index] == $source->t_lot) {
                            if (floatval($req->qtytotransfer[$index]) > floatval($source->t_qtyoh)) {
                                //jika tidak cukup berikan alert
                                // dump($source->t_qtyoh);
                                $notEnough .= $req->hidden_spcode[$index] . ", ";
                            }
                        }
                    }
                }
            }

            if ($notEnough != "") {
                $notEnough = rtrim($notEnough, ", "); // hapus koma terakhir
                alert()->html('<u><b>Alert!</b></u>', "<b>The qty to be transferred does not have sufficient stock for the following spare part code :</b><br>" . $notEnough . "", 'error')->persistent('Dismiss');
                return redirect()->back();
            }

            /* Qxtend Transfer Single Item */
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
                <wsa:To>urn:services-qad-com:' . $qxRcv . '</wsa:To>
                <wsa:MessageID>urn:services-qad-com::' . $qxRcv . '</wsa:MessageID>
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
                    <qcom:propertyValue>' . $domain . '</qcom:propertyValue>
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
                    <qcom:propertyValue/>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>password</qcom:propertyName>
                    <qcom:propertyValue/>
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

            $reqspmstr = DB::table('req_sparepart')->where('req_sp_number', $req->hide_rsnum)->first();

            foreach ($req->qtytotransfer as $index => $qtyfromweb) {
                if ($qtyfromweb > 0) { //jika qty to transfer yang diisi user dari menu wo transfer lebih dari 0, baru lakukan qxtend transfer single item
                    $qdocBody .= '<item>
                            <part>' . $req->hidden_spcode[$index] . '</part>
                            <itemDetail>
                                <lotserialQty>' . $qtyfromweb . '</lotserialQty>
                                <nbr>' . $req->hide_rsnum . '</nbr>
                                <siteFrom>' . $req->hidden_sitefrom[$index] . '</siteFrom>
                                <locFrom>' . $req->hidden_locfrom[$index] . '</locFrom>
                                <lotserFrom>' . $req->hidden_lotfrom[$index] . '</lotserFrom>
                                <siteTo>' . $req->hidden_siteto[$index] . '</siteTo>
                                <locTo>' . $req->hidden_locto[$index] . '</locTo>
                            </itemDetail>
                        </item>';


                    $user = Auth::user();

                    $reqspdet = DB::table('req_sparepart_det')
                        ->where('req_spd_mstr_id', '=', $reqspmstr->id)
                        ->where('req_spd_sparepart_code', '=', $req->hidden_spcode[$index])
                        ->first();

                    if ($req->qtytotransfer[$index] > 0) {

                        if ($reqspdet->req_spd_qty_request != $req->qtytotransfer[$index]) {
                            //jika qty transfer tidak sama dengan request maka akan ditambahkan dengan qty yang pernah di transfer (partial)
                            DB::table('req_sparepart_det')
                                ->where('req_spd_mstr_id', '=', $reqspmstr->id)
                                ->where('req_spd_sparepart_code', '=', $req->hidden_spcode[$index])
                                ->update([
                                    'req_spd_qty_transfer' => $reqspdet->req_spd_qty_transfer + $req->qtytotransfer[$index],
                                    'req_spd_site_from' => $req->hidden_sitefrom[$index],
                                    'req_spd_loc_from' => $req->hidden_locfrom[$index],
                                    'req_spd_lot_from' => $req->hidden_lotfrom[$index],
                                    'req_spd_note' => $req->notes[$index],
                                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);

                            // simpan history transferred
                            DB::table('req_sparepart_hist')
                                ->insert([
                                    'req_sph_number' => $req->hide_rsnum,
                                    'req_sph_wonumber' => $reqspmstr->req_sp_wonumber ? $reqspmstr->req_sp_wonumber : null,
                                    'req_sph_dept' => $reqspmstr->req_sp_dept,
                                    'req_sph_reqby' => $reqspmstr->req_sp_requested_by,
                                    'req_sph_trfby' => $user->username,
                                    'req_sph_spcode' => $req->hidden_spcode[$index],
                                    'req_sph_qtyreq' => $reqspdet->req_spd_qty_request,
                                    'req_sph_qtytrf' => $req->qtytotransfer[$index],
                                    'req_sph_siteto' => $reqspdet->req_spd_site_to,
                                    'req_sph_locto' => $reqspdet->req_spd_loc_to,
                                    'req_sph_sitefrom' => $req->hidden_sitefrom[$index],
                                    'req_sph_locfrom' => $req->hidden_locfrom[$index],
                                    'req_sph_lotfrom' => $req->hidden_lotfrom[$index],
                                    'req_sph_reqnote' => $reqspdet->req_spd_reqnote,
                                    'req_sph_note' => $req->notes[$index],
                                    'req_sph_duedate' => $reqspmstr->req_sp_due_date,
                                    'req_sph_action' => 'request sparepart partial transferred',
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                ]);
                        } else {

                            DB::table('req_sparepart_det')
                                ->where('req_spd_mstr_id', '=', $reqspmstr->id)
                                ->where('req_spd_sparepart_code', '=', $req->hidden_spcode[$index])
                                ->update([
                                    'req_spd_qty_transfer' => $req->qtytotransfer[$index],
                                    'req_spd_site_from' => $req->hidden_sitefrom[$index],
                                    'req_spd_loc_from' => $req->hidden_locfrom[$index],
                                    'req_spd_lot_from' => $req->hidden_lotfrom[$index],
                                    'req_spd_note' => $req->notes[$index],
                                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);

                            // simpan history transferred
                            DB::table('req_sparepart_hist')
                                ->insert([
                                    'req_sph_number' => $req->hide_rsnum,
                                    'req_sph_wonumber' => $reqspmstr->req_sp_wonumber ? $reqspmstr->req_sp_wonumber : null,
                                    'req_sph_dept' => $reqspmstr->req_sp_dept,
                                    'req_sph_reqby' => $reqspmstr->req_sp_requested_by,
                                    'req_sph_trfby' => $user->username,
                                    'req_sph_spcode' => $req->hidden_spcode[$index],
                                    'req_sph_qtyreq' => $reqspdet->req_spd_qty_request,
                                    'req_sph_qtytrf' => $req->qtytotransfer[$index],
                                    'req_sph_siteto' => $reqspdet->req_spd_site_to,
                                    'req_sph_locto' => $reqspdet->req_spd_loc_to,
                                    'req_sph_sitefrom' => $req->hidden_sitefrom[$index],
                                    'req_sph_locfrom' => $req->hidden_locfrom[$index],
                                    'req_sph_lotfrom' => $req->hidden_lotfrom[$index],
                                    'req_sph_reqnote' => $reqspdet->req_spd_reqnote,
                                    'req_sph_note' => $req->notes[$index],
                                    'req_sph_duedate' => $reqspmstr->req_sp_due_date,
                                    'req_sph_action' => 'request sparepart closed',
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                ]);
                        }
                    }


                    //simpan list spare part yang di released ke table wo_det jika nomor wo dipilih
                    if ($reqspmstr->req_sp_wonumber != null) {
                        DB::table('wo_dets_sp')
                            ->insert([
                                'wd_sp_wonumber' => $reqspmstr->req_sp_wonumber,
                                'wd_sp_spcode' => $req->hidden_spcode[$index],
                                'wd_sp_required' => $req->qtytotransfer[$index],
                                'wd_sp_whtf' => $req->qtytotransfer[$index],
                                'wd_sp_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                'wd_sp_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                    }
                }
            }

            $sumqtyreq = DB::table('req_sparepart_det')
                ->where('req_spd_mstr_id', '=', $reqspmstr->id)
                ->sum('req_spd_qty_request');

            $sumqtytrf = DB::table('req_sparepart_det')
                ->where('req_spd_mstr_id', '=', $reqspmstr->id)
                ->sum('req_spd_qty_transfer');

            // dd($sumqtyreq, $sumqtytrf);
            if ($sumqtyreq != $sumqtytrf) {
                //jika qty yg di transfer tidak sesuai jumlah qty request dia masih bisa transfer lagi
                DB::table('req_sparepart')
                    ->where('req_sp_number', '=', $req->hide_rsnum)
                    ->update([
                        'req_sp_transfered_by' => $user->username,
                        'req_sp_transfer_date' => Carbon::now('ASIA/JAKARTA')->format('Y-m-d'),
                        'req_sp_status' => 'partial transferred',
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);
            } else {
                //jika qty yg di transfer sama dengan qty request maka statusnya menjadi closed
                DB::table('req_sparepart')
                    ->where('req_sp_number', '=', $req->hide_rsnum)
                    ->update([
                        'req_sp_transfered_by' => $user->username,
                        'req_sp_transfer_date' => Carbon::now('ASIA/JAKARTA')->format('Y-m-d'),
                        'req_sp_status' => 'closed',
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);
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

            if (!empty($qdocFault)) {
                DB::rollBack();

                $qdocFault = (string) $xmlResp->xpath('//soapenv:faultstring')[0];

                alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $qdocFault . "", 'error')->persistent('Dismiss');
                return redirect()->back();
            }

            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



            if ($qdocResult == "success" or $qdocResult == "warning") {
                /* jika response sukses atau warning maka menyimpan data jika sudah di transferr ke qad*/
                $rsnumber = $req->hide_rsnum;
                //kirim notifikasi kepada para engineer yg mengerjakan wo tersebut bahwa spare part yg tidak cukup sudah ditransfer ke inventory supply
                // SendNotifWarehouseToUser::dispatch($rsnumber);
            } else {

                //jika qtend mengembalikan pesan error 

                DB::rollBack();
                $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                $outputerror = '';
                foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                    $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                    $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                    $outputerror .= "&bull;  " . $context . " - " . $desc . "<br>";
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

                alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $outputerror . "", 'error')->persistent('Dismiss');
                return redirect()->back();
                /* jika qxtend response error */
            }

            DB::commit();

            toast('Spare Part Transfer for ' . $req->hide_rsnum . ' Successfuly !', 'success');
            return redirect()->route('trfspbrowse');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Confirm Failed', 'error');
            return redirect()->route('trfspbrowse');
        }
    }

    //RETURN SPAREPART WAREHOUSE BROWSE
    public function retspwhsbrowse(Request $request)
    {
        if (Session::get('role') == 'ADMIN' || Session::get('role') == 'WHS') {
            $data = DB::table('ret_sparepart')
                ->leftJoin('ret_sparepart_det', 'ret_sparepart_det.ret_spd_mstr_id', 'ret_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'ret_sparepart_det.ret_spd_sparepart_code')
                ->join('users', 'users.username', 'ret_sparepart.ret_sp_return_by')
                ->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_desc, ret_sparepart.created_at')
                ->groupBy('ret_sp_number')
                ->orderByDesc('ret_sp_number');

            // $data = DB::table('req_sparepart')
            //     ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
            //     ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
            //     ->where('req_sp_status', '!=', 'canceled')
            //     ->groupBy('req_sp_number')
            //     ->orderBy('req_sp_due_date', 'ASC');

            $sp_all = DB::table('sp_mstr')
                ->select('spm_code', 'spm_desc', 'spm_um', 'spm_site', 'spm_loc', 'spm_lot')
                ->where('spm_active', '=', 'Yes')
                ->get();

            $loc_to = DB::table('inc_source')->get();

            $requestby = DB::table('ret_sparepart')
                ->join('users', 'users.username', 'ret_sparepart.ret_sp_return_by')
                ->groupBy('ret_sp_return_by')
                ->get();
        } else {
            return view('errors.401');
        }

        // $datefrom = $request->get('s_datefrom') == '' ? '2000-01-01' : date($request->get('s_datefrom'));
        // $dateto = $request->get('s_dateto') == '' ? '3000-01-01' : date($request->get('s_dateto'));

        if ($request->s_nomorrs) {
            $data->where('ret_sp_number', 'like', '%' . $request->s_nomorrs . '%');
        }

        if ($request->s_reqby) {
            $data->where('ret_sp_return_by', '=', $request->s_reqby);
        }

        if ($request->s_status) {
            $data->where('ret_sp_status', '=', $request->s_status);
        }

        // if ($datefrom != '' || $dateto != '') {
        //     $data->where('req_sp_due_date', '>=', $datefrom);
        //     $data->where('req_sp_due_date', '<=', $dateto);
        // }

        $data = $data->paginate(10);
        // dd($data);

        return view('sparepart.returnsparepartwhs-browse', ['data' => $data, 'sp_all' => $sp_all, 'loc_to' => $loc_to, 'requestby' => $requestby,]);
    }

    //RETURN SPAREPART WAREHOUSE CONFIRM
    public function retspwhsdet($id)
    {
        // dd($id);
        $data = DB::table('ret_sparepart')
            ->where('ret_sp_number', $id)
            ->where('ret_sp_status', '!=', 'canceled')
            ->first();

        $sparepart_detail = DB::table('ret_sparepart')
            ->join('ret_sparepart_det', 'ret_sparepart_det.ret_spd_mstr_id', 'ret_sparepart.id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'ret_sparepart_det.ret_spd_sparepart_code')
            ->join('users', 'users.username', 'ret_sparepart.ret_sp_return_by')
            ->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_desc, ret_sparepart.created_at')
            // ->groupBy('ret_sp_number')
            ->where('ret_spd_mstr_id', $data->id)
            // ->groupBy('req_spd_mstr_id')
            ->get();

        // dd($sparepart_detail);
        $datalocsupply = DB::table('inc_source')
            ->get();

        // dd($sparepart_detail);
        return view('sparepart.returnsparepartwhs-detail', compact(
            'data',
            'sparepart_detail',
            'datalocsupply',
        ));
    }

    //RETURN SPAREPART VIEW DETAIL
    public function retspwhsviewdet(Request $req)
    {
        $rsnumber = $req->code;
        // dd($req->code);
        if ($req->ajax()) {

            $data = DB::table('ret_sparepart')
                ->leftJoin('ret_sparepart_det', 'ret_sparepart_det.ret_spd_mstr_id', 'ret_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'ret_sparepart_det.ret_spd_sparepart_code')
                ->join('users', 'users.username', 'ret_sparepart.ret_sp_return_by')
                ->selectRaw('ret_sparepart.*, ret_sparepart_det.*, users.username, spm_desc, ret_sparepart.created_at')
                // ->groupBy('ret_sp_number')
                ->where('ret_sp_number', $rsnumber)
                // ->groupBy('req_sp_number')
                ->get();
            // dd($data);

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>';
                $output .= '<td><input type="hidden" name="te_spreq[]" readonly>' . $data->ret_spd_sparepart_code . ' -- ' . $data->spm_desc . '</td>';
                $output .= '</td>';
                $output .= '<td><input type="hidden" name="te_qtyret[]" readonly>' . $data->ret_spd_qty_return . '</td>';
                // $output .= '<td><input type="hidden" name="te_sitefrom[]" readonly>' . $data->ret_spd_site_from . '</td>';
                $output .= '<td><input type="hidden" name="te_locnlotfrom[]" readonly>' . $data->ret_spd_site_from . ' & ' . $data->ret_spd_loc_from . '</td>';
                $output .= '<td><input type="hidden" name="te_retnote[]" readonly>' . $data->ret_spd_engnote . '</td>';
                $output .= '<td><input type="hidden" name="te_qtytrf[]" readonly>' . $data->ret_spd_qty_transfer . '</td>';
                // $output .= '<td><input type="hidden" name="te_siteto[]" readonly>' . $data->ret_spd_site_to . '</td>';
                $output .= '<td><input type="hidden" name="te_locto[]" readonly>' . $data->ret_spd_site_to . ' & ' . $data->ret_spd_loc_to . '</td>';
                $output .= '<td><input type="hidden" name="te_note[]" readonly>' . $data->ret_spd_whsnote . '</td>';
                $output .= '</td>';
                $output .= '</tr>';
            }

            // dd($output);

            return response($output);
        }
    }

    //RETURN SPAREPART WAREHOUSE SUBMIT
    public function retspwhssubmit(Request $req)
    {
        // dd($req->all()); 

        DB::beginTransaction();

        try {

            /* Qxtend Transfer Single Item */
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
                <wsa:To>urn:services-qad-com:' . $qxRcv . '</wsa:To>
                <wsa:MessageID>urn:services-qad-com::' . $qxRcv . '</wsa:MessageID>
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
                    <qcom:propertyValue>' . $domain . '</qcom:propertyValue>
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
                    <qcom:propertyValue/>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>password</qcom:propertyName>
                    <qcom:propertyValue/>
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

            $retspmstr = DB::table('ret_sparepart')->where('ret_sp_number', $req->hide_rsnum)->first();

            foreach ($req->qtytotransfer as $index => $qtyfromweb) {
                if ($qtyfromweb > 0) { //jika qty to transfer yang diisi user dari menu wo transfer lebih dari 0, baru lakukan qxtend transfer single item
                    $qdocBody .= '<item>
                            <part>' . $req->hidden_spcode[$index] . '</part>
                            <itemDetail>
                                <lotserialQty>' . $qtyfromweb . '</lotserialQty>
                                <nbr>' . $req->hide_rsnum . '</nbr>
                                <siteFrom>' . $req->hidden_sitefrom[$index] . '</siteFrom>
                                <locFrom>' . $req->hidden_locfrom[$index] . '</locFrom>
                                <lotserTo>' . $req->hidden_lotto[$index] . '</lotserTo>
                                <siteTo>' . $req->hidden_siteto[$index] . '</siteTo>
                                <locTo>' . $req->hidden_locto[$index] . '</locTo>
                            </itemDetail>
                        </item>';

                    $user = Auth::user();

                    $retspdet = DB::table('ret_sparepart_det')
                        ->where('ret_spd_mstr_id', '=', $retspmstr->id)
                        ->where('ret_spd_sparepart_code', '=', $req->hidden_spcode[$index])
                        ->first();

                    if ($req->qtytotransfer[$index] > 0) {
                        if ($retspdet->ret_spd_qty_return != $req->qtytotransfer[$index]) {
                            //jika qty transfer tidak sama dengan qty return maka akan ditambahkan dengan qty yang pernah di transfer (partial)
                            DB::table('ret_sparepart_det')
                                ->where('ret_spd_mstr_id', '=', $retspmstr->id)
                                ->where('ret_spd_sparepart_code', '=', $req->hidden_spcode[$index])
                                ->update([
                                    'ret_spd_qty_transfer' => $retspdet->ret_spd_qty_transfer + $req->qtytotransfer[$index],
                                    'ret_spd_site_to' => $req->hidden_siteto[$index],
                                    'ret_spd_loc_to' => $req->hidden_locto[$index],
                                    'ret_spd_lot_to' => $req->hidden_lotto[$index],
                                    'ret_spd_whsnote' => $req->notes[$index],
                                    'ret_sp_flag' => 1,
                                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);

                            DB::table('ret_sparepart_hist')
                                ->insert([
                                    'ret_sph_number' =>  $req->hide_rsnum,
                                    'ret_sph_wonumber' =>  $retspmstr->ret_sp_wonumber,
                                    'ret_sph_dept' =>  $retspmstr->ret_sp_dept,
                                    'ret_sph_retby' =>  $retspmstr->ret_sp_return_by,
                                    'ret_sph_trfby' => $user->username,
                                    'ret_sph_spcode' => $req->hidden_spcode[$index],
                                    'ret_sph_qtyret' => $retspdet->ret_spd_qty_return,
                                    'ret_sph_qtytrf' => $req->qtytotransfer[$index],
                                    'ret_sph_siteto' => $req->hidden_siteto[$index],
                                    'ret_sph_locto' => $req->hidden_locto[$index],
                                    'ret_sph_lotto' => $req->hidden_lotto[$index],
                                    'ret_sph_sitefrom' => $req->hidden_sitefrom[$index],
                                    'ret_sph_locfrom' => $req->hidden_locfrom[$index],
                                    'ret_sph_whsnote' => $req->notes[$index],
                                    'ret_sph_action' => 'return sparepart partial transferred',
                                    'created_at' => Carbon::now('ASIA/JAKARTA'),
                                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                        } else {
                            DB::table('ret_sparepart_det')
                                ->where('ret_spd_mstr_id', '=', $retspmstr->id)
                                ->where('ret_spd_sparepart_code', '=', $req->hidden_spcode[$index])
                                ->update([
                                    'ret_spd_qty_transfer' => $req->qtytotransfer[$index],
                                    'ret_spd_site_to' => $req->hidden_siteto[$index],
                                    'ret_spd_loc_to' => $req->hidden_locto[$index],
                                    'ret_spd_lot_to' => $req->hidden_lotto[$index],
                                    'ret_spd_whsnote' => $req->notes[$index],
                                    'ret_sp_flag' => 1,
                                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);

                            DB::table('ret_sparepart_hist')
                                ->insert([
                                    'ret_sph_number' =>  $req->hide_rsnum,
                                    'ret_sph_wonumber' =>  $retspmstr->ret_sp_wonumber,
                                    'ret_sph_dept' =>  $retspmstr->ret_sp_dept,
                                    'ret_sph_retby' =>  $retspmstr->ret_sp_return_by,
                                    'ret_sph_trfby' => $user->username,
                                    'ret_sph_spcode' => $req->hidden_spcode[$index],
                                    'ret_sph_qtyret' => $retspdet->ret_spd_qty_return,
                                    'ret_sph_qtytrf' => $req->qtytotransfer[$index],
                                    'ret_sph_siteto' => $req->hidden_siteto[$index],
                                    'ret_sph_locto' => $req->hidden_locto[$index],
                                    'ret_sph_lotto' => $req->hidden_lotto[$index],
                                    'ret_sph_sitefrom' => $req->hidden_sitefrom[$index],
                                    'ret_sph_locfrom' => $req->hidden_locfrom[$index],
                                    'ret_sph_whsnote' => $req->notes[$index],
                                    'ret_sph_action' => 'return sparepart closed',
                                    'created_at' => Carbon::now('ASIA/JAKARTA'),
                                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                        }
                    }

                    DB::table('wo_dets_sp')
                        ->where('wd_sp_wonumber', '=', $retspmstr->ret_sp_wonumber)
                        ->update([
                            'wd_already_returned' => 1
                        ]);

                    $sumqtyret = DB::table('ret_sparepart_det')
                        ->where('ret_spd_mstr_id', '=', $retspmstr->id)
                        ->sum('ret_spd_qty_return');

                    $sumqtytrf = DB::table('ret_sparepart_det')
                        ->where('ret_spd_mstr_id', '=', $retspmstr->id)
                        ->sum('ret_spd_qty_transfer');


                    if ($sumqtyret != $sumqtytrf) {
                        DB::table('ret_sparepart')
                            ->where('ret_sp_number', '=', $req->hide_rsnum)
                            ->update([
                                'ret_sp_transfered_by' => $user->username,
                                'ret_sp_transfer_date' => Carbon::now('ASIA/JAKARTA')->format('Y-m-d'),
                                'ret_sp_status' => 'partial transferred',
                                'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                    } else {
                        DB::table('ret_sparepart')
                            ->where('ret_sp_number', '=', $req->hide_rsnum)
                            ->update([
                                'ret_sp_transfered_by' => $user->username,
                                'ret_sp_transfer_date' => Carbon::now('ASIA/JAKARTA')->format('Y-m-d'),
                                'ret_sp_status' => 'closed',
                                'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                    }
                }
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

            if (!empty($qdocFault)) {
                DB::rollBack();

                $qdocFault = (string) $xmlResp->xpath('//soapenv:faultstring')[0];

                alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $qdocFault . "", 'error')->persistent('Dismiss');
                return redirect()->back();
            }

            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



            if ($qdocResult == "success" or $qdocResult == "warning") {
                /* jika response sukses atau warning maka menyimpan data jika sudah di transferr ke qad*/
                $rsnumber = $req->hide_rsnum;
                //kirim notifikasi kepada para engineer yg mengerjakan wo tersebut bahwa spare part yg tidak cukup sudah ditransfer ke inventory supply
                // SendNotifWarehouseToUser::dispatch($rsnumber);
            } else {

                //jika qtend mengembalikan pesan error 

                DB::rollBack();
                $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                $outputerror = '';
                foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                    $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                    $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                    $outputerror .= "&bull;  " . $context . " - " . $desc . "<br>";
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

                alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $outputerror . "", 'error')->persistent('Dismiss');
                return redirect()->back();
                /* jika qxtend response error */
            }

            //kirim email ke engineer yg melakukan return sparepart
            SendNotifRetSpWarehousetoEng::dispatch($req->hide_rsnum);

            DB::commit();

            toast('Return Spare Part Warehouse for ' . $req->hide_rsnum . ' Successfuly !', 'success');
            return redirect()->route('retspwhsbrowse');
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
            toast('Confirm Failed', 'error');
            return redirect()->route('retspwhsbrowse');
        }
    }

    public function accutransfer(Request $req)
    {
        $databrowseaccu = DB::table('inv_required')
            ->select('ir_site', 'assite_desc', 'ir_spare_part', 'spm_desc', 'inv_qty_required')
            ->join('asset_site', 'asset_site.assite_code', 'inv_required.ir_site')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'ir_spare_part')
            ->get();

        $datasite = DB::table('asset_site')
            ->get();

        $datasp = DB::table('sp_mstr')
            ->get();

        return view('sparepart.accutrfsparepart', compact('databrowseaccu', 'datasite', 'datasp'));
    }

    public function searchaccutrf(Request $req)
    {
        // dd($req->all());

        $site = $req->site_search;
        $sparepart = $req->spsearch;

        $datalocsupply = DB::table('inp_supply')
            // ->where('inp_avail', '=', 'Yes')
            ->get();

        $data_assetsite = DB::table('asset_site')
            ->get();

        $data_sp = DB::table('sp_mstr')
            ->where('spm_active', '=', 'Yes')
            ->get();

        $datainvreq = DB::table('inv_required');

        if ($site) {
            $datainvreq->where('ir_site', '=', $site);
        }

        if ($sparepart) {
            $datainvreq->where('ir_spare_part', '=', $sparepart);
        }

        $datainvreq = $datainvreq->get();

        if ($datainvreq->isNotEmpty()) {
            $datatemp = [];
            foreach ($datainvreq as $dt) {
                $datainvsupp = DB::table('inp_supply')
                    ->where('inp_asset_site', '=', $dt->ir_site)
                    ->get();

                // dd($datainvsupp);

                foreach ($datainvsupp as $dtsupp) {

                    $qadsupplydata = (new WSAServices())->wsagetsupply($dt->ir_spare_part, $dtsupp->inp_supply_site, $dtsupp->inp_loc);

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
                            $t_qtyoh = (float) $resultWSA[0]->t_qtyoh;

                            array_push($datatemp, [
                                't_domain' => $t_domain,
                                't_siteasset' => $dt->ir_site,
                                't_part' => $t_part,
                                't_site' => $t_site,
                                't_loc' => $t_loc,
                                't_qtyoh' => $t_qtyoh,
                                't_qtyreq' => $dt->inv_qty_required
                            ]);
                        } else {

                            $wsa = ModelsQxwsa::first();
                            $domain = $wsa->wsas_domain;

                            array_push($datatemp, [
                                't_domain' => $domain,
                                't_siteasset' => $dt->ir_site,
                                't_part' => $dt->ir_spare_part,
                                't_site' => $dtsupp->inp_supply_site,
                                't_loc' => $dtsupp->inp_loc,
                                't_qtyoh' => 0,
                                't_qtyreq' => $dt->inv_qty_required
                            ]);
                        }
                    }
                }
            }

            // dd($datatemp);

            $grouped = collect($datatemp)->groupBy('t_siteasset')->toArray();

            // dd($grouped);

            foreach ($grouped as $siteasset => $group) {
                $output[$siteasset] = collect($group)->groupBy('t_part')->map(function ($items) {
                    return [
                        't_domain' => $items[0]['t_domain'],
                        't_siteasset' => $items[0]['t_siteasset'],
                        't_part' => $items[0]['t_part'],
                        't_qtyoh' => $items->sum('t_qtyoh'),
                        't_qtyreq' => $items[0]['t_qtyreq'],
                    ];
                })->toArray();
            }

            $collection = collect($output);
            // Metode flatten(1) digunakan untuk menggabungkan array kedalam satu tingkat. 
            //Kemudian, metode values() digunakan untuk mengindeks ulang array hasilnya.
            $flattenedData = $collection->flatten(1)->values();

            $output = $flattenedData->toArray();

            // dd($output);

            return view('sparepart.accutrfsparepart-detail', compact('output', 'datalocsupply', 'data_assetsite', 'data_sp'));
        } else {

            toast('Data Not Found', 'error');
            return redirect()->back();
        }
    }

    public function submitaccutrf(Request $req)
    {
        // dd($req->all());

        Schema::dropIfExists('temp_table');
        Schema::create('temp_table', function ($table) {
            $table->string('t_part');
            $table->string('t_site');
            $table->string('t_loc')->nullable();
            $table->string('t_lot')->nullable();
            $table->decimal('t_qtyoh', 10, 2);
            $table->temporary();
        });

        foreach ($req->hide_check as $key => $thischeck) {
            if ($thischeck != 'N') {

                $getActualStockSource = (new WSAServices())->wsacekstoksource($req->spcode_hidden[$key], $req->hidden_sitefrom[$key], $req->hidden_locfrom[$key], $req->hidden_lotfrom[$key]);

                if ($getActualStockSource === false) {
                    toast('WSA Connection Failed', 'error')->persistent('Dismiss');
                    return redirect()->back();
                } else {

                    // jika hasil WSA ke QAD tidak ditemukan
                    if ($getActualStockSource[1] == "false") {
                        toast('Something went wrong with the data', 'error')->persistent('Dismiss');
                        return redirect()->back();
                    }


                    // jika hasil WSA ditemukan di QAD, ambil dari QAD kemudian disimpan dalam array untuk nantinya dikelompokan lagi data QAD tersebut berdasarkan part dan site

                    $resultWSA = $getActualStockSource[0];

                    //kumpulkan hasilnya ke dalam 1 array sebagai penampung list location dan lot from
                    foreach ($resultWSA as $thisresult) {
                        DB::table('temp_table')
                            ->insert([
                                't_part' => $thisresult->t_part,
                                't_site' => $thisresult->t_site,
                                't_loc' => $thisresult->t_loc,
                                't_lot' => $thisresult->t_lot,
                                't_qtyoh' => $thisresult->t_qtyoh,
                            ]);
                    }
                }
            }
        }

        $dataStockQAD = DB::table('temp_table')
            ->get();

        Schema::dropIfExists('temp_table');

        DB::beginTransaction();

        try {

            $notEnough = "";
            foreach ($req->qtytotransfer as $index => $qtytotransfer) {
                foreach ($dataStockQAD as $source) {
                    if ($req->spcode_hidden[$index] == $source->t_part && $req->hidden_sitefrom[$index] == $source->t_site && $req->hidden_locfrom[$index] == $source->t_loc && $req->hidden_lotfrom[$index] == $source->t_lot) {
                        if (floatval($req->qtytotransfer[$index]) > floatval($source->t_qtyoh)) {
                            //jika tidak cukup berikan alert
                            // dump($source->t_qtyoh);
                            $notEnough .= $req->hidden_spcode[$index] . ", ";
                        }
                    }
                }
            }

            if ($notEnough != "") {
                $notEnough = rtrim($notEnough, ", "); // hapus koma terakhir
                alert()->html('<u><b>Alert!</b></u>', "<b>The qty to be transferred does not have sufficient stock for the following spare part code :</b><br>" . $notEnough . "", 'error')->persistent('Dismiss');
                return redirect()->back();
            }


            /* Qxtend Transfer Single Item */
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
                <wsa:To>urn:services-qad-com:' . $qxRcv . '</wsa:To>
                <wsa:MessageID>urn:services-qad-com::' . $qxRcv . '</wsa:MessageID>
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
                    <qcom:propertyValue>' . $domain . '</qcom:propertyValue>
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
                    <qcom:propertyValue/>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>password</qcom:propertyName>
                    <qcom:propertyValue/>
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

            foreach ($req->qtytotransfer as $index => $qtyfromweb) {
                if ($qtyfromweb > 0) { //jika qty to transfer yang diisi user dari menu wo transfer lebih dari 0, baru lakukan qxtend transfer single item
                    $qdocBody .= '<item>
                            <part>' . $req->spcode_hidden[$index] . '</part>
                            <itemDetail>
                                <lotserialQty>' . $qtyfromweb . '</lotserialQty>
                                <siteFrom>' . $req->hidden_sitefrom[$index] . '</siteFrom>
                                <locFrom>' . $req->hidden_locfrom[$index] . '</locFrom>
                                <lotserFrom>' . $req->hidden_lotfrom[$index] . '</lotserFrom>
                                <siteTo>' . $req->hidden_siteto[$index] . '</siteTo>
                                <locTo>' . $req->hidden_locto[$index] . '</locTo>
                            </itemDetail>
                        </item>';


                    DB::table('accum_hist')
                        ->insert([
                            'accum_asset_site' => $req->siteasset_hidden[$index],
                            'accum_sparepart' => $req->spcode_hidden[$index],
                            'accum_sitefrom' => $req->hidden_sitefrom[$index],
                            'accum_locfrom' => $req->hidden_locfrom[$index],
                            'accum_lotfrom' => $req->hidden_lotfrom[$index],
                            'accum_locto' => $req->hidden_locto[$index],
                            'accum_siteto' => $req->hidden_siteto[$index],
                            'accum_qtytransfer' => $qtyfromweb,
                            'accum_transferredby' => Session::get('username'),
                        ]);
                }
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

            if (!empty($qdocFault)) {
                DB::rollBack();

                $qdocFault = (string) $xmlResp->xpath('//soapenv:faultstring')[0];

                alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $qdocFault . "", 'error')->persistent('Dismiss');
                return redirect()->back();
            }

            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



            if ($qdocResult == "success" or $qdocResult == "warning") {
                /* jika response sukses atau warning maka menyimpan data jika sudah di transferr ke qad*/
                $wonumber = $req->hide_wonum;
            } else {

                //jika qtend mengembalikan pesan error 

                DB::rollBack();
                $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                $outputerror = '';
                foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                    $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                    $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                    $outputerror .= "&bull;  " . $context . " - " . $desc . "<br>";
                }

                alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $outputerror . "", 'error')->persistent('Dismiss');
                return redirect()->back();
                /* jika qxtend response error */
            }

            DB::commit();

            toast('Accumulative Transfer Successfuly !', 'success');
            return redirect()->route('accuTransBrw');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Transfer failed', 'error');
            return redirect()->back();
        }
    }

    //Spare Part Stock Browse
    public function spstockbrowse()
    {
        $wsa = (new WSAServices())->wsainvstock(Session::get('domain'));
        if ($wsa === false) {
            alert()->error('Error', 'WSA Failed');
            return redirect()->back();
        } else {
            $tempStockItem = (new CreateTempTable())->invstockDetail($wsa[0]);
        }

        $data = $tempStockItem[0];

        // dd($data);

        return view('report.spstock', compact('data'));
    }
}
