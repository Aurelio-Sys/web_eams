<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AssetSiteController extends Controller
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
        
        $data = DB::table('asset_site');
// dd($req->all());
        if($s_code) {
            $data = $data->where('assite_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('assite_desc','like','%'.$s_desc.'%');
        }   

        $data = $data->paginate(10);

        return view('setting.asset-site', ['data' => $data]);
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

    // melakukan pengecekan double input pada blade
    public function cekasitecode(Request $req)
    {

        $cekCode = DB::table('asset_site')
            ->where('assite_code','=',$req->code)
            ->count();

        $cekDesc = DB::table('asset_site')
            ->where('assite_desc','=',$req->desc)
            ->count();

        $cek = $cekCode + $cekDesc;
                
        if ($cek == 0) {
            return "tidak";
        } else {
            return "ada";
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'assite_code' => 'unique:assite_mstrs',
            'assite_desc' => 'unique:assite_mstrs'
        ], [
            'assite_code.unique' => 'Site Code is Already Registerd!!',
            'assite_desc.unique' => 'Site Description is Already Registerd!!'
        ]);

        $cekCode = DB::table('asset_site')
            ->where('assite_code','=',$request->site_code)
            ->get();

        $cekDesc = DB::table('asset_site')
            ->where('assite_desc','=',$request->site_desc)
            ->get();

        if ($cekCode->count() == 0 && $cekDesc->count() == 0) {
            DB::table('asset_site')
            ->insert([
                'assite_code'     => $request->site_code,
                'assite_desc'     => $request->site_desc,
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
                'edited_by'     => Session::get('username'),
            ]);

            toast('Asset Site Created.', 'success');
            return back();
        } elseif($cekCode->count() > 0) {
            toast('Site Code is Already Registerd!!', 'error');
            return back();
        } else {
            toast('Site Desc is Already Registerd!!', 'error');
            return back();
        }
        
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
    public function edit(Request $request)
    {
        $cekData = DB::table('asset_site')
            ->where('assite_code','<>',$request->te_sitecode)
            ->Where('assite_desc','=',$request->te_sitedesc)
            ->get();

        if ($cekData->count() == 0) {
            DB::table('asset_site')
            ->where('assite_code', '=', $request->te_sitecode)
            ->update([
                'assite_desc'     => $request->te_sitedesc,
                'updated_at'    => Carbon::now()->toDateTimeString(),
                'edited_by'     => Session::get('username'),
            ]);

            toast('Asset Site Updated.', 'success');
            return back();
        } else {
            toast('Asset Site Description is Already Registerd!!', 'error');
            return back();
        }
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
    public function destroy(Request $request)
    {
        // cek dari tabel location
        $cekData = DB::table('asset_loc')
                ->where('asloc_site','=',$request->d_sitecode)
                ->get();

        if ($cekData->count() == 0) {
            DB::table('asset_site')
            ->where('assite_code', '=', $request->d_sitecode)
            ->delete();

            toast('Site Successfully Deleted', 'success');
            return back();
        } else {
            toast('Site Can Not Deleted!!', 'error');
            return back();
        }
    }
}
