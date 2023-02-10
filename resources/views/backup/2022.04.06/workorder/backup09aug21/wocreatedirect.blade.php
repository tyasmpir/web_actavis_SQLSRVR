@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark">WO Create Without Approval </h1>
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
  <form class="form-horizontal" id="new" method="post" action="createdirectwo" autocomplete="off" style="background-color: #ffffff; padding: 2%;">
    {{ csrf_field() }}
    <input type="hidden" name="repairtype" id="repairtype">
    <input type="hidden"  id="v_counter">
    <input type="hidden" name="statuswo" id="statuswo">
    <div class="form-group row col-md-12 c_engineerdiv">
      <label for="c_engineer" class="col-md-2 mt-3 col-form-label text-md-left">Engineer</label>
      <div class="col-md-7">
        <input type="text" id="c_engineer"  class="form-control c_engineer mt-3" value="{{Session::get('name')}}"  readonly>
        <input type="hidden" id="engineercreate"  class="form-control engineercreate" name="engineercreate" value="{{Session::get('username')}}" >
      </div>
    </div>

    <div class="form-group row col-md-12">
      <label for="c_asset" class="col-md-2 col-form-label text-md-left">Asset <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-7">
      <select id="c_asset" type="text" class="form-control c_asset" name="c_asset" autofocus required>
          <option value="">--Select Asset--</option>
          @foreach ($asset2 as $asset2)
            <option value="{{$asset2->asset_code}}">{{$asset2->asset_code}} -- {{$asset2->asset_desc}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group row col-md-12 c_failurediv" id="c_faildiv" style="display: none;">
      <label for="c_failurenum" class="col-md-2 col-form-label text-md-left">Total Failure Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-2">
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
              <div class="form-group row col-md-12 " id="divrepairtype">
            <label for="repaircode" class="col-md-2 col-form-label text-md-left">Repair Type </label>
            <div class="col-md-7" style="vertical-align:middle;">
              <input class=" d-inline" type="radio" name="repairtype" id="argcheck" value="group">
              <label class="form-check-label" for="argcheck">
                Repair Group
              </label>
            
              <input class="d-inline ml-5" type="radio"  name="repairtype" id="arccheck" value="code">
              <label class="form-check-label" for="arccheck">
                Repair Code
              </label>
              <input class="d-inline ml-5" type="radio"  name="repairtype" id="arcmanual" value="manual">
              <label class="form-check-label" for="arcmanual">
                Manual
              </label>
            </div>
          </div>

          <div class="col-md-12 p-0" id="divgroup" style="display: none;">
            <div class="form-group row col-md-12 divrepgroup" >
                <label for="repairgroup" class="col-md-2 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
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
            <div class="form-group row col-md-12 divrepcode" >
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
            
            </div>
          </div> 

    <div class="form-group row col-md-12">
      <label for="c_schedule" class="col-md-2 col-form-label text-md-left">Schedule Date <span id="alert1" style="color: red; font-weight: 100;">*</span></label>
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
    <div class="form-group row col-md-12">
      <label for="c_priority" class="col-md-2 col-form-label text-md-left">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-4">
        <select id="c_priority"  class="form-control" name="c_priority"  autocomplete="off" autofocus required placeholder=>
          <option value='' disabled selected>--select priority--</option>
          <option value='low'>Low</option>
          <option value='medium'>Medium</option>
          <option value='high'>High</option>
        </select>
      </div>
    </div>
    <div class="form-group row col-md-12 c_engineerdiv">
      <label for="c_repairhour" class="col-md-2 col-form-label text-md-left">Repair Hour <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-1">
        <input id="c_repairhour" type="number" class="form-control c_repairhour" name="c_repairhour" min='1'  autofocus required>
      </div>

      <label for="c_finishdate" class="col-md-2 col-form-label text-md-right">Finish Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-3">
        <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" autofocus required>
      </div>
   
      <label for="c_finishtime" class="col-md-2 col-form-label text-md-right">&nbsp;Finish Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
      <div class="col-md-2">
        <select id="c_finishtime" class="form-select c_finishtime mt-1"  name="c_finishtime" style="border:2px solid #ced4da;border-radius:.25rem" autofocus required>
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

    <div class="form-group row col-md-12">
      <label for="c_note" class="col-md-2 col-form-label text-md-left">Note</label>
      <div class="col-md-7">
      <textarea id="c_note" class="form-control c_note" name="c_note" autofocus></textarea>
      </div>
    </div>
    <div class="form-group row col-md-12">
      <!-- <label class="col-md-12 col-form-label text-md-center"><b>Completed</b></label> -->
      <label class="col-md-12 col-form-label text-md-left">Photo Upload :  </label>
    </div>
    <div class="form-group row col-md-12" style="margin-bottom: 10%;">
        <div class="col-md-12 images">
            <div class="pic">
                add
            </div>
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
          col +='<label for="failure'+i+'" class="col-md-2 col-form-label text-md-left">Failure Code '+i+'</label>';
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

    $(document).on('change','#repaircode1',function(event){
    var rc1 = document.getElementById('repaircode1').value;
    // alert(rc1);
    $("#testdiv").html('');
    if(rc1 != ''){
    $.ajax({
      url: "/getrepair1/" + rc1,
      success: function(data) {
        
        var tempres    = JSON.stringify(data);
        var result     = JSON.parse(tempres);
        // console.log(result[0]);
        console.log(result);
        var len        = result.length;
        var col        = '';
        var currenttype;
        var currentnum = 1;
        if(len >0){
        col +='<div class="form-group row col-md-12 divrepcode" >';
        col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
        col +='</div>';
        col+='<div class="table-responsive col-12">';
        col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
        col+='<thead>';
        col+='<tr style="text-align: center;style="border:2px solid"">';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
        
        col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
        col+='</tr>';
        col+='<tr style="text-align: center;">';
        col+='<th style="border:2px solid">Baik</th>';
        col+='<th style="border:2px solid">Tidak</th>';
        col+='</tr>';
        col+='</thead>';
        col+='<tbody style="border:2px solid" >';
        col+='<tr>';
        col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_code+'</b></p></td>';
        col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_desc+'</b></p></td>';
        col+='<td style="height: 20px;border:2px solid"></td>';
        col+='<td style="height: 20px;border:2px solid"></td>';
         
        col+='<td style="height: 20px;border:2px solid"></td>'; 
        col+='</tr>';
        for(i =0; i<len;i++){
          
          // alert(result[i].spm_desc);
          if(result[i].spm_desc == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
          }
          
          col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
          if(result[i].ins_check == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
          }
          
          col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group1[group'+i+']" id="item'+i+'" value="y'+i+'"></td>';
          col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group1[group'+i+']" id="item'+i+'" value="n'+i+'"></td>';
          col+='</tr>';
        }
        col+='</tbody>';
        col+='</table>';
        col+='</div>';
        $("#testdiv").append(col);
        col='';
      
        }  
      }
    })
    }
  })
  $(document).on('change','#repaircode2',function(event){
    var rc2 = document.getElementById('repaircode2').value;
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
        col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
        col +='</div>';
        col+='<div class="table-responsive col-12">';
        col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
        col+='<thead>';
        col+='<tr style="text-align: center;style="border:2px solid"">';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
        
        col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
        col+='</tr>';
        col+='<tr style="text-align: center;">';
        col+='<th style="border:2px solid">Baik</th>';
        col+='<th style="border:2px solid">Tidak</th>';
        col+='</tr>';
        col+='</thead>';
        col+='<tbody style="border:2px solid" >';
        col+='<tr>';
        col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_code+'</b></p></td>';
        col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_desc+'</b></p></td>';
        col+='<td style="height: 20px;border:2px solid"></td>';
        col+='<td style="height: 20px;border:2px solid"></td>';
        
        col+='<td style="height: 20px;border:2px solid"></td>'; 
        col+='</tr>';
        for(i =0; i<len;i++){
          
          if(result[i].spm_desc == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
          }
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
                      if(result[i].ins_check == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
                      }
                      
          col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group2[group'+i+']" id="item'+i+'" value="y'+i+'"></td>';
          col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group2[group'+i+']" id="item'+i+'" value="n'+i+'"></td>';
          col+='</tr>';
        }
        col+='</tbody>';
        col+='</table>';
        col+='</div>';
        $("#testdiv2").append(col);
        col='';
      
        }  
      }
    })
    }
  })
  $(document).on('change','#repaircode3',function(event){
    var rc3 = document.getElementById('repaircode3').value;
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
        col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
        col +='</div>';
        col+='<div class="table-responsive col-12">';
        col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
        col+='<thead>';
        col+='<tr style="text-align: center;style="border:2px solid"">';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
        
        col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
        col+='</tr>';
        col+='<tr style="text-align: center;">';
        col+='<th style="border:2px solid">Baik</th>';
        col+='<th style="border:2px solid">Tidak</th>';
        col+='</tr>';
        col+='</thead>';
        col+='<tbody style="border:2px solid" >';
        col+='<tr>';
        col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_code+'</b></p></td>';
        col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+result[0].repm_desc+'</b></p></td>';
        col+='<td style="height: 20px;border:2px solid"></td>';
        col+='<td style="height: 20px;border:2px solid"></td>';
        
        col+='<td style="height: 20px;border:2px solid"></td>'; 
        col+='</tr>';
        for(i =0; i<len;i++){
          
          if(result[i].spm_desc == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
          }                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
                      if(result[i].ins_check == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
                      }
                      
          col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group3[group'+i+']" id="item'+i+'" value="y'+i+'"></td>';
          col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group3[group'+i+']" id="item'+i+'" value="n'+i+'"></td>';
          col+='</tr>';
        }
        col+='</tbody>';
        col+='</table>';
        col+='</div>';
        $("#testdiv3").append(col);
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
      col +='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
      col +='<thead>';
      col +='<tr style="text-align: center;style="border:2px solid"">';
      col +='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">No</p></th>';
      col +='<th rowspan="2" style="border:2px solid;width:35%"><p style="height:100%">Kode</p></th>';
      col +='<th rowspan="2" style="border:2px solid;width:35%"><p style="height:100%">Deskripsi</p></th>';
      col +='<th colspan="2" style="border:2px solid;width:20%"><p style="height:100%">kondisi</p></th>';
      col +='</tr>';
      col +='<tr style="text-align: center;">';
      col +='<th style="border:2px solid">Baik</th>';
      col +='<th style="border:2px solid">Tidak</th>';
      col +='</tr>';
      col +='</thead>';
      col +='<tbody style="border:2px solid" >';
      for(var co = 0; co < count1; co++){
        col +='<tr>';
        col+='<td style="height: 20px;text-align:center;border:2px solid"><input type="number" style="text-align:center;border:none;width:100%" name="number[]" value='+(co+1)+'></td>';
        col+='<td style="height: 20px;border:2px solid"><input type="text" name="part[]" style="border:none;width:100%"></td>';
        col+='<td style="height: 20px;border:2px solid"><input type="text" name="desc[]" style="border:none;width:100%"></td>';
        col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+co+']" id="item'+co+'" value="y'+co+'"></td>';
        col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+co+']" id="item'+co+'" value="n'+co+'"></td>'; 
        col+='</tr>';
      }
          
          col+='</tbody>';
          col+='</table>';
          col+='</div>';
          $("#testmanual").append(col);
    } 
  });

  $(document).on('change','#repairgroup',function(event){
    var rg1 = document.getElementById('repairgroup').value;
    // alert(rc1);
    $("#testdivgroup").html('');
    if(rg1 != ''){
      $.ajax({
        url: "/getgroup1/" + rg1,
        success: function(data) {
          var tempres    = JSON.stringify(data);
          var result     = JSON.parse(tempres);
          console.log(data);
          console.log(result);
          var len        = result.length;
          var col        = '';
          var currenttype;
          var currentnum = 1;
          var temprepair = new Array();
          var counter = 0;
          var countrepair = 0;
          var repairnow = '';
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
              col +='<div class="form-group row col-md-12 divrepgroup'+p+'" >';
              col +='<input type="hidden" id="repaircodeselection" name="repaircodeselection[]" value="'+temprepair[p]+'" >';
              col +='<input type="hidden" id="repairtypereport" name="repairtypereport" value="group" >';
              col +='<label class="col-md-12 col-form-label text-md-left">Repair group : '+result[0].xxrepgroup_nbr+'</label>';
              col +='<label class="col-md-12 col-form-label text-md-left">Repair group : '+temprepair[p]+'</label>';
              col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
              col +='</div>';
              col+='<div class="table-responsive col-12">';
              col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
              col+='<thead>';
              col+='<tr style="text-align: center;style="border:2px solid"">';
              col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
              col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
              col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
              
              col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
              col+='</tr>';
              col+='<tr style="text-align: center;">';
              col+='<th style="border:2px solid">Baik</th>';
              col+='<th style="border:2px solid">Tidak</th>';
              col+='</tr>';
              col+='</thead>';
              col+='<tbody style="border:2px solid" >';

              for(var i =0; i<len;i++){
                // console.log(temprepair[p]);
                
                if(result[i].xxrepgroup_rep_code == temprepair[p]){
                    
                      if(result[i].spm_desc == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';  
                      }
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
                      if(result[i].ins_check == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
                      }
                      
                      col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+p+']['+counter+']" id="item'+p+counter+'" value="y'+counter+'"></td>';
                      col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+p+']['+counter+']" id="item'+p+counter+'" value="n'+counter+'"></td>';
                      col+='</tr>';
                      counter +=1;
                    }
                  }
                  
                  col+='</tbody>';
                  col+='</table>';
                  col+='</div>';
                  counter = 0;
                  currentnum = 1;
                  currenttype = '';
                  
                }
              }
                

            $("#testdivgroup").append(col);
            col='';
        
          }  
        
      })
    }
  })

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