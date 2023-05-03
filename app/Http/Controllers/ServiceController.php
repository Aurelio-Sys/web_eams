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
            'impact' => $impact, 'dataapp' => $dataapp
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
                        $upload->move($savepath, $filename);

                        // Simpan ke DB Upload
                        DB::table('service_req_upload')
                            ->insert([
                                'filepath' => $savepath . $filename,
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
            // $cekdepartemen = DB::table('dept_mstr')->where('dept_code', $user->dept_user)->first();
            $srdeptapprover = DB::table('sr_approver_mstr')->where('sr_approver_dept', $srmstr->sr_dept)->get();

            //cek engineer approval
            $engdeptapprover = DB::table('eng_mstr')->where('eng_dept', $srmstr->sr_eng_approver)->first();
            // dd($engdeptapprover->eng_dept);

            //cek tingakatan approval
            if (count($srdeptapprover) < 1) {

                //input ke trans approval eng jika tidak ada approval department
                DB::table('sr_trans_approval_eng')
                    ->insert([
                        'srta_eng_mstr_id' => $srmstr->id,
                        'srta_eng_dept_approval' => $engdeptapprover->eng_dept,
                        // 'srta_eng_role_approval' => $engdeptapprover->eng_role,
                        'srta_eng_status' => 'Waiting for engineer approval',
                        'created_at' => Carbon::now()->toDateTimeString(),
                    ]);

                //input ke trans approval eng hist jika tidak ada approval department
                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $engdeptapprover->eng_dept,
                        // 'srtah_eng_role_approval' => $engdeptapprover->eng_role,
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

                //input ke trans approval eng
                DB::table('sr_trans_approval_eng')
                    ->insert([
                        'srta_eng_mstr_id' => $srmstr->id,
                        'srta_eng_dept_approval' => $engdeptapprover->eng_dept,
                        // 'srta_eng_role_approval' => $engdeptapprover->eng_role,
                        'srta_eng_status' => 'Waiting for engineer approval',
                        'created_at' => Carbon::now()->toDateTimeString(),
                    ]);

                //input ke trans approval eng hist
                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $engdeptapprover->eng_dept,
                        // 'srtah_eng_role_approval' => $engdeptapprover->eng_role,
                        'srtah_eng_status' => 'Waiting for engineer approval',
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
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
        $cekdepartemen = DB::table('dept_mstr')->where('dept_code', $user->dept_user)->first();
        $srdeptapprover = DB::table('sr_approver_mstr')->where('sr_approver_dept', $user->dept_user)->get();
        // dd($srdeptapprover);

        if (count($srdeptapprover) == 0) {
            // dd('yes');
            $kepalaengineer = DB::table('eng_mstr')
                ->where('approver', '=', 0)
                ->where('eng_active', '=', 'Yes')
                ->where('eng_code', '=', Session::get('username'))
                ->orderBy('eng_code')
                ->first();

            // if ($kepalaengineer || Session::get('role') == 'ADMIN') {
            if ($kepalaengineer) {
                $wotype = DB::table('wotyp_mstr')
                    ->orderBy('wotyp_code')
                    ->get();

                $impact = DB::table('imp_mstr')
                    ->orderBy('imp_code')
                    ->get();

                $fcode = DB::table('fn_mstr')
                    ->orderBy('fn_code')
                    ->get();


                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                    ->join('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,wotyp_mstr.*,users.*,dept_mstr.*')
                    ->where('sr_status', '=', '1')
                    ->orderBy('sr_req_date', 'DESC')
                    ->orderBy('sr_number', 'DESC');

                // dd($data);

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data->where('sr_eng_approver', '=', Session::get('username'));
                    // $data = $data->where('sr_eng_approver', '=', $kepalaengineer->eng_dept)->get();
                    // dd($data);
                }


                $data = $data->paginate(10);

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
            } else {
                // toast('anda tidak memiliki akses sebagai approver', 'error');
                return view('service.accessdenied');
            }
        } else {
            // dd('get');
            $user = FacadesAuth::user();

            // cek departemen approval
            $cekdepartemen = DB::table('dept_mstr')->where('dept_code', $user->dept_user)->first();
            $srdeptapprover = DB::table('sr_approver_mstr')->where('sr_approver_dept', $cekdepartemen->ID)->first();


            // $data = DB::table('service_req_mstr')
            //     ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
            //     ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
            //     ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
            //     ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
            //     // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
            //     ->join('users', 'users.username', 'service_req_mstr.sr_req_by')
            //     ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
            //     ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
            //     ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,wotyp_mstr.*,users.*,dept_mstr.*,sr_trans_approval.*,service_req_mstr.id')
            //     ->where('sr_status', '=', 'Open')
            //     ->orderBy('sr_req_date', 'DESC')
            //     ->orderBy('sr_number', 'DESC')
            //     ->groupBy('sr_number');

            // dd($data);
            /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
            // if (Session::get('role') <> 'ADMIN') {
            //     // $data = $data->where('sr_eng_approver', '=', Session::get('username'));
            //     // $data = $data->where('sr_eng_approver', '=', $kepalaengineer->eng_code);
            //     $data = $data->where([
            //         'srta_dept_approval' => $srdeptapprover->sr_approver_dept,
            //         // 'srta_role_approval' => Session::get('role')
            //     ]);
            //     // dd(Session::get('username'));
            // }
            $data = ServiceReqMaster::query()
                ->with(['getCurrentApprover'])
                ->where('sr_status_approval', '!=', 'Cancelled')
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
                ->selectRaw('service_req_mstr.*, asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, users.name, dept_mstr.dept_desc')
                ->orderBy('sr_number', 'DESC');

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
            // } else {
            //     // toast('anda tidak memiliki akses sebagai approver', 'error');
            //     return view('service.accessdenied');
            // }
        }
    }

    public function srapprovaleng(Request $req) /* blade : service.servicereq-approval */
    {
        $user = FacadesAuth::user();

        // cek engineer approval
        $engineer_approver = DB::table('eng_mstr')
            ->where('eng_code', $user->username)
            ->where('approver', '=', 1)
            ->first();
        // dd($engineer_approver->eng_code);

        $kepalaengineer = DB::table('eng_mstr')
            ->where('approver', '=', 1)
            ->where('eng_active', '=', 'Yes')
            ->where('eng_code', '=', Session::get('username'))
            ->orderBy('eng_code')
            ->first();


        // if ($kepalaengineer || Session::get('role') == 'ADMIN') {
        if ($kepalaengineer) {
            $wotype = DB::table('wotyp_mstr')
                ->orderBy('wotyp_code')
                ->get();

            $impact = DB::table('imp_mstr')
                ->orderBy('imp_code')
                ->get();

            $fcode = DB::table('fn_mstr')
                ->orderBy('fn_code')
                ->get();


            $data = DB::table('service_req_mstr')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                ->join('users', 'users.username', 'service_req_mstr.sr_req_by')
                ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,wotyp_mstr.*,users.*,dept_mstr.*,service_req_mstr.id')
                ->where('sr_status', '=', 'Open')
                ->orderBy('sr_req_date', 'DESC')
                ->orderBy('sr_number', 'DESC')
                ->groupBy('sr_number',);

            // dd($data);

            /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
            if (Session::get('role') <> 'ADMIN') {
                // $data = $data->where('sr_approver', '=', Session::get('username'));
                $data = $data->where('sr_eng_approver', '=', $engineer_approver->eng_dept);
            }

            $data = $data->paginate(10);

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

            $inslist = DB::table('ins_list')->get();

            $splist = DB::table('spg_list')->get();

            $qclist = DB::table('qcs_list')->get();

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

    public function engajax(Request $req)
    {
        if ($req->ajax()) {
            $eng = DB::table('eng_mstr')
                ->where('eng_active', '=', 'Yes')
                ->orderBy('eng_code')
                ->get();

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
        $uploadfile = $req->hasFile('filename');
        $approver = $req->e_approver;
        // dd($srnbr, $wotype, $failcode, $impact, $priority, $note, $reqdate, $reqtime, $uploadfile);
        // dd($approver);
        if ($req->hasFile('filename')) {

            foreach ($req->file('filename') as $upload) {
                $dataTime = date('Ymd_His');
                $filename = $dataTime . '-' . $upload->getClientOriginalName();

                // Simpan File Upload pada Public
                $savepath = public_path('uploadasset/');
                $upload->move($savepath, $filename);

                // Simpan ke DB Upload
                DB::table('service_req_upload')
                    ->insert([
                        'filepath' => $savepath . $filename,
                        'sr_number' => $srnbr,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
            }

            toast('Service Request ' . $srnbr . ' successfully updated', 'success');
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

        $update = ServiceReqMaster::where('sr_number', $srnbr)->first();
        $update->sr_fail_type = $wotype;
        $update->sr_fail_code = $newfailcode;
        $update->sr_impact = $newimpact;
        $update->sr_priority = $priority;
        $update->sr_note = $note;
        $update->sr_req_date = $reqdate;
        $update->sr_req_time = $reqtime;
        $update->sr_eng_approver = $approver;
        // dd($approver);
        if ($update->isDirty()) {
            //kalo ada update
            $update->sr_status = 'Open';
            $update->updated_at = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

            //jika ada perubahan approval engineer sebelum diapprove oleh engineer
            if ($srmstr->sr_eng_approver != $approver) {
                DB::table('sr_trans_approval_eng')
                    ->where('srta_eng_mstr_id', $srmstr->id)
                    ->update([
                        'srta_eng_dept_approval' => $approver,
                        'srta_eng_reason' => null,
                        'srta_eng_status' => 'Waiting for engineer approval',
                        'srta_eng_approved_by' => null,
                        'updated_at' => null,
                    ]);

                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $approver,
                        'srtah_eng_status' => 'Waiting for engineer approval',
                        'srtah_eng_reason' => 'Approval has been changed by user',
                        'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);
            }

            //jika ada perubahan approval engineer setelah diapprove oleh engineer
            if ($srmstr->sr_status_approval == 'Revision from engineer approval') {

                $update->sr_status_approval = 'Waiting for engineer approval';

                DB::table('sr_trans_approval_eng')
                    ->where('srta_eng_mstr_id', $srmstr->id)
                    ->update([
                        'srta_eng_dept_approval' => $approver,
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
                            'srtah_eng_status' => 'Waiting for engineer approval',
                            'srtah_eng_reason' => 'Approval has been changed by user',
                            'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                } else {
                    DB::table('sr_trans_approval_eng_hist')
                        ->insert([
                            'srtah_eng_sr_number' => $srmstr->sr_number,
                            'srtah_eng_status' => 'Waiting for engineer approval',
                            'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                }
            } elseif ($srmstr->sr_status_approval == 'Revision from department approval') {

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

            $update->save();

            EmailScheduleJobs::dispatch('', '', '10', '', '', $runningnbr, '');

            toast('Service Request ' . $srnbr . ' successfully updated', 'success');
        } else {
            // kalo belum update
            toast('Service Request ' . $srnbr . ' has not been updated', 'error');
        }


        return back();
    }

    /*MR - 160423*/
    public function cancelsr(Request $req)
    {
        $srnbr = $req->c_srnumber;

        $srmstr = ServiceReqMaster::where('sr_number', $srnbr)->first();
        // dd($srmstr);

        DB::table('service_req_mstr')
            ->where('sr_number', '=', $srnbr)
            ->update([
                'sr_status'       => 'Canceled',
                'updated_at'      => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
            ]);

        DB::table('service_req_mstr_hist')
            ->insert([
                'sr_number'       => $srnbr,
                'sr_fail_type'    => $srmstr->sr_fail_type,
                'sr_fail_code'    => $srmstr->sr_fail_code,
                'sr_impact'       => $srmstr->sr_impact,
                'sr_priority'     => $srmstr->sr_priority,
                'sr_note'         => $srmstr->sr_note,
                'sr_req_date'     => $srmstr->sr_req_date,
                'sr_req_time'     => $srmstr->sr_req_time,
                'sr_status'       => 'Canceled',
                'sr_status_approval'       => 'Canceled',
                'sr_eng_approver' => $srmstr->sr_eng_approver,
                'sr_action'       => 'SR Canceled',
                'created_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                // 'sr_access'       => 0
            ]);

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

        // dd($requestor);
        //cek departemen dan role approval yg sesuai dengan user yg login
        $srdeptapprover = DB::table('sr_trans_approval')
            ->where('srta_dept_approval', $srmstr->sr_dept)
            ->where('srta_mstr_id', $idsr)
            ->where('srta_role_approval', $user->role_user)
            ->first();
        // dd($srdeptapprover);

        switch ($req->input('action')) {
            case 'reject':
                //jika direject;
                // dd('test');
                $running = DB::table('running_mstr')
                    ->first();
                // dd($running);
                $newyear = Carbon::now()->format('y');

                // $runningnbr = $running->wo_prefix . '-' . $newyear . '-' . $running->wo_number;
                $runningnbr = $running->wo_prefix . '-' . $newyear . '-' . $running->wo_nbr;
                // $tampungarray = [];
                // $tampungarray = $req->enjiners;
                // dd($tampungarray);
                $rejectnote = $req->rejectreason;
                // $requestor = $req->hiddenreq;
                $srnumber = $req->srnumber;
                $asset = $req->assetcode . ' -- ' . $req->assetdesc;
                $a = 4; //direject 
                $wo = $runningnbr;
                // $wotype = $req->wotype;
                $imdesc = $req->impact;

                $statusakses = DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->first();

                // if ($statusakses->sr_access == 0) {
                //     DB::table('service_req_mstr')
                //         ->where('sr_number', '=', $srnumber)
                //         ->update(['sr_access' => 1]);
                // } else {
                //     toast('SR ' . $srnumber . ' is being used right now', 'error');
                //     return back();
                // }
                // if ($statusakses->sr_status != '1') {
                //     toast('SR ' . $srnumber . ' status has changed, please recheck', 'error');
                //     return back();
                // }

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
                    'sr_action'       => 'Department Approval',
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
                EmailScheduleJobs::dispatch('', $asset, '4', '', $requestor, $srnumber, '');

                toast('Service Request ' . $req->srnumber . '  Rejected Successfully ', 'success');
                return back();

                break;

            case 'approve': //jika diapprove

                //cek engineer approval
                $engineer_approver = DB::table('eng_mstr')->where('eng_dept', $srmstr->sr_eng_approver)
                    ->where('approver', '=', 1)
                    ->first();
                // dd($engineer_approver);

                //cek next approver
                $nextapprover = DB::table('sr_trans_approval')->where('srta_mstr_id', $srdeptapprover->srta_mstr_id)
                    ->where('srta_sequence', '>', $srdeptapprover->srta_sequence)
                    ->first();
                // dump($nextapprover);

                if (is_null($nextapprover)) {
                    //jika tidak ada approver selanjutnya
                    // dd('null');
                    DB::table('sr_trans_approval')
                        ->where('srta_mstr_id', '=', $idsr)
                        ->where('srta_role_approval', '=', $user->role_user)
                        ->update([
                            'srta_status'      => 'Approved',
                            'srta_reason'      => $reason,
                            'srta_approved_by' => $user->id,
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

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
                            'sr_action'       => 'Department Approval',
                            'created_at'   => Carbon::now()->toDateTimeString(),
                            'updated_at'   => Carbon::now()->toDateTimeString(),
                            // 'updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            // 'sr_access'       => 0
                        ]);

                    DB::table('sr_trans_approval_eng')
                        ->insert([
                            'srta_eng_mstr_id' => $idsr,
                            'srta_eng_dept_approval' => $engineer_approver->eng_dept,
                            // 'srta_eng_role_approval' => $engineer_approver->eng_role,
                            'srta_eng_status' => 'Waiting for engineer approval',
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    DB::table('sr_trans_approval_eng_hist')
                        ->insert([
                            'srtah_eng_sr_number' => $srmstr->sr_number,
                            'srtah_eng_dept_approval' => $engineer_approver->eng_dept,
                            // 'srtah_eng_role_approval' => $engineer_approver->eng_role,
                            'srtah_eng_status' => 'Waiting for engineer approval',
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    //kirim email ke engineer approver
                    EmailScheduleJobs::dispatch('', $asset, '8', '', $requestor, $srnumber, '');
                } else {
                    // dd('notnull');
                    DB::table('service_req_mstr')
                        ->where('id', '=', $idsr)
                        ->update([
                            'sr_status' => 'Open',
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

                    DB::table('sr_trans_approval')
                        ->where('srta_mstr_id', '=', $idsr)
                        ->where('srta_role_approval', '=', $user->role_user)
                        ->update([
                            'srta_status'      => 'Approved',
                            'srta_reason'      => $reason,
                            'srta_approved_by' => $user->id,
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

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

                    //kirim email ke approver selanjutnya
                    EmailScheduleJobs::dispatch('', $asset, '7', '', $requestor, $srnumber, '');
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
            ->selectRaw('sr_trans_approval_eng.*, users.username, dept_mstr.dept_desc')
            ->where('srta_eng_mstr_id', '=', $datasr->id)
            ->get();
        // dd($dataApprover);
        $output = '';

        foreach ($dataApprover as $key => $approver) {

            // foreach($userApprover as $user){
            $output .= '<tr>';
            $output .= '<td>';
            $output .= $key + 1;
            $output .= '</td>';
            $output .= '<td>';
            $output .= $approver->dept_desc;
            $output .= '</td>';
            $output .= '<td>';
            $output .= $approver->srta_eng_role_approval;
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

        return response($output);
    }

    public function approvaleng(Request $req)
    { /* blade : service.servicereq-approvaleng */
        // dd($req->wotype);
        $wotype = $req->wotype;
        $imcode = $req->impactcode1;
        $imdesc = $req->impact;
        $idsr   = $req->idsr;
        $rejectnote = $req->rejectnote;
        // dd($idsr);
        $srmstr = DB::table('service_req_mstr')->where('id', $idsr)->first();

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
                $rejectnote = $req->rejectreason;
                $requestor = $req->hiddenreq;
                $srnumber = $req->srnumber;
                $asset = $req->assetcode . ' -- ' . $req->assetdesc;
                $a = 4; //direject 
                $wo = $runningnbr;
                // $wotype = $req->wotype;
                $imdesc = $req->impact;

                // $statusakses = DB::table('service_req_mstr')
                //     ->where('sr_number', '=', $srnumber)
                //     ->first();

                // if ($statusakses->sr_access == 0) {
                //     DB::table('service_req_mstr')
                //         ->where('sr_number', '=', $srnumber)
                //         ->update(['sr_access' => 1]);
                // } else {
                //     toast('SR ' . $srnumber . ' is being used right now', 'error');
                //     return back();
                // }
                // if ($statusakses->sr_status != '1') {
                //     toast('SR ' . $srnumber . ' status has changed, please recheck', 'error');
                //     return back();
                // }


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
                    'sr_action'       => 'Engineer Approval',
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
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $engineer_approver->eng_dept,
                        'srtah_eng_role_approval' => $engineer_approver->eng_role,
                        'srtah_eng_status' => 'Revision from engineer approval',
                        'srtah_eng_reason' => $rejectnote,
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
                $statusakses = DB::table('service_req_mstr')
                    ->where('sr_number', '=', $req->srnumber)
                    ->first();

                $thisFailCode = "";

                if ($req->has('fclist')) {
                    $thisFailCode = implode(';', array_map('strval', $req->fclist));
                } else {
                    $thisFailCode = null;
                }

                $thisImpact = "";

                if ($req->has('impact')) {
                    $thisImpact = implode(';', array_map('strval', $req->impact));
                } else {
                    $thisImpact = null;
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
                    'wo_type'            => 'CM',
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
                        'sr_action'       => 'Engineer Approval',
                        'created_at'   => Carbon::now()->toDateTimeString(),
                        'updated_at'   => Carbon::now()->toDateTimeString(),
                        //         // 'updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        //         // 'sr_access'       => 0
                    ]);

                DB::table('sr_trans_approval_eng')
                    ->where('srta_eng_mstr_id', '=', $idsr)
                    ->update([
                        'srta_eng_dept_approval' => $engineer_approver->eng_dept,
                        'srta_eng_role_approval' => $engineer_approver->eng_role,
                        'srta_eng_status' => 'Approved',
                        'srta_eng_reason' => $rejectnote,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

                DB::table('sr_trans_approval_eng_hist')
                    ->insert([
                        'srtah_eng_sr_number' => $srmstr->sr_number,
                        'srtah_eng_dept_approval' => $engineer_approver->eng_dept,
                        'srtah_eng_role_approval' => $engineer_approver->eng_role,
                        'srtah_eng_status' => 'Revision from engineer approval',
                        'srtah_eng_reason' => $rejectnote,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

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

                // dd($wo,$asset,$a,$tampungarray,$requestor,$srnumber,$rejectnote);
                //nanti kirim email ke engineer dan requestor 
                EmailScheduleJobs::dispatch($wo, $asset, $a, $tampungarray, $requestor, $srnumber, $rejectnote);

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
            // dd($srnumber, $asset, $priority);
            // $period = $req->get('period');

            if ($srnumber == "" && $asset == "" && $priority == "") {

                $dataapps = DB::table('service_req_mstr')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_eng_approver')
                    ->selectRaw('dept_mstr.*')
                    ->where('sr_dept', '=', session::get('department'))
                    ->first();


                $data = ServiceReqMaster::query()
                    ->with(['getCurrentApprover'])
                    ->where('sr_status_approval', '!=', 'Cancelled')
                    ->whereHas('getSRTransAppr', function ($q) {
                        $q->with(['getDeptApprover', 'getRoleApprover'])
                            ->where('srta_status', '=', 'Waiting for department approval');
                    });
                $data = $data
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->leftJoin('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->selectRaw('service_req_mstr.*, service_req_mstr.sr_number, asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, users.name, dept_mstr.dept_desc')
                    ->where('sr_dept', '=', session::get('department'))
                    ->orderBy('sr_number', 'DESC');

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
                    ->where('sr_status_approval', '!=', 'Cancelled')
                    ->whereHas('getSRTransAppr', function ($q) {
                        $q->with(['getDeptApprover', 'getRoleApprover'])
                            ->where('srta_status', '=', 'Waiting for department approval');
                    });
                $data = $data
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('asset_loc', 'asset_loc.asloc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                    ->leftJoin('users', 'users.username', 'service_req_mstr.sr_req_by')
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->selectRaw('service_req_mstr.*, service_req_mstr.sr_number, asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, users.name, dept_mstr.dept_desc')
                    ->where('sr_dept', '=', session::get('department'))
                    ->whereRaw($kondisi)
                    ->orderBy('sr_number', 'DESC');

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
            // dd($srnumber, $asset, $priority);
            // $period = $req->get('period');

            $user = FacadesAuth::user();

            // cek engineer approval
            $engineer_approver = DB::table('eng_mstr')
                ->where('eng_code', $user->username)
                ->where('approver', '=', 1)
                ->first();

            if ($srnumber == "" && $asset == "" && $priority == "") {

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
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,wotyp_mstr.*,users.*,dept_mstr.*,service_req_mstr.id')
                    ->where('sr_status', '=', 'Open')
                    ->orderBy('sr_req_date', 'DESC')
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number',);

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    // $data = $data->where('sr_approver', '=', Session::get('username'));
                    $data = $data->where('sr_eng_approver', '=', $engineer_approver->eng_dept);
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
                    ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
                    ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,asset_loc.*,wotyp_mstr.*,users.*,dept_mstr.*,service_req_mstr.id')
                    ->where('sr_status', '=', 'Open')
                    ->orderBy('sr_req_date', 'DESC')
                    ->orderBy('sr_number', 'DESC')
                    ->whereRaw($kondisi)
                    ->groupBy('sr_number',);

                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    // $data = $data->where('sr_approver', '=', Session::get('username'));
                    $data = $data->where('sr_eng_approver', '=', $engineer_approver->eng_dept);
                }

                $data = $data->paginate(10);
                // dd($data);

                return view('service.table-srapprovaleng', ['datas' => $data, '$dataapps' => $dataapps]);
            }
        }
    }

    public function srbrowse() /* route : srbrowse   blade : service.servicereqbrowse */
    {
        // $q = $req->srnumber;
        $dataapps = DB::table('dept_mstr')
            ->leftjoin('service_req_mstr', 'service_req_mstr.sr_eng_approver', 'dept_mstr.dept_code')
            ->selectRaw('dept_mstr.*, service_req_mstr.*')
            // ->where('sr_eng_approver', '=', session::get('department'))
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
                asset_mstr.asset_code, asset_mstr.asset_desc, asset_mstr.asset_loc, dept_mstr.dept_desc, users.username, users.name,
                wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.dept_desc as u11,
                wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, eng_mstr.eng_dept, eng_mstr.eng_desc, wo_mstr.wo_list_engineer,
                sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
            // ->where('sr_dept', '=', session::get('department'))
            ->orderBy('sr_req_date', 'DESC')
            ->orderBy('sr_number', 'DESC')
            ->groupBy('sr_number');
        // ->get();

        /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
        if (Session::get('role') <> 'ADMIN') {
            $data = $data->where('sr_dept', '=', session::get('department'));
            // $data = $data->where('sr_eng_approver', '=', $kepalaengineer->eng_dept)->get();
            // dd($data);
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
                            <a href="/downloadfile/' . $data->id . '" target="_blank">' . $filename . '</a> 
                            </td>
                            <input type="hidden" value="' . $data->id . '" class="rowval"/>
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
            $srnumber = $req->get('srnumber');
            // dd($srnumber);
            $asset = $req->get('asset');
            // $priority = $req->get('priority');
            // $period = $req->get('period');
            $status = $req->get('status');
            $requestby = $req->get('requestby');
            $datefrom = $req->get('datefrom') == '' ? '2000-01-01' : date($req->get('datefrom'));
            $dateto = $req->get('dateto') == '' ? '3000-01-01' : date($req->get('dateto'));

            $ceksrfile = DB::table(('service_req_upload'))
                ->get();

            $cekdate = DB::table(('service_req_mstr'))->where('id', '>', 0)->whereBetween('sr_req_date', [$datefrom, $dateto])
                ->get();
            // dd($requestby);

            if ($srnumber == "" && $asset == "" /*&& $priority == ""*/  /*&& $period == "" */ && $status == "" && $requestby == "" && $datefrom == "" && $dateto == "") {
                // dd("test");
                // $dummy = DB::table('service_req_mstr')
                // ->selectRaw('wo_mstr.*,u1.eng_code as engcode1,u1.eng_desc as engdesc1,u2.eng_code as engcode2,u2.eng_desc as engdesc2,u3.eng_code as engcode3,u3.eng_desc as engdesc3')
                // ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                // ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                //     ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                //     ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                //     // ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                //     // ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                //         // ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                //         // ->join('users', 'users.name', 'service_req_mstr.req_by')
                //         // ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                //         ->paginate(10);

                // dd($dummy);

                // $data = DB::table('service_req_mstr')                                                //B211014
                //     ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                //     ->join('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                //     ->join('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                //     ->join('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                //     ->join('users', 'users.name', 'service_req_mstr.req_by')
                //     ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                //     ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                //     ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                //     ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                //     ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                //     ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                //     ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                //     ->selectRaw('service_req_mstr.* , asset_mstr.asset_desc, dept_mstr.dept_desc, users.username, wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.eng_desc as u11, u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55')
                //     // ->where('sr_status', '=', '1')
                //     ->orderBy('sr_number', 'DESC')
                //     ->paginate(10);

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
            wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, wo_mstr.wo_list_engineer, eng_mstr.eng_dept,
            sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number')
                    ->paginate(10);

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

                // dd($kondisi);

                // $data = DB::table('service_req_mstr')
                //     ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                //     ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                //     ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                //     ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
                //     ->join('users', 'users.username', 'service_req_mstr.sr_req_by')
                //     ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                //     ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                //     ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
                //     ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
                //     ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
                //     ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
                //     ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
                //     ->leftJoin('fn_mstr as k1', 'service_req_mstr.sr_failurecode1', 'k1.fn_code')
                //     ->leftJoin('fn_mstr as k2', 'service_req_mstr.sr_failurecode2', 'k2.fn_code')
                //     ->leftJoin('fn_mstr as k3', 'service_req_mstr.sr_failurecode3', 'k3.fn_code')
                //     ->selectRaw('service_req_mstr.* , asset_mstr.asset_desc, dept_mstr.dept_desc, users.username, wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.eng_desc as u11, u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, wo_mstr.wo_start_date,
                //         wo_mstr.wo_finish_date, wo_mstr.wo_action, wo_mstr.wo_status,
                //         k1.fn_desc as k11, k2.fn_desc as k22, k3.fn_desc as k33')
                //     ->whereRaw($kondisi)
                //     ->orderBy('sr_number', 'DESC')
                //     ->paginate(10);
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
                wo_mstr.wo_job_startdate, wo_mstr.wo_job_finishdate, wo_mstr.wo_status, wo_mstr.wo_list_engineer, eng_mstr.eng_dept,
                sr_trans_approval.srta_reason, sr_trans_approval_eng.srta_eng_reason, sr_trans_approval.srta_status, sr_trans_approval_eng.srta_eng_status')
                    // ->where('sr_dept', '=', session::get('department'))
                    ->whereRaw($kondisi)
                    ->orderBy('sr_number', 'DESC')
                    ->groupBy('sr_number');
                // ->get();
                /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
                if (Session::get('role') <> 'ADMIN') {
                    $data = $data->where('sr_dept', '=', session::get('department'));
                    // $data = $data->where('sr_eng_approver', '=', $kepalaengineer->eng_dept)->get();
                    // dd($data);
                }

                $data = $data->paginate(10);
                // dd($data);

                return view('service.table-srbrowse', ['datas' => $data, 'ceksrfile' => $ceksrfile, 'dataapps' => $dataapps]);
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
        // dd(Session::get('username'));
        // dd('stop');
        if (Session::get('role') == 'ADM') {
            // dd('aadamin');
            $datas = DB::table('service_req_mstr')
                ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                ->leftjoin('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
                ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
                ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
                ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
                ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
                ->selectRaw('service_req_mstr.* ,wo_mstr.* , asset_mstr.asset_desc, dept_mstr.dept_desc, u1.eng_desc as u11, u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55')
                //->where('wo_status', '=', 'completed')
                // ->where('sr_status', '=', 4) A211014
                ->where('sr_status', '=', 7) //A211019
                //->where(function($query){$query->where('sr_status','=',7) ->orWhere('sr_status','=',6);})
                ->orderBy('sr_updated_at', 'DESC')
                // ->where('sr_req_by', '=', Session::get('username'))
                ->paginate(10);

            //dd('1');

            $datasset = DB::table('asset_mstr')
                ->get();
        } else {
            $datas = DB::table('service_req_mstr')
                ->join('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
                ->leftjoin('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
                ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
                ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
                ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
                ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
                ->selectRaw('service_req_mstr.* ,wo_mstr.* , asset_mstr.asset_desc, dept_mstr.dept_desc, 
                    u1.eng_desc as u11, u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55')
                //->where('wo_status', '=', 'completed')
                // ->where('sr_status', '=', 4) A211014
                //->where('sr_status', '=', 7) A211019
                ->where(function ($query) {
                    $query->where('sr_status', '=', 7)->orWhere('sr_status', '=', 6);
                })
                ->where('sr_req_by', '=', Session::get('username'))
                ->orderBy('sr_updated_at', 'DESC')
                ->paginate(10);

            //dd('2');

            $datasset = DB::table('asset_mstr')
                ->get();
        }


        //dd($datas);

        return view('service.useracceptance', ['dataua' => $datas, 'asset' => $datasset]);
    }

    public function acceptance(Request $req)
    {
        // dd($req->all());
        // $data = explode( ',', $req->imgname[0] );
        // dd($data);
        // $emak = base64_decode($data[1]);
        // file_put_contents('../public/upload/test1.png', $emak);
        // dd('stop');
        switch ($req->input('action')) {
            case 'complete':
                //dd('lg maintenance');
                $srnumber = $req->hiddensr;
                $wonumber = $req->hiddenwo;

                // $albumraw = $req->imgname;

                // dd($albumraw);
                $k = 0;
                // foreach($albumraw as $olah1){
                //     $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                //     // dd($waktu);
                //     $jadi1 = explode(',', $olah1);

                //     $jadi2 = base64_decode($jadi1[2]);


                //     $lenstr = strripos($jadi1[0],'.');
                //     $test = substr($jadi1[0],$lenstr);
                //     // dd($test);
                //     $test3 = str_replace($test,'',$jadi1[0]);
                //     // dd($test3);
                //     $test4 = str_replace('.','',$test3);
                //     $test44 = str_replace(' ','',$test4);
                //     $test5 = $test44.$waktu.$test;

                //     $alamaturl = '../public/upload/'.$test5;
                //     // dd($alamaturl);


                //     file_put_contents($alamaturl, $jadi2);

                //     DB::table('acceptance_image')
                //         ->insert([
                //             'file_srnumber' => $srnumber,
                //             'file_wonumber' => $wonumber,
                //             'file_name' => $jadi1[0], //nama file asli
                //             'file_url' => $alamaturl, 
                //             'uploaded_at' => Carbon::now()->toDateTimeString(),
                //         ]);

                //     // $k++;

                // }

                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->update([
                        'sr_status' => '5',
                        'sr_accept_date' => Carbon::now()->toDateTimeString(),  //   C211014
                    ]);

                DB::table('wo_mstr')
                    ->where('wo_number', '=', $wonumber)
                    ->update([
                        'wo_status' => 'closed',
                    ]);

                toast('Service Request ' . $srnumber . ' Completed ', 'success');
                return back();

                // if ($req->hasFile('imgname')) {
                //     //  Let's do everything here
                //     if ($req->file('imgname')->isValid()) {
                //         //
                //         dd($req->file('imgname'));

                //         $fullfilename = $srnumber."-".$wonumber;
                //         $validated = $req->validate([
                //             'image' => 'mimes:jpeg,png,jpg|max:5120',
                //         ]);
                //         $extension = $req->t_photo->extension();
                //         $req->t_photo->storeAs('/', $srnumber."-".$wonumber.".".$extension, 'public_img');
                //         $url = Storage::disk('public_img')->url($srnumber."-".$wonumber.".".$extension);
                //         $file = DB::table('service_req_mstr')
                //                 ->where('sr_number', '=', $srnumber)
                //                 ->update([
                //                     'photo_name' => $fullfilename,
                //                     'photo_url' => $url,
                //                     'sr_status' => '5',
                //                 ]);





                //     }else{
                //         toast('No Photo File', 'error');
                //         return back();
                //     }
                // }else{
                // toast('No Photo File', 'error');
                // return back();
                // }


                break;

            case 'incomplete':
                //dd('lagi maintenance 1');
                $uncompletereason = $req->uncompletenote;
                $srnumber = $req->hiddensr;
                $wonumber = $req->hiddenwo;

                // dd('sampi sini jalan');
                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->update([
                        // 'sr_status' => '5', --> A210927 status ganti reject bukan close
                        'sr_status' => '6'
                    ]);

                DB::table('wo_mstr')
                    ->where('wo_number', '=', $wonumber)
                    ->update([
                        // 'wo_status' => 'closed', --> A210927 status ganti reject bukan close
                        'wo_status' => 'incomplete',
                        'wo_reject_reason' => $uncompletereason,
                    ]);

                // $note = [''.$wonumber.' Uncomplete'];
                // dd($note);
                toast('Service Request ' . $srnumber . ' Incomplete ', 'success');
                return back();
                //return redirect()->route('srcreate');
                break;
        }
    }

    public function imageview(Request $req)
    {
        //dd($req->all());
        $wonumber = $req->wonumber;

        $gambar = DB::table('acceptance_image')
            ->where('file_wonumber', '=', $wonumber)
            ->get();

        $output = "";
        foreach ($gambar as $gambar) {
            $output .= '<tr>
                    <td><a href="#" class="btn deleterow btn-danger"><i class="icon-table fa fa-trash fa-lg"></i></a>
                    &nbsp
                    <input type="hidden" value="' . $gambar->accept_img_id . '" class="rowval"/>
                    <td><a href="/downloadwofinish/' . $gambar->accept_img_id . '" target="_blank">' . $gambar->file_name . '</a></td>
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
        $srnbr    = $req->srnumber;
        $asset    = $req->asset;
        $status   = $req->status;
        // $priority = $req->priority;
        $period   = $req->period;
        $reqby    = $req->reqby;
        $datefrom = $req->datefrom;
        $dateto   = $req->dateto;

        return Excel::download(new ExportSR($srnbr, $status, $asset, /*$priority,*/ $period, $reqby, $datefrom, $dateto), 'Service Request.xlsx');
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
            ->selectRaw('fn1.fn_desc as fn1, fn2.fn_desc as fn2, fn3.fn_desc as fn3, dept_desc, eng_desc, sr_number, sr_fail_type, sr_dept,
            sr_created_at, sr_asset, asset_desc, req_by, sr_approver, sr_impact, imp_desc, sr_req_date, sr_time, asset_desc, wotyp_desc, 
            sr_note, imp_code, dept_user, req_by, wo_number, wo_duedate, wo_schedule')
            ->leftjoin('eng_mstr', 'service_req_mstr.sr_req_by', 'eng_mstr.eng_code')
            ->leftJoin('dept_mstr', 'service_req_mstr.sr_dept', 'dept_mstr.dept_code')
            ->leftJoin('asset_mstr', 'service_req_mstr.sr_asset', 'asset_mstr.asset_code')
            ->leftJoin('fn_mstr as fn1', 'service_req_mstr.sr_failurecode1', 'fn1.fn_code')
            ->leftJoin('fn_mstr as fn2', 'service_req_mstr.sr_failurecode2', 'fn2.fn_code')
            ->leftJoin('fn_mstr as fn3', 'service_req_mstr.sr_failurecode3', 'fn3.fn_code')
            ->leftJoin('wotyp_mstr', 'service_req_mstr.sr_fail_type', 'wotyp_mstr.wotyp_code')
            ->leftJoin('wo_mstr', 'service_req_mstr.sr_number', 'wo_mstr.wo_sr_nbr')
            ->leftJoin('imp_mstr', 'service_req_mstr.sr_impact', 'imp_mstr.imp_code')
            ->leftJoin('users', 'service_req_mstr.sr_approver', 'users.username')
            ->first();

        $impact = DB::table(('imp_mstr'))
            ->get();
        $dept = DB::table(('dept_mstr'))
            ->get();

        $womstr = DB::table('wo_mstr')
            ->when($sr, function ($q, $sr) {
                return $q->where('wo_sr_nbr', $sr);
            })
            ->leftjoin('users', 'wo_mstr.wo_creator', 'users.username')
            ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
            ->first();
        // dd($womstr);

        $engineerlist = DB::table('wo_mstr')
            ->when($sr, function ($q, $sr) {
                return $q->where('wo_sr_nbr', $sr);
            })
            ->selectRaw('a.name as eng1,b.name as eng2,c.name as eng3,d.name as eng4,e.name as eng5')
            ->leftjoin('users as a', 'wo_mstr.wo_engineer1', 'a.username')
            ->leftjoin('users as b', 'wo_mstr.wo_engineer2', 'b.username')
            ->leftjoin('users as c', 'wo_mstr.wo_engineer3', 'c.username')
            ->leftjoin('users as d', 'wo_mstr.wo_engineer4', 'd.username')
            ->leftjoin('users as e', 'wo_mstr.wo_engineer5', 'e.username')
            ->first();
        // $wodet = DB::table('wo_dets')
        //     ->join('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
        //     ->where('wo_dets_nbr', '=', $sr)
        //     ->get();
        // dd($engineerlist);4
        // $data = DB::table('wo_mstr')
        //     ->selectRaw('wo_number,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,
        //         wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, 
        //         wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,
        //         u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, 
        //         loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,
        //         wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart')
        //     ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
        //     ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
        //     ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
        //     ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
        //     ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
        //     ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
        //     ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
        //     ->leftjoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
        //     ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
        //     ->leftjoin('loc_mstr', 'asset_mstr.asset_loc', 'loc_mstr.loc_code')

        //     ->where('wo_mstr.wo_number', '=', $sr)
        //     ->get();
        // // dd($data);
        // $statusrepair = DB::table('wo_mstr')
        //     ->where('wo_mstr.wo_number', '=', $sr)
        //     ->first();
        // // dd($statusrepair);
        // $arrayrepaircode = [];
        // $repairlist = [];
        // $arrayrepairdetail = [];
        // $arrayrepairinst = [];
        // $arraysptdesc = [];
        // $currspt_desc = '';
        // // $repair = '';
        // $countrepairitr = 0;
        // $engineerlist = DB::table('wo_mstr')
        //     ->selectRaw('a.name as eng1,b.name as eng2,c.name as eng3,d.name as eng4,e.name as eng5')
        //     ->leftjoin('users as a', 'wo_mstr.wo_engineer1', 'a.username')
        //     ->leftjoin('users as b', 'wo_mstr.wo_engineer2', 'b.username')
        //     ->leftjoin('users as c', 'wo_mstr.wo_engineer3', 'c.username')
        //     ->leftjoin('users as d', 'wo_mstr.wo_engineer4', 'd.username')
        //     ->leftjoin('users as e', 'wo_mstr.wo_engineer5', 'e.username')
        //     ->where('wo_mstr.wo_number', $sr)
        //     ->first();

        // // dd($engineerlist);
        // dd($statusrepair);
        // if ($statusrepair->wo_repair_type == 'manual') {
        //     $data = DB::table('wo_mstr')
        //         ->selectRaw('wo_number,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,
        //                             wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,
        //                             wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,
        //                             wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, 
        //                             u4.eng_desc as u44, u5.eng_desc as u55,loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,
        //                             wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart')
        //         ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
        //         ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
        //         ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
        //         ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
        //         ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
        //         ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
        //         ->leftjoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
        //         ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
        //         ->leftjoin('loc_mstr', 'asset_mstr.asset_loc', 'loc_mstr.loc_code')
        //         ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
        //         ->where('wo_mstr.wo_number', '=', $sr)
        //         ->get();
        //     $datamanual = DB::table('wo_manual_detail')
        //         ->where('wo_manual_wo_nbr', '=', $sr)
        //         ->get();
        //     $countdb = count($datamanual);
        // } else if ($statusrepair->wo_repair_type == 'group') {
        //     $data = DB::table('wo_mstr')
        //         ->selectRaw('wo_number,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,
        //                     wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, 
        //                     loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart')
        //         ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
        //         ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
        //         ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
        //         ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
        //         ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
        //         ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
        //         ->leftjoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
        //         ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
        //         ->leftjoin('loc_mstr', 'asset_mstr.asset_loc', 'loc_mstr.loc_code')
        //         ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
        //         ->where('wo_mstr.wo_number', '=', $sr)
        //         ->get();
        //     // dd($data);
        //     // for($pa = 1; $pa <= 5; $pa++)
        //     // $engineername = DB::table('wo_mstr')
        //     //                 ->join('users','wo_mstr.wo_asset','asset_mstr.asset_code')
        //     //                 ->join('loc_mstr as a','asset_mstr.asset_site','a.loc_site')
        //     //                 ->join('loc_mstr as b','asset_mstr.asset_loc','b.loc_code')        
        //     //                 ->where('wo_mstr.wo_number','=',$sr)  
        //     //                 ->first();
        //     $grouprepair = DB::table('xxrepgroup_mstr')
        //         ->where('xxrepgroup_nbr', '=', $statusrepair->wo_repair_group)
        //         ->get();
        //     foreach ($grouprepair as $grouprepair) {
        //         array_push($arrayrepaircode, $grouprepair->xxrepgroup_rep_code);
        //     }
        //     // dd($arrayrepaircode);
        //     $countrepairitr = count($arrayrepaircode);
        //     for ($i = 0; $i < count($arrayrepaircode); $i++) {
        //         // dd($i);
        //         $repairdesc = DB::table('rep_master')
        //             ->where('rep_master.repm_code', '=', $arrayrepaircode[$i])
        //             ->first();

        //         if (!is_null($repairdesc)) {
        //             array_push($repairlist, $repairdesc->repm_desc);
        //         }

        //         $repair[$i] = DB::table('wo_mstr')
        //             ->join('xxrepgroup_mstr', 'wo_mstr.wo_repair_group', 'xxrepgroup_mstr.xxrepgroup_nbr')
        //             ->join('wo_dets', function ($join) {
        //                 $join->on('wo_dets.wo_dets_nbr', '=', 'wo_mstr.wo_number');
        //                 $join->on('wo_dets.wo_dets_rc', '=', 'xxrepgroup_mstr.xxrepgroup_rep_code');
        //             })
        //             ->join('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
        //             // ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //             ->join('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
        //             ->leftjoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
        //             ->where('wo_mstr.wo_number', '=', $sr)
        //             ->where('xxrepgroup_mstr.xxrepgroup_rep_code', '=', $arrayrepaircode[$i])
        //             ->get();
        //         // $repair[$i] = DB::table('xxrepgroup_mstr')
        //         //                 ->leftjoin('rep_master','xxrepgroup_mstr.xxrepgroup_rep_code','rep_master.repm_code')
        //         //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //         //                 // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        //         //                 // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        //         //                 // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        //         //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        //         //                 // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
        //         //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
        //         //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
        //         //                 // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
        //         //                 ->where('xxrepgroup_mstr.xxrepgroup_nbr','=',$statusrepair->wo_repair_group)

        //         //                 ->distinct('ins_mstr.ins_code')
        //         //                 ->orderBy('repm_ins','asc')

        //         //                 ->get();
        //         // dd(count($repair[$i]));
        //         foreach ($repair[$i] as $grouptool) {
        //             $newarr = explode(",", $grouptool->ins_tool);
        //             for ($po = 0; $po < count($newarr); $po++) {
        //                 $arr = DB::table('tool_mstr')
        //                     ->where('tool_code', '=', $newarr[$po])
        //                     ->first();
        //                 if (isset($arr->tool_desc)) {
        //                     $newarr[$po] = $arr->tool_desc;
        //                 } else {
        //                     $newarr[$po] = '';
        //                 }
        //             }
        //             $exparr = implode(",", $newarr);
        //             $grouptool->ins_tool = $exparr;
        //         }
        //         // dd($repair,$arrayrepaircode[$i],$i);
        //         $check[$i] = DB::table('wo_mstr')
        //             ->selectRaw('wrd_flag')
        //             ->leftjoin('wo_rc_detail as a', 'wo_mstr.wo_number', 'a.wrd_wo_nbr')
        //             ->where('wo_mstr.wo_number', '=', $sr)
        //             ->where('a.wrd_repair_code', '=', $arrayrepaircode[$i])
        //             ->first();
        //         if (isset($check[$i]) == true) {
        //             $checkstr[$i] = $check[$i]->wrd_flag;
        //         } else {
        //             $checkstr[$i] = 0;
        //         }
        //         // dd($repair[$i]);
        //         // dd(count($repair[$i]));    
        //         $countdb[$i] = count($repair[$i]);
        //     }
        //     // foreach($repair as $repair){
        //     //     // dd($repair);
        //     //     foreach($repair as $repair2){
        //     //         dd($repair2);
        //     //     }

        //     // }
        //     // dd($check[0]);
        //     // // dd($)
        //     // dd('aaa');

        // } else if ($statusrepair->wo_repair_type == 'code') {
        //     $data = DB::table('wo_mstr')
        //         ->selectRaw('wo_number,wo_repair_code1,wo_repair_code2,wo_repair_code3,wo_priority,wo_dept,dept_desc,
        //                     wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,
        //                     wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,
        //                     u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, 
        //                     u5.eng_desc as u55,loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,
        //                     wo_impact,wo_impact_desc,wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart')
        //         ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
        //         ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
        //         ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
        //         ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
        //         ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
        //         ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
        //         ->leftjoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
        //         ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
        //         ->leftjoin('loc_mstr', 'asset_mstr.asset_loc', 'loc_mstr.loc_code')
        //         ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
        //         ->where('wo_mstr.wo_number', '=', $sr)
        //         ->get();
        //     // dd($data[0]->wo_repair_code1);
        //     if (isset($data[0]->wo_repair_code1)) {
        //         array_push($arrayrepaircode, $data[0]->wo_repair_code1);
        //     }
        //     if (isset($data[0]->wo_repair_code2)) {
        //         array_push($arrayrepaircode, $data[0]->wo_repair_code2);
        //     }
        //     if (isset($data[0]->wo_repair_code3)) {
        //         array_push($arrayrepaircode, $data[0]->wo_repair_code3);
        //     }
        //     $countrepairitr = count($arrayrepaircode);
        //     // dd($arrayrepaircode);
        //     for ($i = 0; $i < count($arrayrepaircode); $i++) {
        //         // dd($arrayrepaircode);
        //         $repairdesc = DB::table('rep_master')
        //             ->where('rep_master.repm_code', '=', $arrayrepaircode[$i])
        //             ->first();

        //         if (!is_null($repairdesc)) {
        //             array_push($repairlist, $repairdesc->repm_desc);
        //         }

        //         $repair[$i] = DB::table('wo_mstr')
        //             ->leftjoin('wo_dets', 'wo_dets.wo_dets_nbr', 'wo_mstr.wo_number')
        //             ->leftjoin('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
        //             ->leftjoin('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
        //             // ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')

        //             ->leftjoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
        //             ->where('wo_mstr.wo_number', '=', $sr)
        //             ->where('wo_dets.wo_dets_rc', '=', $arrayrepaircode[$i])

        //             // ->groupBy('wo_mstr.wo_number','ins_mstr.ins_code')
        //             ->distinct('ins_mstr.ins_code')
        //             ->orderBy('repm_ins', 'asc')
        //             ->get();
        //         // dd($repair);
        //         // $repair[$i] = DB::table('rep_master')
        //         //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //         //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        //         //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
        //         //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
        //         //                 ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
        //         //                 ->distinct('ins_mstr.ins_code')
        //         //                 ->orderBy('repm_ins','asc')

        //         //                 ->get();

        //         // dd($repair);
        //         foreach ($repair[$i] as $grouptool) {
        //             $newarr = explode(",", $grouptool->ins_tool);
        //             for ($j = 0; $j < count($newarr); $j++) {
        //                 $arr = DB::table('tool_mstr')
        //                     ->where('tool_code', '=', $newarr[$j])
        //                     ->first();
        //                 if (isset($arr->tool_desc)) {
        //                     $newarr[$j] = $arr->tool_desc;
        //                 } else {
        //                     $newarr[$j] = '';
        //                 }
        //             }
        //             $exparr = implode(",", $newarr);
        //             $grouptool->ins_tool = $exparr;
        //         }

        //         $check[$i] = DB::table('wo_mstr')
        //             ->selectRaw('wrd_flag')
        //             ->leftjoin('wo_rc_detail as a', 'wo_mstr.wo_number', 'a.wrd_wo_nbr')
        //             ->where('wo_mstr.wo_number', '=', $sr)
        //             ->where('a.wrd_repair_code', '=', $arrayrepaircode[$i])
        //             ->first();
        //         if (isset($check[$i]) == true) {
        //             $checkstr[$i] = $check[$i]->wrd_flag;
        //         } else {
        //             $checkstr[$i] = 0;
        //         }
        //         // if(count($repair[$i])!= )

        //         // dd(count($repair[1]));
        //         $countdb[$i] = count($repair[$i]);
        //     }
        // }
        // // dd($data[0]->wo_number);
        // // $repair = DB::table('wo_mstr')
        // //         ->selectRaw('r1.repm_desc as r11,r2.repm_desc as r22, r3.repm_desc as r33')
        // //         ->leftjoin('rep_master as r1','wo_mstr.wo_repair_code1','r1.repm_code')
        // //         ->leftjoin('rep_master as r2','wo_mstr.wo_repair_code2','r2.repm_code')
        // //         ->leftjoin('rep_master as r3','wo_mstr.wo_repair_code3','r3.repm_code')
        // //         ->where('wo_mstr.wo_number','=',$sr)
        // //         ->get();
        // // $repair2 = DB::table('wo_mstr')
        // //         ->selectRaw('sp_mstr.spm_desc')
        // //         ->join('rep_master','wo_mstr.wo_repair_code2','rep_master.repm_code')
        // //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        // //             ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        // //             ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        // //             ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        // //             ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        // //         ->where('wo_mstr.wo_number','=',$sr)
        // //         // ->groupBy('spt_code')
        // //         ->orderBy('spt_desc')
        // //         ->get();
        // // $repair1 = DB::table('wo_mstr')
        // //         ->selectRaw('sp_mstr.spm_desc')
        // //         ->join('rep_master','wo_mstr.wo_repair_code1','rep_master.repm_code')
        // //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        // //         ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        // //         ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        // //         ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        // //         ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        // //         ->where('wo_mstr.wo_number','=',$sr)
        // //         // ->groupBy('spt_code')
        // //         ->orderBy('spt_desc')
        // //         ->get();
        // // $repair3 = DB::table('wo_mstr')
        // //         ->selectRaw('sp_mstr.spm_desc')
        // //         ->join('rep_master','wo_mstr.wo_repair_code3','rep_master.repm_code')
        // //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        // //             ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        // //             ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        // //             ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        // //             ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        // //         ->where('wo_mstr.wo_number','=',$sr)
        // //         // ->groupBy('spt_code')
        // //         ->orderBy('spt_desc')
        // //         ->get();

        // // $collcon = $repair1->concat($repair2)->concat($repair3);
        // // $array = [];
        // // dd($repairlist);
        // // foreach($engineerlist as $el){
        // //     dd($el);
        // // }
        // // dd($engineerlist);
        // // for($i = 0; $i < count($collcon);$i++){
        // //     if($collcon[$i]->spm_desc =='' || $collcon[$i]->spm_desc == null){
        // //         unset($collcon[$i]);       
        // //     }
        // //     else{
        // //         array_push($array,$collcon[$i]->spm_desc);
        // //     }
        // // }
        // // $array = array_values(array_unique($array));

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
        $pdf = PDF::loadview('service.pdfprint-template', ['impact' => $impact, 'engineerlist' => $engineerlist, 'womstr' => $womstr, 'srmstr' => $srmstr, 'dept' => $dept, 'printdate' => $printdate, 'users' => $users, 'datasr' => $datasr])->setPaper('A4', 'portrait');
        //return view('picklistbrowse.shipperprint-template',['printdata1' => $printdata1, 'printdata2' => $printdata2, 'runningnbr' => $runningnbr,'user' => $user,'last' =>$countprint]);
        return $pdf->stream($sr . '.pdf');
    }
}
