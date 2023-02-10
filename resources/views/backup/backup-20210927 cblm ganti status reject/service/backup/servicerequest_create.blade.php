@extends('layout.newlayout')
@section('content-header')

      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Service Request</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
  <!-- Flash Menu -->
  
  <div class="panel-body">
   <hr>
      <form method="post" id="srform" action="/inputsr">
        {{csrf_field()}}
        <div class="form-group row">
          <label for="assetcode" class="col-md-2 col-form-label my-auto">Asset Code <span id="alert1" style="color: red; font-weight: 200;">* Please Select Asset Code</span></label>
          <div class="col-md-3 col-sm-12">
              <select id="assetcode" name="assetcode" class="form-control" required>
                <option value="">-- Select Asset Code --</option>
                @foreach($showasset as $show)
                  <option value="{{$show->asset_code}}">{{$show->asset_desc." - ".$show->asset_loc}}</option>
                @endforeach
              </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="numberfailure" class="col-md-2 col-form-label my-auto">Number of Failure</label><span id="alert3" style="color: red; font-weight: 200;"></span>
          <div class="col-md-3 col-sm-12">
              <select id="numberfailure" class="form-control" required>
                <option value="">-- Select Number of Failure</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-12 col-form-label"></label><span id="alert2" style="color: red; font-weight: 200;"></span>
          <div class="col-sm-12">
            <table class="table order-list table-borderless" style="table-layout: fixed;" id="table1">
              <tbody id="failurebody">
                <tr id="fl1" style="display: none;">
                  <td><label>Failure Code 1</label></td>
                  <td>
                    <select class="form-control" id="failurecode1" name="failurecode1">
                      <option value="">Pilih Failure Code</option>
                    </select>
                  </td>
                </tr>
                <tr id="fl2" style="display: none;">
                  <td><label>Failure Code 2</label></td>
                  <td>
                    <select class="form-control" id="failurecode2" name="failurecode2">
                      <option value="">Pilih Failure Code</option>
                    </select>
                  </td>
                </tr>
                <tr id="fl3" style="display: none;">
                  <td><label>Failure Code 3</label></td>
                  <td>
                    <select class="form-control" id="failurecode3" name="failurecode3">
                      <option value="">Pilih Failure Code</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-12 col-form-label">Note</label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="notesr" maxlength="50" autocomplete="off"/>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-12 col-form-label">Priority</label>
          <div class="col-sm-12">
            <select  class="form-control" id="priority" name="priority" required>
              <option value="">--Select Data--</option>
              <option value="low">Low</optio>
              <option value="medium">Medium</optio>
              <option value="high">High</optio>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-12 col-form-label">Department</label>
          <div class="col-sm-12">
            <select  class="form-control" id="department" name="department" required>
              <option value="">--Select Department--</option>
              @foreach($dept as $show)
                <option value="{{$show->dept_code}}">{{$show->dept_desc}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12">
            <button type="submit" id="btnsubmit" class="btn btn-success btn-block">Create Service Request</button>
          </div>
        </div>
      </form>
  </div>
  
@endsection

@section('scripts')
    <script>
      $(document).ready(function(){
        $("#numberfailure").select2({
            width : '100%',
            theme : 'bootstrap4',
        });

        $("#priority").select2({
            width : '100%',
            theme : 'bootstrap4',
        });

        $("#assetcode").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });
        $("#failurecode1").select2({
          width : '100%',
          theme : 'bootstrap4',
        });

        $("#failurecode2").select2({
          width : '100%',
          theme : 'bootstrap4',
        });

        $("#failurecode3").select2({
          width : '100%',
          theme : 'bootstrap4',
        });

        $("#department").select2({
          width : '100%',
          theme : 'bootstrap4'
        });
      });

      // $('input').on('input', function(){

      // });

      $(document).on('change', '#numberfailure', function(){
        var numberfailure = document.getElementById('numberfailure').value;

        if(numberfailure == 1){
          // alert('1');
          document.getElementById('fl1').style.display = '';
          // document.getElementById('fl1').focus();
          // document.getElementById('fl1').blur();
          // document.getElementById('fl1').blur();
          document.getElementById('fl2').style.display = 'none';
          document.getElementById('fl3').style.display = 'none';

        }else if(numberfailure == 2){
          // alert('2');
          document.getElementById('fl1').style.display = '';
          document.getElementById('fl2').style.display = '';
          document.getElementById('fl3').style.display = 'none';
          // document.getElementById('fl1').focus();
          // document.getElementById('fl1').focus();
          // document.getElementById('fl1').blur();


        }else{
          // alert('3');
          document.getElementById('fl1').style.display = '';
          document.getElementById('fl2').style.display = '';
          document.getElementById('fl3').style.display = '';
          // document.getElementById('fl1').focus();
          // document.getElementById('fl1').focus();
          // document.getElementById('fl1').focus();

        }
      });


      $(document).on('change', '#assetcode', function(e) {
        var asset = document.getElementById('assetcode').value;
        var i = 0;
        var toAppend = '';
        document.getElementById('alert1').style.display = 'none';

        $.ajax({
          url: "/failuresearch",
          data: {
            asset: asset,
          },
          success: function(data) {
            
            console.log(data);
              // $('#btnsubmit').prop('disabled', false);
              // document.getElementById('btnsubmit').style.display = '';
              
              // alert('row exists');
              // test();

              $('#failurecode1').html('').append(data).trigger('change');
              $('#failurecode2').html('').append(data).trigger('change');;
              $('#failurecode3').html('').append(data).trigger('change');;

              // console.log(globalasset);
                  
          }
          
        })
      });


      $(document).on('click', '#btnsubmit', function(e){
        var assetcode = document.getElementById('assetcode').value;
        var failurecode1 = document.getElementById('failurecode1').value;
        var failurecode2 = document.getElementById('failurecode2').value;
        var failurecode3 = document.getElementById('failurecode3').value;
        var numberoffailure = document.getElementById('numberfailure').value;
        // alert(assetcode);
        if(assetcode == ""){
          // alert('masuk');
          document.getElementById('alert1').style.display = '';
          e.preventDefault();
        }else if(numberoffailure == ""){
          document.getElementById('alert3').innerHTML = "* Please select number of failure";
          e.preventDefault();
        }else if(failurecode1 == "" && failurecode2 == "" && failurecode3 == ""){
          // alert('belom pilih failure code');
          document.getElementById('alert2').innerHTML = "* Please select at least one failure code, start from failure code 1";
          e.preventDefault();
        }else{
          // alert('validasi');
          validasiselect(e);
        }
      });


      function validasiselect(){
        var failurecode1 = document.getElementById('failurecode1').value;
        var failurecode2 = document.getElementById('failurecode2').value;
        var failurecode3 = document.getElementById('failurecode3').value;

        if(failurecode1 != "" && failurecode2 == "" && failurecode3 == ""){
          var test = [failurecode1];
        }else if(failurecode1 != ""  && failurecode2 != "" && failurecode3 == ""){
          var test = [failurecode1, failurecode2];
        }else{
          var test  = [failurecode1, failurecode2, failurecode3];
        }

        var flg = true;
        // alert(test);
        // alert(test[0]);
        for(var i = 0; i < test.length; i++){
          
          if(test.indexOf(test[i], i + 1) >= 0){
            // alert(i);
            flg = false;
            break;
          }
        }

        // alert(flg);

        if(flg){
          // if(failurecode1 == "" && (failurecode2 != "" || failurecode3 != "")){
          //   document.getElementById('alert3').innerHTML = "* Please Select Failure Code 1";
          //   event.preventDefault();
          // }else{
            document.getElementById('alert2').innerHTML = "";
            $('#srform').submit();
          // }
        }else{

            if(failurecode1 == "" && (failurecode2 != "" || failurecode3 != "")){
                document.getElementById('alert2').innerHTML = "* Please Select Failure Code 1";
                event.preventDefault();
            }else{
                document.getElementById('alert2').innerHTML = "* Failure Code Duplicate";
                event.preventDefault();
            }
        }
      }
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        
    </script>
@endsection