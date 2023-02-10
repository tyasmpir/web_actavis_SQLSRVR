<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use PDF;
use File;
use App\User;
use Carbon\Carbon;
use Svg\Tag\Rect;
use App\Jobs\EmailScheduleJobs;
use App;
use App\Exports\ViewExport2;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class wocontroller extends Controller
{
    private function httpHeader($req) {
        return array('Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SOAPAction: ""',        // jika tidak pakai SOAPAction, isinya harus ada tanda petik 2 --> ""
            'Content-length: ' . strlen(preg_replace("/\s+/", " ", $req)));
    }
//wo browse
    public function wobrowsemenu(){
        // dd(Session::get('department'));    
            if (strpos(Session::get('menu_access'), 'WO05') !== false) {
                $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->first();
                // dd($usernow);
                // if($usernow->role_user == 'ADM' || ($usernow->rolemaster != 'ADM' && $usernow->approver == 1)){
                //     $data = DB::table('wo_mstr')
                //         ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
                //         // ->selectRaw('min(wo_id) as wo_id,wo_nbr as wo_nbr,min(asset_desc) as asset_desc,min(wo_schedule) as wo_schedule,min(wo_duedate) as wo_duedate,min(wo_status) as wo_status,min(wo_priority) as wo_priority,min(wo_creator) as wo_creator,minwo_created_at')
                //         ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                //         ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                //         // ->where('wo_creator','=',Session::get('username'))
                //         // ->where('wo_')
                //         // ->groupby('wo_mstr.wo_nbr')
                //         ->orderby('wo_created_at','desc')
                //         ->orderBy('wo_mstr.wo_id', 'desc')
                //         ->distinct()
                //         ->paginate(10);
                // }
                // else{
                // if(Session::get('role'))
                    $data = DB::table('wo_mstr')
                        ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
                        // ->selectRaw('min(wo_id) as wo_id,wo_nbr as wo_nbr,min(asset_desc) as asset_desc,min(wo_schedule) as wo_schedule,min(wo_duedate) as wo_duedate,min(wo_status) as wo_status,min(wo_priority) as wo_priority,min(wo_creator) as wo_creator,minwo_created_at')
                        ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                        ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                        // ->where('wo_creator','=',Session::get('username'))
                        // ->where('wo_')
                        // ->groupby('wo_mstr.wo_nbr')
                        ->orderby('wo_created_at','desc')
                        ->orderBy('wo_mstr.wo_id', 'desc')
                        ->distinct()
                        ->paginate(10);
                    // dd($data);
                // }
                $custrnow = DB::table('wo_mstr')
                            ->selectRaw('wo_creator,min(eng_desc) as creator_desc')
                            ->join('eng_mstr','wo_mstr.wo_creator','eng_mstr.eng_code')
                            ->groupBy('wo_creator')
                            ->get();
                            // dd($custrnow);

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

                return view('workorder.woview', ['custrnow' => $custrnow, 'data' => $data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '']);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    //wo create menu
    public function wocreatemenu(){
        // dd(Session::all())
        if (strpos(Session::get('menu_access'), 'WO04') !== false) {
            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();
            // dd($usernow);
            
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                
                ->whereRaw('wo_sr_nbr is null')
                ->where('wo_status','=','plan')
                ->where('wo_creator','=',Session()->get('username'))
                // ->where(function($query){
                //     $query->where('wo_engineer1','=',Session()->get('username'))
                //     ->orwhere('wo_engineer2','=',Session()->get('username'))
                //     ->orwhere('wo_engineer3','=',Session()->get('username'))
                //     ->orwhere('wo_engineer4','=',Session()->get('username'))
                //     ->orwhere('wo_engineer5','=',Session()->get('username'));
                // })
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(10);
            //  dd($data);
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
            
                    
            return view('workorder.wocreate', ['data' => $data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '']);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    public function wocreatedirectmenu(){
        // dd(Session::all())
        if (strpos(Session::get('menu_access'), 'WO05') !== false) {
            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();
            // dd($usernow);
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->where('wo_type','=','direct')
                ->where('wo_status','=','open')
                ->where(function($query){
                    $query->where('wo_engineer1','=',Session()->get('username'))
                    ->orwhere('wo_engineer2','=',Session()->get('username'))
                    ->orwhere('wo_engineer3','=',Session()->get('username'))
                    ->orwhere('wo_engineer4','=',Session()->get('username'))
                    ->orwhere('wo_engineer5','=',Session()->get('username'));
                })
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
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
            $repaircode = DB::table('rep_master')
                        ->get();
            $sparepart = DB::table('sp_mstr')
                        ->get();
            $repairgroup = DB::table('xxrepgroup_mstr')
                            ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                            ->distinct('xxrepgroup_nbr')
                            ->get();
            return view('workorder.wocreatedirect', ['data' => $data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '','repairgroup'=>$repairgroup, 'repaircode'=>$repaircode,'sparepart'=>$sparepart]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }
    
    // WO maint
    public function wobrowse(){
        if (strpos(Session::get('menu_access'), 'WO01') !== false) {
            // dd(Session::all());
            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();
            // dd($usernow);
            $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->orderby('wo_updated_at','desc')
                    ->orderBy('wo_mstr.wo_nbr', 'desc')
                    ->paginate(10);
                    // dd($data);
            //   dd($data);
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
            $repaircode = DB::table('rep_master')
                        ->get();
			$repairgroup = DB::table('xxrepgroup_mstr')
                        ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                        ->distinct('xxrepgroup_nbr')
						->get();
            return view('workorder.wobrowse', ['repairgroup' => $repairgroup,'data' => $data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '','repaircode' => $repaircode]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    //tyas, link dari Home 
    public function wobrowseopen(){
        if (strpos(Session::get('menu_access'), 'WO01') !== false) {
            // dd(Session::all());
            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();
            // dd($usernow);
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->WHERE('wo_status','=','open')
                ->orderby('wo_updated_at','desc')
                ->orderBy('wo_mstr.wo_nbr', 'desc')
                ->paginate(10);
            //   dd($data);
            $depart = DB::table('dept_mstr')
                    ->get();
            $engineer = DB::table('eng_mstr')
                    ->where('eng_active','=','Yes')
                    ->get();
            $asset = DB::table('asset_mstr')
                    ->get();
            $failure = DB::table('fn_mstr')
                    ->get();
            $repaircode = DB::table('rep_master')
                    ->get();
            $repairgroup = DB::table('xxrepgroup_mstr')
                        ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                        ->distinct('xxrepgroup_nbr')
                        ->get();
            return view('workorder.wobrowse', ['repairgroup' => $repairgroup,'data' => $data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '','repaircode' => $repaircode]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }

    public function createdirectwo(Request $req){
         // dd($req->all());
        $fn1 = null;
        $fn2 = null;
        $fn3 = null;
        $rc1 = null;
        $rc2 = null;
        $rc3 = null;
        $rprg = null;
        $rprtype = null;
        $finisht = null;
        if(array_key_exists(0,$req->get('c_failure'))){
            $fn1 = $req->get('c_failure')[0];
        }
        else{
            $fn1 = null;
        }
        if(array_key_exists(1,$req->get('c_failure'))){
            $fn2 = $req->get('c_failure')[1];
        }
        else{
            $fn3 = null;
        }
        if(array_key_exists(2,$req->get('c_failure'))){
            $fn3 = $req->get('c_failure')[2];
        }
        else{
            $fn3 = null;
        }
        //dd($req->get('c_engineer')[0]);
        //dd($req->get('c_engineer')[4]);
        $tablern = DB::table('running_mstr')
                ->first();
        $tempnewrunnbr = strval(intval($tablern->wd_nbr)+1);
	    $newtemprunnbr = '';
	    if(strlen($tempnewrunnbr) < 4){
	      $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
	    }
        $runningnbr = $tablern->wd_prefix.'-'.$tablern->year.'-'.$newtemprunnbr;
        if(isset($req->repairtype)){
            if ($req->repairtype == 'manual'){
                    DB::table('wo_manual_detail')
                            ->where('wo_manual_wo_nbr','=',$runningnbr)
                            ->delete();
                    for($pop = 0; $pop <count($req->number);$pop++){
                        if($req->part[$pop] != null && $req->desc[$pop] != null){
                            $arraymanual = array([
                                'wo_manual_wo_nbr'      => $runningnbr,
                                'wo_manual_number'      => $req->number[$pop],
                                'wo_manual_part'        => $req->part[$pop],
                                'wo_manual_desc'        => $req->desc[$pop],
                                'wo_manual_flag'        => $req->group4[$pop],
                                'wo_manual_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                               ]);
                                // dd($arraydettemp);
                                DB::table('wo_manual_detail')->insert($arraymanual);
                        } 
                    }
                    $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
                    $rprtype = 'manual';
            }
            else if($req->repairtype == 'code'){
                
                DB::table('wo_rc_detail')
                ->where('wrd_wo_nbr','=',$runningnbr)
                ->delete();
                
                if($req->has('repaircode1')){
                    $rc1 = $req->repaircode1[0];
                    
                    $dborigin = DB::table('rep_master')
                        ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                        ->join('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                        // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                        ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                        ->where('rep_master.repm_code','=',$rc1)
                        // ->groupBy('spt_code')
                        ->orderBy('repdet_step')
                        ->get();
                    $countdb1 = count($dborigin);
                    
                    $flagname = '';
                    for($i = 0; $i<$countdb1;$i++){
                        $newname = 'group'.$i;
                        if(isset($req->group1[$newname])){
                        $flagname .= $req->group1[$newname];
                        }
                    }
                    // dd($flagname);
                    $arrayrc1 = array([
                        'wrd_wo_nbr'      => $runningnbr,
                        'wrd_repair_code' => $req->repaircode1[0],
                        'wrd_flag'        => $flagname,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc1);
                }
                if($req->has('repaircode2')){
                    $rc2 = $req->repaircode2[0];
                    $dborigin2 = DB::table('rep_master')
                        ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                        ->join('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                        // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                        ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                        ->where('rep_master.repm_code','=',$rc2)
                        ->orderBy('repdet_step')
                        ->get();

                    $countdb2 = count($dborigin2);
                    // dd($req->all)
                    $flagname2 = '';
                    // dd($countdb2);
                    for($i = 0; $i<$countdb2;$i++){
                        $newname2 = 'group'.$i;
                        // dd($newname2);
                        if(isset($req->group2[$newname2])){
                            $flagname2 .= $req->group2[$newname2];
                            
                        }
                    }

                    
                    $arrayrc2 = array([
                        'wrd_wo_nbr'      => $runningnbr,
                        'wrd_repair_code' => $req->repaircode2[0],
                        'wrd_flag'        => $flagname2,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc2);
                }
                    // dd($flagname);
                    
                if($req->has('repaircode3')){
                    $rc3 = $req->repaircode3[0];
                    $dborigin3 = DB::table('rep_master')
                    ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                    ->join('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                    // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                    ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                    ->where('rep_master.repm_code','=',$rc3)
                    // ->groupBy('spt_code')
                    ->orderBy('repdet_step')
                    ->get();
                    $countdb3 = count($dborigin3);
                    
                    $flagname = '';
                    for($i = 0; $i<$countdb3;$i++){
                        $newname = 'group'.$i;
                        if(isset($req->group3[$newname])){
                            $flagname .= $req->group3[$newname];
                        }
                    }
                    $arrayrc3 = array([
                        'wrd_wo_nbr'      => $runningnbr,
                        'wrd_repair_code' => $req->repaircode3[0],
                        'wrd_flag'        => $flagname,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc3);
                }
               
                   
                //  dd($req->all());
                $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
                $rprtype = 'code';
                // dd($finisht);
            
                // dd($arrayy);
            }
                
           
            else if($req->repairtype == 'group'){
                $rprg = $req->repairgroup[0];
                DB::table('wo_rc_detail')
                ->where('wrd_wo_nbr','=',$runningnbr)
                ->delete();

                $repairlen = count($req->repaircodeselection);
                for($i = 0; $i<$repairlen; $i++){
                    $rg = $req->repaircodeselection[$i];
                    $dborigin = DB::table('rep_master')
                                ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                ->join('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                                // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                                ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                                ->where('rep_master.repm_code','=',$rg)
                                // ->groupBy('spt_code')
                                ->orderBy('repdet_step')
                                ->get();
                    $countdb1 = count($dborigin);
                    // dd($dborigin);
                    $flagname = '';
                    for($j = 0; $j<$countdb1;$j++){
                        $newname = 'group'.$i;
                        if(isset($req->group4[$i][$j])){
                            $flagname .= $req->group4[$i][$j];
                        }
                    }

                    
                    $arrayrc1 = array([
                        'wrd_wo_nbr'      => $runningnbr,
                        'wrd_repair_code' => $rg,
                        'wrd_flag'        => $flagname,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc1);
                    // dd($flagname);
                }
                $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
            }
        }

        $dataarray = array(
            'wo_nbr'           => $runningnbr,
            'wo_dept'          => Session::get('department'),
            'wo_engineer1'     => $req->engineercreate,
            'wo_failure_code1' => $fn1,
            'wo_failure_code2' => $fn2,
            'wo_failure_code3' => $fn3,
            'wo_repair_code1'  => $rc1,
            'wo_repair_code2'  => $rc2,
            'wo_repair_code3'  => $rc3,
            'wo_repair_group'  => $rprg,
            'wo_repair_type'   => $rprtype,
            'wo_repair_hour'   => $req->c_repairhour,
            'wo_finish_date'   => $req->c_finishdate,
            'wo_finish_time'   => $finisht,
            'wo_asset'         => $req->c_asset,
            'wo_priority'      => $req->c_priority,
            'wo_status'        => 'closed',
            'wo_schedule'      => $req->c_schedule,
            'wo_duedate'       => $req->c_duedate,
            'wo_note'          => $req->c_note,
            'wo_creator'       => session()->get('username'),
            'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
            'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
            'wo_start_date'    => Carbon::now('ASIA/JAKARTA')->toDateString(),
            'wo_start_time'    => Carbon::now('ASIA/JAKARTA')->toTimeString(),
            'wo_created_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_updated_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_type'          => 'direct'
        );
        // dd($dataarray);
        DB::table('wo_mstr')->insert($dataarray);
        DB::table('running_mstr')
        ->where('wd_nbr', '=', $tablern->wd_nbr)
        ->update([
            'wd_nbr' => $newtemprunnbr
        ]);

        $albumraw = $req->imgname;
        if(isset($req->imgname)){
            foreach($albumraw as $olah1){
                $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                // dd($waktu);
                $jadi1 = explode(',', $olah1);
                // a..png
                $jadi2 = base64_decode($jadi1[2]);
                $lenstr = strripos($jadi1[0],'.');
                $test = substr($jadi1[0],$lenstr);
                // dd($test);
                $test3 = str_replace($test,'',$jadi1[0]);
                // dd($test3);
                $test4 = str_replace('.','',$test3);
                $test44 = str_replace(' ','',$test4);
                $test5 = $test44.$waktu.$test;
                $alamaturl = '../public/upload/'.$test5;
                file_put_contents($alamaturl, $jadi2);

                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $req->c_srnbr,
                        'file_wonumber' => $runningnbr,
                        'file_name' => $jadi1[0], //nama file asli
                        'file_url' => $alamaturl, 
                        'uploaded_at' => Carbon::now()->toDateTimeString(),
                    ]);
            }
        }
                    
        $assettable = DB::table('asset_mstr')
            ->where('asset_code','=',$req->c_asset)
            ->first();
                
        $asset = $req->c_asset.' - '.$assettable->asset_desc;
        
        EmailScheduleJobs::dispatch($runningnbr,$asset,'5','','','','');

        toast('WO '.$runningnbr.' Successfuly Created !','success');
        return back();
    }

    public function createenwo(Request $req){
        //  dd($req->all());
        
        
        $fn1 = '';
        $fn2 = '';
        $fn3 = '';
        if(array_key_exists(0,$req->get('c_failure'))){
            $fn1 = $req->get('c_failure')[0];
        }
        else{
            $fn1 = null;
        }
        if(array_key_exists(1,$req->get('c_failure'))){
            $fn2 = $req->get('c_failure')[1];
        }
        else{
            $fn3 = null;
        }
        if(array_key_exists(2,$req->get('c_failure'))){
            $fn3 = $req->get('c_failure')[2];
        }
        else{
            $fn3 = null;
        }
        //dd($req->get('c_engineer')[0]);
        
        
        //dd($req->get('c_engineer')[4]);
        $tablern = DB::table('running_mstr')
                ->first();
        $tempnewrunnbr = strval(intval($tablern->wo_nbr)+1);
	    $newtemprunnbr = '';
	    if(strlen($tempnewrunnbr) < 4){
	      $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
	    }
        $runningnbr = $tablern->wo_prefix.'-'.$tablern->year.'-'.$newtemprunnbr;
        
        $dataarray = array(
            'wo_nbr'           => $runningnbr,
            'wo_dept'          => Session::get('department'),
            'wo_engineer1'     => $req->engineercreate,
            'wo_failure_code1' => $fn1,
            'wo_failure_code2' => $fn2,
            'wo_failure_code3' => $fn3,
            'wo_asset'         => $req->c_asset,
            'wo_priority'      => $req->c_priority,
            'wo_status'        => 'plan',
            'wo_schedule'      => $req->c_schedule,
            'wo_duedate'       => $req->c_duedate,
            'wo_note'          => $req->c_note,
            'wo_creator'       => session()->get('username'),
            'wo_created_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_updated_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_type'          => 'other'
        );
        // dd($dataarray);
        DB::table('wo_mstr')->insert($dataarray);
        DB::table('running_mstr')
        ->where('wo_nbr', '=', $tablern->wo_nbr)
        ->update([
            'wo_nbr' => $newtemprunnbr
        ]);
        $assettable = DB::table('asset_mstr')
            ->where('asset_code','=',$req->c_asset)
            ->first();
                
        $asset = $req->c_asset.' - '.$assettable->asset_desc;
        
        EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');

        toast('WO Successfuly Created !','success');
        return back();
    }

    public function createwo(Request $req){
         // dd($req->get('c_failure'));
        //  dd($req->crepaircode1);
        $eng1 = '';
        $eng2 = '';
        $eng3 = '';
        $eng4 = '';
        $eng5 = '';
        $fn1 = null;
        $fn2 = null;
        $fn3 = null;
        $rc1 = '';
        $rc2 = '';
        $rc3 = '';
        $rg1 = '';
        $c_wotype = null;
        if($req->cwotype == 'preventive'){
            $c_wotype = 'auto';
        }
        else{
            $c_wotype = 'other';
        }
        if($req->get('c_failure') !== null){
            if(array_key_exists(0,$req->get('c_failure'))){
            $fn1 = $req->get('c_failure')[0];
            }
            else{
                $fn1 = null;
            }
            if(array_key_exists(1,$req->get('c_failure'))){
                $fn2 = $req->get('c_failure')[1];
            }
            else{
                $fn3 = null;
            }
            if(array_key_exists(2,$req->get('c_failure'))){
                $fn3 = $req->get('c_failure')[2];
            }
            else{
                $fn3 = null;
            }
        }
        
        //dd($req->get('c_engineer')[0]);
        if(array_key_exists(0,$req->get('c_engineer'))){
            $eng1 = $req->get('c_engineer')[0];
        }
        else{
            $eng1 = null;
        }
        if(array_key_exists(1,$req->get('c_engineer'))){
            $eng2 = $req->get('c_engineer')[1];
        }
        else{
            $eng2 = null;
        }
        if(array_key_exists(2,$req->get('c_engineer'))){
            $eng3 = $req->get('c_engineer')[2];
        }
        else{
            $eng3 = null;
        }
        if(array_key_exists(3,$req->get('c_engineer'))){
            $eng4 = $req->get('c_engineer')[3];
        }
        else{
            $eng4 = null;
        }
        if(array_key_exists(4,$req->get('c_engineer'))){
            $eng5 = $req->get('c_engineer')[4];

        }
        else{
            $eng5 = null;
        }

        // if(isset($req->crepaircode[0])){
        //     $rc1 = $req->c_repaircode[0];
        // }
        // if(isset($req->crepaircode[1])){
        //     $rc2 = $req->c_repaircode[1];
        // }
        // if(isset($req->crepaircode[2])){
        //     $rc3 = $req->c_repaircode[2];
        // }
        // if(isset($req->crepairgroup)){
        //     $rg1 = $req->crepairgroup;
        // }
        
        //dd($req->get('c_engineer')[4]);
        $tablern = DB::table('running_mstr')
                ->first();
        $tempnewrunnbr = strval(intval($tablern->wo_nbr)+1);
	    $newtemprunnbr = '';
	    if(strlen($tempnewrunnbr) < 4){
	      $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
	    }
        $runningnbr = $tablern->wo_prefix.'-'.$tablern->year.'-'.$newtemprunnbr;
        
        $dataarray = array(
            'wo_nbr'           => $runningnbr,
            'wo_dept'          => Session::get('department'),
            'wo_engineer1'     => $eng1,
            'wo_engineer2'     => $eng2,
            'wo_engineer3'     => $eng3,
            'wo_engineer4'     => $eng4,
            'wo_engineer5'     => $eng5,
            'wo_failure_code1' => $fn1,
            'wo_failure_code2' => $fn2,
            'wo_failure_code3' => $fn3,
            'wo_repair_code1'  => $req->crepaircode[0],
            'wo_repair_code2'  => $req->crepaircode[1],
            'wo_repair_code3'  => $req->crepaircode[2],
            'wo_repair_group'  => $req->crepairgroup,
            'wo_repair_type'   => $req->crepairtype,
            'wo_asset'         => $req->c_asset,
            'wo_priority'      => $req->c_priority,
            'wo_status'        => 'open',
            'wo_schedule'      => $req->c_schedule,
            'wo_duedate'       => $req->c_duedate,
            'wo_note'          => $req->c_note,
            'wo_creator'       => session()->get('username'),
            'wo_created_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_updated_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_type'          => $c_wotype
        );
        // dd($dataarray);
        if($c_wotype == 'auto'){
            $checkasset = DB::table('asset_mstr')
                            ->where('asset_code','=',$req->c_asset)
                            ->first();
            if($checkasset->asset_on_user == null){

                DB::table('wo_mstr')->insert($dataarray);

                DB::table('asset_mstr')
                ->where('asset_code','=',$req->c_asset)
                ->update(['asset_on_use' => $runningnbr]);
                
            }
            else{
                toast('Asset '.$req->c_asset.' has been used for PM','success');
                return back();
            }
        }
        else{
            DB::table('wo_mstr')->insert($dataarray);
        }
        
        DB::table('running_mstr')
        ->where('wo_nbr', '=', $tablern->wo_nbr)
        ->update([
            'wo_nbr' => $newtemprunnbr
        ]);
        $assettable = DB::table('asset_mstr')
            ->where('asset_code','=',$req->c_asset)
            ->first();
                
        $asset = $req->c_asset.' - '.$assettable->asset_desc;
        
        EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');

        toast('WO Successfuly Created !','success');
        return back();
    }

    public function editwodirect(Request $req){   
        // dd($req->all());
        $dataaccess = DB::table('wo_mstr')
                    ->where('wo_nbr','=', $req->e_nowo)
                    ->first();
        if($dataaccess->wo_access == 0){
            DB::table('wo_mstr')
                ->where('wo_nbr','=', $req->e_nowo)
                ->update(['wo_access' => 1]);   
        }
        else{
            toast('WO '.$req->e_nowo.' is being used right now', 'error');
            return redirect()->route('wocreatedirectmenu');
        }
        if($dataaccess->wo_status != 'open'){
            toast('WO '.$req->e_nowo.' status has changed, please recheck', 'error');
            return redirect()->route('wocreatedirectmenu');
        }
        $wonbr       = $req->e_nowo;
        $wosr        = $req->e_nosr;
        $woengineer1 = $req->e_engineerval;
        $woasset     = $req->e_asset;
        $woschedule  = $req->e_schedule;
        $woduedate   = $req->e_duedate;
        $wopriority  = $req->e_priority;
        $department  = $req->e_department;
            DB::table('wo_mstr')
            ->where('wo_nbr','=', $wonbr)
            ->update([
                'wo_engineer1'  => $woengineer1,
                'wo_priority'   => $wopriority,
                'wo_asset'      => $woasset,
                'wo_schedule'   => $woschedule,
                'wo_duedate'    => $woduedate,
                'wo_failure_code1' => $req->e_failure1,
                'wo_failure_code2' => $req->e_failure2,
                'wo_failure_code3' => $req->e_failure3,
                // 'wo_dept'       => $department,
                'wo_note'       => $req->e_note,
                'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_access' => 0
            ]);
            
            toast('WO successfully updated', 'success');
            return redirect()->route('wocreatedirectmenu');
        }

    public function editwoeng(Request $req){
        $dataaccess = DB::table('wo_mstr')
                    ->where('wo_nbr','=', $req->e_nowo)
                    ->first();
        if($dataaccess->wo_access == 0){
            DB::table('wo_mstr')
                ->where('wo_nbr','=', $req->e_nowo)
                ->update(['wo_access' => 1]);   
        }
        else{
            toast('WO '.$req->e_nowo.' is being used right now', 'error');
            return redirect()->route('wocreatemenu');
        }
        if($dataaccess->wo_status != 'open'){
            toast('WO '.$req->e_nowo.' status has changed, please recheck', 'error');
            return redirect()->route('wocreatedirectmenu');
        }
        // dd($req->all());
        $wonbr       = $req->e_nowo;
        $wosr        = $req->e_nosr;
        $woengineer1 = $req->e_engineerval;
        $woasset     = $req->e_asset;
        $woschedule  = $req->e_schedule;
        $woduedate   = $req->e_duedate;
        $wopriority  = $req->e_priority;
        $department  = $req->e_department;
            DB::table('wo_mstr')
            ->where('wo_nbr','=', $wonbr)
            ->update([
                'wo_engineer1'  => $woengineer1,
                'wo_priority'   => $wopriority,
                'wo_asset'      => $woasset,
                'wo_schedule'   => $woschedule,
                'wo_duedate'    => $woduedate,
                // 'wo_dept'       => $department,
                'wo_note'       => $req->e_note,
                'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_access'     => 0
            ]);
            
            toast('WO '.$req->e_nowo.' successfully updated', 'success');
            return redirect()->route('wocreatemenu');
        }

    public function editwo(Request $req){
        // dd($req->all());
        $dataaccess = DB::table('wo_mstr')
                    ->where('wo_nbr','=', $req->e_nowo)
                    ->first();
        // if($dataaccess->wo_access == 0){
        //     DB::table('wo_mstr')
        //         ->where('wo_nbr','=', $req->e_nowo)
        //         ->update(['wo_access' => 1]);   
        // }
        // else{
        //     toast('WO '.$req->e_nowo.' is being used right now', 'error');
        //     return redirect()->route('womaint');
        // }
        // if($dataaccess->wo_status != 'open'){
        //     toast('WO '.$req->e_nowo.' status has changed, please recheck', 'error');
        //     return redirect()->route('womaint');
        // }
        // dd($req->all());
        $wonbr       = $req->e_nowo;
        $wosr        = $req->e_nosr;
        $woengineer1 = $req->e_engineer1;
        $woengineer2 = $req->e_engineer2;
        $woengineer3 = $req->e_engineer3;
        $woengineer4 = $req->e_engineer4;
        $woengineer5 = $req->e_engineer5;
        $woasset     = $req->e_asset;
        $woschedule  = $req->e_schedule;
        $woduedate   = $req->e_duedate;
        $wopriority  = $req->e_priority;
        $department  = $req->e_department;
        $repairtype  = $req->erepairtype;
        $repairgroup = $req->erepairgroup;
        $rc1 = null;
        $rc2 = null;
        $rc3 = null;
        $fl1 = null;
        $fl2 = null;
        $fl3 = null;
        // dd($repairgroup,$repairtype);
        if(isset($req->erepaircode[0])){
            $rc1 = $req->erepaircode[0];
        }
        if(isset($req->erepaircode[1])){
            $rc2 = $req->erepaircode[1];
        }
        if(isset($req->erepaircode[2])){
            $rc3 = $req->erepaircode[2];
        }
        if(isset($req->e_failure1)){
            $fl1 = $req->e_failure1;
        }
        if(isset($req->e_failure2)){
            $fl2 = $req->e_failure2;
        }
        if(isset($req->e_failure3)){
            $fl3 = $req->e_failure3;
        }
            DB::table('wo_mstr')
            ->where('wo_nbr','=', $wonbr)
            ->update([
                'wo_engineer1'    => $woengineer1,
                'wo_engineer2'    => $woengineer2,
                'wo_engineer3'    => $woengineer3,
                'wo_engineer4'    => $woengineer4,
                'wo_engineer5'    => $woengineer5,
                'wo_priority'     => $wopriority,
                'wo_asset'        => $woasset,
                'wo_failure_code1' => $fl1,
                'wo_failure_code2' => $fl2,
                'wo_failure_code3' => $fl3,
                'wo_schedule'     => $woschedule,
                'wo_duedate'      => $woduedate,
                // 'wo_dept'         => $department,
                'wo_note'         => $req->e_note,
                'wo_repair_code1' => $rc1,
                'wo_repair_code2' => $rc2,
                'wo_repair_code3' => $rc3,
                'wo_repair_group' => $repairgroup,
                'wo_repair_type'  => $repairtype,
                'wo_updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_access'       => 0
            ]);
            
            toast('WO '.$req->e_nowo.' successfully updated', 'success');
            return redirect()->route('womaint');
        }
    

    public function closewo(Request $req){
        //dd($req->all());
        DB::table("wo_mstr")
            ->where('wo_nbr', '=', $req->tmp_wonbr)
            ->update(['wo_status' => 'delete',
            'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            ]);
        DB::table("service_req_mstr")
            ->where('wo_number', '=', $req->tmp_wonbr)
            ->update(['sr_status' => 4,
            'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            ]);

        //session()->flash('updated', 'User berhasil dihapus');
        toast('Work Order '.$req->tmp_wonbr.' Successfuly deleted!','success');
        return back();
    }


    public function wopaging(Request $req){
        // dd($req->all());
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            $engineer    = $req->get('woengineer');

            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $engineer =='') {
                // dd('aaa');        
                $data = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                        ->orderby($sort_by, $sort_type)
                        ->orderBy('wo_mstr.wo_id', 'desc')
                        ->paginate(10);

                // dd($data);
                    return view('workorder.table-wobrowse', ['data' => $data,'usernow' =>$usernow]);
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
                }
                if ($engineer != ''){
                    $kondisi .= " and (wo_engineer1 = '". $engineer . "' or wo_engineer2 = '".$engineer."' or wo_engineer3 = '".$engineer."' or wo_engineer4 = '".$engineer."' or wo_engineer5 = '".$engineer."')";
                }
                // if($period != ''){
                //     if($period == '1'){
                //         $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                //     }
                //     else if($period == '2'){
                //         $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                //     }
                //     else if($period == '3'){
                //         $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                //     }
                // }
                
                // dd($kondisi);
                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->whereRaw($kondisi)
                    ->orderBy($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-wobrowse', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }

    public function wopagingview(Request $req){
        // dd('aaa');
        // dd($req->all());
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            $engineer    = $req->get('woengineer');
            $creator   = $req->get('wocreator');
            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $engineer =='' and $creator == '') {
                        $data = DB::table('wo_mstr')
                            ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                            ->orderby($sort_by, $sort_type)
                            ->orderBy('wo_mstr.wo_id', 'desc')
                            ->distinct('wo_nbr')
                            ->paginate(10);
                   
                
                    return view('workorder.table-woview', ['data' => $data,'usernow' =>$usernow]);
            } else {
                // dd($creator);
                $kondisi = "wo_mstr.wo_id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_code = '" . $asset . "'";
                }if ($status != '') {
                    $kondisi .= " and wo_status = '" . $status . "'";
                }if ($priority != ''){
                    $kondisi .= " and (wo_priority = '". $priority . "'";
                }if($creator != ''){
                    $kondisi .= " and wo_creator = '". $creator . "'";
                }
                if ($engineer != ''){
                    $kondisi .= " and (wo_engineer1 = '". $engineer . "' or wo_engineer2 = '".$engineer."' or wo_engineer3 = '".$engineer."' or wo_engineer4 = '".$engineer."' or wo_engineer5 = '".$engineer."')";
                }
                // if($period != ''){
                //     if($period == '1'){
                //         $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) . "'";
                //     }
                //     else if($period == '2'){
                //         $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "'AND '".Carbon::today()->subDay(5)."'";
                //     }
                //     else if($period == '3'){
                //         $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) . "'";
                //     }
                // }
                
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
                    return view('workorder.table-woview', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }

    public function wopagingcreate(Request $req){
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
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

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period =='') {
                        $data = DB::table('wo_mstr')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->where('wo_creator','=',session()->get('username'))
                            ->where('wo_status','=','plan')
                            ->orderby($sort_by, $sort_type)
                            ->orderBy('wo_mstr.wo_id', 'desc')
                            ->paginate(10);
                //    dd('aaa');
                
                    return view('workorder.table-wocreate', ['data' => $data,'usernow' =>$usernow]);
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
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->whereRaw($kondisi)
                    ->where('wo_creator','=',session()->get('username'))
                    ->orderBy($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(10);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-wocreate', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }
    public function wopagingcreatedirect(Request $req){
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
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

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $period =='') {
                $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->where('wo_type','=','direct')
                ->where('wo_status','=','open')
                ->where('wo_engineer1','=',Session()->get('username'))
                ->orderby($sort_by,$sort_type)
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(10);
                   
                
                    return view('workorder.table-wocreatedirect', ['data' => $data,'usernow' =>$usernow]);
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
                $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->whereRaw($kondisi)
                ->where('wo_type','=','direct')
                ->where('wo_status','=','open')
                ->where('wo_engineer1','=',Session()->get('username'))
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(10);
                // dd($kondisi);    
                // $data = DB::table('wo_mstr')
                //     ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                //     ->whereRaw($kondisi)
                //     ->orderBy($sort_by, $sort_type)
                //     ->orderBy('wo_mstr.wo_id', 'desc')
                //     ->paginate(10);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-wocreatedirect', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }
    public function wopagingstart(Request $req){
        // dd('aaa');
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            // $period    = $req->get('woperiod');

            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' ) {
                        
                            $data = DB::table('wo_mstr')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->where(function($status){
                                $status->where('wo_status','=','open')
                                ->orwhere('wo_status','=','started');
                            })
                            ->where(function($query){
                                $query->where('wo_engineer1','=',Session()->get('username'))
                                ->orwhere('wo_engineer2','=',Session()->get('username'))
                                ->orwhere('wo_engineer3','=',Session()->get('username'))
                                ->orwhere('wo_engineer4','=',Session()->get('username'))
                                ->orwhere('wo_engineer5','=',Session()->get('username'));
                            })
                            ->orderby('wo_created_at','desc')
                            ->orderBy('wo_mstr.wo_id', 'desc')
                            ->paginate(10);
                
                    return view('workorder.table-wostart', ['data' => $data,'usernow' =>$usernow]);
            } else {
                $kondisi = "wo_mstr.wo_id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_code = '" . $asset . "'";
                }if ($status != '') {
                    $kondisi .= " and wo_status ='".$status."'";
                }
                else{
                    $kondisi .= " and (wo_status = 'open' or wo_status = 'started')";
                }if ($priority != ''){
                    $kondisi .= " and wo_priority = '". $priority . "'";
                }
                
                // dd($kondisi);
                // $data = DB::table('wo_mstr')
                //     ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
                //     ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                //     ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                //     ->whereRaw($kondisi)
                //     ->orderBy($sort_by, $sort_type)
                //     ->orderBy('wo_mstr.wo_id', 'desc')
                //     ->distinct('wo_nbr')
                //     ->paginate(10);
                $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->whereRaw($kondisi)
                ->where(function($query){
                    $query->where('wo_engineer1','=',Session()->get('username'))
                    ->orwhere('wo_engineer2','=',Session()->get('username'))
                    ->orwhere('wo_engineer3','=',Session()->get('username'))
                    ->orwhere('wo_engineer4','=',Session()->get('username'))
                    ->orwhere('wo_engineer5','=',Session()->get('username'));
                })
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                
                ->paginate(10);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-wostart', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }
    public function wopagingreport(Request $req){
        // dd('aaa');
        //   dd($req->get('woperiod'));
        //  dd(Carbon::today()->subDay(2));
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            // $period    = $req->get('woperiod');

            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' ) {
                        
                            $data = DB::table('wo_mstr')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->where(function($status){
                                $status->where('wo_status','=','started')
                                ->orwhere('wo_status','=','finish');
                            })
                            ->where(function($query){
                                $query->where('wo_engineer1','=',Session()->get('username'))
                                ->orwhere('wo_engineer2','=',Session()->get('username'))
                                ->orwhere('wo_engineer3','=',Session()->get('username'))
                                ->orwhere('wo_engineer4','=',Session()->get('username'))
                                ->orwhere('wo_engineer5','=',Session()->get('username'));
                            })
                            ->orderby('wo_created_at','desc')
                            ->orderBy('wo_mstr.wo_id', 'desc')
                            ->paginate(10);
                
                    return view('workorder.table-woclose', ['data' => $data,'usernow' =>$usernow]);
            } else {
                $kondisi = "wo_mstr.wo_id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                }
                if ($asset != '') {
                    $kondisi .= " and wo_asset = '" . $asset . "'";
                }if ($status != '') {
                    $kondisi .= " and wo_status = '".$status."'";
                }
                else{
                    $kondisi .= " and (wo_status = 'started' or wo_status = 'finish')";
                }
                if ($priority != ''){
                    $kondisi .= " and wo_priority = '". $priority . "'";
                }
                // DD($kondisi);
                // dd($kondisi);
                // dd($kondisi);
                // $data = DB::table('wo_mstr')
                //     ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
                //     ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                //     ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                //     ->whereRaw($kondisi)
                //     ->orderBy($sort_by, $sort_type)
                //     ->orderBy('wo_mstr.wo_id', 'desc')
                //     ->distinct('wo_nbr')
                //     ->paginate(10);
                $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->whereRaw($kondisi)
                ->where(function($query){
                    $query->where('wo_engineer1','=',Session()->get('username'))
                    ->orwhere('wo_engineer2','=',Session()->get('username'))
                    ->orwhere('wo_engineer3','=',Session()->get('username'))
                    ->orwhere('wo_engineer4','=',Session()->get('username'))
                    ->orwhere('wo_engineer5','=',Session()->get('username'));
                })
                ->orderBy('wo_status','desc')
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(10);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-woclose', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }
    public function geteditwo(Request $req){
            //dd($req->get('nomorwo'));
            // dd('aaa');
            $nowo = $req->get('nomorwo');
			$currwo = DB::table('wo_mstr')
					->where('wo_mstr.wo_nbr','=',$nowo)
					->first();
						
            $data = DB::table('wo_mstr')
                ->selectRaw('wo_type,wo_nbr,wo_reviewer_appdate,wo_approver_appdate,wo_repair_type,wo_repair_group,xxrepgroup_nbr,xxrepgroup_desc,wo_status,asset_desc,wo_approval_note,wo_creator,wo_reject_reason,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, wo_mstr.wo_failure_code1 as wofc1, wo_mstr.wo_failure_code2 as wofc2, wo_mstr.wo_failure_code3 as wofc3, fn1.fn_desc as fd1, fn2.fn_desc as fd2, fn3.fn_desc as fd3,r1.repm_desc as r11,r2.repm_desc as r22,r3.repm_desc as r33,r1.repm_code as rr11,r2.repm_code as rr22,r3.repm_code as rr33, wo_finish_date,wo_finish_time,wo_repair_hour,asset_last_mtc,asset_last_usage_mtc,asset_measure')
                ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->leftjoin('fn_mstr as fn1','wo_mstr.wo_failure_code1','fn1.fn_code')
                ->leftjoin('fn_mstr as fn2','wo_mstr.wo_failure_code2','fn2.fn_code')
                ->leftjoin('fn_mstr as fn3','wo_mstr.wo_failure_code3','fn3.fn_code')
                ->leftjoin('rep_master as r1','wo_mstr.wo_repair_code1','r1.repm_code')
                ->leftjoin('rep_master as r2','wo_mstr.wo_repair_code2','r2.repm_code')
                ->leftjoin('rep_master as r3','wo_mstr.wo_repair_code3','r3.repm_code')
                ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                ->leftjoin('xxrepgroup_mstr','xxrepgroup_mstr.xxrepgroup_nbr','wo_mstr.wo_repair_group')
                ->where('wo_mstr.wo_nbr','=',$nowo)
                ->get();
                // dd($data);
			// dd($data);
            return $data;
    }


    public function approvewo(Request $req){
        // dd($req->all());
        $dataaccess = DB::table('wo_mstr')
                    ->where('wo_nbr','=', $req->aprwonbr)
                    ->first();
                    
        if($dataaccess->wo_access == 0){
            DB::table('wo_mstr')
                ->where('wo_nbr','=', $req->aprwonbr)
                ->update(['wo_access' => 1]);   
        }
        else{
            toast('WO '.$req->aprwonbr.' is being used right now', 'error');
            return redirect()->route('womaint');
        }
        if($dataaccess->wo_status != 'plan'){
            toast('WO '.$req->aprwonbr.' status has changed, please recheck', 'error');
            return redirect()->route('womaint');
        }
        if($req->switch =='approve'){
            // dd($req->all());
            if($req->repairtypeapp == 'auto'){
                DB::table('wo_mstr')
                ->where('wo_nbr',$req->aprwonbr)
                ->update([
                    'wo_status'=>'open',
                    'wo_approver' => Session::get('username'),
                    'wo_access'     => 0
                ]);
                toast('Work order '.$req->aprwonbr.' approved successfuly', 'success');
                return redirect()->route('womaint');
            }
            else{
                $exprc = explode(',',$req->repaircodeapp);
                $exprg = $req->repairgroupapp;
                $exprt = $req->repairtype;
                // dd(count($teets));
                
                $countexprc = count($exprc); 
                $rc1 = null;
                $rc2 = null;
                $rc3 = null;
                if(isset($exprc[0])){
                    $rc1 = $exprc[0];
                }
                if(isset($exprc[1])){
                    $rc2 = $exprc[1];
                }
                if(isset($exprc[2])){
                    $rc3 = $exprc[2];
                }
                DB::table('wo_mstr')
                ->where('wo_nbr',$req->aprwonbr)
                ->update([
                    'wo_status'=>'open',
                    'wo_repair_code1' =>$rc1,
                    'wo_repair_code2'=>$rc2,
                    'wo_repair_code3'=>$rc3,
                    'wo_repair_group'=>$exprg,
                    'wo_repair_type'=>$exprt,
                    'wo_approver' => Session::get('username'),
                    'wo_access'     => 0
                    ]);

                toast('Work order '.$req->aprwonbr.' approved successfuly', 'success');
                return redirect()->route('womaint');
                }
            }
        else{
            DB::table('wo_mstr')
            ->where('wo_nbr',$req->aprwonbr)
            ->update(['wo_status'=>'closed']);
            toast('Work order '.$req->aprwonbr.' has been rejected', 'success');
            return redirect()->route('womaint');
        }    
    }

    public function getfailure(Request $req){
        
        
            //dd($req->get('nomorwo'));
            $asswo = $req->get('asset');
            $asset2 = DB::table('asset_mstr')
                    ->where('asset_mstr.asset_code','=',$asswo)
                    ->first();
            
            $failure = DB::table('fn_mstr')
                ->selectRaw('fn_code,fn_desc')
                ->where(function($query) use($asset2){
                    $query->where('fn_mstr.fn_assetgroup','=',$asset2->asset_group)
                    ->orwhere('fn_assetgroup','=',null);
                })
                ->get();
                
            return $failure;
    }
    

    public function wojoblist(Request $req){
        //dd(Session()->get('username'));
        if (strpos(Session::get('menu_access'), 'WO02') !== false) {
            $getuser = DB::table('users')
                    ->where('username','=',Session()->get('username'))
                    ->first();

            //  if($getuser->role_user == 'ADM'){
            //     $data = DB::table('wo_mstr')
            //     ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
            //     ->where(function($status){
            //         $status->where('wo_status','=','open')
            //         ->orwhere('wo_status','=','started');
            //     })
            //     ->orderby('wo_created_at','desc')
            //     ->orderBy('wo_mstr.wo_id', 'desc')
            //     ->paginate(10);
            //  }   
            //  else{    
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->where(function($status){
                    $status->where('wo_status','=','open')
                    ->orwhere('wo_status','=','started');
                })
                ->where(function($query){
                    $query->where('wo_engineer1','=',Session()->get('username'))
                    ->orwhere('wo_engineer2','=',Session()->get('username'))
                    ->orwhere('wo_engineer3','=',Session()->get('username'))
                    ->orwhere('wo_engineer4','=',Session()->get('username'))
                    ->orwhere('wo_engineer5','=',Session()->get('username'));
                })
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(10);
                // dd($data);
            // }
                // dd($data);
            $engineer = DB::table('users')
                    ->join('roles','users.role_user','roles.role_code')
                    ->where('role_desc','=','Engineer')
                    ->get();
            $asset = DB::table('wo_mstr')
                    ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                    ->join('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->where(function($status){
                        $status->where('wo_status','=','open')
                        ->orwhere('wo_status','=','started');
                       
                    })
                    ->where(function($query){
                        $query->where('wo_engineer1','=',Session()->get('username'))
                        ->orwhere('wo_engineer2','=',Session()->get('username'))
                        ->orwhere('wo_engineer3','=',Session()->get('username'))
                        ->orwhere('wo_engineer4','=',Session()->get('username'))
                        ->orwhere('wo_engineer5','=',Session()->get('username'));
                    })
                    ->groupBy('asset_code')
                    ->get();
            if($req->ajax()){
                return view('workorder.table-wostart', ['data' => $data]);
            }
            else{
                return view('workorder.wostart', ['data' => $data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset]);
            }
            
        } else {
            toast('you dont have access, please contact admin', 'error');
            return back();
        }
    }
    public function editjob(Request $req){
        // dd($req->all());
        $dataaccess = DB::table('wo_mstr')
                    ->where('wo_nbr','=', $req->v_nowo)
                    ->first();
        if($dataaccess->wo_access == 0){
            DB::table('wo_mstr')
                ->where('wo_nbr','=', $req->v_nowo)
                ->update(['wo_access' => 1]);   
        }
        else{
            toast('WO '.$req->v_nowo.' is being used right now', 'error');
            return redirect()->route('wojoblist');
        }
        if($dataaccess->wo_status != $req->statuswo){
            toast('WO '.$req->v_nowo.' status has changed, please recheck', 'error');
            return redirect()->route('wojoblist');
        }
        $statuswo = $req->statuswo;
        $nomorwo = $req->v_nowo;
        //dd($req->all());
        if($statuswo =='open'){
            DB::table('wo_mstr')
            ->where('wo_nbr','=',$nomorwo)
            ->update([
                'wo_status' => 'started',
                'wo_start_date' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                'wo_start_time' => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                'wo_access'     => 0
            ]);
            if($req->v_nosr != null || $req->v_nosr != ''){
                DB::table('service_req_mstr')
                ->where('wo_number','=',$nomorwo)
                ->update([
                    'sr_status' => 3,
                    'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                ]); 
            }
            toast('Work order '.$nomorwo.' started successfuly', 'success');
            return redirect()->route('wojoblist');
        
        }
        else if($statuswo == 'started'){
            DB::table('wo_mstr')
            ->where('wo_nbr','=',$nomorwo)
            ->update([
                'wo_status' => 'open',
                'wo_start_date' => null,
                'wo_start_time' => null,
                'wo_access'     => 0
            ]);
            if($req->v_nosr != null || $req->v_nosr != ''){
                DB::table('service_req_mstr')
                ->where('wo_number','=',$nomorwo)
                ->update([
                    'sr_status' => 2,
                    'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                ]); 
            }

            $data = DB::table('eng_mstr')
                    ->join('users','eng_mstr.eng_code','=','users.username')
                    ->where('approver','=','1')
                    ->get();
                        // dd($data);
            foreach($data as $data){
            $user = App\User::where('id','=', $data->id)->first(); 
            
            $details = [
                        'body' => 'WO has been abandoned by '.session::get('username'),
                        'url' => 'womaint',
                        'nbr' => $nomorwo,
                        'note' => 'Please check'
                    ]; // isi data yang dioper
                
                
                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel
        }
    
        toast('Work order '.$nomorwo.' has been abandoned', 'success');
        return redirect()->route('wojoblist');
        
        //dd($statuswo);
        }
    }

    public function wocloselist(){
        
        //dd(Session()->get('username'));
        if (strpos(Session::get('menu_access'), 'WO03') !== false) {
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->where(function($status){
                    $status->where('wo_status','=','started')
                    ->orwhere('wo_status','=','finish');
                   
                })
                ->where(function($query){
                    $query->where('wo_engineer1','=',Session()->get('username'))
                    ->orwhere('wo_engineer2','=',Session()->get('username'))
                    ->orwhere('wo_engineer3','=',Session()->get('username'))
                    ->orwhere('wo_engineer4','=',Session()->get('username'))
                    ->orwhere('wo_engineer5','=',Session()->get('username'));
                })
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(10);
            $engineer = DB::table('users')
                    ->join('roles','users.role_user','roles.role_code')
                    ->where('role_desc','=','Engineer')
                    ->get();
            $asset = DB::table('wo_mstr')
                    ->selectRaw('MIN(asset_desc) as asset_desc, MIN(asset_code) as asset_code')
                    ->join('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->where(function($status){
                        $status->where('wo_status','=','started')
                        ->orwhere('wo_status','=','finish');
                       
                    })
                    ->where(function($query){
                        $query->where('wo_engineer1','=',Session()->get('username'))
                        ->orwhere('wo_engineer2','=',Session()->get('username'))
                        ->orwhere('wo_engineer3','=',Session()->get('username'))
                        ->orwhere('wo_engineer4','=',Session()->get('username'))
                        ->orwhere('wo_engineer5','=',Session()->get('username'));
                    })
                    ->groupBy('asset_code')
                    ->get();
            $repaircode = DB::table('rep_master')
                        ->get();

            $sparepart = DB::table('sp_mstr')
                        ->get();
            $repairgroup = DB::table('xxrepgroup_mstr')
                        ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                        ->distinct('xxrepgroup_nbr')
                        ->get();
            return view('workorder.woclose', ['data' => $data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'repaircode'=>$repaircode,'sparepart'=>$sparepart,'repairgroup'=>$repairgroup]);
        } else {
            toast('you dont have access, please contact admin', 'error');
            return back();
        }
    }
    public function reportingwo(Request $req){
        // dd($req->all());
        $dataaccess = DB::table('wo_mstr')
                    ->where('wo_nbr','=', $req->c_wonbr)
                    ->first();
        if($dataaccess->wo_access == 0){
            DB::table('wo_mstr')
                ->where('wo_nbr','=', $req->c_wonbr)
                ->update(['wo_access' => 1,
                    'wo_access_user' => session::get('username')]);   
        }
        else{
            if($dataaccess->wo_access_user != session::get('username')){
                toast('WO '.$req->c_wonbr.' is being used right now', 'error');
                return redirect()->route('woreport');
            }
        }
        if($dataaccess->wo_status == 'finish'){
            toast('WO '.$req->c_wonbr.' status has changed, please refresh page', 'error');
            return redirect()->route('woreport');
        }
        if($req->repairpartnow == 'auto'){
            // dd($req->all());
            $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
            $arrayy = [
                    'wo_updated_at'    =>Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_status'        => 'finish',
                    'wo_repair_hour'   => $req->c_repairhour,
                    'wo_finish_date'   => $req->c_finishdate,
                    'wo_finish_time'   => $finisht,
                    'wo_approval_note' => $req->c_note,
                    'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                    'wo_access'        => 0,
                    'wo_access_user'   => null,
                ];
                DB::table('wo_mstr')->where('wo_nbr','=',$req->c_wonbr)->update($arrayy);
                if($req->assettype == 'M'){
                    $increment = DB::table('asset_mstr')
                                 ->where('asset_code','=',$req->c_assethidden)
                                 ->first();
                    $lastusage = $increment->asset_last_usage;
                    $assetmeter = $increment->asset_meter;
                    $assetlastmt = $increment->asset_last_usage_mt;
                    $newlastusage = $lastusage + $assetmeter;
                    DB::table('asset_mstr')
                    ->where('asset_code','=',$req->c_assethidden)
                    ->update(['asset_on_use' => null,
                        'asset_last_usage' => $req->c_lastmeasurement,
                        'asset_last_mtc' => $req->c_finishdate]);
                }
                else if($req->assettype == 'C'){
                    DB::table('asset_mstr')
                    ->where('asset_code','=',$req->c_assethidden)
                    ->update(['asset_on_use' => null,
                        'asset_last_mtc' => $req->c_finishdate]);
                }
                
                $albumraw = $req->imgname;
        
                // dd($albumraw);
                $k = 0;
                if(isset($req->imgname)){
                    foreach($albumraw as $olah1){
                        $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                        // dd($waktu);
                        $jadi1 = explode(',', $olah1);
                        // a..png
                        $jadi2 = base64_decode($jadi1[2]);
                        $lenstr = strripos($jadi1[0],'.');
                        $test = substr($jadi1[0],$lenstr);
                        // dd($test);
                        $test3 = str_replace($test,'',$jadi1[0]);
                        // dd($test3);
                        $test4 = str_replace('.','',$test3);
                        $test44 = str_replace(' ','',$test4);
                        $test5 = $test44.$waktu.$test;
                        
                        $alamaturl = '../public/upload/'.$test5;
                        file_put_contents($alamaturl, $jadi2);

                        DB::table('acceptance_image')
                            ->insert([
                                'file_srnumber' => $req->c_srnbr,
                                'file_wonumber' => $req->c_wonbr,
                                'file_name' => $jadi1[0], //nama file asli
                                'file_url' => $alamaturl, 
                                'uploaded_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        // $k++;

                    }
                }
                
                toast('data reported successfuly', 'success');
                return redirect()->route('woreport');

            
        }
        else{
            if ($req->repairtype == 'manual'){
                DB::table('wo_manual_detail')
                        ->where('wo_manual_wo_nbr','=',$req->c_wonbr)
                        ->delete();
                for($pop = 0; $pop <count($req->number);$pop++){
                    if($req->part[$pop] != null && $req->desc[$pop] != null){
                        $arraymanual = array([
                            'wo_manual_wo_nbr'      => $req->c_wonbr,
                            'wo_manual_number'      => $req->number[$pop],
                            'wo_manual_part'        => $req->part[$pop],
                            'wo_manual_desc'        => $req->desc[$pop],
                            'wo_manual_flag'        => $req->group4[$pop],
                            'wo_manual_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                           ]);
                            // dd($arraydettemp);
                            DB::table('wo_manual_detail')->insert($arraymanual);
                    } 
                }
                $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
                $arrayy = [
                    'wo_updated_at'    =>Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_status'        => 'finish',
                    'wo_repair_code1'  => null,
                    'wo_repair_code2'  => null,
                    'wo_repair_code3'  => null,
                    'wo_repair_group'  => null,
                    'wo_repair_type'   => 'manual',
                    'wo_repair_hour'   => $req->c_repairhour,
                    'wo_finish_date'   => $req->c_finishdate,
                    'wo_finish_time'   => $finisht,
                    'wo_approval_note' => $req->c_note,
                    'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                    'wo_access'        => 0
                ];
                DB::table('wo_mstr')->where('wo_nbr','=',$req->c_wonbr)->update($arrayy);
                $albumraw = $req->imgname;

                if(isset($req->imgname)){
                    foreach($albumraw as $olah1){
                        $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                        // dd($waktu);
                        $jadi1 = explode(',', $olah1);
                        // a..png
                        $jadi2 = base64_decode($jadi1[2]);
                        $lenstr = strripos($jadi1[0],'.');
                        $test = substr($jadi1[0],$lenstr);
                        // dd($test);
                        $test3 = str_replace($test,'',$jadi1[0]);
                        // dd($test3);
                        $test4 = str_replace('.','',$test3);
                        $test44 = str_replace(' ','',$test4);
                        $test5 = $test44.$waktu.$test;
                        $alamaturl = '../public/upload/'.$test5;
                        file_put_contents($alamaturl, $jadi2);

                        DB::table('acceptance_image')
                            ->insert([
                                'file_srnumber' => $req->c_srnbr,
                                'file_wonumber' => $req->c_wonbr,
                                'file_name' => $jadi1[0], //nama file asli
                                'file_url' => $alamaturl, 
                                'uploaded_at' => Carbon::now()->toDateTimeString(),
                            ]);
                    }
                }
                if($req->c_srnbr != null){
                    DB::table('service_req_mstr')->where('wo_number','=',$req->c_wonbr)->update(['sr_status' => '4','sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toTimeString()]);
                }
                toast('data reported successfuly', 'success');
                return redirect()->route('woreport');
            }
            
            else if($req->repairtype == 'code'){
                $rc1 = null;
                $rc2 = null;
                $rc3 = null;
               
                DB::table('wo_rc_detail')
                ->where('wrd_wo_nbr','=',$req->c_wonbr)
                ->delete();
                
                if($req->has('repaircode1')){
                    $rc1 = $req->repaircode1[0];
                    
                    $dborigin = DB::table('rep_master')
                        ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                        ->join('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                        // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                        ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                        ->where('rep_master.repm_code','=',$rc1)
                        // ->groupBy('spt_code')
                        ->orderBy('repdet_step')
                        ->get();
                    $countdb1 = count($dborigin);
                    
                    $flagname = '';
                    for($i = 0; $i<$countdb1;$i++){
                        $newname = 'group'.$i;
                        if(isset($req->group1[$newname])){
                        $flagname .= $req->group1[$newname];
                        }
                    }
                    // dd($flagname);
                    $arrayrc1 = array([
                        'wrd_wo_nbr'      => $req->c_wonbr,
                        'wrd_repair_code' => $req->repaircode1[0],
                        'wrd_flag'        => $flagname,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc1);
                }
                if($req->has('repaircode2')){
                    $rc2 = $req->repaircode2[0];
                    $dborigin2 = DB::table('rep_master')
                        ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                        ->join('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                        // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                        ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                        ->where('rep_master.repm_code','=',$rc2)
                        ->orderBy('repdet_step')
                        ->get();

                    $countdb2 = count($dborigin2);
                    // dd($req->all)
                    $flagname2 = '';
                    // dd($countdb2);
                    for($i = 0; $i<$countdb2;$i++){
                        $newname2 = 'group'.$i;
                        // dd($newname2);
                        if(isset($req->group2[$newname2])){
                            $flagname2 .= $req->group2[$newname2];
                            
                        }
                    }

                    
                    $arrayrc2 = array([
                        'wrd_wo_nbr'      => $req->c_wonbr,
                        'wrd_repair_code' => $req->repaircode2[0],
                        'wrd_flag'        => $flagname2,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc2);
                   }
                    // dd($flagname);
                    
                
            
                if($req->has('repaircode3')){
                    $rc3 = $req->repaircode3[0];
                    $dborigin3 = DB::table('rep_master')
                    ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                    ->join('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                    // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                    ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                    ->where('rep_master.repm_code','=',$rc3)
                    // ->groupBy('spt_code')
                    ->orderBy('repdet_step')
                    ->get();
                    $countdb3 = count($dborigin3);
                    
                    $flagname = '';
                    for($i = 0; $i<$countdb3;$i++){
                        $newname = 'group'.$i;
                        if(isset($req->group3[$newname])){
                            $flagname .= $req->group3[$newname];
                        }
                    }
                    $arrayrc3 = array([
                        'wrd_wo_nbr'      => $req->c_wonbr,
                        'wrd_repair_code' => $req->repaircode3[0],
                        'wrd_flag'        => $flagname,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc3);
                   }
               
            
                //  dd($req->all());
                $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
                // dd($finisht);
                $arrayy = [
                    'wo_updated_at'    =>Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_status'        => 'finish',
                    'wo_repair_code1'  => $rc1,
                    'wo_repair_code2'  => $rc2,
                    'wo_repair_code3'  => $rc3,
                    'wo_repair_group'  => null,
                    'wo_repair_type'   => 'code',
                    'wo_repair_hour'   => $req->c_repairhour,
                    'wo_finish_date'   => $req->c_finishdate,
                    'wo_finish_time'   => $finisht,
                    'wo_approval_note' => $req->c_note,
                    'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                    'wo_access'        => 0
                ];
                DB::table('wo_mstr')->where('wo_nbr','=',$req->c_wonbr)->update($arrayy);
                $albumraw = $req->imgname;
        
                // dd($albumraw);
                $k = 0;
                if(isset($req->imgname)){
                    foreach($albumraw as $olah1){
                        $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                        // dd($waktu);
                        $jadi1 = explode(',', $olah1);
                        // a..png
                        $jadi2 = base64_decode($jadi1[2]);
                        $lenstr = strripos($jadi1[0],'.');
                        $test = substr($jadi1[0],$lenstr);
                        // dd($test);
                        $test3 = str_replace($test,'',$jadi1[0]);
                        // dd($test3);
                        $test4 = str_replace('.','',$test3);
                        $test44 = str_replace(' ','',$test4);
                        $test5 = $test44.$waktu.$test;
                        // dd($test5);

                        // dd($test2);

                        // dd(substr($jadi1[0],$lenstr));
                        // dd(strlen($jadi1[0]));

                        // $test = preg_replace('/.(?=.*,)/','',$jadi1[0]);
                        //  $test2 = explode('.',$test);
                        // $test2 = 
                        // dd($test);
                        $alamaturl = '../public/upload/'.$test5;
                        file_put_contents($alamaturl, $jadi2);

                        DB::table('acceptance_image')
                            ->insert([
                                'file_srnumber' => $req->c_srnbr,
                                'file_wonumber' => $req->c_wonbr,
                                'file_name' => $jadi1[0], //nama file asli
                                'file_url' => $alamaturl, 
                                'uploaded_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        // $k++;

                    }
                }
                if($req->c_srnbr != null){
                    DB::table('service_req_mstr')->where('wo_number','=',$req->c_wonbr)->update(['sr_status' => '4','sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toTimeString()]);
                }
                toast('data reported successfuly', 'success');
                return redirect()->route('woreport');

            
                // dd($arrayy);
            }
            else if($req->repairtype == 'group'){
                        
                DB::table('wo_rc_detail')
                ->where('wrd_wo_nbr','=',$req->c_wonbr)
                ->delete();

                $repairlen = count($req->repaircodeselection);
                for($i = 0; $i<$repairlen; $i++){
                    $rg = $req->repaircodeselection[$i];
                    $dborigin = DB::table('rep_master')
                                ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                ->join('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                                // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                                ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                                ->where('rep_master.repm_code','=',$rg)
                                // ->groupBy('spt_code')
                                ->orderBy('repdet_step')
                                ->get();
                    $countdb1 = count($dborigin);
                    // dd($dborigin);
                    $flagname = '';
                    for($j = 0; $j<$countdb1;$j++){
                        $newname = 'group'.$i;
                        if(isset($req->group4[$i][$j])){
                            $flagname .= $req->group4[$i][$j];
                        }
                    }

                    
                    $arrayrc1 = array([
                        'wrd_wo_nbr'      => $req->c_wonbr,
                        'wrd_repair_code' => $rg,
                        'wrd_flag'        => $flagname,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                        // dd($arraydettemp);
                        DB::table('wo_rc_detail')->insert($arrayrc1);
                    // dd($flagname);
                }
                $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
                // dd($finisht);
                $arrayy = [
                    'wo_updated_at'    =>Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_status'        => 'finish',
                    'wo_repair_code1'  => null,
                    'wo_repair_code2'  => null,
                    'wo_repair_code3'  => null,
                    'wo_repair_group'  => $req->repairgroup[0],
                    'wo_repair_type'   => 'group',
                    'wo_repair_hour'   => $req->c_repairhour,
                    'wo_finish_date'   => $req->c_finishdate,
                    'wo_finish_time'   => $finisht,
                    'wo_approval_note' => $req->c_note,
                    'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                    'wo_access'        => 0
                ];
                DB::table('wo_mstr')->where('wo_nbr','=',$req->c_wonbr)->update($arrayy);
                $albumraw = $req->imgname;
        
                // dd($albumraw);
                $k = 0;
                if(isset($req->imgname)){
                    foreach($albumraw as $olah1){
                        $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                        // dd($waktu);
                        $jadi1 = explode(',', $olah1);
                        // a..png
                        $jadi2 = base64_decode($jadi1[2]);
                        $lenstr = strripos($jadi1[0],'.');
                        $test = substr($jadi1[0],$lenstr);
                        // dd($test);
                        $test3 = str_replace($test,'',$jadi1[0]);
                        // dd($test3);
                        $test4 = str_replace('.','',$test3);
                        $test44 = str_replace(' ','',$test4);
                        $test5 = $test44.$waktu.$test;
                        // dd($test5);

                        // dd($test2);

                        // dd(substr($jadi1[0],$lenstr));
                        // dd(strlen($jadi1[0]));

                        // $test = preg_replace('/.(?=.*,)/','',$jadi1[0]);
                        //  $test2 = explode('.',$test);
                        // $test2 = 
                        // dd($test);
                        $alamaturl = '../public/upload/'.$test5;
                        file_put_contents($alamaturl, $jadi2);

                        DB::table('acceptance_image')
                            ->insert([
                                'file_srnumber' => $req->c_srnbr,
                                'file_wonumber' => $req->c_wonbr,
                                'file_name' => $jadi1[0], //nama file asli
                                'file_url' => $alamaturl, 
                                'uploaded_at' => Carbon::now()->toDateTimeString(),
                            ]);

                        // $k++;

                    }
                }
                if($req->c_srnbr != null){
                    DB::table('service_req_mstr')->where('wo_number','=',$req->c_wonbr)->update(['sr_status' => '4','sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toTimeString()]);
                }
                toast('data reported successfuly', 'success');
                return redirect()->route('woreport');
                // dd($arrayy);
            }   
        }
    }
        
    // public function reopenwo(Request $req){
        
        //     $dwonbr = $req->get('tmp_rowonbr');
        //     DB::table('wo_mstr')
        //     ->where('wo_nbr','=',$dwonbr)
        //     ->update([
        //         'wo_start_date'  => null,
        //         'wo_start_time'  => null,
        //         'wo_finish_date' => null,
        //         'wo_finish_time' => null,
        //         'wo_repair_code1' => null,
        //         'wo_repair_code2' => null,
        //         'wo_repair_code3' => null,
        //         'wo_repair_hour' => null,
        //         'wo_system_date' => null,
        //         'wo_system_time' => null,
        //         'wo_status' => 'open',  
        //         'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString()      
        //         ]);
        //     DB::table('wo_detail')
        //     ->where('detail_wo_nbr','=',$dwonbr)
        //     ->delete();
        //     DB::table("service_req_mstr")
        //         ->where('wo_number', '=', $req->tmp_wonbr)
        //         ->update(['sr_status' => 2,
        //         'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
        //         ]);

        //     toast('data has been reopened', 'success');
        //     return redirect()->route('womaint');
    // }

    public function openprint(Request $req,$wo){
        // dd($wo);
        $repair = [];
        $countdb = [];
        $checkstr = [];
        $statusrepair = DB::table('wo_mstr')
                        ->where('wo_mstr.wo_nbr','=',$wo)
                        ->first();
        $womstr = DB::table('wo_mstr')
                ->where('wo_nbr','=',$wo)
                ->leftjoin('users','wo_mstr.wo_creator','users.username')
                ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                ->first();
        $wodet = DB::table('wo_detail')
                ->join('sp_mstr','wo_detail.detail_spare_part','sp_mstr.spm_code')
                ->where('detail_wo_nbr','=',$wo)
                ->get();
        // dd($wodet);
        $data = DB::table('wo_mstr')
                ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, wo_mstr.wo_failure_code1 as wofc1, wo_mstr.wo_failure_code2 as wofc2, wo_mstr.wo_failure_code3 as wofc3, fn1.fn_desc as fd1, fn2.fn_desc as fd2, fn3.fn_desc as fd3, fn1.fn_impact as fi1, fn2.fn_impact as fi2, fn3.fn_impact as fi3' )
                ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->leftjoin('fn_mstr as fn1','wo_mstr.wo_failure_code1','fn1.fn_code')
                ->leftjoin('fn_mstr as fn2','wo_mstr.wo_failure_code2','fn2.fn_code')
                ->leftjoin('fn_mstr as fn3','wo_mstr.wo_failure_code3','fn3.fn_code')
                ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                ->where('wo_mstr.wo_nbr','=',$wo)
                ->get();

                $statusrepair = DB::table('wo_mstr')
                                ->where('wo_mstr.wo_nbr','=',$wo)
                                ->first();
                                // dd($statusrepair);
                $arrayrepaircode = [];
                $repairlist = [];
                $arrayrepairdetail = [];
                $arrayrepairinst = [];
                $arraysptdesc = [];
                $currspt_desc = '';
                // $repair = '';
                $countrepairitr = 0;
                $engineerlist = DB::table('wo_mstr')
                                ->selectRaw('a.name as eng1,b.name as eng2,c.name as eng3,d.name as eng4,e.name as eng5')
                                ->leftjoin('users as a','wo_mstr.wo_engineer1','a.username')
                                ->leftjoin('users as b','wo_mstr.wo_engineer2','b.username')
                                ->leftjoin('users as c','wo_mstr.wo_engineer3','c.username')
                                ->leftjoin('users as d','wo_mstr.wo_engineer4','d.username')
                                ->leftjoin('users as e','wo_mstr.wo_engineer5','e.username')
                                ->where('wo_mstr.wo_nbr',$wo)
                                ->first();

                        // dd($engineerlist);
                        // dd($statusrepair);
                        if($statusrepair->wo_repair_type == 'manual'){
                            $data = DB::table('wo_mstr')
                                    ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, wo_mstr.wo_failure_code1 as wofc1, wo_mstr.wo_failure_code2 as wofc2, wo_mstr.wo_failure_code3 as wofc3, fn1.fn_desc as fd1, fn2.fn_desc as fd2, fn3.fn_desc as fd3, fn1.fn_impact as fi1, fn2.fn_impact as fi2, fn3.fn_impact as fi3' )
                                    ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                                    ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                                    ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                                    ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                                    ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                                    ->leftjoin('fn_mstr as fn1','wo_mstr.wo_failure_code1','fn1.fn_code')
                                    ->leftjoin('fn_mstr as fn2','wo_mstr.wo_failure_code2','fn2.fn_code')
                                    ->leftjoin('fn_mstr as fn3','wo_mstr.wo_failure_code3','fn3.fn_code')
                                    ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                                    ->where('wo_mstr.wo_nbr','=',$wo)
                                    ->get();
                            $datamanual = DB::table('wo_manual_detail')
                                            ->where('wo_manual_wo_nbr','=',$wo)
                                            ->get();
                            $countdb = count($datamanual);
                            
                        }
                else if($statusrepair->wo_repair_type == 'group'){
                        $data = DB::table('wo_mstr')
                            ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, wo_mstr.wo_failure_code1 as wofc1, wo_mstr.wo_failure_code2 as wofc2, wo_mstr.wo_failure_code3 as wofc3, fn1.fn_desc as fd1, fn2.fn_desc as fd2, fn3.fn_desc as fd3, fn1.fn_impact as fi1, fn2.fn_impact as fi2, fn3.fn_impact as fi3' )
                            ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                            ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                            ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                            ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                            ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->leftjoin('fn_mstr as fn1','wo_mstr.wo_failure_code1','fn1.fn_code')
                            ->leftjoin('fn_mstr as fn2','wo_mstr.wo_failure_code2','fn2.fn_code')
                            ->leftjoin('fn_mstr as fn3','wo_mstr.wo_failure_code3','fn3.fn_code')
                            ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                            ->where('wo_mstr.wo_nbr','=',$wo)
                            ->get();
                                // dd($data);
                    // for($pa = 1; $pa <= 5; $pa++)
                    // $engineername = DB::table('wo_mstr')
                    //                 ->join('users','wo_mstr.wo_asset','asset_mstr.asset_code')
                    //                 ->join('loc_mstr as a','asset_mstr.asset_site','a.loc_site')
                    //                 ->join('loc_mstr as b','asset_mstr.asset_loc','b.loc_code')        
                    //                 ->where('wo_mstr.wo_nbr','=',$wo)  
                    //                 ->first();
                    $grouprepair = DB::table('xxrepgroup_mstr')
                                    ->where('xxrepgroup_nbr','=',$statusrepair->wo_repair_group)
                                    ->get();
                    foreach($grouprepair as $grouprepair){
                        array_push($arrayrepaircode,$grouprepair->xxrepgroup_rep_code);
                    }
                    // dd($arrayrepaircode);
                    $countrepairitr = count($arrayrepaircode);
                    for($i = 0; $i<count($arrayrepaircode);$i++){
                        // dd($i);
                        $repairdesc = DB::table('rep_master')
                                        ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
                                        ->first();
                        array_push($repairlist,$repairdesc->repm_desc);
                        $repair[$i] = DB::table('xxrepgroup_mstr')
                                        ->leftjoin('rep_master','xxrepgroup_mstr.xxrepgroup_rep_code','rep_master.repm_code')
                                        ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                        // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
                                        // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
                                        // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
                                        ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                                        // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
                                        // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                                        ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                                        // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
                                        ->where('xxrepgroup_mstr.xxrepgroup_nbr','=',$statusrepair->wo_repair_group)
                                        
                                        ->distinct('ins_mstr.ins_code')
                                        ->orderBy('repm_ins','asc')
                                        
                                        ->get();
                                        // dd(count($repair[$i]));
                                        foreach($repair[$i] as $grouptool){
                                            $newarr = explode(",",$grouptool->ins_tool);
                                            for($po = 0; $po < count($newarr);$po++){
                                                $arr= DB::table('tool_mstr')
                                                            ->where('tool_code','=',$newarr[$po])
                                                            ->first();
                                                if(isset($arr->tool_desc)){
                                                    $newarr[$po] = $arr->tool_desc;
                                                }
                                                else{
                                                    $newarr[$po] = '';
                                                }
                                                
                                            }
                                            $exparr = implode(",",$newarr);
                                            $grouptool->ins_tool = $exparr;
                                        }
                        // dd($repair,$arrayrepaircode[$i],$i);
                        $check[$i] = DB::table('wo_mstr')
                                        ->selectRaw('wrd_flag')
                                        ->leftjoin('wo_rc_detail as a','wo_mstr.wo_nbr','a.wrd_wo_nbr')
                                        ->where('wo_mstr.wo_nbr','=',$wo)
                                        ->where('a.wrd_repair_code','=',$arrayrepaircode[$i])
                                        ->first();
                        if(isset($check[$i])==true){
                            $checkstr[$i] = $check[$i]->wrd_flag;
                        }
                        else{
                            $checkstr[$i] = 0;
                        }
                        // dd($repair[$i]);
                        // dd(count($repair[$i]));    
                        $countdb[$i] = count($repair[$i]);
                    }
                    // foreach($repair as $repair){
                    //     // dd($repair);
                    //     foreach($repair as $repair2){
                    //         dd($repair2);
                    //     }
                                    
                    // }
                    // dd($check[0]);
                    // // dd($)
                    // dd('aaa');
                    
                }
                else if ($statusrepair->wo_repair_type == 'code'){
                    $data = DB::table('wo_mstr')
                            ->selectRaw('wo_nbr,wo_repair_code1,wo_repair_code2,wo_repair_code3,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, wo_mstr.wo_failure_code1 as wofc1, wo_mstr.wo_failure_code2 as wofc2, wo_mstr.wo_failure_code3 as wofc3, fn1.fn_desc as fd1, fn2.fn_desc as fd2, fn3.fn_desc as fd3, fn1.fn_impact as fi1, fn2.fn_impact as fi2, fn3.fn_impact as fi3' )
                            ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                            ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                            ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                            ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                            ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->leftjoin('fn_mstr as fn1','wo_mstr.wo_failure_code1','fn1.fn_code')
                            ->leftjoin('fn_mstr as fn2','wo_mstr.wo_failure_code2','fn2.fn_code')
                            ->leftjoin('fn_mstr as fn3','wo_mstr.wo_failure_code3','fn3.fn_code')
                            ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                            ->where('wo_mstr.wo_nbr','=',$wo)
                            ->get();
                        // dd($data[0]->wo_repair_code1);
                    if(isset($data[0]->wo_repair_code1)){
                        array_push($arrayrepaircode,$data[0]->wo_repair_code1);
                    }
                    if(isset($data[0]->wo_repair_code2)){
                        array_push($arrayrepaircode,$data[0]->wo_repair_code2);
                    }
                    if(isset($data[0]->wo_repair_code3)){
                        array_push($arrayrepaircode,$data[0]->wo_repair_code3);
                    }
                    $countrepairitr = count($arrayrepaircode);
                    // dd($arrayrepaircode);
                    for($i = 0; $i<count($arrayrepaircode);$i++){
                        // dd($arrayrepaircode);
                        $repairdesc = DB::table('rep_master')
                                        ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
                                        ->first();
                        array_push($repairlist,$repairdesc->repm_desc);
                        $repair[$i] = DB::table('rep_master')
                                        ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                        ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                                        // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                                        ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                                        ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
                                        ->distinct('ins_mstr.ins_code')
                                        ->orderBy('repm_ins','asc')
                                        
                                        ->get();
        
                        // dd($repair);
                                        foreach($repair[$i] as $grouptool){
                                            $newarr = explode(",",$grouptool->ins_tool);
                                            for($j = 0; $j < count($newarr);$j++){
                                                $arr= DB::table('tool_mstr')
                                                        ->where('tool_code','=',$newarr[$j])
                                                        ->first();
                                                if(isset($arr->tool_desc)){
                                                    $newarr[$j] = $arr->tool_desc;
                                                }
                                                else{
                                                    $newarr[$j] = '';
                                                }           
                                            }
                                            $exparr = implode(",",$newarr);
                                            $grouptool->ins_tool = $exparr;
                                        }
                                        
                        $check[$i] = DB::table('wo_mstr')
                                        ->selectRaw('wrd_flag')
                                        ->leftjoin('wo_rc_detail as a','wo_mstr.wo_nbr','a.wrd_wo_nbr')
                                        ->where('wo_mstr.wo_nbr','=',$wo)
                                        ->where('a.wrd_repair_code','=',$arrayrepaircode[$i])
                                        ->first();
                        if(isset($check[$i])==true){
                            $checkstr[$i] = $check[$i]->wrd_flag;
                        }
                        else{
                            $checkstr[$i] = 0;
                        }
                        // if(count($repair[$i])!= )
                        
                        // dd(count($repair[1]));
                        $countdb[$i] = count($repair[$i]);
                    }          
                }
                // dd($data[0]->wo_nbr);
        // $repair = DB::table('wo_mstr')
        //         ->selectRaw('r1.repm_desc as r11,r2.repm_desc as r22, r3.repm_desc as r33')
        //         ->leftjoin('rep_master as r1','wo_mstr.wo_repair_code1','r1.repm_code')
        //         ->leftjoin('rep_master as r2','wo_mstr.wo_repair_code2','r2.repm_code')
        //         ->leftjoin('rep_master as r3','wo_mstr.wo_repair_code3','r3.repm_code')
        //         ->where('wo_mstr.wo_nbr','=',$wo)
        //         ->get();
        // $repair2 = DB::table('wo_mstr')
        //         ->selectRaw('sp_mstr.spm_desc')
        //         ->join('rep_master','wo_mstr.wo_repair_code2','rep_master.repm_code')
        //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //             ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        //             ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        //             ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        //             ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        //         ->where('wo_mstr.wo_nbr','=',$wo)
        //         // ->groupBy('spt_code')
        //         ->orderBy('spt_desc')
        //         ->get();
        // $repair1 = DB::table('wo_mstr')
        //         ->selectRaw('sp_mstr.spm_desc')
        //         ->join('rep_master','wo_mstr.wo_repair_code1','rep_master.repm_code')
        //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //         ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        //         ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        //         ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        //         ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        //         ->where('wo_mstr.wo_nbr','=',$wo)
        //         // ->groupBy('spt_code')
        //         ->orderBy('spt_desc')
        //         ->get();
        // $repair3 = DB::table('wo_mstr')
        //         ->selectRaw('sp_mstr.spm_desc')
        //         ->join('rep_master','wo_mstr.wo_repair_code3','rep_master.repm_code')
        //         ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
        //             ->leftjoin('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
        //             ->leftjoin('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
        //             ->leftjoin('sp_type','sp_mstr.spm_type','sp_type.spt_code')
        //             ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
        //         ->where('wo_mstr.wo_nbr','=',$wo)
        //         // ->groupBy('spt_code')
        //         ->orderBy('spt_desc')
        //         ->get();
                
        // $collcon = $repair1->concat($repair2)->concat($repair3);
        // $array = [];
        // dd($repairlist);
        // foreach($engineerlist as $el){
        //     dd($el);
        // }
        // dd($engineerlist);
        // for($i = 0; $i < count($collcon);$i++){
        //     if($collcon[$i]->spm_desc =='' || $collcon[$i]->spm_desc == null){
        //         unset($collcon[$i]);       
        //     }
        //     else{
        //         array_push($array,$collcon[$i]->spm_desc);
        //     }
        // }
        // $array = array_values(array_unique($array));

        // dd($array);
        $sparepartarray = [];
        $printdate = Carbon::now('ASIA/JAKARTA')->toDateString();
        // dd($repair);
        foreach($repair as $repair){
            foreach ($repair as $repair1){
                // dd($repair1);
                if(!in_array($repair1->spm_desc,$sparepartarray)){
                    array_push($sparepartarray,$repair1->spm_desc);
                }
                
            }
            
        }
        // dd($sparepartarray);
        // dd($repair);
        // $pdf = PDF::loadview('workorder.pdfprint-template',['womstr' => $womstr,'wodet' => $wodet, 'data' => $data,'printdate' =>$printdate,'repair'=>$repair,'sparepart'=>$array])->setPaper('A4','portrait');
        $pdf = PDF::loadview('workorder.pdfprint-template',['sparepart'=>$sparepartarray,'womstr' => $womstr,'repairlist'=>$repairlist,'data' => $data,'repair'=>$repair,'counter'=>0,'countdb'=>$countdb,'check'=>$checkstr,'countrepairitre' => $countrepairitr,'printdate'=>$printdate,'engineerlist'=>$engineerlist])->setPaper('A4','portrait');
         //return view('picklistbrowse.shipperprint-template',['printdata1' => $printdata1, 'printdata2' => $printdata2, 'runningnbr' => $runningnbr,'user' => $user,'last' =>$countprint]);
         return $pdf->stream($wo.'.pdf');
    }

    public function openprint2(Request $req,$wo){
        // dd($wo);
        // dd($wodet);
        // dd('aaa');
        $repair = [];
        $countdb = [];
        $checkstr = [];
        $statusrepair = DB::table('wo_mstr')
                        ->where('wo_mstr.wo_nbr','=',$wo)
                        ->first();
                        // dd($statusrepair);
        $arrayrepaircode = [];
        $arrayrepairdetail = [];
        $arrayrepairinst = [];
        $arraysptdesc = [];
        $currspt_desc = '';
        // $repair = '';
        $countrepairitr = 0;
        $wotype = substr($wo,0,2);
        $engineerlist = DB::table('wo_mstr')
                        ->selectRaw('a.name as eng1,b.name as eng2,c.name as eng3,d.name as eng4,e.name as eng5')
                        ->leftjoin('users as a','wo_mstr.wo_engineer1','a.username')
                        ->leftjoin('users as b','wo_mstr.wo_engineer2','b.username')
                        ->leftjoin('users as c','wo_mstr.wo_engineer3','c.username')
                        ->leftjoin('users as d','wo_mstr.wo_engineer4','d.username')
                        ->leftjoin('users as e','wo_mstr.wo_engineer5','e.username')
                        ->where('wo_mstr.wo_nbr',$wo)
                        ->first();
        if($statusrepair->wo_repair_type == 'manual'){
            $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->leftjoin('loc_mstr as a','asset_mstr.asset_site','a.loc_site')
                    ->leftjoin('loc_mstr as b','asset_mstr.asset_loc','b.loc_code')        
                    ->where('wo_mstr.wo_nbr','=',$wo)  
                    ->first();
            $datamanual = DB::table('wo_manual_detail')
                            ->where('wo_manual_wo_nbr','=',$wo)
                            ->get();
            $countdb = count($datamanual);
            
        }
        else if($statusrepair->wo_repair_type == 'group'){
            $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->leftjoin('loc_mstr as a','asset_mstr.asset_site','a.loc_site')
                    ->leftjoin('loc_mstr as b','asset_mstr.asset_loc','b.loc_code')        
                    ->where('wo_mstr.wo_nbr','=',$wo)  
                    ->first();
            // dd($data);
            $grouprepair = DB::table('xxrepgroup_mstr')
                            ->where('xxrepgroup_nbr','=',$statusrepair->wo_repair_group)
                            ->get();
            foreach($grouprepair as $grouprepair){
                array_push($arrayrepaircode,$grouprepair->xxrepgroup_rep_code);
            }
            // dd($arrayrepaircode);
            $countrepairitr = count($arrayrepaircode);
            for($i = 0; $i<count($arrayrepaircode);$i++){
                $repair[$i] = DB::table('xxrepgroup_mstr')
                                ->leftjoin('rep_master','xxrepgroup_mstr.xxrepgroup_rep_code','rep_master.repm_code')
                                ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
                                // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
                                // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
                                ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                                // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
                                // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                                ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                                // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
                                ->where('xxrepgroup_mstr.xxrepgroup_nbr','=',$statusrepair->wo_repair_group)
                                ->where('xxrepgroup_mstr.xxrepgroup_rep_code','=',$arrayrepaircode[$i])
                                ->distinct('ins_mstr.ins_code')
                                ->orderBy('repm_ins','asc')
                                
                                ->get();
                // dd($repair);
                                foreach($repair[$i] as $grouptool){
                                    $newarr = explode(",",$grouptool->ins_tool);
                                    for($po = 0; $po < count($newarr);$po++){
                                        $arr= DB::table('tool_mstr')
                                                    ->where('tool_code','=',$newarr[$po])
                                                    ->first();
                                        if(isset($arr->tool_desc)){
                                            $newarr[$po] = $arr->tool_desc;
                                        }
                                        else{
                                            $newarr[$po] = '';
                                        }
                                        
                                    }
                                    $exparr = implode(",",$newarr);
                                    $grouptool->ins_tool = $exparr;
                                }
                // dd($repair,$arrayrepaircode[$i]);
                $check[$i] = DB::table('wo_mstr')
                                ->selectRaw('wrd_flag')
                                ->leftjoin('wo_rc_detail as a','wo_mstr.wo_nbr','a.wrd_wo_nbr')
                                ->where('wo_mstr.wo_nbr','=',$wo)
                                ->where('a.wrd_repair_code','=',$arrayrepaircode[$i])
                                ->first();
                if(isset($check[$i])==true){
                    $checkstr[$i] = $check[$i]->wrd_flag;
                }
                else{
                    $checkstr[$i] = 0;
                }    
                $countdb[$i] = count($repair[$i]);
            }
        }
        else if ($statusrepair->wo_repair_type == 'code'){
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->leftjoin('loc_mstr as a','asset_mstr.asset_site','a.loc_site')
                ->leftjoin('loc_mstr as b','asset_mstr.asset_loc','b.loc_code')        
                ->where('wo_mstr.wo_nbr','=',$wo)  
                ->first();
                // dd($data);
            if(isset($data->wo_repair_code1)){
                array_push($arrayrepaircode,$data->wo_repair_code1);
            }
            if(isset($data->wo_repair_code2)){
                array_push($arrayrepaircode,$data->wo_repair_code2);
            }
            if(isset($data->wo_repair_code3)){
                array_push($arrayrepaircode,$data->wo_repair_code3);
            }
            $countrepairitr = count($arrayrepaircode);
            // dd($arrayrepaircode);
            for($i = 0; $i<count($arrayrepaircode);$i++){
                $repair[$i] = DB::table('rep_master')
                                ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                                // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                                ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                                ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
                                ->distinct('ins_mstr.ins_code')
                                ->orderBy('repm_ins','asc')
                                
                                ->get();

                                foreach($repair[$i] as $grouptool){
                                    $newarr = explode(",",$grouptool->ins_tool);
                                    for($j = 0; $j < count($newarr);$j++){
                                        $arr= DB::table('tool_mstr')
                                                ->where('tool_code','=',$newarr[$j])
                                                ->first();
                                        if(isset($arr->tool_desc)){
                                            $newarr[$j] = $arr->tool_desc;
                                        }
                                        else{
                                            $newarr[$j] = '';
                                        }           
                                    }
                                    $exparr = implode(",",$newarr);
                                    $grouptool->ins_tool = $exparr;
                                }

                $check[$i] = DB::table('wo_mstr')
                                ->selectRaw('wrd_flag')
                                ->leftjoin('wo_rc_detail as a','wo_mstr.wo_nbr','a.wrd_wo_nbr')
                                ->where('wo_mstr.wo_nbr','=',$wo)
                                ->where('a.wrd_repair_code','=',$arrayrepaircode[$i])
                                ->first();
                if(isset($check[$i])==true){
                    $checkstr[$i] = $check[$i]->wrd_flag;
                }
                else{
                    $checkstr[$i] = 0;
                }
                // if(count($repair[$i])!= )
                
                // dd(count($repair[1]));
                $countdb[$i] = count($repair[$i]);
            }
        }   
        $printdate = Carbon::now('ASIA/JAKARTA')->toDateString();
        $printname = session::get('username');
        // dd($repair);
        if($statusrepair->wo_repair_type == 'manual'){
            $pdf = PDF::loadview('workorder.pdfprint2-template',['wotype'=>$wotype,'data' => $data,'datamanual'=>$datamanual,'counter'=>0,'countdb'=>$countdb,'printdate'=>$printdate,'engineerlist'=>$engineerlist])->setPaper('A4','portrait');
        }
        else{
            $pdf = PDF::loadview('workorder.pdfprint2-template',['wotype'=>$wotype,'data' => $data,'repair'=>$repair,'counter'=>0,'countdb'=>$countdb,'check'=>$checkstr,'countrepairitre' => $countrepairitr,'printname'=>$printname,'printdate'=>$printdate,'engineerlist'=>$engineerlist])->setPaper('A4','portrait');
        }
        
        
        //  return view('picklistbrowse.shipperprint-template',['printdata1' => $printdata1, 'printdata2' => $printdata2, 'runningnbr' => $runningnbr,'user' => $user,'last' =>$countprint]);
         return $pdf->stream($wo.'.pdf');
        // return view('workorder.pdfprint2-template',['data' => $data,'repair'=>$repair,'counter'=>0,'countdb'=>$countdb,'check'=>$checkstr,'countrepairitre' => $countrepairitr,'printname'=>$printname,'printdate'=>$printdate,'engineerlist'=>$engineerlist]);
    }
    
    public function donlodwo(Request $req) {
        // dd('Fungsi belum berjalan');
        //dd($req->all());
        $wonbr    = $req->wonumber;
        $asset    = $req->asset;
        $status   = $req->status;
        $priority = $req->priority;
        $period   = $req->period;
        $creator  = $req->creator;
        // $stats = DB::table('wo_mstr')
        //         ->selectRaw('wo_nbr,wo_asset,wo_schedule,wo_duedate,wo_status,wo_priority,CAST(wo_created_at AS DATE) AS wo_created_at,wo_creator')
        //         ->get();
        return Excel::download(new ViewExport2($wonbr,$status,$asset,$priority,$period,$creator),'view.xlsx');
    }
    
    public function getrepair1(Request $req, $rc1){
        // dd($rc1);
        
        $repair1 = DB::table('rep_master')
                    ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                    ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                    // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                    ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                    ->where('rep_master.repm_code','=',$rc1)
                    ->distinct('ins_mstr.ins_code')
                    ->orderBy('repm_ins','asc')
                    
                    ->get();
                // dd($repair1);
                    foreach($repair1 as $grouptool){
                        $newarr = explode(",",$grouptool->ins_tool);
                        for($i = 0; $i < count($newarr);$i++){
                            $arr= DB::table('tool_mstr')
                                    ->where('tool_code','=',$newarr[$i])
                                    ->first();
                            if(isset($arr->tool_desc)){
                                $newarr[$i] = $arr->tool_desc;
                            }
                            else{
                                $newarr[$i] = '';
                            }           
                        }
                        $exparr = implode(",",$newarr);
                        $grouptool->ins_tool = $exparr;
                    }
            
        $countrepair1 = count($repair1);
        return $repair1;
    }
    
    public function getgroup1(Request $req, $rg1){
        
        $group1 = DB::table('xxrepgroup_mstr')
            // ->selectRaw("xxrepgroup_nbr, xxrepgroup_desc, xxrepgroup_rep_code, xxrepgroup_rep_desc,spt_desc, spm_code, spm_desc, ins_code , ins_desc, repdet_std ")
            ->leftjoin('rep_master','xxrepgroup_mstr.xxrepgroup_rep_code','rep_master.repm_code')
            ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
            // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
            // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
            // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
            ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
            // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
            // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
            ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
            // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
            ->where('xxrepgroup_mstr.xxrepgroup_nbr','=',$rg1)
            ->distinct('ins_mstr.ins_code')
            ->orderBy('repm_ins','asc')
            
            // ->orderBy('insg_line','asc')

            // ->orderby('xxrepgroup_rep_code','asc')
            // ->orderby('spt_desc','asc')
            // ->orderBy('insg_line','asc')
            ->get();
        
            // dd($group1);
            foreach($group1 as $grouptool){
                $newarr = explode(",",$grouptool->ins_tool);
                for($i = 0; $i < count($newarr);$i++){
                    $arr= DB::table('tool_mstr')
                                ->where('tool_code','=',$newarr[$i])
                                ->first();
                    if(isset($arr->tool_desc)){
                        $newarr[$i] = $arr->tool_desc;
                    }
                    else{
                        $newarr[$i] = '';
                    }
                    
                }
                // dd($newarr);
                if(end($newarr)!= ''){
                    $exparr = implode(",",$newarr);
                }
                else{
                    $exparr = implode(" ",$newarr);
                }
                $grouptool->ins_tool = $exparr;
            }
            
    
        $countrepair1 = count($group1);
        // dd($group1);
        // dd($group1);
        return $group1;
    }
    public function statusreportingwo(Request $req){
        // dd($req->all());
        $wonumber = $req->aprwonbr2;
        $srnbr = $req->aprsrnbr2;
        if($req->switch2 =='approve'){
            // $exprc = explode(',',$req->repaircodeapp);
            if($req->formtype == 1){
                DB::table('wo_mstr')
                    ->where('wo_nbr', '=', $wonumber)
                    ->update([
                        'wo_status' => 'completed',
                        'wo_reviewer' => Session::get('username'),
                        'wo_reviewer_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()
                    ]);
                    toast('Work Order '.$wonumber.' Approved by reviewer ', 'success');
                    return redirect()->route('womaint');
            }
            else if ($req->formtype == 2){
                if($srnbr !== null){
                    DB::table('service_req_mstr')
                            ->where('sr_number', '=', $srnbr)
                            ->update([
                                'sr_status' => '5',
                            ]);
                    }
        
                    // dd('lg maintenance');
                    
                    // $albumraw = $req->imgname;
                        DB::table('wo_mstr')
                                ->where('wo_nbr', '=', $wonumber)
                                ->update([
                                    'wo_status' => 'closed',
                                    'wo_approver' => Session::get('username'),
                                    'wo_approver_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()
                                    
                                ]);
        
                    toast('Work Order '.$wonumber.' Completed ', 'success');
                    return redirect()->route('womaint');
                }
            
            }else{
                DB::table('wo_mstr')
                ->where('wo_nbr',$wonumber)
                ->update(['wo_status'=>'closed','wo_reject_reason'=>$req->uncompletenote]);
                toast('Work Order '.$wonumber.' Completed ', 'success');
                return redirect()->route('womaint');
            }
    }
    // public function test(Request $req, $cust){
        //     dd($cust);
    // }
    public function downloadfile(Request $req, $wo){
        // dd(class_exists('ZipArchive'));
        $zip = new ZipArchive;

        $assetnow = DB::table('wo_mstr')
                    ->where('wo_nbr','=',$wo)
                    ->first();

        $listdownload = DB::table('asset_upload')
                        ->where('asset_code','=',$assetnow->wo_asset)
                        ->get();
         $fileName = $wo.'_'.$assetnow->wo_asset.'.zip';
        // $zip = new Zipar
         // dd(count($listdownload));
         if(count($listdownload) > 0){
            // dd($listdownload);
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
            {
                foreach ($listdownload as $listdown){
                // dd($listdown->filepath);

                    $files = File::get($listdown->filepath);
                    $relativeNameInZipFile = basename($listdown->filepath);
                    $zip->addFile($listdown->filepath, $relativeNameInZipFile);
                } 
                $zip->close();
            }
        
            return response()->download(public_path($fileName));
        }
        else{
             toast('Tidak ada dokumen untuk asset pada WO '.$wo.'!','error');
            return back();
        }
    }

    public function getpreventivecreate($asset){
        $assetnow = DB::table('asset_mstr')
                    ->where('asset_code','=',$asset)
                    ->first();

        // return 
    }
}
//tanggal betulin 24 may 2021 - 1553