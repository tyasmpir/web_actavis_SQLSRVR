<?php

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
class ExportSR implements FromQuery, WithHeadings, ShouldAutoSize,WithStyles
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

    function __construct($srnbr,$status,$asset,$priority,$period,$reqby) {
        $this->srnbr    = $srnbr;
        $this->status   = $status;
        $this->asset    = $asset;
        $this->priority = $priority;
        $this->period   = $period;
        $this->reqby    = $reqby;
    }

    public function query()
    {
        
        $xsrnbr    = $this->srnbr;
        $status    = $this->status;
        $asset     = $this->asset;
        $priority  = $this->priority;
        $period    = $this->period;
        $reqby     = $this->reqby;

        $tigahari = Carbon::now()->subDays(3)->toDateTimeString();
        $limahari = Carbon::now()->subDays(5)->toDateTimeString();

        if($period == 1){
            $kondisi = "sr_created_at > '".$tigahari."'";
        }else if($period == 2){
            $kondisi = "sr_created_at BETWEEN '".$tigahari."' AND '".$limahari."'";
        }else if($period == 3){
            $kondisi = "sr_created_at < '".$limahari."'";
        }else if($period == ""){
            $kondisi = "sr_created_at > 01-01-1900";
        }

        $data = DB::table("service_req_mstr")
                ->selectRaw("sr_number,wo_number,sr_assetcode,asset_desc")
                ->selectRaw("CASE WHEN sr_status = 1 THEN 'Open' WHEN sr_status = 2 THEN 'Assigned' WHEN sr_status = 3 THEN 'Started'
                    WHEN sr_status = 4 THEN 'Finish' WHEN sr_status = 5 THEN 'Closed' END AS sr_status")
                ->selectRaw("dept_desc,req_by,sr_priority,CAST(sr_created_at AS DATE) AS sr_created_at")
                ->leftjoin("asset_mstr","service_req_mstr.sr_assetcode","=","asset_mstr.asset_code")
                ->leftjoin("dept_mstr","dept_mstr.dept_code","=","service_req_mstr.sr_dept")
                ->whereRaw($kondisi)
                ->orderBy("sr_number", 'DESC');

        $data->when(isset($xsrnbr), function($q) use ($xsrnbr) {
            $q->where('sr_number', $xsrnbr);
        });

        $data->when(isset($status), function($q) use ($status) {
            $q->where('sr_status', $status);
        });

        $data->when(isset($asset), function($q) use ($asset) {
            $q->where('asset_desc', $asset);
        });

        $data->when(isset($priority), function($q) use ($priority) {
            $q->where('sr_priority', $priority);
        });

        $data->when(isset($reqby), function($q) use ($reqby) {
            $q->where('req_username', $reqby);
        });

        return $data;
    }

    public function headings(): array
    {
        return ['Service Request Number','Wo Number','Asset Code','Asset Desc','Status','Department','Requested By','Priority','Requested Date'];
    }

    
}
