<?php

namespace App\Http\Controllers;

use App\Charts\UserChart;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class UserChartController extends Controller
{
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

        $skrg = Carbon::now('ASIA/JAKARTA')->toDateString();

        $totals = DB::table('wo_mstr')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when DATEDIFF('".$skrg."',wo_created_at) <= 3 then 1 end) as a")
            ->selectRaw("count(case when DATEDIFF('".$skrg."',wo_created_at) > 3 and DATEDIFF('".$skrg."',wo_created_at) <= 3 then 1 end) as b")
            ->selectRaw("count(case when DATEDIFF('".$skrg."',wo_created_at) > 5 then 1 end) as c")
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
            ->selectRaw("count(case when DATEDIFF('".$skrg."',sr_created_at) <= 3 then 1 end) as a")
            ->selectRaw("count(case when DATEDIFF('".$skrg."',sr_created_at) > 3 and DATEDIFF('".$skrg."',sr_created_at) <= 3 then 1 end) as b")
            ->selectRaw("count(case when DATEDIFF('".$skrg."',sr_created_at) > 5 then 1 end) as c")
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
        $wotype  = $req->input('wotype');
       
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
                ->orderBy('eng_desc')
                ->get();

        $kondisi = "";
        switch ($wotype) {
          case "All":
            $kondisi = "wo_type <> 'All'";
            break;
          case "PM":
            $kondisi = "wo_type = 'auto'";
            break;
          case "WO":
            $kondisi = "wo_type = 'other'";
            break;
          default:
            $kondisi = "wo_type <> 'All'";
            $wotype = "All";
        }

        if (!isset($engcode)){
            $datawo = DB::table('wo_mstr')
                ->select('wo_nbr','wo_status','wo_schedule','wo_engineer1', 'wo_engineer2', 'wo_engineer3', 'wo_engineer4',
                    'wo_engineer5','wo_asset','asset_desc','wo_sr_nbr','wo_duedate','wo_failure_code1','wo_failure_code2',
                    'wo_failure_code3','wo_creator','wo_note','wo_start_date','wo_finish_date','wo_type')
                //->selectRaw('DAY(wo_schedule) as tgl')
                ->selectRaw("(case when wo_status in ('open','plan','started') then day(wo_schedule) else day(wo_finish_date) end) as tgl")
                ->join('asset_mstr','asset_code','=','wo_asset')
                ->where(function ($query) use ($tgl) {
                    $query->where('wo_schedule','like',date("Y-m",strtotime($tgl)).'%')
                        ->orwhere('wo_finish_date','like',date("Y-m",strtotime($tgl)).'%');
                })
                ->whereRaw($kondisi)
                // ->whereIn('wo_status',['open','plan','started'])
                ->orderBy('tgl')
                ->orderBy('wo_nbr')
                ->get();

            $fotoeng = $dataeng->where('eng_code','=',"")->first();
        }
        else
        {
            //dd(date("Y-m",strtotime($tgl)));
            $datawo = DB::table('wo_mstr')
                ->select('wo_nbr','wo_status','wo_schedule','wo_engineer1', 'wo_engineer2', 'wo_engineer3', 'wo_engineer4',
                    'wo_engineer5','wo_asset','asset_desc','wo_sr_nbr','wo_duedate','wo_failure_code1','wo_failure_code2',
                    'wo_failure_code3','wo_creator','wo_note','wo_start_date','wo_finish_date','wo_type')
                //->selectRaw('DAY(wo_schedule) as tgl')
                ->selectRaw("(case when wo_status in ('open','plan','started') then day(wo_schedule) else day(wo_finish_date) end) as tgl")
                ->join('asset_mstr','asset_code','=','wo_asset')
                ->whereRaw($kondisi)
                ->where(function ($query) use ($engcode) {
                    $query->where('wo_engineer1', '=', $engcode)
                          ->orWhere('wo_engineer2', '=', $engcode)
                          ->orWhere('wo_engineer3', '=', $engcode)
                          ->orWhere('wo_engineer4', '=', $engcode)
                          ->orWhere('wo_engineer5', '=', $engcode);
                })
                ->where(function ($query) use ($tgl) {
                    $query->where('wo_schedule','like',date("Y-m",strtotime($tgl)).'%')
                        ->orwhere('wo_finish_date','like',date("Y-m",strtotime($tgl)).'%');
                })
                // ->whereIn('wo_status',['open','plan','started'])
                ->orderBy('tgl')
                ->orderBy('wo_nbr')
                ->get();
          
           $fotoeng = $dataeng->where('eng_code','=',$engcode)->first();
        }
        //dd(count($datawo));
        $datafn = DB::table('fn_mstr')
                ->get();

        return view('report.engsch',compact('skrg','hari','kosong','bulan','datawo','dataeng','fotoeng','engcode','datafn','wotype'));
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

    public function assetsch(Request $req)
    {
        
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
        //dd($req->all(),$tgl);

        $code = $req->input('t_asset');
       
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

        if (!isset($code)){

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
                // ->whereIn('wo_status',['open','plan','started'])
                ->get();

            $foto = $dataAsset->where('asset_code','=',"")->first();
        }
        else
        {
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
                ->where('wo_asset',$code)
                // ->whereIn('wo_status',['open','plan','started'])
                ->orderBy('tgl')
                ->orderBy('wo_nbr')
                ->get();
           
           $foto = $dataAsset->where('asset_code','=',$code)->first();
        }

        $datafn = DB::table('fn_mstr')
                ->get();

        return view('report.assetsch',compact('skrg','hari','kosong','bulan','datawo','dataAsset','foto','datafn'));
    }

    public function engrpt(Request $req)
    {
       
        $dataeng = DB::table('users')
                ->join('eng_mstr','eng_code','=','username')
                ->whereAccess('Engineer')
                ->whereActive('Yes')
                ->orderBy('eng_desc')
                ->get();
//dd($dataeng);
        $datawo = DB::table('wo_mstr')
                ->join('asset_mstr','asset_code','=','wo_asset')
                ->whereNotIn('wo_status', ['closed','finish','delete'])
                ->orderBy('wo_schedule')
                ->get();

        $thn = Carbon::now('ASIA/JAKARTA')->addMonth(-11)->toDateTimeString();
        $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

        $period = CarbonPeriod::create($thn, '1 month', $tgl);

        $arraynewdate = [];
        foreach ($period as $dt) {
            array_push($arraynewdate, [$dt->format("Y-m")]);
        }

        return view('report.engrpt',compact('dataeng','datawo','arraynewdate'));
    }

    public function engrptview(Request $req)
    {
        if ($req->ajax()) {

            $engcode = $req->code;

            $data = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset')
                    // ->whereNotIn('wo_status', ['closed','finish','delete'])
                    ->where(function ($query) use ($engcode) {
                    $query->where('wo_engineer1', '=', $engcode)
                          ->orWhere('wo_engineer2', '=', $engcode)
                          ->orWhere('wo_engineer3', '=', $engcode)
                          ->orWhere('wo_engineer4', '=', $engcode)
                          ->orWhere('wo_engineer5', '=', $engcode);
                    })
                    ->orderBy('wo_schedule')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $eng = $data->wo_engineer1;
                if(!is_null($data->wo_engineer2)) {
                    $eng .= ", ".$data->wo_engineer2;
                }
                if(!is_null($data->wo_engineer3)) {
                    $eng .= ", ".$data->wo_engineer3;
                }
                if(!is_null($data->wo_engineer4)) {
                    $eng .= ", ".$data->wo_engineer4;
                }
                if(!is_null($data->wo_engineer5)) {
                    $eng .= ", ".$data->wo_engineer5;
                }


                $output .= '<tr>'.
                '<td>'.$data->wo_nbr.'</td>'.
                '<td>'.$data->wo_asset.' - '.$data->asset_desc.'</td>'.
                '<td>'.$eng.'</td>'.
                '<td>'.$data->wo_schedule.'</td>'.
                '<td>'.$data->wo_finish_date.'</td>'.
                '<td>'.$data->wo_status.'</td>'.
                '</tr>';
            }

            return response($output);
        }
    }

    public function assetrpt(Request $req)
    {
       
        $dataAsset = DB::table('asset_mstr')
                    ->orderBy('asset_code')
                    ->get();

        $datawo = DB::table('wo_mstr')
                ->join('asset_mstr','asset_code','=','wo_asset')
                ->whereNotIn('wo_status', ['closed','finish','delete'])
                ->orderBy('wo_schedule')
                ->get();

        $thn = Carbon::now('ASIA/JAKARTA')->addMonth(-11)->toDateTimeString();
        $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

        $period = CarbonPeriod::create($thn, '1 month', $tgl);

        $arraynewdate = [];
        foreach ($period as $dt) {
            array_push($arraynewdate, [$dt->format("Y-m")]);
        }

        return view('report.assetrpt',compact('dataAsset','datawo','arraynewdate'));
    }

    public function assetrptview(Request $req)
    {
        if ($req->ajax()) {

            $code = $req->code;

            $data = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset')
                    ->whereNotIn('wo_status', ['closed','finish','delete'])
                    ->whereWo_asset($code)
                    ->orderBy('wo_schedule')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $output .= '<tr>'.
                '<td>'.$data->wo_nbr.'</td>'.
                '<td>'.$data->wo_asset.' - '.$data->asset_desc.'</td>'.
                '<td>'.$data->wo_engineer1.'</td>'.
                '<td>'.$data->wo_schedule.'</td>'.
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
                    ->join('asset_mstr','asset_code','=','wo_asset')
                    ->whereNotIn('wo_status', ['closed','finish','delete'])
                    ->whereWo_asset($req->code)
                    ->whereMonth('wo_schedule','=',$dt->format("m"))
                    ->whereYear('wo_schedule','=',$dt->format("Y"))
                    ->count();

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
                    ->join('asset_mstr','asset_code','=','wo_asset')
                    ->whereNotIn('wo_status', ['delete'])
                    ->where(function ($query) use ($engcode) {
                    $query->where('wo_engineer1', '=', $engcode)
                          ->orWhere('wo_engineer2', '=', $engcode)
                          ->orWhere('wo_engineer3', '=', $engcode)
                          ->orWhere('wo_engineer4', '=', $engcode)
                          ->orWhere('wo_engineer5', '=', $engcode);
                    })
                    ->whereMonth('wo_schedule','=',$dt->format("m"))
                    ->whereYear('wo_schedule','=',$dt->format("Y"))
                    ->count();

            $dataclose = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_code','=','wo_asset')
                    ->where(function ($query) use ($engcode) {
                    $query->where('wo_engineer1', '=', $engcode)
                          ->orWhere('wo_engineer2', '=', $engcode)
                          ->orWhere('wo_engineer3', '=', $engcode)
                          ->orWhere('wo_engineer4', '=', $engcode)
                          ->orWhere('wo_engineer5', '=', $engcode);
                    })
                    ->whereMonth('wo_finish_date','=',$dt->format("m"))
                    ->whereYear('wo_finish_date','=',$dt->format("Y"))
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
    
}