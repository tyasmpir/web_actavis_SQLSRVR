@forelse($data as $show)

<tr>
    <td>{{$show->ins_code}}</td>
    <td>{{$show->ins_desc}}</td>
    <td>{{$show->ins_ref}}</td>
    <td>
        @php($part = "")
        @php($dtpart = explode(",", $show->ins_part))
        @php($jml = count($dtpart))
        @for ($i = 0; $i < $jml; $i++)
            @php($descpart = $dataPart->where("spm_code","=",$dtpart[$i])->first())
            @if(!$descpart)
                @php($part .= "")
            @else
                @php($part .= $dtpart[$i]." - ".$descpart->spm_desc)
                <p style="margin:0px">{{$part}}</p>
                @php($part = '')
            @endif
        @endfor
    </td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-code="{{$show->ins_code}}" data-desc="{{$show->ins_desc}}" data-tool="{{$show->ins_tool}}" data-hour="{{$show->ins_hour}}"
        data-check="{{$show->ins_check}}" data-check_desc="{{$show->ins_check_desc}}" 
        data-check_mea="{{$show->ins_check_mea}}"
        data-part="{{$show->ins_part}}" data-ref="{{$show->ins_ref}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal"
        data-code="{{$show->ins_code}}" data-desc="{{$show->ins_desc}}">
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