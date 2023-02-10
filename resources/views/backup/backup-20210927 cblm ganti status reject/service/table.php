@extends('layout.newlayout')
@section('content-header')

      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Warehouse Maintenance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Data Warehouse Maintenance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
  <!-- Flash Menu -->
  
  <div class="panel-body">
   <hr>
      <div class="form-group row">
        <label for="s_sonbr" class="col-md-2 ml-4 control-label my-auto">SO Number</label>
        <div class="col-md-3 col-sm-12">
            <input id="s_sonbr" type="text" class="form-control" name="s_sonbr" autocomplete="off" autofocus required>
        </div>
        <label for="s_cust" class="col-md-2 ml-4 control-label my-auto">Customer Code</label>
        <div class="col-md-3">
            <input id="s_cust" type="text" class="form-control" name="s_cust" autocomplete="off" autofocus required>
        </div>
      </div>
      <div class="form-group row">
        <label for="duedatefrom" class="col-md-2 ml-4 control-label my-auto">Due Date From</label>
        <div class="col-md-3 col-sm-12">
            <input id="duedatefrom" type="text" class="form-control" name="duedatefrom" placeholder="yy-mm-dd" min="{{Carbon\Carbon::now()->format('Y-m-d')}}" autocomplete="off" autofocus required>
        </div>
        <label for="duedateto" class="col-md-2 ml-4 control-label my-auto">Due Date To</label>
        <div class="col-md-3 col-sm-12">
            <input id="duedateto" type="text" class="form-control" name="duedateto" placeholder="yy-mm-dd" min="{{Carbon\Carbon::now()->format('Y-m-d')}}" autocomplete="off" autofocus required>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 ml-4"></label>
        <div class="col-md-3">
          <input type="button" class="btn btn-block btn-primary" id="btnsearch" name="btnsearch" value="Search">
        </div>
      </div>

      <input type="hidden" id="tmpsonbr" name="tmpsonbr">
      <input type="hidden" id="tmpcust" name="tmpcust">
      <input type="hidden" id="tmpduedatefrom" name="tmpduedatefrom">
      <input type="hidden" id="tmpduedateto" name="tmpduedateto">

    <!-- table menu -->
    <div class="table-responsive tag-container" style="overflow-x: auto; display: block;white-space: nowrap;">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th class="text-center" style="width:10%;" data-sorting_type="asc" data-column_name="so_nbr" style="cursor: pointer;">Nomor SO</th>
            <th class="text-center" style="width:10%;">Customer</th>
            <th class="text-center" style="width:10%;">Due Date</th>
            <th class="text-center" style="width:10%;">Action</th>
            </tr>
        </thead>
        <tbody id="datawh">
            @include('picklistbrowse.table-datawh')
        </tbody>
        </table>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="so_nbr"/>
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
    </div>
  </div>

  <!-- MODAL EDIT -->
  <div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel">Edit QTY</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/submiteditwh" id='edited' onkeydown="return event.key != 'Enter';">
            {{ csrf_field() }}
            <div class="form-group row col-md-12">
              <label for="sonbr" class="col-md-2 col-form-label text-md-right">SO Number</label>
              <div class="col-md-3 {{ $errors->has('uname') ? 'has-error' : '' }}">
                <input id="sonbr" type="text" class="form-control" name="sonbr" autocomplete="off" maxlength="24" autofocus readonly>
              </div>
              <label for="ed_custcode" class="col-md-2 col-form-label text-md-right">Customer</label>
              <div class="col-md-3 {{ $errors->has('uname') ? 'has-error' : '' }}">
                <input id="ed_custcode" type="text" class="form-control" name="ed_custcode" autocomplete="off" maxlength="24" autofocus readonly>
                <!-- <input type="hidden" id='eds_custcode' name='eds_custcode'> -->
              </div>
            </div>
            <h4 class="mt-3 mb-3" style="margin-left:5px;"><strong>Detail</strong></h4>

            <table id='suppTable' class='table table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
              <thead>
                <tr id='full'>
                  <th style="width:10%">Line</th>
                  <th style="width:15%">Item</th>
                  <th style="width:20%">Description</th>
                  <th style="width:15%">Qty Order</th>
                  <th style="width:15%">UM</th>
                  <th style="width:15%">Qty Pick</th>
                </tr>
              </thead>
              <tbody id='ed_detailwh'>
              </tbody>
            </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Back</button>
          <button type="submit" class="btn btn-success bt-action btn-focus" id="e_btnconf">Submit</button>
          <button type="button" class="btn bt-action" id="e_btnloading" style="display:none">
            <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
          </button>
        </div>
        </form>
      </div>
    </div>
  </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Delete Data WH</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form class="form-horizontal" method="post" action="/deletedatawh">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="d_sonbr" name="d_sonbr">
                        Anda yakin ingin menghapus data SO <b><span id="td_sonbr"></span> dengan customer code <b><span id="td_cust"></span></b> ?
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
        $('#duedatefrom').datepicker({
            dateFormat : 'yy-mm-dd'
        });
        $('#duedateto').datepicker({
            dateFormat : 'yy-mm-dd'
        });

        $(document).on('click', '#editdatawh', function(e){
          // alert('hellooo');
          var sonumber = $(this).data('sonbr');
          var customer = $(this).data('cust');

          document.getElementById('sonbr').value = sonumber;
          document.getElementById('ed_custcode').value = customer;


          $.ajax({
              url : "/vieweditdatawh",
              data : {
                  sonumber : sonumber,
                  customer : customer,
              },
              success: function(data){
                  console.log(data);
                  $('#ed_detailwh').html('');
                  $('#ed_detailwh').html(data);
              }
          })
        });


        $(document).on('click', '#deletedatawh', function(e){
            var sonbr = $(this).data('sonbr');
            var cust = $(this).data('cust');

            document.getElementById('d_sonbr').value = sonbr;
            document.getElementById('td_sonbr').innerHTML = sonbr;
            document.getElementById('td_cust').innerHTML = cust;
        });

        function fetch_data(page, sonbr, cust, duedatefrom, duedateto){
            $.ajax({
                url:"datawhmaint/pagination?page="+page+"&sonbr="+sonbr+"&cust="+cust+"&duedatefrom="+duedatefrom+"&duedateto="+duedateto,
                success:function(data){
                    console.log(data);
                    $('#datawh').html('');
                    $('#datawh').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){
            var sonbr = $('#s_sonbr').val();
            var cust = $('#s_cust').val();
            var duedatefrom = $('#duedatefrom').val();
            var duedateto = $('#duedateto').val();
			// var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpsonbr').value = sonbr;
            document.getElementById('tmpcust').value = cust;
            document.getElementById('tmpduedatefrom').value = duedatefrom;
            document.getElementById('tmpduedateto').value = duedateto;

            fetch_data(page, sonbr, cust, duedatefrom, duedateto);
        });


    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        
    </script>
@endsection