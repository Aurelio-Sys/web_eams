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
            ->leftJoin('asset_mstr','asset_code','pma_asset')
            ->leftJoin('pmc_mstr','pmc_code','pma_pmcode')
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

        $dataum = DB::table('um_mstr')
            ->orderBy('um_code')
            ->get();

        return view('setting.pmasset', compact('data','dataasset','datapm','dataeng','dataum'));
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

    //untuk menampilkan select engineer
    public function pickeng(Request $req)
    {
        if($req->ajax()){
            $eng = DB::table('eng_mstr')
                ->whereEng_active('Yes')
                ->orderBy('eng_code')
                ->get();

            $array = json_decode(json_encode($eng), true);

            return response()->json($array);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $eng = "";
        if(!is_null($req->t_eng)) {
            $flg = 0;
            foreach ($req->t_eng as $ds) {
                $eng = $eng . $req->t_eng[$flg] . "," ;
                $flg += 1;
            }
        } 
        
        DB::table('pma_asset')
            ->insert([
                'pma_asset' => $req->t_asset,
                'pma_pmcode' => $req->t_pmcode,
                'pma_leadtime' => $req->t_time,
                'pma_mea' => $req->t_mea,
                'pma_cal' => $req->t_cal,
                'pma_meter' => $req->t_meter,
                'pma_meterum' => $req->t_durum,
                'pma_tolerance' => $req->t_tol,
                'pma_start' => $req-> t_start,
                'pma_eng' => $eng,
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
    public function update(Request $req)
    {
        $eng = "";
        if(!is_null($req->te_eng)) {
            $flg = 0;
            foreach ($req->te_eng as $ds) {
                $eng = $eng . $req->te_eng[$flg] . "," ;
                $flg += 1;
            }
        } 
        
        DB::table('pma_asset')
            ->wherePma_asset($req->te_asset)
            ->wherePma_pmcode($req->te_pmcode)
            ->update([
                'pma_leadtime' => $req->te_time,
                'pma_mea' => $req->te_mea,
                'pma_cal' => $req->te_cal,
                'pma_meter' => $req->te_meter,
                'pma_meterum' => $req->te_durum,
                'pma_tolerance' => $req->te_tol,
                'pma_start' => $req-> te_start,
                'pma_eng' => $eng,
                'pma_editedby'  => Session::get('username'),
                'created_at'    => Carbon::now()->toDateTimeString(),
            ]);

        toast('Preventive Maintenance Updated.', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        $data = DB::table('pma_asset')
            ->wherePma_asset($req->d_asset)
            ->wherePma_pmcode($req->d_pmcode)
            ->delete();

        toast('Preventive Maintenance Deleted.', 'success');
        return back();
    }
}
