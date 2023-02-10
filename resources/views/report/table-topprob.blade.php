@forelse($data as $show)
@php($a = $dataasset->where('asset_code','=',$show->wo_asset)->count())
@if($a == 0)
    @php($desc = "")
@else
    @php($b = $dataasset->where('asset_code','=',$show->wo_asset)->first())
    @php($desc = $b->asset_desc)
@endif
<tr>
    <td>{{$show->wo_asset}}</td>
    <td>{{$desc}}</td>
    <td>{{$show->jmlasset}}</td>
    <td style="text-align: center">
        <a href="" class="viewdata" id='viewdata' data-toggle="modal" data-target="#viewModal" 
        data-code="{{$show->wo_asset}}">
            <i class="fas fa-eye"></i>
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