<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\EmailScheduleJobs;

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
/*
        // Perhitungan untuk type Calendar
        $datacal = DB::table('pma_asset')
            ->whereIn('pma_mea',['C','B'])
            ->whereRaw('DATE_ADD(DATE_ADD(pma_start,INTERVAL pma_cal DAY), INTERVAL -pma_tolerance DAY) < curdate()')
            ->get();

        if($datacal->count() > 0){
            DB::beginTransaction();

            try {

                foreach($datacal as $dc){
                        
                    // Mencari nomor PM terakhir
                    $tablern = DB::table('running_mstr')
                    ->first();
                    $newyear = Carbon::now()->format('y');

                    if ($tablern->year == $newyear) {
                        $tempnewrunnbr = strval(intval($tablern->wt_nbr) + 1);
                        $newtemprunnbr = '';

                        if (strlen($tempnewrunnbr) < 6) {
                            $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                        }
                    } else {
                        $newtemprunnbr = "000001";
                    }

                    $runningnbr = $tablern->wt_prefix . '-' . $newyear . '-' . $newtemprunnbr;

                    // Mencari site asset
                    $dataasset = DB::table('asset_mstr')
                        ->whereAssetCode($dc->pma_asset)
                        ->first();

                    // Mencari data detail untuk PM Code
                    $datapmcode = DB::table('pmc_mstr')
                        ->wherePmcCode($dc->pma_pmcode)
                        ->first();

                    if($datapmcode) {
                        $dins = $datapmcode->pmc_ins;
                        $dspg = $datapmcode->pmc_spg;
                        $dqcs = $datapmcode->pmc_qcs;
                    } else {
                        $dins = null;
                        $dspg = null;
                        $dqcs = null;
                    }

                    if(is_null($dc->pma_leadtime)) {
                        $dleadtime = 0;
                    } else {
                        $dleadtime = $dc->pma_leadtime;
                    }

                    $dataarray = array(
                        'wo_number'           => $runningnbr,
                        'wo_sr_number'          => '',
                        'wo_asset_code'          => $dc->pma_asset,
                        'wo_site'             => $dataasset->asset_site,
                        'wo_location'           => $dataasset->asset_loc,
                        'wo_type'              => 'PM',
                        'wo_status'              => 'firm',
                        'wo_list_engineer'    => $dc->pma_eng, 
                        'wo_start_date'       => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wo_due_date'          => Carbon::now('ASIA/JAKARTA')->addDays($dleadtime),
                        'wo_mt_code'          => $dc->pma_pmcode, // $req->has('c_mtcode') ? $req->c_mtcode : null,
                        'wo_ins_code'          => $dins,
                        'wo_sp_code'          => $dspg,
                        'wo_qcspec_code'      => $dqcs,
                        'wo_createdby'          => 'ADMIN',
                        'wo_department'       => 'ENG',
                        'wo_system_create'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wo_system_update'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(), 
                    );

                    DB::table('wo_mstr')->insert($dataarray);
        
                    DB::table('wo_trans_history')
                        ->insert([
                            'wo_number' => $runningnbr,
                            'wo_action' => 'firm',
                        ]);
        
                    DB::table('running_mstr')
                        // ->where('wt_nbr', '=', $tablern->wo_nbr)   // ini kenapa pakai where yaaa??
                        ->update([
                            'year' => $newyear,
                            'wt_nbr' => $newtemprunnbr
                        ]);
                    
                } // END foreach($req->he_wonbr as $he_wonbr)
                // dd('stop');
                DB::commit();

            } catch (Exception $err) {
                DB::rollBack();

                dd($err);
                toast('Work Order Generated Error, please re-generate again.', 'success');
                return back();
            }
        }
*/
        // END Perhitungan untuk type Calendar

        // START Perhitungan untuk type Meter
        $data2 = DB::table('pma_asset')
            ->whereIn('pma_mea',['M','B'])
            ->where(function ($subquery) {
                $subquery->whereNull('pma_pmnumber')
                    ->orWhere('pma_pmnumber', '');
            })
            ->get();
// dd($data2);
        $dataussage = DB::table('us_hist')
            ->select('us_hist.us_asset', 'us_last_mea', 'us_date as tgl', 'us_hist.us_mea_um')
            ->join(
                \DB::raw('(SELECT us_asset,us_mea_um, MAX(us_date) AS max_date FROM us_hist GROUP BY us_asset, us_mea_um) as max_us'),
                function ($join) {
                    $join->on('us_hist.us_asset', '=', 'max_us.us_asset');
                    $join->on('us_hist.us_date', '=', 'max_us.max_date');
                    $join->on('us_hist.us_mea_um', '=', 'max_us.us_mea_um');
                }
            )
            ->get();
