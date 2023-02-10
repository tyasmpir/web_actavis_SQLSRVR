@forelse ($data as $show)
<tr class="foottr" style="text-align: center;">
  <td class="foot2" data-label="WO Number">{{ $show->wo_nbr }}</td>
  <td class="foot2" data-label="Asset">{{ $show->asset_desc }}</td>
  <td class="foot2" data-label="Status">{{ $show->wo_status }}</td>
  <td class="foot2" >
  <div class="text-center">
  <input type="hidden" name='wonbrr' value="{{$show->wo_nbr}}"> 
  @if($show->wo_status == 'started')
    <button type="button" class="btn btn-success btn-action jobview" style="width: 70%;">View</button>
  @endif
  @if($show->wo_status =='finish')
  <a id="aprint" target="_blank" style="width: 70%;"><button type="button" class="btn btn-warning bt-action" style="width: 70%;"><b>Print<b></button></a>  
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