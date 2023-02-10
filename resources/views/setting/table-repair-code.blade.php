@forelse($data as $show)
    <tr>
        <td>{{$show->repm_code}}  </td>
        <td>{{$show->repm_desc}} </td>
        <td>{{$show->repm_ref}} </td>
        <td>
            <a href="javascript:void(0)" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
            data-code="{{$show->repm_code}}" data-desc="{{$show->repm_desc}}" data-ref="{{$show->repm_ref}}" >
            <i class="icon-table fa fa-edit fa-lg"></i></a>
            &ensp;            
            <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
            data-code="{{$show->repm_code}}" data-desc="{{$show->repm_desc}}">
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