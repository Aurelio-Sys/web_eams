<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;

class CostCenterController extends Controller
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

        $data = DB::table('cc_mstr')
                ->orderby('cc_code');

        if($s_code) {
            $data = $data->where('cc_code','like','%'.$s_code.'%');
            // dd($data->get());
        }
        if($s_desc) {
            $data = $data->where('cc_desc','like','%'.$s_desc.'%');
        }
        
        $data = $data->paginate(10);

        /** Menarik data dari QAD */
        Schema::create('temp_mstr', function ($table) {
            $table->increments('id');
            $table->string('temp_code');
            $table->string('temp_desc');
            $table->temporary();
        });

        $domain = ModelsQxwsa::first();

        $suppdata = (new WSAServices())->wsacostcenter($domain->wsas_domain);

        if ($suppdata === false) {
            toast('WSA Failed', 'error')->persistent('Dismiss');
            return redirect()->back();
        } else {

            if ($suppdata[1] == "false") {
                toast('Data Cost Center tidak ditemukan', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {
                
                foreach ($suppdata[0] as $datas) {
                    DB::table('temp_mstr')->insert([
                        'temp_code' => $datas->t_code,
                        'temp_desc' => $datas->t_desc,
                    ]);
                }
            }
        }

        $datamstr = DB::table('temp_mstr')
            ->orderBy('temp_code')
            ->get();

        Schema::dropIfExists('temp_mstr');

        return view('setting.costcenter', compact('data','datamstr'));
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

    //cek cost center sebelum input
    public function cekcc(Request $req)
    {
        $cek = DB::table('cc_mstr')
            ->where('cc_code','=',$req->input('code'))
            ->orWhere('cc_desc','=',$req->input('desc'))
            ->get();

        if ($cek->count() == 0) {
            return "tidak";
        } else {
            return "ada";
        }
    }

    public function store(Request $req)
    {
        DB::beginTransaction();

        try {
            $cekData = DB::table('cc_mstr')
                    ->where('cc_code','=',$req->t_code)
                    ->orWhere('cc_desc','=',$req->t_desc)
                    ->get();

            if ($cekData->count() == 0) {
                DB::table('cc_mstr')
                ->insert([
                    'cc_code'   => $req->t_code,
                    'cc_desc'   => $req->t_desc,                
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);

                DB::commit();
                toast('Cost Center Created.', 'success');
                return back();
            } else {
                toast('Cost Center is Already Registerd!!', 'error');
                return back();
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Transaction Error', 'error');
            return redirect()->back();
        }
    }

    public function addcc(Request $req)
    {
        DB::beginTransaction();
        try {
            
            DB::table('cc_mstr')->updateOrInsert(
                ['cc_code' => $req->q_code],
                ['cc_desc' => $req->q_desc]
            ); 

            DB::commit();
            toast('Cost Center Created.', 'success');
            return back();

        } catch (Exception $err) {

            DB::rollBack();

            dd($err);
            toast('Submit Error, please contact Administrator', 'error');
            return redirect()->back();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        DB::beginTransaction();

        try {
            $cekData = DB::table('cc_mstr')
                    ->where('cc_desc','=',$req->te_desc)
                    ->where('cc_code','<>',$req->te_code)
                    ->get();

            if ($cekData->count() == 0) {
                DB::table('cc_mstr')
                ->where('cc_code','=',$req->te_code)
                ->update([
                    'cc_desc'   => $req->te_desc,
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);

                DB::commit();
                toast('Cost Center Updated.', 'success');
                return back();
            } else {
                toast('Cost Center Description is Already Registerd!!', 'error');
                return back();
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Transaction Error', 'error');
            return redirect()->back();
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
        DB::beginTransaction();

        try {
            //cek data dari departemen
            $cekData = DB::table('dept_mstr')
                    ->where('dept_cc','=',$req->d_code)
                    ->get();

            if ($cekData->count() == 0) {
                DB::table('cc_mstr')
                ->where('cc_code', '=', $req->d_code)
                ->delete();

                DB::commit();
                toast('Deleted Cost Center Successfully.', 'success');
                return back();
            } else {
                toast('Cost Center Can Not Deleted!!!', 'error');
                return back();
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Transaction Error', 'error');
            return redirect()->back();
        }
    }
}
