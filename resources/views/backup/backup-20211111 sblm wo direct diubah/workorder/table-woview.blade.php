<!-- Daftar Perubahan
  A211103 : file yang didownload bukan hanya berupa gambar
-->
@forelse ($data as $show)
<tr>
  <td>{{ $show->wo_nbr }}</td>
  <td style="text-align: left;">{{ $show->asset_desc }}</td>
  <td>{{ date('d-m-Y',strtotime($show->wo_schedule)) }}</td>
  <td>{{ date('d-m-Y',strtotime($show->wo_duedate)) }}</td>
  <td>{{ $show->wo_status }}</td>
  <td>{{$show->wo_priority}}</td>
  @if($show->wo_type == 'auto')
    <td>PM</td>
  @else
    <td>WO</td>
  @endif
  <td>{{$show->wo_creator}}</td>
  <td>{{date('d-m-Y',strtotime($show->wo_created_at))}}</td>
  <td>
      <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip" title="View WO"  data-wonbr="{{$show->wo_nbr}}" data-srnbr="{{$show->wo_sr_nbr}}" data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-eye fa-lg"></i></a>
      &ensp;
      @if($show->wo_status == 'finish' || $show->wo_status == 'closed')  
        <a id="adownload" target="_blank" href="{{url('wodownloadfile/'.$show->wo_nbr)}}" data-toggle="tooltip"  title="Download document" ><i class="icon-table fas fa-download fa-lg"></i></a>  
      @endif
  </td>
</tr>
@empty
<tr>
  <td colspan="7" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="7">
    {{ $data->links() }}
  </td>
</tr>