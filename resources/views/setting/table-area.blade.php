@forelse($data as $show)
<tr>
    <td>{{$show->loc_code}}</td>
    <td>{{$show->loc_desc}}</td>
    <td>{{$show->loc_site}} - {{$show->site_desc}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editarea' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-locationid="{{$show->loc_code}}" data-desc="{{$show->loc_desc}}" data-site="{{$show->loc_site}}" 
        data-dsite="{{$show->site_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletearea" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-locationid="{{$show->loc_code}}" data-desc="{{$show->loc_desc}}" data-site="{{$show->loc_site}}">
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