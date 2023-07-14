<?php

namespace App\Http\Controllers\Routine;

use App\Http\Controllers\Controller;
use App\Jobs\SendAlertRoutineCheck;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RoutineCheckController extends Controller
{
    //

    public function myroutinebrowse(){

        $username = Session::get('username');

        if(Session::get('role') == 'ADMIN' || Session::get('role') == 'SPVSR'){
            $dataroutinebrowse = DB::table('rcm_activity_log')
            ->leftJoin('asset_mstr', 'asset_mstr.asset_code', 'rcm_activity_log.ra_asset_code')
            ->select('rcm_activity_log.id as id', 'ra_asset_code', 'asset_desc', 'ra_qcs_code', 'ra_qcs_desc', 'ra_schedule_time', 'ra_already_check')
            ->where('ra_already_check', '=', 0)
            ->orderBy('ra_schedule_time', 'asc')
            ->get();
        }else{
            $dataroutinebrowse = DB::table('rcm_activity_log')
            ->leftJoin('asset_mstr', 'asset_mstr.asset_code', 'rcm_activity_log.ra_asset_code')
            ->select('rcm_activity_log.id as id', 'ra_asset_code', 'asset_desc', 'ra_qcs_code', 'ra_qcs_desc', 'ra_schedule_time', 'ra_already_check')
            ->where('ra_already_check', '=', 0)
            ->where(function ($query) use ($username) {
                $query->where('ra_eng_list', '=', $username . ';')
                    ->orWhere('ra_eng_list', 'LIKE', $username . ';%')
                    ->orWhere('ra_eng_list', 'LIKE', '%;' . $username . ';%')
                    ->orWhere('ra_eng_list', 'LIKE', '%;' . $username)
                    ->orWhere('ra_eng_list', '=', $username);
            })
            ->orderBy('ra_schedule_time', 'asc')
            ->get();
        }

        

        return view('routine-check.routine-browse',['datasroutine' => $dataroutinebrowse]);
    }

    public function routincheckdetail($id){
        
        $get_rcm_activity = DB::table('rcm_activity_log')
                            ->where('id','=', $id)
                            ->first();


        $qcsdatas_det = DB::table('qcs_list')
                        ->where('qcs_code','=', $get_rcm_activity->ra_qcs_code)
                        ->get();


        $lastchecktime = DB::table('rcm_activity_log')
                            ->where('ra_asset_code','=', $get_rcm_activity->ra_asset_code)
                            ->where('ra_qcs_code','=', $get_rcm_activity->ra_qcs_code)
                            ->where('ra_already_check','=', 1)
                            ->orderBy('ra_actual_check_time','desc')
                            ->first();

        return view('routine-check.routine-detail', ['qcsdata_det'=> $qcsdatas_det,'lastchecktime' => $lastchecktime, 'rcm_activity' =>$get_rcm_activity]);

    }

    public function routinesubmit(Request $req){
        // dd($req->all());

        /* ============= note ===================
            ra_alert_status == 0 artinya tidak ada kirim alert
            ra_already_check == 0 artinya belom dicek

        */

        DB::beginTransaction();
        try {

            if($req->btnconf == 1) { //jika confirm

                foreach($req->qc_code as $datasrcm => $value){

                    DB::table('rcm_activity_detail')
                    ->insert([
                        'ra_activity_id' => $req->rcm_activity_id,
                        'ra_det_qcscode' => $value,
                        'ra_det_qcsdesc' => $req->qc_desc[$datasrcm],
                        'ra_det_qcsspec' => $req->qc_spec[$datasrcm],
                        'ra_det_result1' => $req->qc_result1[$datasrcm],
                        'ra_det_note' => $req->qc_note[$datasrcm],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                
                }

                //update table rcm_activity_log

                DB::table('rcm_activity_log')
                    ->where('id', '=', $req->rcm_activity_id)
                    ->update([
                        'ra_eng_check' => Session::get('username'),
                        'ra_actual_check_time' => Carbon::now(),
                        'ra_already_check' => 1,
                        'updated_at' => Carbon::now(),
                    ]);

            } elseif ($req->btnconf == 2) { //jika confirm dan send alert
                foreach($req->qc_code as $datasrcm => $value){

                    DB::table('rcm_activity_detail')
                    ->insert([
                        'ra_activity_id' => $req->rcm_activity_id,
                        'ra_det_qcscode' => $value,
                        'ra_det_qcsdesc' => $req->qc_desc[$datasrcm],
                        'ra_det_qcsspec' => $req->qc_spec[$datasrcm],
                        'ra_det_result1' => $req->qc_result1[$datasrcm],
                        'ra_det_note' => $req->qc_note[$datasrcm],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                
                }

                //update table rcm_activity_log

                DB::table('rcm_activity_log')
                    ->where('id', '=', $req->rcm_activity_id)
                    ->update([
                        'ra_eng_check' => Session::get('username'),
                        'ra_actual_check_time' => Carbon::now(),
                        'ra_alert_status' => 1,
                        'ra_already_check' => 1,
                        'updated_at' => Carbon::now(),
                    ]);

                $datasendalert = DB::table('rcm_activity_detail')
                                ->where('ra_activity_id','=', $req->rcm_activity_id)
                                ->get();

                $datarcm = DB::table('rcm_activity_log')
                                ->join('asset_mstr','asset_mstr.asset_code','rcm_activity_log.ra_asset_code')
                                ->where('rcm_activity_log.id','=', $req->rcm_activity_id)
                                ->first();

                // dd($datarcm);

                SendAlertRoutineCheck::dispatch($datasendalert,$datarcm);
            }



            DB::commit();
            toast('Routine successfuly checked', 'success')->persistent('Dismiss');
            return redirect()->route('myroutine');

        } catch (Exception $err) {
            dd($err);   
            DB::rollBack();
            toast('Submit Error, please contact Administrator', 'error');
            return redirect()->back();

        }
    }
}
