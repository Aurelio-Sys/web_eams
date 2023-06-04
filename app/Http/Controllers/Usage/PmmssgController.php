<?php

namespace App\Http\Controllers\Usage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PmmssgController extends Controller
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

        $data = DB::table('pml_log')
            ->leftJoin('asset_mstr','asset_code','=','pml_asset')
            ->leftJoin('msg_mstr','msg_code','=','pml_message')
            ->select('pml_log.*','asset_code','asset_desc','msg_desc')
            ->orderBy('pml_asset')
            ->orderBy('pml_pmcode');

        // if($s_code) {
        //     $data = $data->where('asset_code','like','%'.$s_code.'%');
        // }
        // if($s_desc) {
        //     $data = $data->where('pmo_pmcode','like','%'.$s_desc.'%');
        // }

        $data = $data->paginate(10);

        return view('schedule.pmmssg', compact('data'));
    }

    public function chgdatewo(Request $req) {
        DB::beginTransaction();
        try {

            // Mencari WO number yang datanya akan di update
            $data = DB::table('pml_log')
                ->whereId($req->d_code)
                ->first();

            // Mencari selisih hari antara start date dan due date sebelum tanggal berubah sesuai dengan data log
            $datawo = DB::table('wo_mstr')
                ->whereWoNumber($data->pml_wo_number)
                ->first();

            $waktuawal  = date_create($datawo->wo_start_date); 
            $waktuakhir = date_create($datawo->wo_due_date); 
            $diff  = date_diff($waktuawal, $waktuakhir);

            $tglsch = date_create($data->pml_pm_date);

            DB::table('wo_mstr')
                ->whereWoNumber($data->pml_wo_number)
                ->update([
                    'wo_start_date' => $data->pml_pm_date,
                    'wo_due_date' => date_add(date_create($data->pml_pm_date), date_interval_create_from_date_string(''.$diff->days.' days')),
                    'wo_system_update' => Carbon::now()->toDateTimeString(),
                ]);

            // Melakukan update data di pml_log agar browse berubah datanya sesuai WO
            DB::table('pml_log')
                ->whereId($req->d_code)
                ->update([
                    'pml_message' => "NF006",
                    'pml_wo_date' => $data->pml_pm_date,
                ]);

            DB::commit();
            toast('Work Order Updated Success', 'success');
            return redirect()->route('pmmssg');
        } catch (Exception $err) {
            DB::rollBack();

            dd($err);
            toast('Work Order Updated Error, please confirm again.', 'success');
            return back();
        }
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
