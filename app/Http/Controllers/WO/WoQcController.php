<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WoQcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $dataApproval = DB::table('wo_mstr')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
                        ->where('wo_status', '=', 'completed')
                        ->orderBy('wo_updated_at');

        if ($request->s_nomorwo) {
            $dataApproval->where('wo_nbr', '=', $request->s_nomorwo);
        }

        if ($request->s_asset) {
            $dataApproval->where('asset_code', '=', $request->s_asset);
        }

        if ($request->s_priority) {
            $dataApproval->where('wo_priority', '=', $request->s_priority);
        }

        $dataApproval = $dataApproval->paginate(10);


        return view('workorder.woqcappr', compact('dataApproval'));
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
