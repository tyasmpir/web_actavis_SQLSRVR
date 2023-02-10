<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Response;
use PDF;
use App\Jobs\EmailScheduleJobs;
use App;


class UsageController extends Controller
{
    public function index(Request $req){

        if($req->ajax()){
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $asset  = $req->get('asset');

            if($asset == ''){
                $data = DB::table('asset_mstr')
                            // ->leftJoin('asset_usage_hist','asset_mstr.asset_code','=','asset_usage_hist.asset_code')
                            ->where('asset_measure','=','M')
                            ->selectRaw('*, asset_mstr.asset_code as "assetcode"')
                            // ->groupBy('asset_mstr.asset_code')
                            // ->orderBy('asset_usage_hist.last_checked')
                            ->orderby($sort_by, $sort_type)
                            ->paginate(10);
                            
            }else{
                $data = DB::table('asset_mstr')
                            // ->leftJoin('asset_usage_hist','asset_mstr.asset_code','=','asset_usage_hist.asset_code')
                            ->where('asset_measure','=','M')
                            ->where('asset_mstr.asset_code','=',$asset)
                            ->selectRaw('*, asset_mstr.asset_code as "assetcode"')
                            // ->groupBy('asset_mstr.asset_code')
                            // ->orderBy('asset_usage_hist.last_checked')
                            ->orderby($sort_by, $sort_type)
                            ->paginate(10);

            }

            return view('schedule.table-usage', ['data' => $data]);


        }else{
            $data = DB::table('asset_mstr')
                        // ->leftJoin('asset_usage_hist','asset_mstr.asset_code','=','asset_usage_hist.asset_code')
                        ->where('asset_measure','=','M')
                        ->selectRaw('*, asset_mstr.asset_code as "assetcode"')
                        // ->groupBy('asset_mstr.asset_code')
                        ->orderBy('asset_mstr.asset_code')
                        ->paginate(10);

            $asset = DB::table('asset_mstr')
                            ->get();
        

            return view('schedule.usage',['data' => $data, 'asset' => $asset]);
        }

        
    }

    public function updateusage(Request $req){
		
        $checkdata = DB::table('asset_mstr')
                    ->where('asset_code','=',$req->e_asset)
                    ->first();

        if($checkdata){

            if(is_null($checkdata->asset_last_usage)){
                DB::table('asset_mstr')
                    ->where('asset_code','=',$req->e_asset)
                    ->update([
                            'asset_last_usage' => $req->e_current,
                            'asset_last_usage_mtc' => $req->e_current,
                    ]);
            }else{
                $nextusage = $checkdata->asset_last_usage + $checkdata->asset_meter;

                // if($nextusage <= $req->e_current){
                  //               DB::table('asset_mstr')
                  //               ->where('asset_code','=',$req->e_asset)
                  //               ->update([
                  //                       'asset_last_usage' => $req->e_current,
                  //                       'asset_last_usage_mtc' => $req->e_current,
                  //               ]);
                                
                  //               // Buat WO

                  //               $tablern = DB::table('running_mstr')
                  //                           ->first();

                  //               $tempnewrunnbr = strval(intval($tablern->wt_nbr)+1);
                  //               $newtemprunnbr = '';

                  //               if(strlen($tempnewrunnbr) <= 4){
                  //               $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
                  //               }

                  //               $runningnbr = $tablern->wt_prefix.'-'.$tablern->year.'-'.$newtemprunnbr;
                                
                  //               // dd($runningnbr);
                  //               $dataarray = array(
                  //                   'wo_nbr' => $runningnbr,
                  //                   'wo_status' => 'plan',
            						// 'wo_priority' => 'high',
            						// 'wo_dept' => 'ENG',
                  //                   'wo_asset' => $req->e_asset, 
                  //                   'wo_schedule' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                  //                   'wo_duedate' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                  //                   'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                  //                   'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                  //                   'wo_type'       => 'auto',
                  //               );

                  //               DB::table('wo_mstr')->insert($dataarray);

                  //               DB::table('running_mstr')
                  //                   ->update([
                  //                       'wt_nbr' => $newtemprunnbr
                  //                   ]);


                  //               DB::table('asset_mstr')
                  //                       ->where('asset_code',$req->asset_code)
                  //                       ->update([
                  //                           'asset_on_use' => $runningnbr,
                  //                       ]);

                  //               // Kirim Email
                  //               $assettable = DB::table('asset_mstr')
                  //                           ->where('asset_code','=',$req->e_asset)
                  //                           ->first();
                            
                  //               $asset = $req->e_asset.' - '.$assettable->asset_desc;

                  //               EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');

                  //               toast('Data Updated & WO Succesfully Created', 'success');
                  //               return back();
                // }else{
                    DB::table('asset_mstr')
                    ->where('asset_code','=',$req->e_asset)
                    ->update([
                            'asset_last_usage_mtc' => $req->e_current,
                    ]);
                // }
            }


            toast('Data Updated', 'success');
            return back();

        }else{
            toast('Error No data Available', 'error');
            return back();
        }
    }


    public function usagemulti(Request $req){
        if($req->ajax()){
            $sort_by   = $req->get('sortby');
            $sort_type = $req->get('sorttype');
            $asset  = $req->get('asset');

            if($asset == ''){
                $data = DB::table('asset_mstr')
                            // ->leftJoin('asset_usage_hist','asset_mstr.asset_code','=','asset_usage_hist.asset_code')
                            ->selectRaw('*, asset_mstr.asset_code as "assetcode"')
                            // ->groupBy('asset_mstr.asset_code')
                            // ->orderBy('asset_usage_hist.last_checked')
                            ->orderby($sort_by, $sort_type)
                            ->paginate(10);
                            
            }else{
                $data = DB::table('asset_mstr')
                            // ->leftJoin('asset_usage_hist','asset_mstr.asset_code','=','asset_usage_hist.asset_code')
                            ->where('asset_mstr.asset_code','=',$asset)
                            ->selectRaw('*, asset_mstr.asset_code as "assetcode"')
                            // ->groupBy('asset_mstr.asset_code')
                            // ->orderBy('asset_usage_hist.last_checked')
                            ->orderby($sort_by, $sort_type)
                            ->paginate(10);
            }

            return view('schedule.table-usage_multi', ['data' => $data]);

        }else{
            $data = DB::table('asset_mstr')
                        ->selectRaw('*, asset_mstr.asset_code as "assetcode"')
                        ->orderBy('assetcode')              
                        ->paginate(10);

            $asset = DB::table('asset_mstr')
                    ->orderBy('asset_mstr.asset_code')
                    ->get();

            return view('schedule.usage_multi',['data' => $data, 'asset' => $asset]);
        }
    }


    public function updateusagemulti(Request $req){
        //dd($req->asset_code);
        
        // Mencari Nomor PM
        $tablern = DB::table('running_mstr')
                    ->first();

        $tempnewrunnbr = strval(intval($tablern->wt_nbr)+1);
        $newtemprunnbr = '';

        if(strlen($tempnewrunnbr) <= 4){
        $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
        }

        $runningnbr = $tablern->wt_prefix.'-'.$tablern->year.'-'.$newtemprunnbr;

        //Mencari engineering
        $dataeng = DB::table('users')
                ->whereRole_user('TECH')
                ->whereActive('Yes')
                ->orderBy('username')
                ->take(5)
                ->get();

        $techjml = $dataeng->count();
        $techeng = [];
        foreach ($dataeng as $dataeng) {
            $techeng[] = $dataeng->username;
        }

        if ($techjml < 5) {
            for ($i = 0; $i < 5 - $techjml; $i++){
                $techeng[] = "";
            }
        }

        // mencari data repair
        $repaset = DB::table('asset_mstr')
            ->whereAsset_code($req->asset_code)
            ->first();
//dd($repaset->asset_repair_type);
        $repcode1 = "";
        $repcode2 = "";
        $repcode3 = "";
        $repgroup = "";
        if ($repaset->asset_repair_type == 'group') {
            $repgroup = $repaset->asset_repair;
        } else if ($repaset->asset_repair_type == 'code') {
            $a = explode(",", $repaset->asset_repair);

            $repcode1 = $a[0];
            if(isset($a[1])) {
                $repcode2 = $a[1];
            }
            if(isset($a[2])) {
                $repcode3 = $a[2];
            }
        } else {
            $rep = "";
        }


        //Insert data
        $dataarray = array(
            'wo_nbr' => $runningnbr,
            'wo_status' => 'open',
            'wo_engineer1' => $techeng[0], 
            'wo_engineer2' => $techeng[1], 
            'wo_engineer3' => $techeng[2], 
            'wo_engineer4' => $techeng[3], 
            'wo_engineer5' => $techeng[4], 
            'wo_priority' => 'high',
            'wo_repair_type' => $repaset->asset_repair_type,
            'wo_repair_group' => $repgroup,
            'wo_repair_code1' => $repcode1,
            'wo_repair_code2' => $repcode2,
            'wo_repair_code3' => $repcode3, 
            'wo_asset' => $req->asset_code, 
            'wo_dept' => 'ENG', // Hardcode
            'wo_type'  => 'auto', // Hardcode
            'wo_schedule' => Carbon::now('ASIA/JAKARTA')->toDateString(),
            'wo_duedate' => Carbon::now('ASIA/JAKARTA')->endOfMonth()->toDateString(),
            'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
            'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
        );

        DB::table('wo_mstr')->insert($dataarray);

        DB::table('running_mstr')
            ->update([
                'wt_nbr' => $newtemprunnbr
            ]);

        DB::table('asset_mstr')
                ->where('asset_code',$req->asset_code)
                ->update([
                    'asset_on_use' => $runningnbr,
                ]);

        // Kirim Email
        $assettable = DB::table('asset_mstr')
                    ->where('asset_code','=',$req->asset_code)
                    ->first();

        $asset = $req->asset_code.' - '.$assettable->asset_desc;

        EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');

        toast('Data Updated & WO Succesfully Created', 'success');
        return back();

    }

    public function usageneedmt(Request $req){
        // dd($req->all());
        if($req->ajax()){
            
            $output = '';

            if($req->search == 'All'){
                $data = DB::table('asset_mstr')
                    ->where('asset_measure','=','C')
                    ->whereRaw('DATEDIFF(DAY, DATEADD(DAY, asset_cal, asset_last_mtc), GETDATE()) >= - asset_tolerance') // fungsi MYSQL
                    ->whereRaw("(asset_on_use is null or asset_on_use = '')")
                    ->get();
            }else{
                $data = DB::table('asset_mstr')
                    ->where('asset_measure','=','C')
                    ->whereRaw('DATEDIFF(DAY, DATEADD(DAY, asset_cal, asset_last_mtc), GETDATE()) >= - asset_tolerance') // fungsi MYSQL
                    ->whereRaw("(asset_on_use is null or asset_on_use = '')")
                    ->where('asset_code','=',$req->search)
                    ->get();
            }
        

            foreach ($data as $data) {
                $output .= '<tr>
                            <td>'.$data->asset_code.'</td>
                            <td>'.$data->asset_desc.'</td>
                            <td>'.$data->asset_measure.'</td>
                            <td>'.Carbon::now()->toDateString().'</td>
                            <td>'.$data->asset_tolerance.'</td>
                            <td>'.date('Y-m-d', strtotime($data->asset_last_mtc. ' + '.$data->asset_cal.' days')).'</td>
                            <td style="vertical-align:middle;text-align:center;"> <input type="checkbox" class="qaddel" checked value=""> </td>
                            <input type="hidden" name="crWO[]" class="defdel" value="Y">
                            <input type="hidden" name="asset_code[]" value="'.$data->asset_code.'">
                            </tr>';

            }

            if($req->search == 'All'){
            $data2 = DB::table('asset_mstr')
                    ->where('asset_measure','=','M')
                    ->whereRaw('asset_last_usage_mtc + asset_tolerance >= asset_last_usage + asset_meter')
                    ->whereRaw("(asset_on_use is null or asset_on_use = '')")
                    ->get();
            }else{
            $data2 = DB::table('asset_mstr')
                    ->where('asset_measure','=','M')
                    ->whereRaw('asset_last_usage_mtc + asset_tolerance >= asset_last_usage + asset_meter')
                    ->whereRaw("(asset_on_use is null or asset_on_use = '')")
                    ->where('asset_code','=',$req->search)
                    ->get();
            }
            

            foreach ($data2 as $data2) {
                $output .= '<tr>
                            <td>'.$data2->asset_code.'</td>
                            <td>'.$data2->asset_desc.'</td>
                            <td>'.$data2->asset_measure.'</td>';

                if($data2->asset_measure == "C"){
                    $output .= '<td>2021-01-01</td>';
                    $output .= '<td>'.$data2->asset_tolerance.'</td>';
                }elseif($data2->asset_measure == "M"){
                    $output .= '<td>'.$data2->asset_last_usage_mtc.'</td>';
                    $output .= '<td>'.$data2->asset_tolerance.'</td>';
                }

                $output .= '<td>'.((int)$data2->asset_last_usage + (int)$data2->asset_meter).'</td>
                            <td style="vertical-align:middle;text-align:center;"> <input type="checkbox" class="qaddel" checked value=""> </td>
                            <input type="hidden" name="crWO[]" class="defdel" value="Y">
                            <input type="hidden" name="asset_code[]" value="'.$data2->asset_code.'">
                            </tr>';

            }

            if($output == ''){
                $output = '<tr>
              <td colspan="7" style="color:red;text-align: center;">No Data Available</td>
            </tr>';
            }

            return response($output);
        }
    }


