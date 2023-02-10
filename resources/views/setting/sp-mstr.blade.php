@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Spare Part Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Spare Part Create</button>
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
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Spart Part Code</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_code" class="form-control" name="s_code">
            <option value=""></option>
            @foreach($datasearch as $sdata)
                <option value="{{$sdata->spm_code}}">{{$sdata->spm_code}} - {{$sdata->spm_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Spart Part Description</label>
    <div class="col-md-4 mb-2 input-group">
        <input id="s_desc" type="text" class="form-control" name="s_desc" value="" autofocus autocomplete="off"/>
    </div>
    <label for="s_type" class="col-md-2 col-sm-2 col-form-label text-md-right">Spare Part Type</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_type" class="form-control" name="s_type" >
            <option value="">--Select Data--</option>
            @foreach($datatype as $dt)
                <option value="{{$dt->spt_code}}">{{$dt->spt_code}} -- {{$dt->spt_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="s_group" class="col-md-2 col-sm-2 col-form-label text-md-right">Spart Part Group</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_group" class="form-control" name="s_group" >
            <option value="">--Select Data--</option>
            @foreach($datagroup as $dg)
                <option value="{{$dg->spg_code}}">{{$dg->spg_code}} -- {{$dg->spg_desc}}</option>
            @endforeach
        </select>
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
    <input type="hidden" id="tmptype"/>
    <input type="hidden" id="tmpgroup"/>
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
                <th width="15%">Code</th>
                <th width="30%">Description</th>
                <th width="5%">UM</th>
                <th width="20%">Type</th>
                <th width="20%">Group</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-sp-mstr')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="spm_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Spare Part Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createspm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Code
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_code" type="text" class="form-control" name="t_code"
                            autocomplete="off" autofocus maxlength="8" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_desc" class="col-md-4 col-form-label text-md-right">Description
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" autofocus maxlength="30" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_um" class="col-md-4 col-form-label text-md-right">UM</label>
                        <div class="col-md-6">
                            <select id="t_um" class="form-control" name="t_um" autocomplete="off">
                                <option value="pcs">PCS</option>
                                <option value="EA">EA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_site" class="col-md-4 col-form-label text-md-right">Site Code</label>
                        <div class="col-md-6">
                            <select id="t_site" class="form-control" name="t_site">
                                <option value="">--Select Data--</option>
                                @foreach($dataSite as $dr)
                                  <option value="{{$dr->site_code}}">{{$dr->site_code}} -- {{$dr->site_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_loc" class="col-md-4 col-form-label text-md-right">Location</label>
                        <div class="col-md-6">
                            <select id="t_loc" class="form-control" name="t_loc">
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_lot" class="col-md-4 col-form-label text-md-right">Lot</label>
                        <div class="col-md-6">
                            <input id="t_lot" type="text" class="form-control" name="t_lot"
                            autocomplete="off" autofocus/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_type" class="col-md-4 col-form-label text-md-right">Type</label>
                        <div class="col-md-6">
                            <select id="t_type" class="form-control" name="t_type" >
                                <option value="">--Select Data--</option>
                                @foreach($datatype as $data)
                                    <option value="{{$data->spt_code}}">{{$data->spt_code}} -- {{$data->spt_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_group" class="col-md-4 col-form-label text-md-right">Group</label>
                        <div class="col-md-6">
                            <select id="t_group" class="form-control" name="t_group" >
                                <option value="">--Select Data--</option>
                                @foreach($datagroup as $data)
                                    <option value="{{$data->spg_code}}">{{$data->spg_code}} -- {{$data->spg_desc}}</option>
                                @endforeach
                            </select>
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
                    <div class="form-group row">
                        <label for="t_prc_price" class="col-md-4 col-form-label text-md-right">Purchase Price</label>
                        <div class="col-md-6">
                            <input id="t_prc_price" type="number" step="0.01" placeholder="0.00" class="form-control" name="t_prc_price" autocomplete="off" autofocus max="99999999999.99"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_safety" class="col-md-4 col-form-label text-md-right">Safety Stock</label>
                        <div class="col-md-6">
                            <input id="t_safety" type="text" class="form-control" name="t_safety" autocomplete="off" autofocus maxlength="25" />
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Spare Part Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editspm">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">Code</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" autocomplete="off" autofocus readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-4 col-form-label text-md-right">Description
                    <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <input id="te_desc" type="text" class="form-control" name="te_desc" autocomplete="off" autofocus maxlength="50" required />
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="te_um" class="col-md-4 col-form-label text-md-right">UM</label>
                    <div class="col-md-6">
                        <select id="te_um" class="form-control" name="te_um" autocomplete="off">
                            <option value="PCS">PCS</option>
                            <option value="EA">EA</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_site" class="col-md-4 col-form-label text-md-right">Site</label>
                    <div class="col-md-6">
                        <select id="te_site" class="form-control" name="te_site">
                            <option value="">--Select Data--</option>
                            @foreach($dataSite as $a)
                                <option value="{{$a->site_code}}">{{$a->site_code}} -- {{$a->site_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_loc" class="col-md-4 col-form-label text-md-right">Location</label>
                    <div class="col-md-6">
                        <select id="te_loc" class="form-control te_loc" name="te_loc">
                            
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                        <label for="te_lot" class="col-md-4 col-form-label text-md-right">Lot</label>
                        <div class="col-md-6">
                            <input id="te_lot" type="text" class="form-control" name="te_lot"
                            autocomplete="off" autofocus/>
                        </div>
                    </div>
                <div class="form-group row">
                    <label for="te_type" class="col-md-4 col-form-label text-md-right">Type</label>
                    <div class="col-md-6">
                        <select id="te_type" class="form-control" name="te_type" >
                            @foreach($datatype as $data)
                                <option value="{{$data->spt_code}}">{{$data->spt_code}} -- {{$data->spt_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_group" class="col-md-4 col-form-label text-md-right">Group</label>
                    <div class="col-md-6">
                        <select id="te_group" class="form-control" name="te_group" >
                            @foreach($datagroup as $data)
                                <option value="{{$data->spg_code}}">{{$data->spg_code}} -- {{$data->spg_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_supp" class="col-md-4 col-form-label text-md-right">Supplier</label>
                    <div class="col-md-6">
                        <select id="te_supp" class="form-control" name="te_supp" >
                            @foreach($datasupp as $data)
                                <option value="{{$data->supp_code}}">{{$data->supp_code}} -- {{$data->supp_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_prc_price" class="col-md-4 col-form-label text-md-right">Purchase Price</label>
                    <div class="col-md-6">
                        <input id="te_prc_price" type="number" step="0.01" placeholder="0.00" class="form-control" name="te_prc_price" autocomplete="off" autofocus max="99999999999.99"  />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_safety" class="col-md-4 col-form-label text-md-right">Safety Stock</label>
                    <div class="col-md-6">
                        <input id="te_safety" type="text" class="form-control" name="te_safety" autocomplete="off" autofocus maxlength="25" />
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Spare Part Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deletespm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Delete Spare Part <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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

           var code         = $(this).data('code');
           var desc         = $(this).data('desc');
           var prc_price    = $(this).data('price');
           var type         = $(this).data('type');
           var group        = $(this).data('group');
           var safety       = $(this).data('safety');
           var supp         = $(this).data('supp');
           var um           = $(this).data('um');
           var site           = $(this).data('site');
           var loc           = $(this).data('loc');
           var lot           = $(this).data('lot');

           document.getElementById('te_code').value         = code;
           document.getElementById('te_desc').value         = desc;
           document.getElementById('te_prc_price').value    = prc_price;
           document.getElementById('te_type').value         = type;
           document.getElementById('te_group').value        = group;
           document.getElementById('te_safety').value       = safety;
           document.getElementById('te_supp').value         = supp;
           document.getElementById('te_um').value           = um;
           document.getElementById('te_site').value           = site;
           document.getElementById('te_loc').value           = loc;
           document.getElementById('te_lot').value           = lot;

           $("#te_type").select2({
                width : '100%',
                theme : 'bootstrap4',
                type
            });

            $("#te_group").select2({
                width : '100%',
                theme : 'bootstrap4',
                group
            });

            $("#te_supp").select2({
                width : '100%',
                theme : 'bootstrap4',
                supp
            });

            $.ajax({
                url:"/locasset2?site=" + site + "&&loc=" + loc ,
                success:function(data){
                    console.log(data);
                    $('#te_loc').html('').append(data);
                }
            }) 

            $("#te_loc").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');

            document.getElementById('d_code').value      = code;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc, type, group){

            $.ajax({
                url:"/spmmaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc+"&type="+type+"&group="+group,
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
            var type = $('#s_type').val();
            var group = $('#s_group').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;
            document.getElementById('tmptype').value = type;
            document.getElementById('tmpgroup').value = group;

            fetch_data(page, sort_type, column_name, code, desc, type, group);
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
            var type = $('#s_type').val();
            var group = $('#s_group').val();
			fetch_data(page, reverse_order, column_name, code, desc, type, group);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            var type = $('#s_type').val();
            var group = $('#s_group').val();
            fetch_data(page, sort_type, column_name, code, desc, type, group);
       });

       $(document).on('click', '#btnrefresh', function() {

            var code  = ''; 
            var desc = '';
            var type = '';
            var group = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_desc').value  = '';
            document.getElementById('s_type').value  = '';
            document.getElementById('s_group').value  = '';
            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmpdesc').value  = desc;
            document.getElementById('tmptype').value  = type;
            document.getElementById('tmpgroup').value  = group;

            fetch_data(page, sort_type, column_name, code, desc, type, group);

            $("#s_type").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });

            $("#s_group").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });

            $("#s_code").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });
        });

        $(document).on('change','#t_code',function(){

            var code = $('#t_code').val();
            var desc = $('#t_desc').val();

            $.ajax({
              url: "/cekspm?code=" + code + "&desc=" + desc,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Spare Part Already Regitered!!");
                  document.getElementById('t_code').value = '';
                  document.getElementById('t_code').focus();
                }
                console.log(data);
              
              }
            })
        });

        $("#t_type").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_group").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_supp").select2({
            width : '100%',
            theme : 'bootstrap4',
            
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

        $("#t_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
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

        $("#te_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#s_type").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#s_group").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#s_code").select2({
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