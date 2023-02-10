@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Truck Master</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Truck Master</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
  <!-- Flash Menu -->
  

  <div class="col-md-2 col-lg-2">
        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">
            Create Truck
        </button>
    </div>
    <div class="col-md-12"><hr></div>
    <!-- Bagian Searching -->
    <div class="col-12 form-group row justify-content-center">
        <label for="s_truck" class="col-md-2 col-sm-2 col-form-label text-md-right">Truck ID</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="s_truck" type="text" class="form-control" name="s_truck"
            value="" autofocus autocomplete="off"/>
        </div>
        <input type="hidden" id="tmptruck"/>
        
        <div class="col-md-2 col-sm-4 offset-md-2 offset-lg-0">
          <input type="button" class="btn btn-block btn-primary" 
          id="btnsearch" value="Search"  style="float:right"/>
        </div>
    </div>
<div class="col-md-12"><hr></div>
    <div class="table-responsive col-12">
        <table class="table table-bordered no-footer mini-table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="sorting" data-sorting_type="asc" data-column_name="truck_id" style="cursor: pointer;">Truck ID<span id="location_id_icon"></span></th>
                    <th>Truck Description</th>
                    <th>Supir</th>
                    <th>Plat Nomor</th>
                    <th style="width: 15%;">Action</th>  
                </tr>
            </thead>
            <tbody>
                <!-- untuk isi table -->
                @include('setting.table-truck')
            </tbody>
        </table>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="truck_id"/>
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Create Truck</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="post" action="/createtruckmaster">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group row col-md-12">
                            <label for="t_truckid" class="col-md-4 col-form-label text-md-right">Truck ID</label>
                            <div class="col-md-6">
                                <input id="t_truckid" type="text" class="form-control" name="t_truckid"
                                autocomplete="off" autofocus maxlength="6" required pattern="[A-Z0-9]{0,6}" title="Masukan hanya huruf Kapital A-Z dan angka 0-9. Maks.6"/>
                            </div>
                        </div>
                        <div class="form-group row col-md-12">
                            <label for="t_platnomor" class="col-md-4 col-form-label text-md-right">Plat Nomor</label>
                            <div class="col-md-6">
                                <input id="t_platnomor" type="text" class="form-control" name="t_platnomor" autocomplete="off" autofocus maxlength="24" required/>
                            </div>
                        </div>
                        <div class="form-group row col-md-12">
                            <label for="t_supir" class="col-md-4 col-form-label text-md-right">Supir</label>
                            <div class="col-md-6">
                               <select class="form-control" id="t_supir" name="t_supir" required>
                                    <option value="">--Select Data--</option>
                                    @foreach($supir as $show)
                                    <option value="{{ $show->username }}">{{$show->username}} -- {{$show->name}}</option>
                                    @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="form-group row col-md-12">
                            <label for="t_truckdesc" class="col-md-4 col-form-label text-md-right">Truck Desc.</label>
                            <div class="col-md-6">
                                <input id="t_truckdesc" type="text" class="form-control" name="t_truckdesc" autocomplete="off" autofocus maxlength="24" required/>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Edit Truck</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/edittruckmaster">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row col-md-12">
                            <label for="te_truckid" class="col-md-4 col-form-label text-md-right">Truck ID</label>
                            <div class="col-md-6">
                                <input id="te_truckid" type="text" class="form-control" name="te_truckid"
                                autocomplete="off" autofocus maxlength="12" readonly/>
                            </div>
                    </div>
                    <div class="form-group row col-md-12">
                        <label for="te_platnomor" class="col-md-4 col-form-label text-md-right">Plat Nomor</label>
                        <div class="col-md-6">
                            <input id="te_platnomor" type="text" class="form-control" name="te_platnomor" autocomplete="off" autofocus maxlength="24" required/>
                        </div>
                    </div>
                    <div class="form-group row col-md-12">
                            <label for="t_supir" class="col-md-4 col-form-label text-md-right">Supir</label>
                            <div class="col-md-6">
                               <select class="form-control" id="te_supir" name="te_supir" required>
                                    <option value="">--Select Data--</option>
                                    @foreach($supir as $show)
                                    <option value="{{ $show->username }}">{{$show->username}} -- {{$show->name}}</option>
                                    @endforeach
                               </select>
                            </div>
                    </div>
                    <div class="form-group row col-md-12">
                            <label for="te_truckdesc" class="col-md-4 col-form-label text-md-right">Truck Desc.</label>
                            <div class="col-md-6">
                                <input id="te_truckdesc" type="text" class="form-control" name="te_truckdesc"
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Delete Truck</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form class="form-horizontal" method="post" action="/deletetruckmaster">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="d_truckid" name="d_truckid">
                        Anda yakin ingin menghapus Truck <b><span id="td_truckid"></span> -- <span id="td_truckdesc"></b></span> dengan plat nomor <b><span id="td_platnomor"></span></b> dan supir atas nama <b><span id="td_supir"></span></b> ?
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
       $(document).on('click', '#edittruck', function(e){
            var truckid = $(this).data('truckid');
            var desc = $(this).data('desc');
            var supir = $(this).data('supir');
            var platnomor = $(this).data('plat');
           
           document.getElementById('te_truckid').value = truckid;
           document.getElementById('te_truckdesc').value = desc;
           document.getElementById('te_supir').value = supir;
           document.getElementById('te_platnomor').value = platnomor;

           $('#te_supir').select2({
                width: '100%',
                theme: 'bootstrap4',
                placeholder: 'Pilih Supir',
                supir,
          });


       });

        $(document).on('click', '.deletetruck', function(e){
            var truckid = $(this).data('truckid');
            var desc = $(this).data('desc');
            var supir = $(this).data('supir');
            var platnomor = $(this).data('plat');

            document.getElementById('d_truckid').value = truckid;
            document.getElementById('td_truckid').innerHTML = truckid;
            document.getElementById('td_truckdesc').innerHTML = desc;
            document.getElementById('td_platnomor').innerHTML = platnomor;
            document.getElementById('td_supir').innerHTML = supir;
        });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, truckid){
            $.ajax({
                url:"truckmaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&truckid="+truckid,
                success:function(data){
                    console.log(data);
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){
            var truckid = $('#s_truck').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmptruck').value = truckid;

            fetch_data(page, sort_type, column_name, truckid);
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
            var truckid = $('#s_truck').val();
			fetch_data(page, reverse_order, column_name, truckid);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var truckid = $('#s_truck').val();
            fetch_data(page, sort_type, column_name, truckid);
       });
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        $('#t_supir').select2({
            width: '100%',
            theme: 'bootstrap4',
            placeholder: 'Pilih Supir',
        });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection