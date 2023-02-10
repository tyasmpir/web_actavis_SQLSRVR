<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App;
use App\Exports\donlodwograf;
use Maatwebsite\Excel\Facades\Excel;

class dashController extends Controller
{
    public function openwo()
    {
	  $data = DB::table('wo_mstr')->where('wo_status', 'open')	
               ->join('asset_mstr', 'wo_mstr.wo_asset', '=', 'asset_mstr.asset_code')       
					->get();								
       return view('/dash/openwo',['openwo'=>$data]);    
    }
    
     public function startwo()
    {
	  $data = DB::table('wo_mstr')->where('wo_status', 'started')
          ->join('asset_mstr', 'wo_mstr.wo_asset', '=', 'asset_mstr.asset_code')       
		->get();								
       return view('/dash/startwo',['openwo'=>$data]);    
    }
	
       public function planwo()
    {
	  $data = DB::table('wo_mstr')->where('wo_status', 'plan')
          ->join('asset_mstr', 'wo_mstr.wo_asset', '=', 'asset_mstr.asset_code')       
		->get();								
       return view('/dash/planwo',['openwo'=>$data]);    
    }
    
     public function finishwo()
    {
	  $data = DB::table('wo_mstr')->where('wo_status', 'finish')
          ->join('asset_mstr', 'wo_mstr.wo_asset', '=', 'asset_mstr.asset_code')       
		->get();								
       return view('/dash/finishwo',['openwo'=>$data]);    
    }
    
         public function closewo()
    {
	  $data = DB::table('wo_mstr')->where('wo_status', 'closed')
            ->join('asset_mstr', 'wo_mstr.wo_asset', '=', 'asset_mstr.asset_code')       
		      ->get();								
       return view('/dash/closewo',['openwo'=>$data]);    
    }
    
