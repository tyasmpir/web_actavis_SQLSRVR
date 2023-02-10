@forelse($datas as $show)
<tr>
    <td>{{$show->sr_number}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->name}}</td>
    <td>{{$show->sr_priority}}</td>
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="approval" type="button" data-toggle="tooltip" title="Service Request Approval" data-target="#viewModal" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_assetcode}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->username}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->req_by}}" 
    data-assetloc="{{$show->loc_desc}}" data-astypedesc="{{$show->astype_desc}}"
    data-wotypedescx="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}">
    <i class="icon-table fas fa-thumbs-up fa-lg">
    </i></a>
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
  <td style="border: none !important;" colspan="5">
    {{ $datas->links() }}
  </td>
</tr>