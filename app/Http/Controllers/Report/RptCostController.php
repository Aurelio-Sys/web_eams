<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;

class RptCostController extends Controller
{
    public function index(Request $req)
    {
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
        ->whereIn('asset_code',['BGN00284R','BGN00292R'])
        ->orderBy('asset_code')
        ->paginate(10);
        // ->get();

        // dd($data);

        // load cost
        /*$domain = ModelsQxwsa::first();

        $qwsa = (new WSAServices())->wsacost($domain->wsas_domain);

        if ($qwsa === false) {
            toast('WSA Failed', 'error')->persistent('Dismiss');
            return redirect()->back();
        } else {

            if ($qwsa[1] == "false") {
                toast('Item cost tidak ditemukan', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {
        */
                Schema::create('temp_cost', function ($table) {
                    $table->increments('id');
                    $table->string('tc_part');
                    $table->decimal('tc_cost',10,2);
                    $table->temporary();
                });

                /* foreach ($qwsa[0] as $datas) {
                    DB::table('temp_cost')->insert([
                        'tc_part' => $datas->t_part,
                        'tc_cost' => $datas->t_cost,
                    ]);
                } */

                $qdata = DB::table('temp_cost')
                    ->where('tc_cost','<>',0)
                    ->orderBy('tc_part')
                    ->get();

                Schema::dropIfExists('temp_cost');
            //}
        //}

        // Menghitung harga per wo
        Schema::create('temp_wodets', function ($table) {
            $table->increments('id');
            $table->string('tc_wo');
            $table->decimal('tc_cost',10,2);
            $table->temporary();
        });

        $qwodets = DB::table('wo_dets')
            ->whereNotNull('wo_dets_sp')
            ->orderBy('wo_dets_nbr')
            ->get();

        $hargaitem = 0;
        foreach($qwodets as $qw) {
            $harga = $qdata->where('tc_part','=',$qw->wo_dets_sp)->first();

            if(is_null($harga)) {
                $hargaitem = 0;
            } else {
                $hargaitem = $harga->tc_cost;
            }

            $hargaitem = $qw->wo_dets_qty_used * $hargaitem;

            DB::table('temp_wodets')->insert([
                'tc_wo' => $qw->wo_dets_nbr,
                'tc_cost' => $hargaitem,
            ]);

            $hargaitem = 0;
        }

        $qcost = DB::table('temp_wodets')
            ->get();

        
        // Mencari nilah perbaikan per asset
        Schema::create('temp_wo', function ($table) {
            $table->increments('id');
            $table->string('tw_wo');
            $table->string('tw_code');
            $table->string('tw_bln')->nullable();
            $table->string('tw_thn')->nullable();
            $table->decimal('tw_cost',10,2);
            $table->temporary();
        });

        $qwo = DB::table('wo_mstr')
            ->orderBy('wo_nbr')
            ->get();

        foreach($qwo as $qwo) {
            $hargawo = $qcost->where('tc_wo','=',$qwo->wo_nbr)->values('tc_cost');
            
            DB::table('temp_wo')->insert([
                'tw_code' => $qwo->wo_asset,
                'tw_wo' => $qwo->wo_nbr,
                'tw_bln' => date("m",strtotime($qwo->wo_created_at)),
                'tw_thn' => date("Y",strtotime($qwo->wo_created_at)),
                'tw_cost' => $hargawo ,
            ]);
        }

        // Menghitung biaya per asset
        $dcost = DB::table('temp_wo')
            ->select('tw_code','tw_bln','tw_thn')
            ->selectRaw('sum(tw_cost) as jml')
            ->groupBy('tw_code','tw_bln','tw_thn')
            ->get();

        Schema::create('temp_asset', function ($table) {
            $table->increments('id');
            $table->string('temp_code');
            $table->string('temp_bln')->nullable();
            $table->string('temp_thn')->nullable();
            $table->decimal('temp_cost',10,2);
            $table->temporary();
        });

        // $dcost = DB::table('wo_mstr')
        //     ->leftjoin('wo_dets','wo_dets_nbr','=','wo_nbr')
        //     ->join('asset_mstr','asset_code','=','wo_asset')
        //     ->select('asset_code','asset_desc')
        //     ->selectRaw('month(wo_created_at) as bln,year(wo_created_at) as thn')
        //     ->selectRaw('sum(wo_dets_qty_used) as jml')
        //     ->where('wo_status','=','closed')
        //     ->groupBy('asset_code')
        //     ->groupByRaw('month(wo_created_at)')
        //     ->groupByRaw('year(wo_created_at)')
        //     ->get();

        /* foreach($dcost as $datas) {
            DB::table('temp_asset')->insert([
                'temp_code' => $datas->tw_code,
                'temp_bln' => $datas->tw_bln,
                'temp_thn' => $datas->tw_thn,
                'temp_cost' => $datas->jml ,
            ]);
        } */

        $dataharga = DB::table('wo_mstr')
            ->selectRaw('wo_asset,month(wo_created_at) as "bln",year(wo_created_at) as "thn",
                sum(wo_dets_sp_price * wo_dets_sp_qty) as jml')
            ->leftJoin('wo_dets','wo_dets_nbr','=','wo_nbr')
            ->groupBy('wo_asset')
            ->groupBy('bln')
            ->groupBy('thn')
            ->get();

        foreach($dataharga as $dataharga) {
            DB::table('temp_asset')->insert([
                'temp_code' => $dataharga->wo_asset,
                'temp_bln' => $dataharga->bln,
                'temp_thn' => $dataharga->thn,
                'temp_cost' => isset($dataharga->jml) ? $dataharga->jml : 0 ,
            ]);
        }
               
        $datatemp = DB::table('temp_asset')
            // ->where('temp_cost','>',0)
            ->get();

        // dd($datatemp);

        // ini buat test, nanti dihapus saja. hanya untuk menampikan asset yang ada nilainya
        // $data = DB::table('asset_mstr')
        //     ->join('temp_asset','temp_code','=','asset_code')
        //     ->paginate(10);

        Schema::dropIfExists('temp_wodets');
        Schema::dropIfExists('temp_wo');
        Schema::dropIfExists('temp_asset');

        return view('report.rptcost', ['data' => $data, 'datatemp' => $datatemp, 'bulan' => $bulan]);
    }  
}
