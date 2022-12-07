<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        ->whereIn('asset_code',['BP03','BP04'])
        ->orderBy('asset_code')
        ->paginate(10);
       
        Schema::create('temp_asset', function ($table) {
            $table->increments('id');
            $table->string('temp_code');
            $table->string('temp_bln')->nullable();
            $table->string('temp_thn')->nullable();
            $table->decimal('temp_cost',10,2);
            $table->temporary();
        });

        $dcost = DB::table('wo_mstr')
            ->leftjoin('wo_dets','wo_dets_nbr','=','wo_nbr')
            ->join('asset_mstr','asset_code','=','wo_asset')
            ->select('asset_code','asset_desc')
            ->selectRaw('month(wo_created_at) as bln,year(wo_created_at) as thn')
            ->selectRaw('sum(wo_dets_qty_used) as jml')
            ->where('wo_status','=','closed')
            ->groupBy('asset_code')
            ->groupByRaw('month(wo_created_at)')
            ->groupByRaw('year(wo_created_at)')
            ->get();
// dd($dcost);
        foreach($dcost as $datas) {
            DB::table('temp_asset')->insert([
                'temp_code' => $datas->asset_code,
                'temp_bln' => $datas->bln,
                'temp_thn' => $datas->thn,
                'temp_cost' => $datas->jml == null ? 0 : $datas->jml ,
            ]);
        }
               
        $datatemp = DB::table('temp_asset')
            ->get();

        Schema::dropIfExists('temp_asset');

        return view('report.rptcost', ['data' => $data, 'datatemp' => $datatemp, 'bulan' => $bulan]);
    }  
}
