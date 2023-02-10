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

class PicklistController extends Controller{
    public function pickbrowsetv(){
        $data = DB::table('so_mstrs')
            ->join('so_dets', 'so_dets.sod_nbr', 'so_mstrs.so_nbr')
            ->selectRaw('so_nbr as sonbr, so_cust as cust, count(sod_nbr) as totalline, so_status as status, pic_wh as picwh, so_mstrs.created_at as waktubuat')
            ->orderBy('waktubuat', 'DESC')
            ->groupBy('sod_nbr')
            ->paginate(7);


        return view('picklistbrowse.browsetv', ['datas'=>$data]);
    }

    public function pagebrowsetv(Request $req){
        $data = DB::table('so_mstrs')
            ->join('so_dets', 'so_dets.sod_nbr', 'so_mstrs.so_nbr')
            ->selectRaw('so_nbr as sonbr, so_cust as cust, count(sod_nbr) as totalline, so_status as status, pic_wh as picwh, so_mstrs.created_at as waktubuat')
            ->orderBy('waktubuat', 'DESC')
            ->groupBy('sod_nbr')
            ->paginate(7);


        return view('picklistbrowse.table-browsetv', ['datas'=>$data]);
    }

    public function pickbrowsewh(){
        $data = DB::table('so_mstrs')
                ->join('so_dets', 'so_dets.sod_nbr', 'so_mstrs.so_nbr')
                // ->where('so_status', '=', 1)
                // // ->where('so_status', '=', 2)
                ->selectRaw('so_nbr as sonbr, so_cust as cust, count(sod_nbr) as totalline, so_status as status, pic_wh as picwh, so_mstrs.created_at as waktubuat')
                ->orderBy('waktubuat', 'DESC')
                ->groupBy('sod_nbr')
                ->paginate(10);
            
        // dd($data);
        return view('picklistbrowse.browsewh', ['datas'=>$data]);
    }

    public function pickingwarehouse(Request $req){
        
        DB::table('so_mstrs')
            ->where('so_nbr', '=', $req->id)
            ->update([
                'so_status' => 3,
                'pic_wh' => Session::get('username'),
            ]);

        $datamstrs = DB::table('so_mstrs')
                ->where('so_nbr', '=', $req->id)
                ->first();

        $datadets = DB::table('so_dets')
                ->where('sod_nbr', '=', $req->id)
                ->get();


        $trolley = DB::table('trolley_mstr')
                ->where('trolley_status', '=', null)
                ->get();

        
        return view('picklistbrowse.pickingwh', ['mstr' => $datamstrs, 'det' => $datadets, 'trolley' => $trolley]);


    }

    public function teststat(Request $req){
        dd($req->all());
        DB::table('so_mstrs')
        ->where('so_nbr', '=', $req->id)
        ->update([
            'so_status' => 1,
            'pic_wh' => Session::get('username'),
        ]);
    }

}