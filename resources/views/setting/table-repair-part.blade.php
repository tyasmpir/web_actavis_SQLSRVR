@forelse($data as $show)
<tr>
    <td>{{$show->reppart_code}}</td>
    <td>{{$show->reppart_desc}}</td>
    <td>
        <a href="" class="editarea2" id='editdata' data-toggle="modal" data-target="#editModal" 
        data-code="{{$show->reppart_code}}" data-desc="{{$show->reppart_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="" class="deletedata" data-toggle="modal" data-target="#deleteModal" 
        data-code="{{$show->reppart_code}}" data-desc="{{$show->reppart_desc}}">
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