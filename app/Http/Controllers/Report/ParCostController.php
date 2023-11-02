<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Qxwsa as ModelsQxwsa;
use App\Services\WSAServices;

class ParCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $sasset = $req->s_asset;
        $sloc = $req->s_loc;
        $sper1 = $req->s_per1;
        $sper2 = $req->s_per2;
        $spar = $req->s_par;

        
        Schema::create('datatemp', function ($table) {
            $table->increments('id');
            $table->string('temp_pc')->nullable();
            $table->string('temp_qadcode')->nullable();
            $table->string('temp_qaddesc')->nullable();
            $table->string('temp_asset');
            $table->string('temp_assetdesc');
            $table->string('temp_assetloc')->nullable();
            $table->decimal('temp_costqad',10,2);
            $table->decimal('temp_costbook',10,2);
            $table->decimal('temp_costeams',10,2);
            $table->decimal('temp_costmtc',10,2);
        });
        
        if($spar) {
            $data = DB::table('');
        }

        $datatemp = DB::table('wo_mstr')
            ->paginate(10);

        $dataasset = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->orderBy('asset_code')
            ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();
        
        $datapar = DB::table('asset_par')
            ->select('aspar_par','asset_desc','asset_loc')
            ->leftJoin('asset_mstr','asset_code','=','aspar_par')
            ->groupBy('aspar_par')
            ->orderBy('aspar_par')
            ->get();

        // $data = $datatemp

        Schema::dropIfExists('datatemp');

        return view('report.parcost', compact('data','datapar','dataasset','dataloc','sasset','sloc','sper1','sper2','spar'));
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
