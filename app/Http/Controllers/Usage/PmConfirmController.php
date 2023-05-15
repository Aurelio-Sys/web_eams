<?php

namespace App\Http\Controllers\Usage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PmConfirmController extends Controller
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

        $data = DB::table('pmo_confirm')
            ->leftJoin('asset_mstr','asset_code','=','pmo_asset')
            ->orderBy('asset_code')
            ->orderBy('pmo_pmcode')
            ->orderBy('pmo_sch_date');

        if($s_code) {
            $data = $data->where('asset_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('pmo_pmcode','like','%'.$s_desc.'%');
        }

        $data = $data->paginate(10);

        $datalog = DB::table('pml_log')
            ->orderBy('pml_asset')
            ->orderBy('pml_pmcode')
            ->get();

        return view('schedule.pmconf', compact('data', 'datalog'));
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

    //menampilkan detail edit
    public function searchlog(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('pml_log')
                    ->wherePmlWoNumber($req->code)
                    ->first();

            $output = '';
            $output .=  '<tr>'.
                        '<td>TEMP-PM'.
                        '<td>'.$data->pml_pm_number.
                        '<td>'.$data->pml_pm_date.
                        '<td><input type="radio" id="opt1" name="opt" value="te_pm">'.
                        '</tr>'.
                        '<tr>'.
                        '<td>WO'.
                        '<td>'.$data->pml_wo_number.
                        '<td>'.$data->pml_wo_date.
                        '<td><input type="radio" id="opt2" name="opt" value="te_wo">'.
                        '</tr>';

            return response($output);
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
    public function destroy($id)
    {
        //
    }
}
