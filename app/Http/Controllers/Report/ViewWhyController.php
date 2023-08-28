<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Exception;

class ViewWhyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $s_asset = $req->s_asset;
        $s_wo = $req->s_wo;
        $s_problem = $req->s_problem;
        $s_key = $req->s_key;

        $data = DB::table('why_hist')
            ->selectRaw('why_hist.id as id, why_asset, why_wo, why_key, why_problem, why_why1, why_why2, why_why3, why_why4, why_why5,
                why_inputby, why_hist.created_at as created_at, asset_desc')
            ->leftJoin('asset_mstr','asset_code','=','why_asset')
            ->orderBy('why_hist.created_at','desc')
            ->orderby('asset_code');

        if($s_asset) {
            $data = $data->where(function($query) use ($s_asset) {
                $query->where('why_asset','like','%'.$s_asset.'%')
                ->orWhere('asset_desc','like','%'.$s_asset.'%');
            });
        }
        if($s_wo) {
            $data = $data->where('why_wo','like','%'.$s_wo.'%');
        }
        if($s_problem) {
            $data = $data->where('why_problem','like','%'.$s_problem.'%');
        }
        if($s_key) {
            $data = $data->where('why_key','like','%'.$s_key.'%');
        }

        $data = $data->paginate(10);

        $dataasset = DB::table('asset_mstr')
            ->whereAsset_active('Yes')
            ->orderBy('asset_code')
            ->get();

        $datawo = DB::table('wo_mstr')
            ->orderBy('wo_number')
            ->get();

        return view('report.viewwhy', compact('data','dataasset','datawo'));
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
