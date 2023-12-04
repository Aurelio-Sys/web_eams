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
        //dd($request->all());
        $usernow = DB::table('users')
            ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
            ->where('username', '=', session()->get('username'))
            ->first();

        $data = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->orderby('wo_start_date', 'desc')
            ->orderBy('wo_mstr.id', 'desc')
            ->paginate(10);

        $custrnow = DB::table('wo_mstr')
            ->selectRaw('wo_createdby,min(name) as creator_desc')
            ->join('users', 'wo_mstr.wo_createdby', 'users.username')
            ->groupBy('wo_createdby')
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
            $table->string('temp_wo')->collation('utf8mb4_general_ci');
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
            $table->string('temp_dept')->nullable();
            $table->temporary();
        });

        /* 1 Mencari data sparepart dari wo detail */
        $datadets = DB::table('wo_dets_sp')
            ->join('wo_mstr','wo_number','=','wd_sp_wonumber')
            ->orderBy('wd_sp_wonumber')
            ->get();
// dd($datadets);
        foreach($datadets as $da){
            DB::table('temp_wo')->insert([
                'temp_wo' => $da->wo_number,
                'temp_type' => $da->wo_type,
                'temp_sr' => $da->wo_sr_number,
                'temp_asset' => $da->wo_asset_code,
                'temp_asset_desc' => DB::table('asset_mstr')->where('asset_code','=',$da->wo_asset_code)->value('asset_desc'),
                'temp_asset_site' => $da->wo_site,
                'temp_asset_loc' => $da->wo_location,
                'temp_creator' => $da->wo_createdby,
                'temp_create_date' => $da->wo_start_date,
                'temp_sch_date' => $da->wo_start_date,
                'temp_fail_type' => $da->wo_failure_type,
                'temp_fail_code' => $da->wo_failure_code.";".$da->wo_failure_code.";".$da->wo_failure_code,
                'temp_note' => $da->wo_note,
                'temp_repair' => "",
                'temp_status' => $da->wo_status,
                'temp_sp' => $da->wd_sp_spcode,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->wd_sp_spcode)->value('spm_desc'),
                'temp_qty_req' => $da->wd_sp_required,
                'temp_qty_whs' => $da->wd_sp_issued,
                'temp_eng1' => $da->wo_list_engineer,
                'temp_dept' => $da->wo_department,
            ]);
        }

        /* 2 Mencari data sparepart yang belum ada wo detail nya */
        $datawo = DB::table('wo_mstr')
            // ->where('wo_nbr','=','PM-23-004839')
            ->whereNotIn('wo_number', function($q){
                $q->select('wd_sp_wonumber')->from('wo_dets_sp');
            })
            ->get();
        // dd($datawo);

        foreach($datawo as $ds) {
            /* 2a Jika ada SparepartList nya */
            if($ds->wo_sp_code <> '' || $ds->wo_sp_code <> NULL) {
                $datasplist = DB::table('spg_list')
                ->whereSpgCode($ds->wo_sp_code)
                ->get();
            
                foreach($datasplist as $da){
                    DB::table('temp_wo')->insert([
                        'temp_wo' => $ds->wo_number,
                        'temp_type' => $ds->wo_type,
                        'temp_sr' => $ds->wo_sr_number,
                        'temp_asset' => $ds->wo_asset_code,
                        'temp_asset_desc' => DB::table('asset_mstr')->where('asset_code','=',$ds->wo_asset_code)->value('asset_desc'),
                        'temp_asset_site' => $ds->wo_site,
                        'temp_asset_loc' => $ds->wo_location,
                        'temp_creator' => $ds->wo_createdby,
                        'temp_create_date' => $ds->wo_start_date,
                        'temp_sch_date' => $ds->wo_start_date,
                        'temp_fail_type' => $ds->wo_failure_type,
                        'temp_fail_code' => $ds->wo_failure_code.";".$ds->wo_failure_code.";".$ds->wo_failure_code,
                        'temp_note' => $ds->wo_note,
                        'temp_repair' => "",
                        'temp_status' => $ds->wo_status,
                        'temp_sp' => $da->spg_spcode,
                        'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->spg_spcode)->value('spm_desc'),
                        'temp_qty_req' => $da->spg_qtyreq,
                        'temp_qty_whs' => 0,
                        'temp_eng1' => $ds->wo_list_engineer,
                        'temp_dept' => $ds->wo_department,
                    ]);
                }

            } else { /* 2a Jika tidak ada SparepartList nya */
                DB::table('temp_wo')->insert([
                    'temp_wo' => $ds->wo_number,
                    'temp_type' => $ds->wo_type,
                    'temp_sr' => $ds->wo_sr_number,
                    'temp_asset' => $ds->wo_asset_code,
                    'temp_asset_desc' => DB::table('asset_mstr')->where('asset_code','=',$ds->wo_asset_code)->value('asset_desc'),
                    'temp_asset_site' => $ds->wo_site,
                    'temp_asset_loc' => $ds->wo_location,
                    'temp_creator' => $ds->wo_createdby,
                    'temp_create_date' => $ds->wo_start_date,
                    'temp_sch_date' => $ds->wo_start_date,
                    'temp_fail_type' => $ds->wo_failure_type,
                    'temp_fail_code' => $ds->wo_failure_code.";".$ds->wo_failure_code.";".$ds->wo_failure_code,
                    'temp_note' => $ds->wo_note,
                    'temp_repair' => "",
                    'temp_status' => $ds->wo_status,
                    'temp_sp' => "",
                    'temp_sp_desc' => "",
                    'temp_qty_req' => 0,
                    'temp_qty_whs' => 0,
                    'temp_eng1' => $ds->wo_list_engineer,
                    'temp_dept' => $ds->wo_department,
                ]);
            }
        }
// dd($request->all());
        $datatemp = DB::table('temp_wo')
        // ->where('temp_wo','=','PM-23-004839')
        ->leftJoin('womaint_upload', 'temp_wo','womaint_wonbr')
        ->orderBy('temp_create_date','desc')
        ->orderBy('temp_wo','desc');
        // dd($datatemp->get());

        if($request->s_nomorwo) {
            $datatemp = $datatemp->where('temp_wo','like','%'.$request->s_nomorwo.'%');
            // dd($datatemp);
        }
        if($request->s_asset) {
            $datatemp = $datatemp->where('temp_asset','=',$request->s_asset);
        }
        if($request->s_per1) {
            $datatemp = $datatemp->whereBetween ('temp_create_date',[$request->s_per1,$request->s_per2]);
        }
        if($request->s_dept) {
            $datatemp = $datatemp->where('temp_dept','=',$request->s_dept);
            // // dd("dept",$request->s_dept);
            // $a = $request->s_dept;
            // $datatemp = $datatemp->whereIn('temp_creator', function($query) use ($a)
            // {
            //     $query->select('username')
            //           ->from('users')
            //           ->where('dept_user','=',$a);
            // });
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
            return Excel::download(new ViewExport2($request->swo,$request->sasset,$request->per1,$request->per2,
            $request->sdept,$request->sloc,$request->seng,$request->stype,$request->s_per1,$request->s_per2), 'DataWO.xlsx');
        } elseif ($request->dexcel == "detail") {
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
