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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DownrptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    //    dd($request->all());

        $asset = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->orderBy('asset_code')
            ->get();

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
            ->leftjoin('asset_mstr','asset_code','=','sr_asset')
            ->whereSr_fail_type('BRE')
            ->where('sr_status','<>','Canceled')
            ->groupBy('sr_asset');

        /** Mencari data dari WO yang tidak ada SR nya */
        $datamtbfwo = DB::table('wo_mstr')
            ->selectRaw('wo_asset_code as asset,count(wo_number) as jmltr')
            ->leftJoin('asset_mstr','asset_code','=','wo_asset_code')
            ->whereWo_failure_type('BRE')
            ->whereWo_type('CM')
            ->where('wo_status','<>','canceled')
            ->where(function ($query) {
                $query->whereNull('wo_sr_number')
                    ->orWhere('wo_sr_number', '');
            })
            ->groupBy('wo_asset_code');

        /** Perhitungan MTTF */
        $datamttfsr = DB::table('service_req_mstr')
            ->selectRaw('sr_asset as asset,sr_req_date as tglawal,wo_job_finishdate as tglakhir')
            ->Join('wo_mstr','wo_mstr.wo_number','=','service_req_mstr.wo_number')
            ->leftjoin('asset_mstr','asset_code','=','sr_asset')
            ->whereSr_fail_type('BRE')
            ->where('sr_status','<>','Canceled')
            ->wherein('wo_status',['finished','Closed','Acceptance']);

        $datamttfwo = DB::table('wo_mstr')
            ->selectRaw('wo_asset_code as asset,wo_start_date as tglawal,wo_job_finishdate as tglakhir')
            ->leftJoin('asset_mstr','asset_code','=','wo_asset_code')
            ->whereWo_failure_type('BRE')
            ->whereWo_type('CM')
            ->where('wo_status','<>','canceled')
            ->where(function ($query) {
                $query->whereNull('wo_sr_number')
                    ->orWhere('wo_sr_number', '');
            })
            ->wherein('wo_status',['finished','Closed','acceptance']);

        /** Perhitungan MDT -> seperti MTTF namun ditambahkan jam nya yang diambil adalah yang setelah approval WO */
        $datamdtsr = DB::table('service_req_mstr')
            ->selectRaw('wo_mstr.id as woid, sr_asset as asset,sr_req_date as tglawal,sr_req_time as jamawal,wo_job_finishdate as tglakhir,wo_job_finishtime as jamakhir')
            ->Join('wo_mstr','wo_mstr.wo_number','=','service_req_mstr.wo_number')
            ->leftjoin('asset_mstr','asset_code','=','sr_asset')
            ->whereSr_fail_type('BRE')
            ->wherein('wo_status',['acceptance','Closed']);
            
        $datamdtwo = DB::table('wo_mstr')   /** Untuk WO jam awalnya ambil dari jam input, karena tidak ada inputan untuk jam dan tanggalnya */
            ->selectRaw('wo_mstr.id as woid,wo_asset_code as asset,wo_start_date as tglawal,TIME(wo_system_create) as jamawal,wo_job_finishdate as tglakhir,wo_job_finishtime as jamakhir')
            ->leftJoin('asset_mstr','asset_code','=','wo_asset_code')
            ->whereWo_failure_type('BRE')
            ->whereWo_type('CM')
            ->where(function ($query) {
                $query->whereNull('wo_sr_number')
                    ->orWhere('wo_sr_number', '');
            })
            ->wherein('wo_status',['acceptance','Closed']);

        /** Perhitungan MTTR -> seperti MDT namun statusnya dari rreporting WO sampai dengan user acceptance */
        $datamttrsr = DB::table('service_req_mstr')
            ->selectRaw('sr_asset as asset,sr_req_date as tglawal,sr_req_time as jamawal,wo_job_finishdate as tglakhir,wo_job_finishtime as jamakhir')
            ->leftjoin('asset_mstr','asset_code','=','sr_asset')
            ->Join('wo_mstr','wo_mstr.wo_number','=','service_req_mstr.wo_number')
            ->whereSr_fail_type('BRE')
            ->wherein('wo_status',['finished','acceptance','Closed']);
            
        $datamttrwo = DB::table('wo_mstr')   /** Untuk WO jam awalnya ambil dari jam input, karena tidak ada inputan untuk jam dan tanggalnya */
            ->selectRaw('wo_asset_code as asset,wo_start_date as tglawal,TIME(wo_system_create) as jamawal,wo_job_finishdate as tglakhir,wo_job_finishtime as jamakhir')
            ->leftJoin('asset_mstr','asset_code','=','wo_asset_code')
            ->whereWo_failure_type('BRE')
            ->whereWo_type('CM')
            ->where(function ($query) {
                $query->whereNull('wo_sr_number')
                    ->orWhere('wo_sr_number', '');
            })
            ->wherein('wo_status',['finished','Closed']);

        /** Kondisi filter Search */
        if($request->s_asset) {
            $datamtbfsr = $datamtbfsr->where('sr_asset','=',$request->s_asset);
            $datamtbfwo = $datamtbfwo->where('wo_asset_code','=',$request->s_asset);

            $datamttfsr = $datamttfsr->where('sr_asset','=',$request->s_asset);
            $datamttfwo = $datamttfwo->where('wo_asset_code','=',$request->s_asset);

            $datamdtsr = $datamdtsr->where('sr_asset','=',$request->s_asset);
            $datamdtwo = $datamdtwo->where('wo_asset_code','=',$request->s_asset);

            $datamttrsr = $datamttrsr->where('sr_asset','=',$request->s_asset);
            $datamttrwo = $datamttrwo->where('wo_asset_code','=',$request->s_asset);
        }
        if($request->s_per1) {
            $datamtbfsr = $datamtbfsr->whereBetween('sr_req_date',[$request->s_per1,$request->s_per2]);
            $datamtbfwo = $datamtbfwo->whereBetween('wo_start_date',[$request->s_per1,$request->s_per2]);

            $datamttfsr = $datamttfsr->whereBetween('sr_req_date',[$request->s_per1,$request->s_per2]);
            $datamttfwo = $datamttfwo->whereBetween('wo_start_date',[$request->s_per1,$request->s_per2]);

            $datamdtsr = $datamdtsr->whereBetween('sr_req_date',[$request->s_per1,$request->s_per2]);
            $datamdtwo = $datamdtwo->whereBetween('wo_start_date',[$request->s_per1,$request->s_per2]);

            $datamttrsr = $datamttrsr->whereBetween('sr_req_date',[$request->s_per1,$request->s_per2]);
            $datamttrwo = $datamttrwo->whereBetween('wo_start_date',[$request->s_per1,$request->s_per2]);
        }
        if($request->s_loc) {
            /** Saat ini serch lokasi berdasarkan master asset nya, bukan berdasarkan lokasi saat transaksi */
            $a = $request->s_loc;
            // $datatemp = $datatemp->whereIn('temp_asset_loc', function($query) use ($a)
            // {
            //     $query->select('asset_code')
            //           ->from('asset_mstr')
            //           ->where('asset_loc','=',$a);
            // });

            $datamtbfsr = $datamtbfsr->where('asset_loc','=',$a);
            $datamtbfwo = $datamtbfwo->where('asset_loc','=',$a);

            $datamttfsr = $datamttfsr->where('asset_loc','=',$a);
            $datamttfwo = $datamttfwo->where('asset_loc','=',$a);

            $datamdtsr = $datamdtsr->where('asset_loc','=',$a);
            $datamdtwo = $datamdtwo->where('asset_loc','=',$a);

            $datamttrsr = $datamttrsr->where('asset_loc','=',$a);
            $datamttrwo = $datamttrwo->where('asset_loc','=',$a);
        }
        if($request->s_site) {
            $datamtbfsr = $datamtbfsr->where('asset_site','=',$request->s_site);
            $datamtbfwo = $datamtbfwo->where('asset_site','=',$request->s_site);

            $datamttfsr = $datamttfsr->where('asset_site','=',$request->s_site);
            $datamttfwo = $datamttfwo->where('asset_site','=',$request->s_site);

            $datamdtsr = $datamdtsr->where('asset_site','=',$request->s_site);
            $datamdtwo = $datamdtwo->where('asset_site','=',$request->s_site);

            $datamttrsr = $datamttrsr->where('asset_site','=',$request->s_site);
            $datamttrwo = $datamttrwo->where('asset_site','=',$request->s_site);
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
        /** Penggabungan data anatar SR dan WO dan tanggal nya tidak boleh ada yang sama */
        $datamttf = DB::table(DB::raw("({$datamttfsr->toSql()} UNION {$datamttfwo->toSql()}) as merged"))
            ->mergeBindings($datamttfsr)
            ->mergeBindings($datamttfwo)
            ->groupBy('asset', 'tglawal', 'tglakhir')
            ->select('asset', DB::raw('MIN(tglawal) as tglawal'), DB::raw('MAX(tglakhir) as tglakhir'))
            ->orderBy('asset')
            ->orderBy('tglawal')
            ->get();

        $uniqueAssets = $datamttf->pluck('asset')->unique();

        /** Melakukan looping berdasarkan asset */
        foreach($uniqueAssets as $da) {
            /** Mencari tanggal berapa saja untuk asset yang di looping */
            $qasset = $datamttf->where('asset','=',$da);
            
            /** Mencari jumlah kerusakan */
            $casset = $qasset->count();
            
            /** Mencari data master untuk asset */
            $detasset = $dataassetloc->where('asset_code','=',$da)->first();

            $ca = 1;    // membedakan perhitungan untuk kerusakan pertama dan kerusakan selanjutnya
            $freeday = 0;
            foreach($qasset as $qa) {
                $tglawal = new \DateTime($qa->tglawal);
                $tglakhir = new \DateTime($qa->tglakhir);
                if($ca == 1) {  // jike kerusakan pertama dalam rentang periode, maka hitungannya dari awal periode1 sampai dengan tanggal mulai kerusakan
                    $freeday = ($datetime_awal->diff($tglawal))->days;     
                } else {    // jika kerusakan selanjutnya maka hitungnya dari tanggal akhir kerusakan sebelumnya sampai tanggal awal kerusakan
                    $freeday = $freeday + (($tglbanding->diff($tglawal))->days) - 1;
                }
                $ca += 1;
                $tglbanding = $tglakhir;    // variabel sebagai pengurang untuk next loop
            }

            $freeday = $freeday + (($datetime_akhir->diff($tglbanding))->days); // penambahan terakhir dari tanggal selesai kerusakan sampai periode 2
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
        
        /** Perhitungan MDT */
        /** Penggabungan data anatar SR dan WO dan tanggal nya tidak boleh ada yang sama */
        $datamdt = DB::table(DB::raw("({$datamdtsr->toSql()} UNION {$datamdtwo->toSql()}) as merged"))
            ->mergeBindings($datamdtsr)
            ->mergeBindings($datamdtwo)
            ->groupBy('woid','asset', 'tglawal', 'tglakhir','jamawal','jamakhir')
            ->select('woid','asset', DB::raw('MIN(tglawal) as tglawal'), DB::raw('MAX(tglakhir) as tglakhir'), DB::raw('MAX(jamawal) as jamawal'), DB::raw('MAX(jamakhir) as jamakhir'))
            ->orderBy('asset')
            ->orderBy('tglawal')
            ->get();

        $uniqueMdt = $datamdt->pluck('asset')->unique();

        $dataappwo = DB::table('wo_trans_approval')->get();

        /** Melakukan looping berdasarkan asset */
        foreach($uniqueMdt as $da) {
            /** Mencari tanggal berapa saja untuk asset yang di looping */
            $qasset = $datamdt->where('asset','=',$da);
            
            /** Mencari jumlah kerusakan */
            $casset = $qasset->count();
            
            /** Mencari data master untuk asset */
            $detasset = $dataassetloc->where('asset_code','=',$da)->first();

            $jmlmenit = 0;      /** Untuk menjumlahkan waktu kerusakan per asset */
            foreach($datamdt as $dm) {
                /** Mencari tanggal approvaal terakhir */
                $qappwo = $dataappwo->where('wotr_mstr_id', '=', $dm->woid);

                $maxUpdated = $dataappwo->max('updated_at');

                // Gabungkan tanggal dan waktu menjadi DateTime
                $awal = \DateTime::createFromFormat('Y-m-d H:i:s', $dm->tglawal . ' ' . $dm->jamawal);
                $akhir = \DateTime::createFromFormat('Y-m-d H:i:s', $maxUpdated);

                // Hitung selisih antara datetime1 dan datetime2
                $selisih = $awal->diff($akhir);

                // Hitung selisih waktu dalam menit
                $selisih_jam = ($selisih->days * 24) + $selisih->h;

                $jmlmenit = $jmlmenit + $selisih_jam;
            }
            
            $mdt = $jmlmenit / $casset;

            // Cek apakah data sudah ada dalam tabel
            $dataExists = DB::table('temp_wo')
                ->whereTemp_asset($da)
                ->exists();

            if ($dataExists) {
                // Lakukan update jika data sudah ada
                DB::table('temp_wo')
                ->whereTemp_asset($da)
                    ->update([
                        'temp_mdt' => $mdt
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
                        'temp_mdt' => 0,
                        'temp_mdt' => $mdt,
                        'temp_mttr' => 0,
                    ]);
            }
        }

        /** Perhitungan MTTR */
        /** Penggabungan data anatar SR dan WO dan tanggal nya tidak boleh ada yang sama */
        $datamdt = DB::table(DB::raw("({$datamdtsr->toSql()} UNION {$datamdtwo->toSql()}) as merged"))
            ->mergeBindings($datamdtsr)
            ->mergeBindings($datamdtwo)
            ->groupBy('asset', 'tglawal', 'tglakhir','jamawal','jamakhir')
            ->select('asset', DB::raw('MIN(tglawal) as tglawal'), DB::raw('MAX(tglakhir) as tglakhir'), DB::raw('MAX(jamawal) as jamawal'), DB::raw('MAX(jamakhir) as jamakhir'))
            ->orderBy('asset')
            ->orderBy('tglawal')
            ->get();

        $uniqueMdt = $datamdt->pluck('asset')->unique();

        /** Melakukan looping berdasarkan asset */
        foreach($uniqueMdt as $da) {
            /** Mencari tanggal berapa saja untuk asset yang di looping */
            $qasset = $datamdt->where('asset','=',$da);
            
            /** Mencari jumlah kerusakan */
            $casset = $qasset->count();
            
            /** Mencari data master untuk asset */
            $detasset = $dataassetloc->where('asset_code','=',$da)->first();

            $jmlmenit = 0;      /** Untuk menjumlahkan waktu kerusakan per asset */
            foreach($datamdt as $dm) {
                // Gabungkan tanggal dan waktu menjadi DateTime
                $awal = \DateTime::createFromFormat('Y-m-d H:i:s', $dm->tglawal . ' ' . $dm->jamawal);
                $akhir = \DateTime::createFromFormat('Y-m-d H:i:s', $dm->tglakhir . ' ' . $dm->jamakhir);

                // Hitung selisih antara datetime1 dan datetime2
                $selisih = $awal->diff($akhir);

                // Hitung selisih waktu dalam menit
                $selisih_jam = ($selisih->days * 24) + $selisih->h;

                $jmlmenit = $jmlmenit + $selisih_jam;
            }
            
            $mttr = $jmlmenit / $casset;

            // Cek apakah data sudah ada dalam tabel
            $dataExists = DB::table('temp_wo')
                ->whereTemp_asset($da)
                ->exists();

            if ($dataExists) {
                // Lakukan update jika data sudah ada
                DB::table('temp_wo')
                ->whereTemp_asset($da)
                    ->update([
                        'temp_mttr' => $mttr
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
                        'temp_mdt' => 0,
                        'temp_mdt' => 0,
                        'temp_mttr' => $mttr,
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

        $datatemp = $datatemp->paginate(10); 

        if ($request->dexcel == "excel") {

            $dataexcel = DB::table('temp_wo')
            ->orderBy('temp_asset')
            ->get();

            // Membuat objek spreadsheet
            $spreadsheet = new Spreadsheet();

            // Memilih lembar kerja aktif
            $sheet = $spreadsheet->getActiveSheet();

            // Isi header kolom
            $sheet->setCellValue('A1', 'Asset');
            $sheet->setCellValue('B1', 'Desc');
            $sheet->setCellValue('C1', 'Site');
            $sheet->setCellValue('D1', 'Location');
            $sheet->setCellValue('E1', 'Location Desc');
            $sheet->setCellValue('F1', 'MTBF (days)');
            $sheet->setCellValue('G1', 'MTTF (days)');
            $sheet->setCellValue('H1', 'MDT (hour)');
            $sheet->setCellValue('I1', 'MTTR (hour)');
            

            // Mengisi data
            $row = 2; // Mulai dari baris kedua (setelah header)
            
            foreach ($dataexcel as $item) {
                $sheet->setCellValue('A' . $row, $item->temp_asset);
                $sheet->setCellValue('B' . $row, $item->temp_asset_desc);
                $sheet->setCellValue('C' . $row, $item->temp_asset_site);
                $sheet->setCellValue('D' . $row, $item->temp_asset_loc);
                $sheet->setCellValue('E' . $row, $item->temp_asset_locdesc);
                $sheet->setCellValue('F' . $row, $item->temp_mtbf);
                $sheet->setCellValue('G' . $row, $item->temp_mttf);
                $sheet->setCellValue('H' . $row, $item->temp_mdt);
                $sheet->setCellValue('I' . $row, $item->temp_mttr);

                $row++;
            }

            // Menyimpan file
            $writer = new Xlsx($spreadsheet);
            $filename = 'data.xlsx';
            $writer->save($filename);

            // Mengirim file sebagai respons unduhan
            return response()->download($filename)->deleteFileAfterSend();

            // return Excel::download(new ViewExport2($request->swo,$request->sasset,$request->per1,$request->per2,
            // $request->sdept,$request->sloc,$request->seng,$request->stype), 'Downtime.xlsx');
        } else {
            return view('report.downrpt', ['data' => $datatemp, 'asset1' => $asset, 
            'dataloc' => $dataloc, 'datasite' => $datasite,
            'sasset' => $request->s_asset, 'sper1' => $request->s_per1, 'sper2' => $request->s_per2,
            'sloc' => $request->s_loc, 'ssite' => $request->s_site, 'stype' => $request->s_type]);
        }
        Schema::dropIfExists('temp_wo');
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
