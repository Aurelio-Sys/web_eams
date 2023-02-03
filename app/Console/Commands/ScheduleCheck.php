<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\EmailScheduleJobs;

/*
Daftar perubahan :
A211025 : WO yang terbentuk dari PM statusnya langsung open, jadi tidak memerlukan approve oleh supervisor. default eng01 02 sesuai kesepakatan meeting
*/

class ScheduleCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sched:wo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim Email kalo PO mendekati parameter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = DB::table('asset_mstr')
                    ->where('asset_measure','=','C')
                    // ->where('asset_code','=','BGN00276')
                    // querry sch bulan ->whereRaw('DATEDIFF(MONTH, DATEADD(MONTH, asset_cal, asset_last_mtc), GETDATE()) >= - asset_tolerance') // fungsi SQL Server
                    // query sch bulan ->whereRaw('PERIOD_DIFF(PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal), date_format(now(),"%Y%m")) <= - asset_tolerance') // fungsi MYSQL
                    ->whereRaw('DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY) < curdate()')
                    ->whereRaw("(asset_on_use is null or asset_on_use = '')")
                    ->get();

                    /*  query di sql SSELECT asset_code, asset_cal, asset_last_mtc, asset_tolerance,
                    DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY) as 'seharusnya' FROM `asset_mstr` WHERE asset_active = 'yes' and asset_measure = 'C'
                    and DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY) < curdate(); */
