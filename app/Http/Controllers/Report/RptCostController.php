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
        // ->whereIn('asset_code',['BGN00284R','BGN00292R'])
        ->orderBy('asset_code');

        if ($req->s_code) {
            $data->where('asset_code', '=', $req->s_code);
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
            ->get();

        $dataasset = Db::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        Schema::dropIfExists('temp_wodets');
        Schema::dropIfExists('temp_wo');
        Schema::dropIfExists('temp_asset');

        $sasset = $req->s_code;

        return view('report.rptcost', ['data' => $data, 'datatemp' => $datatemp, 'bulan' => $bulan, 'dataasset' => $dataasset,
            'sasset' => $sasset]);
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
            ->get();

        $dataasset = Db::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        Schema::dropIfExists('temp_wodets');
        Schema::dropIfExists('temp_wo');
        Schema::dropIfExists('temp_asset');

        $sasset = $req->asset;

        return view('report.rptcost', ['data' => $data, 'datatemp' => $datatemp, 'bulan' => $bulan, 'dataasset' => $dataasset,
            'sasset' => $sasset]);
    }
}
