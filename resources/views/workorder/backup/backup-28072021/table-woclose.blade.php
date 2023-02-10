@forelse ($data as $show)
<tr class="foottr" style="text-align: center;">
  <td class="foot2" data-label="WO Number">{{ $show->wo_nbr }}</td>
  <td class="foot2" data-label="Asset">{{ $show->asset_desc }}</td>
  @if($show->wo_type == 'auto')
    <td class="foot2" data-label="WO Type">Preventive</td>
  @elseif($show->wo_type == 'direct')
    <td class="foot2" data-label="WO Type">Direct</td>
  @elseif($show->wo_type == 'other')
    @if($show->wo_sr_nbr != null)
      <td class="foot2" data-label="WO Type">WO from service request</td>
    @else
      <td class="foot2" data-label="WO Type">Work Order</td>
    @endif
  @endif
  <td class="foot2" data-label="Status">{{ $show->wo_status }}</td>
  <td class="foot2" >
  <div class="text-center">
  <input type="hidden" name='wonbrr' value="{{$show->wo_nbr}}"> 
  @if($show->wo_status == 'started')
    <button type="button" class="btn btn-success btn-action jobview" style="width: 70%;">View</button>
  @endif
  @if($show->wo_status =='finish' && $show->wo_type != 'auto')
  <a class="aprint" target="_blank" style="width: 70%;"><button type="button" class="btn btn-warning bt-action" style="width: 70%;"><b>Print<b></button></a>
  @elseif($show->wo_status =='finish' && $show->wo_type == 'auto')
  <button type="button" class="btn btn-secondary bt-action" style="width: 70%;" disabled="true"><b>Print<b></button>  
  @endif
   
  </div> 
    
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