<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\DetailWOExport;
use App\Services\CreateTempTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ViewExport2;

class DownrptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $usernow = DB::table('users')
        //     ->leftjoin('eng_mstr', 'users.username', 'eng_mstr.eng_code')
        //     ->where('username', '=', session()->get('username'))
        //     ->first();

        // $data = DB::table('wo_mstr')
        //     ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
        //     ->orderby('wo_system_create', 'desc')
        //     ->orderBy('wo_mstr.id', 'desc')
        //     ->paginate(10);

        // $custrnow = DB::table('wo_mstr')
        //     ->selectRaw('wo_createdby,min(name) as creator_desc')
        //     ->join('users', 'wo_mstr.wo_createdby', 'users.username')
        //     ->groupBy('wo_createdby')
        //     ->get();

        // $depart = DB::table('dept_mstr')
        //     ->orderBy('dept_code')
        //     ->get();

        // $engineer = DB::table('eng_mstr')
        //     ->where('eng_active', '=', 'Yes')
        //     ->orderBy('eng_code')
        //     ->get();

        $asset = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->orderBy('asset_code')
            ->get();

        // $failure = DB::table('fn_mstr')
        //     ->get();

        // $impact = DB::table('imp_mstr')
        //     ->get();

        // $wottype = DB::table('wotyp_mstr')
        //     ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        $datasite = DB::table('asset_site')
            ->orderBy('assite_code')
            ->get();

        $dataassetloc = DB::table('asset_mstr')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->get();

        Schema::create('temp_wo', function ($table) {
            $table->increments('id');
            $table->string('temp_asset')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('temp_asset_desc')->nullable();
            $table->string('temp_asset_loc')->nullable();
            $table->string('temp_asset_locdesc')->nullable();
            $table->string('temp_asset_site')->nullable();
            $table->decimal('temp_mtbf',10,2)->nullable();
            $table->decimal('temp_mttf',10,2)->nullable();
            $table->decimal('temp_mdt',10,2)->nullable();
            $table->decimal('temp_mttr',10,2)->nullable();
            $table->temporary();
        });

        /** Perhitungan MTBF */
        /** Mencari data dari SR */
        $datamtbfsr = DB::table('service_req_mstr')
            ->selectRaw('sr_asset as asset,count(sr_number) as jmltr')
            ->whereSr_fail_type('BRE')
            ->groupBy('sr_asset');

        /** Mencari data dari WO yang tidak ada SR nya */
        $datamtbfwo = DB::table('wo_mstr')
            ->selectRaw('wo_asset_code as asset,count(wo_number) as jmltr')
            ->whereWo_failure_type('BRE')
            ->whereWo_type('CM')
            ->where(function ($query) {
                $query->whereNull('wo_sr_number')
                    ->orWhere('wo_sr_number', '');
            })
            ->groupBy('wo_asset_code');

        /** Perhitungan MTTF */
        $datamttfsr = DB::table('service_req_mstr')
            ->selectRaw('sr_asset as asset,sr_req_date as tglawal,wo_job_finishdate as tglakhir')
            ->Join('wo_mstr','wo_mstr.wo_number','=','service_req_mstr.wo_number')
            ->whereSr_fail_type('BRE')
            ->wherein('wo_status',['finished','Closed']);
// dump($datamttfsr->get());
        $datamttfwo = DB::table('wo_mstr')
            ->selectRaw('wo_asset_code as asset,wo_start_date as tglawal,wo_job_finishdate as tglakhir')
            ->whereWo_failure_type('BRE')
            ->whereWo_type('CM')
            ->wherein('wo_status',['finished','Closed']);
