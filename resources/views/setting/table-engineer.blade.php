@forelse($data as $show)
@php($a = $dataeng->where('dept_code','=',$show->eng_dept)->count())
@if($a == 0)
    @php($descdept = "")
@else
    @php($b = $dataeng->where('dept_code','=',$show->eng_dept)->first())
    @php($descdept = $b->dept_desc)
@endif
@if($show->approver == 1)
    @php($app = 'Yes')
@else
    @php($app = 'No')
@endif
<tr>
    <td>{{$show->eng_code}}</td>
    <td>{{$show->eng_desc}}</td>
    <td>{{$descdept}} </td>
    <td>{{$show->eng_role}}</td>
    <td>{{$app}}</td>
    <td>
        <a href="" class="editarea2" id='editdata' data-toggle="modal" data-target="#editModal" 
        data-code="{{$show->eng_code}}" data-desc="{{$show->eng_desc}}" 
        data-birth="{{$show->eng_birth_date}}" data-active="{{$show->eng_active}}" 
        data-join="{{$show->eng_join_date}}" data-rate="{{$show->eng_rate_hour}}"
        data-skill="{{$show->eng_skill}}" data-email="{{$show->eng_email}}" 
        data-photo="{{$show->eng_photo}}" data-role="{{$show->eng_role}}" 
        data-app="{{$show->approver}}" data-dept="{{$show->eng_dept}}">
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="" class="deletedata" data-toggle="modal" data-target="#deleteModal" data-code="{{$show->eng_code}}" data-desc="{{$show->eng_desc}}">
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