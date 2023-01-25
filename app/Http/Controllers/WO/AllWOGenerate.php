<?php

namespace App\Http\Controllers\WO;

use App\Exports\GenerateWOExport;
use App\Http\Controllers\Controller;
use App\Jobs\EmailWOGen;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class AllWOGenerate extends Controller
{
    //
    public function viewWoGenerator()
    {
        return view('workorder.wogenerator-view');
    }


    public function getAll(Request $req)
    {

        // dd($req->all());
        $todaydate = Carbon::now()->toDateTime()->format("Y-m-d");

        $fromdate = date_create($todaydate);
        $todate = date_create($req->todate);
        

        // $todate = number_format($req->day / 30, 1);

        // perhitungan : tanggal seharusnya - tolerance

        $table_asset = DB::table('asset_mstr')
                        ->where('asset_measure', '=', 'C')
                        ->get();

        $arrayTemp = [];

        foreach($table_asset as $tbl_asset){

            $getWoExisting = DB::table('wo_mstr')
                            ->select('wo_asset','wo_schedule')
                            ->where('wo_type','=','auto') // auto = preventive,other = non-preventive
                            ->where('wo_status','=','plan') // status plan = wo baru dibuat, belom dikerjakan
                            ->where('wo_asset','=',$tbl_asset->asset_code)
                            ->orderBy('wo_schedule','desc')
                            ->first();

            if(is_null($getWoExisting)){
                //jika belom ada wo pm untuk asset tersebut
                $interval = date_diff($todate, date_create($tbl_asset->asset_last_mtc),true);
                $this_diff_time =  $interval->format('%a');
                $loopingnumber = (int) $this_diff_time;

                $mtc_totaltime = floor($loopingnumber/$tbl_asset->asset_cal);

                //data awal jadi patokan perhitungan looping berikutnya;
                $next_mtc = date_add(date_create($tbl_asset->asset_last_mtc), date_interval_create_from_date_string(''.$tbl_asset->asset_cal.' days'));
            }else{
                //jika suda ada wo pm untuk asset tersebut
                $interval = date_diff($todate, date_create($getWoExisting->wo_schedule),true);
                $this_diff_time =  $interval->format('%a');
                $loopingnumber = (int) $this_diff_time;

                $mtc_totaltime = floor($loopingnumber/$tbl_asset->asset_cal);

                //data awal jadi patokan perhitungan looping berikutnya;
                $next_mtc = date_add(date_create($getWoExisting->wo_schedule), date_interval_create_from_date_string(''.$tbl_asset->asset_cal.' days'));
            }

            // dd($tbl_asset->asset_last_mtc,$next_mtc);

            if($next_mtc >= $fromdate && $next_mtc <= $todate) {
                $next_mtc = $next_mtc->format('Y-m-d');

                array_push($arrayTemp,[
                    'asset_code' => $tbl_asset->asset_code,
                    'next_woschedule' => $next_mtc,
                    'asset_cal_measure' => $tbl_asset->asset_cal,
                ]);

                //looping per asset berapa kali maintenance dalam range tanggal yang dipilih
                for($i = 0; $i < $mtc_totaltime-1; $i++){
                    $data = collect($arrayTemp);
                    $data = $data->where('asset_code',$tbl_asset->asset_code)->sortByDesc(function($item) {
                        return $item['next_woschedule'];
                    })->first();
                    $next_mtc_looping = date_add(date_create($data['next_woschedule']), date_interval_create_from_date_string(''.$tbl_asset->asset_cal.' days'));

                    if($next_mtc_looping >= $fromdate && $next_mtc_looping <= $todate) {
                        $next_mtc_looping = $next_mtc_looping->format('Y-m-d');
                        array_push($arrayTemp,[
                            'asset_code' => $tbl_asset->asset_code,
                            'next_woschedule' => $next_mtc_looping,
                            'asset_cal_measure' => $tbl_asset->asset_cal,
                        ]);
                    }
                }
            }
        }

        // $arrayTemp sudah berisi next maintenance setiap asset dalam range tanggal yang dipilih
        $data = collect($arrayTemp);

        DB::beginTransaction();

        try {

            if ($data->count() > 0) {

                // Schema::dropIfExists('temp_womstr');
                // Schema::create('temp_womstr', function ($table) {
                //     $table->string('wo_code');
                //     $table->string('asset_site');
                //     $table->string('asset_loc');
                //     $table->string('asset_code');
                //     $table->string('asset_desc', 250);
                //     $table->date('schedule_date');
                //     $table->date('due_date');
                //     $table->date('generate_at');
                //     $table->temporary();
                // });

                foreach ($data as $showdata) {
                    $getmaster_asset = DB::table('asset_mstr')
                                    ->leftJoin('pm_eng', 'pm_eng.pm_asset','asset_mstr.asset_code')
                                    ->where('asset_code','=', $showdata['asset_code'])
                                    ->first();
                    
                    $pm_eng = $getmaster_asset->pm_engcode;
                    $pm_eng = ltrim($pm_eng,";");

                    $array_englist = explode(";",$pm_eng);

                    $repcode1 = "";
                    $repcode2 = "";
                    $repcode3 = "";
                    $repgroup = "";
                    if ($getmaster_asset->asset_repair_type == 'group') {
                        $repgroup = $getmaster_asset->asset_repair;
                    } else if ($getmaster_asset->asset_repair_type == 'code') {
                        $a = explode(",", $getmaster_asset->asset_repair);

                        $repcode1 = $a[0];
                        if (isset($a[1])) {
                            $repcode2 = $a[1];
                        }
                        if (isset($a[2])) {
                            $repcode3 = $a[2];
                        }
                    } else {
                        $rep = "";
                    }

                    // Bkin WO
                    // $tablern = DB::table('running_mstr')
                    //     ->first();

                    // $tempnewrunnbr = strval(intval($tablern->wt_nbr) + 1);
                    // $newtemprunnbr = '';

                    // if (strlen($tempnewrunnbr) <= 4) {
                    //     $newtemprunnbr = str_pad($tempnewrunnbr, 4, '0', STR_PAD_LEFT);
                    // }

                    // $runningnbr = $tablern->wt_prefix . '-' . $tablern->year . '-' . $newtemprunnbr;

                    // ======================================================================= //

                    $running = DB::table('running_mstr')
                        ->first();

                    $newyear = Carbon::now()->format('y');

                    if ($running->year == $newyear) {
                        $tempnewrunnbr = strval(intval($running->wt_nbr) + 1);

                        $newtemprunnbr = '';
                        if (strlen($tempnewrunnbr) < 6) {
                            $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                        }
                    } else {
                        $newtemprunnbr = "000001";
                    }

                    $runningnbr = $running->wt_prefix . '-' . $newyear . '-' . $newtemprunnbr;

                    $dataarray = array(
                        'wo_nbr' => $runningnbr,
                        'wo_status' => 'plan', //-> A211025
                        // 'wo_status' => 'open',
                        'wo_engineer1' => isset($array_englist[0]) ? $array_englist[0]:'', //A211025
                        'wo_engineer2' => isset($array_englist[1]) ? $array_englist[1]:'', //A211025
                        'wo_engineer3' => isset($array_englist[2]) ? $array_englist[2]:'',
                        'wo_engineer4' => isset($array_englist[3]) ? $array_englist[3]:'',
                        'wo_engineer5' => isset($array_englist[4]) ? $array_englist[4]:'',
                        'wo_priority' => 'high',
                        'wo_repair_type' => $getmaster_asset->asset_repair_type,
                        'wo_repair_group' => $repgroup,
                        'wo_repair_code1' => $repcode1,
                        'wo_repair_code2' => $repcode2,
                        'wo_repair_code3' => $repcode3,
                        'wo_asset' => $getmaster_asset->asset_code,
                        'wo_dept' => 'ENG', // Hardcode
                        'wo_type'  => 'auto', // Hardcode
                        'wo_schedule' => $showdata['next_woschedule'],
                        'wo_duedate' => $showdata['next_woschedule'],
                        'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    );

                    DB::table('wo_mstr')->insert($dataarray);

                    // DB::table('temp_womstr')->insert([
                    //     'wo_code' => $runningnbr,
                    //     'asset_site' => $showdata->asset_site,
                    //     'asset_loc' => $showdata->asset_loc,
                    //     'asset_code' => $showdata->asset_code,
                    //     'asset_desc' => $showdata->asset_desc,
                    //     'schedule_date' => $showdata->next_duedate_mtc,
                    //     'due_date' => date("Y-m-t", strtotime($showdata->next_duedate_mtc)),
                    //     'generate_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    // ]);

                    // DB::table('running_mstr')
                    //     ->update([
                    //         'wt_nbr' => $newtemprunnbr
                    //     ]);

                    DB::table('running_mstr')
                        ->update([
                            'year' => $newyear,
                            'wt_nbr' => $newtemprunnbr,
                        ]);
                    
                }

                // $datatemp = DB::table('temp_womstr')->get();

                // dd($datatemp);

                // Excel::store(new GenerateWOExport($datatemp) , 'temp_excel_wogenerate_'.$todaydate.'.xlsx');

                // Excel::store(new GenerateWOExport($datatemp) , 'temp_excel_wogenerate.xlsx');

                // $pesan = "Berikut adalah list WO yang terbentuk";

                // ini dimatiin dulu EmailWOGen::dispatch(
                //     $pesan,
                // );
            }

            DB::commit();
            toast('Work Order Generated Success', 'success');
            return back();
        } catch (Exception $err) {
            DB::rollBack();

            dd($err);
            toast('Work Order Generated Error, please re-generate again.', 'success');
            return back();
        }
    }
}
