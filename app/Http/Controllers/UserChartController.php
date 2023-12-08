<?php

namespace App\Http\Controllers;

use App\Charts\UserChart;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use App\Services\WSAServices;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Qxwsa as ModelsQxwsa;
use Exception;

class UserChartController extends Controller
{

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chart = new UserChart;
        $chart->labels(['senin','selasa','rabu','kamis','jumat','sabtu','minggu']);
        $chart->dataset('Laporan Pendapatan', 'line', ['9000','7000','4000','12000','10000','15000','18000']);

        return view('report.users', compact('chart'));
    }

    public function rptwo()
    {
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)"
        ];

        $totals = DB::table('wo_mstr')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when DATEDIFF(NOW(),wo_created_at) <= 3 then 1 end) as a")
            ->selectRaw("count(case when DATEDIFF(NOW(),wo_created_at) > 3 and DATEDIFF(NOW(),wo_created_at) <= 3 then 1 end) as b")
            ->selectRaw("count(case when DATEDIFF(NOW(),wo_created_at) > 5 then 1 end) as c")
            ->first();

        $jml = [];
        $jml[] = $totals->a;
        $jml[] = $totals->b;
        $jml[] = $totals->c;

        $chart = new UserChart;
        $chart->labels(['wo < 3days','3days < wo < 5days','wo > 5days']);
        $chart->dataset('Status Work Order', 'bar', $jml)
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        $totsr = DB::table('service_req_mstr')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when DATEDIFF(NOW(),sr_created_at) <= 3 then 1 end) as a")
            ->selectRaw("count(case when DATEDIFF(NOW(),sr_created_at) > 3 and DATEDIFF(NOW(),sr_created_at) <= 3 then 1 end) as b")
            ->selectRaw("count(case when DATEDIFF(NOW(),sr_created_at) > 5 then 1 end) as c")
            ->first();

        $jmlsr = [];
        $jmlsr[] = $totsr->a;
        $jmlsr[] = $totsr->b;
        $jmlsr[] = $totsr->c;

        $chartsr = new UserChart;
        $chartsr->labels(['sr < 3days','3days < sr < 5days','sr > 5days']);
        $chartsr->dataset('Status Service Request', 'bar', $jmlsr)
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        $totasset = DB::table('wo_mstr')
                ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                ->where('wo_status','=','started')
                ->groupby('wo_asset')
                ->get();

        $asset = [];
        foreach ($totasset as $ta) {
            $asset[] = $ta->wo_asset;
        }

        $jmlasset = [];
        foreach ($totasset as $tta) {
            $jmlasset[] = $tta->jmlasset;
        }

        $chartasset = new UserChart;
        $chartasset->labels($asset);
        $chartasset->dataset('Status Asset', 'bar', $jmlasset)
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        return view('report.rptwo', compact('chart','chartsr','chartasset','datawo'));

    }

    public function topten() 
    {
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)"
        ];

        $skrg = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        $lalu = Carbon::now('ASIA/JAKARTA')->addYear(-1)->toDateTimeString();

        $totasset = DB::table('wo_mstr')
                    ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                    ->whereBetween('wo_created_at',[$lalu,$skrg])
                    ->groupby('wo_asset')
                    ->limit(10)
                    ->get();

        $asset = [];
        foreach ($totasset as $ta) {
            $asset[] = $ta->wo_asset;
        }

        $jmlasset = [];
        foreach ($totasset as $tta) {
            $jmlasset[] = $tta->jmlasset;
        }

        $chartasset = new UserChart;
        $chartasset->labels($asset);
        $chartasset->dataset('Status Asset', 'bar', $jmlasset)
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        $non = DB::table('wo_mstr')
                ->select('wo_asset')
                ->groupby('wo_asset')
                ->get();

        $totnon = DB::table('asset_mstr')
                ->whereNotIn('asset_code',DB::table('wo_mstr')->groupby('wo_status')->pluck('wo_asset')->toArray())
                ->limit(10)
                ->get();

        $tophealthy = DB::table('asset_mstr')
            ->whereNotIn('asset_code',DB::table('wo_mstr')->groupby('wo_asset')->pluck('wo_asset')->toArray())
            ->limit(10)
            ->get();

        $skrg = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        $lalu = Carbon::now('ASIA/JAKARTA')->addYear(-1)->toDateTimeString();

        $topprob = DB::table('wo_mstr')
                    ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                    ->whereBetween('wo_created_at',[$lalu,$skrg])
                    ->groupby('wo_asset')
                    ->orderby('jmlasset','desc')
                    ->limit(10)
                    ->get();

        $dataasset = DB::table('asset_mstr')
                    ->get();

        return view('report.topten', compact('chartasset','tophealthy','topprob','dataasset'));
    }

    public function topprob()
    {
        $skrg = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        $lalu = Carbon::now('ASIA/JAKARTA')->addYear(-1)->toDateTimeString();

        $data = DB::table('wo_mstr')
                    ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                    ->whereBetween('wo_created_at',[$lalu,$skrg])
                    ->groupby('wo_asset')
                    ->orderby('jmlasset','desc')
                    ->paginate(5);

        $dataasset = DB::table('asset_mstr')
                    ->get();

        return view('report.topprob', compact('data','dataasset'));
    }

    public function topprobpagination(Request $req)
    {
        if ($req->ajax()) {
            $sort_by = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $code = $req->get('code');
            $desc = $req->get('desc');

            $dataasset = DB::table('asset_mstr')
                    ->get();

            if ($code == '' && $desc == '') {
                $data = DB::table('wo_mstr')
                    ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                    ->whereBetween('wo_created_at',[$lalu,$skrg])
                    ->groupby('wo_asset')
                    ->orderby('jmlasset','desc')
                    ->paginate(5);

                return view('report.table-topprob', compact('data','$dataasset'));

            } else {
                $kondisi = '';
                if ($code != '') {
                    $kondisi = 'dept_code like "%' . $code . '%"';
                }
                if ($desc != '') {
                    if ($kondisi != '') {
                        $kondisi .= ' and dept_desc like "%' . $desc . '%"';
                    } else {
                        $kondisi = 'dept_desc like "%' . $desc . '%"';
                    }
                }

                $data = DB::table('wo_mstr')
                    ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                    ->whereBetween('wo_created_at',[$lalu,$skrg])
                    ->groupby('wo_asset')
                    ->orderby('jmlasset','desc')
                    ->paginate(5);


                return view('report.table-topprob', compact('data','$dataasset'));

            }
        }
    }

    //untuk Detail WO berdasarkan asset
    public function detailtopprob(Request $req)
    {
        
        if($req->ajax()){
            
             $data = DB::table('wo_mstr')
                ->where('wo_asset','=',$req->code)
                ->orderby('wo_created_at','asc')
                ->get();

            if($data){
                $output = '';
                $i = 1;
                foreach($data as $data){

                    $output .= '<tr>'.
                            '<td>'.$i.'</td>'.
                            '<td>'.$data->wo_nbr.'</td>'.
                            '<td>'.$data->wo_sr_nbr.'</td>'.
                            '<td>'.$data->wo_engineer1.'</td>'.
                            '<td>'.$data->wo_created_at.'</td>'.
                            '<td>'.$data->wo_failure_code1.'</td>'.
                            '</tr>';
                    $i += 1;
                }
                //dd($output);
                return response($output);
            }

        }
    }

    public function tophealthy() 
    {
        $non = DB::table('wo_mstr')
                ->select('wo_asset')
                ->groupby('wo_asset')
                ->get();

        $data = DB::table('asset_mstr')
                ->whereNotIn('asset_code',DB::table('wo_mstr')->groupby('wo_asset')->pluck('wo_asset')->toArray())
                ->limit(10)
                ->get();

        return view('report.tophealthy', compact('data'));
    }

    public function engsch(Request $req)
    {
        //dd($req->all());
        if (is_null($req->bulan)) {
            $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        } elseif ($req->stat == 'mundur') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(-1)->toDateTimeString();
        } elseif ($req->stat == 'maju') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(1)->toDateTimeString();
        } elseif (!is_null($req->engcode) || !is_null($req->wotype)) {
            $tgl = Carbon::createFromDate($req->bulan)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }
        
        $engcode = $req->input('engcode');
        $wotype  = $req->input('wotype') ? $req->input('wotype') : 'All'  ;
        $sdept  = $req->input('s_dept');
       
        $skrg = Carbon::createFromDate($tgl)->lastOfMonth()->day;
        $hari = Carbon::createFromDate($tgl)->startOfMonth()->isoFormat('dddd');
        $bulan = Carbon::createFromDate($tgl)->isoFormat('MMMM YYYY');
        
        switch ($hari) {
            case "Monday":
                $kosong = 0;
                break;
            case "Tuesday":
                $kosong = 1;
                break;
            case "Wednesday":
                $kosong = 2;
                break;
            case "Thursday":
                $kosong = 3;
                break;
            case "Friday":
                $kosong = 4;
                break;
            case "Saturday":
                $kosong = 5;
                break;
            case "Sunday":
                $kosong = 6;
                break;
        }
        
        $dataeng = DB::table('users')
                ->join('eng_mstr','eng_code','=','username')
                ->whereAccess('Engineer')
                ->whereActive('Yes')
                ->orderBy('eng_code')
                ->get();

        if (!isset($engcode) && !isset($sdept) && $wotype == 'All'){
            // query disamakan dengan assetsch
            $datawo = DB::table('wo_mstr')
                ->select('wo_number','wo_status','wo_start_date','wo_list_engineer','wo_asset_code','asset_desc','wo_sr_number','wo_due_date','wo_createdby','wo_note',
                    'wo_job_startdate','wo_job_finishdate','wo_type','wo_location','wo_site','asloc_desc')
                ->selectRaw("day(wo_start_date) AS tgl")
                ->join('asset_mstr','asset_code','=','wo_asset_code')
                ->join('asset_loc','asloc_code','=','wo_location')
                ->where('wo_start_date','like',date("Y-m",strtotime($tgl)).'%')
                ->orderBy('tgl')
                ->orderBy('wo_number');

            $fotoeng = $dataeng->where('eng_code','=',"")->first();
        }
        else
        {
            $datawo = DB::table('wo_mstr')
                ->select('wo_number','wo_status','wo_start_date','wo_list_engineer','wo_asset_code','asset_desc','wo_sr_number','wo_due_date','wo_createdby','wo_note',
                    'wo_job_startdate','wo_job_finishdate','wo_type','wo_location','wo_site','asloc_desc')
                ->selectRaw("day(wo_start_date) AS tgl")
                ->join('asset_mstr','asset_code','=','wo_asset_code')
                ->join('asset_loc','asloc_code','=','wo_location')
                ->where('wo_start_date','like',date("Y-m",strtotime($tgl)).'%')
                ->orderBy('tgl')
                ->orderBy('wo_number');
         
            if(isset($engcode)) {
                $datawo = $datawo->where('wo_list_engineer','like','%'.$engcode.'%');
            }
            if(isset($sdept)) {

                $engDept = $sdept;

                $datawo = $datawo
                ->where('wo_list_engineer', 'LIKE', '%'.$engDept.'%')
                ->orWhereExists(function ($query) use ($engDept) {
                    $query->select(DB::raw(1))
                        ->from('eng_mstr')
                        ->whereRaw("FIND_IN_SET(eng_code, REPLACE(wo_list_engineer, ';', ','))")
                        ->where('eng_dept', '=', $engDept);
                });

            }
            if($wotype <> 'All') {
                $datawo = $datawo->where('wo_type','=',$wotype);
            }
          
           $fotoeng = $dataeng->where('eng_code','=',$engcode)->first();
        }

        $datawo = $datawo->get();

        $datafn = DB::table('fn_mstr')
                ->get();

        $datadept = DB::table('dept_mstr')
            ->orderBy('dept_code')
            ->get();            

        return view('report.engsch',compact('skrg','hari','kosong','bulan','datawo','dataeng','fotoeng','engcode','datafn','wotype',
            'datadept','sdept'));
    }
    
    public function allrpt(Request $req)
    {
        //dd($req->all());
        if (is_null($req->bulan)) {
            $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        } elseif ($req->stat == 'mundur') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(-1)->toDateTimeString();
        } elseif ($req->stat == 'maju') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(1)->toDateTimeString();
        } elseif (!is_null($req->engcode)) {
            $tgl = Carbon::createFromDate($req->bulan)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }
        
        $engcode = $req->input('engcode');
       
        $skrg = Carbon::createFromDate($tgl)->lastOfMonth()->day;
        $hari = Carbon::createFromDate($tgl)->startOfMonth()->isoFormat('dddd');
        $bulan = Carbon::createFromDate($tgl)->isoFormat('MMMM YYYY');
        
        switch ($hari) {
            case "Monday":
                $kosong = 0;
                break;
            case "Tuesday":
                $kosong = 1;
                break;
            case "Wednesday":
                $kosong = 2;
                break;
            case "Thursday":
                $kosong = 3;
                break;
            case "Friday":
                $kosong = 4;
                break;
            case "Saturday":
                $kosong = 5;
                break;
            case "Sunday":
                $kosong = 6;
                break;
        }
        
        $dataeng = DB::table('users')
                ->join('eng_mstr','eng_code','=','username')
                ->whereAccess('Engineer')
                ->orderBy('eng_desc')
                ->get();

        $datawo = DB::table('wo_mstr')
            ->select('wo_nbr','wo_status','wo_schedule','wo_engineer1', 'wo_engineer2', 'wo_engineer3', 'wo_engineer4',
                'wo_engineer5','wo_asset','asset_desc','wo_sr_nbr','wo_duedate','wo_failure_code1','wo_failure_code2',
                'wo_failure_code3','wo_creator','wo_note','wo_start_date','wo_finish_date','wo_type')
            ->selectRaw("(case when wo_status in ('open','plan','started') then day(wo_schedule) else day(wo_finish_date) end) as tgl")
            ->join('asset_mstr','asset_code','=','wo_asset')
            ->where(function ($query) use ($tgl) {
                $query->where('wo_schedule','like',date("Y-m",strtotime($tgl)).'%')
                    ->orwhere('wo_finish_date','like',date("Y-m",strtotime($tgl)).'%');
            })
            ->orderBy('tgl')
            ->orderBy('wo_nbr')
            ->get();
        //dd($datawo);
        $fotoeng = $dataeng->where('eng_code','=',"")->first();


        $datafn = DB::table('fn_mstr')
                ->get();

        return view('report.allrpt',compact('skrg','hari','kosong','bulan','datawo','dataeng','fotoeng','engcode','datafn'));
    }

    public function engsch1(Request $req)
    {
        $tgl = Carbon::createFromDate($req->bulan)->addMonth(-1)->toDateTimeString();
        
        $skrg = Carbon::createFromDate($tgl)->lastOfMonth()->day;
        $hari = Carbon::createFromDate($tgl)->startOfMonth()->isoFormat('dddd');
        $bulan = Carbon::createFromDate($tgl)->isoFormat('MMMM YYYY');
        
        switch ($hari) {
            case "Monday":
                $kosong = 0;
                break;
            case "Tuesday":
                $kosong = 1;
                break;
            case "Wednesday":
                $kosong = 2;
                break;
            case "Thursday":
                $kosong = 3;
                break;
            case "Friday":
                $kosong = 4;
                break;
            case "Saturday":
                $kosong = 5;
                break;
            case "Sunday":
                $kosong = 6;
                break;
        }

        $datawo = DB::table('wo_mstr')
                ->whereMonth('wo_schedule','=',date("m",strtotime($tgl)))
                ->get();
        //dd($tgl);

        return view('report.engsch',compact('skrg','hari','kosong','bulan','datawo'));
    }

    public function engsch2(Request $req)
    {
        $tgl = Carbon::createFromDate($req->bulan)->addMonth(1)->toDateTimeString();
        
        $skrg = Carbon::createFromDate($tgl)->lastOfMonth()->day;
        $hari = Carbon::createFromDate($tgl)->startOfMonth()->isoFormat('dddd');
        $bulan = Carbon::createFromDate($tgl)->isoFormat('MMMM YYYY');
        
        switch ($hari) {
            case "Monday":
                $kosong = 0;
                break;
            case "Tuesday":
                $kosong = 1;
                break;
            case "Wednesday":
                $kosong = 2;
                break;
            case "Thursday":
                $kosong = 3;
                break;
            case "Friday":
                $kosong = 4;
                break;
            case "Saturday":
                $kosong = 5;
                break;
            case "Sunday":
                $kosong = 6;
                break;
        }
        return view('report.engsch',compact('skrg','hari','kosong','bulan'));
    }

    public function bookcal(Request $req)
    {
        //dd($req->all());
        if (is_null($req->bulan)) {
            $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        } elseif ($req->stat == 'mundur') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(-1)->toDateTimeString();
        } elseif ($req->stat == 'maju') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(1)->toDateTimeString();
        } elseif (!is_null($req->t_asset)) {
            $tgl = Carbon::createFromDate($req->bulan)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }
        
        $skrg = Carbon::createFromDate($tgl)->lastOfMonth()->day;
        $hari = Carbon::createFromDate($tgl)->startOfMonth()->isoFormat('dddd');
        $bulan = Carbon::createFromDate($tgl)->isoFormat('MMMM YYYY');
        
        switch ($hari) {
            case "Monday":
                $kosong = 0;
                break;
            case "Tuesday":
                $kosong = 1;
                break;
            case "Wednesday":
                $kosong = 2;
                break;
            case "Thursday":
                $kosong = 3;
                break;
            case "Friday":
                $kosong = 4;
                break;
            case "Saturday":
                $kosong = 5;
                break;
            case "Sunday":
                $kosong = 6;
                break;
        }

        $dataAsset = DB::table('asset_mstr')
                    ->orderBy('asset_code')
                    ->get();

        $tglquery = date("m",strtotime($tgl));
        $thnquery = date("Y",strtotime($tgl));

        $dataPost = DB::table('booking')
                    ->join('asset_mstr','asset_code','=','book_asset')
                    ->select('book_code','book_asset','book_start','book_end', 'book_edited_by','book_status','asset_desc','book_allday','book_asset','book_note')
                    ->selectRaw('DAY(book_start) as tgl')
                    ->where(function ($query) use ($tglquery) {
                        $query->whereMonth('book_start','=',$tglquery)
                              ->orWhereMonth('book_end','=',$tglquery);
                    })
                    ->where(function ($query) use ($thnquery) {
                        $query->whereYear('book_start','=',$thnquery)
                              ->orwhereYear('book_end','=',$thnquery);
                    });

        $asset = $req->t_asset;

        $dataPost->when(isset($asset), function($q) use ($asset) {
            $q->where('book_asset', $asset);
        });

        $dataBook = $dataPost->get();
        
        $arraynewdate = [];
        $i = 1;
        // dd($dataBook);
        foreach($dataBook as $db) {

            $dbstart    = $db->book_start;
            $dbend      = $db->book_end;
            $dbcode     = $db->book_code;
            $dbby       = $db->book_edited_by;
            $dbstime    = date('H:i', strtotime($dbstart));
            $dbetime    = date('H:i', strtotime($dbend));
            $dbstatus   = $db->book_status;
            $dbasset    = $db->asset_desc;
            $dballday   = $db->book_allday;
            $dbcasset   = $db->book_asset;
            $dbnote   = $db->book_note;

            $dateRange = CarbonPeriod::between($dbstart, $dbend);

            foreach($dateRange as $dr){
                if(date("m",strtotime($tgl)) == $dr->format('m')) {
                    array_push($arraynewdate, [$dbcode,$dbby,$dr->format('d'),$dbstime,$dbetime,$dbstatus,$dbasset,$dballday,$dbstart,$dbend,$dbcasset,$dbnote]);
                }
            }

        }

        return view('report.bookcal',compact('skrg','hari','kosong','bulan','dataAsset','dataBook','arraynewdate','asset'));
    }

    public function assetsch(Request $req) /** Blade : report.assetsch */
    {
        // dd($req->all());
        if (is_null($req->bulan)) {
            $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        } elseif ($req->stat == 'mundur') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(-1)->toDateTimeString();
        } elseif ($req->stat == 'maju') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(1)->toDateTimeString();
        } elseif (!is_null($req->t_asset) || !is_null($req->t_loc) || !is_null($req->t_status)) {
            $tgl = Carbon::createFromDate($req->bulan)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }
        //dd($req->all(),$tgl);

        $code = $req->input('t_asset');
        $sloc = $req->input('t_loc');
        $sstatus = $req->input('t_status');
       
        $skrg = Carbon::createFromDate($tgl)->lastOfMonth()->day;
        $hari = Carbon::createFromDate($tgl)->startOfMonth()->isoFormat('dddd');
        $bulan = Carbon::createFromDate($tgl)->isoFormat('MMMM YYYY');
        
        switch ($hari) {
            case "Monday":
                $kosong = 0;
                break;
            case "Tuesday":
                $kosong = 1;
                break;
            case "Wednesday":
                $kosong = 2;
                break;
            case "Thursday":
                $kosong = 3;
                break;
            case "Friday":
                $kosong = 4;
                break;
            case "Saturday":
                $kosong = 5;
                break;
            case "Sunday":
                $kosong = 6;
                break;
        }
        
        $dataAsset = DB::table('asset_mstr')
            ->leftJoin('asset_loc', function($join) {
                $join->on('asloc_code','=','asset_loc');
                $join->on('asloc_site','=','asset_site');
            })
            ->orderBy('asset_code')
            ->get();

        $foto = $dataAsset->where('asset_code','=',"")->first();

        /** Mencari data asset yang ada data tanggal renewal */
        $datarenew = DB::table('asset_mstr')
            ->whereNotNull('asset_renew')
            ->get();

        $datawo = DB::table('wo_mstr')
            ->select('wo_number','wo_status','wo_start_date','wo_list_engineer','wo_asset_code','asset_desc','wo_sr_number','wo_due_date','wo_createdby','wo_note',
                'wo_job_startdate','wo_job_finishdate','wo_type','wo_location','wo_site','asloc_desc')
            ->selectRaw("day(wo_start_date) AS tgl")
            ->join('asset_mstr','asset_code','=','wo_asset_code')
            ->join('asset_loc','asloc_code','=','wo_location')
            ->where('wo_start_date','like',date("Y-m",strtotime($tgl)).'%')
            ->orderBy('tgl')
            ->orderBy('wo_number');
           
        if(isset($code)) {
            $datawo = $datawo->where('wo_asset_code','=',$code);
            $foto = $dataAsset->where('asset_code','=',$code)->first();
        }

        if(isset($sloc)) {
            $datawo = $datawo->where('wo_location','=',$sloc); 
        }

        if(isset($sstatus)) {
            $datawo = $datawo->where('wo_status','=',$sstatus); 
        }

        $datawo = $datawo->get();

        $datafn = DB::table('fn_mstr')
                ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        $dataeng = DB::table('eng_mstr')
            ->orderBy('eng_code')
            ->get();

        /** Mencari data WO untuk diambil datanya untuk melihat last Wo di View Preventive */
        $datalastwo = DB::table('wo_mstr')
            ->leftJoin('pma_asset', function ($join) {
                $join->on('wo_mstr.wo_asset_code', '=', 'pma_asset.pma_asset')
                    ->where(function ($query) {
                        $query->where('wo_mstr.wo_mt_code', '=', 'pma_asset.pma_pmcode')
                            ->orWhere(function ($subQuery) {
                                $subQuery->whereNull('wo_mstr.wo_mt_code')
                                            ->whereNull('pma_asset.pma_pmcode');
                            });
                    });
            })
            ->whereWo_type('PM')
            ->orderBy('wo_asset_code')
            ->orderBy('wo_mt_code')
            ->orderBy('wo_number','desc')
            ->orderBy('wo_start_date','desc')
            ->get();

        /** Menampilkan data PM yang belum confirm */
        $datapm = DB::table('pmo_confirm')
            ->leftJoin('pma_asset', function ($join) {
                $join->on('pmo_confirm.pmo_asset', '=', 'pma_asset.pma_asset')
                    ->where(function ($query) {
                        $query->where('pmo_confirm.pmo_pmcode', '=', DB::raw('pma_asset.pma_pmcode'))
                            ->orWhere(function ($subQuery) {
                                $subQuery->whereNull('pmo_confirm.pmo_pmcode')
                                        ->whereNull('pma_asset.pma_pmcode');
                            });
                    });
            })
            ->leftJoin("asset_mstr","asset_code","=",'pmo_asset')
            ->leftJoin('asset_loc', function($join) {
                $join->on('asloc_code','=','asset_loc');
                $join->on('asloc_site','=','asset_site');
            })
            ->leftJoin('pmc_mstr','pmo_pmcode','=','pmc_code')
            ->selectRaw("day(pmo_sch_date) AS tgl,pmo_asset,asset_desc,asset_site,asset_loc,asloc_desc,
                pmo_pmcode, pmo_sch_date,
                pma_eng, pma_leadtime, pmc_desc, pma_mea, pma_cal, pma_meter, pma_meterum,
                pmc_desc")
            ->selectRaw('CASE 
                WHEN pma_leadtime <= 1 
                THEN pmo_sch_date
                ELSE DATE_SUB(DATE_ADD(pmo_sch_date, INTERVAL pma_leadtime DAY), INTERVAL 1 DAY)
                END AS tgl_duedate')
            ->where('pmo_sch_date','like',date("Y-m",strtotime($tgl)).'%');

        if(isset($code)) {
            $datapm = $datapm->where('pmo_asset',$code);
        }
        if(isset($sloc)) {
            $datapm = $datapm->where('asset_loc',$sloc);
        }
        if(isset($sstatus)) {
            if($sstatus <> 'plan') {
                $datapm = $datapm->where('pmo_confirm.id','<',0);
            }
        }

        $datapm = $datapm->get();
// dd($datarenew);
        return view('report.assetsch',compact('skrg','hari','kosong','bulan','datawo','dataAsset','foto','datafn','dataloc',
            'sloc','sstatus','dataeng','datapm','datalastwo','datarenew'));
    }

    /** Detail untuk menampilkan data renew */
    public function assetschrenew($id)
    {
        //dd($id);

        // Convert $id to the database date format
        $idInDatabaseFormat = Carbon::createFromFormat('d-m-Y', $id)->format('Y-m-d');

        // Now, perform the database query
        $data = DB::table('asset_mstr')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->where('asset_renew', $idInDatabaseFormat)
            ->get();

        $output = '';
        foreach ($data as $data) {

            $output .= '<tr>'.
                '<td>'.$data->asset_code.'</td>'.
                '<td>'.$data->asset_desc.'</td>'.
                '<td>'.$data->asset_loc.'</td>'.
                '<td>'.$data->asloc_desc.'</td>'.
                '</tr>';
        }

        return response($output);
    }

    public function engrpt(Request $req)
    {
       
        $sdept = $req->s_dept;
        
        $dataeng = DB::table('users')
            ->join('eng_mstr','eng_code','=','username')
            ->join('dept_mstr','dept_code','=','dept_user')
            ->whereAccess('Engineer')
            ->orderBy('eng_desc');

        if ($sdept) {
            $dataeng = $dataeng->where('eng_dept','=',$sdept);
        }

        $dataeng = $dataeng->get();

        $datadept = DB::table('dept_mstr')
            ->whereIn('dept_code', function($query) {
                $query->select('dept_user')
                        ->from('users')
                        ->whereAccess('Engineer');
            })
            ->orderBy('dept_code')
            ->get();

        // Grafik hanya menampilkan data transaksi satu tahun terakhir
        $tahunKebelakang = Carbon::now()->subYear();

        $datawo = DB::table('wo_mstr')
                ->join('asset_mstr','asset_code','=','wo_asset_code')
                // ->whereNotIn('wo_status', ['closed','finish','delete'])
                ->where('wo_start_date', '>=', $tahunKebelakang)
                ->where('wo_start_date', '<=', Carbon::now())
                ->orderBy('wo_start_date')
                ->get();
// dd($datawo);
        $thn = Carbon::now('ASIA/JAKARTA')->addMonth(-11)->toDateTimeString();
        $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

        $period = CarbonPeriod::create($thn, '1 month', $tgl);

        $arraynewdate = [];
        foreach ($period as $dt) {
            array_push($arraynewdate, [$dt->format("Y-m")]);
        }

        return view('report.engrpt',compact('dataeng','datawo','arraynewdate','datadept',
        'sdept'));
    }

    public function engrptview(Request $req)
    {
        if ($req->ajax()) {

            $engcode = $req->code;

            // Grafik hanya menampilkan data transaksi satu tahun terakhir
            $tahunKebelakang = Carbon::now()->subYear();

            $data = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset_code')
                    // ->whereNotIn('wo_status', ['closed','finish','delete'])
                    // ->where(function ($query) use ($engcode) {
                    // $query->where('wo_engineer1', '=', $engcode)
                    //       ->orWhere('wo_engineer2', '=', $engcode)
                    //       ->orWhere('wo_engineer3', '=', $engcode)
                    //       ->orWhere('wo_engineer4', '=', $engcode)
                    //       ->orWhere('wo_engineer5', '=', $engcode);
                    // })
                    ->where('wo_list_engineer', 'like', '%' . $engcode . '%')
                    ->where('wo_start_date', '>=', $tahunKebelakang)
                    ->where('wo_start_date', '<=', Carbon::now())
                    ->orderBy('wo_start_date')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                // $eng = $data->wo_engineer1;
                // if(!is_null($data->wo_engineer2)) {
                //     $eng .= ", ".$data->wo_engineer2;
                // }
                // if(!is_null($data->wo_engineer3)) {
                //     $eng .= ", ".$data->wo_engineer3;
                // }
                // if(!is_null($data->wo_engineer4)) {
                //     $eng .= ", ".$data->wo_engineer4;
                // }
                // if(!is_null($data->wo_engineer5)) {
                //     $eng .= ", ".$data->wo_engineer5;
                // }

                // Memisahkan data menjadi array berdasarkan tanda ;
                $array_data = explode(";", $data->wo_list_engineer);

                // Menampilkan setiap elemen array dalam baris terpisah
                $nilaiBaris = "";
                foreach ($array_data as $nilai) {
                    $nilaiBaris .= $nilai . "<br>";
                }

                $output .= '<tr>'.
                '<td>'.$data->wo_number.'</td>'.
                '<td>'.$data->wo_asset_code.' - '.$data->asset_desc.'</td>'.
                '<td>'.$nilaiBaris.'</td>'.
                '<td>'.$data->wo_start_date.'</td>'.
                '<td>'.$data->wo_due_date.'</td>'.
                '<td>'.$data->wo_status.'</td>'.
                '</tr>';
            }

            return response($output);
        }
    }

    public function assetrpt(Request $req)
    {
        $stype = $req->s_type;
        $sasset = $req->s_asset;
        $seng = $req->s_eng;
        $sloc = $req->s_loc;

        $dataAsset = DB::table('asset_mstr')
            ->leftJoin('asset_loc','asloc_code','=','asset_loc')
            ->orderBy('asset_code');
			
		// Mendapatkan tanggal satu tahun kebelakang dari sekarang
        // Grafik ini hanya menampilkan data transaksi dalam satu tahun kebelakang
        $tahunKebelakang = Carbon::now()->subYear();

        $datawo = DB::table('wo_mstr')
            ->join('asset_mstr','asset_code','=','wo_asset_code')
            ->whereNotIn('wo_status', ['closed', 'finish', 'delete'])
            ->where('wo_start_date', '>=', $tahunKebelakang)
            ->where('wo_start_date', '<=', Carbon::now())
            ->orderBy('wo_start_date');

        if ($sasset) {
            $dataAsset->where('asset_code', '=', $sasset);
			$datawo->where('wo_asset_code', '=', $sasset);
        }
        if ($sloc) {
            $dataAsset->where('asset_loc', '=', $sloc);
			$datawo->where('asset_loc', '=', $sloc);
        }
        if($seng) {
            $a = $seng;
            $dataAsset = $dataAsset->whereIn('asset_code', function($query) use ($a)
            {
                $query->select('wo_asset')
                        ->from('wo_mstr')
                        ->where('wo_engineer1','=',$a)
                        ->orWhere('wo_engineer2','=',$a)
                        ->orWhere('wo_engineer3','=',$a)
                        ->orWhere('wo_engineer4','=',$a)
                        ->orWhere('wo_engineer5','=',$a);
            });
        }
        if ($stype) {
            $a = $stype;
            
            $dataAsset = $dataAsset->whereIn('asset_code', function($query) use ($a)
            {
                $query->select('wo_asset_code')
                        ->from('wo_mstr')
                        ->where('wo_type','=',$a);
            });
			
			$datawo->where('wo_type', '=', $stype);
        }

        if ($stype == "" && $sasset == "" && $sloc == "" && $seng == "") {
            $dataAsset = $dataAsset->where('asset_mstr.id','=',0);
			$datawo->where('asset_mstr.id', '=', 0);
        }

        $dataAsset = $dataAsset->get();
		$datawo = $datawo->get();

        
        $dataeng = DB::table('users')
                ->join('eng_mstr','eng_code','=','username')
                ->whereAccess('Engineer')
                ->orderBy('eng_desc')
                ->get();

        $dataloc = DB::table('asset_loc')
            ->orderBy('asloc_code')
            ->get();

        $dataAsset2 = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        

        $thn = Carbon::now('ASIA/JAKARTA')->addMonth(-11)->toDateTimeString();
        $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

        $period = CarbonPeriod::create($thn, '1 month', $tgl);

        $arraynewdate = [];
        foreach ($period as $dt) {
            array_push($arraynewdate, [$dt->format("Y-m")]);
        }

        return view('report.assetrpt',compact('dataAsset','datawo','arraynewdate','dataeng','dataloc',
            'stype','sasset','sloc','seng','dataAsset2'));
    }

    public function assetrptview(Request $req)
    {
        if ($req->ajax()) {

            $code = $req->code;
			$type = $req->type;

            // Mendapatkan tanggal satu tahun kebelakang dari sekarang
            // Grafik ini hanya menampilkan data transaksi satu tehun kebelakang
            $tahunKebelakang = Carbon::now()->subYear();

            $data = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset_code')
                    ->whereNotIn('wo_status', ['closed','finish','delete'])
                    ->whereWo_asset_code($code)
                    ->where('wo_start_date', '>=', $tahunKebelakang)
                    ->where('wo_start_date', '<=', Carbon::now())
                    ->orderBy('wo_start_date','desc');
					
			if($type) {
				$data->where('wo_type', '=', $type);
			}
			
			$data = $data->get();

            $output = '';
            foreach ($data as $data) {
                // Memisahkan data menjadi array berdasarkan tanda ;
                $array_data = explode(";", $data->wo_list_engineer);

                // Menampilkan setiap elemen array dalam baris terpisah
                $nilaiBaris = "";
                foreach ($array_data as $nilai) {
                    $nilaiBaris  .= $nilai . "<br>";
                }

                $output .= '<tr>'.
                '<td>'.$data->wo_number.'</td>'.
                // '<td>'.$data->wo_asset_code.' - '.$data->asset_desc.'</td>'.
                '<td>'.$nilaiBaris .'</td>'.
                '<td>'.$data->wo_start_date.'</td>'.
                '<td>'.$data->wo_status.'</td>'.
                '</tr>';
            }

            return response($output);
        }
    }

    public function assetgraf(Request $req)
    {
        $thn = Carbon::now('ASIA/JAKARTA')->addMonth(-11)->toDateTimeString();
        $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

        $period = CarbonPeriod::create($thn, '1 month', $tgl);

        $arraynewdate = [];
        $jmlwo = "";
        foreach ($period as $dt) {

            $data = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset_code')
                    ->whereNotIn('wo_status', ['closed','finish','delete'])
                    ->whereWo_asset_code($req->code)
                    ->whereMonth('wo_start_date','=',$dt->format("m"))
                    ->whereYear('wo_start_date','=',$dt->format("Y"));
					
			if($req->type) {
				$data->where('wo_type','=',$req->type);
			}
			
			$data = $data->count();

            if ($jmlwo == "") {
                $jmlwo .= $data;
            } else {
                $jmlwo .= ",".$data;
            }
            
        }

        return response()->json([
                            'success' => 'false',
                            'message'  => $jmlwo,
                        ], 200);
    }

    public function enggraf(Request $req)
    {
        $thn = Carbon::now('ASIA/JAKARTA')->addMonth(-11)->toDateTimeString();
        $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

        $period = CarbonPeriod::create($thn, '1 month', $tgl);

        $engcode = $req->code;
        
        $jmlwo = "";
        $jmlclose = "";
        foreach ($period as $dt) {

            $data = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset_code')
                    // ->whereNotIn('wo_status', ['delete'])
                    ->where('wo_list_engineer','like','%'.$engcode.'%')
                    // ->where(function ($query) use ($engcode) {
                    // $query->where('wo_engineer1', '=', $engcode)
                    //       ->orWhere('wo_engineer2', '=', $engcode)
                    //       ->orWhere('wo_engineer3', '=', $engcode)
                    //       ->orWhere('wo_engineer4', '=', $engcode)
                    //       ->orWhere('wo_engineer5', '=', $engcode);
                    // })
                    ->whereMonth('wo_start_date','=',$dt->format("m"))
                    ->whereYear('wo_start_date','=',$dt->format("Y"))
                    ->count();

            $dataclose = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset_code')
                    ->whereIn('wo_status', ['closed','finish','delete'])
                    ->where('wo_list_engineer','like','%'.$engcode.'%')
                    // ->where(function ($query) use ($engcode) {
                    // $query->where('wo_engineer1', '=', $engcode)
                    //       ->orWhere('wo_engineer2', '=', $engcode)
                    //       ->orWhere('wo_engineer3', '=', $engcode)
                    //       ->orWhere('wo_engineer4', '=', $engcode)
                    //       ->orWhere('wo_engineer5', '=', $engcode);
                    // })
                    ->whereMonth('wo_start_date','=',$dt->format("m"))
                    ->whereYear('wo_start_date','=',$dt->format("Y"))
                    ->count();

            if ($jmlwo == "") {
                $jmlwo .= $data;
            } else {
                $jmlwo .= ",".$data;
            }

            if ($jmlclose == "") {
                $jmlclose .= $dataclose;
            } else {
                $jmlclose .= ",".$dataclose;
            }
            
        }

        return response()->json([
                            'success' => 'false',
                            'message'  => $jmlwo,
                            'close'  => $jmlclose,
                        ], 200);
    }
    
    /* Jadwal preventive asset dengan data PM berlum terbentuk*/
