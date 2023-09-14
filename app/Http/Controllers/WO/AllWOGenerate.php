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
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Echo_;
use Illuminate\Support\Facades\Session;

class AllWOGenerate extends Controller
{
    //
    public function viewWoGenerator()
    {
        $dataasset = DB::table('pma_asset')
            ->leftJoin('asset_mstr','asset_code','pma_asset')
            ->whereAssetActive('Yes')
            ->whereIn('pma_mea',['B','C'])
            ->orderBy('pma_asset')
            ->groupBy('pma_asset')
            ->get();

        $dataloc = DB::table('pma_asset')
            ->leftJoin('asset_mstr','asset_code','pma_asset')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->select('asloc_code','asloc_desc')
            ->whereAssetActive('Yes')
            ->whereIn('pma_mea',['B','C'])
            ->orderBy('asset_loc')
            ->groupBy('asset_loc')
            ->get();

        return view('workorder.wogenerator-view', compact('dataasset','dataloc'));
    }

    //untuk menampilkan asset sesuai dengan lokasi yang dipilih
    public function searchassetpm(Request $req)
    {
        if ($req->ajax()) {
            $loc = $req->get('loc');
      
            $data = DB::table('pma_asset')
                ->leftJoin('asset_mstr','asset_code','pma_asset')
                ->whereAssetActive('Yes')
                ->whereIn('pma_mea',['B','C'])
                ->where('asset_loc','=',$loc)
                ->orderBy('pma_asset')
                ->groupBy('pma_asset')
                ->get();

            $output = '<option value="" >Select</option>';
            foreach($data as $data){

                $output .= '<option value="'.$data->asset_code.'" >'.$data->asset_code.' -- '.$data->asset_desc.'</option>';
                           
            }

            return response($output);
        }
    }


