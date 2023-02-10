@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
<div class="row">
  <div class="col-sm-9">
    <div class="d-flex justify-content-between">
        <h1 class="m-0 text-dark">Asset Booking Schedule</h1>
    </div>
  </div><!-- /.col -->
  <div style="text-align: right">
    Booking Status  :  
    <span class="badge badge-warning">Open</span>
    <span class="badge badge-success">Approve</span>
    <span class="badge badge-danger">Reject</span>
  </div>
</div><!-- /.row -->
<br>
<div class="row">
  <div class="col-sm-12">
    <div class="d-flex justify-content-between">
            
            <form class="form-horizontal col-md-12" method="post" action="/bookcal">
                {{ csrf_field() }}

                @if(!is_null($asset))
                    @php($p_asset = $asset)
                @else
                    @php($p_asset = "")
                @endif

                <div class="row col-md-12">
                    <div class="col-md-2">
                        <label for="t_asset" class="col-form-label text-md-right">Asset Code</label>
                    </div>
                    <div class="col-md-4">
                        <select id="t_asset" class="form-control" name="t_asset" required>
                            <option value="">--Select Data--</option>
                            @foreach($dataAsset as $da)
                              <option value="{{$da->asset_code}}" {{$p_asset === $da->asset_code ? "selected" : ""}}>{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class= "row">
                            <button type="submit" class="btn btn-primary bt-action" id="btnedit">Search</button>
                            &ensp;
                            <a href="/bookcal"  class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'><i class="fas fa-sync-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h1 class="m-0 text-dark d-md-flex justify-content-md-end">
                            <a href="/bookcal?bulan={{$bulan}}&stat=mundur&t_asset={{$p_asset}}" ><i class="fas fa-angle-left"></i></a>
                            &ensp;&ensp;{{$bulan}}&ensp;&ensp;
                            <input type='hidden' name='bulan' id='bulan' value='{{$bulan}}'>
                            <a href="/bookcal?bulan={{$bulan}}&stat=maju&t_asset={{$p_asset}}" ><i class="fas fa-angle-right"></i></a>
                        </h1>
                    </div>
                </div>
            </form>     
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')

<head>
    <title>Chart</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
</head>
<body>
<style>
    table {
        table-layout:fixed;
    }
    th {
        text-align: center;
    }
    td {
        width: 100px;
        height: 100px;
        text-align: right;
        overflow: auto;
    }
</style>
    <table class="table table-bordered">
    <thead class="table-info">
        <tr>
        <th scope="col">Monday</th>
        <th scope="col">Tuesday</th>
        <th scope="col">Wednesday</th>
        <th scope="col">Thursday</th>
        <th scope="col">Friday</th>
        <th scope="col">Saturday</th>
        <th scope="col">Sunday</th>
        </tr>
    </thead>
    <tbody>
        @php($i = 1)
        @php($stop = 0)
        @for($x = 1; $x <= 6; $x++)
        <tr>
            @if($i == 1)
                @for($z = 1; $z <= $kosong; $z++)
                    <td></td>
                @endfor
            @else 
                @php($z = 1)
            @endif
            @for($y = $z; $y <= 7; $y++)
                @if($i > $skrg)
                    <td></td>
                @else
                    @php($ds = $dataBook->where('tgl','=',$i)->count())
                    <td>
                        {{$i}}
                        <br>
                        @foreach($arraynewdate as $ar)
                            @if($i == $ar[2])
                                @if($ar[7] == 'Yes')
                                    @php($jam = 'All Day')
                                @else
                                    @php($jam = $ar[3] . ' - ' . $ar[4])
                                @endif
                                <a href="" class="viewdata" id='viewdata' data-toggle="modal" data-target="#viewModal"
                                    data-code="{{$ar[0]}}" data-asset="{{$ar[10]}}" 
                                    data-start="{{date('Y-m-d  H:i', strtotime($ar[8]))}}" data-end="{{date('Y-m-d  H:i', strtotime($ar[9]))}}"
                                    data-by="{{$ar[1]}}" data-desc="{{$ar[6]}}"
                                    data-note="{{$ar[11]}}" data-allday="{{$ar[7]}}"
                                    data-status="{{$ar[5]}}">
                                    @if($ar[5] == 'Open')
                                        <span class="badge badge-warning">{{$jam}} : {{$ar[6]}}</span>
                                    @elseif($ar[5] == 'Approved')
                                        <span class="badge badge-success">{{$jam}} : {{$ar[6]}}</span>
                                    @elseif($ar[5] == 'Rejected')
                                        <span class="badge badge-danger">{{$jam}} : {{$ar[6]}}</span>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </td>
                @endif
                @if($i == $skrg)
                    @php($stop = 1)
                    @break
                @else
                    @php($i += 1)
                @endif
            @endfor
            </tr>
            @if($stop == 1)
                @break
            @endif
        @endfor
    </tbody>
    </table>
</body>


<!-- Modal View -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Asset Booking View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/appbooking">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                     <label for="ta_code" class="col-md-3 col-form-label text-md-left">Booking Code
                     </label>
                     <div class="col-md-6"> 
                        <input type="text" class="form-control" name="ta_code" id="ta_code"  readonly>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_asset" class="col-md-3 col-form-label text-md-left">Asset
                     </label>
                     <div class="col-md-6">  
                         <input type="text" class="form-control" name="ta_asset" id="ta_asset" readonly>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_start" class="col-md-3 col-form-label text-md-left">Start</label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" name="ta_start" id="ta_start" readonly/>
                     </div>
                 
                     <label for="ta_end" class="col-md-1 col-form-label text-md-right">End</label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" name="ta_end" id="ta_end" readonly/>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_by" class="col-md-3 col-form-label text-md-left">Booked By</label>
                     <div class="col-md-6">
                         <input type="text" class="form-control" name="ta_by" id="ta_by" readonly/>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_status" class="col-md-3 col-form-label text-md-left">Status</label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" name="ta_status" id="ta_status" readonly/>
                     </div>
                    <label for="ta_allday" class="col-md-1 col-form-label text-md-right">All Day</label>
                    <div class="col-md-3 col align-self-center">
                        <input type="checkbox" id="ta_allday" name="ta_allday" disabled readonly/>
                    </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_note" class="col-md-3 col-form-label text-md-left">Note</label>
                     <div class="col-md-6">
                        <textarea class="form-control" id="ta_note" name="ta_note" readonly=""></textarea>
                     </div>
                 </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection('content')

@section('scripts')
    <script>

       $(document).on('click', '#viewdata', function(e){

           var code = $(this).data('code');
           var asset = $(this).data('asset');
           var start = $(this).data('start');
           var end = $(this).data('end');
           var by = $(this).data('by');
           var desc = $(this).data('desc');
           var note = $(this).data('note');
           var allday = $(this).data('allday');
           var status = $(this).data('status');

           document.getElementById('ta_code').value = code;
           document.getElementById('ta_asset').value = asset + " - " + desc;
           document.getElementById('ta_start').value = start;
           document.getElementById('ta_end').value = end;
           document.getElementById('ta_by').value = by;
           document.getElementById('ta_note').value = note;
           document.getElementById('ta_status').value = status;
          
            if(allday == "Yes") {
                document.getElementById("ta_allday").checked = true;
            } else {
                document.getElementById("ta_allday").checked = false;
            }
           
       });

       $("#t_asset").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection