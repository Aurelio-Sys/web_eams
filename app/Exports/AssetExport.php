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

        $data =  DB::table('asset_mstr')
        ->selectRaw("asset_code,asset_desc,asset_active,asset_um,asset_type,astype_desc,asset_group,asgroup_desc,
            asset_site,asset_loc,asloc_desc,asset_sn,
            asset_accounting,asset_supp,asset_prcdate,asset_prcprice,asset_note")
        ->leftjoin('asset_type','astype_code','=','asset_type')
        ->leftjoin('asset_group','asgroup_code','=','asset_group')
        ->leftjoin('asset_loc','asloc_code','=','asset_loc')
        // ->leftJoin('temp_repair','temp_asset','=','asset_code')
        // ->whereRaw($kondisi)
        ->orderby('asset_code');

        if($this->sasset) {
            $sasset = $this->sasset;
            $data = $data->where(function($query) use ($sasset) {
                $query->where('asset_code','like','%'.$sasset.'%')
                ->orwhere('asset_desc','like','%'.$sasset.'%');
            });
        }
        if($this->sloc) {
            $sloc = $this->sloc;
            $data = $data->where(function($query) use ($sloc) {
                $query->where('asloc_code','like','%'.$sloc.'%')
                ->orwhere('asloc_desc','like','%'.$sloc.'%');
            });
        }
        if($this->stype) {
            $stype = $this->stype;
            $data = $data->where(function($query) use ($stype) {
                $query->where('astype_code','like','%'.$stype.'%')
                ->orwhere('astype_desc','like','%'.$stype.'%');
            });
        }
        if($this->sgroup) {
            $sgroup = $this->sgroup;
            $data = $data->where(function($query) use ($sgroup) {
                $query->where('asgroup_code','like','%'.$sgroup.'%')
                ->orwhere('asgroup_desc','like','%'.$sgroup.'%');
            });
        }

        return $data;
        
    }
    public function headings(): array
    {
        return ['Asset Code', 'Asset Desc','Active','Um', 'Type','Type Desc', 'Group','Group Desc',
            'Site', 'Location','Loc Desc', 'Serial Number',
            'Asset QAD', 'Supplier','Purchase Date','Purchase Price','Note']; 
    }

    
}