    public function getAll(Request $req)
    {
        // dd($req->all());
        $todaydate = Carbon::now()->toDateTime()->format("Y-m-d");
        $todate = date_create($req->todate);
        
        // 1111111111111111111111   Mencari data PM dari data PM Asset Maintenance      1111111111111111111111
        // Hasil perhitungan preventive disimpan pada tabel PM_TEMP_HIST dan PM_TEMP
        // Belum dilakukan -> PM_TEMP_HIST digunakan untuk menyimpan hasil proses generate dan tidak akan pernah dihapus datanya
        // PM_TEMP digunakan untuk menyimpan hasil proses generate, jika generate ulang maka data yang lama akan dihapus. Yang dihapus sesuai dengan asset dan pmcode dari looping
        
        // Mencari data dari master PM untuk dihitung tanggal preventive nya
        $datapm = DB::table('pma_asset')
            ->leftJoin('asset_mstr','asset_code','=','pma_asset')
            ->orderBy('pma_asset')
            ->orderBy('pma_mea')
            ->orderBy('pma_pmcode');

        if($req->asset) {
            $datapm = $datapm->where('pma_asset','=',$req->asset);
        }
        if($req->t_loc) {
            $datapm = $datapm->where('asset_loc','=',$req->t_loc);
        }

        $datapm = $datapm->get();

        DB::beginTransaction();
        try {

            $tempsch = [];
            foreach($datapm as $dp) {
                //Hapus dulu data yang sudah terbentuk, yang asset dan pmcode nya sama, agar terbentuk data yang baru
                DB::table('pmt_temp')
                    ->wherePmtAsset($dp->pma_asset)
                    ->wherePmtPmcode($dp->pma_pmcode)
                    ->delete();

                DB::table('pmo_confirm')
                    ->wherePmoAsset($dp->pma_asset)
                    ->wherePmoPmcode($dp->pma_pmcode)
                    ->delete();

                DB::table('pml_log')
                    ->wherePmlAsset($dp->pma_asset)
                    ->wherePmlPmcode($dp->pma_pmcode)
                    ->delete();

                $fromdate = date_create($todaydate);
                // Dibedakan perhitungannya berdasakan measure nya
                if($dp->pma_mea == "B" || $dp->pma_mea == "C") {
                    // cek kapan terakhir dilakukan maintenance
                    // pma_start adalah field untuk menyimpan tanggal terakhir maintenance nya
                    // dihitung dulu jadwal PM yang terbentuk seharusnya tanggal berapa. jika hasilnya kurang dari tanggal skrg, maka ditambahkan notif di tabel nya
                    $ceklastmtc = date_add(date_create($dp->pma_start), date_interval_create_from_date_string(''.$dp->pma_cal.' days'));
                    $messege = "";

                    if($ceklastmtc < $fromdate) {
                        $lastmtc = $fromdate;
                        $messege = "NF003";
                    } elseif($ceklastmtc > $fromdate) {
                        $lastmtc = $ceklastmtc;
                    } else {
                        $lastmtc = $fromdate;
                    }

                    // Membetuk WO sesuai dengan nilai hari yang dimasukkan
                    while($lastmtc <= $todate) {
                        
                        array_push($tempsch,[
                            'arr_asset' => $dp->pma_asset,
                            'arr_lastmtc' => $lastmtc->format('Y-m-d'),
                            'arr_pmcode' => $dp->pma_pmcode,
                        ]);
                        if($lastmtc <= $todate) {
                            DB::table('pmt_temp')
                                ->insert([
                                    'pmt_asset' => $dp->pma_asset,
                                    'pmt_pmcode' =>$dp->pma_pmcode,
                                    'pmt_sch_date' => $lastmtc->format('Y-m-d'),
                                    'pmt_message' => $messege,
                                    'pmt_editedby'  => Session::get('username'),
                                    'created_at'    => Carbon::now()->toDateTimeString(),
                                    'updated_at'    => Carbon::now()->toDateTimeString(),
                                ]);
                            $messege = "";
                        }
                        $lastmtc = date_add($lastmtc, date_interval_create_from_date_string(''.$dp->pma_cal.' days'));
                    }
                }
            } // End foreach($datapm as $dp)

            // 1111111111111111111111    End Mencari data PM dari data PM Asset Maintenance     1111111111111111111111

            // 2222222222222222222222    Mencari data WO yang sudah terbentuk    2222222222222222222222222222222222222
            // data yang tersimpan pada tabel sementara TEMP_WO akan dibandingkan dengan hasil perhitungan preventive di proses berikutnya
            Schema::dropIfExists('temp_wo');
            Schema::create('temp_wo', function ($table) {
                $table->bigIncrements('id');
                $table->string('two_asset');
                $table->string('two_pmcode')->nullable();
                $table->string('two_number',24);
                $table->date('two_date');
                $table->string('two_avail');
                $table->string('two_status',24);
                $table->temporary();
            });

            // data yang diambil adalah data yang didaftarkan assetnya pada menu Asset Preventive
            // $datawo = DB::table('pma_asset')
            // ->leftJoin('wo_mstr', function ($join) {
            //     $join->on('pma_asset', '=', 'wo_asset_code')
            //          ->whereColumn('pma_pmcode', '=', 'wo_mt_code');
            // })
            //     ->whereNotIn('wo_status',['closed'])
            //     ->whereWoType('PM')
            //     ->orderBy('pma_asset')
            //     ->orderBy('pma_mea');

            $query1 = DB::table('wo_mstr')
                ->join('pma_asset', 'pma_asset', '=', 'wo_asset_code')
                ->whereNull('wo_mt_code')
                ->whereNull('pma_pmcode')
                ->orderBy('pma_asset');

            if($req->asset) {
                $query1 = $query1->where('wo_asset_code','=',$req->asset);
            }

            $query2 = DB::table('wo_mstr')
                ->join('pma_asset', 'pma_asset', '=', 'wo_asset_code')
                ->whereNotNull('wo_mt_code')
                ->where('pma_pmcode', '=', DB::raw('wo_mt_code'))
                ->orderBy('pma_asset');

            if($req->asset) {
                $query2 = $query2->where('wo_asset_code','=',$req->asset);
            }

            $datawo = $query1->unionAll($query2);

            $datawo = $datawo->get();
            $tempwo = [];

            foreach($datawo as $dw) {
                array_push($tempwo,$dw->wo_number);
                DB::table('temp_wo')
                    ->insert([
                        'two_asset' => $dw->pma_asset,
                        'two_pmcode' =>$dw->pma_pmcode,
                        'two_number' => $dw->wo_number,
                        'two_date' => $dw->wo_start_date,
                        'two_avail' => 'No',
                        'two_status' => $dw->wo_status,
                    ]);
            } // Eng foreach($datawo as $dw)

            // 2222222222222222222222222222222       End Mencari data WO    222222222222222222222222222222222

            // 33333333333333333333333333        Membandingkan Temporary Schedule dan WO yang sudah terbentuk       33333333333333333333333333
            // data perbandingan diambil dari hasil perhitungan pertama
            $datasch = DB::table('pmt_temp')
                ->orderBy('pmt_asset')
                ->orderBy('pmt_pmcode')
                ->orderBy('pmt_sch_date');

            if($req->asset) {
                $datasch = $datasch->where('pmt_asset','=',$req->asset);
            }

            $datasch = $datasch->get();

            $tempcrsch = [];
            foreach($datasch as $tsch) {
                // apabila tanggal yang terbentuk melebihi tanggal inputan, maka data tidak tersimpan
                if(date_create($tsch->pmt_sch_date) <= $todate) {

                    // dibandingkan dengan data wo yang telah ditampung sesuai dengan asset dan kodepm
                    $datawo = DB::table('temp_wo')
                        // ->whereTwoAsset($tsch->pmt_asset)
                        ->whereTwoPmcode($tsch->pmt_pmcode)
                        ->whereTwoAvail('No')
                        ->orderBy('two_date')
                        ->get();

                    $rsltwo = "";
                    $rsltwodate = "";

                    // perhitungan lama di backup di : AllWOGenerate (2023.05.24 sblm ganti perhitungan)
                    foreach($datawo as $two) {
                        $rsltdate = $tsch->pmt_sch_date;
                        $rsltnumber = $tsch->id;
                        $rsltwo = $two->two_number;
                        $rsltwodate = $two->two_date;
                        $rsltsource = 'WO';

                        switch (true) {
                            case($two->two_status != "firm") :
                                $mssg = "NF004";
                                break;
                            case($tsch->pmt_message != "") :
                                $mssg = $tsch->pmt_message;
                                break; 
                            case($tsch->pmt_sch_date < $two->two_date) :
                                $mssg = "NF002";
                                break;
                            case($tsch->pmt_sch_date > $two->two_date) :
                                $mssg = "NF001";
                                break;
                            case($tsch->pmt_sch_date = $two->two_date) :
                                $mssg = "NF005";
                                break;
                            default :
                                $mssg = "-";
                                break;
                        }

                        DB::table('pml_log')
                            ->insert([
                                'pml_asset' => $tsch->pmt_asset,
                                'pml_pmcode' => $tsch->pmt_pmcode,
                                'pml_pm_number' => $tsch->id,
                                'pml_pm_date' => $tsch->pmt_sch_date,
                                'pml_wo_number' => $two->two_number,
                                'pml_wo_date' => $two->two_date,
                                'pml_message' => $mssg,
                                'pml_user'  => Session::get('username'),
                                'pml_dept'  => Session::get('department'),
                                'created_at'    => Carbon::now()->toDateTimeString(),
                            ]);


                        // Field avail di update Yes agar tidak dibandingkan lagi pada saat looping berikutnya dari temp-pm
                        DB::table('temp_wo')
                            ->whereId($two->id)
                            ->update([
                                'two_avail' => 'Yes',
                            ]);

                        array_push($tempcrsch,[
                            'ts_asset' => $tsch->pmt_asset,
                            'ts_pmcode' => $tsch->pmt_pmcode,
                            'td_date' => $rsltdate,
                        ]);  

                        break;
                    } // End    foreach($datawo as $two)
                        
                    if($datawo->count() == 0){
                        // yang masuk pada kondisi ini adalah perhitungan preventive yang tidak ada wo nya
                        $rsltdate = $tsch->pmt_sch_date;
                        $rsltnumber = $tsch->id;
                        $rsltsource = 'TEMP-PM';
                        array_push($tempcrsch,[
                            'ts_asset' => $tsch->pmt_asset,
                            'ts_pmcode' => $tsch->pmt_pmcode,
                            'td_date' => $tsch->pmt_sch_date,
                        ]);
                    }

                    // pengecekan apakah sudah ada data yang sama berdasarkan asset, kodepm dan tanggal nya
                    $cekpmo = DB::table('pmo_confirm')
                        ->wherePmoAsset($tsch->pmt_asset)
                        ->wherePmoPmcode($tsch->pmt_pmcode)
                        ->wherePmoSchDate($rsltdate)
                        ->count();

                    if($cekpmo == 0) {
                        DB::table('pmo_confirm')
                            ->Insert([
                                'pmo_asset' => $tsch->pmt_asset,
                                'pmo_pmcode' => $tsch->pmt_pmcode,
                                'pmo_sch_date' => $rsltdate,  
                                'pmo_number' => $rsltnumber,
                                'pmo_source' => $rsltsource,
                                'pmo_wonumber' => $rsltwo,
                                'pmo_wodate' => $rsltwodate,
                                'pmo_user'  => Session::get('username'),
                                'pmo_dept'  => Session::get('department'),
                                'created_at'    => Carbon::now()->toDateTimeString(),
                            ]);
                    }
                } // END if(date_create($tsch->pmt_sch_date) <= $todate)

            } // End    foreach($datasch as $ds)
           
            // Menyimpan data WO yang sudah terbentuk namun tidak dibandingan dengan perhitungan PM karena tanggal proses generate PM lebih kecil dari tanggal WO yang terbentuk
            $datawo = DB::table('temp_wo')
                ->whereTwoAvail('No')
                ->orderBy('two_asset')
                ->orderBy('two_pmcode')
                ->orderBy('two_date')
                ->get();

            foreach($datawo as $dw) {
                DB::table('pmo_confirm')
                    ->Insert([
                        'pmo_asset' => $dw->two_asset,
                        'pmo_pmcode' => $dw->two_pmcode,
                        'pmo_wodate' => $dw->two_date,  
                        'pmo_wonumber' => $dw->two_number,
                        'pmo_source' => 'WO',
                        'pmo_user'  => Session::get('username'),
                        'pmo_dept'  => Session::get('department'),
                        'created_at'    => Carbon::now()->toDateTimeString(),
                    ]);
            }

            // 33333333333333333333333333 End Membandingkan Temporary Schedule dan WO yang sudah terbentuk      33333333333333333333333333
    
            $viewwo = collect($tempwo);
            $viewsch = collect($tempsch);
            $viewrslt = collect($tempcrsch);

            DB::commit();
            toast('Work Order Generated Success', 'success');
            return back();
        } catch (Exception $err) {
            DB::rollBack();

            dd($err);
            toast('Work Order Generated Error, please re-generate again.', 'success');
            return back();
        }



        return back();

        // batas proses yang lama, sebelum inventory supply . nanti yang dibawah ini dihapus aja.
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
                                    ->leftJoin('pm_eng', 'pm_eng.pm_group','asset_mstr.asset_group')
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
                        'wo_engineer1' => isset($array_englist[0]) ? $array_englist[0]:null, //A211025
                        'wo_engineer2' => isset($array_englist[1]) ? $array_englist[1]:null, //A211025
                        'wo_engineer3' => isset($array_englist[2]) ? $array_englist[2]:null,
                        'wo_engineer4' => isset($array_englist[3]) ? $array_englist[3]:null,
                        'wo_engineer5' => isset($array_englist[4]) ? $array_englist[4]:null,
                        'wo_priority' => 'high',
                        'wo_repair_type' => $getmaster_asset->asset_repair_type,
                        'wo_repair_group' => $repgroup,
                        'wo_repair_code1' => $repcode1,
                        'wo_repair_code2' => $repcode2,
                        'wo_repair_code3' => $repcode3,
                        'wo_asset' => $getmaster_asset->asset_code,
                        'wo_dept' => 'ENG', // Hardcode
                        'wo_type'  => 'auto', // Hardcode
                        'wo_asset_site' => $getmaster_asset->asset_site,
                        'wo_asset_loc' => $getmaster_asset->asset_loc,
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
