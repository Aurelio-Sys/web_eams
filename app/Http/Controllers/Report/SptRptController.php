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
use Illuminate\Support\Facades\Session;
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

        $datasploc = DB::table('loc_mstr')
            ->orderBy('loc_code')
            ->get();

        $requestby = DB::table('eng_mstr')
            ->orderBy('eng_code')
            ->get();

        $datasp = DB::table('sp_mstr')
            ->orderBy('spm_code')
            ->get();

        $datadept = DB::table('dept_mstr')
            ->orderBy('dept_code')
            ->get();

        Schema::create('temp_trans', function ($table) {
            $table->increments('id');
            $table->string('temp_spcode')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('temp_spdesc')->nullable();
            $table->string('temp_fromloc')->nullable();
            $table->string('temp_fromlocdesc')->nullable();
            $table->string('temp_fromlot')->nullable();
            $table->string('temp_toloc')->nullable();
            $table->string('temp_tolocdesc')->nullable();
            $table->string('temp_date')->nullable();
            $table->string('temp_type')->nullable();
            $table->string('temp_no')->nullable();
            $table->string('temp_by')->nullable();
            $table->string('temp_byname')->nullable();
            $table->string('temp_dept')->nullable();
            $table->string('temp_deptdesc')->nullable();
            $table->decimal('temp_qty',10,2)->nullable();
            $table->temporary();
        });

        /** Mencari data dari histori Request Sparepart */
        $datarequest = DB::table('req_sparepart_hist')
            ->leftJoin('sp_mstr','spm_code','=','req_sph_spcode')
            ->leftJoin('users','username','=','req_sph_reqby')
            ->leftJoin('dept_mstr','dept_code','=','dept_user')
            ->whereNotIn('req_sph_action',['request sparepart created','canceled by user','sparepart updated','canceled by approver'])
            ->selectRaw('req_sph_spcode,spm_desc,req_sph_locfrom,req_sph_lotfrom,req_sph_locto,req_sparepart_hist.created_at as tgl,
                req_sph_action,req_sph_number,req_sph_qtytrf,req_sph_reqby,name,dept_user,dept_desc')
            ->orderBy('req_sparepart_hist.created_at')
            ->orderBy('req_sph_spcode')
            ->get();

        foreach($datarequest as $rs) {

            DB::table('temp_trans')->insert([
                'temp_spcode' => $rs->req_sph_spcode,
                'temp_spdesc' => $rs->spm_desc,
                'temp_fromloc' => $rs->req_sph_locfrom,
                'temp_fromlocdesc' => $datasploc->where('loc_code', $rs->req_sph_locfrom)->pluck('loc_desc')->first() ,
                'temp_fromlot' => $rs->req_sph_lotfrom,
                'temp_toloc' => $rs->req_sph_locto,
                'temp_tolocdesc' => $datasploc->where('loc_code', $rs->req_sph_locto)->pluck('loc_desc')->first() ,
                'temp_date' => $rs->tgl,
                'temp_type' => $rs->req_sph_action,
                'temp_no' => $rs->req_sph_number,
                'temp_by' => $rs->req_sph_reqby,
                'temp_byname' => $rs->name,
                'temp_dept' => $rs->dept_user,
                'temp_deptdesc' => $rs->dept_desc,
                'temp_qty' => $rs->req_sph_qtytrf,
            ]);
        }

        /** Mencari data dari history Return Sparepart */
        $datareturn = DB::table('ret_sparepart_hist')
            ->leftJoin('sp_mstr','spm_code','=','ret_sph_spcode')
            ->leftJoin('users','username','=','ret_sph_retby')
            ->leftJoin('dept_mstr','dept_code','=','dept_user')
            ->whereNotIn('ret_sph_action',['return sparepart created','canceled by user','sparepart updated','sparepart deleted','all sparepart deleted'])
            ->selectRaw('ret_sph_spcode,spm_desc,ret_sph_locfrom,ret_sph_lotto,ret_sph_locto,ret_sparepart_hist.created_at as tgl,
                ret_sph_action,ret_sph_number,ret_sph_qtytrf,ret_sph_retby,name,dept_user,dept_desc')
            ->orderBy('ret_sparepart_hist.created_at')
            ->orderBy('ret_sph_spcode')
            ->get();

        foreach($datareturn as $rt) {

            DB::table('temp_trans')->insert([
                'temp_spcode' => $rt->ret_sph_spcode,
                'temp_spdesc' => $rt->spm_desc,
                'temp_fromloc' => $rt->ret_sph_locfrom,
                'temp_fromlocdesc' => $datasploc->where('loc_code', $rt->ret_sph_locfrom)->pluck('loc_desc')->first() ,
                'temp_fromlot' => $rt->ret_sph_lotto,
                'temp_toloc' => $rt->ret_sph_locto,
                'temp_tolocdesc' => $datasploc->where('loc_code', $rt->ret_sph_locto)->pluck('loc_desc')->first() ,
                'temp_date' => $rt->tgl,
                'temp_type' => $rt->ret_sph_action,
                'temp_no' => $rt->ret_sph_number,
                'temp_by' => $rt->ret_sph_retby,
                'temp_byname' => $rt->name,
                'temp_dept' => $rt->dept_user,
                'temp_deptdesc' => $rt->dept_desc,
                'temp_qty' => $rt->ret_sph_qtytrf,
            ]);
        }
		
		/** Mencari data dari history WO Reporting */
        $datawo = DB::table('wo_reporting_trans_hist')
            ->leftJoin('sp_mstr','spm_code','=','spcode_wohist_report')
            ->leftJoin('eng_mstr','eng_code','=','userid_wohist_report')
            ->leftJoin('dept_mstr','dept_code','=','eng_dept')
            // ->where('ret_sph_action','<>','return sparepart created')
            ->selectRaw('spcode_wohist_report,spm_desc,location_wohist_report,lotser_wohist_report,wohist_report_created_at as tgl,
                "wo reporting" as tipe,wonumber_wohist_report,qtychange_wohist_report,userid_wohist_report,eng_desc,
                eng_dept,dept_desc')
            ->orderBy('tgl')
            ->orderBy('spcode_wohist_report')
            ->get();

        foreach($datawo as $rt) {
            DB::table('temp_trans')->insert([
                'temp_spcode' => $rt->spcode_wohist_report,
                'temp_spdesc' => $rt->spm_desc,
                'temp_fromloc' => $rt->location_wohist_report,
                'temp_fromlocdesc' => $datasploc->where('loc_code', $rt->location_wohist_report)->pluck('loc_desc')->first() ,
                'temp_fromlot' => $rt->lotser_wohist_report,
                'temp_toloc' => '',
                'temp_tolocdesc' => '',
                'temp_date' => $rt->tgl,
                'temp_type' => $rt->tipe,
                'temp_no' => $rt->wonumber_wohist_report,
                'temp_by' => $rt->userid_wohist_report,
                'temp_byname' => $rt->eng_desc,
                'temp_dept' => $rt->eng_dept,
                'temp_deptdesc' => $rt->dept_desc,
                'temp_qty' => $rt->qtychange_wohist_report,
            ]);
        }

        $data = DB::table('temp_trans')
            ->orderBy('temp_spcode')
            ->orderBy('temp_date')
            ->orderBy('temp_type');

        if($request->s_sp) {
            $data->where('temp_spcode','=',$request->s_sp);
        }   
        if ($request->s_nomorrs) {
            $data->where('temp_no','=',$request->s_nomorrs);
        }
        if ($request->s_reqby) {
            $data->where('temp_by', '=', $request->s_reqby);
        }
        if ($request->s_dept) {
            $data->where('temp_dept', '=', $request->s_dept);
        }
        if ($request->s_type) {
            $data->where('temp_type','=',$request->s_type);
        }

        $datefrom = $request->get('s_datefrom') == '' ? '2000-01-01' : date($request->get('s_datefrom'));
        $dateto = $request->get('s_dateto') == '' ? '3000-01-01' : date($request->get('s_dateto'));

        if ($datefrom != '' || $dateto != '') {
            $data->whereRaw('DATE_FORMAT(temp_date, "%Y-%m-%d") >= ?', [$datefrom]);
            $data->whereRaw('DATE_FORMAT(temp_date, "%Y-%m-%d") <= ?', [$dateto]);
        }

        $dataexcel = $data->get();

        $data = $data->paginate(10);

        /** Untuk menampilkan pilihan filter Type */
        $datatype = DB::table('temp_trans')
            ->select('temp_type')
            ->groupBy('temp_type')
            ->orderBy('temp_type')
            ->get();

        if ($request->dexcel == "excel") {

            // $dataexcel = DB::table('temp_trans')
            // ->orderBy('temp_spcode')
            // ->orderBy('temp_date')
            // ->orderBy('temp_type')
            // ->get();

            // Membuat objek spreadsheet
            $spreadsheet = new Spreadsheet();

            // Memilih lembar kerja aktif
            $sheet = $spreadsheet->getActiveSheet();

            // Isi header kolom
            $sheet->setCellValue('A1', 'Trans No.');
            $sheet->setCellValue('B1', 'Trans By');
            $sheet->setCellValue('C1', 'Name');
            $sheet->setCellValue('D1', 'Department');
            $sheet->setCellValue('E1', 'Dept Name');
            $sheet->setCellValue('F1', 'Sparepart');
            $sheet->setCellValue('G1', 'Desc');
            $sheet->setCellValue('H1', 'Qty');
            $sheet->setCellValue('I1', 'Location From');
            $sheet->setCellValue('J1', 'Location Desc From');
            $sheet->setCellValue('K1', 'Lot From');
            $sheet->setCellValue('L1', 'Location To');
            $sheet->setCellValue('M1', 'Location Desc To');
            $sheet->setCellValue('N1', 'Date');            
            $sheet->setCellValue('O1', 'Type');            

            // Mengisi data
            $row = 2; // Mulai dari baris kedua (setelah header)
            
            foreach ($dataexcel as $item) {
                $sheet->setCellValue('A' . $row, $item->temp_no);
                $sheet->setCellValue('B' . $row, $item->temp_by);
                $sheet->setCellValue('C' . $row, $item->temp_byname);
                $sheet->setCellValue('D' . $row, $item->temp_dept);
                $sheet->setCellValue('E' . $row, $item->temp_deptdesc);
                $sheet->setCellValue('F' . $row, $item->temp_spcode);
                $sheet->setCellValue('G' . $row, $item->temp_spdesc);
                $sheet->setCellValue('H' . $row, $item->temp_qty);
                $sheet->setCellValue('I' . $row, $item->temp_fromloc);
                $sheet->setCellValue('J' . $row, $item->temp_fromlocdesc);
                $sheet->setCellValue('K' . $row, $item->temp_fromlot);
                $sheet->setCellValue('L' . $row, $item->temp_toloc);
                $sheet->setCellValue('M' . $row, $item->temp_tolocdesc);
                $sheet->setCellValue('N' . $row, $item->temp_date);
                $sheet->setCellValue('O' . $row, $item->temp_type);

                $row++;
            }

            // Menyimpan file
            $writer = new Xlsx($spreadsheet);
            $filename = 'Data Sparepart eAMS.xlsx';
            $writer->save($filename);

            // Mengirim file sebagai respons unduhan
            return response()->download($filename)->deleteFileAfterSend();

        } else {
            return view('report.sptrpt', ['data' => $data, 'requestby' => $requestby, 'datasp' => $datasp, 'datadept' => $datadept,
            'datatype' => $datatype,
            'ssp' => $request->s_sp, 'sreqby' => $request->s_reqby, 'sdept' => $request->s_dept, 'stype' => $request->s_type,
            'sdatefrom' => $request->s_datefrom, 'sdateto' => $request->s_dateto, 'snomorrs' => $request->s_nomorrs]);
        }
        Schema::dropIfExists('temp_trans');
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
