@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Asset Booking</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Book an Asset</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Bagian Searching -->
<div class="container-fluid mb-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<li class="nav-item has-treeview bg-black">
<a href="#" class="nav-link mb-0 p-0"> 
<p>
  <label class="col-md-2 col-form-label text-md-left" style="color:white;">{{ __('Click here to search') }}</label>
  <i class="right fas fa-angle-left"></i>
</p>
</a>
<ul class="nav nav-treeview">
<li class="nav-item">
<div class="col-12 form-group row">
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Booking Code</label>
    <div class="col-md-3 mb-2 input-group">
        <input id="s_code" type="text" class="form-control" name="s_code"
        value="" autofocus autocomplete="off"/>
    </div>
    <label for="s_asset" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset</label>
    <div class="col-md-3 mb-2 input-group">
        <select id="s_asset" class="form-control" name="s_asset">
             <option value="">--Select Data--</option>
             @foreach($dataAsset as $daa)
                <option value="{{$daa->asset_code}}">{{$daa->asset_code}} -- {{$daa->asset_desc}}</option>
             @endforeach
        </select>  
    </div>  
</div>
<div class="col-12 form-group row">
    <label for="s_status" class="col-md-2 col-sm-2 col-form-label text-md-right">Status</label>
    <div class="col-md-3 mb-2 input-group">
        <select id="s_status" name="s_status" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Status--</option>
            <option value="Open">Open</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>
            <option value="Closed">Closed</option>
          </select>
    </div>
    <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('') }}</label>
    <div class="col-md-2 mb-2 input-group">
        <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" />
    </div>
    <div class="col-md-2 col-sm-12 mb-2 input-group">
        <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
    </div>
</div>
<input type="hidden" id="tmpcode"/>
<input type="hidden" id="tmpasset"/> 
<input type="hidden" id="tmpstatus"/> 
</li>
</ul>
</li>
</ul>
</div>

<div class="col-md-12"><hr></div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="sorting" data-sorting_type="asc" >Booking Code</th>
                <th>Asset</th>
                <th>Start  </th>
                <th>End  </th>
                <th>Booked By </th>
                <th>Status </th>
                <th>Action</th>             
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('booking.table-booking')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="book_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Asset Booking Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id='formcreate' method="post" action="/createbooking">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Booking Code
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6"> 
                            <input type="text" class="form-control" name="t_code" id="t_code" value="{{ $noBook }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_asset" class="col-md-4 col-form-label text-md-right">Asset Code
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_asset" class="form-control" name="t_asset" required>
                                <option value="">--Select Data--</option>
                                @foreach($dataAsset as $da)
                                  <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                                @endforeach
                            </select>     
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_ref" class="col-md-4 col-form-label text-md-right">Start</label>
                        <div class="col-md-6">
                            <input type="datetime-local" class="form-control" name="t_start" id="t_start"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_ref" class="col-md-4 col-form-label text-md-right">End</label>
                        <div class="col-md-6">
                            <input type="datetime-local" class="form-control" name="t_end" id="t_end"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_allday" class="col-md-4 col-form-label text-md-right">All Day</label>
                        <div class="col-md-6 col align-self-center">
                            <input type="checkbox" id="t_allday" name="t_allday" value="Yes">
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button> 
                    <button type="submit" class="btn btn-success bt-action" id="btncreate">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Asset Booking Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" id='formedit' method="post" action="/editbooking">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                     <label for="te_code" class="col-md-4 col-form-label text-md-right">Booking Code
                     <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-6"> 
                        <input type="text" class="form-control" name="te_code" id="te_code"  readonly>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="te_asset" class="col-md-4 col-form-label text-md-right">Asset Code
                     <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-6">
                         <select id="te_asset" class="form-control" name="te_asset" required>
                             <option value="">--Select Data--</option>
                             @foreach($dataAsset as $da)
                               <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                             @endforeach
                         </select>     
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="te_start" class="col-md-4 col-form-label text-md-right">Start</label>
                     <div class="col-md-6">
                         <input type="datetime-local" class="form-control" name="te_start" id="te_start" />
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="t_end" class="col-md-4 col-form-label text-md-right">End</label>
                     <div class="col-md-6">
                         <input type="datetime-local" class="form-control" name="te_end" id="te_end" />
                     </div>
                 </div>
                 <div class="form-group row">
                    <label for="te_allday" class="col-md-4 col-form-label text-md-right">All Day</label>
                    <div class="col-md-6 col align-self-center">
                        <input type="checkbox" id="te_allday" name="te_allday" value="Yes">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success bt-action" id="btnedit">Save</button>
            </div>
        </form>
    </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center" id="exampleModalLabel">Delete Asset Booking</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deletebooking">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Delete Asset Booking <b><span id="td_asset"></span> -- <span id="td_desc"></span></b> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btndelete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Approve -->
