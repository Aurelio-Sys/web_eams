<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AppSpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datarole = DB::table('roles')
            ->orderBy('role_code')
            ->get();

        return view('setting.appsp', compact('datarole'));
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

    //menampilkan detail 
    public function getAppSp(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('sp_approver_mstr')
                ->leftJoin('roles','role_code','=','sp_approver_role')
                ->orderBy('sp_approver_order')
                ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<td><input type="hidden" name="te_id[]" value="'.$data->id.'">
                            <input type="hidden" class="form-control" name="te_seq[]" value="'.$data->sp_approver_order.'">
                            '.$data->sp_approver_order.'</td>'.
                            '<td><input type="hidden" class="form-control" name="te_role[]" value="'.$data->sp_approver_role.'">
                            '.$data->sp_approver_role.' -- '.$data->role_desc.'</td>'.
                            '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">
                            <input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>'.
                            '</tr>';
            }

            return response($output);
        }
    }
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
        if($req->te_seq) {
            // cek apakah ada duplikat sequence
            if(count(array_unique($req->te_seq))<count($req->te_seq))
            {
                toast('Duplicate Sequence!!!', 'error');
                return back();
            }

            // cek apakah ada duplikat role
            if(count(array_unique($req->te_role))<count($req->te_role))
            {
                toast('Duplicate Role!!!', 'error');
                return back();
            }

            /* delete terlebih dulu datanya */
            DB::table('sp_approver_mstr')
            ->delete();

            $flg = 0;
            foreach($req->te_seq as $te_seq){
                if($req->tick[$flg] == 0) {
                    DB::table('sp_approver_mstr')
                    ->insert([
                        'sp_approver_order' => $req->te_seq[$flg],
                        'sp_approver_role' => $req->te_role[$flg],
                        'created_at'    => Carbon::now()->toDateTimeString(),
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                    ]);
                }
                $flg += 1;  
            }

            toast('Approval Sparepart Updated.', 'success');
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
