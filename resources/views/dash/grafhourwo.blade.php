@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Work Order Browse</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>        
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
<label for="s_nomorwo" class="col-md-2 col-form-label text-md-left">{{ __('Work Order Number') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <input id="s_nomorwo" type="text" class="form-control"  name="s_nomorwo" value="" autofocus autocomplete="off">
  </div>
  <label for="s_asset" class="col-md-2 col-form-label text-md-right" >{{ __('Asset') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <select id="s_asset"  class="form-control" name="s_asset" autofocus autocomplete="off">
      <option value="">--Select Asset--</option>
      @foreach($asset as $assetsearch)
      <option value="{{$assetsearch->asset_code}}">{{$assetsearch->asset_desc}}</option>
      @endforeach
    </select>
  </div>
  <label for="s_status" class="col-md-2 col-form-label text-md-left">{{ __('Work Order Status') }}</label>
  <div class="col-md-3 col-sm-12 mb-2 input-group">
    <select id="s_status" type="text" class="form-control"  name="s_status">
    <option value="">--Select Status--</option>
    <option value="plan">Plan</option>
      <option value="open">Open</option>
      <option value="started">Started</option>
      <option value="finish">Finish</option>
      <option value="closed">Closed</option>
      <option value="delete">Delete</option>
      
    </select>
  </div>
  <label for="" class="col-md-1 col-form-label text-md-left">{{ __('') }}</label>
  <label for="s_createdate" class="col-md-2 col-form-label text-md-right">{{ __('WO Created Date') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <input type="month" id="s_createdate" name="s_createdate" value="{{$createdate}}">
  </div>
  <label for="s_tipewo" class="col-md-2 col-form-label text-md-left">{{ __('Work Order Type') }}</label>
  <div class="col-md-3 col-sm-12 mb-2 input-group">
    <select id="s_tipewo" type="text" class="form-control"  name="s_tipewo">
    <option value="">--Select Type--</option>
      <option value="WO" {{$tipewo === "WO" ? "selected" : ""}}>WO</option>
      <option value="PM" {{$tipewo === "PM" ? "selected" : ""}}>PM</option>
    </select>
  </div>
  <label for="s_period" class="col-md-3 col-sm-2 col-form-label text-md-right">{{ __('') }}</label>
  <div class="col-md-4 col-sm-4 mb-2 input-group">
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
<input type="hidden" id="tmpwo" value=""/>
<input type="hidden" id="tmpasset" value=''/>
<input type="hidden" id="tmpstatus" value=""/>
<input type="hidden" id="tmpcreatedate" value="{{$createdate}}"/>
<input type="hidden" id="tmptipewo" value="{{$tipewo}}"/>
<input type="hidden" id="counterfail">
<input type="hidden" id="counter">
<input type="hidden" id="grafwodesc" value="{{$desc}}"/>
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
                <th width="10%">WO Number</th>
                <th width="18%">Asset </th>
                <th width="10%">Schedule Date</th>    
                <th width="10%">Due Date</th>
                <th width="5%">Status</th>
                <th width="10%">Priority</th>
                <th width="10%">Requested by</th>
                <th width="10%">Created Date</th>
                <th width="10%">Finish Date</th>
                <th width="7%">Action</th>
            </tr>
        </thead>
        <tbody>
            @include('dash.table-grafhourwo')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>

<!--Modal View-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <input type="hidden" id="v_counter">
        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="v_nowo" class="col-md-2 col-form-label text-md-left">WO Number</label>
            <div class="col-md-3">
              <input id="v_nowo" type="text" class="form-control" name="v_nowo"  autocomplete="off" readonly autofocus>
            </div>
            <label for="v_nosr" class="col-md-2 col-form-label text-md-right">SR Number</label>
            <div class="col-md-3">
              <input id="v_nosr" type="text" class="form-control" name="v_nosr"  readonly autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vien1">
            <label for="v_engineer1" class="col-md-2 col-form-label text-md-left">Engineer</label>
            <div class="col-md-8">
              <input type='text' id="v_engineer1" class="form-control v_engineer1" name="v_engineer1"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_asset" class="col-md-2 col-form-label text-md-left">Asset</label>
            <div class="col-md-8">
              <input type="text" readonly id="v_asset" type="text" class="form-control v_asset" name="v_asset" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vdivfail1">
            <label for="v_failure1" class="col-md-2 col-form-label text-md-left">Failure</label>
            <div class="col-md-8">
              <textarea id="v_failure1" class="form-control v_failure1" autofocus readonly></textarea>
              <input type="hidden" name="v_failure1" id="vhiddenfail1">
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_schedule" class="col-md-2 col-form-label text-md-left">Schedule Date</label>
            <div class="col-md-3">
              <input id="v_schedule" readonly type="date" class="form-control" name="v_schedule" value="{{ old('v_schedule') }}"   autofocus>
            </div>
            <label for="v_duedate" class="col-md-2 col-form-label text-md-right">Due Date</label>
            <div class="col-md-3">
              <input id="v_duedate" type="date" class="form-control" name="v_duedate" value="{{ old('v_duedate') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_dept" class="col-md-2 col-form-label text-md-left">Department</label>
            <div class="col-md-8">
              <input  id="v_dept" readonly  class="form-control" name="v_dept" value="{{ old('v_dept') }}"  autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_creator" class="col-md-2 col-form-label text-md-left">Requested by</label>
            <div class="col-md-3">
              <input  id="v_creator" readonly  class="form-control" name="v_creator" value="{{ old('v_creator') }}"  autofocus>
            </div>
            <label for="v_priority" class="col-md-2 col-form-label text-md-right">Priority</label>
            <div class="col-md-3">
              <input id="v_priority" type="text" class="form-control" name="v_priority" value="{{ old('v_priority') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divviewcode" style="display: none;">
            <label for="v_repaircode" class="col-md-2 col-form-label text-md-left">Repair Code</label>
            <div class="col-md-8">
              <textarea id="v_repaircode" readonly  class="form-control" name="v_repaircode" value="{{ old('v_repaircode') }}"   autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divviewgroup" style="display: none;">
            <label for="v_repairgroup" class="col-md-2 col-form-label text-md-left">Repair Group</label>
            <div class="col-md-8">
              <input  id="v_repairgroup" readonly  class="form-control" name="v_repairgroup" value="{{ old('v_repairgroup') }}"  autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_note" class="col-md-2 col-form-label text-md-left">Note</label>
            <div class="col-md-8">
              <textarea id="v_note" readonly  class="form-control" name="v_note" value="{{ old('v_note') }}"   autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="reportnote" style="display: none;">
            <label for="v_reportnote" class="col-md-2 col-form-label text-md-left">Reporting Note</label>
            <div class="col-md-8">
            <textarea id="v_reportnote" class="form-control v_reportnote" name="v_reportnote" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divunconf" style="display: none;">
            <label for="v_unconfirm" class="col-md-2 col-form-label text-md-left">Uncompleted Reason</label>
            <div class="col-md-8">
              <textarea id="v_unconfirm" readonly  class="form-control" name="v_unconfirm" value="{{ old('v_unconfirm') }}"   autofocus></textarea>
            </div>
          </div>
        </div>
          
        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<!-- modal image -->
<div class="modal fade" id="imageModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Photo(s) Uploaded</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
        
          <div id="munculgambar">
          
          </div>
          
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
        </div>
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
<script type="text/javascript">

    $(document).on('click', '.viewwo', function() {
      $('#loadingtable').modal('show');
      
      var wonbr       = $(this).data('wonbr');
      var btnendel1   = document.getElementById("btndeleteen1");
      var btnendel2   = document.getElementById("btndeleteen2");
      var btnendel3   = document.getElementById("btndeleteen3");
      var btnendel4   = document.getElementById("btndeleteen4");
      var btnendel5   = document.getElementById("btndeleteen5");
      var counter     = document.getElementById('counter');
      var counterfail = document.getElementById('counterfail');
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
          var asset      = result[0].wo_asset;
          var assdesc    = result[0].asset_desc;
          var schedule   = result[0].wo_schedule;
          var duedate    = result[0].wo_duedate;
          var fc1        = result[0].wofc1;
          var fc2        = result[0].wofc2;
          var fc3        = result[0].wofc3;
          var fn1        = result[0].fd1;
          var fn2        = result[0].fd2;
          var fn3        = result[0].fd3;
          var rc1         = result[0].r11;
          var rc2         = result[0].r22;
          var rc3         = result[0].r33;
          var rd1         = result[0].rr11;
          var rd2         = result[0].rr22;
          var rd3         = result[0].rr33;
          var prio       = result[0].wo_priority;
          var note       = result[0].wo_note;
          var wodept     = result[0].dept_desc;
          var reason     = result[0].wo_reject_reason;
          var creator    = result[0].wo_creator;
          var apprnote   = result[0].wo_approval_note; 
          var repairtype  = result[0].wo_repair_type;
          var repairgroup = result[0].xxrepgroup_desc; 
          var finish      = result[0].wo_finish_date;  
          var arrrc       = [];
          
          if(rc1 != null){
            arrrc.push(rd1+' -- '+rc1);
          }
          if(rc2 != null){
            arrrc.push(rd2+' -- '+rc2);
          }
          if(rc3 != null){
            arrrc.push(rd3+' -- '+rc3);
          } 
        
          var nmeng = en1val;
          if(en2val != null && en2val != ''){
            nmeng = nmeng + ", " + en2val;
          }
          if(en3val != null && en3val != ''){
            nmeng = nmeng + ", " + en3val;
          }
          if(en4val != null && en4val != ''){
            nmeng = nmeng + ", " + en4val;
          }
          if(en5val != null && en5val != ''){
            nmeng = nmeng + ", " + en5val;
          }

          var nmfn = fc1 + ' -- ' + fn1;
          if(fc2 != null && fc2 != ''){
            nmfn = nmfn + "\n" + fc2 + ' -- ' + fn2;
          }
          if(fc3 != null && fc3 != ''){
            nmfn = nmfn + "\n" + fc3 + ' -- '+ fn3;
          }

          document.getElementById('counter').value      = counter;
          document.getElementById('v_nowo').value       = wonbr;
          document.getElementById('v_nosr').value       = srnbr;
          document.getElementById('v_schedule').value   = schedule;
          document.getElementById('v_duedate').value    = duedate;
          document.getElementById('v_finish').value    = finish;
          document.getElementById('v_engineer1').value  = nmeng;
          document.getElementById('v_asset').value      = asset+' -- '+assdesc;
          document.getElementById('v_failure1').value   = nmfn;
          document.getElementById('counterfail').value  = counterfail;
          document.getElementById('v_note').value       = note;
          document.getElementById('v_priority').value   = prio;
          document.getElementById('v_dept').value       = wodept;
          document.getElementById('v_unconfirm').value  = reason;
          document.getElementById('v_creator').value    = creator;
          if(repairtype == 'code'){
            var textareaview = document.getElementById('v_repaircode');
            textareaview.value = arrrc.join("\n");
            document.getElementById('divviewcode').style.display = '';
            document.getElementById('divviewgroup').style.display = 'none';
          }
          else if (repairtype == 'group'){
            
            var vgroup = document.getElementById('v_repairgroup').value = result[0].xxrepgroup_nbr + ' -- ' + repairgroup;
            document.getElementById('divviewcode').style.display = 'none';
            document.getElementById('divviewgroup').style.display = '';
          }
          else{
            document.getElementById('divviewcode').style.display = 'none';
            document.getElementById('divviewgroup').style.display = 'none';
          }
          if(reason != null){
            document.getElementById('divunconf').style.display = '';
          }
          else if (reason == null){
            document.getElementById('divunconf').style.display = 'none';
          }
          document.getElementById('v_reportnote').value    = apprnote;
          if(apprnote != null){
            document.getElementById('reportnote').style.display = '';
          }
          else if (apprnote == null){
            document.getElementById('reportnote').style.display = 'none';
          }
          
          $.ajax({
              url:"/getfinhour?wonbr="+wonbr,
              success:function(data){
                  console.log(data);
                  document.getElementById('v_hour').value    = data;
              }
          }) 

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
  // flag tunggu semua menu

    $('#s_asset').select2({
      width: '100%',
      theme: 'bootstrap4',
      placeholder: '--Select Asset--',
      
  function fetch_data(page, sort_type, sort_by, wonumber,woasset,wostatus,wocreatedate,tipewo) {
    var urlnow = document.getElementById('grafwodesc').value;

    $.ajax({
      url: "/datagrafhourwo/"+urlnow +"/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woasset=" + woasset + "&wostatus=" + wostatus + "&wocreatedate="+wocreatedate+"&tipewo="+tipewo,
      success: function(data) {
        console.log(data);
        $('tbody').html('');
        $('tbody').html(data);
      }
    })
  }

  $(document).on('click', '#btnsearch', function() {
    var wonumber    = $('#s_nomorwo').val(); 
    var woasset     = $("#s_asset").val();
    var wostatus    = $('#s_status').val(); 
    var wocreatedate  = $('#s_createdate').val(); 
    var tipewo    = $('#s_tipewo').val(); 

    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var page        = 1;
    
    document.getElementById('tmpwo').value        = wonumber;
    document.getElementById('tmpasset').value     = woasset;
    document.getElementById('tmpstatus').value    = wostatus;
    document.getElementById('tmpcreatedate').value  = wocreatedate;
    document.getElementById('tmptipewo').value    = tipewo;

    fetch_data(page, sort_type, column_name, wonumber,woasset,wostatus,wocreatedate,tipewo);
  });

  $(document).on('click', '#btnrefresh', function() {
    var wonumber    = ''; 
    var woasset     = '';
    var wostatus    = ''; 
    var wocreatedate  = ''; 
    var tipewo    = ''; 
    var desc          = 'reset'; 

    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var page        = 1;

    document.getElementById('s_nomorwo').value    = '';
    document.getElementById('s_asset').value      = '';
    document.getElementById('s_status').value     = '';
    document.getElementById('s_tipewo').value     = '';
    document.getElementById('s_createdate').value   = '';

    document.getElementById('tmpwo').value          = wonumber;
    document.getElementById('tmpasset').value       = woasset;
    document.getElementById('tmpstatus').value      = wostatus;
    document.getElementById('tmpcreatedate').value  = wocreatedate;
    document.getElementById('tmptipewo').value      = tipewo;
    document.getElementById('grafwodesc').value     = desc;

    
    $('#s_asset').select2({
      width:'100%',
      theme:'bootstrap4',
    });

    fetch_data(page, sort_type, column_name, wonumber,woasset,wostatus,wocreatedate,tipewo);
  });

  $(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    $('#hidden_page').val(page);
    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();

    var wonumber    = $('#tmpwo').val();
    var woasset       = $('#tmpasset').val();
    var wostatus      = $('#tmpstatus').val();
    var wocreatedate    = $('#tmpcreatedate').val();
    var tipewo      = $('#tmptipewo').val();

    fetch_data(page, sort_type, column_name, wonumber,woasset,wostatus,wocreatedate,tipewo);
  });

  $(document).on('click', '#btnexcel', function() {
    var wonumber      = $('#tmpwo').val();
    var woasset       = $('#tmpasset').val();
    var wostatus      = $('#tmpstatus').val();
    var wocreatedate  = $('#tmpcreatedate').val();
    var tipewo        = $('#tmptipewo').val();

    // alert(woasset);
    // document.getElementById('tmpwo').value        = wonumber;
    // document.getElementById('tmpasset').value     = woasset;
    // document.getElementById('tmpstatus').value    = wostatus;
    // document.getElementById('tmppriority').value  = wopriority;
    // document.getElementById('tmpengineer').value    = woengineer;

    window.open("/donlodwograf?wonumber=" + wonumber +"&asset="+woasset+"&status="+wostatus+"&wocreatedate="+wocreatedate+"&tipewo="+tipewo,'_blank');
  });

</script>
@endsection