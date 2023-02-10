<!--------------- INI UNTUK PRINT TEMPLATE --------------->
  <table style="width:740px; height:10px; margin-top:-1.6cm;margin-left:-1.2cm"class="borderless">    
  <!-- <tr>
    <td style="width: 350.724px; height:10px; text-align:left;vertical-align:middle;border-bottom:1px solid;border-left:0px;border-right:0px;border-top:0px" > 
    <p style="margin-left:0.5cm"><b>PT Actavis Indonesia</b></p>
    </td>

    
    <td style="width: 120.724px; height:10px; text-align:center;vertical-align:middle;border-bottom:1px solid;border-left:0px;border-right:0px;border-top:0px">
    <p><b>Effective Date : {{date('d.m.Y',strtotime($data->wo_start_date))}}</b></p>
    </td>
  </tr>
  <tr>    <td style="width: 350.724px; height:10px; text-align:left;vertical-align:middle;border-bottom:0;border-left:0px;border-right:0px;border-top:0px" > 
    
    </td>

    
    <td style="width: 120.724px; height:10px; text-align:center;vertical-align:middle;border-bottom:0;border-left:0px;border-right:0px;border-top:0px">
    
    </td></tr>
  <tr> -->
  <td style="width: 710px; height:10px; text-align:left;vertical-align:middle;border:1px solid" colspan="2"  > 
    <p style="margin-left: 0.5cm;"><b>PT Actavis Indonesia</b></p>
    </td></tr>
  </table>
  <table style="width:740px; height:1px; margin-left:-1.2cm;"class="borderless">
  <tr><td style="height:1px;border: 0px"></td>
  <td style="height:1px;border: 0px"></td>
  <td style="height:1px;border: 0px"></td>
  <td style="height:1px;border: 0px"></td>
  <td style="height:1px;border: 0px"></td></tr>
  <tr>
    <td style="width: 80.724px; height:50px; text-align:left;vertical-align:top;border:1px solid" > 
    <p style="margin-top: 0;margin-bottom:0.2cm"><b>No. FA / ID:</b></p>
    <p style="margin-top: 0;margin-bottom:0.2cm"><b>{{$data->asset_code}}</b></p>
    </td>
    <td style="width: 20px;border: 0px" rowspan="2"></td>
    <td style="width: 350px; height:100px; text-align:center;vertical-align:middle;border:1px solid;font-size:24px" rowspan="2">
    <p style="margin:1cm"><b>SPESIFIKASI KERJA PREVENTIVE MAINTENANCE</b></p>
    </td>
    <td style="width: 20px;border: 0px" rowspan="2"></td>
    <td style="width: 120.724px; height:80px;  text-align:left;vertical-align:top;border:1px solid">
    <p style="margin-top: 0;margin-bottom:0.2cm"><b>Tanggal : </b></p>
    <p style="margin-top: 0;margin-bottom:0.2cm">{{date('d-m-Y',strtotime($data->wo_created_at))}}</p>
    </td>
  </tr>  
  <tr>
    <td style="width: 120.724px;height: 50px;  text-align:left;vertical-align:top;border:1px solid">
    <p style="margin-top: 0;margin-bottom:0.2cm"><b>Periodisasi : </b></p>
    </td>
    <td style="width: 120.724px; height: 50px;  text-align:left;vertical-align:top;border:1px solid">
    <p style="margin-top: 0;margin-bottom:0.2cm"><b>Waktu</b></p>
    <p style="margin-top: 0;margin-bottom:0.2cm"><b>Mulai    : </b><span>{{date('d-m-Y',strtotime($data->wo_start_date))}} </span></p>
    <p style="margin-top: 0;margin-bottom:0.2cm"><b>Selesai  : </b>{{date('d-m-Y',strtotime($data->wo_finish_date))}}</p>
    </td>
  </tr>
  <tr><td colspan="5" style="height: 20px;"><b>WO Number : </b>{{$data->wo_nbr}}</td></tr>
</table>


