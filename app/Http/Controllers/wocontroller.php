<?php

/*
Daftar perubahan :

A210927 : status approval user acceptance, jika reject statusnya incomplete, jadi dibedakan status close dan reject. kode status reject = 6
A211014 : print WO yang bukan prefentif, Assign nya diganti nama bukan username dan dikasih tanggal approve user
A211019 : jika status reviewer Incomplete, maka tidak akan merubah status apapun di SR. Reviewer dapat melakukan complete WO ulang
B211019 : menyimpan NOte WO oleh reviewer ketika akan approve ulang WO yang statusnya Incomplete
A211021 : menambahkan fungsi email jika Wo sudah selesai di approve oleh Reviewer
A211022 : file yang diupload di WO Finish bukan hanya berupa gambar
A211025 : file yang disimpan saat finish PM bukan hanya gambar
A211026 : default repair code hanya satu saja, karena actualnya teknisi tidak akan input repair code. default repair code hanya satu untuk other
A211101 : perubahan nama status incomplete menjadi reprocess pada approval spv
A211103 : file yang didownload bukan hanya berupa gambar

*/

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
use Response;


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
    public function wobrowsemenu(){ /* route : wobrowse blade : workorder.woview */
        //dd(Session::get('department'));    
            if (strpos(Session::get('menu_access'), 'WO05') !== false) {
                $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    ->where('username','=',session()->get('username'))
                    ->first();

                $data = DB::table('wo_mstr')
                    ->join('asset_mstr','asset_mstr.asset_code','wo_mstr.wo_asset')
                    ->orderby('wo_created_at','desc')
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(50);
                //dd($data);

                $custrnow = DB::table('wo_mstr')
                            ->selectRaw('wo_creator,min(name) as creator_desc')
                            // ->join('eng_mstr','wo_mstr.wo_creator','eng_mstr.eng_code')
                            ->join('users','wo_mstr.wo_creator','users.username')
                            ->groupBy('wo_creator')
                            ->get();

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
                $impact = DB::table('imp_mstr')
                        ->get();
                $wottype = DB::table('wotyp_mstr')
                        ->get();
                $asgroup = DB::table('asset_group')
                   ->orderBy('asgroup_code')
                   ->get();
                return view('workorder.woview', ['impact'=>$impact,'wottype'=>$wottype,'custrnow' => $custrnow, 'data' => $data,
                'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,
                'dept'=>$depart,'fromhome' => '','asgroup' => $asgroup]);
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
                ->paginate(50);
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
                ->paginate(50);
            // dd($data);
            $depart = DB::table('dept_mstr')
                        ->get();
            $engineer = DB::table('eng_mstr')
                        ->where('eng_active','=','Yes')
                        ->where('eng_code','<>',Session::get('username'))
                        ->orderBy('eng_code')
                        ->get();

            $asset = DB::table('asset_mstr')
                    ->where('asset_active','=','Yes')
                    ->orderBy('asset_code')
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
            $instruction = DB::table('ins_mstr')
                        ->get();
            $impact = DB::table('imp_mstr')
                        ->get();
            $wottype = DB::table('wotyp_mstr')
                        ->get();
            return view('workorder.wocreatedirect', ['impact'=>$impact, 'wottype'=>$wottype,'instruction' => $instruction,'data' => $data,'user' => $engineer,'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '','repairgroup'=>$repairgroup, 'repaircode'=>$repaircode,'sparepart'=>$sparepart]);
        } else {
            toast('Anda tidak memiliki akses menu, Silahkan kontak admin', 'error');
            return back();
        }
    }
    
    // WO maint
    public function wobrowse(){ /* route : womaint blade : workorder.wobrowse */
        if (strpos(Session::get('menu_access'), 'WO01') !== false) {
            // dd(Session::all());
            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    // ->select('approver')
                    ->where('username','=',session()->get('username'))
                    ->get();
                    
            $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->orderby('wo_created_at','desc')
                    ->orderBy('wo_mstr.wo_nbr', 'desc')
                    ->paginate(50);

            $depart = DB::table('dept_mstr')
                        ->get();
            $engineer = DB::table('eng_mstr')
                        ->where('eng_active','=','Yes')
                        ->get();
            $asset = DB::table('asset_mstr')
                        ->where('asset_active','=','Yes')
                        ->orderBy('asset_code')
                        ->get();
            $failure = DB::table('fn_mstr')
                        ->get();
            $repaircode = DB::table('rep_master')
                        ->get();
            $repairgroup = DB::table('xxrepgroup_mstr')
                        ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                        ->distinct('xxrepgroup_nbr')
                        ->get();
            $impact = DB::table('imp_mstr')
                        ->get();
            $wottype = DB::table('wotyp_mstr')
                        ->get();
            $asgroup = DB::table('asset_group')
               ->orderBy('asgroup_code')
               ->get();

            $custrnow = DB::table('wo_mstr')
                            ->selectRaw('wo_creator,min(name) as creator_desc')
                            // ->join('eng_mstr','wo_mstr.wo_creator','eng_mstr.eng_code')
                            ->join('users','wo_mstr.wo_creator','users.username')
                            ->groupBy('wo_creator')
                            ->get();
							
            return view('workorder.wobrowse', ['impact' => $impact, 'wottype'=>$wottype,'repairgroup' => $repairgroup,'data' => $data,'user' => $engineer,
                'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '',
                'repaircode' => $repaircode, 'custrnow' => $custrnow, 'asgroup' => $asgroup, 'page' => 1, 'tmpwo' => '',
                'tmpasset' => '', 'tmpstatus' => '', 'tmpengineer' => '', 'tmpper1' => '', 'tmpper2' => '', 'tmpreqby' => '',
                'tmpwotype' => '', 'tmpimpact' => '', 'tmpgroup' => '']);
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
                ->paginate(50);
            //   dd($data);
            $depart = DB::table('dept_mstr')
                    ->get();
            $engineer = DB::table('eng_mstr')
                    ->where('eng_active','=','Yes')
                    ->get();
            $asset = DB::table('asset_mstr')
                    ->orderBy('asset_code')
                    ->get();
            dd($asset);
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

    public function createdirectwo(Request $req){ /* blade : workorder.wocreatedirect */

        $fn1 = null;
        $fn2 = null;
        $fn3 = null;
        $rc1 = null;
        $rc2 = null;
        $rc3 = null;
        $rprg = null;
        $rprtype = null;
        $finisht = null;
        $cimpactlist = '';
        $cimpactdesclist = '';
        $c_wotype = null;
        $eng2 = null;
        $eng3 = null;
        $eng4 = null;
        $eng5 = null;
        $wotype = null;
        $action = null;
        $sp = null;
        if(isset($req->o_part)){
            $sp = $req->o_part;
        }
        if(isset($req->o_action)){
            $action = $req->o_action;
        }
        if($req->cwotype == 'manual'){
            $wotype = 'other';
        }
        else{
            $wotype = 'auto';
        }
        if(isset($req->c_engineeroth[0])){
            $eng2 = $req->c_engineeroth[0];
        }
        if(isset($req->c_engineeroth[1])){
            $eng3 = $req->c_engineeroth[1];
        }
        if(isset($req->c_engineeroth[2])){
            $eng4 = $req->c_engineeroth[2];
        }
        if(isset($req->c_engineeroth[3])){
            $eng5 = $req->c_engineeroth[3];
        }
        foreach($req->c_impact as $cimpact){
            if($cimpact != ''){
                
               $testimp = DB::table('imp_mstr')
               ->where('imp_code','=',$cimpact)
               ->first();
               $cimpactdesclist .= $testimp->imp_desc.';';

            }
            $cimpactlist .= $cimpact.';';
        }

        $tablern = DB::table('running_mstr') /* 1 */
                ->first();
        $tempnewrunnbr = strval(intval($tablern->wd_nbr)+1);
	    $newtemprunnbr = '';
	    if(strlen($tempnewrunnbr) < 4){
	      $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
	    } else {
                    $newtemprunnbr = $tempnewrunnbr;
                }

                // ganti tahun baru 2023.05.04
                $tahun = substr(Carbon::now()->format('Y'),2,2);
                if($tablern->year != $tahun) {
                   $dispthn = $tahun;
                   $dispnum = "0001";
                } else {
                   $dispthn = $tablern->year;
                   $dispnum = $newtemprunnbr; 
                } 

                $runningnbr = $tablern->wd_prefix.'-'.$dispthn.'-'.$dispnum;

		$finisht = $req->c_finishtime.':'.$req->c_finishtimeminute; /* 2023.04.12 karena jam tidak tersimpan */
        /* $runningnbr = $tablern->wd_prefix.'-'.$tablern->year.'-'.$newtemprunnbr; */
        if($wotype == 'auto'){
            if(isset($req->repairtype)){
                if ($req->repairtype == 'manual'){
                    //  dd($req->manualcount);
                        DB::table('wo_manual_detail')
                                ->where('wo_manual_wo_nbr','=',$runningnbr)
                                ->delete();
                        
                        for($pop = 0; $pop <$req->manualcount;$pop++){
                            if($req->ins[$pop] != null && $req->part[$pop] != null && $req->desc[$pop] != null){
                                $arraymanual = array([
                                    'wo_manual_wo_nbr'      => $runningnbr,
                                    'wo_manual_number'      => $pop + 1,
                                    'wo_manual_ins'         => $req->ins[$pop],
                                    'wo_manual_part'        => $req->part[$pop],
                                    'wo_manual_desc'        => $req->desc[$pop],
                                    'wo_manual_flag'        => $req->group5[$pop],
                                    'wo_manual_flag2'       => $req->group51[$pop],
                                    'wo_manual_qty'         => $req->qty5[$pop],
                                    'wo_manual_repair_hour' => $req->rph5[$pop],
                                    'wo_manual_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                                ]);

                                    DB::table('wo_manual_detail')->insert($arraymanual);
                            }
                            
                        }

                        $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
                        $rprtype = 'manual';
                }
                else if($req->repairtype == 'code'){
   
                    $c_wotype = 'code';
                    DB::table('wo_rc_detail')
                    ->where('wrd_wo_nbr','=',$runningnbr)
                    ->delete();
                    dump('test');
                    if($req->has('repaircode1')){
                        $rc1 = $req->repaircode1[0];
                        
                        $dborigin = DB::table('rep_master')
                            ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                            ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                            // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                            ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                            ->where('rep_master.repm_code','=',$rc1)
                            // ->groupBy('spt_code')
                            ->orderBy('repdet_step')
                            ->get();
                            // dd($dborigin,$rc1);
                        $countdb1 = count($dborigin);
                        // dd($countdb1);
                        $flagname = '';
                        for($i = 0; $i<$countdb1;$i++){
                            $newname = 'group'.$i;
                            if(isset($req->group1[$i])){
                                $flagname .= $req->group1[$i];
                                $flagnow = $req->group1[$i];
                                $funow   = $req->group11[$i];
                                $notenow = $req->note1[$i];
                            }
                        // dd($req->all());
                        $arraydets1 = array([
                            'wo_dets_nbr'       => $runningnbr,
                            'wo_dets_rc'        => $req->repaircode1[0],
                            'wo_dets_sp'        => $req->spm1[$i],
                            'wo_dets_sp_qty'    => $req->qty1[$i],
                            'wo_dets_ins'       => $req->ins1[$i],
                            //'wo_dets_flag'      => $flagnow,
                            //'wo_dets_fu'        => $funow,
                            //'wo_dets_fu_note'   => $notenow,
                            'wo_dets_rep_hour'  => $req->rph1[$i],
                            'wo_dets_standard'  => $req->std1[$i],
                            'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                        // dd($arraydets1);
                            DB::table('wo_dets')->insert($arraydets1);
                            
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

                            // for($i2 = 0; $i2 < count($req->spm1); $i2++){  
                            //     $arraydets1 = array([
                            //         'wo_dets_nbr'       => $req->c_wonbr,
                            //         'wo_dets_rc'        => $req->repaircode1[0],
                            //         'wo_dets_sp'        => $req->spm1[$i2],
                            //         'wo_dets_sp_qty'    => $req->qty1[$i2],
                            //         'wo_dets_ins'       => $req->ins1[$i2],
                            //         'wo_dets_rep_hour'  => $req->rph1[$i2],
                            //         'wo_dets_standard'  => $req->std1[$i2],
                            //         'wo_dets_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            //     ]);
                            //         // dd($arraydettemp);
                            //         DB::table('wo_dets')->insert($arraydets1);
                            // }

                            for($ii = 0; $ii < $req->sparepartnum1;$ii++){
                                $arrayspare1 = array([
                                    'wo_dets_nbr'       => $runningnbr,
                                    'wo_dets_rc'        => $req->repaircode1[0],
                                    'wo_dets_sp'        => $req->partspare1[$ii],
                                    'wo_dets_sp_qty'    => $req->qtyspare1[$ii],
                                    'wo_dets_ins'       => $req->insspare1[$ii],
                                    'wo_dets_rep_hour'  => $req->rphspare1[$ii],
                                    'wo_dets_standard'  => $req->descspare1[$ii],
                                    'wo_dets_flag'      => $req->groupspare1[$ii],
                                    'wo_dets_fu'        => $req->groupspare11[$ii],
                                    'wo_dets_fu_note'   => $req->note11[$ii],
                                    'wo_dets_type'      => 'addition',
                                    'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                                DB::table('wo_dets')->insert($arrayspare1);
                            }




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
                                $flagname .= $req->group1[$i];
                                $flagnow = $req->group2[$i];
                                $funow   = $req->group21[$i];
                                $notenow = $req->note2[$i];
                            }
                        
                        $arraydets2 = array([
                            'wo_dets_nbr'       => $runningnbr,
                            'wo_dets_rc'        => $req->repaircode2[0],
                            'wo_dets_sp'        => $req->spm2[$i],
                            'wo_dets_sp_qty'    => $req->qty2[$i],
                            'wo_dets_ins'       => $req->ins2[$i],
                            'wo_dets_flag'      => $flagnow,
                            'wo_dets_fu'        => $funow,
                            'wo_dets_fu_note'   => $notenow,
                            'wo_dets_rep_hour'  => $req->rph2[$i],
                            'wo_dets_standard'  => $req->std2[$i],
                            'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                            DB::table('wo_dets')->insert($arraydets2);
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


                            for($iii = 0; $iii < $req->sparepartnum2;$iii++){
                                $arrayspare2 = array([
                                    'wo_dets_nbr'       => $runningnbr,
                                    'wo_dets_rc'        => $req->repaircode2[0],
                                    'wo_dets_sp'        => $req->partspare2[$iii],
                                    'wo_dets_sp_qty'    => $req->qtyspare2[$iii],
                                    'wo_dets_ins'       => $req->insspare2[$iii],
                                    'wo_dets_rep_hour'  => $req->rphspare2[$iii],
                                    'wo_dets_standard'  => $req->descspare2[$iii],
                                    'wo_dets_flag'      => $req->groupspare2[$iii],
                                    'wo_dets_fu'        => $req->groupspare21[$iii],
                                    'wo_dets_fu_note'   => $req->note22[$iii],
                                    'wo_dets_type'      => 'addition',
                                    'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                                DB::table('wo_dets')->insert($arrayspare2);

                                
                    }
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
                            if(isset($req->group3[$i])){
                                $flagname .= $req->group3[$i];
                                $flagnow = $req->group3[$i];
                                $funow   = $req->group31[$i];
                                $notenow = $req->note3[$i];
                            }
                        
                        $arraydets3 = array([
                            'wo_dets_nbr'       => $runningnbr,
                            'wo_dets_rc'        => $req->repaircode3[0],
                            'wo_dets_sp'        => $req->spm3[$i],
                            'wo_dets_sp_qty'    => $req->qty3[$i],
                            'wo_dets_ins'       => $req->ins3[$i],
                            'wo_dets_flag'      => $flagnow,
                            'wo_dets_fu'        => $funow,
                            'wo_dets_fu_note'   => $notenow,
                            'wo_dets_rep_hour'  => $req->rph3[$i],
                            'wo_dets_standard'  => $req->std3[$i],
                            'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                            DB::table('wo_dets')->insert($arraydets3);
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

                            // for($i4 = 0; $i4 < count($req->spm3); $i4++){  
                            //     $arraydets3 = array([
                            //         'wo_dets_nbr'       => $req->c_wonbr,
                            //         'wo_dets_rc'        => $req->repaircode3[0],
                            //         'wo_dets_sp'        => $req->spm3[$i4],
                            //         'wo_dets_sp_qty'    => $req->qty3[$i4],
                            //         'wo_dets_ins'       => $req->ins3[$i4],
                            //         'wo_dets_rep_hour'  => $req->rph3[$i4],
                            //         'wo_dets_standard'  => $req->std3[$i4],
                            //         'wo_dets_flag'      => $req->group3[$i4],
                            //         'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            //     ]);
                            //         // dd($arraydettemp);
                            //         DB::table('wo_dets')->insert($arraydets3);
                            // }

                            for($iiii = 0; $iiii < $req->sparepartnum3;$iiii++){
                                $arrayspare3 = array([
                                    'wo_dets_nbr'       => $runningnbr,
                                    'wo_dets_rc'        => $req->repaircode3[0],
                                    'wo_dets_sp'        => $req->partspare3[$iiii],
                                    'wo_dets_sp_qty'    => $req->qtyspare3[$iiii],
                                    'wo_dets_ins'       => $req->insspare3[$iiii],
                                    'wo_dets_rep_hour'  => $req->rphspare3[$iiii],
                                    'wo_dets_standard'  => $req->descspare3[$iiii],
                                    'wo_dets_flag'      => $req->groupspare3[$iiii],
                                    'wo_dets_fu'        => $req->groupspare31[$iiii],
                                    'wo_dets_fu_note'   => $req->note33[$iiii],
                                    'wo_dets_type'      => 'addition',
                                    'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                                DB::table('wo_dets')->insert($arrayspare3);
                    }
                    }
                
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
                                $flagnow = $req->group4[$i][$j];
                                $funow   = $req->group41[$i][$j];
                                $notenow = $req->note[$i][$j];

                                $flagname .= $req->group4[$i][$j];
                            }
                            
                            $arraydetsgrp = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $rg,
                                'wo_dets_sp'        => $req->spm4[$i][$j],
                                'wo_dets_sp_qty'    => $req->qty4[$i][$j],
                                'wo_dets_ins'       => $req->insm4[$i][$j],
                                'wo_dets_flag'      => $flagnow,
                                'wo_dets_fu'        => $funow,
                                'wo_dets_fu_note'   => $notenow,
                                'wo_dets_rep_hour'  => $req->rph4[$i][$j],
                                'wo_dets_standard'  => $req->std4[$i][$j],
                                'wo_dets_flag'      => $req->group4[$i][$j],
                                'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arraydetsgrp);
                            
                        }
                        

                        
                        $arrayrc1 = array([
                            'wrd_wo_nbr'      => $req->$runningnbr,
                            'wrd_repair_code' => $rg,
                            'wrd_flag'        => $flagname,
                            'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                        ]);
                        DB::table('wo_rc_detail')->insert($arrayrc1);
    
                            // dd($arraydettemp);   
                        // for($i5 = 0; $i5 < $countdb1; $i5++){  
                        //     // eval('$spnow = $req->sparepart'.strval($countrepair).');');

                                
                                
                        // }
                        // dd('stop');

                        eval('$spartnow = $req->partspare'.strval($i+1).';');
                        eval('$insspnow = $req->insspare'.strval($i+1).';');
                        eval('$spstdnow = $req->descspare'.strval($i+1).';');
                        eval('$spqtynow = $req->qtyspare'.strval($i+1).';');
                        eval('$rphspnow = $req->rphspare'.strval($i+1).';');
                        eval('$spflagnow = $req->groupspare'.strval($i+1).';');
                        eval('$spfunow = $req->groupspare'.strval($i+1).'1;');
                        eval('$spfunotenow = $req->groupspare'.strval($i+1).';');

                        for($iiiii = 0; $iiiii < $req->sparepartnum[$i];$iiiii++){
                            
                            $arraysparegrp = array([
                                'wo_dets_nbr'       => $runningnbr,
                                'wo_dets_rc'        => $rg,
                                'wo_dets_sp'        => $spartnow[$iiiii],
                                'wo_dets_sp_qty'    => $spqtynow[$iiiii],
                                'wo_dets_ins'       => $insspnow[$iiiii],
                                'wo_dets_rep_hour'  => $rphspnow[$iiiii],
                                'wo_dets_standard'  => $spstdnow[$iiiii],
                                'wo_dets_flag'      => $spflagnow[$iiiii],
                                'wo_dets_fu'        => $spfunow[$iiiii],
                                'wo_dets_fu_note'   => $spfunotenow[$iiiii],
                                'wo_dets_type'      => 'addition',
                                'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                            DB::table('wo_dets')->insert($arraysparegrp);
                    }

                        // dd($flagname);
                    }

                    $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
                    $rprtype = 'group';
                }
            }
        }
		
        $dataarray = array(
            'wo_nbr'           => $runningnbr,
            'wo_dept'          => Session::get('department'),
            'wo_engineer1'     => $req->engineercreate,
            'wo_engineer2'     => $eng2,
            'wo_engineer3'     => $eng3,
            'wo_engineer4'     => $eng4,
            'wo_engineer5'     => $eng5,
            'wo_repair_code1'  => $rc1,
            'wo_repair_code2'  => $rc2,
            'wo_repair_code3'  => $rc3,
            'wo_repair_group'  => $rprg,
            'wo_repair_type'   => $rprtype,
            'wo_new_type'      => $req->c_wottype,
            'wo_impact'        => $cimpactlist,
            'wo_impact_desc'   => $cimpactdesclist,
            // 'wo_repair_hour'   => $req->c_repairhour,
            'wo_finish_date'   => $req->c_finishdate,
            'wo_finish_time'   => $finisht,
            'wo_asset'         => $req->c_asset,
            'wo_priority'      => $req->c_priority,
            'wo_status'        => 'closed',
            'wo_schedule'      => $req->c_schedule,
            'wo_duedate'       => $req->c_duedate,
            'wo_note'          => $req->c_note,
            'wo_action'         => $action,
            'wo_sparepart'      => $sp,
            'wo_type'           => $wotype,
            'wo_creator'       => session()->get('username'),
            'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
            'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
            'wo_start_date'    => Carbon::now('ASIA/JAKARTA')->toDateString(),
            'wo_start_time'    => Carbon::now('ASIA/JAKARTA')->toTimeString(),
            'wo_created_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_updated_at'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
        );
        // dd($dataarray);
        DB::table('wo_mstr')->insert($dataarray);
        DB::table('running_mstr')
        ->where('wd_nbr', '=', $tablern->wd_nbr)
        ->update([
            'wd_nbr' => $dispnum, /* $newtemprunnbr */
			'year' => $dispthn
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

        if($req->hasfile('filenamewo')){
            foreach($req->file('filenamewo') as $upload){
                $filename = $runningnbr . '-' .$upload->getClientOriginalName();
                
                // Simpan File Upload pada Public
                $savepath = public_path('uploadwofinish/');
                $upload->move($savepath, $filename);
                
                // Simpan ke DB Upload
                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $req->c_srnbr,
                        'file_wonumber' => $runningnbr,
                        'file_name'     => $filename,//$upload->getClientOriginalName(), //nama file asli
                        'file_url'      => $savepath.$filename, 
                        'uploaded_at'   => Carbon::now()->toDateTimeString(),
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
	    } else {
                    $newtemprunnbr = $tempnewrunnbr;
                }

                // ganti tahun baru 2023.05.04
                $tahun = substr(Carbon::now()->format('Y'),2,2);
                if($tablern->year != $tahun) {
                   $dispthn = $tahun;
                   $dispnum = "0001";
                } else {
                   $dispthn = $tablern->year;
                   $dispnum = $newtemprunnbr; 
                } 

                $runningnbr = $tablern->wo_prefix.'-'.$dispthn.'-'.$dispnum;

        /* $runningnbr = $tablern->wo_prefix.'-'.$tablern->year.'-'.$newtemprunnbr; */
        
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
        /* ->where('wo_nbr', '=', $tablern->wo_nbr) */
        ->update([
            'wo_nbr' => $dispnum, /* $newtemprunnbr */
            'year' => $dispthn,
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
        // dd($req->all());
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
        $cimpactlist = '';
        $cimpactdesclist = '';
        $c_wotype = null;
        if($req->cwotype == 'preventive'){
            $c_wotype = 'auto';
        }
        else{
            $c_wotype = 'other';
        }

        foreach($req->c_impact as $cimpact){
            if($cimpact != ''){
                
               $testimp = DB::table('imp_mstr')
               ->where('imp_code','=',$cimpact)
               ->first();
               $cimpactdesclist .= $testimp->imp_desc.';';
            //    dd($cimpact,$testimp); 
            }
            $cimpactlist .= $cimpact.';';
        }
        // dd($cimpactlist);        
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

        if(isset($req->crepaircode[0])){
            $rc1 = $req->c_repaircode[0];
        }
        if(isset($req->crepaircode[1])){
            $rc2 = $req->c_repaircode[1];
        }
        if(isset($req->crepaircode[2])){
            $rc3 = $req->c_repaircode[2];
        }
        if(isset($req->crepairgroup)){
            $rg1 = $req->crepairgroup;
        }
        
        //dd($req->get('c_engineer')[4]);
        $tablern = DB::table('running_mstr')
                ->first();
        $tempnewrunnbr = strval(intval($tablern->wo_nbr)+1);
	    $newtemprunnbr = '';
	    if(strlen($tempnewrunnbr) < 4){
	      $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
	    } else {
               $newtemprunnbr = $tempnewrunnbr;
            }

        // ganti tahun baru 2023.05.04
        $tahun = substr(Carbon::now()->format('Y'),2,2);
        if($tablern->year != $tahun) {
           $dispthn = $tahun;
           $dispnum = "0001";
        } else {
           $dispthn = $tablern->year;
           $dispnum = $newtemprunnbr; 
        } 

        $runningnbr = $tablern->wo_prefix.'-'.$dispthn.'-'.$dispnum;
        /* $runningnbr = $tablern->wo_prefix.'-'.$tablern->year.'-'.$newtemprunnbr; */
        
        $dataarray = array(
            'wo_nbr'           => $runningnbr,
            'wo_dept'          => Session::get('department'),
            'wo_engineer1'     => $eng1,
            'wo_engineer2'     => $eng2,
            'wo_engineer3'     => $eng3,
            'wo_engineer4'     => $eng4,
            'wo_engineer5'     => $eng5,
            'wo_repair_code1'  => $rc1,
            'wo_repair_code2'  => $rc2,
            'wo_repair_code3'  => $rc3,
            'wo_repair_group'  => $rg1,
            'wo_new_type'      => $req->c_wottype,
            'wo_impact'        => $cimpactlist,
            'wo_impact_desc'   => $cimpactdesclist,
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
            /* jika asset dalam kondidi PM, WO tetap masih bisa terbentuk
            $checkasset = DB::table('asset_mstr')
                            ->where('asset_code','=',$req->c_asset)
                            ->first();
            if($checkasset->asset_on_use == null){

                DB::table('wo_mstr')->insert($dataarray);

                DB::table('asset_mstr')
                ->where('asset_code','=',$req->c_asset)
                ->update(['asset_on_use' => $runningnbr]);
                
            }
            else{
                toast('Asset '.$req->c_asset.' has been used for PM','error');
                return back();
            }*/

            DB::table('wo_mstr')->insert($dataarray);

        }
        else{
            DB::table('wo_mstr')->insert($dataarray);
        }
        
        DB::table('running_mstr')
        /* ->where('wo_nbr', '=', $tablern->wo_nbr) */
        ->update([
            'wo_nbr' => $dispnum, /* $newtemprunnbr */
            'year' => $dispthn,
        ]);
        $assettable = DB::table('asset_mstr')
            ->where('asset_code','=',$req->c_asset)
            ->first();
                
        $asset = $req->c_asset.' - '.$assettable->asset_desc;
        
        EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');

        toast($runningnbr.' Successfuly Created !','success');
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
        $eimpactlist = '';
        $eimpactdesclist = '';
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
        foreach($req->e_impact as $eimpact){
            if($eimpact != ''){
               $testimp = DB::table('imp_mstr')
               ->where('imp_code','=',$eimpact)
               ->first();
               $eimpactdesclist .= $testimp->imp_desc.';';
            }
            $eimpactlist .= $eimpact.';';
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
                'wo_schedule'     => $woschedule,
                'wo_duedate'      => $woduedate,
                // 'wo_dept'         => $department,
                'wo_note'         => $req->e_note,
                'wo_repair_code1' => $rc1,
                'wo_repair_code2' => $rc2,
                'wo_repair_code3' => $rc3,
                'wo_repair_group' => $repairgroup,
                'wo_repair_type'  => $repairtype,
                'wo_new_type'     => $req->e_wottype,
                'wo_impact'       => $eimpactlist,
                'wo_impact_desc'  => $eimpactdesclist,
                'wo_updated_at'   => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                'wo_access'       => 0
            ]);
            
            toast('WO '.$req->e_nowo.' successfully updated', 'success');
            // 2022.12.01 return redirect()->route('womaint');
            return redirect()->route('womaintpage',['page' => $req->epage, 'tmpwo' => $req->etmpwo,
                'tmpasset' => $req->etmpasset, 'tmpstatus' => $req->etmpstatus, 'tmpengineer' => $req->etmpengineer,
                'tmpper1' => $req->etmpper1, 'tmpper2' => $req->etmpper2, 'tmpwotype' => $req->etmpwotype,
                'tmpreqby' => $req->etmpreqby, 'tmpimpact' => $req->etmpimpact]);
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
        // 2022.12.01 return back();
        return redirect()->route('womaintpage',['page' => $req->dpage, 'tmpwo' => $req->dtmpwo,
                'tmpasset' => $req->dtmpasset, 'tmpstatus' => $req->dtmpstatus, 'tmpengineer' => $req->dtmpengineer,
                'tmpper1' => $req->dtmpper1, 'tmpper2' => $req->dtmpper2, 'tmpwotype' => $req->dtmpwotype,
                'tmpreqby' => $req->dtmpreqby, 'tmpimpact' => $req->dtmpimpact]);
    }

    public function wopaging(Request $req){ /* route : /womaint/pagination blade : workorder.table-wobrowse*/
		//dd($req->all());
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            //$priority  = $req->get('wopriority');
            $engineer  = $req->get('woengineer');
            $per1      = $req->get('woper1');
            $per2      = $req->get('woper2');
            $wotype    = $req->get('wotype');
            $woreqby   = $req->get('woreqby');
            $woimpact  = $req->get('woimpact');
			$group  = $req->get('group');

            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    ->where('username','=',session()->get('username'))
                    ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $engineer =='' and $per1 == '' and $per2 == '' 
            and $wotype == '' and $woreqby == '' and $woimpact == '' and $group == '') {     
                $data = DB::table('wo_mstr')
                        ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                        ->orderby($sort_by, $sort_type)
                        ->orderBy('wo_mstr.wo_id', 'desc')
                        ->paginate(50);

                    return view('workorder.table-wobrowse', ['data' => $data,'usernow' =>$usernow]);
            } else {
                $kondisi = "wo_mstr.wo_id > 0";

                if ($wonumber != '') {
                    $kondisi .= " and wo_nbr = '" . $wonumber . "'";
                }
                if ($asset != '') {
                    $kondisi .= " and asset_code = '" . $asset . "'";
                }
                if ($status != '') {
                    $kondisi .= " and wo_status = '" . $status . "'";
                }

                if ($engineer != ''){
                    $kondisi .= " and (wo_engineer1 = '". $engineer . "' or wo_engineer2 = '".$engineer."' or wo_engineer3 = '".$engineer."' or wo_engineer4 = '".$engineer."' or wo_engineer5 = '".$engineer."')";
                }
                if ($per1 != '' and $per2 != ''){
                    $kondisi .= " and CAST(wo_created_at AS DATE) between '". $per1 ."' and '". $per2 ."'";
                }
                if ($woreqby != ''){
                    $kondisi .= " and wo_creator = '". $woreqby ."'";
                }
				if ($group != '') {
                   $kondisi .= " and asset_group = '". $group ."'";
                }
                if ($wotype != '') {
                   $kondisi .= " and wo_new_type = '". $wotype ."'";
                }
                if ($woimpact != '' ) {
                    $kondisi .= " and wo_impact like '%" .$woimpact. "%'";
                }
                
                // dd($kondisi);
                $data = DB::table('wo_mstr')
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->whereRaw($kondisi)
                    ->orderBy($sort_by, $sort_type)
                    ->orderBy('wo_mstr.wo_id', 'desc')
                    ->paginate(50);
             
                    return view('workorder.table-wobrowse', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }

    public function wopagingview(Request $req){ /* route : wobrowse/pagination blade : workorder.table-woview */
//dd($req->all());
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            $priority  = $req->get('wopriority');
            $engineer  = $req->get('woengineer');
            $creator   = $req->get('wocreator');
            $woper1    = $req->get('woper1');
            $woper2    = $req->get('woper2');
            $wotype    = $req->get('wotype');
            $woimpact    = $req->get('woimpact');

            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    ->where('username','=',session()->get('username'))
                    ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $priority == '' and $engineer =='' and $creator == '' and $woper1 == '' 
                and $woper2 == '' and $wotype == '' and $woimpact == '') {
                        $data = DB::table('wo_mstr')
                            ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                            ->orderby($sort_by, $sort_type)
                            ->orderBy('wo_mstr.wo_id', 'desc')
                            ->distinct('wo_nbr')
                            ->paginate(50);
                     
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
                }if($creator != ''){
                    $kondisi .= " and wo_creator = '". $creator . "'";
                }
                if ($engineer != ''){
                    $kondisi .= " and (wo_engineer1 = '". $engineer . "' or wo_engineer2 = '".$engineer."' or wo_engineer3 = '".$engineer."' or wo_engineer4 = '".$engineer."' or wo_engineer5 = '".$engineer."')";
                }
                if ($woper1 != '' and $woper2 != '') {
                    $kondisi .= " and CAST(wo_created_at AS DATE) between '". $woper1 . "' and '". $woper2 ."'";
                }
                if ($wotype != '') {
                   $kondisi .= " and asset_group='".$wotype."'";
                }
                if ($woimpact != '') {
                    $kondisi .= " and wo_new_type = '" .$woimpact. "'";
                }
        
                //dd($kondisi);
                $data = DB::table('wo_mstr')
                    ->selectRaw('min(wo_mstr.wo_id) as wo_id,wo_mstr.wo_nbr ,min(wo_mstr.wo_schedule) as wo_schedule, 
                    min(wo_mstr.wo_duedate) as wo_duedate,min(wo_mstr.wo_status) as wo_status, 
                    min(wo_mstr.wo_creator) as wo_creator, min(wo_mstr.wo_priority) as wo_priority, 
                    wo_mstr.wo_created_at, min(wo_mstr.wo_sr_nbr) as wo_sr_nbr,
                    min(asset_mstr.asset_code) as asset_code,min(asset_mstr.asset_desc) as asset_desc,
                    min(acceptance_image.file_wonumber) as file_wonumber,min(wo_mstr.wo_engineer1) as wo_engineer1, 
                    min(wo_asset) as wo_asset, min(wo_type) as wo_type, min(asset_group) as asset_group')
                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                    ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                    ->whereRaw($kondisi)
                    ->groupBy('wo_mstr.wo_nbr')
                    ->groupBy('wo_mstr.wo_created_at')
                    ->orderBy('wo_mstr.wo_created_at', $sort_type)
                    //->get();
                    ->paginate(50);

                    return view('workorder.table-woview', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }

    public function wopagingcreate(Request $req){
        //   dd($req->get('woperiod'));
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
                            ->paginate(50);
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
                    ->paginate(50);
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
                ->paginate(50);
                   
                
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
                ->paginate(50);
                // dd($kondisi);    
                // $data = DB::table('wo_mstr')
                //     ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                //     ->whereRaw($kondisi)
                //     ->orderBy($sort_by, $sort_type)
                //     ->orderBy('wo_mstr.wo_id', 'desc')
                //     ->paginate(50);
                // dd($data);
                // dd($_SERVER['REQUEST_URI']);                
                    return view('workorder.table-wocreatedirect', ['data' => $data,'usernow' => $usernow]);
            }
        }
    }
    public function wopagingstart(Request $req){ /* route : wojoblist/pagination blade : workorder.table-wostart */
        
        if ($req->ajax()) {
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $wonumber  = $req->get('wonumber');
            $asset     = $req->get('woasset');
            $status    = $req->get('wostatus');
            /* $priority  = $req->get('wopriority');
            $period    = $req->get('woperiod'); */
            $engineer  = $req->get('woengineer');
            $per1      = $req->get('woper1');
            $per2      = $req->get('woper2');
            $wotype    = $req->get('wotype');
            $woreqby   = $req->get('wocreator');

            $usernow = DB::table('users')
                    ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                    ->where('username','=',session()->get('username'))
                    ->get();

            if ($wonumber == '' and $asset == '' and $status == '' and $engineer =='' and $per1 == '' and $per2 == '' and $wotype == '' and $woreqby == '') {                      
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
                            ->paginate(50);
                
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
                }
                if ($engineer != ''){
                    $kondisi .= " and (wo_engineer1 = '". $engineer . "' or wo_engineer2 = '".$engineer."' or wo_engineer3 = '".$engineer."' or wo_engineer4 = '".$engineer."' or wo_engineer5 = '".$engineer."')";
                }
                if ($per1 != '' and $per2 != ''){
                   $kondisi .= " and CAST(wo_created_at AS DATE) between '". $per1 ."' and '". $per2 ."'";
                }
                if ($woreqby != ''){
                    $kondisi .= " and wo_creator = '". $woreqby ."'";
                }
                if ($wotype != '') {
                   $kondisi .= " and asset_group = '". $wotype ."'";
                }

                /* 
                if ($priority != ''){
                    $kondisi .= " and wo_priority = '". $priority . "'";
                }
                
                 $data = DB::table('wo_mstr')
                     ->selectRaw('wo_mstr.*,asset_mstr.*,file_wonumber')
                     ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                     ->leftjoin('acceptance_image', 'acceptance_image.file_wonumber', 'wo_mstr.wo_nbr')
                     ->whereRaw($kondisi)
                     ->orderBy($sort_by, $sort_type)
                     ->orderBy('wo_mstr.wo_id', 'desc')
                     ->distinct('wo_nbr')
                     ->paginate(50);
                */
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
                //->get();
                ->paginate(50);
                //dd($data);
               
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
                    ->paginate(50);
                
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
                //     ->paginate(50);
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
                ->paginate(50);
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
                ->selectRaw('wo_type,wo_nbr,wo_reviewer_appdate,wo_approver_appdate,wo_repair_type,
                wo_repair_group,xxrepgroup_nbr,xxrepgroup_desc,wo_status,asset_desc,wo_approval_note,
                wo_creator,wo_reject_reason,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,
                wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, 
                wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,
                u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, 
                wo_mstr.wo_failure_code1 as wofc1, wo_mstr.wo_failure_code2 as wofc2, 
                wo_mstr.wo_failure_code3 as wofc3, fn1.fn_desc as fd1, fn2.fn_desc as fd2, 
                fn3.fn_desc as fd3,r1.repm_desc as r11,r2.repm_desc as r22,r3.repm_desc as r33,
                r1.repm_code as rr11,r2.repm_code as rr22,r3.repm_code as rr33, wo_finish_date,
                wo_finish_time,wo_repair_hour,asset_last_mtc,asset_last_usage_mtc,asset_measure,loc_code,
                loc_desc,astype_code,astype_desc,wo_new_type,wo_impact,wo_impact_desc,wo_action,wotyp_desc,asset_daya,
                wo_reject_reason,wo_start')
                ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->leftjoin('asset_type','asset_mstr.asset_type','asset_type.astype_code')
                ->leftjoin('loc_mstr','asset_mstr.asset_loc','loc_mstr.loc_code')
                ->leftjoin('fn_mstr as fn1','wo_mstr.wo_failure_code1','fn1.fn_code')
                ->leftjoin('fn_mstr as fn2','wo_mstr.wo_failure_code2','fn2.fn_code')
                ->leftjoin('fn_mstr as fn3','wo_mstr.wo_failure_code3','fn3.fn_code')
                ->leftjoin('rep_master as r1','wo_mstr.wo_repair_code1','r1.repm_code')
                ->leftjoin('rep_master as r2','wo_mstr.wo_repair_code2','r2.repm_code')
                ->leftjoin('rep_master as r3','wo_mstr.wo_repair_code3','r3.repm_code')
                ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                ->leftJoin('wotyp_mstr','wo_mstr.wo_new_type','wotyp_mstr.wotyp_code')
                ->leftjoin('xxrepgroup_mstr','xxrepgroup_mstr.xxrepgroup_nbr','wo_mstr.wo_repair_group')
                ->where('wo_mstr.wo_nbr','=',$nowo)
                ->get();
                // dd($data);
                
			//dd($data);
            return $data;
    }

    public function approvewo(Request $req){
         
         $engineernow = $req->engappr[0];
         $engineerexplode = explode(',',$engineernow);
        //  dd($engineerexplode[4]);
         $engnow1 = '';
         $engnow2 = '';
         $engnow3 = '';
         $engnow4 = '';
         $engnow5 = '';

         if(array_key_exists(0,$engineerexplode)){
             $engnow1 = $engineerexplode[0];
         }
         if(array_key_exists(1,$engineerexplode)){
            $engnow2 = $engineerexplode[1];
        }
        if(array_key_exists(2,$engineerexplode)){
            $engnow3 = $engineerexplode[2];
        }
        if(array_key_exists(3,$engineerexplode)){
            $engnow4 = $engineerexplode[3];
        }
        if(array_key_exists(4,$engineerexplode)){
            $engnow5 = $engineerexplode[4];
        }
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
                    'wo_status'     =>'open',
                    'wo_engineer1'  =>  $engnow1,
                    'wo_engineer2'  =>  $engnow2,
                    'wo_engineer3'  =>  $engnow3,
                    'wo_engineer4'  =>  $engnow4,
                    'wo_engineer5'  =>  $engnow5,
                    'wo_approver'   => Session::get('username'),
                    'wo_access'     => 0
                ]);
                toast('Work order '.$req->aprwonbr.' approved successfuly', 'success');
                // 2022.12.01 return redirect()->route('womaint');
                return redirect()->route('womaintpage',['page' => $req->ppage, 'tmpwo' => $req->ptmpwo,
                'tmpasset' => $req->ptmpasset, 'tmpstatus' => $req->ptmpstatus, 'tmpengineer' => $req->ptmpengineer,
                'tmpper1' => $req->ptmpper1, 'tmpper2' => $req->ptmpper2, 'tmpwotype' => $req->ptmpwotype,
                'tmpreqby' => $req->ptmpreqby, 'tmpimpact' => $req->ptmpimpact]);
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
                    'wo_engineer1'  =>  $engnow1,
                    'wo_engineer2'  =>  $engnow2,
                    'wo_engineer3'  =>  $engnow3,
                    'wo_engineer4'  =>  $engnow4,
                    'wo_engineer5'  =>  $engnow5,
                    'wo_repair_code1' =>$rc1,
                    'wo_repair_code2'=>$rc2,
                    'wo_repair_code3'=>$rc3,
                    'wo_repair_group'=>$exprg,
                    'wo_repair_type'=>$exprt,
                    'wo_approver' => Session::get('username'),
                    'wo_access'     => 0
                    ]);

                    toast('Work order '.$req->aprwonbr.' approved successfuly', 'success');
                    // 2022.12.01 return redirect()->route('womaint');
                    return redirect()->route('womaintpage',['page' => $req->ppage, 'tmpwo' => $req->ptmpwo,
                    'tmpasset' => $req->ptmpasset, 'tmpstatus' => $req->ptmpstatus, 'tmpengineer' => $req->ptmpengineer,
                    'tmpper1' => $req->ptmpper1, 'tmpper2' => $req->ptmpper2, 'tmpwotype' => $req->ptmpwotype,
                    'tmpreqby' => $req->ptmpreqby, 'tmpimpact' => $req->ptmpimpact]);
                }
            }
        else{
            DB::table('wo_mstr')
            ->where('wo_nbr',$req->aprwonbr)
            ->update(['wo_status'=>'closed']);
            toast('Work order '.$req->aprwonbr.' has been rejected', 'success');
            // 2022.12.01 return redirect()->route('womaint');
            return redirect()->route('womaintpage',['page' => $req->rpage, 'tmpwo' => $req->rtmpwo,
                'tmpasset' => $req->rtmpasset, 'tmpstatus' => $req->rtmpstatus, 'tmpengineer' => $req->rtmpengineer,
                'tmpper1' => $req->rtmpper1, 'tmpper2' => $req->rtmpper2, 'tmpwotype' => $req->rtmpwotype,
                'tmpreqby' => $req->rtmpreqby, 'tmpimpact' => $req->rtmpimpact]);
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
    
    public function wojoblist(Request $req){ /* blade : workorder.wostart */
        //dd(Session()->get('username'));
        if (strpos(Session::get('menu_access'), 'WO02') !== false) {
            $getuser = DB::table('users')
                    ->where('username','=',Session()->get('username'))
                    ->first();
                    
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
                ->paginate(50);
                // dd($data);

            /* $engineer = DB::table('users')
                    ->join('roles','users.role_user','roles.role_code')
                    ->where('role_desc','=','Engineer')
                    ->get(); */
            $engineer = DB::table('eng_mstr')
                        ->where('eng_active','=','Yes')
                        ->whereEng_code(Session()->get('username'))
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
                    ->orderBy('asset_code')
                    ->get();
                    
               
            $custrnow = DB::table('wo_mstr')
                            ->selectRaw('wo_creator,min(name) as creator_desc')
                            // ->join('eng_mstr','wo_mstr.wo_creator','eng_mstr.eng_code')
                            ->join('users','wo_mstr.wo_creator','users.username')
                            ->groupBy('wo_creator')
                            ->get();
                            
            $asgroup = DB::table('asset_group')
               ->orderBy('asgroup_code')
               ->get();
               
            if($req->ajax()){
                return view('workorder.table-wostart', ['data' => $data]);
            }
            else{
                return view('workorder.wostart', ['page' => '1', 'data' => $data,'user' => $engineer,'engine'=>$engineer,
                'asset1'=>$asset, 'asset2'=>$asset,'asgroup'=>$asgroup,'custrnow'=>$custrnow,
                'englogin'=>Session()->get('username'), 'tmpwo' => "",
                'tmpasset' => "", 'tmpstatus' => "", 'tmpengineer' => "",
                'tmpcreator' => "", 'tmpper1' => "", 'tmpper2' => "",
                'tmpwotype' => ""]);
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
                'wo_start' => $req->v_start,
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
            // return redirect()->route('wojoblist');
            // dd('cek');
            return redirect()->route('wojobliststart',['page' => $req->hidden_page,'tmpwo' => $req->tmpwo,
                'tmpasset' => $req->tmpasset, 'tmpstatus' => $req->tmpstatus, 'tmpengineer' => $req->tmpengineer,
                'tmpcreator' => $req->tmpcreator, 'tmpper1' => $req->tmpper1, 'tmpper2' => $req->tmpper2,
                'tmpwotype' => $req->tmpwotype ]);
        
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
                        'body' => 'WO has been canceled by '.session::get('username'),
                        'url' => 'womaint',
                        'nbr' => $nomorwo,
                        'note' => 'Please check'
                    ]; // isi data yang dioper
                
                
                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel
        }
    
        toast('Work order '.$nomorwo.' has been canceled', 'success');
        return redirect()->route('wojoblist');
        
        
        //dd($statuswo);
        }
    }

    public function wojobliststart(Request $req) {
        // dd($req->all());


        /* $sort_by   = $req->get('sortby');
        $sort_type = $req->get('sorttype'); */
        $wonumber  = $req->tmpwo;
        $passet     = $req->tmpasset == null ? "" : $req->tmpasset;
        $status    = $req->tmpstatus == null ? "" : $req->tmpstatus;
        /* $priority  = $req->get('wopriority');
        $period    = $req->get('woperiod'); */
        $pengineer  = $req->tmpengineer;
        $per1      = $req->tmpper1;
        $per2      = $req->tmpper2;
        $wotype    = $req->tmpwotype;
        $woreqby   = $req->get('wocreator');
        $ppage     = $req->page;

        $getuser = DB::table('users')
                    ->where('username','=',Session()->get('username'))
                    ->first();
                    

        $engineer = DB::table('eng_mstr')
                    ->where('eng_active','=','Yes')
                    ->whereEng_code(Session()->get('username'))
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
                ->orderBy('asset_code')
                ->get();
                    
               
        $custrnow = DB::table('wo_mstr')
                        ->selectRaw('wo_creator,min(name) as creator_desc')
                        // ->join('eng_mstr','wo_mstr.wo_creator','eng_mstr.eng_code')
                        ->join('users','wo_mstr.wo_creator','users.username')
                        ->groupBy('wo_creator')
                        ->get();
                            
        $asgroup = DB::table('asset_group')
            ->orderBy('asgroup_code')
            ->get();

        // if ($wonumber == '' and $asset == '' and $status == '' and $engineer =='' and $per1 == '' and $per2 == '' 
        // and $wotype == '' and $woreqby == '') {  
// dd($passet);            
        if (($wonumber == '' or $wonumber == NULL) and ($passet == '' or $passet == NULL) and ($status == '' or $status == NULL)
        and ($pengineer =='' or $pengineer == NULL) and ($per1 == '' or $per1 == NULL) and ($per2 == '' or $per2 == NULL) 
        and ($wotype == '' or $wotype == NULL) and ($woreqby == '' or $woreqby == NULL)) {  
            // dd('all');                   
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
                        ->paginate(50);
            
                        return view('workorder.wostart', ['page' => $ppage, 'data' => $data,'user' => $engineer,'engine'=>$engineer,
                        'asset1'=>$asset, 'asset2'=>$asset,'asgroup'=>$asgroup,'custrnow'=>$custrnow,'englogin'=>Session()->get('username'),
                        'tmpwo' => $req->tmpwo,
                        'tmpasset' => $req->tmpasset, 'tmpstatus' => $req->tmpstatus, 'tmpengineer' => $req->tmpengineer,
                        'tmpcreator' => $req->tmpcreator, 'tmpper1' => $per1, 'tmpper2' => $per2,
                        'tmpwotype' => $req->tmpwotype]);
        } else {
            // dd('else');
            $kondisi = "wo_mstr.wo_id > 0";

            if ($wonumber != '') {
                $kondisi .= " and wo_nbr = '" . $wonumber . "'";
            }
            if ($passet != '') {
                $kondisi .= " and asset_code = '" . $passet . "'";
            }if ($status != '') {
                $kondisi .= " and wo_status ='".$status."'";
            }
            else{
                $kondisi .= " and (wo_status = 'open' or wo_status = 'started')";
            }
            if ($pengineer != ''){
                $kondisi .= " and (wo_engineer1 = '". $pengineer . "' or wo_engineer2 = '".$pengineer."' or wo_engineer3 = '".$pengineer."' or wo_engineer4 = '".$pengineer."' or wo_engineer5 = '".$pengineer."')";
            }
            if ($per1 != '' and $per2 != ''){
                $kondisi .= " and CAST(wo_created_at AS DATE) between '". $per1 ."' and '". $per2 ."'";
            }
            if ($woreqby != ''){
                $kondisi .= " and wo_creator = '". $woreqby ."'";
            }
            if ($wotype != '') {
                $kondisi .= " and asset_group = '". $wotype ."'";
            }
// dd($kondisi);


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
            //->get();
            ->paginate(50);
            // dd($req->tmpasset);
            
            // return view('workorder.table-wostart', ['data' => $data,'usernow' => $usernow]);
            return view('workorder.wostart', ['page' => $ppage, 'data' => $data,'user' => $engineer,'engine'=>$engineer,
                'asset1'=>$asset, 'asset2'=>$asset,'asgroup'=>$asgroup,'custrnow'=>$custrnow,
                'englogin'=>Session()->get('username'), 'tmpwo' => $req->tmpwo,
                'tmpasset' => $req->tmpasset, 'tmpstatus' => $req->tmpstatus, 'tmpengineer' => $req->tmpengineer,
                'tmpcreator' => $req->tmpcreator, 'tmpper1' => $per1, 'tmpper2' => $per2,
                'tmpwotype' => $req->tmpwotype ]);
        }
    }

    public function wocloselist(){ /* route : woreport   blade : workorder.woclose */
        
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
                ->paginate(50);

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
                    ->orderBy('asset_code')
                    ->get();
            
            $repaircode = DB::table('rep_master')
                        ->get();

            $sparepart = DB::table('sp_mstr')
                        ->get();
            $repairgroup = DB::table('xxrepgroup_mstr')
                        ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                        ->distinct('xxrepgroup_nbr')
                        ->get();
            $instruction = DB::table('ins_mstr')
                        ->get();

            return view('workorder.woclose', ['data' => $data,'user' => $engineer,'engine'=>Session()->get('username'),
            'asset1'=>$asset,'asset2'=>$asset,'repaircode'=>$repaircode,'sparepart'=>$sparepart,'repairgroup'=>$repairgroup,
            'instruction' => $instruction, 'page' => 1, 'tmpstatus' => '', 'tmpwo' => '', 'tmpasset' => '']);
        } else {
            toast('you dont have access, please contact admin', 'error');
            return back();
        }
    }

    // reportin WO untuk yang PM
    public function reportingwo(Request $req){
        // dump('reportingwo');
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
        // if($req->repairpartnow == 'auto'){
        //     // dd($req->all());
        //     $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;
        //     $arrayy = [
        //             'wo_updated_at'    =>Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
        //             'wo_status'        => 'finish',
        //             // 'wo_repair_hour'   => $req->c_repairhour,
        //             'wo_finish_date'   => $req->c_finishdate,
        //             'wo_finish_time'   => $finisht,
        //             'wo_approval_note' => $req->c_note,
        //             'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
        //             'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
        //             'wo_access'        => 0,
        //             'wo_access_user'   => null,
        //         ];
        //         DB::table('wo_mstr')->where('wo_nbr','=',$req->c_wonbr)->update($arrayy);
        //         if($req->assettype == 'M'){
        //             $increment = DB::table('asset_mstr')
        //                          ->where('asset_code','=',$req->c_assethidden)
        //                          ->first();
        //                          dd($increment);
        //             $lastusage = $increment->asset_last_usage;
        //             $assetmeter = $increment->asset_meter;
        //             $assetlastmt = $increment->asset_last_usage_mtc;
        //             $newlastusage = $lastusage + $assetmeter;
        //             DB::table('asset_mstr')
        //             ->where('asset_code','=',$req->c_assethidden)
        //             ->update(['asset_on_use' => null,
        //                 'asset_last_usage' => $req->c_lastmeasurement,
        //                 'asset_last_mtc' => $req->c_finishdate]);
        //         }
        //         else if($req->assettype == 'C'){
        //             DB::table('asset_mstr')
        //             ->where('asset_code','=',$req->c_assethidden)
        //             ->update(['asset_on_use' => null,
        //                 'asset_last_mtc' => $req->c_finishdate]);
        //         }
                
        //         $albumraw = $req->imgname;
        
        //         // dd($albumraw);
        //         $k = 0;
        //         if(isset($req->imgname)){
        //             foreach($albumraw as $olah1){
        //                 $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
        //                 // dd($waktu);
        //                 $jadi1 = explode(',', $olah1);
        //                 // a..png
        //                 $jadi2 = base64_decode($jadi1[2]);
        //                 $lenstr = strripos($jadi1[0],'.');
        //                 $test = substr($jadi1[0],$lenstr);
        //                 // dd($test);
        //                 $test3 = str_replace($test,'',$jadi1[0]);
        //                 // dd($test3);
        //                 $test4 = str_replace('.','',$test3);
        //                 $test44 = str_replace(' ','',$test4);
        //                 $test5 = $test44.$waktu.$test;
                        
        //                 $alamaturl = '../public/upload/'.$test5;
        //                 file_put_contents($alamaturl, $jadi2);

        //                 DB::table('acceptance_image')
        //                     ->insert([
        //                         'file_srnumber' => $req->c_srnbr,
        //                         'file_wonumber' => $req->c_wonbr,
        //                         'file_name' => $jadi1[0], //nama file asli
        //                         'file_url' => $alamaturl, 
        //                         'uploaded_at' => Carbon::now()->toDateTimeString(),
        //                     ]);

        //                 // $k++;

        //             }
        //         }
                
        //         toast('data reported successfuly', 'success');
        //         return redirect()->route('woreport');
        // }
        // else{
        //     dd('aaa');
            if ($req->repairtype == 'manual'){
                // dd($req->all());
                // dd(count($req->ins));
                DB::table('wo_manual_detail')
                        ->where('wo_manual_wo_nbr','=',$req->c_wonbr)
                        ->delete();
                for($pop = 0; $pop <$req->manualcount;$pop++){
                    if($req->part[$pop] != null && $req->desc[$pop] != null){
                        $arraymanual = array([
                            'wo_manual_wo_nbr'      => $req->c_wonbr,
                            'wo_manual_number'      => $pop + 1,
                            'wo_manual_ins'         => $req->ins[$pop],
                            'wo_manual_part'        => $req->part[$pop],
                            'wo_manual_desc'        => $req->desc[$pop],
                            'wo_manual_flag'        => $req->group5[$pop],
                            'wo_manual_flag2'       => $req->group51[$pop],
                            'wo_manual_qty'         => $req->qty5[$pop],
                            'wo_manual_repair_hour' => $req->rph5[$pop],
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
                    // 'wo_repair_hour'   => $req->c_repairhour,
                    'wo_finish_date'   => $req->c_finishdate,
                    'wo_finish_time'   => $finisht,
                    'wo_approval_note' => $req->c_note,
                    'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                    'wo_access'        => 0
                ];

                DB::table('wo_mstr')->where('wo_nbr','=',$req->c_wonbr)->update($arrayy);

                /* simpan file A211025 */
                if($req->hasfile('filenamewo')){
                    foreach($req->file('filenamewo') as $upload){
                        $filename = $req->c_wonbr . '-' .$upload->getClientOriginalName();
                        
                        // Simpan File Upload pada Public
                        $savepath = public_path('uploadwofinish/');
                        $upload->move($savepath, $filename);
                        
                        // Simpan ke DB Upload
                        DB::table('acceptance_image')
                            ->insert([
                                'file_srnumber' => $req->c_srnbr,
                                'file_wonumber' => $req->c_wonbr,
                                'file_name'     => $filename,//$upload->getClientOriginalName(), //nama file asli
                                'file_url'      => $savepath.$filename, 
                                'uploaded_at'   => Carbon::now()->toDateTimeString(),
                            ]); 
                    }

                } /* end simpan file A211025 */

                /* A211025
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
                } */

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

                /* A211026 disini sebetulnya ada coding untuk menyimpan data detail repair 1 2 3, tapi yang ini dihapus karena tidak digunakan. coding aslinya sudah di backup di "backup-20211026 sblm PM attach file" */
            
                //dd($req->all());
                $finisht = $req->c_finishtime.':'.$req->c_finishtimeminute;

                $arrayy = [
                    'wo_updated_at'    =>Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_status'        => 'finish',
                    'wo_repair_code1'  => $rc1,
                    'wo_repair_code2'  => $rc2,
                    'wo_repair_code3'  => $rc3,
                    'wo_repair_group'  => null,
                    'wo_repair_type'   => 'code',
                    // 'wo_repair_hour'   => $req->c_repairhour,
                    'wo_finish_date'   => $req->c_finishdate,
                    'wo_finish_time'   => $finisht,
                    'wo_approval_note' => $req->c_note,
                    'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                    'wo_access'        => 0
                ];

                DB::table('wo_mstr')->where('wo_nbr','=',$req->c_wonbr)->update($arrayy);
            
                /* simpan file A211025 */
                if($req->hasfile('filenamewo')){
                    foreach($req->file('filenamewo') as $upload){
                        $filename = $req->c_wonbr . '-' .$upload->getClientOriginalName();
                        
                        // Simpan File Upload pada Public
                        $savepath = public_path('uploadwofinish/');
                        $upload->move($savepath, $filename);
                        
                        // Simpan ke DB Upload
                        DB::table('acceptance_image')
                            ->insert([
                                'file_srnumber' => $req->c_srnbr,
                                'file_wonumber' => $req->c_wonbr,
                                'file_name'     => $filename,//$upload->getClientOriginalName(), //nama file asli
                                'file_url'      => $savepath.$filename, 
                                'uploaded_at'   => Carbon::now()->toDateTimeString(),
                            ]); 
                    }

                } /* end simpan file A211025 */

                /* A211025
                $albumraw = $req->imgname;
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
                } A211025 */

                if($req->c_srnbr != null){
                    DB::table('service_req_mstr')->where('wo_number','=',$req->c_wonbr)->update(['sr_status' => '4','sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toTimeString()]);
                }
                toast('data reported successfuly', 'success');
                return redirect()->route('woreportpage',['page' => $req->wpage, 'tmpwo' => $req->wtmpwo,
                    'tmpasset' => $req->wtempasset, 'tmpengineer' => $req->wtmpengineer, 'tmpstatus' => $req->wtmpstatus ]);

            
                // dd($arrayy);
            }
            else if($req->repairtype == 'group'){
                //dd($req->all());        
                DB::table('wo_rc_detail')
                ->where('wrd_wo_nbr','=',$req->c_wonbr)
                ->delete();
                
                $repairlen = count($req->repaircodeselection);
                for($i = 0; $i<$repairlen; $i++){
                    $rg = $req->repaircodeselection[$i];
                    //dd($rg);
                    $dborigin = DB::table('rep_master')
                                ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                                // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                                ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                                ->where('rep_master.repm_code','=',$rg)
                                // ->groupBy('spt_code')
                                ->orderBy('repdet_step')
                                ->get();
                    $countdb1 = count($dborigin);
                    // dd($countdb1);
                    //dd($dborigin);
                    $flagname = '';
                    for($j = 0; $j<$countdb1;$j++){
                        $newname = 'group'.$i;
                        if(isset($req->group4[$i][$j])){
                            $flagnow = $req->group4[$i][$j];
                            $funow   = $req->group41[$i][$j];
                            $notenow = $req->note[$i][$j];

                            $flagname .= $req->group4[$i][$j];
                        }
                        
                        $arraydetsgrp = array([
                            'wo_dets_nbr'       => $req->c_wonbr,
                            'wo_dets_rc'        => $rg,
                            'wo_dets_sp'        => $req->spm4[$i][$j],
                            'wo_dets_sp_qty'    => $req->qty4[$i][$j],
                            'wo_dets_ins'       => $req->insm4[$i][$j],
                            'wo_dets_flag'      => $flagnow,
                            'wo_dets_fu'        => $funow,
                            'wo_dets_fu_note'   => $notenow,
                            'wo_dets_rep_hour'  => $req->rph4[$i][$j],
                            'wo_dets_standard'  => $req->std4[$i][$j],
                            'wo_dets_flag'      => $req->group4[$i][$j],
                            'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                        DB::table('wo_dets')->insert($arraydetsgrp);
                        
                    }
                    

                    
                    $arrayrc1 = array([
                        'wrd_wo_nbr'      => $req->c_wonbr,
                        'wrd_repair_code' => $rg,
                        'wrd_flag'        => $flagname,
                        'wrd_created_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        'wrd_updated_at'  => Carbon::now('ASIA/JAKARTA')->toDateTimeString()
                       ]);
                    DB::table('wo_rc_detail')->insert($arrayrc1);
 
                        // dd($arraydettemp);   
                    // for($i5 = 0; $i5 < $countdb1; $i5++){  
                    //     // eval('$spnow = $req->sparepart'.strval($countrepair).');');

                            
                            
                    // }
                    // dd('stop');

                    eval('$spartnow = $req->partspare'.strval($i+1).';');
                    eval('$insspnow = $req->insspare'.strval($i+1).';');
                    eval('$spstdnow = $req->descspare'.strval($i+1).';');
                    eval('$spqtynow = $req->qtyspare'.strval($i+1).';');
                    eval('$rphspnow = $req->rphspare'.strval($i+1).';');
                    eval('$spflagnow = $req->groupspare'.strval($i+1).';');
                    eval('$spfunow = $req->groupspare'.strval($i+1).'1;');
                    eval('$spfunotenow = $req->groupspare'.strval($i+1).';');

                    for($iiiii = 0; $iiiii < $req->sparepartnum[$i];$iiiii++){
                         
                        $arraysparegrp = array([
                            'wo_dets_nbr'       => $req->c_wonbr,
                            'wo_dets_rc'        => $rg,
                            'wo_dets_sp'        => $spartnow[$iiiii],
                            'wo_dets_sp_qty'    => $spqtynow[$iiiii],
                            'wo_dets_ins'       => $insspnow[$iiiii],
                            'wo_dets_rep_hour'  => $rphspnow[$iiiii],
                            'wo_dets_standard'  => $spstdnow[$iiiii],
                            'wo_dets_flag'      => $spflagnow[$iiiii],
                            'wo_dets_fu'        => $spfunow[$iiiii],
                            'wo_dets_fu_note'   => $spfunotenow[$iiiii],
                            'wo_dets_type'      => 'addition',
                            'wo_dets_created_at'=> Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                        DB::table('wo_dets')->insert($arraysparegrp);
                   }

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
                    // 'wo_repair_hour'   => $req->c_repairhour,
                    'wo_finish_date'   => $req->c_finishdate,
                    'wo_finish_time'   => $finisht,
                    'wo_approval_note' => $req->c_note,
                    'wo_system_date'   => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_system_time'   => Carbon::now('ASIA/JAKARTA')->toTimeString(),
                    'wo_access'        => 0
                ];
                DB::table('wo_mstr')->where('wo_nbr','=',$req->c_wonbr)->update($arrayy);

                /* simpan file A211025 */
                if($req->hasfile('filenamewo')){
                    foreach($req->file('filenamewo') as $upload){
                        $filename = $req->c_wonbr . '-' .$upload->getClientOriginalName();
                        
                        // Simpan File Upload pada Public
                        $savepath = public_path('uploadwofinish/');
                        $upload->move($savepath, $filename);
                        
                        // Simpan ke DB Upload
                        DB::table('acceptance_image')
                            ->insert([
                                'file_srnumber' => $req->c_srnbr,
                                'file_wonumber' => $req->c_wonbr,
                                'file_name'     => $filename,//$upload->getClientOriginalName(), //nama file asli
                                'file_url'      => $savepath.$filename, 
                                'uploaded_at'   => Carbon::now()->toDateTimeString(),
                            ]); 
                    }

                } /* end simpan file A211025 */
                
                /* A211025
                $albumraw = $req->imgname;
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
                } */

                if($req->c_srnbr != null){
                    DB::table('service_req_mstr')->where('wo_number','=',$req->c_wonbr)->update(['sr_status' => '4','sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toTimeString()]);
                }
                toast('data reported successfuly', 'success');
                return redirect()->route('woreport',['page' => $req->wpage]);
                // dd($arrayy);
                }   
            }
    // }
       
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

    // tyas reporting wo untuk selain yang preventive
    public function reportingwoother(Request $req) {
        // dump('reportingwoother');
        // dd($req->all());
        /* A211022
        $albumraw = $req->imgname;
        if(isset($req->imgname)){
            foreach($albumraw as $olah1){
                $waktu = (string)date('dmY',strtotime(Carbon::now())).(string)date('His',strtotime(Carbon::now()));
                $jadi1 = explode(',', $olah1);
                $jadi2 = base64_decode($jadi1[2]);
                $lenstr = strripos($jadi1[0],'.');
                $test = substr($jadi1[0],$lenstr);
                $test3 = str_replace($test,'',$jadi1[0]);
                $test4 = str_replace('.','',$test3);
                $test44 = str_replace(' ','',$test4);
                $test5 = $test44.$waktu.$test;
                
                $alamaturl = '../public/upload/'.$test5;
                file_put_contents($alamaturl, $jadi2);

                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $req->o_srnbr,
                        'file_wonumber' => $req->o_wonbr,
                        'file_name' => $jadi1[0], //nama file asli
                        'file_url' => $alamaturl, 
                        'uploaded_at' => Carbon::now()->toDateTimeString(),
                    ]);
            }
        } A211022 */

        if($req->hasfile('filenames')){
            foreach($req->file('filenames') as $upload){
                $filename = $req->o_wonbr . '-' .$upload->getClientOriginalName();
                
                // Simpan File Upload pada Public
                $savepath = public_path('uploadwofinish/');
                $upload->move($savepath, $filename);
                
                // Simpan ke DB Upload
                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $req->o_srnbr,
                        'file_wonumber' => $req->o_wonbr,
                        'file_name'     => $filename,//$upload->getClientOriginalName(), //nama file asli
                        'file_url'      => $savepath.$filename, 
                        'uploaded_at'   => Carbon::now()->toDateTimeString(),
                    ]); 
            }

        }

        //update tabel wo
        $finisht = $req->o_finishtime.':'.$req->o_finishtimeminute;
        DB::table('wo_mstr')
            ->where('wo_nbr','=',$req->o_wonbr)
            ->update([
                'wo_action'         => $req->o_action,
                'wo_sparepart'      => $req->o_part,
                'wo_status'         => 'finish',
                'wo_finish_time'    => $finisht, // Carbon::now('ASIA/JAKARTA')->toTimeString(), 
                'wo_finish_date'    => $req->o_finishdate, // Carbon::now('ASIA/JAKARTA')->toDateTimeString(), 
                'wo_system_time'    => Carbon::now('ASIA/JAKARTA')->toTimeString(), 
                'wo_system_date'    => Carbon::now('ASIA/JAKARTA')->toDateTimeString(), 
                'wo_updated_at'     => Carbon::now('ASIA/JAKARTA')->toDateTimeString()      
        ]); 
          
        //update tabel sr
        DB::table("service_req_mstr")
            ->where('wo_number', '=', $req->o_wonbr)
            ->update([
                'sr_status' => 4,
                'sr_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
        ]); 
        
        toast('Data Reported Successfuly', 'success');
        // return redirect()->route('woreport');
        return redirect()->route('woreportpage',['page' => $req->opage, 'tmpwo' => $req->otmpwo,
            'tmpasset' => $req->otempasset, 'tmpengineer' => $req->otmpengineer, 'tmpstatus' => $req->otmpstatus ]);
    }

    // paging untuk reporting wo agar tidak kembali ke halaman 1
    public function woreportpage(Request $req){
        //   dd($req->all());
        $sort_by   = $req->get('sortby');
        $sort_type = $req->get('sorttype');
        $wonumber  = $req->get('tmpwo');
        $tmpasset  = $req->get('tmpasset');
        $status    = $req->get('tmpstatus');
        $tmpengineer  = $req->get('tmpengineer');
        $page      = $req->get('page');
        // $priority  = $req->get('wopriority');
        // $period    = $req->get('woperiod');

        $usernow = DB::table('users')
                ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                ->where('username','=',session()->get('username'))
                ->get();

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
                ->orderBy('asset_code')
                ->get();

        $repaircode = DB::table('rep_master')
                    ->get();

        $sparepart = DB::table('sp_mstr')
                    ->get();
        $repairgroup = DB::table('xxrepgroup_mstr')
                    ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                    ->distinct('xxrepgroup_nbr')
                    ->get();
        $instruction = DB::table('ins_mstr')
                    ->get();

        if (($wonumber == '' || $wonumber == null) and ($tmpasset == '' || $tmpasset == null) 
            and ($status == '' || $status == null)) {
            // dd('all');
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
            ->paginate(50);
            
            // return view('workorder.table-woclose', ['data' => $data,'usernow' =>$usernow]);
            return view('workorder.woclose', ['data' => $data,'user' => $engineer,'engine'=>Session()->get('username'),
            'asset1'=>$asset,'asset2'=>$asset,'repaircode'=>$repaircode,'sparepart'=>$sparepart,'repairgroup'=>$repairgroup,
            'instruction' => $instruction, 'page' => $page, 'tmpstatus' => $status, 'tmpwo' => $wonumber,
            'tmpasset' => $tmpasset]);

        } else {
            // dd('else');
            $kondisi = "wo_mstr.wo_id > 0";

            if ($wonumber != '') {
                $kondisi .= " and wo_nbr = '" . $wonumber . "'";
            }
            if ($tmpasset != '') {
                $kondisi .= " and wo_asset = '" . $tmpasset . "'";
            }
            if ($status != '') {
                $kondisi .= " and wo_status = '".$status."'";
            }
            else{
                $kondisi .= " and (wo_status = 'started' or wo_status = 'finish')";
            }
            // DD($kondisi);

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
            // ->where('wo_nbr','=','PM-21-4728')
            ->orderBy('wo_status','desc')
            ->orderby('wo_created_at','desc')
            ->orderBy('wo_mstr.wo_id', 'desc')
            // ->get();
            ->paginate(50);
            
            // return view('workorder.table-woclose', ['data' => $data,'usernow' => $usernow]);
            return view('workorder.woclose', ['data' => $data,'user' => $engineer,'engine'=>Session()->get('username'),
            'asset1'=>$asset,'asset2'=>$asset,'repaircode'=>$repaircode,'sparepart'=>$sparepart,'repairgroup'=>$repairgroup,
            'instruction' => $instruction, 'page' => $page, 'tmpstatus' => $status, 'tmpwo' => $wonumber,
            'tmpasset' => $tmpasset]);
        }
    
    }

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
                ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,
                wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, 
                wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,u1.eng_desc as u11,
                u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55, 
                loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,
                wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart
                ,wo_finish_date,wo_finish_time,wo_start')
                ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                ->leftjoin('wotyp_mstr','wo_mstr.wo_new_type','wotyp_mstr.wotyp_code')
                ->leftjoin('asset_type','asset_mstr.asset_type','asset_type.astype_code')
                ->leftjoin('loc_mstr','asset_mstr.asset_loc','loc_mstr.loc_code')
                
                ->where('wo_mstr.wo_nbr','=',$wo)
                ->get();
                // dd($data);
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
                                    ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,
                                    wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,
                                    wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,
                                    wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, 
                                    u4.eng_desc as u44, u5.eng_desc as u55,loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,
                                    wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart
                                    ,wo_finish_date,wo_finish_time,wo_start' )
                                    ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                                    ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                                    ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                                    ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                                    ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                                    ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                                    ->leftjoin('wotyp_mstr','wo_mstr.wo_new_type','wotyp_mstr.wotyp_code')
                                    ->leftjoin('asset_type','asset_mstr.asset_type','asset_type.astype_code')
                                    ->leftjoin('loc_mstr','asset_mstr.asset_loc','loc_mstr.loc_code')
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
                            ->selectRaw('wo_nbr,wo_priority,wo_dept,dept_desc,wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,
                            wo_duedate,wo_engineer1 as woen1,wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,
                            wo_engineer5 as woen5,u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, u5.eng_desc as u55,
                            loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,wo_impact,wo_impact_desc,wo_reviewer,wo_approver,
                            wo_created_at,wo_reviewer_appdate,wo_approver_appdate,wo_action,wo_sparepart,wo_finish_date,wo_finish_time,wo_start')
                            ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                            ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                            ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                            ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                            ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->leftjoin('wotyp_mstr','wo_mstr.wo_new_type','wotyp_mstr.wotyp_code')
                            ->leftjoin('asset_type','asset_mstr.asset_type','asset_type.astype_code')
                            ->leftjoin('loc_mstr','asset_mstr.asset_loc','loc_mstr.loc_code')
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

                        if(!is_null($repairdesc)) {
                            array_push($repairlist,$repairdesc->repm_desc);    
                        } 

                        $repair[$i] = DB::table('wo_mstr')
                                ->join('xxrepgroup_mstr','wo_mstr.wo_repair_group','xxrepgroup_mstr.xxrepgroup_nbr')
                                ->join('wo_dets',function($join){
                                    $join->on('wo_dets.wo_dets_nbr','=','wo_mstr.wo_nbr');
                                    $join->on('wo_dets.wo_dets_rc','=','xxrepgroup_mstr.xxrepgroup_rep_code');
                                })
                                ->join('rep_master','wo_dets.wo_dets_rc','rep_master.repm_code')
                                // ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                ->join('ins_mstr','wo_dets.wo_dets_ins','ins_mstr.ins_code')
                                ->leftjoin('sp_mstr','wo_dets.wo_dets_sp','sp_mstr.spm_code')
                                ->where('wo_mstr.wo_nbr','=',$wo)
                                ->where('xxrepgroup_mstr.xxrepgroup_rep_code','=',$arrayrepaircode[$i])
                                ->get();
                        // $repair[$i] = DB::table('xxrepgroup_mstr')
                        //                 ->leftjoin('rep_master','xxrepgroup_mstr.xxrepgroup_rep_code','rep_master.repm_code')
                        //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                        //                 // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
                        //                 // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
                        //                 // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
                        //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                        //                 // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
                        //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                        //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                        //                 // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
                        //                 ->where('xxrepgroup_mstr.xxrepgroup_nbr','=',$statusrepair->wo_repair_group)
                                        
                        //                 ->distinct('ins_mstr.ins_code')
                        //                 ->orderBy('repm_ins','asc')
                                        
                        //                 ->get();
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
                            ->selectRaw('wo_nbr,wo_repair_code1,wo_repair_code2,wo_repair_code3,wo_priority,wo_dept,dept_desc,
                            wo_note,wo_sr_nbr,wo_status,wo_asset,asset_desc,wo_schedule,wo_duedate,wo_engineer1 as woen1,
                            wo_engineer2 as woen2, wo_engineer3 as woen3,wo_engineer4 as woen4,wo_engineer5 as woen5,
                            u1.eng_desc as u11,u2.eng_desc as u22, u3.eng_desc as u33, u4.eng_desc as u44, 
                            u5.eng_desc as u55,loc_code,loc_desc,astype_code,astype_desc,wo_new_type,wotyp_desc,
                            wo_impact,wo_impact_desc,wo_reviewer,wo_approver,wo_created_at,wo_reviewer_appdate,
                            wo_approver_appdate,wo_action,wo_sparepart,wo_finish_date,wo_finish_time,wo_start')
                            ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                            ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                            ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                            ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                            ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                            ->leftjoin('wotyp_mstr','wo_mstr.wo_new_type','wotyp_mstr.wotyp_code')
                            ->leftjoin('asset_type','asset_mstr.asset_type','asset_type.astype_code')
                            ->leftjoin('loc_mstr','asset_mstr.asset_loc','loc_mstr.loc_code')
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
                                        
                        if(!is_null($repairdesc)) {
                            array_push($repairlist,$repairdesc->repm_desc);    
                        }                
                        
                        $repair[$i] = DB::table('wo_mstr')
                                ->leftjoin('wo_dets','wo_dets.wo_dets_nbr','wo_mstr.wo_nbr')
                                ->leftjoin('ins_mstr','wo_dets.wo_dets_ins','ins_mstr.ins_code')
                                ->leftjoin('rep_master','wo_dets.wo_dets_rc','rep_master.repm_code')
                                // ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                
                                ->leftjoin('sp_mstr','wo_dets.wo_dets_sp','sp_mstr.spm_code')
                                ->where('wo_mstr.wo_nbr','=',$wo)
                                ->where('wo_dets.wo_dets_rc','=',$arrayrepaircode[$i])
                                
                                // ->groupBy('wo_mstr.wo_nbr','ins_mstr.ins_code')
                                ->distinct('ins_mstr.ins_code')
                                ->orderBy('repm_ins','asc')
                                ->get();
                        // dd($repair);
                        // $repair[$i] = DB::table('rep_master')
                        //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                        //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                        //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                        //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                        //                 ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
                        //                 ->distinct('ins_mstr.ins_code')
                        //                 ->orderBy('repm_ins','asc')
                                        
                        //                 ->get();
        
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
        
        // $printdate = Carbon::now('ASIA/JAKARTA')->toDateString();
        // request date diambil dari create SR, jika tidak ada SR maka diambil dari create date WO
        $ceksr = DB::table('service_req_mstr')
            ->whereWo_number($wo)
            ->first();

        if(isset($ceksr)) {
            $printdate = $ceksr->sr_created_at;
        } else {
            $printdate = $womstr->wo_created_at;
        }
        // dd($repair);
        foreach($repair as $repair){
            foreach ($repair as $repair1){
                // dd($repair1);
                if(!in_array($repair1->spm_desc,$sparepartarray)){
                    array_push($sparepartarray,$repair1->spm_desc);
                }
                
            }
            
        }

        /* A211014 */
        $users = DB::table('users')->get();
        $datasr = DB::table('service_req_mstr')
            ->whereWo_number($wo)
            ->first();

        // $pdf = PDF::loadview('workorder.pdfprint-template',['womstr' => $womstr,'wodet' => $wodet, 'data' => $data,'printdate' =>$printdate,'repair'=>$repair,'sparepart'=>$array])->setPaper('A4','portrait');
        $pdf = PDF::loadview('workorder.pdfprint-template',['sparepart'=>$sparepartarray,'womstr' => $womstr,
        'repairlist'=>$repairlist,'data' => $data,'repair'=>$repair,'counter'=>0,'countdb'=>$countdb,
        'check'=>$checkstr,'countrepairitre' => $countrepairitr,'printdate'=>$printdate,'engineerlist'=>$engineerlist,
        'users'=>$users,'datasr'=>$datasr])->setPaper('A4','portrait');
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
        // dd($statusrepair);
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
            // dd($datamanual);
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
                // $repair[$i] = DB::table('xxrepgroup_mstr')
                //                 ->leftjoin('rep_master','xxrepgroup_mstr.xxrepgroup_rep_code','rep_master.repm_code')
                //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                //                 // ->join('rep_partgroup','rep_master.repm_part','rep_partgroup.reppg_code')
                //                 // ->join('sp_mstr','rep_partgroup.reppg_part','sp_mstr.spm_code')
                //                 // ->join('sp_type','sp_mstr.spm_type','sp_type.spt_code')
                //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                //                 // ->leftjoin('sp_group','ins_mstr.ins_part','sp_group.spg_code')
                //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                //                 // ->leftjoin('tool_mstr','ins_mstr.ins_tool','tool_mstr.tool_code')
                //                 ->where('xxrepgroup_mstr.xxrepgroup_nbr','=',$statusrepair->wo_repair_group)
                //                 ->where('xxrepgroup_mstr.xxrepgroup_rep_code','=',$arrayrepaircode[$i])
                //                 ->distinct('ins_mstr.ins_code')
                //                 ->orderBy('repm_ins','asc')
                                
                //                 ->get();

                $repair[$i] = DB::table('wo_mstr')
                                ->join('xxrepgroup_mstr','wo_mstr.wo_repair_group','xxrepgroup_mstr.xxrepgroup_nbr')
                                ->join('wo_dets',function($join){
                                    $join->on('wo_dets.wo_dets_nbr','=','wo_mstr.wo_nbr');
                                    $join->on('wo_dets.wo_dets_rc','=','xxrepgroup_mstr.xxrepgroup_rep_code');
                                })
                                ->join('rep_master','wo_dets.wo_dets_rc','rep_master.repm_code')
                                // ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                ->join('ins_mstr','wo_dets.wo_dets_ins','ins_mstr.ins_code')
                                ->leftjoin('sp_mstr','wo_dets.wo_dets_sp','sp_mstr.spm_code')
                                ->where('wo_mstr.wo_nbr','=',$wo)
                                ->where('xxrepgroup_mstr.xxrepgroup_rep_code','=',$arrayrepaircode[$i])
                                ->get();
                //dd($repair);
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
            // dd($statusrepair);
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
                // dd($arrayrepaircode[$i]);
                    $repair[$i] = DB::table('wo_mstr')
                                ->join('wo_dets','wo_dets.wo_dets_nbr','wo_mstr.wo_nbr')
                                ->join('ins_mstr','wo_dets.wo_dets_ins','ins_mstr.ins_code')
                                ->join('rep_master','wo_dets.wo_dets_rc','rep_master.repm_code')
                                // ->join('rep_det','rep_master.repm_code','rep_det.repdet_code')
                                
                                ->leftjoin('sp_mstr','wo_dets.wo_dets_sp','sp_mstr.spm_code')
                                ->where('wo_mstr.wo_nbr','=',$wo)
                                ->where('wo_dets.wo_dets_rc','=',$arrayrepaircode[$i])
                                
                                // ->groupBy('wo_mstr.wo_nbr','ins_mstr.ins_code')
                                ->distinct('ins_mstr.ins_code')
                                ->orderBy('repm_ins','asc')
                                ->get();
                                // dd('aaa');
                    // dd($repair);
                // $repair[$i] = DB::table('rep_master')
                //                 ->leftjoin('rep_det','rep_master.repm_code','rep_det.repdet_code')
                //                 ->leftjoin('ins_mstr','rep_det.repdet_ins','ins_mstr.ins_code')
                //                 // ->leftjoin('rep_part','ins_mstr.ins_part','rep_part.reppart_code')
                //                 ->leftjoin('sp_mstr','ins_mstr.ins_part','sp_mstr.spm_code')
                //                 ->where('rep_master.repm_code','=',$arrayrepaircode[$i])
                //                 ->distinct('ins_mstr.ins_code')
                //                 ->orderBy('repm_ins','asc')
                //                 ->get();

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
        // foreach ($repair as $repair1){
        //     if(count($repair1) == 0){
        //         dd(count($repair1));
        //     }
            
        // }
        $printdate = Carbon::now('ASIA/JAKARTA')->toDateTimeString();
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
    
    public function donlodwo(Request $req) { /* route : donlodwo */
//dd($req->all());
        $wonbr    = $req->wonumber;
        $asset    = $req->asset;
        $status   = $req->status;
        $priority = $req->priority;
        $period   = '';//$req->period;
        $creator  = $req->creator;
        $engineer = $req->engineer;
        $woper1    = $req->get('woper1');
        $woper2    = $req->get('woper2');
        $wotype    = $req->get('wotype');
        $woimpact  = $req->get('woimpact');

        return Excel::download(new ViewExport2($wonbr,$status,$asset,$priority,$period,$creator,$engineer,$woper1,$woper2,$wotype,$woimpact),'Work Order.xlsx');
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
        // dd($repair1);
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

    // approval WO Finish
    public function statusreportingwo(Request $req){
        // dd($req->all());
        $wonumber = $req->aprwonbr2;
        $srnbr = $req->aprsrnbr2;
        $wonote = $req->ac_reportnote;

        if($req->hasfile('fileother')){
            foreach($req->file('fileother') as $upload){
                $filename = $wonumber . '-' .$upload->getClientOriginalName();
                
                $cekfile = DB::table('acceptance_image')
                    ->whereFile_wonumber($wonumber)
                    ->wherefile_name($filename)
                    ->count();

                if($cekfile > 0) {
                    toast('File names cannot be same.', 'error');
                    return back();
                }

                // Simpan File Upload pada Public
                $savepath = public_path('uploadwofinish/');
                $upload->move($savepath, $filename);
                
                // Simpan ke DB Upload
                DB::table('acceptance_image')
                    ->insert([
                        'file_srnumber' => $srnbr,
                        'file_wonumber' => $wonumber,
                        'file_name'     => $filename,//$upload->getClientOriginalName(), //nama file asli
                        'file_url'      => $savepath.$filename, 
                        'uploaded_at'   => Carbon::now()->toDateTimeString(),
                    ]); 
            }

        }

        if($srnbr == null){
            // dd('1');
            if($req->switch2 =='approve'){
                //dd('aa');
                // $exprc = explode(',',$req->repaircodeapp);

                if($req->formtype == 1){
                    DB::table('wo_mstr')
                        ->where('wo_nbr', '=', $wonumber)
                        ->update([
                            'wo_status' => 'closed',
                            'wo_approval_note' => $wonote , //B211019
                            'wo_reviewer' => Session::get('username'),
                            'wo_approver' => Session::get('username'),
                            'wo_approver_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                            'wo_reviewer_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()
                        ]);

                    $wonow = DB::table('wo_mstr')
                        ->where('wo_nbr','=',$wonumber)
                        ->first();

                    DB::table('asset_mstr')
                        ->where('asset_code','=',$wonow->wo_asset)
                        ->update(['asset_on_use' => NULL]);

                    toast('Work Order '.$wonumber.' Approved by reviewer ', 'success');

                    // 2022.11.30 return redirect()->route('womaint');
                    return redirect()->route('womaintpage',['page' => $req->apage, 'tmpwo' => $req->atmpwo,
                        'tmpasset' => $req->atmpasset, 'tmpstatus' => $req->atmpstatus, 'tmpengineer' => $req->atmpengineer,
                        'tmpper1' => $req->atmpper1, 'tmpper2' => $req->atmpper2, 'tmpwotype' => $req->atmpwotype,
                        'tmpreqby' => $req->atmpreqby, 'tmpimpact' => $req->atmpimpact]);
                }
                else if($req->formtype == 2){
                    DB::table('wo_mstr')
                        ->where('wo_nbr', '=', $wonumber)
                        ->update([
                            'wo_status' => 'closed',
                            'wo_approval_note' => $wonote , //B211019
                            'wo_reviewer' => Session::get('username'),
                            'wo_approver' => Session::get('username'),
                            'wo_approver_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                            'wo_reviewer_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()
                        ]);
                        $wonow = DB::table('wo_mstr')
                            ->where('wo_nbr','=',$wonumber)
                            ->first();
                        DB::table('asset_mstr')
                            ->where('asset_code','=',$wonow->wo_asset)
                            ->update(['asset_on_use' => NULL]);
                        toast('Work Order '.$wonumber.' Approved by reviewer ', 'success');
                        // 2022.11.30 return redirect()->route('womaint');
                        return redirect()->route('womaintpage',['page' => $req->apage, 'tmpwo' => $req->atmpwo,
                        'tmpasset' => $req->atmpasset, 'tmpstatus' => $req->atmpstatus, 'tmpengineer' => $req->atmpengineer,
                        'tmpper1' => $req->atmpper1, 'tmpper2' => $req->atmpper2, 'tmpwotype' => $req->atmpwotype,
                        'tmpreqby' => $req->atmpreqby, 'tmpimpact' => $req->atmpimpact]);
                }


            } /* if($req->switch2 =='approve') */
            else{
                
                DB::table('wo_mstr')
                ->where('wo_nbr',$wonumber)
                // ->update(['wo_status'=>'closed','wo_reject_reason'=>$req->uncompletenote]); --> A210927
                ->update([
                    'wo_status'=>'reprocess',
                    'wo_reject_reason'=>$req->uncompletenote,
                    'wo_approval_note' => $wonote , //B211019
                    'wo_reviewer' => Session::get('username'),
                    'wo_approver' => Session::get('username'),
                    'wo_approver_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_reviewer_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()
                ]);

                $wonow = DB::table('wo_mstr')
                            ->where('wo_nbr','=',$wonumber)
                            ->first();

                /* DB::table('asset_mstr')
                    ->where('asset_code','=',$wonow->wo_asset)
                    ->update(['asset_on_use' => NULL]); A211019 */

                toast('Work Order '.$wonumber.' incomplete ', 'success');
                // 2022.11.30 return redirect()->route('womaint');
                return redirect()->route('womaintpage',['page' => $req->apage, 'tmpwo' => $req->atmpwo,
                        'tmpasset' => $req->atmpasset, 'tmpstatus' => $req->atmpstatus, 'tmpengineer' => $req->atmpengineer,
                        'tmpper1' => $req->atmpper1, 'tmpper2' => $req->atmpper2, 'tmpwotype' => $req->atmpwotype,
                        'tmpreqby' => $req->atmpreqby, 'tmpimpact' => $req->atmpimpact]);
            } /* else if($req->switch2 =='approve')*/


        } else{ /* if($srnbr == null) */  

            if($req->switch2 =='approve'){
                // $exprc = explode(',',$req->repaircodeapp);
                if($req->formtype == 1){
                    DB::table('wo_mstr')
                        ->where('wo_nbr', '=', $wonumber)
                        ->update([
                            'wo_status' => 'completed',
                            'wo_approval_note' => $wonote , //B211019
                            'wo_reviewer' => Session::get('username'),
                            'wo_reviewer_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()
                    ]);

                    // A210927
                    if($srnbr !== null){
                        DB::table('service_req_mstr')
                            ->where('sr_number', '=', $srnbr)
                            ->update([
                                'sr_status' => '7',
                        ]);
                    }

                    toast('Work Order '.$wonumber.' Approved by reviewer ', 'success');
                    // 2022.11.30 return redirect()->route('womaint');
                    return redirect()->route('womaintpage',['page' => $req->apage, 'tmpwo' => $req->atmpwo,
                        'tmpasset' => $req->atmpasset, 'tmpstatus' => $req->atmpstatus, 'tmpengineer' => $req->atmpengineer,
                        'tmpper1' => $req->atmpper1, 'tmpper2' => $req->atmpper2, 'tmpwotype' => $req->atmpwotype,
                        'tmpreqby' => $req->atmpreqby, 'tmpimpact' => $req->atmpimpact]);
                }
                else if ($req->formtype == 2){
            
                    // dd('lg maintenance');
                    
                    // $albumraw = $req->imgname;
                        DB::table('wo_mstr')
                                ->where('wo_nbr', '=', $wonumber)
                                ->update([
                                    'wo_status' => 'closed',
                                    'wo_approval_note' => $wonote , //B211019
                                    'wo_approver' => Session::get('username'),
                                    'wo_approver_appdate' => Carbon::now('ASIA/JAKARTA')->toDateString()
                                    
                                ]);

                    // A210927
                    if($srnbr !== null){
                        DB::table('service_req_mstr')
                                ->where('sr_number', '=', $srnbr)
                                ->update([
                                    'sr_status' => '7',
                                ]);
                    }
            
                    toast('Work Order '.$wonumber.' Completed ', 'success');
                    // 2022.11.30 return redirect()->route('womaint');
                    return redirect()->route('womaintpage',['page' => $req->apage, 'tmpwo' => $req->atmpwo,
                        'tmpasset' => $req->atmpasset, 'tmpstatus' => $req->atmpstatus, 'tmpengineer' => $req->atmpengineer,
                        'tmpper1' => $req->atmpper1, 'tmpper2' => $req->atmpper2, 'tmpwotype' => $req->atmpwotype,
                        'tmpreqby' => $req->atmpreqby, 'tmpimpact' => $req->atmpimpact]);
                }

                // A210927
                if($srnbr !== null){
                    DB::table('service_req_mstr')
                            ->where('sr_number', '=', $srnbr)
                            ->update([
                                'sr_status' => '7',
                            ]);
                }
            
            }else{
        
                DB::table('wo_mstr')
                ->where('wo_nbr',$wonumber)
                // ->update(['wo_status'=>'closed','wo_reject_reason'=>$req->uncompletenote]); --> A210927
                ->update([
                    'wo_status'=>'reprocess',
                    'wo_reject_reason'=>$req->uncompletenote,
                    'wo_approval_note' => $wonote , //B211019
                ]);
                toast('Work Order '.$wonumber.' reprocess ', 'success');

                // A210927  --> A211019 --> A211101
                if($srnbr !== null){
                    DB::table('service_req_mstr')
                            ->where('sr_number', '=', $srnbr)
                            ->update([
                                'sr_status' => '8',
                            ]);
                }

                // 2022.11.30 return redirect()->route('womaint');
                return redirect()->route('womaintpage',['page' => $req->apage, 'tmpwo' => $req->atmpwo,
                        'tmpasset' => $req->atmpasset, 'tmpstatus' => $req->atmpstatus, 'tmpengineer' => $req->atmpengineer,
                        'tmpper1' => $req->atmpper1, 'tmpper2' => $req->atmpper2, 'tmpwotype' => $req->atmpwotype,
                        'tmpreqby' => $req->atmpreqby, 'tmpimpact' => $req->atmpimpact]);
            }

            //EmailScheduleJobs::dispatch($wonumber,'','6','','',$srnbr,''); // A211021
        } /* else if($srnbr == null)   */

    }

    //fungsi untuk menampung page yang sama setelah submit
    public function womaintpage(Request $req){

        // $sort_by   = $req->get('sortby');
        // $sort_type = $req->get('sorttype');
        $wonumber  = $req->get('tmpwo');
        $passet     = $req->get('tmpasset');
        $status    = $req->get('tmpstatus');
        //$priority  = $req->get('wopriority');
        $pengineer  = $req->get('tmpengineer');
        $per1      = $req->get('tmpper1');
        $per2      = $req->get('tmpper2');
        $pwotype    = $req->get('tmpwotype');
        $woreqby   = $req->get('tmpreqby');
        $pwoimpact  = $req->get('tmpimpact');
        $page = $req->page;
        // dd($req->all());

        $usernow = DB::table('users')
                ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                ->where('username','=',session()->get('username'))
                ->get();
                
        $depart = DB::table('dept_mstr')
                    ->get();
        $engineer = DB::table('eng_mstr')
                    ->where('eng_active','=','Yes')
                    ->get();
        $asset = DB::table('asset_mstr')
                    ->where('asset_active','=','Yes')
                    ->orderBy('asset_code')
                    ->get();
        $failure = DB::table('fn_mstr')
                    ->get();
        $repaircode = DB::table('rep_master')
                    ->get();
        $repairgroup = DB::table('xxrepgroup_mstr')
                    ->selectRaw('xxrepgroup_nbr,xxrepgroup_desc')
                    ->distinct('xxrepgroup_nbr')
                    ->get();
        $impact = DB::table('imp_mstr')
                    ->get();
        $wottype = DB::table('wotyp_mstr')
                    ->get();
        $asgroup = DB::table('asset_group')
            ->orderBy('asgroup_code')
            ->get();

        $custrnow = DB::table('wo_mstr')
                        ->selectRaw('wo_creator,min(name) as creator_desc')
                        ->join('users','wo_mstr.wo_creator','users.username')
                        ->groupBy('wo_creator')
                        ->get();

        $usernow = DB::table('users')
                ->leftjoin('eng_mstr','users.username','eng_mstr.eng_code')
                ->where('username','=',session()->get('username'))
                ->get();

        if ($wonumber == '' and $passet == '' and $status == '' and $pengineer =='' and $per1 == '' and $per2 == '' 
        and $pwotype == '' and $woreqby == '' and $pwoimpact == '') {
            // dd('all');        
                $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->orderby('wo_created_at','desc')
                ->orderBy('wo_mstr.wo_nbr', 'desc')
                ->paginate(50);

                // return view('workorder.table-wobrowse', ['data' => $data,'usernow' =>$usernow]);
                return view('workorder.wobrowse', ['impact' => $impact, 'wottype'=>$wottype,'repairgroup' => $repairgroup,'data' => $data,'user' => $engineer,
                'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '',
                'repaircode' => $repaircode, 'custrnow' => $custrnow, 'asgroup' => $asgroup, 'page' => $page, 'tmpwo' => '',
                'tmpasset' => '', 'tmpstatus' => '', 'tmpengineer' => '', 'tmpper1' => '', 'tmpper2' => '', 'tmpreqby' => '',
                'tmpwotype' => '', 'tmpimpact' => '']);
        } else {
            // dd('else');
            $kondisi = "wo_mstr.wo_id > 0";

            if ($wonumber != '') {
                $kondisi .= " and wo_nbr = '" . $wonumber . "'";
            }
            if ($passet != '') {
                $kondisi .= " and asset_code = '" . $passet . "'";
            }
            if ($status != '') {
                $kondisi .= " and wo_status = '" . $status . "'";
            }

            if ($pengineer != ''){
                $kondisi .= " and (wo_engineer1 = '". $pengineer . "' or wo_engineer2 = '".$pengineer."' or wo_engineer3 = '".$pengineer."' or wo_engineer4 = '".$pengineer."' or wo_engineer5 = '".$pengineer."')";
            }
            if ($per1 != '' and $per2 != ''){
                $kondisi .= " and CAST(wo_created_at AS DATE) between '". $per1 ."' and '". $per2 ."'";
            }
            if ($woreqby != ''){
                $kondisi .= " and wo_creator = '". $woreqby ."'";
            }
            if ($pwotype != '') {
                $kondisi .= " and asset_group = '". $pwotype ."'";
            }
            if ($pwoimpact != '' ) {
                $kondisi .= " and wo_new_type = '" .$pwoimpact. "'";
            }
            
            // dd($kondisi);
            $data = DB::table('wo_mstr')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->whereRaw($kondisi)
                ->orderBy('wo_mstr.wo_id', 'desc')
                ->paginate(50);
            
            // return view('workorder.table-wobrowse', ['data' => $data,'usernow' => $usernow]);
            return view('workorder.wobrowse', ['impact' => $impact, 'wottype'=>$wottype,'repairgroup' => $repairgroup,'data' => $data,'user' => $engineer,
                'engine'=>$engineer,'asset1'=>$asset,'asset2'=>$asset,'failure' =>$failure,'usernow' =>$usernow,'dept'=>$depart,'fromhome' => '',
                'repaircode' => $repaircode, 'custrnow' => $custrnow, 'asgroup' => $asgroup, 'page' => $page, 'tmpwo' => $wonumber,
                'tmpasset' => $passet, 'tmpstatus' => $status, 'tmpengineer' => $pengineer, 'tmpper1' => $per1, 'tmpper2' => $per2,
                'tmpreqby' => $woreqby, 'tmpwotype' => $pwotype, 'tmpimpact' => $pwoimpact]);
        }
    }

    public function downloadfile(Request $req, $wo){ /* blade : workorder.table-wobrowse */
        $zip = new ZipArchive;

        $assetnow = DB::table('wo_mstr')
                    ->where('wo_nbr','=',$wo)
                    ->first();

        $listdownload = DB::table('asset_upload')
                        ->where('asset_code','=',$assetnow->wo_asset)
                        ->get();

        /* A211103 */
        $listfinish = DB::table('acceptance_image')
            ->whereFile_wonumber($wo)
            ->get();

         $fileName = $wo.'_'.$assetnow->wo_asset.'.zip';

         if(count($listdownload) > 0 || count($listfinish) > 0){
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
            {
                foreach ($listdownload as $listdown){
                    $files = File::get($listdown->filepath);
                    $relativeNameInZipFile = basename($listdown->filepath);
                    $zip->addFile($listdown->filepath, $relativeNameInZipFile);
                } 

                /* A211103 */
                foreach ($listfinish as $listfinish) {
                    $files = File::get($listfinish->file_url);
                    $relativeNameInZipFile = basename($listfinish->file_url);
                    $zip->addFile($listfinish->file_url, $relativeNameInZipFile);
                }

                $zip->close();
            }
        
            return response()->download(public_path($fileName));
        }
        else{
             toast('Tidak ada dokumen untuk pada WO '.$wo.'!','error');
            return back();
        }
    }

    public function getpreventivecreate($asset){
        $assetnow = DB::table('asset_mstr')
                    ->where('asset_code','=',$asset)
                    ->first();

        // return 
    }

    public function downloadwofinish($id)
    {
        
        $datafile = DB::table('acceptance_image')
                    ->where('accept_img_id','=',$id)
                    ->first();

        if($datafile){

            $lastindex = strrpos($datafile->file_url, "/");
            $filename = substr($datafile->file_wonumber.'-'.$datafile->file_name, $lastindex + 1);

            return Response::download($datafile->file_url, $datafile->file_name);
        }else{
            toast('There is no file', 'error');
            return back();
        }
    }

    public function delfilewofinish($id){

        $data1 = DB::table('acceptance_image')
                    ->where('accept_img_id',$id)
                    ->first();

        if($data1){
            $lastindex = strrpos($data1->file_url, "/");
            $filename = substr($data1->file_url, $lastindex + 1);

            $filename = public_path('/uploadwofinish/'.$filename);

            if(File::exists($filename)) {
                File::delete($filename);

                DB::table('acceptance_image')
                            ->where('accept_img_id',$id)
                            ->delete();
            }
        }

        $gambar = DB::table('acceptance_image')
                    ->where('file_wonumber', '=', $data1->file_wonumber)
                    ->get();

        $output = "";
        foreach($gambar as $gambar) {
            $output .= '<tr>
                    <td><a href="#" class="btn deleterow btn-danger"><i class="icon-table fa fa-trash fa-lg"></i></a>
                    &nbsp
                    <input type="hidden" value="'.$gambar->accept_img_id.'" class="rowval"/>
                    <td><a href="/downloadwofinish/'.$gambar->accept_img_id.'" target="_blank">'.$gambar->file_name.'</a></td>
                </tr>';
        }

        return response($output);
    }

}
//tanggal betulin 24 may 2021 - 1553