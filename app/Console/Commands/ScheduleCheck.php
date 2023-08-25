<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\EmailScheduleJobs;

/*
Daftar perubahan :
A211025 : WO yang terbentuk dari PM statusnya langsung open, jadi tidak memerlukan approve oleh supervisor. default eng01 02 sesuai kesepakatan meeting
A221128 : jadwal terbentuknya PM tidak terpengaruh dari tanggal penyelesaian WO jadi seharusnya terbentuk PM setiap periode calendar.
dan tidak terpengaruh apakah sudah ada PM atau belum
*/

class ScheduleCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sched:wo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim Email kalo PO mendekati parameter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $skrg = Carbon::now('ASIA/JAKARTA')->toDateString();
        $data = DB::table('asset_mstr')
                    ->selectRaw("asset_mstr.*") 
                    ->where('asset_measure','=','C')
                    ->where('asset_active','=','Yes')
                    //->where('asset_code','=','01-MS-050')
                    ->whereRaw('DATEDIFF(MONTH, DATEADD(MONTH, asset_cal, asset_last_mtc), GETDATE()) >= - asset_tolerance') // fungsi MYSQL
                    ->whereRaw("year(DATEADD(MONTH, (asset_cal - asset_tolerance), asset_last_mtc)) <= year(getdate())")
                    /* ->whereRaw("(asset_on_use is null or asset_on_use = '')") A221128 */
                    ->whereRaw("(asset_start_mea < '".$skrg."' or asset_start_mea is null or asset_start_mea = '')")
                    ->get();
        
        /* Coding SQL Server
            select asset_code,asset_last_mtc,DATEADD(MONTH, asset_cal, asset_last_mtc) as seharusnya,asset_cal from asset_mstr
            where asset_measure = 'C'
            and asset_active = 'Yes'
            and DATEDIFF(MONTH, DATEADD(MONTH, asset_cal, asset_last_mtc), GETDATE()) >= - asset_tolerance
            and year(DATEADD(MONTH, (asset_cal - asset_tolerance), asset_last_mtc)) <= year(getdate())
            and (asset_on_use is null or asset_on_use = '')
            and (asset_start_mea < getdate() or asset_start_mea is null or asset_start_mea = '')
        */



        if($data->count() > 0){
            foreach($data as $data){
                // cek repair
                $repcode1 = "";
                $repcode2 = "";
                $repcode3 = "";
                $repgroup = "";
                if ($data->asset_repair_type == 'group') {
                    $repgroup = $data->asset_repair;
                } else if ($data->asset_repair_type == 'code') {
                    $a = explode(",", $data->asset_repair);

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
                // Cari nomor teakhir
                $tablern = DB::table('running_mstr')
                                ->first();

                $tempnewrunnbr = strval(intval($tablern->wt_nbr)+1);
                $newtemprunnbr = '';

                if(strlen($tempnewrunnbr) <= 4){
                $newtemprunnbr = str_pad($tempnewrunnbr,4,'0',STR_PAD_LEFT);
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

        $runningnbr = $tablern->wt_prefix.'-'.$dispthn.'-'.$dispnum;

                /* $runningnbr = $tablern->wt_prefix.'-'.$tablern->year.'-'.$newtemprunnbr; */

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
                
                // simpan data
                $dataarray = array(
                    'wo_nbr' => $runningnbr,
                    //'wo_status' => 'plan', -> A211025
                    'wo_status' => 'open',
                    'wo_engineer1' => $techeng[0], 
                    'wo_engineer2' => $techeng[1], 
                    'wo_engineer3' => $techeng[2], 
                    'wo_engineer4' => $techeng[3], 
                    'wo_engineer5' => $techeng[4], 
					'wo_priority' => 'high',
                    'wo_repair_type' => $data->asset_repair_type,
                    'wo_repair_group' => $repgroup,
                    'wo_repair_code1' => $repcode1,
                    'wo_repair_code2' => $repcode2,
                    'wo_repair_code3' => $repcode3,
                    'wo_asset' => $data->asset_code, 
					'wo_dept' => 'ENG', // Hardcode
                    'wo_type'  => 'auto', // Hardcode
                    'wo_schedule' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_duedate' => Carbon::now('ASIA/JAKARTA')->endOfMonth()->toDateString(),
                    //'wo_schedule' => Carbon::createFromDate($data->seharusnya)->toDateTimeString(),
                    //'wo_duedate' => Carbon::createFromDate($data->seharusnya)->endOfMonth()->toDateString(),
                    'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                );

                DB::table('wo_mstr')->insert($dataarray);

                DB::table('running_mstr')
                ->update([
                    'wt_nbr' => $dispnum,
                    'year' => $dispthn
                ]);


                DB::table('asset_mstr')
                ->where('asset_code',$data->asset_code)
                ->update([
                    'asset_on_use' => $runningnbr,
                ]);
                
                // Kirim Email
                $assettable = DB::table('asset_mstr')
                                ->where('asset_code','=',$data->asset_code)
                                ->first();
                
                $asset = $data->asset_code.' - '.$assettable->asset_desc;

                //2022.04.07 email dimatikan request bu sinta
                //EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');

                // Update Table 
                DB::table('asset_mstr')
                        ->where('asset_code',$data->asset_code)
                        ->where('asset_active','=','Yes')
                        ->where('asset_measure','=','C')
                        ->whereRaw('DATEDIFF(DAY, DATEADD(DAY, asset_cal, asset_last_mtc), GETDATE()) >= 0')
                        ->whereRaw("(asset_start_mea < '".$skrg."' or asset_start_mea is null or asset_start_mea = '')")
                        ->update([
                            'asset_last_mtc' => Carbon::now()->toDateString()
                        ]);

            }
        }


        $data2 = DB::table('asset_mstr')
                    ->where('asset_measure','=','M')
                    ->where('asset_active','=','Yes')
                    ->whereRaw('asset_last_usage_mtc + asset_tolerance >= asset_last_usage + asset_meter')
                    ->whereRaw("(asset_on_use is null or asset_on_use = '')")
                    ->get();

        if($data2->count() > 0){
            foreach($data2 as $data2){
                // cek repair
                $repcode1 = "";
                $repcode2 = "";
                $repcode3 = "";
                $repgroup = "";
                if ($data2->asset_repair_type == 'group') {
                    $repgroup = $data2->asset_repair;
                } else if ($data2->asset_repair_type == 'code') {
                    $a = explode(",", $data2->asset_repair);

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

        // ganti tahun baru 2023.05.04
        $tahun = substr(Carbon::now()->format('Y'),2,2);
        if($tablern->year != $tahun) {
           $dispthn = $tahun;
           $dispnum = "0001";
        } else {
           $dispthn = $tablern->year;
           $dispnum = $newtemprunnbr; 
        } 

        $runningnbr = $tablern->wt_prefix.'-'.$dispthn.'-'.$dispnum;

                /* $runningnbr = $tablern->wt_prefix.'-'.$tablern->year.'-'.$newtemprunnbr; */
                
                $dataarray = array(
                    'wo_nbr' => $runningnbr,
                    'wo_status' => 'open',
                    'wo_engineer1' => 'azis', //A211025
                    'wo_engineer2' => 'sukarya', //A211025
                    'wo_priority' => 'high',
                    'wo_repair_type' => $data2->asset_repair_type,
                    'wo_repair_group' => $repgroup,
                    'wo_repair_code1' => $repcode1,
                    'wo_repair_code2' => $repcode2,
                    'wo_repair_code3' => $repcode3,
                    'wo_asset' => $data2->asset_code, 
                    'wo_dept' => 'ENG', // Hardcode
                    'wo_type'=>'auto', //Hardcode
                    'wo_schedule' => Carbon::now('ASIA/JAKARTA')->toDateString(),
                    'wo_duedate' => Carbon::now('ASIA/JAKARTA')->endOfMonth()->toDateString(),
                    'wo_created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                    'wo_updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                );

                DB::table('wo_mstr')->insert($dataarray);

                DB::table('running_mstr')
                ->update([
                    'wt_nbr' => $dispnum,
                    'year' => $dispthn,
                ]);


                DB::table('asset_mstr')
                ->where('asset_code',$data2->asset_code)
                ->update([
                    'asset_on_use' => $runningnbr,
                ]);
                
                // Kirim Email
                $assettable = DB::table('asset_mstr')
                                ->where('asset_code','=',$data2->asset_code)
                                ->first();
                
                $asset = $data2->asset_code.' - '.$assettable->asset_desc;

                //2022.04.07 email dimatikan request bu sinta
                //EmailScheduleJobs::dispatch($runningnbr,$asset,'1','','','','');
            }
        }
    }
}
