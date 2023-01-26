<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class UMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('um_mstr')
            ->orderBy('um_code');

        $data = $data->paginate(10);

        return view('setting.um', compact('data'));
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

    //cek um sebelum input
    public function cekum(Request $req)
    {
        $cek = DB::table('um_mstr')
            ->where('um_code','=',$req->input('code'))
            ->orWhere('um_desc','=',$req->input('desc'))
            ->get();

        if ($cek->count() == 0) {
            return "tidak";
        } else {
            return "ada";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cekData = DB::table('um_mstr')
                ->where('um_code','=',$request->t_code)
                ->orWhere('um_desc','=',$request->t_desc)
                ->get();
        
        DB::beginTransaction();

        try {
            if ($cekData->count() == 0) {
                DB::table('um_mstr')->insert([
                'um_code' => $request->t_code,
                'um_desc' => $request->t_desc,
                'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'edited_by' => Session::get('username'),
                ]);
            }

            DB::commit();
            $request->session()->flash('updated', 'UM successfully created');
        } catch (\Exception $err) {
            DB::rollback();
            $request->session()->flash('error', 'Failed to create UM');   
        }

        return redirect()->back();
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
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cekData = DB::table('um_mstr')
                ->where('um_code','=',$request->te_desc)
                ->Where('um_desc','<>',$request->te_code)
                ->get();
        // dump($cekData);
        // dd($request->all());
        DB::beginTransaction();

        try {
            if ($cekData->count() == 0) {
                DB::table('um_mstr')
                    ->where('um_code','=',$request->te_code)
                    ->update([
                        'um_desc'   => $request->te_desc,
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                        'edited_by'     => Session::get('username'),
                    ]);
            }

            DB::commit();
            $request->session()->flash('updated', 'UM successfully created');
        } catch (\Exception $err) {
            DB::rollback();
            $request->session()->flash('error', 'Failed to create UM');   
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //cek data dari asset  -> nanti ini dibuka setelah ada fieldnya
        // $cekData = DB::table('asset_mstr')
        //         ->where('asset_type','=',$req->d_code)
        //         ->get();

        // if ($cekData->count() == 0) {
            DB::table('um_mstr')
            ->where('um_code', '=', $request->d_code)
            ->delete();

            toast('Deleted UM Successfully.', 'success');
            return back();
        // } else {
        //     toast('Asset Type Can Not Deleted!!!', 'error');
        //     return back();
        // }
    }
}
