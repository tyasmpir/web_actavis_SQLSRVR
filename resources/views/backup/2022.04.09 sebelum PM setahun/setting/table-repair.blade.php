@forelse($data as $show)
<tr>
    <td>{{$show->rep_code}}</td>
    <td>{{$show->rep_num}}</td>
    <td>{{$show->rep_desc}}</td>
    <td>
        <a href="" class="editarea2" id='editdata' data-toggle="modal" data-target="#editModal" data-code="{{$show->rep_code}}" data-desc="{{$show->rep_desc}}" data-num="{{$show->rep_num}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="" class="deletedata" data-toggle="modal" data-target="#deleteModal" data-code="{{$show->rep_code}}" data-desc="{{$show->rep_desc}}" data-num="{{$show->rep_num}}">
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