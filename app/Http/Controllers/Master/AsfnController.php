<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Facade\Ignition\Tabs\Tab;

class AsfnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('asfn_det')
            ->select('asgroup_code','asgroup_desc','wotyp_code','wotyp_desc')
            ->join('asset_group','asgroup_code','=','asfn_asset')
            ->join('wotyp_mstr','wotyp_code','=','asfn_fntype')
            ->distinct()
            ->orderBy('asfn_asset')
            ->orderBy('asfn_fntype')
            ->orderBy('asfn_fncode');

        $data = $data->paginate(10);

        $dataasgroup = DB::table('asset_group')
            ->orderBy('asgroup_code')
            ->get();

        $datafntype = DB::table('wotyp_mstr')
            ->orderBy('wotyp_code')
            ->get();

        $datafncode = DB::table('fn_mstr')
            ->orderBy('fn_code')
            ->get();

        return view('setting.asfn',compact('data','dataasgroup','datafntype','datafncode'));
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

    /* Cek data */
    public function cekasfn(Request $req) {
        if ($req->ajax()) {
            // dd($req->all());
            $sasset = $req->get('sasset');
            $sfntype = $req->get('sfntype');
      
            $data = DB::table('asfn_det')
                    ->where('asfn_asset','=',$sasset)
                    ->where('asfn_fntype','=',$sfntype)
                    ->count();

            if ($data == 0) {
                return "tidak";
            } else {
                return "ada";
            }
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
        //cek parent sudah terdaftar atau belum
        $cekData = DB::table('asfn_det')
                ->where('asfn_asset','=',$req->t_asset)
                ->where('asfn_fntype','=',$req->t_fntype)
                ->count();
        if ($cekData > 0) {
            toast('Data Already Registered!!', 'error');
            return back();
        }

        $flg = 0;
        foreach($req->barang as $barang){
            DB::table('asfn_det')
            ->insert([
                'asfn_asset'     => $req->t_asset,
                'asfn_fntype'   => $req->t_fntype,        
                'asfn_fncode'   => $req->barang[$flg],        
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
                'edited_by'     => Session::get('username'),
            ]);

            $flg += 1;
        }    

        toast('Mapping Asset - Failure Created.', 'success');
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

    //menampilkan detail edit
    public function editdetailasfn(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('asfn_det')
                    ->join('fn_mstr','fn_code','=','asfn_fncode')
                    ->where('asfn_asset','=',$req->asset)
                    ->where('asfn_fntype','=',$req->fntype)
                    ->orderBy('asfn_asset')
                    ->orderBy('asfn_fntype')
                    ->orderBy('asfn_fncode')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<input type="hidden" class="form-control" name="barang[]" readonly value="'.$data->fn_code.'">'.
                            '<td>'.$data->fn_code.'--'.$data->fn_desc.'</td>'.
                            '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">
                            <input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>'.
                            '</tr>';
            }

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
    public function update(Request $req)
    {
        // dd($req->all());
        // delete terlebih dahulu data nya
        DB::table('asfn_det')
            ->where('asfn_asset','=',$req->te_asset)
            ->where('asfn_fntype','=',$req->te_fntype)
            ->delete();
        
        $flg = 0;
        foreach($req->barang as $barang){
            if($req->tick[$flg] == 0) {
                DB::table('asfn_det')
                ->insert([
                    'asfn_asset'     => $req->te_asset,
                    'asfn_fntype'   => $req->te_fntype,        
                    'asfn_fncode'   => $req->barang[$flg],        
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                    'edited_by'     => Session::get('username'),
                ]);
            }    
            $flg += 1;
        }    

        toast('Mapping Asset - Failure Updated.', 'success');
        return back();
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
