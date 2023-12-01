<?php

/*
Daftar perubahan :

A210927 : status approval user acceptance, jika reject statusnya incomplete, jadi dibedakan status close dan reject. kode status reject = 6
A211014 : status setelah Reviewer approve, jika sebelumnya finish diganti jadi 7 complete biar status nya sama kaya WO 
B211014 : join dengan tabel user diganti where, dari name - req_by diganti jadi username = sr_req_by
C211014 : menyimpan tanggal user acceptance
A211019 : yang ditampilkan di User Acceptance adalah SR yang statusnya Complete pada saat WO Reviewer dan SR yang statusnya Incomplete oleh User, sehingga user bisa melakukan User Acceptance ulang jika pekerjaan telah selesai 

*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\User;
use Carbon\Carbon;
use Svg\Tag\Rect;
use App\Jobs\Emaill;
use App\Jobs\EmailScheduleJobs;
use Carbon\CarbonPeriod;
use File;
use Response;

use App;
use App\Exports\ExportSR;
use App\Exports\ExportSRBrowse;
use App\ServiceReqMaster;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class ServiceController extends Controller
{

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

    public function assetbyloc (Request $req){
        
        //Filter asset by location
        if ($req->ajax()) {
            $asset_loc = $req->assetloc;
            $asset = DB::table('asset_mstr')
            ->leftJoin('asset_loc', 'asloc_code', '=', 'asset_loc')
            ->where('asset_active', '=', 'Yes')
            ->where('asset_loc', '=', $asset_loc)
            ->orderBy('asset_code')
            ->get();
// dd($asset);
            $outputcode = "";
            foreach ($asset as $thiscode) {
                $outputcode .= '<option value="' . $thiscode->asset_code . '" data-assetgroup="' . $thiscode->asset_group . '"> ' . $thiscode->asset_code . ' -- ' . $thiscode->asset_desc . ' -- ' . $thiscode->asloc_desc . '</option>';
            }

            return response()->json([
                // 'optionfailtype' => $outputtype,
                'optionassetcode' => $outputcode,
            ]);
        }
    }


    public function servicerequest(Request $req) /* route : servicerequest  blade : servicerequest_create */
    {
        /* Jika admin, data asset akan muncul semua, jika bukan akan muncul asset sesuai dengan departemen. kode lokasi = kode depatemen */
        if (Session::get('role') == 'ADMIN') {
            $asset = DB::table('asset_mstr')
                ->leftJoin('asset_loc', 'asloc_code', '=', 'asset_loc')
                ->where('asset_active', '=', 'Yes')
                ->orderBy('asset_code')
                ->get();
        } else {
            $asset = DB::table('asset_mstr')
                ->leftJoin('asset_loc', 'asloc_code', '=', 'asset_loc')
                ->where('asset_active', '=', 'Yes')
                // ->where('asset_loc', '=', session::get('department'))
                ->orderBy('asset_code')
                ->get();
        }

        $datadepart = DB::table('dept_mstr')
            ->get();

        $impact = DB::table('imp_mstr')
            ->orderBy('imp_code')
            ->get();

        $wotype = DB::table('wotyp_mstr')
            ->get();

        $dataapp = DB::table('eng_mstr')
            ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'eng_mstr.eng_dept')
            ->selectRaw('dept_mstr.*,eng_mstr.*')
            ->where('eng_active', '=', 'Yes')
            ->where('approver', '=', 1)
            ->groupBy('eng_dept')
            ->orderBy('eng_code')
            ->get();   
            
        $assetloc = DB::table('asset_loc')->get();

        // Default Value Failure Type dan Code
        if ($req->ajax()) {
            $assetgroup = $req->get('group');
            $failtype = $req->get('type');

            $asfn_det = DB::table('asfn_det')
                ->where('asfn_asset', '=', $assetgroup)
                ->count();

            if ($asfn_det > 0) {
                //jika ada failure type dan code yang sudah didaftarkan di menu Mapping Asset - Failure Maintenance
                // $wotype = DB::table('wotyp_mstr')
                //     ->leftJoin('asfn_det', 'asfn_det.asfn_fntype', 'wotyp_mstr.wotyp_code')
                //     ->where('asfn_asset', '=', $assetgroup)
                //     ->groupBy('asfn_asset', 'asfn_fntype')
                //     ->get();

                $fcode = DB::table('fn_mstr')
                    ->leftJoin('asfn_det', 'asfn_det.asfn_fncode', 'fn_mstr.fn_code')
                    ->where('asfn_asset', '=', $assetgroup)
                    ->where('asfn_fntype', '=', $failtype)
                    ->groupBy('asfn_fncode')
                    ->get();
            } else {
                //jika tidak ada
                // $wotype = DB::table('wotyp_mstr')
                //     ->get();

                $fcode = DB::table('fn_mstr')
                    ->get();
            }

            $outputtype = "";
            // $outputtype .= '<option value="">test</option>';
            // foreach ($wotype as $thistype) {
            //     $outputtype .= '<option value="' . $thistype->wotyp_code . '"> ' . $thistype->wotyp_code . ' -- ' . $thistype->wotyp_desc . '</option>';
            // }

            $outputcode = "";
            foreach ($fcode as $thiscode) {
                $outputcode .= '<option value="' . $thiscode->fn_code . '"> ' . $thiscode->fn_code . ' -- ' . $thiscode->fn_desc . '</option>';
            }

            return response()->json([
                // 'optionfailtype' => $outputtype,
                'optionfailcode' => $outputcode,
            ]);
        }


        return view('service.servicerequest_create', [
            'showasset' => $asset, 'dept' => $datadepart,  'wotype' => $wotype,
            'impact' => $impact, 'dataapp' => $dataapp, 'assetloc'=> $assetloc
        ]);
    }

    public function srcheckfailurecodetype(Request $req)
    {
        $assetgroup = $req->group;
        $getType = $req->type;

        $asfn_det = DB::table('asfn_det')
            ->where('asfn_asset', '=', $assetgroup)
            ->where('asfn_fntype', '=', $getType)
            ->count();

        if ($asfn_det > 0) {
            //jika ada
            // $fntype = DB::table('wotyp_mstr')
            //     ->leftJoin('asfn_det','asfn_det.asfn_fntype','wotyp_mstr.wotyp_code')
            //     ->where('asfn_asset','=', $assetgroup)
            //     ->groupBy('asfn_asset','asfn_fntype')
            //     ->get();

            $failure = DB::table('fn_mstr')
                ->leftJoin('asfn_det', 'asfn_det.asfn_fncode', 'fn_mstr.fn_code')
                ->where('asfn_asset', '=', $assetgroup)
                ->where('asfn_fntype', '=', $getType)
                ->groupBy('asfn_fncode')
                ->get();
        } else {
            //jika tidak ada
            // $fntype = DB::table('wotyp_mstr')
            //     ->get();

            $failure = DB::table('fn_mstr')
                ->get();
        }


        // $outputtype = "";
        // foreach($fntype as $thistype ){
        //     $outputtype .= '<option value="'.$thistype->wotyp_code.'"> '.$thistype->wotyp_code.' -- '.$thistype->wotyp_desc.'</option>';
        // }

        $outputcode = [];
        foreach ($failure as $thiscode) {

            $failurecode = array('fn_code' => $thiscode->fn_code, 'fn_desc' => $thiscode->fn_desc);

            array_push($outputcode, $failurecode);
        }

        return response()->json([
            // 'optionfailtype' => $outputtype,
            'optionfailcode' => $outputcode,
        ]);
    }

    public function failuresearch(Request $req)
    {
        // dd($req->all());
        if ($req->ajax()) {
            $asset2 = DB::table('asset_mstr')
                ->where('asset_mstr.asset_code', '=', $req->asset)
                ->first();

            // dd($asset2);


            $failure = DB::table('fn_mstr')
                // ->join('asset_mstr', 'fn_mstr.fn_assetgroup', 'asset_mstr.asset_group')
                ->where(function ($query) use ($asset2) {
                    $query->where('fn_mstr.fn_assetgroup', '=', $asset2->asset_group)
                        ->orWhere('fn_mstr.fn_assetgroup', '=', null);
                })
                ->get();
            // dd($failure);

            $output = '';
            if (count($failure) > 0) {
                $output .= '<option value=""> Pilih Failure Code </option>';
                foreach ($failure as $data) {
                    $output .= '<option value="' . $data->fn_code . '">' . $data->fn_code . ' - ' . $data->fn_desc . '</option>';
                }
            } else {
                $output .= '<option value=""> Tidak Ada Failure Code </option>';
            }

            return response($output);
        }
    }

    public function inputsr(Request $req) /* blade : servicerequest_create.php */
    {
        // dd($req->all());
        DB::beginTransaction();
        try {

            $user = FacadesAuth::user();
            //impact
            if (isset($req->impact)) {
                $counterimpact = count($req->impact);
            } else {
                $counterimpact = 0;
            }

            $newimpact = "";
            //  dd($newimpact);
            for ($i = 0; $i < $counterimpact; $i++) {
                $newimpact .= $req->impact[$i] . ',';
            }
            $newimpact = substr($newimpact, 0, strlen($newimpact) - 1);

            if ($newimpact == false) {
                $newimpact = "";
            }
            // dd($newimpact);

            //failure code
            if (isset($req->failurecode)) {
                $counterfailcode = count($req->failurecode);
            } else {
                $counterfailcode = 0;
            }

            $newfailcode = "";
            for ($i = 0; $i < $counterfailcode; $i++) {
                $newfailcode .= $req->failurecode[$i] . ',';
            }
            $newfailcode = substr($newfailcode, 0, strlen($newfailcode) - 1);

            if ($newfailcode == false) {
                $newfailcode = "";
            }

            $running = DB::table('running_mstr')
                ->first();

            $runnumber = DB::table('dept_mstr')
                ->where('dept_code', '=', session::get('department'))
                ->first();

            // dd($runnumber);

            $newyear = Carbon::now()->format('y');

            if ($runnumber->dept_running_nbr == null) {
                DB::rollBack();
                toast('Please set running number for department code ' . session::get('department') . ' first.', 'error');
                return back();
            }

            if ($running->year == $newyear) {
                $tempnewrunnbr = strval(intval($runnumber->dept_running_nbr) + 1);

                $newtemprunnbr = '';
                if (strlen($tempnewrunnbr) < 6) {
                    $newtemprunnbr = str_pad($tempnewrunnbr, 4, '0', STR_PAD_LEFT);
                }
            } else {
                $newtemprunnbr = '0001';
            }

            $runningnbr = $running->sr_prefix . '-' . session::get('department') . '-' . $newyear . '-' . $newtemprunnbr;

            // dump($runningnbr);

            $cekData = DB::table('service_req_mstr')
                ->where('sr_number', '=', $runningnbr)
                ->get();

            /* Notif erro jika ada nomor SR yang sama di database */
            if ($cekData->count() > 0) {
                DB::rollBack();
                toast('SR Number is already in use!!', 'error');
                return back();
            }

            if ($cekData->count() == 0) {

                if ($req->hasFile('filename')) {
                    // dd($req->hasFile('filename'));

                    foreach ($req->file('filename') as $upload) {
                        $dataTime = date('Ymd_His');
                        $filename = $dataTime . '-' . $upload->getClientOriginalName();

                        // Simpan File Upload pada Public
                        $savepath = public_path('uploadasset/');
                        $filepath = 'uploadasset/';
                        $upload->move($savepath, $filename);

                        // Simpan ke DB Upload
                        DB::table('service_req_upload')
                            ->insert([
                                'filepath' => $filepath . $filename,
                                'sr_number' => $runningnbr,
                                'created_at' => Carbon::now()->toDateTimeString(),
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);
                    }
                }
            }


            DB::table('service_req_mstr')
                ->insert([
                    'sr_number' => $runningnbr,
                    'sr_dept' => Session::get('department'),
                    'sr_asset' => $req->assetcode,
                    'sr_eng_approver' => $req->t_app,
                    'sr_note' => $req->notesr,
                    'sr_status' => 'Open',
                    'sr_status_approval' => 'Waiting For Approval',
                    'sr_req_by' => Session::get('username'),
                    'sr_req_date' => $req->t_date,
                    'sr_req_time' => $req->t_time,
                    'sr_fail_type' => $req->wotype,
                    'sr_fail_code' => $newfailcode,
                    'sr_impact' => $newimpact,
                    'sr_priority' => $req->priority,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    // 'sr_access' => 0,
                    // 'req_by' => Session::get('name'),
                ]);

            DB::table('service_req_mstr_hist')
                ->insert([
                    'sr_number' => $runningnbr,
                    'sr_dept' => Session::get('department'),
                    'sr_asset' => $req->assetcode,
                    'sr_eng_approver' => $req->t_app,
                    'sr_note' => $req->notesr,
                    'sr_status' => 'Open',
                    'sr_status_approval' => 'Waiting For Approval',
                    'sr_req_by' => Session::get('username'),
                    'sr_req_date' => $req->t_date,
                    'sr_req_time' => $req->t_time,
                    'sr_fail_type' => $req->wotype,
                    'sr_fail_code' => $newfailcode,
                    'sr_impact' => $newimpact,
                    'sr_priority' => $req->priority,
                    'sr_action' => 'SR Created',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    // 'sr_access' => 0,
                    // 'req_by' => Session::get('name'),
                ]);

            DB::table('running_mstr')
                ->update([
                    'year' => $newyear,
                ]);

            DB::table('dept_mstr')
                ->where('dept_code', '=', session::get('department'))
                ->update([
                    'dept_running_nbr' => $newtemprunnbr,
                ]);

            //cek sr yg baru di input
            $srmstr = DB::table('service_req_mstr')->orderBy('id', 'DESC')->first();

            //cek departemen approval
            $srdeptapprover = DB::table('sr_approver_mstr')->where('sr_approver_dept', $srmstr->sr_dept)->get();

            //cek engineer approval
            $engdeptapprover = DB::table('eng_mstr')->where('eng_dept', $srmstr->sr_eng_approver)->first();
            // dd($engdeptapprover);

            //cek tingkatan approval
            if (count($srdeptapprover) < 1) {
                //input ke trans approval eng jika tidak ada approval department
                DB::table('sr_trans_approval_eng')
                    ->insert([
                        'srta_eng_mstr_id' => $srmstr->id,
                        'srta_eng_dept_approval' => $srmstr->sr_eng_approver,
                        'srta_eng_role_approval' => 'SPVSR',
                        'srta_eng_status' => 'Waiting for engineer approval',
                        'created_at' => Carbon::now()->toDateTimeString(),
                    ]);

                //input ke trans approval eng hist jika tidak ada approval department
                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $srmstr->sr_eng_approver,
                        'srtah_eng_role_approval' => 'SPVSR',
                        'srtah_eng_status' => 'Waiting for engineer approval',
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
            } else {
                for ($i = 0; $i < count($srdeptapprover); $i++) {
                    $nextdeptapprover = $srdeptapprover[$i]->sr_approver_dept;
                    $nextroleapprover = $srdeptapprover[$i]->sr_approver_role;
                    $nextseqapprover = $srdeptapprover[$i]->sr_approver_order;

                    //input ke trans approval jika ada approval department
                    DB::table('sr_trans_approval')
                        ->insert([
                            'srta_mstr_id' => $srmstr->id,
                            'srta_dept_approval' => $nextdeptapprover,
                            'srta_role_approval' => $nextroleapprover,
                            'srta_sequence' => $nextseqapprover,
                            'srta_status' => 'Waiting for department approval',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    //input ke trans approval hist jika ada approval department
                    DB::table('sr_trans_approval_hist')
                        ->insert([
                            'srtah_sr_number' => $srmstr->sr_number,
                            'srtah_dept_approval' => $nextdeptapprover,
                            'srtah_role_approval' => $nextroleapprover,
                            'srtah_sequence' => $nextseqapprover,
                            'srtah_status' => 'Waiting for department approval',
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }

                // //input ke trans approval eng
                // DB::table('sr_trans_approval_eng')
                //     ->insert([
                //         'srta_eng_mstr_id' => $srmstr->id,
                //         'srta_eng_dept_approval' => $engdeptapprover->eng_dept,
                //         'srta_eng_status' => 'Waiting for engineer approval',
                //         'created_at' => Carbon::now()->toDateTimeString(),
                //     ]);

                // //input ke trans approval eng hist
                // DB::table('sr_trans_approval_eng_hist')
                //     ->insert([
                //         'srtah_eng_sr_number' => $srmstr->sr_number,
                //         'srtah_eng_dept_approval' => $engdeptapprover->eng_dept,
                //         'srtah_eng_status' => 'Waiting for engineer approval',
                //         'created_at' => Carbon::now()->toDateTimeString(),
                //         'updated_at' => Carbon::now()->toDateTimeString(),
                //     ]);
            }

            DB::commit();
            // nanti dibuka, masih error 
            // $email = EmailScheduleJobs::dispatch('','','3','','',$runningnbr,'');
            EmailScheduleJobs::dispatch('', '', '3', '', '', $runningnbr, '');
            // dd($email);

            toast('Service Request ' . $runningnbr . ' Successfully Created', 'success');
            return back();
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
            toast('Service Request Failed Created', 'error');
            return back();
        }
    }

    public function srapproval(Request $req) /* blade : service.servicereq-approval */
    {
        $user = FacadesAuth::user();

        //cek departemen approval
        $srdeptapprover = DB::table('sr_approver_mstr')->where('sr_approver_dept', $user->dept_user)->get();
        // dd($srdeptapprover);

        if (count($srdeptapprover) == 0) {
            //jika department tidak memiliki approval department
            return view('service.accessdenied');
        } else {
            //jika department memiliki approval department
            $data = ServiceReqMaster::query()
                ->with(['getCurrentApprover'])
                ->where('sr_status', '<>', 'Canceled')
                ->where('sr_status', '<>', 'Inprocess')
                ->whereHas('getSRTransAppr', function ($q) {
                    $q->with(['getDeptApprover', 'getRoleApprover'])
                        ->where('srta_status', '=', 'Waiting for department approval')
                        ->orWhere('srta_status', '=', 'Approved')
                        ->orWhere('srta_status', '=', 'Revision');
                });
            $data = $data
                ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                ->leftJoin('users', 'users.username', 'service_req_mstr.sr_req_by')
                ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                ->selectRaw('service_req_mstr.*, asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, users.name, dept_mstr.dept_desc, srta_reason')
                ->orderBy('sr_number', 'DESC')
                ->groupBy('sr_number');

            /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
            if (Session::get('role') <> 'ADMIN') {
                $data = $data->where('srta_role_approval', $user->role_user);
            }

            $data = $data->paginate(10);
            // dd($data);
            $datarepair = DB::table('rep_master')
                ->orderBy('repm_code')
                ->get();

            $datasset = DB::table('asset_mstr')
                ->get();

            $datasrnbr = DB::table('service_req_mstr')->get();
            // dd($datasrnbr->id);

            $datarepgroup = DB::table('xxrepgroup_mstr')
                ->selectRaw('MIN(xxrepgroup_id) as xxrepgroup_id , xxrepgroup_nbr, MIN(xxrepgroup_desc) as xxrepgroup_desc')
                ->groupBy('xxrepgroup_nbr')
                ->get();

            $wotypes = DB::table('wotyp_mstr')
                ->get();
            // dd($wotype);    

            $impacts = DB::table('imp_mstr')
                ->get();

            $fcodes = DB::table('fn_mstr')
                ->get();
            return view('service.servicereq-approval', ['wotypes' => $wotypes, 'impacts' => $impacts, 'fcodes' => $fcodes, 'datasrnbr' => $datasrnbr, 'datas' => $data, 'asset' => $datasset, 'repaircode' => $datarepair, 'repgroup' => $datarepgroup]);
        }
    }

    public function srapprovaleng(Request $req) /* blade : service.servicereq-approvaleng */
    {
        $user = FacadesAuth::user();

        // cek engineer approval
        $engineer_approver = DB::table('eng_mstr')
            ->where('eng_code', $user->username)
            ->where('eng_role', 'SPVSR')
            ->where('approver', '=', 1)
            ->first();
        // dd($engineer_approver);

        $kepalaengineer = DB::table('eng_mstr')
            ->where('approver', '=', 1)
            ->where('eng_active', '=', 'Yes')
            ->where('eng_code', '=', Session::get('username'))
            ->orderBy('eng_code')
            ->first();

        if ($kepalaengineer) {

            //jika yg login user adalah spvsr
            if ($engineer_approver != null || Session::get('role') == 'ADMIN') {
                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->join('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                    ->join('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,
                wotyp_mstr.*,users.*,dept_mstr.*,wo_mstr.*,
                srta_eng_status,eng_role,srta_eng_reason,service_req_mstr.id')
                    ->where('sr_status', '<>', 'Canceled')
                    // ->where('sr_status', '<>', 'Inprocess')
                    ->orderBy('sr_req_date', 'DESC')
                    // ->orderByRaw("FIELD(sr_priority, 'high', 'medium', 'low')")
                    // ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');


                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data
                        ->where('sr_eng_approver', '=', $engineer_approver->eng_dept)
                        ->where('eng_active', '=', 'Yes');
                }
                // dd($data);
            } else {

                //jika yg login user selain spvsr
                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->join('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,
                wotyp_mstr.*,users.*,dept_mstr.*,wo_mstr.*,
                srta_eng_status,eng_role,srta_eng_reason,service_req_mstr.id')
                    ->where('sr_status', '=', 'nostatus')
                    ->orderBy('sr_req_date', 'DESC')
                    // ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');
            }

            /** Tambahan kondisi jika akses dari menu notofikasi */
            if($req->status) {
                $data = $data->where('srta_eng_status','=','Waiting for engineer approval');
            }

            $data = $data->paginate(10);
            // dd($data);

            $datarepair = DB::table('rep_master')
                ->orderBy('repm_code')
                ->get();

            $datasset = DB::table('asset_mstr')
                ->get();

            $datasrnbr = DB::table('service_req_mstr')->get();
            // dd($datasrnbr->id);

            $datarepgroup = DB::table('xxrepgroup_mstr')
                ->selectRaw('MIN(xxrepgroup_id) as xxrepgroup_id , xxrepgroup_nbr, MIN(xxrepgroup_desc) as xxrepgroup_desc')
                ->groupBy('xxrepgroup_nbr')
                ->get();

            $wotypes = DB::table('wotyp_mstr')
                ->get();
            // dd($wotype);    

            $impacts = DB::table('imp_mstr')
                ->get();

            $fcodes = DB::table('fn_mstr')
                ->get();

            $maintenance = DB::table('pmc_mstr')->get();

            $inslist = DB::table('ins_list')->groupBy('ins_code')->get();

            $splist = DB::table('spg_list')->groupBy('spg_code')->get();

            $qclist = DB::table('qcs_list')->groupBy('qcs_code')->get();

            return view('service.servicereq-approvaleng', [
                'wotypes' => $wotypes, 'impacts' => $impacts,
                'fcodes' => $fcodes, 'datasrnbr' => $datasrnbr, 'datas' => $data,
                'asset' => $datasset, 'repaircode' => $datarepair, 'repgroup' => $datarepgroup,
                'inslist' => $inslist, 'splist' => $splist, 'maintenancelist' => $maintenance, 'qclist' => $qclist
            ]);
        } else {
            // toast('anda tidak memiliki akses sebagai approver', 'error');
            return view('service.accessdenied');
        }
    }

    public function engineersearch(Request $req)
    {
        // dd($req->code);

        $dept = Session::get('department');
        if ($req->ajax()) {
            if (Session::get('role') <> 'ADMIN') {
                $eng = DB::table('eng_mstr')
                    ->where('eng_active', '=', 'Yes')
                    ->where('eng_dept', '=', $dept)
                    ->orderBy('eng_code')
                    ->get();
            } else {
                $eng = DB::table('eng_mstr')
                    ->where('eng_active', '=', 'Yes')
                    ->orderBy('eng_code')
                    ->get();
            }

            // dd($eng);

            $array = json_decode(json_encode($eng), true);

            return response()->json($array);
        }
    }

    /*MR - 060223*/
    public function editsr(Request $req)
    {
        $srnbr = $req->e_nosr;
        $status = $req->e_status;
        $wotype = $req->e_wottype;
        $failcode = $req->e_failurecode;
        $impact = $req->e_impact;
        $priority = $req->e_priority;
        $note = $req->e_note;
        $reqdate = $req->e_date;
        $reqtime = $req->e_time;
        // $uploadfile = $req->filename ? $req->filename : [];
        $currentfile = DB::table('service_req_upload')->where('sr_number', $srnbr)->get();
        $approver = $req->e_approver;
        // dd($srnbr, $wotype, $failcode, $impact, $priority, $note, $reqdate, $reqtime, $uploadfile);
        // dd($approver);
        if ($req->hasFile('filename')) {

            foreach ($req->file('filename') as $upload) {
                $dataTime = date('Ymd_His');
                $filename = $dataTime . '-' . $upload->getClientOriginalName();

                // Simpan File Upload pada Public
                $savepath = public_path('uploadasset/');
                $filepath = 'uploadasset/';
                $upload->move($savepath, $filename);

                // Simpan ke DB Upload
                DB::table('service_req_upload')
                    ->insert([
                        'filepath' => $filepath . $filename,
                        'sr_number' => $srnbr,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
            }
        }

        //impact
        if (isset($impact)) {
            $counterimpact = count($impact);
        } else {
            $counterimpact = 0;
        }

        $newimpact = "";
        //  dd($newimpact);
        for ($i = 0; $i < $counterimpact; $i++) {
            $newimpact .= $impact[$i] . ',';
        }
        $newimpact = substr($newimpact, 0, strlen($newimpact) - 1);

        if ($newimpact == false) {
            $newimpact = "";
        }
        // dd($newimpact);

        //failure code
        if (isset($failcode)) {
            $counterfailcode = count($failcode);
        } else {
            $counterfailcode = 0;
        }

        $newfailcode = "";
        for ($i = 0; $i < $counterfailcode; $i++) {
            $newfailcode .= $failcode[$i] . ',';
        }
        $newfailcode = substr($newfailcode, 0, strlen($newfailcode) - 1);

        if ($newfailcode == false) {
            $newfailcode = "";
        }

        $srmstr = ServiceReqMaster::where('sr_number', $srnbr)->first();
        $runningnbr = $srmstr->sr_number;

        //update service_req_mstr
        $update = ServiceReqMaster::where('sr_number', $srnbr)->first();
        $update->sr_fail_type = $wotype;
        $update->sr_fail_code = $newfailcode;
        $update->sr_impact = $newimpact;
        $update->sr_priority = $priority;
        $update->sr_note = $note;
        $update->sr_req_date = $reqdate;
        $update->sr_req_time = $reqtime;
        $update->sr_eng_approver = $approver;
        $update->sr_status = 'Open';
        $update->updated_at = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

        //update service_req_mstr_hist
        DB::table('service_req_mstr_hist')
            ->insert([
                'sr_number' => $srnbr,
                'sr_eng_approver' => $approver,
                'sr_note' => $note,
                'sr_req_date' => $reqdate,
                'sr_req_time' => $reqtime,
                'sr_fail_type' => $wotype,
                'sr_fail_code' => $newfailcode,
                'sr_impact' => $newimpact,
                'sr_priority' => $priority,
                'sr_action' => 'SR Updated',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        //jika ada perubahan approval engineer sebelum diapprove oleh engineer
        // if ($srmstr->sr_eng_approver != $approver) {
        //     // dd(1);
        //     DB::table('sr_trans_approval_eng')
        //         ->where('srta_eng_mstr_id', $srmstr->id)
        //         ->update([
        //             'srta_eng_dept_approval' => $approver,
        //             'srta_eng_role_approval' => 'SPVSR',
        //             'srta_eng_reason' => null,
        //             'srta_eng_status' => 'Waiting for engineer approval',
        //             'srta_eng_approved_by' => null,
        //             'updated_at' => null,
        //         ]);

        //     DB::table('sr_trans_approval_eng_hist')
        //         ->insert([
        //             'srtah_eng_sr_number' => $srmstr->sr_number,
        //             'srtah_eng_dept_approval' => $approver,
        //             'srtah_eng_role_approval' => 'SPVSR',
        //             'srtah_eng_status' => 'Waiting for engineer approval',
        //             'srtah_eng_reason' => 'Approval has been changed by user',
        //             'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
        //             'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
        //         ]);

        //     // EmailScheduleJobs::dispatch('', '', '10', '', '', $runningnbr, '');
        // }

        //jika ada perubahan approval engineer setelah diapprove oleh engineer
        if ($srmstr->sr_status_approval == 'Revision from engineer approval') {
            // dd(2);
            $update->sr_status_approval = 'Waiting for engineer approval';

            DB::table('sr_trans_approval_eng')
                ->where('srta_eng_mstr_id', $srmstr->id)
                ->update([
                    'srta_eng_dept_approval' => $approver,
                    'srta_eng_role_approval' => 'SPVSR',
                    'srta_eng_reason' => null,
                    'srta_eng_status' => 'Waiting for engineer approval',
                    'srta_eng_approved_by' => null,
                    'updated_at' => null,
                ]);

            if ($srmstr->sr_eng_approver != $approver) {

                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $approver,
                        'srtah_eng_role_approval' => 'SPVSR',
                        'srtah_eng_status' => 'Waiting for engineer approval',
                        'srtah_eng_reason' => 'Approval has been changed by user',
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);
            } else {
                // dd(3);
                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_status' => 'Waiting for engineer approval',
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);
            }

            
        } elseif ($srmstr->sr_status_approval == 'Revision from department approval') {
            // dd(4);
            $update->sr_status_approval = 'Waiting for department approval';

            DB::table('sr_trans_approval')
                ->where('srta_mstr_id', $srmstr->id)
                ->update([
                    'srta_reason' => null,
                    'srta_status' => 'Waiting for department approval',
                    'srta_approved_by' => null,
                    'updated_at' => null,
                ]);

            DB::table('sr_trans_approval_hist')
                ->insert([
                    'srtah_sr_number' => $srmstr->sr_number,
                    'srtah_status' => 'Waiting for department approval',
                    'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                ]);
        }

        //email terkirim ke spv engineer/department yg baru
        EmailScheduleJobs::dispatch('', '', '10', '', '', $runningnbr, '');

        $update->save();

        toast('Service Request ' . $srnbr . ' successfully updated', 'success');
        return back();
    }

    /*MR - 160423*/
    public function cancelsr(Request $req)
    {
        $srnbr = $req->c_srnumber;
        $reason = $req->c_reason;

        $srmstr = ServiceReqMaster::where('sr_number', $srnbr)->first();
        // dd($srmstr);

        DB::table('service_req_mstr')
            ->where('sr_number', '=', $srnbr)
            ->update([
                'sr_status'       => 'Canceled',
                'sr_cancel_note'       => $reason,
                'updated_at'      => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
            ]);

        DB::table('service_req_mstr_hist')
            ->insert([
                'sr_number'         => $srnbr,
                'sr_fail_type'      => $srmstr->sr_fail_type,
                'sr_fail_code'      => $srmstr->sr_fail_code,
                'sr_impact'         => $srmstr->sr_impact,
                'sr_priority'       => $srmstr->sr_priority,
                'sr_note'           => $srmstr->sr_note,
                'sr_cancel_note'    => $reason,
                'sr_req_date'       => $srmstr->sr_req_date,
                'sr_req_time'       => $srmstr->sr_req_time,
                'sr_status'         => 'Canceled',
                'sr_status_approval'       => 'Canceled',
                'sr_eng_approver'   => $srmstr->sr_eng_approver,
                'sr_action'         => 'SR Canceled',
                'created_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                // 'sr_access'       => 0
            ]);

        $approvaldept = DB::table('sr_trans_approval')->where('srta_mstr_id', $srmstr->id)->get();

        foreach ($approvaldept as $appr) {
            if ($appr->srta_status = 'Waiting for department approval') {
                DB::table('sr_trans_approval')
                    ->where('srta_mstr_id', '=', $srmstr->id)
                    ->update([
                        'srta_status'     => 'Canceled by user',
                        'updated_at'      => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                    ]);

                DB::table('sr_trans_approval_hist')
                    ->insert([
                        'srtah_sr_number' => $srnbr,
                        'srtah_status' => 'Canceled by user',
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);
            }
        }

        $approvaleng = DB::table('sr_trans_approval_eng')->where('srta_eng_mstr_id', $srmstr->id)->first();
        if ($approvaleng != null) {
            if ($approvaleng->srta_eng_status = 'Waiting for engineer approval') {
                DB::table('sr_trans_approval_eng')
                    ->where('srta_eng_mstr_id', '=', $srmstr->id)
                    ->update([
                        'srta_eng_status'     => 'Canceled by user',
                        'updated_at'      => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                    ]);

                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srnbr,
                        'srtah_eng_status' => 'Canceled by user',
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);
            }
        }


        DB::commit();
        toast('Service Request ' . $srnbr . ' successfully canceled', 'success');
        return back();
    }

    public function approval(Request $req)
    { /* blade : service.servicereq-approval */
        // dd($req->all());

        $wotype = $req->wotype;
        $imcode = $req->impactcode1;
        $imdesc = $req->impact;
        $idsr = $req->idsr;
        $reason = $req->reason;
        // dd($idsr, $reason);

        $user = FacadesAuth::user();

        //cek service_req_mstr
        $srmstr = DB::table('service_req_mstr')->where('service_req_mstr.id', $idsr)
            ->join('asset_mstr', 'asset_mstr.asset_code', '=', 'service_req_mstr.sr_asset')
            ->selectRaw('service_req_mstr.*, service_req_mstr.id, asset_mstr.asset_code, asset_mstr.asset_desc')
            ->first();

        $asset = $srmstr->asset_code . ' -- ' . $srmstr->asset_desc;
        $srnumber = $srmstr->sr_number;
        $requestor = $srmstr->sr_req_by;
        $roleapprover = $user->role_user;

        //cek departemen dan role approval yg sesuai dengan user yg login
        if (Session::get('role') <> 'ADMIN') {
            //jika user bukan admin
            $srdeptapprover = DB::table('sr_trans_approval')
                ->where('srta_dept_approval', $srmstr->sr_dept)
                ->where('srta_mstr_id', $idsr)
                ->where('srta_role_approval', $user->role_user)
                ->first();
        } else {
            //jika user adalah admin
            $srdeptapprover = DB::table('sr_trans_approval')
                ->where('srta_dept_approval', $srmstr->sr_dept)
                ->where('srta_mstr_id', $idsr)
                ->first();
        }
        // dd($srdeptapprover);

        switch ($req->input('action')) {
            case 'reject':
                //jika direject;
                // dd('test');
                $running = DB::table('running_mstr')
                    ->first();
                // dd($running);
                $newyear = Carbon::now()->format('y');
                $runningnbr = $running->wo_prefix . '-' . $newyear . '-' . $running->wo_nbr;
                $srnumber = $req->srnumber;
                $asset = $req->assetcode . ' -- ' . $req->assetdesc;
                $a = 4; //direject 
                $wo = $runningnbr;
                // $wotype = $req->wotype;
                $imdesc = $req->impact;

                $statusakses = DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->first();

                //cek next approver
                $nextapprover = DB::table('sr_trans_approval')->where('srta_mstr_id', $srdeptapprover->srta_mstr_id)
                    ->where('srta_sequence', '>', $srdeptapprover->srta_sequence)
                    ->first();

                //cek previous approver
                $previousapprover = DB::table('sr_trans_approval')->where('srta_mstr_id', $srdeptapprover->srta_mstr_id)
                    ->where('srta_sequence', '<', $srdeptapprover->srta_sequence)
                    ->get();
                // dd(is_null($nextapprover));

                $servicereqmstr = [
                    'sr_status' => 'Revise',
                    'sr_status_approval' => 'Revision from department approval',
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];

                $servicereqmstr_hist = [
                    'sr_number'       => $srmstr->sr_number,
                    'sr_dept'       => $srmstr->sr_dept,
                    'sr_asset'       => $srmstr->sr_asset,
                    'sr_fail_type'    => $srmstr->sr_fail_type,
                    'sr_fail_code'    => $srmstr->sr_fail_code,
                    'sr_impact'       => $srmstr->sr_impact,
                    'sr_priority'     => $srmstr->sr_priority,
                    'sr_note'         => $srmstr->sr_note,
                    'sr_req_by'       => $srmstr->sr_req_by,
                    'sr_req_date'     => $srmstr->sr_req_date,
                    'sr_req_time'     => $srmstr->sr_req_time,
                    'sr_status'       => 'Revise',
                    'sr_status_approval'       => 'Revise',
                    'sr_eng_approver' => $srmstr->sr_eng_approver,
                    'sr_action'       => 'Department Approval Revision',
                    'created_at'   => Carbon::now()->toDateTimeString(),
                    'updated_at'   => Carbon::now()->toDateTimeString(),
                    //         // 'updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    //         // 'sr_access'       => 0
                ];

                $srtransapproval = [
                    'srta_status'      => 'Revision',
                    'srta_reason'      => $reason,
                    'srta_approved_by' => $user->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];

                $srtransapproval_hist = [
                    'srtah_sr_number' => $srmstr->sr_number,
                    'srtah_dept_approval' => $srdeptapprover->srta_dept_approval,
                    'srtah_role_approval' => $srdeptapprover->srta_role_approval,
                    'srtah_sequence' => $srdeptapprover->srta_sequence,
                    'srtah_status' => 'Revision',
                    'srtah_reason' => $reason,
                    'srtah_approved_by' => $user->id,
                    'created_at'   => Carbon::now()->toDateTimeString(),
                    'updated_at'   => Carbon::now()->toDateTimeString(),
                ];

                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->update($servicereqmstr);

                DB::table('service_req_mstr_hist')
                    ->insert($servicereqmstr_hist);

                if (is_null($nextapprover)) {
                    //kondisi hanya 1 approver atau approver terakhir

                    if ($previousapprover->isEmpty()) {
                        // dd('1 approver');
                        DB::table('sr_trans_approval')
                            ->where('srta_mstr_id', '=', $idsr)
                            ->where('srta_role_approval', '=', $user->role_user)
                            ->update($srtransapproval);

                        DB::table('sr_trans_approval_hist')
                            ->insert($srtransapproval_hist);
                    } else {
                        // dd('approver terakhir');
                        DB::table('sr_trans_approval')
                            ->where('srta_mstr_id', '=', $idsr)
                            // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
                            ->update($srtransapproval);

                        DB::table('sr_trans_approval_hist')
                            ->insert($srtransapproval_hist);
                    }
                } else {
                    //kondisi approver pertama atau approver tengah
                    if ($previousapprover->isEmpty()) {
                        // dd('approver pertama');
                        DB::table('sr_trans_approval')
                            ->where('srta_mstr_id', '=', $idsr)
                            // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
                            ->update($srtransapproval);

                        DB::table('sr_trans_approval_hist')
                            ->insert($srtransapproval_hist);
                    } else {
                        // dd('approver tengah');
                        DB::table('sr_trans_approval')
                            ->where('srta_mstr_id', '=', $idsr)
                            // ->where('srta_role_approval', '=', $user->role_user) <-- role dikomen biar semua approver statusnya revisi -->
                            ->update($srtransapproval);

                        DB::table('sr_trans_approval_hist')
                            ->insert($srtransapproval_hist);
                    }
                }

                //nanti dibuka EmailScheduleJobs::dispatch($wo,$asset,$a,'',$requestor,$srnumber,$rejectnote);

                //kirim email ke user
                EmailScheduleJobs::dispatch('', $asset, '4', '', $requestor, $srnumber, $roleapprover);

                toast('Service Request ' . $req->srnumber . '  Rejected Successfully ', 'success');
                return back();

                break;

            case 'approve': //jika diapprove

                //cek engineer approval
                $engineer_approver = DB::table('eng_mstr')->where('eng_dept', $srmstr->sr_eng_approver)
                    ->where('approver', '=', 1)
                    ->first();
                // dump($engineer_approver);

                //cek next approver
                $nextapprover = DB::table('sr_trans_approval')->where('srta_mstr_id', $srdeptapprover->srta_mstr_id)
                    ->where('srta_sequence', '>', $srdeptapprover->srta_sequence)
                    ->first();

                // dd($nextapprover);

                if (is_null($nextapprover)) {
                    //jika tidak ada approver selanjutnya

                    //cek apakah approver admin atau bukan
                    if (Session::get('role') <> 'ADMIN') {
                        //jika user bukan admin
                        DB::table('sr_trans_approval')
                            ->where('srta_mstr_id', '=', $idsr)
                            ->where('srta_role_approval', '=', $user->role_user)
                            ->update([
                                'srta_status'      => 'Approved',
                                'srta_reason'      => $reason,
                                'srta_approved_by' => $user->id,
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);
                    } else {
                        //jika user adalah admin
                        DB::table('sr_trans_approval')
                            ->where('srta_mstr_id', '=', $idsr)
                            ->update([
                                'srta_status'      => 'Approved',
                                'srta_reason'      => $reason,
                                'srta_approved_by' => $user->id,
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);
                    }

                    DB::table('sr_trans_approval_hist')
                        ->insert([
                            'srtah_sr_number' => $srmstr->sr_number,
                            'srtah_dept_approval' => $user->dept_user,
                            'srtah_role_approval' => $user->role_user,
                            'srtah_sequence' => $srdeptapprover->srta_sequence,
                            'srtah_status' => 'Approved',
                            'srtah_reason' => $reason,
                            'srtah_approved_by' => $user->id,
                            'created_at'   => Carbon::now()->toDateTimeString(),
                            'updated_at'   => Carbon::now()->toDateTimeString(),
                        ]);

                    DB::table('service_req_mstr')
                        ->where('id', '=', $idsr)
                        ->update([
                            'sr_status' => 'Open',
                            'sr_status_approval' => 'Waiting for engineer approval',
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    DB::table('service_req_mstr_hist')
                        ->insert([
                            'sr_number'       => $srmstr->sr_number,
                            'sr_dept'       => $srmstr->sr_dept,
                            'sr_asset'       => $srmstr->sr_asset,
                            'sr_fail_type'    => $srmstr->sr_fail_type,
                            'sr_fail_code'    => $srmstr->sr_fail_code,
                            'sr_impact'       => $srmstr->sr_impact,
                            'sr_priority'     => $srmstr->sr_priority,
                            'sr_note'         => $srmstr->sr_note,
                            'sr_req_by'       => $srmstr->sr_req_by,
                            'sr_req_date'     => $srmstr->sr_req_date,
                            'sr_req_time'     => $srmstr->sr_req_time,
                            'sr_status'       => 'Open',
                            'sr_status_approval'       => 'Approved',
                            'sr_eng_approver' => $srmstr->sr_eng_approver,
                            'sr_action'       => 'Department Approval Approved',
                            'created_at'   => Carbon::now()->toDateTimeString(),
                            'updated_at'   => Carbon::now()->toDateTimeString(),
                            // 'updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            // 'sr_access'       => 0
                        ]);

                    DB::table('sr_trans_approval_eng')
                        ->insert([
                            'srta_eng_mstr_id' => $idsr,
                            'srta_eng_dept_approval' => $engineer_approver->eng_dept,
                            'srta_eng_status' => 'Waiting for engineer approval',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    DB::table('sr_trans_approval_eng_hist')
                        ->insert([
                            'srtah_eng_sr_number' => $srmstr->sr_number,
                            'srtah_eng_dept_approval' => $engineer_approver->eng_dept,
                            'srtah_eng_status' => 'Waiting for engineer approval',
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    //kirim email ke engineer approver
                    EmailScheduleJobs::dispatch('', $asset, '8', '', $requestor, $srnumber, $roleapprover);
                } else {
                    // dd('notnull');
                    $tampungarray = $nextapprover;

                    //cek apakah approver admin atau bukan
                    if (Session::get('role') <> 'ADMIN') {
                        //jika user bukan admin
                        DB::table('service_req_mstr')
                            ->where('id', '=', $idsr)
                            ->update([
                                'sr_status' => 'Open',
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        //update ke approval department saat ini
                        DB::table('sr_trans_approval')
                            ->where('srta_mstr_id', '=', $idsr)
                            ->where('srta_role_approval', '=', $user->role_user)
                            ->update([
                                'srta_status'      => 'Approved',
                                'srta_reason'      => $reason,
                                'srta_approved_by' => $user->id,
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        //kirim email ke approver selanjutnya
                        EmailScheduleJobs::dispatch('', $asset, '7', $tampungarray, $requestor, $srnumber, $roleapprover);
                    } else {
                        //jika user adalah admin langsung ke engineer approver
                        DB::table('service_req_mstr')
                            ->where('id', '=', $idsr)
                            ->update([
                                'sr_status' => 'Open',
                                'sr_status_approval' => 'Waiting for engineer approval',
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        //update semua tingakat approval department
                        DB::table('sr_trans_approval')
                            ->where('srta_mstr_id', '=', $idsr)
                            ->update([
                                'srta_status'      => 'Approved',
                                'srta_reason'      => $reason,
                                'srta_approved_by' => $user->id,
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        //insert ke approval engineer
                        DB::table('sr_trans_approval_eng')
                            ->insert([
                                'srta_eng_mstr_id' => $idsr,
                                'srta_eng_dept_approval' => $engineer_approver->eng_dept,
                                'srta_eng_status' => 'Waiting for engineer approval',
                                'created_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        DB::table('sr_trans_approval_eng_hist')
                            ->insert([
                                'srtah_eng_sr_number' => $srmstr->sr_number,
                                'srtah_eng_dept_approval' => $engineer_approver->eng_dept,
                                'srtah_eng_status' => 'Waiting for engineer approval',
                                'created_at' => Carbon::now()->toDateTimeString(),
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        //kirim email ke engineer approver
                        EmailScheduleJobs::dispatch('', $asset, '8', '', $requestor, $srnumber, $roleapprover);
                    }

                    DB::table('sr_trans_approval_hist')
                        ->insert([
                            'srtah_sr_number' => $srmstr->sr_number,
                            'srtah_dept_approval' => $user->dept_user,
                            'srtah_role_approval' => $user->role_user,
                            'srtah_sequence' => $srdeptapprover->srta_sequence,
                            'srtah_status' => 'Approved',
                            'srtah_reason' => $reason,
                            'srtah_approved_by' => $user->id,
                            'created_at'   => Carbon::now()->toDateTimeString(),
                            'updated_at'   => Carbon::now()->toDateTimeString(),
                        ]);
                }
                // }

                toast('Service Request ' . $req->srnumber . '  Succesfully Approved ', 'success');

                return back();

                break;
        }
    }

    public function routesr(Request $request)
    {
        $sr_number = $request->sr_number;
        $datasr = DB::table('service_req_mstr')
            ->where('sr_number', '=', $sr_number)
            ->first();

        $dataApprover = DB::table('sr_trans_approval')
            ->leftJoin('users', 'sr_trans_approval.srta_approved_by', '=', 'users.id')
            ->join('dept_mstr', 'sr_trans_approval.srta_dept_approval', '=', 'dept_mstr.dept_code')
            ->selectRaw('sr_trans_approval.*, users.username, dept_mstr.dept_desc')
            ->where('srta_mstr_id', '=', $datasr->id)
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
                $output .= $approver->srta_dept_approval;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->srta_role_approval;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->srta_reason;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->srta_status;
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
            $output .= '<center> No approval from related departments </center>';
            $output .= '</td>';
            $output .= '</tr>';
        }



        return response($output);
    }

    public function routesreng(Request $request)
    {
        $sr_number = $request->sr_number;
        $datasr = DB::table('service_req_mstr')
            ->where('sr_number', '=', $sr_number)
            ->first();

        $dataApprover = DB::table('sr_trans_approval_eng')
            ->leftJoin('users', 'sr_trans_approval_eng.srta_eng_approved_by', '=', 'users.id')
            ->join('dept_mstr', 'sr_trans_approval_eng.srta_eng_dept_approval', '=', 'dept_mstr.dept_code')
            ->leftJoin('roles', 'sr_trans_approval_eng.srta_eng_role_approval', '=', 'roles.role_code')
            ->selectRaw('sr_trans_approval_eng.*, users.username, dept_mstr.dept_code, dept_mstr.dept_desc, roles.role_desc')
            ->where('srta_eng_mstr_id', '=', $datasr->id)
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
                $output .= $approver->dept_code . ' -- ' . $approver->dept_desc;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->srta_eng_role_approval . ' -- ' . $approver->role_desc;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->srta_eng_reason;
                $output .= '</td>';
                $output .= '<td>';
                $output .= $approver->srta_eng_status;
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
            $output .= '<center> Need approval department first </center>';
            $output .= '</td>';
            $output .= '</tr>';
        }



        return response($output);
    }

    public function approvaleng(Request $req)
    { /* blade : service.servicereq-approvaleng */
        // dd($req->wotype);
        $wotype = $req->wotype;
        $imcode = $req->impactcode1;
        $imdesc = $req->impact;
        $idsr   = $req->idsr;
        $rejectnote = $req->rejectreason;
        $srmstr = DB::table('service_req_mstr')->where('id', $idsr)->first();
        $user = DB::table('users')->where('username', Session::get('username'))->first();
        // dd($user->id);

        // dd($idsr);
        //cek engineer approval
        $engineer_approver = DB::table('eng_mstr')->where('eng_dept', $srmstr->sr_eng_approver)
            ->where('approver', '=', 1)
            ->first();



        switch ($req->input('action')) {
            case 'reject':
                //jika direject;
                // dd('test');
                $running = DB::table('running_mstr')
                    ->first();

                $newyear = Carbon::now()->format('y');

                $runningnbr = $running->wo_prefix . '-' . $newyear . '-' . $running->wo_nbr;
                // $tampungarray = [];
                // $tampungarray = $req->enjiners;
                // dd($tampungarray);
                // $rejectnote = $req->rejectreason;
                $requestor = $req->hiddenreq;
                $srnumber = $req->srnumber;
                $asset = $req->assetcode . ' -- ' . $req->assetdesc;
                $a = 4; //direject 
                $wo = $runningnbr;
                // $wotype = $req->wotype;
                $imdesc = $req->impact;

                $servicereqmstr = [
                    'sr_status' => 'Revise',
                    'sr_status_approval' => 'Revision from engineer approval',
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];

                $servicereqmstr_hist = [
                    'sr_number'       => $srmstr->sr_number,
                    'sr_dept'       => $srmstr->sr_dept,
                    'sr_asset'       => $srmstr->sr_asset,
                    'sr_fail_type'    => $srmstr->sr_fail_type,
                    'sr_fail_code'    => $srmstr->sr_fail_code,
                    'sr_impact'       => $srmstr->sr_impact,
                    'sr_priority'     => $srmstr->sr_priority,
                    'sr_note'         => $srmstr->sr_note,
                    'sr_req_by'       => $srmstr->sr_req_by,
                    'sr_req_date'     => $srmstr->sr_req_date,
                    'sr_req_time'     => $srmstr->sr_req_time,
                    'sr_status'       => 'Revise',
                    'sr_status_approval'       => 'Revision from engineer approval',
                    'sr_eng_approver' => $srmstr->sr_eng_approver,
                    'sr_action'       => 'Engineer Approval Revision',
                    'created_at'   => Carbon::now()->toDateTimeString(),
                    'updated_at'   => Carbon::now()->toDateTimeString(),
                    //         // 'updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    //         // 'sr_access'       => 0
                ];

                DB::table('service_req_mstr')
                    ->where('id', '=', $idsr)
                    ->update($servicereqmstr);

                DB::table('service_req_mstr_hist')
                    ->insert($servicereqmstr_hist);

                DB::table('sr_trans_approval_eng')
                    ->where('srta_eng_mstr_id', '=', $idsr)
                    ->update([
                        'srta_eng_dept_approval' => $engineer_approver->eng_dept,
                        'srta_eng_role_approval' => $engineer_approver->eng_role,
                        'srta_eng_status' => 'Revision from engineer approval',
                        'srta_eng_reason' => $rejectnote,
                        'srta_eng_approved_by' => $user->id,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $engineer_approver->eng_dept,
                        'srtah_eng_role_approval' => $engineer_approver->eng_role,
                        'srtah_eng_status' => 'Revision from engineer approval',
                        'srtah_eng_reason' => $rejectnote,
                        'srtah_eng_approved_by' => $user->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

                //nanti dibuka EmailScheduleJobs::dispatch($wo,$asset,$a,'',$requestor,$srnumber,$rejectnote);
                //kirim email ke user
                EmailScheduleJobs::dispatch('', $asset, '9', '', $requestor, $srnumber, '');

                toast('Service Request ' . $req->srnumber . '  Rejected Successfully ', 'success');
                return back();

                break;

            case 'approve': //jika diapprove
                // dd('approve');
                $asset = DB::table('asset_mstr')
                    ->where('asset_code', '=', $req->assetcode)
                    ->first();

                $thisFailCode = "";

                if ($req->has('fclist')) {
                    $thisFailCode = implode(';', array_map('strval', $req->fclist));
                    $thisFailCodeSR = implode(',', array_map('strval', $req->fclist));
                } else {
                    $thisFailCode = null;
                    $thisFailCodeSR = null;
                }

                $thisImpact = "";

                if ($req->has('impact')) {
                    $thisImpact = implode(';', array_map('strval', $req->impact));
                    $thisImpactSR = implode(',', array_map('strval', $req->impact));
                } else {
                    $thisImpact = null;
                    $thisImpactSR = null;
                }

                $thisListEng = "";

                if ($req->has('enjiners')) {
                    $thisListEng = implode(';', array_map('strval', $req->enjiners));
                } else {
                    $thisListEng = null;
                }

                $running = DB::table('running_mstr')
                    ->first();

                $newyear = Carbon::now()->format('y');

                if ($running->year == $newyear) {
                    $tempnewrunnbr = strval(intval($running->wo_nbr) + 1);

                    $newtemprunnbr = '';
                    if (strlen($tempnewrunnbr) < 6) {
                        $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                    }
                } else {
                    $newtemprunnbr = "000001";
                }

                $runningnbr = $running->wo_prefix . '-' . $newyear . '-' . $newtemprunnbr;

                $tampungarray = [];
                $tampungarray2 = [];
                $tampungarray = $req->enjiners;
                $jmlarray = count($tampungarray);
                $fcodes = $req->fclist;

                $arrayarray = [
                    'wo_number'         => $runningnbr,
                    'wo_sr_number'      => $req->srnumber,
                    'wo_asset_code'     => $req->assetcode,
                    'wo_site'           => $asset->asset_site,
                    'wo_location'       => $asset->asset_loc,
                    'wo_type'           => 'CM',
                    'wo_status'         => 'firm', /* awalnya open, tapi karena ada WO release, status open hanya jika sudah whsconfirm */
                    'wo_priority'       => $req->priority,
                    'wo_failure_code'   => $thisFailCode,
                    'wo_failure_type'   => $wotype,
                    'wo_list_engineer'  => $thisListEng,
                    'wo_impact_code'    => $thisImpact,
                    'wo_start_date'     => $req->scheduledate,
                    'wo_due_date'       => $req->duedate,
                    'wo_mt_code'        => $req->has('c_mtcode') ? $req->c_mtcode : null,
                    'wo_ins_code'       => $req->has('c_inslist') ? $req->c_inslist : null,
                    'wo_sp_code'        => $req->has('c_splist') ? $req->c_splist : null,
                    'wo_qcspec_code'    => $req->has('c_qclist') ? $req->c_qclist : null,
                    'wo_note'           => $req->wonote,
                    'wo_createdby'      => session()->get('username'),
                    'wo_department'     => session()->get('department'),
                    'wo_system_create'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_system_update'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                ];

                DB::table('wo_mstr')
                    ->insert($arrayarray);

                // dd('stop here');

                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $req->srnumber)
                    ->update([
                        'wo_number' => $runningnbr,
                        'sr_status' => 'Inprocess', //status SR = ASSIGNED
                        'sr_priority' => $req->priority,
                        'sr_fail_type' => $wotype,
                        'sr_fail_code' => $thisFailCodeSR,
                        'sr_impact' => $thisImpactSR,
                        'sr_status_approval' => 'Approved by engineer', //status SR = ASSIGNED
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);

                DB::table('service_req_mstr_hist')
                    ->insert([
                        'sr_number'       => $srmstr->sr_number,
                        'sr_dept'       => $srmstr->sr_dept,
                        'sr_asset'       => $srmstr->sr_asset,
                        'sr_fail_type'    => $srmstr->sr_fail_type,
                        'sr_fail_code'    => $srmstr->sr_fail_code,
                        'sr_impact'       => $srmstr->sr_impact,
                        'sr_priority'     => $srmstr->sr_priority,
                        'sr_note'         => $srmstr->sr_note,
                        'sr_req_by'       => $srmstr->sr_req_by,
                        'sr_req_date'     => $srmstr->sr_req_date,
                        'sr_req_time'     => $srmstr->sr_req_time,
                        'sr_status'       => 'Approved',
                        'sr_status_approval'       => 'Approved',
                        'sr_eng_approver' => $srmstr->sr_eng_approver,
                        'sr_action'       => 'Engineer Approval Approved',
                        'created_at'   => Carbon::now()->toDateTimeString(),
                        'updated_at'   => Carbon::now()->toDateTimeString(),
                        //         // 'updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        //         // 'sr_access'       => 0
                    ]);

                //update approval engineer
                DB::table('sr_trans_approval_eng')
                    ->where('srta_eng_mstr_id', '=', $idsr)
                    ->update([
                        'srta_eng_dept_approval' => $engineer_approver->eng_dept,
                        'srta_eng_role_approval' => $engineer_approver->eng_role,
                        'srta_eng_status' => 'Approved',
                        'srta_eng_reason' => $rejectnote,
                        'srta_eng_approved_by' => $user->id,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $engineer_approver->eng_dept,
                        'srtah_eng_role_approval' => $engineer_approver->eng_role,
                        'srtah_eng_status' => 'Approved from engineer approval',
                        'srtah_eng_reason' => $rejectnote,
                        'srtah_eng_approved_by' => $user->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

                //insert wo approval

                //get wo dan sr mstr
                $womstr = DB::table('wo_mstr')->where('wo_sr_number', $req->srnumber)->first();
                // $srmstr = DB::table('service_req_mstr')->where('sr_number', $req->srnumber)->first();

                //cek departemen approval
                $woapprover = DB::table('wo_approver_mstr')->where('id', '>', 0)->get();

                //cek engineer approval
                $engdeptapprover = DB::table('eng_mstr')->where('eng_dept', $srmstr->sr_eng_approver)->first();

                if (count($woapprover) > 0) {
                    for ($i = 0; $i < count($woapprover); $i++) {
                        $nextroleapprover = $woapprover[$i]->wo_approver_role;
                        $nextseqapprover = $woapprover[$i]->wo_approver_order;

                        //jika lewat approval QC, department dikosongkan
                        if ($woapprover[$i]->wo_approver_role == 'QCA') {
                            //input ke wo trans approval jika ada approval
                            DB::table('wo_trans_approval')
                                ->insert([
                                    'wotr_mstr_id' => $womstr->id,
                                    'wotr_sr_number' => $womstr->wo_sr_number,
                                    'wotr_role_approval' => $nextroleapprover,
                                    'wotr_sequence' => $nextseqapprover,
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                ]);

                            //input ke wo trans approval hist jika ada approval department
                            DB::table('wo_trans_approval_hist')
                                ->insert([
                                    'wotrh_wo_number' => $womstr->wo_number,
                                    'wotrh_sr_number' => $womstr->wo_sr_number,
                                    'wotrh_role_approval' => $nextroleapprover,
                                    'wotrh_sequence' => $nextseqapprover,
                                    'wotrh_status' => 'WO created',
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                    'updated_at' => Carbon::now()->toDateTimeString(),
                                ]);
                        } else {
                            //input ke wo trans approval jika ada approval
                            DB::table('wo_trans_approval')
                                ->insert([
                                    'wotr_mstr_id' => $womstr->id,
                                    'wotr_sr_number' => $womstr->wo_sr_number,
                                    'wotr_dept_approval' => session()->get('department'),
                                    'wotr_role_approval' => $nextroleapprover,
                                    'wotr_sequence' => $nextseqapprover,
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                ]);

                            //input ke wo trans approval hist jika ada approval department
                            DB::table('wo_trans_approval_hist')
                                ->insert([
                                    'wotrh_wo_number' => $womstr->wo_number,
                                    'wotrh_sr_number' => $womstr->wo_sr_number,
                                    'wotrh_dept_approval' => session()->get('department'),
                                    'wotrh_role_approval' => $nextroleapprover,
                                    'wotrh_sequence' => $nextseqapprover,
                                    'wotrh_status' => 'WO created',
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                    'updated_at' => Carbon::now()->toDateTimeString(),
                                ]);
                        }
                    }
                }


                DB::table('wo_trans_history')
                    ->insert([
                        'wo_number' => $runningnbr,
                        'wo_action' => 'firm',
                    ]);

                //update running number
                DB::table('running_mstr')
                    ->where('wo_nbr', '=', $running->wo_nbr)
                    ->update([
                        'year' => $newyear,
                        'wo_nbr' => $newtemprunnbr,
                    ]);

                $a = 2; //SR diapprove engineer dan konversi menjadi WO
                $wo = $runningnbr;
                $requestor = $req->hiddenreq;
                $srnumber = $req->srnumber;
                $rejectnote = $req->rejectreason;
                $asset = $req->assetcode . ' -- ' . $req->assetdesc;
                // dd($rejectnote);

                // dd($wo,$asset,$a,$tampungarray,$requestor,$srnumber,$rejectnote);
                //nanti kirim email ke engineer dan requestor 
                EmailScheduleJobs::dispatch($wo, $asset, $a, $tampungarray, $requestor, $srnumber, '');

                toast('Service Request ' . $req->srnumber . '  Approved to Work Order ' . $runningnbr . ' ', 'success');
                return back();

                break;
        }
    }

    public function searchapproval(Request $req)
    { /* blade : service.servicereq-approval */
        if ($req->ajax()) {
            $srnumber = $req->get('srnumber');
            $asset = $req->get('asset');
            $priority = $req->get('priority');

            $user = FacadesAuth::user();

            if ($srnumber == "" && $asset == "" && $priority == "") {

                $dataapps = DB::table('service_req_mstr')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_eng_approver')
                    ->selectRaw('dept_mstr.*')
                    ->where('sr_dept', '=', session::get('department'))
                    ->first();

                $data = ServiceReqMaster::query()
                    ->with(['getCurrentApprover'])
                    ->where('sr_status', '<>', 'Canceled')
                    ->where('sr_status', '<>', 'Inprocess')
                    ->whereHas('getSRTransAppr', function ($q) {
                        $q->with(['getDeptApprover', 'getRoleApprover'])
                            ->where('srta_status', '=', 'Waiting for department approval')
                            ->orWhere('srta_status', '=', 'Approved')
                            ->orWhere('srta_status', '=', 'Revision');
                    });
                $data = $data
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->leftJoin('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                    ->selectRaw('service_req_mstr.*, asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, users.name, dept_mstr.dept_desc, srta_reason')
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data->where('srta_role_approval', $user->role_user);
                }

                $data = $data->paginate(10);

                return view('service.table-srapproval', ['datas' => $data, 'dataapps' => $dataapps]);
            } else {
                // $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
                // $limahari = Carbon::now()->subDays(5)->toDateTimeString();


                // dd($tigahari,$limahari);

                // $kondisi = "sr_created_at > 01-01-1900";
                $kondisi = "service_req_mstr.id > 0";


                if ($srnumber != '') {
                    $kondisi .= " and sr_number like '%" . $srnumber . "%'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_desc like '%" . $asset . "%'";
                }
                if ($priority != '') {
                    $kondisi .= " and sr_priority = '" . $priority . "'";
                }

                // dd($kondisi);

                $dataapps = DB::table('service_req_mstr')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_eng_approver')
                    ->selectRaw('dept_mstr.*')
                    ->where('sr_dept', '=', session::get('department'))
                    ->first();

                $data = ServiceReqMaster::query()
                    ->with(['getCurrentApprover'])
                    ->where('sr_status', '<>', 'Canceled')
                    ->where('sr_status', '<>', 'Inprocess')
                    ->whereHas('getSRTransAppr', function ($q) {
                        $q->with(['getDeptApprover', 'getRoleApprover'])
                            ->where('srta_status', '=', 'Waiting for department approval')
                            ->orWhere('srta_status', '=', 'Approved')
                            ->orWhere('srta_status', '=', 'Revision');
                    });
                $data = $data
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->leftJoin('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                    ->selectRaw('service_req_mstr.*, asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, users.name, dept_mstr.dept_desc, srta_reason')
                    ->whereRaw($kondisi)
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data->where('srta_role_approval', $user->role_user);
                }

                $data = $data->paginate(10);

                return view('service.table-srapproval', ['datas' => $data, '$dataapps' => $dataapps]);
            }
        }
    }

    public function searchapprovaleng(Request $req)
    { /* blade : service.servicereq-approvaleng */
        if ($req->ajax()) {
            $srnumber = $req->get('srnumber');
            $asset = $req->get('asset');
            $priority = $req->get('priority');
            $status = $req->get('status');
            // dd($status);
            // dd($srnumber, $asset, $priority);
            // $period = $req->get('period');

            $user = FacadesAuth::user();

            // cek engineer approval
            $engineer_approver = DB::table('eng_mstr')
                ->where('eng_code', $user->username)
                ->where('eng_role', 'SPVSR')
                ->where('approver', '=', 1)
                ->first();

            if ($srnumber == "" && $asset == "" && $priority == "" && $status == "") {

                $dataapps = DB::table('service_req_mstr')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_eng_approver')
                    ->selectRaw('dept_mstr.*')
                    ->where('sr_dept', '=', session::get('department'))
                    ->first();


                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->join('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,
                wotyp_mstr.*,users.*,dept_mstr.*,wo_mstr.*,
                srta_eng_status,eng_role,srta_eng_reason,service_req_mstr.id')
                    ->where('sr_status', '<>', 'Canceled')
                    // ->where('sr_status', '<>', 'Inprocess')
                    ->orderBy('sr_req_date', 'DESC')
                    // ->orderBy('sr_number', 'DESC')
                    // ->orderByRaw("FIELD(sr_priority, 'high', 'medium', 'low')")
                    ->groupBy('sr_number');


                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data
                        ->where('sr_eng_approver', '=', $engineer_approver->eng_dept)
                        ->where('eng_active', '=', 'Yes');
                }

                $data = $data->paginate(10);
                // dd($data);

                return view('service.table-srapprovaleng', ['datas' => $data, 'dataapps' => $dataapps]);
            } else {
                // $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
                // $limahari = Carbon::now()->subDays(5)->toDateTimeString();


                // dd($tigahari,$limahari);

                // $kondisi = "sr_created_at > 01-01-1900";
                $kondisi = "service_req_mstr.id > 0";


                if ($srnumber != '') {
                    $kondisi .= " and sr_number like '%" . $srnumber . "%'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_desc like '%" . $asset . "%'";
                }
                if ($priority != '') {
                    $kondisi .= " and sr_priority = '" . $priority . "'";
                }
                if ($status != '') {
                    $kondisi .= " and srta_eng_status = '" . $status . "'";
                }

                // dd($kondisi);

                $dataapps = DB::table('service_req_mstr')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_eng_approver')
                    ->selectRaw('dept_mstr.*')
                    ->where('sr_dept', '=', session::get('department'))
                    ->first();

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->join('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,
                wotyp_mstr.*,users.*,dept_mstr.*,wo_mstr.*,
                srta_eng_status,eng_role,srta_eng_reason,service_req_mstr.id')
                    ->where('sr_status', '<>', 'Canceled')
                    ->whereRaw($kondisi)
                    ->orderBy('sr_req_date', 'DESC')
                    // ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data
                        ->where('sr_eng_approver', '=', $engineer_approver->eng_dept)
                        ->where('eng_active', '=', 'Yes');
                }

                $data = $data->paginate(10);
                // dd($data);

                return view('service.table-srapprovaleng', ['datas' => $data, '$dataapps' => $dataapps]);
            }
        }
    }

    public function srbrowse(Request $req) /* route : srbrowse   blade : service.servicereqbrowse */
    {

        $dataapps = DB::table('dept_mstr')
            ->leftjoin('service_req_mstr', 'service_req_mstr.sr_eng_approver', 'dept_mstr.dept_code')
            ->selectRaw('dept_mstr.*, service_req_mstr.*')
            ->get();


        $data = DB::table('service_req_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
            ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
            ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
            ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
            ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
            ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
            ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
            ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
            ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
            ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
            ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
            ->selectRaw('service_req_mstr.* ,
                asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_code, dept_mstr.dept_desc, users.username, users.name,
                wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11, wo_cancel_note,
                wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, eng_mstr.eng_dept, eng_mstr.eng_desc, wo_mstr.wo_list_engineer,
                sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
            ->orderBy('sr_req_date', 'DESC')
            ->orderBy('sr_number', 'DESC')
            ->groupBy('sr_number');
        // ->get();

        /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
        if (Session::get('role') <> 'ADMIN') {
            $data = $data->where('sr_dept', '=', session::get('department'));
        }

        /** Ditambahkan kondisi ini untuk link dari menu Notification */
        if($req->status) {
            $data = $data->where('sr_status','=','Revise');
        }

        $data = $data->paginate(10);
        // dd($data);

        $asset = DB::table('asset_mstr')
            ->leftJoin('asset_loc', 'asloc_code', '=', 'asset_loc')
            ->where('asset_active', '=', 'Yes')
            // ->where('asset_loc','=',session::get('department'))
            ->orderBy('asset_code')
            ->get();
        // dd($asset);
        $datadepart = DB::table('dept_mstr')
            ->get();

        $wotype = DB::table('wotyp_mstr')
            ->orderBy('wotyp_code')
            ->get();

        $impact = DB::table('imp_mstr')
            ->orderBy('imp_code')
            ->get();

        $fcode = DB::table('fn_mstr')
            ->orderBy('fn_code')
            ->get();

        $datasset = DB::table('asset_mstr')
            ->get();

        $datauser = DB::table('users')
            ->where('active', '=', 'Yes')
            ->get();

        $ceksrfile = DB::table(('service_req_upload'))
            ->get();

        $dataapp = DB::table('eng_mstr')
            ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'eng_mstr.eng_dept')
            ->selectRaw('dept_mstr.*,eng_mstr.*')
            ->where('eng_active', '=', 'Yes')
            ->where('approver', '=', 1)
            ->groupBy('eng_dept')
            ->orderBy('eng_code')
            ->get();

        return view('service.servicereqbrowse', [
            'datas' => $data, 'asset' => $datasset, 'fromhome' => '',
            'users' => $datauser, 'ceksrfile' => $ceksrfile, 'fcode' => $fcode,
            'wotype' => $wotype, 'impact' => $impact, 'dataapp' => $dataapp, 'dataapps' => $dataapps,
        ]);
    }

    public function srbrowseonly() /* route : srbrowse   blade : service.servicereqbrowse */
    {
        // $q = $req->srnumber;
        $dataapps = DB::table('dept_mstr')
            ->leftjoin('service_req_mstr', 'service_req_mstr.sr_eng_approver', 'dept_mstr.dept_code')
            ->selectRaw('dept_mstr.*, service_req_mstr.*')
            ->get();


        $data = DB::table('service_req_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
            ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
            ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
            ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
            ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
            ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
            ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
            ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
            ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
            ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
            ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
            ->selectRaw('service_req_mstr.* ,
                asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_code, dept_mstr.dept_desc, users.username, users.name,
                wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11, wo_cancel_note,
                wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, eng_mstr.eng_dept, eng_mstr.eng_desc, wo_mstr.wo_list_engineer,
                sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
            ->orderBy('sr_req_date', 'DESC')
            ->orderBy('sr_number', 'DESC')
            ->groupBy('sr_number');
        // ->get();

        /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
        // if (Session::get('role') <> 'ADMIN') {
        //     $data = $data->where('sr_dept', '=', session::get('department'));
        // }

        $data = $data->paginate(10);
        // dd($data);

        $asset = DB::table('asset_mstr')
            ->leftJoin('asset_loc', 'asloc_code', '=', 'asset_loc')
            ->where('asset_active', '=', 'Yes')
            // ->where('asset_loc','=',session::get('department'))
            ->orderBy('asset_code')
            ->get();
        // dd($asset);
        $datadepart = DB::table('dept_mstr')
            ->get();

        $wotype = DB::table('wotyp_mstr')
            ->orderBy('wotyp_code')
            ->get();

        $impact = DB::table('imp_mstr')
            ->orderBy('imp_code')
            ->get();

        $fcode = DB::table('fn_mstr')
            ->orderBy('fn_code')
            ->get();

        $datasset = DB::table('asset_mstr')
            ->get();

        $datauser = DB::table('users')
            ->where('active', '=', 'Yes')
            ->get();

        $ceksrfile = DB::table(('service_req_upload'))
            ->get();

        $dataapp = DB::table('eng_mstr')
            ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'eng_mstr.eng_dept')
            ->selectRaw('dept_mstr.*,eng_mstr.*')
            ->where('eng_active', '=', 'Yes')
            ->where('approver', '=', 1)
            ->groupBy('eng_dept')
            ->orderBy('eng_code')
            ->get();

        return view('service.servicereqbrowseonly', [
            'datas' => $data, 'asset' => $datasset, 'fromhome' => '',
            'users' => $datauser, 'ceksrfile' => $ceksrfile, 'fcode' => $fcode,
            'wotype' => $wotype, 'impact' => $impact, 'dataapp' => $dataapp, 'dataapps' => $dataapps,
        ]);
    }

    public function downloadfile($id)
    {
        // dd($id);
        $asset = DB::table('service_req_upload')
            ->where('id', '=', $id)
            ->first();

        if ($asset) {

            $lastindex = strrpos($asset->filepath, "/");
            $filename = substr($asset->filepath, $lastindex + 1);

            return Response::download($asset->filepath, $filename);
        } else {
            toast('There is no file', 'error');
            return back();
        }
    }

    public function downloadfilezip(Request $req, $sr)
    {
        $zip = new ZipArchive;

        $srnumber = DB::table('service_req_mstr')
            ->where('sr_number', '=', $sr)
            ->first();

        $listdownload = DB::table('service_req_upload')
            ->where('sr_number', '=', $srnumber->sr_number)
            ->get();
        // dd($listdownload);

        /* A211103 */
        // $listfinish = DB::table('acceptance_image')
        //     ->whereFile_wonumber($sr)
        //     ->get();

        $fileName = $sr . '.zip';

        try {

            if (count($listdownload) > 0) {
                if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                    foreach ($listdownload as $listdown) {
                        $files = File::get($listdown->filepath);
                        $relativeNameInZipFile = basename($listdown->filepath);
                        $zip->addFile($listdown->filepath, $relativeNameInZipFile);
                        // dd($listdown->filepath);
                    }

                    /* A211103 */
                    // foreach ($listfinish as $listfinish) {
                    //     $files = File::get($listfinish->file_url);
                    //     $relativeNameInZipFile = basename($listfinish->file_url);
                    //     $zip->addFile($listfinish->file_url, $relativeNameInZipFile);
                    // }

                    $zip->close();
                }

                return response()->download(public_path($fileName));
            } else {
                toast('Tidak ada dokumen untuk pada SR ' . $sr . '!', 'error');
                return back();
            }
        } catch (FileNotFoundException $e) {
            // dd($e);
            abort('404');
        }
    }

    public function listupload($id)
    {
        // dd($id);

        $data = DB::table('service_req_upload')
            ->where('sr_number', $id)
            ->get();
        // dd($data);

        $output = '';
        foreach ($data as $data) {

            $lastindex = strrpos($data->filepath, "/");
            $filename = substr($data->filepath, $lastindex + 1);


            $output .=  '<tr>
                            <td> 
                            <a href="/' . $data->filepath . '" target="_blank">' . $filename . '</a> 
                            </td>
                            <td>
                            <a href="#" class="btn deleterow btn-danger">
                            <i class="icon-table fa fa-trash fa-lg"></i>
                            </a>
                            <input type="hidden" value="' . $data->id . '" class="rowval"/>
                            </td>
                            <input type="hidden" value="' . $data->id . '" class="rowval"/>
                        </tr>';
        }

        return response($output);
    }

    public function listuploadview($id)
    {
        // dd($id);

        $data = DB::table('service_req_upload')
            ->where('sr_number', $id)
            ->get();

        $output = '';
        foreach ($data as $data) {

            $lastindex = strrpos($data->filepath, "/");
            $filename = substr($data->filepath, $lastindex + 1);


            $output .=  '<tr>
                            <td> 
                            <a href="/' . $data->filepath . '" target="_blank">' . $filename . '</a> 
                            </td>
                            <input type="hidden" value="' . $data->id . '" class="rowval"/>
                        </tr>';
        }

        return response($output);
    }

    public function deleteuploadsr($id)
    {
        $data = DB::table('service_req_upload')
            ->where('id', $id)
            ->first();

        if ($data) {
            $lastindex = strrpos($data->filepath, "/");
            $filename = substr($data->filepath, $lastindex + 1);

            $filename = public_path('/uploadasset/' . $filename);

            if (File::exists($filename)) {
                File::delete($filename);

                DB::table('service_req_upload')
                    ->where('id', $id)
                    ->delete();
            }
        }

        $data = DB::table('service_req_upload')
            ->where('sr_number', $data->sr_number)
            ->get();

        $output = '';
        foreach ($data as $data) {

            $lastindex = strrpos($data->filepath, "/");
            $filename = substr($data->filepath, $lastindex + 1);


            $output .=  '<tr>
                            <td> 
                            <a href="/' . $data->id . '" target="_blank">' . $filename . '</a> 
                            </td>
                            <td>
                            <a href="#" class="btn deleterow btn-danger">
                            <i class="icon-table fa fa-trash fa-lg"></i>
                            </a>
                            <input type="hidden" value="' . $data->id . '" class="rowval"/>
                            </td>
                        </tr>';
        }

        return response($output);
    }

    //tyas, link dari Home
    public function srbrowseopen()
    {
        $data = DB::table('service_req_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
            ->join('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
            ->join('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
            ->join('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
            ->join('users', 'users.name', 'service_req_mstr.req_by')
            ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
            ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
            ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
            ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
            ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
            ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
            ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
            ->leftJoin('fn_mstr as k1', 'service_req_mstr.sr_failurecode1', 'k1.fn_code')
            ->leftJoin('fn_mstr as k2', 'service_req_mstr.sr_failurecode2', 'k2.fn_code')
            ->leftJoin('fn_mstr as k3', 'service_req_mstr.sr_failurecode3', 'k3.fn_code')
            ->selectRaw('service_req_mstr.* , asset_mstr.asset_desc, dept_mstr.dept_desc, users.username, wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.eng_desc as u11, u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, wo_mstr.wo_start_date,
                    wo_mstr.wo_finish_date, wo_mstr.wo_action, wo_mstr.wo_status,
                    k1.fn_desc as k11, k2.fn_desc as k22, k3.fn_desc as k33')
            ->where('sr_status', '=', '1')
            ->orderBy('sr_number', 'DESC')
            ->paginate(10);

        dd($data);

        $datasset = DB::table('asset_mstr')
            ->get();

        $datauser = DB::table('users')
            ->where('active', '=', 'Yes')
            ->get();

        return view('service.servicereqbrowse', ['datas' => $data, 'asset' => $datasset, 'fromhome' => 'open', 'users' => $datauser]);
    }

    public function searchsr(Request $req)
    {
        if ($req->ajax()) {
            $srnumber = '';
            $asset = '';
            $status = '';
            $requestby = '';
            $datefrom = '2000-01-01';
            $dateto = '3000-01-01';

            $searchfilter = $req->searchfilter;
            $operandfilter = $req->operandfilter;
            $valuefilter = $req->valuefilter;

            foreach($searchfilter as $key => $searching){
                if($searching == 's_servicenbr'){
                    $srnumber = $valuefilter[$key];
                }
                if($searching == 's_asset'){
                    $asset = $valuefilter[$key];
                }
                if($searching == 's_user'){
                    $requestby = $valuefilter[$key];
                }
                if($searching == 's_status'){
                    $status = $valuefilter[$key];
                }
                if($searching == 's_datefrom'){
                    $datefrom = $valuefilter[$key];
                }
                if($searching == 's_dateto'){
                    $dateto = $valuefilter[$key];
                }
            }


            // $srnumber = $req->get('srnumber');
            // $asset = $req->get('asset');
            // $status = $req->get('status');
            // $requestby = $req->get('requestby');
            // $datefrom = $req->get('datefrom') == '' ? '2000-01-01' : date($req->get('datefrom'));
            // $dateto = $req->get('dateto') == '' ? '3000-01-01' : date($req->get('dateto'));

            // dd($datefrom, $dateto);

            $ceksrfile = DB::table(('service_req_upload'))
                ->get();

            $cekdate = DB::table(('service_req_mstr'))->where('id', '>', 0)->whereBetween('sr_req_date', [$datefrom, $dateto])
                ->get();
            // dd($requestby);

            if ($srnumber == "" && $asset == "" /*&& $priority == ""*/  /*&& $period == "" */ && $status == "" && $requestby == "" && $datefrom == "2000-01-01" && $dateto == "3000-01-01") {

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                    ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
                    ->selectRaw('service_req_mstr.* ,
                    asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_code, dept_mstr.dept_desc, users.username, users.name,
                    wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11,wo_cancel_note,
                    wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, eng_mstr.eng_dept, eng_mstr.eng_desc, wo_mstr.wo_list_engineer,
                    sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
                    ->orderBy('sr_req_date', 'DESC')
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');
                // ->get();

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data->where('sr_dept', '=', session::get('department'));
                }

                $data = $data->paginate(10);

                // dd($data);

                return view('service.table-srbrowse', ['datas' => $data, 'ceksrfile' => $ceksrfile]);
            } else {
                // dd("test2");
                $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
                $limahari = Carbon::now()->subDays(5)->toDateTimeString();

                $kondisi = "service_req_mstr.id > 0";


                // dd($tigahari,$limahari);

                // if($period == 1){
                //     $kondisi = "sr_created_at > '".$tigahari."'";
                // }else if($period == 2){
                //     $kondisi = "sr_created_at BETWEEN '".$tigahari."' AND '".$limahari."'";
                // }else if($period == 3){
                //     $kondisi = "sr_created_at < '".$limahari."'";
                // }else if($period == ""){
                //     $kondisi = "sr_created_at > 01-01-1900";
                // }

                if ($srnumber != '') {
                    $kondisi .= " AND sr_number LIKE '%" . $srnumber . "%'";
                    // dd($var);
                }
                if ($asset != '') {
                    $kondisi .= " AND asset_desc LIKE '%" . $asset . "%'";
                }
                if ($status != '') {
                    $kondisi .= " AND sr_status = '" . $status . "' ";
                }
                // if ($priority != '') {
                //     $kondisi .= " AND sr_priority = '" . $priority . "'";
                // }
                if ($requestby != '') {
                    $kondisi .= " AND sr_req_by = '" . $requestby . "' ";
                }

                if ($datefrom != '' || $dateto != '') {
                    $kondisi .= " AND sr_req_date BETWEEN '" . $datefrom . "' AND '" . $dateto . "'";
                }

                $dataapps = DB::table('service_req_mstr')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_eng_approver')
                    ->selectRaw('dept_mstr.*')
                    ->where('sr_dept', '=', session::get('department'))
                    ->first();

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                    ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
                    ->selectRaw('service_req_mstr.* ,
                asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_desc, users.username, users.name,
                wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11,
                wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, wo_mstr.wo_list_engineer, eng_mstr.eng_dept, wo_cancel_note,
                sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
                    ->whereRaw($kondisi)
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data->where('sr_dept', '=', session::get('department'));
                }

                $data = $data->paginate(10);
                // dd($data);

                return view('service.table-srbrowse', ['datas' => $data, 'ceksrfile' => $ceksrfile, 'dataapps' => $dataapps]);
            }
        }
    }

    public function searchbrowseonly(Request $req)
    {
        if ($req->ajax()) {
            $srnumber = $req->get('srnumber');
            $asset = $req->get('asset');
            $status = $req->get('status');
            $requestby = $req->get('requestby');
            $datefrom = $req->get('datefrom') == '' ? '2000-01-01' : date($req->get('datefrom'));
            $dateto = $req->get('dateto') == '' ? '3000-01-01' : date($req->get('dateto'));

            // dd($datefrom, $dateto);

            $ceksrfile = DB::table(('service_req_upload'))
                ->get();

            $cekdate = DB::table(('service_req_mstr'))->where('id', '>', 0)->whereBetween('sr_req_date', [$datefrom, $dateto])
                ->get();
            // dd($requestby);

            if ($srnumber == "" && $asset == "" /*&& $priority == ""*/  /*&& $period == "" */ && $status == "" && $requestby == "" && $datefrom == "2000-01-01" && $dateto == "3000-01-01") {

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                    ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
                    ->selectRaw('service_req_mstr.* ,
                    asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_code, dept_mstr.dept_desc, users.username, users.name,
                    wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11,wo_cancel_note,
                    wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, eng_mstr.eng_dept, eng_mstr.eng_desc, wo_mstr.wo_list_engineer,
                    sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
                    ->orderBy('sr_req_date', 'DESC')
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');
                // ->get();

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                // if (Session::get('role') <> 'ADMIN') {
                //     $data = $data->where('sr_dept', '=', session::get('department'));
                // }

                $data = $data->paginate(10);

                // dd($data);

                return view('service.table-srbrowseonly', ['datas' => $data, 'ceksrfile' => $ceksrfile]);
            } else {
                // dd("test2");
                $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
                $limahari = Carbon::now()->subDays(5)->toDateTimeString();

                $kondisi = "service_req_mstr.id > 0";


                // dd($tigahari,$limahari);

                // if($period == 1){
                //     $kondisi = "sr_created_at > '".$tigahari."'";
                // }else if($period == 2){
                //     $kondisi = "sr_created_at BETWEEN '".$tigahari."' AND '".$limahari."'";
                // }else if($period == 3){
                //     $kondisi = "sr_created_at < '".$limahari."'";
                // }else if($period == ""){
                //     $kondisi = "sr_created_at > 01-01-1900";
                // }

                if ($srnumber != '') {
                    $kondisi .= " AND sr_number LIKE '%" . $srnumber . "%'";
                    // dd($var);
                }
                if ($asset != '') {
                    $kondisi .= " AND asset_desc LIKE '%" . $asset . "%'";
                }
                if ($status != '') {
                    $kondisi .= " AND sr_status = '" . $status . "' ";
                }
                // if ($priority != '') {
                //     $kondisi .= " AND sr_priority = '" . $priority . "'";
                // }
                if ($requestby != '') {
                    $kondisi .= " AND sr_req_by = '" . $requestby . "' ";
                }

                if ($datefrom != '' || $dateto != '') {
                    $kondisi .= " AND sr_req_date BETWEEN '" . $datefrom . "' AND '" . $dateto . "'";
                }

                $dataapps = DB::table('service_req_mstr')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_eng_approver')
                    ->selectRaw('dept_mstr.*')
                    ->where('sr_dept', '=', session::get('department'))
                    ->first();

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                    ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
                    ->selectRaw('service_req_mstr.* ,
                asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_desc, users.username, users.name,
                wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11,
                wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, wo_mstr.wo_list_engineer, eng_mstr.eng_dept, wo_cancel_note,
                sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
                    ->whereRaw($kondisi)
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                // if (Session::get('role') <> 'ADMIN') {
                //     $data = $data->where('sr_dept', '=', session::get('department'));
                // }

                $data = $data->paginate(10);
                // dd($data);

                return view('service.table-srbrowseonly', ['datas' => $data, 'ceksrfile' => $ceksrfile, 'dataapps' => $dataapps]);
            }
        }
    }

    public function searchimpact(Request $req)
    {
        // dd($req->all());
        if ($req->ajax()) {
            $impact = $req->impact;
            // dd($impact);
            if ($impact != '') {
                $array_impact = explode(',', $impact);

                $countarray = count($array_impact);

                $desc = "";

                for ($i = 0; $i < $countarray; $i++) {

                    $impactdesc = DB::table('imp_mstr')
                        ->where('imp_code', '=', $array_impact[$i])
                        ->selectRaw('imp_desc')
                        ->first();

                    $desc .= $impactdesc->imp_desc . ',';
                }

                $desc = substr($desc, 0, strlen($desc) - 1);

                return response()->json($desc);
            } else {
                $desc = '';
                return response()->json($desc);
            }
        }
    }

    public function searchfailtype(Request $req)
    {
        if ($req->ajax()) {
            $failtype = $req->failtype;
            if ($failtype != '') {
                $data = "";

                $wotype = DB::table('wotyp_mstr')
                    ->where('wotyp_code', '=', $failtype)
                    ->selectRaw('wotyp_desc')
                    ->first();


                $data = $wotype->wotyp_desc;

                return response()->json($data);
            } else {
                $data = '';

                return response()->json($data);
            }
        }
    }

    public function searchfailcode(Request $req)
    {
        if ($req->ajax()) {
            $failcode = $req->failcode;

            if ($failcode != '') {
                $array_failcode = explode(',', $failcode);

                $countarray = count($array_failcode);
                // dd($countarray);
                $desc = "";

                for ($i = 0; $i < $countarray; $i++) {

                    $failcodedesc = DB::table('fn_mstr')
                        ->where('fn_code', '=', $array_failcode[$i])
                        ->selectRaw('fn_desc')
                        ->first();


                    $desc .= $failcodedesc->fn_desc . ',';
                }


                $desc = substr($desc, 0, strlen($desc) - 1);

                return response()->json($desc);
            } else {
                $desc = '';

                return response()->json($desc);
            }
        }
    }

    public function useracceptance(Request $req)
    {
        $data = DB::table('service_req_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
            ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
            ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
            ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
            ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
            ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
            ->leftjoin('wo_mstr', 'wo_mstr.wo_sr_number', 'service_req_mstr.sr_number')
            ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
            ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
            ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
            ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
            ->selectRaw('service_req_mstr.* ,
                asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_code, dept_mstr.dept_desc, users.username, users.name,
                wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11, wo_report_note,
                wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, eng_mstr.eng_dept, eng_mstr.eng_desc, wo_mstr.wo_list_engineer,
                sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
            ->where('wo_status', 'acceptance')
            ->orderBy('sr_req_date', 'DESC')
            ->orderBy('sr_number', 'DESC')
            ->groupBy('sr_number');
        // ->get();

        /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
        if (Session::get('role') <> 'ADMIN') {
            $data = $data->where('sr_dept', '=', session::get('department'));
        }

        $data = $data->paginate(10);

        $datasset = DB::table('asset_mstr')
            ->get();
        // dd($data);

        return view('service.useracceptance', ['dataua' => $data, 'asset' => $datasset]);
    }

    public function searchuseracc(Request $req)
    {
        if ($req->ajax()) {
            $srnumber = $req->get('srnumber');
            $wonumber = $req->get('wonumber');
            $asset = $req->get('asset');
            $status = $req->get('status');
            $datefrom = $req->get('datefrom_') == '' ? '2000-01-01' : date($req->get('datefrom_'));
            $dateto = $req->get('dateto') == '' ? '3000-01-01' : date($req->get('dateto'));

            // dd($req->all());

            $ceksrfile = DB::table(('service_req_upload'))
                ->get();

            $cekdate = DB::table(('service_req_mstr'))->where('id', '>', 0)->whereBetween('sr_req_date', [$datefrom, $dateto])
                ->get();
            // dd($requestby);

            if ($srnumber == "" && $wonumber == "" && $asset == "" && $status == "" && $datefrom == "2000-01-01" && $dateto == "3000-01-01") {

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_sr_number', 'service_req_mstr.sr_number')
                    ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
                    ->selectRaw('service_req_mstr.* ,
                asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_code, dept_mstr.dept_desc, users.username, users.name,
                wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11, wo_report_note,
                wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, eng_mstr.eng_dept, eng_mstr.eng_desc, wo_mstr.wo_list_engineer,
                sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
                    ->where('wo_status', 'acceptance')
                    ->orderBy('sr_req_date', 'DESC')
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');
                // ->get();

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data->where('sr_dept', '=', session::get('department'));
                }

                $data = $data->paginate(10);

                // dd($data);

                return view('service.table-ua', ['dataua' => $data]);
            } else {
                // dd("test2");
                $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
                $limahari = Carbon::now()->subDays(5)->toDateTimeString();

                $kondisi = "service_req_mstr.id > 0";


                // dd($tigahari,$limahari);

                // if($period == 1){
                //     $kondisi = "sr_created_at > '".$tigahari."'";
                // }else if($period == 2){
                //     $kondisi = "sr_created_at BETWEEN '".$tigahari."' AND '".$limahari."'";
                // }else if($period == 3){
                //     $kondisi = "sr_created_at < '".$limahari."'";
                // }else if($period == ""){
                //     $kondisi = "sr_created_at > 01-01-1900";
                // }

                if ($srnumber != '') {
                    $kondisi .= " AND sr_number LIKE '%" . $srnumber . "%'";
                }
                if ($wonumber != '') {
                    $kondisi .= " AND service_req_mstr.wo_number LIKE '%" . $wonumber . "%'";
                }
                if ($asset != '') {
                    $kondisi .= " AND (asset_code LIKE '%" . $asset . "%' OR asset_desc LIKE '%" . $asset . "%')";
                }
                if ($status != '') {
                    $kondisi .= " AND sr_status_approval = '" . $status . "' ";
                }

                if ($datefrom != '' || $dateto != '') {
                    $kondisi .= " AND sr_req_date BETWEEN '" . $datefrom . "' AND '" . $dateto . "'";
                }

                $dataapps = DB::table('service_req_mstr')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_eng_approver')
                    ->selectRaw('dept_mstr.*')
                    ->where('sr_dept', '=', session::get('department'))
                    ->first();

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_sr_number', 'service_req_mstr.sr_number')
                    ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
                    ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
                    ->selectRaw('service_req_mstr.* ,
                        asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_code, dept_mstr.dept_desc, users.username, users.name,
                        wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11, wo_report_note,
                        wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, eng_mstr.eng_dept, eng_mstr.eng_desc, wo_mstr.wo_list_engineer,
                        sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
                    ->where('wo_status', 'acceptance')
                    ->whereRaw($kondisi)
                    ->orderBy('sr_req_date', 'DESC')
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data->where('sr_dept', '=', session::get('department'));
                }

                $data = $data->paginate(10);
                // dd($data);

                return view('service.table-ua', ['dataua' => $data]);
            }
        }
    }

    public function acceptance(Request $req)
    {
        // dd($req->all());
        $srnumber = $req->srnumber;
        $wonumber = $req->wonumber;
        $acceptance = $req->sracceptance;

        $srmstr = DB::table('service_req_mstr')
            ->join('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
            ->join('asset_mstr', 'asset_mstr.asset_code', '=', 'service_req_mstr.sr_asset')
            ->where('sr_number', $srnumber)->first();

        $asset = $srmstr->asset_code . ' -- ' . $srmstr->asset_desc;
        $requestor = $srmstr->wo_list_engineer;
        // dd($srmstr);

        switch ($req->input('action')) {
            case 'complete':
                //dd('lg maintenance');
                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->update([
                        'sr_status' => 'Closed',
                        'sr_status_approval' => 'acceptance approved',
                        'sr_acceptance_note' => $acceptance,
                        'updated_at' => Carbon::now()->toDateTimeString(),  //   C211014
                    ]);

                DB::table('service_req_mstr_hist')
                    ->insert([
                        'sr_number' => $srnumber,
                        'wo_number' => $wonumber,
                        'sr_dept' => $srmstr->sr_dept,
                        'sr_asset' => $srmstr->sr_asset,
                        'sr_eng_approver' => $srmstr->sr_eng_approver,
                        'sr_note' => $srmstr->sr_note,
                        'sr_status' => 'Closed',
                        'sr_status_approval' => $srmstr->sr_status_approval,
                        'sr_req_by' => $srmstr->sr_req_by,
                        'sr_req_date' => $srmstr->sr_req_date,
                        'sr_req_time' => $srmstr->sr_req_time,
                        'sr_fail_type' => $srmstr->sr_fail_type,
                        'sr_fail_code' => $srmstr->sr_fail_code,
                        'sr_impact' => $srmstr->sr_impact,
                        'sr_priority' => $srmstr->sr_priority,
                        'sr_acceptance_note' => $acceptance,
                        'sr_action' => 'SR Closed',
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);

                DB::table('wo_mstr')
                    ->where('wo_number', '=', $wonumber)
                    ->update([
                        'wo_status' => 'closed',
                        'wo_system_update' => Carbon::now()->toDateTimeString(),
                    ]);

                DB::table('wo_trans_history')
                    ->insert([
                        'wo_number' => $wonumber,
                        'wo_action' => 'closed',
                        'system_update' => Carbon::now()->toDateTimeString(),
                    ]);

                toast('Service Request ' . $srnumber . ' Closed ! ', 'success');
                return back();

                break;

            case 'incomplete':
                // dd('sampi sini jalan');
                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->update([
                        'sr_status' => 'Inprocess',
                        'sr_status_approval' => 'acceptance revision',
                        'sr_acceptance_note' => $acceptance,
                        'updated_at' => Carbon::now()->toDateTimeString(),  //   C211014
                    ]);

                DB::table('service_req_mstr_hist')
                    ->insert([
                        'sr_number' => $srnumber,
                        'wo_number' => $wonumber,
                        'sr_dept' => $srmstr->sr_dept,
                        'sr_asset' => $srmstr->sr_asset,
                        'sr_eng_approver' => $srmstr->sr_eng_approver,
                        'sr_note' => $srmstr->sr_note,
                        'sr_status' => 'Inprocess',
                        'sr_status_approval' => $srmstr->sr_status_approval,
                        'sr_req_by' => $srmstr->sr_req_by,
                        'sr_req_date' => $srmstr->sr_req_date,
                        'sr_req_time' => $srmstr->sr_req_time,
                        'sr_fail_type' => $srmstr->sr_fail_type,
                        'sr_fail_code' => $srmstr->sr_fail_code,
                        'sr_impact' => $srmstr->sr_impact,
                        'sr_priority' => $srmstr->sr_priority,
                        'sr_acceptance_note' => $acceptance,
                        'sr_action' => 'User Acceptance wants SR to be rechecked',
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);

                DB::table('wo_mstr')
                    ->where('wo_number', '=', $wonumber)
                    ->update([
                        'wo_status' => 'started',
                        'wo_system_update' => Carbon::now()->toDateTimeString(),
                    ]);

                DB::table('wo_trans_history')
                    ->insert([
                        'wo_number' => $wonumber,
                        'wo_action' => 'started again (from user acceptance)',
                        'system_update' => Carbon::now()->toDateTimeString(),
                    ]);

                //email terikirm ke engineer yg mengerjakan wo
                EmailScheduleJobs::dispatch('', $asset, '13', '', $requestor, $wonumber, '');

                toast('Service Request ' . $srnumber . ' will be re-checked !', 'success');
                return back();
                //return redirect()->route('srcreate');
                break;
        }
    }

    public function imageview(Request $req)
    {
        //dd($req->all());
        $wonumber = $req->wonumber;

        $gambar = DB::table('wo_report_upload')
            ->where('woreport_wonbr', '=', $wonumber)
            ->get();

        $output = "";
        foreach ($gambar as $gambar) {
            $output .= '<tr>
                    <td><a href="#" class="btn deleterow btn-danger"><i class="icon-table fa fa-trash fa-lg"></i></a>
                    &nbsp
                    <input type="hidden" value="' . $gambar->id . '" class="rowval"/>
                    <td><a href="/' . $gambar->woreport_wonbr_filepath . '" target="_blank">' . $gambar->woreport_filename . '</a></td>
                </tr>';
        }

        //return response()->json($gambar);
        return response($output);
    }

    public function useracceptancesearch(Request $req)
    {
        if ($req->ajax()) {
            $srnumber = $req->get('srnumber');
            $asset = $req->get('asset');
            $priority = $req->get('priority');
            // $period = $req->get('period');

            if ($srnumber == "" && $asset == "" && $priority == "") {

                if (Session::get('role') == 'ADM') {
                    // dd('aaaadmin');
                    $datas = DB::table('service_req_mstr')
                        ->join('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                        ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                        ->where('wo_status', '=', 'completed')
                        ->where('sr_status', '=', 4)
                        ->selectRaw('service_req_mstr.* , wo_mstr.*, asset_mstr.asset_desc, asset_mstr.asset_code, dept_mstr.*')
                        ->orderBy('sr_updated_at', 'DESC')
                        // ->where('sr_req_by', '=', Session::get('username'))
                        ->paginate(10);

                    $datasset = DB::table('asset_mstr')
                        ->get();
                } else {
                    $datas = DB::table('service_req_mstr')
                        ->join('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                        ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                        ->where('wo_status', '=', 'completed')
                        ->where('sr_status', '=', 4)
                        ->where('sr_req_by', '=', Session::get('username'))
                        ->selectRaw('service_req_mstr.* , wo_mstr.*, asset_mstr.asset_desc, asset_mstr.asset_code, dept_mstr.*')
                        ->orderBy('sr_updated_at', 'DESC')
                        ->paginate(10);

                    $datasset = DB::table('asset_mstr')
                        ->get();
                }

                return view('service.table-ua', ['dataua' => $datas]);
            } else {
                // $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
                // $limahari = Carbon::now()->subDays(5)->toDateTimeString();


                // dd($tigahari,$limahari);

                $kondisi = "sr_created_at > 01-01-1900";

                if ($srnumber != '') {
                    $kondisi .= " AND sr_number LIKE '%" . $srnumber . "%'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_desc like '%" . $asset . "%'";
                }
                if ($priority != '') {
                    $kondisi .= " and sr_priority = '" . $priority . "'";
                }

                // dd($kondisi);

                if (Session::get('role') == 'ADM') {
                    $datas = DB::table('service_req_mstr')
                        ->join('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                        ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                        ->where('wo_status', '=', 'completed')
                        ->where('sr_status', '=', 4)
                        ->whereRaw($kondisi)
                        ->selectRaw('service_req_mstr.* , wo_mstr.*, asset_mstr.asset_desc, asset_mstr.asset_code, dept_mstr.*')
                        ->orderBy('sr_updated_at', 'DESC')
                        // ->where('sr_req_by', '=', Session::get('username'))
                        ->paginate(10);

                    $datasset = DB::table('asset_mstr')
                        ->get();
                } else {
                    $datas = DB::table('service_req_mstr')
                        ->join('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                        ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                        ->where('wo_status', '=', 'completed')
                        ->where('sr_status', '=', 4)
                        ->where('sr_req_by', '=', Session::get('username'))
                        ->whereRaw($kondisi)
                        ->selectRaw('service_req_mstr.* , wo_mstr.*, asset_mstr.asset_desc, asset_mstr.asset_code, dept_mstr.*')
                        ->orderBy('sr_updated_at', 'DESC')
                        ->paginate(10);

                    $datasset = DB::table('asset_mstr')
                        ->get();
                }

                return view('service.table-ua', ['dataua' => $datas]);
            }
        }
    }

    public function donlodsr(Request $req)
    { /* blade : servicereqbrowse */
        $srnbr    = '';
        $asset    = '';
        $status   = '';
        $reqby    = '';
        $datefrom = '';
        $dateto   = '';

        $searchfilter = explode(',',$req->searchfilter);
        $operandfilter = explode(',',$req->operandfilter);
        $valuefilter = explode(',',$req->valuefilter);
        
        foreach($searchfilter as $key => $searching){
            if($searching == 's_servicenbr'){
                $srnbr = $valuefilter[$key];
            }
            if($searching == 's_asset'){
                $asset = $valuefilter[$key];
            }
            if($searching == 's_user'){
                $reqby = $valuefilter[$key];
            }
            if($searching == 's_status'){
                $status = $valuefilter[$key];
            }
            if($searching == 's_datefrom'){
                $datefrom = $valuefilter[$key];
            }
            if($searching == 's_dateto'){
                $dateto = $valuefilter[$key];
            }
        }

        return Excel::download(new ExportSR($srnbr, $status, $asset, $reqby, $datefrom, $dateto), 'Service Request.xlsx');
    }

    public function donlodsrbrowse(Request $req)
    { /* blade : servicereqbrowseonly */
        $srnbr    = $req->srnumber;
        $asset    = $req->asset;
        $status   = $req->status;
        $reqby    = $req->reqby;
        $datefrom = $req->datefrom;
        $dateto   = $req->dateto;

        // dd($srnbr,$asset,$status,$reqby,$datefrom,$dateto);

        return Excel::download(new ExportSRBrowse($srnbr, $status, $asset, $reqby, $datefrom, $dateto), 'Service Request.xlsx');
    }

    public function getsrdetail(Request $req)
    {
        dd($req->all());
        $nosr = $req->get('srnumber');
        $currwo = DB::table('wo_mstr')
            ->where('wo_mstr.wo_number', '=', $nowo)
            ->first();

        dd($nosr);

        // check apakah wo berasal dari SR
        // variable tampung sr note
        $srnote = '';
        $rejectreason = '';
        if ($currwo->wo_sr_number != "") {
            $getSRInfo = DB::table('service_req_mstr')
                ->where('sr_number', '=', $currwo->wo_sr_number)
                ->first();

            $srnote = $getSRInfo->sr_note;
            $rejectreason = $getSRInfo->sr_acceptance_note;
        }

        if ($currwo->wo_failure_type !== null) {
            $getFailTypeDesc = DB::table('wotyp_mstr')
                ->select('wotyp_desc')
                ->where('wotyp_code', '=', $currwo->wo_failure_type)
                ->first();
        } else {
            $getFailTypeDesc = '';
        }


        if ($currwo->wo_asset_code !== null) {
            $getAssetDesc = DB::table('asset_mstr')
                ->select('asset_desc', 'asset_loc', 'asset_group', 'asloc_desc')
                ->join('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                ->where('asset_code', '=', $currwo->wo_asset_code)
                ->first();
        } else {
            $getAssetDesc = '';
        }



        $listFailDesc = [];

        if ($currwo->wo_failure_code !== null) {
            $listFailCode = explode(';', $currwo->wo_failure_code);



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

        $listEngDesc = [];

        if ($currwo->wo_list_engineer !== null) {
            $listEngCode = explode(';', $currwo->wo_list_engineer);

            foreach ($listEngCode as $engcode) {
                $getEngDesc = DB::table('eng_mstr')
                    ->select('eng_desc')
                    ->where('eng_code', '=', $engcode)
                    ->first();

                $eng = array('eng_code' => $engcode, 'eng_desc' => $getEngDesc->eng_desc);

                array_push($listEngDesc, $eng);
            }
        }

        $listImpactDesc = [];

        if ($currwo->wo_impact_code !== null) {
            $listImpactCode = explode(';', $currwo->wo_impact_code);

            foreach ($listImpactCode as $impactcode) {
                $getImpactDesc = DB::table('imp_mstr')
                    ->select('imp_desc')
                    ->where('imp_code', '=', $impactcode)
                    ->first();

                $impact = array('imp_code' => $impactcode, 'imp_desc' => $getImpactDesc->imp_desc);

                array_push($listImpactDesc, $impact);
            }
        } else {
            $getImpactDesc = '';
        }

        $getMtDesc = DB::table('pmc_mstr')
            ->select('pmc_code', 'pmc_desc')
            ->where('pmc_code', '=', $currwo->wo_mt_code)
            ->first();

        $getInslistDesc = DB::table('ins_list')
            ->select('ins_code', 'ins_desc')
            ->where('ins_code', '=', $currwo->wo_ins_code)
            ->first();

        $getSPlistDesc = DB::table('spg_list')
            ->select('spg_code', 'spg_desc')
            ->where('spg_code', '=', $currwo->wo_sp_code)
            ->first();

        $getQClistDesc = DB::table('qcs_list')
            ->select('qcs_code', 'qcs_desc')
            ->where('qcs_code', '=', $currwo->wo_qcspec_code)
            ->first();

        $getDeptDesc = DB::table('dept_mstr')
            ->select('dept_code', 'dept_desc')
            ->where('dept_code', '=', $currwo->wo_department)
            ->first();

        return response()->json([
            'wo_master' => $currwo,
            'asset' => $getAssetDesc,
            'failure_type' => $getFailTypeDesc,
            'failurecode' => $listFailDesc,
            'engineer' => $listEngDesc,
            'impact' => $listImpactDesc,
            'mtcode' => $getMtDesc,
            'inslist' => $getInslistDesc,
            'splist' => $getSPlistDesc,
            'qcslist' => $getQClistDesc,
            'sr_note' => $srnote,
            'dept_desc' => $getDeptDesc,
            'sr_acceptance_note' => $rejectreason,
        ]);
    }

    public function srprint(Request $req, $sr)
    {
        // dd($wo);
        $repair = [];
        $countdb = [];
        $checkstr = [];
        $statusrepair = DB::table('service_req_mstr')
            ->where('service_req_mstr.sr_number', '=', $sr)
            ->first();
        $srmstr = DB::table('service_req_mstr')
            ->where('sr_number', '=', $sr)
            ->selectRaw('"" as fn1, "" as fn2, "" as fn3, dept_desc, eng_desc, sr_number, sr_fail_type, sr_dept, sr_eng_approver,
            sr_req_date, sr_asset, asset_desc, sr_req_by, "" as sr_approver, sr_impact, imp_desc, sr_req_date, sr_req_time, asset_desc, wotyp_desc, sr_fail_code,
            sr_note, imp_code, "" as dept_user, sr_req_by, service_req_mstr.wo_number, wo_due_date, wo_start_date')
            ->leftjoin('eng_mstr', 'service_req_mstr.sr_req_by', 'eng_mstr.eng_code')
            ->leftJoin('dept_mstr', 'service_req_mstr.sr_dept', 'dept_mstr.dept_code')
            ->leftJoin('asset_mstr', 'service_req_mstr.sr_asset', 'asset_mstr.asset_code')
            // ->leftJoin('fn_mstr as fn1', 'service_req_mstr.sr_failurecode1', 'fn1.fn_code')
            // ->leftJoin('fn_mstr as fn2', 'service_req_mstr.sr_failurecode2', 'fn2.fn_code')
            // ->leftJoin('fn_mstr as fn3', 'service_req_mstr.sr_failurecode3', 'fn3.fn_code')
            ->leftJoin('wotyp_mstr', 'service_req_mstr.sr_fail_type', 'wotyp_mstr.wotyp_code')
            ->leftJoin('wo_mstr', 'service_req_mstr.sr_number', 'wo_mstr.wo_sr_number')
            ->leftJoin('imp_mstr', 'service_req_mstr.sr_impact', 'imp_mstr.imp_code')
            // ->leftJoin('users', 'service_req_mstr.sr_approver', 'users.username')
            ->first();

        $engapprover = DB::table('service_req_mstr')
            ->where('sr_number', '=', $sr)
            ->leftJoin('dept_mstr', 'service_req_mstr.sr_eng_approver', 'dept_mstr.dept_code')
            ->first();

        $listFailDesc = [];

        if ($srmstr->sr_fail_code !== '') {
            $listFailCode = explode(',', $srmstr->sr_fail_code);

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

        $listImpactDesc = [];

        if ($srmstr->sr_impact !== '') {
            $listImpactCode = explode(',', $srmstr->sr_impact);

            foreach ($listImpactCode as $impactcode) {
                $getImpactDesc = DB::table('imp_mstr')
                    ->select('imp_desc')
                    ->where('imp_code', '=', $impactcode)
                    ->first();

                $impact = array('imp_code' => $impactcode, 'imp_desc' => $getImpactDesc->imp_desc);

                array_push($listImpactDesc, $impact);
            }
        } else {
            $getImpactDesc = '';
        }

        $dept = DB::table(('dept_mstr'))
            ->get();

        $womstr = DB::table('wo_mstr')
            ->when($sr, function ($q, $sr) {
                return $q->where('wo_sr_number', $sr);
            })
            ->leftjoin('users', 'wo_mstr.wo_createdby', 'users.username')
            ->leftJoin('dept_mstr', 'wo_mstr.wo_department', 'dept_mstr.dept_code')
            ->first();
        // dd($womstr);

        // $engineerlist = DB::table('wo_mstr')
        //     ->when($sr, function ($q, $sr) {
        //         return $q->where('wo_sr_number', $sr);
        //     })
        //     ->selectRaw('a.name as eng1,b.name as eng2,c.name as eng3,d.name as eng4,e.name as eng5')
        //     ->leftjoin('users as a', 'wo_mstr.wo_engineer1', 'a.username')
        //     ->leftjoin('users as b', 'wo_mstr.wo_engineer2', 'b.username')
        //     ->leftjoin('users as c', 'wo_mstr.wo_engineer3', 'c.username')
        //     ->leftjoin('users as d', 'wo_mstr.wo_engineer4', 'd.username')
        //     ->leftjoin('users as e', 'wo_mstr.wo_engineer5', 'e.username')
        //     ->first();

        $engineerlist = "";

        // // dd($array);
        $sparepartarray = [];
        $printdate = Carbon::now('ASIA/JAKARTA')->toDateString();
        // dd($repair);
        foreach ($repair as $repair) {
            foreach ($repair as $repair1) {
                // dd($repair1);
                if (!in_array($repair1->spm_desc, $sparepartarray)) {
                    array_push($sparepartarray, $repair1->spm_desc);
                }
            }
        }

        /* A211014 */
        $users = DB::table('users')->get();
        $datasr = DB::table('service_req_mstr')
            ->whereWo_number($sr)
            ->first();

        // $pdf = PDF::loadview('workorder.pdfprint-template',['womstr' => $womstr,'wodet' => $wodet, 'data' => $data,'printdate' =>$printdate,'repair'=>$repair,'sparepart'=>$array])->setPaper('A4','portrait');
        $pdf = PDF::loadview('service.pdfprint-template', [
            'engineerlist' => $engineerlist, 'womstr' => $womstr,
            'srmstr' => $srmstr, 'dept' => $dept, 'printdate' => $printdate, 'users' => $users,
            'datasr' => $datasr, 'failurecode' => $listFailDesc, 'impact' => $listImpactDesc,
            'engapprover' => $engapprover,
        ])->setPaper('A4', 'portrait');
        //return view('picklistbrowse.shipperprint-template',['printdata1' => $printdata1, 'printdata2' => $printdata2, 'runningnbr' => $runningnbr,'user' => $user,'last' =>$countprint]);
        return $pdf->stream($sr . '.pdf');
    }
}
