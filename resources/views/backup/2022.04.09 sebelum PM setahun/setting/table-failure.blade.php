@forelse($data as $show)
@php($dgroup = $dataasgroup->where('asgroup_code','=',$show->fn_assetgroup)->count())
@if($dgroup == 0)
    @php($descgroup = '')
@else
    @php($ddgroup = $dataasgroup->where('asgroup_code','=',$show->fn_assetgroup)->first())
    @php($descgroup = $ddgroup->asgroup_desc)
@endif
<tr>
    <td>{{$show->fn_code}}</td>
    <td>{{$show->fn_desc}}</td>
    <td>{{$show->fn_impact}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->fn_code}}" data-desc="{{$show->fn_desc}}" data-imp="{{$show->fn_impact}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->fn_code}}" data-desc="{{$show->fn_desc}}">
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