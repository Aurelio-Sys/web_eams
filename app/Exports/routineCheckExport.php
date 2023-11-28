<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class routineCheckExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    public function __construct($qcspec, $asset, $datefrom, $dateto)
    {
        $this->qcspec = $qcspec;
        $this->asset = $asset;
        $this->datefrom = $datefrom;
        $this->dateto = $dateto;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {


        $qcspec = $this->qcspec;
        $asset = $this->asset;
        $datefrom = $this->datefrom;
        $dateto = $this->dateto;

        $routinedata = DB::table('rcm_activity_log')
            ->leftJoin('rcm_activity_detail', 'rcm_activity_detail.ra_activity_id','rcm_activity_log.id')
            ->leftJoin('asset_mstr', 'asset_mstr.asset_code', 'rcm_activity_log.ra_asset_code')
            ->select('*','rcm_activity_log.id as id','rcm_activity_log.created_at as rcm_create_date');

        $routinedata->when(isset($datefrom) && isset($dateto), function ($q) use ($datefrom, $dateto) {
            // $q->whereBetween('rcm_activity_log.created_at', [$datefrom, $dateto]);
            $q->whereDate('rcm_activity_log.created_at', '>=', $datefrom);
            $q->whereDate('rcm_activity_log.created_at', '<=', $dateto);
        });


        $routinedata->when(isset($qcspec), function ($q) use ($qcspec) {
            $q->where('rcm_activity_log.ra_qcs_code', 'like','%'.$qcspec.'%');
        });

        $routinedata->when(isset($asset), function ($q) use ($asset) {
            $q->where('rcm_activity_log.ra_asset_code', $asset);
        });

        $routinedata = $routinedata->orderBy('rcm_activity_log.created_at', 'asc')->orderBy('rcm_activity_log.ra_schedule_time', 'asc')->get();

        return view('export.routine-check-report',[
            'routinedata' => $routinedata
        ]);
    }
}
