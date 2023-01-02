<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;

class RptAssetYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }

        $bulan = Carbon::createFromDate($tgl)->isoFormat('YYYY');

        $data = DB::table('asset_mstr')
        // rumus untuk sch by bulan ->selectRaw('asset_mstr.*, PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal) as harusnya')
        ->selectRaw('asset_mstr.*, date_format(DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY),"%Y%m") as harusnya')
        ->where('asset_measure','=','C')
        ->where('asset_active','=','Yes')
        // ->where('asset_code','=','01-AT-002')
        // rumus untuk sch by bulan ->whereRaw('PERIOD_DIFF(PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal), date_format(now(),"%Y%m")) <= - asset_tolerance') // fungsi MYSQL
        ->whereRaw('DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY) < curdate()')
        ->orderBy('asset_code')
        ->paginate(10);
// dd($data);        
        Schema::create('temp_asset', function ($table) {
            $table->increments('id');
            $table->string('temp_code');
            $table->string('temp_sch');
            $table->string('temp_cal');
            $table->temporary();
        });

        foreach($data as $datas) {
            DB::table('temp_asset')->insert([
                'temp_code' => $datas->asset_code,
                'temp_sch' => $datas->harusnya,
                'temp_cal' => $datas->asset_cal,
            ]);
        }
               
        $datatemp = DB::table('temp_asset')
            ->get();

        /* Menyimpan data sementara schedule WO yang selanjutnya */
        /* foreach($datatemp as $dt) {
            $tglharusnya = Carbon::create(substr($dt->temp_sch,0,4), substr($dt->temp_sch,4,2), 1, 0);

            for($i = 1;$i<=10;$i++)
            {
                DB::table('temp_asset')->insert([
                    'temp_code' => $dt->temp_code,
                    'temp_sch' => $tglharusnya->addMonth($dt->temp_cal)->format('Ym'),
                    'temp_cal' => $dt->temp_cal,
                ]);
            }

            $tglharusnya = Carbon::create(substr($dt->temp_sch,0,4), substr($dt->temp_sch,4,2), 1, 0);
            for($i = 1;$i<=10;$i++)
            {
                DB::table('temp_asset')->insert([
                    'temp_code' => $dt->temp_code,
                    'temp_sch' => $tglharusnya->subMonth($dt->temp_cal)->format('Ym'),
                    'temp_cal' => $dt->temp_cal,
                ]);
            } 
        } */

        $datatemp = DB::table('temp_asset')
            ->orderBy('temp_code')
            ->get();
        
        /* Actual data WO */
        $datawo = DB::table('wo_mstr')
            // ->where('wo_type','=','auto')
            ->orderBy('wo_asset')
            ->orderBy('wo_nbr')
            ->get();
// dd($data);
        Schema::dropIfExists('temp_asset');

        $dataasset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            // ->where('asset_measure','=','C')
            ->where('asset_active','=','Yes')
            ->paginate(10);
            // ->get();

        return view('report.assetyear', ['data' => $data, 'datatemp' => $datatemp, 'datawo' => $datawo, 'bulan' => $bulan,
            'dataasset' => $dataasset]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
