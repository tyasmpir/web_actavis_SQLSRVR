@forelse($data as $show)
<tr>
    <td>{{$show->truck_id}}</td>
    <td>{{$show->truck_desc}}</td>
    <td>{{$show->supir}}</td>
    <td>{{$show->platnomor}}</td>
    <td>
        <a href="" id="edittruck"  data-toggle="modal" data-target="#editModal" data-truckid="{{$show->truck_id}}" 
        data-desc="{{$show->truck_desc}}" data-supir="{{ $show->supir }}" data-plat="{{ $show->platnomor }}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>

        <a href="" class="deletetruck" data-toggle="modal" data-target="#deleteModal" data-truckid="{{$show->truck_id}}" 
        data-desc="{{$show->truck_desc}}" data-supir="{{ $show->supir }}" data-plat="{{ $show->platnomor }}">
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