<div class="modal fade" id="approveModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Asset Booking Approval</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/appbooking">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                     <label for="ta_code" class="col-md-4 col-form-label text-md-right">Booking Code
                     </label>
                     <div class="col-md-6"> 
                        <input type="text" class="form-control" name="ta_code" id="ta_code"  readonly>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_asset" class="col-md-4 col-form-label text-md-right">Asset Code
                     </label>
                     <div class="col-md-6">  
                         <input type="text" class="form-control" name="ta_asset" id="ta_asset" readonly>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_start" class="col-md-4 col-form-label text-md-right">Start</label>
                     <div class="col-md-6">
                         <input type="text" class="form-control" name="ta_start" id="ta_start" readonly/>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_end" class="col-md-4 col-form-label text-md-right">End</label>
                     <div class="col-md-6">
                         <input type="text" class="form-control" name="ta_end" id="ta_end" readonly/>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="ta_by" class="col-md-4 col-form-label text-md-right">Booked By</label>
                     <div class="col-md-6">
                         <input type="text" class="form-control" name="ta_by" id="ta_by" readonly/>
                     </div>
                 </div>
                 <div class="form-group row">
                    <label for="ta_allday" class="col-md-4 col-form-label text-md-right">All Day</label>
                    <div class="col-md-6 col align-self-center">
                        <input type="checkbox" id="ta_allday" name="ta_allday" readonly>
                    </div>
                </div>
                 <div class="form-group row">
                     <label for="ta_note" class="col-md-4 col-form-label text-md-right">Note</label>
                     <div class="col-md-6">
                        <textarea class="form-control" id="ta_note" name="ta_note"></textarea>
                     </div>
                 </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger bt-action" id="btnedit" name="ta_reject" value="Rejected">Reject</button>
                <button type="submit" class="btn btn-success bt-action" id="btnedit" name="ta_app" value="Approved">Approve</button>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
       $(document).on('click', '#editdata', function(e){
    
            $('#editModal').modal('show');
           
           var code = $(this).data('code');
           var asset = $(this).data('asset');
           var start = $(this).data('start');
           var end = $(this).data('end');
           var allday = $(this).data('allday');

           /* Date for Start */
           var s = new Date(start);           
           var smonth = s.getMonth() + 1;           
           var sday = s.getDate();
           var syear = s.getFullYear();
           var shour = s.getHours();
           var smin = s.getMinutes();

           smonth = ('0'+smonth).slice(-2);
           sday = ('0'+sday).slice(-2);
           shour = ('0'+shour).slice(-2);
           smin = ('0'+smin).slice(-2);
           
           var startdate = syear+'-'+smonth+'-'+sday+'T'+shour+':'+smin;

           /* Date for End */
           var d = new Date(end);

           var month = d.getMonth() + 1;
           var day = d.getDate();
           var year = d.getFullYear();
           var hour = d.getHours();
           var min = d.getMinutes();


           month = ('0'+month).slice(-2);
           day = ('0'+day).slice(-2);
           hour = ('0'+hour).slice(-2);
           min = ('0'+min).slice(-2);
           
           var enddate = year+'-'+month+'-'+day+'T'+hour+':'+min;

           document.getElementById('te_code').value = code;
           document.getElementById('te_asset').value = asset;
           document.getElementById('te_start').value = startdate;
           document.getElementById("te_end").min = startdate;
           document.getElementById('te_end').value = enddate;

           
           if(allday == "Yes") {
                document.getElementById("te_allday").checked = true;
            } else {
                document.getElementById("te_allday").checked = false;
            }
           
       });

       $(document).on('click', '#appdata', function(e){

            $('#approveModal').modal('show');

           var code = $(this).data('code');
           var asset = $(this).data('asset');
           var start = $(this).data('start');
           var end = $(this).data('end');
           var by = $(this).data('by');
           var desc = $(this).data('desc');
           var note = $(this).data('note');
           var allday = $(this).data('allday');

           document.getElementById('ta_code').value = code;
           document.getElementById('ta_asset').value = asset + " - " + desc;
           document.getElementById('ta_start').value = start;
           document.getElementById('ta_end').value = end;
           document.getElementById('ta_by').value = by; 
            document.getElementById('ta_note').value = note;
          
            if(allday == "Yes") {
                document.getElementById("ta_allday").checked = true;
            } else {
                document.getElementById("ta_allday").checked = false;
            }
           
       });

       $(document).on('change', '#t_code', function(e){
            var desc = $(this).data('t_desc');

            document.getElementById('t_desc').value      = desc;

       });

       $(document).on('change', '#t_start', function(e){
            var start = document.getElementById("t_start").value;
     
            document.getElementById("t_end").min = start;

       });

       $(document).on('change', '#te_start', function(e){
            var start = document.getElementById("te_start").value;
     
            document.getElementById("te_end").min = start;

       });

       $(document).on('click', '.deletedata', function(e){
           
            $('#deleteModal').modal('show');
            
            var code = $(this).data('code');
           var asset = $(this).data('asset');
           var desc = $(this).data('desc');

            document.getElementById('d_code').value = code;
           document.getElementById('td_asset').innerHTML = asset;
            document.getElementById('td_desc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, asset, status){
            $.ajax({
                url:"/booking/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&asset="+asset+"&status="+status,
                success:function(data){
                    console.log(data);
                    
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){

            var code = $('#s_code').val();
            var asset = $('#s_asset').val();
            var status = $('#s_status').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpasset').value = asset;
            document.getElementById('tmpstatus').value = status;

            fetch_data(page, sort_type, column_name, code, asset, status);
        });

       $(document).on('click', '.sorting', function(){
			var column_name = $(this).data('column_name');
			var order_type = $(this).data('sorting_type');
			var reverse_order = '';
			if(order_type == 'asc')
			{
			$(this).data('sorting_type', 'desc');
			reverse_order = 'desc';
			clear_icon();
			$('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
			}
			if(order_type == 'desc')
			{
			$(this).data('sorting_type', 'asc');
			reverse_order = 'asc';
			clear_icon();
			$('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
			}
			$('#hidden_column_name').val(column_name);
			$('#hidden_sort_type').val(reverse_order);
            var page = $('#hidden_page').val();
            var code = $('#s_code').val();
            var asset = $('#s_asset').val();
            var status = $('#s_status').val();

			fetch_data(page, sort_type, column_name, code, asset, status);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var code = $('#s_code').val();
            var asset = $('#s_asset').val();
            var status = $('#s_status').val();

            fetch_data(page, sort_type, column_name, code, asset, status);
       });

       $(document).on('click', '#btnrefresh', function() {

            var code  = ''; 
            var asset = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_asset').value  = '';
            document.getElementById('s_status').value  = '';

            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmpasset').value  = asset;
            document.getElementById('tmpstatus').value = status;

            fetch_data(page, sort_type, column_name, code, asset, status);
        });

        $("#s_asset").select2({
            width : '100%',
            theme : 'bootstrap4',
        });

        $(document).on('submit','#formcreate',function(e){
          e.preventDefault();
          // alert('masuk');
          var start = document.getElementById('t_start').value;
          var end = document.getElementById('t_end').value;
          var asset = document.getElementById('t_asset').value;
          
          $.ajax({
            type : "post",
            url : "/cekbooking",
            data:{
              _token:"{{ csrf_token() }}",
              start: start,
              end : end,
              asset : asset
            },
            success:function(data){
                
              console.log(data);

              if(data == 'error'){
                Swal.fire({
                    title: '',
                    text: "Asset has been booked, still want to book assets?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Create'
                   }).then((result) => {
                    if (result.value) {
                     document.getElementById('formcreate').submit();
                    } else {
                        $("#createModal").modal('hide');
                    }
                   })
              }
              else if(data == 'success'){
                document.getElementById('formcreate').submit();
              }
            }
          })
        });

        $(document).on('submit','#formedit',function(e){
          e.preventDefault();
          
          var start = document.getElementById('te_start').value;
          var end = document.getElementById('te_end').value;
          var asset = document.getElementById('te_asset').value;
          
          $.ajax({
            type : "post",
            url : "/cekbooking",
            data:{
              _token:"{{ csrf_token() }}",
              start: start,
              end : end,
              asset : asset
            },
            success:function(data){
                
              console.log(data);

              if(data == 'error'){
                Swal.fire({
                    title: '',
                    text: "Asset has been booked, still want to book assets?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Create'
                   }).then((result) => {
                    if (result.value) {
                     document.getElementById('formedit').submit();
                    } else {
                        $("#editModal").modal('hide');
                    }
                   })
              }
              else if(data == 'success'){
                document.getElementById('formedit').submit();
              }
            }
          })
        });
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection