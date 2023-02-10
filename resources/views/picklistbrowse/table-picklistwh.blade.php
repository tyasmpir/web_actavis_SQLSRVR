@forelse ($datas as $show)
<tr class="foottr">
    <td class="foot2" data-label="No. SO">{{ $show->sonbr }}</td>
    <td class="foot2" data-label="Cust.">{{ $show->cust }}</td>
    <td class="foot2" data-label="Tot. Line">{{ $show->totalline }}</td>
    @if($show->status == 1)
      <td class="foot2" data-label="Status">Open</td>
    @elseif($show->status == 2)
      <td class="foot2" data-label="Status">Re-Open</td>
    @else
      <td>Picking</td>
    @endif

    @if($show->picwh == "")
      <td class="foot2" data-label="PIC WH">-</td>
    @else
      <td class="foot2" data-label="PIC WH">{{$show->picwh}}</td>
    @endif
    
    <td>
      @if($show->status == 1 or $show->status == 2)
      <form method="post" action="/pickingwarehouse">
      {{csrf_field()}}
      <input type="hidden" value="{{$show->sonbr}}" name="id">
      <button type="sumbit" class="btn btn-block btn-outline-primary" >Pick</button>
      </form>
      @else
        Picking ...
      @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="6" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse