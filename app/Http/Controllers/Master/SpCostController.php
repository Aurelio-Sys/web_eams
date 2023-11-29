<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;

use App\Models\SPMstr;

class SpCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if (strpos(Session::get('menu_access'), 'MTD52') !== false) {

            $scode = $req->s_code;
            $scostset = $req->s_costset;

            $data = DB::table('sp_cost')
                ->Join('sp_mstr','spm_code','=','spc_part')
                ->orderBy('spc_costset','desc')
                ->orderby('spc_part');

            if($scode) {
                $data = $data->where('spm_code','=',$scode);
            }
            if($scostset) {
                $data = $data->where('spc_costset','=',$scostset);
            }
			/* if(!$scode && !$scostset) {
				$data = $data->where('sp_cost.id','<','0');
			} */
            
            $data = $data->paginate(10);

            $datasp = DB::table('sp_mstr')
                ->orderby('spm_code')
                ->get();

            $datacostset = DB::table('sp_cost')
                ->select('spc_costset')
                ->groupBy('spc_costset')
                ->orderBy('spc_costset')
                ->get();

            return view('setting.spcost', compact('data','datasp','datacostset','scode','scostset'));
        } else {
            toast('You do not have menu access, please contact admin.', 'error');
            return back();
        }
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
    public function store(Request $request) /** Route : loadspcost */
    {
        $domain = ModelsQxwsa::first();
//dd($request->all());
        /** Load data cost dari Item Cost Set */
        
        $datacost = (new WSAServices())->wsacostset($domain->wsas_domain,$request->t_period);

        /** Hapus dulu data yang sudah ada */
        //DB::statement('TRUNCATE TABLE sp_cost');    // di truncate agar id nya tidak selalu bertambah

        DB::table('sp_cost')
            ->where('spc_period','=',$request->t_period)
            ->delete();

        if ($datacost === false) {
            toast('WSA Failed', 'error')->persistent('Dismiss');
            return redirect()->back();
        } else {
            if ($datacost[1] == "false") {
                toast('No Data Found', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {
                // dd('test');
                foreach ($datacost[0] as $datas) {
                    DB::table('sp_cost')
                        ->insert([
                            'spc_period' => substr($datas->t_sim,5,4),
                            'spc_part' => $datas->t_part,
                            'spc_costset' => $datas->t_sim,
                            'spc_cost' => $datas->t_cost,
                        ]);
                }
            }
            toast('Spare Part Loaded.', 'success');
            return back();
        } /** else ($datacost === false) { */
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
