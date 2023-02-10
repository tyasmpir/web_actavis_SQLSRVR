@forelse($data as $show)
<tr>
    @php($dobel = "")
    @foreach($assetdobel as $ad)
        @if($show->book_code == $ad[0])
            @php($dobel = "Yes")
        @endif
    @endforeach

    @if($dobel == "Yes")
        <td style="color:blue">{{$show->book_code}}</td>
        <td style="color:blue">{{$show->book_asset}} - {{$show->asset_desc}} </td>
        <td style="color:blue">{{date('Y-m-d  H:i', strtotime($show->book_start))}}</td>
        <td style="color:blue">{{date('Y-m-d  H:i', strtotime($show->book_end))}}</td>
        <td style="color:blue">{{$show->book_edited_by }}</td>
        <td style="color:blue">{{$show->book_status }}</td>
    @else
        <td>{{$show->book_code}}</td>
        <td>{{$show->book_asset}} - {{$show->asset_desc}} </td>
        <td>{{date('Y-m-d  H:i', strtotime($show->book_start))}}</td>
        <td>{{date('Y-m-d  H:i', strtotime($show->book_end))}}</td>
        <td>{{$show->book_edited_by }}</td>
        <td>{{$show->book_status }}</td>
    @endif
   
    <td>
        @if($show->book_status == 'Open')
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Booking Modify"  data-target="#editModal"
            data-code="{{$show->book_code}}" data-asset="{{$show->book_asset}}" 
            data-start="{{$show->book_start}}" data-end="{{$show->book_end}}"
            data-allday="{{$show->book_allday}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp; 
        @endif
        @if(Session::get('role') != 'USER')
        <a href="javascript:void(0)" class="appdata" id='appdata' data-toggle="tooltip"  title="Booking Approval" data-target="#approveModal"
            data-code="{{$show->book_code}}" data-asset="{{$show->book_asset}}" 
            data-start="{{date('Y-m-d  H:i', strtotime($show->book_start))}}" data-end="{{date('Y-m-d  H:i', strtotime($show->book_end))}}"
            data-by="{{$show->edited_by}}" data-desc="{{$show->asset_desc}}"
            data-note="{{$show->book_note}}" data-allday="{{$show->book_allday}}">
            <i class="icon-table fas fa-thumbs-up fa-lg"></i></a>
        &ensp; 
        @endif
        @if($show->book_status == 'Open')
            <a href="javascript:void(0)" class="deletedata" id='deletedata' data-toggle="tooltip"  title="Booking Delete" data-target="#deleteModal"
            data-code="{{$show->book_code}}" data-asset="{{$show->book_asset}}"
            data-desc="{{$show->asset_desc}}">
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
    {{ $data->links() }}
  </td>
</tr>