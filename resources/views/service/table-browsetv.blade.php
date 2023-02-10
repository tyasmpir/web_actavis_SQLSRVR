@forelse($datas as $shows)
<tr>
	<td style="text-align:center; border-bottom: 2px solid; vertical-align: middle; height: 25%;"><h2>{{$shows->sonbr}}</h2></td>
	<td style="text-align:center; border-bottom: 2px solid; vertical-align: middle; height: 25%;"><h2>{{$shows->cust}}</h2></td>
	<td style="text-align:center; border-bottom: 2px solid; vertical-align: middle; height: 25%;"><h2>{{$shows->totalline}}</h2></td>
    
    @if($shows->status == 1)
    <td style="text-align: center; border-bottom: 2px solid; vertical-align: middle; height: 25%;"><h2>Open</h2></td>
    @else
    <td style="text-align: center; border-bottom: 2px solid; vertical-align: middle; height: 25%;"><h2 style="color: red;">Re-Open</h2></td>
    @endif


    @if($shows->picwh == "")
    <td style="text-align: center; border-bottom: 2px solid; vertical-align: middle; height: 25%;"><h2>-</h2></td>
    @else
    <td style="text-align: center; border-bottom: 2px solid; vertical-align: middle; height: 25%;"><h2>{{$shows->picwh}}</h2></td>
    @endif
</tr>
@empty
<tr>
	<td colspan="12" style="color:red; border-left: 2px solid; vertical-align: middle; height: 25%;">
		<center><h2>No Data Available</h2></center>
	</td>
</tr>
@endforelse
<tr>
  <td style="display: none;">
    {{ $datas->links() }}
  </td>
</tr>
	    