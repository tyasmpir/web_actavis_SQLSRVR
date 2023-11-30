@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark">WO Create Without Approval</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-3">
          <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">
          Work Order Create</button>
          </div> -->
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<style>
.swal-popup{
  font-size: 2rem !important;
}
hr.new1{
  border-top: 1px solid red !important;
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
  background-color: #dcdcdc;
  align-self: center;
  text-align: center;
  padding: 40px 0;
  text-transform: uppercase;
  color: #000000;
  font-size: 12px;
  cursor: pointer;
}
</style>
<!-- Flash Menu -->

<!--Table Menu-->

<!-- <hr style="margin:0%"> -->

<div class="col-md-12">
  <form class="form-horizontal" id="new" method="post" action="createdirectwo" autocomplete="off" style="background-color: #ffffff; padding: 2%;" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="repairtype" id="repairtype">
    <input type="hidden"  id="v_counter">
    <input type="hidden" name="statuswo" id="statuswo">
    <div class="form-group row col-md-12 c_engineerdiv">
      <label for="c_engineer" class="col-md-3 mt-3 col-form-label text-md-left">Engineer</label>
      <div class="col-md-6">
        <input type="text" id="c_engineer"  class="form-control c_engineer mt-3" value="{{Session::get('name')}}"  readonly>
        <input type="hidden" id="engineercreate"  class="form-control engineercreate" name="engineercreate" value="{{Session::get('username')}}" >
      </div>
    </div>
    <div class="form-group row col-md-12 c_engineerdiv">
            <label for="c_engineernum" class="col-md-3 col-form-label text-md-left">Other Engineer</label>
            <div class="col-md-6">
            <select id="c_engineeroth"  class="form-control c_engineeroth" name="c_engineeroth[]"  multiple="multiple" autofocus >
              @foreach($engine as $enginee)
                <option value="{{$enginee->eng_code}}">{{$enginee->eng_code}} -- {{$enginee->eng_desc}}</option>

                @endforeach
              </select>
            </div>
          </div>
    <div class="form-group row col-md-12" id="cdevwotype">
              <label for="cwotype" class="col-md-3 col-form-label text-md-left">WO Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
              <div class="col-md-7" style="vertical-align:middle;">
                <input class=" d-inline" type="radio" name="cwotype" id="cpreventive" value="preventive">
                <label class="form-check-label" for="cpreventive" style="font-size:15px">
                  Preventive
                </label>

                <input class="d-inline ml-5" type="radio"  name="cwotype" id="cwomanual" value="manual">
                <label class="form-check-label" for="cwomanual" style="font-size:15px">
                  Work Order
                </label>
              </div>  
          </div>
    <div class="form-group row col-md-12">
      <label for="c_asset" class="col-md-3 col-form-label text-md-left">Asset <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-6">
      <select id="c_asset" type="text" class="form-control c_asset" name="c_asset" autofocus required>
          <option value="">--Select Asset--</option>
          @foreach ($asset2 as $asset2)
            <option value="{{$asset2->asset_code}}">{{$asset2->asset_code}} -- {{$asset2->asset_desc}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group row col-md-12 c_wottypediv" id="c_wottypediv" style="display: none;">
            <label for="c_wottype" class="col-md-3 col-form-label text-md-left">Work Order Type</label>
            <div class="col-md-6">
              <select id="c_wottype"  class="form-control c_wottype" name="c_wottype"  autofocus required >
                <option value="" selected>Select Work Order Type</option>
                @foreach($wottype as $c_wottype)
                <option value="{{$c_wottype->wotyp_code}}">{{$c_wottype->wotyp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12 c_impactdiv" id="c_impactdiv" style="display: none;">
            <label for="c_impact" class="col-md-3 col-form-label text-md-left">Impact</label>
            <div class="col-md-6">
              <select id="c_impact"  class="form-control c_impact" name="c_impact[]"  multiple="multiple" required autofocus >
                <!-- <option value="" selected>Select Impact</option> -->
                @foreach($impact as $c_impact)
                <option value="{{$c_impact->imp_code}}">{{$c_impact->imp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
    <div id="failurediv">
    
    </div>
          <div class="form-group row col-md-12 " id="divrepairtype">
            <label for="repaircode" class="col-md-3 col-form-label text-md-left">Repair Type </label>
            <div class="row col-md-7" style="vertical-align:middle;">
              <div class="col-md-4" id="argcheckdiv" style="display: none;">
                <input class=" d-inline" type="radio" name="repairtype" id="argcheck" value="group" style="display:none">
                <label class="form-check-label" for="argcheck" >
                  Repair Group
                </label>
              </div>
              <div class="col-md-4" id="arccheckdiv" style="display: none;">

                <input class="d-inline" type="radio"  name="repairtype" id="arccheck" value="code" style="display:none">
                <label class="form-check-label" for="arccheck">
                  Repair Code
                </label>
              </div>
              <!-- <div class="col-md-4" id="arcmanualdiv" style="display: none;">
                <input class="d-inline" type="radio"  name="repairtype" id="arcmanual" value="manual" style="display:none">
                <label class="form-check-label" for="arcmanual">
                  Manual
                </label>
              </div> -->
            </div>
          </div>

          <div class="col-md-12 p-0" id="divgroup" style="display: none;">
            <div class="form-group row col-md-12 divrepgroup" >
                <label for="repairgroup" class="col-md-3 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-7">
                  <input type="hidden" id="inputgroup1">
                  <select id="repairgroup" type="text" class="form-control repairgroup" name="repairgroup[]"  autofocus>
                  <option value="" selected disabled>--Select Repair Group--</option>
                  @foreach($repairgroup as $rp)
                    <option value="{{$rp->xxrepgroup_nbr}}">{{$rp->xxrepgroup_nbr}} -- {{$rp->xxrepgroup_desc}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div id="testdivgroup">
            
            </div>
          </div>

          <div class="col-md-12 p-0" id="divmanual" style="display: none;">
            <div class="form-group row col-md-12 divrepgroup" >
                <label for="manualcount" class="col-md-3 col-form-label text-md-left">Number of part repaired <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-7">
                  <input type="hidden" id="inputgroup1">
                  <select id="manualcount" type="text" class="form-control repairgroup" name="manualcount"  autofocus>
                    <option value="" selected disabled>--Number of part repaired--</option>                  
                    @for($co = 1; $co<=50; $co++)
                      <option value="{{$co}}">{{$co}}</option>
                    @endfor
                  </select>
                </div>
            </div>
            <div id="testmanual">
            
            </div>
          </div>

          <div class="col-md-12 p-0" id="divrepair" style="display: none;">
            <div class="form-group row col-md-12 divrepcode" >
              <label for="repaircode1" class="col-md-3 col-form-label text-md-left">Repair Code 1 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
              <div class="col-md-7">
                <input type="hidden" id="inputrepair1">
                <select id="repaircode1" type="text" class="form-control repaircode1" name="repaircode1[]"  autofocus>
                <option value="" selected disabled>--Select Repair Code--</option>
            @foreach ($repaircode as $repaircode2)
              <option value="{{$repaircode2->repm_code}}">{{$repaircode2->repm_code}} -- {{$repaircode2->repm_desc}}</option>
            @endforeach
              </select>
              </div>
            </div>
            <div id="testdiv">
            
            </div>
            <!-- <div class="form-group row col-md-12 divrepcode" >
              <label for="repaircode2" class="col-md-3 col-form-label text-md-left">Repair Code 2</label>
              <div class="col-md-7">
              <input type="hidden" id="inputrepair2">
                <select id="repaircode2" type="text" class="form-control repaircode2" name="repaircode2[]"  autofocus>
                <option value="" selected disabled>--Select Repair Code--</option>
              @foreach ($repaircode as $repaircode3)
                <option value="{{$repaircode3->repm_code}}">{{$repaircode3->repm_code}} -- {{$repaircode3->repm_desc}}</option>
              @endforeach
                </select>
              </div>
            </div>
            <div id="testdiv2">
            
            </div>
            <div class="form-group row col-md-12 divrepcode" >
              <label for="repaircode3" class="col-md-3 col-form-label text-md-left">Repair Code 3</label>
              <div class="col-md-7">
                <input type="hidden" id="inputrepair3">
                <select id="repaircode3" type="text" class="form-control repaircode3" name="repaircode3[]"  autofocus>
                <option value="" selected disabled>--Select Repair Code--</option>
              @foreach ($repaircode as $repaircode4)
                <option value="{{$repaircode4->repm_code}}">{{$repaircode4->repm_code}} -- {{$repaircode4->repm_desc}}</option>
              @endforeach
                </select>
              </div>
            </div>
            <div id="testdiv3">
            
            </div> -->
          </div> 

    <div class="form-group row col-md-12">
      <label for="c_schedule" class="col-md-3 col-form-label text-md-left">Schedule Date <span id="alert1" style="color: red; font-weight: 100;">*</span></label>
      <div class="col-md-3">
        <input type="date" id="c_schedule"  class="form-control" name="c_schedule" value="{{ old('scheduledate') }}" autocomplete="off" maxlength="20" autofocus required>
      </div>
 
    
      <label for="c_duedate" class="col-md-2 col-form-label text-md-right">Due Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-3">
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
    <div class="form-group row col-md-12 c_engineerdiv">
      <!-- <label for="c_repairhour" class="col-md-2 col-form-label text-md-left">Repair Hour <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-1">
        <input id="c_repairhour" type="number" class="form-control c_repairhour" name="c_repairhour" min='1'  autofocus required>
      </div> -->

      <label for="c_finishdate" class="col-md-3 col-form-label text-md-left">Finish Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-3">
        <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" autofocus required>
      </div>
   
      <label for="c_finishtime" class="col-md-2 col-form-label text-md-right">&nbsp;Finish Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-2">
        <select id="c_finishtime" class="form-select c_finishtime mt-1"  name="c_finishtime" style="border:2px solid #ced4da;border-radius:.25rem" autofocus required>
          <option value=''></option>
          <option value='00'>00</option>
          <option value='01'>01</option>
          <option value='02'>02</option>
          <option value='03'>03</option>
          <option value='04'>04</option>
          <option value='05'>05</option>
          <option value='06'>06</option>
          <option value='07'>07</option>
          <option value='08'>08</option>
          <option value='09'>09</option>
          <option value='10'>10</option>
          <option value='11'>11</option>
          <option value='12'>12</option>
          <option value='13'>13</option>
          <option value='14'>14</option>
          <option value='15'>15</option>
          <option value='16'>16</option>
          <option value='17'>17</option>
          <option value='18'>18</option>
          <option value='19'>19</option>
          <option value='20'>20</option>
          <option value='21'>21</option>
          <option value='22'>22</option>
          <option value='23'>23</option>
        </select>
        :
        <select id="c_finishtimeminute" class="form-select c_finishtime" name="c_finishtimeminute" style="border:2px solid #ced4da;border-radius:.25rem" autofocus required>
          <option value=''></option>
          <option value='00'>00</option>
          <option value='01'>01</option>
          <option value='02'>02</option>
          <option value='03'>03</option>
          <option value='04'>04</option>
          <option value='05'>05</option>
          <option value='06'>06</option>
          <option value='07'>07</option>
          <option value='08'>08</option>
          <option value='09'>09</option>
          @for ($i = 10; $i < 60; $i++)
          <option value='{{$i}}'>{{$i}}</option>
          @endfor
        </select>
      </div>
    </div>
    <div id="manualonly" style='display:none'>
            
    <div class="form-group row col-md-12">
            <label for="o_action" class="col-md-3 col-form-label text-md-left">Action Taken</label>
            <div class="col-md-8">
              <textarea class="form-control" name="o_action" id="o_action" rows="4"></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="o_part" class="col-md-3 col-form-label text-md-left">Sparepart</label>
            <div class="col-md-8">
              <textarea class="form-control" name="o_part" id="o_part"></textarea>
            </div>
          </div>
            <!-- <div class="form-group row col-md-12 c_lastmeasurement">
              <label for="c_repairhour" class="col-md-5 col-form-label text-md-left">Last Measurement</label>
              <div class="col-md-7">
                <input id="c_lastmeasurement" type="number" class="form-control c_repairhour" name="c_lastmeasurement" min='1' step="0.01" readonly>
              </div>
            </div>
            <div class="form-group row col-md-12 c_engineerdiv">
              <label for="c_lastmeasurementdate" class="col-md-5 col-form-label text-md-left">Last Maintenance</label>
              <div class="col-md-7">
                <input id="c_lastmeasurementdate" type="date" class="form-control c_lastmeasureentdate" name="c_lastmeasurementdate"  readonly>
              </div>
            </div> -->
          </div> 
    <div class="form-group row col-md-12">
      <label for="c_priority" class="col-md-3 col-form-label text-md-left">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-3">
        <select id="c_priority"  class="form-control" name="c_priority"  autocomplete="off" autofocus required placeholder=>
          <option value='' disabled selected>--select priority--</option>
          <option value='low'>Low</option>
          <option value='medium'>Medium</option>
          <option value='high'>High</option>
        </select>
      </div>
    </div>
    <div class="form-group row col-md-12">
      <label for="c_note" class="col-md-3 col-form-label text-md-left">Note</label>
      <div class="col-md-6">
      <textarea id="c_note" class="form-control c_note" name="c_note" autofocus></textarea>
      </div>
    </div>
    <!-- <div class="form-group row col-md-12">
      <label class="col-md-12 col-form-label text-md-left">Photo Upload :  </label>
    </div>
    <div class="form-group row col-md-12" style="margin-bottom: 10%;">
        <div class="col-md-12 images">
            <div class="pic">
                add
            </div>
        </div>
    </div> -->
    <div class="form-group row col-md-12">
      <label for="c_part" class="col-md-3 col-form-label text-md-left">Upload File</label>
      <div class="col-md-6">
        <input type="file" name="filenamewo[]" class="form-control" multiple>
      </div>
    </div>
    <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
    <input type="hidden" id="repairtypenow" name="repairpartnow"  />
    <div class="form-group row col-md-12">
      <div class="col-md-1">
      </div>
      <div class="col-md-6" style="float: right">
      <button type="submit" class="btn btn-success bt-action float-right" id="btnconf">Save</button>
      <button type="button" class="btn btn-info bt-action float-right mr-2" id="btnclose" data-dismiss="modal">Cancel</button>

        <button type="button" class="btn btn-block btn-info float-right" id="btnloading" style="display:none">
          <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
        </button>
      </div>

    </div>
  </form>
</div>

<!--Modal Create-->

<!--Modal Edit-->



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


  // flag tunggu semua menu

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
          col +='<label for="failure'+i+'" class="col-md-3 col-form-label text-md-left">Failure Code '+i+'</label>';
          col +='<div class="col-md-4">';
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
  $('#c_engineeroth').select2({
          placeholder: "Select Value",
          width:'100%',
          closeOnSelect : false,
          allowClear : true,
          theme: 'bootstrap4',
          maximumSelectionLength: 4
    });

  $(document).on('change','#c_asset',function(){
    var assetval = document.getElementById('c_asset').value;
    if(assetval == ''){
      document.getElementById('c_wottypediv').style.display='none';
      document.getElementById('c_impactdiv').style.display='none'; 
    }
    else{
      document.getElementById('c_wottypediv').style.display=''; 
      document.getElementById('c_impactdiv').style.display=''; 
    }
    $('#c_wottype').select2({
          placeholder: "Select Value",
          width:'100%',
          theme: 'bootstrap4',
    });
    $('#c_impact').select2({
          placeholder: "Select Value",
          width:'100%',
          closeOnSelect : false,
          allowClear : true,
          theme: 'bootstrap4',
    });
  });
  $(document).on('change','#cpreventive',function(e){
    if(this.checked == true){
      //document.getElementById('manualonly').style.display='none';
      //document.getElementById('argcheckdiv').style.display="";
      document.getElementById('arccheckdiv').style.display="";
      //document.getElementById('arcmanualdiv').style.display="";
    }
  });

  $(document).on('change','#cwomanual',function(e){

    if(this.checked==true){
      //document.getElementById('manualonly').style.display='';
      //document.getElementById('argcheckdiv').style.display="";
      document.getElementById('arccheckdiv').style.display="";
      //document.getElementById('arcmanualdiv').style.display="none";
    }
  });

   $(document).on('change','#arccheck',function(e){
    // alert('aaa');
    document.getElementById('divrepair').style.display='';
    document.getElementById('divgroup').style.display='none';  
    document.getElementById('divmanual').style.display='none';
    
    

    // alert('aaa');

    $("#manualcount").val(null).trigger('change');
    $("#repairgroup").val(null).trigger('change');
    $("#repaircode1").val(null).trigger('change');
    $("#repaircode2").val(null).trigger('change');
    $("#repaircode3").val(null).trigger('change');

    document.getElementById('repairtype').value= 'code';
  });
  
  $(document).on('change','#argcheck',function(e){
    document.getElementById('divgroup').style.display='';
    document.getElementById('divrepair').style.display='none';
    document.getElementById('divmanual').style.display='none';
    $("#manualcount").val(null).trigger('change');
    $("#repairgroup").val(null).trigger('change');
    $("#repaircode1").val(null).trigger('change');
    $("#repaircode2").val(null).trigger('change');
    $("#repaircode3").val(null).trigger('change');
    document.getElementById('repairtype').value= 'group';
  });

  $(document).on('change','#arcmanual',function(e){
    document.getElementById('divmanual').style.display='';
    document.getElementById('divgroup').style.display='none';
    document.getElementById('divrepair').style.display='none';
    $("#manualcount").val(null).trigger('change');
    $("#repairgroup").val(null).trigger('change');
    $("#repaircode1").val(null).trigger('change');
    $("#repaircode2").val(null).trigger('change');
    $("#repaircode3").val(null).trigger('change');
    document.getElementById('repairtype').value= 'manual';
  });

  $('#repairgroup').select2({
        placeholder: "Select Data",
        width:'100%',
        theme: 'bootstrap4',
      });
  $('#repaircode1').select2({
        placeholder: "Select Data",
        width:'100%',
        theme: 'bootstrap4',
      });
  $('#repaircode2').select2({
        placeholder: "Select Data",
        width:'100%',
        theme: 'bootstrap4',
  });
  $('#repaircode3').select2({
        placeholder: "Select Data",
        width:'100%',
        theme: 'bootstrap4',
  });
  var object = {
  spare1: 0,
  spare2: 0,
  spare3: 0
  }

  // $(document).on('change','#repaircode1',function(event){
  //   var rc1 = document.getElementById('repaircode1').value;
  //   // alert(rc1);
  //   $("#testdiv").html('');
  //   if(rc1 != ''){
  //   $.ajax({
  //     url: "/getrepair1/" + rc1,
  //     success: function(data) {
        
  //       var tempres    = JSON.stringify(data);
  //       var result     = JSON.parse(tempres);
  //       // console.log(result[0]);
  //       console.log(result);
  //       var len        = result.length;
  //       var col        = '';
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
  //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
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
  //       col+='<tr>';
  //       col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_code+'</b></p></td>';
  //       col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_desc+'</b></p></td>';
  //       col+='<td style="height: 20px;border:2px solid"></td>';
  //       col+='<td style="height: 20px;border:2px solid"></td>';
         
  //       col+='<td style="height: 20px;border:2px solid"></td>'; 
  //       col+='</tr>';
  //       for(i =0; i<len;i++){
          
  //         // alert(result[i].spm_desc);
  //         if(result[i].spm_desc == null){
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //         }
  //         else{
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
  //         }
          
  //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
  //         if(result[i].ins_check == null){
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //         }
  //         else{
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
  //         }
          
  //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group1[group'+i+']" id="item'+i+'" value="y'+i+'"></td>';
  //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group1[group'+i+']" id="item'+i+'" value="n'+i+'"></td>';
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
  //   }
  // })
  // $(document).on('change','#repaircode2',function(event){
  //   var rc2 = document.getElementById('repaircode2').value;
  //   $("#testdiv2").html('');
  //   if(rc2 != ''){
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
  //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
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
  //       col+='<tr>';
  //       col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_code+'</b></p></td>';
  //       col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_desc+'</b></p></td>';
  //       col+='<td style="height: 20px;border:2px solid"></td>';
  //       col+='<td style="height: 20px;border:2px solid"></td>';
        
  //       col+='<td style="height: 20px;border:2px solid"></td>'; 
  //       col+='</tr>';
  //       for(i =0; i<len;i++){
          
  //         if(result[i].spm_desc == null){
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //         }
  //         else{
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
  //         }
  //                     col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
  //                     if(result[i].ins_check == null){
  //                       col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //                     }
  //                     else{
  //                       col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
  //                     }
                      
  //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group2[group'+i+']" id="item'+i+'" value="y'+i+'"></td>';
  //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group2[group'+i+']" id="item'+i+'" value="n'+i+'"></td>';
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
  //   }
  // })
  // $(document).on('change','#repaircode3',function(event){
  //   var rc3 = document.getElementById('repaircode3').value;
  //   $("#testdiv3").html('');
  //   if(rc3 != ''){
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
  //       col +='<div class="form-group row col-md-12 divrepcode"  >';
  //       col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
  //       col +='</div>';
  //       col+='<div class="table-responsive col-12">';
  //       col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
  //       col+='<thead>';
  //       col+='<tr style="text-align: center;style="border:2px solid"">';
  //       col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
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
  //       col+='<tr>';
  //       col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_code+'</b></p></td>';
  //       col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_desc+'</b></p></td>';
  //       col+='<td style="height: 20px;border:2px solid"></td>';
  //       col+='<td style="height: 20px;border:2px solid"></td>';
        
  //       col+='<td style="height: 20px;border:2px solid"></td>'; 
  //       col+='</tr>';
  //       for(i =0; i<len;i++){
          
  //         if(result[i].spm_desc == null){
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //         }
  //         else{
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
  //         }                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
  //                     if(result[i].ins_check == null){
  //                       col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //                     }
  //                     else{
  //                       col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
  //                     }
                      
  //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group3[group'+i+']" id="item'+i+'" value="y'+i+'"></td>';
  //         col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group3[group'+i+']" id="item'+i+'" value="n'+i+'"></td>';
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
  //   }
  // })

  // $(document).on('change','#manualcount',function(e){
  //   // alert('aaa');
  //   $("#testmanual").html('');
  //   var count1 = document.getElementById('manualcount').value;
  //   if(count1 != ''){
  //     var col = '';
  //     col +='<div class="form-group row col-md-12 divrepmanual" >';
  //     col +='<input type="hidden" id="repairtypereport" name="repairtypereport" value="manual" >';
  //     col +='<label class="col-md-12 col-form-label text-md-left">Detail : </label>';
  //     col +='</div>';
  //     col +='<div class="table-responsive col-12">';
  //     col +='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
  //     col +='<thead>';
  //     col +='<tr style="text-align: center;style="border:2px solid"">';
  //     col +='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">No</p></th>';
  //     col +='<th rowspan="2" style="border:2px solid;width:35%"><p style="height:100%">Kode</p></th>';
  //     col +='<th rowspan="2" style="border:2px solid;width:35%"><p style="height:100%">Deskripsi</p></th>';
  //     col +='<th colspan="2" style="border:2px solid;width:20%"><p style="height:100%">kondisi</p></th>';
  //     col +='</tr>';
  //     col +='<tr style="text-align: center;">';
  //     col +='<th style="border:2px solid">Baik</th>';
  //     col +='<th style="border:2px solid">Tidak</th>';
  //     col +='</tr>';
  //     col +='</thead>';
  //     col +='<tbody style="border:2px solid" >';
  //     for(var co = 0; co < count1; co++){
  //       col +='<tr>';
  //       col+='<td style="height: 20px;text-align:center;border:2px solid"><input type="number" style="text-align:center;border:none;width:100%" name="number[]" value='+(co+1)+'></td>';
  //       col+='<td style="height: 20px;border:2px solid"><input type="text" name="part[]" style="border:none;width:100%"></td>';
  //       col+='<td style="height: 20px;border:2px solid"><input type="text" name="desc[]" style="border:none;width:100%"></td>';
  //       col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+co+']" id="item'+co+'" value="y'+co+'"></td>';
  //       col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+co+']" id="item'+co+'" value="n'+co+'"></td>'; 
  //       col+='</tr>';
  //     }
          
  //         col+='</tbody>';
  //         col+='</table>';
  //         col+='</div>';
  //         $("#testmanual").append(col);
  //   } 
  // });

  // $(document).on('change','#repairgroup',function(event){
  //   var rg1 = document.getElementById('repairgroup').value;
  //   // alert(rc1);
  //   $("#testdivgroup").html('');
  //   if(rg1 != ''){
  //     $.ajax({
  //       url: "/getgroup1/" + rg1,
  //       success: function(data) {
  //         var tempres    = JSON.stringify(data);
  //         var result     = JSON.parse(tempres);
  //         console.log(data);
  //         console.log(result);
  //         var len        = result.length;
  //         var col        = '';
  //         var currenttype;
  //         var currentnum = 1;
  //         var temprepair = new Array();
  //         var counter = 0;
  //         var countrepair = 0;
  //         var repairnow = '';
  //         for(j =0; j<len;j++){
  //           if(!temprepair.includes(result[j].xxrepgroup_rep_code)){
  //             temprepair.push(result[j].xxrepgroup_rep_code);
  //             countrepair += 1;
  //           }
  //         }
  //         console.log(temprepair[0]);
  //         // console.log(countrepair);
  //         // alert(temprepair);
  //         // alert(countrepair);
  //         // var currentrepair;
  //         if(len >0){
  //           for(p = 0; p<countrepair; p++){
  //             col +='<div class="form-group row col-md-12 divrepgroup'+p+'" >';
  //             col +='<input type="hidden" id="repaircodeselection" name="repaircodeselection[]" value="'+temprepair[p]+'" >';
  //             col +='<input type="hidden" id="repairtypereport" name="repairtypereport" value="group" >';
  //             col +='<label class="col-md-12 col-form-label text-md-left">Repair group : '+result[0].xxrepgroup_nbr+'</label>';
  //             col +='<label class="col-md-12 col-form-label text-md-left">Repair group : '+temprepair[p]+'</label>';
  //             col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
  //             col +='</div>';
  //             col+='<div class="table-responsive col-12">';
  //             col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
  //             col+='<thead>';
  //             col+='<tr style="text-align: center;style="border:2px solid"">';
  //             col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
  //             col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
  //             col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
              
  //             col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
  //             col+='</tr>';
  //             col+='<tr style="text-align: center;">';
  //             col+='<th style="border:2px solid">Baik</th>';
  //             col+='<th style="border:2px solid">Tidak</th>';
  //             col+='</tr>';
  //             col+='</thead>';
  //             col+='<tbody style="border:2px solid" >';

  //             for(var i =0; i<len;i++){
  //               // console.log(temprepair[p]);
                
  //               if(result[i].xxrepgroup_rep_code == temprepair[p]){
                    
  //                     if(result[i].spm_desc == null){
  //                       col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //                     }
  //                     else{
  //                       col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
  //                     }
  //                     col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
  //                     if(result[i].ins_check == null){
  //                       col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //                     }
  //                     else{
  //                       col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
  //                     }
                      
  //                     col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+p+']['+counter+']" id="item'+p+counter+'" value="y'+counter+'"></td>';
  //                     col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+p+']['+counter+']" id="item'+p+counter+'" value="n'+counter+'"></td>';
  //                     col+='</tr>';
  //                     counter +=1;
  //                   }
  //                 }
                  
  //                 col+='</tbody>';
  //                 col+='</table>';
  //                 col+='</div>';
  //                 counter = 0;
  //                 currentnum = 1;
  //                 currenttype = '';
                  
  //               }
  //             }
                

  //           $("#testdivgroup").append(col);
  //           col='';
        
  //         }  
        
  //     })
  //   }
  // })

  function uploadImage() {
    var button = $('.images .pic')
    var uploader = $('<input type="file" accept="image/jpeg, image/png, image/jpg" />')
    var images = $('.images')
    var potoArr = [];
    var initest = $('.images .img span #imgname')
        
    button.on('click', function () {
      // alert('aaa');
      uploader.click();
    })
        
    uploader.on('change', function () {
      var reader = new FileReader();
      i = 0;
      reader.onload = function(event) {
      images.prepend('<div id="img" class="img" style="background-image: url(\'' + event.target.result + '\');" rel="'+ event.target.result  +'"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
      // alert(JSON.stringify(uploader));
        document.getElementById('imgname').value = uploader[0].files.item(0).name+','+event.target.result; 
        document.getElementById('hidden_var').value = 1;
      }
      reader.readAsDataURL(uploader[0].files[0])
            // potoArr.push(uploader[0].files[0]);

            // console.log(potoArr);
        })


        images.on('click', '.img', function () {        
          $(this).remove();
        })
      
      // confirmPhoto(potoArr);
  }

//------------------------------------------------------------------------------------------------------


$(document).on('change','.sparepartnum',function(){
      // if(document.getElementById('repaircode').checked){
      var thisid = this.id;

      var valu = document.getElementById(thisid).value;
      if(thisid == 'sparepartnum1'){
        object.spare1 = valu;
      }
      else if(thisid == 'sparepartnum2'){
        object.spare2 = valu;
      }
      else if(thisid == 'sparepartnum3'){
        object.spare3 = valu;
      }
    //alert(object.spare1);
    // alert(thisid);
    var newval = parseInt(object.spare1) + parseInt(object.spare2) + parseInt(object.spare3);
    //alert(newval);
    // if(newval < 11){
        var substrthis = parseInt(thisid.substr(12,1));
        var intid = document.getElementById(thisid).value;
      alert(intid);
    // alert(substrthis);
    var col2 = '';
    if(intid != 0 && intid <100){
      var tablenamenow = '#divtablespare'+substrthis;
      // $('.divspare'+substrthis).remove();
      $(tablenamenow).remove();
      // $('.sparepart').select2('destroy');
      var col2 = '';
      // alert(intid);
      
      col2 +='<div class="table-responsive col-12" id="divtablespare'+substrthis+'">';
      col2 +='<table class="table table-borderless mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
      col2 +='<thead>';
      col2 +='<tr style="text-align: center;style="border:2px solid"">';
      col2+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
              col2+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Instruksi</p></th>';
              col2+='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">Sparepart</p></th>';
              col2+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard</p></th>';
              col2+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Qty</p></th>';
              col2+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Hour(s)</p></th>';
              col2+='<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Result</p></th>';
              col2+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Note</p></th>';
      col2 +='</tr>';
      col2 +='<tr style="text-align: center;">';
      col2 +='<th style="border:2px solid">OK</th>';
      col2 +='<th style="border:2px solid">F.U.</th>';
      col2 +='</tr>';
      col2 +='</thead>';
      col2 +='<tbody style="border:2px solid" >';

      
      for(var i = 0; i<intid; i++){
        
        col2 +='<tr>';
        col2+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+(i+1)+'</b></p></td>';
        
        col2+='<td style="height: 20px;border:2px solid"><select id="insspare'+substrthis+'" name="insspare'+substrthis+'[]" style="border:none;width:100%"><option value=null></option>';
        col2+='@foreach($instruction as $instruction1)';
        col2+='<option value="{{$instruction1->ins_code}}">{{$instruction1->ins_code}} -- {{$instruction1->ins_desc}}</option>';
        col2+='@endforeach</select></td>';
        
        col2+='<td style="height: 20px;border:2px solid"><select id="partspare'+substrthis+'" name="partspare'+substrthis+'[]" style="border:none;width:100%"><option value=null></option>';
        col2+='@foreach($sparepart as $sparepart1)';
        col2+='<option value="{{$sparepart1->spm_code}}">{{$sparepart1->spm_code}} -- {{$sparepart1->spm_desc}}</option>';
        col2+='@endforeach</select></td>';

        col2+='<td style="height: 20px;border:2px solid"><input type="text" name="descspare'+substrthis+'[]" style="border:none;width:100%"></td>';
        col2+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="qtyspare'+substrthis+'[]" min=1 value=1 style="border:0px;width:100%"></td>';
        col2+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rphspare'+substrthis+'[]" min=1 value=1 style="border:0px;width:100%"></td>';
 
        col2+='<input type="hidden" name="groupspare'+substrthis+'['+i+']" value="n'+i+'">';
        col2+='<td style="text-align:center;margin-top:0;border:2px solid;vertical-align:middle"><input type="checkbox" name="groupspare'+substrthis+'['+i+']" id="itemspare'+i+'" value="y'+i+'"></td>';
        col2+='<input type="hidden" name="groupspare'+substrthis+'1['+i+']" value="n'+i+'">';
        col2+='<td style="text-align:center;margin-top:0;border:2px solid;vertical-align:middle"><input type="checkbox" name="groupspare'+substrthis+'1['+i+']" id="itemspare1'+i+'" value="y'+i+'"></td>';
        col2+='<td style="text-align:center;margin-top:0;border:2px solid"><textarea name="note'+substrthis+substrthis+'['+i+']" id="note'+i+'" style="border:0;width:100%"></textarea></td>';
        col2+='</tr>';


        // col2 +='<div class="form-group row col-md-12 divspare'+substrthis+'" >';
        // col2 +='<label class="col-md-5 col-form-label text-md-left">Spare Part '+i+'</label>';
        // col2 +='<div class="col-md-5 maman">';
        // col2 +='<select type="text" class="form-control sparepart" name="sparepart'+substrthis+'[]" required autofocus>';
        // col2 +='<option value="" selected disabled>--Select Sparepart--</option>';
        
        
        // @foreach ($sparepart as $sparepart2)
        // col2 +='<option value="{{$sparepart2->spm_code}}">{{$sparepart2->spm_code}} </option>';
        // @endforeach
        // col2 +='</select>';
        
        // col2 +='</div>';
        // col2 +='<div class="col-md-2">';
        // col2 +='<input type="number"  min="1" class="form-control qtyspare" name="qtyspare'+substrthis+'[]">';
        // col2 +='</div>';
        // col2 +='</div>';
      }
      col2+='</tbody>';
      col2+='</table>';
      col2+='</div>';
          

      $("#divspare"+substrthis).append(col2);
      for(cop=0; cop <intid;cop++){
        var namepartnow = "#partspare"+substrthis;
        var nameinsnow = "#insspare"+substrthis;
        // alert(namepartnow);
        $(namepartnow).select2({
          placeholder: "--Select Spare Part--",
          width:'175px',
          theme: 'bootstrap4',
        }); 
        $(nameinsnow).select2({
          placeholder: "--Select Spare Part--",
          width:'250px',
          theme: 'bootstrap4',
        });
      }
      $('.sparepart').select2({
          placeholder: "--Select Spare Part--",
          width:'100%',
          theme: 'bootstrap4',
        }); 
 
      col2 = '';
    
      }

});

  // $(document).on('change','#repaircode1',function(event){
  //   var rc1 = document.getElementById('repaircode1').value;
  //   var cpre = document.getElementById('cpreventive').checked;
  //   // alert(rc1);
  //   $("#testdiv").html('');
  //   if(rc1 != ''){
  //   $.ajax({
  //     url: "/getrepair1/" + rc1,
  //     success: function(data) {
        
  //       var tempres    = JSON.stringify(data);
  //       var result     = JSON.parse(tempres);
  //       console.log(result[0]);
  //       console.log(result);
  //       var len        = result.length;
  //       var col        = '';
  //       var currenttype;
  //       var currentnum = 1;
  //       if(len >0){
  //       col +='<div class="form-group row col-md-12 divrepcode" >';
  //       col +='<label class="col-md-12 col-form-label text-md-left">Repair code : '+result[0].repm_code+' -- '+ result[0].repm_desc +'</label>';
  //       // col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
  //       col +='</div>';
        
  //       col+='<div class="table-responsive col-12">';
  //       col+='<table class="table table-borderless mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
  //       col+='<thead>';
  //       col+='<tr style="text-align: center;style="border:2px solid"">';
  //       col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
  //             col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Instruksi</p></th>';
  //             col+='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">Sparepart</p></th>';
  //             col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard</p></th>';
  //             col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Qty</p></th>';
  //             col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Hour(s)</p></th>';
  //             col+='<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Result</p></th>';
  //             col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Note</p></th>';
  //       col+='</tr>';
  //       col+='<tr style="text-align: center;">';
  //       col+='<th style="border:2px solid">OK</th>';
  //       col+='<th style="border:2px solid">F.U.</th>';
  //       col+='</tr>';
  //       col+='</thead>';
  //       col+='<tbody style="border:2px solid" >';
        
  //       for(i =0; i<len;i++){
          
  //         // alert(result[i].spm_desc);
  //         col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+(i+1)+'</b></p></td>';
  //         if(result[i].ins_code == null){
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //           col+='<input type="hidden" name="ins1[]" value="">';
  //         }
  //         else{
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
  //           col+='<input type="hidden" name="ins1[]" value="'+result[i].ins_code+'">';
  //         }
  //         if(result[i].spm_desc == null){
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //           col+='<input type="hidden" name="spm1[]" value="">';
  //         }
  //         else{
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
  //           col+='<input type="hidden" name="spm1[]" value="'+result[i].spm_code+'">';  
  //         }
          
          
  //         if(result[i].ins_check == null){
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
  //           col+='<input type="hidden" name="std1[]" value="">';
  //         }
  //         else{
  //           col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
  //           col+='<input type="hidden" name="std1[]" value="'+result[i].ins_check+'">';
  //         }
  //         col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="qty1[]" min=1 value=1 style="border:0px;width:100%;height:100%"></td>';
  //         col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph1[]" min=1 value=1 style="border:0px;width:100%;height:100%"></td>';
          
  //         col+='<input type="hidden" name="group1['+i+']" value="n'+i+'">';
  //         col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group1['+i+']" id="item'+i+'" value="y'+i+'"></td>';
  //         col+='<input type="hidden" name="group11['+i+']" value="n'+i+'">';
  //         col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group11['+i+']" id="item'+i+'" value="y'+i+'"></td>';
  //         col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><textarea name="note1['+i+']" id="note'+i+'" style="border:0;width:100%"></textarea></td>';
  //         col+='</tr>';
  //       }
  //       col+='</tbody>';
  //       col+='</table>';
  //       col+='</div>';
  //       col +='<div class="form-group row col-md-12 divrepcode" >';
  //       col +='<label for="sparepartnum1" class="col-md-3 col-form-label text-md-left">Repair Code 1 New Instructions </label>';
  //       col +='<div class="col-md-1">';
  //       col +='<input id="sparepartnum1" type="number" class="form-control sparepartnum" name="sparepartnum1"  min ="0" max="100">';
  //       col +='</div>';
  //       col +='</div>';
  //       col +='<div class="divspare" id="divspare1">'
  //       col +='</div>';
  //       col += '<div class="hr">';
  //       col += '<hr class="new1">';
  //       col += '</div>';
  //       if(cpre == true){
  //         $("#testdiv").append(col);
  //       }
  //       col='';
      
  //       }  
  //     }
  //   })
  //   }
  // })

  $(document).on('change','#repaircode2',function(event){
    var rc2 = document.getElementById('repaircode2').value;
    var cpre = document.getElementById('cpreventive').checked;
    $("#testdiv2").html('');
    if(rc2 != ''){
    $.ajax({
      url: "/getrepair1/" + rc2,
      success: function(data) {
        var tempres    = JSON.stringify(data);
        var result     = JSON.parse(tempres);
        var len = result.length;
        var col = '';
        var currenttype;
        var currentnum = 1;
        if(len >0){
        col +='<div class="form-group row col-md-12 divrepcode" >';
        
        col +='<div class="form-group row col-md-12 divrepcode" >';
        col +='<label class="col-md-12 col-form-label text-md-left">Repair code : '+result[0].repm_code+' -- '+ result[0].repm_desc +'</label>';
        // col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
        col +='</div>';
        col+='<div class="table-responsive col-12">';
        col+='<table class="table table-borderless mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
        col+='<thead>';
        col+='<tr style="text-align: center;style="border:2px solid"">';
        col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Instruksi</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">Sparepart</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Qty</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Hour(s)</p></th>';
              col+='<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Result</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Note</p></th>';
        col+='</tr>';
        col+='<tr style="text-align: center;">';
        col+='<th style="border:2px solid">OK</th>';
        col+='<th style="border:2px solid">F.U.</th>';
        col+='</tr>';
        col+='</thead>';
        col+='<tbody style="border:2px solid" >';

        for(i =0; i<len;i++){
          col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+(i+1)+'</b></p></td>';
          
          if(result[i].ins_code == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
            col+='<input type="hidden" name="ins2[]" value="">';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
            col+='<input type="hidden" name="ins2[]" value="'+result[i].ins_code+'">';
          }
          if(result[i].spm_desc == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
            col+='<input type="hidden" name="spm2[]" value="">';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
            col+='<input type="hidden" name="spm2[]" value="'+result[i].spm_code+'">'; 
          }
          
            
            if(result[i].ins_check == null){
              col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
              col+='<input type="hidden" name="std2[]" value="">';
            }
            else{
              col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
              col+='<input type="hidden" name="std2[]" value="'+result[i].ins_check+'">';
            }
            col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="qty2[]" min=0 value=1 style="border:0px;width:100%;height:100%"></td>';
            col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph2[]" min=1 value=1 style="border:0px;width:100%;height:100%"></td>';

            col+='<input type="hidden" name="group2['+i+']" value="n'+i+'">';
            col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group2['+i+']" id="item'+i+'" value="y'+i+'"></td>';
            col+='<input type="hidden" name="group21['+i+']" value="n'+i+'">';
            col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group21['+i+']" id="item'+i+'" value="y'+i+'"></td>';
            col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><textarea name="note2['+i+']" id="note'+i+'" style="border:0;width:100%"></textarea></td>';
            col+='</tr>';
        }
        col+='</tbody>';
        col+='</table>';
        col+='</div>';
        col +='<div class="form-group row col-md-12 divrepcode" >';
        col +='<label for="sparepartnum2" class="col-md-3 col-form-label text-md-left">Repair Code 2 New Instructions </label>';
        col +='<div class="col-md-1">';
        col +='<input id="sparepartnum2" type="number" class="form-control sparepartnum" name="sparepartnum2"  min ="0" max="100">';
        col +='</div>';
        col +='</div>';
        col +='<div class="divspare" id="divspare2">'
        col +='</div>';
        col += '<div class="hr">';
        col += '<hr class="new1">';
        col += '</div>';
        if(cpre == true){
          $("#testdiv2").append(col);
        }
        col='';
      
        }  
      }
    })
    }
  })
  $(document).on('change','#repaircode3',function(event){
    var rc3 = document.getElementById('repaircode3').value;
    var cpre = document.getElementById('cpreventive').checked;
    $("#testdiv3").html('');
    if(rc3 != ''){
    $.ajax({
      url: "/getrepair1/" + rc3,
      success: function(data) {
        var tempres    = JSON.stringify(data);
        var result     = JSON.parse(tempres);
        var len = result.length;
        var col = '';
        var currenttype;
        var currentnum = 1;
        if(len >0){
        col +='<div class="form-group row col-md-12 divrepcode"  >';
        col +='<label class="col-md-12 col-form-label text-md-left">Repair code : '+result[0].repm_code+' -- '+ result[0].repm_desc +'</label>';
        // col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
        col +='</div>';
        col+='<div class="table-responsive col-12">';
        col+='<table class="table table-borderless mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
        col+='<thead>';
        col+='<tr style="text-align: center;style="border:2px solid"">';
        col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Instruksi</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">Sparepart</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Qty</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Hour(s)</p></th>';
              col+='<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Result</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Note</p></th>';
        col+='</tr>';
        col+='<tr style="text-align: center;">';
        col+='<th style="border:2px solid">OK</th>';
        col+='<th style="border:2px solid">F.U.</th>';
        col+='</tr>';
        col+='</thead>';
        col+='<tbody style="border:2px solid" >';

        for(i =0; i<len;i++){
          col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+(i+1)+'</b></p></td>';
          
          if(result[i].ins_code == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
            col+='<input type="hidden" name="ins3[]" value="">';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
            col+='<input type="hidden" name="ins3[]" value="'+result[i].ins_code+'">';
          }
            if(result[i].spm_desc == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
            col+='<input type="hidden" name="spm3[]" value="">'; 
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
            col+='<input type="hidden" name="spm3[]" value="'+result[i].spm_code+'">'; 
          }
            
            if(result[i].ins_check == null){
              col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
            col+='<input type="hidden" name="std3[]" value="">'; 
            }
            else{
              col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
            col+='<input type="hidden" name="std3[]" value="'+result[i].ins_check+'">';
            }
            col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="qty3[]" min=1 value=1 style="border:0px;width:100%;height:100%"></td>';
            col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph3[]" min=1 value=1 style="border:0px;width:100%;height:100%"></td>';
            col+='<input type="hidden" name="group3['+i+']" value="n'+i+'">';
            col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;vertical-align:middle"><input type="checkbox" name="group3['+i+']" id="item'+i+'" value="y'+i+'"></td>';
            col+='<input type="hidden" name="group31['+i+']" value="n'+i+'">';
            col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;vertical-align:middle"><input type="checkbox" name="group31['+i+']" id="item'+i+'" value="y'+i+'"></td>';
            col+='<td style="text-align:center;margin-top:0;border:2px solid"><textarea name="note3['+i+']" id="note'+i+'" style="border:0;width:100%"></textarea></td>';
            col+='</tr>';
        }
        col+='</tbody>';
        col+='</table>';
        col+='</div>';
        col +='<div class="form-group row col-md-12 divrepcode" >';
        col +='<label for="sparepartnum3" class="col-md-3 col-form-label text-md-left">Repair Code 3 New Instructions </label>';
        col +='<div class="col-md-1">';
        col +='<input id="sparepartnum3" type="number" class="form-control sparepartnum" name="sparepartnum3"  min ="0" max="100">';
        col +='</div>';
        col +='</div>';
        col +='<div class="divspare" id="divspare3">'
        col +='</div>';
        col += '<div class="hr">';
        col += '<hr class="new1">';
        col += '</div>';
        if(cpre == true){
          $("#testdiv3").append(col);
        }
        col='';
      
        }  
      }
    })
    }
  })

  $(document).on('change','#manualcount',function(e){
    // alert('aaa');
    $("#testmanual").html('');
    var count1 = document.getElementById('manualcount').value;
    if(count1 != ''){
      var col = '';
      col +='<div class="form-group row col-md-12 divrepmanual" >';
      col +='<input type="hidden" id="repairtypereport" name="repairtypereport" value="manual" >';
      col +='<label class="col-md-12 col-form-label text-md-left">Detail : </label>';
      col +='</div>';
      col +='<div class="table-responsive col-12">';
      col +='<table class="table table-borderless mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
      col +='<thead>';
      col +='<tr style="text-align: center;style="border:2px solid"">';
      col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Instruksi<span id="alert1" style="color: red; font-weight: 200;">*</span></p> </th>';
              col+='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">Sparepart<span id="alert1" style="color: red; font-weight: 200;">*</span></p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard<span id="alert1" style="color: red; font-weight: 200;">*</span></p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Qty</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Hour(s)</p></th>';
              col+='<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Result</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Note</p></th>';
      col +='</tr>';
      col +='<tr style="text-align: center;">';
      col +='<th style="border:2px solid">OK</th>';
      col +='<th style="border:2px solid">F.U.</th>';
      col +='</tr>';
      col +='</thead>';
      col +='<tbody style="border:2px solid" >';
      for(var co = 0; co < count1; co++){
        col +='<tr>';
        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+(co+1)+'</b></p></td>';
        col+='<td style="height: 20px;border:2px solid"><input type="text" id="ins'+co+'" name="ins[]" style="border:none;width:100%;height:100%;"></td>';
        col+='<td style="height: 20px;border:2px solid"><input type="text" id="part'+co+'" name="part[]" style="border:none;width:100%"></td>';       
        col+='<td style="height: 20px;border:2px solid"><input type="text" name="desc[]" style="border:none;width:100%"></td>';
        col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="qty5['+co+']" min=1 value=1 style="border:0px;width:100%"></td>';
        col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph5['+co+']" min=1 value=1 style="border:0px;width:100%"></td>';
        col+='<input type="hidden" name="group5['+co+']" value="n'+co+'">';
        col+='<td style="text-align:center;margin-top:0;vertical-align:middle;border:2px solid"><input type="checkbox" name="group5['+co+']" id="item'+co+'" value="y'+co+'" ></td>';
        col+='<input type="hidden" name="group51['+co+']" value="n'+co+'">';
        col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group51['+co+']" id="item'+co+'" value="y'+co+'" ></td>';
        col+='<td style="text-align:center;margin-top:0;border:2px solid"><textarea name="note5['+co+']" id="note'+co+'" style="border:0;width:100%"></textarea></td>';
        col+='</tr>';
      }
          
          col+='</tbody>';
          col+='</table>';
          col+='</div>';
          // col +='<div class="form-group row col-md-12 divrepcode" >';
          // col +='<label for="sparepartnum4" class="col-md-5 col-form-label text-md-left">Repair Code Manual Spareparts </label>';
          // col +='<div class="col-md-7">';
          // col +='<input id="sparepartnum4" type="number" class="form-control sparepartnum" name="sparepartnum[]" required autofocus min ="1">';
          // col +='</div>';
          // col +='</div>';
          // col +='<div class="divspare" id="divspare4">'
          // col +='</div>';
          // col += '<div class="hr">';
          // col += '<hr class="new1">';
          // col += '</div>';
          $("#testmanual").append(col);
          for(cop=0; cop <count1;cop++){
            var namepartnow = "#part"+cop;
            var nameinsnow = "#ins"+cop;
        // alert(namepartnow);
        $(namepartnow).select2({
          width : '150px',
          placeholder : "Select Sparepart",
          closeOnSelect : true,
          theme : 'bootstrap4'
        });
        $(nameinsnow).select2({
          width : '200px',
          placeholder : "Select Instruction",
          closeOnSelect : true,
          theme : 'bootstrap4'
        });
          }
    } 
  });

  $(document).on('change','#repairgroup',function(event){
    var rg1 = document.getElementById('repairgroup').value;
    var cpre = document.getElementById('cpreventive').checked;
    // alert(rc1);
    $("#testdivgroup").html('');
    if(rg1 != ''){
      $.ajax({
        url: "/getgroup1/" + rg1,
        success: function(data) {
          var tempres    = JSON.stringify(data);
          var result     = JSON.parse(tempres);
          // console.log(data);
          // console.log(result);
          var len        = result.length;
          var col        = '';
          var currenttype;
          var curfrentnum = 1;
          var temprepair = new Array();
          var counter = 0;
          var countrepair = 0;
          var repairnow = '';
          var contline = 1;
          // console.log(result[0]);
          for(j =0; j<len;j++){
            if(!temprepair.includes(result[j].xxrepgroup_rep_code)){
              temprepair.push(result[j].xxrepgroup_rep_code);
              countrepair += 1;
            }
          }
          console.log(temprepair[0]);
          // console.log(countrepair);
          // alert(temprepair);
          // alert(countrepair);
          // var currentrepair;
          if(len >0){
            for(p = 0; p<countrepair; p++){
              col +='<div class="form-group row col-md-12 pb-0 mb-0 divrepgroup'+p+'" >';
              col +='<input type="hidden" id="repaircodeselection" name="repaircodeselection[]" value="'+temprepair[p]+'" >';
              col +='<input type="hidden" id="repairtypereport" name="repairtypereport" value="group" >';
              col +='<label class="col-md-12 col-form-label text-md-left">Repair code : '+temprepair[p]+' -- '+result[p].repm_desc+'</label>';
              col +='</div>';
              col+='<div class="table-responsive col-12">';
              col+='<table class="table table-borderless mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
              col+='<thead>';
              col+='<tr style="text-align: center;style="border:2px solid"">';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Instruksi</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">Sparepart</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Qty</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Hour(s)</p></th>';
              col+='<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Result</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Note</p></th>';
              col+='</tr>';
              col+='<tr style="text-align: center;">';
              col+='<th style="border:2px solid">OK</th>';
              col+='<th style="border:2px solid">F.U.</th>';
              col+='</tr>';
              col+='</thead>';
              col+='<tbody style="border:2px solid" >';

              for(var i =0; i<len;i++){
                // console.log(temprepair[p]);
                
                if(result[i].xxrepgroup_rep_code == temprepair[p]){
                  col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+contline+'</b></p></td>';                    
                  if(result[i].ins_code == null){
                    col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                    col+='<input type="hidden" name="insm4['+p+']['+counter+']" value="">';
                  }
                  else{
                    col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
                    col+='<input type="hidden" name="insm4['+p+']['+counter+']" value="'+result[i].ins_code+'">';
                  }
                  if(result[i].spm_desc == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                        col+='<input type="hidden" name="spm4['+p+']['+counter+']" value="">'
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
                        col+='<input type="hidden" name="spm4['+p+']['+counter+']" value="'+result[i].spm_code+'">'  
                      }
                      
                      
                      if(result[i].ins_check == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                        col+='<input type="hidden" name="std4['+p+']['+counter+']" value="">'
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
                        col+='<input type="hidden" name="std4['+p+']['+counter+']" value="'+result[i].ins_check+'">'
                      }
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="qty4['+p+']['+counter+']" min=0 value=1 style="border:0px;width:100%;height:100%"></td>';
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph4['+p+']['+counter+']" min=0 value=1 style="border:0px;width:100%;height:100%"></td>';
                      col+='<input type="hidden" name="group4['+p+']['+counter+']" value="n'+counter+'">';
                      col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group4['+p+']['+counter+']" id="item'+p+counter+'" value="y'+counter+'" ></td>';
                      col+='<input type="hidden" name="group41['+p+']['+counter+']" value="n'+counter+'">';
                      col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group41['+p+']['+counter+']" id="item'+p+counter+'" value="y'+counter+'" ></td>';
                      col+='<td style="text-align:center;margin-top:0;border:2px solid"><textarea name="note['+p+']['+counter+']" id="note'+p+counter+'" style="border:0;width:100%"></textarea></td>';
                      col+='</tr>';
                      counter +=1;
                      contline +=1;
                    }
                    
                  }
                  contline=1;
                  
                  col+='</tbody>';
                  col+='</table>';
                  col+='</div>';
                  col +='<div class="form-group row col-md-12 divrepcode" >';
                  col +='<label for="sparepartnum'+(p+1)+'" class="col-md-3 col-form-label text-md-left">Repair Code '+(p+1)+' New Instructions </label>';
                  col +='<div class="col-md-1">';
                  col +='<input id="sparepartnum'+(p+1)+'" type="number" class="form-control sparepartnum" name="sparepartnum[]"  min ="0" max="100">';
                  col +='</div>';
                  col +='</div>';
                  col +='<div class="divspare" id="divspare'+(p+1)+'">'
                  col +='</div>';
                  col += '<div class="hr">';
                  col += '<hr class="new1">';
                  col += '</div>';
                  counter = 0;
                  currentnum = 1;
                  currenttype = '';
                  
                }
              }
                
              if(cpre == true){
                $("#testdivgroup").append(col);
              }
            col='';
        
          }  
        
      })
    }
  })
$(document).ready(function(){
  // submit();
  uploadImage();
 $('#file-input').on('change', function(){ //on file input change
    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    {
         
        var data = $(this)[0].files; //this file data
        // console.log(data);
        $.each(data, function(index, file){ //loop though each file
            if(/(\.|\/)(jpe?g|png)$/i.test(file.type)){ //check supported file type
                var fRead = new FileReader(); //new filereader
                fRead.onload = (function(file){ //trigger function on successful read
                return function(e) {
                    var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
                    $('#thumb-output').append(img); //append image to output element
                };
                })(file);
                fRead.readAsDataURL(file); //URL representing the file's data.
            }
        });

        $("#thumb-output").on('click', '.thumb', function () {
          $(this).remove();
        })
         
    }else{
        // alert("Your browser doesn't support File API!");
        swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: "Your browser doesn't support File API!",
                      toast: true,
                      showConfirmButton: false,
                      timer: 2000,
        }) //if File API is absent
    }
 });
});


</script>
@endsection