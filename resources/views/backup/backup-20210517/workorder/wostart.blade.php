@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Work Order Start</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Work Order Start</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->
<style>
.swal-popup{
  font-size: 2rem !important;
}
</style>
<!--Table Menu-->
<div class="col-md-2">

</div>

<hr>
<div class="col-12 form-group row">
  
<div class="table-responsive col-12">
  <table class="table table-borderless mini-table mt-4" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <th>Work Order Number</th>
        <th>Asset</th>
        <th>Status</th>
        <th>Priority</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @include('workorder.table-wostart')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>
<input type="hidden" id="tmpwo" value="">
<input type="hidden" id="tmpengineer" value="">
<input type="hidden" id="tmpstatus" value="">
 
<!--Modal view-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order View</h5>
        <button type="button" id="xclose" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="newedit" method="post" action="editjob">
        {{ csrf_field() }}
        <input type="hidden"  id="v_counter">
        <input type="hidden" name="statuswo" id="statuswo">
        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="v_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
              <input id="v_nowo" type="text" class="form-control" name="v_nowo"  autocomplete="off" readonly autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_nosr" class="col-md-5 col-form-label text-md-left">SR Number</label>
            <div class="col-md-7">
              <input id="v_nosr" type="text" class="form-control" name="v_nosr"  readonly autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vien1" style="display:none">
            <label for="v_engineer1" class="col-md-5 col-form-label text-md-left">Engineer 1</label>
            <div class="col-md-7">
              <input type='text' id="v_engineer1" class="form-control v_engineer1" name="v_engineer1"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vien2" style="display:none">
            <label for="v_engineer2" class="col-md-5 col-form-label text-md-left">Engineer 2</label>
            <div class="col-md-7">
              <input type='text' id="v_engineer2" class="form-control v_engineer2" name="v_engineer2" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vien3" style="display:none">
            <label for="v_engineer3" class="col-md-5 col-form-label text-md-left">Engineer 3</label>
            <div class="col-md-7">
              <input type="text" readonly id="v_engineer3" class="form-control v_engineer3" name="v_engineer3" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vien4" style="display:none">
            <label for="v_engineer4" class="col-md-5 col-form-label text-md-left">Engineer 4</label>
            <div class="col-md-7">
              <input type="text" readonly id="v_engineer4" class="form-control v_engineer4" name="v_engineer4" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vien5" style="display:none">
            <label for="v_engineer5" class="col-md-5 col-form-label text-md-left">Engineer 5</label>
            <div class="col-md-7">
              <input type="text" readonly id="v_engineer5" class="form-control v_engineer5" name="v_engineer5" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
              <input type="text" readonly id="v_asset" type="text" class="form-control v_asset" name="v_asset" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail1" style="display:none">
            <label for="e_failure1" class="col-md-5 col-form-label text-md-left">Failure Code 1</label>
            <div class="col-md-7">
              <input id="e_failure1" class="form-control e_failure1"  autofocus readonly>
              <input type="hidden" name="e_failure1" id="hiddenfail1">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail2" style="display:none">
            <label for="e_failure2" class="col-md-5 col-form-label text-md-left">Failure Code 2</label>
            <div class="col-md-7">
              <input id="e_failure2" class="form-control e_failure2"  autofocus readonly >
              <input type="hidden" name="e_failure2" id="hiddenfail2">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail3" style="display:none">
            <label for="e_failure3" class="col-md-5 col-form-label text-md-left">Failure Code 3</label>
            <div class="col-md-7">
              <input id="e_failure3" class="form-control e_failure3"  autofocus readonly>
              <input type="hidden" name="e_failure3" id="hiddenfail3">
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_schedule" class="col-md-5 col-form-label text-md-left">Schedule Date</label>
            <div class="col-md-7">
              <input id="v_schedule" readonly type="date" class="form-control" name="v_schedule" value="{{ old('v_schedule') }}"   autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_duedate" class="col-md-5 col-form-label text-md-left">Due Date</label>
            <div class="col-md-7">
              <input id="v_duedate" readonly type="date" class="form-control" name="v_duedate" value="{{ old('e_duedate') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <input  id="v_dept" readonly  class="form-control" name="v_note" value="{{ old('v_dept') }}"  autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
            <div class="col-md-7">
              <input id="v_priority" type="text" class="form-control" name="v_priority" value="{{ old('v_priority') }}"  autofocus readonly>
            </div>
          </div>
          <div class="modal-footer" style="font-size:small">
            <div class="container">
            <div class="d-flex justify-content-center mb-2">
              <label id="labelcheck"  style="display: none;" for="checkboxaban">Abandon this job?</label>
              <input type="checkbox" id="checkboxaban" class="ml-2" style="display: none;">
            </div>
            
            
            <div style="width:100%"><a id="aprint" target="_blank" style="float:right"><button type="button" class="btn btn-warning bt-action"><b>Print<b></button></a>
            <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-primary bt-action ml-5 mr-2"  id="e_btnclose" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success bt-action ml-2" id="e_btnchgstatus">Start</button>
            <button type="submit" style="display:none;"class="btn btn-danger bt-dark ml-2" id="e_btnchgstatus2" disabled>Abandon</button>
            <button type="button" class="btn btn-block btn-info" id="e_btnloading" style="display:none"><i class="fas fa-circle-notch fa-spin"></i> &nbsp;Loading</button>
            </div>
            </div>
            
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>      
    </div>
  </div>

