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

class ShipController extends Controller{

    private function httpHeader($req) {
        return array('Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SOAPAction: ""',        // jika tidak pakai SOAPAction, isinya harus ada tanda petik 2 --> ""
            'Content-length: ' . strlen(preg_replace("/\s+/", " ", $req)));
    }


    public function shipinstructmenu(){
        $makk = DB::table('so_mstr_tmp')
                ->leftJoin('so_mstrs','so_mstrs.so_nbr', 'so_mstr_tmp.sonbr_mstr_tmp')
                ->where('so_nbr', '=', null)
                ->where('session_user', '=', Session::get('username'))
                ->get();

        return view('picklistbrowse.shipinstruction', ['show'=>$makk]);
    }

    public function sendtowh(Request $req){
        // dd($req->all());

        if($req->data == ''){
            toast('Harus memilih minimal 1 SO', 'error');
            return back();

        }else{

            $flg = 0;
            foreach($req->data as $datas){
                // dd($datas);
                $tmpmstrs = DB::table('so_mstr_tmp')
                    ->where('sonbr_mstr_tmp', '=', $datas)
                    ->where('session_user', '=', Session::get('username'))
                    ->first();

                // dd($tmpmstrs);


                // foreach($tmpmstrs as $tmpmstrs){
                    DB::table('so_mstrs')
                        ->insert([
                            'so_nbr' => $tmpmstrs->sonbr_mstr_tmp,
                            'so_cust' => $tmpmstrs->socust_tmp,
                            'so_shipto' => $tmpmstrs->soshipto_tmp,
                            'so_status' => 1,
                            'so_duedate' => $tmpmstrs->duedate_tmp,
                            'salesperson' => $tmpmstrs->salespsn_tmp,
                            'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                // }

                // dd('1');

                $tmpdets = DB::table('so_dets_tmp')
                        ->where('sonbr_det_tmp', '=', $datas)
                        ->where('session_user_det', '=', Session::get('username'))
                        ->get();

                // dd($tmpdets);

                
                $qtynew = 0;
                foreach($tmpdets as $det){
                    // dd('2');

                    DB::table('so_dets')
                        ->insert([
                            'sod_line' => $det->sod_line_tmp,
                            'sod_nbr' => $det->sonbr_det_tmp,
                            'sod_itemcode' => $det->item_code_tmp,
                            'sod_itemcode_desc' => $det->item_desc_tmp,
                            'qty_order' => $det->qty_order_tmp,
                            'qty_topick' => $det->qty_pick_tmp,
                            'qty_toship' =>$det->qty_pick_tmp,
                            'um' => $det->item_um_tmp,
                            'sod_status' => 1,
                            'loc' => $det->loc_tmp,
                            'lot' => $det->lot_tmp,
                            'loc_avail' => $det->loc_tmp,
                            'lot_avail' => $det->lot_tmp,
                            'created_at' =>Carbon::now('ASIA/JAKARTA')->toDateTimeString(), 
                        ]);
                }

                // dd('3');
                DB::table('so_mstr_tmp')
                ->where('sonbr_mstr_tmp', '=', $datas)
                ->where('session_user', '=', Session::get('username'))
                ->delete();

                DB::table('so_dets_tmp')
                ->where('sonbr_det_tmp', '=', $datas)
                ->where('session_user_det', '=', Session::get('username'))
                ->delete();
                
            }

                // dd($flg);
        }

        toast('Berhasil Kirim ke WH', 'success');

                // $flg = $flg+1;
        return back();
    }

    public function editshipinstruksi(Request $req){
        if($req->ajax()){
            $datadet = DB::table('so_mstr_tmp')
                    ->join('so_dets_tmp', 'so_dets_tmp.sonbr_det_tmp', 'so_mstr_tmp.sonbr_mstr_tmp')
                    ->where('so_mstr_tmp.sonbr_mstr_tmp', '=', $req->sonumber)
                    ->get();

            if($datadet){
                $output = '';
                $test = '';
                foreach($datadet as $data){
                    if($data->qty_pick_tmp == null){
                        $qtynow = $data->qty_order_tmp;
                    }else{
                        $qtynow = $data->qty_pick_tmp;
                    }

                    $output .= '<tr>'.
                                
                                '<td>'.$data->sod_line_tmp.'<input type="hidden" name="hiddenline[]" value="'.$data->sod_line_tmp.'"></td>'.
                                '<td>'.$data->item_code_tmp.'<input type="hidden" name="hiddenitemcode[]" value="'.$data->item_code_tmp.'"></td>'.
                                '<td>'.$data->item_desc_tmp.'</td>'.
                                '<td>'.$data->qty_order_tmp.'</td>'.
                                '<td>'.$data->qty_pick_tmp.'</td>'.
                                '<td>'.$data->qty_ship_tmp.'</td>'.
                                '<td>'.$data->item_um_tmp.'</td>'.
                               '</tr>';
                }

                return response($output);
            }
        }
    }


    public function submitedit(Request $req){
        // dd($req->all());
        foreach($req->hiddenitemcode as $data=>$v){
            $dataedit = DB::table('so_dets_tmp')
                        ->where('sonbr_det_tmp', '=', $req->sonbr)
                        ->where('sod_line_tmp', '=', $req->hiddenline[$data])
                        ->where('item_code_tmp','=', $req->hiddenitemcode[$data])
                        ->update([
                            'qty_pick_tmp' => $req->qtypick[$data],
                        ]);
        }
        toast('Qty Pick untuk SO '.$req->sonbr.' berhasil disimpan ', 'success');
        return back();

    }

    public function searchso(Request $req){
        if($req->ajax()){
            // dd($req->all());

            $sonumber = $req->sonumber;

            $qxURL = config('qxURL.globalURL');
            $qxdomain = config('qxURL.globalDomain');

            // Validasi WSA
            $qxUrl          = $qxURL;
            $qxReceiver     = '';
            $qxSuppRes      = 'false';
            $qxScopeTrx     = '';
            $qdocName       = '';
            $qdocVersion    = '';
            $dsName         = '';
            
            $timeout        = 0;

            // ** Edit here
            $qdocRequest =   '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                                <Body>
                                    <xxsomaa xmlns="urn:iris.co.id:wsatest">
                                        <inpdomain>'.$qxdomain.'</inpdomain>
                                        <sonumber>'.$sonumber.'</sonumber>
                                    </xxsomaa>
                                </Body>
                            </Envelope>';

    
            $curlOptions = array(CURLOPT_URL => $qxUrl,
                                CURLOPT_CONNECTTIMEOUT => $timeout,        // in seconds, 0 = unlimited / wait indefinitely.
                                CURLOPT_TIMEOUT => $timeout + 120, // The maximum number of seconds to allow cURL functions to execute. must be greater than CURLOPT_CONNECTTIMEOUT
                                CURLOPT_HTTPHEADER => $this->httpHeader($qdocRequest),
                                CURLOPT_POSTFIELDS => preg_replace("/\s+/", " ", $qdocRequest),
                                CURLOPT_POST => true,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_SSL_VERIFYHOST => false);
                        
            $getInfo = '';
            $httpCode = 0;
            $curlErrno = 0;
            $curlError = '';
            $qdocResponse = '';

            $curl = curl_init();
            if ($curl) {
                curl_setopt_array($curl, $curlOptions);
                $qdocResponse = curl_exec($curl);           // sending qdocRequest here, the result is qdocResponse.
                $curlErrno    = curl_errno($curl);
                $curlError    = curl_error($curl);
                $first        = true;
            
                foreach (curl_getinfo($curl) as $key=>$value) {
                    if (gettype($value) != 'array') {
                        if (! $first) $getInfo .= ", ";
                        $getInfo = $getInfo . $key . '=>' . $value;
                        $first = false;
                        if ($key == 'http_code') $httpCode = $value;
                    }
                }
                curl_close($curl);
                
            }
                    
            $xmlResp = simplexml_load_string($qdocResponse);       
        
            $xmlResp->registerXPathNamespace('ns1', 'urn:iris.co.id:wsatest');  
            
            $dataloop =$xmlResp->xpath('//ns1:tempRow');
            $result = (string) $xmlResp->xpath('//ns1:outOK')[0];
            $flag = 0;
            // dd($qdocResponse);

            DB::table('so_mstr_tmp')
                    ->where('session_user', '=', Session::get('username'))
                    ->delete();

            DB::table('so_dets_tmp')
                    ->where('session_user_det', '=', Session::get('username'))
                    ->delete();

            if($result == 'true'){

                foreach($dataloop as $data){ 
                    
                    $datas = DB::table("so_mstr_tmp")
                        // ->leftJoin("so_mstrs", "so_mstrs.so_nbr", "so_mstr_tmp.sonbr_mstr_tmp")
                        ->where('sonbr_mstr_tmp', '=', $data->t_xxsonbr)
                        ->first();
                    
                    $datasdet = DB::table("so_dets_tmp")
                        ->where('sonbr_det_tmp','=',$data->t_xxsonbr)
                        ->where('sod_line_tmp','=', $data->t_xxsodline)
                        ->first();
                        
                    if(!$datas){
                        DB::table('so_mstr_tmp')
                        ->insert([
                            'sonbr_mstr_tmp' => $data->t_xxsonbr,
                            'socust_tmp' =>$data->t_xxcust,
                            'duedate_tmp' =>$data->t_xxduedate,
                            'soshipto_tmp' => $data->t_xxshipto,
                            'salespsn_tmp' => $data->t_xxslspsn1,
                            'flag' => 'Y',
                            'session_user' => Session::get('username'),
                            'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                            if(!$datasdet){
                                DB::table('so_dets_tmp')
                                ->insert([
                                    'sod_line_tmp' => $data->t_xxsodline,
                                    'sonbr_det_tmp' => $data->t_xxsonbr,
                                    'item_code_tmp' => $data->t_xxitmnbr,
                                    'item_desc_tmp' => $data->t_xxitmname,
                                    'item_um_tmp' => $data->t_xxum,
                                    'qty_order_tmp' => $data->t_xxqtyorder,
                                    'qty_pick_tmp' => $data->t_xxqtypick,
                                    'qty_ship_tmp' => $data->t_xxqtypick,
                                    'loc_tmp' => $data->t_xxloc,
                                    'lot_tmp' => $data->t_xxlot,
                                    'session_user_det' => Session::get('username'),
                                    'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                            }
                            else if($datasdet){
                                DB::table('so_dets_tmp')
                                ->where('sonbr_det_tmp', '=', $data->t_xxsonbr)
                                ->where('sod_line_tmp','=', $data->t_xxsodline)
                                ->update([
                                    'item_code_tmp' => $data->t_xxitmnbr,
                                    'item_desc_tmp' => $data->t_xxitmname,
                                    'item_um_tmp' => $data->t_xxum,
                                    'qty_order_tmp' => $data->t_xxqtyorder,
                                    'qty_pick_tmp' =>$data->t_xxqtypick,
                                    'qty_ship_tmp' =>$data->t_xxqtypick,
                                    'loc_tmp' => $data->t_xxloc,
                                    'lot_tmp' => $data->t_xxlot,
                                    'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                                ]);
                    
                        }
                    }else if($datas){
                        DB::table('so_mstr_tmp')
                        ->where('sonbr_mstr_tmp', '=', $data->t_xxsonbr)
                        ->update([
                            'sonbr_mstr_tmp' => $data->t_xxsonbr,
                            'socust_tmp' =>$data->t_xxcust,
                            'duedate_tmp' =>$data->t_xxduedate,
                            'soshipto_tmp' => $data->t_xxshipto,
                            'salespsn_tmp' => $data->t_xxslspsn1,
                            'flag' => 'Y',
                            'session_user' => Session::get('username'),
                            'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                        ]);
                        if(!$datasdet){
                            DB::table('so_dets_tmp')
                            ->insert([
                                'sod_line_tmp' => $data->t_xxsodline,
                                'sonbr_det_tmp' => $data->t_xxsonbr,
                                'item_code_tmp' => $data->t_xxitmnbr,
                                'item_desc_tmp' => $data->t_xxitmname,
                                'item_um_tmp' => $data->t_xxum,
                                'qty_order_tmp' => $data->t_xxqtyorder,
                                'qty_pick_tmp' =>$data->t_xxqtypick,
                                'qty_ship_tmp' =>$data->t_xxqtypick,
                                'loc_tmp' => $data->t_xxloc,
                                'lot_tmp' => $data->t_xxlot,
                                'session_user_det' => Session::get('username'),
                                'created_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);
                        }
                        else if($datasdet){
                            DB::table('so_dets_tmp')
                            ->where('sonbr_det_tmp', '=', $data->t_xxsonbr)
                            ->where('sod_line_tmp','=',$data->t_xxsodline)
                            ->update([
                                'item_code_tmp' => $data->t_xxitmnbr,
                                'item_desc_tmp' => $data->t_xxitmname,
                                'item_um_tmp' => $data->t_xxum,
                                'qty_order_tmp' => $data->t_xxqtyorder,
                                'qty_pick_tmp' =>$data->t_xxqtypick,
                                'qty_ship_tmp' =>$data->t_xxqtypick,
                                'loc_tmp' => $data->t_xxloc,
                                'lot_tmp' => $data->t_xxlot,
                                'session_user_det' => Session::get('username'),
                                'updated_at' => Carbon::now('ASIA/JAKARTA')->toDateTimeString(),
                            ]);

                        }
                    }
                }
                
                $makk = DB::table('so_mstr_tmp')
                        // ->join('so_dets_tmp','so_dets_tmp.sonbr_det_tmp', 'so_mstr_tmp.sonbr_mstr_tmp')
                        ->leftJoin('so_mstrs', 'so_mstrs.so_nbr', 'so_mstr_tmp.sonbr_mstr_tmp')
                        ->where('session_user', '=', Session::get('username'))
                        ->first();

                if($makk->so_nbr != null){
                    // dd('data ada');

                    dd($makk);
                    return view("picklistbrowse.table-tempso", ['show' => $makk]);
                }else{
                    // dd('data tidak ada');
                }

                

                // dd($makk);

                
                // dd('1');
                // return view("picklistbrowse.table-tempso", ['show' => $makk]);    


               
            }else{

                // dd('2');
                $makk = DB::table('so_mstr_tmp')
                        // ->join('so_dets_tmp','so_dets_tmp.sonbr_det_tmp', 'so_mstr_tmp.sonbr_mstr_tmp')
                        ->leftJoin('so_mstrs', 'so_mstrs.so_nbr', 'so_mstr_tmp.sonbr_mstr_tmp')
                        ->where('session_user', '=', Session::get('username'))
                        ->get();

                dd($makk);

                // return view("picklistbrowse.table-tempso", ['show' => $makk]);

            }            
            
            // dd('stop');
    
        }
    }


    public function datawhmaint(){
        $data = DB::table('so_mstrs')
                ->where('so_status', '!=', '7')
                ->get();

        return view('picklistbrowse.datawhmaint', ['datas'=>$data]);
    }

    public function vieweditdatawh(Request $req){
        if($req->ajax()){
            $datadet = DB::table('so_mstrs')
                    ->join('so_dets', 'so_dets.sod_nbr', 'so_mstrs.so_nbr')
                    ->where('so_mstrs.so_nbr', '=', $req->sonumber)
                    ->get();

            if($datadet){
                $output = '';
                foreach($datadet as $data){
                    $output .= '<tr>'.
                                
                                '<td>'.$data->sod_line.'<input type="hidden" name="hiddenline[]" value="'.$data->sod_line.'"></td>'.
                                '<td>'.$data->sod_itemcode.'<input type="hidden" name="hiddenitemcode[]" value="'.$data->sod_itemcode.'"></td>'.
                                '<td>'.$data->sod_itemcode_desc.'</td>'.
                                '<td>'.$data->qty_order.'</td>'.
                                '<td>'.$data->um.'</td>'.
                                '<td><input class="form-control" type="number" value="'.$data->qty_topick.'" min="0" max="'.$data->qty_order.'" name="qtypick[]"></td>'.
                               '</tr>';
                }

                return response($output);
            }
        }
    }

    public function submiteditwh(Request $req){
        foreach($req->hiddenitemcode as $data=>$v){
            $dataedit = DB::table('so_dets')
                        ->where('sod_nbr', '=', $req->sonbr)
                        ->where('sod_line', '=', $req->hiddenline[$data])
                        ->where('sod_itemcode','=', $req->hiddenitemcode[$data])
                        ->update([
                            'qty_topick' => $req->qtypick[$data],
                        ]);
        }
        toast('Qty Pick untuk SO '.$req->sonbr.' berhasil diedit ', 'success');
        return back();
    }

    public function deletedatawh(Request $req){
        DB::table('so_mstrs')
            ->where('so_nbr', '=', $req->d_sonbr)
            ->delete();

        DB::table('so_dets')
            ->where('sod_nbr', '=', $req->d_sonbr)
            ->delete();

        toast('SO '.$req->d_sonbr.' berhasil dihapus', 'success');
        return back();
    }

    public function datawhpage(Request $req){
        if($req->ajax()){
            $sonbr = $req->get('sonbr');
            $cust = $req->get('cust');
            $duedatefrom = $req->get('duedatefrom');
            $duedateto = $req->get('duedateto');

            if($sonbr == "" and $cust == "" and $duedatefrom == "" and $duedateto == ""){
                $data = DB::table('so_mstrs')
                        ->where('so_status', '!=', 7)
                        ->paginate(10);

                return view('picklistbrowse.table-datawh', ['datas'=>$data]);
            }else{
                if($duedatefrom == null){
                    $duedatefrom = '1900-01-01';
                }
                if($duedateto == null){
                    $duedateto = '3000-01-01';
                }

                $kondisi = '';

                $kondisi = "so_duedate between '".$duedatefrom."' and '".$duedateto."' ";

                if($sonbr != ''){
                    $kondisi .= ' and so_nbr = "'.$sonbr.'"';
                }
                if($cust != ''){
                    $kondisi .= ' and so_cust = "'.$cust.'"';
                }

                $data = DB::table('so_mstrs')
                        ->whereRaw($kondisi)
                        ->paginate(10);


                return view('picklistbrowse.table-datawh', ['datas'=>$data]);
            }
        }
    }

   
}