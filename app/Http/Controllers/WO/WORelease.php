<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WORelease extends Controller
{
    //

    public function browse(Request $request){
        
        $asset1 = DB::table('asset_mstr')
                    ->where('asset_active','=','Yes')
                    ->get();

        $data = DB::table('wo_mstr')
                ->join('asset_mstr','asset_mstr.asset_code','wo_mstr.wo_asset')
                ->where('wo_status','=','open')
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_id', 'desc');

        
        if($request->s_nomorwo){
            $data->where('wo_nbr','=',$request->s_nomorwo);
        }

        if($request->s_asset){
            $data->where('asset_code','=',$request->s_asset);
        }

        if($request->s_priority){
            $data->where('wo_priority','=',$request->s_priority);
        }

        $data = $data->paginate(2);
        
        
        return view('workorder.worelease-browse',['asset1'=>$asset1,'data'=>$data]);
        
    }

    public function detailrelease($id){

        $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->where('wo_id','=',$id)
                ->first();

        $spdata = DB::table('sp_mstr')
                    ->orderBy('spm_code')
                    ->get();

        if($data->wo_repair_code1 != ""){

        }

        if($data->wo_repair_code2 != ""){

        }

        if($data->wo_repair_code3 != ""){

        }

        $sparepart1 = DB::table('wo_mstr')
                        ->leftJoin('rep_master','wo_mstr.wo_repair_code1','rep_master.repm_code')
                        ->leftJoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                        ->leftJoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                        ->where('wo_id','=',$id)
                        ->get();

        // dd($sparepart1);

        return view('workorder.worelease-detail', compact('data','spdata'));
    }
    
    public function requesttowh(Request $request){
        
    }
}
