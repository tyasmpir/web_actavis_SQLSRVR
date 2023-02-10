@extends('layout.newlayout')
@section('content-header')

      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Ship Instruction</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Ship Instruction</li>
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
        <label for="sonumber" class="col-md-2 ml-4 control-label my-auto">SO Number</label>
        <div class="col-md-3 col-sm-12">
            <input id="sonumber" type="text" class="form-control" name="sonumber" autocomplete="off" autofocus required>
        </div>
        <label class="col-md-2 ml-4"></label>
        <div class="col-md-3">
          <input type="button" class="btn btn-block btn-primary" id="btnsearch" name="btnsearch" value="Search">
        </div>
      </div>

      <form action="/sendtowh" method="POST">
        {{csrf_field()}}

        <div class="table-responsive tag-container" style="overflow-x: auto; display: block;white-space: nowrap;">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="width:10%">Line</th>
                <th style="width:15%">Item</th>
                <th style="width:20%">Description</th>
                <th style="width:15%">Qty Order</th>
                <th style="width:15%">Qty Pick</th>
                <th style="width:15%">Qty Ship</th>
                <th style="width:15%">UM</th>
                <th style="width:15%;">Keterangan</th>
              </tr>
            </thead>
            <tbody id="sotemp">
                @include('picklistbrowse.table-tempso')
            </tbody>
          </table>
        </div>
      </form>
  </div>

  <!-- MODAL ALERT -->
  <div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel">Konfirmasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/submitedit" id='edited' onkeydown="return event.key != 'Enter';">
            {{ csrf_field() }}
            <div class="form-group row col-md-12">
              SO dengan nomor <span id="sonbr" ><b></b></span> sudah ada di QAD, anda yakin ingin reload ulang data yang sudah ada ?
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Back</button>
          <!-- <button type="submit" class="btn btn-success bt-action btn-focus" id="e_btnconf">Submit</button>
          <button type="button" class="btn bt-action" id="e_btnloading" style="display:none">
            <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
          </button> -->
        </div>
        </form>
      </div>
    </div>
  </div>
  
@endsection

@section('scripts')
    <script>
        $("#checkall").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

       $('#duedatefrom').datepicker({
         dateFormat : 'dd-mm-yy'
       });
       $('#duedateto').datepicker({
         dateFormat : 'dd-mm-yy'
       });

       $(document).on('click', '#btnsearch', function(){
         let sonumber = document.getElementById('sonumber').value;
         

        if(sonumber == ''){
          swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Input terlebih dahulu nomor SO',
            toast: true,
            showConfirmButton: false,
            timer: 2000,
          })
        }else{ 

          $.ajax({
            url:"/searchso",
            data:{
              sonumber : sonumber,
            },
            // beforeSend: function(){
            //   $('#loader').removeClass('hidden')
            // },
            success:function(data){
              console.log(data);
              // alert(data);
              if(data != 'kosong'){
                $('#sotemp').html('').append(data);
              }
              // var panjang = document.getElementById('dataTable').rows.length;
              // if(panjang > 1){
                $('#editModal').show();
              // }
              // else{
                
              // }


            
          },
            // complete: function () {
            //   $('#loader').addClass('hidden')
            // },
          })

         }
       });

        // $(document).on('click', '#editsotmp', function(e){
        //   // alert('hellooo');
        //   var sonumber = $(this).data('sonbr');
        //   var customer = $(this).data('cust');

        //   document.getElementById('sonbr').value = sonumber;
        //   document.getElementById('ed_custcode').value = customer;


        //   $.ajax({
        //       url : "/editshipinstruksi",
        //       data : {
        //           sonumber : sonumber,
        //           customer : customer,
        //       },
        //       success: function(data){
        //           console.log(data);
        //           $('#ed_detailso').html('');
        //           $('#ed_detailso').html(data);
        //       }
        //   })
        // });

    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        
    </script>
@endsection