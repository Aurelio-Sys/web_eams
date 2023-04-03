<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class EngGroupContoller extends Controller
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

        $data = DB::table('egr_mstr')
            ->select('egr_code','egr_desc')
            ->orderby('egr_code')
            ->groupBy('egr_code');

        if($s_code) {
            $data = $data->where('egr_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('egr_desc','like','%'.$s_desc.'%');
        }

        $data = $data->paginate(10);

        $dataeng = DB::table('egr_mstr')
            ->leftJoin('eng_mstr','eng_code','egr_eng')
            ->whereEng_active('Yes')
            ->orderBy('eng_code')
            ->get();

        return view('setting.eng-group', compact('data','dataeng'));
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
        $flg = 0;
        foreach($req->dcode as $dcode){
            DB::table('egr_mstr')
                ->insert([
                    'egr_code'      => $req->t_code,
                    'egr_desc'      => $req->t_desc,
                    'egr_eng'       => $req->dcode[$flg], 
                    'egr_editedby'  => Session::get('username'),
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
            $flg += 1;
        }

        toast('Engineer Group Created.', 'success');
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

    //menampilkan detail edit
    public function editdetegr(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('egr_mstr')
                    ->leftJoin('eng_mstr','eng_code','egr_eng')
                    ->whereEgr_code($req->code)
                    ->whereEng_active('Yes')
                    ->orderBy('eng_code')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<input type="hidden" class="form-control" name="dcode[]" readonly value="'.$data->egr_eng.'">'.
                            '<td>'.$data->egr_eng.'</td>'.
                            '<td>'.$data->eng_desc.'</td>'.
                            '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">
                            <input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>'.
                            '</tr>';
            }

            return response($output);
        }
    }

    public function update(Request $req)
    {
        // dd($req->all());
        // delete terlebih dahulu data nya
        DB::table('egr_mstr')
            ->whereEgr_code($req->te_code)
            ->delete();
        
        $flg = 0;
        foreach($req->dcode as $dcode){

            if($req->tick[$flg] == 0) {
                DB::table('egr_mstr')
                    ->insert([
                        'egr_code'      => $req->te_code,
                        'egr_desc'      => $req->te_desc,
                        'egr_eng'       => $req->dcode[$flg], 
                        'egr_editedby'  => Session::get('username'),
                        'created_at'    => Carbon::now()->toDateTimeString(),
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                    ]);
            }
            $flg += 1;  
        }

        toast('Engineer Group Updated.', 'success');
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
        DB::table('egr_mstr')
        ->whereEgr_code($req->d_code)
        ->delete();

        toast('Deleted Engineer Group Successfully.', 'success');
        return back();
    }
}
