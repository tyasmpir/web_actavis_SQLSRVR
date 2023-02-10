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
use App\User;
use Carbon\Carbon;
use Svg\Tag\Rect;

class wotypController extends Controller
{
     public function home()
    {
       
	  $data = DB::table('wotyp_mstr')					
					->get();
					
       return view('/setting/wotyp',compact('data'));  
    }
    
     public function create(Request $req)
	{
	$code  = $req->input('t_code');	
	$desc = $req->input('t_desc');
     
     
	$data1 = array('wotyp_code'=>$code,
                    'wotyp_desc'=>$desc,                           
                );               
				
	DB::table('wotyp_mstr')->insert($data1);	
	 $data = DB::table('wotyp_mstr')	
    ->get();    
      return view('/setting/wotyp',compact('data'));                       
     }
     
    public function edit(Request $req)
	{
		$code  = $req->input('te_code');	
      $desc = $req->input('te_desc');
      
      $data1 = array(
                    'wotyp_desc'=>$desc,                           
                );   

      DB::table('wotyp_mstr')->where('wotyp_code',$code)->update($data1);	
	  
      $data = DB::table('wotyp_mstr')					
				->get();
       
      return view('/setting/wotyp',compact('data'));  
    
   }
   
   public function delete(Request $req)
	{
		$code  = $req->input('d_code');	

		
		DB::table('wotyp_mstr')->where('wotyp_code', $code)->delete();       
        return redirect()->back();
	}
   
}
