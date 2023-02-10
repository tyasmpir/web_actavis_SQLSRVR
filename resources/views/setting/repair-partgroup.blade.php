@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Rapair Part Group Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-3">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Rapair Part Group Create</button>
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
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Rapair Part Group Code</label>
    <div class="col-md-2 col-sm-4 mb-2 input-group">
        <input id="s_code" type="text" class="form-control" name="s_code" value="" autofocus autocomplete="off"/>
    </div>
    <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Rapair Part Group Desc</label>
    <div class="col-md-2 col-sm-4 mb-2 input-group">
        <input id="s_desc" type="text" class="form-control" name="s_desc" value="" autofocus autocomplete="off"/>
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
                <th width="15%" class="sorting" data-sorting_type="asc" >Spare Part Group Code</th>
                <th width="25%">Spare Part Group Description </th>
                <th width="40%">Spare Part Code</th>
                <th width="10%">Quantity</th>
                <th width="10%">Action</th>             
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @forelse($data as $show)
                @php($descspm = $dataspm->where('spm_code','=',$show->reppg_part)->first())
                <tr>
                    <td>{{$show->reppg_code}}</td>
                    <td>{{$show->reppg_desc}}</td>
                    <td>{{$show->reppg_part}} - {{$descspm->spm_desc}}</td>
                    <td>{{$show->reppg_qty}}</td>
                    <td>   
                        <a href="" id='editdata' data-toggle="modal" data-target="#editModal" 
                        data-code="{{$show->reppg_code}}" data-desc="{{$show->reppg_desc}}" data-part="{{$show->reppg_part}}" 
                        data-qty="{{$show->reppg_qty}}">
                        <i class="icon-table fa fa-edit fa-lg"></i></a>
                        &ensp;
                        <a href="" class="deletedata" data-toggle="modal" data-target="#deleteModal" 
                        data-code="{{$show->reppg_code}}" data-part="{{$show->reppg_part}}">
                        <i class="icon-table fa fa-trash fa-lg"></i></a>
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
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="aspar_par"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Spare Part Group Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createreppg">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Spare Part Group Code</label>
                        <div class="col-md-6">
                           <input id="t_code" type="text" class="form-control" name="t_code" autocomplete="off" required>
                        </div>
                    </div>
					<div class="form-group row">
                        <label for="t_desc" class="col-md-4 col-form-label text-md-right">Spare Part Group Description</label>
                        <div class="col-md-6">
                           <input id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" required> 
                        </div>
                    </div>
                    <div class="col-md-10 offset-md-1">
                        <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                          <thead>
                            <tr id='full'>
                              <th width="60%">Spare Part Code</th>
                              <th width="20%">Quantity</th>
                              <th width="20%">Delete</th>
                            </tr>
                          </thead>
                          <tbody id='detailapp'>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="3">
                                <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow" value="Add Item" style="background-color:#1234A5; color:white; font-size:16px" />
                              </td>
                            </tr>
                          </tfoot>
                        </table>
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Spare Part Group Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editreppg">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">Spare Part Group</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" autocomplete="off" autofocus maxlength="12" readonly/>
                        <input type="hidden" name="h_code" id="h_code">
                        <input type="hidden" name="h_desc" id="h_desc">
                    </div>
                </div>
                
                <h4 class="mb-3" style="margin-left:5px;"><strong>Detail</strong></h4>
                <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                    <thead>
                        <th width="80%">Spare Part Code</th>
                        <th width="10%">Quntity</th>
                        <th width="10%">Delete</th>
                    </thead>
                    <tbody id='ed_detailapp'></tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3">
                          <input type="button" class="btn btn-lg btn-block btn-focus" id="ed_addrow" value="Add Item" style="background-color:#1234A5; color:white; font-size:16px" />
                        </td>
                      </tr>
                    </tfoot>
                </table>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Delete Line</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deletereppg">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    <input type="hidden" id="d_part" name="d_part">
                    Are you sure want to delete Rapair Part Group <b><span id="td_code"></span></b> Part <b><span id="td_part"></span></b> ?
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
    
           var code = $(this).data('code');
           var desc = $(this).data('desc');
           var part = $(this).data('part');

           document.getElementById('te_code').value     = code + ' -- ' + desc;
           document.getElementById('h_code').value      = code;
           document.getElementById('h_desc').value      = part;

            $.ajax({
                url:"editreppgroup?code="+code+"&part="+part,
                success: function(data) {
                console.log(data);
                $('#ed_detailapp').html('').append(data);
              }
            })

       });

       $(document).on('click', '.deletedata', function(e){
            var code = $(this).data('code');
            var part = $(this).data('part');

            document.getElementById('d_code').value      = code;
            document.getElementById('d_part').value      = part;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_part').innerHTML = part;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, code, part){
            $.ajax({
                url:"/reppartgroup/pagination?page="+page+"&code="+code+"&part="+part,
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
            var code1 = $('#s_code1').val();
            var desc1 = $('#s_desc1').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;
            document.getElementById('tmpcode1').value = code1;
            document.getElementById('tmpdesc1').value = desc1;

            fetch_data(page, code, desc);
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
            var code1 = $('#s_code1').val();
            var desc1 = $('#s_desc1').val();
			fetch_data(page, code, desc);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            var code1 = $('#s_code1').val();
            var desc1 = $('#s_desc1').val();
            fetch_data(page, code, desc);
       });

       $(document).on('click', '#btnrefresh', function() {

            var code  = ''; 
            var desc = '';
            var code1  = ''; 
            var desc1 = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_desc').value  = '';
            document.getElementById('s_code1').value  = '';
            document.getElementById('s_desc1').value  = '';
            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmpdesc').value  = desc;
            document.getElementById('tmpcode1').value  = code;
            document.getElementById('tmpdesc1').value  = desc;

            fetch_data(page, code, desc);
        });

        

        $("table.order-list").on("click", ".ibtnDel", function(event) {
          $(this).closest("tr").remove();
          counter -= 1
        });

        

        $(document).on('change','#cek',function(e){
            var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox


            if (checkbox.is(':checked'))
            {
                $(this).closest("tr").find('.tick').val(1);
            } else
            {
                $(this).closest("tr").find('.tick').val(0);
            }        
        });

        $("#addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";
     
          cols += '<td data-label="Barang">';
          cols += '<select id="barang" class="form-control barang selectpicker" name="barang[]" data-live-search="true" required autofocus>';
          cols += '<option value = ""> -- Select Data -- </option>'
          @foreach($dataspm as $da)
          cols += '<option value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
          @endforeach
          cols += '</select>';
          cols += '</td>';
          cols += '<td data-label="qty"><input type="text" name="qty[]" class="form-control" autocomplete="off"></td>';
          cols += '<td data-title="Action"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
          cols += '</tr>'
          newRow.append(cols);
          $("#detailapp").append(newRow);

          $(".barang").select2({
            width : '100%',
            theme : 'bootstrap4',
          });
        });

        $("#ed_addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";

          cols += '<td data-label="Barang">';
          cols += '<select id="barang" class="form-control barang selectpicker" name="barang[]" data-live-search="true" required autofocus>';
          cols += '<option value = ""> -- Select Data -- </option>'
          @foreach($dataspm as $da)
          cols += '<option value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
          @endforeach
          cols += '</select>';
          cols += '</td>';
          cols += '<td data-label="qty"><input type="text" name="qty[]" class="form-control" autocomplete="off" value="0"></td>';
          cols += '<input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>';

          cols += '<td data-title="Action"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
          cols += '</tr>'
          newRow.append(cols);
          $("#ed_detailapp").append(newRow);

          $(".barang").select2({
            width : '100%',
            theme : 'bootstrap4',
          });
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