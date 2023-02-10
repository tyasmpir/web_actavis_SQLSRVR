@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Repair Part Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Repair Part Create</button>
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
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Repair Part Code</label>
    <div class="col-md-4 mb-2 input-group">
        <input id="s_code" type="text" class="form-control" name="s_code"
        value="" autofocus autocomplete="off"/>
    </div>
    <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Repair Part Description</label>
    <div class="col-md-4 mb-2 input-group">
        <input id="s_desc" type="text" class="form-control" name="s_desc"
        value="" autofocus autocomplete="off"/>
    </div>
    <input type="hidden" id="tmpcode"/>
    <input type="hidden" id="tmpdesc"/>
</div>
<div class="col-12 form-group row justify-content-center">    
    <div class="col-md-1 col-sm-4 offset-md-2 offset-lg-0">
        <input type="button" class="btn btn-block btn-primary" 
        id="btnsearch" value="Search"  style="float:right; width: 100px !important"/> 
    </div>
    <div class="col-md-1 col-sm-4 offset-md-2 offset-lg-0">
        <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
    </div>
</div>
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
                <th class="sorting" data-sorting_type="asc" data-column_name="reppart_code" style="cursor: pointer;" style="width: 35%;">Repair Part Code<span id="location_id_icon"></span></th>
                <th style="width: 50%;">Repair Part Description</th>
                <th style="width: 15%;">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-repair-part')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="reppart_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Repair Part Code Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createreppart">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Repair Part Code
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_code" type="text" class="form-control" name="t_code" autocomplete="off" autofocus maxlength="10" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_desc" class="col-md-4 col-form-label text-md-right">Repair Part Description
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" autofocus maxlength="50" required/>
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btncreate">Create</button> 
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Edit Repair Part</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editreppart">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">Repair Part Code</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" autocomplete="off" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-4 col-form-label text-md-right">Repair Part Description
                    <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <input id="te_desc" type="text" class="form-control" name="te_desc" autocomplete="off" autofocus maxlength="50" required/>
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Delete Repair Part</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form class="form-horizontal" method="post" action="/deletereppart">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="d_code" name="d_code">
                        Anda yakin ingin menghapus Repair Part <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success bt-action" id="btndelete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Detail-->
    <div class="modal fade" id="deletedetailmodal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Delete Detail Repair Part</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form class="form-horizontal" method="post" action="/deletedetailreppart">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="dd_code" name="dd_code">
                        <input type="hidden" id="dd_step" name="dd_step">
                        Anda yakin ingin menghapus Repair Part <b><span id="dd_code"></span> -- <span id="dd_step"></span></b> ?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-info bt-action" id="d_btnclose" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success bt-action" id="btndelete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!--Modal View-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
<div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-body">
        <h4 class="mb-3" style="margin-left:5px;"><strong>Detail Repair Instruction<div id='v_code'></div></strong></h4>
        <table id='suppTable' class='table table-bordered dataTable no-footer order-list mini-table'>
            <thead class="table-primary">
                <tr id='full'>
                    <th>Step</th>
                    <th>Spare Part Code</th>
                    <th>Spare Part Desc</th>
                    <th>Quantity</th>
                    <th>Action</th>  
                </tr>
            </thead>
            <tbody id='e_detailapp'>
            </tbody>
        </table>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>  
</div>
@endsection

@section('scripts')
    <script>
       $(document).on('click', '#editdata', function(e){
           $('#viewModal').modal('hide');
           var code = $(this).data('code');
           var desc = $(this).data('desc');

           document.getElementById('te_code').value = code;
           document.getElementById('te_desc').value = desc;
       });

       $(document).on('click', '.deletedata', function(e){
            $('#viewModal').modal('hide');
            var code = $(this).data('code');
            var desc = $(this).data('desc');

            document.getElementById('d_code').value          = code;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

       $(document).on('click', '.deletedetail', function(e){
            $('#viewModal').modal('hide');

            var code = $(this).data('code');
            var step = $(this).data('step');

            document.getElementById('dd_code').value     = code;
            document.getElementById('dd_step').value     = step;
            document.getElementById('dd_code').innerHTML = code;
            document.getElementById('dd_step').innerHTML = step;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc){
            $.ajax({
                url:"reppart/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc,
                success:function(data){
                    console.log(data);

                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){

            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;

            fetch_data(page, sort_type, column_name, code, desc);
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
            var desc = $('#s_desc').val();

			fetch_data(page, reverse_order, column_name, code, desc);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var code = $('#s_code').val();
            var desc = $('#s_desc').val();

            fetch_data(page, sort_type, column_name, code, desc);
       });

       $(document).on('click', '#btnrefresh', function() {

            var code  = ''; 
            var desc = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_desc').value  = '';
            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmpdesc').value  = desc;

            fetch_data(page, sort_type, column_name, code, desc);
        });

       $(document).on('click', '.viewdata', function() {
          var code      = $(this).data('code');
          var desc      = $(this).data('desc');

          document.getElementById('v_code').innerHTML  = code + ' - ' + desc;

          $.ajax({
              url:"/detailreppart",
              data:{
                code : code,
              },
              success:function(data){
                  console.log(data);
                  $('#e_detailapp').html('');
                  $('#e_detailapp').html(data);
              }
          })
        });

        // $(document).on('change','#t_step',function(){

        //     var code = $('#t_code').val();
        //     var step = $('#t_step').val();

        //     $.ajax({
        //       url: "/cekreppart?code=" + code + "&step=" + step,
        //       success: function(data) {
                
        //         if (data == "ada") {
        //           alert("Repair Step Already Registered!!");
        //           document.getElementById('t_step').value = '';
        //           document.getElementById('t_step').focus();
        //         }
        //         console.log(data);
              
        //       }
        //     })
        // });
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection