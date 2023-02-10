@forelse($data as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->asset_code}}</td>
    <td style="text-align: center">
        <a href="" class="viewdata" id='viewdata' data-toggle="modal" data-target="#viewModal" 
        data-code="{{$show->asset_code}}">
            <i class="fas fa-eye"></i>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