// dump($datamttfwo->get());
        if($request->s_asset) {
            $datatemp = $datatemp->where('temp_asset','=',$request->s_asset);
        }
        if($request->s_per1) {
            $datamtbfsr = $datamtbfsr->whereBetween('sr_req_date',[$request->s_per1,$request->s_per2]);
            $datamtbfwo = $datamtbfwo->whereBetween('wo_start_date',[$request->s_per1,$request->s_per2]);

            $datamttfsr = $datamttfsr->whereBetween('sr_req_date',[$request->s_per1,$request->s_per2]);
            $datamttfwo = $datamttfwo->whereBetween('wo_start_date',[$request->s_per1,$request->s_per2]);
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
        if($request->s_type) {
            $datatemp = $datatemp->where('temp_type','=',$request->s_type);
        } 

        /** Perhitungan MTBF */
        $datamtbfsr = $datamtbfsr->get();
        $datamtbfwo = $datamtbfwo->get();

        /** Menggabungkan dan menjumlahkan transaksi dari data SR dan WO */
        $datasrwo = [];
        foreach ($datamtbfsr as $sr) {
            $dsasset = $sr->asset;
            $jmltr = $sr->jmltr;

            if (!isset($datasrwo[$dsasset])) {
                $datasrwo[$dsasset] = [
                    'asset' => $dsasset,
                    'jmltr' => $jmltr,
                ];
            } else {
                $datasrwo[$dsasset]['jmltr'] += $jmltr;
            }
        }

        foreach ($datamtbfwo as $wo) {
            $dsasset = $wo->asset;
            $jmltr = $wo->jmltr;

            if (!isset($datasrwo[$dsasset])) {
                $datasrwo[$dsasset] = [
                    'asset' => $dsasset,
                    'jmltr' => $jmltr,
                ];
            } else {
                $datasrwo[$dsasset]['jmltr'] += $jmltr;
            }
        }

        // Konversi array asosiatif menjadi indeks numerik jika diperlukan
        $datagabung = array_values($datasrwo);

        
// dd($request->s_per1);

        foreach($datagabung as $ds) {
            $dsasset = $ds['asset'];
            $dsjmltr = $ds['jmltr'];

            $detasset = $dataassetloc->where('asset_code','=',$dsasset)->first();

            // Buat objek DateTime untuk tanggal awal dan akhir
            $datetime_awal = new \DateTime($request->s_per1);
            $datetime_akhir = new \DateTime($request->s_per2);
            
            // Hitung selisih antara dua tanggal
            $selisih = ($datetime_awal->diff($datetime_akhir))->days + 1;
            
            $mtbf = $selisih / $dsjmltr;
            
            DB::table('temp_wo')
                ->insert([
                    'temp_asset' => $dsasset,
                    'temp_asset_desc' => $detasset ? $detasset->asset_desc : "",
                    'temp_asset_site' => $detasset ? $detasset->asset_site : "",
                    'temp_asset_loc' => $detasset ? $detasset->asset_loc : "",
                    'temp_asset_locdesc' => $detasset ? $detasset->asloc_desc : "",
                    'temp_mtbf' => $mtbf,
                    'temp_mttf' => 0,
                    'temp_mdt' => 0,
                    'temp_mttr' => 0,
                ]);
        }

        /** Perhitungan MTTF */
        $datamttf = DB::table(DB::raw("({$datamttfsr->toSql()} UNION {$datamttfwo->toSql()}) as merged"))
            ->mergeBindings($datamttfsr)
            ->mergeBindings($datamttfwo)
            ->groupBy('asset', 'tglawal', 'tglakhir')
            ->select('asset', DB::raw('MIN(tglawal) as tglawal'), DB::raw('MAX(tglakhir) as tglakhir'))
            ->orderBy('asset')
            ->orderBy('tglawal')
            ->get();

        $uniqueAssets = $datamttf->pluck('asset')->unique();

        /** Melakukan loopin berdasarkan asset */
        foreach($uniqueAssets as $da) {
            /** Mencari tanggal berapa saja untuk asset yang di looping */
            $qasset = $datamttf->where('asset','=',$da);
            // $qasset = $datamttf->where('asset','=','MSNTL104');
            $casset = $qasset->count();
            
            $detasset = $dataassetloc->where('asset_code','=',$da)->first();

            $ca = 1;
            $freeday = 0;
            foreach($qasset as $qa) {
                $tglawal = new \DateTime($qa->tglawal);
                $tglakhir = new \DateTime($qa->tglakhir);
                if($ca == 1) {
                    $freeday = ($datetime_awal->diff($tglawal))->days;     
                } else {
                    $freeday = $freeday + (($tglbanding->diff($tglawal))->days) - 1;
                }
                $ca += 1;
                $tglbanding = $tglakhir;    // variabel sebagai pengurang untuk next loop
            }
            $freeday = $freeday + (($datetime_akhir->diff($tglbanding))->days);
            $mttf = $freeday / $casset;

            // Cek apakah data sudah ada dalam tabel
            $dataExists = DB::table('temp_wo')
                ->whereTemp_asset($da)
                ->exists();

            if ($dataExists) {
                // Lakukan update jika data sudah ada
                DB::table('temp_wo')
                ->whereTemp_asset($da)
                    ->update([
                        'temp_mttf' => $mttf
                    ]);
            } else {
                // Lakukan insert jika data belum ada
                DB::table('temp_wo')
                    ->insert([
                        'temp_asset' => $da,
                        'temp_asset_desc' => $detasset->asset_desc,
                        'temp_asset_site' => $detasset->asset_site,
                        'temp_asset_loc' => $detasset->asset_loc,
                        'temp_asset_locdesc' => $detasset->asloc_desc,
                        'temp_mtbf' => 0,
                        'temp_mttf' => $mttf,
                        'temp_mdt' => 0,
                        'temp_mttr' => 0,
                    ]);
            }
        }
        
  
        $datatemp = DB::table('temp_wo')
            ->orderBy('temp_asset');


        /** Data akan muncul setelah di lakukan search */
        if(!$request->s_type && !$request->s_asset && !$request->s_site && !$request->s_loc && !$request->s_per1 && !$request->s_per2) {
            // $datatemp = $datatemp->where('id','<',0);
            $datatemp = $datatemp->where('id','<',0);
        }
        // dd($datatemp->get());

        $datatemp = $datatemp->paginate(10); 

        Schema::dropIfExists('temp_wo');

        if ($request->dexcel == "excel") {
            return Excel::download(new ViewExport2($request->swo,$request->sasset,$request->per1,$request->per2,
            $request->sdept,$request->sloc,$request->seng,$request->stype), 'DataWO.xlsx');
        } elseif ($request->dexcel == "detail") {
            return Excel::download(new DetailWOExport($request->swo,$request->sasset,$request->per1,$request->per2,
            $request->sdept,$request->sloc,$request->seng,$request->stype), 'DetailWO.xlsx');
        } else {
            // dd($request->s_nomorwo);
            return view('report.downrpt', ['data' => $datatemp, 'asset1' => $asset, 
            'dataloc' => $dataloc, 'datasite' => $datasite,
            'sasset' => $request->s_asset, 'sper1' => $request->s_per1, 'sper2' => $request->s_per2,
            'sloc' => $request->s_loc, 'ssite' => $request->s_site, 'stype' => $request->s_type]);
            // return view('report.downrpt', ['impact' => $impact, 'wottype' => $wottype, 'custrnow' => $custrnow, 
            // 'data' => $datatemp, 'user' => $engineer, 'engine' => $engineer, 'asset1' => $asset, 'asset2' => $asset, 
            // 'failure' => $failure, 'usernow' => $usernow, 'dept' => $depart, 'fromhome' => '', 'dataloc' => $dataloc, 'datasite' => $datasite,
            // 'swo' => $request->s_nomorwo, 'sasset' => $request->s_asset, 'sper1' => $request->s_per1, 'sper2' => $request->s_per2,
            // 'sdept' => $request->s_dept, 'sloc' => $request->s_loc, 'seng' => $request->s_eng, 'stype' => $request->s_type]);
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
