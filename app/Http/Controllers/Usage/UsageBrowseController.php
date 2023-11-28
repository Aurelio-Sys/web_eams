<?php

namespace App\Http\Controllers\Usage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class UsageBrowseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $sasset = $req->s_asset;

        $dataus = DB::table('us_hist')
            ->selectRaw('asset_code,asset_desc,us_asset_site,asloc_desc,us_mea_um,us_date,us_time,
                us_last_mea,us_hist.edited_by,us_hist.created_at,us_no_pm,pma_meter,pma_meterum')
                // us_last_mea,us_hist.edited_by,us_hist.created_at,us_no_pm,asset_meter')
            ->Join('asset_mstr','asset_code','=','us_asset')
            ->Join('asset_site','assite_code','=','us_asset_site')
            ->Join('asset_loc','asloc_code','=','us_asset_loc')
            ->join('pma_asset','pma_asset','=','asset_code')
            ->where('pma_meterum', '=', DB::raw('us_mea_um'))
            ->wherePmaMea('M')
            ->orderBy('us_date','desc')
            ->orderBy('us_last_mea','desc')
            ->orderBy('us_asset')
            ->orderBy('us_mea_um');

        if($sasset) {
            $dataus = $dataus->where('us_asset','=',$sasset);
        }

        $dataexcel = $dataus->get();

        $dataus = $dataus->paginate(10);

        $dataasset = DB::table('asset_mstr')
            ->leftJoin('asset_site','assite_code','=','asset_site')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            // ->where('asset_measure','=','M')
            ->orderBy('asset_code')
            ->get();

        if ($req->dexcel == "excel") {

            // Membuat objek spreadsheet
            $spreadsheet = new Spreadsheet();

            // Memilih lembar kerja aktif
            $sheet = $spreadsheet->getActiveSheet();

            // Isi header kolom
            $sheet->setCellValue('A1', 'Asset');
            $sheet->setCellValue('B1', 'Description');
            $sheet->setCellValue('C1', 'Location');
            $sheet->setCellValue('D1', 'Location Desc');
            $sheet->setCellValue('E1', 'Measure');
            $sheet->setCellValue('F1', 'UM');
            $sheet->setCellValue('G1', 'Date');
            $sheet->setCellValue('H1', 'Time');
            $sheet->setCellValue('I1', 'Result');
            $sheet->setCellValue('J1', 'Created By');
            $sheet->setCellValue('K1', 'Created At');
            $sheet->setCellValue('L1', 'Nomor PM');          

            // Mengisi data
            $row = 2; // Mulai dari baris kedua (setelah header)
            
            foreach ($dataexcel as $item) {
                $sheet->setCellValue('A' . $row, $item->asset_code);
                $sheet->setCellValue('B' . $row, $item->asset_desc);
                $sheet->setCellValue('C' . $row, $item->us_asset_site);
                $sheet->setCellValue('D' . $row, $item->asloc_desc);
                $sheet->setCellValue('E' . $row, $item->pma_meter);
                $sheet->setCellValue('F' . $row, $item->pma_meterum);
                $sheet->setCellValue('G' . $row, $item->us_date);
                $sheet->setCellValue('H' . $row, $item->us_time);
                $sheet->setCellValue('I' . $row, $item->us_last_mea);
                $sheet->setCellValue('J' . $row, $item->edited_by);
                $sheet->setCellValue('K' . $row, $item->created_at);
                $sheet->setCellValue('L' . $row, $item->us_no_pm);

                $row++;
            }

            // Menyimpan file
            $writer = new Xlsx($spreadsheet);
            $filename = 'EAMS Data Usage Asset.xlsx';
            $writer->save($filename);

            // Mengirim file sebagai respons unduhan
            return response()->download($filename)->deleteFileAfterSend();

        } else {
            return view('schedule.usbrowse', compact('dataus','dataasset','sasset'));
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
