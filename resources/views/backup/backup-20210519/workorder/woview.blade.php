@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Browse</h1>
          </div><!-- /.col -->
          <div class="col-sm-3">
          
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->
<style>
div #munculgambar .gambar{
  margin: 5px;
  border: 2px solid grey;
  border-radius: 5px;
}

div #munculgambar .gambar:hover{
  /* margin: 5px; */
  border: 2px solid red;
  border-radius: 5px;
}

</style>
<!--Table Menu-->

<!-- <hr style="margin:0%"> -->
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
  <label for="s_nomorwo" class="col-md-2 col-form-label text-md-left">{{ __('Work Order Number') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <input id="s_nomorwo" type="text" class="form-control"  name="s_nomorwo" value="" autofocus autocomplete="off">
  </div>
  <label for="s_asset" class="col-md-2 col-form-label text-md-right" >{{ __('Asset') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <select id="s_asset"  class="form-control" style="color:white" name="s_asset" autofocus autocomplete="off">
      <option value="">--Select Asset--</option>
      @foreach($asset1 as $assetsearch)
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
  <label for="s_priority" class="col-md-2 col-form-label text-md-right">{{ __('Priority') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <select id="s_priority" type="text" class="form-control"  name="s_priority">
    <option value="">--Select Priority--</option>
      <option value="low">Low</option>
      <option value="medium">Medium</option>
      <option value="high">High</option>
    </select>
  </div>
  <label for="s_period" class="col-md-2 col-form-label text-md-left">{{ __('Work Order Period') }}</label>
  <div class="col-md-3 col-sm-12 mb-2 input-group">
    <select id="s_period" type="text" class="form-control"  name="s_period">
    <option value="">--Select Period--</option>
      <option value="1">< 3 Days </option>
      <option value="2">3-5 Days</option>
      <option value="3">> 5 Days</option>
    </select>
  </div>
  <label for="" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" style="float:right" />
  </div>
  <div class="col-md-1 col-sm-12 mb-2 input-group justify-content-center">
    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' ><i class="fas fa-sync-alt"></i></button>
  </div>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <input type="button" class="btn btn-block btn-primary" id="btnexcel" value="Export to Excel" style="float:right" />
  </div>
</div>
</li>
</ul>
</li>
</ul>
</div>
<input type="hidden" id="tmpwo" value=""/>
<input type="hidden" id="tmpasset" value=""/>
<input type="hidden" id="tmpstatus" value=""/>
<input type="hidden" id="tmppriority" value=""/>
<input type="hidden" id="tmpperiod" value=""/>

<div class="table-responsive col-12 mt-0 pt-0 align-top">
  <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0" style="width:100%;padding: .2rem !important;">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" style="cursor: pointer" width="8%">Work Order Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" style="cursor: pointer" width="15%">Asset<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_schedule" style="cursor: pointer" width="8%">Schedule Date<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_duedate" style="cursor: pointer" width="8%">Due Date<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_status" style="cursor: pointer" width="8%">Status<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_priority" style="cursor: pointer" width="8%">Priority</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_priority" style="cursor: pointer" width="8%">Requested by</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_priority" style="cursor: pointer" width="8%">Created At</th>
        <th width="8%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('workorder.table-woview')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>
<input type="hidden" id="counterfail">
<input type="hidden" id="counter">
<!--Modal View-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
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
            <label for="v_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
              <input id="v_nowo" type="text" class="form-control" name="v_nowo"  autocomplete="off" readonly autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_nosr" class="col-md-5 col-form-label text-md-left">Service Request Number</label>
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
          <div class="form-group row justify-content-center" id="vdivfail1" style="display:none">
            <label for="v_failure1" class="col-md-5 col-form-label text-md-left">Failure 1</label>
            <div class="col-md-7">
              <input id="v_failure1" class="form-control v_failure1" autofocus readonly>
              <input type="hidden" name="v_failure1" id="vhiddenfail1">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vdivfail2" style="display:none">
            <label for="v_failure2" class="col-md-5 col-form-label text-md-left">Failure 2</label>
            <div class="col-md-7">
              <input id="v_failure2" class="form-control v_failure2"  autofocus readonly>
              <input type="hidden" name="v_failure2" id="vhiddenfail2">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vdivfail3" style="display:none">
            <label for="v_failure3" class="col-md-5 col-form-label text-md-left">Failure 3</label>
            <div class="col-md-7">
              <input id="v_failure3" class="form-control v_failure3"  autofocus readonly>
              <input type="hidden" name="v_failure3" id="vhiddenfail3">
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
              <input id="v_duedate" type="date" class="form-control" name="v_duedate" value="{{ old('v_duedate') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <input  id="v_dept" readonly  class="form-control" name="v_dept" value="{{ old('v_dept') }}"  autofocus>
            </div>
          </div>
          
          <div class="form-group row justify-content-center">
            <label for="v_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
            <div class="col-md-7">
              <input id="v_priority" type="text" class="form-control" name="v_priority" value="{{ old('v_priority') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_creator" class="col-md-5 col-form-label text-md-left">Requested by</label>
            <div class="col-md-7">
              <input  id="v_creator" readonly  class="form-control" name="v_creator" value="{{ old('v_creator') }}"  autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divviewcode" style="display: none;">
            <label for="v_repaircode" class="col-md-5 col-form-label text-md-left">Repair Code</label>
            <div class="col-md-7">
              <textarea id="v_repaircode" readonly  class="form-control" name="v_repaircode" value="{{ old('v_repaircode') }}"   autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divviewgroup" style="display: none;">
            <label for="v_repairgroup" class="col-md-5 col-form-label text-md-left">Repair Group</label>
            <div class="col-md-7">
              <input  id="v_repairgroup" readonly  class="form-control" name="v_repairgroup" value="{{ old('v_repairgroup') }}"  autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
              <textarea id="v_note" readonly  class="form-control" name="v_note" value="{{ old('v_note') }}"   autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="reportnote" style="display: none;">
            <label for="v_reportnote" class="col-md-5 col-form-label text-md-left">Reporting Note</label>
            <div class="col-md-7">
            <textarea id="v_reportnote" class="form-control v_reportnote" name="v_reportnote" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divunconf" style="display: none;">
            <label for="v_unconfirm" class="col-md-5 col-form-label text-md-left">Uncompleted Reason</label>
            <div class="col-md-7">
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
<script>

$('#s_asset').select2({
  width: '100%',
  theme: 'bootstrap4',
  placeholder: '--Select Asset--',
  
});


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
        var arrrc= [];
        
        if(rc1 != null){
          arrrc.push(rd1+' -- '+rc1);
        }
        if(rc2 != null){
          arrrc.push(rd2+' -- '+rc2);
        }
        if(rc3 != null){
          arrrc.push(rd3+' -- '+rc3);
        } 
        if(fc1 == null || fc1 == ''){
          document.getElementById('vdivfail1').style.display = 'none';
        }
        else{
          document.getElementById('vdivfail1').style.display = '';
          document.getElementById('v_failure1').value = fn1;
          document.getElementById('vhiddenfail1').value = fc1;
          counterfail = 1;
        }
          
        if(fc2 == null || fc2 == '' ){
          document.getElementById('vdivfail2').style.display = 'none';
        }  
        else{
            document.getElementById('vdivfail2').style.display = '';
            document.getElementById('v_failure2').value = fn2;
            document.getElementById('vhiddenfail2').value = fc2;
            counterfail = 2;
        }
            
        if(fc3 == null || fc3 == ''){
          document.getElementById('vdivfail3').style.display = 'none';
        }
        else{
          document.getElementById('vdivfail3').style.display = '';
          document.getElementById('v_failure3').value = fn3;
          document.getElementById('vhiddenfail3').value = fc3;
          counterfail = 3;
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

        document.getElementById('counter').value      = counter;
        document.getElementById('v_nowo').value       = wonbr;
        document.getElementById('v_nosr').value       = srnbr;
        document.getElementById('v_schedule').value   = schedule;
        document.getElementById('v_duedate').value    = duedate;
        document.getElementById('v_engineer1').value  = en1val;
        document.getElementById('v_engineer2').value  = en2val;
        document.getElementById('v_engineer3').value  = en3val;
        document.getElementById('v_engineer4').value  = en4val;
        document.getElementById('v_engineer5').value  = en5val;
        document.getElementById('v_asset').value      = asset+' -- '+assdesc;
        document.getElementById('v_failure1').value   = fc1+' -- '+fn1;
        document.getElementById('v_failure2').value   = fc2+' -- '+fn2;
        document.getElementById('v_failure3').value   = fc3+' -- '+fn3;
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
        
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));
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



  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function fetch_data(page, sort_type, sort_by, wonumber, woasset, wostatus,wopriority,woperiod) {
    $.ajax({
      url: "/wobrowse/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woasset=" + woasset+ "&wostatus=" + wostatus + "&wopriority="+wopriority+"&woperiod="+woperiod,
      success: function(data) {
        console.log(data);
        $('tbody').html('');
        $('tbody').html(data);
      }
    })
  }

  $(document).on('click', '#btnsearch', function() {
    var wonumber    = $('#s_nomorwo').val(); 
    var woasset     = $('#s_asset').val(); 
    var wostatus    = $('#s_status').val(); 
    var wopriority  = $('#s_priority').val(); 
    var woperiod    = $('#s_period').val(); 
    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var page        = 1;
    
    document.getElementById('tmpwo').value        = wonumber;
    document.getElementById('tmpasset').value     = woasset;
    document.getElementById('tmpstatus').value    = wostatus;
    document.getElementById('tmppriority').value  = wopriority;
    document.getElementById('tmpperiod').value    = woperiod;

    fetch_data(page, sort_type, column_name, wonumber, woasset,wostatus,wopriority,woperiod);
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
    var assert   = $('#s_asset').val();
    var status   = $('#s_status').val();
    var priority = $('#s_priority').val();
    var period   = $('#s_period').val();
    fetch_data(page, reverse_order, column_name, username, divisi);
  });

  
  $(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    $('#hidden_page').val(page);
    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var wonumber    = $('#tmpwo').val();
    var asset       = $('#tmpasset').val();
    var status      = $('#tmpstatus').val();
    var priority    = $('#tmppriority').val();
    var period      = $('#tmpperiod').val();
    fetch_data(page, sort_type, column_name, wonumber, asset,status,priority,period);
  });

  $(document).on('click', '#btnrefresh', function() {
    var wonumber    = ''; 
    var asset       = ''; 
    var status      = '';
    var period      = '';
    var priority    = '';
    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var page        = 1;

    document.getElementById('s_nomorwo').value    = '';
    document.getElementById('s_asset').value      = '';
    document.getElementById('s_status').value     = '';
    document.getElementById('s_period').value     = '';
    document.getElementById('s_priority').value   = '';
    document.getElementById('tmpwo').value        = '';
    document.getElementById('tmpasset').value     = '';
    document.getElementById('tmpstatus').value    = '';
    document.getElementById('tmppriority').value  = '';
    document.getElementById('tmpperiod').value    = '';
    
    $('#s_asset').select2({
      width:'100%',
      theme:'bootstrap4',
      asset
    })
    fetch_data(page, sort_type, column_name, wonumber, asset,status,priority,period);
  });

  $(document).on('click', '#btnexcel', function() {
    var wonumber    = $('#tmpwo').val(); 
    var woasset     = $('#tmpasset').val(); 
    var wostatus    = $('#tmpstatus').val(); 
    var wopriority  = $('#tmppriority').val(); 
    var woperiod    = $('#tmpperiod').val(); 
    // alert(woasset);
    // document.getElementById('tmpwo').value        = wonumber;
    // document.getElementById('tmpasset').value     = woasset;
    // document.getElementById('tmpstatus').value    = wostatus;
    // document.getElementById('tmppriority').value  = wopriority;
    // document.getElementById('tmpperiod').value    = woperiod;

    window.open("/donlodwo?wonumber=" + wonumber +"&asset="+woasset+"&status="+wostatus+"&priority="+wopriority+"&period="+woperiod,'_blank');
  });

  $(document).on('click', '.imageview', function(){
    $('#imageModal').modal('show');
    var wonumber = $(this).data('wonbr');

    $.ajax({
      url: "/imageview",
      data : {
          wonumber: wonumber,
      },success: function(data){
        console.log(data);

        var totalgambar = data.length;

        console.log(totalgambar);

        var url_gambar = [];
        var test = [];
        for(var i = 0; i < totalgambar; i++){
          url_gambar.push(data[i].file_url);
          var pisah = url_gambar[i];

          var pisah2 = pisah.split("/");

          var gabungurl = pisah2[2]+'/'+pisah2[3];  

          // alert(src);
          test += '<a target="_blank" href="'+gabungurl+'"><img class="gambar" src="' + gabungurl + '" width="200" height="200"></a>';

        }

        $('#munculgambar').html('').append(test);
      }
    })
  });

</script>
@endsection