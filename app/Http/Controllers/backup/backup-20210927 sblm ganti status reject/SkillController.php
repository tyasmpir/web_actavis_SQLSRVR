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

class SkillController extends Controller
{
     public function skillmaster()
    {
       
	  $data = DB::table('skill_mstr')					
					->get();
	  $dom = DB::table('skill_mstr')					
					->get();					
				
       return view('/setting/skill',['sitemt'=>$data],['domain'=>$dom]);    
    }
    
    public function skillcreate(Request $req)
	{
	$code  = $req->input('code');	
	$desc = $req->input('desc');
     
     
	$data1 = array('skill_code'=>$code,
                    'skill_desc'=>$desc,                           
                );               
				
	DB::table('skill_mstr')->insert($data1);	
	 $data = DB::table('skill_mstr')					
					->get();
	$dom = DB::table('skill_mstr')					
					->get();	
                                 
     return view('/setting/skill',['sitemt'=>$data],['domain'=>$dom]);                       
     }
}
