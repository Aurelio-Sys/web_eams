<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotifReqSparepart;
use App\Jobs\SendNotifReqSparepartApproval;
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
use App\WOMaster;
use Illuminate\Support\Facades\Session;

class SparepartController extends Controller
{
    public function reqspbrowse(Request $request)
    {
        $data = DB::table('req_sparepart')
            ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
            ->join('users', 'users.username', 'req_sparepart.req_sp_requested_by')
            ->groupBy('req_sp_number')
            ->orderBy('req_sp_due_date', 'ASC');

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
            $data->where('req_sp_number', 'like', '%' . $request->s_nomorrs . '%');
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

        //nomor wo akan di filter berdasarkan departmen user yang login harus sama dengan departmen wo, kecuali admin dapat mengakses semua nomor wo
        $womstr = WOMaster::where('wo_status', '<>', 'closed')
            ->where('wo_status', '<>', 'finished')
            ->where('wo_status', '<>', 'acceptance')
            ->where('wo_status', '<>', 'canceled')
            ->when(Session::get('role') <> 'ADMIN', function ($q) {
                return $q->where('wo_department', Session::get('department'));
            })
            ->get();

        // dd($womstr);

        return view('sparepart.reqsparepart-detail', compact('data', 'wo_sp', 'sp_all', 'loc_to', 'womstr'));
    }

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
                        'req_sp_wonumber' => $requestData['wonbr'],
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

                    //simpan list spare part yang di released ke table wo_det
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
                            'req_sph_wonumber' => $requestData['wonbr'],
                            'req_sph_dept' => $user->dept_user,
                            'req_sph_reqby' => $user->username,
                            'req_sph_spcode' => $loopsp['spreq'],
                            'req_sph_qtyreq' => $loopsp['qtyrequest'],
                            'req_sph_locto' => $loopsp['locto'],
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

                    //send notifikasi ke approver pertama
                    SendNotifReqSparepartApproval::dispatch($runningnbr, $requestData['wonbr'], $getFirstApprover->sp_approver_role, Session::get('department'));

