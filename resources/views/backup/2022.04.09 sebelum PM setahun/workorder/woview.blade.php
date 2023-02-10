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
      <option value="{{$assetsearch->asset_code}}">{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
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
      <option value="completed">Completed</option>
      <option value="reprocess">Reprocess</option>
      <option value="incomplete">Incomplete</option>
      <option value="closed">Closed</option>
      <option value="delete">Delete</option>
      
      
    </select>
  </div>
  <label for="" class="col-md-1 col-form-label text-md-left">{{ __('') }}</label>
  <label for="s_creator" class="col-md-2 col-form-label text-md-right">{{ __('Requested by') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
  <select id="s_creator" type="text" class="form-control"  name="s_creator">
    <option value="">--Select user--</option>
    @foreach($custrnow as $custrnow)
    <option value="{{$custrnow->wo_creator}}"><b>{{$custrnow->wo_creator}} -- {{$custrnow->creator_desc}} </b></option>
    @endforeach
    </select>
  </div>
  <!-- <label for="s_priority" class="col-md-2 col-form-label text-md-right">{{ __('Priority') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <select id="s_priority" type="text" class="form-control"  name="s_priority">
    <option value="">--Select Priority--</option>
      <option value="low">Low</option>
      <option value="medium">Medium</option>
      <option value="high">High</option>
    </select>
  </div> -->
  <label for="s_engineer" class="col-md-2 col-form-label text-md-left">{{ __('Engineer') }}</label>
  <div class="col-md-3 col-sm-12 mb-2 input-group">
    <select id="s_engineer" type="text" class="form-control"  name="s_engineer">
      <option value="">--Select Engineer--</option>
        @foreach($engine as $enginesearch)
          <option value="{{$enginesearch->eng_code}}">{{$enginesearch->eng_code}} -- {{$enginesearch->eng_desc}}</option>
        @endforeach
    </select>
  </div>
  <label for="" class="col-md-1 col-form-label text-md-right">{{ __('') }}</label>
  <label for="s_typewo" class="col-md-2 col-form-label text-md-right">{{ __('Asset Group') }}</label>
  <div class="col-md-3 col-sm-12 mb-2 input-group">
    <select id="s_typewo" type="text" class="form-control"  name="s_typewo">
    <!-- <option value="">--Select Type--</option>
    <option value="WO">WO</option>
    <option value="PM">PM</option> -->
    <option value="">--Select Asset Group--</option>
    @foreach($asgroup as $asgroup)
    <option value="{{$asgroup->asgroup_code}}">{{$asgroup->asgroup_code}} -- {{$asgroup->asgroup_desc}}</option>
    @endforeach
    </select>
  </div>
  <label for="s_per1" class="col-md-2 col-form-label text-md-left">{{ __('Periode') }}</label>
  <div class="col-md-3 col-sm-12 mb-2 input-group">
    <input id="s_per1" type="date" class="form-control" name="s_per1">
  </div>
  <label for="" class="col-md-2 col-form-label text-center">{{ __(' s/d ') }}</label>
  <label for="s_per2" class="col-md-1 col-form-label text-md-right">{{ __('Periode') }}</label>
  <div class="col-md-3 col-sm-12 mb-2 input-group">
    <input id="s_per2" type="date" class="form-control" name="s_per2">
  </div>
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
<input type="hidden" id="tmpengineer" value=""/>
<input type="hidden" id="tmpcreator" value=""/>
<input type="hidden" id="tmpper1" value=""/>
<input type="hidden" id="tmpper2" value=""/>
<input type="hidden" id="tmpwotype" value=""/>

<div class="table-responsive col-12 mt-0 pt-0 align-top">
  <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0" style="width:100%;padding: .2rem !important;">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" style="cursor: pointer" width="10%">Work Order Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" style="cursor: pointer" width="10%">Asset<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="asset_desc" style="cursor: pointer" width="30%">Desc Asset<span id="username_icon"></span></th>
        <!-- <th class="sorting" data-sorting_type="asc" data-column_name="wo_schedule" style="cursor: pointer" width="10%">Schedule Date<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_duedate" style="cursor: pointer" width="10%">Due Date<span id="username_icon"></span></th> -->
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_status" style="cursor: pointer" width="10%">Status<span id="username_icon"></span></th>
        <!-- <th class="sorting" data-sorting_type="asc" data-column_name="wo_priority" style="cursor: pointer" width="6%">Priority</th> -->
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_type" style="cursor: pointer" width="5%">WO Type</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="asset_group" style="cursor: pointer" width="5%">Asset Group</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_created_at" style="cursor: pointer" width="10%">Requested Date</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_creator" style="cursor: pointer" width="10%">Requested by</th>
        <th width="10%">Action</th>
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
        <input type="hidden" id="v_counter" value=0>
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
          <div class="form-group row justify-content-center">
            <label for="v_creator" class="col-md-5 col-form-label text-md-left">Requested By</label>
            <div class="col-md-7">
              <input  id="v_creator" readonly  class="form-control" name="v_creator" value="{{ old('v_creator') }}"  autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <input  id="v_dept" readonly  class="form-control" name="v_dept" value="{{ old('v_dept') }}"  autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_asset" class="col-md-5 col-form-label text-md-left">Asset Code</label>
            <div class="col-md-7">
              <input type="text" readonly id="v_asset" type="text" class="form-control v_asset" name="v_asset" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_assetdesc" class="col-md-5 col-form-label text-md-left">Asset Desc</label>
            <div class="col-md-7">
              <input type="text" readonly id="v_assetdesc" type="text" class="form-control v_assetdesc" name="v_assetdesc" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_loc" class="col-md-5 col-form-label text-md-left">Location</label>
            <div class="col-md-7">
              <input id="v_loc" type="text" class="form-control" name="v_loc" value="{{ old('v_loc') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_proc" class="col-md-5 col-form-label text-md-left">Process / Technology</label>
            <div class="col-md-7">
              <input id="v_proc" type="text" class="form-control" name="v_proc" value="{{ old('v_proc') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_wottype" class="col-md-5 col-form-label text-md-left">Work Order Type</label>
            <div class="col-md-7">
              <input id="v_wottype" type="text" class="form-control" name="v_wottype" value="{{ old('v_wottype') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_impact" class="col-md-5 col-form-label text-md-left">Impact</label>
            <div class="col-md-7">
              <textarea id="v_impact" class="form-control" name="v_impact" value="{{ old('v_impact') }}"  autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
              <textarea id="v_note" readonly  class="form-control" name="v_note" value="{{ old('v_note') }}"   autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
            <div class="col-md-7">
              <input id="v_priority" type="text" class="form-control" name="v_priority" value="{{ old('v_priority') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_engineerl" class="col-md-5 col-form-label text-md-left">Engineer List</label>
            <div class="col-md-7">
              <textarea id="v_engineerl" class="form-control v_engineerl" name="v_engineerl"  autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="v_mtcby" class="col-md-5 col-form-label text-md-left">Maintenance By</label>
            <div class="col-md-7">
              <input id="v_mtcby" type="text" class="form-control" name="v_mtcby" readonly>
            </div>
          </div>
          <!--<div class="form-group row justify-content-center" id="divviewcode" style="display: none;">
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
          <div class="form-group row justify-content-center" id="divviewmanual" style="display: none;">
            <label for="v_repairmanual" class="col-md-5 col-form-label text-md-left">Repair</label>
            <div class="col-md-7">
              <input  id="v_repairmanual" readonly  class="form-control" name="v_repairmanual" value="Manual"  autofocus>
            </div>
          </div> -->
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
          <div class="form-group row justify-content-center" id="reportnote" >
            <label for="v_reportnote" class="col-md-5 col-form-label text-md-left">Reporting Note</label>
            <div class="col-md-7">
            <textarea id="v_reportnote" class="form-control v_reportnote" name="v_reportnote" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divunconf" style="display: none;">
            <label for="v_unconfirm" class="col-md-5 col-form-label text-md-left">Uncomplete reason</label>
            <div class="col-md-7">
              <textarea id="v_unconfirm" readonly  class="form-control" name="v_unconfirm" value="{{ old('v_unconfirm') }}"   autofocus></textarea>
            </div>
          </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
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
});

$('#s_engineer').select2({
  width: '100%',
  theme: 'bootstrap4',
});

$('#s_creator').select2({
  width: '100%',
  theme: 'bootstrap4',
});

$(document).on('click', '.viewwo', function() {
    $('#loadingtable').modal('show');
    
    var wonbr       = $(this).data('wonbr');
    var btnendel1   = document.getElementById("btndeleteen1");
    var btnendel2   = document.getElementById("btndeleteen2");
    var btnendel3   = document.getElementById("btndeleteen3");
    var btnendel4   = document.getElementById("btndeleteen4");
    var btnendel5   = document.getElementById("btndeleteen5");
    var counter     = document.getElementById('counter').value;
    var counterfail = document.getElementById('counterfail').value;
    $.ajax({
      url: '/womaint/getnowo?nomorwo=' +wonbr,
      success:function(vamp){
        var tempres     = JSON.stringify(vamp);
        var result      = JSON.parse(tempres);
        var wonbr       = result[0].wo_nbr;
        var srnbr       = result[0].wo_sr_nbr;
        var en1val      = result[0].u11;
        var en2val      = result[0].u22;
        var en3val      = result[0].u33;
        var en4val      = result[0].u44;
        var en5val      = result[0].u55;
        var asset       = result[0].wo_asset;
        var assdesc     = result[0].asset_desc;
        var schedule    = result[0].wo_schedule;
        var duedate     = result[0].wo_duedate;
        var fc1         = result[0].wofc1;
        var fc2         = result[0].wofc2;
        var fc3         = result[0].wofc3;
        var fn1         = result[0].fd1;
        var fn2         = result[0].fd2;
        var fn3         = result[0].fd3;
        var prio        = result[0].wo_priority;
        var note        = result[0].wo_note;
        var wodept      = result[0].dept_desc;
        var rc1         = result[0].r11;
        var rc2         = result[0].r22;
        var rc3         = result[0].r33;
        var rd1         = result[0].rr11;
        var rd2         = result[0].rr22;
        var rd3         = result[0].rr33;
        var reason      = result[0].wo_reject_reason;
        var creator     = result[0].wo_creator;
        var apprnote    = result[0].wo_approval_note;
        var repairtype  = result[0].wo_repair_type;
        var repairgroup = result[0].xxrepgroup_desc;
        var loccode     = result[0].loc_code;
        var locdesc     = result[0].loc_desc;
        var astypecode  = result[0].astype_code;
        var astypedesc  = result[0].astype_desc;
        var vimpact     = result[0].wo_impact;
        var vimpactdesc = result[0].wo_impact_desc;
        var vwottype    = result[0].wo_new_type + ' -- ' + result[0].wotyp_desc;
        var mtcby       = result[0].asset_daya;
        // console.log(rd1);
        // alert(vimpact);
        var strimp = '';
        if(vimpact != null && vimpactdesc != null){
          var arrimpact = vimpact.split(';');
          var arrimpactdesc = vimpactdesc.split(';');
          if(arrimpact.length != 0 && arrimpactdesc.length != 0){  
            for(var oo = 0; oo< (arrimpact.length-1);oo++){
              strimp += arrimpact[oo]+ ' -- ' + arrimpactdesc[oo]+'\n';
            }
          }
        }
        // alert(arrimpact[0]);
        
        // alert(strarr);
        // alert(arrimpact);
        var arreng = '';        
        if(en1val == null || en1val == ''){
          en1val = '';
        }
        else{
          arreng += en1val+'\n'; 
          counter = 1;
        }

        if(en2val == null || en2val ==''){
          en2val = '';
          
        }
        else{
          arreng += en2val+'\n';
          counter = 2;
        }
        if(en3val == null || en3val ==''){
          en3val = '';
          
        }
        else{
          arreng += en3val+'\n';
          counter = 3;
        }

        if(en4val == null || en4val ==''){
          en4val = '';
          
        }
        else{
          arreng += en4val+'\n';
          counter = 4;
        }

        if(en5val == null || en5val == ''){
          en5val = '';
          
        }
        else{
          arreng += en5val+'n';
          counter = 5;
        }
        
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

        if(astypecode == null) {
          astypecode = '';
        } else {
          astypecode = astypecode + ' -- ' + astypedesc;
        }

        if (loccode == null) {
          loccode = '';
        } else {
          loccode = loccode + ' -- ' + locdesc;
        }

        if (vwottype == 'null -- null') {
          vwottype = '';
        } else {
          vwottype = vwottype;
        }
        // alert(arrrc);
        document.getElementById('counter').value          = counter;
        document.getElementById('v_nowo').value           = wonbr;
        document.getElementById('v_nosr').value           = srnbr;
        document.getElementById('v_schedule').value       = schedule;
        document.getElementById('v_duedate').value        = duedate;
        document.getElementById('v_engineerl').innerHTML  = arreng;
        document.getElementById('v_impact').innerHTML     = strimp;
        document.getElementById('v_wottype').value        = vwottype;
        document.getElementById('v_asset').value          = asset;
        document.getElementById('v_assetdesc').value      = assdesc;
        document.getElementById('v_loc').value            = loccode;
        document.getElementById('v_proc').value           = astypecode;
        document.getElementById('counterfail').value      = counterfail;
        document.getElementById('v_priority').value       = prio;
        document.getElementById('v_note').value           = note;
        document.getElementById('v_dept').value           = wodept;
        document.getElementById('v_creator').value        = creator;
        document.getElementById('v_unconfirm').value      = reason;
        document.getElementById('v_mtcby').value          = mtcby;
        
        /*
        if(repairtype == 'code'){
          var textareaview = document.getElementById('v_repaircode');
          textareaview.value = arrrc.join("\n");
          document.getElementById('divviewcode').style.display = '';
          document.getElementById('divviewgroup').style.display = 'none';
          document.getElementById('divviewmanual').style.display='none';
        }
        else if (repairtype == 'group'){
          
          var vgroup = document.getElementById('v_repairgroup').value = result[0].xxrepgroup_nbr + ' -- ' + repairgroup;
          document.getElementById('divviewcode').style.display = 'none';
          document.getElementById('divviewmanual').style.display='none';
          document.getElementById('divviewgroup').style.display = '';
        }
        else if (repairtype == 'manual'){
          document.getElementById('divviewcode').style.display = 'none';
          document.getElementById('divviewgroup').style.display = 'none';
          document.getElementById('divviewmanual').style.display='';
        }
        else{
          document.getElementById('divviewcode').style.display = 'none';
          document.getElementById('divviewgroup').style.display = 'none';
          document.getElementById('divviewmanual').style.display='none';
        } */
        if(reason != null){
          document.getElementById('divunconf').style.display = '';
        }
        else if (reason == null){
          document.getElementById('divunconf').style.display = 'none';
        }
        document.getElementById('v_reportnote').value    = apprnote;
      },
        
      complete: function(vamp){
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));
        
          setTimeout(function(){
            $('#loadingtable').modal('hide');
          },500);
        
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

  function fetch_data(page, sort_type, sort_by, wonumber, woasset, wostatus,woengineer,wocreator,woper1,woper2,wotype) {
    $.ajax({
      url: "/wobrowse/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woasset=" + woasset + "&wostatus=" + wostatus + "&woengineer=" + woengineer + "&wocreator=" + wocreator + "&woper1=" + woper1 + "&woper2=" + woper2 + "&wotype=" + wotype ,
      success: function(data) {
        // alert(data);
        // alert(url);
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
    //var wopriority  = $('#s_priority').val(); 
    var woengineer  = $('#s_engineer').val(); 
    var wocreator   = $('#s_creator').val(); 
    var woper1      = $('#s_per1').val();
    var woper2      = $('#s_per2').val();
    var wotype      = $('#s_typewo').val();

    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var page        = 1;
    // alert(wocreator);
    document.getElementById('tmpwo').value        = wonumber;
    document.getElementById('tmpasset').value     = woasset;
    document.getElementById('tmpstatus').value    = wostatus;
    //document.getElementById('tmppriority').value  = wopriority;
    document.getElementById('tmpengineer').value  = woengineer;
    document.getElementById('tmpcreator').value   = wocreator;
    document.getElementById('tmpper1').value      = woper1;
    document.getElementById('tmpper2').value      = woper2;
    document.getElementById('tmpwotype').value    = wotype
    // alert(document.getElementById('tmpcreator').value);
    fetch_data(page, sort_type, column_name, wonumber, woasset,wostatus,woengineer,wocreator,woper1,woper2,wotype);
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
    //var priority = $('#s_priority').val();
    var engineer = $('#s_engineer').val();
    var creator  = $('#s_creator').val();
    var woper1   = $('#s_per1').val();
    var woper2   = $('#s_per2').val();
    var wotype   = $('#s_typewo').val();
   
    fetch_data(page, reverse_order, column_name, wonumber, assert,status,engineer,creator,woper1,woper2,wotype);
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
    var engineer    = $('#tmpengineer').val();
    var creator     = $('#tmpcreator').val();
    var woper1      = $('#tmpper1').val();
    var woper2      = $('#tmpper2').val();
    var wotype      = $('#tmpwotype').val();

    fetch_data(page, sort_type, column_name, wonumber, asset,status,engineer,creator,woper1,woper2,wotype);
  });

  $(document).on('click', '#btnrefresh', function() {
    var wonumber    = ''; 
    var asset       = ''; 
    var status      = '';
    var engineer    = '';
    var priority    = '';
    var creator     = '';
    var woper1      = '';
    var woper2      = '';
    var wotype      = '';

    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var page        = 1;

    document.getElementById('s_nomorwo').value    = '';
    document.getElementById('s_asset').value      = '';
    document.getElementById('s_status').value     = '';
    document.getElementById('s_engineer').value   = '';
    //document.getElementById('s_priority').value   = '';
    document.getElementById('s_creator').value    = '';
    document.getElementById('s_per1').value       = '';
    document.getElementById('s_per2').value       = '';
    document.getElementById('s_typewo').value     = '';

    document.getElementById('tmpwo').value        = '';
    document.getElementById('tmpasset').value     = '';
    document.getElementById('tmpstatus').value    = '';
    //document.getElementById('tmppriority').value  = '';
    document.getElementById('tmpengineer').value  = '';
    document.getElementById('tmpcreator').value   = '';
    document.getElementById('tmpper1').value      = '';
    document.getElementById('tmpper2').value      = '';
    document.getElementById('tmpwotype').value    = '';

    $('#s_asset').select2({
      width:'100%',
      theme:'bootstrap4',
      asset
    })
    fetch_data(page, sort_type, column_name, wonumber, asset,status,engineer,creator,woper1,woper2,wotype);
  });

  $(document).on('click', '#btnexcel', function() {
    var wonumber    = $('#tmpwo').val(); 
    var woasset     = $('#tmpasset').val(); 
    var wostatus    = $('#tmpstatus').val(); 
    var wopriority  = $('#tmppriority').val(); 
    var woengineer  = $('#tmpengineer').val(); 
    var wocreator   = $('#tmpcreator').val();
    var woper1      = $('#tmpper1').val();
    var woper2      = $('#tmpper2').val();
    var wotype      = $('#tmpwotype').val();
    // alert(woasset);
    // document.getElementById('tmpwo').value        = wonumber;
    // document.getElementById('tmpasset').value     = woasset;
    // document.getElementById('tmpstatus').value    = wostatus;
    // document.getElementById('tmppriority').value  = wopriority;
    // document.getElementById('tmpengineer').value    = woengineer;

    window.open("/donlodwo?wonumber=" + wonumber +"&asset="+woasset+"&status="+wostatus+"&priority="+wopriority+"&engineer="+woengineer+"&creator"+wocreator+ "&woper1=" + woper1 + "&woper2=" + woper2 + 
      "&wotype=" + wotype,'_blank');
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