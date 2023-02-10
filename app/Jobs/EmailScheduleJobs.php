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

class EmailScheduleJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $wo;
    protected $asset;
    protected $a;
    protected $tampungarray;
    protected $requestor;
    protected $srnumber;
    protected $rejectnote;

    public function __construct($wo,$asset,$a,$tampungarray,$requestor,$srnumber,$rejectnote)
    {
        //
        $this->wo = $wo;
        $this->asset = $asset;
        $this->a = $a;
        $this->tampungarray = $tampungarray;
        $this->requestor = $requestor;
        $this->srnumber = $srnumber;
        $this->rejectnote = $rejectnote;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $wo = $this->wo;
        $asset = $this->asset;
        $a = $this->a;
          
        // dd($tampungarray);

        if($a == 2){ //kirim email ke semua enjiner yg dipilih pada saat approve service request & kirim email ke requestor bahwa service requestnya assigned
			$tampungarray = $this->tampungarray;
			// dd($tampungarray);
			$countarray1 = count($tampungarray);
			$requestor = $this->requestor;
			$srnumber = $this->srnumber;  
			$rejectnote = $this->rejectnote;
			
            $list2 = [];
            

            for($i = 0 ; $i < $countarray1; $i++){
                $email2 = DB::table('eng_mstr')
                        ->where('eng_code', '=', $tampungarray[$i])
                        ->first();
                $list2[$i] = $email2->eng_email;

            }

            Mail::send('emailwo', 
                    ['pesan' => 'Notifikasi New Work Order',
                    'note1' => $wo,
                    'note2' => $asset,
                    'header1' => 'WO Number'],
                    function ($message) use ($wo,$list2)
                    {
                        $message->subject('Actavis - New work order');
                        // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                        $message->to(array_filter($list2));
                    });

            for($x = 0 ; $x < $countarray1; $x++){
                $email2 = DB::table('eng_mstr')
                        ->join('users','eng_mstr.eng_code','=','users.username')
                        ->where('eng_code', '=', $tampungarray[$x])
                        ->first();
               
                $user = App\User::where('id','=', $email2->id)->first(); 
                $details = [
                            'body' => 'There is New WO for you',
                            'url' => 'wojoblist',
                            'nbr' => $wo,
                            'note' => 'Please Check'
        
                ]; // isi data yang dioper
            
            
                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel

            }


            $emailrequestor = DB::table('users')
                            ->where('username', '=', $requestor)
                            ->first();


            Mail::send('emailrequestor', 
                    ['pesan' => 'Notifikasi Service Request Assigned',
                    'note1' => $srnumber,
                    'note2' => $asset,
                    'header1' => 'SR Number'],
                    function ($message) use ($emailrequestor)
                    {
                        $message->subject('Actavis - Service Request Assigned to Work Order');
                        // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                        $message->to($emailrequestor->email_user);
                    });

            $user = App\User::where('id','=', $emailrequestor->id)->first(); 
            $details = [
                        'body' => 'Service Request Assigned',
                        'url' => 'srbrowse',
                        'nbr' => $srnumber,
                        'note' => 'Please Check'
    
            ]; // isi data yang dioper
        
        
            $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel

            

            // dd($list2);
        }else if($a == 3){ //kirim email ke kepala engineer ketika user submit service request
            $srnumber = $this->srnumber; 
            // dd($runningnbr);
            //
            $toemail = DB::table('service_req_mstr')
                        ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_assetcode')
                        ->where('sr_number' , '=', $srnumber)
                        ->selectRaw('*, service_req_mstr.sr_created_at as reqdatetime')
                        ->first();
    
    
            $emailto = DB::table('eng_mstr')
                        ->where('approver', '=', 1)
                        ->where('eng_active', '=', 'Yes')
                        ->selectRaw('eng_email')
                        ->get();

            $approverto = DB::table('eng_mstr')
                        ->join('users','eng_mstr.eng_code','=','users.username')
                        ->where('approver', '=', 1)
                        ->where('eng_active', '=', 'Yes')
                        // ->selectRaw('eng_code')
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
             function ($message) use ($array_email){
                $message->subject('Actavis - New Service Request');
                // $message->from('andrew@ptimi.co.id');
                $message->to($array_email);
             });
             
             
            foreach($approverto as $approver){
                // dd($email2->eng_code);
                $user = App\User::where('id','=', $approver->id)->first(); 
                $details = [
                            'body' => 'New Service Request',
                            'url' => 'srapproval',
                            'nbr' => $srnumber,
                            'note' => 'Please check'
        
                ]; // isi data yang dioper
            
            
                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                


            }
        }else if($a == 4){ //kirim email ke requestor ketika service request ditolak/reject
            // $tampungarray = $this->tampungarray;
			// dd($tampungarray);
			// $countarray1 = count($tampungarray);
			$requestor = $this->requestor;
			$srnumber = $this->srnumber;  
			$rejectnote = $this->rejectnote;

            $emailrequestor = DB::table('users')
                            ->where('username', '=', $requestor)
                            ->first();


            Mail::send('emailrequestor', 
                    ['pesan' => 'Service Request Rejected',
                    'note1' => $srnumber,
                    'note2' => $asset,
                    'header1' => 'Reason Reject : '.$rejectnote.' '],
                    function ($message) use ($emailrequestor)
                    {
                        $message->subject('Actavis - Service Request Rejected');
                        // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                        $message->to($emailrequestor->email_user);
                    });

            $user = App\User::where('id','=', $emailrequestor->id)->first(); 
            $details = [
                        'body' => 'Service Request Rejected',
                        'url' => 'srbrowse',
                        'nbr' => $srnumber,
                        'note' => 'Please check'
    
            ]; // isi data yang dioper
        
        
            $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel
    
        }else if($a == 1){ //kirim email ke spv kalau ada WO baru
			$wo = $this->wo;
			$asset = $this->asset;
			$flag = $this->a;

            $data = DB::table('eng_mstr')
                        ->join('users','eng_mstr.eng_code','=','users.username')
                        ->where('approver','=','1')
                        ->get();

			
			$listto = [];
			$i = 0;
			if($data->count() > 0){
			
				foreach($data as $data1){
					$listto[$i] = $data1->eng_email;
					$i++;
				}

				// Kirim Email
				Mail::send('emailwo', 
					['pesan' => 'Notifikasi New Work Order',
					'note1' => $wo,
					'note2' => $asset,
					'header1' => 'Work Order'],
					function ($message) use ($wo,$listto)
					{
						$message->subject('Actavis - New Work Order');
						// $message->from('andrew@ptimi.co.id'); // Email Admin Fix
						$message->to(array_filter($listto));
					});
					

                foreach($data as $data){
                    $user = App\User::where('id','=', $data->id)->first(); 
                    $details = [
                                'body' => 'There is new WO that you need to approve',
                                'url' => 'wobrowse',
                                'nbr' => $wo,
                                'note' => 'Please check'
            
                    ]; // isi data yang dioper
                
                
                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel
                }
					
			}
		}
        else if($a == 5){ //kirim email ke spv kalau ada WO direct
			$wo = $this->wo;
			$asset = $this->asset;
			$flag = $this->a;

            $data = DB::table('eng_mstr')
                        ->join('users','eng_mstr.eng_code','=','users.username')
                        ->where('approver','=','1')
                        ->get();

			
			$listto = [];
			$i = 0;
			if($data->count() > 0){
			
				foreach($data as $data1){
					$listto[$i] = $data1->eng_email;
					$i++;
				}

				// Kirim Email
				Mail::send('emailwo', 
					['pesan' => 'Notifikasi New Work Order Direct',
					'note1' => $wo,
					'note2' => $asset,
					'header1' => 'Work Order'],
					function ($message) use ($wo,$listto)
					{
						$message->subject('Actavis - New Work Order Direct');
						// $message->from('andrew@ptimi.co.id'); // Email Admin Fix
						$message->to(array_filter($listto));
					});
					

                foreach($data as $data){
                    $user = App\User::where('id','=', $data->id)->first(); 
                    $details = [
                                'body' => 'There is new WO that created directly',
                                'url' => 'wobrowse',
                                'nbr' => $wo,
                                'note' => 'Please check'
            
                    ]; // isi data yang dioper
                
                
                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel
                }
					
			}
		} else if($a == 6) { //kirim email ke user ketika reviewer WO diapprove atau reject
            $nomorwo = $this->wo;
            $srnumber =  $this->srnumber;

            $emailuser = DB::table('service_req_mstr')
                ->join('users','username','req_username')
                ->where('sr_number', '=', $srnumber)
                ->first();

            Mail::send('emailrequestor', 
                    ['pesan' => 'Service Request Rejected',
                    'note1' => $srnumber,
                    'note2' => $nomorwo,
                    'header1' => 'Work Order'],
                    function ($message) use ($emailuser)
                    {
                        $message->subject('Actavis - Service Request Rejected');
                        // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                        $message->to($emailuser->email_user);
                    });
//dd('tyas');
            $user = App\User::where('id','=', $emailuser->id)->first(); 
            $details = [
                        'body' => 'Service Request Rejected',
                        'url' => 'srbrowse',
                        'nbr' => $srnumber,
                        'note' => 'Please check'
    
            ]; // isi data yang dioper
        
        
            $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel

        }

    }
}
