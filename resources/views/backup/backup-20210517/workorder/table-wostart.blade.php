@forelse ($data as $show)
<tr class="foottr" style="text-align: center;">
  <td class="foot1" data-label="WO Number">{{ $show->wo_nbr }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asset_desc }}</td>
  <td class="foot1" data-label="Status">{{ $show->wo_status }}</td>
  <td class="foot1" data-label="Priority">{{ $show->wo_priority }}</td>
  <td class="foot1" >
  <input type="hidden" name='wonbrr' value="{{$show->wo_nbr}}"> 
    <button type="button"  class="btn btn-success btn-action jobview" style="width: 100%;">View</button>
    
  </td>
</tr>
@empty
<tr>
  <td colspan="5" style="color:red;">
    <center>No Task Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>