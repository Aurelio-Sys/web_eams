<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

            //ambil list engineer dari engineer group
            $detail_enggroup = DB::table('egr_mstr')
                            ->where('egr_code', '=', $datas->rcm_eng)
                            ->get();

            $listeng = '';
            foreach ($detail_enggroup as $datasegr){
                $listeng .= $datasegr->egr_eng.';';
            }

            $qcsdesc = DB::table('qcs_list')
                        ->select('qcs_desc')
                        ->where('qcs_code','=', $datas->rcm_qcs)
                        ->first();



            for($time = $start_schedule; $time <= $end_schedule; $time += $Interval_minutes * 60){
                $activityTime = date('H:i', $time);

                DB::table('rcm_activity_log')->insert([
                    'ra_asset_code' => $datas->rcm_asset,
                    'ra_qcs_code' => $datas->rcm_qcs,
                    'ra_qcs_desc' => $qcsdesc->qcs_desc,
                    'ra_schedule_time' => $activityTime,
                    'ra_eng_list' => $listeng,
                    'ra_emailalert' => $datas->rcm_email,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }


        }

        Log::channel('customlog')->info('Mulai Proses Create Routine Check');
    }
}