// dd($data);
        if($data->count() > 0){
            foreach($data as $data){
                // cek repair
                $repcode1 = "";
                $repcode2 = "";
                $repcode3 = "";
                $repgroup = "";
                if ($data->asset_repair_type == 'group') {
                    $repgroup = $data->asset_repair;
                } else if ($data->asset_repair_type == 'code') {
                    $a = explode(",", $data->asset_repair);

                    $repcode1 = $a[0];
                    if(isset($a[1])) {
                        $repcode2 = $a[1];
                    }
                    if(isset($a[2])) {
                        $repcode3 = $a[2];
                    }
                } else {
                    $rep = "";
                }
                
                // Bkin WO
                $tablern = DB::table('running_mstr')
                                ->first();

                // $tempnewrunnbr = strval(intval($tablern->wt_nbr)+1);
                // $newtemprunnbr = '';

                // if(strlen($tempnewrunnbr) <= 6){
                // $newtemprunnbr = str_pad($tempnewrunnbr,6,'0',STR_PAD_LEFT);
                // }

                $newyear = Carbon::now()->format('y');

                if ($tablern->year == $newyear) {
                    $tempnewrunnbr = strval(intval($tablern->wt_nbr) + 1);

                    $newtemprunnbr = '';
                    if (strlen($tempnewrunnbr) < 6) {
                        $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                    }
                } else {
                    $newtemprunnbr = '000001';
                }

                $runningnbr = $tablern->wt_prefix.'-'.$newyear.'-'.$newtemprunnbr;
                
                /* Mencari engineer yang bertugas */
                $dataengpm = DB::table('pm_eng')
                    ->where('pm_group','=',$data->asset_group)
                    ->first();

                $arrayeng = [];
                foreach(explode(';', $dataengpm->pm_engcode) as $info) {
                    $arrayeng[] = $info;
                }

                $dataarray = array(
                    'wo_nbr' => $runningnbr,
                    'wo_status' => 'plan', //-> A211025
                    // 'wo_status' => 'open',
                    'wo_engineer1' => isset($arrayeng[1]) ? $arrayeng[1] : "", //A211025
                    'wo_engineer2' => isset($arrayeng[2]) ? $arrayeng[2] : "", //A211025
                    'wo_engineer3' => isset($arrayeng[3]) ? $arrayeng[3] : "", //A211025
                    'wo_engineer4' => isset($arrayeng[4]) ? $arrayeng[4] : "", //A211025
                    'wo_engineer5' => isset($arrayeng[5]) ? $arrayeng[5] : "", //A211025
					'wo_priority' => 'high',
                    'wo_repair_type' => $data->asset_repair_type,
                    'wo_repair_group' => $repgroup,
                    'wo_repair_code1' => $repcode1,
                    'wo_repair_code2' => $repcode2,
                    'wo_repair_code3' => $repcode3,
                    'wo_asset' => $data->asset_code, 
					'wo_dept' => 'ENG', // Hardcode
                    'wo_type'  => 'auto', // Hardcode
                    'wo_schedule' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_duedate' => Carbon::now('ASIA/JAKARTA')->endOfMonth()->toDateString(),
                    'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                );

                DB::table('wo_mstr')->insert($dataarray);

                DB::table('running_mstr')
                ->update([
                    'wt_nbr' => $newtemprunnbr,
                    'year' => $newyear,
                ]);


                DB::table('asset_mstr')
                ->where('asset_code',$data->asset_code)
                ->update([
                    'asset_on_use' => $runningnbr,
                ]);
                
                // Kirim Email
                $assettable = DB::table('asset_mstr')
                                ->where('asset_code','=',$data->asset_code)
                                ->first();
                
                $asset = $data->asset_code.' - '.$assettable->asset_desc;

                // ditutup dulu email belum di setting EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');

                // Update Table 
                /* DB::table('asset_mstr')
                        ->where('asset_measure','=','C')
                        ->whereRaw('DATEDIFF(DAY, DATEADD(DAY, asset_cal, asset_last_mtc), GETDATE()) >= 0')
                        ->update([
                            'asset_last_mtc' => Carbon::now()->toDateString()
                        ]);
                */
            }
        }


        $data2 = DB::table('asset_mstr')
                    ->where('asset_measure','=','M')
                    ->whereRaw('asset_last_usage_mtc + asset_tolerance >= asset_last_usage + asset_meter')
                    // ->whereRaw("(asset_on_use is null or asset_on_use = '')")
                    ->get();

        if($data2->count() > 0){
            foreach($data2 as $data2){
                // cek repair
                $repcode1 = "";
                $repcode2 = "";
                $repcode3 = "";
                $repgroup = "";
                if ($data2->asset_repair_type == 'group') {
                    $repgroup = $data2->asset_repair;
                } else if ($data2->asset_repair_type == 'code') {
                    $a = explode(",", $data2->asset_repair);

                    $repcode1 = $a[0];
                    if(isset($a[1])) {
                        $repcode2 = $a[1];
                    }
                    if(isset($a[2])) {
                        $repcode3 = $a[2];
                    }
                } else {
                    $rep = "";
                }
                
                // Bkin WO
                $tablern = DB::table('running_mstr')
                                ->first();

                // $tempnewrunnbr = strval(intval($tablern->wt_nbr)+1);
                // $newtemprunnbr = '';

                // if(strlen($tempnewrunnbr) <= 6){
                // $newtemprunnbr = str_pad($tempnewrunnbr,6,'0',STR_PAD_LEFT);
                // }

                $newyear = Carbon::now()->format('y');

                if ($tablern->year == $newyear) {
                    $tempnewrunnbr = strval(intval($tablern->wt_nbr) + 1);

                    $newtemprunnbr = '';
                    if (strlen($tempnewrunnbr) < 6) {
                        $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                    }
                } else {
                    $newtemprunnbr = '000001';
                }

                $runningnbr = $tablern->wt_prefix.'-'.$newyear.'-'.$newtemprunnbr;

                /* Mencari engineer yang bertugas */
                $dataengpm = DB::table('pm_eng')
                    ->where('pm_group','=',$data2->asset_group)
                    ->first();

                $arrayeng = [];
                if($dataengpm) {
                    foreach(explode(';', $dataengpm->pm_engcode) as $info) {
                        $arrayeng[] = $info;
                    }
                }
                
                
                $dataarray = array(
                    'wo_nbr' => $runningnbr,
                    'wo_status' => 'plan',
                    'wo_engineer1' => isset($arrayeng[1]) ? $arrayeng[1] : "", //A211025
                    'wo_engineer2' => isset($arrayeng[2]) ? $arrayeng[2] : "", //A211025
                    'wo_engineer3' => isset($arrayeng[3]) ? $arrayeng[3] : "", //A211025
                    'wo_engineer4' => isset($arrayeng[4]) ? $arrayeng[4] : "", //A211025
                    'wo_engineer5' => isset($arrayeng[5]) ? $arrayeng[5] : "", //A211025
                    'wo_priority' => 'high',
                    'wo_repair_type' => $data2->asset_repair_type,
                    'wo_repair_group' => $repgroup,
                    'wo_repair_code1' => $repcode1,
                    'wo_repair_code2' => $repcode2,
                    'wo_repair_code3' => $repcode3,
                    'wo_asset' => $data2->asset_code, 
                    'wo_dept' => 'ENG', // Hardcode
                    'wo_type'=>'auto', //Hardcode
                    'wo_schedule' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_duedate' => Carbon::now('ASIA/JAKARTA')->endOfMonth()->toDateString(),
                    'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                );

                DB::table('wo_mstr')->insert($dataarray);

                DB::table('running_mstr')
                ->update([
                    'wt_nbr' => $newtemprunnbr,
                    'year' => $newyear
                ]);

                DB::table('asset_mstr')
                ->where('asset_code',$data2->asset_code)
                ->update([
                    'asset_on_use' => $runningnbr,
                    'asset_last_usage' => $data2->asset_last_usage_mtc,
                ]);
                
                // Melakukan edit untuk histori transaksi
                DB::table('us_hist')
                    ->where('us_asset','=',$data2->asset_code)
                    ->where('us_asset_site','=',$data2->asset_site)
                    ->where('us_asset_loc','=',$data2->asset_loc)
                    ->where('us_last_mea','=',$data2->asset_last_usage_mtc)
                    ->update([
                        'us_no_pm' => $runningnbr,
                    ]);

                // Kirim Email
                $assettable = DB::table('asset_mstr')
                                ->where('asset_code','=',$data2->asset_code)
                                ->first();
                
                $asset = $data2->asset_code.' - '.$assettable->asset_desc;

                // ditutup dulu, email belum di seting EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');
            }
        }
    }
}
