@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Maintenance</h1>
          </div><!-- /.col -->
          <div class="col-sm-3">
          <button class="btn btn-block btn-primary createnewwo" data-toggle="modal" data-target="#createModal">
          Create WO</button>
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
.images {
  display: flex;
  flex-wrap:  wrap;
  margin-top: 20px;
}
.images .img,
.images .pic {
  flex-basis: 31%;
  margin-bottom: 10px;
  border-radius: 4px;
}
.images .img {
  width: 112px;
  height: 93px;
  background-size: cover;
  margin-right: 10px;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.images .img:nth-child(3n) {
  margin-right: 0;
}
.images .img span {
  display: none;
  text-transform: capitalize;
  z-index: 2;
}
.images .img::after {
  content: '';
  width: 100%;
  height: 100%;
  transition: opacity .1s ease-in;
  border-radius: 4px;
  opacity: 0;
  position: absolute;
}
.images .img:hover::after {
  display: block;
  background-color: #000;
  opacity: .5;
}
.images .img:hover span {
  display: block;
  color: #fff;
}
.images .pic {
  background-color: #F5F7FA;
  align-self: center;
  text-align: center;
  padding: 40px 0;
  text-transform: uppercase;
  color: #848EA1;
  font-size: 12px;
  cursor: pointer;
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
    <select id="s_asset"  class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
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
    @if($usernow[0]->approver == 1)
      <option value="plan">Plan</option>
      @endif
      @if($fromhome == 'open')
        <option value="open" selected>Open</option>
      @else
        <option value="open">Open</option>
      @endif
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
@if($fromhome == 'open')
  <input type="hidden" id="tmpstatus" value="open"/>
@else
  <input type="hidden" id="tmpstatus" value=""/>
@endif
<input type="hidden" id="tmppriority" value=""/>
<input type="hidden" id="tmpperiod" value=""/>

<div class="table-responsive col-12 mt-0 pt-0 align-top">
  <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0" style="width:100%;padding: .2rem !important;">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" style="cursor: pointer" width="10%">Work Order Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" style="cursor: pointer" width="10%">Asset<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_schedule" style="cursor: pointer" width="10%">Schedule Date<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_duedate" style="cursor: pointer" width="10%">Due Date<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_status" style="cursor: pointer" width="5%">Status<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_priority" style="cursor: pointer" width="5%">Priority</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_created_at" style="cursor: pointer" width="5%">Requested Date<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_creator" style="cursor: pointer" width="5%">Requested by</th>
        
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('workorder.table-wobrowse')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_updated_at" />
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
        <form class="form-horizontal" id="new" method="post" action="createwo" autocomplete="off">
          {{ csrf_field() }}
          <input type="hidden" id="crepairtypeedit" name = "crepairtypeedit" value = ''>
          <div class="form-group row col-md-12 c_engineerdiv">
            <label for="c_engineernum" class="col-md-5 col-form-label text-md-left">Total Engineer</label>
            <div class="col-md-7">
              <select id="c_engineernum" type="number" class="form-control c_engineernum" name="c_engineernum" min='1' max='5' autofocus required>
              <option value="" disabled selected>Select Engineer</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
          </div>
          <div id="testdiv">
          
          </div>
          
          <div class="form-group row col-md-12">
            <label for="c_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
            <select id="c_asset" type="text" class="form-control c_asset" name="c_asset" autofocus required>
                <option value="">--Select Asset--</option>
                @foreach ($asset2 as $asset2)
                  <option value="{{$asset2->asset_code}}">{{$asset2->asset_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12 c_failurediv" id="c_faildiv" style="display: none;">
            <label for="c_failurenum" class="col-md-5 col-form-label text-md-left">Total Failure Code</label>
            <div class="col-md-7">
              <select id="c_failurenum"  class="form-control c_failurenum" name="c_failurenum"  autofocus required>
                <option value="" disabled selected>Select Failure Number</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </div>
          </div>
          <div id="failurediv">
          
          </div>
          <div class="form-group row col-md-12">
            <label for="c_schedule" class="col-md-5 col-form-label text-md-left">Schedule Date</label>
            <div class="col-md-7">
              <input type="date" id="c_schedule"  class="form-control" name="c_schedule" value="{{ old('scheduledate') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_duedate" class="col-md-5 col-form-label text-md-left">Due Date</label>
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
            <label for="c_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
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
          
          <div class="form-group row justify-content-center" id="cdevrepairtype">
              <label for="crepaircode" class="col-md-5 col-form-label text-md-left">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
              <div class="col-md-7" style="vertical-align:middle;">
                <input class=" d-inline" type="radio" name="crepairtype" id="cargcheck" value="group">
                <label class="form-check-label" for="cargcheck">
                  Repair Group
                </label>

                <input class="d-inline ml-5" type="radio"  name="crepairtype" id="carccheck" value="code">
                <label class="form-check-label" for="carccheck">
                  Repair Code
                </label>
              </div>
              </div>
              <div class="form-group row justify-content-center" id="crepaircodediv" style="display: none;">
                  <label for="crepaircode" class="col-md-5 col-form-label text-md-left">Repair Code(Max 3) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-7">
                      <select id="crepaircode" name="crepaircode[]" class="form-control" multiple="multiple">
                          @foreach($repaircode as $rc)
                            <option value="{{$rc->repm_code}}">{{$rc->repm_code}} -- {{$rc->repm_desc}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="form-group row justify-content-center" id="crepairgroupdiv" style="display: none;">
                  <label for="crepairgroup" class="col-md-5 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-7">
                      <select id="crepairgroup" name="crepairgroup" class="form-control">
                          @foreach($repairgroup as $rp)
                            <option value="{{$rp->xxrepgroup_nbr}}">{{$rp->xxrepgroup_nbr}} -- {{$rp->xxrepgroup_desc}}</option>
                          @endforeach
                      </select>
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
      <input type="hidden" id="statusedit">
      <form class="form-horizontal" id="newedit" method="post" action="editwo">
        {{ csrf_field() }}
        <input type="hidden" id="counter" value=0>
        <input type="hidden" id="counterfail" value=0>
        <input type="hidden" id="repairtypeedit">
        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="e_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
              <input id="e_nowo" type="text" class="form-control" name="e_nowo"  autocomplete="off" maxlength="6" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_nosr" class="col-md-5 col-form-label text-md-left">SR Number</label>
            <div class="col-md-7">
              <input id="e_nosr" type="text" class="form-control" name="e_nosr" readonly >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="diven1" style="display:none">
            <label for="e_engineer1" class="col-md-5 col-form-label text-md-left">Engineer 1 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6">
              <select id="e_engineer1" class="form-control e_engineer1" name="e_engineer1" required>
              <!-- <option value="" disabled>--select data--</option> -->
              @foreach ($engine as $engine1)
                <option value="{{$engine1->eng_code}}">{{$engine1->eng_desc}}</option>
              @endforeach
              </select>
            </div>
            <div class="col-md-1">
              
            </div>
          </div>
          <div class="form-group row justify-content-center" id="diven2" style="display:none">
            <label for="e_engineer2" class="col-md-5 col-form-label text-md-left">Engineer 2 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6">
              <select id="e_engineer2" class="form-control e_engineer2" name="e_engineer2"  >
              <!-- <option value="">--select data--</option> -->
              @foreach ($engine as $engine2)
                <option value="{{$engine2->eng_code}}">{{$engine2->eng_desc}}</option>
              @endforeach
              </select>
            </div>
            <div class="col-md-1">
              <a style="display: none;" href="javascript:void(0)" id="btndeleteen2" class="btndeleteen"><i class="icon-table fa fa-trash fa-lg"></i></a>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="diven3" style="display:none">
            <label for="e_engineer3" class="col-md-5 col-form-label text-md-left">Engineer 3 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6">
              <select id="e_engineer3" class="form-control e_engineer3" name="e_engineer3"  >
              <!-- <option value="">--select data--</option> -->
              @foreach ($engine as $engine3)
                <option value="{{$engine3->eng_code}}">{{$engine3->eng_desc}}</option>
              @endforeach
              </select>
            </div>
            <div class="col-md-1">
              <a style="display: none;" href="javascript:void(0)" id="btndeleteen3" class="btndeleteen"><i class="icon-table fa fa-trash fa-lg"></i></a>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="diven4" style="display:none">
            <label for="e_engineer4" class="col-md-5 col-form-label text-md-left">Engineer 4 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6">
              <select id="e_engineer4" class="form-control e_engineer4" name="e_engineer4"  >
              <!-- <option value="">--select data--</option>    -->
              @foreach ($engine as $engine4)
                <option value="{{$engine4->eng_code}}">{{$engine4->eng_desc}}</option>
              @endforeach
              </select>
            </div>
            <div class="col-md-1">
              <a style="display: none;" href="javascript:void(0)" id="btndeleteen4" class="btndeleteen"><i class="icon-table fa fa-trash fa-lg"></i></a>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="diven5" style="display:none">
            <label for="e_engineer5" class="col-md-5 col-form-label text-md-left">Engineer 5 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6">
              <select id="e_engineer5" class="form-control e_engineer5" name="e_engineer5" >
              <!-- <option value="">--select data--</option> -->
              @foreach ($engine as $engine5)
                <option value="{{$engine5->eng_code}}">{{$engine5->eng_desc}}</option>
              @endforeach
              </select>
            </div>
            <div class="col-md-1">
              <a  style="display: none;" href="javascript:void(0)" id="btndeleteen5" class="btndeleteen"><i class="icon-table fa fa-trash fa-lg"></i></a>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
              <input id="e_asset" type="text" class="form-control e_asset" readonly>
              <input id="e_assethid" type="hidden" class="form-control e_asset" name="e_asset" readonly>
              
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail1" style="display:none">
            <label for="e_failure1" class="col-md-5 col-form-label text-md-left">Failure Code 1 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="e_failure1" class="form-control e_failure1" required  >
              @foreach ($failure as $failure1)
                <option value="{{$failure1->fn_code}}">{{$failure1->fn_code}} -- {{$failure1->fn_desc}}</option>
              @endforeach
              </select>
              <input type="hidden" name="e_failure1" id="hiddenfail1">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail2" style="display:none">
            <label for="e_failure2" class="col-md-5 col-form-label text-md-left">Failure Code 2 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="e_failure2" class="form-control e_failure2" >
              @foreach ($failure as $failure2)
                <option value="{{$failure2->fn_code}}">{{$failure2->fn_code}} -- {{$failure2->fn_desc}}</option>
              @endforeach
              </select>
              <input type="hidden" name="e_failure2" id="hiddenfail2">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divfail3" style="display:none">
            <label for="e_failure3" class="col-md-5 col-form-label text-md-left">Failure Code 3 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="e_failure3" class="form-control e_failure3" >
              @foreach ($failure as $failure3)
                <option value="{{$failure3->fn_code}}">{{$failure3->fn_code}} -- {{$failure3->fn_desc}}</option>
              @endforeach
              </select>
              <input type="hidden" name="e_failure3" id="hiddenfail3">
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_schedule" class="col-md-5 col-form-label text-md-left">Schedule Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input id="e_schedule" type="date" class="form-control" name="e_schedule" value="{{ old('e_schedule') }}"   autofocus required>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_duedate" class="col-md-5 col-form-label text-md-left">Due Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
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
            <label for="e_priority" class="col-md-5 col-form-label text-md-left">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
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
          
          <div class="form-group row justify-content-center" id="edevrepairtype">
              <label for="repaircode" class="col-md-5 col-form-label text-md-left">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
              <div class="col-md-7" style="vertical-align:middle;">
                <input class=" d-inline" type="radio" name="erepairtype" id="eargcheck" value="group">
                <label class="form-check-label" for="eargcheck">
                  Repair Group
                </label>

                <input class="d-inline ml-5" type="radio"  name="erepairtype" id="earccheck" value="code">
                <label class="form-check-label" for="earccheck">
                  Repair Code
                </label>
              </div>
              </div>
              <div class="form-group row justify-content-center" id="erepaircodediv" style="display: none;">
                  <label for="erepaircode" class="col-md-5 col-form-label text-md-left">Repair Code(Max 3) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-7">
                      <select id="erepaircode" name="erepaircode[]" class="form-control" multiple="multiple">
                          @foreach($repaircode as $rc)
                            <option value="{{$rc->repm_code}}">{{$rc->repm_code}} -- {{$rc->repm_desc}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="form-group row justify-content-center" id="erepairgroupdiv" style="display: none;">
                  <label for="erepairgroup" class="col-md-5 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-7">
                      <select id="erepairgroup" name="erepairgroup" class="form-control">
                          @foreach($repairgroup as $rp)
                            <option value="{{$rp->xxrepgroup_nbr}}">{{$rp->xxrepgroup_nbr}} -- {{$rp->xxrepgroup_desc}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger bt-action mr-auto e_btnadd"  id="e_addeng" >Add Engineer</button>
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


<!--Modal Approve-->
<div class="modal fade" id="approveModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Approval</h5>
        <button type="button" class="close" id='closeapprove' data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <input type="hidden" id="a_counter">
        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="a_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
              <input id="a_nowo" type="text" class="form-control" name="a_nowo"  autocomplete="off" readonly autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="a_nosr" class="col-md-5 col-form-label text-md-left">SR Number</label>
            <div class="col-md-7">
              <input id="a_nosr" type="text" class="form-control" name="a_nosr"  readonly autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="avien1" style="display:none">
            <label for="a_engineer1" class="col-md-5 col-form-label text-md-left">Engineer 1</label>
            <div class="col-md-7">
              <input type='text' id="a_engineer1" class="form-control a_engineer1" name="a_engineer1"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="avien2" style="display:none">
            <label for="a_engineer2" class="col-md-5 col-form-label text-md-left">Engineer 2</label>
            <div class="col-md-7">
              <input type='text' id="a_engineer2" class="form-control a_engineer2" name="a_engineer2" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="avien3" style="display:none">
            <label for="a_engineer3" class="col-md-5 col-form-label text-md-left">Engineer 3</label>
            <div class="col-md-7">
              <input type="text" readonly id="a_engineer3" class="form-control a_engineer3" name="a_engineer3" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="avien4" style="display:none">
            <label for="a_engineer4" class="col-md-5 col-form-label text-md-left">Engineer 4</label>
            <div class="col-md-7">
              <input type="text" readonly id="a_engineer4" class="form-control a_engineer4" name="a_engineer4" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="avien5" style="display:none">
            <label for="a_engineer5" class="col-md-5 col-form-label text-md-left">Engineer 5</label>
            <div class="col-md-7">
              <input type="text" readonly id="a_engineer5" class="form-control a_engineer5" name="a_engineer5" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="a_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
              <input type="text" readonly id="a_asset" type="text" class="form-control a_asset" name="a_asset" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="adivfail1" style="display:none">
            <label for="a_failure1" class="col-md-5 col-form-label text-md-left">Failure Code 1</label>
            <div class="col-md-7">
              <input id="a_failure1" class="form-control a_failure1" autofocus readonly>
              <input type="hidden" name="a_failure1" id="ahiddenfail1">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="adivfail2" style="display:none">
            <label for="a_failure2" class="col-md-5 col-form-label text-md-left">Failure Code 2</label>
            <div class="col-md-7">
              <input id="a_failure2" class="form-control a_failure2"  autofocus readonly>
              <input type="hidden" name="a_failure2" id="ahiddenfail2">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="adivfail3" style="display:none">
            <label for="a_failure3" class="col-md-5 col-form-label text-md-left">Failure Code 3</label>
            <div class="col-md-7">
              <input id="a_failure3" class="form-control a_failure3"  autofocus readonly>
              <input type="hidden" name="a_failure3" id="ahiddenfail3">
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="a_schedule" class="col-md-5 col-form-label text-md-left">Schedule Date</label>
            <div class="col-md-7">
              <input id="a_schedule" readonly type="date" class="form-control" name="a_schedule" value="{{ old('a_schedule') }}"   autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="a_duedate" class="col-md-5 col-form-label text-md-left">Due Date</label>
            <div class="col-md-7">
              <input id="a_duedate" readonly type="date" class="form-control" name="a_duedate" value="{{ old('a_duedate') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="a_department" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <input id="a_department"  class="form-control a_department" name="a_department"  autofocus readonly>              
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="a_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
            <div class="col-md-7">
              <input id="a_priority" type="text" class="form-control" name="a_priority" value="{{ old('a_priority') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="a_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
            <textarea id="a_note" class="form-control c_note" name="a_note" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">

          <label for="repaircode" class="col-md-5 col-form-label text-md-left">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>

          <div class="col-md-7" style="vertical-align:middle;">
            <input class=" d-inline" type="radio" name="repairtype" id="argcheck" value="group">
            <label class="form-check-label" for="argcheck">
              Repair Group
            </label>
          
            <input class="d-inline ml-5" type="radio"  name="repairtype" id="arccheck" value="code">
            <label class="form-check-label" for="arccheck">
              Repair Code
            </label>
          </div>
          </div>
          <div class="form-group row justify-content-center" id="repaircodediv" style="display: none;">
              <label for="repaircodeselect" class="col-md-5 col-form-label text-md-left">Repair Code(Max 3) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-7">
                  <select id="repaircodeselect" name="repaircode" class="form-control repaircodeselect" multiple="multiple">
                      @foreach($repaircode as $rc)
                        <option value="{{$rc->repm_code}}">{{$rc->repm_code}} -- {{$rc->repm_desc}}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="form-group row justify-content-center" id="repairgroupdiv" style="display: none;">
              <label for="repairgroup" class="col-md-5 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-7">
                  <select id="repairgroup" name="repairgroup" class="form-control">
						  @foreach($repairgroup as $rp)
                            <option value="{{$rp->xxrepgroup_nbr}}">{{$rp->xxrepgroup_nbr}} -- {{$rp->xxrepgroup_desc}}</option>
                          @endforeach
                  </select>
              </div>
          </div>
        </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="a_btnclose" data-dismiss="modal">Close</button>
            <form method="post" id="approvee" action="/approvewo">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger bt-action" id="a_btnreject">Reject</button>
            <input type='hidden' name='switch' value='reject'>
            <input type='hidden' name='aprwonbr' id="apprwonbr2">
            
            </form>
            <form method="post" id="approvee2" action="/approvewo">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-success bt-action" id="a_btnapprove" >Approve</button>
            <input type='hidden' name='switch' value='approve'>
            <input type='hidden' name='aprwonbr' id="apprwonbr">
            <input type='hidden' name='repairtype' id='repairtype'>
            <input type='hidden' name='repaircodeapp' id="repaircodeapp">
            <input type='hidden' name='repairgroupapp' id="repairgroupapp">
            </form>
            <button type="button" class="btn btn-block btn-info" id="a_btnloading" style="display:none"><i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
        </div>
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
            <label for="v_creator" class="col-md-5 col-form-label text-md-left">Created By</label>
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
<!-- modal accepting -->
<div class="modal fade" id="acceptModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Acceptance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
        <input type="hidden"  id="v_counter">
        <input type="hidden" name="statuswo" id="statuswo">
        <div class="form-group row justify-content-center">
            <label for="ac_wonbr2" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
            <input id="ac_wonbr2" type="text" class="form-control ac_wonbr2" name="ac_wonbr2" autofocus readonly>
              <!-- <input type="hidden" id="c_assetcode"> -->
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="ac_srnbr2" class="col-md-5 col-form-label text-md-left">SR Number</label>
            <div class="col-md-7">
            <input id="ac_srnbr2" type="text" class="form-control ac_srnbr2" name="ac_srnbr2" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="ac_asset2" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
            <input id="ac_asset2" type="text" class="form-control ac_asset2" name="ac_asset2" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer1" style="display:none">
            <label for="ac_engineer1" class="col-md-5 col-form-label text-md-left">Engineer 1</label>
            <div class="col-md-7">
              <input type='text' id="ac_engineer1" class="form-control ac_engineer1" name="ac_engineer1"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer2" style="display:none">
            <label for="ac_engineer2" class="col-md-5 col-form-label text-md-left">Engineer 2</label>
            <div class="col-md-7">
              <input type='text' id="ac_engineer2" class="form-control ac_engineer2" name="ac_engineer2" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer3" style="display:none">
            <label for="ac_engineer3" class="col-md-5 col-form-label text-md-left">Engineer 3</label>
            <div class="col-md-7">
              <input type="text" readonly id="ac_engineer3" class="form-control ac_engineer3" name="ac_engineer3" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer4" style="display:none">
            <label for="ac_engineer4" class="col-md-5 col-form-label text-md-left">Engineer 4</label>
            <div class="col-md-7">
              <input type="text" readonly id="ac_engineer4" class="form-control ac_engineer4" name="ac_engineer4" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer5" style="display:none">
            <label for="ac_engineer5" class="col-md-5 col-form-label text-md-left">Engineer 5</label>
            <div class="col-md-7">
              <input type="text" readonly id="ac_engineer5" class="form-control ac_engineer5" name="ac_engineer5" autofocus >
            </div>
          </div>
          <!-- <div class="form-group row col-md-12 c_engineerdiv">
            <label for="c_repaircodenum" class="col-md-5 col-form-label text-md-left">Total Repair Code</label>
            <div class="col-md-7">
              <input id="c_repaircodenum" type="number" class="form-control c_repaircodenum" name="c_repaircodenum" min='1' max='3'  autofocus>
            </div>
          </div> -->
          <div class="form-group row justify-content-center" id="acdivfail1" style="display:none">
            <label for="ac_failure1" class="col-md-5 col-form-label text-md-left">Failure Code 1</label>
            <div class="col-md-7">
              <input id="ac_failure1" class="form-control ac_failure1" autofocus readonly>
              
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivfail2" style="display:none">
            <label for="ac_failure2" class="col-md-5 col-form-label text-md-left">Failure Code2</label>
            <div class="col-md-7">
              <input id="ac_failure2" class="form-control ac_failure2"  autofocus readonly>
              
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivfail3" style="display:none">
            <label for="ac_failure3" class="col-md-5 col-form-label text-md-left">Failure Code 3</label>
            <div class="col-md-7">
              <input id="ac_failure3" class="form-control ac_failure3"  autofocus readonly>
              
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divaccode" style="display: none;">
            <label for="ac_repaircode" class="col-md-5 col-form-label text-md-left">Repair Code</label>
            <div class="col-md-7">
              <textarea id="ac_repaircode" readonly  class="form-control" name="ac_repaircode" value="{{ old('v_repaircode') }}"   autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divacgroup" style="display: none;">
            <label for="ac_repairgroup" class="col-md-5 col-form-label text-md-left">Repair Group</label>
            <div class="col-md-7">
              <input id="ac_repairgroup" readonly  class="form-control" name="ac_repairgroup" value="{{ old('v_repairgroup') }}"  autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center c_engineerdiv">
            <label for="c_repairhour" class="col-md-5 col-form-label text-md-left">Repair Hour</label>
            <div class="col-md-7">
              <input id="c_repairhour" type="number" class="form-control c_repairhour" name="c_repairhour" min='1'  autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="c_finishdate" class="col-md-5 col-form-label text-md-left">Finish Date</label>
            <div class="col-md-7">
            <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="c_finishtime" class="col-md-5 col-form-label text-md-left">Finish Time</label>
            <div class="col-md-7">
            <input id="c_finishtime" type="text" class="form-control c_finishdate" name="c_finishdate" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="ac_note" class="col-md-5 col-form-label text-md-left">Reporting Note</label>
            <div class="col-md-7">
            <textarea id="ac_note" class="form-control c_note" name="c_note" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="photodiv">
            <div class="col-md-12 justify-content-center"  >
              <label for="v_fotoupload" class="col-md-12 col-form-label text-md-center">Photo(s) uploaded</label>
              
            </div>
            <div class="col-md-12 justify-content-center">
              <div id="munculgambar">
          
              </div>
            </div>
          </div>
          
          <form id="reportstatuswo" method="post"  action="/statusreportingwo">
            {{ csrf_field() }}
          <!-- <div class="form-group row justify-content-center">
            <label class="col-md-12 col-form-label text-md-center"><b>Completed</b></label>
            <label class="col-md-12 col-form-label text-md-left">Photo Upload : <span id="alert1" style="color: red; font-weight: 200;">*</span> </label>
          </div>
          <div class="form-group row justify-content-center" style="margin-bottom: 10%;">
              <div class="col-md-12 images">
                  <div class="pic">
                      add
                  </div>
              </div>
          </div> -->
          <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
          <input type="hidden" id="formtype" name="formtype" value="0" />
          <h6 style="text-align: center;"><b>Uncompleted</b></h6>
          <hr>
          <div class="form-group row">
            <label for="uncompletenote" class="col-md-3 col-form-label text-md-left">Reason <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <textarea id="uncompletenote" type="text" class="form-control" name="uncompletenote" rows="6" maxlength="50" autocomplete="off" autofocus></textarea>
            </div>
          </div>
<!--           
          <div id="divrepair">
          
          </div> -->
      </div>

      <div class="modal-footer">
        
        <a id="aprint" target="_blank" class="mr-auto" style="width: 20%;"><button type="button" class="btn btn-warning bt-action" style="width: 70%;"><b>Print</b></button></a>  
        <button type="button" class="btn btn-info bt-action" id="ac_btnclose" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger bt-action" id="ac_btnuncom">Uncompleted</button>
        <button type="submit" class="btn btn-success bt-action" id="ac_btncom">Completed</button>
        <input type='hidden' name='switch2' id="switch2" value=''>
        <input type='hidden' name='aprwonbr2' id="apprwonbr3">
        <input type='hidden' name='aprsrnbr2' id="apprsrnbr3">
        <button type="button" class="btn btn-block btn-info" id="ac_btnloading" style="display:none">
          <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
        </button>
      </div>
      </form>
    </div>
  </div>
</div>



<!--Modal Delete-->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Close</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="delete" method="post" action="closewo">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="tmp_wonbr" id="tmp_wonbr">
          Are you sure want to close this <i>Work Order</i> <b> <span id="d_wonbr"></span></b> ?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="d_btnclosed" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success bt-action" id="d_btnconfd">Confirm</button>
          <button type="button" class="btn btn-block btn-info" id="d_btnloadingd" style="display:none">
            <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="reopenModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Reopen WO</h5>
        <button type="button" class="close" id='deletequit' data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="reopen" method="post" action="reopenwo">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="tmp_rowonbr" id="tmp_rowonbr">
          Do you want to reopen <i>work order</i> <b> <span id="d_rowonbr"></span></b> ?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="d_btnclose" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success bt-action" id="d_btnconf">Confirm</button>
          <button type="button" class="btn btn-block btn-info" id="d_btnloading" style="display:none">
            <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
          </button>
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

$(document).on('change','#arccheck',function(e){
  document.getElementById('repaircodediv').style.display='';
  document.getElementById('repaircodeselect').value=null;
  document.getElementById('repairgroupdiv').style.display='none';
  document.getElementById('repairgroup').value=null;  
  document.getElementById('repairtype').value= 'code';
});
$(document).on('change','#argcheck',function(e){
  document.getElementById('repairgroupdiv').style.display='';
  document.getElementById('repairgroup').value=null;
  document.getElementById('repaircodediv').style.display='none';
  document.getElementById('repaircodeselect').value=null;
  document.getElementById('repairtype').value= 'group';
});

$(document).on('change','#earccheck',function(e){
  document.getElementById('erepaircodediv').style.display='';
  document.getElementById('erepairgroupdiv').style.display='none';
  $("#erepairgroup").val(null).trigger('change');
  $("#erepaircode").val(null).trigger('change');
  document.getElementById('repairtypeedit').value = 'code';
});
$(document).on('change','#eargcheck',function(e){
  document.getElementById('erepairgroupdiv').style.display='';
  document.getElementById('erepaircodediv').style.display='none';
  $("#erepairgroup").val(null).trigger('change');
  $("#erepaircode").val(null).trigger('change');
  document.getElementById('repairtypeedit').value = 'group';
});

$(document).on('change','#carccheck',function(e){
  document.getElementById('crepaircodediv').style.display='';
  document.getElementById('crepairgroupdiv').style.display='none';
  $("#crepairgroup").val(null).trigger('change');
  $("#crepaircode").val(null).trigger('change');
  document.getElementById('crepairtypeedit').value = 'code';
});
$(document).on('change','#cargcheck',function(e){
  document.getElementById('crepairgroupdiv').style.display='';
  document.getElementById('crepaircodediv').style.display='none';
  $("#crepairgroup").val(null).trigger('change');
  $("#crepaircode").val(null).trigger('change');
  document.getElementById('crepairtypeedit').value = 'group';
});

$(document).on('submit','#approvee',function(event){
  
  event.preventDefault();
  // document.getElementById('repaircodeapp').values = document.getElementById('repaircode').values;
  
  
  document.getElementById('a_btnapprove').style.display='none';
  document.getElementById('a_btnreject').style.display='none';
  document.getElementById('a_btnclose').style.display='none';
  document.getElementById('a_btnloading').style.display='';  
  document.getElementById('closeapprove').style.display='none';  
  document.getElementById('repaircodeapp').value = test;
  // test.forEach(insertapprove); 
});

$(document).on('submit','#approvee2',function(event){
  
  event.preventDefault();
  // document.getElementById('repaircodeapp').values = document.getElementById('repaircode').values;
  
  
  var test = $('#repaircodeselect').val();
  var repairgroup = $('#repairgroup').val();
  if(test == null && repairgroup == null){
    swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Enter minimum 1 repair code/group',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
  }
  else{
      // document.getElementById('repaircodeapp').value = document.getElementById('repaircode');
      document.getElementById('repairgroupapp').value = repairgroup;
      document.getElementById('a_btnapprove').style.display='none';
      document.getElementById('a_btnreject').style.display='none';
      document.getElementById('a_btnclose').style.display='none';
      document.getElementById('a_btnloading').style.display='';  
      document.getElementById('closeapprove').style.display='none';  
      document.getElementById('repaircodeapp').value = test;
      // test.forEach(insertapprove);
      document.getElementById('approvee2').submit();
  }
});

$("#repaircodeselect").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
          });
$('#repairgroup').select2({

placeholder:'--Select Repair Group--',
width:'100%',
closeOnSelect : true,

})
$("#repaircodeselect").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
          });
$('#repairgroup').select2({

placeholder:'--Select Repair Group--',
width:'100%',
closeOnSelect : true,

})
$('#erepairgroup').select2({
  placeholder:'--Select Repair Group--',
  width:'100%',
  closeOnSelect : true,
})
$("#erepaircode").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
          });
$('#crepairgroup').select2({
  placeholder:'--Select Repair Group--',
  width:'100%',
  closeOnSelect : true,
})
$("#crepaircode").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
          });
