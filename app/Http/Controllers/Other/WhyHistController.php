<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class WhyHistController extends Controller
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
        $s_loc = $req->s_loc;

        $data = DB::table('why_hist')
            ->leftJoin('asset_mstr','asset_code','=','why_asset')
            ->orderby('asset_code');

        /* if($s_code) {
            $data = $data->where(function($query) use ($s_code) {
                $query->where('inp_asset_site','like','%'.$s_code.'%')
                ->orWhere('assite_desc','like','%'.$s_code.'%');
            });
        }
        if($s_desc) {
            $data = $data->where(function($query) use ($s_desc) {
                $query->where('inp_supply_site','like','%'.$s_desc.'%')
                ->orWhere('site_desc','like','%'.$s_desc.'%');
            });
        } */

        $data = $data->paginate(10);

        $dataasset = DB::table('asset_mstr')
            ->whereAsset_active('Yes')
            ->orderBy('asset_code')
            ->get();

        $datawo = DB::table('wo_mstr')
            ->orderBy('wo_number')
            ->get();

        return view('booking.whyhist', compact('data','dataasset','datawo'));
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
        DB::table('why_hist')
            ->insert([
                'why_asset' => $req->t_asset,
                'why_wo' => $req->t_wo,
                'why_problem' => $req->t_problem,
                'why_why1' => $req->t_why1,
                'why_why2' => $req->t_why2,
                'why_why3' => $req->t_why3,
                'why_why4' => $req->t_why4,
                'why_why5' => $req->t_why5,
                'why_editedby'  => Session::get('username'),
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
            ]);

        toast('Transactions Created.', 'success');
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
