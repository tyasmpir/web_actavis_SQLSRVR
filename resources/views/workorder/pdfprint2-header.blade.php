<!--------------- INI UNTUK PRINT TEMPLATE --------------->
  <table style="width:730px; height:10px; margin-top:-1.6cm;margin-left:-0.5cm;"class="borderless">
  <tr>    
    <td style="width: 710px; height:10px; text-align:left;vertical-align:middle;border:1px solid"> 
 
      <p style="margin-left: 0.5cm"><span style="display:inline-block;text-align: left;width:410px"><b>PT Actavis Indonesia</b></span><span style="display:inline-block;text-align: right;width:300px"><b>Ref. SOP 02-04-000-01</b></span> </p>      
    </td>
    
  </table>
  <table style="width:730px; height:1px; margin-left:-0.5cm;"class="borderless">
    <tr>
      <td style="height:1px;border: 0px"></td>
      <td style="height:1px;border: 0px"></td>
      <td style="height:1px;border: 0px"></td>
      <td style="height:1px;border: 0px"></td>
      <td style="height:1px;border: 0px"></td>
    </tr>
    <tr>
      <td style="width: 80.724px; height:40px; text-align:left;vertical-align:top;border:1px solid" > 
        <p style="margin-top: 0;margin-bottom:0.2cm"><b>No. FA / ID:</b></p>
        <p style="margin-top: 0;margin-bottom:0.2cm"><b>{{$data->asset_code}}</b></p>
      </td>
      <td style="width: 20px;border: 0px" rowspan="2"></td>
      <td style="width: 350px; height:80px; text-align:center;vertical-align:middle;border:1px solid;font-size:22px" rowspan="2">
    
        <p style="margin:1cm"><b>SPESIFIKASI KERJA PREVENTIVE MAINTENANCE</b></p>
    
      </td>
      <td style="width: 20px;border: 0px" rowspan="2"></td>
        <td style="width: 120.724px; height:40px;  text-align:left;vertical-align:top;border:1px solid">
          <p style="margin-top: 0;margin-bottom:0.2cm"><b>Tanggal : </b></p> 
          <p style="margin-top: 0;margin-bottom:0.2cm">{{date('d-m-Y H:i:s',strtotime($printdate))}}</p>
        </td>
    </tr>  
    <tr>
      <td style="width: 120.724px;height: 40px;  text-align:left;vertical-align:top;border:1px solid">
        <p style="margin-top: 0;margin-bottom:0.2cm"><b>Periodisasi : </b></p>
        @if($data->asset_measure == 'C')
          <p style="margin-top: 0;margin-bottom:0.1cm">{{number_format(($data->asset_cal / 30),1,'.','')}} Bulan</p>      
        @endif
      </td>
      <td style="width: 120.724px; height: 40px;  text-align:left;vertical-align:top;border:1px solid">
        <p style="margin-top: 0;margin-bottom:0.1cm"><b>Waktu</b></p>
        <p style="margin-top: 0;margin-bottom:0.1cm"><b>Mulai    : </b><span>{{date('d-m-Y',strtotime($data->wo_schedule))}} </span></p>
        <p style="margin-top: 0;margin-bottom:0.1cm"><b>Selesai  : </b>{{date('d-m-Y',strtotime($data->wo_finish_date))}}</p>
      </td>
    </tr>
    <tr>
      <td colspan="5" style="height: 20px;"><b>WO Number : </b>{{$data->wo_nbr}}</td>
    </tr>
</table>


