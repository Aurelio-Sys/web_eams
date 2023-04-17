<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PMCodeController extends Controller
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

        $data = DB::table('pmc_mstr')
            ->orderby('pmc_code');

        if($s_code) {
            $data = $data->where('pmc_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('pmc_desc','like','%'.$s_desc.'%');
        }

        $data = $data->paginate(10);

        $datains = DB::table('ins_list')
            ->select('ins_code','ins_desc')
            ->orderBy('ins_code')
            ->groupBy('ins_code')
            ->get();

        $dataqcs = DB::table('qcs_list')
            ->select('qcs_code','qcs_desc')
            ->orderBy('qcs_code')
            ->groupBy('qcs_code')
            ->get();
        
        $dataspg = DB::table('spg_list')
            ->select('spg_code','spg_desc')
            ->orderBy('spg_code')
            ->groupBy('spg_code')
            ->get();

        return view('setting.pmcode', compact('data','datains','dataqcs','dataspg'));
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
        DB::table('pmc_mstr')
            ->insert([
                'pmc_code' => $req->t_code,
                'pmc_desc' => $req->t_desc,
                'pmc_type' => $req->t_type,
                'pmc_ins' => $req->t_ins,
                'pmc_spg' => $req->t_spg,
                'pmc_qcs' => $req->t_qcs,
                'pmc_editedby'  => Session::get('username'),
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
            ]);

        toast('Preventive Code Created.', 'success');
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
        DB::table('pmc_mstr')
            ->wherePmc_code($req->te_code)
            ->update([
                'pmc_desc' => $req->te_desc,
                'pmc_type' => $req->te_type,
                'pmc_ins' => $req->te_ins,
                'pmc_spg' => $req->te_spg,
                'pmc_qcs' => $req->te_qcs,
                'pmc_editedby'  => Session::get('username'),
                'updated_at'    => Carbon::now()->toDateTimeString(),
            ]);

        toast('Preventive Code Updated.', 'success');
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
        $data = DB::table('pmc_mstr')
            ->wherePmc_code($req->d_code)
            ->delete();

        toast('Preventive Code Deleted.', 'success');
        return back();
    }
}
