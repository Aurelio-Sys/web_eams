<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmEng extends Controller
{
    //

    public function index(Request $request){
        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        $data = DB::table('wo_mstr')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset')
            ->where('wo_status', '=', 'open')
            ->orderby('wo_created_at', 'desc')
            ->orderBy('wo_mstr.wo_id', 'desc');


        if ($request->s_nomorwo) {
            $data->where('wo_nbr', '=', $request->s_nomorwo);
        }

        if ($request->s_asset) {
            $data->where('asset_code', '=', $request->s_asset);
        }

        if ($request->s_priority) {
            $data->where('wo_priority', '=', $request->s_priority);
        }

        $data = $data->paginate(10);


        return view('workorder.confirmeng-browse', ['asset1' => $asset1, 'data' => $data]);
    }
}
