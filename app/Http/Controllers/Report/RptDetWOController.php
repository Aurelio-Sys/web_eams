<?php

namespace App\Http\Controllers\Report;

use App\Exports\DetailWOExport;
use App\Http\Controllers\Controller;
use App\Services\CreateTempTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ViewExport2;

class RptDetWOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $usernow = DB::table('users')
            ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
            ->where('username', '=', session()->get('username'))
            ->first();

        $data = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->orderby('wo_created_at', 'desc')
            ->orderBy('wo_mstr.wo_id', 'desc')
            ->paginate(10);

        $custrnow = DB::table('wo_mstr')
            ->selectRaw('wo_creator,min(name) as creator_desc')
            ->join('users', 'wo_mstr.wo_creator', 'users.username')
            ->groupBy('wo_creator')
            ->get();

        $depart = DB::table('dept_mstr')
            ->orderBy('dept_code')
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

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        Schema::create('temp_wo', function ($table) {
            $table->increments('id');
            $table->string('temp_wo');
            $table->string('temp_sr')->nullable();
            $table->string('temp_type')->nullable();
            $table->string('temp_asset')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('temp_asset_desc')->nullable();
            $table->string('temp_asset_loc')->nullable();
            $table->string('temp_asset_site')->nullable();
            $table->string('temp_creator')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci'); /* Untuk PM Creator nya kosong */
            $table->date('temp_create_date');
            $table->date('temp_sch_date');
            $table->string('temp_fail_type')->nullable();
            $table->string('temp_fail_code')->nullable();
            $table->string('temp_note')->nullable();
            $table->string('temp_repair')->nullable();
            $table->string('temp_status');
            $table->string('temp_sp')->nullable();
            $table->string('temp_sp_desc')->nullable();
            $table->decimal('temp_qty_req',10,2)->nullable();
            $table->decimal('temp_qty_whs',10,2)->nullable();
            $table->string('temp_eng1')->nullable();
            $table->string('temp_eng2')->nullable();
            $table->string('temp_eng3')->nullable();
            $table->string('temp_eng4')->nullable();
            $table->string('temp_eng5')->nullable();
            $table->temporary();
        });

        /* Mencari data sparepart dari wo detail */
        $datadets = DB::table('wo_dets')
            ->join('wo_mstr','wo_nbr','=','wo_dets_nbr')
            ->leftjoin('rep_master','repm_code','wo_dets_rc')
            // ->whereNotNull('wo_dets_sp')
            ->orderBy('wo_dets_nbr')
            ->get();
// dd($datadets);
        foreach($datadets as $da){
            DB::table('temp_wo')->insert([
                'temp_wo' => $da->wo_nbr,
                'temp_type' => $da->wo_type == 'auto' ? 'PM' : 'WO',
                'temp_sr' => $da->wo_sr_nbr,
                'temp_asset' => $da->wo_asset,
                'temp_asset_desc' => DB::table('asset_mstr')->where('asset_code','=',$da->wo_asset)->value('asset_desc'),
                'temp_asset_site' => $da->wo_asset_site,
                'temp_asset_loc' => $da->wo_asset_loc,
                'temp_creator' => $da->wo_creator,
                'temp_create_date' => $da->wo_created_at,
                'temp_sch_date' => $da->wo_schedule,
                'temp_fail_type' => $da->wo_new_type,
                'temp_fail_code' => $da->wo_failure_code1.";".$da->wo_failure_code2.";".$da->wo_failure_code3,
                'temp_note' => $da->wo_note,
                'temp_repair' => $da->wo_dets_rc.' : '.$da->repm_desc,
                'temp_status' => $da->wo_status,
                'temp_sp' => $da->wo_dets_sp,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->wo_dets_sp)->value('spm_desc'),
                'temp_qty_req' => $da->wo_dets_sp_qty,
                'temp_qty_whs' => $da->wo_dets_qty_used,
                'temp_eng1' => $da->wo_engineer1,
                'temp_eng2' => $da->wo_engineer2,
                'temp_eng3' => $da->wo_engineer3,
                'temp_eng4' => $da->wo_engineer4,
                'temp_eng5' => $da->wo_engineer5,
            ]);
        }

        /* Mencari data sparepart yang belum ada wo detail nya */
        $datawo = DB::table('wo_mstr')->whereNotIn('wo_nbr', function($q){
                $q->select('wo_dets_nbr')->from('wo_dets');
            })
            ->get();

        foreach($datawo as $do) {
            if ($do->wo_repair_code1 != "") {

                $sparepart1 = DB::table('wo_mstr')
                    ->select('wo_nbr','wo_repair_code1 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc',
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status', 'wo_schedule',
                    'wo_sr_nbr', 'wo_creator', 'wo_created_at', 'wo_new_type', 'wo_failure_code1',
                    'wo_failure_code2', 'wo_failure_code3', 'wo_asset', 'wo_note', 'repm_desc', 'wo_type',
                    'wo_engineer1','wo_engineer2','wo_engineer3','wo_engineer4','wo_engineer5',
                    'wo_asset_site','wo_asset_loc')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code1', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc1 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code1', 'rep_master.repm_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->get();

                $combineSP = $sparepart1;
                $rc = $rc1;
            }

            if ($do->wo_repair_code2 != "") {
                $sparepart2 = DB::table('wo_mstr')
                    ->select('wo_nbr','wo_repair_code2 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc',
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status', 'wo_schedule',
                    'wo_sr_nbr', 'wo_creator', 'wo_created_at', 'wo_new_type', 'wo_failure_code1',
                    'wo_failure_code2', 'wo_failure_code3', 'wo_asset', 'wo_note', 'repm_desc', 'wo_type',
                    'wo_engineer1','wo_engineer2','wo_engineer3','wo_engineer4','wo_engineer5',
                    'wo_asset_site','wo_asset_loc')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code2', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc2 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code2', 'rep_master.repm_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->get();

                $combineSP = $sparepart1->merge($sparepart2);
                $rc = $rc1->merge($rc2);
            }

            if ($do->wo_repair_code3 != "") {
                $sparepart3 = DB::table('wo_mstr')
                    ->select('wo_nbr','wo_repair_code3 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc',
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status', 'wo_schedule',
                    'wo_sr_nbr', 'wo_creator', 'wo_created_at', 'wo_new_type', 'wo_failure_code1',
                    'wo_failure_code2', 'wo_failure_code3', 'wo_asset', 'wo_note', 'repm_desc', 'wo_type',
                    'wo_engineer1','wo_engineer2','wo_engineer3','wo_engineer4','wo_engineer5',
                    'wo_asset_site','wo_asset_loc')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc3 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->get();

                $combineSP = $sparepart1->merge($sparepart2)->merge($sparepart3);
                $rc = $rc1->merge($rc2)->merge($rc3);
            }

            if ($do->wo_repair_code1 == "" && $do->wo_repair_code2 == "" && $do->wo_repair_code3 == "") {
                $combineSP = DB::table('xxrepgroup_mstr')
                    ->select('wo_nbr','repm_code as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc', 
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status', 'wo_schedule',
                    'wo_sr_nbr', 'wo_creator', 'wo_created_at', 'wo_new_type', 'wo_failure_code1',
                    'wo_failure_code2', 'wo_failure_code3', 'wo_asset', 'wo_note', 'repm_desc', 'wo_type',
                    'wo_engineer1','wo_engineer2','wo_engineer3','wo_engineer4','wo_engineer5',
                    'wo_asset_site','wo_asset_loc')
                    ->leftjoin('rep_master', 'xxrepgroup_mstr.xxrepgroup_rep_code', 'rep_master.repm_code',)
                    ->leftjoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftjoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->leftJoin('wo_mstr','wo_repair_group','xxrepgroup_mstr.xxrepgroup_nbr')
                    ->where('xxrepgroup_mstr.xxrepgroup_nbr', '=', $do->wo_repair_group)
                    ->where('wo_id', '=', $do->wo_id)
                    ->orderBy('repair_code', 'asc')
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc = DB::table('xxrepgroup_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->leftjoin('rep_master', 'xxrepgroup_mstr.xxrepgroup_rep_code', 'rep_master.repm_code')
                    ->get();
            }
        }
        
        foreach($combineSP as $dc){
            DB::table('temp_wo')->insert([
                'temp_wo' => $dc->wo_nbr,
                'temp_type' => $da->wo_type == 'auto' ? 'PM' : 'WO',
                'temp_sr' => $dc->wo_sr_nbr,
                'temp_asset' => $dc->wo_asset,
                'temp_asset_desc' => DB::table('asset_mstr')->where('asset_code','=',$dc->wo_asset)->value('asset_desc'),
                'temp_asset_site' => $dc->wo_asset_site,
                'temp_asset_loc' => $dc->wo_asset_loc,
                'temp_creator' => $dc->wo_creator,
                'temp_create_date' => $dc->wo_created_at,
                'temp_sch_date' => $dc->wo_schedule,
                'temp_fail_type' => $dc->wo_new_type,
                'temp_fail_code' => $dc->wo_failure_code1.";".$dc->wo_failure_code2.";".$dc->wo_failure_code3,
                'temp_note' => $dc->wo_note,
                'temp_repair' => $dc->repair_code." : ".$dc->repm_desc,
                'temp_status' => $dc->wo_status,
                'temp_sp' => $dc->insd_part,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$dc->insd_part)->value('spm_desc'),
                'temp_qty_req' => $dc->insd_qty,
                'temp_qty_whs' => 0,
                'temp_eng1' => $dc->wo_engineer1,
                'temp_eng2' => $dc->wo_engineer2,
                'temp_eng3' => $dc->wo_engineer3,
                'temp_eng4' => $dc->wo_engineer4,
                'temp_eng5' => $dc->wo_engineer5,
            ]);
        }

        $datatemp = DB::table('temp_wo')
        ->orderBy('temp_create_date','desc')
        ->orderBy('temp_wo','desc');
        // dd($datatemp->get());

        if($request->s_nomorwo) {
            $datatemp = $datatemp->where('temp_wo','like','%'.$request->s_nomorwo.'%');
        }
        if($request->s_asset) {
            $datatemp = $datatemp->where('temp_asset','=',$request->s_asset);
        }
        if($request->s_per1) {
            $datatemp = $datatemp->whereBetween ('temp_create_date',[$request->s_per1,$request->s_per2]);
        }
        if($request->s_dept) {
            // dd("dept",$request->s_dept);
            $a = $request->s_dept;
            $datatemp = $datatemp->whereIn('temp_creator', function($query) use ($a)
            {
                $query->select('username')
                      ->from('users')
                      ->where('dept_user','=',$a);
            });
        }
        if($request->s_loc) {
            $a = $request->s_loc;
            $datatemp = $datatemp->where('temp_asset_loc','=',$a);
            // $datatemp = $datatemp->whereIn('temp_asset_loc', function($query) use ($a)
            // {
            //     $query->select('asset_code')
            //           ->from('asset_mstr')
            //           ->where('asset_loc','=',$a);
            // });
        }
        if($request->s_eng) {
            $datatemp = $datatemp->where('temp_eng1','=',$request->s_eng)
                ->orWhere('temp_eng2','=',$request->s_eng)
                ->orWhere('temp_eng3','=',$request->s_eng)
                ->orWhere('temp_eng4','=',$request->s_eng)
                ->orWhere('temp_eng5','=',$request->s_eng);
        }
        if($request->s_type) {
            $datatemp = $datatemp->where('temp_type','=',$request->s_type);
        } 
            
        $datatemp = $datatemp->paginate(10); 

        Schema::dropIfExists('temp_wo');
        // dd($impact);
        if ($request->dexcel == "excel") {
            // dd($request->stype);
            return Excel::download(new DetailWOExport($request->swo,$request->sasset,$request->per1,$request->per2,
            $request->sdept,$request->sloc,$request->seng,$request->stype), 'DetailWO.xlsx');
            
        } else {
            // dd($request->s_nomorwo);
            return view('report.rptdetwo', ['impact' => $impact, 'wottype' => $wottype, 'custrnow' => $custrnow, 
            'data' => $datatemp, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset, 
            'failure' => $failure, 'usernow' => $usernow, 'dept' => $depart, 'fromhome' => '', 'dataloc' => $dataloc,
            'swo' => $request->s_nomorwo, 'sasset' => $request->s_asset, 'sper1' => $request->s_per1, 'sper2' => $request->s_per2,
            'sdept' => $request->s_dept, 'sloc' => $request->s_loc, 'seng' => $request->s_eng, 'stype' => $request->s_type]);
        }
        

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
