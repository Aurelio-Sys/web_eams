<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class InsListController extends Controller
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

        $data = DB::table('ins_list')
            ->select('ins_code','ins_desc')
            ->orderby('ins_code')
            ->groupBy('ins_code');

        /* if($s_code) {
            $data = $data->where('egr_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('egr_desc','like','%'.$s_desc.'%');
        } */

        $data = $data->paginate(10);

        $dataum = DB::table('um_mstr')
            ->orderBy('um_code')
            ->get();

        $detins = DB::table('ins_list')
            ->orderBy('ins_code')
            ->orderBy('ins_step')
            ->get();

        return view('setting.inslist', compact('data','dataum','detins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        foreach($req->t_step as $t_step){
            DB::table('ins_list')
                ->insert([
                    'ins_code' => $req->t_code,
                    'ins_desc' => $req->t_desc,
                    'ins_duration' => $req->t_dur,
                    'ins_durationum' => $req->t_durum,
                    'ins_manpower' => $req->t_mp,
                    'ins_step' => $req->t_step[$flg],
                    'ins_stepdesc' => $req->t_stepdesc[$flg],
                    'ins_ref' => $req->t_ref[$flg],
                    'ins_editedby'  => Session::get('username'),
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
            $flg += 1;
        }

        toast('Instruction List Created.', 'success');
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
