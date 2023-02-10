@forelse($datauser as $show)

@php($a = $dataeng->where('dept_code','=',$show->dept_user)->count())
@if($a == 0)
    @php($descdept = "")
@else
    @php($b = $dataeng->where('dept_code','=',$show->dept_user)->first())
    @php($descdept = $b->dept_desc)
@endif

@php($a = $data->where('eng_code','=',$show->username)->count())
@if($a == 0)
    @php($app = "")
    @php($app = "")
    @php($bd = "")
    @php($jd = "")
    @php($ht = "")
    @php($skill = "")
    @php($foto = "")
@else
    @php($b = $data->where('eng_code','=',$show->username)->first())
    @php($app = $b->approver)
    @php($bd = $b->eng_birth_date)
    @php($jd = $b->eng_join_date)
    @php($ht = $b->eng_rate_hour)
    @php($skill = $b->eng_skill)
    @php($foto = $b->eng_photo)
@endif
@if($app == 1)
    @php($app = 'Yes')
@else
    @php($app = 'No')
@endif

<!-- @php($a = $datarole->where('role_code','=',$show->role_user)->count())
@if($a == 0)
    @php($acc = "")
@else
    @php($b = $datarole->where('role_code','=',$show->role_user)->first())
    @php($acc = $b->role_access)
@endif -->

<tr>
    <td>{{$show->username}}</td>
    <td>{{$show->name}}</td>
    <td>{{$descdept}} </td>
    <td>{{$show->access}} </td>
    <td>{{$show->role_user}}</td>
    <td>{{$show->active}}</td>
    <td>{{$app}}</td>
    <td>
        @if($show->username != 'admin')
            <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
            data-code="{{$show->username}}" data-desc="{{$show->name}}" data-active="{{$show->active}}" data-email="{{$show->email_user}}" data-role="{{$show->role_user}}" data-dept="{{$show->dept_user}}"
            data-birth="{{$bd}}"  data-join="{{$jd}}" data-rate="{{$ht}}" data-skill="{{$skill}}" data-photo="{{$foto}}" data-app="{{$app}}" data-acc="{{$show->access}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
            &ensp;
            <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
            data-code="{{$show->username}}" data-desc="{{$show->name}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
        @endif
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
    {{ $datauser->links() }}
  </td>
</tr>