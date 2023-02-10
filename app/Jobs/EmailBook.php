<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use PDF;
use App;

class EmailBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $emailrequestor = DB::table('users')
                            ->where('username', '=', 'admin3')
                            ->first();

        Mail::send('test', 
                    ['pesan' => 'Notifikasi Service Request Assigned',
                    'note1' => 'note 1',
                    'note2' => 'note 2',
                    'header1' => 'SR Number'],
                    function ($message) use ($emailrequestor)
                    {
                        $message->subject('Actavis - Service Request Assigned to Work Order');
                        $message->from('tyas@ptimi.co.id'); // Email Admin Fix
                        $message->to('tyas@ptimi.co.id');
                    });

    }
}
