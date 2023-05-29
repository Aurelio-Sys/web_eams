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
            ->leftJoin('pmc_mstr','pmc_code','=','pmo_pmcode')
            // ->leftjoin('pma_asset', function ($join) {
            //     $join->on('pmo_confirm.pmo_asset', '=', 'pma_asset.pma_asset')
            //         ->on('pmo_confirm.pmo_pmcode', '=', 'pma_asset.pma_pmcode');     
            // })
            ->select('pmo_confirm.*','asset_code','asset_desc','pmc_desc')
            ->whereNotIn('pmo_number', function ($query) {
                $query->select('pml_pm_number')->from('pml_log');
            })
            ->orderBy('asset_code')
            ->orderBy('pmo_pmcode')
            ->orderBy('id');

        if($s_code) {
            $data = $data->where('asset_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('pmo_pmcode','like','%'.$s_desc.'%');
        }

        $data = $data->paginate(10);
// dd($data);
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


    public function getdetpmco(Request $req){
        $code = $req->get('code');

        //ambil data dari tabel inc_source berdasarkan asset site nya
        $qdata = DB::table('pml_log')
                    ->wherePmlWoNumber($req->code)
                    ->first();

        $data = [];

        array_push($data, [
            'det_pm_number' => (string) "PM".$qdata->pml_pm_number,
            'det_pm_date' => (string) date('d-m-Y', strtotime($qdata->pml_pm_date)),
            'det_wo_number' => (string) $qdata->pml_wo_number,
            'det_wo_date' => (string) date('d-m-Y', strtotime($qdata->pml_wo_date)),
        ]);

        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        
        DB::beginTransaction();

        try {

            $flg = 0;
            foreach($req->he_wonbr as $he_wonbr){
                // Membuat WO berdasarkan transaksi yang di beri tanda tick 
                if($req->tick[$flg] == 1 ) {
                    // masuk konsisi ini jika source dari TEMP-PM maka terbentuk data work order dengantype PM dan numbering menggunakan PM
                    if($req->he_pick[$flg] == "TEMP-PM") {
                        // Mencari nomor PM terakhir
                        $tablern = DB::table('running_mstr')
                        ->first();
                        $newyear = Carbon::now()->format('y');

                        if ($tablern->year == $newyear) {
                            $tempnewrunnbr = strval(intval($tablern->wt_nbr) + 1);
                            $newtemprunnbr = '';

                            if (strlen($tempnewrunnbr) < 6) {
                                $newtemprunnbr = str_pad($tempnewrunnbr, 6, '0', STR_PAD_LEFT);
                            }
                        } else {
                            $newtemprunnbr = "000001";
                        }

                        $runningnbr = $tablern->wt_prefix . '-' . $newyear . '-' . $newtemprunnbr;

                        // Mencari site asset
                        $dataasset = DB::table('asset_mstr')
                            ->whereAssetCode($req->te_asset[$flg])
                            ->first();

                        // Mencari data detail preventive asset
                        $datapm = DB::table('pma_asset')
                            ->wherePmaAsset($req->te_asset[$flg])
                            ->wherePmaPmcode($req->te_pmcode[$flg])
                            ->first();

                        if($datapm) {
                            $deng = $datapm->pma_eng;
                            $dleadtime = $datapm->pma_leadtime;
                        } else {
                            $deng = null;
                            $dleadtime = 0;
                        }

                        if(is_null($dleadtime)) {
                            $dleadtime = 0;
                        }

                        // Mencari data detail untuk PM Code
                        $datapmcode = DB::table('pmc_mstr')
                            ->wherePmcCode($req->te_pmcode[$flg])
                            ->first();

                        if($datapmcode) {
                            $dins = $datapmcode->pmc_ins;
                            $dspg = $datapmcode->pmc_spg;
                            $dqcs = $datapmcode->pmc_qcs;
                        } else {
                            $dins = null;
                            $dspg = null;
                            $dqcs = null;
                        }

                        $dataarray = array(
                            'wo_number'           => $runningnbr,
                            'wo_sr_number'          => '',
                            'wo_asset_code'          => $req->te_asset[$flg],
                            'wo_site'             => $dataasset->asset_site,
                            'wo_type'              => 'PM',
                            'wo_status'              => 'firm',
                            'wo_list_engineer'    => $deng, 
                            'wo_start_date'       => $req->te_pmdate[$flg],
                            'wo_due_date'          => Carbon::createFromFormat('Y-m-d', $req->te_pmdate[$flg])->addDays($dleadtime),
                            'wo_mt_code'          => $req->te_pmcode[$flg], // $req->has('c_mtcode') ? $req->c_mtcode : null,
                            'wo_ins_code'          => $dins,
                            'wo_sp_code'          => $dspg,
                            'wo_qcspec_code'      => $dqcs,
                            'wo_createdby'          => 'ADMIN',
                            'wo_department'       => 'ENG',
                            'wo_system_create'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wo_system_update'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(), 
                        );

                        DB::table('wo_mstr')->insert($dataarray);
            
                        DB::table('wo_trans_history')
                            ->insert([
                                'wo_number' => $runningnbr,
                                'wo_action' => 'firm',
                            ]);
            
                        DB::table('running_mstr')
                            // ->where('wt_nbr', '=', $tablern->wo_nbr)   // ini kenapa pakai where yaaa??
                            ->update([
                                'year' => $newyear,
                                'wt_nbr' => $newtemprunnbr
                            ]);

                        // Jika sudah di confirm dari WO, maka hapus dari tabel pmo_confirm agar tidak muncul lagi pada saat memilih confirm WO
                        DB::table('pmo_confirm')
                            ->wherePmoAsset($req->te_asset[$flg])
                            ->wherePmoPmcode($req->te_pmcode[$flg])
                            ->wherePmoSchDate($req->te_pmdate[$flg])
                            ->delete();
                    } // END if($req->he_pick[$flg] == "TEMP-PM") 
                    else {      // ELSE if($req->he_pick[$flg] == "TEMP-PM") 
                        // masuk konsisi ini jika source dari WO, data dari pmo_confirm dihapus agar tidak muncul lagi pada saat memilih confirm WO
                        DB::table('pmo_confirm')
                            ->whereId($req->te_id[$flg])
                            ->delete();
                    }       // END ELSE if($req->he_pick[$flg] == "TEMP-PM") 
                    
                } // END if($req->tick[$flg] == 1)
                
                $flg += 1;  
            } // END foreach($req->he_wonbr as $he_wonbr)
            // dd('stop');
            DB::commit();
            toast('Work Order Generated Success', 'success');
            return back();
        } catch (Exception $err) {
            DB::rollBack();

            dd($err);
            toast('Work Order Generated Error, please re-generate again.', 'success');
            return back();
        }
        
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