@forelse ($data as $show)
<tr class="foottr">
  <td class="foot1" data-label="WO Number">{{ $show->assetcode }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asset_desc }}</td>
  <td class="foot1" data-label="Last Usage">
  @if(is_null($show->asset_last_usage))
    0
  @else
    {{ $show->asset_last_usage }}
  @endif
  </td>
  <td class="foot1" data-label="Next Usage">{{ $show->asset_last_usage + $show->asset_meter }}</td>
  <td class="foot1" data-label="Last Checked">
  @if(is_null($show->asset_last_usage_mtc))
    0
  @else
    {{ $show->asset_last_usage_mtc }}
  @endif
  </td>
  <td class="foot1" style="text-align: center;" >
    <a href="" class="editmodal" data-toggle="modal" data-target="#editModal" 
            data-asset="{{$show->assetcode}}" data-desc="{{$show->asset_desc}}" data-lastusage="{{$show->asset_last_usage}}"
            data-lastmt="{{$show->asset_last_usage_mtc}}"><i class="fas fa-edit"></i></a>  
  </td>
</tr>
@empty
<tr>
  <td colspan="6" style="color:red;" class="nodata">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>