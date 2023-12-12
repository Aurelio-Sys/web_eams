<?php
namespace App\Http\Controllers\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
class StartnotifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        /** Notifaksi untuk pembuat SR jika ada SR yang perlu di revisi */
        $datasr = DB::table('service_req_mstr')
            ->where('sr_status', '=', 'Revise');
        /** Notifikasi untuk SPV Eng jika ada permintaan approval */
        $datasrappeng = DB::table('sr_trans_approval_eng')
            ->where('srta_eng_status', '=', 'Waiting for engineer approval');

        /** Notifaksi untuk pembuat SR jika ada SR yang perlu di revisi */
        // $dataaccep = DB::table('service_req_mstr')
        //     ->where('sr_status', '=', 'acceptance');
        $dataaccep = DB::table('wo_mstr')	// lihat dari menu user acceptance, datanya berdasarkan wo bukan sr
            ->where('wo_status', '=', 'acceptance');

        /** Notifkasi untuk teknisi yang mendapatkan WO */
        $datawostart = DB::table('wo_mstr')
            ->where('wo_status', 'released');
     
        /** Notifikasi untuk aprroval WO Release */
        $dataapprels = DB::table('release_trans_approval')
            ->select(DB::raw('COUNT(*)'))
            ->from(function ($subquery) {
                $subquery->from('release_trans_approval')
                    ->where('retr_status', '=', 'waiting for approval')
                    ->groupBy('retr_mstr_id');
            }, 'subquery');
        /** Notifikasi untuk WO Transafer */
        $datawotrans = DB::table('wo_mstr')
            // ->select(DB::raw('count(*) as jmlwotrans'))
            ->join('release_trans_approval', function ($join) {
                $join->on('release_trans_approval.retr_mstr_id', '=', 'wo_mstr.id')
                    ->where('release_trans_approval.retr_status', '=', 'approved');
            })
            ->where(function ($status) {
                $status->where('wo_status', '=', 'released');
                $status->orWhere('wo_status', '=', 'started');
            })
            ->count();
        /** Notifkasi untuk Wo yang bisa dikerjakan */
        $datawofirm = DB::table('wo_mstr')
            ->where('wo_status', 'firm');
        /** Notifkasi untuk WO Reporting */
        $datawofinish = DB::table('wo_mstr')
            ->where('wo_status', 'started');
        /** Notifikasi untuk approval WO Finish */
        $dataappwo = DB::table('wo_trans_approval')
            ->where('wotr_status', 'waiting for approval');
        /** Notifikasi untuk Request Sparepart yang harus melakukan revisi */
        $datareqsprev = DB::table('reqsp_trans_approval')
            ->join('req_sparepart', 'reqsp_trans_approval.rqtr_mstr_id', '=', 'req_sparepart.id')
            ->where('rqtr_status', 'revision');
        
        /** Notifikasi untuk Request Sparepart */
        $datareqspapp = DB::table('reqsp_trans_approval')
            ->select(DB::raw('COUNT(*)'))
            ->from(function ($subquery) {
                $subquery->from('reqsp_trans_approval')
                    ->where('rqtr_status', '=', 'waiting for approval')
                    ->groupBy('rqtr_mstr_id');
            }, 'subquery');
        /** Notifikasi untuk Warehouse melakukan transfer sparepart */
        $datareqsptrans = DB::table('req_sparepart')
            ->whereIn('req_sp_status', ['partial transferred'])
            ->count();
        
        /** Notofikasi untuk Warehouse melakukan receipt sparepart */
        $dataretsptrans = DB::table('ret_sparepart')
            ->where('ret_sp_status', 'open')
            ->count();
        /** Jika role admin maka akan muncul semuanya, jika yang login SPVSR maka yang muncul dari departemennya, selain itu yang muncul sesuai login */
        switch (Session::get('role')) {
            case "ADMIN":
                $datasr = $datasr->count();
                $datasrappeng = $datasrappeng->count();
                $dataaccep = $dataaccep->count();
                $datawofirm = $datawofirm->count();
                $dataapprels = $dataapprels->count();
                $datawostart = $datawostart->count();
                $datawofinish = $datawofinish->count();
                $dataappwo = $dataappwo->count();
                $datareqsprev = $datareqsprev->count();
                $datareqspapp = $datareqspapp->count();
                break;
            case "SPVSR":
                $datasr = $datasr->where('sr_dept','=',Session::get('department'))->count();
                $datasrappeng = $datasrappeng->where('srta_eng_dept_approval','=',Session::get('department'))->count();
                $dataaccep = $dataaccep->where('sr_dept','=',Session::get('department'))->count();
                $datawofirm = $datawofirm->where('wo_department','=',Session::get('department'))->count();
                $dataapprels = $dataapprels->where('retr_dept_approval','=',Session::get('department'))->count();
                $datawostart = $datawostart->where('wo_department','=',Session::get('department'))->count();
                $datawofinish = $datawofinish->where('wo_department','=',Session::get('department'))->count();
                $dataappwo = $dataappwo->where('wotr_dept_approval','=',Session::get('department'))->count();
                $datareqsprev = $datareqsprev->where('rqtr_dept_approval','=',Session::get('department'))->count();
                $datareqspapp = $datareqspapp->where('rqtr_dept_approval','=',Session::get('department'))->count();
                break;
            default:
                $datasr = $datasr->where('sr_req_by','=',Session::get('username'))->count();
                $datasrappeng = $datasrappeng->where('srta_eng_dept_approval','=',Session::get('department'))->count();
                $dataaccep = $dataaccep->where('sr_req_by','=',Session::get('username'))->count();
                $datawofirm = $datawofirm->where('wo_list_engineer','like','%'.Session::get('username').'%')->count();
                $dataapprels = $dataapprels->where('retr_dept_approval','=',Session::get('department'))->count();
                $datawostart = $datawostart->where('wo_list_engineer','like','%'.Session::get('username').'%')->count();
                $datawofinish = $datawofinish->where('wo_list_engineer','like','%'.Session::get('username').'%')->count();
                $dataappwo = $dataappwo->where('wotr_dept_approval','=',Session::get('department'))->count();
                $datareqsprev = $datareqsprev->where('req_sp_requested_by','like','%'.Session::get('username').'%')->count();
                $datareqspapp = $datareqspapp->where('rqtr_dept_approval','=',Session::get('department'))->count();
        }
        
        return view('report.startnotif', compact('datasr','datasrappeng','dataaccep','dataapprels','datawotrans',
            'dataappwo','datareqsprev','datareqspapp','datareqsptrans','dataretsptrans','datawofirm','datawostart','datawofinish'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}