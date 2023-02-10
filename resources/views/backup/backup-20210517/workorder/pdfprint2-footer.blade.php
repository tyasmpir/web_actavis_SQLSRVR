	
	<!--------------- INI UNTUK PRINT TEMPLATE --------------->
  <table style="width:740px; height:140px;margin-top:-0.3cm; margin-left:-1.2cm;margin-bottom:-1.7cm;"class="borderless">
  	
    <tr>
    <td style="width: 740px;font-family:sans-serif;border-top:0px" colspan="5">
    <p style="margin-top: 0"><b>* Kesimpulan :</b></p>
    <input type="checkbox" style="margin-left:4cm;transform:scale(1.5)"><label style="margin-left: 0.5cm;margin-right:0cm;font-size:14px">Kondisi mesin layak kerja</label>
    <input type="checkbox" style="margin-left:2cm;transform:scale(1.5)"><label style="margin-left: 0.5cm;margin-right:3cm;font-size:14px">Kondisi mesin tidak layak kerja</label>
    <p style="margin-top:0;margin-bottom:0cm"><b>Catatan :</b></p>
    
    </td>
    <tr><td colspan="2"  style="width:296px;font-family:sans-serif;height:20px" rowspan="3">
    <p style="margin: 0px"><b>Pemeriksaan oleh Engineering Supervisor</b></p>
    </td>
    
    <td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>Engineer</b></p></td>
    <td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>Reviewer</b></p></td>
    <td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>Approver</b></p></td>
    </tr>
    
    <tr>
    <td style="font-family:sans-serif;text-align:center;vertical-align:middle;height:80px">
    @if($engineerlist->eng1 != null)
      <p style="margin:0px;padding:0px">{{$engineerlist->eng1}}</p>
    
    @endif
    @if($engineerlist->eng2 != null)
      <p style="margin:0px;padding:0px">{{$engineerlist->eng2}}</p>
    @endif
    @if($engineerlist->eng3 != null)
      <p style="margin:0px;padding:0px">{{$engineerlist->eng3}}</p>
    @endif
    @if($engineerlist->eng4 != null)
      <p style="margin:0px;padding:0px">{{$engineerlist->eng4}}</p>
    @endif
    @if($engineerlist->eng5 != null)
      <p style="margin:0px;padding:0px">{{$engineerlist->eng5}}</p>
    @endif
    

    
    </td>
    <td style="font-family:sans-serif;text-align:center;height:50px;vertical-align:middle"><b>{{$printname}}</b></td>
    <td style="font-family:sans-serif;text-align:center;height:50px;vertical-align:middle"><b>{{$printname}}</b></td>
    </tr>
    <tr>
    <td style="font-family:sans-serif;text-align:left;height:20px"><p style="margin: 0px"><b>Tgl  </b> {{date('d-m-Y',strtotime($printdate))}}</p></td>
    <td style="font-family:sans-serif;text-align:left;height:20px"><p style="margin: 0px"><b>Tgl  </b> {{date('d-m-Y',strtotime($printdate))}}</p></td>
    <td style="font-family:sans-serif;text-align:left;height:20px"><p style="margin: 0px"><b>Tgl  </b> {{date('d-m-Y',strtotime($printdate))}}</p></td>
    </tr>  
</table>

