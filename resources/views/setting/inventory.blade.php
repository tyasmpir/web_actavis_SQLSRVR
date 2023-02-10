@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">          
        <div class="col-sm-4">
            <h1 class="m-0 text-dark">Inventory Data Maintenance</h1>
        </div>    
    </div><!-- /.row -->
    <div class="col-md-12">
        <hr>
    </div>
    <div class="row">                 
        <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Inventory Data Create</button>
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
    <label for="s_site" class="col-md-1 col-sm-2 col-form-label text-md-right">Site</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_site" class="form-control" name="s_site" required>
            <option value="">--Select Data--</option>
            @foreach($datasite as $data)
              <option value="{{$data->site_code}}">{{$data->site_code}} -- {{$data->site_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="s_loc" class="col-md-2 col-sm-2 col-form-label text-md-right">Location</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_loc" class="form-control" name="s_loc" required>
            <option value="">--Select Data--</option>
            @foreach($dataloc as $data)
              <option value="{{$data->loc_code}}">{{$data->loc_site}} : {{$data->loc_code}} -- {{$data->loc_desc}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-12 form-group row">    
    <label for="s_spm" class="col-md-1 col-sm-2 col-form-label text-md-right">Part</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_spm" class="form-control" name="s_spm" required>
            <option value="">--Select Data--</option>
            @foreach($dataspm as $data)
              <option value="{{$data->spm_code}}">{{$data->spm_code}} -- {{$data->spm_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('') }}</label>
    <div class="col-md-1 col-sm-4 offset-md-2 offset-lg-0">
      <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search"  style="float:right; width: 100px !important"/> 
    </div>
    <div class="col-md-1 col-sm-4 offset-md-2 offset-lg-0">
      <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
    </div>
</div>
<input type="hidden" id="tmpsite"/>
<input type="hidden" id="tmploc"/>
<input type="hidden" id="tmpspm"/>
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
                <th class="sorting" data-sorting_type="asc" data-column_name="inv_site" style="cursor: pointer;">Site<span id="location_id_icon"></span></th>
                <th>Location</th>
                <th>Spare Part</th>
                <th>Quantity</th>
                <th>Lot/Serial</th>
                <th>Supplier</th>
                <th>Expiry Date</th>
                <th>Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-inventory')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="inv_site"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
    </div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Inventory Data Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createinv">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_site" class="col-md-4 col-form-label text-md-right">Site</label>
                        <div class="col-md-6">
                            <select id="t_site" class="form-control" name="t_site" required>
                                <option value="">--Select Data--</option>
                                @foreach($datasite as $data)
                                  <option value="{{$data->site_code}}">{{$data->site_code}} -- {{$data->site_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_loc" class="col-md-4 col-form-label text-md-right">Location</label>
                        <div class="col-md-6">
                            <select id="t_loc" class="form-control" name="t_loc" required>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_spm" class="col-md-4 col-form-label text-md-right">Spare Part</label>
                        <div class="col-md-6">
                            <select id="t_spm" class="form-control" name="t_spm" required>
                                <option value="">--Select Data--</option>
                                @foreach($dataspm as $data)
                                  <option value="{{$data->spm_code}}">{{$data->spm_code}} -- {{$data->spm_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_qty" class="col-md-4 col-form-label text-md-right">Quantity</label>
                        <div class="col-md-6">
                            <input id="t_qty" type="number" placeholder="0.00" class="form-control" name="t_qty" autocomplete="off" autofocus max="999999999.99" step="0.01"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_lot" class="col-md-4 col-form-label text-md-right">Lot/Serial</label>
                        <div class="col-md-6">
                            <input id="t_lot" type="text" class="form-control" name="t_lot" autocomplete="off" autofocus maxlength="25" />
                        </div>
                    </div>                      
                    <div class="form-group row">
                        <label for="t_supp" class="col-md-4 col-form-label text-md-right">Supplier</label>
                        <div class="col-md-6">
                            <select id="t_supp" class="form-control" name="t_supp" >
                                <option value="">--Select Data--</option>
                                @foreach($datasupp as $data)
                                  <option value="{{$data->supp_code}}">{{$data->supp_code}} -- {{$data->supp_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="t_date" class="col-md-4 col-form-label text-md-right">Expiry Date</label>
                    <div class="col-md-6">
                        <input id="t_date" type="date" class="form-control" name="t_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Inventory Data Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editinv">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_site" class="col-md-4 col-form-label text-md-right">Site</label>
                    <div class="col-md-6">
                        <input type="text" id="te_dsite" name="te_dsite" readonly class="form-control" >
                        <input type="hidden" id="te_site" name="te_site" class="form-control" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_loc" class="col-md-4 col-form-label text-md-right">Location</label>
                    <div class="col-md-6">
                        <input type="text" id="te_dloc" name="te_dloc" readonly class="form-control" >
                        <input type="hidden" id="te_loc" name="te_loc" class="form-control" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_spm" class="col-md-4 col-form-label text-md-right">Spare Part</label>
                    <div class="col-md-6">
                        <input type="text" id="te_dspm" name="te_dspm" readonly class="form-control" >
                        <input type="hidden" id="te_spm" name="te_spm" class="form-control" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_qty" class="col-md-4 col-form-label text-md-right">Quantity</label>
                    <div class="col-md-6">
                        <input id="te_qty" type="number" step='any' placeholder="0.00" class="form-control" name="te_qty" autocomplete="off" autofocus max="999999999.99" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_lot" class="col-md-4 col-form-label text-md-right">Lot/Serial</label>
                    <div class="col-md-6">
                        <input id="te_lot" type="text" class="form-control" name="te_lot" autocomplete="off" autofocus maxlength="25" />
                    </div>
                </div>                      
                <div class="form-group row">
                    <label for="te_supp" class="col-md-4 col-form-label text-md-right">Supplier</label>
                    <div class="col-md-6">
                        <select id="te_supp" class="form-control" name="te_supp" >
                            <option value="">--Select Data--</option>
                            @foreach($datasupp as $data)
                              <option value="{{$data->supp_code}}">{{$data->supp_code}} -- {{$data->supp_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_date" class="col-md-4 col-form-label text-md-right">Expiry Date</label>
                    <div class="col-md-6">
                        <input id="te_date" type="date" class="form-control" name="te_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Inventory Data Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteinv">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_site" name="d_site">
                    <input type="hidden" id="d_loc" name="d_loc">
                    <input type="hidden" id="d_spm" name="d_spm">
                    Delete Inventory Data <b><span id="td_spm"></span> in Location <span id="td_loc"></span></b> ?
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
           var site   = $(this).data('site');
           var dsite   = $(this).data('dsite');
           var loc    = $(this).data('loc');
           var dloc    = $(this).data('dloc');
           var spm    = $(this).data('spm');
           var dspm    = $(this).data('dspm');
           var qty    = $(this).data('qty');
           var lot    = $(this).data('lot');
           var supp   = $(this).data('supp');
           var date   = $(this).data('date');

           document.getElementById('te_site').value  = site;
           document.getElementById('te_dsite').value  = site + " - " + dsite;
           document.getElementById('te_loc').value   = loc;
           document.getElementById('te_dloc').value  = loc + " - " + dloc;
           document.getElementById('te_spm').value   = spm;
           document.getElementById('te_dspm').value  = spm + " - " + dspm;
           document.getElementById('te_qty').value   = qty;
           document.getElementById('te_lot').value   = lot;
           document.getElementById('te_supp').value  = supp;
           document.getElementById('te_date').value  = date;
           document.getElementById('te_loc').value  = loc;

            $("#te_supp").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });
       });

       $(document).on('click', '.deletedata', function(e){
            var site = $(this).data('site');
            var loc = $(this).data('loc');
            var spm = $(this).data('spm');

            document.getElementById('d_site').value     = site;
            document.getElementById('d_loc').value      = loc;
            document.getElementById('d_spm').value      = spm;
            document.getElementById('td_spm').innerHTML = spm;
            document.getElementById('td_loc').innerHTML = loc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, site, loc, spm){
            $.ajax({
                url:"inv/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&site="+site+"&loc="+loc+"&spm="+spm,
                success:function(data){
                    console.log(data);

                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){

            var site = $('#s_site').val();
            var loc  = $('#s_loc').val();
            var spm  = $('#s_spm').val();

            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpsite').value = site;
            document.getElementById('tmploc').value  = loc;
            document.getElementById('tmpspm').value  = spm;

            fetch_data(page, sort_type, column_name, site, loc, spm);
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

            var site = $('#s_site').val();
            var loc  = $('#s_loc').val();
            var spm  = $('#s_spm').val();

			fetch_data(page, reverse_order, column_name, site, loc, spm);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();

            var site = $('#s_site').val();
            var loc  = $('#s_loc').val();
            var spm  = $('#s_spm').val();
            fetch_data(page, sort_type, column_name, site, loc, spm);
       });

       $(document).on('click', '#btnrefresh', function() {

            var site  = ''; 
            var loc = '';
            var spm = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_site').value  = '';
            document.getElementById('s_loc').value  = '';
            document.getElementById('s_spm').value  = '';
            document.getElementById('tmpsite').value  = site;
            document.getElementById('tmploc').value  = loc;
            document.getElementById('tmpspm').value  = spm;

            fetch_data(page, sort_type, column_name, site, loc, spm);

            $("#s_spm").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });

            $("#s_loc").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });
        });

        $(document).on('change', '#s_code', function() {
          var site = $('#t_site').val();

          $.ajax({
                url:"/locasset?t_site="+site,
                success:function(data){
                    console.log(data);
                    $('#t_loc').html('').append(data);
                }
            }) 
        });

        $(document).on('change', '#t_site', function() {
          var site = $('#t_site').val();

          $.ajax({
                url:"/locasset?t_site="+site,
                success:function(data){
                    console.log(data);
                    $('#t_loc').html('').append(data);
                }
            }) 
        });

        $(document).on('change', '#te_site', function() {
          var site = $('#te_site').val();

          $.ajax({
                url:"/locasset?t_site="+site,
                success:function(data){
                    console.log(data);
                    $('#te_loc').html('').append(data);
                }
            }) 
        });

        $(document).on('change','#t_spm',function(){

            var site = $('#t_site').val();
            var loc = $('#t_loc').val();
            var spm = $('#t_spm').val();

            $.ajax({
              url: "/cekinv?site=" + site + "&loc=" + loc + "&spm=" + spm,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Inventory Already Registered!!");
                  document.getElementById('t_spm').value = '';
                  document.getElementById('t_spm').focus();
                }
                console.log(data);
              
              }
            })
        });

        $("#t_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_spm").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_supp").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#s_spm").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#s_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
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