    public function batchwo(Request $req){
        if(!$req->has('asset_code')){
            toast('Needs at least 1 data', 'error');
            return back();
        }

        $i = 0;

        foreach($req->asset_code as $data){
            // dump($data);
            if($req->crWO[$i] == 'Y'){

                $cektipe = DB::table('asset_mstr')
                            ->where('asset_code',$data)
                            ->first();

                if($cektipe){
                        // cek repair
                        $repcode1 = "";
                        $repcode2 = "";
                        $repcode3 = "";
                        $repgroup = "";
                        $tmp = 1;
                        if ($cektipe->asset_repair_type == 'group') {
                            $repgroup = $cektipe->asset_repair;
                        } else if ($cektipe->asset_repair_type == 'code') {
                                $a = explode(",", $cektipe->asset_repair);
                            
                                $repcode1 = $a[0];
                            if(isset($a[1])) {
                                $repcode2 = $a[1];
                            }
                            if(isset($a[2])) {
                                $repcode3 = $a[2];
                            }
                        } else {
                            $rep = "";
                        }

                        // Bkin WO
                        $tablern = DB::table('running_mstr')
                                        ->first();

                        $tempnewrunnbr = strval(intval($tablern->wt_nbr)+1);
                        $newtemprunnbr = '';

                        if(strlen($tempnewrunnbr) <= 4){
                        $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
                        }

                        $runningnbr = $tablern->wt_prefix.'-'.$tablern->year.'-'.$newtemprunnbr;
                        
                        $dataarray = array(
                            'wo_nbr' => $runningnbr,
                            'wo_status' => 'plan',
                            'wo_priority' => 'high',
                            'wo_repair_type' => $cektipe->asset_repair_type,
                            'wo_repair_group' => $repgroup,
                            'wo_repair_code1' => $repcode1,
                            'wo_repair_code2' => $repcode2,
                            'wo_repair_code3' => $repcode3,
                            'wo_asset' => $cektipe->asset_code, 
                            'wo_dept' => 'ENG', // Hardcode
                            'wo_type'=>'auto', // Hardcode
                            'wo_schedule' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                            'wo_duedate' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                            'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        );

                        DB::table('wo_mstr')->insert($dataarray);

                        DB::table('running_mstr')
                        ->update([
                            'wt_nbr' => $newtemprunnbr
                        ]);


                        DB::table('asset_mstr')
                        ->where('asset_code',$cektipe->asset_code)
                        ->update([
                            'asset_on_use' => $runningnbr,
                        ]);
                        
                        // Kirim Email
                        $assettable = DB::table('asset_mstr')
                                        ->where('asset_code','=',$cektipe->asset_code)
                                        ->first();
                        
                        $asset = $cektipe->asset_code.' - '.$assettable->asset_desc;

                        EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');


                        if($cektipe->asset_measure == 'C'){

                            // Update Table 
                            DB::table('asset_mstr')
                                    ->where('asset_measure','=','C')
                                    ->where('asset_code',$cektipe->asset_code)
                                    ->update([
                                        'asset_last_mtc' => Carbon::now()->toDateString()
                                    ]);
                        }
                }



            }

            $i++;
        }

        toast(''. $i .' New WO Created', 'success');
        return back();

    }

    //ditambahkan 03/11/2020
    public function notifread(Request $req){
        auth()->user()
        ->unreadNotifications
        ->when($req->input('id'), function ($query) use ($req) {
            return $query->where('id', $req->input('id'));
        })
        ->markAsRead();
         
        // DB::table('notifications')->where('id', '=', $req->input('id'))->delete();

        return response()->noContent();
        
    }
    
    public function notifreadall(Request $req){
       
      auth()->user()->unreadNotifications()->update(['read_at' => now()]);
      // DB::table('notifications')->where('id', '=', $req->input('id'))->delete();
      
      return response()->noContent();
    }
    
}
