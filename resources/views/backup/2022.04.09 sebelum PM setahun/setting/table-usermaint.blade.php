@forelse ($data as $show)
<tr>
  <td>{{ $show->username }}</td>
  <td>{{ $show->name }}</td>
  <td> {{ $show->email_user }} </td>
  <td>{{ $show->dept_user }} </td>
  <td>
    @if($show->username != 'admin')
    <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
    data-name="{{$show->name}}" data-username="{{$show->username}}" data-email="{{$show->email_user}}">
    <i class="icon-table fa fa-edit fa-lg"></i></a>
    &ensp;
    <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
    data-name="{{$show->name}}" data-username="{{$show->username}}"><i class="icon-table fa fa-trash fa-lg"></i></a>
    @endif
    
  </td>
</tr>
@empty
<tr>
  <td colspan="5" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>