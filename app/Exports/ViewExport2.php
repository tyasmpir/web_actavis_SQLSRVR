<?php

/*
Daftar perubahan :
A211126 : repair dihilangkan, karena defaultnya akan other semua. file sebelumnya sudah di backup di 211126 sblm diilangin repair

*/

namespace App\Exports;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ViewExport2 implements FromQuery, WithHeadings, ShouldAutoSize,WithStyles
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function styles(Worksheet $sheet)
    {
        return [
        // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
    function __construct($wonbr,$status,$asset,$priority,$period,$creator,$engineer,$woper1,$woper2,$wotype,$woimpact) {
        $this->wonbr    = $wonbr;
        $this->status   = $status;
        $this->asset    = $asset;
        $this->priority = $priority;
        $this->period   = $period;
        $this->creator  = $creator;
        $this->engineer = $engineer;
        $this->woper1   = $woper1;
        $this->woper2   = $woper2;
        $this->wotype   = $wotype;
        $this->woimpact = $woimpact;
    }
    public function query()
    {
        $kondisi = "wo_mstr.wo_id > 0";

        if($this->wonbr != null ||$this->wonbr != '' ){
            $kondisi .= "wo_nbr = '".$this->wonbr."'";
            // dd($kondisi);
        }
        if($this->status != null ||$this->status != '' ){
            if($kondisi <> '') {
                $kondisi .= " and wo_status = '".$this->status."'";
            } else {
                $kondisi .= "wo_status = '".$this->status."'";
            }
        }
        if($this->asset != null ||$this->asset != '' ){
            if($kondisi <> '') {
                $kondisi .= "and wo_asset = '".$this->asset."'";
            } else {
                $kondisi .= "wo_asset = '".$this->asset."'";
            }
        }
        if($this->priority != null ||$this->priority != '' ){
            if($kondisi <> '') {
                $kondisi .= " and wo_priority = '".$this->priority."'";
            } else {
                $kondisi .= "wo_priority = '".$this->priority."'";
            }
            // dd($kondisi);
        }
        if($this->creator != null ||$this->creator != '' ){
            if($kondisi <> '') {
                $kondisi .= " and wo_creator = '".$this->creator."'";
            } else {
                $kondisi .= "wo_creator = '".$this->creator."'";
            }
        }
        if($this->period != null || $this->period != ''){
            if($this->period == '1'){
                $kondisi .= " and wo_created_at > '". Carbon::today()->subDay(2) ."'";
            }
            else if($this->period == '2'){
                $kondisi .= " and wo_created_at BETWEEN'". Carbon::today()->subDay(3) . "' AND '" .Carbon::today()->subDay(5)."'";
            }
            else if($this->period == '3'){
                $kondisi .= " and wo_created_at < '". Carbon::today()->subDay(5) ."'";
            }
        }
        if($this->engineer != null ||$this->engineer != '' ){
            if($kondisi <> '') {
                $kondisi .= " and (wo_engineer1 = '".$this->engineer."' or wo_engineer2 = '".$this->engineer."' or wo_engineer3 = '".$this->engineer."' or wo_engineer4 = '".$this->engineer."' or wo_engineer5 = '".$this->engineer."')";
            } else {
                $kondisi .= "(wo_engineer1 = '".$this->engineer."' or wo_engineer2 = '".$this->engineer."' or wo_engineer3 = '".$this->engineer."' or wo_engineer4 = '".$this->engineer."' or wo_engineer5 = '".$this->engineer."')";
            }
        }
        if (($this->woper1 != NULL || $this->woper1 != '') and ($this->woper2 != NULL || $this->woper2 != '')) {
            $kondisi .= " and CAST(wo_schedule AS DATE) between '". $this->woper1 . "' and '". $this->woper2 ."'";
        }
        if ($this->wotype != NULL || $this->wotype != '') {
           $kondisi .= " and asset_group='".$this->wotype."'";
        }
        if ($this->woimpact != '') {
            $kondisi .= " and wo_new_type = '" .$this->woimpact. "'";
        }
//dd($kondisi);
        if($kondisi == ''){
            //dd('test1');
            return  DB::table('wo_mstr')
                ->selectRaw("wo_nbr,(case when wo_type = 'auto' then 'PM' else 'WO' end) as Type, asset_group,
                    wo_sr_nbr,convert(varchar, sr_created_at, 105) as 'tgl',convert(varchar, sr_created_at, 8) as 'jam',
                    wo_note,wo_asset,asset_desc,wo_new_type,
                    IsNull(wo_mstr.wo_engineer1,'-') as 'eng1', IsNull(u1.eng_desc,'-') as 'nm1',
                    IsNull(wo_mstr.wo_engineer2,'-') as 'eng2', IsNull(u2.eng_desc,'-') as 'nm2', IsNull(wo_engineer3, '-') as 'eng3',
                    IsNull(u3.eng_desc, '-') as 'nm3', IsNull(wo_engineer4, '-') as 'eng4', IsNull(u4.eng_desc, '-') as 'nm4',
                    IsNull(wo_engineer5, '-') as 'eng5', IsNull(u5.eng_desc, '-') as 'nm5',
                    dept_desc, wo_schedule,wo_start, wo_finish_date,wo_finish_time, wo_duedate,
                    wo_status, wo_priority, CAST(wo_created_at AS DATE) AS wo_created_at, wo_creator")
                ->leftJoin('service_req_mstr','wo_sr_nbr','sr_number')
                ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
                ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
                ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
                ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
                ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
                ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
                ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
                ->leftjoin('xxrepgroup_mstr','xxrepgroup_mstr.xxrepgroup_nbr','wo_mstr.wo_repair_group')
                ->distinct()
                ->orderby('wo_created_at','desc');  
        }
        else{
            //dd('test');
            return  DB::table('wo_mstr')
            ->selectRaw("wo_nbr,(case when wo_type = 'auto' then 'PM' else 'WO' end) as Type, asset_group,
                wo_sr_nbr,convert(varchar, sr_created_at, 105) as 'tgl',convert(varchar, sr_created_at, 8) as 'jam',
                wo_note,wo_asset,asset_desc,wo_new_type,
                IsNull(wo_mstr.wo_engineer1,'-') as 'eng1', IsNull(u1.eng_desc,'-') as 'nm1',
                IsNull(wo_mstr.wo_engineer2,'-') as 'eng2', IsNull(u2.eng_desc,'-') as 'nm2', IsNull(wo_engineer3, '-') as 'eng3',
                IsNull(u3.eng_desc, '-') as 'nm3', IsNull(wo_engineer4, '-') as 'eng4', IsNull(u4.eng_desc, '-') as 'nm4',
                IsNull(wo_engineer5, '-') as 'eng5', IsNull(u5.eng_desc, '-') as 'nm5',
                dept_desc, wo_schedule,wo_start, wo_finish_date,wo_finish_time, wo_duedate,
                wo_status, wo_priority, CAST(wo_created_at AS DATE) AS wo_created_at, wo_creator")
            ->leftJoin('service_req_mstr','wo_sr_nbr','sr_number')
            ->leftjoin('eng_mstr as u1','wo_mstr.wo_engineer1','u1.eng_code')
            ->leftjoin('eng_mstr as u2','wo_mstr.wo_engineer2','u2.eng_code')
            ->leftjoin('eng_mstr as u3','wo_mstr.wo_engineer3','u3.eng_code')
            ->leftjoin('eng_mstr as u4','wo_mstr.wo_engineer4','u4.eng_code')
            ->leftjoin('eng_mstr as u5','wo_mstr.wo_engineer5','u5.eng_code')
            ->leftjoin('asset_mstr','wo_mstr.wo_asset','asset_mstr.asset_code')
            ->leftJoin('dept_mstr','wo_mstr.wo_dept','dept_mstr.dept_code')
            ->leftjoin('xxrepgroup_mstr','xxrepgroup_mstr.xxrepgroup_nbr','wo_mstr.wo_repair_group')
            ->whereRaw($kondisi)
            ->distinct()
            ->orderby('wo_created_at','desc');
        }
        
        // dd($test); 
    }
    public function headings(): array
    {
        return ['Work Order Number','WO Type','Asset Group','Service Request Number','Service Request Date','Service Request Time',
        'Note','Asset Code','Asset Name','WO Type','Engineer 1 Code','Engineer 1 Name','Engineer 2 Code',
        'Engineer 2 Name','Engineer 3 Code','Engineer 3 Name','Engineer 4 Code','Engineer 4 Name','Engineer 5 Code',
        'Engineer 5 Name','Department',
        'Schedule Date','Start Date','Finish Date','Finish Time',
        'Due Date','Status','Priority','Requested Date','Requested By']; /* A211126 */
    }

    
}