//     public function prevsch(Request $req)
//     {   

//         // dd($req->all());
//         $tgl = '';
//         if (is_null($req->bulan)) {
//             $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
//         } elseif ($req->stat == 'mundur') {
//             $tgl = Carbon::createFromDate($req->bulan)->addYear(-1)->toDateTimeString();
//         } elseif ($req->stat == 'maju') {
//             $tgl = Carbon::createFromDate($req->bulan)->addYear(1)->toDateTimeString();
//         } else {
//             toast('Back to Home!!', 'error');
//             return back();
//         }

//         $bulan = Carbon::createFromDate($tgl)->isoFormat('YYYY');

//         $data = DB::table('asset_mstr')
//         // rumus untuk sch by bulan ->selectRaw('asset_mstr.*, PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal) as harusnya')
//         ->selectRaw('asset_mstr.*, date_format(DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY),"%Y%m") as harusnya')
//         ->where('asset_measure','=','C')
//         ->where('asset_active','=','Yes')
//         // ->where('asset_code','=','01-AT-002')
//         // rumus untuk sch by bulan ->whereRaw('PERIOD_DIFF(PERIOD_ADD(date_format(asset_last_mtc,"%Y%m"),asset_cal), date_format(now(),"%Y%m")) <= - asset_tolerance') // fungsi MYSQL
//         ->whereRaw('DATE_ADD(DATE_ADD(asset_last_mtc,INTERVAL asset_cal DAY), INTERVAL -asset_tolerance DAY) < curdate()')
//         ->orderBy('asset_code')
//         ->paginate(10);
// // dd($data);        
//         Schema::create('temp_asset', function ($table) {
//             $table->increments('id');
//             $table->string('temp_code');
//             $table->string('temp_sch');
//             $table->string('temp_cal');
//             $table->temporary();
//         });

