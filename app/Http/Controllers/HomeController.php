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
                    ->where("users.id",$id)
                    ->get();

    
        return view("home");   
    }

    
}