// dd($dataussage);
        if($data2->count() > 0){
            DB::beginTransaction();

            try {

                foreach($data2 as $dc){
                        
                    // Mencari nomor PM terakhir
                    $tablern = DB::table('running_mstr')
                    ->first();
                    $newyear = Carbon::now()->format('y');

                    if ($tablern->year == $newyear) {
                        $tempnewrunnbr = strval(intval($tablern->wt_nbr) + 1);
                        $newtemprunnbr = '';

                        if (strlen($tempnewrunnbr) < 6) {
                            $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                        }
                    } else {
                        $newtemprunnbr = "000001";
                    }

                    $runningnbr = $tablern->wt_prefix . '-' . $newyear . '-' . $newtemprunnbr;

                    // Mencari site asset
                    $dataasset = DB::table('asset_mstr')
                        ->whereAssetCode($dc->pma_asset)
                        ->first();

                    // Mencari data detail untuk PM Code
                    $datapmcode = DB::table('pmc_mstr')
                        ->wherePmcCode($dc->pma_pmcode)
                        ->first();

                    if($datapmcode) {
                        $dins = $datapmcode->pmc_ins;
                        $dspg = $datapmcode->pmc_spg;
                        $dqcs = $datapmcode->pmc_qcs;
                    } else {
                        $dins = null;
                        $dspg = null;
                        $dqcs = null;
                    }

                    if(is_null($dc->pma_leadtime)) {
                        $dleadtime = 0;
                    } else {
                        $dleadtime = $dc->pma_leadtime;
                    }

                    // Mencari data pengukuran terakhir
                    $qlastmea = $dataussage->where('us_asset','=',$dc->pma_asset)->where('us_mea_um','=',$dc->pma_meterum)->first();
                    $lastusage = $qlastmea ? $qlastmea->us_last_mea : 0;

                    // Membentuk PM jika pengukuran terakhir melebihi pengukuran
                    if($lastusage > $dc->pma_meter + $dc->pma_lastmea) {

                        $dataarray = array(
                            'wo_number'           => $runningnbr,
                            'wo_sr_number'          => '',
                            'wo_asset_code'          => $dc->pma_asset,
                            'wo_site'             => $dataasset->asset_site,
                            'wo_location'           => $dataasset->asset_loc,
                            'wo_type'              => 'PM',
                            'wo_status'              => 'firm',
                            'wo_list_engineer'    => $dc->pma_eng, 
                            'wo_start_date'       => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wo_due_date'          => Carbon::now('ASIA/JAKARTA')->addDays($dleadtime),
                            'wo_mt_code'          => $dc->pma_pmcode, // $req->has('c_mtcode') ? $req->c_mtcode : null,
                            'wo_ins_code'          => $dins,
                            'wo_sp_code'          => $dspg,
                            'wo_qcspec_code'      => $dqcs,
                            'wo_createdby'          => 'ADMIN',
                            'wo_department'       => 'ENG',
                            'wo_system_create'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wo_system_update'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(), 
                        );

                        DB::table('wo_mstr')->insert($dataarray);
            
                        DB::table('wo_trans_history')
                            ->insert([
                                'wo_number' => $runningnbr,
                                'wo_action' => 'firm',
                            ]);
            
                        DB::table('running_mstr')
                            // ->where('wt_nbr', '=', $tablern->wo_nbr)   // ini kenapa pakai where yaaa??
                            ->update([
                                'year' => $newyear,
                                'wt_nbr' => $newtemprunnbr
                            ]);

                        // Update data di pma_asset untuk mencatat pengukuran saat terbentuknya PM
                        DB::table('pma_asset')
                            ->wherePmaAsset($dc->pma_asset)
                            ->wherePmaPmcode($dc->pma_pmcode)
                            ->wherePmaMeterum($dc->pma_meterum)
                            ->update([
                                'pma_lastmea' => $lastusage,
                                'pma_pmnumber' => $runningnbr
                            ]);
                    }
                    
                } // END foreach($req->he_wonbr as $he_wonbr)
                // dd('stop');
                DB::commit();

            } catch (Exception $err) {
                DB::rollBack();

                dd($err);
                toast('Work Order Generated Error, please re-generate again.', 'success');
                return back();
            }
        }
    }
}
