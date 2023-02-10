@forelse ($data as $show)
<tr class="foottr">
  <td class="foot1" data-label="WO Number">{{ $show->wo_nbr }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asset_code }} -- {{ $show->asset_desc }}</td>
  @if($show->wo_type == 'auto')
  <td class="foot1" data-label="WO Type">Preventive</td>
  @elseif($show->wo_type == 'direct')
  <td class="foot1" data-label="WO Type">Direct</td>
  @elseif($show->wo_type == 'other')
    @if($show->wo_sr_nbr != null)
    <td class="foot1" data-label="WO Type">WO from SR</td>
    @else
    <td class="foot1" data-label="WO Type">Work Order</td>
    @endif
  @endif
  <td class="foot1" data-label="Status">{{ $show->asset_group }}</td>
  <td class="foot1" data-label="Status">{{ date('d-m-Y',strtotime($show->wo_created_at)) }}</td>
  <td class="foot1" data-label="Status">{{ $show->wo_status }}</td>

  <!-- <td class="foot1" data-label="Priority">{{ $show->wo_priority }}</td> -->
  <td class="foot1" >
  <input type="hidden" name='wonbrr' value="{{$show->wo_nbr}}"> 
    <button type="button"  class="btn btn-success btn-action jobview" style="width: 100%;">View</button>
    
  </td>
@empty
<tr>
  <td colspan="7" style="color:red;">
    <center>No Task Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td colspan="7" style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>