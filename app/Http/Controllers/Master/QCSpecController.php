<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class QCSpecController extends Controller
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

        $data = DB::table('qcs_list')
            ->select('qcs_code','qcs_desc')
            ->orderby('qcs_code')
            ->groupBy('qcs_code');

        /* if($s_code) {
            $data = $data->where('egr_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where('egr_desc','like','%'.$s_desc.'%');
        } */

        $data = $data->paginate(10);

        $datadet = DB::table('qcs_list')
            ->orderBy('qcs_code')
            ->orderBy('qcs_spec')
            ->get();

        return view('setting.qcspec', compact('data','datadet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $flg = 0;
        foreach($req->t_spec as $t_spec){
            DB::table('qcs_list')
                ->insert([
                    'qcs_code' => $req->t_code,
                    'qcs_desc' => $req->t_desc,
                    'qcs_spec' => $req->t_spec[$flg],
                    'qcs_tools' => $req->t_tools[$flg],
                    'qcs_op' => $req->t_op[$flg],
                    'qcs_val1' => $req->t_val1[$flg],
                    'qcs_val2' => $req->t_val2[$flg],
                    'qcs_um' => $req->t_um[$flg],
                    'qcs_editedby'  => Session::get('username'),
                    'created_at'    => Carbon::now()->toDateTimeString(),
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
            $flg += 1;
        }

        toast('QC Specification Created.', 'success');
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

    //menampilkan detail edit
    public function editdetqcs(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('qcs_list')
                ->whereQcs_code($req->code)
                ->orderBy('qcs_spec')
                ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<td><input type="text" class="form-control" name="te_spec[]" value="'.$data->qcs_spec.'"></td>'.
                            '<td><input type="text" class="form-control" name="te_tools[]" value="'.$data->qcs_tools.'"></td>'.
                            '<td><input type="text" class="form-control" name="te_op[]" value="'.$data->qcs_op.'"></td>'.
                            '<td><input type="text" class="form-control" name="te_val1[]" value="'.$data->qcs_val1.'"></td>'.
                            '<td><input type="text" class="form-control" name="te_val2[]" value="'.$data->qcs_val2.'"></td>'.
                            '<td><input type="text" class="form-control" name="te_um[]" value="'.$data->qcs_um.'"></td>'.
                            '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">
                            <input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>'.
                            '</tr>';
            }

            return response($output);
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
    public function update(Request $req)
    {
        // dd($req->all());
        // cari tanggal create
        $dcreate = DB::table('qcs_list')
            ->whereQcs_code($req->te_code)
            ->value('created_at');

        // delete terlebih dahulu data nya
        DB::table('qcs_list')
            ->whereQcs_code($req->te_code)
            ->delete();
        
        $flg = 0;
        foreach($req->te_spec as $te_spec){
            if($req->tick[$flg] == 0) {
                DB::table('qcs_list')
                ->insert([
                    'qcs_code' => $req->te_code,
                    'qcs_desc' => $req->te_desc,
                    'qcs_spec' => $req->te_spec[$flg],
                    'qcs_tools' => $req->te_tools[$flg],
                    'qcs_op' => $req->te_op[$flg],
                    'qcs_val1' => $req->te_val1[$flg],
                    'qcs_val2' => $req->te_val2[$flg],
                    'qcs_um' => $req->te_um[$flg],
                    'qcs_editedby'  => Session::get('username'),
                    'created_at'    => $dcreate,
                    'updated_at'    => Carbon::now()->toDateTimeString(),
                ]);
            }
            $flg += 1;  
        }

        toast('QC Specifation Updated.', 'success');
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
        DB::table('qcs_list')
            ->whereQcs_code($req->d_code)
            ->delete();
        
        toast('Deleted QC Specification Successfully.', 'success');
        return back();
    }
}
