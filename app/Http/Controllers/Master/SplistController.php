<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SplistController extends Controller
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
        $s_code1 = $req->s_code1;
        $s_desc1 = $req->s_desc1;

        $data = DB::table('spg_list')
            ->leftJoin('sp_mstr','spm_code','spg_spcode')
            ->orderBy('spg_code')
            ->orderBy('spg_spcode');

        if($s_code) {
            $data = $data->where('spg_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('spg_desc','like','%'.$s_desc.'%');
        }
        if($s_code1) {
            $data = $data->where('spm_code','like','%'.$s_code1.'%');
        }
        if($s_desc1) {
            $data = $data->where('spm_desc','like','%'.$s_desc1.'%');
        }

        $data = $data->paginate(10);

        $datasp = DB::table('sp_mstr')
            ->orderBy('spm_code')
            ->get();    

        return view('setting.splist', compact('data','datasp'));
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

    public function getspmstr(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('sp_mstr')
                ->whereSpm_code($req->code)
                ->first();

            return response()->json([
                'spm_desc' => $data->spm_desc,
                'spm_um' => $data->spm_um,
            ], 200);
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
        $flg = 0;
        foreach($req->t_scode as $t_scode){
            DB::table('spg_list')
                ->insert([
                    'spg_code' => $req->t_code,
                    'spg_desc' => $req->t_desc,
                    'spg_spcode' => $req->t_scode[$flg],
                    'spg_qtyreq' => $req->t_qty[$flg],
                    'spg_editedby'  => Session::get('username'),
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
            $flg += 1;
        }

        toast('Sparepart List Created.', 'success');
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
    public function editdetsplist(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('spg_list')
                ->leftJoin('sp_mstr','spm_code','spg_spcode')
                ->whereSpg_code($req->code)
                ->orderBy('spg_spcode')
                ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<td><input type="text" class="form-control" name="te_scode[]" value="'.$data->spg_spcode.'" readonly></td>'.
                            '<td><input type="text" class="form-control" name="te_sdesc[]" value="'.$data->spm_desc.'" readonly></td>'.
                            '<td><input type="text" class="form-control" name="te_sum[]" value="'.$data->spm_um.'" readonly></td>'.
                            '<td><input type="text" class="form-control" name="te_qty[]" value="'.$data->spg_qtyreq.'" min="0" step="0.1"></td>'.
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
        $dcreate = DB::table('spg_list')
            ->whereSpg_code($req->te_code)
            ->value('created_at');

        // delete terlebih dahulu data nya
        DB::table('spg_list')
            ->whereSpg_code($req->te_code)
            ->delete();
        
        $flg = 0;
        foreach($req->te_scode as $te_scode){
            if($req->tick[$flg] == 0) {
                DB::table('spg_list')
                ->insert([
                    'spg_code' => $req->te_code,
                    'spg_desc' => $req->te_desc,
                    'spg_spcode' => $req->te_scode[$flg],
                    'spg_qtyreq' => $req->te_qty[$flg],
                    'spg_editedby'  => Session::get('username'),
                    'created_at'    => $dcreate,
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
            }
            $flg += 1;  
        }

        toast('Sparepart List Updated.', 'success');
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
        DB::table('spg_list')
        ->whereSpg_code($req->d_code)
        ->delete();

        toast('Deleted Sparepart List Successfully.', 'success');
        return back();
    }
}
