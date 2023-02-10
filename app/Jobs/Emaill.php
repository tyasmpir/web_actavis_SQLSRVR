<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use Illuminate\Support\Facades\Mail;

class Emaill implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $runningnbr;
    
    public function __construct($runningnbr)
    {
        //
        // $this->halo = $halo;
        $this->runningnbr = $runningnbr;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $dop = $this->test;

        // dd($this->testtt);
        
        $runningnbr = $this->runningnbr;
        // dd($runningnbr);
        //
        $toemail = DB::table('service_req_mstr')
                    ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                    ->where('sr_number' , '=', $runningnbr)
                    ->selectRaw('*, service_req_mstr.sr_created_at as reqdatetime')
                    ->first();

        // dd($toemail);

        $com = DB::table('com_mstr')
                ->selectRaw('com_email')
                ->first();
        // dd($com);

        $newcom = trim($com->com_email);

        // dd($newcom);

        $emailto = DB::table('eng_mstr')
                    ->where('approver', '=', 1)
                    ->selectRaw('eng_email')
                    ->get();

        // dd($emailto);

        $emails = '';

        foreach($emailto as $email){
            $emails .= $email->eng_email.',';
        }

        // dd($emails);
        $emails = substr($emails, 0, strlen($emails) - 1);

        $array_email = explode(',', $emails);

        // dd($array_email);
        //kirim email ke kepala engineer
        Mail::send('emailwo',
        ['pesan' => 'New Service Request',
         'note1' => $toemail->sr_number,
         'note2' => $toemail->sr_assetcode.'--'.$toemail->asset_desc,
         'header1' => 'SR Number',],
        //  'srnote' => $toemail->sr_note,
        //  'requestby' => $toemail->req_by,
         function ($message) use ($array_email, $newcom){
            $message->subject('Actavis - New Service Request');
            $message->from($newcom);
            $message->to($array_email);
         });
        
    }
}
