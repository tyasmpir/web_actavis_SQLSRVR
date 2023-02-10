@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark">Repair Detail</h1>
          </div><!-- /.col -->
          <div class="col-sm-3">
          <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">
    Create Repair Detail</button>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Bagian Searching -->
<div class="container-fluid mb-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<li class="nav-item has-treeview bg-green">
<a href="#" class="nav-link mb-0 p-0"> 
<p>
  <label class="col-md-2 col-form-label text-md-left" style="color:black;">{{ __('Click here to search') }}</label>
  <i class="right fas fa-angle-left"></i>
</p>
</a>
<ul class="nav nav-treeview">
<li class="nav-item">
<div class="col-12 form-group row">
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Code</label>
    <div class="col-md-4 mb-2 input-group">
        <input id="s_code" type="text" class="form-control" name="s_code" value="" autofocus autocomplete="off"/>
    </div>
    <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Description</label>
    <div class="col-md-4 mb-2 input-group">
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
                <th class="sorting" data-sorting_type="asc" data-column_name="repins_code" style="cursor: pointer;" style="width: 35%;">Code<span id="location_id_icon"></span></th>
                <th style="width: 50%;">Description</th>
                <th style="width: 15%;">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-repair-detail')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="repdet_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Create Repair Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createrepdet">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Repair Code</label>
                        <div class="col-md-6">
                            <input id="t_step" type="text" class="form-control" name="t_step"
                            autocomplete="off" autofocus maxlength="2" required pattern="[0-9]{0,3}" title="Masukan hanya angka 0-9. Maks.2"/>
                            <!-- <select id="t_code" class="form-control" name="t_code" required>
                                <option value="">--Select Data--</option>
                                @foreach($datarep as $data)
                                    <option value="{{$data->rep_code}}">{{$data->rep_code}} -- {{$data->rep_desc}}</option>
                                @endforeach
                            </select> -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_step" class="col-md-4 col-form-label text-md-right">Repair Step</label>
                        <div class="col-md-6">
                            <input id="t_step" type="text" class="form-control" name="t_step"
                            autocomplete="off" autofocus maxlength="2" required pattern="[0-9]{0,3}" title="Masukan hanya angka 0-9. Maks.2"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_ins" class="col-md-4 col-form-label text-md-right">Instruction</label>
                        <div class="col-md-6">
                            <select id="t_ins" class="form-control" name="t_ins">
                                <option value="">--Select Data--</option>
                                @foreach($datains as $data)
                                    <option value="{{$data->ins_code}}">{{$data->ins_code}} -- {{$data->ins_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_part" class="col-md-4 col-form-label text-md-right">Part</label>
                        <div class="col-md-6">
                            <select id="t_part" class="form-control" name="t_part">
                                <option value="">--Select Data--</option>
                                @foreach($datapart as $dp)
                                    <option value="{{$dp->spm_code}}">{{$dp->spm_code}} -- {{$dp->spm_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="t_qty" class="col-md-4 col-form-label text-md-right">Quantity</label>
                        <div class="col-md-6">
                            <input id="t_qty" type="text" class="form-control" name="t_qty"
                            autocomplete="off" autofocus max="9999999.99" />
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="t_std" class="col-md-4 col-form-label text-md-right">Standard</label>
                        <div class="col-md-6">
                            <input id="t_std" type="text" class="form-control" name="t_std" autocomplete="off" maxlength="30"/>
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
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Edit Repair Instruction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editrepdet">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                        <label for="te_code" class="col-md-4 col-form-label text-md-right">Repair Code</label>
                        <div class="col-md-6">
                            <input id="te_code" type="text" class="form-control" name="te_code"
                            autocomplete="off" autofocus maxlength="12" readonly/>
                        </div>
                </div>
                <div class="form-group row">
                    <label for="te_step" class="col-md-4 col-form-label text-md-right">Repair Step</label>
                    <div class="col-md-6">
                        <input id="te_step" type="text" class="form-control" name="te_step"
                        autocomplete="off" autofocus maxlength="2" required pattern="[0-9]{0,2}" title="Masukan hanya angka 0-9. Maks.2" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_ins" class="col-md-4 col-form-label text-md-right">Instruction Detail</label>
                    <div class="col-md-6">
                        <select id="te_ins" class="form-control" name="te_ins" >
                            <option value="">--Select Data--</option>
                            @foreach($datains as $data)
                                <option value="{{$data->ins_code}}">{{$data->ins_code}} -- {{$data->ins_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_part" class="col-md-4 col-form-label text-md-right">Part</label>
                    <div class="col-md-6">
                        <select id="te_part" class="form-control" name="te_part">
                            <option value="">--Select Data--</option>
                            @foreach($datapart as $dp)
                                <option value="{{$dp->spm_code}}">{{$dp->spm_code}} -- {{$dp->spm_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_qty" class="col-md-4 col-form-label text-md-right">Quantity</label>
                    <div class="col-md-6">
                        <input id="te_qty" type="text" class="form-control" name="te_qty"
                        autocomplete="off" autofocus max="9999999.99" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_std" class="col-md-4 col-form-label text-md-right">Standard</label>
                    <div class="col-md-6">
                        <input id="te_std" type="text" class="form-control" name="te_std" autocomplete="off" maxlength="30"/>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Delete Repair Instruction</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleterepdet">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Anda yakin ingin menghapus Repair Instruction <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="d_btnclose" data-dismiss="modal">Cancel</button>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Delete Detail Repair Instruction</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deletedetailrepdet">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="ddd_code" name="ddd_code">
                    <input type="hidden" id="ddd_desc" name="ddd_desc">
                    Anda yakin ingin menghapus Repair Instruction <b><span id="dd_code"></span> -- Step <span id="dd_desc"></span></b> ?
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
                    <th>Instruction Code</th>
                    <th>Instruction Desc</th>
                    <th>Part Code</th>
                    <th>Part Desc</th>
                    <th>Standard</th>
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

           var code     = $(this).data('code');
           var codeDesc = $(this).data('codeDesc');
           var step     = $(this).data('step');
           var ins      = $(this).data('ins');
           var insDesc  = $(this).data('insDesc');
           var part     = $(this).data('part');
           var std      = $(this).data('std');
           var qty      = $(this).data('qty');

            document.getElementById('te_code').value     = code;
            document.getElementById('te_step').value     = step;
            document.getElementById('te_ins').value      = ins;
            document.getElementById('te_part').value     = part;
            document.getElementById('te_std').value      = std;
            document.getElementById('te_qty').value      = qty;

            $("#te_ins").select2({
                width : '100%',
                theme : 'bootstrap4',
                ins
            });

            $("#te_part").select2({
                width : '100%',
                theme : 'bootstrap4',
                part
            });
       });

       $(document).on('click', '.deletedata', function(e){
            var code = $(this).data('code');
            var desc = $(this).data('desc');

            document.getElementById('d_code').value      = code;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

       $(document).on('click', '.deletedetail', function(e){
            $('#viewModal').modal('hide');

            var code = $(this).data('code');
            var step = $(this).data('step');
//alert('aaa');
            document.getElementById('ddd_code').value    = code;
            document.getElementById('ddd_desc').value    = step;
            document.getElementById('dd_code').innerHTML = code;
            document.getElementById('dd_desc').innerHTML = step;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc){
            $.ajax({
                url:"repdet/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc,
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
              url:"/detailrepdet",
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

        $(document).on('change','#t_step',function(){

            var code = $('#t_code').val();
            var step = $('#t_step').val();

            $.ajax({
              url: "/cekrepdet?code=" + code + "&step=" + step,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Repair Step Already Registered!!");
                  document.getElementById('t_step').value = '';
                  document.getElementById('t_step').focus();
                }
                console.log(data);
              
              }
            })
        });

        $("#t_code").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_ins").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_part").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection