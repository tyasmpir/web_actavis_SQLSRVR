@forelse ($data as $show)
<tr class="foottr" style="text-align: left;">
  <td style="text-align: left;">{{ $show->assetcode }}</td>
  <td style="text-align: left;">{{ $show->asset_desc }}</td>
  <td style="text-align: right;">{{ $show->asset_last_usage }}</td>
  <td style="text-align: right;">{{ $show->asset_tolerance }}</td>
  @if($show->asset_measure == 'C')
    <td style="text-align: right;">{{ $show->asset_cal }}</td>
  @else
    <td style="text-align: right;">{{ $show->asset_meter }}</td>
  @endif
  <td style="text-align: left;">{{ $show->asset_measure }}</td>
  <td style="text-align: right;">{{ $show->asset_on_use }}</td>
  <td>
    <a href="" class="editmodal" data-toggle="modal" data-target="#editModal" 
            data-asset="{{$show->assetcode}}" data-lastusage="{{$show->asset_last_usage}}"
            data-lastmt="{{$show->asset_last_usage_mtc}}" data-assetonuse="{{$show->asset_on_use}}"><i class="fas fa-edit"></i></a>  
  </td>
</tr>
@empty
<tr>
  <td colspan="8" style="color:red;" class="nodata">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td colspan="8" style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>