//         foreach($data as $datas) {
//             DB::table('temp_asset')->insert([
//                 'temp_code' => $datas->asset_code,
//                 'temp_sch' => $datas->harusnya,
//                 'temp_cal' => $datas->asset_cal,
//             ]);
//         }
               
//         $datatemp = DB::table('temp_asset')
//             ->get();

//         /* Menyimpan data sementara schedule WO yang selanjutnya */
//         foreach($datatemp as $dt) {
//             $tglharusnya = Carbon::create(substr($dt->temp_sch,0,4), substr($dt->temp_sch,4,2), 1, 0);

//             for($i = 1;$i<=10;$i++)
//             {
//                 DB::table('temp_asset')->insert([
//                     'temp_code' => $dt->temp_code,
//                     'temp_sch' => $tglharusnya->addMonth($dt->temp_cal)->format('Ym'),
//                     'temp_cal' => $dt->temp_cal,
//                 ]);
//             }

//             $tglharusnya = Carbon::create(substr($dt->temp_sch,0,4), substr($dt->temp_sch,4,2), 1, 0);
//             for($i = 1;$i<=10;$i++)
//             {
//                 DB::table('temp_asset')->insert([
//                     'temp_code' => $dt->temp_code,
//                     'temp_sch' => $tglharusnya->subMonth($dt->temp_cal)->format('Ym'),
//                     'temp_cal' => $dt->temp_cal,
//                 ]);
//             } 
//         }

