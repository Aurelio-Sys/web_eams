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
                    // ->where('asset_code','=','EQ-0205-1')
                    // ->whereRaw('DATEDIFF(MONTH, DATEADD(MONTH, asset_cal, asset_last_mtc), GETDATE()) >= - asset_tolerance') // fungsi SQL Server
                    ->whereRaw('PERIOD_DIFF(PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal), date_format(now(),"%Y%m")) <= - asset_tolerance') // fungsi MYSQL
                    ->whereRaw("(asset_on_use is null or asset_on_use = '')")
                    ->get();
//dd($data);
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
                
                $dataarray = array(
                    'wo_nbr' => $runningnbr,
                    'wo_status' => 'plan', //-> A211025
                    // 'wo_status' => 'open',
                    'wo_engineer1' => 'admin', //A211025
                    'wo_engineer2' => 'sukarya', //A211025
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
                    ->whereRaw("(asset_on_use is null or asset_on_use = '')")
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
                
                $dataarray = array(
                    'wo_nbr' => $runningnbr,
                    'wo_status' => 'open',
                    'wo_engineer1' => 'azis', //A211025
                    'wo_engineer2' => 'sukarya', //A211025
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
