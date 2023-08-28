<?php

namespace App\Exports;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ViewExport2 implements FromQuery, WithHeadings, ShouldAutoSize,WithStyles
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
        // dd($this->stats);
        // dd($wonbr,$status,$asset,$priority,$period);
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

        $kondisi = 'wo_mstr.id > 0';
        // $wonbr = new Array();
        if($wonbr != null ||$wonbr != '' ){
            $kondisi .= " and wo_mstr.wo_number = '".$wonbr."'";
        }

        // if($this->status != null ||$this->status != '' ){
        //     $kondisi .= " and wo_status = '".$this->status."'";
        // }

        if($sasset != null ||$sasset != '' ){
            $kondisi .= " and wo_asset_code = '".$sasset."'";
        }

        if($dept != null ||$dept != '' ){
            $kondisi .= " and wo_department = '".$dept."'";
        }

        if($type != null ||$type != '' ){
            $kondisi .= " and wo_type = '".$type."'";
        }

        if($loc != null ||$loc != '' ){
            $kondisi .= " and wo_location = '".$loc."'";
        }

        if($per1 != null ||$per1 != '' ){
            $kondisi .= " and wo_system_create between CONCAT('".$per1."',' 00:00:00') AND CONCAT('".$per1."',' 23:59:59')";
        }
        

        

        // if($this->priority != null ||$this->priority != '' ){
        //     $kondisi .= " and wo_priority = '".$this->priority."'";
        // }

        // if($this->creator != null ||$this->creator != '' ){
        //     $kondisi .= " and wo_creator = '".$this->creator."'";
        // }

        // dd($kondisi);
        // Untuk nama engineer belum bisa, program yang lama udah di backup
        return  DB::table('wo_mstr')
        ->selectRaw("wo_mstr.wo_number,
            wo_createdby, d1.dept_desc, wo_type , wo_priority, wo_status, 
            wo_sr_number, CAST(sr_req_date AS DATE) AS sr_date,CAST(sr_req_time AS TIME) AS sr_time, sr_req_by, IfNull(d2.dept_desc,'-') as 'd1', 
            wo_asset_code, asset_desc,asset_site,asset_loc,asloc_desc,wo_note,
            wo_mt_code,pmc_desc,wo_ins_code,ins_desc,wo_sp_code,spg_desc,wo_qcspec_code,qcs_desc,
            SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 1), ';', -1) AS eng1,
            CASE WHEN LOCATE(';', wo_list_engineer) > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 2), ';', -1) ELSE '' END AS eng2,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 2 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 3), ';', -1) ELSE '' END AS eng3,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 3 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 4), ';', -1) ELSE '' END AS eng4,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 4 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 5), ';', -1) ELSE '' END AS eng5,
            TIMESTAMPDIFF(MINUTE,CONCAT(sr_req_date, ' ', sr_req_time), wo_system_create) as selisih3,
            CAST(wo_system_create AS DATE) AS wo_created_at2, CAST(wo_system_create AS TIME) AS wo_time,wo_start_date,wo_released_date,wo_released_time,
            TIMESTAMPDIFF(MINUTE, CONCAT(wo_released_date, ' ', wo_released_time), CONCAT(wo_job_startdate, ' ', wo_job_starttime)) as selisih1,
            wo_job_startdate, wo_job_starttime,
            TIMESTAMPDIFF(MINUTE, CONCAT(wo_job_startdate, ' ', wo_job_starttime), CONCAT(wo_job_finishdate, ' ', wo_job_finishtime)) AS selisih2,
            wo_job_finishdate, wo_job_finishtime, wo_due_date, 
            wo_downtime,wo_downtime_um,wo_report_note")
        ->leftjoin('asset_mstr','wo_mstr.wo_asset_code','asset_mstr.asset_code')
        ->leftJoin('dept_mstr as d1','wo_mstr.wo_department','d1.dept_code')
        ->leftJoin('service_req_mstr','sr_number','=','wo_sr_number')
        ->leftJoin('dept_mstr as d2','sr_dept','d2.dept_code')
        ->leftJoin('asset_loc','asloc_code','=','asset_loc')
        ->leftJoin('pmc_mstr','pmc_code','=','wo_mt_code')
        ->leftJoin('ins_list','ins_code','=','wo_ins_code')
        ->leftJoin('spg_list','spg_code','wo_sp_code')
        ->leftJoin('qcs_list','qcs_code','=','wo_qcspec_code')
        ->whereRaw($kondisi)
        ->distinct()
        ->orderby('wo_created_at2','desc')
        ->orderby('wo_time','desc');
        
    }
    public function headings(): array
    {
        return ['Work Order Number',
        'WO Created', 'Departement','Type','Priority','Status',
        'Service Request Number', 'Requested Date', 'Requested Time','Requested By', 'Departement', 
        'Asset Code','Asset Name','Asset Site','Asset Location Code','Asset Location Desc','Note',
        'Maintenance Code','Maintenance Desc','Instruction List','Instruction Desc','Spare part List','Spare part Desc','QC Spesification','Spesification Desc',
        'Engineer 1','Engineer 2','Engineer 3','Engineer 4','Engineer 5',
        'SR - WO',
        'WO Date', 'WO Time', 'Schedule Date','Release Date','Release Time','Release - Start',
        'Start Date', 'Start Time','Start - Finish',
        'Finish Date', 'Finish Time','Due Date',
        'Downtime','Downtime UM', 'Note Reporting']; /* A211126 */
    }

    
}
