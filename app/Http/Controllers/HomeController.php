<?php

namespace App\Http\Controllers;

use App\Charts\UserChart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Session;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $req)
    {
        $id = Auth::id();

        $users = DB::table("users")
            ->where("users.id", $id)
            ->get();



        return view("home");
    }

    public function expenseMT()
    {
        $expenses = DB::table('wo_mstr')
            ->select('wo_mstr.wo_department', 'dept_mstr.dept_desc', DB::raw('ROUND(SUM(wo_dets_sp.wd_sp_issued * wo_dets_sp.wd_sp_itemcost),2) as total_sparepart_cost'))
            ->join('wo_dets_sp', 'wo_mstr.wo_number', '=', 'wo_dets_sp.wd_sp_wonumber')
            ->join('dept_mstr', 'wo_mstr.wo_department', 'dept_mstr.dept_code')
            ->where('wo_mstr.wo_status', 'closed')
            ->groupBy('wo_mstr.wo_department')
            ->orderBy('total_sparepart_cost', 'asc')
            ->get();

        return response()->json($expenses);
    }

    public function WoGraph()
    {
        $WoOpen = DB::table('wo_mstr')
            ->whereNotIn('wo_status', ['close', 'canceled'])
            ->count();

        $currentDate = Carbon::now()->toDateString();

        $WoOverDue = DB::table('wo_mstr')
            ->whereNotIn('wo_status', ['close', 'canceled'])
            ->whereDate('wo_due_date', '<', $currentDate)
            ->count();

        $WoOnProg = DB::table('wo_mstr')
            ->where('wo_status', 'started')
            ->count();

        return response()->json([
            'WoOpen' => $WoOpen,
            'WoOverDue' => $WoOverDue,
            'WoOnProg' => $WoOnProg
        ]);
    }

    public function WoDeptStats()
    {
        $WoPerDept = DB::table('wo_mstr')
            ->select(DB::raw('count(*) as count'), 'dept_desc')
            ->join('dept_mstr','wo_mstr.wo_department','dept_mstr.dept_code')
            ->groupBy('wo_department')
            ->get();

        return response()->json($WoPerDept);
    }
}
