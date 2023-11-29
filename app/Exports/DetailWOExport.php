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
		
		/* Note : 
			- Mengambil harga dari data PC di pc_cost berdasarkan tanggal issued item. bukan berdasarkan tanggal terbentuknya WO 
			- Tanggal transaksi adalah tanggal schedule date bukan dari tanggal terbentuknya wo, karena bisa jadi ada wo yang terbentuk skrg tapi jadwalnya untuk next bulan
			- Detail WO report belum mengambil dari schedule date, harus di cek lagi
		*/
        
        /* 1 Mencari data sparepart dari wo detail */
        $datadet = DB::table('wo_dets_sp')
            ->selectRaw("wo_number,wo_system_create,wo_start_date,wo_job_finishdate,wo_department,wo_status,wo_type,
                wo_asset_code,asset_desc,asset_site,asset_loc,asloc_desc,wo_note,
                SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 1), ';', -1) AS eng1,
                CASE WHEN LOCATE(';', wo_list_engineer) > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 2), ';', -1) ELSE '' END AS eng2,
                CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 2 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 3), ';', -1) ELSE '' END AS eng3,
                CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 3 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 4), ';', -1) ELSE '' END AS eng4,
                CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 4 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 5), ';', -1) ELSE '' END AS eng5,
                wd_sp_spcode as spcode,spm_desc,spc_cost,wd_sp_required as req,wd_sp_whtf,wd_sp_issued ")
            ->join('wo_mstr','wo_number','=','wd_sp_wonumber')
            ->leftJoin('asset_mstr','asset_code','=','wo_asset_code')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->leftJoin('sp_mstr','spm_code','=','wd_sp_spcode')
            ->leftJoin('sp_cost', function ($join) {
                $join->on('sp_cost.spc_part', '=', 'sp_mstr.spm_code')
                     ->whereRaw("sp_cost.spc_period = DATE_FORMAT(wo_mstr.wo_job_finishdate, '%y%m')");
            })
			/* ->where('wo_number','=','WO-23-000288') */
            ->orderBy('wd_sp_wonumber');
//dd($datadet->get());

        /* 2 Mencari data sparepart yang belum ada wo detail nya */
        
        /* 2a Jika ada SparepartList nya */
        $dataspg = DB::table('wo_mstr')
            ->selectRaw("wo_number,wo_system_create,wo_start_date,wo_job_finishdate,wo_department,wo_status,wo_type,
            wo_asset_code,asset_desc,asset_site,asset_loc,asloc_desc,wo_note,
            SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 1), ';', -1) AS eng1,
            CASE WHEN LOCATE(';', wo_list_engineer) > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 2), ';', -1) ELSE '' END AS eng2,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 2 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 3), ';', -1) ELSE '' END AS eng3,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 3 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 4), ';', -1) ELSE '' END AS eng4,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 4 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 5), ';', -1) ELSE '' END AS eng5,
            spm_code as spcode,spm_desc,spc_cost,spg_qtyreq as req,'0' as wd_sp_whtf,'0' as wd_sp_issued ")
            // ->where('wo_nbr','=','PM-23-004839')
            ->whereNotIn('wo_number', function($q){
                $q->select('wd_sp_wonumber')->from('wo_dets_sp');
            })
            ->join('spg_list','spg_code','=','wo_sp_code')
            ->leftJoin('asset_mstr','asset_code','=','wo_asset_code')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->leftJoin('sp_mstr','spm_code','=','spg_spcode')
            ->leftJoin('sp_cost', function ($join) {
                $join->on('sp_cost.spc_part', '=', 'sp_mstr.spm_code')
                     ->whereRaw("sp_cost.spc_period = DATE_FORMAT(wo_mstr.wo_job_finishdate, '%y%m')");
            });

        /* 2a Jika tidak ada SparepartList nya */
        $datawo = DB::table('wo_mstr')
            ->selectRaw("wo_number,wo_system_create,wo_start_date,wo_job_finishdate,wo_department,wo_status,wo_type,
            wo_asset_code,asset_desc,asset_site,asset_loc,asloc_desc,wo_note,
            SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 1), ';', -1) AS eng1,
            CASE WHEN LOCATE(';', wo_list_engineer) > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 2), ';', -1) ELSE '' END AS eng2,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 2 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 3), ';', -1) ELSE '' END AS eng3,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 3 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 4), ';', -1) ELSE '' END AS eng4,
            CASE WHEN LENGTH(wo_list_engineer) - LENGTH(REPLACE(wo_list_engineer, ';', '')) >= 4 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(wo_list_engineer, ';', 5), ';', -1) ELSE '' END AS eng5,
            '' as spcode,'' as spm_desc,'0' as spc_cost,'0' as req,'0' as wd_sp_whtf,'0' as wd_sp_issued ")
            // ->where('wo_nbr','=','PM-23-004839')
            ->whereNotIn('wo_number', function($q){
                $q->select('wd_sp_wonumber')->from('wo_dets_sp');
            })
            ->leftJoin('asset_mstr','asset_code','=','wo_asset_code')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->whereNull('wo_sp_code');

        if($wonbr) {
            $datadet = $datadet->where('wo_number','=',$wonbr);
            $datawo = $datawo->where('wo_number','=',$wonbr);
            $dataspg = $dataspg->where('wo_number','=',$wonbr);
        }
        if($sasset) {
            $datadet = $datadet->where('wo_asset_code','=',$sasset);
            $datawo = $datawo->where('wo_asset_code','=',$sasset);
            $dataspg = $dataspg->where('wo_asset_code','=',$sasset);
        }
        if($dept) {
            $datadet = $datadet->where('wo_department','=',$dept);
            $datawo = $datawo->where('wo_department','=',$dept);
            $dataspg = $dataspg->where('wo_department','=',$dept);
        }
        if($type) {
            $datadet = $datadet->where('wo_type','=',$type);
            $datawo = $datawo->where('wo_type','=',$type);
            $dataspg = $dataspg->where('wo_type','=',$type);
        }
        if($loc) {
            $datadet = $datadet->where('wo_location','=',$loc);
            $datawo = $datawo->where('wo_location','=',$loc);
            $dataspg = $dataspg->where('wo_location','=',$loc);
        }
        // if($eng) {
        //     $datadet = $datadet->where('wo_list_engineer','like','%'.$eng.'%');
        //     $datawo = $datawo->where('wo_list_engineer','like','%'.$eng.'%');
        //     $dataspg = $dataspg->where('wo_list_engineer','like','%'.$eng.'%');
        // }
        if($per1) {
            /* $per1 = $per1.' 00:00:00';
            $per2 = $per2.' 23:59:59'; */
            $datadet = $datadet->whereBetween('wo_system_create',[$per1,$per2]);
            $datawo = $datawo->whereBetween('wo_system_create',[$per1,$per2]);
            $dataspg = $dataspg->whereBetween('wo_system_create',[$per1,$per2]);
        } 

        $data = $datadet->union($datawo)->union($dataspg)
            ->orderby('wo_start_date','desc')
            ->orderBy('wo_number','desc');

        return $data;
    }

    public function headings(): array
    {
        return ['Work Order Number','WO Date','WO Start Date', 'WO Finish Date', 'Departement','Status','Type',
        'Asset Code','Asset Name','Asset Site','Asset Location Code','Asset Location Desc', 'Note',
        'Engineer 1','Engineer 2','Engineer 3','Engineer 4','Engineer 5',
        'Sparepart','Sparepart Desc','Price','Qty Required','Qty Confirm Whs','Qty Used'];
    }

    
}