@endsection

@section('scripts')
<script>
$(document).on('change','#checkboxaban',function(){
   var checkbox = document.getElementById('checkboxaban');
  if (this.checked){
    document.getElementById('e_btnchgstatus2').disabled = false;
  } else {
    document.getElementById('e_btnchgstatus2').disabled = true;
  }
})
$(document).on('click','#e_btnchgstatus',function(){
  document.getElementById('xclose').style.display='none';
  document.getElementById('e_btnchgstatus').style.display='none';
  document.getElementById('e_btnclose').style.display='none';
  document.getElementById('aprint').style.display='none';
  document.getElementById('e_btnloading').style.display='';
})

$(document).on('click','#e_btnchgstatus2',function(){
  document.getElementById('xclose').style.display='none';
  document.getElementById('labelcheck').style.display='none';
  document.getElementById('checkboxaban').style.display='none';
  document.getElementById('e_btnchgstatus2').style.display='none';
  document.getElementById('e_btnclose').style.display='none';
  document.getElementById('aprint').style.display='none';
  document.getElementById('e_btnloading').style.display='';
})

function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function fetch_data(page, sort_type, sort_by, wonumber, woengineer, wostatus) {
    $.ajax({
      url: "/wojoblist?page=" + page,
      success: function(data) {
        console.log(data);
        $('tbody').html('');
        $('tbody').html(data);
      }
    })
  }

    $(document).on('click', '.jobview', function() {
    var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
    // $('#loadingtable').modal('hide');
    $('#loadingtable').modal('show');
    var counter   = document.getElementById('v_counter');
    $.ajax({
      url: '/womaint/getnowo?nomorwo=' +wonbr,
      success:function(vamp){
        var tempres    = JSON.stringify(vamp);
        var result     = JSON.parse(tempres);
        var wonbr      = result[0].wo_nbr;
        var srnbr      = result[0].wo_sr_nbr;
        var en1val     = result[0].u11;
        var en2val     = result[0].u22;
        var en3val     = result[0].u33;
        var en4val     = result[0].u44;
        var en5val     = result[0].u55;
        var asset      = result[0].asset_desc;
        var schedule   = result[0].wo_schedule;
        var duedate    = result[0].wo_duedate;
        var wostatus   = result[0].wo_status;
        var fc1        = result[0].wofc1;
        var fc2        = result[0].wofc2;
        var fc3        = result[0].wofc3;
        var fn1        = result[0].fd1;
        var fn2        = result[0].fd2;
        var fn3        = result[0].fd3;
        var prio       = result[0].wo_priority;
        var note       = result[0].wo_note;
        var wodept     = result[0].dept_desc;
        var url = "{{url('openprint','id')}}";
        // var newo = JSON.stringify(wonbr);
        url = url.replace('id', wonbr);
        // alert(url);
        document.getElementById('aprint').href=url;
        if(fc1 == null || fc1 == ''){
          document.getElementById('divfail1').style.display = 'none';
        }
        else{
          document.getElementById('divfail1').style.display = '';
          document.getElementById('e_failure1').value = fn1;
          document.getElementById('hiddenfail1').value = fc1;
        }
          
        if(fc2 == null || fc2 == '' ){
          document.getElementById('divfail2').style.display = 'none';
        }  
        else{
            document.getElementById('divfail2').style.display = '';
            document.getElementById('e_failure2').value = fn2;
            document.getElementById('hiddenfail2').value = fc2;
        }
          
        if(fc3 == null || fc3 == ''){
          document.getElementById('divfail3').style.display = 'none';
        }
        else{
          document.getElementById('divfail3').style.display = '';
          document.getElementById('e_failure3').value = fn3;
          document.getElementById('hiddenfail3').value = fc3;
        }
        document.getElementById('statuswo').value = wostatus;
        if(wostatus == 'open'){
          document.getElementById('e_btnchgstatus').style.display = '';
          document.getElementById('e_btnchgstatus2').style.display = 'none';
          document.getElementById('checkboxaban').style.display = 'none';
          document.getElementById('labelcheck').style.display = 'none';
        }
        else{
          document.getElementById('e_btnchgstatus').style.display = 'none';
          document.getElementById('e_btnchgstatus2').style.display = '';
          document.getElementById('checkboxaban').style.display = '';
          document.getElementById('labelcheck').style.display = '';
        }
        if(en1val == null || en1val == ''){
          en1val = '';
        }
        else{
          document.getElementById('vien1').style.display = '';
          counter = 1;
        }

        if(en2val == null || en2val ==''){
          en2val = '';
          document.getElementById('vien2').style.display = 'none';
        }
        else{
          document.getElementById('vien2').style.display = '';
          counter = 2;
        }
        if(en3val == null || en3val ==''){
          en3val = '';
          document.getElementById('vien3').style.display = 'none';
        }
        else{
          document.getElementById('vien3').style.display = '';
          counter = 3;
        }

        if(en4val == null || en4val ==''){
          en4val = '';
          document.getElementById('vien4').style.display = 'none';
        }
        else{
          document.getElementById('vien4').style.display = '';
          counter = 4;
        }

        if(en5val == null || en5val == ''){
          en5val = '';
          document.getElementById('vien5').style.display = 'none';
        }
        else{
          document.getElementById('vien5').style.display = '';
          counter = 5;
        }
        document.getElementById('v_counter').value    = counter;
        document.getElementById('v_nowo').value       = wonbr;
        document.getElementById('v_nosr').value       = srnbr;
        document.getElementById('v_schedule').value   = schedule;
        document.getElementById('v_duedate').value    = duedate;
        document.getElementById('v_engineer1').value  = en1val;
        document.getElementById('v_engineer2').value  = en2val;
        document.getElementById('v_engineer3').value  = en3val;
        document.getElementById('v_engineer4').value  = en4val;
        document.getElementById('v_engineer5').value  = en5val;
        document.getElementById('v_asset').value      = asset;
        document.getElementById('v_priority').value   = prio;
        document.getElementById('v_dept').value       = wodept;
        
        if($('#loadingtable').hasClass('show')){
          
          setTimeout(function(){
            $('#loadingtable').modal('hide');
              
          },500);
          
          
        }
        setTimeout(function(){
            
            $('#viewModal').modal('show');  
          },1000);
      }
    })
  });
  $(document).on('click', '.sorting', function() {
    var column_name = $(this).data('column_name');
    var order_type = $(this).data('sorting_type');
    var reverse_order = '';
    if (order_type == 'asc') {
      $(this).data('sorting_type', 'desc');
      reverse_order = 'desc';
      clear_icon();
      $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
    }
    if (order_type == 'desc') {
      $(this).data('sorting_type', 'asc');
      reverse_order = 'asc';
      clear_icon();
      $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
    }
    $('#hidden_column_name').val(column_name);
    $('#hidden_sort_type').val(reverse_order);

    var page     = $('#hidden_page').val();
    var wonumber = $('#s_nomorwo').val();
    var engineer = $('#s_engineer').val();
    var status   = $('#s_status').val();

    fetch_data(page, reverse_order, column_name, username, divisi);
  });

  
  $(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    $('#hidden_page').val(page);
    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var wonumber    = $('#tmpwo').val();
    var engineer    = $('#tmpengineer').val();
    var status      = $('#tmpstatus').val();
    fetch_data(page, sort_type, column_name, wonumber, engineer,status);
  });

  
</script>
@endsection