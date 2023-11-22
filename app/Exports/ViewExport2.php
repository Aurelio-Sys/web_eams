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

        if($per1 != null ||$per2 != '' ){
            $kondisi .= " and wo_system_create between CONCAT('".$per1."',' 00:00:00') AND CONCAT('".$per2."',' 23:59:59')";
        }

        // dd($kondisi);
        // Untuk nama engineer belum bisa, program yang lama udah di backup
        return DB::table('wo_mstr')
        ->selectRaw("wo_mstr.wo_number,
            wo_createdby, e1.eng_desc, wo_department, d1.dept_desc, wo_type, wo_priority, wo_status, 
            wo_sr_number, CAST(sr_req_date AS DATE) AS sr_date, CAST(sr_req_time AS TIME) AS sr_time, sr_req_by, 
            IFNULL(d2.dept_desc, '-') as 'd1', 
            wo_asset_code, asset_desc, asset_site, asset_loc, asloc_desc, wo_note,
            wo_mt_code, pmc_desc, wo_ins_code, ins_desc, wo_sp_code, spg_desc, wo_qcspec_code, qcs_desc,
            SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 1), ';', -1) AS fncode1,
            fn1.fn_desc as fn_desc1, 
            CASE WHEN LOCATE(';', wo_failure_code) > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 2), ';', -1) ELSE '' END AS fncode2,
            fn2.fn_desc as fn_desc2, 
            CASE WHEN LENGTH(wo_failure_code) - LENGTH(REPLACE(wo_failure_code, ';', '')) >= 2 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 3), ';', -1) ELSE '' END AS fncode3,
            fn3.fn_desc as fn_desc3, 
            CASE WHEN LENGTH(wo_failure_code) - LENGTH(REPLACE(wo_failure_code, ';', '')) >= 3 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 4), ';', -1) ELSE '' END AS fncode4,
            fn4.fn_desc as fn_desc4, 
            CASE WHEN LENGTH(wo_failure_code) - LENGTH(REPLACE(wo_failure_code, ';', '')) >= 4 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 5), ';', -1) ELSE '' END AS fncode5,
            fn5.fn_desc as fn_desc5,
            wo_failure_type, wotyp_desc, wo_impact_code, imp_desc,
            SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 1), ';', -1) AS eng1,
            eng1.eng_desc as eng_name1, 
            CASE WHEN LOCATE(';', wo_list_engineer) > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 2), ';', -1) ELSE '' END AS eng2,
            eng2.eng_desc as eng_name2, 
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 2 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 3), ';', -1) ELSE '' END AS eng3,
            eng3.eng_desc as eng_name3, 
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 3 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 4), ';', -1) ELSE '' END AS eng4,
            eng4.eng_desc as eng_name4,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 4 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 5), ';', -1) ELSE '' END AS eng5,
            eng5.eng_desc as eng_name5, 
            TIMESTAMPDIFF(MINUTE, CONCAT(sr_req_date, ' ', sr_req_time), wo_system_create) as selisih3,
            CAST(wo_system_create AS DATE) AS wo_created_at2, CAST(wo_system_create AS TIME) AS wo_time, wo_start_date, wo_released_date, wo_released_time,
            TIMESTAMPDIFF(MINUTE, CONCAT(wo_released_date, ' ', wo_released_time), CONCAT(wo_job_startdate, ' ', wo_job_starttime)) as selisih1,
            wo_job_startdate, wo_job_starttime,
            TIMESTAMPDIFF(MINUTE, CONCAT(wo_job_startdate, ' ', wo_job_starttime), CONCAT(wo_job_finishdate, ' ', wo_job_finishtime)) AS selisih2,
            wo_job_finishdate, wo_job_finishtime, wo_due_date, 
            wo_downtime, wo_downtime_um, wo_report_note")
        ->leftjoin('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
        ->leftJoin('eng_mstr as e1','eng_code','wo_createdby')
        ->leftJoin('dept_mstr as d1', 'wo_mstr.wo_department', 'd1.dept_code')
        ->leftJoin('service_req_mstr', 'sr_number', '=', 'wo_sr_number')
        ->leftJoin('dept_mstr as d2', 'sr_dept', 'd2.dept_code')
        ->leftJoin('asset_loc', 'asloc_code', '=', 'asset_loc')
        ->leftJoin('pmc_mstr', 'pmc_code', '=', 'wo_mt_code')
        ->leftJoin('ins_list', 'ins_code', '=', 'wo_ins_code')
        ->leftJoin('spg_list', 'spg_code', 'wo_sp_code')
        ->leftJoin('qcs_list', 'qcs_code', '=', 'wo_qcspec_code')
        ->leftJoin('fn_mstr as fn1', 'fn1.fn_code', '=', DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 1), ';', -1)"))
        ->leftJoin('fn_mstr as fn2', 'fn2.fn_code', '=', DB::raw("CASE WHEN LOCATE(';', wo_failure_code) > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 2), ';', -1) ELSE '' END"))
        ->leftJoin('fn_mstr as fn3', 'fn3.fn_code', '=', DB::raw("CASE WHEN LENGTH(wo_failure_code) - LENGTH(REPLACE(wo_failure_code, ';', '')) >= 2 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 3), ';', -1) ELSE '' END"))
        ->leftJoin('fn_mstr as fn4', 'fn4.fn_code', '=', DB::raw("CASE WHEN LENGTH(wo_failure_code) - LENGTH(REPLACE(wo_failure_code, ';', '')) >= 3 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 4), ';', -1) ELSE '' END"))
        ->leftJoin('fn_mstr as fn5', 'fn5.fn_code', '=', DB::raw("CASE WHEN LENGTH(wo_failure_code) - LENGTH(REPLACE(wo_failure_code, ';', '')) >= 4 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 5), ';', -1) ELSE '' END"))
        ->leftJoin('imp_mstr', 'imp_code', '=', 'wo_impact_code')
        ->leftJoin('wotyp_mstr', 'wotyp_code', '=', 'wo_failure_type')
        ->leftJoin('eng_mstr as eng1', function ($join) {
            $join->on('eng1.eng_code', '=', DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 1), ';', -1)"));
        })
        ->leftJoin('eng_mstr as eng2', function ($join) {
            $join->on('eng2.eng_code', '=', DB::raw("CASE WHEN LOCATE(';', wo_list_engineer) > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 2), ';', -1) ELSE '' END"));
        })
        ->leftJoin('eng_mstr as eng3', function ($join) {
            $join->on('eng3.eng_code', '=', DB::raw("CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 2 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 3), ';', -1) ELSE '' END"));
        })
        ->leftJoin('eng_mstr as eng4', function ($join) {
            $join->on('eng4.eng_code', '=', DB::raw("CASE WHEN LENGTH(wo_failure_code) - LENGTH(REPLACE(wo_failure_code, ';', '')) >= 3 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 4), ';', -1) ELSE '' END"));
        })
        ->leftJoin('eng_mstr as eng5', function ($join) {
            $join->on('eng5.eng_code', '=', DB::raw("CASE WHEN LENGTH(wo_failure_code) - LENGTH(REPLACE(wo_failure_code, ';', '')) >= 4 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_failure_code, ';', 5), ';', -1) ELSE '' END"));
        })
        ->whereRaw($kondisi)
        ->distinct()
        ->orderBy('wo_created_at2', 'desc')
        ->orderBy('wo_time', 'desc');
    



       
        
    }
    public function headings(): array
    {
        return ['Work Order Number',
        'WO Created','WO Created Name', 'Departement', 'Departement Desc','Type','Priority','Status',
        'Service Request Number', 'Requested Date', 'Requested Time','Requested By', 'Departement', 
        'Asset Code','Asset Name','Asset Site','Asset Location Code','Asset Location Desc','Note',
        'Maintenance Code','Maintenance Desc','Instruction List','Instruction Desc','Spare part List','Spare part Desc','QC Spesification','Spesification Desc',
        'Failure Code 1','Failure Desc 1','Failure Code 2','Failure Desc 2','Failure Code 3','Failure Desc 3',
        'Failure Code 4','Failure Desc 4','Failure Code 5','Failure Desc 5',
        'Failure Type','Failure Type Desc','Impact','Impact Desc',
        'Engineer 1','Engineer Name 1','Engineer 2','Engineer Name 2','Engineer 3','Engineer Name 3',
        'Engineer 4','Engineer Name 4','Engineer 5','Engineer Name 5',
        'SR - WO',
        'WO Date', 'WO Time', 'Schedule Date','Release Date','Release Time','Release - Start',
        'Start Date', 'Start Time','Start - Finish',
        'Finish Date', 'Finish Time','Due Date',
        'Downtime','Downtime UM', 'Note Reporting']; /* A211126 */
    }

    
}
