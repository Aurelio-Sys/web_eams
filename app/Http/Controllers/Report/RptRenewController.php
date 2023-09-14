<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RptRenewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
         // dd($req->all());
         $tgl = '';
         if (is_null($req->bulan)) {
             $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
         } elseif ($req->stat == 'mundur') {
             $tgl = Carbon::createFromDate($req->bulan)->addYear(-1)->toDateTimeString();
         } elseif ($req->stat == 'maju') {
             $tgl = Carbon::createFromDate($req->bulan)->addYear(1)->toDateTimeString();
         } elseif (isset($req->s_type) || isset($req->s_asset) || isset($req->s_loc) || isset($req->s_eng)) {
             $tgl = Carbon::createFromDate($req->bulan)->toDateTimeString();
         } else {
             toast('Back to Home!!', 'error');
             return back();
         }
 
         $bulan = Carbon::createFromDate($tgl)->isoFormat('YYYY');
 
         /** dibedakan sama data asset karena kalo sama nanti muncul di search nya cuman 10  asset karena paging */
         $datasearchasset = DB::table('asset_mstr')
             ->orderBy('asset_code')
             ->where('asset_active','=','Yes')
             ->get();
 
         $dataasset = DB::table('asset_mstr')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
             ->selectRaw('asset_code,asset_desc,DATE_FORMAT(asset_renew, "%Y") AS tahun,DATE_FORMAT(asset_renew, "%c") AS bulan,asset_loc,asloc_desc')
             ->orderBy('asset_code')
             ->whereNotNull('asset_renew')
             ->where(DB::raw('DATE_FORMAT(asset_renew, "%Y")'), '=', $bulan)
             ->where('asset_active','=','Yes')
             ->orderBy('asset_code');

         if ($req->s_asset) {
             $dataasset->where('asset_code', '=', $req->s_asset);
         }
         if ($req->s_loc) {
             $dataasset->where('asset_loc', '=', $req->s_loc);
         }

         $dataasset = $dataasset->paginate(10);

         $dataloc = DB::table('asset_loc')
             ->orderBy('asloc_code')
             ->get();
 
         $sasset = $req->s_code;
 
        return view('report.renewrpt', ['bulan' => $bulan, 'dataasset' => $dataasset, 'sasset' => $sasset, 'sasset' => $req->s_asset,
            'sloc' => $req->s_loc, 'datasearchasset' => $datasearchasset, 'dataloc' => $dataloc]);
         
    }

    /** Fungsi ke excel */
    public function excelrenewrpt()
    {
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
        $sheet->setCellValue('F1', 'Year');
        $sheet->setCellValue('G1', 'January');
        $sheet->setCellValue('H1', 'February');
        $sheet->setCellValue('I1', 'March');
        $sheet->setCellValue('J1', 'April');
        $sheet->setCellValue('K1', 'May');
        $sheet->setCellValue('L1', 'June');
        $sheet->setCellValue('M1', 'July');
        $sheet->setCellValue('N1', 'August');
        $sheet->setCellValue('O1', 'September');
        $sheet->setCellValue('P1', 'October');
        $sheet->setCellValue('Q1', 'November');
        $sheet->setCellValue('R1', 'December');
        

        // Mengisi data
        $row = 2; // Mulai dari baris kedua (setelah header)

        $dataexcel = DB::table('asset_mstr')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
             ->selectRaw('DATE_FORMAT(asset_renew, "%Y") AS tahun,asset_code,asset_desc,DATE_FORMAT(asset_renew, "%c") AS bulan,asset_site,asset_loc,asloc_desc')
             ->orderBy('asset_code')
             ->whereNotNull('asset_renew')
             ->where('asset_active','=','Yes')
             ->orderBy('asset_renew')
             ->orderBy('asset_code')
             ->get();
     
        foreach ($dataexcel as $item) {
            $sheet->setCellValue('A' . $row, $item->asset_code);
            $sheet->setCellValue('B' . $row, $item->asset_desc);
            $sheet->setCellValue('C' . $row, $item->asset_site);
            $sheet->setCellValue('D' . $row, $item->asset_loc);
            $sheet->setCellValue('E' . $row, $item->asloc_desc);
            $sheet->setCellValue('F' . $row, $item->tahun);
            $sheet->setCellValue('G' . $row, $item->bulan == '1' ? 'Renew' : '' );
            $sheet->setCellValue('H' . $row, $item->bulan == '2' ? 'Renew' : '' );
            $sheet->setCellValue('I' . $row, $item->bulan == '3' ? 'Renew' : '' );
            $sheet->setCellValue('J' . $row, $item->bulan == '4' ? 'Renew' : '' );
            $sheet->setCellValue('K' . $row, $item->bulan == '5' ? 'Renew' : '' );
            $sheet->setCellValue('L' . $row, $item->bulan == '6' ? 'Renew' : '' );
            $sheet->setCellValue('M' . $row, $item->bulan == '7' ? 'Renew' : '' );
            $sheet->setCellValue('N' . $row, $item->bulan == '8' ? 'Renew' : '' );
            $sheet->setCellValue('O' . $row, $item->bulan == '9' ? 'Renew' : '' );
            $sheet->setCellValue('P' . $row, $item->bulan == '10' ? 'Renew' : '' );
            $sheet->setCellValue('Q' . $row, $item->bulan == '11' ? 'Renew' : '' );
            $sheet->setCellValue('R' . $row, $item->bulan == '12' ? 'Renew' : '' );

            $row++;
        }

        // Menyimpan file
        $writer = new Xlsx($spreadsheet);
        $filename = 'AssetRenew.xlsx';
        $writer->save($filename);

        // Mengirim file sebagai respons unduhan
        return response()->download($filename)->deleteFileAfterSend();
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
