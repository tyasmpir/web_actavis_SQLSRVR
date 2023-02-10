@forelse($data as $show)
@php($a = $datains->where('insg_code','=',$show->repm_ins)->count())
@if($a == 0)
    @php($desca = '')
@else
    @php($a = $datains->where('insg_code','=',$show->repm_ins)->first())
    @php($desca = $a->insg_desc)
@endif

@php($b = $datapart->where('reppg_code','=',$show->repm_part)->count())
@if($b == 0)
    @php($descb = '')
@else
    @php($b = $datapart->where('reppg_code','=',$show->repm_part)->first())
    @php($descb = $b->reppg_desc)
@endif

<tr>
    <td>{{$show->repm_code}}</td>
    <td>{{$show->repm_desc}}</td>
    <td>{{$show->repm_ref}}</td>
    <td>{{$show->repm_ins}} - {{$desca}} </td>
    <td>
        <a href="" class="editarea2" id='editdata' data-toggle="modal" data-target="#editModal" 
        data-code="{{$show->repm_code}}" data-desc="{{$show->repm_desc}}" data-ins="{{$show->repm_ins}}"
        data-ref="{{$show->repm_ref}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="" class="deletedata" data-toggle="modal" data-target="#deleteModal" 
        data-code="{{$show->repm_code}}" data-desc="{{$show->repm_desc}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
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
    {{ $data->links() }}
  </td>
</tr>