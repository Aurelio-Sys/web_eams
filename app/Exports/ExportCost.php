<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportCost implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles
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

    protected $asset;
    protected $type;
    protected $loc;
    protected $eng;
    protected $bulan;

    function __construct($asset,$type,$loc,$eng,$bulan)
    {
        $this->asset    = $asset;
        $this->type    = $type;
        $this->loc    = $loc;
        $this->eng    = $eng;
        $this->bulan    = $bulan;
    }

    public function query()
    {

        $asset     = $this->asset;
        $type     = $this->type;
        $loc     = $this->loc;
        $eng     = $this->eng;
        $bulan     = $this->bulan;

        $data = DB::table('asset_mstr')
            ->leftJoin('wo_mstr','wo_asset_code','=','asset_code')
            ->leftJoin('wo_dets_sp', 'wd_sp_wonumber', '=', 'wo_number')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
			->leftJoin('sp_cost', function ($join) {
					$join->on('sp_cost.spc_part', '=', 'wo_dets_sp.wd_sp_spcode')
						 ->whereRaw("sp_cost.spc_period = DATE_FORMAT(wo_mstr.wo_job_finishdate, '%y%m')");
				})
            ->select('asset_code','asset_desc','asloc_desc')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 1 THEN wd_sp_issued * spc_cost ELSE 0 END) AS jan')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 2 THEN wd_sp_issued * spc_cost ELSE 0 END) AS feb')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 3 THEN wd_sp_issued * spc_cost ELSE 0 END) AS mar')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 4 THEN wd_sp_issued * spc_cost ELSE 0 END) AS apr')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 5 THEN wd_sp_issued * spc_cost ELSE 0 END) AS may')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 6 THEN wd_sp_issued * spc_cost ELSE 0 END) AS jun')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 7 THEN wd_sp_issued * spc_cost ELSE 0 END) AS jul')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 8 THEN wd_sp_issued * spc_cost ELSE 0 END) AS aug')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 9 THEN wd_sp_issued * spc_cost ELSE 0 END) AS sep')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 10 THEN wd_sp_issued * spc_cost ELSE 0 END) AS oct')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 11 THEN wd_sp_issued * spc_cost ELSE 0 END) AS nov')
            ->selectRaw('SUM(CASE WHEN month(wo_start_date) = 12 THEN wd_sp_issued * spc_cost ELSE 0 END) AS xxx')
            ->whereYear('wo_start_date','=',$bulan)
            ->groupBy('asset_code')
            ->orderBy('asset_code');

        $data->when(isset($asset), function ($q) use ($asset) {
            $q->where('asset_code', '=', $asset);
        });

        $data->when(isset($type), function ($q) use ($type) {
            $q->where('wo_type', '=', $type);
        });

        $data->when(isset($loc), function ($q) use ($loc) {
            $q->where('asset_loc', '=', $loc);
        });

        $data->when(isset($eng), function ($q) use ($eng) {
            $q->where('wo_list_engineer', 'like', '%'.$eng.'%');
        });

        return $data;

        // dd($data);
    }

    public function headings(): array
    {
        return [
            'Asset Code', 'Asset Desc', 'Location' , 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' 
        ];
    }
}
