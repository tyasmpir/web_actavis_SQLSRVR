@extends('layout.newlayout')
@section('content-header')
	  
	  	  <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Location Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Location Create</button>
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
            <input id="s_code" type="text" class="form-control" name="s_code"
            value="" autofocus autocomplete="off"/>
        </div>
        <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Site Description</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="s_desc" type="text" class="form-control" name="s_desc"
            value="" autofocus autocomplete="off"/>
        </div>
        <input type="hidden" id="tmpcode"/>
        <input type="hidden" id="tmpdesc"/>
    </div>
    <div class="col-12 form-group row">
        <label for="ss_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Location Code</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="ss_code" type="text" class="form-control" name="ss_code"
            value="" autofocus autocomplete="off"/>
        </div>
        <label for="ss_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Location Description</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="ss_desc" type="text" class="form-control" name="ss_desc"
            value="" autofocus autocomplete="off"/>
        </div>
        <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search"/> 
        </div>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
        </div>
        <input type="hidden" id="tmpscode"/>
        <input type="hidden" id="tmpsdesc"/>
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
                    <th>Code</th>
                    <th>Description</th>
                    <th>Site</th>
                    <th style="width: 15%;">Action</th>  
                </tr>
            </thead>
            <tbody>
                <!-- untuk isi table -->
                @include('setting.table-area')
            </tbody>
        </table>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="loc_code"/>
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Location Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="post" action="/createarea">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="t_site" class="col-md-4 col-form-label text-md-right">Site <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                            <div class="col-md-6">
                                <select id="t_site" class="form-control" name="t_site" required>
                                    <option value="">--Select Data--</option>
                                    @foreach($dataSite as $s)
                                        <option value="{{$s->site_code}}">{{$s->site_code}} -- {{$s->site_desc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_locationid" class="col-md-4 col-form-label text-md-right">Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                            <div class="col-md-6">
                                <input id="t_locationid" type="text" class="form-control" name="t_locationid"
                                autocomplete="off" autofocus maxlength="10" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_locationdesc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                            <div class="col-md-6">
                                <input id="t_locationdesc" type="text" class="form-control" name="t_locationdesc" 
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

    @php($descSite = '')
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center" id="exampleModalLabel">Location Modify</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/editarea">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="te_dsite" class="col-md-4 col-form-label text-md-right">Site</label>
                        <div class="col-md-6">     
                            <input id="te_dsite" type="text" class="form-control" name="te_dsite"
                             readonly/>
                             <input type="hidden" id="te_site" name="te_site">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_locationid" class="col-md-4 col-form-label text-md-right">Code</label>
                        <div class="col-md-6">
                            <input id="te_locationid" type="text" class="form-control" name="te_locationid" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_locationdesc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="te_locationdesc" type="text" class="form-control" name="te_locationdesc" 
                            autocomplete="off" autofocus maxlength="50"/>
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Location Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form class="form-horizontal" method="post" action="/deletearea">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="d_locationid" name="d_locationid">
                        <input type="hidden" id="d_site" name="d_site">
                        Delete Location <b><span id="td_locationid"></span> -- <span id="td_locationdesc"></span></b> For Site <b><span id="td_site"></span></b> ?
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
       $(document).on('click', '#editarea', function(e){
           $('#editModal').modal('show');

           var locationid   = $(this).data('locationid');
           var desc         = $(this).data('desc');
           var site         = $(this).data('site');
           var dsite        = $(this).data('dsite');

           document.getElementById('te_locationid').value   = locationid;
           document.getElementById('te_locationdesc').value = desc;
           document.getElementById('te_site').value         = site
           document.getElementById('te_dsite').value        = site + " - " + dsite;
       });

       $(document).on('click', '.deletearea', function(e){
            $('#deleteModal').modal('show');

            var locationid   = $(this).data('locationid');
            var desc         = $(this).data('desc');
            var site         = $(this).data('site');

            document.getElementById('d_locationid').value        = locationid;
            document.getElementById('d_site').value              = site;
            document.getElementById('td_locationid').innerHTML   = locationid;
            document.getElementById('td_locationdesc').innerHTML = desc;
            document.getElementById('td_site').innerHTML         = site;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc, scode, sdesc){
            $.ajax({
                url:"areamaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc+"&scode="+scode+"&sdesc="+sdesc,
                success:function(data)
                {
                    console.log(data);
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){
            var code    = $('#s_code').val();
            var desc    = $('#s_desc').val();
            var scode   = $('#ss_code').val();
            var sdesc   = $('#ss_desc').val();

            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value    = code;
            document.getElementById('tmpdesc').value    = desc;
            document.getElementById('tmpscode').value   = scode;
            document.getElementById('tmpscode').value   = sdesc;

            fetch_data(page, sort_type, column_name, code, desc, scode, sdesc);
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
            var code    = $('#s_code').val();
            var desc    = $('#s_desc').val();
            var scode   = $('#ss_code').val();
            var sdesc   = $('#ss_desc').val();
			fetch_data(page, sort_type, column_name, code, desc, scode, sdesc);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var code    = $('#s_code').val();
            var desc    = $('#s_desc').val();
            var scode   = $('#ss_code').val();
            var sdesc   = $('#ss_desc').val();
            fetch_data(page, sort_type, column_name, code, desc, scode, sdesc);
       });

       $(document).on('click', '#btnrefresh', function() {

            var code    = '';
            var desc    = '';
            var scode   = '';
            var sdesc   = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value    = code;
            document.getElementById('tmpdesc').value    = desc;
            document.getElementById('tmpscode').value   = scode;
            document.getElementById('tmpscode').value   = sdesc;

            document.getElementById('s_code').value    = code;
            document.getElementById('s_desc').value    = desc;
            document.getElementById('ss_code').value   = scode;
            document.getElementById('ss_desc').value   = sdesc;
            
            fetch_data(page, sort_type, column_name, code, desc, scode, sdesc);
        });

        $(document).on('change','#t_locationid',function(){

            var site = $('#t_site').val();
            var code = $('#t_locationid').val();
            var desc = $('#t_locationdesc').val();

            $.ajax({
              url: "/cekarea?code=" + code + "&desc=" + desc + "&site=" + site,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Location Already Regitered!!");
                  document.getElementById('t_locationid').value = '';
                  document.getElementById('t_locationid').focus();
                }
                console.log(data);
              
              }
            })
        });

        $(document).on('change','#t_locationdesc',function(){

            var site = $('#t_site').val();
            var code = $('#t_locationid').val();
            var desc = $('#t_locationdesc').val();

            $.ajax({
              url: "/cekarea?code=" + code + "&desc=" + desc + "&site=" + site,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Description Location Already Regitered!!");
                  document.getElementById('t_locationdesc').value = '';
                  document.getElementById('t_locationdesc').focus();
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