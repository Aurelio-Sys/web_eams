<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class RcmMstrController extends Controller
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

        $data = DB::table('rcm_mstr')
            ->leftJoin('asset_mstr','asset_code','rcm_asset')
            ->leftJoin('qcs_list','qcs_code','rcm_qcs')
            ->orderby('rcm_asset')
            ->orderby('qcs_code');
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

        $dataqcs = DB::table('qcs_list')
            ->orderBy('qcs_code')
            ->groupBy('qcs_code')
            ->get();

        $dataegr = DB::table('egr_mstr')
            ->select('egr_code','egr_desc')
            ->orderBy('egr_code')
            ->groupBy('egr_code')
            ->get();

        return view('setting.rcmmstr', compact('data','dataasset','dataqcs','dataegr'));
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
        DB::table('rcm_mstr')
            ->insert([
                'rcm_asset' => $req->t_asset,
                'rcm_qcs' => $req->t_qcs,
                'rcm_start' => $req->t_start,
                'rcm_end' => $req->t_end,
                'rcm_interval' => $req->t_interval,
                'rcm_eng' => $req->t_eng,
                'rcm_email' => $req->t_email,
                'rcm_editedby'  => Session::get('username'),
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
            ]);

        toast('Routine Check Maintenance Created.', 'success');
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
        DB::table('rcm_mstr')
            ->whereRcm_asset($req->te_asset)
            ->whereRcm_qcs($req->te_qcs)
            ->update([
                'rcm_start' => $req->te_start,
                'rcm_end' => $req->te_end,
                'rcm_interval' => $req->te_interval,
                'rcm_eng' => $req->te_eng,
                'rcm_email' => $req->te_email,
                'rcm_editedby'  => Session::get('username'),
                'updated_at'    => Carbon::now()->toDateTimeString(),
            ]);

        toast('Routine Check Maintenance Updated.', 'success');
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
        DB::table('rcm_mstr')
            ->whereRcm_asset($req->d_asset)
            ->whereRcm_qcs($req->d_qcs)
            ->delete();

        toast('Routine Check Maintenance Deleted.', 'success');
        return back();
    }
}
