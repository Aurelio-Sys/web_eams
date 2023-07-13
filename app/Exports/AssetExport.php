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
class AssetExport implements FromQuery, WithHeadings, ShouldAutoSize,WithStyles
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
    function __construct($sasset,$sloc,$stype,$sgroup) {
        $this->sasset    = $sasset;
        $this->sloc   = $sloc;
        $this->stype  = $stype;
        $this->sgroup = $sgroup;
    }
    public function query()
    {
        $kondisi = 'asset_mstr.id > 0';

        if($this->sasset != null ||$this->sasset != '' ){
            $kondisi .= " and asset_code = '".$this->sasset."'";
        }
        if($this->sloc != null ||$this->sloc != '' ){
            $explloc = explode(".",$this->sloc);
            $esite = $explloc[0];
            $eloc = $explloc[1];
            $kondisi .= " and asset_site = '".$esite."' and asset_loc = '".$eloc."'";
        }
        if($this->stype != null ||$this->stype != '' ){
            $kondisi .= " and asset_type = '".$this->stype."'";
        }
        if($this->sgroup != null ||$this->sgroup != '' ){
            $kondisi .= " and asset_group = '".$this->sgroup."'";
        }
        
        /* Mencari deskripsi repair */
        // $dataasset = DB::table('asset_mstr')
        //     ->whereNotNull('asset_repair_type')
        //     ->orWhere('asset_repair_type','<>','')
        //     ->get();

        // DB::statement("CREATE TEMPORARY TABLE temp_repair (id INT(11) PRIMARY KEY AUTO_INCREMENT, temp_asset VARCHAR(255), temp_rep VARCHAR(255))");

        // foreach($dataasset as $da) {
        //     if($da->asset_repair_type == 'code') {
        //         $explrep = explode(",",$da->asset_repair);
        //         foreach($explrep as $ep){
        //             $descrep = Db::table('rep_master')
        //                 ->whereRepm_code($ep)
        //                 ->first();
        //             if(isset($repair)){
        //                 $repair = $repair . "," . $descrep->repm_desc;
        //             } else {
        //                 $repair = $descrep->repm_desc;
        //             }
        //         }
        //     } elseif ($da->asset_repair_type == 'group') {
        //         $descrep = Db::table('xxrepgroup_mstr')
        //             ->whereXxrepgroup_nbr($da->asset_repair)
        //             ->first();
        //         $repair = $descrep->xxrepgroup_desc;
        //     } else {
        //         $repair = '-';
        //     }

        //     DB::table('temp_repair')->insert([
        //         'temp_asset' => $da->asset_code,
        //         'temp_rep' => $repair,
        //     ]);
        // }

        $data =  DB::table('asset_mstr')
        ->selectRaw("asset_code,asset_desc,asset_active,asset_um,asset_type,astype_desc,asset_group,asgroup_desc,
            asset_site,asset_loc,asloc_desc,asset_sn,
            asset_accounting,asset_supp,asset_prcdate,asset_prcprice,asset_note")
        ->leftjoin('asset_type','astype_code','=','asset_type')
        ->leftjoin('asset_group','asgroup_code','=','asset_group')
        ->leftjoin('asset_loc','asloc_code','=','asset_loc')
        // ->leftJoin('temp_repair','temp_asset','=','asset_code')
        ->whereRaw($kondisi)
        ->orderby('asset_code');

        return $data;
        
    }
    public function headings(): array
    {
        return ['Asset Code', 'Asset Desc','Active','Um', 'Type','Type Desc', 'Group','Group Desc',
            'Site', 'Location','Loc Desc', 'Serial Number',
            'Asset QAD', 'Supplier','Purchase Date','Purchase Price','Note']; 
    }

    
}
