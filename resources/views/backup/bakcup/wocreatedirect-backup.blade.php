@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Direct Create</h1>
          </div><!-- /.col -->
          <div class="col-sm-3">
          <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">
          Work Order Create</button>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->

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
    <select id="s_asset"  class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
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
    @if($usernow[0]->approver == 1)
      <option value="plan">Plan</option>
      @endif
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
  <label for="" class="col-md-3 col-form-label text-md-right">{{ __('') }}</label>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" style="float:right" />
  </div>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
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
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" style="cursor: pointer" width="12%">Work Order Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" style="cursor: pointer" width="15%">Asset<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_schedule" style="cursor: pointer" width="12%">Schedule Date<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_duedate" style="cursor: pointer" width="12%">Due Date<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_status" style="cursor: pointer" width="12%">Status<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_priority" style="cursor: pointer" width="10%">Priority</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_priority" style="cursor: pointer" width="12%">Created At</th>
        <th width="15%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('workorder.table-wocreatedirect')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>

<!--Modal Create-->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="new" method="post" action="createdirectwo" autocomplete="off">
          {{ csrf_field() }}
          <div class="form-group row col-md-12 c_engineerdiv">
            <label for="c_engineer" class="col-md-5 col-form-label text-md-left">Engineer</label>
            <div class="col-md-7">
              <input type="text" id="c_engineer"  class="form-control c_engineer" value="{{Session::get('name')}}"  readonly>
              <input type="hidden" id="engineercreate"  class="form-control engineercreate" name="engineercreate" value="{{Session::get('username')}}" >
            </div>
          </div>
          
          <div class="form-group row col-md-12">
            <label for="c_asset" class="col-md-5 col-form-label text-md-left">Asset <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
            <select id="c_asset" type="text" class="form-control c_asset" name="c_asset" autofocus required>
                <option value="">--Select Asset--</option>
                @foreach ($asset2 as $asset2)
                  <option value="{{$asset2->asset_code}}">{{$assetsearch->asset_code}} -- {{$asset2->asset_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12 c_failurediv" id="c_faildiv" style="display: none;">
            <label for="c_failurenum" class="col-md-5 col-form-label text-md-left">Total Failure Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="c_failurenum"  class="form-control c_failurenum" name="c_failurenum"  autofocus required>
                <option value="" disabled selected>Select Failure Code</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </div>
          </div>
          <div id="failurediv">
          
          </div>
          <div class="form-group row col-md-12">
            <label for="c_schedule" class="col-md-5 col-form-label text-md-left">Schedule Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input type="date" id="c_schedule"  class="form-control" name="c_schedule" value="{{ old('scheduledate') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_duedate" class="col-md-5 col-form-label text-md-left">Due Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input type="date" id="c_duedate"  class="form-control" name="c_duedate" value="{{ old('duedate') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <!-- <div class="form-group row col-md-12 c_departmentdiv">
            <label for="c_department" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <select id="c_department"  class="form-control c_department" name="c_department"  autofocus required>
              <option value="" disabled selected>Select Department</option>
                @foreach ($dept as $cdept)
                <option value="{{$cdept->dept_code}}">{{$cdept->dept_desc}}</option>
                @endforeach
              </select>
            </div>
          </div> -->
          <div class="form-group row col-md-12">
            <label for="c_priority" class="col-md-5 col-form-label text-md-left">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="c_priority"  class="form-control" name="c_priority"  autocomplete="off" autofocus required placeholder=>
                <option value='' disabled selected>--select priority--</option>
                <option value='low'>Low</option>
                <option value='medium'>Medium</option>
                <option value='high'>High</option>
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
            <textarea id="c_note" class="form-control c_note" name="c_note" autofocus></textarea>
            </div>
          </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
        <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
          <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
        </button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--Modal Edit-->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="newedit" method="post" action="editwodirect">
        {{ csrf_field() }}
        <input type="hidden" id="counter">
        <input type="hidden" id="counterfail">
        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="e_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
              <input id="e_nowo" type="text" class="form-control" name="e_nowo"  autocomplete="off" maxlength="6" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_nosr" class="col-md-5 col-form-label text-md-left">Service Request Number</label>
            <div class="col-md-7">
              <input id="e_nosr" type="text" class="form-control" name="e_nosr" readonly >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="diven1" >
            <label for="e_engineer1" class="col-md-5 col-form-label text-md-left">Engineer</label>
            <div class="col-md-7">
              <input type="text" id="e_engineer1" class="form-control e_engineer1"  autofocus readonly>
              <input type="hidden" id="e_engineerval" class="form-control e_engineerval" name="e_engineerval" autofocus readonly>
      
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
              <input id="e_asset" type="text" class="form-control e_asset" name="e_asset" readonly>
              
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail1" style="display:none">
            <label for="e_failure1" class="col-md-5 col-form-label text-md-left">Failure Code 1 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="e_failure1" name="e_failure1" class="form-control e_failure1"  >
              @foreach ($failure as $failure1)
                <option value="{{$failure1->fn_code}}">{{$failure1->fn_code}} -- {{$failure1->fn_desc}}</option>
              @endforeach
              </select>
              <!-- <input type="hidden" name="e_failure1" id="hiddenfail1"> -->
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail2" style="display:none">
            <label for="e_failure2" class="col-md-5 col-form-label text-md-left">Failure Code 2</label>
            <div class="col-md-7">
              <select id="e_failure2" name="e_failure2" class="form-control e_failure2" >
              @foreach ($failure as $failure2)
                <option value="{{$failure2->fn_code}}">{{$failure2->fn_code}} -- {{$failure2->fn_desc}}</option>
              @endforeach
              </select>
              <!-- <input type="hidden" name="e_failure2" id="hiddenfail2"> -->
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail3" style="display:none">
            <label for="e_failure3" class="col-md-5 col-form-label text-md-left">Failure Code 3</label>
            <div class="col-md-7">
              <select id="e_failure3" name="e_failure3" class="form-control e_failure3" >
              @foreach ($failure as $failure3)
                <option value="{{$failure3->fn_code}}">{{$failure3->fn_code}} -- {{$failure3->fn_desc}}</option>
              @endforeach
              </select>
              <input type="hidden" name="e_failure3" id="hiddenfail3">
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_schedule" class="col-md-5 col-form-label text-md-left">Schedule Date</label>
            <div class="col-md-7">
              <input id="e_schedule" type="date" class="form-control" name="e_schedule" value="{{ old('e_schedule') }}"   autofocus required>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_duedate" class="col-md-5 col-form-label text-md-left">Due Date</label>
            <div class="col-md-7">
              <input id="e_duedate" type="date" class="form-control" name="e_duedate" value="{{ old('e_duedate') }}"  autofocus required>
            </div>
          </div>
          <!-- <div class="form-group row justify-content-center">
            <label for="e_department" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <select id="e_department"  class="form-control e_department" name="e_department"  autofocus required>
              <option value="" disabled selected>Select Department</option>
                @foreach ($dept as $edept)
                <option value="{{$edept->dept_code}}">{{$edept->dept_desc}}</option>
                @endforeach
              </select>
            </div>
          </div> -->
          <div class="form-group row justify-content-center">
            <label for="e_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
            <div class="col-md-7">
              <select id="e_priority"  class="form-control" name="e_priority" autofocus required>
                <option value='low'>Low</option>
                <option value='medium'>Medium</option>
                <option value='high'>High</option>
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
            <textarea id="e_note" class="form-control e_note" name="e_note" autofocus></textarea>
            </div>
          </div>         
          
          
          <div class="modal-footer">
            
            <button type="button" class="btn btn-warning bt-action mr-auto e_btnaddfai"  id="e_addfai" ><b>Add Failure Code</b></button>
            <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success bt-action" id="e_btnconf">Save</button>
            <button type="button" class="btn btn-block btn-info" id="e_btnloading" style="display:none">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


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
            <label for="v_failure1" class="col-md-5 col-form-label text-md-left">Failure Code 1</label>
            <div class="col-md-7">
              <input id="v_failure1" class="form-control v_failure1" autofocus readonly>
              <input type="hidden" name="v_failure1" id="vhiddenfail1">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vdivfail2" style="display:none">
            <label for="v_failure2" class="col-md-5 col-form-label text-md-left">Failure Code 2</label>
            <div class="col-md-7">
              <input id="v_failure2" class="form-control v_failure2"  autofocus readonly>
              <input type="hidden" name="v_failure2" id="vhiddenfail2">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="vdivfail3" style="display:none">
            <label for="v_failure3" class="col-md-5 col-form-label text-md-left">Failure Code 3</label>
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
            <label for="v_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
            <textarea id="v_note" class="form-control v_note" name="v_note" readonly autofocus></textarea>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
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

$('#s_asset').select2({
  width: '100%',
  theme: 'bootstrap4',
  placeholder: '--Select Asset--',
  
});
$('#c_department').select2({
  width: '100%',
  theme: 'bootstrap4',
  placeholder: '--Select Department--'
})
$(document).on('click','#a_btnapprove',function(){
  document.getElementById('a_btnapprove').style.display='none';
  document.getElementById('a_btnreject').style.display='none';
  document.getElementById('a_btnclose').style.display='none';
  document.getElementById('a_btnloading').style.display='';  
  document.getElementById('a_closeapprove').style.display='none';  
})
$(document).on('click','#a_btnreject',function(){
  document.getElementById('a_btnapprove').style.display='none';
  document.getElementById('a_btnreject').style.display='none';
  document.getElementById('a_btnclose').style.display='none';
  document.getElementById('a_btnloading').style.display='';  
  document.getElementById('a_closeapprove').style.display='none';  
})
$('#e_failure1').select2({
  theme: 'bootstrap4',
  width:'100%',
});

$('#e_failure2').select2({
  theme: 'bootstrap4',
  width:'100%',      
});

$('#e_failure3').select2({
  theme: 'bootstrap4',
  width:'100%',          
});


$('.c_asset').select2({
    placeholder: "Select Asset",
    width:'100%',
    theme: 'bootstrap4',
  });
  
$("#new").submit(function(e) {
    var engarr = [];
    var failarr = [];    
    var failure = document.getElementsByName('c_failure[]');
    var engineer = document.getElementsByName('c_engineer[]');
    var engineerlength = engineer.length;
    var failurelength = failure.length;
    for(var i = 0; i< failurelength; i++){
      var failurenow = document.getElementsByName('c_failure[]')[i].value;
      if(failurenow != ''){
        failarr.push(failurenow);
      }
    }
    for(var k = 0; k< engineerlength; k++){
      var engineernow = document.getElementsByName('c_engineer[]')[k].value;
      if(engineernow != ''){
        engarr.push(engineernow);
      }
    }
    const counteng = {};
    const countfail = {};
    failarr.forEach(function (item, index) {
      if (countfail[failarr[index]]) {
        countfail[failarr[index]] += 1;
      } else {
        countfail[failarr[index]] = 1;
      }
    });
    engarr.forEach(function (item, index) {
      if (counteng[engarr[index]]) {
        counteng[engarr[index]] += 1;
      } else {
        counteng[engarr[index]] = 1;
      }
    });
    const duplfail = Object.values(countfail).filter(x => x != 1);
    const dupleng = Object.values(counteng).filter(y => y != 1);
    if(duplfail.length > 0){
      // eksekusi jika duplikat
      swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Failure Code Duplicate',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
      e.preventDefault();
    }
    if(dupleng.length > 0){
      // eksekusi jika duplikat
      swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Engineer Duplicate',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
      e.preventDefault();
    }
    if(duplfail <= 0 && dupleng <=0){
      document.getElementById('btnclose').style.display = 'none';
      document.getElementById('btnconf').style.display = 'none';
      document.getElementById('btnloading').style.display = '';
    }
  });

$("#newedit").submit(function(e) {
    var count2 = document.getElementById('counter').value;
    var countfail2 = document.getElementById('counterfail').value;
    var engarr = [];
    var failarr = [];
    for(var i = 1; i<= count2; i++){
      var engtemp = document.getElementById('e_engineer'+i).value;
      if(engtemp != ''){
        engarr.push(engtemp);
      }
    } 
    for(var j = 1; j<=countfail2;j++){
      var failtemp = document.getElementById('e_failure'+j).value;
      console.log(failtemp);
      if(failtemp != ''){
        failarr.push(failtemp);
      }
    }   
    console.log(failarr);
    const counteng = {};
    const countfail = {};
    failarr.forEach(function (item, index) {
      if (countfail[failarr[index]]) {
        countfail[failarr[index]] += 1;
      } else {
        countfail[failarr[index]] = 1;
      }
    });
    engarr.forEach(function (item, index) {
      if (counteng[engarr[index]]) {
        counteng[engarr[index]] += 1;
      } else {
        counteng[engarr[index]] = 1;
      }
    });
    const duplfail = Object.values(countfail).filter(x => x != 1);
    const dupleng = Object.values(counteng).filter(y => y != 1);
    if(duplfail.length > 0){
      // eksekusi jika duplikat
      swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Failure Code Duplicate',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
      event.preventDefault();
    }
    if(dupleng.length > 0){
      // eksekusi jika duplikat
      swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Engineer Duplicate',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
      event.preventDefault();
    }
    if(duplfail <= 0 && dupleng <=0){
      var btndelete = 'btndeleteen'+count2;
      document.getElementById('e_btnclose').style.display = 'none';
      document.getElementById('e_btnconf').style.display = 'none';

      document.getElementById('e_addfai').style.display='none';
      // document.getElementById(btndelete).style.display = 'none';
      document.getElementById('e_btnloading').style.display = '';
    }
  });



  $("#delete").submit(function() {
    //alert('test');
    document.getElementById('d_btnclose').style.display = 'none';
    document.getElementById('d_btnconf').style.display = 'none';
    document.getElementById('d_btnloading').style.display = '';
  });

  $(document).on('click','.btndeleteen',function(e){
    var counter = parseInt(document.getElementById('counter').value);
    var dummy = '';
    var idengineer = 'e_engineer'+counter;
    console.log(idengineer);
    var divnow = 'diven'+counter;
    // alert(idengineer);
    document.getElementById(idengineer).value = '';
    $('#'+idengineer).attr('required',false);
    $('#'+idengineer).select2({
      theme: 'bootstrap4',
      width:'100%',
          dummy,
    });
    
    document.getElementById(divnow).style.display='none';
    counter -= 1;
    var newdiv = 'btndeleteen'+counter;
    if(counter >1){
    document.getElementById(newdiv).style.display='';
    }
 
    document.getElementById('counter').value = counter;
     
  });

  
  $(document).on('click','#e_addfai',function(e){
    var counterfail = parseInt(document.getElementById('counterfail').value);
    var isfailnan = isNaN(counterfail);
    if(isfailnan){
      counterfail = 0;
    }
    if(counterfail <3){
    // var lastdiv = 'btndeleteen'+counter;
    //  if(counterfail > 1){
    //   document.getElementById(lastdiv).style.display ='none';
    //  }
    counterfail += 1;
    var nextdiv = 'divfail'+counterfail;
    // var newdiv = 'btndeleteen'+counter;
    // alert(nextdiv);
    document.getElementById(nextdiv).style.display ='';
    $('#e_failure'+counterfail).attr('required',true);
    // document.getElementById(newdiv).style.display = '';
    document.getElementById('counterfail').value = counterfail;
    if (counterfail == 3){
      document.getElementById('e_addfai').style.display='none';
    } 
  }
  });

  $(document).on('click', '.editwo', function() {
    $('#loadingtable').modal('show');
    
    var wonbr = $(this).data('wonbr');
    var btnendel1 = document.getElementById("btndeleteen1");
    var btnendel2 = document.getElementById("btndeleteen2");
    var btnendel3 = document.getElementById("btndeleteen3");
    var btnendel4 = document.getElementById("btndeleteen4");
    var btnendel5 = document.getElementById("btndeleteen5");
    var counter   = document.getElementById('counter');
    var counterfail = document.getElementById('counterfail');
    $.ajax({
      url: '/womaint/getnowo?nomorwo=' +wonbr,
      success:function(vamp){
        var tempres    = JSON.stringify(vamp);
        var result     = JSON.parse(tempres);
        var wonbr      = result[0].wo_nbr;
        var srnbr      = result[0].wo_sr_nbr;
        var en1val     = result[0].woen1;
        var en2val     = result[0].woen2;
        var en3val     = result[0].woen3;
        var en4val     = result[0].woen4;
        var en5val     = result[0].woen5;
        var asset      = result[0].wo_asset;
        var schedule   = result[0].wo_schedule;
        var duedate    = result[0].wo_duedate;
        var fc1        = result[0].wofc1;
        var fc2        = result[0].wofc2;
        var fc3        = result[0].wofc3;
        var fn1        = result[0].fd1;
        var fn2        = result[0].fd2;
        var fn3        = result[0].fd3;
        var prio       = result[0].wo_priority;
        var wodept     = result[0].wo_dept;
        var en1name    = result[0].u11;
        var note       = result[0].wo_note;
        console.log(result[0]);
        if(fc1 == null || fc1 == ''){
          document.getElementById('divfail1').style.display = 'none';
        }
        else{
          document.getElementById('divfail1').style.display = '';
          document.getElementById('e_failure1').value = fn1;
          // document.getElementById('hiddenfail1').value = fc1;
          counterfail = 1;
        }
          
        if(fc2 == null || fc2 == '' ){
          document.getElementById('divfail2').style.display = 'none';
        }  
        else{
            document.getElementById('divfail2').style.display = '';
            document.getElementById('e_failure2').value = fn2;
            // document.getElementById('hiddenfail2').value = fc2;
            counterfail = 2;
        }
            
        if(fc3 == null || fc3 == ''){
          document.getElementById('divfail3').style.display = 'none';
        }
        else{
          document.getElementById('divfail3').style.display = '';
          document.getElementById('e_failure3').value = fn3;
          // document.getElementById('hiddenfail3').value = fc3;
          counterfail = 3;
        }
        
        
        document.getElementById('counter').value       = counter;
        document.getElementById('e_nowo').value        = wonbr;
        document.getElementById('e_nosr').value        = srnbr;
        document.getElementById('e_schedule').value    = schedule;
        document.getElementById('e_duedate').value     = duedate;
        document.getElementById('e_engineerval').value = en1val;
        document.getElementById('e_engineer1').value   = en1name;
        document.getElementById('e_asset').value       = asset;
        document.getElementById('e_failure1').value    = fc1;
        document.getElementById('e_failure2').value    = fc2;
        document.getElementById('e_failure3').value    = fc3;
        document.getElementById('counterfail').value   = counterfail;
        document.getElementById('e_priority').value    = prio;
        // document.getElementById('e_department').value = wodept;
        document.getElementById('e_note').value        = note;
      
        if(counterfail == 3){
          document.getElementById('e_addfai').style.display='none';
        }

        else{
          document.getElementById('e_addfai').style.display='';
        }
        for(var f = 1; f<=counterfail;f++){
          $('#e_failure'+f).attr('required',true);
        }
        var sisafail = 3 - counterfail;
        if(sisafail != 0){
          for(var s = counterfail+1; s <= 3; s++){
            $('#e_failure'+s).attr('required',false);
          }
        }

        for(var i = 1; f<=counter;i++){
          $('#e_engineer'+f).attr('required',true);
        }
        var sisaeng = 5 - counterfail;
        if(sisaeng != 0){
          for(var s = counter+1; s <= 5; s++){
            $('#e_engineer'+s).attr('required',false);
          }
        }
        

        if(counter >1){
          var deletecount= 'btndeleteen'+counter;
          document.getElementById(deletecount).style.display='';
        }
        $('#e_failure1').select2({
          theme: 'bootstrap4',
          width:'100%',
          placeholder:'select failure',
          fc1,
          
        });
        $('#e_failure2').select2({
          theme: 'bootstrap4',
          width:'100%',
          placeholder:'select failure',
          fc2,
        });
        $('#e_failure3').select2({
          theme: 'bootstrap4',
          width:'100%',
          placeholder:'select failure',
          fc3,
        });

        // $('#e_department').select2({
        //   theme: 'bootstrap4',
        //   width:'100%',
        //   wodept,
        // });
        
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));
        if($('#loadingtable').hasClass('show')){
          setTimeout(function(){
            $('#loadingtable').modal('hide');
          },500);
        }
        setTimeout(function(){
            $('#editModal').modal('show');
          },1000);
        
      }
    })
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
        var schedule   = result[0].wo_schedule;
        var duedate    = result[0].wo_duedate;
        var fc1        = result[0].wofc1;
        var fc2        = result[0].wofc2;
        var fc3        = result[0].wofc3;
        var fn1        = result[0].fd1;
        var fn2        = result[0].fd2;
        var fn3        = result[0].fd3;
        var prio       = result[0].wo_priority;
        var note       = result[0].wo_note;
        var wodept     = result[0].dept_desc;
        
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
        document.getElementById('v_asset').value      = asset;
        document.getElementById('v_failure1').value   = fn1;
        document.getElementById('v_failure2').value   = fn2;
        document.getElementById('v_failure3').value   = fn3;
        document.getElementById('counterfail').value  = counterfail;
        document.getElementById('v_priority').value   = prio;
        document.getElementById('v_dept').value       = wodept;
        document.getElementById('v_note').value       = note;

        
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


  $(document).on('click', '.deletewo', function() {
    var wonbr = $(this).data('wonbr');
    document.getElementById('d_wonbr').innerHTML = wonbr;
    document.getElementById('tmp_wonbr').value = wonbr;

  });

  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function fetch_data(page, sort_type, sort_by, wonumber, woasset, wostatus,wopriority,woperiod) {
    $.ajax({
      url: "/wocreatedirect/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woasset=" + woasset+ "&wostatus=" + wostatus + "&wopriority="+wopriority+"&woperiod="+woperiod,
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
    var wonumber = $('#tmpwo').val();
    var assert   = $('#tmpasset').val();
    var status   = $('#tmpstatus').val();
    var priority = $('#tmppriority').val();
    var period   = $('#tmpperiod').val();
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


  $(document).on('change','#c_failurenum',function(){
    var assets = document.getElementById('c_asset').value;
    $.ajax({
      url: '/womaint/getfailure?asset=' +assets,
      success:function(fail){
        var tempfai       = JSON.stringify(fail);
        var resultfai     = JSON.parse(tempfai);
        var col           = '';
        var failurenum    = document.getElementById('c_failurenum').value;
        var divfailure1   = document.getElementById('failurediv');
        var appendclone   = divfailure1.cloneNode(true);
        col               = '';
        var i;
        
        if(failurenum != 0 && failurenum <=3){
          $('.divfailure').remove();
        for(i =1; i<=failurenum;i++){
          col +='<div class="form-group row col-md-12 divfailure" id="failure" >';
          col +='<label for="failure'+i+'" class="col-md-5 col-form-label text-md-left">Failure Code '+i+'</label>';
          col +='<div class="col-md-7">';
          col +='<select id="c_failure'+i+'" type="text" class="form-control c_failure" name="c_failure[]" required>';
          col +='<option value="">--Select Failure code--</option>';
          for(var j =0; j<resultfai.length;j++){
          col +='<option value="'+resultfai[j].fn_code+'">'+resultfai[j].fn_desc+'</option>';
          }
          col+='</select>';
          col+='</div>';
          col+='</div>';
          // var newid = 'engineer'+i;
          //   console.log(newid);
          // document.getElementById('testdiv').append(col);
          $("#failurediv").append(col);
          col='';
          }
          $('.c_failure').select2({
            placeholder: "Select Data",
            width:'100%',
            theme: 'bootstrap4',
          }); 
        }
      }
    });
  });

  $(document).on('change','#c_asset',function(){
    var assetval = document.getElementById('c_asset').value;
    if(assetval == ''){
      document.getElementById('c_faildiv').style.display='none';
    }
    else{
      document.getElementById('c_faildiv').style.display=''; 
    }
    $('#c_failurenum').select2({
            placeholder: "Select Value",
            width:'100%',
            theme: 'bootstrap4',
          });
  });



</script>
@endsection