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
        $interval = date_diff($todate, $fromdate, true);
        $this_diff_time =  $interval->format('%a');

        $loopingnumber = (int) $this_diff_time;

        // $todate = number_format($req->day / 30, 1);

        // perhitungan : tanggal seharusnya - tolerance

        $table_asset = DB::table('asset_mstr')
                        ->where('asset_measure', '=', 'C')
                        ->get();

        $arrayTemp = [];

        foreach($table_asset as $tbl_asset){
            $mtc_totaltime = floor($loopingnumber/$tbl_asset->asset_cal);

            //data awal jadi patokan perhitungan looping berikutnya;
            $next_mtc = date_add(date_create($tbl_asset->asset_last_mtc), date_interval_create_from_date_string(''.$tbl_asset->asset_cal.' days'));
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

        dd($arrayTemp);

        
        // dd($next_mtc_looping);
//Kdrn0048
        $data = DB::table('asset_mstr')
            ->selectRaw('asset_mstr.* , DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY) as next_duedate_mtc, 
                    DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY) as persiapan_mtc,
                    DATE_ADD(DATE_FORMAT(NOW(),"%Y-%m-%d"), INTERVAL ' . $this_diff_time . ' DAY) as to_date,
                    DATE_FORMAT(NOW(),"%Y-%m-%d") as from_date') 
                    //interval date untuk to_date akan diganti dengan inputan hari dari depan
            ->where('asset_measure', '=', 'C')
            // ->whereRaw('DATE_ADD(asset_last_mtc, INTERVAL asset_cal DAY) >= date_format(now(),"%Y-%m-%d")')
            ->havingRaw('next_duedate_mtc between from_date and to_date')
            ->orderBy('next_duedate_mtc', 'asc')
            ->get();

        Schema::dropIfExists('temp_datagenerate');
        Schema::create('temp_datagenerate', function ($table) {
            $table->string('asset_code');
            $table->date('asset_last_mtc');
            $table->date('wo_schedule');
            $table->integer('asset_cal');
            $table->temporary();
        });

        

        foreach($data as $dataFirst){
            DB::table('temp_datagenerate')
                ->insert([
                    'asset_code' => $dataFirst->asset_code,
                    'asset_last_mtc' => $dataFirst->asset_last_mtc,
                    'wo_schedule' => $dataFirst->next_duedate_mtc,
                    'asset_cal' => $dataFirst->asset_cal,
                ]);

            array_push($arrayTemp,[
                'asset_code' => $dataFirst->asset_code,
                'asset_last_mtc' => $dataFirst->asset_last_mtc,
                'wo_schedule' => $dataFirst->next_duedate_mtc,
                'asset_cal' => $dataFirst->asset_cal,
            ]);
        }

        $data_2 = DB::table('temp_datagenerate')
            ->selectRaw('*, DATE_ADD(wo_schedule,INTERVAL asset_cal DAY) as next_duedate_mtc, 
                    DATE_ADD(wo_schedule,INTERVAL asset_cal DAY) as persiapan_mtc,
                    DATE_ADD(DATE_FORMAT(NOW(),"%Y-%m-%d"), INTERVAL ' . $this_diff_time . ' DAY) as to_date,
                    DATE_FORMAT(NOW(),"%Y-%m-%d") as from_date') 
            ->havingRaw('next_duedate_mtc between from_date and to_date')
            ->orderBy('next_duedate_mtc', 'asc')
            ->get();

        Schema::dropIfExists('temp_datagenerate');

        array_push($arrayTemp,[
            'asset_code' => $data_2->asset_code,
            'asset_last_mtc' => $data_2->asset_last_mtc,
            'wo_schedule' => $data_2->next_duedate_mtc,
            'asset_cal' => $data_2->asset_cal,
        ]);

        DB::beginTransaction();

        try {

            if ($data->count() > 0) {

                Schema::dropIfExists('temp_womstr');
                Schema::create('temp_womstr', function ($table) {
                    $table->string('wo_code');
                    $table->string('asset_site');
                    $table->string('asset_loc');
                    $table->string('asset_code');
                    $table->string('asset_desc', 250);
                    $table->date('schedule_date');
                    $table->date('due_date');
                    $table->date('generate_at');
                    $table->temporary();
                });

                foreach ($data as $showdata) {
                    $checkwo = DB::table('wo_mstr')
                        ->where('wo_asset', '=', $showdata->asset_code)
                        ->where('wo_dept', '=', 'ENG')
                        ->where('wo_type', '=', 'auto')
                        ->where('wo_schedule', '=', $showdata->next_duedate_mtc)
                        ->first();

                    if ($checkwo == null) {

                        $repcode1 = "";
                        $repcode2 = "";
                        $repcode3 = "";
                        $repgroup = "";
                        if ($showdata->asset_repair_type == 'group') {
                            $repgroup = $showdata->asset_repair;
                        } else if ($showdata->asset_repair_type == 'code') {
                            $a = explode(",", $showdata->asset_repair);

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
                            'wo_engineer1' => 'admin', //A211025
                            'wo_engineer2' => 'sukarya', //A211025
                            'wo_priority' => 'high',
                            'wo_repair_type' => $showdata->asset_repair_type,
                            'wo_repair_group' => $repgroup,
                            'wo_repair_code1' => $repcode1,
                            'wo_repair_code2' => $repcode2,
                            'wo_repair_code3' => $repcode3,
                            'wo_asset' => $showdata->asset_code,
                            'wo_dept' => 'ENG', // Hardcode
                            'wo_type'  => 'auto', // Hardcode
                            'wo_schedule' => $showdata->next_duedate_mtc,
                            'wo_duedate' => date("Y-m-t", strtotime($showdata->next_duedate_mtc)),
                            'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        );

                        DB::table('wo_mstr')->insert($dataarray);

                        DB::table('temp_womstr')->insert([
                            'wo_code' => $runningnbr,
                            'asset_site' => $showdata->asset_site,
                            'asset_loc' => $showdata->asset_loc,
                            'asset_code' => $showdata->asset_code,
                            'asset_desc' => $showdata->asset_desc,
                            'schedule_date' => $showdata->next_duedate_mtc,
                            'due_date' => date("Y-m-t", strtotime($showdata->next_duedate_mtc)),
                            'generate_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);

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
                }

                $datatemp = DB::table('temp_womstr')->get();

                // dd($datatemp);

                // Excel::store(new GenerateWOExport($datatemp) , 'temp_excel_wogenerate_'.$todaydate.'.xlsx');

                Excel::store(new GenerateWOExport($datatemp) , 'temp_excel_wogenerate.xlsx');

                $pesan = "Berikut adalah list WO yang terbentuk";

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
