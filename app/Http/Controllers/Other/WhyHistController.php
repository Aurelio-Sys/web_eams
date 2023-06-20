<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Exception;

class WhyHistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $s_asset = $req->s_asset;
        $s_wo = $req->s_wo;
        $s_problem = $req->s_problem;

        $data = DB::table('why_hist')
            ->selectRaw('why_hist.id as id, why_asset, why_wo, why_problem, why_why1, why_why2, why_why3, why_why4, why_why5,
                why_inputby, why_hist.created_at as created_at, asset_desc')
            ->leftJoin('asset_mstr','asset_code','=','why_asset')
            ->orderBy('why_hist.created_at','desc')
            ->orderby('asset_code');

        if($s_asset) {
            $data = $data->where(function($query) use ($s_asset) {
                $query->where('why_asset','like','%'.$s_asset.'%')
                ->orWhere('asset_desc','like','%'.$s_asset.'%');
            });
        }
        if($s_wo) {
            $data = $data->where('why_wo','like','%'.$s_wo.'%');
        }
        if($s_problem) {
            $data = $data->where('why_problem','like','%'.$s_problem.'%');
        }

        $data = $data->paginate(10);

        $dataasset = DB::table('asset_mstr')
            ->whereAsset_active('Yes')
            ->orderBy('asset_code')
            ->get();

        $datawo = DB::table('wo_mstr')
            ->orderBy('wo_number')
            ->get();

        return view('booking.whyhist', compact('data','dataasset','datawo'));
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

    //untuk mencari wo berdasarkan asset yang diinputkan
    public function searchwoasset(Request $req)
    {
        if ($req->ajax()) {
            $code = $req->get('code');
      
            $data = DB::table('wo_mstr')
                    ->where('wo_asset_code','=',$code)
                    ->get();

            $output = '<option value="" >Select</option>';
            foreach($data as $data){

                $output .= '<option value="'.$data->wo_number.'" >'.$data->wo_number.'</option>';
                           
            }

            return response($output);
        }
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
            DB::table('why_hist')
                ->insert([
                    'why_asset' => $req->t_asset,
                    'why_wo' => $req->t_wo,
                    'why_problem' => $req->t_problem,
                    'why_why1' => $req->t_why1,
                    'why_why2' => $req->t_why2,
                    'why_why3' => $req->t_why3,
                    'why_why4' => $req->t_why4,
                    'why_why5' => $req->t_why5,
                    'why_inputby'  => Session::get('username'),
                    'why_editedby'  => Session::get('username'),
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);

            $getid = DB::table('why_hist')
                ->whereWhy_asset($req->t_asset)
                ->whereWhy_wo($req->t_wo)
                ->whereWhy_problem($req->t_problem)
                ->orderBy('created_at','desc')
                ->value('id');

            if ($req->hasFile('filename')) {

                foreach ($req->file('filename') as $upload) {
                    $dataTime = date('Ymd_His');
                    $filename = $dataTime . '-' . $upload->getClientOriginalName();

                    // Simpan File Upload pada Public
                    $savepath = public_path('upload5why/');
                    $upload->move($savepath, $filename);

                    // Simpan ke DB Upload
                    DB::table('why_file')
                        ->insert([
                            'wf_filepath' => $savepath . $filename,
                            'wf_whyid' => $getid,
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }
            }

        
            DB::commit();

            toast('Transactions Created.', 'success');
            return back();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Transactions Failed Created', 'error');
            return back();
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

    // menampilkan file yang pernah diinput
    public function whyfile($id)
    {
        // dd($id);
        $datas = DB::table('why_file')
            ->where('wf_whyid', $id)
            ->get();

        $output = '';
        foreach ($datas as $data) {

            $lastindex = strrpos($data->wf_filepath, "/");
            $filename = substr($data->wf_filepath, $lastindex + 1);

            $output .=  '<tr>
                            <td> 
                            <a href="/upload5why/' . $filename . '" target="_blank">' . $filename . '</a> 
                            </td>
                            <input type="hidden" value="' . $data->id . '" class="rowval"/>
                            <td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">
                            <input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>
                        </tr>';
        }

        return response($output);
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
            DB::table('why_hist')
                ->where('id','=',$req->te_id)
                ->whereWhy_asset($req->te_asset)
                ->update([
                    'why_wo' => $req->te_wo,
                    'why_problem' => $req->te_problem,
                    'why_why1' => $req->te_why1,
                    'why_why2' => $req->te_why2,
                    'why_why3' => $req->te_why3,
                    'why_why4' => $req->te_why4,
                    'why_why5' => $req->te_why5,
                    'why_editedby'  => Session::get('username'),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);

            if ($req->hasFile('te_filename')) {
                foreach ($req->file('te_filename') as $upload) {
                    $dataTime = date('Ymd_His');
                    $filename = $dataTime . '-' . $upload->getClientOriginalName();

                    // Simpan File Upload pada Public
                    $savepath = public_path('upload5why/');
                    $upload->move($savepath, $filename);

                    // Simpan ke DB Upload
                    DB::table('why_file')
                        ->insert([
                            'wf_filepath' => $savepath . $filename,
                            'wf_whyid' => $req->te_id,
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                }
            }

        
            DB::commit();

            toast('Transactions Updated.', 'success');
            return back();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Transactions Failed Created', 'error');
            return back();
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
        // dd($req->all());
        DB::table('why_hist')
            ->where('id','=',$req->te_id)
            ->delete();

        toast('Transactions Deleted.', 'success');
        return back();
    }
}
