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

        $tglnow = Carbon::now('ASIA/JAKARTA')->toDateTimeString();

        // 10.08.21 update status booking yang sudah lewat
        $databook = DB::table("booking")
                    ->where("book_end","<",Carbon::now()->toDateTimeString())
                    ->get();

        DB::table('booking')
            ->where("book_end","<",Carbon::now()->toDateTimeString())
            ->whereBook_status("Open")
            ->update([
                'book_status' => "Closed",
            ]);
        //////////////////////////////////////////////////////    

        $totsr = DB::table('service_req_mstr')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when DATEDIFF(day,sr_created_at, '$tglnow') <= 3 then 1 end) as a")
            ->selectRaw("count(case when DATEDIFF(day,sr_created_at, '$tglnow') > 3 and DATEDIFF(day,sr_created_at, '$tglnow') <= 7 then 1 end) as b")
            ->selectRaw("count(case when DATEDIFF(day,sr_created_at, '$tglnow') > 7 and DATEDIFF(day,sr_created_at, '$tglnow') <= 14 then 1 end) as c")
            ->selectRaw("count(case when DATEDIFF(day,sr_created_at, '$tglnow') > 14 then 1 end) as d")
            ->first();
            
             $totwo = DB::table('wo_mstr')->where('wo_status', 'open')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when DATEDIFF(day,wo_created_at,'$tglnow') <= 3 then 1 end) as a1")
            ->selectRaw("count(case when DATEDIFF(day,wo_created_at,'$tglnow') > 3 and DATEDIFF(day,wo_created_at,'$tglnow') <= 7 then 1 end) as b1")
            ->selectRaw("count(case when DATEDIFF(day,wo_created_at, '$tglnow') > 7 and DATEDIFF(day,wo_created_at, '$tglnow') <= 14 then 1 end) as c1")
            ->selectRaw("count(case when DATEDIFF(day,wo_created_at,'$tglnow') > 14 then 1 end) as d1")
            ->first();

          $invbr1 = DB::table('wo_mstr')->where('wo_status', 'open')->count();
          $invbr2 = DB::table('wo_mstr')->where('wo_status', 'plan')->count();
          $invbr3 = DB::table('wo_mstr')->where('wo_status', 'started')->count();
          $invbr4 = DB::table('wo_mstr')->where('wo_status', 'waiting')->count();
          $invbr5 = DB::table('wo_mstr')->where('wo_status', 'close')->count();
          
          
          
   
          
        $invdx1 = $totsr->a;
        $invdx2 = $totsr->b;
        $invdx3 = $totsr->c;
        $invdx4 = $totsr->d;
        
        $invwo1 = $totwo->a1;
        $invwo2 = $totwo->b1;
        $invwo3 = $totwo->c1;
        $invwo4 = $totwo->d1;
       
        $skrg = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        $lalu = Carbon::now('ASIA/JAKARTA')->addYear(-1)->toDateTimeString();

        $topprob = DB::table('wo_mstr')
                    ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                    ->whereBetween('wo_created_at',[$lalu,$skrg])
                    ->groupby('wo_asset')
                    ->orderby('jmlasset','desc')
                    ->limit(10)
                    ->get();
        /* 2022.11..18 diganti untuk top 10 masalah BREAKDOWN
        $topheal = DB::table('wo_mstr')
                    ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                    ->whereBetween('wo_created_at',[$lalu,$skrg])
                    ->groupby('wo_asset')
                    ->orderby('jmlasset','asc')
                    ->limit(10)
                    ->get(); */

        $topheal = DB::table('wo_mstr')
                    ->select(DB::raw('count(*) as jmlasset, wo_asset'))
                    ->whereBetween('wo_created_at',[$lalu,$skrg])
                    ->where('wo_new_type','=','BRE')
                    ->groupby('wo_asset')
                    ->orderby('jmlasset','asc')
                    ->orderBy('wo_asset')
                    ->limit(10)
                    ->get();
            
        $dataasset = DB::table('asset_mstr')
                    ->get();
        $countwosr= DB::table('wo_mstr')
                ->selectRaw('count(wo_nbr) as countwosr')
                ->where('wo_sr_nbr','!=',null)
                ->first();
        $countwoauto = DB::table('wo_mstr')
                ->selectRaw('count(wo_nbr) as countwoauto')
                ->where('wo_sr_nbr','=',null)
                ->where('wo_nbr','like','WT%')
                ->first();
        $countwodirect = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countdirect')
                    ->where('wo_sr_nbr','=',null)
                    ->where('wo_nbr','like','WD%')
                    ->first();
        $countwoother = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countother')
                    ->where('wo_sr_nbr','=',null)
                    ->where('wo_nbr','like','WO%')
                    ->first();
        $opensr = DB::table('service_req_mstr')
        			->where('sr_status','=',1)
        			->count();
        $engineer = DB::table('eng_mstr')
                    ->get();

        $arrayname = [];
        $arrayval = [];

        foreach ($engineer as $engineernew){
            $var1 = DB::table('wo_mstr')
                    ->selectRaw('count(wo_engineer1) as wo_engineer1val')
                    ->where('wo_engineer1','=',$engineernew->eng_code)
                    ->first();
                    $var2 = DB::table('wo_mstr')
                    ->selectRaw('count(wo_engineer2) as wo_engineer2val')
                    ->where('wo_engineer2','=',$engineernew->eng_code)
                    ->first();
                    $var3 = DB::table('wo_mstr')
                    ->selectRaw('count(wo_engineer3) as wo_engineer3val')
                    ->where('wo_engineer3','=',$engineernew->eng_code)
                    ->first();
                    $var4 = DB::table('wo_mstr')
                    ->selectRaw('count(wo_engineer4) as wo_engineer4val')
                    ->where('wo_engineer4','=',$engineernew->eng_code)
                    ->first();
                    $var5 = DB::table('wo_mstr')
                    ->selectRaw('count(wo_engineer5) as wo_engineer5val')
                    ->where('wo_engineer5','=',$engineernew->eng_code)
                    ->first();
        $sum = $var1->wo_engineer1val + $var2->wo_engineer2val + $var3->wo_engineer3val + $var4->wo_engineer4val + $var5->wo_engineer5val;
        $arrayname[$engineernew->eng_desc.' ('.$engineernew->eng_code.')'] = $sum;
        
        // array_push($arrayval,$sum);
        }
        // dd($arrayval);
        arsort($arrayname);
        

        // 10.08.21 grafwo
        if (is_null($req->bulan)) {
            $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        } elseif ($req->stat == 'mundur') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(-1)->toDateTimeString();
        } elseif ($req->stat == 'maju') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(1)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }

        $bulan = Carbon::createFromDate($tgl)->isoFormat('MMMM YYYY');

        $countwomonth = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwomonth')
                    ->whereMonth('wo_created_at','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_created_at','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwoopen = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwoopen')
                    ->whereWo_status("open")
                    ->whereMonth('wo_created_at','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_created_at','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwostart = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwostart')
                    ->whereWo_status("started")
                    ->whereMonth('wo_start_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_start_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwofinish = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwofinish')
                    ->whereWo_status("finish")
                    ->whereMonth('wo_finish_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_finish_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwocomplete = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwocomplete')
                    ->whereWo_status("Completed")
                    ->whereMonth('wo_finish_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_finish_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwoclosed = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwoclosed')
                    ->whereWo_status("closed")
                    ->whereMonth('wo_finish_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_finish_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwopmmonth = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmmonth')
                    ->whereMonth('wo_created_at','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_created_at','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();

        $countwopmopen = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmopen')
                    ->whereWo_status("open")
                    ->whereMonth('wo_created_at','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_created_at','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();

        $countwopmstart = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmstart')
                    ->whereWo_status("started")
                    ->whereMonth('wo_start_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_start_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();

        $countwopmfinish = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmfinish')
                    ->whereWo_status("finish")
                    ->whereMonth('wo_finish_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_finish_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();

        $countwopmcomplete = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmcomplete')
                    ->whereWo_status("Completed")
                    ->whereMonth('wo_finish_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_finish_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();

        $countwopmclosed = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmclosed')
                    ->whereWo_status("closed")
                    ->whereMonth('wo_finish_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_finish_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();    

        /* grafytdwo */
        $now = Carbon::now();
        $ytdwo = [];
        for ($i=1; $i < 13; $i++) { 
            $grafytdwo = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwo')
                    ->whereMonth('wo_created_at','=',$i)
                    ->whereYear('wo_created_at','=',$now->year)
                    ->where("wo_type","<>","auto")
                    ->first();

            $ytdwo[$i] = $grafytdwo->countwo;
        }
        $ytdwopm = [];
        for ($i=1; $i < 13; $i++) { 
            $grafytdwopm = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwo')
                    ->whereMonth('wo_created_at','=',$i)
                    ->whereYear('wo_created_at','=',$now->year)
                    ->where("wo_type","=","auto")
                    ->first();

            $ytdwopm[$i] = $grafytdwopm->countwo;
        }

        /* grafhourwo */
        $now = Carbon::now();
        $hourwo = [];
        for ($i=1; $i < 13; $i++) { 
            $grafhourwo = DB::table('wo_mstr')
                    ->join('wo_dets','wo_dets_nbr','=','wo_nbr')
                    ->selectRaw('count(wo_dets_rep_hour) as counthour')
                    ->whereMonth('wo_finish_date','=',$i)
                    ->whereYear('wo_finish_date','=',$now->year)
                    ->where('wo_type','<>','auto')
                    ->first();

            $hourwo[$i] = $grafhourwo->counthour;
        }

        $hourpm = [];
        for ($i=1; $i < 13; $i++) { 
            $grafhourpm = DB::table('wo_mstr')
                    ->join('wo_dets','wo_dets_nbr','=','wo_nbr')
                    ->selectRaw('count(wo_dets_rep_hour) as counthour')
                    ->whereMonth('wo_finish_date','=',$i)
                    ->whereYear('wo_finish_date','=',$now->year)
                    ->where('wo_type','=','auto')
                    ->first();

            $hourpm[$i] = $grafhourpm->counthour;
        }

        /**  2023.10.12 Untuk menampilkan jumlah seluruh status WO yang terbentuk */
        $countstatus = DB::table('wo_mstr')
            ->select('wo_status', DB::raw('count(wo_status) as jmlstatus'))
            ->groupBy('wo_status')
            ->orderBy('wo_status')
            ->get();

        return view("home", compact('arrayname','countwosr','countwoauto','countwodirect','countwoother','topheal','users',
            'invdx2','invdx1','invdx3','invdx4', 'invbr1','invbr2','invbr3','invbr4','invbr5','invwo1','invwo2','invwo3','invwo4','topprob','dataasset','opensr',
            "countwomonth","countwoopen","countwostart","countwofinish","countwocomplete","countwoclosed",
            "bulan","ytdwo","hourwo","hourpm",
            "countwopmmonth","countwopmopen","countwopmstart","countwopmfinish","countwopmcomplete","countwopmclosed",
            "ytdwopm", "countstatus"));   
    }

    public function grafmajumundur(Request $req){
        //dd($req->all());
        $tgl = '';
        if (is_null($req->bulan)) {
            $tgl = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
        } elseif ($req->stat == 'mundur') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(-1)->toDateTimeString();
        } elseif ($req->stat == 'maju') {
            $tgl = Carbon::createFromDate($req->bulan)->addMonth(1)->toDateTimeString();
        } else {
            toast('Back to Home!!', 'error');
            return back();
        }

        $bulan = Carbon::createFromDate($tgl)->isoFormat('MMMM YYYY');
        
        $countwomonth = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwomonth')
                    ->whereMonth('wo_created_at','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_created_at','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwoopen = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwoopen')
                    ->whereWo_status("open")
                    ->whereMonth('wo_created_at','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_created_at','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwostart = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwostart')
                    ->whereWo_status("started")
                    ->whereMonth('wo_start_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_start_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first();

        $countwofinish = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwofinish')
                    ->whereMonth('wo_finish_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_finish_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","<>","auto")
                    ->first(); 

        $countwopmmonth = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmmonth')
                    ->whereMonth('wo_created_at','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_created_at','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();

        $countwopmopen = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmopen')
                    ->whereWo_status("open")
                    ->whereMonth('wo_created_at','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_created_at','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();

        $countwopmstart = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmstart')
                    ->whereWo_status("started")
                    ->whereMonth('wo_start_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_start_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first();

        $countwopmfinish = DB::table('wo_mstr')
                    ->selectRaw('count(wo_nbr) as countwopmfinish')
                    ->whereMonth('wo_finish_date','=',date("m",strtotime($tgl)))
                    ->whereYear('wo_finish_date','=',date("Y",strtotime($tgl)))
                    ->where("wo_type","=","auto")
                    ->first(); 

        $arr = [$countwomonth,$countwoopen,$countwostart,$countwofinish,$countwopmmonth,$countwopmopen,$countwopmstart,$countwopmfinish,$bulan];
        // dd($arr);
        return $arr;     
    }
}
