@forelse($data as $show)
<tr>
    <td>{{$show->wo_status}}</td>
    <td>{{$show->jmlstatus}}</td>
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
