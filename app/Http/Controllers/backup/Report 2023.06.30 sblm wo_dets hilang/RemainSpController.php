<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class RemainSpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $swo = $request->s_nomorwo;
        $sasset = $request->s_asset;
        // $sper1 = Carbon::createFromDate($request->s_per1;
        // $sper2 = Carbon::createFromDate($request->s_per1)->subDay();
        $sper1 = $request->s_per1;
        $sper2 = $request->s_per1;
        $ssp = $request->s_sp;
        $seng = $request->s_eng;
// dd($sper1);
        $dataremsp = DB::table('wo_dets')
            ->join('wo_mstr','wo_nbr','=','wo_dets_nbr')
            ->join('sp_mstr','spm_code','=','wo_dets_sp')
            ->join('asset_mstr','asset_code','=','wo_asset')
            // ->where('wo_status','=','finish')
            ->where('wo_dets_sp_qty','>','wo_dets_qty_used');

        // dd($dataremsp->get());

        if($swo) {
            $dataremsp = $dataremsp->where('wo_nbr','like','%'.$swo.'%');
        }
        if($sasset) {
            $dataremsp = $dataremsp->where('wo_asset','=',$sasset);
        }
        if($sper1) {
            $dataremsp = $dataremsp->whereBetween('wo_created_at',[$sper1,$sper2]);
        }
        if($ssp) {
            $dataremsp = $dataremsp->where('wo_dets_sp',$ssp);
        }
        if($seng) {
            $dataremsp = $dataremsp->where('wo_engineer1','=',$seng)
                ->orWhere('wo_engineer2','=',$seng)
                ->orWhere('wo_engineer3','=',$seng)
                ->orWhere('wo_engineer4','=',$seng)
                ->orWhere('wo_engineer5','=',$seng);
        }

        $dataremsp = $dataremsp->paginate(10);

        $datasp = DB::table('sp_mstr')
            ->orderBy('spm_code')
            ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        $dataasset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        $dataeng = DB::table('eng_mstr')
            ->orderBy('eng_code')
            ->get();

        $datadept = DB::table('dept_mstr')
            ->orderBy('dept_code')
            ->get();

        return view('report.remainsp', ['data' => $dataremsp, 'datasp' => $datasp, 'dataasset' => $dataasset, 'dataloc' => $dataloc,
            'dataeng' => $dataeng, 'datadept' => $datadept, 'swo' => $swo, 'sasset' => $sasset, 'sper1' => $sper1,
            'sper2' => $sper2, 'seng' => $seng, 'ssp' => $ssp]);
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
