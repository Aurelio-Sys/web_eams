<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PMdetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('asset_mstr')
            ->whereIn('asset_code', function($query){
                $query->select('aspm_asset')
                ->from('asset_pmdets');
            })
            ->orderby('asset_code')
            ->paginate(10);

        $dataasset = DB::table('asset_mstr')
            ->orderby('asset_code')
            ->get();

        return view('workorder.pmdets', ['data' => $data, 'dataasset' => $dataasset]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataasset = DB::table('asset_mstr')
            ->orderby('asset_code')
            ->get();

        return view('workorder.pmdets-create', ['dataasset' => $dataasset]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());

        DB::beginTransaction();

        try {
            foreach ($request->t_pmdet as $a => $key) {
                DB::table('asset_pmdets')->insert([
                    'aspm_asset' => $request->t_code,
                    'aspm_item' => $request->t_pmdet[$a],
                    'aspm_mea' => $request->t_mea[$a],
                    'aspm_value' => $request->t_value[$a],
                ]);
            }

            DB::commit();

            toast('WO Successfuly Released !', 'success');
            return redirect()->route('pmdets');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('WO Release Failed', 'error');
            return redirect()->route('browseRelease');
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
