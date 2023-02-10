@forelse($data as $show)

@php($det = '')
@php($flg = 1)
@php($datarep = $datadetail->where('xxrepgroup_nbr','=',$show->xxrepgroup_nbr))
@foreach($datarep as $dd)
    @if($flg == 1)
        @php($det = $dd->xxrepgroup_rep_code)
        @php($flg = 2)
    @else
        @php($det .= ', '.$dd->xxrepgroup_rep_code)
    @endif
@endforeach

    <tr>
        <td>{{$show->xxrepgroup_nbr}}  </td>
        <td>{{$show->xxrepgroup_desc}} </td>
        <td>{{$det}} </td>
        <td>
            <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
            data-code="{{$show->xxrepgroup_nbr}}" data-desc="{{$show->xxrepgroup_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
            &ensp;            
            <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
            data-code="{{$show->xxrepgroup_nbr}}" data-desc="{{$show->xxrepgroup_desc}}">
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