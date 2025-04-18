<!--
  Daftar Perubahan :
  A210928 : reportnya hanya 1 icon, dibedakan berdasarkan type wo nya saja
  A211019 : jika status reviewer Incomplete, maka tidak akan merubah status apapun di SR. Reviewer dapat melakukan complete WO ulang
  A211101 : perubahan nama status incomplete menjadi reprocess pada approval spv
-->
@forelse ($data as $show)
<tr>
  <td>{{ $show->wo_nbr }}</td>
  <td style="text-align: left;">{{ $show->asset_code }}</td>
  <td style="text-align: left;">{{ $show->asset_desc }}</td>
  <!-- <td>{{ date('d-m-Y',strtotime($show->wo_schedule)) }}</td>
  <td>{{ date('d-m-Y',strtotime($show->wo_duedate)) }}</td> -->
  <td>{{ $show->wo_status }}</td>
  <!-- <td>{{$show->wo_priority}}</td> -->
  @if($show->wo_type == 'auto')
    <td>PM</td>
  @else
    <td>WO</td>
  @endif
  <td>{{ $show->wo_impact }}</td>
  <td>{{ $show->asset_group }}</td>
  <td>{{date('d-m-Y',strtotime($show->wo_created_at))}}</td>
  <td>{{$show->wo_creator}}</td>
  <td >
    <input type="hidden" name='wonbrr' value="{{$show->wo_nbr}}">
    <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip"  title="View WO"  data-wonbr="{{$show->wo_nbr}}" data-srnbr="{{$show->wo_sr_nbr}}" data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-eye fa-lg"></i></a>

    @if($show->wo_status == 'open' || $show->wo_status == 'plan')
    &nbsp;
    <a href="javascript:void(0)" class="editwo2" data-toggle="tooltip"  title="Edit WO"  data-target="#editModal" data-wonbr="{{$show->wo_nbr}}" data-srnbr="{{$show->wo_sr_nbr}}" data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-edit fa-lg"></i></a>
    
    @endif
    @if($show->wo_status =='plan' && $usernow[0]->approver == 1)
    &nbsp;
    <a href="javascript:void(0)" class="approvewo" data-toggle="tooltip"  title="Approve WO"  data-target="#approveModal" data-wonbr="{{$show->wo_nbr}}"  data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-thumbs-up fa-lg"></i></a>
    
    @endif
    <!-- @if ($show->wo_status == 'closed')
    <a href="javascript:void(0)" class="reopen"  data-wonbr="{{$show->wo_nbr}}"  data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-redo fa-lg"></i></a>      
    &ensp;
    @endif -->
    @if (($show->wo_status == 'finish' && $show->wo_reviewer == null && $usernow[0]->approver == 1) || ($show->wo_status == 'finish' && $show->wo_reviewer == $usernow[0]->username && $show->wo_reviewer_appdate == null) || ($show->wo_status == 'finish' && $show->wo_reviewer_appdate != null && $show->wo_approver == null && $usernow[0]->approver == 1) || ($show->wo_status == 'finish' && $show->wo_reviewer_appdate != null && $show->wo_approver == $usernow[0]->username && $show->wo_approver_appdate == null) 
    || ($show->wo_status == 'reprocess') {{-- A211019 A211101 --}} )
      &nbsp;
      <a href="javascript:void(0)" class="accepting" data-toggle="tooltip"  title="Confirm WO" data-wonbr="{{$show->wo_nbr}}"  data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fas fa-check-double fa-lg"></i></a>      
    
    @endif

    {{-- @if($show->wo_type != 'auto' && $show->wo_status != 'open' && $show->wo_status != 'plan' ) --}}
    @if($show->wo_type != 'auto' && $show->wo_status != 'open' )
    &nbsp;
    <a href="{{url('openprint/'.$show->wo_nbr)}}" data-toggle="tooltip"  title="Print WO" target="_blank" ><i class="icon-table fa fa-print fa-lg"></i></a>
    @endif

    @if($show->wo_status == 'open')
    &nbsp;
    <a href="" class="deletewo" data-toggle="modal" data-target="#deleteModal" data-wonbr="{{$show->wo_nbr}}"><i class="icon-table fa fa-trash fa-lg"></i></a>
    @endif
    
    {{-- @if($show->wo_repair_type != null && $show->wo_type != 'auto' && $show->wo_status != 'open' && $show->wo_status != 'plan' ) --}}
    {{--
    @if($show->wo_repair_type != null && $show->wo_type == 'auto' && $show->wo_status != 'open')
    &nbsp;
      <a id="aprint2" target="_blank" href="{{url('openprint2/'.$show->wo_nbr)}}" data-toggle="tooltip"  title="Print WO" >2<i class="icon-table fas fa-print fa-lg"></i></a>  
    @endif 
    --}}
    &nbsp;
      <a id="adownload" target="_blank" href="{{url('wodownloadfile/'.$show->wo_nbr)}}" data-toggle="tooltip"  title="Download asset document" ><i class="icon-table fas fa-download fa-lg"></i></a>  
  </td>
</tr>
@empty
<tr>
  <td colspan="9" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td colspan="9" style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>