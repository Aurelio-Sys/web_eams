<?php

/*
Daftar perubahan :
A211126 : repair dihilangkan, karena defaultnya akan other semua. file sebelumnya sudah di backup di 211126 sblm diilangin repair

*/

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
    function __construct($wonbr,$status,$asset,$priority,$period,$creator,$engineer) {
        $this->wonbr    = $wonbr;
        $this->status   = $status;
        $this->asset    = $asset;
        $this->priority = $priority;
        $this->period   = $period;
        $this->creator  = $creator;
        $this->engineer = $engineer;
        // dd($this->stats);
        // dd($wonbr,$status,$asset,$priority,$period);
    }
    public function query()
    {
        $kondisi = 'wo_id > 0';
        // $wonbr = new Array();
        if($this->wonbr != null ||$this->wonbr != '' ){
            $kondisi .= "and wo_nbr = '".$this->wonbr."'";
        }

        if($this->status != null ||$this->status != '' ){
            $kondisi .= " and wo_status = '".$this->status."'";
        }

        if($this->asset != null ||$this->asset != '' ){
            $kondisi .= "and wo_asset = '".$this->asset."'";
        }

        if($this->priority != null ||$this->priority != '' ){
            $kondisi .= " and wo_priority = '".$this->priority."'";
        }

        if($this->creator != null ||$this->creator != '' ){
            $kondisi .= " and wo_creator = '".$this->creator."'";
        }

        if($this->period != null || $this->period != ''){
            if($this->period == '1'){
                $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) ."'";
            }
            else if($this->period == '2'){
                $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "' AND '" .Carbon::today()->subDay(5)."'";
            }
            else if($this->period == '3'){
                $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) ."'";
            }
        }

        if($this->engineer != null ||$this->engineer != '' ){
            $kondisi .= " and (wo_engineer1 = '".$this->engineer."' or wo_engineer2 = '".$this->engineer."' or wo_engineer3 = '".$this->engineer."' or wo_engineer4 = '".$this->engineer."' or wo_engineer5 = '".$this->engineer."')";
        }
        
        return  DB::table('wo_mstr')
        ->selectRaw("wo_nbr,CAST(wo_created_at AS DATE) AS wo_created_at2, CAST(wo_created_at AS TIME) AS wo_time,
            wo_creator, d1.dept_desc,
            (case when wo_type = 'auto' then 'PM' else 'WO' end) as Type, wo_priority, wo_status,
            wo_sr_nbr, 
            CAST(sr_date AS DATE) AS sr_date, req_username, IfNull(d2.dept_desc,'-') as 'd1', wo_asset, asset_desc,wo_note,
            IfNull(wo_mstr.wo_engineer1,'-') as 'eng1', IfNull(u1.eng_desc,'-') as 'nm1',
            IfNull(wo_mstr.wo_engineer2,'-') as 'eng2', IfNull(u2.eng_desc,'-') as 'nm2', IfNull(wo_engineer3, '-') as 'eng3',
            IfNull(u3.eng_desc, '-') as 'nm3', IfNull(wo_engineer4, '-') as 'eng4', IfNull(u4.eng_desc, '-') as 'nm4',
            IfNull(wo_engineer5, '-') as 'eng5', IfNull(u5.eng_desc, '-') as 'nm5',
            wo_schedule, wo_start_date, wo_start_time, wo_finish_date, wo_finish_time, wo_duedate, 
            wo_failure_code1, IfNull(f1.fn_desc, '-') as 'fd1',
            wo_failure_code2, IfNull(f2.fn_desc, '-') as 'fd2', wo_failure_code3,
            IfNull(f3.fn_desc, '-') as 'fd3', wo_approval_note")
        ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
        ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
        ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
        ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
        ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
        ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
        ->leftJoin('dept_mstr as d1','wo_mstr.wo_dept','d1.dept_code')
        ->leftjoin('xxrepgroup_mstr','xxrepgroup_mstr.xxrepgroup_nbr','wo_mstr.wo_repair_group')
        ->leftJoin('service_req_mstr','sr_number','=','wo_sr_nbr')
        ->leftJoin('dept_mstr as d2','sr_dept','d2.dept_code')
        ->leftjoin('fn_mstr as f1','f1.fn_code','wo_failure_code1')
        ->leftjoin('fn_mstr as f2','f2.fn_code','wo_failure_code2')
        ->leftjoin('fn_mstr as f3','f3.fn_code','wo_failure_code3')
        ->whereRaw($kondisi)
        ->distinct()
        ->orderby('wo_created_at2','desc')
        ->orderby('wo_time','desc');;
        
    }
    public function headings(): array
    {
        return ['Work Order Number','WO Date', 'WO Time', 'WO Created', 'Departement','Type','Priority','Status','Service Request Number',
        'Requested Date',
        'Requested By', 'Departement', 'Asset Code','Asset Name','Note','Engineer 1 Code','Engineer 1 Name','Engineer 2 Code',
        'Engineer 2 Name','Engineer 3 Code','Engineer 3 Name','Engineer 4 Code','Engineer 4 Name','Engineer 5 Code',
        'Engineer 5 Name',
        'Schedule Date', 'Start Date', 'Start Time','Finish Date', 'Finish Time','Due Date', 'Failure Code 1', 'Failure Desc 1', 
        'Failure Code 2', 'Failure Desc 2', 'Failure Code 3', 'Failure Desc 3', 'Finish Note']; /* A211126 */
    }

    
}
