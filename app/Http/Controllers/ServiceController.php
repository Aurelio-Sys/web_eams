<?php

/*
Daftar perubahan :

A210927 : status approval user acceptance, jika reject statusnya incomplete, jadi dibedakan status close dan reject. kode status reject = 6
A211014 : status setelah Reviewer approve, jika sebelumnya finish diganti jadi 7 complete biar status nya sama kaya WO 
B211014 : join dengan tabel user diganti where, dari name - req_by diganti jadi username = req_username
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
use PDF;

use App;
use App\Exports\ExportSR;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
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


    public function servicerequest() /* route : servicerequest  blade : servicerequest_create */
    {
        $asset = DB::table('asset_mstr')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->where('asset_active', '=', 'Yes')
            ->where('asset_loc','=',session::get('department'))
            ->orderBy('asset_code')
            ->get();
        // dd(session::get('department'));
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

        $dataapp = DB::table('eng_mstr')
            ->where('eng_active','=','Yes')
            ->where('approver','=',1)
            ->orderBy('eng_code')
            ->get();
        // dd($asset);
        return view('service.servicerequest_create', ['showasset' => $asset, 'dept' => $datadepart, 
        'wotype' => $wotype, 'impact' => $impact, 'fc' => $fcode, 'dataapp' => $dataapp ]);
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

        DB::beginTransaction();

        try {
            if (isset($req->impact)) {
                $counterimpact = count($req->impact);
            } else {
                $counterimpact = 0;
            }
            

            $newimpact = "";

            for ($i = 0; $i < $counterimpact; $i++) {
                $newimpact .= $req->impact[$i] . ',';
            }

            $newimpact = substr($newimpact, 0, strlen($newimpact) - 1);

            $running = DB::table('running_mstr')
                ->first();

            $runnumber = DB::table('dept_mstr')
                            ->where('dept_code','=', session::get('department'))
                            ->first();
                            // dd(session::get('department'));            
            $newyear = Carbon::now()->format('y');

            // dd($runnumber);
            if($runnumber->dept_running_nbr == null){
                DB::rollBack();
                toast('Please set running number for department code '.session::get('department').' first.', 'error');
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

            
            if ($cekData->count() == 0) {

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
                    'sr_assetcode' => $req->assetcode,
                    'sr_failurecode1' => isset($req->failurecode[0]) ? $req->failurecode[0] : null,
                    'sr_failurecode2' => isset($req->failurecode[1]) ? $req->failurecode[1] : null,
                    'sr_failurecode3' => isset($req->failurecode[2]) ? $req->failurecode[2] : null,
                    'sr_wotype' => $req->wotype,
                    'sr_impact' => $newimpact,
                    'sr_note' => $req->notesr,
                    'sr_status' => '1', //1 = OPEN
                    'sr_priority' => $req->priority,
                    'sr_access' => 0,
                    'sr_approver' => $req->t_app,
                    'sr_date' => $req->t_date,
                    'sr_time' => $req->t_time,
                    'sr_dept' => Session::get('department'),
                    'req_by' => Session::get('name'),
                    'req_username' => Session::get('username'),
                    'sr_created_at' => Carbon::now()->toDateTimeString(),
                    'sr_updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('running_mstr')
                ->update([
                    'year' => $newyear,
                ]);

            DB::table('dept_mstr')
                ->where('dept_code','=',session::get('department'))
                ->update([
                    'dept_running_nbr' => $newtemprunnbr,
                ]);

            // nanti dibuka, masih error EmailScheduleJobs::dispatch('','','3','','',$runningnbr,'');

            DB::commit();
            toast('Service Request ' . $runningnbr . ' Successfully Created', 'success');
            return back();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Service Request Failed Created', 'error');
            return back();
        }
    }

    public function srapproval() /* blade : service.servicereq-approval */
    { 

        $kepalaengineer = DB::table('eng_mstr')
            ->where('approver', '=', 1)
            ->where('eng_active', '=', 'Yes')
            ->where('eng_code', '=', Session::get('username'))
            ->orderBy('eng_code')
            ->first();


        if ($kepalaengineer || Session::get('role') == 'ADMIN') {


            $data = DB::table('service_req_mstr')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                ->leftJoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
                // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                ->join('users', 'users.username', 'service_req_mstr.req_username')
                ->leftjoin('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                ->leftJoin('fn_mstr as k1', 'service_req_mstr.sr_failurecode1', 'k1.fn_code')
                ->leftJoin('fn_mstr as k2', 'service_req_mstr.sr_failurecode2', 'k2.fn_code')
                ->leftJoin('fn_mstr as k3', 'service_req_mstr.sr_failurecode3', 'k3.fn_code')
                ->selectRaw('service_req_mstr.*,asset_mstr.*,asset_type.*,loc_mstr.*,wotyp_mstr.*,users.*,dept_mstr.*,
                            k1.fn_desc as k11, k2.fn_desc as k22, k3.fn_desc as k33')
                ->where('sr_status', '=', '1')
                ->orderBy('sr_date','DESC')
                ->orderBy('sr_number', 'DESC');
            
            /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
            if (Session::get('role') <> 'ADMIN') {
                $data = $data->where('sr_approver','=',Session::get('username'));
            }

            $data = $data->paginate(10);

            $datarepair = DB::table('rep_master')
                ->orderBy('repm_code')
                ->get();

            $datasset = DB::table('asset_mstr')
                ->get();

            $datarepgroup = DB::table('xxrepgroup_mstr')
                ->selectRaw('MIN(xxrepgroup_id) as xxrepgroup_id , xxrepgroup_nbr, MIN(xxrepgroup_desc) as xxrepgroup_desc')
                ->groupBy('xxrepgroup_nbr')
                ->get();

            return view('service.servicereq-approval', ['datas' => $data, 'asset' => $datasset, 'repaircode' => $datarepair, 'repgroup' => $datarepgroup]);
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

    public function approval(Request $req)
    { /* blade : service.servicereq-approval */
        // dd($req->all());

        $wotype = $req->wotype;
        $imcode = $req->impactcode1;
        $imdesc = $req->impact;


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
                $wotype = $req->wotype;
                $imdesc = $req->impact;

                $statusakses = DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->first();

                if ($statusakses->sr_access == 0) {
                    DB::table('service_req_mstr')
                        ->where('sr_number', '=', $srnumber)
                        ->update(['sr_access' => 1]);
                } else {
                    toast('SR ' . $srnumber . ' is being used right now', 'error');
                    return back();
                }
                if ($statusakses->sr_status != '1') {
                    toast('SR ' . $srnumber . ' status has changed, please recheck', 'error');
                    return back();
                }


                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnumber)
                    ->update([
                        'sr_status' => '4',
                        'rejectnote' => $req->rejectreason,
                        'sr_access' => 0,
                    ]);

                //nanti dibuka EmailScheduleJobs::dispatch($wo,$asset,$a,'',$requestor,$srnumber,$rejectnote);

                toast('Service Request ' . $req->srnumber . '  Rejected Successfully ', 'success');
                return back();

                break;

            case 'approve': //jika diapprove
                $statusakses = DB::table('service_req_mstr')
                    ->where('sr_number', '=', $req->srnumber)
                    ->first();

                /* ditutup sementara
                if($statusakses->sr_access == 0){
                    DB::table('service_req_mstr')
                        ->where('sr_number','=', $req->srnumber)
                        ->update(['sr_access' => 1]);   
                }
                else{
                    toast('SR '.$req->srnumber.' is being used right now', 'error');
                    return back();
                }
                if($statusakses->sr_status != '1'){
                    toast('SR '.$req->srnumber.' status has changed, please recheck', 'error');
                    return back();
                } */


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




                $asset = $req->assetcode . ' -- ' . $req->assetdesc;

                $runningnbr = $running->wo_prefix . '-' . $newyear . '-' . $newtemprunnbr;

                $tampungarray = [];
                $tampungarray2 = [];

                if ($req->rad_repgroup == "code") {
                    $tampungarray = $req->enjiners;
                    $tampungarray2 = $req->repaircode;

                    $jmlarray = count($tampungarray);
                    $jmlarray2 = count($tampungarray2);
                    $repgroup = null;

                    $arrayarray = [];

                    if ($req->tmpfail1 == '-') {
                        $fail1 = null;
                    } else {
                        $fail1 = $req->tmpfail1;
                    }

                    if ($req->tmpfail2 == '-') {
                        $fail2 = null;
                    } else {
                        $fail2 = $req->tmpfail2;
                    }

                    if ($req->tmpfail3 == '-') {
                        $fail3 = null;
                    } else {
                        $fail3 = $req->tmpfail3;
                    }

                    if ($req->rad_repgroup == "group") {
                        $repgroup = $req->repgroup;
                    } else {
                        $repgroup = null;
                    }


                    $ambildata = DB::table('service_req_mstr')
                        ->where('sr_number', '=', $req->srnumber)
                        ->first();

                    // dd($ambildata);

                    $newimpact = str_replace(',', ';', $ambildata->sr_impact);

                    // dd($newimpact);

                    $impact = $ambildata->sr_impact;

                    $array_impact = explode(',', $impact);

                    // dd($array_impact);
                    $countarray = count($array_impact);
                    // dd($countarray);
                    $desc = "";

                    // $tampungdesc = [];

                    for ($i = 0; $i < $countarray; $i++) {

                        // dump($array_impact[$i]);

                        $impactdesc = DB::table('imp_mstr')
                            ->where('imp_code', '=', $array_impact[$i])
                            ->selectRaw('imp_desc')
                            ->first();

                        // dump($impactdesc);

                        $desc .= $impactdesc->imp_desc . ';';
                    }


                    $desc = substr($desc, 0, strlen($desc) - 1);

                    // dd($desc);

                    $arrayarray = [
                        'wo_nbr' => $runningnbr,
                        'wo_sr_nbr' => $req->srnumber,
                        'wo_asset' => $req->assetcode,
                        'wo_failure_code1' => $fail1,
                        'wo_failure_code2' => $fail2,
                        'wo_failure_code3' => $fail3,
                        'wo_engineer1' => null,
                        'wo_engineer2' => null,
                        'wo_engineer3' => null,
                        'wo_engineer4' => null,
                        'wo_engineer5' => null,
                        'wo_repair_code1' => null,
                        'wo_repair_code2' => null,
                        'wo_repair_code3' => null,
                        'wo_status' => 'plan', /* awalnya open, tapi karena ada WO release, status open hanya jika sudah whsconfirm */
                        'wo_repair_group' => null,
                        'wo_repair_type' => "code",
                        'wo_schedule' => $req->scheduledate,
                        'wo_duedate' => $req->duedate,
                        'wo_priority' => $req->priority,
                        'wo_dept' => $req->hiddendeptcode,
                        'wo_creator' => $req->hiddenreq,
                        'wo_approver' => $req->hiddenreq,
                        'wo_note' => $req->srnote,
                        'wo_created_at' => Carbon::now()->toDateTimeString(),
                        'wo_updated_at' => Carbon::now()->toDateTimeString(),
                        'wo_type'       => 'other',
                        'wo_new_type'       => $ambildata->sr_wotype,
                        'wo_impact'       => $newimpact,
                        'wo_impact_desc' => $desc
                    ];

                    // $arraysekian= [];

                    for ($i = 0; $i < $jmlarray; $i++) {
                        $test1 = $req->enjiners[$i];


                        $namakolom = 'wo_engineer' . ($i + 1);


                        $arrayarray[$namakolom] .= $test1;
                    }

                    for ($k = 0; $k < $jmlarray2; $k++) {
                        $test2 = $req->repaircode[$k];

                        $namakolom2 = 'wo_repair_code' . ($k + 1);
                        $arrayarray[$namakolom2] .= $test2;
                    }

                    // dd($arrayarray);
                    // dd($test2);

                    DB::table('wo_mstr')
                        ->insert($arrayarray);
                } elseif ($req->rad_repgroup == "group") {

                    $tampungarray = $req->enjiners;
                    $jmlarray = count($tampungarray);

                    $arrayarray = [];
                    if ($req->tmpfail1 == '-') {
                        $fail1 = null;
                    } else {
                        $fail1 = $req->tmpfail1;
                    }

                    if ($req->tmpfail2 == '-') {
                        $fail2 = null;
                    } else {
                        $fail2 = $req->tmpfail2;
                    }

                    if ($req->tmpfail3 == '-') {
                        $fail3 = null;
                    } else {
                        $fail3 = $req->tmpfail3;
                    }

                    $ambildata = DB::table('service_req_mstr')
                        ->where('sr_number', '=', $req->srnumber)
                        ->first();

                    // dd($ambildata);

                    $newimpact = str_replace(',', ';', $ambildata->sr_impact);

                    // dd($newimpact);

                    $impact = $ambildata->sr_impact;

                    $array_impact = explode(',', $impact);

                    // dd($array_impact);
                    $countarray = count($array_impact);

                    $desc = "";

                    // $tampungdesc = [];

                    for ($i = 0; $i < $countarray; $i++) {

                        // dump($array_impact[$i]);

                        $impactdesc = DB::table('imp_mstr')
                            ->where('imp_code', '=', $array_impact[$i])
                            ->selectRaw('imp_desc')
                            ->first();

                        // dump($impactdesc);

                        $desc .= $impactdesc->imp_desc . ';';
                    }


                    $desc = substr($desc, 0, strlen($desc) - 1);

                    $arrayarray = [];

                    $arrayarray = [
                        'wo_nbr' => $runningnbr,
                        'wo_sr_nbr' => $req->srnumber,
                        'wo_asset' => $req->assetcode,
                        'wo_failure_code1' => $fail1,
                        'wo_failure_code2' => $fail2,
                        'wo_failure_code3' => $fail3,
                        'wo_engineer1' => null,
                        'wo_engineer2' => null,
                        'wo_engineer3' => null,
                        'wo_engineer4' => null,
                        'wo_engineer5' => null,
                        'wo_repair_code1' => null,
                        'wo_repair_code2' => null,
                        'wo_repair_code3' => null,
                        'wo_status' => 'plan', /* awalnya open, tapi karena ada WO release, status open hanya jika sudah whsconfirm */
                        'wo_repair_group' => $req->repgroup,
                        'wo_repair_type' => "group",
                        'wo_schedule' => $req->scheduledate,
                        'wo_duedate' => $req->duedate,
                        'wo_priority' => $req->priority,
                        'wo_dept' => $req->hiddendeptcode,
                        'wo_creator' => $req->hiddenreq,
                        'wo_approver' => $req->hiddenreq,
                        'wo_note' => $req->srnote,
                        'wo_created_at' => Carbon::now()->toDateTimeString(),
                        'wo_updated_at' => Carbon::now()->toDateTimeString(),
                        'wo_type'      => 'other',
                        'wo_impact'     => $newimpact,
                        'wo_new_type'   => $ambildata->sr_wotype,
                        'wo_impact_desc' => $desc
                    ];

                    for ($i = 0; $i < $jmlarray; $i++) {
                        // dd('halllooo');
                        $test1 = $req->enjiners[$i];


                        $namakolom = 'wo_engineer' . ($i + 1);


                        $arrayarray[$namakolom] .= $test1;
                    }

                    // dd($arrayarray);
                    DB::table('wo_mstr')
                        ->insert($arrayarray);
                }

                // dd('stop here');

                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $req->srnumber)
                    ->update([
                        'wo_number' => $runningnbr,
                        'sr_status' => 2, //status SR = ASSIGNED
                        'sr_access' => 0
                    ]);

                //update running number


                DB::table('running_mstr')
                    ->update([
                        'year' => $newyear,
                        'wo_nbr' => $newtemprunnbr,
                    ]);

                $a = 2; //SR diapprove
                $wo = $runningnbr;
                $requestor = $req->hiddenreq;
                $srnumber = $req->srnumber;
                $rejectnote = $req->rejectreason;
                //nanti dibuka EmailScheduleJobs::dispatch($wo,$asset,$a,$tampungarray,$requestor,$srnumber,$rejectnote);

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
            // $period = $req->get('period');

            if ($srnumber == "" && $asset == "" && $priority == "") {
                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
                    // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                    ->join('users', 'users.username', 'service_req_mstr.req_username')
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->where('sr_status', '=', '1')
                    ->selectRaw('service_req_mstr.* , asset_mstr.asset_desc, asset_mstr.asset_code, dept_mstr.dept_desc, dept_mstr.dept_code, users.username, users.name, wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc')
                    ->orderBy('sr_number', 'DESC')
                    ->paginate(10);

                return view('service.table-srapproval', ['datas' => $data]);
            } else {
                // $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
                // $limahari = Carbon::now()->subDays(5)->toDateTimeString();


                // dd($tigahari,$limahari);

                $kondisi = "sr_created_at > 01-01-1900";





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

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                    ->leftJoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftJoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
                    // ->join('users', 'users.name', 'service_req_mstr.req_by')                  --> B211014
                    ->join('users', 'users.username', 'service_req_mstr.req_username')
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->where('sr_status', '=', '1')
                    ->whereRaw($kondisi)
                    ->selectRaw('service_req_mstr.* , asset_mstr.asset_desc, asset_mstr.asset_code, dept_mstr.dept_desc, dept_mstr.dept_code, users.username, users.name, wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc')
                    ->orderBy('sr_number', 'DESC')
                    ->paginate(10);

                return view('service.table-srapproval', ['datas' => $data]);
            }
        }
    }

    public function srbrowse() /* route : srbrowse   blade : service.servicereqbrowse */
    {
        $data = DB::table('service_req_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
            ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
            ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
            ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
            ->join('users', 'users.username', 'service_req_mstr.req_username')  //B211014
            ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
            ->leftjoin('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
            ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
            ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
            ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
            ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
            ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
            ->leftJoin('fn_mstr as k1', 'service_req_mstr.sr_failurecode1', 'k1.fn_code')
            ->leftJoin('fn_mstr as k2', 'service_req_mstr.sr_failurecode2', 'k2.fn_code')
            ->leftJoin('fn_mstr as k3', 'service_req_mstr.sr_failurecode3', 'k3.fn_code')
            ->selectRaw('service_req_mstr.* ,
                asset_mstr.asset_code, asset_mstr.asset_desc, dept_mstr.dept_desc, users.username,
                wotyp_mstr.* , asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc,
                u1.eng_desc as u11, u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55,
                wo_mstr.wo_start_date, wo_mstr.wo_finish_date, wo_mstr.wo_action, wo_mstr.wo_status,
                k1.fn_desc as k11, k2.fn_desc as k22, k3.fn_desc as k33')
            ->where('sr_dept','=',session::get('department'))
            ->orderBy('sr_date','DESC')
            ->orderBy('sr_number', 'DESC')
            // ->get();
            ->paginate(10);

        $datasset = DB::table('asset_mstr')
            ->get();

        $datauser = DB::table('users')
            ->where('active', '=', 'Yes')
            ->get();

        $ceksrfile = DB::table(('service_req_upload'))
            ->get();

        return view('service.servicereqbrowse', [
            'datas' => $data, 'asset' => $datasset, 'fromhome' => '',
            'users' => $datauser, 'ceksrfile' => $ceksrfile
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

        } catch ( FileNotFoundException $e) {
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
            ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
            ->join('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
            ->join('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
            ->join('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
            ->join('users', 'users.name', 'service_req_mstr.req_by')
            ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
            ->leftjoin('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
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
            $asset = $req->get('asset');
            $priority = $req->get('priority');
            // $period = $req->get('period');
            $status = $req->get('status');
            $requestby = $req->get('requestby');

            $ceksrfile = DB::table(('service_req_upload'))
                ->get();

            // dd($requestby);

            if ($srnumber == "" && $asset == "" && $priority == ""  /*&& $period == "" */ && $status == "" && $requestby == "") {
                // dd("test");
                // $dummy = DB::table('service_req_mstr')
                // ->selectRaw('wo_mstr.*,u1.eng_code as engcode1,u1.eng_desc as engdesc1,u2.eng_code as engcode2,u2.eng_desc as engdesc2,u3.eng_code as engcode3,u3.eng_desc as engdesc3')
                // ->leftjoin('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
                // ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                //     ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                //     ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                //     // ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                //     // ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                //         // ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                //         // ->join('users', 'users.name', 'service_req_mstr.req_by')
                //         // ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                //         ->paginate(10);

                // dd($dummy);

                // $data = DB::table('service_req_mstr')                                                //B211014
                //     ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                //     ->join('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                //     ->join('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                //     ->join('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
                //     ->join('users', 'users.name', 'service_req_mstr.req_by')
                //     ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                //     ->leftjoin('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
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
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
                    ->join('users', 'users.username', 'service_req_mstr.req_username')
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
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
                    ->orderBy('sr_number', 'DESC')
                    ->paginate(10);

                // dd($data);

                return view('service.table-srbrowse', ['datas' => $data, 'ceksrfile' => $ceksrfile]);
            } else {
                // dd("test2");
                $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
                $limahari = Carbon::now()->subDays(5)->toDateTimeString();

                $kondisi = "id_sr > 0";


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
                if ($asset != '') {
                    $kondisi .= " AND asset_desc LIKE '%" . $asset . "%'";
                }
                if ($status != '') {
                    $kondisi .= " AND sr_status = '" . $status . "' ";
                }
                if ($priority != '') {
                    $kondisi .= " AND sr_priority = '" . $priority . "'";
                }
                if ($requestby != '') {
                    $kondisi .= " AND req_username = '" . $requestby . "' ";
                }

                // dd($kondisi);

                // $data = DB::table('service_req_mstr')                                                //B211014
                //     ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                //     ->join('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                //     ->join('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                //     ->join('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
                //     ->join('users', 'users.name', 'service_req_mstr.req_by')
                //     ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                //     ->leftjoin('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
                //     ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                //     ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                //     ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                //     ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                //     ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                //     // ->selectRaw('*, u1.eng_desc as u11, u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55')
                //     ->selectRaw('service_req_mstr.* , asset_mstr.asset_desc, dept_mstr.dept_desc, users.username, wotyp_mstr.*, asset_type.astype_code, asset_type.astype_desc, loc_mstr.loc_code, loc_mstr.loc_desc, u1.eng_desc as u11, u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55')
                //     // ->where('sr_status', '=', '1')
                //     ->whereRaw($kondisi)
                //     ->orderBy('sr_number', 'DESC')
                //     ->paginate(10);

                $data = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                    ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
                    ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
                    ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_wotype')
                    ->join('users', 'users.username', 'service_req_mstr.req_username')
                    ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                    ->leftjoin('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
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
                    ->whereRaw($kondisi)
                    ->orderBy('sr_number', 'DESC')
                    ->paginate(10);

                return view('service.table-srbrowse', ['datas' => $data, 'ceksrfile' => $ceksrfile]);
            }
        }
    }

    public function searchimpact(Request $req)
    {
        // dd($req->all());
        if ($req->ajax()) {
            $impact = $req->impact;

            // dd($impact);

            $array_impact = explode(',', $impact);

            // dd($array_impact);
            $countarray = count($array_impact);
            // dd($countarray);
            $desc = "";

            // $tampungdesc = [];

            for ($i = 0; $i < $countarray; $i++) {

                // dump($array_impact[$i]);

                $impactdesc = DB::table('imp_mstr')
                    ->where('imp_code', '=', $array_impact[$i])
                    ->selectRaw('imp_desc')
                    ->first();

                // dump($impactdesc);

                $desc .= $impactdesc->imp_desc . ',';
            }


            $desc = substr($desc, 0, strlen($desc) - 1);
            // dd($desc);
            // dd($desc);




            // $output = $searchfail1[].$searchfail2.$searchfail3;

            return response()->json($desc);
        }
    }

    public function searchfailtype(Request $req)
    {
        if ($req->ajax()) {
            $failtype = $req->failtype;

            $data = "";

            $wotype = DB::table('wotyp_mstr')
                ->where('wotyp_code', '=', $failtype)
                ->selectRaw('wotyp_desc')
                ->first();


            $data = $wotype->wotyp_desc;



            return response()->json($data);
        }
    }

    public function  searchfailcode(Request $req)
    {
        if ($req->ajax()) {
            $failcode = $req->failcode;

            // dd($impact);

            $array_failcode = explode(';', $failcode);

            // dd($array_impact);
            $countarray = count($array_failcode);
            // dd($countarray);
            $desc = "";

            // $tampungdesc = [];

            for ($i = 0; $i < $countarray; $i++) {

                // dump($array_impact[$i]);

                $failcodedesc = DB::table('fn_mstr')
                    ->where('fn_code', '=', $array_failcode[$i])
                    ->selectRaw('fn_desc')
                    ->first();

                // dump($impactdesc);

                $desc .= $failcodedesc->fn_desc . ',';
            }


            $desc = substr($desc, 0, strlen($desc) - 1);
            // dd($desc);
            // dd($desc);




            // $output = $searchfail1[].$searchfail2.$searchfail3;

            return response()->json($desc);
        }
    }

    public function useracceptance(Request $req)
    {
        // dd(Session::get('username'));
        // dd('stop');
        if (Session::get('role') == 'ADM') {
            // dd('aadamin');
            $datas = DB::table('service_req_mstr')
                ->leftjoin('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
                ->leftjoin('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
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
                // ->where('req_username', '=', Session::get('username'))
                ->paginate(10);

            //dd('1');

            $datasset = DB::table('asset_mstr')
                ->get();
        } else {
            $datas = DB::table('service_req_mstr')
                ->join('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
                ->leftjoin('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
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
                ->where('req_username', '=', Session::get('username'))
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
                    ->where('wo_nbr', '=', $wonumber)
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
                    ->where('wo_nbr', '=', $wonumber)
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
                        ->join('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                        ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                        ->where('wo_status', '=', 'completed')
                        ->where('sr_status', '=', 4)
                        ->selectRaw('service_req_mstr.* , wo_mstr.*, asset_mstr.asset_desc, asset_mstr.asset_code, dept_mstr.*')
                        ->orderBy('sr_updated_at', 'DESC')
                        // ->where('req_username', '=', Session::get('username'))
                        ->paginate(10);

                    $datasset = DB::table('asset_mstr')
                        ->get();
                } else {
                    $datas = DB::table('service_req_mstr')
                        ->join('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                        ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                        ->where('wo_status', '=', 'completed')
                        ->where('sr_status', '=', 4)
                        ->where('req_username', '=', Session::get('username'))
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
                        ->join('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                        ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                        ->where('wo_status', '=', 'completed')
                        ->where('sr_status', '=', 4)
                        ->whereRaw($kondisi)
                        ->selectRaw('service_req_mstr.* , wo_mstr.*, asset_mstr.asset_desc, asset_mstr.asset_code, dept_mstr.*')
                        ->orderBy('sr_updated_at', 'DESC')
                        // ->where('req_username', '=', Session::get('username'))
                        ->paginate(10);

                    $datasset = DB::table('asset_mstr')
                        ->get();
                } else {
                    $datas = DB::table('service_req_mstr')
                        ->join('wo_mstr', 'wo_mstr.wo_nbr', 'service_req_mstr.wo_number')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                        ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
                        ->where('wo_status', '=', 'completed')
                        ->where('sr_status', '=', 4)
                        ->where('req_username', '=', Session::get('username'))
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
        $priority = $req->priority;
        $period   = $req->period;
        $reqby    = $req->reqby;

        return Excel::download(new ExportSR($srnbr, $status, $asset, $priority, $period, $reqby), 'Service Request.xlsx');
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
            ->selectRaw('fn1.fn_desc as fn1, fn2.fn_desc as fn2, fn3.fn_desc as fn3, dept_desc, eng_desc, sr_number, sr_wotype, sr_dept,
            sr_created_at, sr_assetcode, asset_desc, req_by, sr_approver, sr_impact, imp_desc, sr_date, sr_time, asset_desc, wotyp_desc, 
            sr_note, imp_code, dept_user, req_by, wo_nbr, wo_duedate, wo_schedule')
            ->leftjoin('eng_mstr', 'service_req_mstr.req_username', 'eng_mstr.eng_code')
            ->leftJoin('dept_mstr', 'service_req_mstr.sr_dept', 'dept_mstr.dept_code')
            ->leftJoin('asset_mstr', 'service_req_mstr.sr_assetcode', 'asset_mstr.asset_code')
            ->leftJoin('fn_mstr as fn1', 'service_req_mstr.sr_failurecode1', 'fn1.fn_code')
            ->leftJoin('fn_mstr as fn2', 'service_req_mstr.sr_failurecode2', 'fn2.fn_code')
            ->leftJoin('fn_mstr as fn3', 'service_req_mstr.sr_failurecode3', 'fn3.fn_code')
            ->leftJoin('wotyp_mstr', 'service_req_mstr.sr_wotype', 'wotyp_mstr.wotyp_code')
            ->leftJoin('wo_mstr', 'service_req_mstr.sr_number', 'wo_mstr.wo_sr_nbr')
            ->leftJoin('imp_mstr', 'service_req_mstr.sr_impact', 'imp_mstr.imp_code')
            ->leftJoin('users', 'service_req_mstr.sr_approver', 'users.username')
            ->first();

        $impact = DB::table(('imp_mstr'))
            ->get();
        $dept = DB::table(('dept_mstr'))
            ->get();
        // dd($srmstr);
        // $wodet = DB::table('wo_dets')
        //     ->join('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
        //     ->where('wo_dets_nbr', '=', $sr)
        //     ->get();
        // // dd($wodet);
        // $data = DB::table('wo_mstr')
        //     ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,
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

        //     ->where('wo_mstr.wo_nbr', '=', $sr)
        //     ->get();
        // // dd($data);
        // $statusrepair = DB::table('wo_mstr')
        //     ->where('wo_mstr.wo_nbr', '=', $sr)
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
        //     ->where('wo_mstr.wo_nbr', $sr)
        //     ->first();

        // // dd($engineerlist);
        // dd($statusrepair);
        // if ($statusrepair->wo_repair_type == 'manual') {
        //     $data = DB::table('wo_mstr')
        //         ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,
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
        //         ->where('wo_mstr.wo_nbr', '=', $sr)
        //         ->get();
        //     $datamanual = DB::table('wo_manual_detail')
        //         ->where('wo_manual_wo_nbr', '=', $sr)
        //         ->get();
        //     $countdb = count($datamanual);
        // } else if ($statusrepair->wo_repair_type == 'group') {
        //     $data = DB::table('wo_mstr')
        //         ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,
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
        //         ->where('wo_mstr.wo_nbr', '=', $sr)
        //         ->get();
        //     // dd($data);
        //     // for($pa = 1; $pa <= 5; $pa++)
        //     // $engineername = DB::table('wo_mstr')
        //     //                 ->join('users','wo_mstr.wo_asset','asset_mstr.asset_code')
        //     //                 ->join('loc_mstr as a','asset_mstr.asset_site','a.loc_site')
        //     //                 ->join('loc_mstr as b','asset_mstr.asset_loc','b.loc_code')        
        //     //                 ->where('wo_mstr.wo_nbr','=',$sr)  
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
        //                 $join->on('wo_dets.wo_dets_nbr', '=', 'wo_mstr.wo_nbr');
        //                 $join->on('wo_dets.wo_dets_rc', '=', 'xxrepgroup_mstr.xxrepgroup_rep_code');
        //             })
        //             ->join('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
        //             // ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //             ->join('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
        //             ->leftjoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
        //             ->where('wo_mstr.wo_nbr', '=', $sr)
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
        //             ->leftjoin('wo_rc_detail as a', 'wo_mstr.wo_nbr', 'a.wrd_wo_nbr')
        //             ->where('wo_mstr.wo_nbr', '=', $sr)
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
        //         ->selectRaw('wo_nbr,wo_repair_code1,wo_repair_code2,wo_repair_code3,wo_priority,wo_dept,dept_desc,
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
        //         ->where('wo_mstr.wo_nbr', '=', $sr)
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
        //             ->leftjoin('wo_dets', 'wo_dets.wo_dets_nbr', 'wo_mstr.wo_nbr')
        //             ->leftjoin('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
        //             ->leftjoin('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
        //             // ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')

        //             ->leftjoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
        //             ->where('wo_mstr.wo_nbr', '=', $sr)
        //             ->where('wo_dets.wo_dets_rc', '=', $arrayrepaircode[$i])

        //             // ->groupBy('wo_mstr.wo_nbr','ins_mstr.ins_code')
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
        //             ->leftjoin('wo_rc_detail as a', 'wo_mstr.wo_nbr', 'a.wrd_wo_nbr')
        //             ->where('wo_mstr.wo_nbr', '=', $sr)
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
        // // dd($data[0]->wo_nbr);
        // // $repair = DB::table('wo_mstr')
        // //         ->selectRaw('r1.repm_desc as r11,r2.repm_desc as r22, r3.repm_desc as r33')
        // //         ->leftjoin('rep_master as r1','wo_mstr.wo_repair_code1','r1.repm_code')
        // //         ->leftjoin('rep_master as r2','wo_mstr.wo_repair_code2','r2.repm_code')
        // //         ->leftjoin('rep_master as r3','wo_mstr.wo_repair_code3','r3.repm_code')
        // //         ->where('wo_mstr.wo_nbr','=',$sr)
        // //         ->get();
        // // $repair2 = DB::table('wo_mstr')
        // //         ->selectRaw('sp_mstr.spm_desc')
        // //         ->join('rep_master','wo_mstr.wo_repair_code2','rep_master.repm_code')
        // //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        // //             ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        // //             ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        // //             ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        // //             ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        // //         ->where('wo_mstr.wo_nbr','=',$sr)
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
        // //         ->where('wo_mstr.wo_nbr','=',$sr)
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
        // //         ->where('wo_mstr.wo_nbr','=',$sr)
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
        $pdf = PDF::loadview('service.pdfprint-template', ['impact' => $impact, 'srmstr' => $srmstr, 'dept' => $dept, 'printdate' => $printdate, 'users' => $users, 'datasr' => $datasr])->setPaper('A4', 'portrait');
        //return view('picklistbrowse.shipperprint-template',['printdata1' => $printdata1, 'printdata2' => $printdata2, 'runningnbr' => $runningnbr,'user' => $user,'last' =>$countprint]);
        return $pdf->stream($sr . '.pdf');
    }
}
