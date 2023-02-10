@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Picking Warehouse</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Picking Warehouse</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <hr>
@endsection

@section('content')
<form method='post' id='postman' action='/teststat'>
    <input type="hidden" id="sessionusernow" name="sessionusernow" value="{{Session::get('username')}}">
    <input type="hidden" id="sonbr" name="sonbr" class="form-control" value="{{$mstr->so_nbr}}">
</form>
<!-- modal picking warehouse -->
<input type="hidden" id="sessionusernow" name="sessionusernow" value="{{Session::get('username')}}">
<form class="form-horizontal" method="POST" action="/submitpicwh">
  <div class="modal-body">
    <div class="form-group row col-md-12">
        <label for="sonbr" class="col-sm-12 col-md-2">Nomor SO</label>
        <div class="col-sm-12 col-md-3">
            <input type="text" id="sonbr" name="sonbr" class="form-control" value="{{$mstr->so_nbr}}" required readonly autofocus autocomplete="off">
        </div>
        <label for="cust" class="col-sm-12 col-md-2 text-md-right">Customer</label>
        <div class="col-sm-12 col-md-3">
            <input type="text" id="cust" name="cust" class="form-control" value="{{$mstr->so_cust}}" required readonly autofocus autocomplete="off">
        </div>
    </div>
    <div class="form-group row col-md-12">
        <label for="reason" class="col-sm-12 col-md-2">Reason</label>
        <div class="col-sm-12 col-md-8">
            <input type="text" id="reason" name="reason" class="form-control" value="{{$mstr->reason}}" readonly autofocus autocomplete="off">
        </div>
    </div>
    <div class="form-group row col-md-12">
        <label for="trolley_so" class="col-sm-12 col-md-2">Trolley</label>
        <div class="col-sm-12 col-md-3">
            <select class="form-control" id="trolley_so" name="trolley_so" required autofocus autocomplete="off">
                <option value="">Pilih Trolley</option>
                @foreach($trolley as $trolley)
                    <option value="{{$trolley->trolley_id}}">{{$trolley->trolley_id}} -- {{$trolley->trolley_desc}}</option>
                @endforeach
            </select>
        </div>
    </div>
  </div>

     <div class="table-responsive form-group row">
        <div class="col-md-12">
            <table id="rfpapp" class="table edit-list no-footer mini-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">No. SO</th>
                        <th style="width: 15%;">Item</th>
                        <th style="width: 15%;">Desc</th>
                        <th style="width: 10%;">Loc. QAD</th>
                        <th style="width: 10%;">Lot QAD</th>
                        <th style="width: 10%;">Qty Order</th>
                        <th style="width: 10%;">Qty Pick</th>
                        <th style="width: 10%;">Qty Ship</th>
                        <th style="width: 10%;">UM</th>
                        <th style="width: 10%;">Loc. Available</th>
                        <th style="width: 10%;">Lot Available</th>
                        <th style="width: 10%;">Edit</th>
                    </tr>
                </thead>
                <tbody>
                   @forelse($det as $show)
                        <tr class="foottr">
                            <td class="foot2" data-label="No. SO">{{$show->sod_nbr}}</td>
                            <td class="foot2" data-label="Item">{{$show->sod_itemcode}}</td>
                            @if($show->sod_itemcode_desc == "")
                                <td class="foot2" data-label="Description">-</td>
                            @else
                                <td class="foot2" data-label="Description">{{$show->sod_itemcode_desc}}</td>
                            @endif
                            @if($show->loc == "")
                                <td class="foot2" data-label="Location QAD">-</td>
                            @else
                                <td class="foot2" data-label="Location QAD">{{$show->loc}}</td>
                            @endif
                            @if($show->lot == "")
                                <td class="foot2" data-label="Lot QAD">-</td>
                            @else
                                <td class="foot2" data-label="Lot QAD">{{$show->lot}}</td>
                            @endif

                            <td class="foot2" data-label="Qty Order">{{$show->qty_order}}</td>
                            <td class="foot2" data-label="Qty Pick">{{$show->qty_topick}}</td>
                            <td class="foot2" data-label="Qty Ship">{{$show->qty_toship}}</td>
                            <td class="foot2" data-label="UM">{{$show->um}}</td>
                            @if($show->loc_avail == "")
                                <td class="foot2" data-label="Location Available">-</td>
                            @else
                                <td class="foot2" data-label="Location Available">{{$show->loc_avail}}</td>
                            @endif
                            @if($show->lot_avail == "")
                                <td class="foot2" data-label="Lot Available">-</td>
                            @else
                                <td class="foot2" data-label="Lot Available">{{$show->loc_avail}}</td>
                            @endif
                            <td>
                                <a href="" data-toggle="modal" data-target="#editModal" data-sonbr="{{$show->sod_nbr}}" data-itemcode="{{$show->sod_itemcode}}">
                                    <i class="icon-table fa fa-edit fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                   @empty

                   @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group row col-md-12">
        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Back</button>
        <!-- <button type="submit" class="btn btn-success bt-action btn-focus" id="e_btnconf">Submit</button>
          <button type="button" class="btn bt-action" id="e_btnloading" style="display:none">
            <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
          </button> -->
    </div>
</form>

<!-- Flash Menu -->

@endsection


@section('scripts')
<script type="text/javascript">
$('#trolley_so').select2({
        width: '100%',
        theme: 'bootstrap4',
});


// window.addEventListener('beforeunload', function (e) {
//     e.returnValue = document.getElementById('postman').submit();
// });



// function fetchdata(username){

//     $.ajax({
// 		url:"/teststat?username="+username,
// 		success:function(data)
// 		{
            
//         }
//     })
// }

</script>
@endsection