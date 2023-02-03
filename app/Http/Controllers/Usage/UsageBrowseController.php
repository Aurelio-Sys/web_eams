<?php

namespace App\Http\Controllers\Usage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class UsageBrowseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $sasset = $req->s_asset;

        $dataus = DB::table('us_hist')
            ->selectRaw('asset_code,asset_desc,us_asset_site,asloc_desc,us_mea_um,us_date,us_time,
                us_last_mea,us_hist.edited_by,us_hist.created_at,us_no_pm')
            ->Join('asset_mstr','asset_code','=','us_asset')
            ->Join('asset_site','assite_code','=','us_asset_site')
            ->Join('asset_loc','asloc_code','=','us_asset_loc')
            ->orderBy('us_date','desc')
            ->orderBy('us_asset');

        if($sasset) {
            $dataus = $dataus->where('us_asset','=',$sasset);
        }

        $dataus = $dataus->paginate(10);

        $dataasset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        return view('schedule.usbrowse', compact('dataus','dataasset','sasset'));
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
