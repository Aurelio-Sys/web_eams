<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AppSrController extends Controller
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
        $s_code1 = $req->s_code1;
        $s_desc1 = $req->s_desc1;

        $data = DB::table('dept_mstr')
            ->orderBy('dept_code');

        if($s_code) {
            $data = $data->where('dept_code','like','%'.$s_code.'%');
        }
        if($s_desc) {
            $data = $data->where(function ($query) use ($s_desc) {
                // $query->DB::table('sr_approver_mstr')
                //     ->select('sr_approver_dept')
                //     ->whereSrApproverRole($s_desc)
                //     ->get();
            });
        }

        $data = $data->paginate(10);

        $datarole = DB::table('roles')
            ->orderBy('role_code')
            ->get();

        $datadet = DB::table('sr_approver_mstr')
            ->orderBy('sr_approver_dept')
            ->orderBy('sr_approver_order')
            ->get();

        return view('setting.appsr', compact('data','datarole','datadet'));
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

    //menampilkan detail 
    public function editdetappsr(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('sr_approver_mstr')
                ->leftJoin('roles','role_code','sr_approver_role')
                ->whereSr_approver_dept($req->code)
                ->orderBy('sr_approver_order')
                ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                            '<td><input type="hidden" name="te_seq[]" value="'.$data->sr_approver_order.'">'.$data->sr_approver_order.'</td>'.
                            '<td><input type="hidden" name="te_role[]" value="'.$data->sr_approver_role.'">'.$data->sr_approver_role.' -- '.$data->role_desc.'</td>'.
                            '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">
                            <input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>'.
                            '</tr>';
            }

            return response($output);
        }
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

        if($req->te_seq) {
            // cek apakah ada duplikat sequence
            if(count(array_unique($req->te_seq))<count($req->te_seq))
            {
                toast('Duplicate Sequence!!!', 'error');
                return back();
            }

            // cek apakah ada duplikat role
            if(count(array_unique($req->te_role))<count($req->te_role))
            {
                toast('Duplicate Role!!!', 'error');
                return back();
            }

            // cari tanggal create
            $dcreate = DB::table('sr_approver_mstr')
            ->whereSr_approver_dept($req->te_code)
            ->value('created_at');

            if(is_null($dcreate)) {
                $dcreate = Carbon::now()->toDateTimeString();
            }

            // delete terlebih dahulu data nya
            DB::table('sr_approver_mstr')
                ->whereSr_approver_dept($req->te_code)
                ->delete();
            
            $flg = 0;
            foreach($req->te_seq as $te_seq){
                if($req->tick[$flg] == 0) {
                    DB::table('sr_approver_mstr')
                    ->insert([
                        'sr_approver_dept' => $req->te_code,
                        'sr_approver_order' => $req->te_seq[$flg],
                        'sr_approver_role' => $req->te_role[$flg],
                        'created_at'    => $dcreate,
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                    ]);
                }
                $flg += 1;  
            }

            toast('Approval SR Updated.', 'success');
            return back();
        } else {
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
        DB::table('sr_approver_mstr')
        ->whereSr_approver_dept($req->d_code)
        ->delete();

        toast('Deleted Approval SR Successfully.', 'success');
        return back();
    }
}
