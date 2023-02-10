@forelse($data as $show)
    <tr>
        <td>{{$show->insg_code}}</td>
        <td>{{$show->insg_desc}}</td>
        <td>   
            <a href="" id='editdata' data-toggle="modal" data-target="#editModal" 
            data-code="{{$show->insg_code}}" data-desc="{{$show->insg_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
            &ensp;
            <a href="" class="deletedata" data-toggle="modal" data-target="#deleteModal" 
            data-code="{{$show->insg_code}}">
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