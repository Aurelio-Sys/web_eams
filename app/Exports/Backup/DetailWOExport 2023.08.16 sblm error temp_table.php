<?php

namespace App\Exports;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Services\CreateTempTable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class DetailWOExport implements FromQuery, WithHeadings, ShouldAutoSize,WithStyles
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function styles(Worksheet $sheet)
    {
        return [
        // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    function __construct($wonbr,$sasset,$per1,$per2,$dept,$loc,$eng,$type) {
        $this->wonbr    = $wonbr;
        $this->sasset    = $sasset;
        $this->per1   = $per1;
        $this->per2 = $per2;
        $this->dept = $dept;
        $this->loc = $loc;
        $this->eng = $eng;
        $this->type = $type;
    }

    public function query()
    {
        $wonbr    = $this->wonbr;
        $sasset     = $this->sasset;
        $per1    = $this->per1;
        $per2  = $this->per2;
        $dept = $this->dept;
        $loc = $this->loc;
        $eng = $this->eng;
        $type = $this->type;

        Schema::create('temp_wo', function ($table) {
            $table->increments('id');
            $table->string('temp_wo');
            $table->string('temp_creator')->nullable(); /* Untuk PM Creator nya kosong */
            $table->date('temp_create_date');
            $table->string('temp_wo_codedept')->nullable();
            $table->string('temp_wo_dept')->nullable();
            $table->string('temp_type');
            $table->string('temp_wo_priority');
            $table->string('temp_status');
            $table->string('temp_sr')->nullable();
            $table->date('temp_sr_date');
            $table->string('temp_sr_request');
            $table->string('temp_sr_dept');
            $table->string('temp_asset');
            $table->string('temp_asset_desc')->nullable();
            $table->string('temp_asset_loc')->nullable();
            $table->string('temp_asset_site')->nullable();
            $table->string('temp_note')->nullable();
            $table->string('temp_ceng1')->nullable();
            $table->string('temp_neng1')->nullable();
            $table->string('temp_ceng2')->nullable();
            $table->string('temp_neng2')->nullable();
            $table->string('temp_ceng3')->nullable();
            $table->string('temp_neng3')->nullable();
            $table->string('temp_ceng4')->nullable();
            $table->string('temp_neng4')->nullable();
            $table->string('temp_ceng5')->nullable();
            $table->string('temp_neng5')->nullable();
            $table->date('temp_sch_date');
            $table->date('temp_start_date')->nullable();
            $table->time('temp_start_time')->nullable();
            $table->date('temp_finish_date')->nullable();
            $table->time('temp_finish_time')->nullable();
            $table->date('temp_due_date')->nullable();
            $table->integer('temp_time1')->nullable();
            $table->integer('temp_time2')->nullable();
            $table->integer('temp_time3')->nullable();
            $table->string('temp_cfail1')->nullable();
            $table->string('temp_nfail1')->nullable();
            $table->string('temp_cfail2')->nullable();
            $table->string('temp_nfail2')->nullable();
            $table->string('temp_cfail3')->nullable();
            $table->string('temp_nfail3')->nullable();
            $table->string('temp_crep1')->nullable();
            $table->string('temp_nrep1')->nullable();
            $table->string('temp_crep2')->nullable();
            $table->string('temp_nrep2')->nullable();
            $table->string('temp_crep3')->nullable();
            $table->string('temp_nrep3')->nullable();
            $table->string('temp_sp')->nullable();
            $table->string('temp_sp_desc')->nullable();
            $table->decimal('temp_sp_price',10,2)->nullable();
            $table->decimal('temp_qty_req',10,2)->nullable();
            $table->decimal('temp_qty_whs',10,2)->nullable();
            $table->decimal('temp_qty_used',10,2)->nullable();
            $table->string('temp_finish_note')->nullable();
            $table->temporary();
        });

        /* Mencari data sparepart dari wo detail */
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
                'temp_create_date' => $da->wo_system_create,
                'temp_sch_date' => $da->wo_start_date,
                'temp_cfail1' => $da->wo_failure_type,
                'temp_nfail1' => $da->wo_failure_code.";".$da->wo_failure_code.";".$da->wo_failure_code,
                'temp_note' => $da->wo_note,
                'temp_crep1' => "",
                'temp_status' => $da->wo_status,
                'temp_sp' => $da->wd_sp_spcode,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->wd_sp_spcode)->value('spm_desc'),
                'temp_qty_req' => $da->wd_sp_required,
                'temp_qty_whs' => $da->wd_sp_issued,
                'temp_ceng1' => $da->wo_list_engineer,
            ]);
        }

        /* Mencari data sparepart yang belum ada wo detail nya */
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
                        'temp_create_date' => $ds->wo_system_create,
                        'temp_sch_date' => $ds->wo_start_date,
                        'temp_cfail1' => $ds->wo_failure_type,
                        'temp_nfail1' => $ds->wo_failure_code.";".$ds->wo_failure_code.";".$ds->wo_failure_code,
                        'temp_note' => $ds->wo_note,
                        'temp_crep1' => "",
                        'temp_status' => $ds->wo_status,
                        'temp_sp' => $da->spg_spcode,
                        'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->spg_spcode)->value('spm_desc'),
                        'temp_qty_req' => $da->spg_qtyreq,
                        'temp_qty_whs' => 0,
                        'temp_ceng1' => $ds->wo_list_engineer,
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
                    'temp_create_date' => $ds->wo_system_create,
                    'temp_sch_date' => $ds->wo_start_date,
                    'temp_cfail1' => $ds->wo_failure_type,
                    'temp_nfail1' => $ds->wo_failure_code.";".$ds->wo_failure_code.";".$ds->wo_failure_code,
                    'temp_note' => $ds->wo_note,
                    'temp_crep1' => "",
                    'temp_status' => $ds->wo_status,
                    'temp_sp' => "",
                    'temp_sp_desc' => "",
                    'temp_qty_req' => 0,
                    'temp_qty_whs' => 0,
                    'temp_ceng1' => $ds->wo_list_engineer,
                ]);
            }
        }

        /* Melengkapi data untuk report */
        $updwo = DB::table('temp_wo')
            ->get();
    
        foreach($updwo as $updwo){
            $upddatawo = DB::table('wo_mstr')
                ->selectRaw('wo_department,wo_type,wo_priority,wo_job_startdate,wo_job_starttime,wo_job_finishdate,wo_job_finishtime,wo_due_date')
                // ->selectRaw('wo_engineer1,wo_engineer2,wo_engineer3,wo_engineer4,wo_engineer5')
                // ->selectRaw('wo_failure_code1,f1.fn_desc as "fd1",wo_failure_code2,f2.fn_desc as "fd2",wo_failure_code3,f3.fn_desc as "fd3"')
                // ->selectRaw('wo_action,wo_created_at')
                // ->leftjoin('fn_mstr as f1','f1.fn_code','=','wo_failure_code1')
                // ->leftjoin('fn_mstr as f2','f2.fn_code','=','wo_failure_code2')
                // ->leftjoin('fn_mstr as f3','f3.fn_code','=','wo_failure_code3')
                ->where('wo_number','=',$updwo->temp_wo)
                ->first();

            $updsr = DB::table('service_req_mstr')
                ->where('wo_number','=',$updwo->temp_wo)
                ->first();

            /* Select Dept user create WO */
            $upddeptwo = DB::table('dept_mstr')
                ->where('dept_code','=',$upddatawo->wo_department)
                ->first();

            /* Select Dept user create SR */
            if(isset($updsr->sr_dept)){
                $upddeptsr = DB::table('dept_mstr')
                ->where('dept_code','=',$updsr->sr_dept)
                ->first();

                $deptsr = $upddeptsr->dept_desc;
            } else {
                $deptsr = "";
            }

            /* Location asset */
            $updassetloc = DB::table('asset_mstr')
                ->leftjoin('asset_loc','asloc_code','=','asset_loc')
                ->where('asset_code','=',$updwo->temp_asset)
                ->first();

            DB::table('temp_wo')
                ->where('temp_wo','=',$updwo->temp_wo)
                ->update([
                    'temp_wo_codedept' => isset($upddatawo->wo_department) ? $upddatawo->wo_department : "",
                    'temp_wo_dept' => isset($upddeptwo->dept_desc) ? $upddeptwo->dept_desc : "",
                    'temp_type' => $upddatawo->wo_type,
                    'temp_wo_priority' => $upddatawo->wo_priority,
                    'temp_sr_date' => isset($updsr->sr_date) ? $updsr->sr_date : "",
                    'temp_sr_request' => isset($updsr->req_username) ? $updsr->req_username : "",
                    'temp_sr_dept' => $deptsr,
                    'temp_asset_loc' => isset($updassetloc->asloc_desc) ? $updassetloc->asloc_desc : "",
                    'temp_ceng1' => "", // $upddatawo->wo_engineer1,
                    'temp_ceng2' => "", // $upddatawo->wo_engineer2,
                    'temp_ceng3' => "", // $upddatawo->wo_engineer3,
                    'temp_ceng4' => "", // $upddatawo->wo_engineer4,
                    'temp_ceng5' => "", // $upddatawo->wo_engineer5,
                    'temp_start_date' => $upddatawo->wo_job_startdate,
                    'temp_start_time' => $upddatawo->wo_job_starttime,
                    'temp_finish_date' => $upddatawo->wo_job_finishdate,
                    'temp_finish_time' => $upddatawo->wo_job_finishtime,
                    'temp_due_date' => $upddatawo->wo_due_date,
                    'temp_time1' => "", // (strtotime($upddatawo->wo_finish_time) - strtotime($upddatawo->wo_start_time)) / 60,
                    'temp_time2' => "", // isset($updsr->sr_time) ? (strtotime($upddatawo->wo_finish_time) - strtotime($updsr->sr_time)) / 60 : "0",
                    'temp_time2' => "", // isset($updsr->sr_time) ? (strtotime($upddatawo->wo_created_at) - strtotime($updsr->sr_time)) / 60 : "0",
                    'temp_cfail1' => "", // $upddatawo->wo_failure_code1,
                    'temp_nfail1' => "", // $upddatawo->fd1,
                    'temp_cfail2' => "", // $upddatawo->wo_failure_code2,
                    'temp_nfail2' => "", // $upddatawo->fd2,
                    'temp_cfail3' => "", // $upddatawo->wo_failure_code3,
                    'temp_nfail3' => "", // $upddatawo->fd3,
                    'temp_finish_note' => "", // $upddatawo->wo_action,
                ]);
                
        }

        $data = DB::table('temp_wo')
            ->select('temp_wo','temp_create_date','temp_creator','temp_wo_dept',
                'temp_type','temp_wo_priority','temp_status',
                'temp_sr','temp_sr_date','temp_sr_request','temp_sr_dept',
                'temp_asset','temp_asset_desc','temp_asset_loc','temp_note',
                'temp_ceng1','temp_ceng2','temp_ceng3','temp_ceng4','temp_ceng5',
                'temp_sch_date','temp_start_date','temp_start_time','temp_finish_date','temp_finish_time','temp_due_date',
                'temp_time1','temp_time2','temp_time3',
                'temp_cfail1','temp_nfail1','temp_cfail2','temp_nfail2','temp_cfail3','temp_nfail3','temp_finish_note',
                'temp_sp','temp_sp_desc','temp_sp_price','temp_qty_req','temp_qty_whs','temp_qty_used')
            ->orderBy('temp_create_date','desc')->orderBy('temp_wo','desc');

        // dd($this->type);

        if($this->wonbr) {
            $datatemp = $data->where('temp_wo','like','%'.$this->wonbr.'%');
        }
        if($this->sasset) {
            $data = $data->where('temp_asset','=',$this->sasset);
        }
        if($this->per1) {
            $data = $data->whereBetween ('temp_create_date',[$this->per1,$this->per2]);
        }
        if($this->dept) {
            $data = $data->where('temp_wo_codedept','=',$this->dept);
        }
        if($this->loc) {
            $data = $data->where('temp_asset_loc','=',$this->loc);
        }
        if($this->eng) {
            $data = $data->where('temp_ceng1','=',$this->eng)
                ->orWhere('temp_ceng2','=',$this->eng)
                ->orWhere('temp_ceng3','=',$this->eng)
                ->orWhere('temp_ceng4','=',$this->eng)
                ->orWhere('temp_ceng5','=',$this->eng);
        }
        if($this->type) {
            $data = $data->where('temp_type','=',$this->type);
        }

        // dd($data);

        Schema::dropIfExists('temp_wo');

        return $data;
    }

    public function headings(): array
    {
        return ['Work Order Number','WO Date', 'WO Created', 'Departement','Type','Priority','Status',
        'Service Request Number', 'Requested Date', 'Requested By', 'Departement', 
        'Asset Code','Asset Name','Asset Location', 'Note',
        'Engineer 1','Engineer 2','Engineer 3','Engineer 4','Engineer 5',
        'Schedule Date', 'Start Date', 'Start Time','Finish Date', 'Finish Time','Due Date', 
        'Finish - Start','Finish - SR Create','WO Create - SR Create',
        'Failure Code 1', 'Failure Desc 1', 'Failure Code 2', 'Failure Desc 2', 'Failure Code 3', 'Failure Desc 3', 'Finish Note',
        'Sparepart','Sparepart Desc','Price','Qty Required','Qty Confirm Whs','Qty Used'];
    }

    
}
