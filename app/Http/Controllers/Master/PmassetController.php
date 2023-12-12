<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Exception;

class PmassetController extends Controller
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

        $data = DB::table('pma_asset')
            ->selectRaw('asset_mstr.*, pmc_mstr.*, pma_asset.id as pma_id, pma_asset, pma_pmcode, pma_leadtime, pma_leadtimeum, 
                pma_mea, pma_cal, pma_calum, pma_meter, pma_meterum, pma_tolerance, pma_start, pma_eng')
            ->leftJoin('asset_mstr','asset_code','pma_asset')
            ->leftJoin('pmc_mstr','pmc_code','pma_pmcode')
            ->orderby('pma_asset')
            ->orderby('pma_pmcode');

        if($s_code) {
            $data = $data->where('pma_asset','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('pma_pmcode','like','%'.$s_desc.'%');
        }

        $data = $data->paginate(10);

        $dataasset = Db::table('asset_mstr')
            ->whereAsset_active('Yes')
            ->orderBy('asset_code')
            ->get();

        $datapm = DB::table('pmc_mstr')
            ->wherePmcType('PM')
            ->orderby('pmc_code')
            ->get();

        $dataeng = DB::table('eng_mstr')
            ->whereEng_active('Yes')
            ->orderBy('eng_code')
            ->get();

        $dataum = DB::table('um_mstr')
            ->orderBy('um_code')
            ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        return view('setting.pmasset', compact('data','dataasset','datapm','dataeng','dataum','dataloc'));
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

    //cek dobel data asset dan PM code yang sama
    public function cekpmmtc(Request $req)
    {
        
        $cek = DB::table('pma_asset')
            ->wherePmaAsset($req->asset)
            ->wherePmaPmcode($req->pmcode);

        if ($cek->count() == 0) {
            return "tidak";
        } else {
            return "ada";
        }
    }

    //untuk menampilkan select engineer
    public function pickeng(Request $req)
    {
        if($req->ajax()){
            $eng = DB::table('eng_mstr')
                ->whereEng_active('Yes')
                ->orderBy('eng_code')
                ->get();

            $array = json_decode(json_encode($eng), true);

            return response()->json($array);
        }
    }

    //untuk menampilkan asset sesuai dengan lokasi yang dipilih
    public function searchasset(Request $req)
    {
        if ($req->ajax()) {
            $loc = $req->get('loc');
      
            $data = DB::table('asset_mstr')
                    ->where('asset_loc','=',$loc)
                    ->get();

            $output = '<option value="" >Select</option>';
            foreach($data as $data){

                $output .= '<option value="'.$data->asset_code.'" >'.$data->asset_code.' -- '.$data->asset_desc.'</option>';
                           
            }

            return response($output);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //cek apakah terdapat data yang sama
        $cekdata = DB::table('pma_asset')
            ->wherePmaAsset($req->t_asset)
            ->wherePmaPmcode($req->t_pmcode)
            ->count();

        if ($cekdata > 0) {
            toast('Data Already Registered!!', 'error');
            return back();
        }

        $eng = "";
        if(!is_null($req->t_eng)) {
            $flg = 0;
            foreach ($req->t_eng as $ds) {
                $eng = $eng . $req->t_eng[$flg] . ";" ;
                $flg += 1;
            }
        } 
        
        DB::table('pma_asset')
            ->insert([
                'pma_asset' => $req->t_asset,
                'pma_pmcode' => $req->t_pmcode,
                'pma_leadtime' => $req->t_time,
                'pma_mea' => $req->t_mea,
                'pma_cal' => $req->t_cal,
                'pma_meter' => $req->t_meter,
                'pma_meterum' => $req->t_durum,
                'pma_tolerance' => $req->t_tol,
                'pma_start' => $req-> t_start,
                'pma_eng' => substr($eng, 0, -1),
                'pma_editedby'  => Session::get('username'),
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
            ]);

        toast('Preventive Maintenance Created.', 'success');
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
    public function update(Request $req)
    {
        // dd($req->all());

        //cek data dobel, tidak boleh menyimpan data dengan asset dan pmcode yang sudah terdaftar
        $cekdata = DB::table('pma_asset')
            ->wherePmaAsset($req->te_asset)
            ->wherePmaPmcode($req->te_pmcode)
            ->where('id','<>',$req->te_pmaid)
            ->count();

        if($cekdata > 0) {
            toast('Asset code with PM code selected is already registered!!!', 'error');
            return back();
        }

        $eng = "";
        if(!is_null($req->te_eng)) {
            $flg = 0;
            foreach ($req->te_eng as $ds) {
                $eng = $eng . $req->te_eng[$flg] . ";" ;
                $flg += 1;
            }
        } 
        
        $asset = DB::table('pma_asset')
            // ->wherePmaAsset($req->te_asset)
            // ->wherePmaPmcode($req->te_pmcode)
            ->where('id',$req->te_pmaid)
            // ->get();
            ->update([
                'pma_pmcode' => $req->te_pmcode,
                'pma_leadtime' => $req->te_time,
                'pma_mea' => $req->te_mea,
                'pma_cal' => $req->te_cal,
                'pma_meter' => $req->te_meter,
                'pma_meterum' => $req->te_durum,
                'pma_tolerance' => $req->te_tol,
                'pma_start' => $req-> te_start,
                'pma_eng' => substr($eng, 0, -1),
                'pma_editedby'  => Session::get('username'),
                'created_at'    => Carbon::now()->toDateTimeString(),
            ]);
// dd($req->pmaid);
        toast('Preventive Maintenance Updated.', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        /** Melakukan pengecekan apakah data sudah di pakai di wo_mstr */
        $cek = DB::table('wo_mstr')
            ->whereWoMtCode($req->d_pmcode)
            ->whereWoAssetCode($req->d_asset)
            ->count();

        if ($cek > 0) {
            toast('Data can not be deleted, data has been used for the transaction!!!.', 'error');
            return back();
        } else {
            DB::beginTransaction();
            try {
                $data = DB::table('pma_asset')
                ->wherePma_asset($req->d_asset)
                ->wherePma_pmcode($req->d_pmcode)
                ->delete();

                DB::commit();

                toast('Preventive Maintenance Deleted.', 'success');
                return back();
            } catch (Exception $err) {
                DB::rollBack();
    
                dd($err);
                toast('Preventive Maintenance Error, please re-generate again.', 'success');
                return back();
            }
        }
        

        
    }
}
