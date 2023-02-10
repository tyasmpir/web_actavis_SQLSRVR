@forelse($data as $show)
@php($dsite = $datasite->where('site_code','=',$show->asset_site)->first())
@php($dloc = $dataloc->where('loc_code','=',$show->asset_loc)->where('loc_site','=',$show->asset_site)->count())
@if($dloc == 0)
    @php($descloc = "")
@else
    @php($ddloc = $dataloc->where('loc_code','=',$show->asset_loc)->where('loc_site','=',$show->asset_site)->first())
    @php($descloc = $ddloc->loc_desc)
@endif
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->astype_desc}}</td>
    <td>{{$show->asgroup_desc}}</td>
    <td>{{$show->asset_measure}}</td>
    <td>{{$show->asset_site}} : {{$descloc}}  </td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->asset_code}}" data-desc="{{$show->asset_desc}}" 
        data-site="{{$show->asset_site}}" data-loc="{{$show->asset_loc}}" data-um="{{$show->asset_um}}" data-sn="{{$show->asset_sn}}"
        data-prc_date="{{$show->asset_prc_date}}" data-daya="{{$show->asset_daya}}" data-prc_price="{{$show->asset_prc_price}}" 
        data-type="{{$show->asset_type}}" data-group="{{$show->asset_group}}" data-failure="{{$show->asset_failure}}" 
        data-measure="{{$show->asset_measure}}" data-supp="{{$show->asset_supp}}" data-meter="{{$show->asset_meter}}" 
        data-cal="{{$show->asset_cal}}" data-start_mea="{{$show->asset_start_mea}}" data-note="{{$show->asset_note}}" 
        data-active="{{$show->asset_active}}"
        data-repair_type="{{$show->asset_repair_type}}" data-repair="{{$show->asset_repair}}" data-upload="{{$show->asset_upload}}"
        data-lastusage="{{$show->asset_last_usage}}" data-lastusagemtc="{{$show->asset_last_usage_mtc}}" 
        data-lastmtc="{{$show->asset_last_mtc}}" data-onuse="{{$show->asset_on_use}}" data-tolerance="{{$show->asset_tolerance}}"
        data-assetimg="{{$show->asset_image}}">
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal"  
        data-code="{{$show->asset_code}}" data-desc="{{$show->asset_desc}}" 
        data-site="{{$show->asset_site}}" data-loc="{{$show->asset_loc}}">
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
  <td colspan="12" style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>