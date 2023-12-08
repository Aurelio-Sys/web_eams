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
        } elseif (isset($req->s_type) || isset($req->s_asset) || isset($req->s_loc) || isset($req->s_eng)) {
            $tgl = Carbon::createFromDate($req->bulan)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }

        $bulan = Carbon::createFromDate($tgl)->isoFormat('YYYY');

        $data = DB::table('asset_mstr')
        ->selectRaw('asset_mstr.*, now() as harusnya')
        ->where('asset_active','=','Yes')
        ->orderBy('asset_code')
        ->get();

        // $data = DB::table('asset_mstr')
        // // rumus untuk sch by bulan ->selectRaw('asset_mstr.*, PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal) as harusnya')
        // ->selectRaw('asset_mstr.*, date_format(DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY),"%Y%m") as harusnya')
        // ->where('asset_measure','=','C')
        // ->where('asset_active','=','Yes')
        // // ->where('asset_code','=','01-AT-002')
        // // rumus untuk sch by bulan ->whereRaw('PERIOD_DIFF(PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal), date_format(now(),"%Y%m")) <= - asset_tolerance') // fungsi MYSQL
        // ->whereRaw('DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY) < curdate()')
        // ->orderBy('asset_code')
        // ->get();
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
                'temp_cal' => '',
            ]);
        }
               
        $datatemp = DB::table('temp_asset')
            ->get();

        $datatemp = DB::table('temp_asset')
            ->orderBy('temp_code')
            ->get();
        
        /* Actual data WO */
        $datawo = DB::table('wo_mstr')
            ->selectRaw('wo_asset_code,year(wo_start_date) as "thnwo", month(wo_start_date) as "blnwo", wo_type')
            ->orderBy('wo_asset_code')
            ->orderBy('wo_number')
            ->groupBy('wo_asset_code','thnwo','blnwo','wo_type')
            ->get();

        // dd($datawo);

        /** Menampilkan data PM yang belum confirm */
        $datapm = DB::table('pmo_confirm')
            ->leftJoin('pma_asset', function ($join) {
                $join->on('pmo_confirm.pmo_asset', '=', 'pma_asset.pma_asset')
                    ->where(function ($query) {
                        $query->where('pmo_confirm.pmo_pmcode', '=', DB::raw('pma_asset.pma_pmcode'))
                            ->orWhere(function ($subQuery) {
                                $subQuery->whereNull('pmo_confirm.pmo_pmcode')
                                        ->whereNull('pma_asset.pma_pmcode');
                            });
                    });
            })
            ->selectRaw('pmo_asset,year(pmo_sch_date) as "thnwo", month(pmo_sch_date) as "blnwo"')
            ->get();

        Schema::dropIfExists('temp_asset');

        /** dibedakan sama data asset karena kalo sama nanti muncul di search nya cuman 10  asset karena paging */
        $datasearchasset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->where('asset_active','=','Yes')
            ->get();

        $dataasset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->where('asset_active','=','Yes');

        if(!$req->s_asset && !$req->s_loc && !$req->s_eng && !$req->s_type) {
            $dataasset = $dataasset->where('id','<',0);
        }

        if ($req->s_asset) {
            $dataasset->where('asset_code', '=', $req->s_asset);
        }
        if ($req->s_loc) {
            $dataasset->where('asset_loc', '=', $req->s_loc);
        }
        if($req->s_eng) {
            $a = $req->s_eng;
            $dataasset = $dataasset->whereIn('asset_code', function($query) use ($a, $bulan)
            {
                $query->select('wo_asset')
                        ->from('wo_mstr')
                        ->whereYear('wo_created_at','=',$bulan)
                        ->where(function ($query) use ($a) {
                            $query->where('wo_engineer1', '=', $a)
                                  ->orWhere('wo_engineer2', '=', $a)
                                  ->orWhere('wo_engineer3', '=', $a)
                                  ->orWhere('wo_engineer4', '=', $a)
                                  ->orWhere('wo_engineer5', '=', $a);
                            });
            });
        }
        if($req->s_type == "CM") {
            $dataasset = $dataasset->whereIn('asset_code', function($query) use ($bulan)
            {
                $query->select('wo_asset_code')
                        ->from('wo_mstr')
                        ->whereYear('wo_start_date','=',$bulan)
                        ->where('wo_type','=','CM');
            });
        }
        if($req->s_type == "PM") {
            $dataasset = $dataasset->whereIn('asset_code', function($query) use ($bulan)
            {
                $query->select('wo_asset_code')
                        ->from('wo_mstr')
                        ->whereYear('wo_start_date','=',$bulan)
                        ->where('wo_type','=','PM');
            });
        }
// dd($dataasset->get());
        $dataasset = $dataasset->paginate(10);

        $dataeng = DB::table('eng_mstr')
            ->where('eng_active', '=', 'Yes')
            ->orderBy('eng_code')
            ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        $sasset = $req->s_code;

        return view('report.assetyear', ['data' => $data, 'datatemp' => $datatemp, 'datawo' => $datawo, 'bulan' => $bulan,
            'dataasset' => $dataasset, 'sasset' => $sasset, 'swo' => $req->s_nomorwo, 'sasset' => $req->s_asset,
            'sloc' => $req->s_loc, 'seng' => $req->s_eng, 'datasearchasset' => $datasearchasset,
            'dataloc' => $dataloc, 'dataeng' => $dataeng, 'stype' => $req->s_type, 'datapm' => $datapm]);
    }

    public function assetyeardetail(Request $req) /** Blade : needsp */
    {
        if ($req->ajax()) {

            $code = $req->code;
            $schbln = $req->schbln;
            $schthn = $req->schthn;

            // $data = DB::table('asset_loc')
            // ->orderBy('asloc_code')
            // ->get();

            $data = DB::table('wo_mstr')
                ->whereWo_asset_code($code)
                ->whereMonth('wo_start_date',$schbln)
                ->whereYear('wo_start_date',$schthn)
                ->get();
// dd($data);
            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                '<td>'.$data->wo_number.'</td>'.
                '<td>'.$data->wo_start_date.'</td>'.
                '<td>'.$data->wo_status.'</td>'.
                '<td>'.$data->wo_mt_code.'</td>'.
                '<td>'.$data->wo_list_engineer.'</td>'.
                '</tr>';
            }

            return response($output);
        }
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
