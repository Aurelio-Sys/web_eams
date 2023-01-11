<?php

namespace App\Exports;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

    function __construct($wonbr,$sasset,$per1,$per2) {
        $this->wonbr    = $wonbr;
        $this->sasset    = $sasset;
        $this->per1   = $per1;
        $this->per2 = $per2;
    }

    public function query()
    {
        // dd($this->wonbr);
        
        $wonbr    = $this->wonbr;
        $sasset     = $this->sasset;
        $per1    = $this->per1;
        $per2  = $this->per2;

        Schema::create('temp_wo', function ($table) {
            $table->increments('id');
            $table->string('temp_wo');
            $table->string('temp_creator')->nullable(); /* Untuk PM Creator nya kosong */
            $table->date('temp_create_date');
            $table->string('temp_wo_dept')->nullable();
            $table->string('temp_wo_type');
            $table->string('temp_wo_priority');
            $table->string('temp_status');
            $table->string('temp_sr')->nullable();
            $table->date('temp_sr_date');
            $table->string('temp_sr_request');
            $table->string('temp_sr_dept');
            $table->string('temp_asset');
            $table->string('temp_asset_desc')->nullable();
            $table->string('temp_asset_loc')->nullable();
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
                'temp_creator' => $da->wo_creator,
                'temp_create_date' => date("Y-m-d",strtotime($da->wo_created_at)),
                'temp_sr' => $da->wo_sr_nbr,
                'temp_asset' => $da->wo_asset,
                'temp_asset_desc' => DB::table('asset_mstr')->where('asset_code','=',$da->wo_asset)->value('asset_desc'),
                
                
                'temp_sch_date' => $da->wo_schedule,
                // 'temp_fail_type' => $da->wo_new_type,
                // 'temp_fail_code' => $da->wo_failure_code1.";".$da->wo_failure_code2.";".$da->wo_failure_code3,
                'temp_note' => $da->wo_note,
                // 'temp_repair' => $da->wo_dets_rc.' : '.$da->repm_desc,
                'temp_status' => $da->wo_status,
                'temp_sp' => $da->wo_dets_sp,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->wo_dets_sp)->value('spm_desc'),
                'temp_sp_price' => $da->wo_dets_sp_price,
                'temp_qty_req' => $da->wo_dets_sp_qty,
                'temp_qty_whs' => $da->wo_dets_wh_conf,
                'temp_qty_used' => $da->wo_dets_qty_used,
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
                    'wo_failure_code2', 'wo_failure_code3', 'wo_asset', 'wo_note', 'repm_desc')
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
                    'wo_failure_code2', 'wo_failure_code3', 'wo_asset', 'wo_note', 'repm_desc')
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
                    'wo_failure_code2', 'wo_failure_code3', 'wo_asset', 'wo_note', 'repm_desc')
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
                    'wo_failure_code2', 'wo_failure_code3', 'wo_asset', 'wo_note', 'repm_desc')
                    ->leftjoin('rep_master', 'xxrepgroup_mstr.xxrepgroup_rep_code', 'rep_master.repm_code')
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
                'temp_sr' => $dc->wo_sr_nbr,
                'temp_asset' => $dc->wo_asset,
                'temp_asset_desc' => DB::table('asset_mstr')->where('asset_code','=',$da->wo_asset)->value('asset_desc'),
                'temp_creator' => $dc->wo_creator,
                'temp_create_date' => date("Y-m-d",strtotime($dc->wo_created_at)),
                'temp_sch_date' => $dc->wo_schedule,
                // 'temp_fail_type' => $dc->wo_new_type,
                // 'temp_fail_code' => $dc->wo_failure_code1.";".$dc->wo_failure_code2.";".$dc->wo_failure_code3,
                'temp_note' => $dc->wo_note,
                // 'temp_repair' => $dc->repair_code." : ".$dc->repm_desc,
                'temp_status' => $dc->wo_status,
                'temp_sp' => $dc->insd_part,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$dc->insd_part)->value('spm_desc'),
                'temp_qty_req' => $dc->insd_qty,
            ]);
        }

        /* Melengkapi data untuk report */
        $updwo = DB::table('temp_wo')
            ->get();
    
        foreach($updwo as $updwo){
            $upddatawo = DB::table('wo_mstr')
                ->selectRaw('wo_dept,wo_type,wo_priority,wo_start_date,wo_start_time,wo_finish_date,wo_finish_time,wo_duedate')
                ->selectRaw('wo_engineer1,wo_engineer2,wo_engineer3,wo_engineer4,wo_engineer5')
                ->selectRaw('wo_failure_code1,f1.fn_desc as "fd1",wo_failure_code2,f2.fn_desc as "fd2",wo_failure_code3,f3.fn_desc as "fd3"')
                ->selectRaw('wo_action,wo_created_at')
                ->leftjoin('fn_mstr as f1','f1.fn_code','=','wo_failure_code1')
                ->leftjoin('fn_mstr as f2','f2.fn_code','=','wo_failure_code2')
                ->leftjoin('fn_mstr as f3','f3.fn_code','=','wo_failure_code3')
                ->where('wo_nbr','=',$updwo->temp_wo)
                ->first();

            $updsr = DB::table('service_req_mstr')
                ->where('wo_number','=',$updwo->temp_wo)
                ->first();

            /* Select Dept user create WO */
            $upddeptwo = DB::table('dept_mstr')
                ->where('dept_code','=',$upddatawo->wo_dept)
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
                    'temp_wo_dept' => isset($upddeptwo->dept_desc) ? $upddeptwo->dept_desc : "",
                    'temp_wo_type' => $upddatawo->wo_type,
                    'temp_wo_priority' => $upddatawo->wo_priority,
                    'temp_sr_date' => isset($updsr->sr_date) ? $updsr->sr_date : "",
                    'temp_sr_request' => isset($updsr->req_username) ? $updsr->req_username : "",
                    'temp_sr_dept' => $deptsr,
                    'temp_asset_loc' => isset($updassetloc->asloc_desc) ? $updassetloc->asloc_desc : "",
                    'temp_ceng1' => $upddatawo->wo_engineer1,
                    'temp_ceng2' => $upddatawo->wo_engineer2,
                    'temp_ceng3' => $upddatawo->wo_engineer3,
                    'temp_ceng4' => $upddatawo->wo_engineer4,
                    'temp_ceng5' => $upddatawo->wo_engineer5,
                    'temp_start_date' => $upddatawo->wo_start_date,
                    'temp_start_time' => $upddatawo->wo_start_time,
                    'temp_finish_date' => $upddatawo->wo_finish_date,
                    'temp_finish_time' => $upddatawo->wo_finish_time,
                    'temp_due_date' => $upddatawo->wo_duedate,
                    'temp_time1' => (strtotime($upddatawo->wo_finish_time) - strtotime($upddatawo->wo_start_time)) / 60,
                    'temp_time2' => isset($updsr->sr_time) ? (strtotime($upddatawo->wo_finish_time) - strtotime($updsr->sr_time)) / 60 : "0",
                    'temp_time2' => isset($updsr->sr_time) ? (strtotime($upddatawo->wo_created_at) - strtotime($updsr->sr_time)) / 60 : "0",
                    'temp_cfail1' => $upddatawo->wo_failure_code1,
                    'temp_nfail1' => $upddatawo->fd1,
                    'temp_cfail2' => $upddatawo->wo_failure_code2,
                    'temp_nfail2' => $upddatawo->fd2,
                    'temp_cfail3' => $upddatawo->wo_failure_code3,
                    'temp_nfail3' => $upddatawo->fd3,
                    'temp_finish_note' => $upddatawo->wo_action,
                ]);
                
        }

        $data = DB::table('temp_wo')
            ->select('temp_wo','temp_create_date','temp_creator','temp_wo_dept',
                'temp_wo_type','temp_wo_priority','temp_status',
                'temp_sr','temp_sr_date','temp_sr_request','temp_sr_dept',
                'temp_asset','temp_asset_desc','temp_asset_loc','temp_note',
                'temp_ceng1','temp_ceng2','temp_ceng3','temp_ceng4','temp_ceng5',
                'temp_sch_date','temp_start_date','temp_start_time','temp_finish_date','temp_finish_time','temp_due_date',
                'temp_time1','temp_time2','temp_time3',
                'temp_cfail1','temp_nfail1','temp_cfail2','temp_nfail2','temp_cfail3','temp_nfail3','temp_finish_note',
                'temp_sp','temp_sp_desc','temp_sp_price','temp_qty_req','temp_qty_whs','temp_qty_used')
            ->orderBy('temp_wo','desc');

        if($this->wonbr) {
            $datatemp = $data->where('temp_wo','=',$this->wonbr);
        }

        if($this->sasset) {
            $data = $data->where('temp_asset','=',$this->sasset);
        }

        if($this->per1) {
            $data = $data->whereBetween ('temp_create_date',[$this->per1,$this->per2]);
        }

        // dd($data);

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