    public function problemwo(Request $req,$asset){
      //  dd(strpos($asset,'('));
      $assetcode = substr($asset,0,strpos($asset,'('));
      $type = substr($asset,strpos($asset,'(')+1);
      $typelen = strlen($type);
      $type = substr($type,0,$typelen -1);
      // dd($type);
      $usernow = DB::table('users')
                  ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                  // ->select('approver')
                  ->where('username','=',session()->get('username'))
                  ->get();

      $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               // ->selectRaw('min(wo_id) as wo_id,wo_nbr as wo_nbr,min(asset_desc) as asset_desc,min(wo_schedule) as wo_schedule,min(wo_duedate) as wo_duedate,min(wo_status) as wo_status,min(wo_priority) as wo_priority,min(wo_creator) as wo_creator,minwo_created_at')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               // ->groupby('wo_mstr.wo_nbr')
               ->where('wo_asset','=',$assetcode)
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->distinct()
               ->paginate(10);
      // dd($data);
      $depart = DB::table('dept_mstr')
                        ->get();
                $engineer = DB::table('eng_mstr')
                        ->where('eng_active','=','Yes')
                        ->get();
                $asset = DB::table('asset_mstr')
                        ->where('asset_active','=','Yes')
                        ->get();
                $failure = DB::table('fn_mstr')
                        ->get();
       return view('/dash/problemwo',['data'=>$data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'type'=>$type]);
    }
    public function problemwopaging(Request $req,$asset){
      // dd('aaa');
      //   dd($req->get('woperiod'));
      //  dd(Carbon::today()->subDay(2));
      if ($req->ajax()) {
          $sort_by   = $req->get('sortby');
          $sort_type = $req->get('sorttype');
          $wonumber  = $req->get('wonumber');
          $asset     = $asset;
          $status    = $req->get('wostatus');
          $priority  = $req->get('wopriority');
          $period    = $req->get('woperiod');

          $usernow = DB::table('users')
                  ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                  // ->select('approver')
                  ->where('username','=',session()->get('username'))
                  ->get();

          if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period =='') {
                           $data = DB::table('wo_mstr')
                           ->selectRaw('min(wo_mstr.wo_id) as wo_id,wo_mstr.wo_nbr ,min(wo_mstr.wo_schedule) as wo_schedule, 
                           min(wo_mstr.wo_duedate) as wo_duedate,min(wo_mstr.wo_status) as wo_status, 
                           min(wo_mstr.wo_creator) as wo_creator, min(wo_mstr.wo_priority) as wo_priority, 
                           wo_mstr.wo_created_at, min(wo_mstr.wo_sr_nbr) as wo_sr_nbr,
                           min(asset_mstr.asset_code) as asset_code,min(asset_mstr.asset_desc) as asset_desc,
                           min(acceptance_image.file_wonumber) as file_wonumber,min(wo_mstr.wo_engineer1) as wo_engineer1, 
                           min(wo_asset) as wo_asset')
                           
                           ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                           ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                           ->groupBy('wo_mstr.wo_nbr')
                           ->groupBy('wo_mstr.wo_created_at')
                           
                           ->orderby('wo_mstr.wo_created_at','desc')
                           ->paginate(10);
                 
              
                  return view('workorder.table-woview', ['data' => $data,'usernow' =>$usernow]);
          } else {
              $kondisi = "wo_mstr.wo_id > 0";

              if ($wonumber != '') {
                  $kondisi .= " and wo_nbr = '" . $wonumber . "'";
              }
              if ($asset != '') {
                  $kondisi .= " and asset_code = '" . $asset . "'";
              }if ($status != '') {
                  $kondisi .= " and wo_status = '" . $status . "'";
              }if ($priority != ''){
                  $kondisi .= " and wo_priority = '". $priority . "'";
              }if($period != ''){
                  if($period == '1'){
                      $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                  }
                  else if($period == '2'){
                      $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                  }
                  else if($period == '3'){
                      $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                  }
              }
              
              // dd($kondisi);
              $data = DB::table('wo_mstr')
                  ->selectRaw('min(wo_mstr.wo_id) as wo_id,wo_mstr.wo_nbr ,min(wo_mstr.wo_schedule) as wo_schedule, 
                  min(wo_mstr.wo_duedate) as wo_duedate,min(wo_mstr.wo_status) as wo_status, 
                  min(wo_mstr.wo_creator) as wo_creator, min(wo_mstr.wo_priority) as wo_priority, 
                  wo_mstr.wo_created_at, min(wo_mstr.wo_sr_nbr) as wo_sr_nbr,
                  min(asset_mstr.asset_code) as asset_code,min(asset_mstr.asset_desc) as asset_desc,
                  min(acceptance_image.file_wonumber) as file_wonumber,min(wo_mstr.wo_engineer1) as wo_engineer1, 
                  min(wo_asset) as wo_asset')
                  
                  ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                  ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                  ->whereRaw($kondisi)
                  // ->orderBy('wo_id', 'desc')
                  ->groupBy('wo_mstr.wo_nbr')
                  ->groupBy('wo_mstr.wo_created_at')
                  
                  ->orderby('wo_mstr.wo_created_at','desc')
                  
                  // ->orderBy('wo_id', 'desc')
                  // ->distinct()
                  // ->tosql();
                  ->paginate(10);
                  // ;
              // dd($data );
                  // dd($sort_by,$sort_type);
              // dd($_SERVER['REQUEST_URI']);                
                  return view('dash.table-problemwo', ['data' => $data,'usernow' => $usernow]);
          }
      }
  }
  public function wotypeget(Request $req,$desc){
     $kondisi = '';
   if($desc == 'WO from SR'){
      $kondisi = "wo_sr_nbr is not null";      
   }
   else if ($desc == 'WO Automatic'){
      $kondisi = "wo_nbr like 'WT%'";
   }
   else if ($desc == 'WO direct'){
      $kondisi = "wo_nbr like 'WD%'";
   }
   else{
      $kondisi = "wo_sr_nbr is null and wo_nbr like 'WO%'";
   }
   $usernow = DB::table('users')
                  ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                  // ->select('approver')
                  ->where('username','=',session()->get('username'))
                  ->get();

      $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               // ->selectRaw('min(wo_id) as wo_id,wo_nbr as wo_nbr,min(asset_desc) as asset_desc,min(wo_schedule) as wo_schedule,min(wo_duedate) as wo_duedate,min(wo_status) as wo_status,min(wo_priority) as wo_priority,min(wo_creator) as wo_creator,minwo_created_at')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               // ->groupby('wo_mstr.wo_nbr')
               ->whereRaw($kondisi)
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->distinct()
               ->paginate(10);
      // dd($data);
      $depart = DB::table('dept_mstr')
                        ->get();
                $engineer = DB::table('eng_mstr')
                        ->where('eng_active','=','Yes')
                        ->get();
                $asset = DB::table('asset_mstr')
                        ->where('asset_active','=','Yes')
                        ->get();
                $failure = DB::table('fn_mstr')
                        ->get();
   // dd($desc);
   return view('/dash/wotype',['data'=>$data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'desc'=>$desc]);      
   // dd($data);
  }
  public function wotypepaging(Request $req,$desc){
   // dd($desc);   
      // dd('aaa');
      //   dd($req->get('woperiod'));
      //  dd(Carbon::today()->subDay(2));
      if ($req->ajax()) {
         $kondisi = '';
      if($desc == 'WO from SR'){
         $kondisi = "wo_sr_nbr is not null";      
      }
      else if ($desc == 'WO Automatic'){
         $kondisi = "wo_nbr like 'WT%'";
      }
      else if ($desc == 'WO direct'){
         $kondisi = "wo_nbr like 'WD%'";
      }
      else{
         $kondisi = "wo_sr_nbr is null and wo_nbr like 'WO%'";
      }     
          $sort_by   = $req->get('sortby');
          $sort_type = $req->get('sorttype');
          $wonumber  = $req->get('wonumber');
          $asset     = $req->get('woasset');
          $status    = $req->get('wostatus');
          $priority  = $req->get('wopriority');
          $period    = $req->get('woperiod');

          $usernow = DB::table('users')
                  ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                  // ->select('approver')
                  ->where('username','=',session()->get('username'))
                  ->get();
      // dd($sort_by);
          if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period =='') {
                      $data = DB::table('wo_mstr')
                           ->selectRaw('min(wo_mstr.wo_id) as wo_id,wo_mstr.wo_nbr ,min(wo_mstr.wo_schedule) as wo_schedule, 
                           min(wo_mstr.wo_duedate) as wo_duedate,min(wo_mstr.wo_status) as wo_status, 
                           min(wo_mstr.wo_creator) as wo_creator, min(wo_mstr.wo_priority) as wo_priority, 
                           wo_mstr.wo_created_at, min(wo_mstr.wo_sr_nbr) as wo_sr_nbr,
                           min(asset_mstr.asset_code) as asset_code,min(asset_mstr.asset_desc) as asset_desc,
                           min(acceptance_image.file_wonumber) as file_wonumber,min(wo_mstr.wo_engineer1) as wo_engineer1, 
                           min(wo_asset) as wo_asset')
                           
                           ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                           ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                           ->whereRaw($kondisi)
                           // ->orderBy('wo_id', 'desc')
                           ->groupBy('wo_mstr.wo_nbr')
                           ->groupBy('wo_mstr.wo_created_at')
                           ->orderBy('wo_mstr.wo_created_at', $sort_type)
                          ->paginate(10);
                 
              
                  return view('dash.table-wotype', ['data' => $data,'usernow' =>$usernow]);
          } else {
            //  dd($asset);
              if ($wonumber != '') {
                  $kondisi .= " and wo_nbr = '" . $wonumber . "'";
              }
              if ($asset != '') {
                  $kondisi .= " and asset_code = '" . $asset . "'";
              }if ($status != '') {
                  $kondisi .= " and wo_status = '" . $status . "'";
              }if ($priority != ''){
                  $kondisi .= " and wo_priority = '". $priority . "'";
              }if($period != ''){
                  if($period == '1'){
                      $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                  }
                  else if($period == '2'){
                      $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                  }
                  else if($period == '3'){
                      $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                  }
              }
              
              // dd($kondisi);
              $data = DB::table('wo_mstr')
                  ->selectRaw('min(wo_mstr.wo_id) as wo_id,wo_mstr.wo_nbr ,min(wo_mstr.wo_schedule) as wo_schedule, 
                  min(wo_mstr.wo_duedate) as wo_duedate,min(wo_mstr.wo_status) as wo_status, 
                  min(wo_mstr.wo_creator) as wo_creator, min(wo_mstr.wo_priority) as wo_priority, 
                  wo_mstr.wo_created_at, min(wo_mstr.wo_sr_nbr) as wo_sr_nbr,
                  min(asset_mstr.asset_code) as asset_code,min(asset_mstr.asset_desc) as asset_desc,
                  min(acceptance_image.file_wonumber) as file_wonumber,min(wo_mstr.wo_engineer1) as wo_engineer1, 
                  min(wo_asset) as wo_asset')
                  
                  ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                  ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                  ->whereRaw($kondisi)
                  // ->orderBy('wo_id', 'desc')
                  ->groupBy('wo_mstr.wo_nbr')
                  ->groupBy('wo_mstr.wo_created_at')
                  ->orderBy('wo_mstr.wo_created_at', $sort_type)
                  // ->orderBy('wo_id', 'desc')
                  // ->distinct()
                  // ->tosql();
                  ->paginate(10);
                  // ;
              // dd($data );
                  // dd($sort_by,$sort_type);
              // dd($_SERVER['REQUEST_URI']);                
                  return view('dash.table-wotype', ['data' => $data,'usernow' => $usernow]);
          }
      }
  }

  public function woengget(Request $req,$eng){
   $kondisi = '';
   $eng2 = $eng;
   // dd($eng);
   $test = 'aaa';
 $usernow = DB::table('users')
                ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                // ->select('approver')
                ->where('username','=',session()->get('username'))
                ->get();
    $data = DB::table('wo_mstr')
             ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
             // ->selectRaw('min(wo_id) as wo_id,wo_nbr as wo_nbr,min(asset_desc) as asset_desc,min(wo_schedule) as wo_schedule,min(wo_duedate) as wo_duedate,min(wo_status) as wo_status,min(wo_priority) as wo_priority,min(wo_creator) as wo_creator,minwo_created_at')
             ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
             ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
             // ->groupby('wo_mstr.wo_nbr')
             ->where(function($query) use ($eng) {
                    $query->where('wo_engineer1','=',$eng)
                    ->orwhere('wo_engineer2','=',$eng)
                    ->orwhere('wo_engineer3','=',$eng)
                    ->orwhere('wo_engineer4','=',$eng)
                    ->orwhere('wo_engineer5','=',$eng);
                })
             ->orderby('wo_created_at','desc')
             ->orderBy('wo_mstr.wo_id', 'desc')
             ->distinct()
             ->paginate(10);
    // dd($data);
    $depart = DB::table('dept_mstr')
                      ->get();
              $engineer = DB::table('eng_mstr')
                      ->where('eng_active','=','Yes')
                      ->get();
              $asset = DB::table('asset_mstr')
                      ->where('asset_active','=','Yes')
                      ->get();
              $failure = DB::table('fn_mstr')
                      ->get();
 // dd($desc);
 return view('/dash/woeng',['data'=>$data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'eng'=>$eng]);      
 // dd($data);
}
public function woengpaging(Request $req,$eng){
 // dd($desc);   
    // dd('aaa');
    //   dd($req->get('woperiod'));
    //  dd(Carbon::today()->subDay(2));
    if ($req->ajax()) {
       $kondisi = '';
    
        $sort_by   = $req->get('sortby');
        $sort_type = $req->get('sorttype');
        $wonumber  = $req->get('wonumber');
        $asset     = $req->get('woasset');
        $status    = $req->get('wostatus');
        $priority  = $req->get('wopriority');
        $period    = $req->get('woperiod');

        $usernow = DB::table('users')
                ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                // ->select('approver')
                ->where('username','=',session()->get('username'))
                ->get();
    // dd($sort_by);
        if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period =='') {
                    $data = DB::table('wo_mstr')
                    ->selectRaw('min(wo_mstr.wo_id) as wo_id,wo_mstr.wo_nbr ,min(wo_mstr.wo_schedule) as wo_schedule, 
                    min(wo_mstr.wo_duedate) as wo_duedate,min(wo_mstr.wo_status) as wo_status, 
                    min(wo_mstr.wo_creator) as wo_creator, min(wo_mstr.wo_priority) as wo_priority, 
                    wo_mstr.wo_created_at, min(wo_mstr.wo_sr_nbr) as wo_sr_nbr,
                    min(asset_mstr.asset_code) as asset_code,min(asset_mstr.asset_desc) as asset_desc,
                    min(acceptance_image.file_wonumber) as file_wonumber,min(wo_mstr.wo_engineer1) as wo_engineer1, 
                    min(wo_asset) as wo_asset')
                    
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                        ->where(function($query) use ($eng) {
                           $query->where('wo_engineer1','=',$eng)
                           ->orwhere('wo_engineer2','=',$eng)
                           ->orwhere('wo_engineer3','=',$eng)
                           ->orwhere('wo_engineer4','=',$eng)
                           ->orwhere('wo_engineer5','=',$eng);
                       })
                       ->groupBy('wo_mstr.wo_nbr')
                       ->groupBy('wo_mstr.wo_created_at')
                       ->orderBy('wo_mstr.wo_created_at', $sort_type)
                        ->distinct('wo_nbr')
                        ->paginate(10);
               
            
                return view('dash.table-wotype', ['data' => $data,'usernow' =>$usernow]);
        } else {
          //  dd($asset);
          $kondisi = "(wo_engineer1 = '".$eng."' or wo_engineer2 = '".$eng."' or wo_engineer3 = '".$eng."' or wo_engineer4 = '".$eng."' or wo_engineer5 = '".$eng."')";
            if ($wonumber != '') {
                $kondisi .= " and wo_nbr = '" . $wonumber . "'";
            }
            if ($asset != '') {
                $kondisi .= " and asset_code = '" . $asset . "'";
            }if ($status != '') {
                $kondisi .= " and wo_status = '" . $status . "'";
            }if ($priority != ''){
                $kondisi .= " and wo_priority = '". $priority . "'";
            }if($period != ''){
                if($period == '1'){
                    $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                }
                else if($period == '2'){
                    $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                }
                else if($period == '3'){
                    $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                }
            }
            
            // dd($kondisi);
            $data = DB::table('wo_mstr')
                ->selectRaw('min(wo_mstr.wo_id) as wo_id,wo_mstr.wo_nbr ,min(wo_mstr.wo_schedule) as wo_schedule, 
                min(wo_mstr.wo_duedate) as wo_duedate,min(wo_mstr.wo_status) as wo_status, 
                min(wo_mstr.wo_creator) as wo_creator, min(wo_mstr.wo_priority) as wo_priority, 
                wo_mstr.wo_created_at, min(wo_mstr.wo_sr_nbr) as wo_sr_nbr,
                min(asset_mstr.asset_code) as asset_code,min(asset_mstr.asset_desc) as asset_desc,
                min(acceptance_image.file_wonumber) as file_wonumber,min(wo_mstr.wo_engineer1) as wo_engineer1, 
                min(wo_asset) as wo_asset')
                
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                
                ->whereRaw($kondisi)
                // ->orderBy('wo_id', 'desc')
                ->groupBy('wo_mstr.wo_nbr')
                ->groupBy('wo_mstr.wo_created_at')
                ->orderBy('wo_mstr.wo_created_at', $sort_type)
                // ->orderBy('wo_id', 'desc')
                // ->distinct()
                // ->tosql();
                ->paginate(10);
                // ;
            // dd($data );
                // dd($sort_by,$sort_type);
            // dd($_SERVER['REQUEST_URI']);                
                return view('dash.table-wotype', ['data' => $data,'usernow' => $usernow]);
        }
    }
}

public function datagrafwo(Request $req, $desc) {

    $posisi     = strrpos($desc,"&");
    $panjang    = strlen($desc);
    $deskripsi  = substr($desc, 3, $posisi-3);
    $tgl        = substr($desc, $posisi+1);
    $bulan      = date("n",strtotime($tgl));
    $tahun      = date("Y",strtotime($tgl));
    $tipewo     = substr($desc, 0, 2);
    $createdate     = Carbon::createFromDate($tgl)->isoFormat('YYYY-MM');

    if ($deskripsi == "WO in Month") {
      $kondisi = "month(wo_created_at) = ".$bulan." and year(wo_created_at) = ".$tahun;
    } elseif ($deskripsi == "WO Open") {
      $kondisi = "month(wo_created_at) = ".$bulan." and year(wo_created_at) = ".$tahun." and wo_status='open'";
    } elseif ($deskripsi == "WO in Progress") {
      $kondisi = "month(wo_start_date) = ".$bulan." and year(wo_start_date) = ".$tahun." and wo_status = 'started'";
    } elseif ($deskripsi == "WO Finish") {
      $kondisi = "month(wo_finish_date) = ".$bulan." and year(wo_finish_date) = ".$tahun." and wo_status in ('closed','finish')";
    } else {
      $kondisi = "";
    }

    if($tipewo == "PM") {
      $kondisi .= " and wo_type = 'auto'";
    } elseif($tipewo == "WO") {
      $kondisi .= " and wo_type <> 'auto'";
    } else {
      $kondisi .= "";
    }

    $depart = DB::table('dept_mstr')
                        ->get();
    $engineer = DB::table('eng_mstr')
            ->where('eng_active','=','Yes')
            ->get();
    $asset = DB::table('asset_mstr')
            ->where('asset_active','=','Yes')
            ->get();
    $failure = DB::table('fn_mstr')
            ->get();
//dd($kondisi);
    $data = DB::table('wo_mstr')
             ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
             ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
             ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
             ->whereRaw($kondisi)
             ->orderby('wo_created_at','desc')
             ->orderBy('wo_mstr.wo_id', 'desc')
             ->distinct()
             ->paginate(10);

    return view("dash.grafwo", compact("data","desc","asset","createdate","tipewo","deskripsi"));
  }

  public function datagrafwopaging(Request $req, $desc) {

    if ($req->ajax()) {

        $sort_by   = $req->get('sortby');
        $sort_type = $req->get('sorttype');

        $wonumber  = $req->get('wonumber');
        $woasset     = $req->get('woasset');
        $status    = $req->get('wostatus');
        $priority  = $req->get('wopriority');
        $tipewo    = $req->get('tipewo');
        $wocreatedate    = $req->get('wocreatedate');
//dd($req->all());
        if ($desc == 'reset') {
          $kondisi   = "wo_type <> 'all'";
        } else {
          $posisi     = strrpos($desc,"&");
          $panjang    = strlen($desc);
          $deskripsi  = substr($desc, 3, $posisi-3);
          $tgl        = substr($desc, $posisi+1);
          //$tipewo     = substr($desc, 0, 2);
          $createdate     = Carbon::createFromDate($tgl)->isoFormat('YYYY-MM');

          $bulan      = date("n",strtotime($wocreatedate));
          $tahun      = date("Y",strtotime($wocreatedate));

          if ($deskripsi == "WO in Month") {
            $kondisi = "month(wo_created_at) = ".$bulan." and year(wo_created_at) = ".$tahun;
          } elseif ($deskripsi == "WO Open") {
            $kondisi = "month(wo_created_at) = ".$bulan." and year(wo_created_at) = ".$tahun." and wo_status='open'";
          } elseif ($deskripsi == "WO in Progress") {
            $kondisi = "month(wo_start_date) = ".$bulan." and year(wo_start_date) = ".$tahun." and wo_status = 'started'";
          } elseif ($deskripsi == "WO Finish") {
            $kondisi = "month(wo_finish_date) = ".$bulan." and year(wo_finish_date) = ".$tahun." and wo_status in ('closed','finish')";
          } else {
            $kondisi = "";
          }   
        }
//dd($kondisi);
        $asset = DB::table('asset_mstr')
                ->where('asset_active','=','Yes')
                ->get();

        if ($wonumber == '' and $woasset == '' and $status == '' and $priority == '' and $tipewo =='' 
          and $wocreatedate == '') {
            
            $data = DB::table('wo_mstr')
             ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
             ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
             ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
             ->whereRaw($kondisi)
             ->orderby('wo_created_at','desc')
             ->orderBy('wo_mstr.wo_id', 'desc')
             ->distinct()
             ->paginate(10);

            return view("dash.table-grafwo", compact("data","desc","asset","createdate","tipewo","deskripsi"));
        } else {

            if ($wonumber != '') {
                $kondisi .= " and wo_nbr = '" . $wonumber . "'";
            }
            if ($woasset != '') {
                $kondisi .= " and asset_code = '" . $woasset . "'";
            }
            if ($status != '') {
                $kondisi .= " and wo_status = '" . $status . "'";
            }
            if ($desc == 'reset') {
              if ($wocreatedate != ''){
                  $bulan      = date("n",strtotime($wocreatedate));
                  $tahun      = date("Y",strtotime($wocreatedate));

                  $kondisi .= " and month(wo_created_at) = ".$bulan." and year(wo_created_at) = ".$tahun;
              }
            }
            
            if($tipewo == "PM") {
              $kondisi .= " and wo_type = 'auto'";
            } elseif($tipewo == "WO") {
              $kondisi .= " and wo_type <> 'auto'";
            } else {
              $kondisi .= "";
            }
           
            $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               ->whereRaw($kondisi)
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->distinct()
               ->paginate(10);

            return view("dash.table-grafwo", compact("data","desc","asset","createdate","tipewo","deskripsi"));
        }
    }
  }

  public function datagrafytdwo(Request $req, $desc) {
    $tipewo       = substr($desc,0,2);
    $deskripsi    = substr($desc, 3);

    switch ($deskripsi) {
      case "Jan":
        $bulan = 1;
        break;
      case "Feb":
        $bulan = 2;
        break;
      case "Mar":
        $bulan = 3;
        break;
      case "Apr":
        $bulan = 4;
        break;
      case "May":
        $bulan = 5;
        break;
      case "Jun":
        $bulan = 6;
        break;
      case "Jul":
        $bulan = 7;
        break;
      case "Aug":
        $bulan = 8;
        break;
      case "Sep":
        $bulan = 9;
        break;
      case "Oct":
        $bulan = 10;
        break;
      case "Nov":
        $bulan = 11;
        break;
      case "Dec":
        $bulan = 12;
        break;
      default:
        $bulan = 0;
    }

    $tahun      = Carbon::now('ASIA/JAKARTA')->isoFormat('YYYY');
    $createdate   = $tahun.'-'.str_pad($bulan, 2, '0',STR_PAD_LEFT);

    $kondisi = "month(wo_created_at) = ".$bulan." and year(wo_created_at) = ".$tahun;

    if ($tipewo == 'WO') {
      $kondisi .= " and wo_type <> 'auto'";
    } elseif ($tipewo == 'PM') {
      $kondisi .= " and wo_type = 'auto'";
    } else {
      $kondisi .= "";
    }

    $depart = DB::table('dept_mstr')
                        ->get();
    $engineer = DB::table('eng_mstr')
            ->where('eng_active','=','Yes')
            ->get();
    $asset = DB::table('asset_mstr')
            ->where('asset_active','=','Yes')
            ->get();
    $failure = DB::table('fn_mstr')
            ->get();

    
    $data = DB::table('wo_mstr')
             ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
             ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
             ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
             ->whereRaw($kondisi)
             ->orderby('wo_created_at','desc')
             ->orderBy('wo_mstr.wo_id', 'desc')
             ->distinct()
             ->paginate(10);

    return view("dash.grafytdwo", compact("data","desc","asset","createdate","tipewo"));
  }

  public function datagrafytdwopaging(Request $req, $desc) {

    if ($req->ajax()) {
       
        $sort_by   = $req->get('sortby');
        $sort_type = $req->get('sorttype');
        $wonumber  = $req->get('wonumber');
        $woasset   = $req->get('woasset');
        $status    = $req->get('wostatus');
        $createdate    = $req->get('wocreatedate');
        $tipewo    = $req->get('tipewo');

        if ($desc == 'reset') {
          $deskripsi   = 0;
        } else {
          $tipewo = substr($desc,0,2);
          $deskripsi  = substr($desc, 3);

          switch ($deskripsi) {
            case "Jan":
              $bulan = 1;
              break;
            case "Feb":
              $bulan = 2;
              break;
            case "Mar":
              $bulan = 3;
              break;
            case "Apr":
              $bulan = 4;
              break;
            case "May":
              $bulan = 5;
              break;
            case "Jun":
              $bulan = 6;
              break;
            case "Jul":
              $bulan = 7;
              break;
            case "Aug":
              $bulan = 8;
              break;
            case "Sep":
              $bulan = 9;
              break;
            case "Oct":
              $bulan = 10;
              break;
            case "Nov":
              $bulan = 11;
              break;
            case "Dec":
              $bulan = 12;
              break;
            default:
              $bulan = 0;
          }

          $tahun   = Carbon::now('ASIA/JAKARTA')->isoFormat('YYYY');
        }

        if ($desc == 'reset') {
          $deskripsi   = 0;
          if (isset($createdate)) {
            $bulan      = date("n",strtotime($createdate));
            $tahun      = date("Y",strtotime($createdate));
          } else {
            $createdate   = null;
          }
        } else {
          $tipewo = substr($desc,0,2);
          $deskripsi  = substr($desc, 3);
          $createdate   = $tahun.'-'.str_pad($bulan, 2, '0',STR_PAD_LEFT);
        }
        

        $asset = DB::table('asset_mstr')
                ->where('asset_active','=','Yes')
                ->get();

        if ($wonumber == '' and $woasset == '' and $status == '' and $createdate == '' and $tipewo == '' 
            || $desc=='reset') {
             
            $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->distinct()
               ->paginate(10);
        
            return view("dash.table-grafytdwo", compact("data","desc","asset","createdate","tipewo"));
        } else {

            $kondisi = "month(wo_created_at) = ".$bulan." and year(wo_created_at) = ".$tahun;

            if ($tipewo == 'WO') {
              $kondisi .= " and wo_type <> 'auto'";
            } elseif ($tipewo == 'PM') {
              $kondisi .= " and wo_type = 'auto'";
            } else {
              $kondisi .= "";
            }

            if ($wonumber != '') {
                $kondisi .= " and wo_nbr = '" . $wonumber . "'";
            }
            if ($woasset != '') {
                $kondisi .= " and asset_code = '" . $woasset . "'";
            }
            if ($status != '') {
                $kondisi .= " and wo_status = '" . $status . "'";
            }

           $data = DB::table('wo_mstr')
             ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
             ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
             ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
             ->whereRaw($kondisi)
             ->orderby('wo_created_at','desc')
             ->orderBy('wo_mstr.wo_id', 'desc')
             ->distinct()
             ->paginate(10);

            return view("dash.table-grafytdwo", compact("data","desc","asset","createdate","tipewo"));
        }
    }
  }

  public function datagrafhourwo(Request $req, $desc) {

    $tipewo       = substr($desc,0,2);
    $deskripsi    = substr($desc, 3);

    switch ($deskripsi) {
      case "Jan":
        $bulan = 1;
        break;
      case "Feb":
        $bulan = 2;
        break;
      case "Mar":
        $bulan = 3;
        break;
      case "Apr":
        $bulan = 4;
        break;
      case "May":
        $bulan = 5;
        break;
      case "Jun":
        $bulan = 6;
        break;
      case "Jul":
        $bulan = 7;
        break;
      case "Aug":
        $bulan = 8;
        break;
      case "Sep":
        $bulan = 9;
        break;
      case "Oct":
        $bulan = 10;
        break;
      case "Nov":
        $bulan = 11;
        break;
      case "Dec":
        $bulan = 12;
        break;
      default:
        $bulan = 0;
    }

    $tahun      = Carbon::now('ASIA/JAKARTA')->isoFormat('YYYY');
    $createdate   = $tahun.'-'.str_pad($bulan, 2, '0',STR_PAD_LEFT);

    $kondisi = "month(wo_finish_date) = ".$bulan." and year(wo_finish_date) = ".$tahun;

    if ($tipewo == 'WO') {
      $kondisi .= " and wo_type <> 'auto'";
    } elseif ($tipewo == 'PM') {
      $kondisi .= " and wo_type = 'auto'";
    } else {
      $kondisi .= "";
    }

//dd($kondisi);
    $depart = DB::table('dept_mstr')
                        ->get();
    $engineer = DB::table('eng_mstr')
            ->where('eng_active','=','Yes')
            ->get();
    $asset = DB::table('asset_mstr')
            ->where('asset_active','=','Yes')
            ->get();
    $failure = DB::table('fn_mstr')
            ->get();

    // $data = DB::table('wo_mstr')
    //            ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
    //            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
    //            ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
    //            ->whereExists(function ($query) {
    //                $query->select(DB::raw(1))
    //                      ->from('wo_dets');
    //            })
    //            ->whereRaw($kondisi)
    //            ->orderby('wo_created_at','desc')
    //            ->orderBy('wo_mstr.wo_id', 'desc')
    //            ->distinct()
    //            ->paginate(10);

    $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               ->whereExists(function ($query) {
                   $query->select(DB::raw(1))
                         ->from('wo_dets');
               })
               ->whereRaw($kondisi)
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->distinct()
               ->paginate(10);
//dd($data);
    return view("dash.grafhourwo", compact("data","desc","asset","createdate","tipewo"));
  }

  public function datagrafhourwopaging(Request $req, $desc) {

    if ($req->ajax()) {

        switch ($desc) {
          case "Jan":
            $bulan = 1;
            break;
          case "Feb":
            $bulan = 2;
            break;
          case "Mar":
            $bulan = 3;
            break;
          case "Apr":
            $bulan = 4;
            break;
          case "May":
            $bulan = 5;
            break;
          case "Jun":
            $bulan = 6;
            break;
          case "Jul":
            $bulan = 7;
            break;
          case "Aug":
            $bulan = 8;
            break;
          case "Sep":
            $bulan = 9;
            break;
          case "Oct":
            $bulan = 10;
            break;
          case "Nov":
            $bulan = 11;
            break;
          case "Dec":
            $bulan = 12;
            break;
          default:
            $bulan = 0;
        }

        $tahun   = Carbon::now('ASIA/JAKARTA')->isoFormat('YYYY');

        $kondisi = "month(wo_finish_date) = ".$bulan." and year(wo_finish_date) = ".$tahun;

        $asset = DB::table('asset_mstr')
                ->where('asset_active','=','Yes')
                ->get();

        $sort_by   = $req->get('sortby');
        $sort_type = $req->get('sorttype');
        $wonumber  = $req->get('wonumber');
        $asset     = $req->get('woasset');
        $status    = $req->get('wostatus');
        $priority  = $req->get('wopriority');
        $period    = $req->get('woperiod');

        if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period =='') {
              
            $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               ->whereExists(function ($query) {
                   $query->select(DB::raw(1))
                         ->from('wo_dets');
               })
               ->whereRaw($kondisi)
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->paginate(10);

            return view("dash.table-grafhourwo", compact("data","desc","asset"));
        } else {

            if ($wonumber != '') {
                $kondisi .= " and wo_nbr = '" . $wonumber . "'";
            }
            if ($asset != '') {
                $kondisi .= " and asset_code = '" . $asset . "'";
            }
            if ($status != '') {
                $kondisi .= " and wo_status = '" . $status . "'";
            }
            if ($priority != ''){
                $kondisi .= " and wo_priority = '". $priority . "'";
            }
            if($period != ''){
                if($period == '1'){
                    $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                }
                else if($period == '2'){
                    $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                }
                else if($period == '3'){
                    $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                }
            }

            $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               ->whereExists(function ($query) {
                   $query->select(DB::raw(1))
                         ->from('wo_dets');
               })
               ->whereRaw($kondisi)
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->distinct()
               ->paginate(10);

            return view("dash.table-grafhourwo", compact("data","desc","asset"));
        }
    }
  }

  public function wostatus(Request $req, $desc) {

    if ($desc == "Under Maintenance") {
      $kondisi = "wo_status = 'started'";
    } elseif ($desc == "Planned Maintenance") {
      $kondisi = "wo_status = 'plan'";
    } elseif ($desc == "Request Maintenance") {
      $kondisi = "wo_status = 'open'";
    } else {
      $kondisi = "";
    }    

    $depart = DB::table('dept_mstr')
                        ->get();
    $engineer = DB::table('eng_mstr')
            ->where('eng_active','=','Yes')
            ->get();
    $asset = DB::table('asset_mstr')
            ->where('asset_active','=','Yes')
            ->get();
    $failure = DB::table('fn_mstr')
            ->get();

    $data = DB::table('wo_mstr')
             ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
             ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
             ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
             ->whereRaw($kondisi)
             ->orderby('wo_created_at','desc')
             ->orderBy('wo_mstr.wo_id', 'desc')
             ->distinct()
             ->paginate(10);

    return view("dash.wostatus", compact("data","desc","asset"));
  }

  public function wostatuspaging(Request $req, $desc) {

    if ($req->ajax()) {

        $asset = DB::table('asset_mstr')
                ->where('asset_active','=','Yes')
                ->get();

        $sort_by   = $req->get('sortby');
        $sort_type = $req->get('sorttype');
        $wonumber  = $req->get('wonumber');
        $asset     = $req->get('woasset');
        $status    = $req->get('wostatus');
        $priority  = $req->get('wopriority');
        $period    = $req->get('woperiod');

        if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period =='') {
              
            $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->distinct()
               ->paginate(10);
        
            return view("dash.table-wostatus", compact("data","desc","asset"));
        } else {

            $kondisi = "wo_nbr <> 'a'";
            if ($wonumber != '') {
                $kondisi .= " and wo_nbr = '" . $wonumber . "'";
            }
            if ($asset != '') {
                $kondisi .= " and asset_code = '" . $asset . "'";
            }
            if ($status != '') {
                $kondisi .= " and wo_status = '" . $status . "'";
            }
            if ($priority != ''){
                $kondisi .= " and wo_priority = '". $priority . "'";
            }
            if($period != ''){
                if($period == '1'){
                    $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                }
                else if($period == '2'){
                    $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                }
                else if($period == '3'){
                    $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                }
            }

            $data = DB::table('wo_mstr')
               ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
               ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
               ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
               ->whereRaw($kondisi)
               ->orderby('wo_created_at','desc')
               ->orderBy('wo_mstr.wo_id', 'desc')
               ->distinct()
               ->paginate(10);

            return view("dash.table-wostatus", compact("data","desc","asset"));
        }
    }
  }

  public function getfinhour(Request $req)
  {
      if ($req->ajax()) {
          $wonbr = $req->get('wonbr');
    
          $data = DB::table('wo_dets')
                  ->selectRaw('count(wo_dets_rep_hour) as counthour')
                  ->where('wo_dets_nbr','=',$wonbr)
                  ->first();

          return response($data->counthour);
      }
  }

  public function donlodwograf(Request $req) {
//dd($req->all());
        $wonbr          = $req->wonumber;
        $asset          = $req->asset;
        $status         = $req->status;
        $wocreatedate   = $req->wocreatedate;
        $tipewo         = $req->tipewo;
        $deskripsi      = $req->deskripsi;
        
        return Excel::download(new donlodwograf($wonbr,$status,$asset,$wocreatedate,$tipewo,$deskripsi),'Data WO.xlsx');
    }

}
