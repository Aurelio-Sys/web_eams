<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use App\Models\Qxwsa as ModelsQxwsa;
use Carbon\Carbon;

use File;
use App\Exports\AssetExport;
use Maatwebsite\Excel\Facades\Excel;

class ViewAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $s_code = $req->s_code;
        $s_loc = $req->s_loc;
        $s_type = $req->s_type;
        $s_group = $req->s_group;

        $data = DB::table('asset_mstr')
            ->selectRaw('asset_type.*, asset_group.*, asset_loc.*, asset_mstr.id as asset_id, asset_code, asset_desc, asset_site, asset_loc, asset_um, asset_sn, 
            asset_supp, asset_prcdate, asset_prcprice, asset_type, asset_group, asset_accounting, asset_note, asset_active, asset_image, 
            asset_imagepath, asset_upload, asset_editedby, asset_renew')
            ->leftjoin('asset_type','asset_mstr.asset_type','asset_type.astype_code')
            ->leftjoin('asset_group','asset_mstr.asset_group','asset_group.asgroup_code')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->orderByRaw("REGEXP_REPLACE(asset_code, '[0-9]', '') ASC")
            ->orderByRaw("CAST(REGEXP_REPLACE(asset_code, '\\D', '') AS UNSIGNED) ASC");

        if($s_code) {
            $data = $data->where(function($query) use ($s_code) {
                $query->where('asset_code','like','%'.$s_code.'%')
                ->orwhere('asset_desc','like','%'.$s_code.'%');
            });
        }
        if($s_loc) {
            $data = $data->where(function($query) use ($s_loc) {
                $query->where('asloc_code','like','%'.$s_loc.'%')
                ->orwhere('asloc_desc','like','%'.$s_loc.'%');
            });
        }
        if($s_type) {
            $data = $data->where(function($query) use ($s_type) {
                $query->where('astype_code','like','%'.$s_type.'%')
                ->orwhere('astype_desc','like','%'.$s_type.'%');
            });
        }
        if($s_group) {
            $data = $data->where(function($query) use ($s_group) {
                $query->where('asgroup_code','like','%'.$s_group.'%')
                ->orwhere('asgroup_desc','like','%'.$s_group.'%');
            });
        }
        
        $data = $data->paginate(10);

        $dataasset = DB::table('asset_mstr')
            ->orderByRaw("REGEXP_REPLACE(asset_code, '[0-9]', '') ASC")
            ->orderByRaw("CAST(REGEXP_REPLACE(asset_code, '\\D', '') AS UNSIGNED) ASC")
            ->get();

        $datasite = DB::table('asset_site')
            ->orderby('assite_code')
            ->get();

        $dataloc = DB::table('asset_loc')
            ->orderby('asloc_site')
            ->orderby('asloc_code')
            ->get();

        $dataastype = DB::table('asset_type')
            ->orderby('astype_code')
            ->get();

        $dataasgroup = DB::table('asset_group')
            ->orderby('asgroup_code')
            ->get();

        $datasupp = DB::table('supp_mstr')
            ->orderby('supp_code')
            ->get();

        $datafn = DB::table('fn_mstr')
            ->orderby('fn_code')
            ->get();

        $repaircode = DB::table('rep_master')
            ->get();

        $repairgroup = DB::table('xxrepgroup_mstr')
            ->select('xxrepgroup_nbr','xxrepgroup_desc')
            ->distinct('xxrepgroup_nbr','xxrepgroup_desc')
            ->get();

        $datasearch = DB::table('asset_mstr')
            ->orderby('asset_code')
            ->get();

        $datameaum = DB::table('um_mstr')
            ->orderBy('um_code')
            ->get();

        /* Load data asset dari QAD */

        Schema::create('temp_asset', function ($table) {
            $table->increments('id');
            $table->string('temp_domain');
            $table->string('temp_entity');
            $table->string('temp_code')->nullable();
            $table->string('temp_desc')->nullable();
            $table->temporary();
        });

        /* ini ditutup dulu, nanti dibuka lagi */
        // $domain = ModelsQxwsa::first();
        // $datawsa = (new WSAServices())->wsaassetqad($domain->wsas_domain);

        // if ($datawsa === false) {
        //     toast('WSA Failed', 'error')->persistent('Dismiss');
        //     return redirect()->back();
        // } else {
        //     foreach ($datawsa[0] as $datas) {
        //         DB::table('temp_asset')->insert([
        //             'temp_code' => $datas->t_code,
        //             'temp_desc' => $datas->t_desc,
        //         ]);
        //     }
        // } 

        $dataassetqad = DB::table('temp_asset')
            ->orderBy('temp_code')
            ->get();

        Schema::dropIfExists('temp_asset');

        return view('report.viewasset', ['data' => $data, 'datasite' => $datasite, 'dataloc' => $dataloc, 
        'dataastype' => $dataastype, 'dataasgroup' => $dataasgroup, 'datasupp' => $datasupp, 'datafn' => $datafn, 
        'repaircode' => $repaircode, 'repairgroup' => $repairgroup, 'datasearch' => $datasearch, 
        'dataassetqad' => $dataassetqad, 'datameaum' => $datameaum, 'dataasset' => $dataasset,
        's_code' =>$req->s_code, 's_loc' =>$req->s_loc, 's_type' =>$req->s_type, 's_group' =>$req->s_group]);
    }

    public function assetfile($id){
        dd('test');
        $data = DB::table('asset_upload')
                        ->where('asset_code',$id)
                        ->get();
        $output = '';
        foreach($data as $data){

            $lastindex = strrpos($data->filepath, "/");
            $filename = substr($data->filepath, $lastindex + 1);


            $output .=  '<tr>
                            <td> 
                            <a href="/uploadasset/'.$data->id.'" target="_blank">'.$filename.'</a> 
                            </td>
                        </tr>';
        }

        return response($output);
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
