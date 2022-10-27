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

        // $todate = number_format($req->day / 30, 1);

        $data = DB::table('asset_mstr')
            ->selectRaw('asset_mstr.* , DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY) as next_duedate_mtc, 
                    DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY) as persiapan_mtc,
                    DATE_ADD(DATE_FORMAT(NOW(),"%Y-%m-%d"), INTERVAL ' . $this_diff_time . ' DAY) as to_date,
                    DATE_FORMAT(NOW(),"%Y-%m-%d") as from_date') //interval date untuk to_date akan diganti dengan inputan hari dari depan
            ->where('asset_measure', '=', 'C')
            // ->whereRaw('PERIOD_DIFF(PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal), date_format(now(),"%Y%m")) <= - asset_tolerance')
            ->whereRaw('DATE_ADD(DATE_ADD(asset_last_mtc, INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY) >= date_format(now(),"%Y-%m-%d")')
            ->havingRaw('persiapan_mtc between from_date and to_date')
            ->orderBy('next_duedate_mtc', 'asc')
            ->limit(10) //sementara ambil hanya 10 data
            ->get();

        // dd($data);

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

                        // $dataarray = array(
                        //     'wo_nbr' => $runningnbr,
                        //     'wo_status' => 'plan', //-> A211025
                        //     // 'wo_status' => 'open',
                        //     'wo_engineer1' => 'admin', //A211025
                        //     'wo_engineer2' => 'sukarya', //A211025
                        //     'wo_priority' => 'high',
                        //     'wo_repair_type' => $showdata->asset_repair_type,
                        //     'wo_repair_group' => $repgroup,
                        //     'wo_repair_code1' => $repcode1,
                        //     'wo_repair_code2' => $repcode2,
                        //     'wo_repair_code3' => $repcode3,
                        //     'wo_asset' => $showdata->asset_code,
                        //     'wo_dept' => 'ENG', // Hardcode
                        //     'wo_type'  => 'auto', // Hardcode
                        //     'wo_schedule' => $showdata->next_duedate_mtc,
                        //     'wo_duedate' => date("Y-m-t", strtotime($showdata->next_duedate_mtc)),
                        //     'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        //     'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        // );

                        // DB::table('wo_mstr')->insert($dataarray);

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

                EmailWOGen::dispatch(
                    $pesan,
                );
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
