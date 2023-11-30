<!DOCTYPE html>
<html>
<head>
	<title>Work Order Requisition</title>
</head>
<body>
	<style type="text/css">
    @page { margin: 50px 50px 50px 50px; }
    #header { 
      position: fixed; 
      left: 0px; 
      top: -70px; 
      right: 0px;  
      text-align: center; 
    }
    #detail { 
      position: fixed; 
      left: 0px; 
      top: -60px; 
      right: 0px;  
      text-align: center; 
    }
    .pindah{
      display: block;
      page-break-before: always;
    }
    table.minimalistBlack td, table.minimalistBlack th {
      border: 0.5px solid #000000;
      vertical-align: center;
      padding-left: 3px;
      padding-right: 3px;
      padding-top: 2px;
    }
    table.minimalistBlack tbody td {
      font-size: 14px;
      word-wrap:break-word;
    }
    table.minimalistBlack {
      width: 816.4px;
      border-spacing: 0px;
      
    }
    table.borderless td, table.borderless th {
      border-top: 0.5px solid #000000;
      
      border-right: 0.5px solid #000000;
      vertical-align: center;
      padding-left: 3px;
      padding-right: 3px;
      padding-top: 2px;
    }
    table.borderless tbody td {
      font-size: 14px;
      word-wrap:break-word;
    }
    table.borderless {
      width: 816.4px;
      border-spacing: 0px;
    }
    .noborder tr td{
      border:none;
      vertical-align: center;
    }
    th {
      font-weight: bold;
      font-size: 14px;
      text-align: center; 
    }
	</style>
	@php($flg = 0)
  @php($batas = 30)
  @php($batasakhir = 0)
  @php($pagenow = 1)

<!-- Daftar Perubahan 
  A211014 : Ganti nama approver, tadinya yang tampil username, diganti jadi namanya
  B211014 : Tambahin tanggal user acceptance
  A221028 : Perubahan sesuai email tanggal 25 Oktober 2022
-->


	<!--------------- INI UNTUK PRINT TEMPLATE --------------->
  @include('workorder.pdfprint-header')
<table style="width:722px; height:800.5px;margin-left:-0.5cm; margin-top:0.7cm;margin-bottom:-5cm;border:1px solid;page-break-after:always" class="borderless">
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Work Order Number</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{$womstr->wo_nbr}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Name</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{$womstr->name}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Department</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{$womstr->dept_desc}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Request Date</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{date('d-m-Y H:i',strtotime($printdate))}}</p>
</td>
</tr>
<tr>
  <td style="width: 250px;">
    <p style="margin-left:5px;">Due Date</p>
  </td>
  <td style="width: 300px;vertical-align:middle" colspan="2">
    {{date('d-m-Y',strtotime($data[0]->wo_duedate))}}
  </td>
  </tr>
<tr>
<td style="width: 250px; height:15px;vertical-align:middle">
  <p style="margin-left:5px;">Work Order Type</p>
</td>
<td style="width: 300px;vertical-align:middle" colspan="2">

  <p>{{$data[0]->wotyp_desc}}</p>
</td>
</tr>
<tr>
<td style="width: 250px; height:80px;vertical-align:middle">
  <p style="margin-left:5px;">Impact</p>
</td>
<td style="width: 250px;" colspan="2">
@php ($newarray = explode(";",$data[0]->wo_impact_desc))
@foreach($newarray as $na)
  <p style="margin:0">{{$na}}</p>  
@endforeach
</td>
</tr>

<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Location</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{$data[0]->loc_desc}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Process / Technology</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{$data[0]->astype_desc}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">ID Code</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{$data[0]->wo_asset}} -- {{$data[0]->asset_desc}}</p>
</td>
</tr>
<tr>
<td style="width: 250px; height:190px;vertical-align:middle">
  <p style="margin-left:5px;">Work Order Description</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{ is_null($data[0]->wo_note) ? '-' : $data[0]->wo_note }}</p>
</td>
</tr>

<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Engineering SPV</p>
</td>
<td style="width: 300px;" colspan="2">
  <p>{{ is_null($data[0]->wo_reviewer) ? '-' : $data[0]->wo_reviewer }}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Status</p>
</td>
<td style="width: 300px; vertical-align:middle" colspan="2">
  <input type="checkbox" id="checkboxreject" style="vertical-align: middle;"><label for="checkboxreject" style="vertical-align:middle"> Reject</label>
</td>
</tr>


</table>
@php($pagenow += 1)
@include('workorder.pdfprint-header')
<table style="width:722px; height:300px;margin-left:-0.5cm; margin-top:0.7cm;margin-bottom:-5cm;border:1px solid" class="borderless">
{{--  A221028 <tr>
  <td style="height:55px;" width = "70">
    <p  style="margin-left:5px;">Assigned to technician</p>
  </td>
 <td style="width: 350px;" colspan="2">
   <p>
  @foreach($engineerlist as $el)
    @if($el != null)
      {{$el}},
    @endif
  @endforeach
  </p>
  
  <!-- <p style="margin-top:0">{{$data[0]->u11}}</p>
  <p>{{$data[0]->u22}}</p>
  <p>{{$data[0]->u33}}</p>
  <p>{{$data[0]->u44}}</p>
  <p>{{$data[0]->u55}}</p> -->
  </td>
  </tr>  --}}
  <tr>
  <td style="width: 250px; height:190px" rowspan="2">
    <p  style="margin-left:5px;">Action Taken :</p>
    <p  style="margin-left:5px;">Start Date : {{ is_null($data[0]->wo_start) ? '-' : date('d-m-Y',strtotime($data[0]->wo_start )) }} </p>
  </td>
    <td colspan="2">{{ is_null($data[0]->wo_action) ? '-' : $data[0]->wo_action}}</td>
  </tr>
  <tr></tr>
  <tr>
  <td style="width: 250px;">
    <p style="margin-left:5px;">Sparepart</p>
  </td>
  <td colspan="2">{{ is_null($data[0]->wo_sparepart) ? '-' : $data[0]->wo_sparepart}}</td>
</tr>


<tr>
<td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>Engineer</b></p></td>
    <td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>Reviewer</b></p></td>
    <td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>Approver</b></p></td>

<!---
<td style="width: 250px;">
  <p style="margin-left:5px;">Excecution</p>
  <p></p>
  <p style="margin-left:5px;">Creator</p>
  <p></p>
</td>
<td style="width: 300px;" colspan="2" >
<input type="checkbox" style="height: 30px;padding-top:15px" id="vehicle1" name="vehicle1" value="Bike">
  <label for="vehicle1" style="vertical-align:center"> Completed</label><br>
  <input type="checkbox" id="vehicle2" style="height: 30px;padding-top:15px" name="vehicle2" value="Car">
  <label for="vehicle2" style="vertical-align:center"> Uncompleted</label>
  <label for="vehicle2" style="vertical-align: center;padding-left:5px"> Reason : ...</label>
</td>
-->

</tr>
 <tr>
    <td style="font-family:sans-serif;text-align:center;vertical-align:middle;height:80px">
     <p style="margin:0px;padding:0px;">
    @if($engineerlist->eng1 != null)
      {{$engineerlist->eng1}}
    @endif
    @if($engineerlist->eng2 != null)
      , {{$engineerlist->eng2}}
    @endif
    @if($engineerlist->eng3 != null)
      , {{$engineerlist->eng3}}
    @endif
    @if($engineerlist->eng4 != null)
      , {{$engineerlist->eng4}}
    @endif
    @if($engineerlist->eng5 != null)
      , {{$engineerlist->eng5}}
    @endif
    </p>
     </td>
    @if($data[0]->wo_reviewer != null)
      <td style="font-family:sans-serif;text-align:center;height:50px;vertical-align:middle">
        <!-- A211014 -->
        @php($nmreview = $users->where('username','=',$data[0]->wo_reviewer)->first())
        {{$nmreview->name}}
      </td>  
    @else
      <td style="font-family:sans-serif;text-align:center;height:50px;vertical-align:middle"></td>  
    @endif
    @if($data[0]->wo_approver != null)
      <td style="font-family:sans-serif;text-align:center;height:50px;vertical-align:middle">
        <!-- A211014 -->
        @php($nmapp = $users->where('username','=',$data[0]->wo_approver)->first())
        {{$nmapp->name}}
      </td>  
    @else
      <td style="font-family:sans-serif;text-align:center;height:50px;vertical-align:middle"></td>
    @endif
    
    <tr>
      {{--  A221028 <td style="font-family:sans-serif;text-align:left;height:20px"><p style="margin: 0px"><b>Tgl : </b> {{date('d-m-Y',strtotime($data[0]->wo_created_at))}}</p></td>  --}}
      @if(is_null($data[0]->wo_finish_date))
        <td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>-</b></p></td>
      @else
        <td style="font-family:sans-serif;text-align:left;height:20px"><p style="margin: 0px"><b>Tgl : </b> {{ date('d-m-Y',strtotime($data[0]->wo_finish_date )).' '.date('H:i',strtotime($data[0]->wo_finish_time))}}</p></td>
      @endif

      @if($data[0]->wo_reviewer_appdate != null)
        <td style="font-family:sans-serif;text-align:left;height:20px"><p style="margin: 0px"><b>Tgl : </b> {{date('d-m-Y',strtotime($data[0]->wo_reviewer_appdate))}}</p></td>
      @else
        <td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>-</b></p></td>
      @endif
      
      @if($data[0]->wo_approver_appdate != null)
        <td style="font-family:sans-serif;text-align:left;height:20px"><p style="margin: 0px"><b>Tgl : </b> {{date('d-m-Y',strtotime($data[0]->wo_approver_appdate))}}</p></td>
      @else
          <!-- B211014 -->
          @if(!$datasr)
            <td style="font-family:sans-serif;text-align:center;height:20px"><p style="margin: 0px"><b>-</b></p></td>
          @else
            <td style="font-family:sans-serif;text-align:left;height:20px">
              <p style="margin: 0px"><b>Tgl : </b> @if(!is_null($datasr->sr_accept_date)) {{date('d-m-Y',strtotime($datasr->sr_accept_date))}} @endif </p>
            </td>
          @endif
      @endif     
    </tr>

</table>
</body>
</html>
