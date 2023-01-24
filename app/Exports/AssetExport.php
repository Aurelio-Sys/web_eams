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
    function __construct() {
        // $this->wonbr    = $wonbr;
        // $this->status   = $status;
        // $this->asset    = $asset;
        // $this->priority = $priority;
        // $this->period   = $period;
        // $this->creator  = $creator;
        // $this->engineer = $engineer;
        // dd($this->stats);
        // dd($wonbr,$status,$asset,$priority,$period);
    }
    public function query()
    {
        $kondisi = 'asset_mstr.id > 0';
        // // $wonbr = new Array();
        // if($this->wonbr != null ||$this->wonbr != '' ){
        //     $kondisi .= "and wo_nbr = '".$this->wonbr."'";
        // }

        // dd($kondisi);
        
        /* Mencari deskripsi repair */
        $dataasset = DB::table('asset_mstr')
            ->whereNotNull('asset_repair_type')
            ->orWhere('asset_repair_type','<>','')
            ->get();

        // Schema::dropIfExists('temp_repair');

        Schema::create('temp_repair', function($table){
            $table->increments('id');
            $table->string('temp_asset');
            $table->string('temp_rep')->nullable();
        });

        foreach($dataasset as $da) {
            if($da->asset_repair_type == 'code') {
                $repair = 'code';
            } elseif ($da->asset_repair_type == 'group') {
                $repair = 'group';
            } else {
                $repair = '-';
            }

            DB::table('temp_repair')->insert([
                'temp_asset' => $da->asset_code,
                'temp_rep' => $repair,
            ]);
        }

        $data =  DB::table('asset_mstr')
        ->selectRaw("asset_code,asset_desc,asset_active,asset_um,asset_type,astype_desc,asset_group,asgroup_desc,
            asset_site,asset_loc,asloc_desc,asset_sn,
            asset_qad,asset_supp,asset_prc_date,asset_prc_price,asset_note,
            CASE WHEN asset_measure = 'C' THEN 'Calendar' WHEN asset_measure = 'M' THEN 'Meter' ELSE '-' END as 'mea',
            CASE WHEN asset_measure = 'C' THEN asset_cal WHEN asset_measure = 'M' THEN asset_meter ELSE '-' END as 'cal',
            asset_tolerance,'UM',asset_start_mea,
            asset_repair,asset_repair_type,asset_last_usage, asset_last_usage_mtc,asset_last_mtc")
        ->leftjoin('asset_type','astype_code','=','asset_type')
        ->leftjoin('asset_group','asgroup_code','=','asset_group')
        ->leftjoin('asset_loc','asloc_code','=','asset_loc')
        ->leftJoin('temp_repair','temp_asset','=','asset_code')
        ->whereRaw($kondisi)
        ->orderby('asset_code');

        Schema::dropIfExists('temp_repair');

        return $data;
        
    }
    public function headings(): array
    {
        return ['Asset Code', 'Asset Desc','Active','Um', 'Type','Type Desc', 'Group','Group Desc',
            'Site', 'Location','Loc Desc', 'Serial Number',
            'Asset QAD', 'Supplier','Purchase Date','Purchase Price','Note',
            'Measurement',
            'Value',
            'Mea Tolerance','Mea Um','Mea Start Date',
            'Repair','Engineer','Last Usage','Last Usage Maintenance','Last Maintenance']; 
    }

    
}
