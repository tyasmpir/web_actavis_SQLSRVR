@php($data = $datadetail->where('repins_code','=','12'))
@forelse($data as $show)
<tr>
    @php($descRep = $datarep->where('rep_code','=',$show->repins_code)->first())
    @php($descIns = $datains->where('ins_code','=',$show->repins_ins)->first())
    @php($desctool = $datatool->where('tool_code','=',$show->repins_tool)->first())
    <td>{{$show->repins_code}}</td>
    <td>{{$descRep->rep_desc}}</td>
    <td>{{$show->repins_step}}</td>
    <td>{{$show->repins_ins}}</td>
    <td>{{$descIns->ins_desc}}</td>
    <td>{{$show->repins_tool}}</td>
    <td>{{$desctool->tool_desc}}</td>
    <td>{{$show->repins_hour}}</td>
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
   
  </td>
</tr>