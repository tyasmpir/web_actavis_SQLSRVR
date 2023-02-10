@forelse($data as $show)

@php($description = $datatype->where('spt_code','=',$show->spm_type)->count())
@if($description == 0)
    @php($desc = "")
@else
    @php($description = $datatype->where('spt_code','=',$show->spm_type)->first())
    @php($desc = $description->spt_desc)
@endif

@php($description1 = $datagroup->where('spg_code','=',$show->spm_group)->count())
@if($description1 == 0)
    @php($desc1 = "")
@else
    @php($description1 = $datagroup->where('spg_code','=',$show->spm_group)->first())
    @php($desc1 = $description1->spg_desc)
@endif

<tr>
    <td>{{$show->spm_code}}</td>
    <td>{{$show->spm_desc}}</td>
    <td>{{$show->spm_um}}</td>
    <td>{{$show->spm_type}} -- {{$desc}} </td>
    <td>{{$show->spm_group}} -- {{$desc1}} </td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->spm_code}}" data-desc="{{$show->spm_desc}}" data-type="{{$show->spm_type}}" 
        data-group="{{$show->spm_group}}" data-price="{{$show->spm_price}}" data-site="{{$show->spm_site}}" 
        data-loc="{{$show->spm_loc}}" data-supp="{{$show->spm_supp}}" data-safety="{{$show->spm_safety}}" 
        data-um="{{$show->spm_um}}" data-dtype="{{$desc}}" data-dgroup="{{$desc1}}" 
        data-lot="{{$show->spm_lot}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal"
        data-code="{{$show->spm_code}}" data-desc="{{$show->spm_desc}}" >
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