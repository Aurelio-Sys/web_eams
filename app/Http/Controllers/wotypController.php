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

class wotypController extends Controller
{
     public function home(Request $request)
    {
       
	    $data = DB::table('wotyp_mstr');

        if ($request->s_code) {
            $data->where('wotyp_code', '=', $request->s_code);
        }

        if ($request->s_desc) {
            $data->where('wotyp_desc', '=', $request->s_desc);
        }

        $data = $data->get();
					
        return view('/setting/wotyp',compact('data'));  
    }
    
     public function create(Request $req)
	{
        $code  = $req->input('t_code');	
        $desc = $req->input('t_desc');
        
        
        $data1 = array('wotyp_code'=>$code,
                        'wotyp_desc'=>$desc,                           
                    );               
                    
        DB::table('wotyp_mstr')->insert($data1);	
   
        toast('WO type successfully created', 'success');
        return redirect()->back();                       
    }
     
    public function edit(Request $req)
	{
		$code  = $req->input('te_code');	
        $desc = $req->input('te_desc');
        
        $data1 = array(
                        'wotyp_desc'=>$desc,                           
                    );   

        DB::table('wotyp_mstr')->where('wotyp_code',$code)->update($data1);	
        
        toast('WO type successfully updated', 'success');
        return redirect()->back();
    
   }
   
   public function delete(Request $req)
	{
		$code  = $req->input('d_code');	

		
		DB::table('wotyp_mstr')->where('wotyp_code', $code)->delete();
        
        toast('WO type successfully deleted', 'success');
        return redirect()->back();
	}
   
}
