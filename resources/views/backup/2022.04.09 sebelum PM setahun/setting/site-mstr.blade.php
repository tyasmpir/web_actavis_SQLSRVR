@extends('layout.newlayout')
@section('content-header')

	  	  <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Site Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Site Create</button>
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
        <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Site Code</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="s_code" type="text" class="form-control" name="s_code" value="" autofocus autocomplete="off"/>
        </div>
        <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Site Description</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="s_desc" type="text" class="form-control" name="s_desc" value="" autofocus autocomplete="off"/>
        </div>
        <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search"/> 
        </div>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
        </div>
        <input type="hidden" id="tmpcode"/>
        <input type="hidden" id="tmpdesc"/>
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
                <th width="30%">Code<span id="location_id_icon"></span></th>
                <th width="60%">Description</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-site')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="site_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Site Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createsite">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_sitecode" class="col-md-4 col-form-label text-md-right">Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_sitecode" type="text" class="form-control" name="site_code" 
                            autocomplete="off" autofocus maxlength="10" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_sitedesc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_sitedesc" type="text" class="form-control" name="site_desc" 
                            autocomplete="off" autofocus maxlength="50" required/>
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Site Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editsite">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                        <label for="te_sitecode" class="col-md-4 col-form-label text-md-right">Code</label>
                        <div class="col-md-6">
                            <input id="te_sitecode" type="text" class="form-control" name="te_sitecode"
                            autocomplete="off" autofocus readonly/>
                        </div>
                </div>
                <div class="form-group row">
                        <label for="te_sitedesc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="te_sitedesc" type="text" class="form-control" name="te_sitedesc"
                            autocomplete="off" autofocus maxlength="50" required/>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Site Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deletesite">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_sitecode" name="d_sitecode">
                    Delete Site <b><span id="td_sitecode"></span> -- <span id="td_sitedesc"></span></b> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btndelete">Delete</button>
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

           var sitecode = $(this).data('sitecode');
           var desc = $(this).data('desc');

           document.getElementById('te_sitecode').value = sitecode;
           document.getElementById('te_sitedesc').value = desc;
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var sitecode = $(this).data('sitecode');
            var desc = $(this).data('desc');

            document.getElementById('d_sitecode').value = sitecode;
            document.getElementById('td_sitecode').innerHTML = sitecode;
            document.getElementById('td_sitedesc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc){
            $.ajax({
                url:"sitemaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc,
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
			fetch_data(page, sort_type, column_name, code, desc);
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

            var code = '';
            var desc = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;
            document.getElementById('s_code').value = code;
            document.getElementById('s_desc').value = desc;

            fetch_data(page, sort_type, column_name, code, desc);
        });

        $(document).on('change','#t_sitecode',function(){

            var code = $('#t_sitecode').val();
            var desc = $('#t_sitedesc').val();

            $.ajax({
              url: "/ceksite?code=" + code + "&desc=" + desc,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Site Already Regitered!!");
                  document.getElementById('t_sitecode').value = '';
                  document.getElementById('t_sitecode').focus();
                }
                console.log(data);
              
              }
            })
       });

       $(document).on('change','#t_sitedesc',function(){

            var code = $('#t_sitecode').val();
            var desc = $('#t_sitedesc').val();

            $.ajax({
              url: "/ceksite?code=" + code + "&desc=" + desc,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Description Site Already Regitered!!");
                  document.getElementById('t_sitedesc').value = '';
                  document.getElementById('t_sitedesc').focus();
                }
                console.log(data);
              
              }
            })
       });

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