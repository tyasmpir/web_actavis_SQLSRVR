<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RepController extends Controller
{
    public function repgroup()
    {
	    $data = DB::table('xxrepgroup_mstr')
            ->selectRaw('MIN(xxrepgroup_nbr) as xxrepgroup_nbr, MIN(xxrepgroup_desc) as xxrepgroup_desc')
            // ->distinct('xxrepgroup_nbr')
            ->groupBy('xxrepgroup_nbr')
            ->orderby('xxrepgroup_nbr')
            ->paginate(10);
            // dd($data);
        $dataasset = DB::table('rep_master')
            ->orderby('repm_code')
            ->get();

        $datadetail = DB::table('xxrepgroup_mstr')
            ->get();

        $datarepair = DB::table('rep_master')
            ->orderby('repm_code')
            ->get();

        $datagroup = DB::table('xxrepgroup_mstr')
            ->selectRaw('MIN(xxrepgroup_nbr) as xxrepgroup_nbr, MIN(xxrepgroup_desc) as xxrepgroup_desc')
            ->groupBy('xxrepgroup_nbr')
            ->orderby('xxrepgroup_nbr')
            ->get();

        return view('setting.repgroup', ['data' => $data, 'dataasset' => $dataasset, 'datadetail' => $datadetail,
            'datarepair' => $datarepair, 'datagroup' => $datagroup]);     
    }
    
    public function createrepgroup(Request $req)
    {
			
        // harus ada inputan anak
        if (is_null($req->line)) {
            toast('Please Line Items!!', 'error');
             return back();
        }

        if (is_null($req->barang)) {
            toast('Please Input Repair Code!!', 'error');
             return back();
        }
        
           $flg = 0;
        foreach($req->barang as $barang){
            DB::table('xxrepgroup_mstr')
            ->insert([
                'xxrepgroup_nbr'        => $req->t_code,
				'xxrepgroup_desc'       => $req->t_desc,
				'xxrepgroup_line'       => $req->line[$flg],
                'xxrepgroup_rep_code'   => $req->barang[$flg],      
                'xxrepgroup_rep_desc'   => $req->repmdesc[$flg],                
            ]);

            $flg += 1;
        }    

        toast('Repair Group Created.', 'success');
        return back();
    }

    //menampilkan detail edit
    public function editdetailrepgroup(Request $req)
    {
        if ($req->ajax()) {
            $data = DB::table('xxrepgroup_mstr')
                    ->where('xxrepgroup_nbr','=',$req->code)
                    ->get();

            $dataRep = DB::table('rep_master')
                    ->get();

            $output = '';
            foreach ($data as $data) {
                $descRep = $dataRep->where('repm_code','=',$data->xxrepgroup_rep_code)->first();
                $a = $descRep->repm_desc.' -- '.$descRep->repm_ref;

                $output .= '<tr>'.
                            '<td>'.$data->xxrepgroup_line.'</td>'.
                            '<td>'.$data->xxrepgroup_rep_code.' -- '.$a.'</td>'.
                            '<td><input type="checkbox" name="cek[]" class="cek" id="cek" value="0">
                            <input type="hidden" name="tick[]" id="tick" class="tick" value="0">
                            <input type="hidden" name="erepmdesc[]" id="erepmdesc" class="erepmdesc" value="'.$descRep->repm_desc.'"></td>'.
                            '<input type="hidden" name="line[]" id="line" class="line" value="'.$data->xxrepgroup_line.'"></td>'.
                            '<input type="hidden" name="barang[]" id="barang" class="barang" value="'.$data->xxrepgroup_rep_code.'"></td>'.
                            '</tr>';
            }

            return response($output);
        }
    }
	
    public function editrepgroup(Request $req)
    {

        DB::table('xxrepgroup_mstr')
            ->where('xxrepgroup_nbr','=',$req->h_code)
            ->delete();

        $flg = 0;
        foreach($req->barang as $barang){
            /* tick = 0 --> tidak dicentang delete, dan di save */
            if ($req->tick[$flg] == 0) {
                DB::table('xxrepgroup_mstr')
                ->insert([
                    'xxrepgroup_nbr'        => $req->h_code,
                    'xxrepgroup_desc'       => $req->h_desc,
                    'xxrepgroup_line'       => $req->line[$flg],
                    'xxrepgroup_rep_code'   => $req->barang[$flg],      
                    'xxrepgroup_rep_desc'   => $req->erepmdesc[$flg],      
                ]);
            }            

            $flg += 1;
        }    

        toast('Repair Group Updated.', 'success');
        return back();
    }

	 public function deleterepgroup(Request $req)
    {
			
        DB::table('xxrepgroup_mstr')
            ->where('xxrepgroup_nbr', '=', $req->d_code)
            ->delete();

        toast('Deleted Repair Group Successfully.', 'success');
        return back();
    }
	
    public function repgrouppagination(Request $req)
    {
        //dd($req->all());
        if ($req->ajax()) {
            $sort_by = $req->get('sortby');
            $sort_group = $req->get('sorttype');
            $code = $req->get('code');
            $desc = $req->get('desc');

            $datadetail = DB::table('xxrepgroup_mstr')
                ->get();

            $datarepair = DB::table('rep_master')
                ->orderby('repm_code')
                ->get();

            $datagroup = DB::table('xxrepgroup_mstr')
                ->selectRaw('MIN(xxrepgroup_nbr) as xxrepgroup_nbr, MIN(xxrepgroup_desc) as xxrepgroup_desc')
                ->groupBy('xxrepgroup_nbr')
                ->orderby('xxrepgroup_nbr')
                ->get();
      
            if ($code == '' && $desc == '') {
                $data = DB::table('xxrepgroup_mstr')
                    ->selectRaw('MIN(xxrepgroup_nbr) as xxrepgroup_nbr, MIN(xxrepgroup_desc) as xxrepgroup_desc')
                    ->groupBy('xxrepgroup_nbr')
                    ->orderby('xxrepgroup_nbr')
                    ->paginate(10);
                return view('setting.table-repgroup', ['data' => $data, 'datadetail' => $datadetail, 'datarepair' => $datarepair, 
                    'datagroup' => $datagroup]);
            } else {
                $kondisi = '';
                if ($code != '') {
                    $kondisi = "xxrepgroup_nbr like '%" . $code . "%'";
                }
                if ($desc != '') {
                    if ($kondisi != '') {
                        $kondisi .= " and xxrepgroup_rep_code like '%" . $desc . "%'";
                    } else {
                        $kondisi = "xxrepgroup_rep_code like '%" . $desc . "%'";
                    }
                }

                $data = DB::table('xxrepgroup_mstr')
                    ->selectRaw('MIN(xxrepgroup_nbr) as xxrepgroup_nbr, MIN(xxrepgroup_desc) as xxrepgroup_desc')
                    ->whereRaw($kondisi)
                    ->groupBy('xxrepgroup_nbr')
                    ->orderby('xxrepgroup_nbr')
                    ->paginate(10);

                return view('setting.table-repgroup', ['data' => $data, 'datadetail' => $datadetail, 'datarepair' => $datarepair,
                    'datagroup' => $datagroup]);
            }
        }
    }
}
