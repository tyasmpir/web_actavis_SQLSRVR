@php($eng = $ds->wo_engineer1)
@if(!is_null($ds->wo_engineer2))
    @php($eng .= ','.$ds->wo_engineer2)
@endif
@if(!is_null($ds->wo_engineer3))
    @php($eng .= ','.$ds->wo_engineer3)
@endif
@if(!is_null($ds->wo_engineer4))
    @php($eng .= ','.$ds->wo_engineer4)
@endif
@if(!is_null($ds->wo_engineer5))
    @php($eng .= ','.$ds->wo_engineer5)
@endif

@php($fc = $ds->wo_failure_code1)
@php($dfc = "")
@if(!is_null($ds->wo_failure_code1) && $ds->wo_failure_code1 != "")
    @php($fcode = $datafn->where('fn_code','=',$ds->wo_failure_code1)->first())
    @php($dfc = $fc.' - '.$fcode->fn_desc."\n")
@endif
@if(!is_null($ds->wo_failure_code2) && $ds->wo_failure_code2 != "")
    @php($fcode = $datafn->where('fn_code','=',$ds->wo_failure_code2)->first())
    @php($dfc .= $ds->wo_failure_code2.' - '.$fcode->fn_desc."\n")
@endif
@if(!is_null($ds->wo_failure_code3) && $ds->wo_failure_code3 != "")
    @php($fcode = $datafn->where('fn_code','=',$ds->wo_failure_code3)->first())
    @php($dfc .= $ds->wo_failure_code3.' - '.$fcode->fn_desc."\n")    
@endif

<a href="javascript:void(0)" class="viewwo" data-toggle="modal"  title="View WO"  data-target="#viewModal" 
    data-wonbr="{{$ds->wo_nbr}}" data-srnbr="{{$ds->wo_sr_nbr}}" data-woengineer="{{$ds->wo_engineer1}}" 
    data-woasset="{{$ds->wo_asset}}" data-schedule="{{$ds->wo_schedule}}" data-duedate="{{$ds->wo_duedate}}"
    data-assdesc="{{$ds->asset_desc}}" data-eng="{{$eng}}" data-dfc="{{$dfc}}" data-creator="{{$ds->wo_creator}}"
    data-note="{{$ds->wo_note}}">

    @if($ds->wo_status == 'plan')
        <span class="badge badge-primary">{{$eng}} - {{$ds->asset_desc}}</span>
    @elseif($ds->wo_status == 'started')
        <span class="badge badge-warning">{{$eng}} - {{$ds->asset_desc}}</span>
    @elseif($ds->wo_status == 'open')
        <span class="badge badge-danger">{{$eng}} - {{$ds->asset_desc}}</span>
    @elseif($ds->wo_status == 'finish')
        <span class="badge badge-success">{{$eng}} - {{$ds->asset_desc}}</span>
    @elseif($ds->wo_status == 'closed')
        <span class="badge badge-secondary">{{$eng}} - {{$ds->asset_desc}}</span>
    @endif

</a>
