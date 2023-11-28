<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\User;
use Carbon\Carbon;
use Svg\Tag\Rect;

class impController extends Controller
{
    public function home(Request $req)
    {
        $scode = $req->s_code;
        $sdesc = $req->s_desc;
        
        $data = DB::table('imp_mstr');

        if($scode) {
            $data = $data->where('imp_code','like','%'.$scode.'%');
        }
        if($sdesc) {
            $data = $data->where('imp_desc','like','%'.$sdesc.'%');
        }

        $data = $data->paginate(10);

        return view('/setting/imp', compact('data','scode','sdesc'));
    }

    public function create(Request $req)
    {
        $code  = $req->input('t_code');
        $desc = $req->input('t_desc');


        $data1 = array(
            'imp_code' => $code,
            'imp_desc' => $desc,
        );

        DB::table('imp_mstr')->insert($data1);
        return redirect()->back();
    }

    public function edit(Request $req)
    {
        $code  = $req->input('te_code');
        $desc = $req->input('te_desc');

        $data1 = array(
            'imp_desc' => $desc,
        );

        DB::table('imp_mstr')->where('imp_code', $code)->update($data1);

        $data = DB::table('imp_mstr')
            ->get();

        return redirect()->back();
    }

    public function delete(Request $req)
    {
        $code  = $req->input('d_code');


        DB::table('imp_mstr')->where('imp_code', $code)->delete();
        return redirect()->back();
    }
}
