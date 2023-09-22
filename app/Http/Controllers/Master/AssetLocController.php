<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AssetLocController extends Controller
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
        $ss_code = $req->ss_code;
        $ss_desc = $req->ss_desc;
        /* if (strpos(Session::get('menu_access'), 'MT04') !== false) { */
            $dataSite = DB::table('asset_site')
                ->get();

            $data = DB::table('asset_loc')
                ->join('asset_site','assite_code','=','asloc_site')
                ->orderby('asloc_site')
                ->orderby('asloc_code');
            
            if($s_code) {
                $data = $data->where('asloc_site','like','%'.$s_code.'%');
            }
            if($s_desc) {
                $data = $data->where('assite_desc','like','%'.$s_desc.'%');
            }
            if($ss_code) {
                $data = $data->where('asloc_code','like','%'.$ss_code.'%');
            }
            if($ss_desc) {
                $data = $data->where('asloc_desc','like','%'.$ss_desc.'%');
            }

            $data = $data->paginate(10);

            return view('setting.asset-loc', ['data' => $data, 'dataSite' => $dataSite]);
        /* } else {
            toast('You do not have menu access, please contact admin.', 'error');
            return back();
        } */
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
        /** Kode lokasi tidak boleh sama. Jika mempunya nama lokasi nya sama tapi beda site, sebaiknya dibedakan saja site nya. 
         * Karena jika satu lokasi bisa digunakan multi site, maka akan berpengaruh ke banyak transaksi */
        $cekData = DB::table('asset_loc')
                // ->where('asloc_site','=',$request->t_site)
                ->where('asloc_code','=',$request->t_locationid)
                ->get();

        if ($cekData->count() == 0) {
            DB::table('asset_loc')
            ->insert([
                'asloc_site'      => $request->t_site,
                'asloc_code'      => $request->t_locationid,
                'asloc_desc'      => $request->t_locationdesc,                
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
                'edited_by'     => Session::get('username'),
            ]);

            toast('Location Successfully.', 'success');
            return back();
        } else {
            toast('Location is Already Registerd!!', 'error');
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
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cekData = DB::table('asset_loc')
                ->where('asloc_site','=',$request->te_site)
                ->where('asloc_desc','=',$request->te_locationdesc)
                ->get();

        if ($cekData->count() == 0) {
            DB::table('asset_loc')
            ->where('asloc_site','=',$request->te_site)
            ->where('asloc_code','=',$request->te_locationid)
            ->update([
                'asloc_desc'      => $request->te_locationdesc,
                'updated_at'    => Carbon::now()->toDateTimeString(),
                'edited_by'     => Session::get('username'),
            ]);

            toast('Asset Location Updated.', 'success');
            return back();
        } else {
            toast('Asset Location Description is Already Registerd!!', 'error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //cek data di asset
        $cekData = DB::table('asset_mstr')
                ->where('asset_loc', '=', $request->d_locationid)
                ->where('asset_site', '=', $request->d_site)
                ->get();

        if ($cekData->count() == 0) {
            DB::table('Asset_loc')
            ->where('asloc_code', '=', $request->d_locationid)
            ->where('asloc_site', '=', $request->d_site)
            ->delete();

            toast('Deleted Location Successfully.', 'success');
            return back();
        } else {
            toast('Location Can Not Deleted!!', 'error');
            return back();
        }
    }
}
