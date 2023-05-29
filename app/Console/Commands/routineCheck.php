<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class routineCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routineCheck:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        $data_rcm = DB::table('rcm_mstr')
                        ->get();


        foreach($data_rcm as $datas){
            $start_schedule = strtotime($datas->rcm_start);
            $end_schedule = strtotime($datas->rcm_end);
            $interval_hours = $datas->rcm_interval;
            $Interval_minutes = $interval_hours * 60;

            for($time = $start_schedule; $time <= $end_schedule; $time += $Interval_minutes * 60){
                $activityTime = date('H:i', $time);

                DB::table('rcm_activity_log')->insert([
                    'ra_asset_code' => $datas->rcm_asset,
                    'ra_qcs_code' => $datas->rcm_qcs,
                    'ra_schedule_time' => $activityTime,
                    'ra_eng_group' => $datas->rcm_eng,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }


        }
    }
}
