<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class InvSoController extends Controller
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

        $data = DB::table('inc_source')
            ->leftJoin('asset_site','assite_code','=','inc_asset_site')
            ->leftJoin('site_mstrs','site_code','=','inc_source_site')
            ->select('inc_asset_site','inc_source_site','assite_desc','site_desc')
            ->orderby('inc_asset_site')
            ->orderBy('inc_source_site')
            ->groupBy('inc_asset_site','inc_source_site');

        if($s_code) {
            $data = $data->where(function($query) use ($s_code) {
                $query->where('inc_asset_site','like','%'.$s_code.'%')
                ->orWhere('assite_desc','like','%'.$s_code.'%');
            });
        }
        if($s_desc) {
            $data = $data->where(function($query) use ($s_desc) {
                $query->where('inc_source_site','like','%'.$s_desc.'%')
                ->orWhere('site_desc','like','%'.$s_desc.'%');
            });
        }

        $data = $data->paginate(10);

        $datadet = DB::table('inc_source')
            ->orderby('inc_asset_site')
            ->orderBy('inc_source_site')
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

        return view('setting.invso', compact('data','datadet','dataassite','dataspsite','dataloc'));
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

    //untuk search location by site sparepart
    public function locsp(Request $req)
    {
        if ($req->ajax()) {
            $t_site = $req->get('site');
      
            $data = DB::table('loc_mstr')
                    ->where('loc_site','=',$t_site)
                    ->get();

            $output = '<option value="" >Select</option>';
            foreach($data as $data){

                $output .= '<option value="'.$data->loc_code.'" >'.$data->loc_code.' -- '.$data->loc_desc.'</option>';
                           
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
        // cek menyimpan dengan detail atau tidak
        if($req->t_step) {
            $flg = 0;
            foreach($req->t_step as $t_step){
                DB::table('inc_source')
                    ->insert([
                        'inc_asset_site' => $req->t_code,
                        'inc_source_site' => $req->t_desc,
                        'inc_sequence' => $req->t_step[$flg],
                        'inc_loc' => $req->a_code[$flg],
                        'inc_editedby'  => Session::get('username'),
                        'created_at'    => Carbon::now()->toDateTimeString(),
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                    ]);
                $flg += 1;
            }
        } else {
            DB::table('inc_source')
                ->insert([
                    'inc_asset_site' => $req->t_code,
                    'inc_source_site' => $req->t_desc,
                    'inc_editedby'  => Session::get('username'),
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
        }

        toast('Inventory Source Created.', 'success');
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
    public function editdetinvso(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('inc_source')
                    ->leftJoin('loc_mstr','loc_code','=','inc_loc')
                    ->whereInc_asset_site($req->code1)
                    ->whereInc_source_site($req->code2)
                    ->whereNotNull('inc_loc')
                    ->orderBy('inc_sequence')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<td><input type="hidden" class="form-control" name="te_step[]" value="'.$data->inc_sequence.'" readonly>'.
                            $data->inc_sequence.'</td>'.
                            '<td><input type="hidden" class="form-control" name="te_loc[]" value="'.$data->inc_loc.'" readonly>'.
                            $data->inc_loc.' -- '.$data->loc_desc.'</td>'.
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
        // dd($req->all())
        if($req->te_step) {
            // cari tanggal create
            $dcreate = DB::table('inc_source')
                ->whereInc_asset_site($req->te_code)
                ->whereInc_source_site($req->te_desc)
                ->value('created_at');

            // delete terlebih dahulu data nya
            DB::table('inc_source')
                ->whereInc_asset_site($req->te_code)
                ->whereInc_source_site($req->te_desc)
                ->delete();

            //cek apakah ada detail nya atau tidak, untuk membedakan cara menyimpannya
            $flg = 0;
            $cekdetail = 0;
            foreach($req->te_step as $te_step){
                if($req->tick[$flg] == 0) {
                    $cekdetail = 1;
                }
                $flg += 1;  
            }

            if($cekdetail == 1) {
                $flg = 0;
                foreach($req->te_step as $te_step){
                    if($req->tick[$flg] == 0) {
                        DB::table('inc_source')
                        ->insert([
                            'inc_asset_site' => $req->te_code,
                            'inc_source_site' => $req->te_desc,
                            'inc_sequence' => $req->te_step[$flg],
                            'inc_loc' => $req->te_loc[$flg],
                            'inc_editedby'  => Session::get('username'),
                            'created_at'    => $dcreate,
                            'updated_at'    => Carbon::now()->toDateTimeString(),
                        ]);
                    }
                    $flg += 1;  
                }
            } else {
                DB::table('inc_source')
                ->insert([
                    'inc_asset_site' => $req->te_code,
                    'inc_source_site' => $req->te_desc,
                    'inc_editedby'  => Session::get('username'),
                    'created_at'    => $dcreate,
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
            }
            
            toast('Inventory Source Updated.', 'success');
            return back();

        } else {
            toast('Detail Not Found!', 'error');
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        DB::table('inc_source')
            ->whereInc_asset_site($req->d_code)
            ->whereInc_source_site($req->d_desc)
            ->delete();

        toast('Inventory Source Successfully.', 'success');
        return back();
    }
}
