@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Repair Group Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Repair Group Create</button>
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
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Repair Group Code</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_code" class="form-control" name="s_code">
            <option value=""></option>
            @foreach($datagroup as $sgroup)
                <option value="{{$sgroup->xxrepgroup_nbr}}">{{$sgroup->xxrepgroup_nbr}} - {{$sgroup->xxrepgroup_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Repair Code</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_desc" class="form-control" name="s_desc">
            <option value=""></option>
            @foreach($datarepair as $srep)
                <option value="{{$srep->repm_code}}">{{$srep->repm_code}} - {{$srep->repm_desc}}</option>
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
                <th width="20%">Group Code</th>
                <th width="35%">Description </th>
                <th width="35%">Repair Code</th>             
                <th width="10%">Action</th>             
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-repgroup')
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Repair Group Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createrepgroup">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Code
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                           <input id="t_code" type="text" class="form-control" name="t_code" autocomplete="off" required>                                
                        </div>
                    </div>
					<div class="form-group row">
                        <label for="t_desc" class="col-md-4 col-form-label text-md-right">Description
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                           <input id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" required>                                
                        </div>
                    </div>
                    <div class="col-md-10 offset-md-1">
                        <h5 class="mb-3" style="margin-left:5px;"><strong>Repair Detail</strong></h5>
                        <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                          <thead>
                            <tr id='full'>
                              <th width="20%">Line</th>
                              <th width="60%">Repair Code</th>
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Repair Group Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editrepgroup">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">Repair Group</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" readonly/>
                        <input type="hidden" name="h_code" id="h_code">
                        <input type="hidden" name="h_desc" id="h_desc">
                    </div>
                </div>
                
                <h5 class="mb-3" style="margin-left:5px;"><strong>Repair Detail</strong></h5>
                <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                    <thead>
                        <th width="20%">Line</th>
                        <th width="60%">Repair Code</th>
                        <th width="20%">Delete</th>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Repair Group Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleterepgroup">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    <input type="hidden" id="d_desc" name="d_desc">
                    Delete Repair Group <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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
           
           var code = $(this).data('code');
           var desc = $(this).data('desc');

           document.getElementById('te_code').value = code + ' -- ' + desc;
           document.getElementById('h_code').value = code;
           document.getElementById('h_desc').value = desc;

            $.ajax({
                url:"editdetailrepgroup?code="+code,
                success: function(data) {
                console.log(data);
                $('#ed_detailapp').html('').append(data);
              }
            })

       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');

            document.getElementById('d_code').value      = code;
            document.getElementById('d_desc').value      = desc;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc){
            $.ajax({
                url:"/repgroup/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc,
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

            fetch_data(page, sort_type, column_name, code, desc,);
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

            $("#s_desc").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });

            $("#s_code").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });
        });
        var counteri = 1;
        $("#addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";
     
          cols += '<td data-label="Line"><input type="number" name="line[]" required class="form-control" autocomplete="off" min=1 ></td>'
          cols += '<td data-label="Barang">';
          cols += '<select id="barang" class="form-control barang selectpicker" name="barang[]" data-live-search="true" required autofocus>';
          cols += '<option value = ""> -- Select Data -- </option>'
          @if($dataasset->count() == 0)
          @else
            @foreach($dataasset as $da)
              cols += '<option value="{{$da->repm_code}}"> {{$da->repm_code}} -- {{$da->repm_desc}} -- {{$da->repm_ref}} </option>';
              @endforeach
              cols += '</select>';
              cols += '<input type="hidden" name="repmdesc" value="{{$da->repm_desc}}">';
              cols += '</td>';
          @endif
          cols += '<td data-title="Action"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
          cols += '</tr>'
          newRow.append(cols);
          $("#detailapp").append(newRow);
          counteri++;

          selectRefresh();
        });

        $("table.order-list").on("click", ".ibtnDel", function(event) {
          $(this).closest("tr").remove();
          counteri -= 1
        });

        $("#ed_addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";


          cols += '<td data-label="Line"><input type="text" name="line[]" class="form-control" autocomplete="off"></td>'
          cols += '<td data-label="Barang">';
          cols += '<select id="barang" class="form-control barang selectpicker" name="barang[]" data-live-search="true" required autofocus>';
          cols += '<option value = ""> -- Select Data -- </option>'
          @if($dataasset->count() == 0)
          @else
              @foreach($dataasset as $da)
              cols += '<option value="{{$da->repm_code}}"> {{$da->repm_code}} -- {{$da->repm_desc}} -- {{$da->repm_ref}} </option>';
              @endforeach
              cols += '</select>';
              cols += '<input type="hidden" name="tick[]" id="tick" class="tick" value="0">';
              cols += '<input type="hidden" name="erepmdesc[]" id="erepmdesc" class="erepmdesc" value="{{$da->repm_desc}}">';
              cols += '</td>';
          @endif
          cols += '<td data-title="Action"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
          cols += '</tr>'
          newRow.append(cols);
          $("#ed_detailapp").append(newRow);
          counteri++;

          selectRefresh();
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

        $("#s_desc").select2({
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