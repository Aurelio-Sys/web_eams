<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Services\CreateTempTable;
use App\Services\WSAServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class WORelease extends Controller
{
    //

    public function browse(Request $request)
    {

        $asset1 = DB::table('asset_mstr')
            ->where('asset_active', '=', 'Yes')
            ->get();

        if(Session::get('role') == 'ADMIN'){
            $data = DB::table('wo_mstr')
                ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
                ->whereIn('wo_status', ['firm'])
                ->orderby('wo_system_create', 'desc');
        }else{

            $username = Session::get('username');

            // dd($username);

            $data = DB::table('wo_mstr')
            ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
            ->join('asset_mstr', 'asset_mstr.asset_code', 'wo_mstr.wo_asset_code')
            ->whereIn('wo_status', ['firm'])
            ->where('wo_list_engineer', 'like', '%'.$username.'%')
            ->orderby('wo_system_create', 'desc');
        }

        

        if ($request->s_nomorwo) {
            $data->where('wo_number', 'like', '%'.$request->s_nomorwo.'%');
        }

        if ($request->s_asset) {
            $data->where('wo_asset_code', '=', $request->s_asset);
        }

        if ($request->s_priority) {
            $data->where('wo_priority', '=', $request->s_priority);
        }

        $data = $data->paginate(10);
        // $data = $data->get();

        return view('workorder.worelease-browse', ['asset1' => $asset1, 'data' => $data]);
    }

    public function detailrelease($id)
    {

        $data = DB::table('wo_mstr')
            // ->select('wo_mstr.id as wo_id','wo_number','asset_code','asset_desc','wo_status','wo_start_date','wo_due_date','wo_priority')
            ->join('asset_mstr', 'wo_mstr.wo_asset_code', 'asset_mstr.asset_code')
            ->where('wo_mstr.id', '=', $id)
            ->first();

        $sp_all = DB::table('sp_mstr')
                ->select('spm_code','spm_desc', 'spm_um','spm_site','spm_loc','spm_lot')
                ->where('spm_active','=', 'Yes')
                ->get();

            // dd($data->wo_sp_code);

        if ($data->wo_sp_code !== null) {
            // melakukan sesuatu jika nilai dari $data->wo_sp_code tidak null

            $wo_sp = DB::table('spg_list')
                    ->join('sp_mstr','sp_mstr.spm_code','spg_list.spg_spcode')
                    ->where('spg_code','=', $data->wo_sp_code)
                    ->get();
            
        } else {
            // melakukan sesuatu jika nilai dari $data->wo_sp_code null
            $wo_sp = collect([]);
        }

        return view('workorder.worelease-detail', compact('data','sp_all', 'wo_sp'));
    }

    public function submitrelease(Request $req)
    {        

        DB::beginTransaction();

        try {

            //mengelompokan data dari request depan
            $requestData = $req->all(); // mengambil data dari request
            $data = [
                "spreq" => $requestData['spreq'],
                "qtystandard" => $requestData['qtystandard'],
                "qtyrequired" => $requestData['qtyrequired'],
            ];
            
            $groupedData = collect($data['spreq'])->map(function ($spreq, $key) use ($data) {
                return [
                    'spreq' => $spreq,
                    'qtystandard' => $data['qtystandard'][$key],
                    'qtyrequired' => $data['qtyrequired'][$key],
                ];
            })->groupBy('spreq')->map(function ($group) {
                $totalQtyRequired = $group->sum('qtyrequired');
                $totalQtyStandard = $group->sum('qtystandard');
            
                return [
                    'spreq' => $group[0]['spreq'],
                    'qtystandard' => $totalQtyStandard,
                    'qtyrequired' => $totalQtyRequired,
                ];
            })->values();

            $data = [];

            //cari dan simpan ke dalam inv_required kemudian ambil data dari QAD berdasarkan table inp_supply yang kondisinya inp_asset_site sama dengan asset site wo yang di release
            foreach($groupedData as $loopsp){
                $ir = DB::table('inv_required')
                    ->where('ir_spare_part', $loopsp['spreq'])
                    ->where('ir_site', $req->assetsite)
                    ->first();
                if ($ir) {
                    // jika data sudah ada, update record table inv_required
                    DB::table('inv_required')
                        ->where('ir_spare_part', $loopsp['spreq'])
                        ->where('ir_site', $req->assetsite)
                        ->update([
                            'inv_qty_required' => DB::raw('inv_qty_required + '.$loopsp['qtyrequired']), //inv_qty_required yang lama + inv_qty_required dari wo yang baru di release
                            'ir_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                } else {
                    // jika data belum ada, buat data baru
                    DB::table('inv_required')->insert([
                        'ir_spare_part' => $loopsp['spreq'],
                        'ir_site' => $req->assetsite,
                        'inv_qty_required' => $loopsp['qtyrequired'],
                        'ir_create' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'ir_update' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    ]);
                }

                //harus ada datanya. ambil data dari table inp_supply untuk kemudian dicheck ke QAD untuk qty on hand yang ada di QAD
                $supplydata = DB::table('inp_supply')
                            ->where('inp_asset_site','=', $req->assetsite)
                            ->where('inp_avail','=', 'Yes')
                            ->get();

                // dd($supplydata);

                //looping wsa ke qad berdasarkan dari table inventory dengan kondisi inp_asset_site adalah request dari asset wo dan inp_avail nya yes
                foreach($supplydata as $invsupply){
                    //wsa ambil data ke qad
                    $qadsupplydata = (new WSAServices())->wsagetsupply($loopsp['spreq'],$invsupply->inp_supply_site,$invsupply->inp_loc);

                    if ($qadsupplydata === false) {
                        toast('WSA Connection Failed', 'error')->persistent('Dismiss');
                        return redirect()->back();
                    } else {

                        // jika hasil WSA ke QAD tidak ditemukan
                        if ($qadsupplydata[1] == "false") {
                            // dd('stop there');
                            toast('Something went wrong with the data', 'error')->persistent('Dismiss');
                            return redirect()->back();
                        }


                        // jika hasil WSA ditemukan di QAD, ambil dari QAD kemudian disimpan dalam array untuk nantinya dikelompokan lagi data QAD tersebut berdasarkan part dan site
                        
                        $resultWSA = $qadsupplydata[0];
                        
                        $t_domain = (string) $resultWSA[0]->t_domain;
                        $t_part = (string) $resultWSA[0]->t_part;
                        $t_site = (string) $resultWSA[0]->t_site;
                        $t_loc = (string) $resultWSA[0]->t_loc;
                        $t_qtyoh = (string) $resultWSA[0]->t_qtyoh;

                        array_push($data, [
                            't_domain' => $t_domain,
                            't_part' => $t_part,
                            't_site' => $t_site,
                            't_loc' => $t_loc,
                            't_qtyoh' => $t_qtyoh,
                        ]);
                    }

                    //tampung didalam array


                }

            }


            // dd($data);


            //proses pengelompokan berdasarkan part dan site sehingga didapat total qty onhand untuk part per site nya data QAD
            foreach ($data as $item) {
                $part = $item['t_part'];
                $site = $item['t_site'];
                $qtyoh = $item['t_qtyoh'];
            
                if (!isset($result[$part][$site])) {
                    $result[$part][$site] = [
                        'part' => $part,
                        'site' => $site,
                        'qtyoh' => 0,
                    ];
                }
            
                $result[$part][$site]['qtyoh'] += $qtyoh;
            }
            

            //hasil pengelompokan/grouping by part dan site data QAD kemudian ditampung dalam $output
            $output = [];
            foreach ($result as $part => $sites) {
                foreach ($sites as $site => $qtyoh) {
                    $output[] = $qtyoh;
                }
            }

            dd(collect($output));

            //mulai membandingkan data antara data di table inv_required (web) dengan qty tersedia dari data QAD ($output)

            //ambil data dari table inv_required
            $getInvRequired = DB::table('inv_required')
                            ->where()

            dd('stop here');

            DB::commit();

            toast('WO Successfuly Released !', 'success');
            return redirect()->route('browseRelease');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('WO Release Failed', 'error');
            return redirect()->route('browseRelease');
        }
    }
}
