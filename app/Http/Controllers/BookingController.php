<?php

namespace App\Http\Controllers;

use App\Charts\UserChart;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use App\Jobs\Emaill;
use App\Jobs\EmailBook;

use Carbon\Carbon;

/* Update Status Closed di HomeController*/

class BookingController extends Controller
{

    public function booking()
    {
        $dataAsset = DB::table('asset_mstr')
                    ->get();

        $data = DB::table('booking')
                    ->join('asset_mstr','asset_code','=','book_asset')
                    ->orderBy('book_id','desc')
                    ->paginate(50);
                    
        $codeBook = DB::table('booking')
                    ->orderBy('book_id','desc')
                    ->first();

        $qBook = DB::table("running_mstr")
                ->select("bo_prefix","bo_nbr","year")
                ->first();

        if (is_null($codeBook)) {
            $noBook = "BO210001";
        } else {
            $noBook = $qBook->bo_prefix.$qBook->year.str_pad($qBook->bo_nbr+1,4,'0',STR_PAD_LEFT);
        }

        $datadobel = DB::table("booking")
                    ->whereIn("book_status",["Open","Approved"])
                    ->get();
//dd($datadobel);
        $assetdobel = [];
        $cekDataAwal = 0;
        $cekDataAkhir = 0;
        foreach ($datadobel as $datadobel) {
            $tglawal = date('Y-m-d H:i', strtotime($datadobel->book_start));
            $tglakhir = date('Y-m-d H:i', strtotime($datadobel->book_end));

            $cekDataAwal = DB::table('booking')
                    ->where('book_asset','=',$datadobel->book_asset)
                    ->whereBetween('book_start', [$tglawal, $tglakhir])
                    ->whereIn("book_status",["Open","Approved"])
                    ->where("book_code","<>",$datadobel->book_code)
                    ->count();

            $cekDataAkhir = DB::table('booking')
                    ->where('book_asset','=',$datadobel->book_asset)
                    ->whereBetween('book_end', [$tglawal, $tglakhir])
                    ->whereIn("book_status",["Open","Approved"])
                    ->where("book_code","<>",$datadobel->book_code)
                    ->count();

            $cektglawal = DB::table('booking')
                    ->where('book_asset','=',$datadobel->book_asset)
                    ->where("book_start","<=",$tglawal)
                    ->where("book_end",">=",$tglawal)
                    ->whereIn("book_status",["Open","Approved"])
                    ->where("book_code","<>",$datadobel->book_code)
                    ->count();

            $cektglakhir = DB::table('booking')
                    ->where('book_asset','=',$datadobel->book_asset)
                    ->where("book_start","<=",$tglakhir)
                    ->where("book_end",">=",$tglakhir)
                    ->whereIn("book_status",["Open","Approved"])
                    ->where("book_code","<>",$datadobel->book_code)
                    ->count();

            // untuk tau ada dobel schedule booking
            if($cekDataAkhir > 0 || $cekDataAwal > 0 || $cektglawal > 0 || $cektglakhir > 0) {
                array_push($assetdobel,[$datadobel->book_code]);
            } else {
                
            }
        }

        return view('booking.booking', compact('dataAsset','data','noBook','assetdobel'));
    }

    public function createbooking(Request $req)
    {
        //dd($req->all());
       $tglawal = date('Y-m-d H:i', strtotime($req->t_start));
       $tglakhir = date('Y-m-d H:i', strtotime($req->t_end));


        if(is_null($req->t_allday)) {
            $allday = "No";
        } else {
            $allday = "Yes";
        }

        DB::table('booking')
        ->insert([
            'book_code'      => $req->t_code,
            'book_asset'       => $req->t_asset,
            'book_start'      => $tglawal,  
           'book_end'      => $tglakhir,                  
           'book_status'      => 'Open',                  
           'book_allday'      => $allday,      
           'book_dobel'         => $req->t_dobel,            
            'book_created_at'    => Carbon::now()->toDateTimeString(),
            'book_updated_at'    => Carbon::now()->toDateTimeString(),
            'book_edited_by'     => Session::get('username'),
        ]);

        DB::table('running_mstr')
            ->update([
                'bo_nbr' => substr($req->t_code,4,4),
            ]);

        EmailBook::dispatch();

        toast('Booking Asset Created.', 'success');
        return back();         
    }
    
    public function editbooking(Request $req)
    {
       
       $tglawal = date('Y-m-d H:i', strtotime($req->te_start));
       $tglakhir = date('Y-m-d H:i', strtotime($req->te_end));

        if(is_null($req->te_allday)) {
            $allday = "No";
        } else {
            $allday = "Yes";
        }

        if($tglawal > $tglakhir) {
            toast('Wrong End Date !!!', 'error');
            return back();
        }


       DB::table('booking')
            ->where('book_code','=',$req->te_code)
            ->update([
                'book_asset'       => $req->te_asset,
                'book_start'      => $tglawal,  
               'book_end'      => $tglakhir,  
               'book_allday'      => $allday,                 
                'book_updated_at'    => Carbon::now()->toDateTimeString(),
                'book_edited_by'     => Session::get('username'),
            ]);
            
            toast('Booking Asset Updated.', 'success');
            return back();
    }

    public function appbooking(Request $req)
    {
        $status = "";
        if (!is_null($req->ta_app)) {
            $status = "Approved";
        } else {
            $status = "Rejected";
        }
        
       DB::table('booking')
            ->where('book_code','=',$req->ta_code)
            ->update([ 
               'book_status'      => $status,                  
               'book_note'      => $req->ta_note,                  
                'book_updated_at'    => Carbon::now()->toDateTimeString(),
            ]);
            
              toast('Booking Asset Updated.', 'success');
            return back();
    }

