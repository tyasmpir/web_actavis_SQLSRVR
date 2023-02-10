@extends('layout.newlayout')
@section('content-header')

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Service Request Create</h1>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->

<div class="panel-body">
  <hr>
  <form method="post" id="srform" action="/inputsr" style="background-color: white; padding: 2%;">
    {{csrf_field()}}
    <div class="form-group row">
      <label for="assetcode" class="col-md-2 col-lg-3 col-form-label my-auto">Asset Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-5 col-sm-12">
        <select id="assetcode" name="assetcode" class="form-control" required>
          <option value="">-- Select Asset Code --</option>
          @foreach($showasset as $show)
          <option value="{{$show->asset_code}}">{{$show->asset_code.' => '.$show->asset_desc." - ".$show->asset_loc}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="wotype" class="col-md-2 col-lg-3 col-form-label my-auto">Work Order Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-5 col-sm-12">
        <select class="form-control" id="wotype" name="wotype" required>
          <option></option>
          @foreach($wotype as $wotypeshow)
          <option value="{{$wotypeshow->wotyp_code}}">{{$wotypeshow->wotyp_code}} -- {{$wotypeshow->wotyp_desc}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="impact" class="col-md-2 col-lg-3 col-form-label my-auto">Impact <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-5 col-sm-12">
        <select class="form-control" id="impact" name="impact[]" multiple="multiple" required>
          @foreach($impact as $impactshow)
          <option value="{{$impactshow->imp_code}}">{{$impactshow->imp_code}} -- {{$impactshow->imp_desc}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <!-- <div class="form-group row">
          <div class="col-md-2 col-lg-6 my-auto">
            <input type="checkbox" id="OtherCb"><label for="OtherCb" class="col-form-label ml-2">Other Failure Code</label>
          </div>
          <div class="col-md-3 col-sm-12">
            <textarea type="text" class="form-control" id="otherfailure" name="otherfailure" maxlength="250" autocomplete="off" disabled></textarea>
          </div>
        </div> -->
    <div class="form-group row">
      <label class="col-sm-12 col-lg-3 col-form-label">Note</label>
      <div class="col-sm-12 col-md-5">
        <textarea type="text" class="form-control" id="notesr" name="notesr" maxlength="250" autocomplete="off"></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-12 col-lg-3 col-form-label">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-sm-12 col-md-5">
        <select class="form-control" id="priority" name="priority" required>
          <option value="">--Select Data--</option>
          <option value="low">Low</optio>
          <option value="medium">Medium</optio>
          <option value="high">High</optio>
        </select>
      </div>
    </div>
    <!-- <div class="form-group row">
          <label class="col-sm-12 col-lg-6 col-form-label">Department</label>
          <div class="col-sm-12 col-md-3">
            <select  class="form-control" id="department" name="department" required>
              <option value="">--Select Department--</option>
              @foreach($dept as $show)
                <option value="{{$show->dept_code}}">{{$show->dept_desc}}</option>
              @endforeach
            </select>
          </div>
        </div> -->
    <div class="form-group row">
      <div class="col-sm-12 col-lg-3"></div>
      <div class="col-sm-12 col-md-5">
        <button type="submit" id="btnsubmit" class="btn btn-success" style="color: white !important;">Save</button>&nbsp;
        <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
          <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
        </button>
      </div>
    </div>

  </form>
</div>

@endsection

@section('scripts')
<script>
  $(document).on('submit','#srform',function(e){
      document.getElementById('btnloading').style.display = 'block';
      document.getElementById('btnsubmit').style.display = 'none';
      triggerdelete = 'yes';
    });

  $(document).ready(function() {

    // document.getElementById('OtherCb').onchange = function() {
    //   document.getElementById('otherfailure').disabled = !this.checked;
    //   document.getElementById('otherfailure').required = this.checked;
    // };

    $("#assetcode").select2({
      width: '100%',
      allowClear: true
      // theme : 'bootstrap4',
    });


    $("#numberfailure").select2({
      width: '100%',
      theme: 'bootstrap4',
    });

    $("#priority").select2({
      width: '100%',
      theme: 'bootstrap4',
    });

    $("#assetcode").select2({
      width: '100%',
      theme: 'bootstrap4',

    });
    $("#wotype").select2({
      width: '100%',
      // theme : 'bootstrap4',
      allowClear: true,
      placeholder: 'Select Work Order Type',

    });

    $("#impact").select2({
      width: '100%',
      placeholder: "Select Impact",
      closeOnSelect: false,
      allowClear: true,
      multiple: true,

    });

    $("#department").select2({
      width: '100%',
      theme: 'bootstrap4'
    });
  });

  // $('input').on('input', function(){

  // });

  // $(document).on('change', '#numberfailure', function(){
  //   var numberfailure = document.getElementById('numberfailure').value;
  //   $("#failurecode1").val('');
  //   $("#failurecode2").val('');
  //   $("#failurecode3").val('');

  //   var fl1 = document.getElementById('failurecode1').value;
  //   var fl2 = document.getElementById('failurecode2').value;
  //   var fl3 = document.getElementById('failurecode3').value;

  //   $("#failurecode1").select2({
  //     width : '100%',
  //     theme : 'bootstrap4',
  //     placeholder:'Select Failure Code',
  //     fl1
  //   });

  //   $("#failurecode2").select2({
  //     width : '100%',
  //     theme : 'bootstrap4',
  //     placeholder:'Select Failure Code',
  //     fl2
  //   });

  //   $("#failurecode3").select2({
  //     width : '100%',
  //     theme : 'bootstrap4',
  //     placeholder:'Select Failure Code',
  //     fl3
  //   });

  //   if(numberfailure == 1){
  //     // alert('1');
  //     document.getElementById('fl1').style.display = '';
  //     document.getElementById('fl2').style.display = 'none';
  //     document.getElementById('fl3').style.display = 'none';
  //     $("#failurecode1").attr('required',true);
  //     $("#failurecode2").attr('required',false);
  //     $("#failurecode3").attr('required',false);

  //   }else if(numberfailure == 2){
  //     // alert('2');
  //     document.getElementById('fl1').style.display = '';
  //     document.getElementById('fl2').style.display = '';
  //     document.getElementById('fl3').style.display = 'none';

  //     $("#failurecode1").attr('required',true);
  //     $("#failurecode2").attr('required',true);
  //     $("#failurecode3").attr('required',false);


  //   }else{
  //     // alert('3');
  //     document.getElementById('fl1').style.display = '';
  //     document.getElementById('fl2').style.display = '';
  //     document.getElementById('fl3').style.display = '';

  //     $("#failurecode1").attr('required',true);
  //     $("#failurecode2").attr('required',true);
  //     $("#failurecode3").attr('required',true);

  //   }
  // });
</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection