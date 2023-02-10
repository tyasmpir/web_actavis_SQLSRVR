@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Service Request Approval</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Picklist Browse WH</li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <!-- <hr> -->
@endsection

@section('content')
<style type="text/css">
  @media screen and (max-width: 992px) {

    .mini-table {
      border: 0;
    }

    .mini-table thead {
      display: none;
    }

    .mini-table tr {
      margin-bottom: 10px;
      display: block;
      border-bottom: 2px solid #ddd;
    }

    .mini-table td {
      display: block;
      text-align: right;
      font-size: 13px;
      border-bottom: 1px dotted #ccc;
    }

    .mini-table td:last-child {
      border-bottom: 0;
    }

    .mini-table td:before {
      content: attr(data-label);
      float: left;
      text-transform: uppercase;
      font-weight: bold;
    }

    .select2-results__option--disabled{
      color: grey !important;
    }
  }
</style>
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
            <!--FORM Search Disini-->
            <label for="s_servicenbr" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Service Request Number') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <input id="s_servicenbr" type="text" class="form-control"  name="s_servicenbr" value="" autofocus autocomplete="off">
            </div>
            <label for="s_asset" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('Asset Code') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <select id="s_asset" name="s_asset" class="form-control" value="" autofocus autocomplete="off">
                <option value="">Select Asset</option>
                @foreach($asset as $show)
                <option value="{{$show->asset_desc}}">{{$show->asset_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-12 form-group row">
            <!--FORM Search Disini-->
            <label for="s_priority" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Priority') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <select id="s_priority" name="s_priority" class="form-control" value="" autofocus autocomplete="off">
                <option value="">--Select Priority--</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
            <label for="s_period" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <input type="button" class="btn btn-primary" id="btnsearch" value="Search" style="float:right" />
              <button type="button" class="btn btn-primary ml-2" id="btnrefresh"><i class="fas fa-redo-alt"></i></button>
            </div>
          </div>
        </li>
      </ul>
    </li>
  </ul>
</div>

<input type="hidden" id="tmpsrnumber"/>
<input type="hidden" id="tmpasset"/>
<input type="hidden" id="tmppriority"/>
<input type="hidden" id="tmpperiod"/>

<!-- table picklist -->
<div class="table-responsive col-12">
  <table class="table table-bordered mt-4 no-footer mini-table" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" data-sorting_type="asc" data-column_name="so_nbr" width="15%">SR Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust" width="25%">Asset<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust" width="25%">Requested by<span id="username_icon"></span></th>
        <th width="10%">Priority</th>
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('service.table-srapproval')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Service Request Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="approval" method="post" action="/approval" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="hiddenreq" name="hiddenreq"/>
                    <div class="form-group row">
                        <label for="srnumber" class="col-md-5 col-form-label text-md-right">Service Request Number</label>
                        <div class="col-md-6">
                            <input id="srnumber" type="text" class="form-control" name="srnumber"
                            autocomplete="off" autofocus readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="reqbyname" class="col-md-5 col-form-label text-md-right">Requested by</label>
                        <div class="col-md-6">
                            <input id="reqbyname" type="text" class="form-control" autocomplete="off" autofocus readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dept" class="col-md-5 col-form-label text-md-right">Department</label>
                        <div class="col-md-6">
                            <input id="dept" type="text" class="form-control" name="dept" autocomplete="off" autofocus readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="assetcode" class="col-md-5 col-form-label text-md-right">Asset Code</label>
                        <div class="col-md-6">
                            <input id="assetcode" type="text" class="form-control" name="assetcode" autocomplete="off" autofocus readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="assetdesc" class="col-md-5 col-form-label text-md-right">Asset Description</label>
                        <div class="col-md-6">
                            <input id="assetdesc" type="text" class="form-control" name="assetdesc" autocomplete="off" autofocus readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="assetloc" class="col-md-5 col-form-label text-md-right">Location</label>
                        <div class="col-md-6">
                            <input id="assetloc" type="text" class="form-control" name="assetloc" autocomplete="off" autofocus readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="assettype" class="col-md-5 col-form-label text-md-right">Process / Technology</label>
                        <div class="col-md-6">
                            <input id="assettype" type="text" class="form-control" name="assettype" autocomplete="off" autofocus readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wotype" class="col-md-5 col-form-label text-md-right">Work Order Type</label>
                        <div class="col-md-6">
                            <input id="wotype" type="text" class="form-control" name="wotype" autocomplete="off" autofocus readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="impact" class="col-md-5 col-form-label text-md-right">Impact</label>
                        <div class="col-md-6">
                        <textarea id="impact" type="text" class="form-control" name="impact" autocomplete="off" rows="5" autofocus readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="srnote" class="col-md-5 col-form-label text-md-right">Note</label>
                        <div class="col-md-6">
                            <textarea id="srnote" type="text" class="form-control" name="srnote" maxlength="250" autocomplete="off" autofocus readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="priority" class="col-md-5 col-form-label text-md-right">Priority</label>
                        <div class="col-md-6">
                            <input id="priority" type="text" name="priority" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- <div class="form-group row">
                        <label for="numberengineer" class="col-md-5 col-form-label text-md-right">Number of Engineer</label>
                        <div class="col-md-6">
                            <select id="numberengineer" class="form-control" name="numberengineer" required value="{{ old('numberengineer') }}">
                                <option value="">--Select Number of Engineer--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="form-group row" id="eng1" style="display: none;">
                        <label for="enjiner1" class="col-md-5 col-form-label text-md-right">Engineer 1</label>
                        <div class="col-md-6">
                            <select id="enjiner1" class="form-control inicheck" name="enjiner1"  >
                                <option value="">--Select Engineer--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="eng2" style="display: none;">
                        <label for="enjiner2" class="col-md-5 col-form-label text-md-right">Engineer 2</label>
                        <div class="col-md-6">
                            <select id="enjiner2" class="form-control inicheck" name="enjiner2"  >
                                <option value="">--Select Engineer--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="eng3" style="display: none;">
                        <label for="enjiner3" class="col-md-5 col-form-label text-md-right">Engineer 3</label>
                        <div class="col-md-6">
                            <select id="enjiner3" class="form-control inicheck" name="enjiner3"  >
                                <option value="">--Select Engineer--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="eng4" style="display: none;">
                        <label for="enjiner4" class="col-md-5 col-form-label text-md-right">Engineer 4</label>
                        <div class="col-md-6">
                            <select id="enjiner4" class="form-control inicheck" name="enjiner4"  >
                                <option value="">--Select Engineer--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="eng5" style="display: none;">
                        <label for="enjiner5" class="col-md-5 col-form-label text-md-right">Engineer 5</label>
                        <div class="col-md-6">
                            <select id="enjiner5" class="form-control inicheck" name="enjiner5" >
                                <option value="">--Select Engineer--</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="enjiners" class="col-md-5 col-form-label text-md-right">Engineer (Max. 5) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="enjiners" name="enjiners[]" class="form-control" multiple="multiple" required>
                                <option value="">--Select Engineer--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <label for="selectrep" class="col-md-5 col-form-label text-md-right">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-7 my-auto">
                          <input type="radio" id="rad_repgroup1" class="d-inline" name="rad_repgroup" value="group" required>
                          <label for="rad_repgroup1" class="form-check-label">Repair Group</label>

                          <input type="radio" id="rad_repgroup2" class="d-inline ml-2" name="rad_repgroup" value="code">
                          <label for="rad_repgroup2" class="form-check-label">Repair Code</label>
                        </div>
                    </div>

                    <div class="form-group row" id="tampilanrepgroup" style="display: none;">
                        <label for="repaircode" class="col-md-5 col-form-label text-md-right">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="repgroup" name="repgroup" class="form-control">
                                <option>--Select Repair Group--</option>
                                @foreach($repgroup as $repgroupshow)
                                <option value="{{$repgroupshow->xxrepgroup_nbr}}">{{$repgroupshow->xxrepgroup_nbr}} -- {{$repgroupshow->xxrepgroup_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="tampilanrepcode" style="display: none;">
                        <label for="repaircode" class="col-md-5 col-form-label text-md-right">Repair Code (Max. 3) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="repaircode" name="repaircode[]" class="form-control" multiple="multiple">
                                <!-- <option>--Select Repair Code--</option> -->
                                @foreach($repaircode as $repairshow)
                                <option value="{{$repairshow->repm_code}}">{{$repairshow->repm_code}} -- {{$repairshow->repm_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Engineer ENDDDDD -->
                    <!-- <div class="row" id="inialert1" style="display: none; margin-bottom: 1rem;">
                        <label class="col-md-4"></label>
                        <span id="alert1" style="font-weight: 400; color: red;"></span>
                    </div> -->
                    <div class="form-group row">
                        <label for="scheduledate" class="col-md-5 col-form-label text-md-right">Schedule Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="scheduledate" type="date" class="form-control" name="scheduledate" placeholder="yy-mm-dd"  autocomplete="off" min="{{Carbon\Carbon::now()->format("Y-m-d")}}" autofocus required value="{{ old('scheduledate') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="duedate" class="col-md-5 col-form-label text-md-right">Due Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="duedate" type="date" class="form-control" name="duedate" placeholder="yy-mm-dd"  autocomplete="off" min="{{Carbon\Carbon::now()->format("Y-m-d")}}" autofocus required value="{{ old('duedate') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rejectreason" class="col-md-5 col-form-label text-md-right">Reject Reason</label>
                        <div class="col-md-6">
                            <textarea id="rejectreason" type="text" class="form-control" name="rejectreason" maxlength="250" autocomplete="off" autofocus></textarea>
                            <span id="alert3"  style="color: red; font-weight: 200;"></span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="tmpfail1" name="tmpfail1" value="">
                <input type="hidden" id="impactcode1" name="impactcode1" value="">
                <input type="hidden" id="tmpfail2" name="tmpfail2" value="">
                <input type="hidden" id="tmpfail3" name="tmpfail3" value="">
                <input type="hidden" id="hiddendeptcode" name="hiddendeptcode" />
                <!-- <input type="hidden" id="hiddenreqby" name="hiddenreqby" /> -->
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="action" value="reject" id="btnreject">Reject</button>
                    <button type="submit" class="btn btn-success" name="action" value="approve" id="btnapprove">Approve</button> 
                    <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
                      <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
                    </button>
                </div>
            </form>
        </div>
    </div>
  </div>

@endsection


@section('scripts')
<script type="text/javascript">
$("#approval").submit(function() {
    document.getElementById('btnclose').style.display = 'none';
    document.getElementById('btnreject').style.display = 'none';
    document.getElementById('btnapprove').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
});

$(document).ready(function(){
    $("#enjiner1").select2({
      width : '100%',
      theme : 'bootstrap4',
    });

    $("#enjiner2").select2({
      width : '100%',
      theme : 'bootstrap4',
    });

    $("#enjiner3").select2({
      width : '100%',
      theme : 'bootstrap4',
    });

    $("#s_asset").select2({
      width : '100%',
      // placeholder : "Select Asset",
      theme : 'bootstrap4',
    });

    $(".select2bs4").select2({
      width : '100%',
      theme : 'bootstrap4',
    });


    $("#enjiners").select2({
      width : '100%',
      placeholder : "Select Engineer",
      maximumSelectionLength : 5,
      closeOnSelect : false,
      allowClear : true,
      multiple : true,
      // theme : 'bootstrap4'
    });

    $("#repaircode").select2({
      width : '100%',
      placeholder : "Select Repair Code",
      maximumSelectionLength : 3,
      closeOnSelect : false,
      allowClear : true,
      // theme : 'bootstrap4'
    });

    $("#repgroup").select2({
      width : '100%',
      placeholder : 'Select Repair Group',
      allowClear : true,
      // theme : 'bootstrap4',
    });

    $(document).on('change','#rad_repgroup1',function(e){
	  document.getElementById('tampilanrepgroup').style.display='';
	  document.getElementById('repgroup').value=null;
	  document.getElementById('tampilanrepcode').style.display='none';
	  document.getElementById('repaircode').value=null;  
	});
	$(document).on('change','#rad_repgroup2',function(e){
	  document.getElementById('tampilanrepcode').style.display='';
	  document.getElementById('repaircode').value=null;
	  document.getElementById('tampilanrepgroup').style.display='none';
	  document.getElementById('repgroup').value=null;
	});


    $(document).on('click', '#btnreject', function(event){
      var rejectreason = document.getElementById('rejectreason').value;
      var enjiners = document.getElementById('enjiners').value;
      var scheduledate = document.getElementById('scheduledate').value;
      var duedate = document.getElementById('duedate').value;
      // event.preventDefault();
      // $('#approval')
      
      if(rejectreason == ""){
          // alert('masuk reject');
          $("#enjiners").attr('required', false);
          $("#scheduledate").attr('required', false);
          $("#duedate").attr('required', false);
          $("#repaircode").attr('required', false);
          $("#rad_repgroup1").attr('required', false);
          // document.getElementById("alert3").innerHTML = 'Please fill out reason reject';
          $("#rejectreason").attr('required', true);
        }else{
          // alert('masuk sini');
          $("#enjiners").attr('required', false);
          $("#scheduledate").attr('required', false);
          $("#duedate").attr('required', false);
          $("#repaircode").attr('required', false);
          $("#rad_repgroup1").attr('required', false);
          // document.getElementById("alert3").innerHTML = 'Please fill out reason reject';
          $("#rejectreason").attr('required', true);

          $('#approval').submit();

        }

    });

    $(document).on('click', '#btnapprove', function(event){
      var rejectreason = document.getElementById('rejectreason').value;
      var enjiners = document.getElementById('enjiners').value;
      var scheduledate = document.getElementById('scheduledate').value;
      var duedate = document.getElementById('duedate').value;
      var pilihgrup =  document.getElementById('rad_repgroup1').checked;
      var pilihcode = document.getElementById('rad_repgroup2').checked;
      // event.preventDefault();
      // $('#approval')
      // alert(pilihgrup);
      // alert(pilihcode);
      
      if(enjiners == "" || scheduledate == "" || duedate == "" || (pilihgrup == false && pilihcode == false)){
          // alert('ada yg kosong');
          $("#enjiners").attr('required', true);
          $("#scheduledate").attr('required', true);
          $("#duedate").attr('required', true);
          $("#rad_repgroup1").attr('required', true);
          // $("#repaircode").attr('required', true);
          // document.getElementById("alert3").innerHTML = 'Please fill out reason reject';
          $("#rejectreason").attr('required', false);
        }else{
          if(pilihgrup){
          	// alert('pilihgrup');
          	$("#repgroup").attr('required', true);
          	$("#repaircode").attr('required', false);
          	// $('#approval').submit();
          	// event.preventDefault();
          }else{
          	// alert('pilihcode');
          	$("#repaircode").attr('required', true);
          	$("#repgroup").attr('required', false);
          	// $('#approval').submit();
          	// event.preventDefault();
          }
          // $("#rad_repgroup1").attr('required',true);

        }

    });

    function fetch_data(page, srnumber, asset, priority) {
      $.ajax({
        url: "/srapproval/searchapproval?page=" + page + "&srnumber=" + srnumber + "&asset=" + asset + "&priority=" + priority,
        success: function(data) {
          console.log(data);
          $('tbody').html('');
          $('tbody').html(data);
        }
      })
    }


    $(document).on('click', '#btnsearch', function() {
      var srnumber  = $('#s_servicenbr').val(); 
      var asset    = $('#s_asset').val(); 
      var priority = $('#s_priority').val();
      // var column_name = $('#hidden_column_name').val();
      // var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      document.getElementById('tmpsrnumber').value  = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;

      fetch_data(page, srnumber, asset, priority);
    });

  
    $(document).on('click', '.pagination a', function(event) {
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      $('#hidden_page').val(page);
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();

      var srnumber = $('#tmpsrnumber').val();
      var asset = $('#tmpasset').val();
      var priority = $('#tmppriority').val();
      
      fetch_data(page, srnumber, asset, priority);
    });

    $(document).on('click', '#btnrefresh', function() {
      var srnumber  = ''; 
      var asset    = '';
      var priority = '';
      var page = 1;

      document.getElementById('s_servicenbr').value     = '';
      document.getElementById('s_asset').value          = '';
      document.getElementById('s_priority').value = '';
      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;

      fetch_data(page, srnumber, asset, priority);

      $("#s_asset").select2({
        width : '100%',
        // placeholder : "Select Asset",
        theme : 'bootstrap4',
        asset,
      });
    });

    $(document).on('click', '.approval', function() {
      $('#viewModal').modal('show');

      var srnumber = $(this).data('srnumber');
      var assetcode = $(this).data('assetcode');
      var assetdesc = $(this).data('assetdesc');
      var srnote = $(this).data('srnote');
      var reqby = $(this).data('reqby');
      var priority = $(this).data('priority');
      var dept = $(this).data('deptdesc');
      var deptcode = $(this).data('deptcode');
      var reqbyname = $(this).data('reqbyname');
      var wotype = $(this).data('wotypedescx');
      var impact = $(this).data('impactcode');
      // alert(impact);
      var assetloc = $(this).data('assetloc');
      var astype = $(this).data('astypedesc');
      var impactcode1 = $(this).data('impactcode');

      
      // alert(assetdesc);
      $.ajax({
          url: "/searchimpactdesc",
          data : {
            impact : impact,
          },
          success: function(data) {
            // console.log(data);
            // alert('test');

            var imp_desc = data;

            var desc = imp_desc.replaceAll(",", "\n");

            // console.log(desc);

            document.getElementById('impact').value =  desc;
            // }
                
          }   
      })
      // alert(impactcode1);
      document.getElementById('srnumber').value = srnumber;
      document.getElementById('assetcode').value = assetcode;
      document.getElementById('assetdesc').value = assetdesc;
      document.getElementById('assettype').value = astype;
      document.getElementById('wotype').value = wotype;
      document.getElementById('impactcode1').value = impactcode1;
      document.getElementById('assetloc').value = assetloc;
      
      // document.getElementById('failurecode1').value = failurecode1;
      // document.getElementById('failurecode2').value = failurecode2;
      // document.getElementById('failurecode3').value = failurecode3;
      document.getElementById('srnote').value = srnote;
      document.getElementById('hiddenreq').value = reqby;
      document.getElementById('priority').value = priority;
      document.getElementById('dept').value = dept;
      document.getElementById('hiddendeptcode').value = deptcode;
      document.getElementById('reqbyname').value = reqbyname;

    });

    function ambilenjiner(){
      // alert('ketrigger');
      $.ajax({
          url: "/engineersearch",
          success: function(data) {
          
          console.log(data);
          var jmldata = data.length;

          var eng_code = [];
          var eng_desc = [];
          var test = [];


          for(i = 0; i < jmldata; i++){
          eng_code.push(data[i].eng_code);
            eng_desc.push(data[i].eng_desc);

            test += '<option value=' + eng_code[i] + '>' + eng_code[i] + '--' + eng_desc[i] + '</option>';
          }

          // console.log(test);

            // $('#btnsubmit').prop('disabled', false);
            // document.getElementById('btnsubmit').style.display = '';
            
            // alert('row exists');
            // test();

            // $('#enjiner1').html('').append(test);
            // $('#enjiner2').html('').append(test);
            // $('#enjiner3').html('').append(test);
            // $('#enjiner4').html('').append(test);
            // $('#enjiner5').html('').append(test);
            $('#enjiners').html('').append(test);


            // console.log(globalasset);
                
        }
        
      })
    }
    
    ambilenjiner();

  

});


</script>
@endsection