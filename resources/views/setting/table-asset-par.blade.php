@forelse($data as $show)
@php($descPar = $dataasset->where('asset_code','=',$show->aspar_par)->count())
@if($descPar == 0)
    @php($desca = "")
@else
    @php($descPar = $dataasset->where('asset_code','=',$show->aspar_par)->first())
    @php($desca = $descPar->asset_desc)
@endif

@php($descChild = $dataasset->where('asset_code','=',$show->aspar_child)->count())
@if($descChild == 0)
    @php($descb = "")
@else
    @php($descChild = $dataasset->where('asset_code','=',$show->aspar_child)->first())
    @php($descb = $descChild->asset_desc)
@endif

<tr>

    <td>{{$show->aspar_par}} - {{$desca}} </td>
    <td>{{$show->aspar_child}} - {{$descb}} </td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->aspar_par}}" data-desc="{{$desca}}">
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->aspar_par}}" data-desc="{{$show->aspar_child}}">
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