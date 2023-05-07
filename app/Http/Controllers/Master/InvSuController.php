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
            ->leftJoin('loc_mstr', function($join) {
                $join->on('loc_mstr.loc_code', '=', 'inp_supply.inp_loc')
                     ->on('loc_mstr.loc_site', '=', 'inp_supply.inp_supply_site');
            })
            ->select('inp_asset_site','inp_supply_site','assite_desc','site_desc','inp_loc','loc_desc','inp_supply.id as transid','inp_avail')
            ->orderby('inp_asset_site')
            ->orderBy('inp_supply_site');

        
        if($s_code) {
            $data = $data->where(function($query) use ($s_code) {
                $query->where('inp_asset_site','like','%'.$s_code.'%')
                ->orWhere('assite_desc','like','%'.$s_code.'%');
            });
        }
        if($s_desc) {
            $data = $data->where(function($query) use ($s_desc) {
                $query->where('inp_supply_site','like','%'.$s_desc.'%')
                ->orWhere('site_desc','like','%'.$s_desc.'%');
            });
        }
        if($s_loc) {
            $data = $data->where(function($query) use ($s_loc) {
                $query->where('inp_loc','like','%'.$s_loc.'%')
                ->orWhere('loc_desc','like','%'.$s_loc.'%');
            });
        }
        

        $data = $data->paginate(10);

        $datadet = DB::table('inp_supply')
            ->whereInp_avail('Yes')
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
        // dd($req->all());
        $cekData = DB::table('inp_supply')
            ->where('inp_asset_site','=',$req->t_code)
            ->Where('inp_supply_site','=',$req->t_desc)
            ->Where('inp_loc','=',$req->t_loc);

        if ($cekData->count() == 0) {
            DB::table('inp_supply')
                ->insert([
                    'inp_asset_site' => $req->t_code,
                    'inp_supply_site' => $req->t_desc,
                    'inp_loc' => $req->t_loc,
                    'inp_avail' => $req->t_avail,
                    'inp_editedby'  => Session::get('username'),
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);

            toast('Inventory Supply Created.', 'success');
            return back();
        } else {
            toast('Inventory Supply are Already Registered!!', 'error');
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
                    ->leftJoin('loc_mstr','loc_code','=','inp_loc')
                    ->whereNotNull('inp_loc')
                    ->whereInp_asset_site($req->code1)
                    ->whereInp_supply_site($req->code2)
                    ->orderBy('inp_sequence')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<td><input type="hidden" class="form-control" name="te_step[]" value="'.$data->inp_sequence.'" readonly>'.
                            $data->inp_sequence.'</td>'.
                            '<td><input type="hidden" class="form-control" name="te_loc[]" value="'.$data->inp_loc.'" readonly>'.
                            $data->inp_loc.' -- '.$data->loc_desc.'</td>'.
                            '<td><select class="form-control" name="te_avail[]">';

                if($data->inp_avail == 'Yes') {
                    $output .= '<option value="Yes" selected>Yes</option><option value="No">No</option>';
                } else {
                    $output .= '<option value="Yes">Yes</option><option value="No" selected>No</option>';
                }
                
                $output .=  '</select>'.
                            '</td>'.
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
        //cek data sudah terdaftar atau belum, dibandingkan dengan id record data
        $cekData = DB::table('inp_supply')
            ->whereInp_asset_site($req->te_code)
            ->whereInp_supply_site($req->te_desc)
            ->whereInp_loc($req->te_loc)
            ->where('id','!=',$req->te_transid)
            ->count();

        if ($cekData > 0) {
            toast('Data Already Registered!!', 'error');
            return back();
        }

        DB::table('inp_supply')
        ->where('id','=',$req->te_transid)
        ->update([
            'inp_loc' => $req->te_loc,
            'inp_avail' => $req->te_avail,
            'inp_editedby'  => Session::get('username'),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ]);
                    
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
            ->where('id','=',$req->d_transid)
            ->delete();

        toast('Inventory Supply Successfully.', 'success');
        return back();
    }
}
