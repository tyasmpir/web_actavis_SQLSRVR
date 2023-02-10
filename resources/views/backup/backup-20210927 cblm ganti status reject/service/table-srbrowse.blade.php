@forelse($datas as $show)
<tr>
    <td>{{$show->sr_number}}</td>
    @if($show->wo_number == "")
    <td>-</td>
    @else
    <td>{{$show->wo_number}}</td>
    @endif
    <td>{{$show->asset_desc}}</td>
    @if($show->sr_status == 1)
    <td>Open</td>
    @elseif($show->sr_status == 2)
    <td>Assigned</td>
    @elseif($show->sr_status == 3)
    <td>Started</td>
    @elseif($show->sr_status == 4)
    <td>Finish</td>
    @elseif($show->sr_status == 5)
    <td>Closed</td>
    @endif
    <td>{{$show->dept_desc}}</td>
    <td>{{$show->sr_priority}}</td>
    <td>{{$show->req_by}}</td>
    <td>{{date('d-m-Y', strtotime($show->sr_created_at))}}</td>


    
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="View Service Request" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_assetcode}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->username}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-rejectnote="{{$show->rejectnote}}"
    data-eng1="{{$show->u11}}" data-eng2="{{$show->u22}}" data-eng3="{{$show->u33}}" data-eng4="{{$show->u44}}" data-eng5="{{$show->u55}}"
    data-reqbyname="{{$show->req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->loc_desc}}" data-astypedesc="{{$show->astype_desc}}"
    data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"><i class="icon-table far fa-eye fa-lg"></i></a>
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