@forelse($data as $show)
<tr>
    <td>{{$show->reppart_code}}</td>
    <td>{{$show->rep_desc}}</td>
    <td>
        <a href="" class="viewdata" id='viewdata' data-toggle="modal" data-target="#viewModal" data-code="{{$show->reppart_code}}" data-desc="{{$show->rep_desc}}">
        <i class="icon-table fa fa-eye fa-lg"></i>
        &ensp;
        <a href="" class="deletedata" data-toggle="modal" data-target="#deleteModal" data-code="{{$show->reppart_code}}">
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