<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AssetMoveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('asset_move')
            ->join('asset_site as f1','f1.assite_code','=','asmove_fromsite')
            ->join('asset_loc as f2','f2.asloc_code','=','asmove_fromloc')
            /* ->where(function ($query) {
                $query->where('f2.asloc_site','=','f1.assite_code');
            }) */
            ->join('asset_site as t1','t1.assite_code','=','asmove_tosite')
            ->join('asset_loc as t2','t2.asloc_code','=','asmove_toloc')
            /* ->where(function ($query) {
                $query->where('t2.asloc_site','=','t1.assite_code');
            }) */
            ->join('asset_mstr','asset_code','=','asmove_code')
            ->orderby('asmove_code')
            ->paginate(10);
            // ->get();

        // dd($data);

        $fromSite = DB::table('asset_site')
            ->get();

        $fromLoc = DB::table('asset_loc')
            ->get();

        $toSite = DB::table('asset_site')
            ->get();

        $toLoc = DB::table('asset_loc')
            ->get();

        $asset = DB::table('asset_mstr')
            ->whereAsset_active('Yes')
            ->orderBy('asset_code')
            ->get();

        return view('setting.asset-move', ['data' => $data, 'fromSite' => $fromSite, 'fromLoc' => $fromLoc,
            'toSite' => $toSite, 'toLoc' => $toLoc, 'asset' => $asset]);
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
        // dd($request->all());
        DB::table('asset_move')
            ->insert([
                'asmove_code'      => $request->t_asset,
                'asmove_fromsite'      => $request->t_fromsite,
                'asmove_fromloc'      => $request->t_fromloc,
                'asmove_tosite'      => $request->t_tosite,
                'asmove_toloc'      => $request->t_toloc, 
                'asmove_date'   => $request->t_date,               
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
                // 'edited_by'     => Session::get('username'),
        ]);

        DB::table('asset_mstr')
            ->where('asset_code','=',$request->t_asset)
            ->update([
                'asset_site' => $request->t_tosite,
                'asset_loc' => $request->t_toloc,
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
                // 'edited_by'     => Session::get('username'),
            ]);

        toast('Asset Movement Successfully.', 'success');
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

    public function cekassetloc(Request $request) {
        $asset = DB::table('asset_mstr')
            ->where('asset_code','=',$request->asset)
            ->first();
            // dd($asset);
        $hasil = $asset->asset_site . "," . $asset->asset_loc;

        return($hasil);
    }
}
