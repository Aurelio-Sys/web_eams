<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Exception;

use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;



class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        /** Cara input adalah pilih data yang ada di combo box (data dari QAD) lalu Add to eAMS untuk menyimpan data ke eAMS. */
        $data = DB::table('acc_mstr')
            ->orderby('acc_code');

        if($req->s_code){
            // dd($req->all());
            $data = $data->where('acc_code','like','%'.$req->s_code.'%');
        }
        if($req->s_desc){
            $data = $data->where('acc_desc','like','%'.$req->s_desc.'%');
        }

        $data = $data->paginate(10);

        /** Menarik data supplier dari QAD */
        Schema::create('temp_mstr', function ($table) {
            $table->increments('id');
            $table->string('temp_code');
            $table->string('temp_desc');
            $table->string('temp_cc');
            $table->temporary();
        });

        $domain = ModelsQxwsa::first();

        $suppdata = (new WSAServices())->wsaaccount($domain->wsas_domain);
// dd($domain->wsas_domain);
        if ($suppdata === false) {
            toast('WSA Failed', 'error')->persistent('Dismiss');
            return redirect()->back();
        } else {

            if ($suppdata[1] == "false") {
                toast('Data Account tidak ditemukan', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {
                
                foreach ($suppdata[0] as $datas) {
                    DB::table('temp_mstr')->insert([
                        'temp_code' => $datas->t_code,
                        'temp_desc' => $datas->t_desc,
                        'temp_cc' => $datas->t_cc,
                    ]);
                }
            }
        }

        $datamstr = DB::table('temp_mstr')
            ->orderBy('temp_code')
            ->get();

        Schema::dropIfExists('temp_mstr');

        return view('setting.accmstr', compact('data','datamstr'));
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
        DB::beginTransaction();
        try {
            
            DB::table('acc_mstr')->updateOrInsert(
                ['acc_code' => $req->t_code],
                ['acc_desc' => $req->t_desc, 'acc_cc' => $req->t_cc]
            ); 

            DB::commit();
            toast('Account Created.', 'success');
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
    public function destroy(Request $req)
    {
        DB::beginTransaction();
        try {
            $cek = DB::table('wo_dets_sp')
                ->where('wd_sp_glaccount','=',$req->d_code)
                ->get();

            if ($cek->count() == 0) {
                DB::table('acc_mstr')
                ->where('acc_code', '=', $req->d_code)
                ->delete();

                DB::commit();
                toast('Deleted Account Successfully.', 'success');
                return back();
            } else {
                toast('Account Can Not Deleted!!!', 'error');
                return back();
            }
        } catch (Exception $err) {

            DB::rollBack();

            dd($err);
            toast('Submit Error, please contact Administrator', 'error');
            return redirect()->back();
        }
    }
}
