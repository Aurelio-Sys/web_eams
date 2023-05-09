<?php

/*
Daftar perubahan :

A210927 : status approval user acceptance, jika reject statusnya incomplete, jadi dibedakan status close dan reject. kode status reject = 6
A211014 : print WO yang bukan prefentif, Assign nya diganti nama bukan username dan dikasih tanggal approve user
A211019 : jika status reviewer Incomplete, maka tidak akan merubah status apapun di SR. Reviewer dapat melakukan complete WO ulang
B211019 : menyimpan NOte WO oleh reviewer ketika akan approve ulang WO yang statusnya Incomplete
A211021 : menambahkan fungsi email jika Wo sudah selesai di approve oleh Reviewer
A211022 : file yang diupload di WO Finish bukan hanya berupa gambar
A211025 : file yang disimpan saat finish PM bukan hanya gambar
A211026 : default repair code hanya satu saja, karena actualnya teknisi tidak akan input repair code. default repair code hanya satu untuk other
A211101 : perubahan nama status incomplete menjadi reprocess pada approval spv
A211103 : file yang didownload bukan hanya berupa gambar

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use PDF;
use File;
use App\User;
use Carbon\Carbon;
use Svg\Tag\Rect;
use App\Jobs\EmailScheduleJobs;
use App;
use App\Exports\ViewExport2;
use App\Jobs\SendWorkOrderCanceledNotification;
use App\Models\Qxwsa;
use App\Services\WSAServices;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use Response;
use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\CreateTempTable;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class wocontroller extends Controller
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
    //wo browse
    public function wobrowsemenu() /* route : wobrowse  blade : workorder.woview */
    {
        //dd(Session::get('department'));    
        if (strpos(Session::get('menu_access'), 'WO05') !== false) {
            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                ->where('username', '=', session()->get('username'))
                ->first();

            $data = DB::table('wo_mstr')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
                ->orderby('wo_created_at', 'desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                //->whereWo_nbr('WO-21-0036')
                //->get();
                ->paginate(10);
            //dd($data);

            $custrnow = DB::table('wo_mstr')
                ->selectRaw('wo_creator,min(name) as creator_desc')
                // ->join('eng_mstr','wo_mstr.wo_creator','eng_mstr.eng_code')
                ->join('users', 'wo_mstr.wo_creator', 'users.username')
                ->groupBy('wo_creator')
                ->get();
            // dd($custrnow);

            $depart = DB::table('dept_mstr')
                ->get();
            $engineer = DB::table('eng_mstr')
                ->where('eng_active', '=', 'Yes')
                ->orderBy('eng_code')
                ->get();
            $asset = DB::table('asset_mstr')
                ->where('asset_active', '=', 'Yes')
                ->orderBy('asset_code')
                ->get();
            $failure = DB::table('fn_mstr')
                ->get();
            $impact = DB::table('imp_mstr')
                ->get();
            $wottype = DB::table('wotyp_mstr')
                ->get();
            $ceksrfile = DB::table('service_req_upload')
                ->get();

            return view('workorder.woview', ['impact' => $impact, 'wottype' => $wottype, 'custrnow' => $custrnow, 'data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset, 'failure' => $failure, 'usernow' => $usernow, 'dept' => $depart, 'fromhome' => '', 'ceksrfile' => $ceksrfile]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    //wo create menu
    public function wocreatemenu()
    {
        // dd(Session::all())
        if (strpos(Session::get('menu_access'), 'WO04') !== false) {
            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();
            // dd($usernow);

            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')

                ->whereRaw('wo_sr_nbr is null')
                ->where('wo_status', '=', 'plan')
                ->where('wo_creator', '=', Session()->get('username'))
                // ->where(function($query){
                //     $query->where('wo_engineer1','=',Session()->get('username'))
                //     ->orwhere('wo_engineer2','=',Session()->get('username'))
                //     ->orwhere('wo_engineer3','=',Session()->get('username'))
                //     ->orwhere('wo_engineer4','=',Session()->get('username'))
                //     ->orwhere('wo_engineer5','=',Session()->get('username'));
                // })
                ->orderby('wo_created_at', 'desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(10);
            //  dd($data);
            $depart = DB::table('dept_mstr')
                ->get();
            $engineer = DB::table('eng_mstr')
                ->where('eng_active', '=', 'Yes')
                ->get();
            $asset = DB::table('asset_mstr')
                ->where('asset_active', '=', 'Yes')
                ->get();
            $failure = DB::table('fn_mstr')
                ->get();


            return view('workorder.wocreate', ['data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset, 'failure' => $failure, 'usernow' => $usernow, 'dept' => $depart, 'fromhome' => '']);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    public function wocreatedirectmenu()
    { // route : wocreatedirectmenu   blade : workorder.wocreatedirect
        // dd(Session::all())
        if (strpos(Session::get('menu_access'), 'WO05') !== false) {
            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();
            // dd($usernow);
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->where('wo_type', '=', 'direct')
                ->where('wo_status', '=', 'open')
                ->where(function ($query) {
                    $query->where('wo_engineer1', '=', Session()->get('username'))
                        ->orwhere('wo_engineer2', '=', Session()->get('username'))
                        ->orwhere('wo_engineer3', '=', Session()->get('username'))
                        ->orwhere('wo_engineer4', '=', Session()->get('username'))
                        ->orwhere('wo_engineer5', '=', Session()->get('username'));
                })
                ->orderby('wo_created_at', 'desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(10);
            // dd($data);
            $depart = DB::table('dept_mstr')
                ->get();
            $engineer = DB::table('eng_mstr')
                ->where('eng_active', '=', 'Yes')
                ->where('eng_code', '<>', Session::get('username'))
                ->orderBy('eng_code')
                ->get();

            $asset = DB::table('asset_mstr')
                ->where('asset_active', '=', 'Yes')
                ->orderBy('asset_code')
                ->get();
            $failure = DB::table('fn_mstr')
                ->get();
            $repaircode = DB::table('rep_master')
                ->get();
            $sparepart = DB::table('sp_mstr')
                ->get();
            $repairgroup = DB::table('xxrepgroup_mstr')
                ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                ->distinct('xxrepgroup_nbr')
                ->get();
            $instruction = DB::table('ins_mstr')
                ->get();
            $impact = DB::table('imp_mstr')
                ->get();
            $wottype = DB::table('wotyp_mstr')
                ->get();
            return view('workorder.wocreatedirect', ['impact' => $impact, 'wottype' => $wottype, 'instruction' => $instruction, 'data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset, 'failure' => $failure, 'usernow' => $usernow, 'dept' => $depart, 'fromhome' => '', 'repairgroup' => $repairgroup, 'repaircode' => $repaircode, 'sparepart' => $sparepart]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    // WO maint
    public function wobrowse(Request $req)
    {         // route : womaint  blade : workorder.wobrowse
        if (strpos(Session::get('menu_access'), 'WO01') !== false) {
            // dd(Session::all());
            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                ->where('username', '=', session()->get('username'))
                ->get();

            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code');

            // if (Session::get('role') <> 'ADMIN') {
            //     $data = $data->where('wo_dept','=',session::get('department'));
            // }
            if ($req->s_nomorwo) {
                $data->where('wo_number', 'like', '%' . $req->s_nomorwo . '%');
            }
            if ($req->s_asset) {
                $data->where('asset_code', $req->s_asset);
            }
            if ($req->s_status) {
                $data->where('wo_status', $req->s_status);
            }
            if ($req->s_wotype) {
                $data->where('wo_type', $req->s_wotype);
            }
            if ($req->s_engineer) {
                $data->where('wo_list_engineer', 'like', '%' . $req->s_engineer . '%');
            }

            $data = $data->orderby('wo_system_create', 'desc')->orderBy('wo_number', 'desc')->paginate(10);

            $depart = DB::table('dept_mstr')
                ->get();
            $engineer = DB::table('eng_mstr')
                ->where('eng_active', '=', 'Yes')
                ->orderBy('eng_code')
                ->get();
            $asset = DB::table('asset_mstr')
                ->where('asset_active', '=', 'Yes')
                ->orderBy('asset_code')
                ->get();

            $failure = DB::table('fn_mstr')
                ->leftJoin('asfn_det', 'asfn_det.asfn_fncode', 'fn_mstr.fn_code')
                ->groupBy('fn_code')
                ->get();


            $maintenance = DB::table('pmc_mstr')->get();

            $inslist = DB::table('ins_list')->groupBy('ins_code')->get();

            $splist = DB::table('spg_list')->groupBy('spg_code')->get();

            $qclist = DB::table('qcs_list')->groupBy('qcs_code')->get();

            $impact = DB::table('imp_mstr')
                ->get();
            $wottype = DB::table('wotyp_mstr')
                // ->leftJoin('asfn_det','asfn_det.asfn_fntype','wotyp_mstr.wotyp_code')
                // ->groupBy('asfn_asset','asfn_fntype')
                ->get();

            // dd($wottype);
            $ceksrfile = DB::table(('service_req_upload'))
                ->get();
            return view('workorder.wobrowse', [
                'impact' => $impact, 'wottype' => $wottype, 'data' => $data,
                'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset,
                'failure' => $failure, 'usernow' => $usernow, 'dept' => $depart, 'fromhome' => '',
                'maintenancelist' => $maintenance, 'ceksrfile' => $ceksrfile, 'inslist' => $inslist, 'splist' => $splist,
                'qclist' => $qclist
            ]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    //tyas, link dari Home 
    public function wobrowseopen()
    {
        if (strpos(Session::get('menu_access'), 'WO01') !== false) {
            // dd(Session::all());
            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();
            // dd($usernow);
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->WHERE('wo_status', '=', 'open')
                ->orderby('wo_updated_at', 'desc')
                ->orderBy('wo_mstr.wo_nbr', 'desc')
                ->paginate(10);
            //   dd($data);
            $depart = DB::table('dept_mstr')
                ->get();
            $engineer = DB::table('eng_mstr')
                ->where('eng_active', '=', 'Yes')
                ->get();
            $asset = DB::table('asset_mstr')
                ->orderBy('asset_code')
                ->get();

            $failure = DB::table('fn_mstr')
                ->get();
            $repaircode = DB::table('rep_master')
                ->get();
            $repairgroup = DB::table('xxrepgroup_mstr')
                ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                ->distinct('xxrepgroup_nbr')
                ->get();
            return view('workorder.wobrowse', ['repairgroup' => $repairgroup, 'data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset, 'failure' => $failure, 'usernow' => $usernow, 'dept' => $depart, 'fromhome' => '', 'repaircode' => $repaircode]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    public function createdirectwo(Request $req)
    { /* blade : workorder.wocreatedirect */
        // dd($req->all());
        $fn1 = null;
        $fn2 = null;
        $fn3 = null;
        $rc1 = null;
        $rc2 = null;
        $rc3 = null;
        $rprg = null;
        $rprtype = null;
        $finisht = null;
        $cimpactlist = '';
        $cimpactdesclist = '';
        $c_wotype = null;
        $eng2 = null;
        $eng3 = null;
        $eng4 = null;
        $eng5 = null;
        $wotype = null;
        $action = null;
        $sp = null;
        if (isset($req->o_part)) {
            $sp = $req->o_part;
        }
        if (isset($req->o_action)) {
            $action = $req->o_action;
        }
        if ($req->cwotype == 'manual') {
            $wotype = 'other';
        } else {
            $wotype = 'auto';
        }
        if (isset($req->c_engineeroth[0])) {
            $eng2 = $req->c_engineeroth[0];
        }
        if (isset($req->c_engineeroth[1])) {
            $eng3 = $req->c_engineeroth[1];
        }
        if (isset($req->c_engineeroth[2])) {
            $eng4 = $req->c_engineeroth[2];
        }
        if (isset($req->c_engineeroth[3])) {
            $eng5 = $req->c_engineeroth[3];
        }
        foreach ($req->c_impact as $cimpact) {
            if ($cimpact != '') {

                $testimp = DB::table('imp_mstr')
                    ->where('imp_code', '=', $cimpact)
                    ->first();
                $cimpactdesclist .= $testimp->imp_desc . ';';
                //    dd($cimpact,$testimp); 
            }
            $cimpactlist .= $cimpact . ';';
        }
        //dd($req->get('c_engineer')[0]);
        //dd($req->get('c_engineer')[4]);
        $tablern = DB::table('running_mstr')
            ->first();
        $newyear = Carbon::now()->format('y');

        if ($tablern->year == $newyear) {
            $tempnewrunnbr = strval(intval($tablern->wd_nbr) + 1);
            $newtemprunnbr = '';

            if (strlen($tempnewrunnbr) < 6) {
                $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
            }
        } else {
            $newtemprunnbr = "000001";
        }

        $runningnbr = $tablern->wd_prefix . '-' . $newyear . '-' . $newtemprunnbr;
        if ($wotype == 'auto') {
            if (isset($req->repairtype)) {
                if ($req->repairtype == 'manual') {
                    //  dd($req->manualcount);
                    DB::table('wo_manual_detail')
                        ->where('wo_manual_wo_nbr', '=', $runningnbr)
                        ->delete();

                    for ($pop = 0; $pop < $req->manualcount; $pop++) {
                        if ($req->ins[$pop] != null && $req->part[$pop] != null && $req->desc[$pop] != null) {
                            $arraymanual = array([
                                'wo_manual_wo_nbr'      => $runningnbr,
                                'wo_manual_number'      => $pop + 1,
                                'wo_manual_ins'         => $req->ins[$pop],
                                'wo_manual_part'        => $req->part[$pop],
                                'wo_manual_desc'        => $req->desc[$pop],
                                'wo_manual_flag'        => $req->group5[$pop],
                                'wo_manual_flag2'       => $req->group51[$pop],
                                'wo_manual_qty'         => $req->qty5[$pop],
                                'wo_manual_repair_hour' => $req->rph5[$pop],
                                'wo_manual_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                            ]);
                            // dd($arraydettemp);
                            DB::table('wo_manual_detail')->insert($arraymanual);
                        }
                    }
                    $finisht = $req->c_finishtime . ':' . $req->c_finishtimeminute;
                    $rprtype = 'manual';
                } else if ($req->repairtype == 'code') {
                    // dd('aaa');  

                    $c_wotype = 'code';
                    // DB::table('wo_rc_detail')
                    //     ->where('wrd_wo_nbr', '=', $runningnbr)
                    //     ->delete();

                    if ($req->has('repaircode1')) {
                        $rc1 = $req->repaircode1[0];

                        /*
                        $dborigin = DB::table('rep_master')
                            ->leftjoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                            ->leftjoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                            // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                            ->leftjoin('sp_mstr', 'ins_mstr.ins_part', 'sp_mstr.spm_code')
                            ->where('rep_master.repm_code', '=', $rc1)
                            // ->groupBy('spt_code')
                            ->orderBy('repdet_step')
                            ->get();
                        // dd($dborigin,$rc1);
                        $countdb1 = count($dborigin);
                        // dd($countdb1);
                        $flagname = '';
                        for ($i = 0; $i < $countdb1; $i++) {
                            $newname = 'group' . $i;
                            if (isset($req->group1[$i])) {
                                $flagname .= $req->group1[$i];
                                $flagnow = $req->group1[$i];
                                $funow   = $req->group11[$i];
                                $notenow = $req->note1[$i];
                            }
                            // dd($req->all());
                            $arraydets1 = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $req->repaircode1[0],
                                'wo_dets_sp'        => $req->spm1[$i],
                                'wo_dets_sp_qty'    => $req->qty1[$i],
                                'wo_dets_ins'       => $req->ins1[$i],
                                //'wo_dets_flag'      => $flagnow,
                                //'wo_dets_fu'        => $funow,
                                //'wo_dets_fu_note'   => $notenow,
                                'wo_dets_rep_hour'  => $req->rph1[$i],
                                'wo_dets_standard'  => $req->std1[$i],
                                'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            // dd($arraydets1);
                            DB::table('wo_dets')->insert($arraydets1);
                        }
                        // dd($flagname);
                        $arrayrc1 = array([
                            'wrd_wo_nbr'      => $runningnbr,
                            'wrd_repair_code' => $req->repaircode1[0],
                            'wrd_flag'        => $flagname,
                            'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                        ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc1);

                        // for($i2 = 0; $i2 < count($req->spm1); $i2++){  
                        //     $arraydets1 = array([
                        //         'wo_dets_nbr'       => $req->c_wonbr,
                        //         'wo_dets_rc'        => $req->repaircode1[0],
                        //         'wo_dets_sp'        => $req->spm1[$i2],
                        //         'wo_dets_sp_qty'    => $req->qty1[$i2],
                        //         'wo_dets_ins'       => $req->ins1[$i2],
                        //         'wo_dets_rep_hour'  => $req->rph1[$i2],
                        //         'wo_dets_standard'  => $req->std1[$i2],
                        //         'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        //     ]);
                        //         // dd($arraydettemp);
                        //         DB::table('wo_dets')->insert($arraydets1);
                        // }

                        for ($ii = 0; $ii < $req->sparepartnum1; $ii++) {
                            $arrayspare1 = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $req->repaircode1[0],
                                'wo_dets_sp'        => $req->partspare1[$ii],
                                'wo_dets_sp_qty'    => $req->qtyspare1[$ii],
                                'wo_dets_ins'       => $req->insspare1[$ii],
                                'wo_dets_rep_hour'  => $req->rphspare1[$ii],
                                'wo_dets_standard'  => $req->descspare1[$ii],
                                'wo_dets_flag'      => $req->groupspare1[$ii],
                                'wo_dets_fu'        => $req->groupspare11[$ii],
                                'wo_dets_fu_note'   => $req->note11[$ii],
                                'wo_dets_type'      => 'addition',
                                'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arrayspare1);
                        }

                        */
                    }
                    if ($req->has('repaircode2')) {
                        $rc2 = $req->repaircode2[0];
                        /*
                        $dborigin2 = DB::table('rep_master')
                            ->join('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                            ->join('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                            // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                            ->leftjoin('sp_mstr', 'ins_mstr.ins_part', 'sp_mstr.spm_code')
                            ->where('rep_master.repm_code', '=', $rc2)
                            ->orderBy('repdet_step')
                            ->get();

                        $countdb2 = count($dborigin2);
                        // dd($req->all)
                        $flagname2 = '';
                        // dd($countdb2);
                        for ($i = 0; $i < $countdb2; $i++) {
                            $newname2 = 'group' . $i;
                            // dd($newname2);
                            if (isset($req->group2[$newname2])) {
                                $flagname .= $req->group1[$i];
                                $flagnow = $req->group2[$i];
                                $funow   = $req->group21[$i];
                                $notenow = $req->note2[$i];
                            }

                            $arraydets2 = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $req->repaircode2[0],
                                'wo_dets_sp'        => $req->spm2[$i],
                                'wo_dets_sp_qty'    => $req->qty2[$i],
                                'wo_dets_ins'       => $req->ins2[$i],
                                'wo_dets_flag'      => $flagnow,
                                'wo_dets_fu'        => $funow,
                                'wo_dets_fu_note'   => $notenow,
                                'wo_dets_rep_hour'  => $req->rph2[$i],
                                'wo_dets_standard'  => $req->std2[$i],
                                'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arraydets2);
                        }


                        $arrayrc2 = array([
                            'wrd_wo_nbr'      => $runningnbr,
                            'wrd_repair_code' => $req->repaircode2[0],
                            'wrd_flag'        => $flagname2,
                            'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                        ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc2);


                        for ($iii = 0; $iii < $req->sparepartnum2; $iii++) {
                            $arrayspare2 = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $req->repaircode2[0],
                                'wo_dets_sp'        => $req->partspare2[$iii],
                                'wo_dets_sp_qty'    => $req->qtyspare2[$iii],
                                'wo_dets_ins'       => $req->insspare2[$iii],
                                'wo_dets_rep_hour'  => $req->rphspare2[$iii],
                                'wo_dets_standard'  => $req->descspare2[$iii],
                                'wo_dets_flag'      => $req->groupspare2[$iii],
                                'wo_dets_fu'        => $req->groupspare21[$iii],
                                'wo_dets_fu_note'   => $req->note22[$iii],
                                'wo_dets_type'      => 'addition',
                                'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arrayspare2);
                        }
                        */
                    }
                    if ($req->has('repaircode3')) {
                        $rc3 = $req->repaircode3[0];
                        /*
                        $dborigin3 = DB::table('rep_master')
                            ->join('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                            ->join('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                            // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                            ->leftjoin('sp_mstr', 'ins_mstr.ins_part', 'sp_mstr.spm_code')
                            ->where('rep_master.repm_code', '=', $rc3)
                            // ->groupBy('spt_code')
                            ->orderBy('repdet_step')
                            ->get();
                        $countdb3 = count($dborigin3);

                        $flagname = '';
                        for ($i = 0; $i < $countdb3; $i++) {
                            $newname = 'group' . $i;
                            if (isset($req->group3[$i])) {
                                $flagname .= $req->group3[$i];
                                $flagnow = $req->group3[$i];
                                $funow   = $req->group31[$i];
                                $notenow = $req->note3[$i];
                            }

                            $arraydets3 = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $req->repaircode3[0],
                                'wo_dets_sp'        => $req->spm3[$i],
                                'wo_dets_sp_qty'    => $req->qty3[$i],
                                'wo_dets_ins'       => $req->ins3[$i],
                                'wo_dets_flag'      => $flagnow,
                                'wo_dets_fu'        => $funow,
                                'wo_dets_fu_note'   => $notenow,
                                'wo_dets_rep_hour'  => $req->rph3[$i],
                                'wo_dets_standard'  => $req->std3[$i],
                                'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arraydets3);
                        }
                        $arrayrc3 = array([
                            'wrd_wo_nbr'      => $runningnbr,
                            'wrd_repair_code' => $req->repaircode3[0],
                            'wrd_flag'        => $flagname,
                            'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                        ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc3);

                        // for($i4 = 0; $i4 < count($req->spm3); $i4++){  
                        //     $arraydets3 = array([
                        //         'wo_dets_nbr'       => $req->c_wonbr,
                        //         'wo_dets_rc'        => $req->repaircode3[0],
                        //         'wo_dets_sp'        => $req->spm3[$i4],
                        //         'wo_dets_sp_qty'    => $req->qty3[$i4],
                        //         'wo_dets_ins'       => $req->ins3[$i4],
                        //         'wo_dets_rep_hour'  => $req->rph3[$i4],
                        //         'wo_dets_standard'  => $req->std3[$i4],
                        //         'wo_dets_flag'      => $req->group3[$i4],
                        //         'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        //     ]);
                        //         // dd($arraydettemp);
                        //         DB::table('wo_dets')->insert($arraydets3);
                        // }

                        for ($iiii = 0; $iiii < $req->sparepartnum3; $iiii++) {
                            $arrayspare3 = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $req->repaircode3[0],
                                'wo_dets_sp'        => $req->partspare3[$iiii],
                                'wo_dets_sp_qty'    => $req->qtyspare3[$iiii],
                                'wo_dets_ins'       => $req->insspare3[$iiii],
                                'wo_dets_rep_hour'  => $req->rphspare3[$iiii],
                                'wo_dets_standard'  => $req->descspare3[$iiii],
                                'wo_dets_flag'      => $req->groupspare3[$iiii],
                                'wo_dets_fu'        => $req->groupspare31[$iiii],
                                'wo_dets_fu_note'   => $req->note33[$iiii],
                                'wo_dets_type'      => 'addition',
                                'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arrayspare3);
                        }
                        
                        */
                    }


                    //  dd($req->all());
                    // $finisht = $req->c_finishtime . ':' . $req->c_finishtimeminute; 


                    $rprtype = 'code';
                    // dd($finisht);

                    // dd($arrayy);
                } else if ($req->repairtype == 'group') {
                    $rprg = $req->repairgroup[0];

                    /*
                    DB::table('wo_rc_detail')
                        ->where('wrd_wo_nbr', '=', $runningnbr)
                        ->delete();

                    $repairlen = count($req->repaircodeselection);
                    for ($i = 0; $i < $repairlen; $i++) {
                        $rg = $req->repaircodeselection[$i];
                        $dborigin = DB::table('rep_master')
                            ->join('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                            ->join('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                            // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                            ->leftjoin('sp_mstr', 'ins_mstr.ins_part', 'sp_mstr.spm_code')
                            ->where('rep_master.repm_code', '=', $rg)
                            // ->groupBy('spt_code')
                            ->orderBy('repdet_step')
                            ->get();
                        $countdb1 = count($dborigin);
                        // dd($dborigin);
                        $flagname = '';
                        for ($j = 0; $j < $countdb1; $j++) {
                            $newname = 'group' . $i;
                            if (isset($req->group4[$i][$j])) {
                                $flagnow = $req->group4[$i][$j];
                                $funow   = $req->group41[$i][$j];
                                $notenow = $req->note[$i][$j];

                                $flagname .= $req->group4[$i][$j];
                            }

                            $arraydetsgrp = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $rg,
                                'wo_dets_sp'        => $req->spm4[$i][$j],
                                'wo_dets_sp_qty'    => $req->qty4[$i][$j],
                                'wo_dets_ins'       => $req->insm4[$i][$j],
                                'wo_dets_flag'      => $flagnow,
                                'wo_dets_fu'        => $funow,
                                'wo_dets_fu_note'   => $notenow,
                                'wo_dets_rep_hour'  => $req->rph4[$i][$j],
                                'wo_dets_standard'  => $req->std4[$i][$j],
                                'wo_dets_flag'      => $req->group4[$i][$j],
                                'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arraydetsgrp);
                        }



                        $arrayrc1 = array([
                            'wrd_wo_nbr'      => $req->$runningnbr,
                            'wrd_repair_code' => $rg,
                            'wrd_flag'        => $flagname,
                            'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                        ]);
                        DB::table('wo_rc_detail')->insert($arrayrc1);

                        // dd($arraydettemp);   
                        // for($i5 = 0; $i5 < $countdb1; $i5++){  
                        //     // eval('$spnow = $req->sparepart'.strval($countrepair).');');



                        // }
                        // dd('stop');

                        eval('$spartnow = $req->partspare' . strval($i + 1) . ';');
                        eval('$insspnow = $req->insspare' . strval($i + 1) . ';');
                        eval('$spstdnow = $req->descspare' . strval($i + 1) . ';');
                        eval('$spqtynow = $req->qtyspare' . strval($i + 1) . ';');
                        eval('$rphspnow = $req->rphspare' . strval($i + 1) . ';');
                        eval('$spflagnow = $req->groupspare' . strval($i + 1) . ';');
                        eval('$spfunow = $req->groupspare' . strval($i + 1) . '1;');
                        eval('$spfunotenow = $req->groupspare' . strval($i + 1) . ';');

                        for ($iiiii = 0; $iiiii < $req->sparepartnum[$i]; $iiiii++) {

                            $arraysparegrp = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $rg,
                                'wo_dets_sp'        => $spartnow[$iiiii],
                                'wo_dets_sp_qty'    => $spqtynow[$iiiii],
                                'wo_dets_ins'       => $insspnow[$iiiii],
                                'wo_dets_rep_hour'  => $rphspnow[$iiiii],
                                'wo_dets_standard'  => $spstdnow[$iiiii],
                                'wo_dets_flag'      => $spflagnow[$iiiii],
                                'wo_dets_fu'        => $spfunow[$iiiii],
                                'wo_dets_fu_note'   => $spfunotenow[$iiiii],
                                'wo_dets_type'      => 'addition',
                                'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arraysparegrp);
                        }

                        // dd($flagname);
                    }
                    $finisht = $req->c_finishtime . ':' . $req->c_finishtimeminute;
                    */
                    $rprtype = 'group';
                }
            }
        } else {
            // dd('manual');
            $rc1 = $req->has('repaircode1') ? $req->repaircode1[0] : null;
            $rc2 = $req->has('repaircode2') ? $req->repaircode2[0] : null;
            $rc3 = $req->has('repaircode3') ? $req->repaircode3[0] : null;

            if ($rc1 != null || $rc2 != null || $rc3 != null) {
                $rprtype = 'code';
            }

            $rprg = $req->has('repairgroup') ? $req->repairgroup[0] : null;

            if ($rprg != null) {
                $rprtype = 'group';
            }


            // dd($rc1,$rc2,$rc3);


        }
        $dataarray = array(
            'wo_nbr'           => $runningnbr,
            'wo_dept'          => Session::get('department'),
            'wo_engineer1'     => $req->engineercreate,
            'wo_engineer2'     => $eng2,
            'wo_engineer3'     => $eng3,
            'wo_engineer4'     => $eng4,
            'wo_engineer5'     => $eng5,
            'wo_repair_code1'  => $rc1,
            'wo_repair_code2'  => $rc2,
            'wo_repair_code3'  => $rc3,
            'wo_repair_group'  => $rprg,
            'wo_repair_type'   => $rprtype,
            'wo_new_type'      => $req->c_wottype,
            'wo_impact'        => $cimpactlist,
            'wo_impact_desc'   => $cimpactdesclist,
            // 'wo_repair_hour'   => $req->c_repairhour,
            'wo_finish_date'   => $req->c_finishdate,
            'wo_finish_time'   => $finisht,
            'wo_asset'         => $req->c_asset,
            'wo_priority'      => $req->c_priority,
            'wo_status'        => 'plan',
            'wo_schedule'      => $req->c_schedule,
            'wo_duedate'       => $req->c_duedate,
            'wo_note'          => $req->c_note,
            'wo_action'         => $action,
            'wo_sparepart'      => $sp,
            'wo_type'           => $wotype,
            'wo_creator'       => session()->get('username'),
            'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
            'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
            // 'wo_start_date'    => Carbon::now('ASIA/JAKARTA')->toDateString(),
            // 'wo_start_time'    => Carbon::now('ASIA/JAKARTA')->toTimeString(),
            'wo_created_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_updated_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
        );
        // dd($dataarray);
        DB::table('wo_mstr')->insert($dataarray);
        DB::table('running_mstr')
            ->where('wd_nbr', '=', $tablern->wd_nbr)
            ->update([
                'year' => $newyear,
                'wd_nbr' => $newtemprunnbr
            ]);

        $albumraw = $req->imgname;
        if (isset($req->imgname)) {
            foreach ($albumraw as $olah1) {
                $waktu = (string)date('dmY', strtotime(Carbon::now())) . (string)date('His', strtotime(Carbon::now()));
                // dd($waktu);
                $jadi1 = explode(',', $olah1);
                // a..png
                $jadi2 = base64_decode($jadi1[2]);
                $lenstr = strripos($jadi1[0], '.');
                $test = substr($jadi1[0], $lenstr);
                // dd($test);
                $test3 = str_replace($test, '', $jadi1[0]);
                // dd($test3);
                $test4 = str_replace('.', '', $test3);
                $test44 = str_replace(' ', '', $test4);
                $test5 = $test44 . $waktu . $test;
                $alamaturl = '../public/upload/' . $test5;
                file_put_contents($alamaturl, $jadi2);

                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $req->c_srnbr,
                        'file_wonumber' => $runningnbr,
                        'file_name' => $jadi1[0], //nama file asli
                        'file_url' => $alamaturl,
                        'uploaded_at' => Carbon::now()->toDateTimeString(),
                    ]);
            }
        }

        if ($req->hasfile('filenamewo')) {
            foreach ($req->file('filenamewo') as $upload) {
                $filename = $runningnbr . '-' . $upload->getClientOriginalName();

                // Simpan File Upload pada Public
                $savepath = public_path('uploadwofinish/');
                $upload->move($savepath, $filename);

                // Simpan ke DB Upload
                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $req->c_srnbr,
                        'file_wonumber' => $runningnbr,
                        'file_name'     => $filename, //$upload->getClientOriginalName(), //nama file asli
                        'file_url'      => $savepath . $filename,
                        'uploaded_at'   => Carbon::now()->toDateTimeString(),
                    ]);
            }
        }


        $assettable = DB::table('asset_mstr')
            ->where('asset_code', '=', $req->c_asset)
            ->first();

        $asset = $req->c_asset . ' - ' . $assettable->asset_desc;

        //EmailScheduleJobs::dispatch($runningnbr, $asset, '5', '', '', '', '');

        toast('WO ' . $runningnbr . ' Successfuly Created !', 'success');
        return back();
    }

    public function searchic(Request $req)
    {
        $searchic = DB::table('pmc_mstr')
            ->where('pmc_code', '=', $req->pmc_code)
            ->first();

        return response()->json($searchic);
    }

    public function createenwo(Request $req)
    {
        //  dd($req->all());


        $fn1 = '';
        $fn2 = '';
        $fn3 = '';
        if (array_key_exists(0, $req->get('c_failure'))) {
            $fn1 = $req->get('c_failure')[0];
        } else {
            $fn1 = null;
        }
        if (array_key_exists(1, $req->get('c_failure'))) {
            $fn2 = $req->get('c_failure')[1];
        } else {
            $fn3 = null;
        }
        if (array_key_exists(2, $req->get('c_failure'))) {
            $fn3 = $req->get('c_failure')[2];
        } else {
            $fn3 = null;
        }
        //dd($req->get('c_engineer')[0]);


        //dd($req->get('c_engineer')[4]);
        $tablern = DB::table('running_mstr')
            ->first();
        $newyear = Carbon::now()->format('y');

        if ($tablern->year == $newyear) {
            $tempnewrunnbr = strval(intval($tablern->wo_nbr) + 1);
            $newtemprunnbr = '';

            if (strlen($tempnewrunnbr) < 6) {
                $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
            }
        } else {
            $newtemprunnbr = "000001";
        }


        $runningnbr = $tablern->wo_prefix . '-' . $newyear . '-' . $newtemprunnbr;

        $dataarray = array(
            'wo_nbr'           => $runningnbr,
            'wo_dept'          => Session::get('department'),
            'wo_engineer1'     => $req->engineercreate,
            'wo_failure_code1' => $fn1,
            'wo_failure_code2' => $fn2,
            'wo_failure_code3' => $fn3,
            'wo_asset'         => $req->c_asset,
            'wo_priority'      => $req->c_priority,
            'wo_status'        => 'plan',
            'wo_schedule'      => $req->c_schedule,
            'wo_duedate'       => $req->c_duedate,
            'wo_note'          => $req->c_note,
            'wo_creator'       => session()->get('username'),
            'wo_created_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_updated_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_type'          => 'other'
        );
        // dd($dataarray);
        DB::table('wo_mstr')->insert($dataarray);
        DB::table('running_mstr')
            ->where('wo_nbr', '=', $tablern->wo_nbr)
            ->update([
                'year' => $newyear,
                'wo_nbr' => $newtemprunnbr
            ]);
        $assettable = DB::table('asset_mstr')
            ->where('asset_code', '=', $req->c_asset)
            ->first();

        $asset = $req->c_asset . ' - ' . $assettable->asset_desc;

        //EmailScheduleJobs::dispatch($runningnbr, $asset, '1', '', '', '', '');

        toast('WO Successfuly Created !', 'success');
        return back();
    }

    public function createwo(Request $req)
    {
        // dd($req->all());

        DB::beginTransaction();

        try {

            $thisFailCode = "";

            if ($req->has('failurecode')) {
                $thisFailCode = implode(';', array_map('strval', $req->failurecode));
            } else {
                $thisFailCode = null;
            }

            $thisImpact = "";

            if ($req->has('c_impact')) {
                $thisImpact = implode(';', array_map('strval', $req->c_impact));
            } else {
                $thisImpact = null;
            }

            $thisListEng = "";

            if ($req->has('c_listengineer')) {
                $thisListEng = implode(';', array_map('strval', $req->c_listengineer));
            } else {
                $thisListEng = null;
            }

            // dd($thisFailCode,$thisImpact,$thisListEng);


            //dd($req->get('c_engineer')[4]);
            $tablern = DB::table('running_mstr')
                ->first();
            $newyear = Carbon::now()->format('y');

            if ($tablern->year == $newyear) {
                $tempnewrunnbr = strval(intval($tablern->wo_nbr) + 1);
                $newtemprunnbr = '';

                if (strlen($tempnewrunnbr) < 6) {
                    $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                }
            } else {
                $newtemprunnbr = "0001";
            }



            $runningnbr = $tablern->wo_prefix . '-' . $newyear . '-' . $newtemprunnbr;

            $dataarray = array(
                'wo_number'           => $runningnbr,
                'wo_sr_number'          => '',
                'wo_asset_code'          => $req->c_asset,
                'wo_site'             => $req->hide_site,
                'wo_type'              => $req->cwotype,
                'wo_status'              => 'firm',
                'wo_priority'          => $req->c_priority,
                'wo_failure_code'      => $thisFailCode,
                'wo_failure_type'      => $req->c_failuretype,
                'wo_list_engineer'    => $thisListEng,
                'wo_impact_code'      => $thisImpact,
                'wo_start_date'       => $req->c_startdate,
                'wo_due_date'          => $req->c_duedate,
                'wo_mt_code'          => $req->has('c_mtcode') ? $req->c_mtcode : null,
                'wo_ins_code'          => $req->has('c_inslist') ? $req->c_inslist : null,
                'wo_sp_code'          => $req->has('c_splist') ? $req->c_splist : null,
                'wo_qcspec_code'      => $req->has('c_qclist') ? $req->c_qclist : null,
                'wo_note'              => $req->c_note,
                'wo_createdby'          => session()->get('username'),
                'wo_department'       => session()->get('department'),
                'wo_system_create'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_system_update'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            );

            DB::table('wo_mstr')->insert($dataarray);

            DB::table('wo_trans_history')
                ->insert([
                    'wo_number' => $runningnbr,
                    'wo_action' => 'firm',
                ]);

            DB::table('running_mstr')
                ->where('wo_nbr', '=', $tablern->wo_nbr)
                ->update([
                    'year' => $newyear,
                    'wo_nbr' => $newtemprunnbr
                ]);
            $assettable = DB::table('asset_mstr')
                ->where('asset_code', '=', $req->c_asset)
                ->first();

            $asset = $req->c_asset . ' - ' . $assettable->asset_desc;

            EmailScheduleJobs::dispatch($runningnbr, $asset, '1', '', '', '', '');

            DB::commit();
            toast($runningnbr . ' Successfuly Created !', 'success');
            return back();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast("The data couldn't be saved due to an error.", 'error');
            return back();
        }
    }

    public function editwodirect(Request $req)
    {
        // dd($req->all());
        $dataaccess = DB::table('wo_mstr')
            ->where('wo_nbr', '=', $req->e_nowo)
            ->first();
        if ($dataaccess->wo_access == 0) {
            DB::table('wo_mstr')
                ->where('wo_nbr', '=', $req->e_nowo)
                ->update(['wo_access' => 1]);
        } else {
            toast('WO ' . $req->e_nowo . ' is being used right now', 'error');
            return redirect()->route('wocreatedirectmenu');
        }
        if ($dataaccess->wo_status != 'plan') {
            toast('WO ' . $req->e_nowo . ' status has changed, please recheck', 'error');
            return redirect()->route('wocreatedirectmenu');
        }
        $wonbr       = $req->e_nowo;
        $wosr        = $req->e_nosr;
        $woengineer1 = $req->e_engineerval;
        $woasset     = $req->e_asset;
        $woschedule  = $req->e_schedule;
        $woduedate   = $req->e_duedate;
        $wopriority  = $req->e_priority;
        $department  = $req->e_department;
        DB::table('wo_mstr')
            ->where('wo_nbr', '=', $wonbr)
            ->update([
                'wo_engineer1'  => $woengineer1,
                'wo_priority'   => $wopriority,
                'wo_asset'      => $woasset,
                'wo_schedule'   => $woschedule,
                'wo_duedate'    => $woduedate,
                'wo_failure_code1' => $req->e_failure1,
                'wo_failure_code2' => $req->e_failure2,
                'wo_failure_code3' => $req->e_failure3,
                // 'wo_dept'       => $department,
                'wo_note'       => $req->e_note,
                'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_access' => 0
            ]);

        toast('WO successfully updated', 'success');
        return redirect()->route('wocreatedirectmenu');
    }

    public function editwoeng(Request $req)
    {
        $dataaccess = DB::table('wo_mstr')
            ->where('wo_nbr', '=', $req->e_nowo)
            ->first();
        if ($dataaccess->wo_access == 0) {
            DB::table('wo_mstr')
                ->where('wo_nbr', '=', $req->e_nowo)
                ->update(['wo_access' => 1]);
        } else {
            toast('WO ' . $req->e_nowo . ' is being used right now', 'error');
            return redirect()->route('wocreatemenu');
        }
        if ($dataaccess->wo_status != 'plan') {
            toast('WO ' . $req->e_nowo . ' status has changed, please recheck', 'error');
            return redirect()->route('wocreatedirectmenu');
        }
        // dd($req->all());
        $wonbr       = $req->e_nowo;
        $wosr        = $req->e_nosr;
        $woengineer1 = $req->e_engineerval;
        $woasset     = $req->e_asset;
        $woschedule  = $req->e_schedule;
        $woduedate   = $req->e_duedate;
        $wopriority  = $req->e_priority;
        $department  = $req->e_department;
        DB::table('wo_mstr')
            ->where('wo_nbr', '=', $wonbr)
            ->update([
                'wo_engineer1'  => $woengineer1,
                'wo_priority'   => $wopriority,
                'wo_asset'      => $woasset,
                'wo_schedule'   => $woschedule,
                'wo_duedate'    => $woduedate,
                // 'wo_dept'       => $department,
                'wo_note'       => $req->e_note,
                'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_access'     => 0
            ]);

        toast('WO ' . $req->e_nowo . ' successfully updated', 'success');
        return redirect()->route('wocreatemenu');
    }

    public function editwo(Request $req)
    {

        // dd($req->all());
        DB::beginTransaction();

        try {

            $thisFailCode = "";

            if ($req->has('m_failurecode')) {
                $thisFailCode = implode(';', array_map('strval', $req->m_failurecode));
            }

            $thisImpact = "";

            if ($req->has('e_impact')) {
                $thisImpact = implode(';', array_map('strval', $req->e_impact));
            }

            $thisListEng = "";

            if ($req->has('e_engineerlist')) {

                $thisListEng = implode(';', array_map('strval', $req->e_engineerlist));
            }

            DB::table('wo_mstr')
                ->where('wo_number', '=', $req->e_nowo)
                ->update([
                    'wo_list_engineer' => $thisListEng,
                    'wo_failure_type' => $req->e_wottype,
                    'wo_failure_code' => $thisFailCode,
                    'wo_impact_code' => $thisImpact,
                    'wo_start_date' => $req->e_startdate,
                    'wo_due_date' => $req->e_duedate,
                    'wo_note' => $req->e_note,
                    'wo_mt_code' => $req->e_mtcode,
                    'wo_ins_code' => $req->e_inslist,
                    'wo_sp_code' => $req->e_splist,
                    'wo_qcspec_code' => $req->e_qclist,
                    'wo_priority' => $req->e_priority,
                    'wo_system_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                ]);

            DB::commit();
            toast('WO ' . $req->e_nowo . ' successfully updated', 'success');
            return redirect()->route('womaint');
        } catch (Exception $e) {
            DB::rollBack();
            toast("The data couldn't be saved due to an error.", 'error');
            return redirect()->route('womaint');
        }
    }


    public function closewo(Request $req)
    {

        DB::beginTransaction();

        try {

            //dd($req->all());
            //lakukan pengecekan apakah dia status firm atau released
            if ($req->tmp_wostatus == 'firm') {

                DB::table('wo_mstr')
                    ->where('wo_number', '=', $req->tmp_wonbr)
                    ->where('wo_status', '=', 'firm')
                    ->update([
                        'wo_status' => 'canceled',
                        'wo_system_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);

                DB::table('wo_trans_history')
                    ->insert([
                        'wo_number' => $req->tmp_wonbr,
                        'wo_action' => 'canceled',
                    ]);

                //check apakah wo berasal dari sr ? jika ya, ubah status sr jadi open
                $checksr = DB::table('wo_mstr')
                    ->where('wo_number', '=', $req->tmp_wonbr)
                    ->first();

                if ($checksr->wo_sr_number !== "") {
                    //ubah status sr
                    DB::table('service_req_mstr')
                        ->where('sr_number', '=', $checksr->wo_sr_number)
                        ->update([
                            'sr_status' => 'Open',
                            'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);

                    //kirim notifikasi ke pembuat sr
                    $thiswonumber = $checksr->wo_number;
                    $thissrnumber = $checksr->wo_sr_number;
                    $thisnotecancel = $req->notecancel;
                    SendWorkOrderCanceledNotification::dispatch($thiswonumber, $thissrnumber, $thisnotecancel);
                }
            } elseif ($req->tmp_wostatus == 'released') {
                //jika status wo sudah released

                $checktransfer = DB::table('wo_dets_sp')
                    ->where('wd_sp_wonumber', '=', $req->tmp_wonbr)
                    ->where('wd_sp_issued', '>', 0)
                    ->count();

                if ($checktransfer > 0) {
                    //jika status wo sudah released dan sudah ada transaksi spare part di table wo_dets_sp
                    toast('The Work Order cannot be cancelled as there are already transactions associated with it.', 'error');
                    return back();
                } else {
                    //jika status wo sudah released dan belum ada transaksi maka status wo bisa diubah menjadi cancel
                    DB::table('wo_mstr')
                        ->where('wo_number', '=', $req->tmp_wonbr)
                        ->where('wo_status', '=', 'released')
                        ->update([
                            'wo_status' => 'canceled',
                            'wo_system_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);

                    DB::table('wo_trans_history')
                        ->insert([
                            'wo_number' => $req->tmp_wonbr,
                            'wo_action' => 'canceled',
                        ]);

                    //check apakah wo berasal dari sr ? jika ya, ubah status sr jadi open
                    $checksr = DB::table('wo_mstr')
                        ->where('wo_number', '=', $req->tmp_wonbr)
                        ->first();

                    if ($checksr->wo_sr_number !== "") {
                        DB::table('service_req_mstr')
                            ->where('sr_number', '=', $checksr->wo_sr_number)
                            ->update([
                                'sr_status' => 'Open',
                                'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);


                        //kirim notifikasi ke pembuat sr
                        $thiswonumber = $checksr->wo_number;
                        $thissrnumber = $checksr->wo_sr_number;
                        $thisnotecancel = $req->notecancel;
                        SendWorkOrderCanceledNotification::dispatch($thiswonumber, $thissrnumber, $thisnotecancel);
                    }
                }
            } else {
                DB::rollBack();
                toast('work order cannot be cancelled because its status is not firm or released.', 'error');
                return back();
            }


            DB::commit();
            toast('Work Order ' . $req->tmp_wonbr . ' Successfuly Canceled!', 'success');
            return back();
        } catch (Exception $e) {
            DB::rollBack();

            dd($e);
            toast('Work Order ' . $req->tmp_wonbr . ' Cancel Process Error!', 'error');
            return back();
        }
    }

    public function wopaging(Request $req)
    {
        // dd($req->all());
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            $engineer    = $req->get('woengineer');

            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $engineer == '') {
                // dd('aaa');        
                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->orderby($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);

                $ceksrfile = DB::table(('service_req_upload'))
                    ->get();

                // dd($data);
                return view('workorder.table-wobrowse', ['data' => $data, 'usernow' => $usernow, 'ceksrfile' => $ceksrfile]);
            } else {
                $kondisi = "wo_mstr.wo_id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_code = '" . $asset . "'";
                }
                if ($status != '') {
                    $kondisi .= " and wo_status = '" . $status . "'";
                }
                if ($priority != '') {
                    $kondisi .= " and wo_priority = '" . $priority . "'";
                }
                if ($engineer != '') {
                    $kondisi .= " and (wo_engineer1 = '" . $engineer . "' or wo_engineer2 = '" . $engineer . "' or wo_engineer3 = '" . $engineer . "' or wo_engineer4 = '" . $engineer . "' or wo_engineer5 = '" . $engineer . "')";
                }
                // if($period != ''){
                //     if($period == '1'){
                //         $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                //     }
                //     else if($period == '2'){
                //         $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                //     }
                //     else if($period == '3'){
                //         $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                //     }
                // }

                // dd($kondisi);
                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->whereRaw($kondisi)
                    ->orderBy($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);

                $ceksrfile = DB::table(('service_req_upload'))
                    ->get();
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                return view('workorder.table-wobrowse', ['data' => $data, 'usernow' => $usernow, 'ceksrfile' => $ceksrfile]);
            }
        }
    }

    public function wopagingview(Request $req)
    {
        // dd('aaa');
        // dd($req->all());
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            $engineer    = $req->get('woengineer');
            $creator   = $req->get('wocreator');
            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $engineer == '' and $creator == '') {
                $data = DB::table('wo_mstr')
                    ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                    ->orderby($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->distinct('wo_nbr')
                    ->paginate(10);

                $ceksrfile = DB::table('service_req_upload')
                    ->get();


                return view('workorder.table-woview', ['data' => $data, 'usernow' => $usernow, 'ceksrfile' => $ceksrfile]);
            } else {
                // dd($creator);
                $kondisi = "wo_mstr.wo_id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_code = '" . $asset . "'";
                }
                if ($status != '') {
                    $kondisi .= " and wo_status = '" . $status . "'";
                }
                if ($priority != '') {
                    $kondisi .= " and wo_priority = '" . $priority . "'";
                }
                if ($creator != '') {
                    $kondisi .= " and wo_creator = '" . $creator . "'";
                }
                if ($engineer != '') {
                    $kondisi .= " and (wo_engineer1 = '" . $engineer . "' or wo_engineer2 = '" . $engineer . "' or wo_engineer3 = '" . $engineer . "' or wo_engineer4 = '" . $engineer . "' or wo_engineer5 = '" . $engineer . "')";
                }
                // if($period != ''){
                //     if($period == '1'){
                //         $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                //     }
                //     else if($period == '2'){
                //         $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                //     }
                //     else if($period == '3'){
                //         $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                //     }
                // }

                // dd($kondisi);
                $data = DB::table('wo_mstr')
                    ->selectRaw('min(wo_mstr.wo_id) as wo_id,wo_mstr.wo_nbr ,min(wo_mstr.wo_schedule) as wo_schedule, 
                    min(wo_mstr.wo_duedate) as wo_duedate,min(wo_mstr.wo_status) as wo_status, 
                    min(wo_mstr.wo_creator) as wo_creator, min(wo_mstr.wo_priority) as wo_priority, 
                    wo_mstr.wo_created_at, min(wo_mstr.wo_sr_nbr) as wo_sr_nbr,
                    min(asset_mstr.asset_code) as asset_code,min(asset_mstr.asset_desc) as asset_desc,
                    min(acceptance_image.file_wonumber) as file_wonumber,min(wo_mstr.wo_engineer1) as wo_engineer1, 
                    min(wo_asset) as wo_asset, min(wo_type) as wo_type')

                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                    ->whereRaw($kondisi)
                    // ->orderBy('wo_id', 'desc')
                    ->groupBy('wo_mstr.wo_nbr')
                    ->groupBy('wo_mstr.wo_created_at')
                    ->orderBy('wo_mstr.wo_created_at', $sort_type)
                    // ->orderBy('wo_id', 'desc')
                    // ->distinct()
                    // ->tosql();
                    ->paginate(10);
                // ;
                // dd($data );
                // dd($sort_by,$sort_type);
                // dd($_SERVER['REQUEST_URI']);

                $ceksrfile = DB::table('service_req_upload')
                    ->get();
                return view('workorder.table-woview', ['data' => $data, 'usernow' => $usernow, 'ceksrfile' => $ceksrfile]);
            }
        }
    }

    public function wopagingcreate(Request $req)
    {
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            $period    = $req->get('woperiod');

            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period == '') {
                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->where('wo_creator', '=', session()->get('username'))
                    ->where('wo_status', '=', 'plan')
                    ->orderby($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);
                //    dd('aaa');

                return view('workorder.table-wocreate', ['data' => $data, 'usernow' => $usernow]);
            } else {
                $kondisi = "wo_mstr.wo_id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_code = '" . $asset . "'";
                }
                if ($status != '') {
                    $kondisi .= " and wo_status = '" . $status . "'";
                }
                if ($priority != '') {
                    $kondisi .= " and wo_priority = '" . $priority . "'";
                }
                if ($period != '') {
                    if ($period == '1') {
                        $kondisi .= " and wo_created_at > '" . Carbon::today()->subDay(2) . "'";
                    } else if ($period == '2') {
                        $kondisi .= " and wo_created_at BETWEEN'" . Carbon::today()->subDay(3) . "'AND '" . Carbon::today()->subDay(5) . "'";
                    } else if ($period == '3') {
                        $kondisi .= " and wo_created_at < '" . Carbon::today()->subDay(5) . "'";
                    }
                }

                // dd($kondisi);
                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->whereRaw($kondisi)
                    ->where('wo_creator', '=', session()->get('username'))
                    ->orderBy($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                return view('workorder.table-wocreate', ['data' => $data, 'usernow' => $usernow]);
            }
        }
    }
    public function wopagingcreatedirect(Request $req)
    {
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            $period    = $req->get('woperiod');

            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period == '') {
                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->where('wo_type', '=', 'direct')
                    ->where('wo_status', '=', 'open')
                    ->where('wo_engineer1', '=', Session()->get('username'))
                    ->orderby($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);


                return view('workorder.table-wocreatedirect', ['data' => $data, 'usernow' => $usernow]);
            } else {
                $kondisi = "wo_mstr.wo_id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_code = '" . $asset . "'";
                }
                if ($status != '') {
                    $kondisi .= " and wo_status = '" . $status . "'";
                }
                if ($priority != '') {
                    $kondisi .= " and wo_priority = '" . $priority . "'";
                }
                if ($period != '') {
                    if ($period == '1') {
                        $kondisi .= " and wo_created_at > '" . Carbon::today()->subDay(2) . "'";
                    } else if ($period == '2') {
                        $kondisi .= " and wo_created_at BETWEEN'" . Carbon::today()->subDay(3) . "'AND '" . Carbon::today()->subDay(5) . "'";
                    } else if ($period == '3') {
                        $kondisi .= " and wo_created_at < '" . Carbon::today()->subDay(5) . "'";
                    }
                }
                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->whereRaw($kondisi)
                    ->where('wo_type', '=', 'direct')
                    ->where('wo_status', '=', 'open')
                    ->where('wo_engineer1', '=', Session()->get('username'))
                    ->orderby('wo_created_at', 'desc')
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);
                // dd($kondisi);    
                // $data = DB::table('wo_mstr')
                //     ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                //     ->whereRaw($kondisi)
                //     ->orderBy($sort_by, $sort_type)
                //     ->orderBy('wo_mstr.wo_id', 'desc')
                //     ->paginate(10);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                return view('workorder.table-wocreatedirect', ['data' => $data, 'usernow' => $usernow]);
            }
        }
    }
    public function wopagingstart(Request $req)
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

            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();

            if (Session::get('role') == 'ADMIN') {
                //ADMIN
                if ($wonumber == '' and $asset == '' and $status == '' and $priority == '') {

                    $data = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                        ->where(function ($status) {
                            $status->where('wo_status', '=', 'released');
                            $status->orWhere('wo_status', '=', 'started');
                        })
                        ->orderby('wo_system_create', 'desc')
                        ->orderBy('wo_mstr.id', 'desc')
                        ->paginate(10);

                    return view('workorder.table-wostart', ['data' => $data, 'usernow' => $usernow]);
                } else {
                    $kondisi = "wo_mstr.id > 0";

                    if ($wonumber != '') {
                        $kondisi .= " and wo_number LIKE '%" . $wonumber . "%'";
                    }
                    if ($asset != '') {
                        $kondisi .= " and asset_code LIKE '%" . $asset . "%'";
                    }
                    if ($status != '') {
                        $kondisi .= " and wo_status ='" . $status . "'";
                    } else {
                        $kondisi .= " and (wo_status = 'released' or wo_status = 'started')";
                    }
                    if ($priority != '') {
                        $kondisi .= " and wo_priority = '" . $priority . "'";
                    }

                    $data = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                        ->whereRaw($kondisi)
                        ->orderby('wo_system_create', 'desc')
                        ->orderBy('wo_mstr.id', 'desc')

                        ->paginate(10);
                    // dd($kondisi);
                    // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-wostart', ['data' => $data, 'usernow' => $usernow]);
                }
            } else {
                //engineer yang ditunjuk
                if ($wonumber == '' and $asset == '' and $status == '' and $priority == '') {

                    $user = Session()->get('username');
                    // dd($user);
                    $datawo = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                        ->where(function ($status) {
                            $status->where('wo_status', '=', 'released');
                            $status->orWhere('wo_status', '=', 'started');
                        })
                        ->get();

                    $data = [];

                    foreach ($datawo as $value) {
                        $dataeng = $value->wo_list_engineer;
                        $arrayeng = explode(';', $dataeng);
                        // dd($arrayeng);
                        if (in_array($user, $arrayeng)) {

                            $data = DB::table('wo_mstr')
                                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                                ->where(function ($status) {
                                    $status->where('wo_status', '=', 'released');
                                    $status->orWhere('wo_status', '=', 'started');
                                })
                                ->where('wo_list_engineer', $dataeng)
                                ->orderby('wo_system_create', 'desc')
                                ->orderBy('wo_mstr.id', 'desc')
                                ->paginate(10);
                        }
                    }

                    return view('workorder.table-wostart', ['data' => $data, 'usernow' => $usernow]);
                } else {
                    $kondisi = "wo_mstr.id > 0";

                    if ($wonumber != '') {
                        $kondisi .= " and wo_number LIKE '%" . $wonumber . "%'";
                    }
                    if ($asset != '') {
                        $kondisi .= " and asset_code LIKE '%" . $asset . "%'";
                    }
                    if ($status != '') {
                        $kondisi .= " and wo_status ='" . $status . "'";
                    } else {
                        $kondisi .= " and (wo_status = 'released' or wo_status = 'started')";
                    }
                    if ($priority != '') {
                        $kondisi .= " and wo_priority = '" . $priority . "'";
                    }

                    $user = Session()->get('username');
                    // dd($user);
                    $datawo = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                        ->where(function ($status) {
                            $status->where('wo_status', '=', 'released');
                            $status->orWhere('wo_status', '=', 'started');
                        })
                        ->get();

                    $data = [];

                    foreach ($datawo as $value) {
                        $dataeng = $value->wo_list_engineer;
                        $arrayeng = explode(';', $dataeng);
                        // dd($arrayeng);
                        if (in_array($user, $arrayeng)) {

                            $data = DB::table('wo_mstr')
                                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                                ->where(function ($status) {
                                    $status->where('wo_status', '=', 'released');
                                    $status->orWhere('wo_status', '=', 'started');
                                })
                                ->where('wo_list_engineer', $dataeng)
                                ->whereRaw($kondisi)
                                ->orderby('wo_system_create', 'desc')
                                ->orderBy('wo_mstr.id', 'desc')
                                ->paginate(10);
                        }
                    }
                    // dd($data);
                    // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-wostart', ['data' => $data, 'usernow' => $usernow]);
                }
            }
        }
    }
    public function wopagingreport(Request $req)
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

            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                // ->select('approver')
                ->where('username', '=', session()->get('username'))
                ->get();

            if (Session::get('role') == 'ADMIN') {

                if ($wonumber == '' and $asset == '' and $status == '' and $priority == '') {

                    $data = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                        ->where(function ($status) {
                            $status->where('wo_status', '=', 'started')
                                ->orwhere('wo_status', '=', 'finish');
                        })
                        ->orderby('wo_created_at', 'desc')
                        ->orderBy('wo_mstr.wo_id', 'desc')
                        ->paginate(10);

                    return view('workorder.table-woclose', ['data' => $data, 'usernow' => $usernow]);
                } else {
                    $kondisi = "wo_mstr.wo_id > 0";

                    if ($wonumber != '') {
                        $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                    }
                    if ($asset != '') {
                        $kondisi .= " and wo_asset = '" . $asset . "'";
                    }
                    if ($status != '') {
                        $kondisi .= " and wo_status = '" . $status . "'";
                    } else {
                        $kondisi .= " and (wo_status = 'started' or wo_status = 'finish')";
                    }
                    if ($priority != '') {
                        $kondisi .= " and wo_priority = '" . $priority . "'";
                    }

                    $data = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                        ->whereRaw($kondisi)
                        ->orderBy('wo_status', 'desc')
                        ->orderby('wo_created_at', 'desc')
                        ->orderBy('wo_mstr.wo_id', 'desc')
                        ->paginate(10);
                    // dd($data);
                    // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-woclose', ['data' => $data, 'usernow' => $usernow]);
                }
            } else {

                if ($wonumber == '' and $asset == '' and $status == '' and $priority == '') {

                    $data = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                        ->where(function ($status) {
                            $status->where('wo_status', '=', 'started')
                                ->orwhere('wo_status', '=', 'finish');
                        })
                        ->where(function ($query) {
                            $query->where('wo_engineer1', '=', Session()->get('username'))
                                ->orwhere('wo_engineer2', '=', Session()->get('username'))
                                ->orwhere('wo_engineer3', '=', Session()->get('username'))
                                ->orwhere('wo_engineer4', '=', Session()->get('username'))
                                ->orwhere('wo_engineer5', '=', Session()->get('username'));
                        })
                        ->orderby('wo_created_at', 'desc')
                        ->orderBy('wo_mstr.wo_id', 'desc')
                        ->paginate(10);

                    return view('workorder.table-woclose', ['data' => $data, 'usernow' => $usernow]);
                } else {
                    $kondisi = "wo_mstr.wo_id > 0";

                    if ($wonumber != '') {
                        $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                    }
                    if ($asset != '') {
                        $kondisi .= " and wo_asset = '" . $asset . "'";
                    }
                    if ($status != '') {
                        $kondisi .= " and wo_status = '" . $status . "'";
                    } else {
                        $kondisi .= " and (wo_status = 'started' or wo_status = 'finish')";
                    }
                    if ($priority != '') {
                        $kondisi .= " and wo_priority = '" . $priority . "'";
                    }

                    $data = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                        ->whereRaw($kondisi)
                        ->where(function ($query) {
                            $query->where('wo_engineer1', '=', Session()->get('username'))
                                ->orwhere('wo_engineer2', '=', Session()->get('username'))
                                ->orwhere('wo_engineer3', '=', Session()->get('username'))
                                ->orwhere('wo_engineer4', '=', Session()->get('username'))
                                ->orwhere('wo_engineer5', '=', Session()->get('username'));
                        })
                        ->orderBy('wo_status', 'desc')
                        ->orderby('wo_created_at', 'desc')
                        ->orderBy('wo_mstr.wo_id', 'desc')
                        ->paginate(10);
                    // dd($data);
                    // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-woclose', ['data' => $data, 'usernow' => $usernow]);
                }
            }
        }
    }

    public function geteditwoold(Request $req)
    {
        //dd($req->get('nomorwo'));
        // dd('aaa');
        $nowo = $req->get('nomorwo');
        // $currwo = DB::table('wo_mstr')
        //     ->where('wo_mstr.wo_nbr', '=', $nowo)
        //     ->first();

        $data = DB::table('wo_mstr')
            ->leftJoin('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->leftJoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'wo_mstr.wo_failure_type')
            ->leftJoin('pmc_mstr', 'pmc_mstr.pmc_code', 'wo_mstr.wo_mt_code')
            ->leftJoin('ins_list', 'ins_list.ins_code', 'wo_mstr.wo_ins_code')
            ->leftJoin('spg_list', 'spg_list.spg_code', 'wo_mstr.wo_sp_code')
            ->leftJoin('qcs_list', 'qcs_list.qcs_code', 'wo_mstr.wo_qcspec_code')
            ->where('wo_mstr.wo_number', '=', $nowo)
            ->first();

        $kodeEngineers = explode(';', $data->wo_list_engineer);
        $listDescEng = [];
        foreach ($kodeEngineers as $cEng) {
            $deskripsiEng = DB::table('eng_mstr')->where('eng_code', '=', $cEng)->first()->eng_desc;
            array_push($listDescEng, $deskripsiEng);
        }

        $kodeFailure = explode(';', $data->wo_failure_code);
        $listFailure = [];
        foreach ($kodeFailure as $cFail) {
            $deskripsiFail = DB::table('fn_mstr')->where('fn_code', '=', $cFail)->first()->fn_desc;
            array_push($listFailure, $deskripsiFail);
        }

        return $data;
    }

    public function geteditwo(Request $req)
    {
        // dd($req->get('wonumber'));
        $nowo = $req->get('wonumber');
        $currwo = DB::table('wo_mstr')
            ->where('wo_mstr.wo_number', '=', $nowo)
            ->first();

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
                ->select('asset_desc', 'asset_loc', 'asset_group')
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
        ]);
    }

    public function woapprovalbrowse(Request $req)
    {
        if (strpos(Session::get('menu_access'), 'WO08') !== false) {
            $usernow = DB::table('users')
                ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
                ->where('username', '=', session()->get('username'))
                ->first();
            // dd($usernow);

            if (Session::get('role') == 'ADMIN') {

                $data = DB::table('wo_mstr')
                    ->leftJoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                    ->leftJoin('wo_trans_approval', 'wo_mstr.id', 'wo_trans_approval.wotr_mstr_id')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'reported'); //status reported --> setelah selesai melakukan wo reporting
                        $status->where('wotr_status', '=', 'waiting for approval'); //kalo statusnya null berarti belum bisa approve
                    })
                    ->orderby('wo_system_create', 'desc')
                    ->orderBy('wo_mstr.id', 'desc')
                    ->groupBy('wo_mstr.wo_number')
                    ->paginate(10);
                // dd($data);

                $engineer = DB::table('users')
                    ->join('roles', 'users.role_user', 'roles.role_code')
                    ->where('role_desc', '=', 'Engineer')
                    ->get();
                $asset = DB::table('wo_mstr')
                    ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                    ->join('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'reported'); //status reported --> setelah selesai melakukan wo reporting
                    })
                    ->groupBy('asset_code')
                    ->orderBy('asset_code')
                    ->get();
            } else {
                $user = Session()->get('username');
                // dd($user);
                $datawo = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'reported'); //status reported --> setelah selesai melakukan wo reporting
                        // $status->orWhere('wo_status', '=', 'started');
                    })
                    ->get();

                $data = [];

                foreach ($datawo as $value) {
                    $dataeng = $value->wo_list_engineer;
                    $arrayeng = explode(';', $dataeng);
                    // dd($arrayeng);
                    if (in_array($user, $arrayeng)) {

                        $data = DB::table('wo_mstr')
                            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                            ->where(function ($status) {
                                $status->where('wo_status', '=', 'reported'); //status reported --> setelah selesai melakukan wo reporting
                                // $status->orWhere('wo_status', '=', 'started');
                            })
                            ->where('wo_list_engineer', $dataeng)
                            ->orderby('wo_system_create', 'desc')
                            ->orderBy('wo_mstr.id', 'desc')
                            ->paginate(10);
                    } else {

                        //jika user yg login bukan engineer di wo tersebut
                        $data = DB::table('wo_mstr')
                            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                            ->where(function ($status) {
                                $status->where('wo_status', '=', 'nostatus');
                            })
                            ->where('wo_list_engineer', $dataeng)
                            ->orderby('wo_system_create', 'desc')
                            ->orderBy('wo_mstr.id', 'desc')
                            ->paginate(10);
                    }
                }
                // dd($data);

                $engineer = DB::table('users')
                    ->join('roles', 'users.role_user', 'roles.role_code')
                    ->where('role_desc', '=', 'Engineer')
                    ->get();
                $asset = DB::table('wo_mstr')
                    ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                    ->join('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'reported'); //status reported --> setelah selesai melakukan wo reporting
                    })
                    ->groupBy('asset_code')
                    ->orderBy('asset_code')
                    ->get();
            }
            if ($req->ajax()) {
                return view('workorder.table-woapproval', ['data' => $data]);
            } else {
                return view('workorder.woapproval', ['data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset]);
            }
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    public function approvewo(Request $req)
    {

        $engineernow = $req->engappr[0];
        $engineerexplode = explode(',', $engineernow);
        //  dd($engineerexplode[4]);
        $engnow1 = '';
        $engnow2 = '';
        $engnow3 = '';
        $engnow4 = '';
        $engnow5 = '';

        if (array_key_exists(0, $engineerexplode)) {
            $engnow1 = $engineerexplode[0];
        }
        if (array_key_exists(1, $engineerexplode)) {
            $engnow2 = $engineerexplode[1];
        }
        if (array_key_exists(2, $engineerexplode)) {
            $engnow3 = $engineerexplode[2];
        }
        if (array_key_exists(3, $engineerexplode)) {
            $engnow4 = $engineerexplode[3];
        }
        if (array_key_exists(4, $engineerexplode)) {
            $engnow5 = $engineerexplode[4];
        }
        $dataaccess = DB::table('wo_mstr')
            ->where('wo_nbr', '=', $req->aprwonbr)
            ->first();

        if ($dataaccess->wo_access == 0) {
            DB::table('wo_mstr')
                ->where('wo_nbr', '=', $req->aprwonbr)
                ->update(['wo_access' => 1]);
        } else {
            toast('WO ' . $req->aprwonbr . ' is being used right now', 'error');
            return redirect()->route('womaint');
        }
        if ($dataaccess->wo_status != 'plan') {
            toast('WO ' . $req->aprwonbr . ' status has changed, please recheck', 'error');
            return redirect()->route('womaint');
        }
        if ($req->switch == 'approve') {
            // dd($req->all());
            if ($req->repairtypeapp == 'auto') {
                DB::table('wo_mstr')
                    ->where('wo_nbr', $req->aprwonbr)
                    ->update([
                        'wo_status'     => 'open',
                        'wo_engineer1'  =>  $engnow1,
                        'wo_engineer2'  =>  $engnow2,
                        'wo_engineer3'  =>  $engnow3,
                        'wo_engineer4'  =>  $engnow4,
                        'wo_engineer5'  =>  $engnow5,
                        'wo_approver'   => Session::get('username'),
                        'wo_access'     => 0
                    ]);
                toast('Work order ' . $req->aprwonbr . ' approved successfuly', 'success');
                return redirect()->route('womaint');
            } else {
                $exprc = explode(',', $req->repaircodeapp);
                $exprg = $req->repairgroupapp;
                $exprt = $req->repairtype;
                // dd(count($teets));

                $countexprc = count($exprc);
                $rc1 = null;
                $rc2 = null;
                $rc3 = null;
                if (isset($exprc[0])) {
                    $rc1 = $exprc[0];
                }
                if (isset($exprc[1])) {
                    $rc2 = $exprc[1];
                }
                if (isset($exprc[2])) {
                    $rc3 = $exprc[2];
                }
                DB::table('wo_mstr')
                    ->where('wo_nbr', $req->aprwonbr)
                    ->update([
                        'wo_status' => 'open',
                        'wo_engineer1'  =>  $engnow1,
                        'wo_engineer2'  =>  $engnow2,
                        'wo_engineer3'  =>  $engnow3,
                        'wo_engineer4'  =>  $engnow4,
                        'wo_engineer5'  =>  $engnow5,
                        'wo_repair_code1' => $rc1,
                        'wo_repair_code2' => $rc2,
                        'wo_repair_code3' => $rc3,
                        'wo_repair_group' => $exprg,
                        'wo_repair_type' => $exprt,
                        'wo_approver' => Session::get('username'),
                        'wo_access'     => 0
                    ]);

                toast('Work order ' . $req->aprwonbr . ' approved successfuly', 'success');
                return redirect()->route('womaint');
            }
        } else {
            DB::table('wo_mstr')
                ->where('wo_nbr', $req->aprwonbr)
                ->update(['wo_status' => 'closed']);
            toast('Work order ' . $req->aprwonbr . ' has been rejected', 'success');
            return redirect()->route('womaint');
        }
    }

    public function getfailure(Request $req)
    {


        //dd($req->get('nomorwo'));
        $asswo = $req->get('asset');
        $asset2 = DB::table('asset_mstr')
            ->where('asset_mstr.asset_code', '=', $asswo)
            ->first();

        $failure = DB::table('fn_mstr')
            ->selectRaw('fn_code,fn_desc')
            ->where(function ($query) use ($asset2) {
                $query->where('fn_mstr.fn_assetgroup', '=', $asset2->asset_group)
                    ->orwhere('fn_assetgroup', '=', null);
            })
            ->get();

        return $failure;
    }

    public function wojoblist(Request $req)
    {

        // dd($user);
        if (strpos(Session::get('menu_access'), 'WO02') !== false) {
            $getuser = DB::table('users')
                ->where('username', '=', Session()->get('username'))
                ->first();

            $maintenance = DB::table('pmc_mstr')->get();

            $inslist = DB::table('ins_list')->groupBy('ins_code')->get();

            $splist = DB::table('spg_list')->groupBy('spg_code')->get();

            $qclist = DB::table('qcs_list')->groupBy('qcs_code')->get();

            if (Session::get('role') == 'ADMIN') {

                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                    ->leftjoin('pmc_mstr', 'wo_mstr.wo_mt_code', 'pmc_mstr.pmc_code')
                    ->leftJoin('ins_list', 'wo_mstr.wo_ins_code', 'ins_list.ins_code')
                    ->leftJoin('spg_list', 'wo_mstr.wo_sp_code', 'spg_list.spg_code')
                    ->leftJoin('qcs_list', 'wo_mstr.wo_qcspec_code', 'qcs_list.qcs_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'released');
                        $status->orWhere('wo_status', '=', 'started');
                    })
                    ->orderby('wo_system_create', 'desc')
                    ->orderBy('wo_mstr.id', 'desc')
                    ->paginate(10);
                // dd($data);
                // }
                // dd($data);
                $engineer = DB::table('users')
                    ->join('roles', 'users.role_user', 'roles.role_code')
                    ->where('role_desc', '=', 'Engineer')
                    ->get();
                $asset = DB::table('wo_mstr')
                    ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                    ->join('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'released');
                        $status->orWhere('wo_status', '=', 'started');
                    })
                    ->groupBy('asset_code')
                    ->orderBy('asset_code')
                    ->get();
            } else {
                $user = Session()->get('username');
                // dd($user);
                $datawo = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'released');
                        $status->orWhere('wo_status', '=', 'started');
                    })
                    ->get();

                $data = [];

                foreach ($datawo as $value) {
                    $dataeng = $value->wo_list_engineer;
                    $arrayeng = explode(';', $dataeng);
                    // dd($arrayeng);
                    if (in_array($user, $arrayeng)) {

                        //jika user yg login adalah engineer di wo tersebut
                        $data = DB::table('wo_mstr')
                            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                            ->where(function ($status) {
                                $status->where('wo_status', '=', 'released');
                                $status->orWhere('wo_status', '=', 'started');
                            })
                            ->where('wo_list_engineer', $dataeng)
                            ->orderby('wo_system_create', 'desc')
                            ->orderBy('wo_mstr.id', 'desc')
                            ->paginate(10);
                    } else {

                        //jika user yg login bukan engineer di wo tersebut
                        $data = DB::table('wo_mstr')
                            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                            ->where(function ($status) {
                                $status->where('wo_status', '=', 'nostatus');
                            })
                            ->where('wo_list_engineer', $dataeng)
                            ->orderby('wo_system_create', 'desc')
                            ->orderBy('wo_mstr.id', 'desc')
                            ->paginate(10);
                    }
                }

                // dd($data);
                $engineer = DB::table('users')
                    ->join('roles', 'users.role_user', 'roles.role_code')
                    ->where('role_desc', '=', 'Engineer')
                    ->get();
                $asset = DB::table('wo_mstr')
                    ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                    ->join('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'released');
                        $status->orWhere('wo_status', '=', 'started');
                    })
                    ->groupBy('asset_code')
                    ->orderBy('asset_code')
                    ->get();
            }
            if ($req->ajax()) {
                return view('workorder.table-wostart', ['data' => $data]);
            } else {
                return view('workorder.wostart', [
                    'data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset, 'maintenancelist' => $maintenance, 'inslist' => $inslist, 'splist' => $splist,
                    'qclist' => $qclist
                ]);
            }
        } else {
            toast('you dont have access, please contact admin', 'error');
            return back();
        }
    }

    public function editjob(Request $req)
    {
        // dd($req->all());
        $dataaccess = DB::table('wo_mstr')
            ->where('wo_number', '=', $req->v_nowo)
            ->first();
        // if ($dataaccess->wo_access == 0) {
        //     DB::table('wo_mstr')
        //         ->where('wo_number', '=', $req->v_nowo)
        //         ->update(['wo_access' => 1]);
        // } else {
        //     toast('WO ' . $req->v_nowo . ' is being used right now', 'error');
        //     return redirect()->route('wojoblist');
        // }
        if ($dataaccess->wo_status != $req->statuswo) {
            toast('WO ' . $req->v_nowo . ' status has changed, please recheck', 'error');
            return redirect()->route('wojoblist');
        }
        $statuswo = $req->statuswo;
        // dd($statuswo);
        $nomorwo = $req->v_nowo;
        // dd($req->all());
        if ($statuswo == 'released') {
            DB::table('wo_mstr')
                ->where('wo_number', '=', $nomorwo)
                ->update([
                    'wo_status' => 'started',
                    'wo_job_startdate' => $req->v_startdate,
                    'wo_job_starttime' => $req->v_starttime,
                    'wo_actual_start' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    // 'wo_access'     => 0
                ]);
            // if ($req->v_nosr != null || $req->v_nosr != '') {
            //     DB::table('service_req_mstr')
            //         ->where('wo_number', '=', $nomorwo)
            //         ->update([
            //             'sr_status' => 3,
            //             'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            //         ]);
            // }
            toast('Work order ' . $nomorwo . ' started successfuly', 'success');
            return redirect()->route('wojoblist');
        } else if ($statuswo == 'started') {
            DB::table('wo_mstr')
                ->where('wo_number', '=', $nomorwo)
                ->update([
                    'wo_status' => 'released',
                    'wo_job_startdate' => null,
                    'wo_job_starttime' => null,
                    'wo_actual_start' => null,
                ]);
            // if ($req->v_nosr != null || $req->v_nosr != '') {
            //     DB::table('service_req_mstr')
            //         ->where('wo_number', '=', $nomorwo)
            //         ->update([
            //             'sr_status' => 2,
            //             'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            //         ]);
            // }

            // notifikasi saat melakukan cancel, di comment dulu
            // $data = DB::table('eng_mstr')
            //     ->join('users', 'eng_mstr.eng_code', '=', 'users.username')
            //     ->where('approver', '=', '1')
            //     ->get();
            // dd($data);
            // foreach ($data as $data) {
            //     $user = App\User::where('id', '=', $data->id)->first();

            //     $details = [
            //         'body' => 'WO has been canceled by ' . session::get('username'),
            //         'url' => 'womaint',
            //         'nbr' => $nomorwo,
            //         'note' => 'Please check'
            //     ]; // isi data yang dioper


            //     $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel
            // }

            toast('Work order ' . $nomorwo . ' has been canceled', 'success');
            return redirect()->route('wojoblist');

            //dd($statuswo);
        }
    }

    public function wocloselist()
    {      //route : woreport      blade : workorder.woclose

        //dd(Session()->get('username'));
        if (strpos(Session::get('menu_access'), 'WO03') !== false) {

            if (Session::get('role') == 'ADMIN') {

                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'started')
                            ->orwhere('wo_status', '=', 'finish');
                    })
                    ->orderBy('wo_status', 'desc')
                    ->orderby('wo_created_at', 'desc')
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);

                $engineer = DB::table('users')
                    ->join('roles', 'users.role_user', 'roles.role_code')
                    ->where('role_desc', '=', 'Engineer')
                    ->get();
                $asset = DB::table('wo_mstr')
                    ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                    ->join('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'started')
                            ->orwhere('wo_status', '=', 'finish');
                    })
                    ->groupBy('asset_code')
                    ->orderBy('asset_code')
                    ->get();
                $repaircode = DB::table('rep_master')
                    ->get();

                $sparepart = DB::table('sp_mstr')
                    ->get();
                $repairgroup = DB::table('xxrepgroup_mstr')
                    ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                    ->distinct('xxrepgroup_nbr')
                    ->get();
                $instruction = DB::table('ins_mstr')
                    ->get();
            } else {

                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'started')
                            ->orwhere('wo_status', '=', 'finish');
                    })
                    ->where(function ($query) {
                        $query->where('wo_engineer1', '=', Session()->get('username'))
                            ->orwhere('wo_engineer2', '=', Session()->get('username'))
                            ->orwhere('wo_engineer3', '=', Session()->get('username'))
                            ->orwhere('wo_engineer4', '=', Session()->get('username'))
                            ->orwhere('wo_engineer5', '=', Session()->get('username'));
                    })
                    ->orderBy('wo_status', 'desc')
                    ->orderby('wo_created_at', 'desc')
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);
                $engineer = DB::table('users')
                    ->join('roles', 'users.role_user', 'roles.role_code')
                    ->where('role_desc', '=', 'Engineer')
                    ->get();
                $asset = DB::table('wo_mstr')
                    ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                    ->join('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                    ->where(function ($status) {
                        $status->where('wo_status', '=', 'started')
                            ->orwhere('wo_status', '=', 'finish');
                    })
                    ->where(function ($query) {
                        $query->where('wo_engineer1', '=', Session()->get('username'))
                            ->orwhere('wo_engineer2', '=', Session()->get('username'))
                            ->orwhere('wo_engineer3', '=', Session()->get('username'))
                            ->orwhere('wo_engineer4', '=', Session()->get('username'))
                            ->orwhere('wo_engineer5', '=', Session()->get('username'));
                    })
                    ->groupBy('asset_code')
                    ->orderBy('asset_code')
                    ->get();
                $repaircode = DB::table('rep_master')
                    ->get();

                $sparepart = DB::table('sp_mstr')
                    ->get();
                $repairgroup = DB::table('xxrepgroup_mstr')
                    ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                    ->distinct('xxrepgroup_nbr')
                    ->get();
                $instruction = DB::table('ins_mstr')
                    ->get();
            }


            return view('workorder.woclose', ['data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset, 'repaircode' => $repaircode, 'sparepart' => $sparepart, 'repairgroup' => $repairgroup, 'instruction' => $instruction]);
        } else {
            toast('you dont have access, please contact admin', 'error');
            return back();
        }
    }

    public function reportingwo(Request $req)
    {

        $domain = ModelsQxwsa::first();

        $costdata = (new WSAServices())->wsacost($domain->wsas_domain);

        if ($costdata === false) {
            alert()->error('Error', 'WSA Failed');
            return redirect()->route('woreport');
        } else {
            if ($costdata[1] == "false") {
                alert()->error('Error', 'Item Cost tidak ditemukan');
                return redirect()->route('woreport');
            } else {
                $tempCost = (new CreateTempTable())->createTempCost($costdata[0]);

                $tempCost = collect($tempCost[0]);
            }
        }

        DB::beginTransaction();

        try {

            $dataaccess = DB::table('wo_mstr')
                ->where('wo_nbr', '=', $req->c_wonbr)
                ->first();
            if ($dataaccess->wo_access == 0) {
                DB::table('wo_mstr')
                    ->where('wo_nbr', '=', $req->c_wonbr)
                    ->update([
                        'wo_access' => 1,
                        'wo_access_user' => session::get('username')
                    ]);
            } else {
                if ($dataaccess->wo_access_user != session::get('username')) {
                    toast('WO ' . $req->c_wonbr . ' is being used right now', 'error');
                    return redirect()->route('woreport');
                }
            }
            if ($dataaccess->wo_status == 'finish') {
                toast('WO ' . $req->c_wonbr . ' status has changed, please refresh page', 'error');
                return redirect()->route('woreport');
            }

            if ($req->has('do') && $req->has('result')) {

                //sudah tidak dikelompokan oleh repair type
                foreach ($req->do[0] as $key => $value) {
                    $arraydo[$key] = $value;
                }

                foreach ($req->result[0] as $key => $value) {
                    $arrayresult[$key] = $value;
                }

                // dd($arraydo,$arrayresult);

                foreach ($req->rc_hidden2 as $k_sp => $value) {

                    foreach ($req->rc_hidden1 as $k_ins => $value) {

                        if ($req->rc_hidden2[$k_sp] == $req->rc_hidden1[$k_ins] && $req->inscode_hidden2[$k_sp] == $req->inscode_hidden1[$k_ins]) {

                            $testarray[] = [
                                'wonbr' => $req->wonbr_hidden2[$k_sp],
                                'rc' => $req->rc_hidden2[$k_sp],
                                'ic' => $req->inscode_hidden2[$k_sp],
                                'sp' => $req->spcode_hidden2[$k_sp],
                                'site' => $req->spsite_hidden2[$k_sp],
                                'do' => $arraydo[$k_ins],
                                'result' => $arrayresult[$k_ins],
                                'note' => $req->note[$k_ins],
                                'qtyused' => $req->qtyused[$k_sp],
                            ];
                        }
                    }
                }

                // foreach ($tempCost as $coscos) {
                //     foreach ($testarray as $a) {
                //         if ($coscos->cost_site == $a['site'] && $coscos->cost_part == $a['sp']) {
                //             $collection = collect($testarray)->map(function ($item, $key) use ($tempCost) {
                //                 $item['cost'] =($tempCost[$key]->cost_cost);
                //                 return $item;
                //             });
                //         }
                //     }
                // }

                // $testarray = $collection->toArray();

                foreach ($tempCost as $coscos) {
                    foreach ($testarray as $a) {
                        if ($coscos->cost_site == $a['site'] && $coscos->cost_part == $a['sp']) {
                            $collection = collect($testarray)->map(function ($item, $key) use ($tempCost) {
                                $item['cost'] = ($tempCost[$key]->cost_cost);
                                return $item;
                            });
                        } else {
                            $collection = collect($testarray)->map(function ($item, $key) use ($tempCost) {
                                $item['cost'] = 0;
                                return $item;
                            });
                        }
                    }
                }

                $testarray = $collection->toArray();
                // dd(gettype($collection));
                // dd('stop');

                foreach ($testarray as $k_all => $value) {

                    DB::table('wo_dets')
                        ->where('wo_dets_nbr', '=', $testarray[$k_all]['wonbr'])
                        ->where('wo_dets_rc', '=', $testarray[$k_all]['rc'])
                        ->where('wo_dets_ins', '=', $testarray[$k_all]['ic'])
                        ->where('wo_dets_sp', '=', $testarray[$k_all]['sp'])
                        ->update([
                            'wo_dets_flag' => $testarray[$k_all]['result'],
                            'wo_dets_do_flag' => $testarray[$k_all]['do'],
                            'wo_dets_fu_note' => $testarray[$k_all]['note'],
                            'wo_dets_qty_used' => DB::raw('CASE WHEN wo_dets_qty_used IS NULL THEN ' . $testarray[$k_all]['qtyused'] . ' ELSE wo_dets_qty_used + ' . $testarray[$k_all]['qtyused'] . ' END'),
                            'wo_dets_sp_price' => $testarray[$k_all]['cost'] ? $testarray[$k_all]['cost'] : 0,
                            'wo_dets_used_tmp' => $testarray[$k_all]['qtyused'],
                        ]);
                }


                /* get data buat qxtend issue unplanned */
                $dataqxtend = DB::table('wo_dets')
                    ->select('wo_dets_nbr', 'wo_dets_sp', 'wo_dets_wh_site', 'wo_dets_wh_loc', 'wo_dets_wh_tosite', 'wo_dets_wh_toloc', 'wo_dets_wh_lot', 'spm_desc', 'spm_um', 'wo_dets_wh_qty', DB::raw('SUM(wo_dets_qty_used) as qtytoqx'), DB::raw('SUM(wo_dets_wh_qty) as qtywh'), DB::raw('SUM(wo_dets_used_tmp) as qtynow'))
                    ->join('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
                    ->where('wo_dets_nbr', '=', $req->c_wonbr)
                    ->groupBy('wo_dets_sp', 'wo_dets_wh_site', 'wo_dets_wh_loc')
                    ->get();

                // dd($dataqxtend);

                $cekstatus = DB::table('wo_dets')
                    ->where('wo_dets_nbr', '=', $req->c_wonbr)
                    ->where(function ($query) {
                        $query->where('wo_dets_wh_conf', '=', 0)
                            ->orWhere('wo_dets_wh_conf', '=', null);
                    })
                    ->count();

                /* jika WO tidak ada spare part, status akan menjadi open */
                $ceksp = DB::table('wo_dets')
                    ->where('wo_dets_nbr', '=', $req->c_wonbr)
                    ->where('wo_dets_sp', '=', null)
                    ->count();

                // dd($cekstatus,$ceksp);


                //jika tidak ada spare part 
                if ($cekstatus == 0 || $ceksp == 0) {

                    /* start Qxtend */

                    $qxwsa = Qxwsa::first();

                    // Var Qxtend
                    $qxUrl          = $qxwsa->qx_url; // Edit Here

                    $qxRcv          = $qxwsa->qx_rcv;

                    $timeout        = 0;

                    $domain         = $qxwsa->wsas_domain;

                    // XML Qextend ** Edit Here

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
                    <issueInventory>
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
                            <qcom:propertyValue>eB_2</qcom:propertyValue>
                        </qcom:ttContext>
                        <qcom:ttContext>
                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                            <qcom:propertyName>mnemonicsRaw</qcom:propertyName>
                            <qcom:propertyValue>false</qcom:propertyValue>
                        </qcom:ttContext>
                        <qcom:ttContext>
                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                            <qcom:propertyName>username</qcom:propertyName>
                            <qcom:propertyValue>mfg</qcom:propertyValue>
                        </qcom:ttContext>
                        <qcom:ttContext>
                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                            <qcom:propertyName>password</qcom:propertyName>
                            <qcom:propertyValue></qcom:propertyValue>
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
                        <dsInventoryIssue>';

                    $qdocBody = '';
                    foreach ($dataqxtend as $dtqx) {

                        if ($dtqx->qtynow > 0) {
                            $qdocBody .= ' <inventoryIssue>
                                <ptPart>' . $dtqx->wo_dets_sp . '</ptPart>
                                <lotserialQty>' . $dtqx->qtynow . '</lotserialQty>
                                <site>' . $dtqx->wo_dets_wh_tosite . '</site>
                                <location>' . $dtqx->wo_dets_wh_toloc . '</location>
                                <ordernbr>' . $dtqx->wo_dets_nbr . '</ordernbr>
                            </inventoryIssue>';

                            //cek apakah masih ada sisa ?
                            $sisaqty = $dtqx->qtywh - $dtqx->qtytoqx;

                            if ($sisaqty > 0) {
                                $cek_returnbacksp = DB::table('returnback_sp')
                                    ->where('rb_wonbr', '=', $dtqx->wo_dets_nbr)
                                    ->where('rb_spcode', '=', $dtqx->wo_dets_sp)
                                    ->exists();

                                $getuserinput = DB::table('wo_mstr')
                                    ->select('wo_user_input')
                                    ->where('wo_nbr', '=', $dtqx->wo_dets_nbr)
                                    ->first();

                                if ($cek_returnbacksp) { //kalau sudah ada

                                    DB::table('returnback_sp')
                                        ->where('rb_wonbr', '=', $dtqx->wo_dets_nbr)
                                        ->where('rb_spcode', '=', $dtqx->wo_dets_sp)
                                        ->update([
                                            'rb_qtyeng' => $dtqx->qtywh,
                                            'rb_qtyactual' => $dtqx->qtytoqx,
                                            'rb_qtyreturnback' => $sisaqty,
                                        ]);
                                } else {
                                    // dd('inser data baru ke returnback sp');
                                    DB::table('returnback_sp')
                                        ->insert([
                                            'rb_wonbr' => $dtqx->wo_dets_nbr,
                                            'rb_spcode' => $dtqx->wo_dets_sp,
                                            'rb_spdesc' => $dtqx->spm_desc,
                                            'rb_sp_um' => $dtqx->spm_um,
                                            'rb_sitefrom' => $dtqx->wo_dets_wh_site,
                                            'rb_locfrom' => $dtqx->wo_dets_wh_loc,
                                            'rb_lotfrom' => $dtqx->wo_dets_wh_lot,
                                            'rb_siteto' => $dtqx->wo_dets_wh_tosite,
                                            'rb_locto' => $dtqx->wo_dets_wh_toloc,
                                            'rb_qtyeng' => $dtqx->qtywh,
                                            'rb_qtyactual' => $dtqx->qtytoqx,
                                            'rb_qtyreturnback' => $sisaqty,
                                            'rb_user' => $getuserinput->wo_user_input,
                                        ]);
                                }
                            }
                        }
                    }

                    $qdocfooter =   '</dsInventoryIssue>
                                </issueInventory>
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
                        return redirect()->route('woreport');
                    }
                    $xmlResp = simplexml_load_string($qdocResponse);
                    $xmlResp->registerXPathNamespace('soapenv', 'urn:schemas-qad-com:xml-services:common');
                    $qdocFault = '';
                    $qdocFault = $xmlResp->xpath('//soapenv:faultstring');
                    // dd($qdocFault);

                    if (!empty($qdocFault)) {


                        $qdocFault = (string) $xmlResp->xpath('//soapenv:faultstring')[0];

                        DB::rollBack();
                        alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $qdocFault . "", 'error')->persistent('Dismiss');
                        return redirect()->back();
                    }

                    $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
                    $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



                    if ($qdocResult == "success" or $qdocResult == "warning") {
                    } else {
                        // dd('abcd');
                        DB::rollBack();

                        $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                        $outputerror = '';
                        foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                            $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                            $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                            $outputerror .= "&bull;  " . $context . " - " . $desc . "<br>";
                        }

                        alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $outputerror . "", 'error')->persistent('Dismiss');

                        return redirect()->route('woreport');
                    }
                }
            }



            /* QXTEND issue - unplanned */

            $arrayy = [
                'wo_updated_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_status'        => 'finish',
                'wo_failure_code1' => isset($req->failurecode[0]) ? $req->failurecode[0] : null,
                'wo_failure_code2' => isset($req->failurecode[1]) ? $req->failurecode[1] : null,
                'wo_failure_code3' => isset($req->failurecode[2]) ? $req->failurecode[2] : null,
                'wo_finish_date'   => $req->c_finishdate,
                'wo_finish_time'   => $req->c_finishtime,
                'wo_approval_note' => $req->c_note,
                'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
                'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                'wo_access'        => 0
            ];
            DB::table('wo_mstr')->where('wo_nbr', '=', $req->c_wonbr)->update($arrayy);
            // dd('abcd');
            /* simpan file A211025 */
            if ($req->has('filenamewo')) {
                foreach ($req->file('filenamewo') as $upload) {
                    $filename = $req->c_wonbr . '-' . $upload->getClientOriginalName();

                    // Cek apakah file sudah ada di database
                    $existingFile = DB::table('acceptance_image')
                        ->where('file_name', $filename)
                        ->where('file_wonumber', '=', $req->c_wonbr)
                        ->count();
                    if ($existingFile > 0) {
                        toast('File names cannot be same.', 'error');
                        return back();
                    }

                    // Simpan File Upload pada Public
                    $savepath = public_path('uploadwofinish/');
                    $upload->move($savepath, $filename);

                    // Simpan ke DB Upload
                    DB::table('acceptance_image')
                        ->insert([
                            'file_srnumber' => $req->c_srnbr,
                            'file_wonumber' => $req->c_wonbr,
                            'file_name'     => $filename, //$upload->getClientOriginalName(), //nama file asli
                            'file_url'      => $savepath . $filename,
                            'uploaded_at'   => Carbon::now()->toDateTimeString(),
                        ]);
                }
            } /* end simpan file A211025 */
            /* A211025
                $albumraw = $req->imgname;
                $k = 0;
                if(isset($req->imgname)){
                    foreach($albumraw as $olah1){
                        $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                        // dd($waktu);
                        $jadi1 = explode(',', $olah1);
                        // a..png
                        $jadi2 = base64_decode($jadi1[2]);
                        $lenstr = strripos($jadi1[0],'.');
                        $test = substr($jadi1[0],$lenstr);
                        // dd($test);
                        $test3 = str_replace($test,'',$jadi1[0]);
                        // dd($test3);
                        $test4 = str_replace('.','',$test3);
                        $test44 = str_replace(' ','',$test4);
                        $test5 = $test44.$waktu.$test;
                        // dd($test5);

                        // dd($test2);

                        // dd(substr($jadi1[0],$lenstr));
                        // dd(strlen($jadi1[0]));

                        // $test = preg_replace('/.(?=.*,)/','',$jadi1[0]);
                        //  $test2 = explode('.',$test);
                        // $test2 = 
                        // dd($test);
                        $alamaturl = '../public/upload/'.$test5;
                        file_put_contents($alamaturl, $jadi2);

                        DB::table('acceptance_image')
                            ->insert([
                                'file_srnumber' => $req->c_srnbr,
                                'file_wonumber' => $req->c_wonbr,
                                'file_name' => $jadi1[0], //nama file asli
                                'file_url' => $alamaturl, 
                                'uploaded_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        // $k++;

                    }
                } */

            if ($req->c_srnbr != null) {
                DB::table('service_req_mstr')->where('wo_number', '=', $req->c_wonbr)->update(['sr_status' => '4', 'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toTimeString()]);
            }
            DB::commit();
            toast('data reported successfuly', 'success');
            return redirect()->route('woreport');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Save Error', 'error');
            return redirect()->route('woreport');
        }
    }
    // }

    public function reissued_wo($wo)
    {
        // dd($wo);

        $dataget = DB::table('wo_mstr')
            ->join('wo_dets', 'wo_dets.wo_dets_nbr', 'wo_mstr.wo_nbr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->leftJoin('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
            ->leftjoin('insd_det', function ($join) {
                $join->on('wo_dets.wo_dets_ins', '=', 'insd_det.insd_code');
                $join->on('wo_dets.wo_dets_sp', '=', 'insd_det.insd_part');
            })
            ->leftJoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
            ->where('wo_nbr', '=', $wo)
            ->orderBy('wo_dets_rc', 'asc')
            ->get();

        return view('workorder.wo-reissued', compact('dataget'));
    }

    public function reissuedwofinish(Request $req)
    {

        // dd('abcd');
        $filterqtyissued = array_filter($req->qtyreissued);

        if (empty($filterqtyissued)) {
            // dd("allzero");
            toast('Qty Re-issued tidak bisa 0 semua', 'error');
            return back()->withInput($req->only('qtyreissued'));
        }

        DB::beginTransaction();

        try {


            $qxwsa = Qxwsa::first();

            // Var Qxtend
            $qxUrl          = $qxwsa->qx_url; // Edit Here

            $qxRcv          = $qxwsa->qx_rcv;

            $timeout        = 0;

            $domain         = $qxwsa->wsas_domain;

            // XML Qextend ** Edit Here

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
                <issueInventory>
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
                    <qcom:propertyValue>eB_2</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>mnemonicsRaw</qcom:propertyName>
                    <qcom:propertyValue>false</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>username</qcom:propertyName>
                    <qcom:propertyValue>mfg</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>password</qcom:propertyName>
                    <qcom:propertyValue></qcom:propertyValue>
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
                <dsInventoryIssue>';

            $qdocBody = '';
            foreach ($req->spcode_hidden as $spcode => $value) {

                if ($req->spcode_hidden[$spcode] != "" || $req->spcode_hidden[$spcode] != null) {
                    // dump($req->spcode_hidden[$spcode]);
                    $qdocBody .= ' <inventoryIssue>
                        <ptPart>' . $req->spcode_hidden[$spcode] . '</ptPart>
                        <lotserialQty>' . $req->qtyreissued[$spcode] . '</lotserialQty>
                        <site>' . $req->site_hidden[$spcode] . '</site>
                        <location>' . $req->loc_hidden[$spcode] . '</location>
                        <lotserial>' . $req->lotserial[$spcode] . '</lotserial>
                        <ordernbr>' . $req->wonbr_hidden[$spcode] . '</ordernbr>
                    </inventoryIssue>';
                }
            }
            $qdocfooter =   '</dsInventoryIssue>
                        </issueInventory>
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
                toast('Something Wrong with Qxtend Connection', 'error');
                return redirect()->route('woreport');
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

                foreach ($req->spcode_hidden as $jmlspcode => $value) {

                    $cekwodets = DB::table('wo_dets')
                        ->where('wo_dets_nbr', $req->wonbr_hidden[$jmlspcode])
                        ->where('wo_dets_rc', $req->rc_hidden[$jmlspcode])
                        ->where('wo_dets_ins', $req->inscode_hidden[$jmlspcode])
                        ->where('wo_dets_sp', $req->spcode_hidden[$jmlspcode])
                        ->first();

                    $new_qty_used = 0;

                    $new_qty_used = $cekwodets->wo_dets_qty_used + $req->qtyreissued[$jmlspcode];

                    DB::table('wo_dets')
                        ->where('wo_dets_nbr', $req->wonbr_hidden[$jmlspcode])
                        ->where('wo_dets_rc', $req->rc_hidden[$jmlspcode])
                        ->where('wo_dets_ins', $req->inscode_hidden[$jmlspcode])
                        ->where('wo_dets_sp', $req->spcode_hidden[$jmlspcode])
                        ->update([
                            'wo_dets_qty_used' => $new_qty_used
                        ]);
                }

                DB::commit();
                toast('Qty Issued updated for WO : ' . $req->c_wonbr . ' ', 'success');
                return redirect()->route('woreport');
            } else {

                DB::rollBack();

                $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                $outputerror = '';
                foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                    $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                    $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                    $outputerror .= "&bull;  " . $context . " - " . $desc . "<br>";
                }

                alert()->html('<u><b>Error Response Qxtend</b></u>', "<b>Detail Response Qxtend :</b><br>" . $outputerror . "", 'error')->persistent('Dismiss');
                return redirect()->route('woreport');
            }


            foreach ($req->spcode_hidden as $jmlspcode => $value) {

                $cekwodets = DB::table('wo_dets')
                    ->where('wo_dets_nbr', $req->wonbr_hidden[$jmlspcode])
                    ->where('wo_dets_rc', $req->rc_hidden[$jmlspcode])
                    ->where('wo_dets_ins', $req->inscode_hidden[$jmlspcode])
                    ->where('wo_dets_sp', $req->spcode_hidden[$jmlspcode])
                    ->first();

                $new_qty_used = 0;

                $new_qty_used = $cekwodets->wo_dets_qty_used + $req->qtyreissued[$jmlspcode];

                DB::table('wo_dets')
                    ->where('wo_dets_nbr', $req->wonbr_hidden[$jmlspcode])
                    ->where('wo_dets_rc', $req->rc_hidden[$jmlspcode])
                    ->where('wo_dets_ins', $req->inscode_hidden[$jmlspcode])
                    ->where('wo_dets_sp', $req->spcode_hidden[$jmlspcode])
                    ->update([
                        'wo_dets_qty_used' => $new_qty_used
                    ]);
            }

            DB::commit();
            toast('Qty Issued updated for WO : ' . $req->c_wonbr . ' ', 'success');
            return redirect()->route('woreport');
        } catch (Exception $err) {

            DB::rollBack();
            toast('Save Error', 'error');
            return redirect()->route('woreport');
        }
    }

    // public function reopenwo(Request $req){

    //     $dwonbr = $req->get('tmp_rowonbr');
    //     DB::table('wo_mstr')
    //     ->where('wo_nbr','=',$dwonbr)
    //     ->update([
    //         'wo_start_date'  => null,
    //         'wo_start_time'  => null,
    //         'wo_finish_date' => null,
    //         'wo_finish_time' => null,
    //         'wo_repair_code1' => null,
    //         'wo_repair_code2' => null,
    //         'wo_repair_code3' => null,
    //         'wo_repair_hour' => null,
    //         'wo_system_date' => null,
    //         'wo_system_time' => null,
    //         'wo_status' => 'open',  
    //         'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString()      
    //         ]);
    //     DB::table('wo_detail')
    //     ->where('detail_wo_nbr','=',$dwonbr)
    //     ->delete();
    //     DB::table("service_req_mstr")
    //         ->where('wo_number', '=', $req->tmp_wonbr)
    //         ->update(['sr_status' => 2,
    //         'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
    //         ]);

    //     toast('data has been reopened', 'success');
    //     return redirect()->route('womaint');
    // }

    // tyas reporting wo untuk selain yang preventive
    public function reportingwoother(Request $req)
    {

        /* A211022
        $albumraw = $req->imgname;
        if(isset($req->imgname)){
            foreach($albumraw as $olah1){
                $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                $jadi1 = explode(',', $olah1);
                $jadi2 = base64_decode($jadi1[2]);
                $lenstr = strripos($jadi1[0],'.');
                $test = substr($jadi1[0],$lenstr);
                $test3 = str_replace($test,'',$jadi1[0]);
                $test4 = str_replace('.','',$test3);
                $test44 = str_replace(' ','',$test4);
                $test5 = $test44.$waktu.$test;
                
                $alamaturl = '../public/upload/'.$test5;
                file_put_contents($alamaturl, $jadi2);

                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $req->o_srnbr,
                        'file_wonumber' => $req->o_wonbr,
                        'file_name' => $jadi1[0], //nama file asli
                        'file_url' => $alamaturl, 
                        'uploaded_at' => Carbon::now()->toDateTimeString(),
                    ]);
            }
        } A211022 */

        if ($req->hasfile('filenames')) {
            foreach ($req->file('filenames') as $upload) {
                $filename = $req->o_wonbr . '-' . $upload->getClientOriginalName();

                // Simpan File Upload pada Public
                $savepath = public_path('uploadwofinish/');
                $upload->move($savepath, $filename);

                // Simpan ke DB Upload
                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $req->o_srnbr,
                        'file_wonumber' => $req->o_wonbr,
                        'file_name'     => $filename, //$upload->getClientOriginalName(), //nama file asli
                        'file_url'      => $savepath . $filename,
                        'uploaded_at'   => Carbon::now()->toDateTimeString(),
                    ]);
            }
        }

        //update tabel wo
        DB::table('wo_mstr')
            ->where('wo_nbr', '=', $req->o_wonbr)
            ->update([
                'wo_action'         => $req->o_action,
                'wo_sparepart'      => $req->o_part,
                'wo_status'         => 'finish',
                'wo_finish_time'    => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                'wo_finish_date'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_system_time'    => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                'wo_system_date'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_updated_at'     => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
            ]);

        //update tabel sr
        DB::table("service_req_mstr")
            ->where('wo_number', '=', $req->o_wonbr)
            ->update([
                'sr_status' => 4,
                'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            ]);

        toast('Data Reported Successfuly', 'success');
        return redirect()->route('woreport');
    }

    public function openprint(Request $req, $wo)
    {
        // dd($wo);
        $repair = [];
        $countdb = [];
        $checkstr = [];
        $statusrepair = DB::table('wo_mstr')
            ->where('wo_mstr.wo_nbr', '=', $wo)
            ->first();
        $womstr = DB::table('wo_mstr')
            ->where('wo_nbr', '=', $wo)
            ->leftjoin('users', 'wo_mstr.wo_creator', 'users.username')
            ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
            ->leftJoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            ->leftJoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
            ->first();
        $wodet = DB::table('wo_dets')
            ->join('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
            ->where('wo_dets_nbr', '=', $wo)
            ->get();
        // dd($wodet);
        $data = DB::table('wo_mstr')
            ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status, wo_created_at, wo_schedule, wo_duedate
                wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_note,
                wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,
                u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, 
                loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,
                wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart')
            ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
            ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
            ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
            ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
            ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
            ->leftjoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
            ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
            ->leftjoin('loc_mstr', 'asset_mstr.asset_loc', 'loc_mstr.loc_code')

            ->where('wo_mstr.wo_nbr', '=', $wo)
            ->get();
        // dd($data);
        $statusrepair = DB::table('wo_mstr')
            ->where('wo_mstr.wo_nbr', '=', $wo)
            ->first();
        // dd($statusrepair);
        $arrayrepaircode = [];
        $repairlist = [];
        $arrayrepairdetail = [];
        $arrayrepairinst = [];
        $arraysptdesc = [];
        $currspt_desc = '';
        // $repair = '';
        $countrepairitr = 0;
        $engineerlist = DB::table('wo_mstr')
            ->selectRaw('a.name as eng1,b.name as eng2,c.name as eng3,d.name as eng4,e.name as eng5')
            ->leftjoin('users as a', 'wo_mstr.wo_engineer1', 'a.username')
            ->leftjoin('users as b', 'wo_mstr.wo_engineer2', 'b.username')
            ->leftjoin('users as c', 'wo_mstr.wo_engineer3', 'c.username')
            ->leftjoin('users as d', 'wo_mstr.wo_engineer4', 'd.username')
            ->leftjoin('users as e', 'wo_mstr.wo_engineer5', 'e.username')
            ->where('wo_mstr.wo_nbr', $wo)
            ->first();

        // dd($engineerlist);
        // dd($statusrepair);
        if ($statusrepair->wo_repair_type == 'manual') {
            $data = DB::table('wo_mstr')
                ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,
                                    wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1, wo_created_at,
                                    wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,
                                    wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, 
                                    u4.eng_desc as u44, u5.eng_desc as u55,loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,
                                    wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart')
                ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
                ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
                ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
                ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
                ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->leftjoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
                ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
                ->leftjoin('loc_mstr', 'asset_mstr.asset_loc', 'loc_mstr.loc_code')
                ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
                ->where('wo_mstr.wo_nbr', '=', $wo)
                ->get();
            $datamanual = DB::table('wo_manual_detail')
                ->where('wo_manual_wo_nbr', '=', $wo)
                ->get();
            $countdb = count($datamanual);
        } else if ($statusrepair->wo_repair_type == 'group') {
            $data = DB::table('wo_mstr')
                ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule, wo_created_at,
                            wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, 
                            loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart')
                ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
                ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
                ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
                ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
                ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->leftjoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
                ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
                ->leftjoin('loc_mstr', 'asset_mstr.asset_loc', 'loc_mstr.loc_code')
                ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
                ->where('wo_mstr.wo_nbr', '=', $wo)
                ->get();
            // dd($data);
            // for($pa = 1; $pa <= 5; $pa++)
            // $engineername = DB::table('wo_mstr')
            //                 ->join('users','wo_mstr.wo_asset','asset_mstr.asset_code')
            //                 ->join('loc_mstr as a','asset_mstr.asset_site','a.loc_site')
            //                 ->join('loc_mstr as b','asset_mstr.asset_loc','b.loc_code')        
            //                 ->where('wo_mstr.wo_nbr','=',$wo)  
            //                 ->first();
            $grouprepair = DB::table('xxrepgroup_mstr')
                ->where('xxrepgroup_nbr', '=', $statusrepair->wo_repair_group)
                ->get();
            foreach ($grouprepair as $grouprepair) {
                array_push($arrayrepaircode, $grouprepair->xxrepgroup_rep_code);
            }
            // dd($arrayrepaircode);
            $countrepairitr = count($arrayrepaircode);
            for ($i = 0; $i < count($arrayrepaircode); $i++) {
                // dd($i);
                $repairdesc = DB::table('rep_master')
                    ->where('rep_master.repm_code', '=', $arrayrepaircode[$i])
                    ->first();

                if (!is_null($repairdesc)) {
                    array_push($repairlist, $repairdesc->repm_desc);
                }

                $repair[$i] = DB::table('wo_mstr')
                    ->join('xxrepgroup_mstr', 'wo_mstr.wo_repair_group', 'xxrepgroup_mstr.xxrepgroup_nbr')
                    ->join('wo_dets', function ($join) {
                        $join->on('wo_dets.wo_dets_nbr', '=', 'wo_mstr.wo_nbr');
                        $join->on('wo_dets.wo_dets_rc', '=', 'xxrepgroup_mstr.xxrepgroup_rep_code');
                    })
                    ->join('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
                    // ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                    ->join('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
                    ->leftjoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
                    ->where('wo_mstr.wo_nbr', '=', $wo)
                    ->where('xxrepgroup_mstr.xxrepgroup_rep_code', '=', $arrayrepaircode[$i])
                    ->get();
                // $repair[$i] = DB::table('xxrepgroup_mstr')
                //                 ->leftjoin('rep_master','xxrepgroup_mstr.xxrepgroup_rep_code','rep_master.repm_code')
                //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                //                 // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
                //                 // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
                //                 // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
                //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                //                 // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
                //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                //                 // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
                //                 ->where('xxrepgroup_mstr.xxrepgroup_nbr','=',$statusrepair->wo_repair_group)

                //                 ->distinct('ins_mstr.ins_code')
                //                 ->orderBy('repm_ins','asc')

                //                 ->get();
                // dd(count($repair[$i]));
                foreach ($repair[$i] as $grouptool) {
                    $newarr = explode(",", $grouptool->ins_tool);
                    for ($po = 0; $po < count($newarr); $po++) {
                        $arr = DB::table('tool_mstr')
                            ->where('tool_code', '=', $newarr[$po])
                            ->first();
                        if (isset($arr->tool_desc)) {
                            $newarr[$po] = $arr->tool_desc;
                        } else {
                            $newarr[$po] = '';
                        }
                    }
                    $exparr = implode(",", $newarr);
                    $grouptool->ins_tool = $exparr;
                }
                // dd($repair,$arrayrepaircode[$i],$i);
                $check[$i] = DB::table('wo_mstr')
                    ->selectRaw('wrd_flag')
                    ->leftjoin('wo_rc_detail as a', 'wo_mstr.wo_nbr', 'a.wrd_wo_nbr')
                    ->where('wo_mstr.wo_nbr', '=', $wo)
                    ->where('a.wrd_repair_code', '=', $arrayrepaircode[$i])
                    ->first();
                if (isset($check[$i]) == true) {
                    $checkstr[$i] = $check[$i]->wrd_flag;
                } else {
                    $checkstr[$i] = 0;
                }
                // dd($repair[$i]);
                // dd(count($repair[$i]));    
                $countdb[$i] = count($repair[$i]);
            }
            // foreach($repair as $repair){
            //     // dd($repair);
            //     foreach($repair as $repair2){
            //         dd($repair2);
            //     }

            // }
            // dd($check[0]);
            // // dd($)
            // dd('aaa');

        } else if ($statusrepair->wo_repair_type == 'code') {
            $data = DB::table('wo_mstr')
                ->selectRaw('wo_nbr,wo_repair_code1,wo_repair_code2,wo_repair_code3,wo_priority,wo_dept,dept_desc, wo_created_at,
                            wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,
                            wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,
                            u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, 
                            u5.eng_desc as u55,loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,
                            wo_impact,wo_impact_desc,wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart')
                ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
                ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
                ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
                ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
                ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->leftjoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
                ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
                ->leftjoin('loc_mstr', 'asset_mstr.asset_loc', 'loc_mstr.loc_code')
                ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
                ->where('wo_mstr.wo_nbr', '=', $wo)
                ->get();
            // dd($data[0]->wo_repair_code1);
            if (isset($data[0]->wo_repair_code1)) {
                array_push($arrayrepaircode, $data[0]->wo_repair_code1);
            }
            if (isset($data[0]->wo_repair_code2)) {
                array_push($arrayrepaircode, $data[0]->wo_repair_code2);
            }
            if (isset($data[0]->wo_repair_code3)) {
                array_push($arrayrepaircode, $data[0]->wo_repair_code3);
            }
            $countrepairitr = count($arrayrepaircode);
            // dd($arrayrepaircode);
            for ($i = 0; $i < count($arrayrepaircode); $i++) {
                // dd($arrayrepaircode);
                $repairdesc = DB::table('rep_master')
                    ->where('rep_master.repm_code', '=', $arrayrepaircode[$i])
                    ->first();

                if (!is_null($repairdesc)) {
                    array_push($repairlist, $repairdesc->repm_desc);
                }

                $repair[$i] = DB::table('wo_mstr')
                    ->leftjoin('wo_dets', 'wo_dets.wo_dets_nbr', 'wo_mstr.wo_nbr')
                    ->leftjoin('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
                    ->leftjoin('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
                    // ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')

                    ->leftjoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
                    ->where('wo_mstr.wo_nbr', '=', $wo)
                    ->where('wo_dets.wo_dets_rc', '=', $arrayrepaircode[$i])

                    // ->groupBy('wo_mstr.wo_nbr','ins_mstr.ins_code')
                    ->distinct('ins_mstr.ins_code')
                    ->orderBy('repm_ins', 'asc')
                    ->get();
                // dd($repair);
                // $repair[$i] = DB::table('rep_master')
                //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                //                 ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
                //                 ->distinct('ins_mstr.ins_code')
                //                 ->orderBy('repm_ins','asc')

                //                 ->get();

                // dd($repair);
                // foreach ($repair[$i] as $grouptool) {
                //     $newarr = explode(",", $grouptool->ins_tool);
                //     for ($j = 0; $j < count($newarr); $j++) {
                //         $arr = DB::table('tool_mstr')
                //             ->where('tool_code', '=', $newarr[$j])
                //             ->first();
                //         if (isset($arr->tool_desc)) {
                //             $newarr[$j] = $arr->tool_desc;
                //         } else {
                //             $newarr[$j] = '';
                //         }
                //     }
                //     $exparr = implode(",", $newarr);
                //     $grouptool->ins_tool = $exparr;
                // }

                // $check[$i] = DB::table('wo_mstr')
                //     ->selectRaw('wrd_flag')
                //     ->leftjoin('wo_rc_detail as a', 'wo_mstr.wo_nbr', 'a.wrd_wo_nbr')
                //     ->where('wo_mstr.wo_nbr', '=', $wo)
                //     ->where('a.wrd_repair_code', '=', $arrayrepaircode[$i])
                //     ->first();
                // if (isset($check[$i]) == true) {
                //     $checkstr[$i] = $check[$i]->wrd_flag;
                // } else {
                //     $checkstr[$i] = 0;
                // }
                // // if(count($repair[$i])!= )

                // // dd(count($repair[1]));
                // $countdb[$i] = count($repair[$i]);
            }
        }
        // dd($data[0]->wo_nbr);
        // $repair = DB::table('wo_mstr')
        //         ->selectRaw('r1.repm_desc as r11,r2.repm_desc as r22, r3.repm_desc as r33')
        //         ->leftjoin('rep_master as r1','wo_mstr.wo_repair_code1','r1.repm_code')
        //         ->leftjoin('rep_master as r2','wo_mstr.wo_repair_code2','r2.repm_code')
        //         ->leftjoin('rep_master as r3','wo_mstr.wo_repair_code3','r3.repm_code')
        //         ->where('wo_mstr.wo_nbr','=',$wo)
        //         ->get();
        // $repair2 = DB::table('wo_mstr')
        //         ->selectRaw('sp_mstr.spm_desc')
        //         ->join('rep_master','wo_mstr.wo_repair_code2','rep_master.repm_code')
        //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //             ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        //             ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        //             ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        //             ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        //         ->where('wo_mstr.wo_nbr','=',$wo)
        //         // ->groupBy('spt_code')
        //         ->orderBy('spt_desc')
        //         ->get();
        // $repair1 = DB::table('wo_mstr')
        //         ->selectRaw('sp_mstr.spm_desc')
        //         ->join('rep_master','wo_mstr.wo_repair_code1','rep_master.repm_code')
        //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //         ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        //         ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        //         ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        //         ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        //         ->where('wo_mstr.wo_nbr','=',$wo)
        //         // ->groupBy('spt_code')
        //         ->orderBy('spt_desc')
        //         ->get();
        // $repair3 = DB::table('wo_mstr')
        //         ->selectRaw('sp_mstr.spm_desc')
        //         ->join('rep_master','wo_mstr.wo_repair_code3','rep_master.repm_code')
        //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //             ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        //             ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        //             ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        //             ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        //         ->where('wo_mstr.wo_nbr','=',$wo)
        //         // ->groupBy('spt_code')
        //         ->orderBy('spt_desc')
        //         ->get();

        // $collcon = $repair1->concat($repair2)->concat($repair3);
        // $array = [];
        // dd($repairlist);
        // foreach($engineerlist as $el){
        //     dd($el);
        // }
        // dd($engineerlist);
        // for($i = 0; $i < count($collcon);$i++){
        //     if($collcon[$i]->spm_desc =='' || $collcon[$i]->spm_desc == null){
        //         unset($collcon[$i]);       
        //     }
        //     else{
        //         array_push($array,$collcon[$i]->spm_desc);
        //     }
        // }
        // $array = array_values(array_unique($array));

        // dd($array);
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
            ->whereWo_number($wo)
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

        // $pdf = PDF::loadview('workorder.pdfprint-template',['womstr' => $womstr,'wodet' => $wodet, 'data' => $data,'printdate' =>$printdate,'repair'=>$repair,'sparepart'=>$array])->setPaper('A4','portrait');
        $pdf = PDF::loadview('workorder.pdfprint-template', [
            'sparepart' => $sparepartarray, 'womstr' => $womstr,
            'repairlist' => $repairlist, 'data' => $data, 'repair' => $repair, 'counter' => 0, 'countdb' => $countdb,
            'check' => $checkstr, 'countrepairitre' => $countrepairitr, 'printdate' => $printdate, 'engineerlist' => $engineerlist,
            'users' => $users, 'datasr' => $datasr, 'impact' => $impact, 'dept' => $dept
        ])->setPaper('A4', 'portrait');
        //return view('picklistbrowse.shipperprint-template',['printdata1' => $printdata1, 'printdata2' => $printdata2, 'runningnbr' => $runningnbr,'user' => $user,'last' =>$countprint]);
        return $pdf->stream($wo . '.pdf');
    }

    public function openprint2(Request $req, $wo)
    {
        // dd($wo);
        // dd($wodet);
        // dd('aaa');
        $repair = [];
        $countdb = [];
        $checkstr = [];
        $statusrepair = DB::table('wo_mstr')
            ->where('wo_mstr.wo_nbr', '=', $wo)
            ->first();
        // dd($statusrepair);
        $arrayrepaircode = [];
        $arrayrepairdetail = [];
        $arrayrepairinst = [];
        $arraysptdesc = [];
        $currspt_desc = '';
        // $repair = '';
        $countrepairitr = 0;
        $wotype = substr($wo, 0, 2);
        // dd($statusrepair);
        $engineerlist = DB::table('wo_mstr')
            ->selectRaw('a.name as eng1,b.name as eng2,c.name as eng3,d.name as eng4,e.name as eng5')
            ->leftjoin('users as a', 'wo_mstr.wo_engineer1', 'a.username')
            ->leftjoin('users as b', 'wo_mstr.wo_engineer2', 'b.username')
            ->leftjoin('users as c', 'wo_mstr.wo_engineer3', 'c.username')
            ->leftjoin('users as d', 'wo_mstr.wo_engineer4', 'd.username')
            ->leftjoin('users as e', 'wo_mstr.wo_engineer5', 'e.username')
            ->where('wo_mstr.wo_nbr', $wo)
            ->first();
        if ($statusrepair->wo_repair_type == 'manual') {
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->leftjoin('loc_mstr as a', 'asset_mstr.asset_site', 'a.loc_site')
                ->leftjoin('loc_mstr as b', 'asset_mstr.asset_loc', 'b.loc_code')
                ->where('wo_mstr.wo_nbr', '=', $wo)
                ->first();

            $datamanual = DB::table('wo_manual_detail')
                ->where('wo_manual_wo_nbr', '=', $wo)
                ->get();
            // dd($datamanual);
            $countdb = count($datamanual);
        } else if ($statusrepair->wo_repair_type == 'group') {

            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->leftjoin('loc_mstr as a', 'asset_mstr.asset_site', 'a.loc_site')
                ->leftjoin('loc_mstr as b', 'asset_mstr.asset_loc', 'b.loc_code')
                ->where('wo_mstr.wo_nbr', '=', $wo)
                ->first();
            // dd($data);

            $grouprepair = DB::table('xxrepgroup_mstr')
                ->where('xxrepgroup_nbr', '=', $statusrepair->wo_repair_group)
                ->get();
            foreach ($grouprepair as $grouprepair) {
                array_push($arrayrepaircode, $grouprepair->xxrepgroup_rep_code);
            }
            // dd($arrayrepaircode);
            $countrepairitr = count($arrayrepaircode);
            for ($i = 0; $i < count($arrayrepaircode); $i++) {
                // $repair[$i] = DB::table('xxrepgroup_mstr')
                //                 ->leftjoin('rep_master','xxrepgroup_mstr.xxrepgroup_rep_code','rep_master.repm_code')
                //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                //                 // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
                //                 // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
                //                 // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
                //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                //                 // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
                //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                //                 // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
                //                 ->where('xxrepgroup_mstr.xxrepgroup_nbr','=',$statusrepair->wo_repair_group)
                //                 ->where('xxrepgroup_mstr.xxrepgroup_rep_code','=',$arrayrepaircode[$i])
                //                 ->distinct('ins_mstr.ins_code')
                //                 ->orderBy('repm_ins','asc')

                //                 ->get();

                $repair[$i] = DB::table('wo_mstr')
                    ->join('xxrepgroup_mstr', 'wo_mstr.wo_repair_group', 'xxrepgroup_mstr.xxrepgroup_nbr')
                    ->join('wo_dets', function ($join) {
                        $join->on('wo_dets.wo_dets_nbr', '=', 'wo_mstr.wo_nbr');
                        $join->on('wo_dets.wo_dets_rc', '=', 'xxrepgroup_mstr.xxrepgroup_rep_code');
                    })
                    ->join('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
                    // ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                    ->join('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
                    ->leftjoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
                    ->where('wo_mstr.wo_nbr', '=', $wo)
                    ->where('xxrepgroup_mstr.xxrepgroup_rep_code', '=', $arrayrepaircode[$i])
                    ->get();
                //dd($repair);
                foreach ($repair[$i] as $grouptool) {
                    $newarr = explode(",", $grouptool->ins_tool);
                    for ($po = 0; $po < count($newarr); $po++) {
                        $arr = DB::table('tool_mstr')
                            ->where('tool_code', '=', $newarr[$po])
                            ->first();
                        if (isset($arr->tool_desc)) {
                            $newarr[$po] = $arr->tool_desc;
                        } else {
                            $newarr[$po] = '';
                        }
                    }
                    $exparr = implode(",", $newarr);
                    $grouptool->ins_tool = $exparr;
                }
                // dd($repair,$arrayrepaircode[$i]);
                // $check[$i] = DB::table('wo_mstr')
                //     ->selectRaw('wrd_flag')
                //     ->leftjoin('wo_rc_detail as a', 'wo_mstr.wo_nbr', 'a.wrd_wo_nbr')
                //     ->where('wo_mstr.wo_nbr', '=', $wo)
                //     ->where('a.wrd_repair_code', '=', $arrayrepaircode[$i])
                //     ->first();
                // if (isset($check[$i]) == true) {
                //     $checkstr[$i] = $check[$i]->wrd_flag;
                // } else {
                //     $checkstr[$i] = 0;
                // }
                // $countdb[$i] = count($repair[$i]);
            }
        } else if ($statusrepair->wo_repair_type == 'code') {
            // dd($statusrepair);
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->leftjoin('loc_mstr as a', 'asset_mstr.asset_site', 'a.loc_site')
                ->leftjoin('loc_mstr as b', 'asset_mstr.asset_loc', 'b.loc_code')
                ->where('wo_mstr.wo_nbr', '=', $wo)
                ->first();
            // dd($data);
            if (isset($data->wo_repair_code1)) {
                array_push($arrayrepaircode, $data->wo_repair_code1);
            }
            if (isset($data->wo_repair_code2)) {
                array_push($arrayrepaircode, $data->wo_repair_code2);
            }
            if (isset($data->wo_repair_code3)) {
                array_push($arrayrepaircode, $data->wo_repair_code3);
            }
            $countrepairitr = count($arrayrepaircode);
            // dd($arrayrepaircode);
            for ($i = 0; $i < count($arrayrepaircode); $i++) {
                // dd($arrayrepaircode[$i]);
                $repair[$i] = DB::table('wo_mstr')
                    ->join('wo_dets', 'wo_dets.wo_dets_nbr', 'wo_mstr.wo_nbr')
                    ->join('ins_mstr', 'wo_dets.wo_dets_ins', 'ins_mstr.ins_code')
                    ->join('rep_master', 'wo_dets.wo_dets_rc', 'rep_master.repm_code')
                    // ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')

                    ->leftjoin('sp_mstr', 'wo_dets.wo_dets_sp', 'sp_mstr.spm_code')
                    ->where('wo_mstr.wo_nbr', '=', $wo)
                    ->where('wo_dets.wo_dets_rc', '=', $arrayrepaircode[$i])

                    // ->groupBy('wo_mstr.wo_nbr','ins_mstr.ins_code')
                    ->distinct('ins_mstr.ins_code')
                    ->orderBy('repm_ins', 'asc')
                    ->get();
                // dd('aaa');
                // dd($repair);
                // $repair[$i] = DB::table('rep_master')
                //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                //                 ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
                //                 ->distinct('ins_mstr.ins_code')
                //                 ->orderBy('repm_ins','asc')
                //                 ->get();

                foreach ($repair[$i] as $grouptool) {
                    $newarr = explode(",", $grouptool->ins_tool);
                    for ($j = 0; $j < count($newarr); $j++) {
                        $arr = DB::table('tool_mstr')
                            ->where('tool_code', '=', $newarr[$j])
                            ->first();
                        if (isset($arr->tool_desc)) {
                            $newarr[$j] = $arr->tool_desc;
                        } else {
                            $newarr[$j] = '';
                        }
                    }
                    $exparr = implode(",", $newarr);
                    $grouptool->ins_tool = $exparr;
                }

                // $check[$i] = DB::table('wo_mstr')
                //     ->selectRaw('wrd_flag')
                //     ->leftjoin('wo_rc_detail as a', 'wo_mstr.wo_nbr', 'a.wrd_wo_nbr')
                //     ->where('wo_mstr.wo_nbr', '=', $wo)
                //     ->where('a.wrd_repair_code', '=', $arrayrepaircode[$i])
                //     ->first();
                // if (isset($check[$i]) == true) {
                //     $checkstr[$i] = $check[$i]->wrd_flag;
                // } else {
                //     $checkstr[$i] = 0;
                // }
                // if(count($repair[$i])!= )

                // dd(count($repair[1]));
                $countdb[$i] = count($repair[$i]);
            }
        }
        // foreach ($repair as $repair1){
        //     if(count($repair1) == 0){
        //         dd(count($repair1));
        //     }

        // }

        $womstr = DB::table('wo_mstr')
            ->where('wo_nbr', '=', $wo)
            ->leftjoin('users', 'wo_mstr.wo_creator', 'users.username')
            ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
            ->leftJoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            ->leftJoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
            ->first();

        $datasr = DB::table('service_req_mstr')
            ->whereWo_number($wo)
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

        $printdate = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        $printname = session::get('username');
        // dd($repair);

        if ($statusrepair->wo_repair_type == 'manual') {
            // $pdf = PDF::loadview('workorder.pdfprint2-template', ['wotype' => $wotype, 'data' => $data, 'datamanual' => $datamanual, 'counter' => 0, 'countdb' => $countdb, 'printdate' => $printdate, 'engineerlist' => $engineerlist])->setPaper('A4', 'portrait');
            $pdf = PDF::loadview('workorder.pdfprint-template', ['womstr' => $womstr, 'datasr' => $datasr, 'impact' => $impact, 'dept' => $dept, 'wotype' => $wotype, 'data' => $data, 'datamanual' => $datamanual, 'counter' => 0, 'countdb' => $countdb, 'printdate' => $printdate, 'engineerlist' => $engineerlist])->setPaper('A4', 'portrait');
        } else {
            // $pdf = PDF::loadview('workorder.pdfprint2-template', ['wotype' => $wotype, 'data' => $data, 'repair' => $repair, 'counter' => 0, 'countdb' => $countdb, 'check' => $checkstr, 'countrepairitre' => $countrepairitr, 'printname' => $printname, 'printdate' => $printdate, 'engineerlist' => $engineerlist])->setPaper('A4', 'portrait');
            $pdf = PDF::loadview('workorder.pdfprint-template', ['womstr' => $womstr, 'datasr' => $datasr, 'impact' => $impact, 'dept' => $dept, 'wotype' => $wotype, 'data' => $data, 'repair' => $repair, 'counter' => 0, 'countdb' => $countdb, 'check' => $checkstr, 'countrepairitre' => $countrepairitr, 'printname' => $printname, 'printdate' => $printdate, 'engineerlist' => $engineerlist])->setPaper('A4', 'portrait');
        }


        //  return view('picklistbrowse.shipperprint-template',['printdata1' => $printdata1, 'printdata2' => $printdata2, 'runningnbr' => $runningnbr,'user' => $user,'last' =>$countprint]);
        return $pdf->stream($wo . '.pdf');
        // return view('workorder.pdfprint2-template',['data' => $data,'repair'=>$repair,'counter'=>0,'countdb'=>$countdb,'check'=>$checkstr,'countrepairitre' => $countrepairitr,'printname'=>$printname,'printdate'=>$printdate,'engineerlist'=>$engineerlist]);
    }

    public function donlodwo(Request $req)
    {
        // dd('Fungsi belum berjalan');
        // dd($req->all());
        $wonbr    = $req->wonumber;
        $asset    = $req->asset;
        $status   = $req->status;
        $priority = $req->priority;
        $period   = $req->period;
        $creator  = $req->creator;
        $engineer = $req->engineer;
        // $stats = DB::table('wo_mstr')
        //         ->selectRaw('wo_nbr,wo_asset,wo_schedule,wo_duedate,wo_status,wo_priority,CAST(wo_created_at AS DATE) AS wo_created_at,wo_creator')
        //         ->get();
        return Excel::download(new ViewExport2($wonbr, $status, $asset, $priority, $period, $creator, $engineer), 'Work Order.xlsx');
    }

    public function getrepair1(Request $req, $rc1)
    {
        // dd($rc1);

        $repair1 = DB::table('rep_master')
            ->leftjoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
            ->leftjoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
            // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
            ->leftjoin('sp_mstr', 'ins_mstr.ins_part', 'sp_mstr.spm_code')
            ->where('rep_master.repm_code', '=', $rc1)
            ->distinct('ins_mstr.ins_code')
            ->orderBy('repm_ins', 'asc')

            ->get();
        // dd($repair1);
        foreach ($repair1 as $grouptool) {
            $newarr = explode(",", $grouptool->ins_tool);
            for ($i = 0; $i < count($newarr); $i++) {
                $arr = DB::table('tool_mstr')
                    ->where('tool_code', '=', $newarr[$i])
                    ->first();
                if (isset($arr->tool_desc)) {
                    $newarr[$i] = $arr->tool_desc;
                } else {
                    $newarr[$i] = '';
                }
            }
            $exparr = implode(",", $newarr);
            $grouptool->ins_tool = $exparr;
        }

        $countrepair1 = count($repair1);
        // dd($repair1);
        return $repair1;
    }

    public function getgroup1(Request $req, $rg1)
    {

        $group1 = DB::table('xxrepgroup_mstr')
            // ->selectRaw("xxrepgroup_nbr, xxrepgroup_desc, xxrepgroup_rep_code, xxrepgroup_rep_desc,spt_desc, spm_code, spm_desc, ins_code , ins_desc, repdet_std ")
            ->leftjoin('rep_master', 'xxrepgroup_mstr.xxrepgroup_rep_code', 'rep_master.repm_code')
            ->leftjoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
            // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
            // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
            // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
            ->leftjoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
            // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
            // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
            ->leftjoin('sp_mstr', 'ins_mstr.ins_part', 'sp_mstr.spm_code')
            // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
            ->where('xxrepgroup_mstr.xxrepgroup_nbr', '=', $rg1)
            ->distinct('ins_mstr.ins_code')
            ->orderBy('repm_ins', 'asc')

            // ->orderBy('insg_line','asc')

            // ->orderby('xxrepgroup_rep_code','asc')
            // ->orderby('spt_desc','asc')
            // ->orderBy('insg_line','asc')
            ->get();

        // dd($group1);
        foreach ($group1 as $grouptool) {
            $newarr = explode(",", $grouptool->ins_tool);
            for ($i = 0; $i < count($newarr); $i++) {
                $arr = DB::table('tool_mstr')
                    ->where('tool_code', '=', $newarr[$i])
                    ->first();
                if (isset($arr->tool_desc)) {
                    $newarr[$i] = $arr->tool_desc;
                } else {
                    $newarr[$i] = '';
                }
            }
            // dd($newarr);
            if (end($newarr) != '') {
                $exparr = implode(",", $newarr);
            } else {
                $exparr = implode(" ", $newarr);
            }
            $grouptool->ins_tool = $exparr;
        }


        $countrepair1 = count($group1);
        // dd($group1);
        // dd($group1);
        return $group1;
    }

    public function statusreportingwo(Request $req)
    {
        // dd($req->all());
        $wonumber = $req->aprwonbr2;
        $srnbr = $req->aprsrnbr2;
        $wonote = $req->ac_reportnote;

        if ($req->hasfile('fileother')) {
            foreach ($req->file('fileother') as $upload) {
                $filename = $wonumber . '-' . $upload->getClientOriginalName();

                $cekfile = DB::table('acceptance_image')
                    ->whereFile_wonumber($wonumber)
                    ->wherefile_name($filename)
                    ->count();

                if ($cekfile > 0) {
                    toast('File names cannot be same.', 'error');
                    return back();
                }

                // Simpan File Upload pada Public
                $savepath = public_path('uploadwofinish/');
                $upload->move($savepath, $filename);

                // Simpan ke DB Upload
                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $srnbr,
                        'file_wonumber' => $wonumber,
                        'file_name'     => $filename, //$upload->getClientOriginalName(), //nama file asli
                        'file_url'      => $savepath . $filename,
                        'uploaded_at'   => Carbon::now()->toDateTimeString(),
                    ]);
            }
        }


        if ($req->switch2 == 'approve') { //di approve
            // $exprc = explode(',',$req->repaircodeapp);
            if ($req->formtype == 1) {
                DB::table('wo_mstr')
                    ->where('wo_nbr', '=', $wonumber)
                    ->update([
                        'wo_status' => 'QC Approval',
                        'wo_approval_note' => $wonote, //B211019
                        'wo_reviewer' => Session::get('username'),
                        'wo_reviewer_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()
                    ]);

                toast('Work Order ' . $wonumber . ' Approved by reviewer ', 'success');
                return redirect()->route('womaint');
            } else if ($req->formtype == 2) {

                // dd('lg maintenance');

                // $albumraw = $req->imgname;
                DB::table('wo_mstr')
                    ->where('wo_nbr', '=', $wonumber)
                    ->update([
                        'wo_status' => 'QC Approval',
                        'wo_approval_note' => $wonote, //B211019
                        'wo_approver' => Session::get('username'),
                        'wo_approver_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()

                    ]);

                // A210927
                if ($srnbr !== null) {
                    DB::table('service_req_mstr')
                        ->where('sr_number', '=', $srnbr)
                        ->update([
                            'sr_status' => '7',
                        ]);
                }

                toast('Work Order ' . $wonumber . ' Completed ', 'success');
                return redirect()->route('womaint');
            }

            // A210927
            if ($srnbr !== null) {
                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnbr)
                    ->update([
                        'sr_status' => '7',
                    ]);
            }
        } else {

            DB::table('wo_mstr')
                ->where('wo_nbr', $wonumber)
                // ->update(['wo_status'=>'closed','wo_reject_reason'=>$req->uncompletenote]); --> A210927
                ->update([
                    'wo_status' => 'started',
                    'wo_reject_reason' => $req->uncompletenote,
                    'wo_approval_note' => $wonote, //B211019
                ]);
            toast('Work Order ' . $wonumber . ' reprocess ', 'success');

            // A210927  --> A211019 --> A211101
            if ($srnbr !== null) {
                DB::table('service_req_mstr')
                    ->where('sr_number', '=', $srnbr)
                    ->update([
                        'sr_status' => '3',
                    ]);
            }

            return redirect()->route('womaint');
        }

        //EmailScheduleJobs::dispatch($wonumber,'','6','','',$srnbr,''); // A211021
    }

    public function downloadfile(Request $req, $wo)
    { /* blade : workorder.table-wobrowse */
        $zip = new ZipArchive;

        $assetnow = DB::table('wo_mstr')
            ->where('wo_nbr', '=', $wo)
            ->first();

        // dd($wo);

        $listdownload = DB::table('asset_upload')
            ->where('asset_code', '=', $assetnow->wo_asset)
            ->get();

        /* A211103 */
        $listfinish = DB::table('acceptance_image')
            ->whereFile_wonumber($wo)
            ->get();

        $fileName = $wo . '_' . $assetnow->wo_asset . '.zip';

        if (count($listdownload) > 0 || count($listfinish) > 0) {
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                foreach ($listdownload as $listdown) {
                    $files = File::get($listdown->filepath);
                    $relativeNameInZipFile = basename($listdown->filepath);
                    $zip->addFile($listdown->filepath, $relativeNameInZipFile);
                }

                /* A211103 */
                foreach ($listfinish as $listfinish) {
                    $files = File::get($listfinish->file_url);
                    $relativeNameInZipFile = basename($listfinish->file_url);
                    $zip->addFile($listfinish->file_url, $relativeNameInZipFile);
                }

                $zip->close();
            }

            return response()->download(public_path($fileName));
        } else {
            toast('Tidak ada dokumen untuk pada WO ' . $wo . '!', 'error');
            return back();
        }
    }

    public function getpreventivecreate($asset)
    {
        $assetnow = DB::table('asset_mstr')
            ->where('asset_code', '=', $asset)
            ->first();

        // return 
    }

    public function downloadwofinish($id)
    {

        $datafile = DB::table('acceptance_image')
            ->where('accept_img_id', '=', $id)
            ->first();

        if ($datafile) {

            $lastindex = strrpos($datafile->file_url, "/");
            $filename = substr($datafile->file_wonumber . '-' . $datafile->file_name, $lastindex + 1);

            return Response::download($datafile->file_url, $datafile->file_name);
        } else {
            toast('There is no file', 'error');
            return back();
        }
    }

    public function delfilewofinish($id)
    {

        $data1 = DB::table('acceptance_image')
            ->where('accept_img_id', $id)
            ->first();

        if ($data1) {
            $lastindex = strrpos($data1->file_url, "/");
            $filename = substr($data1->file_url, $lastindex + 1);

            $filename = public_path('/uploadwofinish/' . $filename);

            if (File::exists($filename)) {
                File::delete($filename);

                DB::table('acceptance_image')
                    ->where('accept_img_id', $id)
                    ->delete();
            }
        }

        $gambar = DB::table('acceptance_image')
            ->where('file_wonumber', '=', $data1->file_wonumber)
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

        return response($output);
    }

    public function returnsp(Request $req)
    {
        if (Session::get('role') == 'ADMIN') {
            // $data = DB::table('wo_mstr')
            //     ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            //     ->where('wo_status','=','closed')
            //     ->orderby('wo_created_at', 'desc')
            //     ->orderBy('wo_mstr.wo_id', 'desc')
            //     ->paginate(10);

            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->join('returnback_sp', 'wo_mstr.wo_nbr', '=', 'returnback_sp.rb_wonbr')
                ->where('wo_mstr.wo_status', '=', 'closed')
                ->where('returnback_sp.rb_qtyreturnback', '>', 0);

            $data = $data->groupBy('wo_nbr');

            $data = $data->orderBy('wo_nbr', 'desc')->paginate(10);

            // dd($data);

            $engineer = DB::table('users')
                ->join('roles', 'users.role_user', 'roles.role_code')
                ->where('role_desc', '=', 'Engineer')
                ->get();
            $asset = DB::table('wo_mstr')
                ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                ->join('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->where(function ($status) {
                    $status->where('wo_status', '=', 'open')
                        ->orwhere('wo_status', '=', 'started');
                })
                ->groupBy('asset_code')
                ->orderBy('asset_code')
                ->get();
        } else {
            // $data = DB::table('wo_mstr')
            //     ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            //     ->where('wo_status','=','closed')
            //     ->where('wo_user_input','=', Session::get('username'))
            //     ->orderby('wo_created_at', 'desc')
            //     ->orderBy('wo_mstr.wo_id', 'desc')
            //     ->paginate(10);

            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->join('returnback_sp', 'wo_mstr.wo_nbr', '=', 'returnback_sp.rb_wonbr')
                ->where('wo_mstr.wo_status', '=', 'closed')
                ->where('returnback_sp.rb_qtyreturnback', '>', 0)
                ->where('wo_user_input', '=', Session::get('username'));

            $data = $data->groupBy('wo_nbr');

            $data = $data->orderBy('wo_nbr', 'desc')->paginate(10);
            // dd($data);
            // }
            // dd($data);
            $engineer = DB::table('users')
                ->join('roles', 'users.role_user', 'roles.role_code')
                ->where('role_desc', '=', 'Engineer')
                ->get();
            $asset = DB::table('wo_mstr')
                ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                ->join('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
                ->where(function ($status) {
                    $status->where('wo_status', '=', 'open')
                        ->orwhere('wo_status', '=', 'started');
                })
                ->where(function ($query) {
                    $query->where('wo_engineer1', '=', Session()->get('username'))
                        ->orwhere('wo_engineer2', '=', Session()->get('username'))
                        ->orwhere('wo_engineer3', '=', Session()->get('username'))
                        ->orwhere('wo_engineer4', '=', Session()->get('username'))
                        ->orwhere('wo_engineer5', '=', Session()->get('username'));
                })
                ->groupBy('asset_code')
                ->orderBy('asset_code')
                ->get();
        }

        return view('workorder.returnbacksp-browse', ['data' => $data, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset]);
    }

    public function returnsp_detail($wonbr)
    {
        $datadetail = DB::table('returnback_sp')
            ->where('rb_wonbr', $wonbr)
            ->get();

        $datadetail_master = DB::table('wo_mstr')
            ->leftjoin('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            ->where('wo_nbr', '=', $wonbr)
            ->select('wo_nbr', 'wo_asset', 'wo_asset_site', 'wo_asset_loc', 'wo_finish_date', 'wo_finish_time', 'asset_code', 'asset_desc')
            ->first();

        // dd($datadetail_master);

        return view('workorder.returnbacksp-detail', ['datadetail' => $datadetail, 'detailmaster' => $datadetail_master]);
    }

    public function submit_returnback(Request $req)
    {
        // dd($req->all());

        DB::beginTransaction();

        try {

            /* ini qxtend transfer single item */

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
                    <qcom:propertyValue>mfg</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                    <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                    <qcom:propertyName>password</qcom:propertyName>
                    <qcom:propertyValue></qcom:propertyValue>
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

            foreach ($req->tick as $thistick => $value) { //cek apakah dichecklist confirm
                if ($req->qtyreturnback[$thistick] > 0) { //cek apakah qty yang dikembalikan tidak 0
                    $qdocBody .= '<item>
                                <part>' . $req->spcode[$thistick] . '</part>
                                <itemDetail>
                                    <lotserialQty>' . $req->qtyreturnback[$thistick] . '</lotserialQty>
                                    <nbr>' . $req->wonbr[$thistick] . '</nbr>
                                    <siteFrom>' . $req->siteto[$thistick] . '</siteFrom>
                                    <locFrom>' . $req->locto[$thistick] . '</locFrom>
                                    <lotserFrom>' . $req->lotfrom[$thistick] . '</lotserFrom>
                                    <siteTo>' . $req->siteform[$thistick] . '</siteTo>
                                    <locTo>' . $req->locform[$thistick] . '</locTo>
                                </itemDetail>
                            </item>';

                    DB::table('returnback_sp')
                        ->where('rb_wonbr', '=', $req->wonbr[$thistick])
                        ->where('rb_spcode', '=', $req->spcode[$thistick])
                        // ->where('rb_sitefrom','=', $req->siteform[$thistick])
                        // ->where('rb_locfrom','=', $req->locform[$thistick])
                        ->update([
                            'rb_qtyreturnback' => DB::raw('rb_qtyreturnback - ' . $req->qtyreturnback[$thistick]),
                            'rb_qtyreturned' => DB::raw('rb_qtyreturned + ' . $req->qtyreturnback[$thistick]),
                            'rb_updated_at' => Carbon::now(),
                        ]);
                }
            }

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
                DB::commit();
                toast('Confirm Transfer Back Spare Part from ' . $req->wonbr[0] . ' Successfuly !', 'success');
                return redirect()->route('returnSPBrowse');
            } else {

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
                return redirect()->route('returnSPBrowse');
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Save Error', 'error');
            return redirect()->route('returnSPBrowse');
        }
    }

    public function checkfailurecodetype(Request $req)
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
}
//tanggal betulin 24 may 2021 - 1553