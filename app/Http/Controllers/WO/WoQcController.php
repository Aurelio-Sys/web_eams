<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WoQcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $dataApproval = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->leftJoin('asset_loc','asloc_code','asset_loc')
            ->where('wo_status', '=', 'QC Approval')
            ->orderBy('wo_updated_at');

        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        if ($request->s_nomorwo) {
            $dataApproval->where('wo_nbr', '=', $request->s_nomorwo);
        }

        if ($request->s_asset) {
            $dataApproval->where('asset_code', '=', $request->s_asset);
        }

        if ($request->s_priority) {
            $dataApproval->where('wo_priority', '=', $request->s_priority);
        }

        $dataApproval = $dataApproval->paginate(10);


        return view('workorder.woqcappr', compact('dataApproval','asset1'));
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
    public function show($id, $nbr)
    {
        //

        $dataDetail = DB::table('wo_mstr')
            ->selectRaw('asset_mstr.asset_desc,u1.eng_desc as u1,u2.eng_desc as u2, u3.eng_desc as u3, u4.eng_desc as u4,
                        u5.eng_desc as u5, wo_mstr.*, asset_loc.*,
                        wo_mstr.wo_failure_code1 as wofc1, wo_mstr.wo_failure_code2 as wofc2, 
                        wo_mstr.wo_failure_code3 as wofc3, fn1.fn_desc as fd1, fn2.fn_desc as fd2, 
                        fn3.fn_desc as fd3,r1.repm_desc as r11,r2.repm_desc as r22,r3.repm_desc as r33,
                        r1.repm_code as rr11,r2.repm_code as rr22,r3.repm_code as rr33,wotyp_desc')
            ->join('asset_mstr', 'wo_mstr.wo_asset', 'asset_mstr.asset_code')
            ->leftjoin('eng_mstr as u1', 'wo_mstr.wo_engineer1', 'u1.eng_code')
            ->leftjoin('eng_mstr as u2', 'wo_mstr.wo_engineer2', 'u2.eng_code')
            ->leftjoin('eng_mstr as u3', 'wo_mstr.wo_engineer3', 'u3.eng_code')
            ->leftjoin('eng_mstr as u4', 'wo_mstr.wo_engineer4', 'u4.eng_code')
            ->leftjoin('eng_mstr as u5', 'wo_mstr.wo_engineer5', 'u5.eng_code')
            ->leftjoin('asset_type', 'asset_mstr.asset_type', 'asset_type.astype_code')
            ->leftjoin('asset_loc', 'asset_mstr.asset_loc', 'asset_loc.asloc_code')
            ->leftjoin('fn_mstr as fn1', 'wo_mstr.wo_failure_code1', 'fn1.fn_code')
            ->leftjoin('fn_mstr as fn2', 'wo_mstr.wo_failure_code2', 'fn2.fn_code')
            ->leftjoin('fn_mstr as fn3', 'wo_mstr.wo_failure_code3', 'fn3.fn_code')
            ->leftjoin('rep_master as r1', 'wo_mstr.wo_repair_code1', 'r1.repm_code')
            ->leftjoin('rep_master as r2', 'wo_mstr.wo_repair_code2', 'r2.repm_code')
            ->leftjoin('rep_master as r3', 'wo_mstr.wo_repair_code3', 'r3.repm_code')
            ->leftJoin('dept_mstr', 'wo_mstr.wo_dept', 'dept_mstr.dept_code')
            ->leftJoin('wotyp_mstr', 'wo_mstr.wo_new_type', 'wotyp_mstr.wotyp_code')
            ->leftjoin('xxrepgroup_mstr', 'xxrepgroup_mstr.xxrepgroup_nbr', 'wo_mstr.wo_repair_group')
            ->where('wo_id', $id)
            ->where('wo_nbr', $nbr)
            ->first();

        // dd($dataDetail);

        return view('workorder.woqcappr-detail', compact('dataDetail'));
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
    public function update(Request $req)
    {
        //
        // dd($req->all());

        DB::beginTransaction();

        try{

            if($req->submit == 'approve'){

                DB::table('wo_mstr')
                    ->where('wo_id', $req->woid)
                    ->where('wo_nbr', $req->wonumber)
                    ->update([
                        'wo_qc_appnote' => $req->qcnote,
                        'wo_status' => 'closed',
                        'wo_qc_approver' => Session::get('username'),
                        'wo_qc_appdate' => Carbon::now()->toDateTimeString(),
                        'wo_qc_status' => 'approved',
                        'wo_updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

                if($req->srnumber !== '-'){
                    DB::table('service_req_mstr')
                        ->where('sr_number', $req->srnumber)
                        ->where('wo_number', $req->wonumber)
                        ->update([
                            'sr_status' => 5,
                            'sr_updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }

                DB::commit();
                toast('WO : '.$req->wonumber.' QC successfully approved', 'success');
                return redirect()->route('woQCIndex');
            }else{
                
                DB::table('wo_mstr')
                    ->where('wo_id', $req->woid)
                    ->where('wo_nbr', $req->wonumber)
                    ->update([
                        'wo_qc_appnote' => $req->qcnote,
                        'wo_status' => 'closed',
                        'wo_qc_approver' => Session::get('username'),
                        'wo_qc_appdate' => Carbon::now()->toDateTimeString(),
                        'wo_qc_status' => 'rejected',
                        'wo_updated_at' => Carbon::now()->toDateTimeString(),
                    ]);

                if($req->srnumber !== '-'){
                    DB::table('service_req_mstr')
                        ->where('sr_number', $req->srnumber)
                        ->where('wo_number', $req->wonumber)
                        ->update([
                            'sr_status' => 5,
                            'sr_updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }

                DB::commit();
                toast('WO : '.$req->wonumber.' QC  successfully rejected', 'success');
                return redirect()->route('woQCIndex');

            }

        } catch (Exception $err) {

            DB::rollBack();
            toast('Approve/Reject Error', 'error');
            return redirect()->route('woQCIndex');

        }

        
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
