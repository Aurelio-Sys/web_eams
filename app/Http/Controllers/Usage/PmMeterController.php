<?php

namespace App\Http\Controllers\Usage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Facade\Ignition\Tabs\Tab;

class PmMeterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataasset = DB::table('pma_asset')
            ->leftJoin('asset_mstr','asset_code','pma_asset')
            ->whereAssetActive('Yes')
            ->whereIn('pma_mea',['B','M'])
            ->orderBy('pma_asset')
            ->groupBy('pma_asset')
            ->get();

        $dataloc = DB::table('pma_asset')
            ->leftJoin('asset_mstr','asset_code','pma_asset')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->select('asloc_code','asloc_desc')
            ->whereAssetActive('Yes')
            ->whereIn('pma_mea',['B','M'])
            ->orderBy('asset_loc')
            ->groupBy('asset_loc')
            ->get();

        return view('schedule.pmmeter', compact('dataasset','dataloc'));
    }

    //untuk menampilkan asset sesuai dengan lokasi yang dipilih
    public function searchassetmeter(Request $req)
    {
        if ($req->ajax()) {
            $loc = $req->get('loc');
      
            $data = DB::table('pma_asset')
                ->leftJoin('asset_mstr','asset_code','pma_asset')
                ->whereAssetActive('Yes')
                ->whereIn('pma_mea',['B','M'])
                ->where('asset_loc','=',$loc)
                ->orderBy('pma_asset')
                ->groupBy('pma_asset')
                ->get();

            $output = '<option value="" >Select</option>';
            foreach($data as $data){

                $output .= '<option value="'.$data->asset_code.'" >'.$data->asset_code.' -- '.$data->asset_desc.'</option>';
                           
            }

            return response($output);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function pmmetergen(Request $req) {
        // Mencari data asset yang hasil pengukurannya harus dilakukan preventive
        $results = DB::table('pma_asset')
            ->select('pma_asset', 'pma_pmcode', 'pma_meter', 'pma_meterum', 'pma_lastmea', 'maxmea')
            ->leftJoin('asset_mstr','asset_code','=','pma_asset')
            ->join(DB::raw('(SELECT us_asset as asset, us_mea_um as um, MAX(us_last_mea) as maxmea FROM us_hist GROUP BY us_asset, us_mea_um) AS tmptable'), function ($join) {
                $join->on('pma_asset.pma_asset', '=', 'tmptable.asset')
                    ->on('pma_asset.pma_meterum', '=', 'tmptable.um');
            })
            ->whereIn('pma_mea', ['M', 'B'])
            // ->where('pma_asset', 'BGNKG03')
            ->whereRaw('(pma_meter + pma_lastmea) < maxmea');

        if($req->asset) {
            $results = $results->where('pma_asset','=',$req->asset);
        }
        if($req->t_loc) {
            $results = $results->where('asset_loc','=',$req->t_loc);
        }

        $results = $results->get();

        // Mencari data Work order yang sudah terbentuk
        $datawo = DB::table('wo_mstr')
            ->whereWo_type('PM')
            // ->where('wo_asset_code', 'BGNKG03')
            ->whereIn('wo_status',['firm','released','started','finished'])
            ->get();

        try {
            foreach($results as $dc){
                //disimpan pada tabel sementara
                DB::table('pmt_temp')
                    ->insert([
                        'pmt_asset' => $dc->pma_asset,
                        'pmt_pmcode' =>$dc->pma_pmcode,
                        'pmt_sch_date' => Carbon::now(),  
                        'pmt_message' => 'PM Meter',
                        'pmt_editedby'  => Session::get('username'),
                        'created_at'    => Carbon::now()->toDateTimeString(),
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                    ]);
                
                //Mencari ID dari tabel sementara untuk disimpan di tabel confirm atau notif
                $idtemp = DB::table('pmt_temp')
                    ->selectRaw('max(id) as maxid')
                    ->first();

                // Mencari data di work order berdasarkan asset dan pm code nya
                $cekwo = $datawo->where('wo_asset_code','=',$dc->pma_asset)->where('wo_mt_code','=',$dc->pma_pmcode)->first();
                // Jika data tidak ada di work order maka akan disimpan di pm confirm (tabel pmo_confirm)
                if(!$cekwo) {
                    // dd('1');
                    DB::table('pmo_confirm')
                        ->Insert([
                            'pmo_asset' => $dc->pma_asset,
                            'pmo_pmcode' => $dc->pma_pmcode,
                            'pmo_sch_date' => Carbon::now(),  
                            'pmo_source' => 'PM Meter',
                            'pmo_number' => $idtemp->maxid,
                            'pmo_user'  => Session::get('username'),
                            'pmo_dept'  => Session::get('department'),
                            'created_at'    => Carbon::now()->toDateTimeString(),
                        ]);
                } else {    // Jika data ada di Work order maka akan di simpan di notif message (tabel pml_log)
                    // dd('2');
                    DB::table('pml_log')
                        ->insert([
                            'pml_asset' => $dc->pma_asset,
                            'pml_pmcode' => $dc->pma_pmcode,
                            'pml_pm_number' => $idtemp->maxid,
                            'pml_pm_date' => Carbon::now(),  
                            'pml_wo_number' => $cekwo->wo_number,
                            'pml_wo_date' => $cekwo->wo_start_date,
                            'pml_message' => 'NF007',
                            'pml_user'  => Session::get('username'),
                            'pml_dept'  => Session::get('department'),
                            'created_at'    => Carbon::now()->toDateTimeString(),
                        ]);
                }
                
            }
                
            DB::commit();
            toast('PM Generated Success', 'success');
            return back();
        } catch (Exception $err) {
            DB::rollBack();

            dd($err);
            toast('PM Generated Error, please re-generate again.', 'success');
            return back();
        }
     }

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
