<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportSRBrowse implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles
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

    protected $srnbr;
    protected $asset;
    protected $status;
    protected $datefrom;
    protected $dateto;
    protected $reqby;

    function __construct($srnbr, $status, $asset, $reqby, $datefrom, $dateto)
    {
        $this->srnbr    = $srnbr;
        $this->status   = $status;
        $this->asset    = $asset;
        $this->reqby    = $reqby;
        $this->datefrom = $datefrom;
        $this->dateto   = $dateto;
    }

    public function query()
    {

        $xsrnbr    = $this->srnbr;
        $asset     = $this->asset;
        $status    = $this->status;
        $reqby     = $this->reqby;
        $datefrom  = $this->datefrom;
        $dateto    = $this->dateto;

        $kondisi = "service_req_mstr.id > 0";

        $data = DB::table('service_req_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
            ->leftjoin('asset_type', 'asset_type.astype_code', 'asset_mstr.asset_type')
            ->leftjoin('loc_mstr', 'loc_mstr.loc_code', 'asset_mstr.asset_loc')
            ->leftjoin('wotyp_mstr', 'wotyp_mstr.wotyp_code', 'service_req_mstr.sr_fail_type')
            ->join('users', 'users.username', 'service_req_mstr.sr_req_by')  //B211014
            ->join('dept_mstr', 'dept_mstr.dept_code', 'service_req_mstr.sr_dept')
            ->leftjoin('wo_mstr', 'wo_mstr.wo_number', 'service_req_mstr.wo_number')
            ->leftjoin('sr_trans_approval', 'sr_trans_approval.srta_mstr_id', 'service_req_mstr.id')
            ->leftjoin('sr_trans_approval_eng', 'sr_trans_approval_eng.srta_eng_mstr_id', 'service_req_mstr.id')
            ->leftjoin('eng_mstr', 'eng_mstr.eng_dept', 'service_req_mstr.sr_eng_approver')
            ->leftjoin('dept_mstr as u1', 'eng_mstr.eng_dept', 'u1.dept_code')
            ->selectRaw('sr_number, service_req_mstr.wo_number, sr_asset, asset_desc, sr_dept, asset_loc, 
            sr_status, sr_req_by, sr_req_date, sr_req_time, sr_fail_type, sr_fail_code, 
            sr_impact, sr_priority, sr_note, sr_eng_approver, service_req_mstr.created_at')
            ->whereRaw($kondisi)
            ->orderBy('sr_number', 'DESC')
            ->groupBy('sr_number');

        /* Jika bukan admin, maka yang muncul adalah approver sesuai login */
        // if (Session::get('role') <> 'ADMIN') {
        //     $data = $data->where('sr_dept', '=', session::get('department'));
        // }

        $data->when(isset($xsrnbr), function ($q) use ($xsrnbr) {
            $q->where('sr_number', 'like', '%' . $xsrnbr . '%');
        });

        $data->when(isset($status), function ($q) use ($status) {
            $q->where('sr_status', $status);
        });

        $data->when(isset($asset), function ($q) use ($asset) {
            $q->where('asset_desc', 'like', '%' .  $asset . '%');
        });

        $data->when(isset($reqby), function ($q) use ($reqby) {
            $q->where('sr_req_by', $reqby);
        });

        $data->when(isset($datefrom, $dateto), function ($q) use ($datefrom, $dateto) {
            $q->whereBetween('sr_req_date', [$datefrom, $dateto]);
        });

        return $data;

        // dd($data);
    }

    public function headings(): array
    {
        return [
            'Service Request Number', 'Wo Number', 'Asset Code', 'Asset Description', 'Department', 'Asset Location', 'Status',
            'Requested By', 'Requested Date', 'Requested Time', 'Failure Type', 'Failure Code', 'Impact', 'Priority', 'Note', 'Engineer Approver', 'Created At'
        ];
    }
}
