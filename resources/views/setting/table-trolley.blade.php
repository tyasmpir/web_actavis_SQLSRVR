@forelse($data as $show)
<tr>
    <td>{{$show->trolley_id}}</td>
    <td>{{$show->trolley_desc}}</td>
    <td>
        <a href="" class="editarea2" id="edittrolley"  data-toggle="modal" data-target="#editModal" data-trolleyid="{{$show->trolley_id}}" data-desc="{{$show->trolley_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>

        <a href="" class="deletetrolley" data-toggle="modal" data-target="#deleteModal" data-trolleyid="{{$show->trolley_id}}" data-desc="{{$show->trolley_desc}}">
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