                    //get wo dan sr mstr
                    $womstr = DB::table('wo_mstr')->where('wo_number', $requestData['wonbr'])->first();
                    $rsmstr = DB::table('req_sparepart')->where('req_sp_number', $runningnbr)->first();

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
                                        'rqtr_wo_number' => $womstr->wo_number,
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
                                        'rqtrh_wo_number' => $womstr->wo_number,
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
                                        'rqtr_wo_number' => $womstr->wo_number,
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
                                        'rqtrh_wo_number' => $womstr->wo_number,
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
                }

                //kirim email ke warehouse
                // SendNotifReqSparepart::dispatch($runningnbr);

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
            toast('WO Release Failed', 'error');
            return redirect()->route('reqspbrowse');
        }
    }

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
                $output .= '<td><input type="hidden" name="te_locto[]" readonly>' . $data->req_spd_loc_to . '</td>';
                $output .= '<td><input type="hidden" name="te_reqnote[]" readonly>' . $data->req_spd_reqnote . '</td>';
                $output .= '</td>';
                $output .= '</tr>';
            }

            // dd($output);

            return response($output);
        }
    }

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
                $output .= '<label class="col-form-label" style="color:green;">this wo release has been approved by ' . $approver->username . '</label>';
            } elseif ($approver->rqtr_status == 'revision') {
                $output .= '<label class="col-form-label" style="color:red;">this wo release has been rejected by ' . $approver->username . '</label>';
            } else {
                $output .= '<label class="col-form-label" style="color:navy;">please wait the previous approver to do approval</label>';
            }
            // dd($output);

            return response($output);
        }
    }

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

    public function reqspupdate(Request $req)
    {
        $newData = $req->all();

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
                                'req_sph_locto' => $data['locto'],
                                'req_sph_action' => 'sparepart updated',
                                'created_at' => Carbon::now()->toDateTimeString(),
                            ]);
                    } else {
                        DB::table('req_sparepart_hist')
                            ->insert([
                                'req_sph_number' => $req->e_rsnumber,
                                'req_sph_spcode' => $data['spreq'],
                                'req_sph_qtyreq' => $data['qtyrequest'],
                                'req_sph_locto' => $data['locto'],
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
                            'req_sph_locto' => $data['locto'],
                            'req_sph_action' => 'sparepart deleted',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }
            }
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

    public function reqspapprovalbrowse(Request $request)
    {
        if (strpos(Session::get('menu_access'), 'BO06') !== false) {
            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                ->where('username', '=', session()->get('username'))
                ->first();
            // dd($usernow);

            $data = ReqSPMstr::query()
                ->with(['getCurrentApprover'])
                ->whereHas('getReqSPTransAppr', function ($q) {
                    $q->where('rqtr_status', '=', 'waiting for approval');
                    $q->orWhere('rqtr_status', '=', 'approved');
                    $q->orWhere('rqtr_status', '=', 'rejected');
                });

            $data = $data
                ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
                ->Join('users', 'req_sparepart.req_sp_requested_by', 'users.username')
                ->selectRaw('req_sparepart.*, sp_mstr.*, users.username')
                ->groupBy('req_sp_number')
                ->orderBy('req_sp_due_date', 'ASC');

            if (Session::get('role') <> 'ADMIN') {
                $data = $data->join('reqsp_trans_approval', function ($join) {
                    $join->on('req_sparepart.id', '=', 'reqsp_trans_approval.rqtr_mstr_id')
                        // ->where('rqtr_dept_approval', '=', Session::get('department'))
                        ->where('rqtr_role_approval', '=', Session::get('role'));
                    // ->where('req_sp_dept', Session::get('department'));
                });
            } else {
                $data = $data->join('reqsp_trans_approval', 'reqsp_trans_approval.rqtr_mstr_id', 'req_sparepart.id');
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
                $data->where('req_sp_number', 'like', '%' . $request->s_nomorrs . '%');
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

            return view('sparepart.reqsparepartappr-browse', ['data' => $data, 'sp_all' => $sp_all, 'loc_to' => $loc_to, 'requestby' => $requestby,]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    public function reqspapproval(Request $req)
    {
        $rsnbr = $req->e_rsnumber;
        $reason = $req->v_reason;

        // dd($req->all());

        $user = Auth::user();

        $idrs = ReqSPMstr::where('req_sp_number', $rsnbr)->first();

        //ambil data Req SP
        $reqspmstr = DB::table('req_sparepart')
            ->where('req_sp_number', $rsnbr)
            ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
            ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
            ->Join('users', 'req_sparepart.req_sp_requested_by', 'users.username')
            ->first();

        $srmstr = DB::table('service_req_mstr')->where('wo_number', $reqspmstr->req_sp_wonumber)->first();

        $asset = $reqspmstr->asset_code . ' -- ' . $reqspmstr->asset_desc;
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
            // 'rqtrh_sequence'         => $woapprover->rqtr_sequence,
            'rqtrh_approved_by'      => $user->id,
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

            $srnumber = $reqspmstr->req_sp_wonumber ? $reqspmstr->req_sp_wonumber : $reqspmstr->req_sp_number;
            $requestor = $reqspmstr->wo_releasedby;

            if ($countwoapprover != 0) {
                //jika next approver null
                if (is_null($nextapprover)) {
                    // dd(1);
                    //cek apakah approver admin atau bukan
                    if (Session::get('role') <> 'ADMIN') {
                        //jika user bukan admin, hanya tingkatan yang rolenya sama yang akan menjadi approved
                        DB::table('reqsp_trans_approval')
                            ->where('rqtr_mstr_id', '=', $idrs)
                            ->where('rqtr_role_approval', '=', $user->role_user)
                            ->update($rqtransapproved);

                        DB::table('release_trans_approval_hist')
                            ->insert($rqtransapprovedhist);
                    } else {
                        //jika user adalah admin, maka semua approval (approval bertingkat) akan menjadi approved
                        DB::table('reqsp_trans_approval')
                            ->where('rqtr_mstr_id', '=', $idrs)
                            ->update($rqtransapproved);

                        DB::table('release_trans_approval_hist')
                            ->insert($rqtransapprovedhist);
                    }
                    //email terikirm ke engineer yg melakukan released
                    // EmailScheduleJobs::dispatch('', $asset, '16', '', $requestor, $srnumber, '');
                } else {
                    // dd(2);
                    //jika next approval not null

                    $tampungarray = $nextapprover;
                    // $requestor = $reqspmstr->sr_req_by;

                    //cek apakah approver admin atau bukan
                    if (Session::get('role') <> 'ADMIN') {
                        //jika user bukan admin, hanya tingkatan yang rolenya sama yang akan menjadi approved
                        DB::table('reqsp_trans_approval')
                            ->where('rqtr_mstr_id', '=', $idrs)
                            ->where('rqtr_role_approval', '=', $user->role_user)
                            ->update($rqtransapproved);

                        DB::table('release_trans_approval_hist')
                            ->insert($rqtransapprovedhist);

                        //email terikirm ke approver selanjutnya
                        // EmailScheduleJobs::dispatch('', $asset, '15', $tampungarray, '', $srnumber, $roleapprover);
                    } else {
                        // dd(2);
                        //jika user adalah admin, maka semua approval (approval bertingkat) akan menjadi approved
                        DB::table('reqsp_trans_approval')
                            ->where('rqtr_mstr_id', '=', $idrs)
                            ->update($rqtransapproved);

                        DB::table('release_trans_approval_hist')
                            ->insert($rqtransapprovedhist);

                        //email terikirm ke engineer yg melakukan released
                        // EmailScheduleJobs::dispatch('', $asset, '16', '', $requestor, $srnumber, '');
                    }
                }
            }
            // else {
            //     if ($reqspmstr->req_sp_wonumber == "") {
            //         //jika wo tidak memiliki sr number 
            //         DB::table('wo_mstr')
            //             ->where('id', '=', $idrs)
            //             ->update([
            //                 'wo_status' => 'closed',
            //                 'wo_system_update' => Carbon::now()->toDateTimeString(),
            //             ]);

            //         DB::table('wo_trans_history')
            //             ->insert([
            //                 'wo_number' => $reqspmstr->wo_number,
            //                 'wo_action' => 'closed',
            //                 'system_update' => Carbon::now()->toDateTimeString(),
            //             ]);
            //     } else {
            //         //jika wo memiliki sr number akan kembali ke user acceptance dan wo di close oleh user
            //         DB::table('wo_mstr')
            //             ->where('id', '=', $idrs)
            //             ->update([
            //                 'wo_status' => 'acceptance',
            //                 'wo_system_update' => Carbon::now()->toDateTimeString(),
            //             ]);

            //         DB::table('wo_trans_history')
            //             ->insert([
            //                 'wo_number' => $reqspmstr->wo_number,
            //                 'wo_action' => 'acceptance',
            //                 'system_update' => Carbon::now()->toDateTimeString(),
            //             ]);

            //         DB::table('service_req_mstr')
            //             ->where('sr_number', '=', $reqspmstr->req_sp_wonumber)
            //             ->update($srupdate);

            //         DB::table('service_req_mstr_hist')
            //             ->insert($srupdatehist);

            //         //email terikirm ke user yang membuat SR
            //         // EmailScheduleJobs::dispatch('', $asset, '12', '', $requestor, $srnumber, '');
            //     }
            // }

            DB::commit();
            toast('Request Sparepart ' . $reqspmstr->req_sp_number . ' approved successfuly', 'success');
            return redirect()->route('approvalBrowseSP');
        }
        else {
            //REJECT
            $requestor = $reqspmstr->wo_list_engineer;
            if (is_null($nextapprover)) {
                //kondisi hanya 1 approver atau approver terakhir

                //jika user bukan admin dan hanya 1 approver
                if (is_null($prevapprover) && Session::get('role') <> 'ADMIN') {
                    // dd('1 approver');
                    DB::table('reqsp_trans_approval')
                        ->where('rqtr_mstr_id', '=', $idrs)
                        ->where('rqtr_role_approval', '=', $user->role_user)
                        ->update($rqtransreject);

                    DB::table('release_trans_approval_hist')
                        ->insert($rqtransrejecthist);
                } else {
                    // dd('approver terakhir');
                    DB::table('reqsp_trans_approval')
                        ->where('rqtr_mstr_id', '=', $idrs)
                        // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
                        ->update($rqtransreject);

                    DB::table('release_trans_approval_hist')
                        ->insert($rqtransrejecthist);
                }
            } else {
                //kondisi approver pertama atau approver tengah
                DB::table('reqsp_trans_approval')
                    ->where('rqtr_mstr_id', '=', $idrs)
                    // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
                    ->update($rqtransreject);

                DB::table('release_trans_approval_hist')
                    ->insert($rqtransrejecthist);
            }

            //email terkirim ke wo list engineer
            // EmailScheduleJobs::dispatch('', $asset, '11', '', $requestor, $srnumber, '');

            // DB::commit();
            toast('Request Sparepart' . $reqspmstr->req_sp_number . ' has been rejected', 'success');
            return redirect()->route('approvalBrowseSP');
        }
    }

    public function trfspbrowse(Request $request)
    {
        if (Session::get('role') == 'ADMIN' || Session::get('role') == 'WHS') {
            $data = DB::table('req_sparepart')
                ->leftJoin('req_sparepart_det', 'req_sparepart_det.req_spd_mstr_id', 'req_sparepart.id')
                ->join('sp_mstr', 'sp_mstr.spm_code', 'req_sparepart_det.req_spd_sparepart_code')
                ->where('req_sp_status', '!=', 'canceled')
                ->groupBy('req_sp_number')
                ->orderBy('req_sp_due_date', 'ASC');

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
            $data->where('req_sp_number', 'like', '%' . $request->s_nomorrs . '%');
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

        // dd($data);
        return view('sparepart.trfsparepart-detail', compact(
            'data',
            'sparepart_detail',
            'datalocsupply',
        ));
    }

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
                // ->groupBy('req_sp_number')
                ->get();
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
                $output .= '</td>';
                $output .= '</tr>';
            }

            // dd($output);

            return response($output);
        }
    }

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

        $dataStockQAD = DB::table('temp_table')
            ->get();


        Schema::dropIfExists('temp_table');

        DB::beginTransaction();

        try {

            $notEnough = "";
            foreach ($req->qtytotransfer as $index => $qtytotransfer) {
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

                    $user = Auth::user();

                    DB::table('req_sparepart')
                        ->where('req_sp_number', '=', $req->hide_rsnum)
                        ->update([
                            'req_sp_transfered_by' => $user->username,
                            'req_sp_transfer_date' => Carbon::now('ASIA/JAKARTA')->format('Y-m-d'),
                            'req_sp_status' => 'closed',
                            'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
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
            ->where('inp_avail', '=', 'Yes')
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
}
