@forelse($datas as $data)
<tr>
    <td>{{$data->supp_code}}</td>
    <td>{{$data->supp_desc}}</td>
    <td>{{$data->supp_telepon}}</td>
</tr>
@empty
<tr>
    <td colspan="5" style="color: red"><center>No Data Available</center></td>
</tr>
@endforelse
<tr style="border-bottom: none !important;">
    <td>
        {{$datas->links()}}
    </td>
</tr>
