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
    function __construct($wonbr,$status,$asset,$priority,$period,$creator) {
        $this->wonbr    = $wonbr;
        $this->status   = $status;
        $this->asset    = $asset;
        $this->priority = $priority;
        $this->period   = $period;
        $this->creator  = $creator;
        // dd($this->stats);
        // dd($wonbr,$status,$asset,$priority,$period);
    }
    public function query()
    {
        $kondisi = '';
        // $wonbr = new Array();
        if($this->wonbr != null ||$this->wonbr != '' ){
            $kondisi .= "wo_nbr = '".$this->wonbr."'";
            // dd($kondisi);
        }
        if($this->status != null ||$this->status != '' ){
            if($kondisi <> '') {
                $kondisi .= " and wo_status = '".$this->status."'";
            } else {
                $kondisi .= "wo_status = '".$this->status."'";
            }
        }
        if($this->asset != null ||$this->asset != '' ){
            if($kondisi <> '') {
                $kondisi .= "and wo_asset = '".$this->asset."'";
            } else {
                $kondisi .= "wo_asset = '".$this->asset."'";
            }
        }
        if($this->priority != null ||$this->priority != '' ){
            if($kondisi <> '') {
                $kondisi .= " and wo_priority = '".$this->priority."'";
            } else {
                $kondisi .= "wo_priority = '".$this->priority."'";
            }
            // dd($kondisi);
        }
        if($this->creator != null ||$this->creator != '' ){
            if($kondisi <> '') {
                $kondisi .= " and wo_creator = '".$this->creator."'";
            } else {
                $kondisi .= "wo_creator = '".$this->creator."'";
            }
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
        //dd($kondisi);
        if($kondisi == ''){
            return  DB::table('wo_mstr')
                ->selectRaw("wo_nbr,wo_sr_nbr,wo_note,wo_asset,asset_desc,
                    IsNull(wo_mstr.wo_engineer1,'-') as 'eng1', IsNull(u1.eng_desc,'-') as 'nm1',
                    IsNull(wo_mstr.wo_engineer2,'-') as 'eng2', IsNull(u2.eng_desc,'-') as 'nm2', IsNull(wo_engineer3, '-') as 'eng3',
                    IsNull(u3.eng_desc, '-') as 'nm3', IsNull(wo_engineer4, '-') as 'eng4', IsNull(u4.eng_desc, '-') as 'nm4',
                    IsNull(wo_engineer5, '-') as 'eng5', IsNull(u5.eng_desc, '-') as 'nm5',
                    IsNull(wo_failure_code1,'-') as 'cfn1', IsNull(fn1.fn_desc,'-') as 'dfn1', IsNull(wo_failure_code2,'-') as 'cfn2',
                    IsNull(fn2.fn_desc,'-') as 'dfn2', IsNull(wo_failure_code3,'-') as 'cfn3', IsNull(fn3.fn_desc,'-') as 'dfn3',
                    CONCAT(xxrepgroup_nbr,',',wo_repair_code1,',',wo_repair_code2,',',wo_repair_code3) as 'repair',
                    dept_desc, wo_schedule, wo_duedate, wo_status, wo_priority, CAST(wo_created_at AS DATE) AS wo_created_at2, wo_creator")
                ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->leftjoin('fn_mstr as fn1','wo_mstr.wo_failure_code1','fn1.fn_code')
                ->leftjoin('fn_mstr as fn2','wo_mstr.wo_failure_code2','fn2.fn_code')
                ->leftjoin('fn_mstr as fn3','wo_mstr.wo_failure_code3','fn3.fn_code')
                ->leftjoin('rep_master as r1','wo_mstr.wo_repair_code1','r1.repm_code')
                ->leftjoin('rep_master as r2','wo_mstr.wo_repair_code2','r2.repm_code')
                ->leftjoin('rep_master as r3','wo_mstr.wo_repair_code3','r3.repm_code')
                ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                ->leftjoin('xxrepgroup_mstr','xxrepgroup_mstr.xxrepgroup_nbr','wo_mstr.wo_repair_group')
                ->distinct()
                ->orderby('wo_created_at2','desc');
        }
        else{
            return  DB::table('wo_mstr')
            ->selectRaw("wo_nbr,wo_sr_nbr,wo_note,wo_asset,asset_desc,
                IsNull(wo_mstr.wo_engineer1,'-') as 'eng1', IsNull(u1.eng_desc,'-') as 'nm1',
                IsNull(wo_mstr.wo_engineer2,'-') as 'eng2', IsNull(u2.eng_desc,'-') as 'nm2', IsNull(wo_engineer3, '-') as 'eng3',
                IsNull(u3.eng_desc, '-') as 'nm3', IsNull(wo_engineer4, '-') as 'eng4', IsNull(u4.eng_desc, '-') as 'nm4',
                IsNull(wo_engineer5, '-') as 'eng5', IsNull(u5.eng_desc, '-') as 'nm5',
                IsNull(wo_failure_code1,'-') as 'cfn1', IsNull(fn1.fn_desc,'-') as 'dfn1', IsNull(wo_failure_code2,'-') as 'cfn2',
                IsNull(fn2.fn_desc,'-') as 'dfn2', IsNull(wo_failure_code3,'-') as 'cfn3', IsNull(fn3.fn_desc,'-') as 'dfn3',
                IsNull(wo_mstr.wo_repair_group,'-') as 'cg1', IsNull(xxrepgroup_mstr.xxrepgroup_desc,'-') as 'dg1',
                IsNull(wo_mstr.wo_repair_code1,'-') as 'cr1', IsNull(r1.repm_desc,'-') as 'dr1', IsNull(wo_mstr.wo_repair_code2,'-') as 'cr2',
                IsNull(r2.repm_desc,'-') as 'dr2', IsNull(wo_mstr.wo_repair_code3,'-') as 'cr3', IsNull(r3.repm_desc,'-') as 'dr3',
                dept_desc, wo_schedule, wo_duedate, wo_status, wo_priority, CAST(wo_created_at AS DATE) AS wo_created_at2, wo_creator")
            ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
            ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
            ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
            ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
            ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
            ->leftjoin('fn_mstr as fn1','wo_mstr.wo_failure_code1','fn1.fn_code')
            ->leftjoin('fn_mstr as fn2','wo_mstr.wo_failure_code2','fn2.fn_code')
            ->leftjoin('fn_mstr as fn3','wo_mstr.wo_failure_code3','fn3.fn_code')
            ->leftjoin('rep_master as r1','wo_mstr.wo_repair_code1','r1.repm_code')
            ->leftjoin('rep_master as r2','wo_mstr.wo_repair_code2','r2.repm_code')
            ->leftjoin('rep_master as r3','wo_mstr.wo_repair_code3','r3.repm_code')
            ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
            ->leftjoin('xxrepgroup_mstr','xxrepgroup_mstr.xxrepgroup_nbr','wo_mstr.wo_repair_group')
            ->whereRaw($kondisi)
            ->distinct()
            ->orderby('wo_created_at2','desc');
        }
        
        // dd($test);
    }
    public function headings(): array
    {
        return ['Work Order Number','Service Request Number','Note','Asset Code','Asset Name','Engineer 1 Code','Engineer 1 Name','Engineer 2 Code','Engineer 2 Name','Engineer 3 Code','Engineer 3 Name','Engineer 4 Code','Engineer 4 Name','Engineer 5 Code','Engineer 5 Name','Failure 1 Code','Failure 1 Desc','Failure 2 Code','Failure 2 Desc','Failure 3 Code','Failure 3 Desc','Repair Group','Repair Group Desc','Repair 1','Repair 1 Desc','Repair 2','Repair 2 Desc','Repair 3','Repair 3 Desc','Department','Schedule Date','Due Date','Status','Priority','Requested Date','Requested By'];
    }

    
}
