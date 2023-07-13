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

        if ($req->s_asset) {
            $data->where('asset_code', '=', $req->s_asset);
        }
        if ($req->s_loc) {
            $data->where('asset_loc', '=', $req->s_loc);
        }
        if($req->s_eng) {
            $a = $req->s_eng;
            $data = $data->whereIn('asset_code', function($query) use ($a, $bulan)
            {
                $query->select('wo_asset_code')
                      ->from('wo_mstr')
                      ->whereYear('wo_system_create','=',$bulan)
                      ->where('wo_engineer1','=',$a)
                      ->orWhere('wo_engineer2','=',$a)
                      ->orWhere('wo_engineer3','=',$a)
                      ->orWhere('wo_engineer4','=',$a)
                      ->orWhere('wo_engineer5','=',$a);
            });
        }
        if($req->s_type == "WO") {
            $a = $req->s_type;
            $data = $data->whereIn('asset_code', function($query) use ($bulan)
            {
                $query->select('wo_asset_code')
                      ->from('wo_mstr')
                      ->whereYear('wo_system_create','=',$bulan)
                      ->where('wo_type','<>','auto');
            });
        }
        if($req->s_type == "PM") {
            $a = $req->s_type;
            $data = $data->whereIn('asset_code', function($query) use ($bulan)
            {
                $query->select('wo_asset_code')
                      ->from('wo_mstr')
                      ->whereYear('wo_system_create','=',$bulan)
                      ->where('wo_type','=','auto');
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
            ->selectRaw('wo_asset_code,month(wo_system_create) as "bln",year(wo_system_create) as "thn",
                sum(0) as jml')
            // ->leftJoin('wo_dets','wo_dets_nbr','=','wo_nbr')
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
            'dataloc' => $dataloc, 'dataeng' => $dataeng, 'stype' => $req->s_type]);
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

            $data = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset_code')
                    ->whereNotIn('wo_status', ['closed','finish','delete'])
                    ->whereWo_asset_code($code)
                    ->orderBy('wo_schedule')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $eng = "";
                if ($data->wo_engineer1 <> "" && $data->wo_engineer1 <> NULL) {
                    $eng = $data->wo_engineer1;
                }
                if ($data->wo_engineer2 <> "" && $data->wo_engineer2 <> NULL) {
                    $eng = $eng.";".$data->wo_engineer2;
                }
                if ($data->wo_engineer3 <> "" && $data->wo_engineer3 <> NULL) {
                    $eng = $eng.";".$data->wo_engineer3;
                }
                if ($data->wo_engineer4 <> "" && $data->wo_engineer4 <> NULL) {
                    $eng = $eng.";".$data->wo_engineer4;
                }
                if ($data->wo_engineer5 <> "" && $data->wo_engineer5 <> NULL) {
                    $eng = $eng.";".$data->wo_engineer5;
                }

                $dataharga = DB::table('wo_dets')
                    ->selectRaw('sum(wo_dets_sp_price * wo_dets_sp_qty) as jml')
                    ->whereWo_dets_nbr($data->wo_nbr)
                    ->first();

                // dump($dataharga->jml);

                $output .= '<tr>'.
                '<td>'.$data->wo_nbr.'</td>'.
                '<td>'.$eng.'</td>'.
                '<td>'.$data->wo_schedule.'</td>'.
                '<td>'.$data->wo_status.'</td>'.
                '<td>'.$dataharga->jml.'</td>'.
                '</tr>';
            }

            // dd('test');

            return response($output);
        }
    }
}
