<!DOCTYPE html>
<html>
<head>
	<title>Work Order Requisition </title>
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
  

	<!--------------- INI UNTUK PRINT TEMPLATE --------------->
  @include('workorder.pdfprint-header')
<table style="width:725px; height:800.5px;margin-left:-1cm; margin-top:0.7cm;margin-bottom:-5cm;border:1px solid" class="borderless">
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Work Order Number</p>
</td>
<td style="width: 475px;" colspan="2">
  <p>{{$womstr->wo_nbr}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Name</p>
</td>
<td style="width: 475px;" colspan="2">
  <p>{{$womstr->name}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Department</p>
</td>
<td style="width: 475px;" colspan="2">
  <p>{{$womstr->dept_desc}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Date</p>
</td>
<td style="width: 475px;" colspan="2">
  <p>{{date('d-m-Y',strtotime($printdate))}}</p>
</td>
</tr>
<tr>
<td style="width: 250px; height:55px;vertical-align:middle">
  <p style="margin-left:5px;">Work Order Type</p>
</td>
<td style="width: 475px;" colspan="2">
  <p style="margin:0">{{$data[0]->fd1}}</p>
  <p style="margin:0">{{$data[0]->fd2}}</p>
  
  <p style="margin:0">{{$data[0]->fd3}}</p>

</td>
</tr>
<tr>
<td style="width: 250px; height:55px; vertical-align:middle">
  <p style="margin-left:5px;">Impact</p>
</td>
<td style="width: 475px;" colspan="2">
  <p style="margin:0">{{$data[0]->fi1}}</p>  
  <p style="margin:0">{{$data[0]->fi2}}</p>
  <p style="margin:0">{{$data[0]->fi3}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Work Order Description</p>
</td>
<td style="width: 475px;" colspan="2">
  <p>{{$data[0]->wo_note}}</p>
</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Due Date</p>
</td>
<td style="width: 475px;vertical-align:middle" colspan="2">
  {{date('d-m-Y',strtotime($data[0]->wo_duedate))}}
</td>
</tr>
<tr>
<td style="width: 250px; height:153px;vertical-align:middle">
  <p style="margin-left:5px;">Assign To</p>
</td>
<td style="width: 250px;">
@foreach($engineerlist as $el)
  @if($el != null)
    <p style="margin-top:0">{{$data[0]->u11}}</p>
  @endif
@endforeach
  <!-- <p style="margin-top:0">{{$data[0]->u11}}</p>
  <p>{{$data[0]->u22}}</p>
  <p>{{$data[0]->u33}}</p>
  <p>{{$data[0]->u44}}</p>
  <p>{{$data[0]->u55}}</p> -->
</td>
<td style="width: 225px;">
  <p style="margin-top:0">Action Taken :</p>
  @foreach($repairlist as $rl)
  <p>{{$rl}}</p>
  @endforeach

</td>
</tr>
<tr>
<td style="width: 250px; height:220px;vertical-align:middle">
  <p style="margin-left:5px;">Spare Part</p>
</td>
<td style="width: 250px;" colspan="2">
@foreach($sparepart as $sparepart)
  <p style="margin:0">{{$sparepart}}</p>
@endforeach

  

</td>
</tr>
<tr>
<td style="width: 250px;">
  <p style="margin-left:5px;">Excecution</p>
  <p></p>
  <p style="margin-left:5px;">Creator</p>
  <p></p>
</td>
<td style="width: 475px;" colspan="2" >
<input type="checkbox" style="height: 30px;padding-top:15px" id="vehicle1" name="vehicle1" value="Bike">
  <label for="vehicle1" style="vertical-align:center"> Completed</label><br>
  <input type="checkbox" id="vehicle2" style="height: 30px;padding-top:15px" name="vehicle2" value="Car">
  <label for="vehicle2" style="vertical-align:center"> Uncompleted</label>
  <label for="vehicle2" style="vertical-align: center;padding-left:5px"> Reason : ...</label>
</td>
</tr>
</table>
</body>
</html>
