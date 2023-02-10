@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Service Request Browse</h1>
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
      <a href="javascript:void(0)" class="nav-link mb-0 p-0">
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
            <label for="s_asset" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('Asset') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <select id="s_asset" name="s_asset" class="form-control" value="" autofocus autocomplete="off">
                <option value="">--Select Asset--</option>
                @foreach($asset as $show)
                <option value="{{$show->asset_desc}}">{{$show->asset_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-12 form-group row">
            <label for="s_priority" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Priority') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <select id="s_priority" name="s_priority" class="form-control" value="" autofocus autocomplete="off">
                <option value="">--Select Priority--</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
            <!-- <label for="s_period" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('SR Period') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <select id="s_period" name="s_period" class="form-control" value="" autofocus autocomplete="off">
                <option value="">--Select Period--</option>
                <option value="1"> < 3 days </option>
                <option value="2"> 3-5 days </option>
                <option value="3"> > 5 days </option>
              </select>
            </div> -->
            <label for="s_user" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('Requested by') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <select id="s_user" name="s_user" class="form-control" value="" autofocus autocomplete="off">
                <option value="">--Select User--</option>
                @foreach($users as $usershow)
                <option value="{{$usershow->username}}">{{$usershow->username}} - {{$usershow->name}}</option>
                @endforeach
              </select>
            </div>
            
          </div>
          <div class="col-12 form-group row">
            <label for="s_status" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Status') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <select id="s_status" name="s_status" class="form-control" value="" autofocus autocomplete="off">
                <option value="">--Select Status--</option>
                @if($fromhome == 'open')
                  <option value="1" selected>Open</option>
                @else
                  <option value="1">Open</option>
                @endif
                <option value="2">Assigned</option>
                <option value="3">Started</option>
                <option value="4">Finish</option>
                <option value="5">Closed</option>
              </select>
            </div>
            <label for="s_period" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <input type="button" class="btn btn-primary" id="btnsearch" value="Search" style="float:right" />
              <button type="button" class="btn btn-primary ml-2" id="btnrefresh"><i class="fas fa-redo-alt"></i></button>
              &nbsp;&nbsp;&nbsp;
              <input type="button" class="btn btn-primary" id="btnexcel" value="Export to Excel" style="float:right" />
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
<input type="hidden" id="tmpuser"/>
@if($fromhome == 'open')
  <input type="hidden" id="tmpstatus" value="1"/>
@else
  <input type="hidden" id="tmpstatus"/>
@endif

<!-- table SR -->
<div class="table-responsive col-12">
  <table class="table table-bordered mt-4 no-footer mini-table" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" data-sorting_type="asc" data-column_name="so_nbr"  width="10%">SR Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust"  width="10%">WO Number<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust"  width="17%">Asset<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust"  width="8%">Status<span id="username_icon"></span></th>
        <th width = "10%">Department</th>
        <th width = "10%">Priority</th>
        <th width = "10%">Requested by</th>
        <th width = "10%">Requested Date</th>
        <!-- <th width = "5%">Aging</th> -->
        <th width = "5%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('service.table-srbrowse')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Service Request View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
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
                            <textarea id="srnote" type="text" class="form-control" name="srnote" autocomplete="off" autofocus readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="priority" class="col-md-5 col-form-label text-md-right">Priority</label>
                        <div class="col-md-6">
                            <input id="priority" type="text" name="priority" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rejectnote" class="col-md-5 col-form-label text-md-right">Reject Note</label>
                        <div class="col-md-6">
                          <textarea id="rejectnote" type="text" class="form-control" name="rejectnote" autocomplete="off" autofocus readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="englist" class="col-md-5 col-form-label text-md-right">Engineer List</label>
                        <div class="col-md-6">
                            <textarea id="englist" type="text" class="form-control" name="englist" rows="6" autocomplete="off" autofocus readonly></textarea>
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                    <!-- <button type="submit" class="btn btn-danger" name="action" value="reject" id="btnreject">Reject</button>
                    <button type="submit" class="btn btn-success" name="action" value="approve" id="btnapprove">Approve</button>  -->
                </div>
        </div>
    </div>
  </div>

@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $("#s_asset").select2({
      width : '100%',
      // placeholder : "Select Asset",
      theme : 'bootstrap4',
    });

    $("#s_user").select2({
      width : '100%',
      // placeholder : "Select User",
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
      // theme : 'bootstrap4'
    });

    function fetch_data(page, srnumber, asset, priority /*period*/, status, requestby) {
      $.ajax({
        url: "/srbrowse/searchsr?page=" + page + "&srnumber=" + srnumber + "&asset=" + asset + "&priority=" + priority + /* "&period=" + period + */ "&status=" + status + "&requestby=" + requestby,
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
    /*  var period = $('#s_period').val(); */
      var status = $('#s_status').val();
      var requestby = $('#s_user').val();

      // var column_name = $('#hidden_column_name').val();
      // var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      document.getElementById('tmpsrnumber').value  = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;
      /*document.getElementById('tmpperiod').value = period; */
      document.getElementById('tmpstatus').value = status;
      document.getElementById('tmpuser').value = requestby;

      fetch_data(page, srnumber, asset, priority /*period*/, status, requestby);
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
      /*var period = $('#tmpperiod').val();*/
      var status = $('#tmpstatus').val();
      var requestby = $('#tmpuser').val();
      
      fetch_data(page, srnumber, asset, priority /*period*/, status, requestby);
    });

    $(document).on('click', '#btnrefresh', function() {
      var srnumber  = ''; 
      var asset    = '';
      var priority = '';
      /*var period = ''; */
      var status = '';
      var requestby = '';
      var page = 1;

      document.getElementById('s_servicenbr').value     = '';
      document.getElementById('s_asset').value          = '';
      document.getElementById('s_priority').value = '';
      /*document.getElementById('s_period').value = '';*/
      document.getElementById('s_status').value = '';
      document.getElementById('s_user').value = '';
      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;
      /*document.getElementById('tmpperiod').value = period;*/
      document.getElementById('tmpstatus').value = status;
      document.getElementById('tmpuser').value = requestby

      fetch_data(page, srnumber, asset, priority /*period*/, status, requestby);

      $("#s_asset").select2({
        width : '100%',
        // placeholder : "Select Asset",
        theme : 'bootstrap4',
        asset,
      });

      $("#s_user").select2({
      width : '100%',
      // placeholder : "Select User",
      theme : 'bootstrap4',
      requestby,
    });

      
    });

    $(document).on('click', '.view', function() {

      $('#viewModal').modal('show');

      var srnumber = $(this).data('srnumber');
      var assetcode = $(this).data('assetcode');
      var assetdesc = $(this).data('assetdesc');
      var dept = $(this).data('dept');
      var assetloc = $(this).data('assetloc');
      var astype = $(this).data('astypedesc');
      var srnote = $(this).data('srnote');
      var reqby = $(this).data('reqby');
      var priority = $(this).data('priority');
      var rejectnote = $(this).data('rejectnote');
      var reqbyname = $(this).data('reqbyname');
      var wotype = $(this).data('wotypedesc');
      var impact = $(this).data('impactcode');
      

      var eng1 = $(this).data('eng1');
      var eng2 = $(this).data('eng2');
      var eng3 = $(this).data('eng3');
      var eng4 = $(this).data('eng4');
      var eng5 = $(this).data('eng5');

      var englist = eng1 + '\n' + eng2 + '\n' + eng3 + '\n' + eng4 + '\n' + eng5;

      console.log(englist);

      document.getElementById('englist').value = englist;

      // if(eng1 != ''){
      //   document.getElementById('engineer1').value = eng1;
      // }else{
      //   document.getElementById('engineer1').value = '-';
      // }

      // if(eng2 != ''){
      //   // alert('inul');
      //   document.getElementById('engineer2').value = eng2;
      // }else{
      //   // alert('kosong')
      //   document.getElementById('engineer2').value = '-';
      // }

      // if(eng3 != ''){
      //   document.getElementById('engineer3').value = eng3;
      // }else{
      //   document.getElementById('engineer3').value = '-';
      // }
      
      
      // if(eng4 != ''){
      //   document.getElementById('engineer4').value = eng4;
      // }else{
      //   document.getElementById('engineer4').value = '-';
      // }

      // if(eng5 != ''){
      //   document.getElementById('engineer5').value = eng5;
      // }else{
      //   document.getElementById('engineer5').value = '-';
      // }

      // alert(assetdesc);

      $.ajax({
          url: "/searchimpactdesc",
          data : {
            impact : impact,
          },
          success: function(data) {
            // console.log(data);

            var imp_desc = data;

            var desc = imp_desc.replaceAll(",", "\n");

            // console.log(desc);

            document.getElementById('impact').value =  desc;
            // }
                
          }   
      })

      document.getElementById('srnumber').value = srnumber;
      document.getElementById('assetcode').value = assetcode;
      document.getElementById('assetdesc').value = assetdesc;
      document.getElementById('dept').value = dept;
      document.getElementById('assetloc').value = assetloc;
      document.getElementById('assettype').value = astype;
      document.getElementById('wotype').value = wotype;
      
      document.getElementById('srnote').value = srnote;
      document.getElementById('hiddenreq').value = reqby;
      document.getElementById('priority').value = priority;
      document.getElementById('rejectnote').value = rejectnote;
      document.getElementById('reqbyname').value = reqbyname;

    });

    $(document).on('click', '#btnexcel', function() {
      var srnumber    = $('#tmpsrnumber').val(); 
      var srasset     = $('#tmpasset').val(); 
      var srstatus    = $('#tmpstatus').val(); 
      var srpriority  = $('#tmppriority').val(); 
      var srperiod    = $('#tmpperiod').val(); 
      var srreq       = $('#tmpuser').val(); 
      
      window.open("/donlodsr?srnumber=" + srnumber +"&asset="+srasset+"&status="+srstatus+"&priority="+srpriority+"&period="+srperiod+"&reqby="+srreq,'_blank');
    });
});


</script>
@endsection