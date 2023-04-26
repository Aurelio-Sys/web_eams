<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class InvSuController extends Controller
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

        $data = DB::table('inp_supply')
            ->leftJoin('asset_site','assite_code','=','inp_asset_site')
            ->leftJoin('site_mstrs','site_code','=','inp_supply_site')
            ->select('inp_asset_site','inp_supply_site','assite_desc','site_desc')
            ->orderby('inp_asset_site')
            ->orderBy('inp_supply_site')
            ->groupBy('inp_asset_site','inp_supply_site');

        
        if($s_code) {
            $data = $data->where('inp_asset_site','like','%'.$s_code.'%')
                ->orWhere('assite_desc','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('inp_supply_site','like','%'.$s_desc.'%')
            ->orWhere('site_desc','like','%'.$s_desc.'%');
        }
        

        $data = $data->paginate(10);

        $datadet = DB::table('inp_supply')
            ->orderby('inp_asset_site')
            ->orderBy('inp_supply_site')
            ->orderBy('inp_sequence')
            ->get();

        $dataassite = DB::table('asset_site')
            ->orderBy('assite_code')
            ->get();

        $dataspsite = DB::table('site_mstrs')
            ->whereSite_flag('Yes')
            ->orderBy('site_code')
            ->get();

        $dataloc = DB::table('loc_mstr')
            ->whereLoc_active('Yes')
            ->orderBy('loc_code')
            ->get();

        return view('setting.invsu', compact('data','datadet','dataassite','dataspsite','dataloc'));
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
        if($req->t_step) {
            $flg = 0;
            foreach($req->t_step as $t_step){
                DB::table('inp_supply')
                    ->insert([
                        'inp_asset_site' => $req->t_code,
                        'inp_supply_site' => $req->t_desc,
                        'inp_sequence' => $req->t_step[$flg],
                        'inp_loc' => $req->a_code[$flg],
                        'inp_editedby'  => Session::get('username'),
                        'created_at'    => Carbon::now()->toDateTimeString(),
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                    ]);
                $flg += 1;
            }

            toast('Inventory Supply Created.', 'success');
            return back();
        } else {
            toast('Detail Not Found!', 'error');
            return back();
        }
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
    public function editdetinvsu(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('inp_supply')
                    ->whereInp_asset_site($req->code1)
                    ->whereInp_supply_site($req->code2)
                    ->orderBy('inp_sequence')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<td><input type="text" class="form-control" name="te_step[]" value="'.$data->inp_sequence.'" readonly></td>'.
                            '<td><input type="text" class="form-control" name="te_loc[]" value="'.$data->inp_loc.'" readonly></td>'.
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
        // cari tanggal create
        $dcreate = DB::table('inp_supply')
            ->whereInp_asset_site($req->te_code)
            ->whereInp_supply_site($req->te_desc)
            ->value('created_at');

        // delete terlebih dahulu data nya
        DB::table('inp_supply')
            ->whereInp_asset_site($req->te_code)
            ->whereInp_supply_site($req->te_desc)
            ->delete();
        
        $flg = 0;
        foreach($req->te_step as $te_step){
            if($req->tick[$flg] == 0) {
                DB::table('inp_supply')
                ->insert([
                    'inp_asset_site' => $req->te_code,
                    'inp_supply_site' => $req->te_desc,
                    'inp_sequence' => $req->te_step[$flg],
                    'inp_loc' => $req->te_loc[$flg],
                    'inp_editedby'  => Session::get('username'),
                    'created_at'    => $dcreate,
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
            }
            $flg += 1;  
        }

        toast('Inventory Supply Updated.', 'success');
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
        DB::table('inp_supply')
            ->whereInp_asset_site($req->d_code)
            ->whereInp_supply_site($req->d_desc)
            ->delete();

        toast('Inventory Supply Successfully.', 'success');
        return back();
    }
}