    public function deletebooking(Request $req)
    {

            DB::table('booking')
            ->where('book_code', '=', $req->d_code)
            ->delete();

            toast('Booking Asset Successfully Deleted', 'success');
            return back();
    }

    // cek data dobel sebelum create dan edit
    public function cekbooking(Request $req)
    {
        $tglawal = date('Y-m-d H:i', strtotime($req->start));
        $tglakhir = date('Y-m-d H:i', strtotime($req->end));

        $cekDataAwal = DB::table('booking')
                ->where('book_asset','=',$req->asset)
                ->whereBetween('book_start', [$tglawal, $tglakhir])
                ->whereIn("book_status",["Open","Approved"])
                ->count();

        $cekDataAkhir = DB::table('booking')
                ->where('book_asset','=',$req->asset)
                ->whereBetween('book_end', [$tglawal, $tglakhir])
                ->whereIn("book_status",["Open","Approved"])
                ->count();

        $cektglawal = DB::table('booking')
                    ->where('book_asset','=',$req->asset)
                    ->where("book_start","<=",$tglawal)
                    ->where("book_end",">=",$tglawal)
                    ->whereIn("book_status",["Open","Approved"])
                    ->count();

        $cektglakhir = DB::table('booking')
                    ->where('book_asset','=',$req->asset)
                    ->where("book_start","<=",$tglakhir)
                    ->where("book_end",">=",$tglakhir)
                    ->whereIn("book_status",["Open","Approved"])
                    ->count();

        if($cekDataAkhir > 0 || $cekDataAwal > 0 || $cektglawal > 0 || $cektglakhir > 0) {
            $result = 'error';
            
        } else {
            $result = 'success';
        }
        return $result;
    }
    
    //untuk paginate failure
    public function bookingpage(Request $req)
    {

        if ($req->ajax()) {
            $sort_by = $req->get('sortby');
            $sort_group = $req->get('sorttype');
            $code = $req->get('code');
            $asset = $req->get('asset');
            $status = $req->get('status');

            $dataAsset = DB::table('asset_mstr')
                    ->get();
      
            $datadobel = DB::table("booking")
                        ->whereIn("book_status",["Open","Approved"])
                        ->get();

            $assetdobel = [];
            $cekDataAwal = 0;
            $cekDataAkhir = 0;
            foreach ($datadobel as $datadobel) {
                $tglawal = date('Y-m-d H:i', strtotime($datadobel->book_start));
                $tglakhir = date('Y-m-d H:i', strtotime($datadobel->book_end));

                $cekDataAwal = DB::table('booking')
                        ->where('book_asset','=',$datadobel->book_asset)
                        ->whereBetween('book_start', [$tglawal, $tglakhir])
                        ->whereIn("book_status",["Open","Approved"])
                        ->where("book_code","<>",$datadobel->book_code)
                        ->count();

                $cekDataAkhir = DB::table('booking')
                        ->where('book_asset','=',$datadobel->book_asset)
                        ->whereBetween('book_end', [$tglawal, $tglakhir])
                        ->whereIn("book_status",["Open","Approved"])
                        ->where("book_code","<>",$datadobel->book_code)
                        ->count();

                $cektglawal = DB::table('booking')
                    ->where('book_asset','=',$datadobel->book_asset)
                    ->where("book_start","<=",$tglawal)
                    ->where("book_end",">=",$tglawal)
                    ->whereIn("book_status",["Open","Approved"])
                    ->where("book_code","<>",$datadobel->book_code)
                    ->count();

                $cektglakhir = DB::table('booking')
                    ->where('book_asset','=',$datadobel->book_asset)
                    ->where("book_start","<=",$tglakhir)
                    ->where("book_end",">=",$tglakhir)
                    ->whereIn("book_status",["Open","Approved"])
                    ->where("book_code","<>",$datadobel->book_code)
                    ->count();

                //return dd($cekDataAwal, $cekDataAkhir);

                if($cekDataAkhir > 0 || $cekDataAwal > 0 || $cektglawal > 0 || $cektglakhir > 0) {
                    array_push($assetdobel,[$datadobel->book_code]);
                } else {
                    
                }
            }

            if ($code == '' && $asset == '' && $status == '') {
                $data = DB::table('booking')
                        ->join('asset_mstr','asset_code','=','book_asset')
                        ->orderBy('book_id','desc')
                        ->paginate(50);
                
                return view('booking.table-booking', ['data' => $data, 'dataAsset' => $dataAsset,'assetdobel' => $assetdobel]);
            } else {
                $kondisi = '';
                if ($code != '') {
                    $kondisi = "book_code like '%" . $code . "%'";
                }
                if ($asset != '') {
                    if ($kondisi != '') {
                        $kondisi .= " and book_asset like '%" . $asset . "%'";
                    } else {
                        $kondisi = "book_asset like '%" . $asset . "%'";
                    }
                }
                if ($status != '') {
                    if ($kondisi != '') {
                        $kondisi .= " and book_status like '%" . $status . "%'";
                    } else {
                        $kondisi = "book_status like '%" . $status . "%'";
                    }
                }
                //dd($kondisi);
                $data = DB::table('booking')
                    ->join('asset_mstr','asset_code','=','book_asset')
                    ->whereRaw($kondisi)
                    ->orderBy('book_id','desc')
                    ->paginate(50);

                return view('booking.table-booking', ['data' => $data, 'dataAsset' => $dataAsset,'assetdobel' => $assetdobel]);
            }
        }
    }
}