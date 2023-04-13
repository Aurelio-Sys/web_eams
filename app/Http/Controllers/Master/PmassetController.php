<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PmassetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $s_code = $req->s_code;
        $s_desc = $req->s_desc;

        $data = DB::table('pma_asset')
            ->orderby('pma_asset')
            ->orderby('pma_pmcode');
/*
        if($s_code) {
            $data = $data->where('pmc_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('pmc_desc','like','%'.$s_desc.'%');
        }
*/
        $data = $data->paginate(10);

        $datains = DB::table('ins_list')
            ->select('ins_code','ins_desc')
            ->orderBy('ins_code')
            ->groupBy('ins_code')
            ->get();

        $dataqcs = DB::table('qcs_list')
            ->select('qcs_code','qcs_desc')
            ->orderBy('qcs_code')
            ->groupBy('qcs_code')
            ->get();
        
        $dataspg = DB::table('spg_list')
            ->select('spg_code','spg_desc')
            ->orderBy('spg_code')
            ->groupBy('spg_code')
            ->get();

        $dataasset = Db::table('asset_mstr')
            ->whereAsset_active('Yes')
            ->orderBy('asset_code')
            ->get();

        $datapm = DB::table('pmc_mstr')
            ->orderby('pmc_code')
            ->get();

        $dataeng = DB::table('eng_mstr')
            ->whereEng_active('Yes')
            ->orderBy('eng_code')
            ->get();

        return view('setting.pmasset', compact('data','dataasset','datapm','dataeng'));
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
    public function store(Request $req)
    {
        DB::table('pma_asset')
            ->insert([
                'pma_asset' => $req->t_asset,
                'pma_pmcode' => $req->t_pmasset,
                'pma_leadtime' => $req->t_time,
                'pma_mea' => $req->t_mea,
                'pma_cal' => $req->t_cal,
                'pma_meter' => $req->t_meter,
                'pma_meterum' => $req->t_meterum,
                'pma_eng' => $req->t_eng,
                'pma_editedby'  => Session::get('username'),
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
            ]);

        toast('Preventive Maintenance Created.', 'success');
        return back();
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
