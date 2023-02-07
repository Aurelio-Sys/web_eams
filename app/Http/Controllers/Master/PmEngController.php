<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PmEngController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        // dd($req->all());
        $scode1 = $req->s_code1;
        $sdesc1 = $req->s_desc1;
        $scode2 = $req->s_code2;
        
        $data = DB::table('pm_eng')
            // ->leftJoin('asset_type','astype_code','=','pm_type')
            ->leftJoin('asset_group','asgroup_code','=','pm_group')
            // ->leftJoin('asset_mstr','asset_code','=','pm_asset')
            // ->orderBy('pm_type')
            ->orderBy('pm_group');
            // ->orderBy('pm_asset')

        if(isset($scode1)) {
            $data = $data->where('pm_group','like','%'.$scode1.'%');
        }
        if($sdesc1) {
            $data = $data->where('asgroup_desc','like','%'.$sdesc1.'%');
        }
        if($scode2) {
            $data = $data->where('pm_engcode','like','%'.$scode2.'%');
        }

        $data = $data->paginate(10);

        $datatype = DB::table('asset_type')
            ->orderBy('astype_code')
            ->get();

        $datagroup = DB::table('asset_group')
            ->orderBy('asgroup_code')
            ->get();

        $datasset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        $dataeng = DB::table('eng_mstr')
            ->whereEng_active('Yes')
            ->orderBy('eng_code')
            ->get();
        
        return view('setting.pmeng', ['data' => $data, 'datatype' => $datatype, 'datagroup' => $datagroup, 
            'dataasset' => $datasset, 'dataeng' => $dataeng, 'scode1' => $scode1, 'sdesc1' => $sdesc1,
            'scode2' => $scode2]);
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
        DB::beginTransaction();

        try {
        
            $arrayeng = [];
            $arrayeng = $request->t_eng;
            $jmleng = count($arrayeng);

            $dataeng = "";
            for ($i = 0; $i < $jmleng; $i++) {
                $dataeng = $dataeng .";". $request->t_eng[$i];
            }
            
            DB::table('pm_eng')
                ->insert([
                    // 'pm_type'      => $request->t_type,
                    'pm_group'      => $request->t_group,
                    // 'pm_asset'      => $request->t_asset,
                    'pm_engcode'      => $dataeng,             
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                    'edited_by'     => Session::get('username'),
            ]);

            DB::commit();

            toast('Engineer for PM Created !', 'success');
            return redirect()->route('pmeng');
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
            toast('Engineer for PM Failed', 'error');
            return redirect()->route('pmeng');
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

    public function searcheng(Request $req)
    {
        if($req->ajax()){
            $eng = DB::table('eng_mstr')
                ->whereEng_active('Yes')
                ->orderBy('eng_code')
                ->get();

            $array = json_decode(json_encode($eng), true);

            return response()->json($array);
        }
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
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
        // dd($request->all());
            $arrayeng = [];
            $arrayeng = $request->te_eng;
            $jmleng = count($arrayeng);

            $dataeng = "";
            for ($i = 0; $i < $jmleng; $i++) {
                $dataeng = $dataeng .";". $request->te_eng[$i];
            }
            
            DB::table('pm_eng')
                ->where('pm_group','=',$request->te_code)
                ->update([
                    'pm_engcode'      => $dataeng,             
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                    'edited_by'     => Session::get('username'),
            ]);

            DB::commit();

            toast('Engineer for PM Updated !', 'success');
            return redirect()->route('pmeng');
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
            toast('Engineer for PM Failed', 'error');
            return redirect()->route('pmeng');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('pm_eng')
            ->where('pm_group', '=', $request->d_code)
            ->delete();

            toast('Deleted Engineer for PM Successfully.', 'success');
            return back();
    }
}
