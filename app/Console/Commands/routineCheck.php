<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App;

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
        DB::beginTransaction();

        try {

            $data_rcm = DB::table('rcm_mstr')
                ->join('asset_mstr','asset_mstr.asset_code','rcm_mstr.rcm_asset')
                ->get();


            foreach ($data_rcm as $datas) {
                $start_schedule = strtotime($datas->rcm_start);
                $end_schedule = strtotime($datas->rcm_end);
                $interval_hours = $datas->rcm_interval;
                $Interval_minutes = $interval_hours * 60;

                //ambil list engineer dari engineer group
                $detail_enggroup = DB::table('egr_mstr')
                    ->where('egr_code', '=', $datas->rcm_eng)
                    ->get();

                $listeng = '';
                foreach ($detail_enggroup as $datasegr) {
                    $listeng .= $datasegr->egr_eng . ';';

                    $user = App\User::where('username', '=', $datasegr->egr_eng)->first();
                    $details = [
                        'body' => 'New Routine Check Activity For You',
                        'url' => 'myroutine',
                        'nbr' => $datas->asset_desc. ' - ' .$datas->rcm_qcs,
                        'note' => 'Please check'
        
                    ]; // isi data yang dioper
        
                    $user->notify(new \App\Notifications\eventNotification($details)); 
                }

                $qcsdesc = DB::table('qcs_list')
                    ->select('qcs_desc')
                    ->where('qcs_code', '=', $datas->rcm_qcs)
                    ->first();



                for ($time = $start_schedule; $time <= $end_schedule; $time += $Interval_minutes * 60) {
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

        
            DB::commit();

            Log::channel('customlog')->info('Create Routine Check Berhasil');
        } catch (Exception $err) {
            DB::rollBack();
            Log::channel('customlog')->info('Create Routine Check Error pesan : '.$err.'');
        }
    }
}