//         $datatemp = DB::table('temp_asset')
//             ->orderBy('temp_code')
//             ->get();
        
//         /* Actual data WO */
//         $datawo = DB::table('wo_mstr')
//             ->where('wo_type','=','auto')
//             ->orderBy('wo_asset')
//             ->orderBy('wo_nbr')
//             ->get();
// // dd($data);
//         Schema::dropIfExists('temp_asset');

//         $dataasset = DB::table('asset_mstr')
//             ->orderBy('asset_code')
//             ->where('asset_measure','=','C')
//             ->where('asset_active','=','Yes')
//             ->get();

//         return view('report.prevsch', ['data' => $data, 'datatemp' => $datatemp, 'datawo' => $datawo, 'bulan' => $bulan,
//             'dataasset' => $dataasset]);
//     }

    /* Kebutuhan sparepart */
    public function needspLama(Request $req)  // 2023.05.20Fungsi yang sudah tidak digunakan karena sudah tidak ada repair atau repar group
    {   
        $swo = $req->s_nomorwo;
        $sasset = $req->s_asset;
        $sper1 = $req->s_per1;
        $sper2 = $req->s_per2;
        $ssp = $req->s_sp;
        $seng = $req->s_eng;
        
        /* Temp table untuk menampun data spare part dari Wo detail, Wo yang belum ada detailnya, Wo yang belum terbentuk */
        Schema::create('temp_wo', function ($table) {
            $table->increments('id');
            $table->string('temp_wo');
            $table->string('temp_asset');
            $table->date('temp_sch_date');
            $table->date('temp_create_date');
            $table->string('temp_status');
            $table->string('temp_sp')->nullable();
            $table->string('temp_sp_desc')->nullable();
            $table->decimal('temp_qty_req',10,2)->nullable();
            $table->decimal('temp_qty_whs',10,2)->nullable();
            $table->decimal('temp_qty_need',10,2)->nullable();
            $table->temporary();
        });

        /* Mencari data sparepart dari wo detail */
        $data = DB::table('wo_dets')
            ->join('wo_mstr','wo_nbr','=','wo_dets_nbr')
            ->whereNotNull('wo_dets_sp')
            ->whereNotIn('wo_status',['closed','delete'])
            ->orderBy('wo_dets_nbr')
            ->get();

        foreach($data as $da){
            DB::table('temp_wo')->insert([
                'temp_wo' => $da->wo_nbr,
                'temp_asset' => $da->wo_asset,
                'temp_create_date' => $da->wo_created_at,
                'temp_sch_date' => $da->wo_schedule,
                'temp_status' => $da->wo_status,
                'temp_sp' => $da->wo_dets_sp,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->wo_dets_sp)->value('spm_desc'),
                'temp_qty_req' => $da->wo_dets_sp_qty,
                'temp_qty_whs' => $da->wo_dets_wh_qty,
                'temp_qty_need' => $da->wo_dets_sp_qty - $da->wo_dets_wh_qty,
            ]);
        }
        // dd($data);
        /* Mencari data sparepart yang belum ada wo detail nya */
        $datawo = DB::table('wo_mstr')->whereNotIn('wo_nbr', function($q){
                $q->select('wo_dets_nbr')->from('wo_dets');
            })
            // ->where('wo_nbr','=','WO-22-0098')
            ->get();

        foreach($datawo as $do) {
            if ($do->wo_repair_code1 != "") {

                $sparepart1 = DB::table('wo_mstr')
                    ->select('wo_nbr','wo_repair_code1 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc',
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status', 'wo_schedule','wo_asset','wo_created_at')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code1', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc1 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code1', 'rep_master.repm_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->get();


                $combineSP = $sparepart1;
                $rc = $rc1;
            }

            if ($do->wo_repair_code2 != "") {
                // dump('repaircode2');
                $sparepart2 = DB::table('wo_mstr')
                    ->select('wo_nbr','wo_repair_code2 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc',
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status', 'wo_schedule','wo_asset','wo_created_at')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code2', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc2 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code2', 'rep_master.repm_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->get();

                // $tempSP2 = (new CreateTempTable())->createSparePartUsed($sparepart2);

                $combineSP = $sparepart1->merge($sparepart2);
                $rc = $rc1->merge($rc2);
            }

            if ($do->wo_repair_code3 != "") {
                // dump('repaircode3');
                $sparepart3 = DB::table('wo_mstr')
                    ->select('wo_nbr','wo_repair_code3 as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc',
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status', 'wo_schedule','wo_asset','wo_created_at')
                    ->leftJoin('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                    ->leftJoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftJoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                $rc3 = DB::table('wo_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->join('rep_master', 'wo_mstr.wo_repair_code3', 'rep_master.repm_code')
                    ->where('wo_id', '=', $do->wo_id)
                    ->get();

                // $tempSP3 = (new CreateTempTable())->createSparePartUsed($sparepart3);

                $combineSP = $sparepart1->merge($sparepart2)->merge($sparepart3);
                $rc = $rc1->merge($rc2)->merge($rc3);
            }

            // dd($rc);

            if ($do->wo_repair_code1 == "" && $do->wo_repair_code2 == "" && $do->wo_repair_code3 == "") {
                // dd('aa');
                $combineSP = DB::table('xxrepgroup_mstr')
                    ->select('wo_nbr','repm_code as repair_code', 'repdet_step', 'ins_code', 'insd_part_desc', 
                    'insd_det.insd_part', 'insd_det.insd_um', 'insd_qty', 'wo_status', 'wo_schedule','wo_asset','wo_created_at')
                    ->leftjoin('rep_master', 'xxrepgroup_mstr.xxrepgroup_rep_code', 'rep_master.repm_code')
                    ->leftjoin('rep_det', 'rep_master.repm_code', 'rep_det.repdet_code')
                    ->leftjoin('ins_mstr', 'rep_det.repdet_ins', 'ins_mstr.ins_code')
                    ->leftJoin('insd_det', 'ins_mstr.ins_code', 'insd_det.insd_code')
                    ->leftJoin('wo_mstr','wo_repair_group','xxrepgroup_mstr.xxrepgroup_nbr')
                    ->where('xxrepgroup_mstr.xxrepgroup_nbr', '=', $do->wo_repair_group)
                    ->where('wo_id', '=', $do->wo_id)
                    ->orderBy('repair_code', 'asc')
                    ->orderBy('repm_ins', 'asc')
                    ->orderBy('repdet_step', 'asc')
                    ->orderBy('ins_code', 'asc')
                    ->get();

                // dd($combineSP);

                $rc = DB::table('xxrepgroup_mstr')
                    ->select('repm_code', 'repm_desc')
                    ->leftjoin('rep_master', 'xxrepgroup_mstr.xxrepgroup_rep_code', 'rep_master.repm_code')
                    ->get();
            }
        }
        // dd($combineSP);
        foreach($combineSP as $dc){
            DB::table('temp_wo')->insert([
                'temp_wo' => $dc->wo_nbr,
                'temp_asset' => $da->wo_asset,
                'temp_create_date' => $da->wo_created_at,
                'temp_sch_date' => $dc->wo_schedule,
                'temp_status' => $dc->wo_status,
                'temp_sp' => $dc->insd_part,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$dc->insd_part)->value('spm_desc'),
                'temp_qty_req' => $dc->insd_qty,
                'temp_qty_whs' => 0,
                'temp_qty_need' => $dc->insd_qty,
            ]);
        }

        $datatemp = DB::table('temp_wo')
            ->whereNotIn('temp_status',['closed','delete'])
            ->orderBy('temp_sch_date')
            ->orderBy('temp_wo');

        if($swo) {
            $datatemp = $datatemp->where('temp_wo','like','%'.$swo.'%');
        }
        if($sasset) {
            $datatemp = $datatemp->where('temp_asset','=',$sasset);
        }
        if($sper1) {
            $datatemp = $datatemp->whereBetween('temp_create_date',[$sper1,$sper2]);
        }
        if($ssp) {
            $datatemp = $datatemp->where('temp_sp',$ssp);
        }
            
        $datatemp = $datatemp->paginate(10);   

        Schema::dropIfExists('temp_wo');

        $dataasset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();


        $datasite = DB::table('site_mstrs')
                        ->where('site_flag','=','yes')
                        ->get();

        $datasp = DB::table('sp_mstr')
            ->orderBy('spm_code')
            ->get();

        return view('report.needsp', ['data' => $datatemp, 'dataasset' => $dataasset, 'datasite' => $datasite,
            'datasp' => $datasp, 'swo' => $swo, 'sasset' => $sasset, 'sper1' => $sper1,
            'sper2' => $sper2, 'ssp' => $ssp]);
    }

    /* Kebutuhan sparepart */
    public function needsp(Request $req)  
    {   
        $swo = $req->s_nomorwo;
        $sasset = $req->s_asset;
        $sper1 = $req->s_per1;
        $sper2 = $req->s_per2;
        $ssp = $req->s_sp;
        $seng = $req->s_eng;
        $ssite = $req->s_site;
        
        /* Temp table untuk menampung data spare part dari Wo detail, Wo yang belum ada detailnya, Wo yang belum terbentuk */
        Schema::create('temp_wo', function ($table) {
            $table->increments('id');
            $table->string('temp_wo');
            $table->string('temp_asset');
            $table->date('temp_sch_date');
            $table->date('temp_create_date');
            $table->string('temp_status');
            $table->string('temp_site')->nullable();
            $table->string('temp_sp')->nullable();
            $table->string('temp_sp_desc')->nullable();
            $table->decimal('temp_qty_req',10,2)->nullable();
            $table->decimal('temp_qty_whs',10,2)->nullable();
            $table->decimal('temp_qty_need',10,2)->nullable();
            $table->temporary();
        });

        /* Mencari data sparepart dari wo yang statusnya bukan close atau delete dan tidak mempunyai data detail sparepart dari tabel wo_dets_sp */
        $data = DB::table('wo_mstr')
            ->whereNotIn('wo_number', function ($query) {
                    $query->select('wd_sp_wonumber')
                        ->from('wo_dets_sp')
                        ->groupby('wd_sp_wonumber');
                })
            ->join('spg_list','spg_code','=','wo_sp_code')
            ->leftJoin('sp_mstr','spm_code','=','spg_spcode')
            ->whereNotIn('wo_status',['closed','delete','canceled'])
            ->orderBy('wo_start_date')
            ->orderBy('wo_number')
            ->get();

        foreach($data as $da){
            DB::table('temp_wo')->insert([
                'temp_wo' => $da->wo_number,
                'temp_asset' => $da->wo_asset_code,
                'temp_create_date' => $da->wo_system_create,
                'temp_sch_date' => $da->wo_start_date,
                'temp_status' => $da->wo_status,
                'temp_site' => $da->spm_site,
                'temp_sp' => $da->spg_spcode,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->spg_spcode)->value('spm_desc'),
                'temp_qty_req' => $da->spg_qtyreq,
                'temp_qty_whs' => 0,
                'temp_qty_need' => $da->spg_qtyreq,
            ]);
        } 
       
        /* Mencari data sparepart yang sudah ada wo detail nya  di tabel wo_dets_sp */
        $data = DB::table('wo_mstr')
            ->join('wo_dets_sp','wd_sp_wonumber','=','wo_number')
            ->leftJoin('sp_mstr','spm_code','=','wd_sp_spcode')
            ->whereNotIn('wo_status',['closed','delete','canceled'])
            ->orderBy('wo_start_date')
            ->orderBy('wo_number')
            ->get();

        foreach($data as $da){
            DB::table('temp_wo')->insert([
                'temp_wo' => $da->wo_number,
                'temp_asset' => $da->wo_asset_code,
                'temp_create_date' => $da->wo_system_create,
                'temp_sch_date' => $da->wo_start_date,
                'temp_status' => $da->wo_status,
                'temp_site' => $da->spm_site,
                'temp_sp' => $da->wd_sp_spcode,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->wd_sp_spcode)->value('spm_desc'),
                'temp_qty_req' => $da->wd_sp_required,
                'temp_qty_whs' => $da->wd_sp_issued,
                'temp_qty_need' => $da->wd_sp_required - $da->wd_sp_issued, 
            ]);
        } 

        /** Mencari data sparepart dari PM Plan (yang belum di confirm) */
        $data = DB::table('pmo_confirm')
            ->leftJoin('pmc_mstr','pmo_pmcode','=','pmc_code')
            ->leftJoin('spg_list','spg_code','=','pmc_spg')
            ->leftJoin('sp_mstr','spm_code','=','spg_spcode')
            // ->wherePmo_sch_date('2023-07-17')
            ->whereNotNull('pmo_pmcode')
            ->get();
// dd($data);
        foreach($data as $da){
            DB::table('temp_wo')->insert([
                'temp_wo' => 'PM Not Confirm',
                'temp_asset' => $da->pmo_asset,
                'temp_create_date' => $da->pmo_sch_date,
                'temp_sch_date' => $da->pmo_sch_date,
                'temp_status' => 'Plan',
                'temp_site' => $da->spm_site,
                'temp_sp' => $da->spg_spcode,
                'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->spg_spcode)->value('spm_desc'),
                'temp_qty_req' => $da->spg_qtyreq,
                'temp_qty_whs' => 0,
                'temp_qty_need' => 0, 
            ]);
        } 

        $datatemp = DB::table('temp_wo')
            ->whereNotIn('temp_status',['closed','delete'])
            ->selectRaw('temp_sch_date,temp_sp,temp_sp_desc,sum(temp_qty_req) as sumreq,temp_site')
            // ->whereTemp_sp('BESI')
            ->whereNotNull('temp_sp')
            ->orderBy('temp_sch_date')
            ->orderBy('temp_site')
            ->orderBy('temp_sp')
            ->groupBy('temp_sch_date','temp_sp');
// dd($datatemp->get());
        if($swo) {
            $datatemp = $datatemp->where('temp_wo','like','%'.$swo.'%');
        }
        if($sasset) {
            $datatemp = $datatemp->where('temp_asset','=',$sasset);
        }
        if($sper1) {
            $datatemp = $datatemp->whereBetween('temp_create_date',[$sper1,$sper2]);
        }
        if($ssp) {
            $datatemp = $datatemp->where('temp_sp',$ssp);
        }
        if($ssite) {
            $datatemp = $datatemp->where('temp_site','=',$ssite);
        }
       
        $datatemp = $datatemp->paginate(10);   

        Schema::dropIfExists('temp_wo');

        $dataasset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        $datasite = DB::table('site_mstrs')
                        ->where('site_flag','=','yes')
                        ->get();

        $datasp = DB::table('sp_mstr')
            ->orderBy('spm_code')
            ->get();

        return view('report.needsp', ['data' => $datatemp, 'dataasset' => $dataasset, 'datasite' => $datasite,
            'datasp' => $datasp, 'swo' => $swo, 'sasset' => $sasset, 'sper1' => $sper1,
            'sper2' => $sper2, 'ssp' => $ssp, 'ssite' => $ssite]);
    }

    public function needspdetail(Request $req) /** Blade : needsp */
    {
        if ($req->ajax()) {

            $code = $req->code;
            $sch = $req->sch;

            /* Temp table untuk menampung data spare part dari Wo detail, Wo yang belum ada detailnya, Wo yang belum terbentuk */
            Schema::create('temp_wo', function ($table) {
                $table->increments('id');
                $table->string('temp_wo');
                $table->string('temp_asset');
                $table->date('temp_sch_date');
                $table->date('temp_create_date');
                $table->string('temp_status');
                $table->string('temp_sp')->nullable();
                $table->string('temp_sp_desc')->nullable();
                $table->decimal('temp_qty_req',10,2)->nullable();
                $table->decimal('temp_qty_whs',10,2)->nullable();
                $table->decimal('temp_qty_need',10,2)->nullable();
                $table->temporary();
            });

            /* Mencari data sparepart dari wo yang statusnya bukan close atau delete dan tidak mempunyai data detail sparepart dari tabel wo_dets_sp */
            $data = DB::table('wo_mstr')
                ->whereNotIn('wo_number', function ($query) use ($code) {
                        $query->select('wd_sp_wonumber')
                            ->from('wo_dets_sp')
                            // ->whereWd_sp_spcode($code) 
                            ->groupby('wd_sp_wonumber');
                    })
                ->join('spg_list','spg_code','=','wo_sp_code')
                ->whereSpg_spcode($code)
                ->whereNotIn('wo_status',['closed','delete','canceled'])
                ->whereWo_start_date($sch)
                ->orderBy('wo_start_date')
                ->orderBy('wo_number')
                ->get();

            foreach($data as $da){
                DB::table('temp_wo')->insert([
                    'temp_wo' => $da->wo_number,
                    'temp_asset' => $da->wo_asset_code,
                    'temp_create_date' => $da->wo_system_create,
                    'temp_sch_date' => $da->wo_start_date,
                    'temp_status' => $da->wo_status,
                    'temp_sp' => $da->spg_spcode,
                    'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->spg_spcode)->value('spm_desc'),
                    'temp_qty_req' => $da->spg_qtyreq,
                    'temp_qty_whs' => 0,
                    'temp_qty_need' => $da->spg_qtyreq,
                ]);
            } 
        
            /* Mencari data sparepart yang sudah ada wo detail nya  di tabel wo_dets_sp */
            $data = DB::table('wo_mstr')
                ->join('wo_dets_sp','wd_sp_wonumber','=','wo_number')
                ->whereNotIn('wo_status',['closed','delete','canceled'])
                ->whereWd_sp_spcode($code)
                ->whereWo_start_date($sch)
                ->orderBy('wo_start_date')
                ->orderBy('wo_number')
                ->get();

            foreach($data as $da){
                DB::table('temp_wo')->insert([
                    'temp_wo' => $da->wo_number,
                    'temp_asset' => $da->wo_asset_code,
                    'temp_create_date' => $da->wo_system_create,
                    'temp_sch_date' => $da->wo_start_date,
                    'temp_status' => $da->wo_status,
                    'temp_sp' => $da->wd_sp_spcode,
                    'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->wd_sp_spcode)->value('spm_desc'),
                    'temp_qty_req' => $da->wd_sp_required,
                    'temp_qty_whs' => $da->wd_sp_issued,
                    'temp_qty_need' => $da->wd_sp_required - $da->wd_sp_issued, 
                ]);
            } 

            /** Mencari data sparepart dari PM Plan (yang belum di confirm) */
            $data = DB::table('pmo_confirm')
                ->leftJoin('pmc_mstr','pmo_pmcode','=','pmc_code')
                ->leftJoin('spg_list','spg_code','=','pmc_spg')
                ->whereSpg_spcode($code)
                ->wherePmo_sch_date($sch)
                ->whereNotNull('pmo_pmcode')
                ->get();
        // dd($data);
            foreach($data as $da){
                DB::table('temp_wo')->insert([
                    'temp_wo' => 'PM Not Confirm',
                    'temp_asset' => $da->pmo_asset,
                    'temp_create_date' => $da->pmo_sch_date,
                    'temp_sch_date' => $da->pmo_sch_date,
                    'temp_status' => 'Plan',
                    'temp_sp' => $da->spg_spcode,
                    'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->spg_spcode)->value('spm_desc'),
                    'temp_qty_req' => $da->spg_qtyreq,
                    'temp_qty_whs' => 0,
                    'temp_qty_need' => 0, 
                ]);
            } 

            $data = Db::table('temp_wo')
                ->get();

            $dataasset = DB::table('asset_mstr')
                ->get();

            $output = '';
            foreach ($data as $data) {

                $assetdesc = $dataasset->where('asset_code','=',$data->temp_asset)->first();

                $output .= '<tr>'.
                '<td>'.$data->temp_wo.'</td>'.
                '<td>'.$data->temp_sch_date.'</td>'.
                '<td>'.$data->temp_asset.' -- '.$assetdesc->asset_desc.'</td>'.
                '<td>'.$data->temp_status.'</td>'.
                '<td>'.$data->temp_qty_req.'</td>'.
                '<td>'.$data->temp_qty_whs.'</td>'.
                '<td>'.$data->temp_qty_need.'</td>'.
                '</tr>';
            }

            Schema::dropIfExists('temp_wo');

            return response($output);
        }
    }
    
    public function generateso(Request $req) /** Blade : needsp */
    {
        if(!$req->site_genso) {
            toast('Site is required!!', 'error')->persistent('Dismiss');
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $sonumber = 'eams' . $req->site_genso;
            $domain = ModelsQxwsa::first();

            $checkso_eams = (new WSAServices())->wsasearchso($domain->wsas_domain,$sonumber);

            if ($checkso_eams === false) {
                toast('WSA Error', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {

                if ($checkso_eams[1] == "false") {
                    toast('WSA Failed', 'error')->persistent('Dismiss');
                    return redirect()->back();
                } else {
                    //dd($req->all());
                    $sper1 = $req->hs_per1;
                    $sper2 = $req->hs_per2;
                    $ssp = $req->hs_sp;
                    $ssite = $req->site_genso;
                    
                    /* Temp table untuk menampung data spare part dari Wo detail, Wo yang belum ada detailnya, Wo yang belum terbentuk */
                    Schema::create('temp_wo', function ($table) {
                        $table->increments('id');
                        $table->string('temp_wo');
                        $table->string('temp_asset');
                        $table->date('temp_sch_date');
                        $table->date('temp_create_date');
                        $table->string('temp_status');
                        $table->string('temp_site')->nullable();
                        $table->string('temp_sp')->nullable();
                        $table->string('temp_sp_desc')->nullable();
                        $table->decimal('temp_qty_req',10,2)->nullable();
                        $table->decimal('temp_qty_whs',10,2)->nullable();
                        $table->decimal('temp_qty_need',10,2)->nullable();
                        $table->temporary();
                    });
            
                    /* Mencari data sparepart dari wo yang statusnya bukan close atau delete dan tidak mempunyai data detail sparepart dari tabel wo_dets_sp */
                    $data = DB::table('wo_mstr')
                        ->whereNotIn('wo_number', function ($query) {
                                $query->select('wd_sp_wonumber')
                                    ->from('wo_dets_sp')
                                    ->groupby('wd_sp_wonumber');
                            })
                        ->join('spg_list','spg_code','=','wo_sp_code')
                        ->leftJoin('sp_mstr','spm_code','=','spg_spcode')
                        ->whereNotIn('wo_status',['closed','delete','canceled'])
                        ->orderBy('wo_start_date')
                        ->orderBy('wo_number')
                        ->get();
            
                    foreach($data as $da){
                        DB::table('temp_wo')->insert([
                            'temp_wo' => $da->wo_number,
                            'temp_asset' => $da->wo_asset_code,
                            'temp_create_date' => $da->wo_system_create,
                            'temp_sch_date' => $da->wo_start_date,
                            'temp_status' => $da->wo_status,
                            'temp_site' => $da->spm_site,
                            'temp_sp' => $da->spg_spcode,
                            'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->spg_spcode)->value('spm_desc'),
                            'temp_qty_req' => $da->spg_qtyreq,
                            'temp_qty_whs' => 0,
                            'temp_qty_need' => $da->spg_qtyreq,
                        ]);
                    } 
                   
                    /* Mencari data sparepart yang sudah ada wo detail nya  di tabel wo_dets_sp */
                    $data = DB::table('wo_mstr')
                        ->join('wo_dets_sp','wd_sp_wonumber','=','wo_number')
                        ->leftJoin('sp_mstr','spm_code','=','wd_sp_spcode')
                        ->whereNotIn('wo_status',['closed','delete','canceled'])
                        ->orderBy('wo_start_date')
                        ->orderBy('wo_number')
                        ->get();
            
                    foreach($data as $da){
                        DB::table('temp_wo')->insert([
                            'temp_wo' => $da->wo_number,
                            'temp_asset' => $da->wo_asset_code,
                            'temp_create_date' => $da->wo_system_create,
                            'temp_sch_date' => $da->wo_start_date,
                            'temp_status' => $da->wo_status,
                            'temp_site' => $da->spm_site,
                            'temp_sp' => $da->wd_sp_spcode,
                            'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->wd_sp_spcode)->value('spm_desc'),
                            'temp_qty_req' => $da->wd_sp_required,
                            'temp_qty_whs' => $da->wd_sp_issued,
                            'temp_qty_need' => $da->wd_sp_required - $da->wd_sp_issued, 
                        ]);
                    } 
            
                    /** Mencari data sparepart dari PM Plan (yang belum di confirm) */
                    $data = DB::table('pmo_confirm')
                        ->leftJoin('pmc_mstr','pmo_pmcode','=','pmc_code')
                        ->leftJoin('spg_list','spg_code','=','pmc_spg')
                        ->leftJoin('sp_mstr','spm_code','=','spg_spcode')
                        // ->wherePmo_sch_date('2023-07-17')
                        ->whereNotNull('pmo_pmcode')
                        ->get();
            // dd($data);
                    foreach($data as $da){
                        DB::table('temp_wo')->insert([
                            'temp_wo' => 'PM Not Confirm',
                            'temp_asset' => $da->pmo_asset,
                            'temp_create_date' => $da->pmo_sch_date,
                            'temp_sch_date' => $da->pmo_sch_date,
                            'temp_status' => 'Plan',
                            'temp_site' => $da->spm_site,
                            'temp_sp' => $da->spg_spcode,
                            'temp_sp_desc' => DB::table('sp_mstr')->where('spm_code','=',$da->spg_spcode)->value('spm_desc'),
                            'temp_qty_req' => $da->spg_qtyreq,
                            'temp_qty_whs' => 0,
                            'temp_qty_need' => 0, 
                        ]);
                    } 
            
                    $datatemp = DB::table('temp_wo')
                        ->whereNotIn('temp_status',['closed','delete'])
                        ->selectRaw('temp_sch_date,temp_sp,temp_sp_desc,sum(temp_qty_req) as sumreq,temp_site')
                        // ->whereTemp_sp('BESI')
                        ->whereNotNull('temp_sp')
                        ->orderBy('temp_sch_date')
                        ->orderBy('temp_site')
                        ->orderBy('temp_sp')
                        ->groupBy('temp_sch_date','temp_sp');
            // dd($datatemp->get());

                    if($sper1) {
                        $datatemp = $datatemp->whereBetween('temp_create_date',[$sper1,$sper2]);
                    }
                    if($ssp) {
                        $datatemp = $datatemp->where('temp_sp',$ssp);

                    }
                    if($ssite) {
                        $datatemp = $datatemp->where('temp_site','=',$ssite);
         
          }

                    $datatemp = $datatemp->get();   

                    $lastschedule = DB::table('temp_wo')
                            ->orderBy('temp_sch_date','desc')
                            ->first();

                    Schema::dropIfExists('temp_wo');


                    foreach ($checkso_eams[0] as $datas) {
                        if ($datas->t_msg == "false") {
                            $qxwsa = ModelsQxwsa::first();

                            // Var Qxtend
                            $qxUrl          = $qxwsa->qx_url; // Edit Here

                            $qxRcv          = $qxwsa->qx_rcv;

                            $timeout        = 0;

                            $domain         = $qxwsa->wsas_domain;

                            $qdocHead = '<soapenv:Envelope xmlns="urn:schemas-qad-com:xml-services"
                                    xmlns:qcom="urn:schemas-qad-com:xml-services:common"
                                    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsa="http://www.w3.org/2005/08/addressing">
                                    <soapenv:Header>
                                        <wsa:Action/>
                                        <wsa:To>urn:services-qad-com:' . $qxRcv . '</wsa:To>
                                        <wsa:MessageID>urn:services-qad-com::' . $qxRcv . '</wsa:MessageID>
                                        <wsa:ReferenceParameters>
                                        <qcom:suppressResponseDetail>true</qcom:suppressResponseDetail>
                                        </wsa:ReferenceParameters>
                                        <wsa:ReplyTo>
                                        <wsa:Address>urn:services-qad-com:</wsa:Address>
                                        </wsa:ReplyTo>
                                    </soapenv:Header>
                                    <soapenv:Body>
                                        <maintainSalesOrder>
                                        <qcom:dsSessionContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>domain</qcom:propertyName>
                                            <qcom:propertyValue>' . $domain . '</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>scopeTransaction</qcom:propertyName>
                                            <qcom:propertyValue>true</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>version</qcom:propertyName>
                                            <qcom:propertyValue>ERP3_2</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>mnemonicsRaw</qcom:propertyName>
                                            <qcom:propertyValue>false</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>username</qcom:propertyName>
                                            <qcom:propertyValue>mfg</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>password</qcom:propertyName>
                                            <qcom:propertyValue></qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>action</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>entity</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>email</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>emailLevel</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                        </qcom:dsSessionContext>
                                        <dsSalesOrder>';

                            $qdocBody = '';

                            $qdocBody .= '<salesOrder>
                                                <operation>A</operation>
                                                <soNbr>'.$sonumber.'</soNbr>
                                                <soCust>'.$req->t_cust.'</soCust>
                                                <soShipvia>FEDX</soShipvia>
                                                <soDueDate>'.$lastschedule->temp_sch_date.'</soDueDate>
                                                <soPo>EAMS</soPo>';

                            $line_nbr = 1;

                            foreach($datatemp as $datas) {
                                if($datas->sumreq > 0){
                                    $qdocBody .= '<salesOrderDetail>
                                                    <operation>A</operation>
                                                    <line>'.$line_nbr.'</line>
                                                    <sodPart>'.$datas->temp_sp.'</sodPart>
                                                    <sodSite>'.$req->site_genso.'</sodSite>
                                                    <sodQtyOrd>'.$datas->sumreq.'</sodQtyOrd>
                                                    <sodSite>'.$req->site_genso.'</sodSite>
                                                    <sodDueDate>'.$datas->temp_sch_date.'</sodDueDate>
                                                </salesOrderDetail>';
                                    $line_nbr++;
                                    // dump($datas->temp_sp);
                                }
                            }

                            $qdocfooter =   '</salesOrder>
                                        </dsSalesOrder>
                                    </maintainSalesOrder>
                                </soapenv:Body>
                            </soapenv:Envelope>';

                            $qdocRequest = $qdocHead . $qdocBody . $qdocfooter;

                            // dd($qdocRequest);

                            $curlOptions = array(
                                CURLOPT_URL => $qxUrl,
                                CURLOPT_CONNECTTIMEOUT => $timeout,        // in seconds, 0 = unlimited / wait indefinitely.
                                CURLOPT_TIMEOUT => $timeout + 120, // The maximum number of seconds to allow cURL functions to execute. must be greater than CURLOPT_CONNECTTIMEOUT
                                CURLOPT_HTTPHEADER => $this->httpHeader($qdocRequest),
                                CURLOPT_POSTFIELDS => preg_replace("/\s+/", " ", $qdocRequest),
                                CURLOPT_POST => true,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_SSL_VERIFYHOST => false
                            );

                            $getInfo = '';
                            $httpCode = 0;
                            $curlErrno = 0;
                            $curlError = '';


                            $qdocResponse = '';

                            $curl = curl_init();
                            if ($curl) {
                                curl_setopt_array($curl, $curlOptions);
                                $qdocResponse = curl_exec($curl);           // sending qdocRequest here, the result is qdocResponse.
                                //
                                $curlErrno = curl_errno($curl);
                                $curlError = curl_error($curl);
                                $first = true;
                                foreach (curl_getinfo($curl) as $key => $value) {
                                    if (gettype($value) != 'array') {
                                        if (!$first) $getInfo .= ", ";
                                        $getInfo = $getInfo . $key . '=>' . $value;
                                        $first = false;
                                        if ($key == 'http_code') $httpCode = $value;
                                    }
                                }
                                curl_close($curl);
                            }

                            // dd($qdocResponse);

                            if (is_bool($qdocResponse)) {

                                DB::rollBack();
                                toast('Something Wrong with Qxtend', 'error');
                                return redirect()->back();
                            }
                            $xmlResp = simplexml_load_string($qdocResponse);
                            $xmlResp->registerXPathNamespace('soapenv', 'urn:schemas-qad-com:xml-services:common');
                            $qdocFault = '';
                            $qdocFault = $xmlResp->xpath('//soapenv:faultstring');
                            // dd($qdocFault);

                            if(!empty($qdocFault)){
                                DB::rollBack();

                                $qdocFault = (string) $xmlResp->xpath('//soapenv:faultstring')[0];

                                alert()->html('<u><b>Error Response Qxtend</b></u>',"<b>Detail Response Qxtend :</b><br>".$qdocFault."",'error')->persistent('Dismiss');
                                return redirect()->back();
                            }

                            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
                            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];

                            

                            if ($qdocResult == "success" or $qdocResult == "warning") {
                                DB::commit();
                                toast('Created SO EAMS Successfully', 'success');
                                return redirect()->back();
                            } else {
                                DB::rollBack();
                                $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                                $outputerror = '';
                                foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                                    $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                                    $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                                    $outputerror .= "&bull;  ".$context . " - " . $desc . "<br>";
                                }

                                // dd('stop');
                                // $qdocMsgDesc = $xmlResp->xpath('//ns3:tt_msg_desc');
                                // $output = '';

                                // foreach($qdocMsgDesc as $datas){
                                // 	if(str_contains($datas, 'ERROR:')){
                                // 		$output .= $datas. ' <br> ';
                                // 	}
                                // }

                                // $output = substr($output, 0, -6);

                                alert()->html('<u><b>Error Response Qxtend</b></u>',"<b>Detail Response Qxtend :</b><br>".$outputerror."",'error')->persistent('Dismiss');
                                return redirect()->back();
                            }
                        } else {

                            $qxwsa = ModelsQxwsa::first();

                            // Var Qxtend
                            $qxUrl          = $qxwsa->qx_url; // Edit Here

                            $qxRcv          = $qxwsa->qx_rcv;

                            $timeout        = 0;

                            $domain         = $qxwsa->wsas_domain;

                            // XML Qextend ** Edit Here

                            // dd($qxRcv);

                            $qdocHead = '<soapenv:Envelope xmlns="urn:schemas-qad-com:xml-services"
                                    xmlns:qcom="urn:schemas-qad-com:xml-services:common"
                                    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsa="http://www.w3.org/2005/08/addressing">
                                    <soapenv:Header>
                                        <wsa:Action/>
                                        <wsa:To>urn:services-qad-com:' . $qxRcv . '</wsa:To>
                                        <wsa:MessageID>urn:services-qad-com::' . $qxRcv . '</wsa:MessageID>
                                        <wsa:ReferenceParameters>
                                        <qcom:suppressResponseDetail>true</qcom:suppressResponseDetail>
                                        </wsa:ReferenceParameters>
                                        <wsa:ReplyTo>
                                        <wsa:Address>urn:services-qad-com:</wsa:Address>
                                        </wsa:ReplyTo>
                                    </soapenv:Header>
                                    <soapenv:Body>
                                        <maintainSalesOrder>
                                        <qcom:dsSessionContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>domain</qcom:propertyName>
                                            <qcom:propertyValue>' . $domain . '</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>scopeTransaction</qcom:propertyName>
                                            <qcom:propertyValue>false</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>version</qcom:propertyName>
                                            <qcom:propertyValue>ERP3_2</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>mnemonicsRaw</qcom:propertyName>
                                            <qcom:propertyValue>false</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>username</qcom:propertyName>
                                            <qcom:propertyValue>mfg</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>password</qcom:propertyName>
                                            <qcom:propertyValue></qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>action</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>entity</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>email</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>emailLevel</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                        </qcom:dsSessionContext>
                                        <dsSalesOrder>';

                            $qdocBody = '';
                            $qdocBody .= '<salesOrder>
                                            <operation>R</operation>
                                            <soNbr>' . $sonumber . '</soNbr>
                                        </salesOrder>';

                            $qdocfooter =   '</dsSalesOrder>
                                            </maintainSalesOrder>
                                        </soapenv:Body>
                                    </soapenv:Envelope>';

                            $qdocRequest = $qdocHead . $qdocBody . $qdocfooter;

                            // dd($qdocRequest);

                            $curlOptions = array(
                                CURLOPT_URL => $qxUrl,
                                CURLOPT_CONNECTTIMEOUT => $timeout,        // in seconds, 0 = unlimited / wait indefinitely.
                                CURLOPT_TIMEOUT => $timeout + 120, // The maximum number of seconds to allow cURL functions to execute. must be greater than CURLOPT_CONNECTTIMEOUT
                                CURLOPT_HTTPHEADER => $this->httpHeader($qdocRequest),
                                CURLOPT_POSTFIELDS => preg_replace("/\s+/", " ", $qdocRequest),
                                CURLOPT_POST => true,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_SSL_VERIFYHOST => false
                            );

                            $getInfo = '';
                            $httpCode = 0;
                            $curlErrno = 0;
                            $curlError = '';


                            $qdocResponse = '';

                            $curl = curl_init();
                            if ($curl) {
                                curl_setopt_array($curl, $curlOptions);
                                $qdocResponse = curl_exec($curl);           // sending qdocRequest here, the result is qdocResponse.
                                //
                                $curlErrno = curl_errno($curl);
                                $curlError = curl_error($curl);
                                $first = true;
                                foreach (curl_getinfo($curl) as $key => $value) {
                                    if (gettype($value) != 'array') {
                                        if (!$first) $getInfo .= ", ";
                                        $getInfo = $getInfo . $key . '=>' . $value;
                                        $first = false;
                                        if ($key == 'http_code') $httpCode = $value;
                                    }
                                }
                                curl_close($curl);
                            }

                            // dd($qdocResponse);

                            if (is_bool($qdocResponse)) {

                                DB::rollBack();
                                toast('Something Wrong with Qxtend', 'error');
                                return redirect()->back();
                            }
                            $xmlResp = simplexml_load_string($qdocResponse);
                            $xmlResp->registerXPathNamespace('soapenv', 'urn:schemas-qad-com:xml-services:common');
                            $qdocFault = '';
                            $qdocFault = $xmlResp->xpath('//soapenv:faultstring');
                            // dd($qdocFault);

                            if(!empty($qdocFault)){
                                DB::rollBack();

                                $qdocFault = (string) $xmlResp->xpath('//soapenv:faultstring')[0];

                                alert()->html('<u><b>Error Response Qxtend</b></u>',"<b>Detail Response Qxtend :</b><br>".$qdocFault."",'error')->persistent('Dismiss');
                                return redirect()->back();
                            }

                            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
                            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];

                            if ($qdocResult == "success" or $qdocResult == "warning") {
                                // DB::commit();
                                // toast('Delete SO EAMS Successfully', 'success');
                                // return redirect()->back();
                            } else {
                                DB::rollBack();
                                $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                                $outputerror = '';
                                foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                                    $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                                    $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                                    $outputerror .= "&bull;  ".$context . " - " . $desc . "<br>";
                                }

                                // dd('stop');
                                // $qdocMsgDesc = $xmlResp->xpath('//ns3:tt_msg_desc');
                                // $output = '';

                                // foreach($qdocMsgDesc as $datas){
                                // 	if(str_contains($datas, 'ERROR:')){
                                // 		$output .= $datas. ' <br> ';
                                // 	}
                                // }

                                // $output = substr($output, 0, -6);

                                alert()->html('<u><b>Error Response Qxtend</b></u>',"<b>Detail Response Qxtend :</b><br>".$outputerror."",'error')->persistent('Dismiss');
                                return redirect()->back();
                            }

                            /* BUAT SO EAMS BARU SETELAH YANG LAMA DIHAPUS */

                            $qdocHead = '<soapenv:Envelope xmlns="urn:schemas-qad-com:xml-services"
                                    xmlns:qcom="urn:schemas-qad-com:xml-services:common"
                                    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsa="http://www.w3.org/2005/08/addressing">
                                    <soapenv:Header>
                                        <wsa:Action/>
                                        <wsa:To>urn:services-qad-com:' . $qxRcv . '</wsa:To>
                                        <wsa:MessageID>urn:services-qad-com::' . $qxRcv . '</wsa:MessageID>
                                        <wsa:ReferenceParameters>
                                        <qcom:suppressResponseDetail>true</qcom:suppressResponseDetail>
                                        </wsa:ReferenceParameters>
                                        <wsa:ReplyTo>
                                        <wsa:Address>urn:services-qad-com:</wsa:Address>
                                        </wsa:ReplyTo>
                                    </soapenv:Header>
                                    <soapenv:Body>
                                        <maintainSalesOrder>
                                        <qcom:dsSessionContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>domain</qcom:propertyName>
                                            <qcom:propertyValue>' . $domain . '</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>scopeTransaction</qcom:propertyName>
                                            <qcom:propertyValue>true</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>version</qcom:propertyName>
                                            <qcom:propertyValue>ERP3_2</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>mnemonicsRaw</qcom:propertyName>
                                            <qcom:propertyValue>false</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>username</qcom:propertyName>
                                            <qcom:propertyValue>mfg</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>password</qcom:propertyName>
                                            <qcom:propertyValue></qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>action</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>entity</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>email</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>emailLevel</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                        </qcom:dsSessionContext>
                                        <dsSalesOrder>';

                            $qdocBody = '';

                            $qdocBody .= '<salesOrder>
                                                <operation>A</operation>
                                                <soNbr>'.$sonumber.'</soNbr>
                                                <soCust>'.$req->t_cust.'</soCust>
                                                <soShipvia>FEDX</soShipvia>
                                                <soDueDate>'.$lastschedule->temp_sch_date.'</soDueDate>
                                                <soPo>EAMS</soPo>';

                            $line_nbr = 1;

                            foreach($datatemp as $datas) {
                                if($datas->sumreq > 0){
                                    $qdocBody .= '<salesOrderDetail>
                                                    <operation>A</operation>
                                                    <line>'.$line_nbr.'</line>
                                                    <sodPart>'.$datas->temp_sp.'</sodPart>
                                                    <sodSite>'.$req->site_genso.'</sodSite>
                                                    <sodQtyOrd>'.$datas->sumreq.'</sodQtyOrd>
                                                    <sodSite>'.$req->site_genso.'</sodSite>
                                                    <sodDueDate>'.$datas->temp_sch_date.'</sodDueDate>
                                                </salesOrderDetail>';
                                    $line_nbr++;
                                }
                            }

                            $qdocfooter =   '</salesOrder>
                                        </dsSalesOrder>
                                    </maintainSalesOrder>
                                </soapenv:Body>
                            </soapenv:Envelope>';

                            $qdocRequest = $qdocHead . $qdocBody . $qdocfooter;

                            // dd($qdocRequest);

                            $curlOptions = array(
                                CURLOPT_URL => $qxUrl,
                                CURLOPT_CONNECTTIMEOUT => $timeout,        // in seconds, 0 = unlimited / wait indefinitely.
                                CURLOPT_TIMEOUT => $timeout + 120, // The maximum number of seconds to allow cURL functions to execute. must be greater than CURLOPT_CONNECTTIMEOUT
                                CURLOPT_HTTPHEADER => $this->httpHeader($qdocRequest),
                                CURLOPT_POSTFIELDS => preg_replace("/\s+/", " ", $qdocRequest),
                                CURLOPT_POST => true,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_SSL_VERIFYHOST => false
                            );

                            $getInfo = '';
                            $httpCode = 0;
                            $curlErrno = 0;
                            $curlError = '';


                            $qdocResponse = '';

                            $curl = curl_init();
                            if ($curl) {
                                curl_setopt_array($curl, $curlOptions);
                                $qdocResponse = curl_exec($curl);           // sending qdocRequest here, the result is qdocResponse.
                                //
                                $curlErrno = curl_errno($curl);
                                $curlError = curl_error($curl);
                                $first = true;
                                foreach (curl_getinfo($curl) as $key => $value) {
                                    if (gettype($value) != 'array') {
                                        if (!$first) $getInfo .= ", ";
                                        $getInfo = $getInfo . $key . '=>' . $value;
                                        $first = false;
                                        if ($key == 'http_code') $httpCode = $value;
                                    }
                                }
                                curl_close($curl);
                            }

                            // dd($qdocResponse);

                            if (is_bool($qdocResponse)) {

                                DB::rollBack();
                                toast('Something Wrong with Qxtend', 'error');
                                return redirect()->back();
                            }
                            $xmlResp = simplexml_load_string($qdocResponse);
                            $xmlResp->registerXPathNamespace('soapenv', 'urn:schemas-qad-com:xml-services:common');
                            $qdocFault = '';
                            $qdocFault = $xmlResp->xpath('//soapenv:faultstring');
                            // dd($qdocFault);

                            if(!empty($qdocFault)){
                                DB::rollBack();

                                $qdocFault = (string) $xmlResp->xpath('//soapenv:faultstring')[0];

                                alert()->html('<u><b>Error Response Qxtend</b></u>',"<b>Detail Response Qxtend :</b><br>".$qdocFault."",'error')->persistent('Dismiss');
                                return redirect()->back();
                            }

                            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
                            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



                            if ($qdocResult == "success" or $qdocResult == "warning") {
                                // DB::commit();
                                // toast('Delete SO EAMS Successfully', 'success');
                                // return redirect()->back();
                            } else {
                                DB::rollBack();
                                $xmlResp->registerXPathNamespace('ns3', 'urn:schemas-qad-com:xml-services:common');
                                $outputerror = '';
                                foreach ($xmlResp->xpath('//ns3:temp_err_msg') as $temp_err_msg) {
                                    $context = $temp_err_msg->xpath('./ns3:tt_msg_context')[0];
                                    $desc = $temp_err_msg->xpath('./ns3:tt_msg_desc')[0];
                                    $outputerror .= "&bull;  ".$context . " - " . $desc . "<br>";
                                }

                                // dd('stop');
                                // $qdocMsgDesc = $xmlResp->xpath('//ns3:tt_msg_desc');
                                // $output = '';

                                // foreach($qdocMsgDesc as $datas){
                                // 	if(str_contains($datas, 'ERROR:')){
                                // 		$output .= $datas. ' <br> ';
                                // 	}
                                // }

                                // $output = substr($output, 0, -6);

                                alert()->html('<u><b>Error Response Qxtend</b></u>',"<b>Detail Response Qxtend :</b><br>".$outputerror."",'error')->persistent('Dismiss');
                                return redirect()->back();
                            }
                            DB::commit();
                            toast('SO EAMS Successfully Created', 'Success');
                            return redirect()->back();
                        }
                    }
                }
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Transaction Error', 'error');
            return redirect()->back();
        }
    }

}
