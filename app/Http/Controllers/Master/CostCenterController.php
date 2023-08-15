<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('cc_mstr')
                ->orderby('cc_code')
                ->paginate(10);

        return view('setting.costcenter', ['data' => $data]);
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
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            //cek data dari asset
            $cekData = DB::table('dept_mstr')
                    ->where('dept_user','=',$req->d_code)
                    ->get();

            if ($cekData->count() == 0) {
                DB::table('dept_mstr')
                ->where('dept_code', '=', $req->d_code)
                ->delete();

                DB::commit();
                toast('Deleted Departemen Successfully.', 'success');
                return back();
            } else {
                toast('Departemen Can Not Deleted!!!', 'error');
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
