<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;

use App;
use App\Exports\ExportCost;
use Maatwebsite\Excel\Facades\Excel;

class RptCostController extends Controller
{
    public function index(Request $req)
    {
        // dd($req->all());
        $tgl = '';
        if (is_null($req->bulan)) {
            $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        } elseif ($req->stat == 'mundur') {
            $tgl = Carbon::createFromDate($req->bulan)->addYear(-1)->toDateTimeString();
        } elseif ($req->stat == 'maju') {
            $tgl = Carbon::createFromDate($req->bulan)->addYear(1)->toDateTimeString();
        } elseif (!is_null($req->bulan)) {
            $tgl = Carbon::createFromDate($req->bulan)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }

        $bulan = Carbon::createFromDate($tgl)->isoFormat('YYYY');

        $data = DB::table('asset_mstr')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->orderBy('asset_code');

        if($req->s_loc) {
            $data = $data->where('asset_loc','=',$req->s_loc);
            // $a = $req->s_loc;
            // $data = $data->whereIn('asset_code', function($query) use ($bulan,$a)
            // {
            //     $query->select('wo_asset')
            //           ->from('wo_mstr')
            //           ->whereYear('wo_created_at','=',$bulan)
            //           ->where('wo_location','=',$a);
            // });
        }
        if($req->s_asset) {
            $data = $data->where('asset_code','=',$req->s_asset);
        }
        if($req->s_eng) {
            $a = $req->s_eng;
            $data = $data->whereIn('asset_code', function($query) use ($bulan,$a)
            {
                $query->select('wo_asset_code')
                      ->from('wo_mstr')
                      ->whereYear('wo_start_date','=',$bulan)
                      ->where('wo_list_engineer','like','%'.$a.'%');
            });
        }

        $data = $data->paginate(10);
        // $data = $data->get();

        // dd($data);

        Schema::create('temp_asset', function ($table) {
            $table->increments('id');
            $table->string('temp_code');
            $table->string('temp_bln')->nullable();
            $table->string('temp_thn')->nullable();
            $table->decimal('temp_cost',10,2);
            $table->temporary();
        });

        // sum(wo_dets_sp_price * wo_dets_sp_qty) as jml')

        $dataharga = DB::table('wo_mstr')
            ->selectRaw('wo_asset_code,wo_type,month(wo_start_date) as "bln",year(wo_start_date) as "thn",
                sum(wd_sp_issued * wd_sp_itemcost) as jml')
            ->leftJoin('wo_dets_sp','wd_sp_wonumber','=','wo_number')
            ->whereYear('wo_start_date','=',$bulan)
            ->groupBy('wo_asset_code')
            ->groupBy('bln')
            ->groupBy('thn');

        if($req->s_type) {
            $dataharga = $dataharga->where('wo_type','=',$req->s_type);
        }
        if($req->s_eng) {
            $dataharga = $dataharga->where('wo_list_engineer','like','%'.$a.'%');
        }

        $dataharga = $dataharga->get();

        foreach($dataharga as $dataharga) {
            DB::table('temp_asset')->insert([
                'temp_code' => $dataharga->wo_asset_code,
                'temp_bln' => $dataharga->bln,
                'temp_thn' => $dataharga->thn,
                'temp_cost' => isset($dataharga->jml) ? $dataharga->jml : 0 ,
            ]);
        }

        $datatemp = DB::table('temp_asset')
            ->get();

        /** Kondisi jika include perhitungan parent */
        if($req->s_child) {
            /** Mencari asset yang terdaftar di asset hierarchy */
            $datapar = DB::table('asset_par')
            ->selectRaw('aspar_par,wo_type,month(wo_start_date) as "bln",year(wo_start_date) as "thn"')
            ->selectRaw('SUM(wd_sp_issued * wd_sp_itemcost) as jml')
            ->leftJoin('wo_mstr', 'wo_asset_code', '=', 'aspar_child')
            ->leftJoin('wo_dets_sp', 'wo_number', '=', 'wd_sp_wonumber')
            ->whereYear('wo_start_date','=',$bulan)
            ->groupBy('aspar_par')
            ->groupBy('bln')
            ->groupBy('thn')
            ->get();

            // dd($datapars);

            /** Update cost untuk asset yang ada parent nya */
            foreach($datatemp as $dt) {
                $sumpar = $datapar->where('aspar_par','=',$dt->temp_code)
                    ->where('bln','=',$dt->temp_bln)->where('thn','=',$dt->temp_thn)->first();

                /** menambahkan cost dari parent ke looping utama */
                if($sumpar) {
                    if($sumpar->jml > 0) {
                        $tambah = $dt->temp_cost + $sumpar->jml;
                        DB::table('temp_asset')
                            ->where('temp_code', $dt->temp_code)
                            ->where('temp_bln', $dt->temp_bln)
                            ->where('temp_thn', $dt->temp_thn)
                            ->update([
                                'temp_cost' => $tambah ,
                            ]);
                    }
                }
            }
            // dd('stop');
        }

        $datatemp = DB::table('temp_asset')
            ->get();

        $dataasset = Db::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        $dataeng = DB::table('eng_mstr')
            ->where('eng_active', '=', 'Yes')
            ->orderBy('eng_code')
            ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        Schema::dropIfExists('temp_wodets');
        Schema::dropIfExists('temp_wo');
        Schema::dropIfExists('temp_asset');

        $sasset = $req->s_code;

        return view('report.rptcost', ['data' => $data, 'datatemp' => $datatemp, 'bulan' => $bulan, 'dataasset' => $dataasset,
            'sasset' => $sasset, 'swo' => $req->s_nomorwo, 'sasset' => $req->s_asset,'sloc' => $req->s_loc, 'seng' => $req->s_eng,
            'dataloc' => $dataloc, 'dataeng' => $dataeng, 'stype' => $req->s_type, 'schild' => $req->s_child]);
    }  

    /* Jadwal preventive asset */
    public function yearcost(Request $req)
    {   

        // dd($req->all());
        $tgl = '';
        if (is_null($req->bulan)) {
            $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        } elseif ($req->stat == 'mundur') {
            $tgl = Carbon::createFromDate($req->bulan)->addYear(-1)->toDateTimeString();
        } elseif ($req->stat == 'maju') {
            $tgl = Carbon::createFromDate($req->bulan)->addYear(1)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }

        $bulan = Carbon::createFromDate($tgl)->isoFormat('YYYY');

        $data = DB::table('asset_mstr')
        ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->orderBy('asset_code');

        if ($req->asset) {
            $data->where('asset_code', '=', $req->asset);
        }

        $data = $data->paginate(10);
        // ->get();

        // dd($data);

        Schema::create('temp_asset', function ($table) {
            $table->increments('id');
            $table->string('temp_code');
            $table->string('temp_bln')->nullable();
            $table->string('temp_thn')->nullable();
            $table->decimal('temp_cost',10,2);
            $table->temporary();
        });

        $dataharga = DB::table('wo_mstr')
            ->selectRaw('wo_asset_code,month(wo_system_create) as "bln",year(wo_system_create) as "thn",
                sum(wo_dets_sp_price * wo_dets_sp_qty) as jml')
            ->leftJoin('wo_dets','wo_dets_nbr','=','wo_nbr')
            ->groupBy('wo_asset_code')
            ->groupBy('bln')
            ->groupBy('thn')
            ->get();

        foreach($dataharga as $dataharga) {
            DB::table('temp_asset')->insert([
                'temp_code' => $dataharga->wo_asset_code,
                'temp_bln' => $dataharga->bln,
                'temp_thn' => $dataharga->thn,
                'temp_cost' => isset($dataharga->jml) ? $dataharga->jml : 0 ,
            ]);
        }
               
        $datatemp = DB::table('temp_asset')
            ->get();

        $dataasset = Db::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        $dataeng = DB::table('eng_mstr')
            ->where('eng_active', '=', 'Yes')
            ->orderBy('eng_code')
            ->get();

        Schema::dropIfExists('temp_wodets');
        Schema::dropIfExists('temp_wo');
        Schema::dropIfExists('temp_asset');

        $sasset = $req->asset;

        return view('report.rptcost', ['data' => $data, 'datatemp' => $datatemp, 'bulan' => $bulan, 'dataasset' => $dataasset,
            'sasset' => $sasset]);
    }

    public function rptcostview(Request $req)
    {
        if ($req->ajax()) {

            $code = $req->code;
            $bln = $req->bln;
            $thn = $req->thn;
            $type = $req->type;
            $eng = $req->eng;
            $child = $req->child;

            /** Data untuk seluruh WO */
            $datawo = DB::table('wo_mstr')
                    ->select('wo_number','wo_note','wo_list_engineer','wo_start_date','wo_type','wo_status')
                    ->join('asset_mstr','asset_code','=','wo_asset_code')
                    ->whereWo_asset_code($code)
                    ->whereMonth('wo_start_date','=',$bln)
                    ->whereYear('wo_start_date','=',$thn)
                    ->orderBy('wo_start_date');

            /** Data jika include parent dari hierarchy asset */
            $datapar = DB::table('asset_par')
                    ->leftJoin('wo_mstr', 'wo_asset_code', '=', 'aspar_child')
                    ->selectRaw('wo_number,CONCAT("child asset ", wo_asset_code) as wo_note,wo_list_engineer,wo_start_date,wo_type,wo_status')
                    ->whereAspar_par($code)
                    ->whereMonth('wo_start_date','=',$bln)
                    ->whereYear('wo_start_date','=',$thn);

            if($type) {
                $datawo = $datawo->where('wo_type','=',$type);
                $datapar = $datapar->where('wo_type','=',$type);
            }
            if($eng) {
                $datawo = $datawo->where('wo_list_engineer','like','%'.$eng.'%');
                $datapar = $datapar->where('wo_list_engineer','like','%'.$eng.'%');
            }

            $datawo = $datawo->get();
            $datapar = $datapar->get();

            if($child == "Yes") {
                $data = $datawo->merge($datapar);
            } else {
                $data = $datawo;
            }

            $output = '';
            foreach ($data as $data) {
                $eng = "";

                $dataharga = DB::table('wo_dets_sp')
                    ->selectRaw('sum(wd_sp_issued * wd_sp_itemcost) as jml')
                    ->whereWd_sp_wonumber($data->wo_number)
                    ->first();

                // dump($dataharga->jml);

                $output .= '<tr>'.
                '<td>'.$data->wo_number.'</td>'.
                '<td>'.$data->wo_note.'</td>'.
                '<td>'.$data->wo_list_engineer.'</td>'.
                '<td>'.date('d-m-Y', strtotime($data->wo_start_date)).'</td>'.
                '<td>'.$data->wo_type.'</td>'.
                '<td>'.$data->wo_status.'</td>'.
                '<td style="text-align: right">'.number_format($dataharga->jml,2).'</td>'.
                // Ditutup dulu, nanti dibuatkan detailnya
                // '<td><a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="View Service Request"
                //     data-sp="{{$show->temp_sp}}" data-spdesc="{{$show->temp_sp_desc}}" data-sch="{{$show->temp_sch_date}}">
                //     <i class="icon-table far fa-eye fa-lg"></i>
                // </a></td>'.
                '</tr>';
            }

            // dd('test');

            return response($output);
        }
    }

    public function donlodcost(Request $req)
    { 
        $asset    = $req->asset;
        $type    = $req->type;
        $loc    = $req->loc;
        $eng    = $req->eng;
        $bulan    = $req->bulan;

        return Excel::download(new ExportCost($asset,$type,$loc,$eng,$bulan), 'EAMS Cost Report.xlsx');
    }
}
