@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Trolley Master</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Trolley Master</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
  <!-- Flash Menu -->
  

  <div class="col-md-2 col-lg-2">
        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">
            Create Trolley
        </button>
    </div>
    <div class="col-md-12"><hr></div>
    <!-- Bagian Searching -->
    <div class="col-12 form-group row justify-content-center">
        <label for="s_trolley" class="col-md-2 col-sm-2 col-form-label text-md-right">Trolley ID</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="s_trolley" type="text" class="form-control" name="s_trolley"
            value="" autofocus autocomplete="off"/>
        </div>
        <input type="hidden" id="tmptrolley"/>
        
        <div class="col-md-2 col-sm-4 offset-md-2 offset-lg-0">
          <input type="button" class="btn btn-block btn-primary" 
          id="btnsearch" value="Search"  style="float:right"/>
        </div>
    </div>
<div class="col-md-12"><hr></div>
    <div class="table-responsive col-12">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="sorting" data-sorting_type="asc" data-column_name="trolley_id" style="cursor: pointer;">Trolley ID<span id="location_id_icon"></span></th>
                    <th>Trolley Description</th>
                    <th style="width: 15%;">Action</th>  
                </tr>
            </thead>
            <tbody>
                <!-- untuk isi table -->
                @include('setting.table-trolley')
            </tbody>
        </table>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="trolley_id"/>
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Create Trolley</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="post" action="/createtrolley">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="t_trolleyid" class="col-md-4 col-form-label text-md-right">Trolley ID</label>
                            <div class="col-md-6">
                                <input id="t_trolleyid" type="text" class="form-control" name="t_trolleyid"
                                autocomplete="off" autofocus maxlength="6" required pattern="[A-Z0-9]{0,6}" title="Masukan hanya huruf Kapital A-Z dan angka 0-9. Maks.6"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_trolleydesc" class="col-md-4 col-form-label text-md-right">Trolley Desc.</label>
                            <div class="col-md-6">
                                <input id="t_trolleydesc" type="text" class="form-control" name="t_trolleydesc" autocomplete="off" autofocus maxlength="24" required/>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Edit Trolley</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/edittrolley">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                            <label for="te_trolleyid" class="col-md-4 col-form-label text-md-right">Trolley ID</label>
                            <div class="col-md-6">
                                <input id="te_trolleyid" type="text" class="form-control" name="te_trolleyid"
                                autocomplete="off" autofocus maxlength="12" readonly/>
                            </div>
                    </div>
                    <div class="form-group row">
                            <label for="te_trolleydesc" class="col-md-4 col-form-label text-md-right">Trolley Desc.</label>
                            <div class="col-md-6">
                                <input id="te_trolleydesc" type="text" class="form-control" name="te_trolleydesc"
                                autocomplete="off" autofocus maxlength="24"/>
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Delete Trolley</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form class="form-horizontal" method="post" action="/deletetrolley">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="d_trolleyid" name="d_trolleyid">
                        Anda yakin ingin menghapus Trolley <b><span id="td_trolleyid"></span> -- <span id="td_trolleydesc"></span></b> ?
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
       $(document).on('click', '#edittrolley', function(e){
           var trolleyid = $(this).data('trolleyid');
           var desc = $(this).data('desc');

           document.getElementById('te_trolleyid').value = trolleyid;
           document.getElementById('te_trolleydesc').value = desc;
       });

       $(document).on('click', '.deletetrolley', function(e){
            var trolleyid = $(this).data('trolleyid');
            var desc = $(this).data('desc');

            document.getElementById('d_trolleyid').value = trolleyid;
            document.getElementById('td_trolleyid').innerHTML = trolleyid;
            document.getElementById('td_trolleydesc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, trolleyid){
            $.ajax({
                url:"trolley/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&trolleyid="+trolleyid,
                success:function(data){
                    console.log(data);
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){
            var trolleyid = $('#s_trolley').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmptrolley').value = trolleyid;

            fetch_data(page, sort_type, column_name, trolleyid);
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
            var trolleyid = $('#s_trolley').val();
			fetch_data(page, reverse_order, column_name, trolleyid);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var trolleyid = $('#s_trolley').val();
            fetch_data(page, sort_type, column_name, trolleyid);
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