<?php

namespace App\Http\Controllers\SP;

use App\Http\Controllers\Controller;
use App\Services\WSAServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Qxwsa as ModelsQxwsa;
use Exception;

class KebutuhanSPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function httpHeader($req)
    {
      return array(
        'Content-type: text/xml;charset="utf-8"',
        'Accept: text/xml',
        'Cache-Control: no-cache',
        'Pragma: no-cache',
        'SOAPAction: ""',        // jika tidak pakai SOAPAction, isinya harus ada tanda petik 2 --> ""
        'Content-length: ' . strlen(preg_replace("/\s+/", " ", $req))
      );
    }

    public function index(Request $request)
    {
        $asset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        $datawo = DB::table('wo_mstr')
            ->leftJoin('wo_dets', 'wo_dets_nbr', '=', 'wo_nbr')
            ->join('asset_mstr', 'asset_code', '=', 'wo_asset')
            ->leftjoin('sp_mstr', 'wo_dets_sp', '=', 'spm_code')
            ->where('wo_dets_sp', '<>', '')
            ->orderBy('wo_schedule');

        if ($request->s_nomorwo) {
            $datawo->where('wo_nbr', '=', $request->s_nomorwo);
        }

        if ($request->s_asset) {
            $datawo->where('asset_code', '=', $request->s_asset);
        }

        if ($request->s_priority) {
            $datawo->where('wo_priority', '=', $request->s_priority);
        }

        $datawo = $datawo->paginate(10);

        // dd($datawo);

        return view('schedule.kebutuhansp-browse', ['datawo' => $datawo, 'asset' => $asset]);
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
     * @param  \App\KebutuhanSP  $kebutuhanSP
     * @return \Illuminate\Http\Response
     */

}
