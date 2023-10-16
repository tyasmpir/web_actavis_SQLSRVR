@forelse($data as $show)
<tr>
    <td>{{$show->wo_status}}</td>
    <td>{{ $datawo->where('wo_status', $show->wo_status)->first()->jmlwo ?? 0 }}</td>
    <td>{{ $datapm->where('wo_status', $show->wo_status)->first()->jmlpm ?? 0 }}</td>
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
