@forelse($datas as $show)

@php($description = $dataloc->where('loc_code','=',$show->inv_loc)->where('loc_site','=',$show->inv_site)->count())
@if($description == 0)
    @php($desc = "")
@else
    @php($description = $dataloc->where('loc_code','=',$show->inv_loc)->where('loc_site','=',$show->inv_site)->first())
    @php($desc = $description->loc_desc)
@endif

@php($description1 = $dataspm->where('spm_code','=',$show->inv_sp)->count())
@if($description1 == 0)
    @php($desc1 = "")
@else
    @php($description1 = $dataspm->where('spm_code','=',$show->inv_sp)->first())
    @php($desc1 = $description1->spm_desc)
@endif

<tr>
    <td>{{$show->inv_site}} - {{$show->site_desc}} </td>
    <td>{{$show->inv_loc}} - {{$desc}}</td>
    <td>{{$show->inv_sp}} - {{$desc1}}</td>
    <td style="text-align:right;">{{$show->inv_qty}}</td>
    <td>{{$show->inv_lot}}</td>
    <td>{{$show->inv_supp}}</td>
    <td>{{$show->inv_date}}</td>
    <td>
        <a href="" class="editarea2" id='editdata' data-toggle="modal" data-target="#editModal" 
        data-site="{{$show->inv_site}}" data-loc="{{$show->inv_loc}}" data-spm="{{$show->inv_sp}}" data-qty="{{$show->inv_qty}}" data-lot="{{$show->inv_lot}}" data-supp="{{$show->inv_supp}}" data-date="{{$show->inv_date}}" data-dsite="{{$show->site_desc}}" 
        data-dloc="{{$desc}}" data-dspm="{{$desc1}}">
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="" class="deletedata" data-toggle="modal" data-target="#deleteModal" 
        data-site="{{$show->inv_site}}" data-loc="{{$show->inv_loc}}" data-spm="{{$show->inv_sp}}" >
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
    {{ $datas->links() }}
  </td>
</tr>