$('#s_asset').select2({
  width: '100%',
  theme: 'bootstrap4',
  placeholder: '--Select Asset--',
  
});
// $('#c_department').select2({
//   width: '100%',
//   theme: 'bootstrap4',
//   placeholder: '--Select Department--'
// })

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

$('.c_engineernum').select2({
    placeholder: "Select Engineer Number",
    width:'100%',
    theme: 'bootstrap4',
  });
$('.c_engineer').select2({
    placeholder: "Select Engineer",
    width:'100%',
    theme: 'bootstrap4',
  });

$('.c_asset').select2({
    placeholder: "Select Asset",
    width:'100%',
    theme: 'bootstrap4',
  });
  $('#reportstatuswo').submit(function(e){
    document.getElementById('ac_btnclose').style.display='none';
    document.getElementById('ac_btnuncom').style.display='none';
    document.getElementById('ac_btncom').style.display='none';
    document.getElementById('ac_btnloading').style.display='';
    document.getElementById('aprint').style.display='none';
  })
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
    var statuseditwo = document.getElementById('statusedit').value;
    var count2 = document.getElementById('counter').value;
    var countfail2 = document.getElementById('counterfail').value;
    var engarr = [];
    var failarr = [];
    for(var i = 1; i<= count2; i++){
      var engtemp = document.getElementById('e_engineer'+i).value;
      // alert(count2);
      if(engtemp != ''){
        engarr.push(engtemp);
      }
    } 
    for(var j = 1; j<=countfail2;j++){
      var failtemp = document.getElementById('e_failure'+j).value;
      // alert(failtemp);
      // console.log(failtemp);
      if(failtemp != ''){
        failarr.push(failtemp);
      }
    }   
    // console.log(failarr);
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
   var erepaircd = document.getElementById('erepaircode').value;
  //  alert(erepaircd.length);
   var erepairgr = document.getElementById('erepairgroup').value;
  //  alert(erepairgr.length);
   if(statuseditwo != 'plan'){
   if(erepaircd.length == 0 && erepairgr.length == 0){
    swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Enter minimum 1 repair code/group',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
      event.preventDefault();
   }
    if(duplfail <= 0 && dupleng <=0 && (erepaircd.length != 0 || erepairgr.length != 0)){
      var btndelete = 'btndeleteen'+count2;
      document.getElementById('e_btnclose').style.display = 'none';
      document.getElementById('e_btnconf').style.display = 'none';
      document.getElementById('e_addeng').style.display = 'none';
      document.getElementById('e_addfai').style.display='none';
      if(count2 > 1){
        document.getElementById(btndelete).style.display = 'none';
      }
      document.getElementById('e_btnloading').style.display = '';
    }
   }
   else{
    if(duplfail <= 0 && dupleng <=0){
      var btndelete = 'btndeleteen'+count2;
      document.getElementById('e_btnclose').style.display = 'none';
      document.getElementById('e_btnconf').style.display = 'none';
      document.getElementById('e_addeng').style.display = 'none';
      document.getElementById('e_addfai').style.display='none';
      if(count2 > 1){
        document.getElementById(btndelete).style.display = 'none';
      }
      document.getElementById('e_btnloading').style.display = '';
    }
   }
  });


$(document).on('click','.approvewo',function(){
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
        var assdesc    = result[0].asset_desc;
        var schedule   = result[0].wo_schedule;
        var duedate    = result[0].wo_duedate;
        var fc1        = result[0].wofc1;
        var fc2        = result[0].wofc2;
        var fc3        = result[0].wofc3;
        var fn1        = result[0].fd1;
        var fn2        = result[0].fd2;
        var fn3        = result[0].fd3;
        var wodept     = result[0].wo_dept;
        var prio       = result[0].wo_priority;
        var note       = result[0].wo_note;

        if(fc1 == null || fc1 == ''){
          document.getElementById('adivfail1').style.display = 'none';
        }
        else{
          document.getElementById('adivfail1').style.display = '';
          document.getElementById('a_failure1').value = fn1;
          document.getElementById('ahiddenfail1').value = fc1;
          counterfail = 1;
        }
          
        if(fc2 == null || fc2 == '' ){
          document.getElementById('adivfail2').style.display = 'none';
        }  
        else{
            document.getElementById('adivfail2').style.display = '';
            document.getElementById('a_failure2').value = fn2;
            document.getElementById('ahiddenfail2').value = fc2;
            counterfail = 2;
        }
            
        if(fc3 == null || fc3 == ''){
          document.getElementById('adivfail3').style.display = 'none';
        }
        else{
          document.getElementById('adivfail3').style.display = '';
          document.getElementById('a_failure3').value = fn3;
          document.getElementById('ahiddenfail3').value = fc3;
          counterfail = 3;
        }
        
        if(en1val == null || en1val == ''){
          en1val = '';
        }
        else{
          document.getElementById('avien1').style.display = '';
          counter = 1;
        }

        if(en2val == null || en2val ==''){
          en2val = '';
          document.getElementById('avien2').style.display = 'none';
        }
        else{
          document.getElementById('avien2').style.display = '';
          counter = 2;
        }
        if(en3val == null || en3val ==''){
          en3val = '';
          document.getElementById('avien3').style.display = 'none';
        }
        else{
          document.getElementById('avien3').style.display = '';
          counter = 3;
        }

        if(en4val == null || en4val ==''){
          en4val = '';
          document.getElementById('avien4').style.display = 'none';
        }
        else{
          document.getElementById('avien4').style.display = '';
          counter = 4;
        }

        if(en5val == null || en5val == ''){
          en5val = '';
          document.getElementById('avien5').style.display = 'none';
        }
        else{
          document.getElementById('avien5').style.display = '';
          counter = 5;
        }

        document.getElementById('counter').value     = counter;
        document.getElementById('a_nowo').value      = wonbr;
        document.getElementById('a_nosr').value      = srnbr;
        document.getElementById('a_schedule').value  = schedule;
        document.getElementById('a_duedate').value   = duedate;
        document.getElementById('a_engineer1').value = en1val;
        document.getElementById('a_engineer2').value = en2val;
        document.getElementById('a_engineer3').value = en3val;
        document.getElementById('a_engineer4').value = en4val;
        document.getElementById('a_engineer5').value = en5val;
        document.getElementById('a_asset').value     = asset +' -- '+assdesc;
        document.getElementById('a_failure1').value  = fc1+' -- '+fn1;
        document.getElementById('a_failure2').value  = fc2+' -- '+fn2;
        document.getElementById('a_failure3').value  = fc3+' -- '+fn3;
        document.getElementById('a_department').value= wodept;
        document.getElementById('a_note').value= note;
        document.getElementById('a_priority').value  = prio;
        document.getElementById('counterfail').value = counterfail;
        document.getElementById('apprwonbr2').value  = wonbr;
        
        document.getElementById('apprwonbr').value   = wonbr;
        $("#repaircodeselect").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
          });

      },
      complete: function(vamp){
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));
        
          setTimeout(function(){
            $('#loadingtable').modal('hide');
          },500);
        
        setTimeout(function(){
            $('#approveModal').modal('show');
          },1000);
        
      }
    })
  });
  $("#delete").submit(function() {
    //alert('test');
    document.getElementById('d_btnclosed').style.display = 'none';
    document.getElementById('d_btnconfd').style.display = 'none';
    document.getElementById('d_btnloadingd').style.display = '';
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
    document.getElementById('e_addeng').style.display='';
    document.getElementById('counter').value = counter;
     
  });

  $(document).on('click','#e_addeng',function(e){
    var counter = parseInt(document.getElementById('counter').value);
    var nancount = isNaN(counter);
    // alert(nancount);
    if(nancount){
      counter = 0;
      // alert('yay');
    }

    if(counter <5){
      // alert('yay2');
    var lastdiv = 'btndeleteen'+counter;
     if(counter > 1){
    document.getElementById(lastdiv).style.display ='none';
     }
    counter += 1;
    var nextdiv = 'diven'+counter;
    
    
    document.getElementById(nextdiv).style.display ='';
    $('#e_engineer'+counter).attr('required',true);
    if(counter >1){
    var newdiv = 'btndeleteen'+counter;
    document.getElementById(newdiv).style.display = '';
    }
    document.getElementById('counter').value = counter;
    if (counter == 5){
      document.getElementById('e_addeng').style.display='none';
    } 
  }
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
  

  $(document).on('click', '.editwo2', function() {
    $('#loadingtable').modal('show');
    // alert('aaa');
    var wonbr = $(this).data('wonbr');
    var btnendel1 = document.getElementById("btndeleteen1");
    var btnendel2 = document.getElementById("btndeleteen2");
    var btnendel3 = document.getElementById("btndeleteen3");
    var btnendel4 = document.getElementById("btndeleteen4");
    var btnendel5 = document.getElementById("btndeleteen5");
    var counter   = document.getElementById('counter').value;
    var counterfail = document.getElementById('counterfail').value;
    $.ajax({
      url: '/womaint/getnowo?nomorwo=' +wonbr,
      success:function(vamp){
        var tempres    = JSON.stringify(vamp);
        var result     = JSON.parse(tempres);
        console.log(result);
        var wonbr      = result[0].wo_nbr;
        var srnbr      = result[0].wo_sr_nbr;
        var en1val     = result[0].woen1;
        var en2val     = result[0].woen2;
        var en3val     = result[0].woen3;
        var en4val     = result[0].woen4;
        var en5val     = result[0].woen5;
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
        var prio       = result[0].wo_priority;
        var wodept     = result[0].wo_dept;
        var note       = result[0].wo_note;
        var rc1        = result[0].rr11;
        var rc2        = result[0].rr22;
        var rc3        = result[0].rr33;
        var wostatus   = result[0].wo_status;
        var rprstatus  = result[0].wo_repair_type;
        var rprgroup   = result[0].wo_repair_group;
        // alert(rprgroup,rprstatus);
        document.getElementById('statusedit').value = wostatus;
        if(fc1 == null || fc1 == ''){
          document.getElementById('divfail1').style.display = 'none';
        }
        else{
          document.getElementById('divfail1').style.display = '';
          document.getElementById('e_failure1').value = fn1;
          document.getElementById('hiddenfail1').value = fc1;
          counterfail = 1;
        }
          
        if(fc2 == null || fc2 == '' ){
          document.getElementById('divfail2').style.display = 'none';
        }  
        else{
            document.getElementById('divfail2').style.display = '';
            document.getElementById('e_failure2').value = fn2;
            document.getElementById('hiddenfail2').value = fc2;
            counterfail = 2;
        }
            
        if(fc3 == null || fc3 == ''){
          document.getElementById('divfail3').style.display = 'none';
        }
        else{
          document.getElementById('divfail3').style.display = '';
          document.getElementById('e_failure3').value = fn3;
          document.getElementById('hiddenfail3').value = fc3;
          counterfail = 3;
        }
        
        if(en1val == null || en1val == ''){
          en1val = '';
        }
        else{
          document.getElementById('diven1').style.display = '';
          counter = 1;
        }

        if(en2val == null || en2val ==''){
          en2val = '';
          document.getElementById('diven2').style.display = 'none';
        }
        else{
          document.getElementById('diven2').style.display = '';
          counter = 2;
        }
        if(en3val == null || en3val ==''){
          en3val = '';
          document.getElementById('diven3').style.display = 'none';
        }
        else{
          document.getElementById('diven3').style.display = '';
          counter = 3;
        }

        if(en4val == null || en4val ==''){
          en4val = '';
          document.getElementById('diven4').style.display = 'none';
        }
        else{
          document.getElementById('diven4').style.display = '';
          counter = 4;
        }

        if(en5val == null || en5val == ''){
          en5val = '';
          document.getElementById('diven5').style.display = 'none';
        }
        else{
          document.getElementById('diven5').style.display = '';
          counter = 5;
        }
        var arrrc= [];
        if(rc1 != null){
          arrrc.push(rc1);
        }
        if(rc2 != null){
          arrrc.push(rc2);
        }
        if(rc3 != null){
          arrrc.push(rc3);
        }
        
        document.getElementById('counter').value     = counter;
        document.getElementById('e_nowo').value      = wonbr;
        document.getElementById('e_nosr').value      = srnbr;
        document.getElementById('e_schedule').value  = schedule;
        document.getElementById('e_duedate').value   = duedate;
        document.getElementById('e_engineer1').value = en1val;
        document.getElementById('e_engineer2').value = en2val;
        document.getElementById('e_engineer3').value = en3val;
        document.getElementById('e_engineer4').value = en4val;
        document.getElementById('e_engineer5').value = en5val;
        document.getElementById('e_asset').value     = asset+' -- '+assdesc;
        document.getElementById('e_assethid').value  = asset;
        document.getElementById('e_note').value      = note;
        document.getElementById('e_failure1').value  = fc1;
        document.getElementById('e_failure2').value  = fc2;
        document.getElementById('e_failure3').value  = fc3;
        document.getElementById('counterfail').value = counterfail;
        document.getElementById('e_priority').value  = prio;
        // document.getElementById('e_department').value = wodept;
        if(rprstatus == 'code'){
          document.getElementById('eargcheck').checked = false;
          document.getElementById('earccheck').checked = true;
          // console.log(arrrc); 
          document.getElementById('erepaircodediv').style.display='';
          document.getElementById('erepairgroupdiv').style.display='none';
          document.getElementById('erepairgroup').value=null;
          $("#erepairgroup").val(null).trigger('change');
          $("#erepaircode").val(arrrc).trigger('change');
          // document.getElementById('erepaircode').value = arrrc;
          // document.getElementById('erepairgroup').value = null;
          // alert(arrrc);
          // alert(document.getElementById('erepaircode').value);
          document.getElementById('repairtypeedit').value = 'code';         
        }
        else if(rprstatus == 'group'){
          document.getElementById('eargcheck').checked = true;
          document.getElementById('earccheck').checked = false;
          document.getElementById('erepairgroupdiv').style.display='';
          document.getElementById('erepaircodediv').style.display='none';
          // alert(repairgroup);
          $("#erepairgroup").val(rprgroup).trigger('change');
          $("#erepaircode").val(null).trigger('change');
          // document.getElementById('erepairgroup').value = repairgroup;
          // document.getElementById('erepaircode').value = null;
          document.getElementById('repairtypeedit').value = 'group';

        }
        // document.getElementById('erepaircode').value = arrrc;
        if (counter == 5){
          document.getElementById('e_addeng').style.display='none';
        }
        else{
          document.getElementById('e_addeng').style.display='';
        } 
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

        for(var i = 1; i<=counter;i++){
          $('#e_engineer'+f).attr('required',true);
        }
        var sisaeng = 5 - counterfail;
        if(sisaeng != 0){
          for(var s = counter+1; s <= 5; s++){
            $('#e_engineer'+s).attr('required',false);
          }
        }
        
        if(wostatus == 'plan'){
          document.getElementById('erepairgroupdiv').style.display = 'none';
          document.getElementById('erepaircodediv').style.display = 'none';
          document.getElementById('edevrepairtype').style.display = 'none';
          document.getElementById('erepaircode').value = null;
          document.getElementById('erepairgroup').value = null;
          if(counterfail == 0){
            document.getElementById('divfail1').style.display = '';
            counterfail = 1
          }
          if(counter == 0){
            counter = 1;
            document.getElementById('diven1').style.display = '';  
          }
          
        }
        else if(wostatus == 'open'){
          document.getElementById('edevrepairtype').style.display = '';
        }

        if(counter >1){
          var deletecount= 'btndeleteen'+counter;
          document.getElementById(deletecount).style.display='';
        }
        // alert(arrrc);
        $("#erepaircode").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
            arrrc
            // theme : 'bootstrap4'
            // arrrc
          });
        // $('#e_repaircode').val(arrrc).trigger('change');
        $('#erepairgroup').select2({
            placeholder:'--Select Repair Group--',
            width:'100%',
            closeOnSelect : true,
            repairgroup
          })
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
        $('#e_engineer1').select2({
          theme: 'bootstrap4',
          width:'100%',
          en1val,
        });
        $('#e_engineer2').select2({
          theme: 'bootstrap4',
          width:'100%',
          en2val,
        });
        
        $('#e_engineer3').select2({
          theme: 'bootstrap4',
          width:'100%',
          en3val,
        });
        $('#e_engineer4').select2({
          theme: 'bootstrap4',
          width:'100%',
          en4val,
        });
        $('#e_engineer5').select2({
          theme: 'bootstrap4',
          width:'100%',
          en5val,
        });

        // $('#e_department').select2({
        //   theme: 'bootstrap4',
        //   width:'100%',
        //   wodept,
        // });
      },complete: function(vamp){
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));
        
          setTimeout(function(){
            $('#loadingtable').modal('hide');
          },500);
        
        
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
        // console.log(rd1);
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
        // alert(arrrc);
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
        document.getElementById('apprwonbr2').value   = wonbr;
        document.getElementById('apprwonbr').value    = wonbr;
        document.getElementById('v_priority').value   = prio;
        document.getElementById('v_note').value       = note;
        document.getElementById('v_dept').value       = wodept;
        document.getElementById('v_creator').value    = creator;
        document.getElementById('v_unconfirm').value  = reason;
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
      url: "/womaint/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woasset=" + woasset+ "&wostatus=" + wostatus + "&wopriority="+wopriority+"&woperiod="+woperiod,
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

  $(document).on('change','#c_engineernum',function(){
    var col = '';
    var engineernum = document.getElementById('c_engineernum').value;
    
    var divengine1 = document.getElementById('testdiv');
    var appendclone = divengine1.cloneNode(true);
    col = '';
    var i;
    if(engineernum != 0 && engineernum <6){
      $('.divenginer').remove();
    for(i =1; i<=engineernum;i++){
      col +='<div class="form-group row col-md-12 divenginer" id="engineer1" >';
      col +='<label for="engineer'+i+'" class="col-md-5 col-form-label text-md-left">Engineer'+i+'</label>';
      col +='<div class="col-md-7">';
      col +='<select id="c_engineer'+i+'" type="text" class="form-control c_engineer" name="c_engineer[]" required>';
      col +='<option value="">--Select Engineer--</option>';
      @foreach ($user as $user2)
      col +='<option value="{{$user2->eng_code}}">{{$user2->eng_desc}}</option>';
      @endforeach
      col+='</select>';
      col+='</div>';
      col+='</div>';
      // var newid = 'engineer'+i;
      //   console.log(newid);
      // document.getElementById('testdiv').append(col);
      $("#testdiv").append(col);
      col='';
      }
      $('.c_engineer').select2({
        placeholder: "Select Data",
        width:'100%',
        theme: 'bootstrap4',
      }); 
    }
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
  $(document).on('click','.reopen',function(){
  
  var wonbr = this.getAttribute('data-wonbr');
  // alert(wonbr);
  document.getElementById('d_rowonbr').textContent = wonbr;
  document.getElementById('tmp_rowonbr').value = wonbr;
  $('#reopenModal').modal('show');  
    
});
$(document).on('click','#createnewwo',function(e){
  document.getElementById('counter').value = 0;
  document.getElementById('counterfail').value = 0;
})
  // set today 
  // var today = new Date().toISOString().split('T')[0];
  // document.getElementsByName("c_duedate")[0].setAttribute('min', today);
  // document.getElementsByName("c_schedule")[0].setAttribute('min', today);
  // document.getElementsByName("e_duedate")[0].setAttribute('min', today);
  // document.getElementsByName("e_schedule")[0].setAttribute('min', today);
  // var object = {
  //   failure1: {
  //     subfailure2:'',
  //     subfailure3:''
  //   },
  //   failure2: {
  //     subfailure1:'',
  //     subfailure3:''
  //   },
  //   failure3: {
  //     subfailure1:'',
  //     subfailure2:''
  //   }
  // }
  // $(document).on('change','#c_failure1',function(e){
  //   var selected1val = document.getElementById('c_failure1').value;
  //   if(object.failure1.subfailure2 != ''){
  //     $('#c_failure2').append(object.failure1.subfailure2);
  //     object.failure1.subfailure2= $('#c_failure2 option[value="'+selected1val+'"]').detach();
  //   }
  //   else{
  //     object.failure1.subfailure2= $('#c_failure2 option[value="'+selected1val+'"]').detach();
  //   }
  //   if(object.failure1.subfailure3 != ''){
  //     $('#c_failure3').append(object.failure1.subfailure3);
  //     object.failure1.subfailure3= $('#c_failure3 option[value="'+selected1val+'"]').detach();
  //   }
  //   else{
  //     object.failure1.subfailure3= $('#c_failure3 option[value="'+selected1val+'"]').detach();
  //   }
  // })

  // $(document).on('change','#c_failure2',function(){
  //   var selected2val = document.getElementById('c_failure2').value;
  //   if(object.failure2.subfailure1 != ''){
  //     $('#c_failure1').append(object.failure2.subfailure1);
  //     object.failure2.subfailure1= $('#c_failure1 option[value="'+selected2val+'"]').detach();
  //   }
  //   else{
  //     object.failure2.subfailure1= $('#c_failure1 option[value="'+selected2val+'"]').detach();
  //   }

  //   if(object.failure2.subfailure3 != ''){
  //     $('#c_failure3').append(object.failure2.subfailure3);
  //     object.failure2.subfailure3= $('#c_failure3 option[value="'+selected2val+'"]').detach();
  //   }
  //   else{
  //     object.failure2.subfailure3= $('#c_failure3 option[value="'+selected2val+'"]').detach();
  //   }
  // })

  // $(document).on('change','#c_failure3',function(){
  //   var selected3val = document.getElementById('c_failure3').value;
  //   if(object.failure3.subfailure1 != ''){
  //     $('#c_failure1').append(object.failure3.subfailure1);
  //     object.failure3.subfailure1= $('#c_failure1 option[value="'+selected3val+'"]').detach();
  //   }
  //   else{
  //     object.failure3.subfailure1= $('#c_failure1 option[value="'+selected3val+'"]').detach();
  //   }
  //   if(object.failure3.subfailure2 != ''){
  //     $('#c_failure2').append(object.failure3.subfailure2);
  //     object.failure3.subfailure2= $('#c_failure2 option[value="'+selected3val+'"]').detach();
  //   }
  //   else{
  //     object.failure3.subfailure2= $('#c_failure2 option[value="'+selected3val+'"]').detach();
  //   }
  // })

  // $(document).on('change','#c_failure1',function(e){
  //   var selected1val = document.getElementById('c_failure1').value;
  //   if(object.failure1.subfailure2 != ''){
  //     $('#c_failure2').append(object.failure1.subfailure2);
  //     object.failure1.subfailure2= $('#c_failure2 option[value="'+selected1val+'"]').detach();
  //   }
  //   else{
  //     object.failure1.subfailure2= $('#c_failure2 option[value="'+selected1val+'"]').detach();
  //   }
  //   if(object.failure1.subfailure3 != ''){
  //     $('#c_failure3').append(object.failure1.subfailure3);
  //     object.failure1.subfailure3= $('#c_failure3 option[value="'+selected1val+'"]').detach();
  //   }
  //   else{
  //     object.failure1.subfailure3= $('#c_failure3 option[value="'+selected1val+'"]').detach();
  //   }
  // })

  // $(document).on('change','#c_failure2',function(){
  //   var selected2val = document.getElementById('c_failure2').value;
  //   if(object.failure2.subfailure1 != ''){
  //     $('#c_failure1').append(object.failure2.subfailure1);
  //     object.failure2.subfailure1= $('#c_failure1 option[value="'+selected2val+'"]').detach();
  //   }
  //   else{
  //     object.failure2.subfailure1= $('#c_failure1 option[value="'+selected2val+'"]').detach();
  //   }

  //   if(object.failure2.subfailure3 != ''){
  //     $('#c_failure3').append(object.failure2.subfailure3);
  //     object.failure2.subfailure3= $('#c_failure3 option[value="'+selected2val+'"]').detach();
  //   }
  //   else{
  //     object.failure2.subfailure3= $('#c_failure3 option[value="'+selected2val+'"]').detach();
  //   }
  // })

  // $(document).on('change','#c_failure3',function(){
  //   var selected3val = document.getElementById('c_failure3').value;
  //   if(object.failure3.subfailure1 != ''){
  //     $('#c_failure1').append(object.failure3.subfailure1);
  //     object.failure3.subfailure1= $('#c_failure1 option[value="'+selected3val+'"]').detach();
  //   }
  //   else{
  //     object.failure3.subfailure1= $('#c_failure1 option[value="'+selected3val+'"]').detach();
  //   }

  //   if(object.failure3.subfailure2 != ''){
  //     $('#c_failure2').append(object.failure3.subfailure2);
  //     object.failure3.subfailure2= $('#c_failure2 option[value="'+selected3val+'"]').detach();
  //   }
  //   else{
  //     object.failure3.subfailure2= $('#c_failure2 option[value="'+selected3val+'"]').detach();
  //   }
  // })


$(document).on('click', '.accepting', function() {
    var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
    // $('#loadingtable').modal('hide');
    $('#loadingtable').modal('show');
    var counter   = document.getElementById('v_counter').value;
    
    $.ajax({
      url: '/womaint/getnowo?nomorwo=' +wonbr,
      success:function(vamp){
        var tempres     = JSON.stringify(vamp);
        var result      = JSON.parse(tempres);
        var wonbr       = result[0].wo_nbr;
        var srnbr       = result[0].wo_sr_nbr;
        var asset       = result[0].asset_desc;
        var wostatus    = result[0].wo_status;
        var repair1     = result[0].rr11;
        var repair2     = result[0].rr22;
        var repair3     = result[0].rr33;
        var en1val      = result[0].u11;
        var en2val      = result[0].u22;
        var en3val      = result[0].u33;
        var en4val      = result[0].u44;
        var en5val      = result[0].u55;
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
        var repairhour  = result[0].wo_repair_hour;
        var finishdate  = result[0].wo_finish_date;
        var finishtime  = result[0].wo_finish_time;
        var note        = result[0].wo_approval_note;
        var repairtype  = result[0].wo_repair_type;
        var repairgroup = result[0].xxrepgroup_desc;
        var superappdate = result[0].wo_reviewer_appdate;
        var apprdate = result[0].wo_approval_appdate;
        // alert(srnbr);
        // alert(repairhour)
        if(fc1 == null || fc1 == ''){
          document.getElementById('acdivfail1').style.display = 'none';
        }
        else{
          document.getElementById('acdivfail1').style.display = '';
          document.getElementById('ac_failure1').value = fn1;
          
          counterfail = 1;
        }
          
        if(fc2 == null || fc2 == '' ){
          document.getElementById('acdivfail2').style.display = 'none';
        }  
        else{
            document.getElementById('acdivfail2').style.display = '';
            document.getElementById('ac_failure2').value = fn2;
            
            counterfail = 2;
        }
            
        if(fc3 == null || fc3 == ''){
          document.getElementById('acdivfail3').style.display = 'none';
        }
        else{
          document.getElementById('acdivfail3').style.display = '';
          document.getElementById('ac_failure3').value = fn3;
          
          counterfail = 3;
        }
        
        if(en1val == null || en1val == ''){
          en1val = '';
        }
        else{
          document.getElementById('acdivengineer1').style.display = '';
          counter = 1;
        }

        if(en2val == null || en2val ==''){
          en2val = '';
          document.getElementById('acdivengineer2').style.display = 'none';
        }
        else{
          document.getElementById('acdivengineer2').style.display = '';
          counter = 2;
        }
        if(en3val == null || en3val ==''){
          en3val = '';
          document.getElementById('acdivengineer3').style.display = 'none';
        }
        else{
          document.getElementById('acdivengineer3').style.display = '';
          counter = 3;
        }

        if(en4val == null || en4val ==''){
          en4val = '';
          document.getElementById('acdivengineer4').style.display = 'none';
        }
        else{
          document.getElementById('acdivengineer4').style.display = '';
          counter = 4;
        }

        if(en5val == null || en5val == ''){
          en5val = '';
          document.getElementById('acdivengineer5').style.display = 'none';
        }
        else{
          document.getElementById('acdivengineer5').style.display = '';
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

        var event = new Event('change',{"bubbles": true});
        // alert(arrrc);
        document.getElementById('apprwonbr3').value   = wonbr;
        document.getElementById('apprsrnbr3').value   = srnbr;
        document.getElementById('counter').value      = counter;
        document.getElementById('ac_engineer1').value = en1val;
        document.getElementById('ac_engineer2').value = en2val;
        document.getElementById('ac_engineer3').value = en3val;
        document.getElementById('ac_engineer4').value = en4val;
        document.getElementById('ac_engineer5').value = en5val;
        document.getElementById('ac_failure1').value  = fn1;
        document.getElementById('ac_failure2').value  = fn2;
        document.getElementById('ac_failure3').value  = fn3;
        document.getElementById('counterfail').value  = counterfail;
        document.getElementById('apprwonbr2').value   = wonbr;
        document.getElementById('apprwonbr').value    = wonbr;
        document.getElementById('c_finishtime').value = finishtime;
        document.getElementById('c_finishdate').value = finishdate;
        document.getElementById('c_repairhour').value = repairhour;
        document.getElementById('statuswo').value     = wostatus;
        document.getElementById('v_counter').value    = counter;
        document.getElementById('ac_wonbr2').value    = wonbr;
        document.getElementById('ac_srnbr2').value    = srnbr;
        document.getElementById('ac_asset2').value    = asset;
        
        document.getElementById('ac_note').value      = note;
        if(repairtype == 'code'){
          var textareaview = document.getElementById('ac_repaircode');
          textareaview.value = arrrc.join("\n");
          document.getElementById('divaccode').style.display = '';
          document.getElementById('divacgroup').style.display = 'none';
        }
        else if (repairtype == 'group'){
          
          var vgroup = document.getElementById('ac_repairgroup').value = result[0].xxrepgroup_nbr + ' -- ' + repairgroup;
          document.getElementById('divaccode').style.display = 'none';
          document.getElementById('divacgroup').style.display = '';
        }
        else{
          document.getElementById('divaccode').style.display = 'none';
          document.getElementById('divacgroup').style.display = 'none';
        }
        if(superappdate == null){
          document.getElementById('formtype').value = 1;
        }
        else if (superappdate != null){
          document.getElementById('formtype').value = 2;
        }
        // uploadImage();
        $.ajax({
          url: "/imageview",
          data : {
              wonumber: wonbr,
          },success: function(data){
            console.log(data);
            var totalgambar = data.length;
            if(totalgambar <=0){
              document.getElementById('photodiv').style.display = 'none';

            }
            else{
              document.getElementById('photodiv').style.display = '';
            }
            

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
        
      },
      complete: function(vamp){
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));
        
        setTimeout(function(){
            $('#loadingtable').modal('hide');

          },500);
        
        setTimeout(function(){
            $('#acceptModal').modal('show');  
          },1000);
        
      }

    })
  });
 

  $(document).on('change','#e_failure1',function(e){
  document.getElementById('hiddenfail1').value = document.getElementById('e_failure1').value;
  
})
$(document).on('change','#e_failure2',function(e){
  document.getElementById('hiddenfail2').value = document.getElementById('e_failure2').value;
  
})
$(document).on('change','#e_failure3',function(e){
  document.getElementById('hiddenfail3').value = document.getElementById('e_failure3').value;
  
})

  // $(document).on('change','#repaircode1',function(event){
    //   var rc1 = document.getElementById('repaircode1').value;
    //   $.ajax({
    //     url: "/getrepair1/" + rc1,
    //     success: function(data) {
    //       var tempres    = JSON.stringify(data);
    //       var result     = JSON.parse(tempres);
    //       var len = result.length;
    //       var col = '';
    //       var currenttype;
    //       var currentnum = 1;
    //       if(len >0){
    //       col +='<div class="form-group row col-md-12 divrepcode" >';
    //       col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
    //       col +='</div>';
    //       col+='<div class="table-responsive col-12">';
    //       col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
    //       col+='<thead>';
    //       col+='<tr style="text-align: center;style="border:2px solid"">';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Part</p></th>';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
    //       col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
    //       col+='</tr>';
    //       col+='<tr style="text-align: center;">';
    //       col+='<th style="border:2px solid">Baik</th>';
    //       col+='<th style="border:2px solid">Tidak</th>';
    //       col+='</tr>';
    //       col+='</thead>';
    //       col+='<tbody style="border:2px solid" >';
    //       for(i =0; i<len;i++){
    //         if(currenttype !== result[i].spt_code){
    //           if(result[i].spt_code == null){
    //             col+='<tr >';
                
    //             col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'Lain-lain</b></p></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>'; 
    //             col+='</tr>';
    //             currenttype = result[i].spt_code;
    //             currentnum +=1;
    //           }
    //           else{
    //             col+='<tr>';  
    //             col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'.'+result[0].spt_desc+'</b></p></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='</tr>';
    //             currenttype = result[i].spt_code;
    //             currentnum +=1;
    //           }
    //         }
    //         col+='<tr>';
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>'
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].repdet_std+'</b></p></td>';
    //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="checkbox" name="group1[group'+i+']" id="item'+i+'" value="y'+i+'" readonly></td>';
    //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="checkbox" name="group1[group'+i+']" id="item'+i+'" value="n'+i+'" readonly></td>';
    //         col+='</tr>';
    //       }
    //       col+='</tbody>';
    //       col+='</table>';
    //       col+='</div>';
    //       $("#testdiv").append(col);
    //       col='';
        
    //       }  
    //     }
    //   })
    // })
    // $(document).on('change','#repaircode2',function(event){
    //   var rc2 = document.getElementById('repaircode2').value;
    //   $.ajax({
    //     url: "/getrepair1/" + rc2,
    //     success: function(data) {
    //       var tempres    = JSON.stringify(data);
    //       var result     = JSON.parse(tempres);
    //       var len = result.length;
    //       var col = '';
    //       var currenttype;
    //       var currentnum = 1;
    //       if(len >0){
    //       col +='<div class="form-group row col-md-12 divrepcode" >';
    //       col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
    //       col +='</div>';
    //       col+='<div class="table-responsive col-12">';
    //       col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
    //       col+='<thead>';
    //       col+='<tr style="text-align: center;style="border:2px solid"">';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Part</p></th>';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
    //       col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
    //       col+='</tr>';
    //       col+='<tr style="text-align: center;">';
    //       col+='<th style="border:2px solid">Baik</th>';
    //       col+='<th style="border:2px solid">Tidak</th>';
    //       col+='</tr>';
    //       col+='</thead>';
    //       col+='<tbody style="border:2px solid" >';
    //       for(i =0; i<len;i++){
    //         if(currenttype !== result[i].spt_code){
    //           if(result[i].spt_code == null){
    //             col+='<tr >';
                
    //             col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'Lain-lain</b></p></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>'; 
    //             col+='</tr>';
    //             currenttype = result[i].spt_code;
    //             currentnum +=1;
    //           }
    //           else{
    //             col+='<tr>';  
    //             col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'.'+result[0].spt_desc+'</b></p></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='</tr>';
    //             currenttype = result[i].spt_code;
    //             currentnum +=1;
    //           }
    //         }
    //         col+='<tr>';
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>'
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].repdet_std+'</b></p></td>';
    //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="checkbox" name="group2[group'+i+']" id="item'+i+'" value="y'+i+'" readonly></td>';
    //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="checkbox" name="group2[group'+i+']" id="item'+i+'" value="n'+i+'" readonly></td>';
    //         col+='</tr>';
    //       }
    //       col+='</tbody>';
    //       col+='</table>';
    //       col+='</div>';
    //       $("#testdiv2").append(col);
    //       col='';
        
    //       }  
    //     }
    //   })
    // })
    // $(document).on('change','#repaircode3',function(event){
    //   var rc3 = document.getElementById('repaircode3').value;
    //   $.ajax({
    //     url: "/getrepair1/" + rc3,
    //     success: function(data) {
    //       var tempres    = JSON.stringify(data);
    //       var result     = JSON.parse(tempres);
    //       var len = result.length;
    //       var col = '';
    //       var currenttype;
    //       var currentnum = 1;
    //       if(len >0){
    //       col +='<div class="form-group row col-md-12 divrepcode" >';
    //       col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
    //       col +='</div>';
    //       col+='<div class="table-responsive col-12">';
    //       col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
    //       col+='<thead>';
    //       col+='<tr style="text-align: center;style="border:2px solid"">';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Part</p></th>';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
    //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
    //       col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
    //       col+='</tr>';
    //       col+='<tr style="text-align: center;">';
    //       col+='<th style="border:2px solid">Baik</th>';
    //       col+='<th style="border:2px solid">Tidak</th>';
    //       col+='</tr>';
    //       col+='</thead>';
    //       col+='<tbody style="border:2px solid" >';
    //       for(i =0; i<len;i++){
    //         if(currenttype !== result[i].spt_code){
    //           if(result[i].spt_code == null){
    //             col+='<tr >';
                
    //             col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'Lain-lain</b></p></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>'; 
    //             col+='</tr>';
    //             currenttype = result[i].spt_code;
    //             currentnum +=1;
    //           }
    //           else{
    //             col+='<tr>';  
    //             col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'.'+result[0].spt_desc+'</b></p></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='<td style="height: 20px;border:2px solid"></td>';
    //             col+='</tr>';
    //             currenttype = result[i].spt_code;
    //             currentnum +=1;
    //           }
    //         }
    //         col+='<tr>';
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>'
    //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].repdet_std+'</b></p></td>';
    //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="checkbox" name="group3[group'+i+']" id="item'+i+'" value="y'+i+'" readonly></td>';
    //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="checkbox" name="group3[group'+i+']" id="item'+i+'" value="n'+i+'" readonly></td>';
    //         col+='</tr>';
    //       }
    //       col+='</tbody>';
    //       col+='</table>';
    //       col+='</div>';
    //       $("#testdiv3").append(col);
    //       col='';
        
    //       }  
    //     }
    //   })
    // })
  $(document).on('click','#aprint',function(event){
    var wonbr = document.getElementById('ac_wonbr2').value;
    var url = "{{url('openprint2','id')}}";
        // var newo = JSON.stringify(wonbr);
        url = url.replace('id', wonbr);
        // alert(url);
        document.getElementById('aprint').href=url;
  });
  
  $("#acceptance").submit(function() {
    document.getElementById('btnclose').style.display = 'none';
    document.getElementById('btnreject').style.display = 'none';
    document.getElementById('btnapprove').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
});

// function uploadImage() {
//   var button = $('.images .pic')
//   var uploader = $('<input type="file" accept="image/jpeg, image/png, image/jpg" />')
//   var images = $('.images')
//   var potoArr = [];
//   var initest = $('.images .img span #imgname')
      
//   button.on('click', function () {
//     uploader.click();
//   })
      
//   uploader.on('change', function () {
//     var reader = new FileReader();
//     i = 0;
//     reader.onload = function(event) {
//     images.prepend('<div id="img" class="img" style="background-image: url(\'' + event.target.result + '\');" rel="'+ event.target.result  +'"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
//     // alert(JSON.stringify(uploader));
//       document.getElementById('imgname').value = uploader[0].files.item(0).name+','+event.target.result; 
//       document.getElementById('hidden_var').value = 1;
//     }
//     reader.readAsDataURL(uploader[0].files[0])
//           // potoArr.push(uploader[0].files[0]);

//           // console.log(potoArr);
//       })


//       images.on('click', '.img', function () {        
//         $(this).remove();
//       })
      
//       // confirmPhoto(potoArr);
// }



// $(document).ready(function(){
//   // submit();
//  $('#file-input').on('change', function(){ //on file input change
//     if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
//     {
         
//         var data = $(this)[0].files; //this file data
//         console.log(data);
//         $.each(data, function(index, file){ //loop though each file
//             if(/(\.|\/)(jpe?g|png)$/i.test(file.type)){ //check supported file type
//                 var fRead = new FileReader(); //new filereader
//                 fRead.onload = (function(file){ //trigger function on successful read
//                 return function(e) {
//                     var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
//                     $('#thumb-output').append(img); //append image to output element
//                 };
//                 })(file);
//                 fRead.readAsDataURL(file); //URL representing the file's data.
//             }
//         });

//         $("#thumb-output").on('click', '.thumb', function () {
//           $(this).remove();
//         })
         
//     }else{
//         // alert("Your browser doesn't support File API!");
//         swal.fire({
//                       position: 'top-end',
//                       icon: 'error',
//                       title: "Your browser doesn't support File API!",
//                       toast: true,
//                       showConfirmButton: false,
//                       timer: 2000,
//         }) //if File API is absent
//     }
//  });
// });

$(document).on('click','#ac_btnuncom',function(event){
  document.getElementById('switch2').value = 'reject';
  var rejectreason = document.getElementById('uncompletenote').value;
      
      // event.preventDefault();
      // $('#approval')
      
      if(rejectreason == ""){
          $("#t_photo").attr('required', false);
          $("#uncompletenote").attr('required', true);
        }else{
          // alert('masuk sini');
          $("#t_photo").attr('required', false);
          $("#uncompletenote").attr('required', true);
          $('#acceptance').submit();

        }
})

$(document).on('click','#ac_btncom',function(event){
  document.getElementById('switch2').value = 'approve';

  $("#uncompletenote").attr('required', false);
  $('#acceptance').submit();
})
</script>
@endsection