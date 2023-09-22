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

class SptRptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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

        $datatemp = DB::table('temp_wo')
            ->orderBy('temp_asset');

        /** Data akan muncul setelah di lakukan search */
        if(!$request->s_type && !$request->s_asset && !$request->s_site && !$request->s_loc && !$request->s_per1 && !$request->s_per2) {
            // $datatemp = $datatemp->where('id','<',0);
            $datatemp = $datatemp->where('id','<',0);
        }

        $datatemp = $datatemp->paginate(10); 


        /** Mencari data dari histori perubahan sparepart */
        $datatrans = DB::table('req_sparepart_hist')
            ->leftJoin('sp_mstr','spm_code','=','req_sph_spcode')
            ->where('req_sph_action','<>','request sparepart created')
            ->selectRaw('req_sph_spcode,spm_desc,req_sph_locfrom,req_sph_locfrom,req_sph_lotfrom,req_sph_locto,req_sph_locto,req_sparepart_hist.created_at,
                req_sph_action,req_sph_number,req_sph_qtytrf')
            ->orderBy('req_sparepart_hist.created_at')
            ->orderBy('req_sph_spcode')
            ->paginate(10);

//             <td>{{ $show->req_sph_spcode }}</td>
//   <td>{{ $show->spm_desc }}</td>
//   <td>{{ $show->req_sph_locfrom }}</td>
//   <td>{{ $show->req_sph_locfrom }}</td>
//   <td>{{ $show->req_sph_lotfrom }}</td>
//   <td>{{ $show->req_sph_locto }}</td>
//   <td>{{ $show->req_sph_locto }}</td>
//   <td>{{ $show->created_at }}</td>
//   <td>{{ $show->req_sph_action }}</td>
//   <td>{{ $show->req_sph_number }}</td>
//   <td>{{ $show->req_sph_qtytrf }}</td>

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
            return view('report.sptrpt', ['data' => $datatrans, 'asset1' => $asset, 
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
