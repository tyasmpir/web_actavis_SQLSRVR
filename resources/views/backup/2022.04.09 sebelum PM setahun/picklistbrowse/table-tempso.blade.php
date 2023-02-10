@forelse($show as $shows)
<tr>
	<td style="text-align:center;">{{$shows->sonbr_mstr_tmp}}</td>
	<td style="text-align:center;">{{$shows->socust_tmp}}</td>
	<td style="text-align:center;">{{$shows->duedate_tmp}}</td>
	
</tr>
@empty
<tr>
	<td colspan="5" style="color:red">
		<center>No Data Available</center>
	</td>
</tr>
@endforelse
	    