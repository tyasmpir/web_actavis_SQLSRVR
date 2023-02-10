@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Work Order Finish</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Work Order Reporting</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->
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
.images  .img,
.images  .pic {
  flex-basis: 31%;
  margin-bottom: 10px;
  border-radius: 4px;
}
.images  .img {
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
.images  .img:nth-child(3n) {
  margin-right: 0;
}
.images  .img span {
  display: none;
  text-transform: capitalize;
  z-index: 2;
}
.images  .img::after {
  content: '';
  width: 100%;
  height: 100%;
  transition: opacity .1s ease-in;
  border-radius: 4px;
  opacity: 0;
  position: absolute;
}
.images  .img:hover::after {
  display: block;
  background-color: #000;
  opacity: .5;
}
.images  .img:hover span {
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

/* other  */
.images_oth {
  display: flex;
  flex-wrap:  wrap;
  margin-top: 20px;
}
.images_oth  .img_oth,
.images_oth  .pic_other {
  flex-basis: 31%;
  margin-bottom: 10px;
  border-radius: 4px;
}
.images_oth  .img_oth {
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
.images_oth  .img_oth:nth-child(3n) {
  margin-right: 0;
}
.images_oth  .img_oth span {
  display: none;
  text-transform: capitalize;
  z-index: 2;
}
.images_oth  .img_oth::after {
  content: '';
  width: 100%;
  height: 100%;
  transition: opacity .1s ease-in;
  border-radius: 4px;
  opacity: 0;
  position: absolute;
}
.images_oth  .img_oth:hover::after {
  display: block;
  background-color: #000;
  opacity: .5;
}
.images_oth  .img_oth:hover span {
  display: block;
  color: #fff;
}
.images_oth .pic_other {
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

{{--
  Daftar Perubahan :
  A210928 : upload image saat save selain auto
  A211022 : file yang diupload bukan hanya berupa gambar
  A211025 : untuk yang PM, yang dibutuhkan adalah upload file, bukan hanya gambar. dan tidak memerlukan inputan repair code.
--}}
<!--Table Menu-->
<div class="container-fluid mb-2" >
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
      <option value="started">Started</option>
      <option value="finish">Finish</option>
      
    </select>
  </div>
  <label for="" class="col-md-3 col-form-label text-md-right">{{ __('') }}</label>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" style="float:right" />
  </div>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' ><i class="fas fa-sync-alt"></i></button>
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


<div class="col-md-2">

</div>

<hr>
<div class="col-12 form-group row">
  
<div class="table-responsive col-12">
  <table class="table table-borderless mini-table mt-4" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <th>Work Order Number</th>
        <th>Asset</th>
        <th>WO type</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @include('workorder.table-woclose')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>

<!--Modal view-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="newedit" method="post" action="/reportingwo">
        {{ csrf_field() }}
        <div class="modal-body">
        <input type="hidden" name="repairtype" id="repairtype">
        <input type="hidden"  id="v_counter">
        <input type="hidden" name="statuswo" id="statuswo">
        <div class="form-group row col-md-12">
          <div class="col-md-3 h-50">
            <label for="c_wonbr" class="col-md-12 col-form-label text-md-left p-0">Work Order</label>
          </div>
          <div class="col-md-3 h-50">
            <label for="c_srnbr" class="col-md-12 col-form-label text-md-left p-0">SR Number</label>
          </div>
          <div class="col-md-6 h-50">
            <label for="c_asset" class="col-md-12 col-form-label text-md-left p-0">Asset</label>
          </div>
          <div class="col-md-3">
            <input id="c_wonbr" type="text" class="form-control pl-0 col-md-12 c_wonbr" style="background:transparent;border:none;text-align:left" name="c_wonbr" autofocus readonly>
          </div>
          <div class="col-md-3">
            <input id="c_srnbr" type="text" class="form-control pl-0 col-md-12 c_srnbr" style="background:transparent;border:none;text-align:left" name="c_srnbr" autofocus readonly>
          </div>
          <div class="col-md-6">
            <input id="c_asset" type="text" class="form-control pl-0 col-md-12 c_asset" style="background:transparent;border:none;text-align:left" name="c_asset" autofocus readonly>
            <input id="c_assethid" type="hidden" class="form-control c_asset" name="c_assethidden">
          </div>
          
        </div>
          
        <div id="divrepairtype">
          <div class="form-group row col-md-12 ">
            <label for="repaircode" class="col-md-4 col-form-label text-md-left">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6" style="vertical-align:middle;">
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
                <label for="repairgroup" class="col-md-4 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-6">
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
                <label for="manualcount" class="col-md-4 col-form-label text-md-left">Number of part repaired <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-6">
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
              <label for="repaircode1" class="col-md-4 col-form-label text-md-left">Repair Code 1 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
              <div class="col-md-6">
                <input type="hidden" id="inputrepair1">
                <select id="repaircode1" type="text" class="form-control repaircode1" name="repaircode1[]"  autofocus>
                <option value="" selected disabled>--Select Repair Code--</option>
            @foreach ($repaircode as $repaircode2)
              <option value="{{$repaircode2->repm_code}}">{{$repaircode2->repm_code}} -- {{$repaircode2->repm_desc}}</option>
            @endforeach
              </select>
              </div>
            </div>
            <!-- <div id="testdiv">
            
            </div> -->
            <div class="form-group row col-md-12 divrepcode" >
              <label for="repaircode2" class="col-md-4 col-form-label text-md-left">Repair Code 2</label>
              <div class="col-md-6">
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
              <label for="repaircode3" class="col-md-4 col-form-label text-md-left">Repair Code 3</label>
              <div class="col-md-6">
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
        </div>
          <div id="preventiveonly" style="display:none">
            
            <div class="form-group row col-md-12 c_lastmeasurementdiv">
              <label for="c_repairhour" class="col-md-4 col-form-label text-md-left">Last Measurement</label>
              <div class="col-md-6">
                <input id="c_lastmeasurement" type="number" class="form-control c_repairhour" name="c_lastmeasurement" min='1' step="0.01">
              </div>
            </div>
            <div class="form-group row col-md-12 c_engineerdiv">
              <label for="c_lastmeasurementdate" class="col-md-4 col-form-label text-md-left">Last Maintenance</label>
              <div class="col-md-6">
                <input id="c_lastmeasurementdate" type="date" class="form-control c_lastmeasureentdate" name="c_lastmeasurementdate"  readonly>
              </div>
            </div>
            <input type="hidden" name="assettype" id="assettype">
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
            <label for="c_finishdate" class="col-md-4 col-form-label text-md-left">Finish Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6">
            <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_finishtime" class="col-md-4 col-form-label text-md-left">Finish Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6">
            <select id="c_finishtime" class="form-select c_finishtime" name="c_finishtime" style="border:2px solid #ced4da;border-radius:.25rem" autofocus required>
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
            <label for="c_note" class="col-md-4 col-form-label text-md-left">Reporting Note 
              <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-6">
              <textarea id="c_note" class="form-control c_note" name="c_note" autofocus></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_part" class="col-md-4 col-form-label text-md-left">Upload File</label>
            <div class="col-md-6">
              <input type="file" name="fileauto[]" multiple>
            </div>
          </div>
          <!-- A211025
          <div class="form-group row justify-content-center">
            <label class="col-md-12 col-form-label text-md-left">Photo Upload :  </label>
          </div>
          <div class="form-group row justify-content-center" style="margin-bottom: 10%;">
              <div class="col-md-12 images">
                  <div class="pic">
                      add
                  </div>
              </div>
          </div> -->
          <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
          <input type="hidden" id="repairtypenow" name="repairpartnow"  />
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

<!--Modal View Other-->
<div class="modal fade" id="viewOtherModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="neweditother" method="post" action="/reportingwoother">
        {{ csrf_field() }}
        
        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="o_wonbr" class="col-md-4 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-8">
              <input id="o_wonbr" type="text" class="form-control" name="o_wonbr" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="o_srnbr" class="col-md-4 col-form-label text-md-left">SR Number</label>
            <div class="col-md-8">
              <input id="o_srnbr" type="text" class="form-control" name="o_srnbr" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="o_asset" class="col-md-4 col-form-label text-md-left">Asset</label>
            <div class="col-md-8">
              <input type="text" readonly id="o_asset" type="text" class="form-control o_asset" name="o_asset" >
              <input type="hidden" name="o_assetcode" id="o_assetcode">
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="o_action" class="col-md-4 col-form-label text-md-left">Action Taken</label>
            <div class="col-md-8">
              <textarea class="form-control" name="o_action" id="o_action" rows="4" required></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="o_part" class="col-md-4 col-form-label text-md-left">Sparepart</label>
            <div class="col-md-8">
              <textarea class="form-control" name="o_part" id="o_part"></textarea>
            </div>
          </div>
          <!-- A211022
          <div class="form-group row justify-content-center m-0 p-0">
            <label class="col-md-12 col-form-label text-md-left">Photo Upload :  </label>
          </div>
          <div class="form-group row justify-content-center" style="margin-bottom: 10%;">
              <div class="col-md-12 images_oth m-0">
                  <div class="col-md-4 pic_other">
                      add
                  </div>
              </div>
          </div> -->
          <div class="form-group row justify-content-center">
            <label for="o_part" class="col-md-4 col-form-label text-md-left">Upload File</label>
            <div class="col-md-8">
              <input type="file" name="fileother[]" multiple>
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

<div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>      
  </div>
</div>


<!--Modal Delete-->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Close</h5>
        <button type="button" class="close" id='deletequit' data-dismiss="modal"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="delete" method="post" action="reopenwo">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="tmp_wonbr" id="tmp_wonbr">
          Do you want to reopen this <i>Work Order</i> <b> <span id="d_wonbr"></span></b> ?
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
@endsection

@section('scripts')
<script>

$(document).on('click', '#btnsearch', function() {
    var wonumber    = $('#s_nomorwo').val(); 
    var woasset     = $('#s_asset').val(); 
    var wostatus    = $('#s_status').val(); 


    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var page        = 1;

    document.getElementById('tmpwo').value        = wonumber;
    document.getElementById('tmpasset').value     = woasset;
    document.getElementById('tmpstatus').value    = wostatus;



    fetch_data(page, sort_type, column_name, wonumber, woasset,wostatus);
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
    fetch_data(page, sort_type, column_name, wonumber, asset,status);
  });
  $("#s_asset").select2({
    width : '100%',

    closeOnSelect : true,
    theme : 'bootstrap4'
  });
  $(document).on('click', '#btnrefresh', function() {
    var wonumber    = ''; 
    var asset       = ''; 
    var status      = '';
    
    var priority    = '';
    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var page        = 1;

    document.getElementById('s_nomorwo').value    = '';
    document.getElementById('s_asset').value      = '';
    document.getElementById('s_status').value     = '';
    

    document.getElementById('tmpwo').value        = '';
    document.getElementById('tmpasset').value     = '';
    document.getElementById('tmpstatus').value    = '';
    document.getElementById('tmppriority').value  = '';
    
    
    $('#s_asset').select2({
      width:'100%',
      theme:'bootstrap4',
      asset
    })
    fetch_data(page, sort_type, column_name, wonumber, asset,status,priority);
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

  $(document).on('submit','#newedit',function(event){
    event.preventDefault();

    rptype1 = document.getElementById('repairtype').value;
    
    val1 = document.getElementById('repaircode1').value;
    val2 = document.getElementById('repaircode2').value;
    val3 = document.getElementById('repaircode3').value;
    valgroup = document.getElementById('repairgroup').value;
    if(rptype1 == 'code'){
      if(val1 == '' && val2 == '' && val3 == ''){
        swal.fire({
          position: 'top-end',
          icon: 'error',
          title: 'Enter minimum 1 repair code',
          toast: true,
          showConfirmButton: false,
          timer: 2000,
        })
        event.preventDefault();
      }
      else{
        document.getElementById('btnconf').style.display='none';
        document.getElementById('btnclose').style.display='none';
        document.getElementById('btnloading').style.display = '';
        document.getElementById('deletequit').style.display='none';
        document.getElementById('newedit').submit();
      }
    }
    else if(rptype1 == 'group'){
      if(repairgroup == '' || repairgroup == null){
          swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Enter minimum 1 repair group',
            toast: true,
            showConfirmButton: false,
            timer: 2000,
          })
          event.preventDefault();
        }
        else{

          document.getElementById('btnconf').style.display='none';
          document.getElementById('btnclose').style.display='none';
          document.getElementById('btnloading').style.display = '';
          document.getElementById('deletequit').style.display='none';
          document.getElementById('newedit').submit();
        }   
    }
    else{
        document.getElementById('btnconf').style.display='none';
        document.getElementById('btnclose').style.display='none';
        document.getElementById('btnloading').style.display = '';
        document.getElementById('deletequit').style.display='none';
        document.getElementById('newedit').submit();
    }
  });
  $(document).on('click','.reopen',function(){
  
    var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
    document.getElementById('d_wonbr').textContent = wonbr;
    document.getElementById('tmp_wonbr').value = wonbr;
    $('#deleteModal').modal('show');  
    
  });

  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function fetch_data(page, sort_type, sort_by, wonumber, woasset, wostatus) {
    $.ajax({
      url: "/woreport/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woasset=" + woasset+ "&wostatus=" + wostatus,
      success: function(data) {
        // console.log(data);
        $('tbody').html('');
        $('tbody').html(data);
      }
    })
  }

    $(document).on('click', '.jobview', function() {
      var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
      // $('#loadingtable').modal('hide');
      $('#loadingtable').modal('show');
      var counter   = document.getElementById('v_counter');
    
      $.ajax({
        url: '/womaint/getnowo?nomorwo=' +wonbr,
        success:function(vamp){
          var tempres    = JSON.stringify(vamp);
          var result     = JSON.parse(tempres);
          // console.log(result);
          var wonbr      = result[0].wo_nbr;
          var srnbr      = result[0].wo_sr_nbr;
          var asset      = result[0].asset_desc;
          var asscode    = result[0].wo_asset;
          var wostatus   = result[0].wo_status;
          var repair1    = result[0].rr11;
          var repair2    = result[0].rr22;
          var repair3    = result[0].rr33;
          var rprstatus  = result[0].wo_repair_type;
          var rprgroup   = result[0].wo_repair_group;
          var wotype     = result[0].wo_type;
          var assetlastmt= result[0].asset_last_mtc;
          var assetlastus= result[0].asset_last_usage_mtc;
          var assettype  = result[0].asset_measure;
          

          document.getElementById('repairtypenow').value = wotype;
          var event = new Event('change',{"bubbles": true});
          document.getElementById('statuswo').value = wostatus;
          // alert(repair1);
          document.getElementById('v_counter').value     = counter;
          document.getElementById('c_wonbr').value       = wonbr;
          document.getElementById('c_srnbr').value       = srnbr;
          document.getElementById('c_asset').value       = asscode + '-' + asset;
          document.getElementById('c_assethid').value    = asscode;
          document.getElementById('repaircode1').value   = repair1;
          document.getElementById('repaircode2').value   = repair2;
          document.getElementById('repaircode3').value   = repair3;
          if(wotype == 'auto'){
            document.getElementById('divrepairtype').style.display = '';
            document.getElementById('assettype').value = assettype;
            // document.getElementById('c_lastmeasurement').value = assetlastus;
            // document.getElementById('c_lastmeasurementdate').value = assetlastmt;
            document.getElementById('preventiveonly').style.display = 'none';
             if(rprstatus == 'code'){

              document.getElementById('argcheck').checked = false;
              document.getElementById('arccheck').checked = true;
              document.getElementById('divrepair').style.display='';
              document.getElementById('divgroup').style.display='none';
              document.getElementById('repairgroup').value=null;
              $("#repairgroup").val(null).trigger('change');
              document.getElementById('repairtype').value = 'code';
              if(repair1 != null){
                document.getElementById('repaircode1').dispatchEvent(event);
              }
              if(repair2 != null){
                document.getElementById('repaircode2').dispatchEvent(event);
              }
              if(repair3 != null){
                document.getElementById('repaircode3').dispatchEvent(event);
              }         
            }
            else if(rprstatus == 'group'){
              document.getElementById('argcheck').checked = true;
              document.getElementById('arccheck').checked = false;
              document.getElementById('divgroup').style.display='';
              document.getElementById('divrepair').style.display='none';
              $("#repairgroup").val(rprgroup).trigger('change');
              $("#repaircode1").val(null).trigger('change');
              $("#repaircode2").val(null).trigger('change');
              $("#repaircode3").val(null).trigger('change');
              document.getElementById('repairtype').value = 'group';
            }
          }
          else{
              document.getElementById('divrepairtype').style.display = 'none';
              document.getElementById('preventiveonly').style.display = '';
           
          }

          //document.getElementById('divrepairtype').style.display = 'none'; //A211125

          /* untuk view other */
          document.getElementById('o_wonbr').value       = wonbr;
          document.getElementById('o_srnbr').value       = srnbr;
          document.getElementById('o_asset').value       = asscode + '-' + asset;
          document.getElementById('o_assetcode').value   = asscode;

          $('#repaircode1').select2({
            placeholder: "Select Data",
            width:'100%',
            theme: 'bootstrap4',
            allowClear : true,
            repair1
          });
          $('#repaircode2').select2({
            placeholder: "Select Data",
            width:'100%',
            theme: 'bootstrap4',
            allowClear : true,
            repair2
          });
          $('#repaircode3').select2({
            placeholder: "Select Data",
            width:'100%',
            theme: 'bootstrap4',
            allowClear : true,
            repair3

          });

          if (wotype == 'auto') {
            uploadImage();
          } else {
            uploadImage_oth();
          }

          if($('#loadingtable').hasClass('show')){
            
            setTimeout(function(){
              $('#loadingtable').modal('hide');

            },500);
          }
          
          /* beda inputan finish jika beda type*/
          if (wotype == 'auto') {
            setTimeout(function(){
              $('#viewModal').modal('show');  
            },1000);
          } else {
            setTimeout(function(){
              $('#viewOtherModal').modal('show');  
            },1000);
          }
        }
      })
    });
  
  

  // $(document).on('change','#c_repaircodenum',function(){
    //   var col = '';
    //   var repairnum = document.getElementById('c_repaircodenum').value;
      
    //   var divengine1 = document.getElementById('divrepair');
    //   var appendclone = divengine1.cloneNode(true);
    //   col = '';
    //   var i;
    //   if(repairnum != 0 && repairnum <6){
    //     $('.divrepcode').remove();
    //     $('.divspare').remove();
    //     $('.hr').remove();
    //   for(i =1; i<=repairnum;i++){
    //     col +='<div class="form-group row col-md-12 divrepcode" >';
    //     col +='<label for="repaircode'+i+'" class="col-md-5 col-form-label text-md-left">Repair Code '+i+'</label>';
    //     col +='<div class="col-md-7">';
    //     col +='<select id="repaircode'+i+'" type="text" class="form-control repaircode" name="repaircode[]" required autofocus>';
    //     col +='<option value="" selected disabled>--Select Engineer--</option>';
    
    //     col +='</select>';
    //     col +='</div>';
    //     col +='</div>';
    //     col +='<div class="form-group row col-md-12 divrepcode" >';
    //     col +='<label for="sparepartnum'+i+'" class="col-md-5 col-form-label text-md-left">Repair Code '+i+' Spareparts </label>';
    //     col +='<div class="col-md-7">';
    //     col +='<input id="sparepartnum'+i+'" type="number" class="form-control sparepartnum" name="sparepartnum[]" required autofocus min ="1">';
    //     col +='</div>';
    //     col +='</div>';
    //     col +='<div class="divspare" id="divspare'+i+'">'
    //     col +='</div>';
    //     col += '<div class="hr">';
    //     col += '<hr class="new1">';
    //     col += '</div>';
    //     // var newid = 'engineer'+i;
    //     // console.log(newid);
    //     // document.getElementById('testdiv').append(col);
    //     $("#testdiv").append(col);
    //     col='';
    //     }
    //     $('.repaircode').select2({
    //       placeholder: "Select Data",
    //       width:'100%',
    //       theme: 'bootstrap4',
    //     }); 
    //   }
    // });

    // $(document).on('change','.sparepartnum',function(){
    //   var thisid = this.id;
    //   var valu = document.getElementById(thisid).value;
    //   if(thisid == 'sparepartnum1'){
    //     object.spare1 = valu;
    //   }
    //   else if(thisid == 'sparepartnum2'){
    //     object.spare2 = valu;
    //   }
    //   else if(thisid == 'sparepartnum3'){
    //     object.spare3 = valu;
    //   }

    //   var newval = parseInt(object.spare1) + parseInt(object.spare2) + parseInt(object.spare3);
    //   if(newval < 11){
    //   var substrthis = parseInt(thisid.substr(12,1));
    //   var intid = document.getElementById(thisid).value;
    //   var col2 = '';
    //   if(intid != 0 && intid <6){
    //     $('.divspare'+substrthis).remove();
    //     // $('.sparepart').select2('destroy');
    //     for(var i = 1; i<=intid; i++){
    //       col2 +='<div class="form-group row col-md-12 divspare'+substrthis+'" >';
    //       col2 +='<label class="col-md-5 col-form-label text-md-left">Spare Part '+i+'</label>';
    //       col2 +='<div class="col-md-5 maman">';
    //       col2 +='<select type="text" class="form-control sparepart" name="sparepart'+substrthis+'[]" required autofocus>';
    //       col2 +='<option value="" selected disabled>--Select Sparepart--</option>';
    //       @foreach ($sparepart as $sparepart2)
          // col2 +='<option value=""></option>';
    //       @endforeach
    //       col2 +='</select>';
          
    //       col2 +='</div>';
    //       col2 +='<div class="col-md-2">';
    //       col2 +='<input type="number"  min="1" class="form-control qtyspare" name="qtyspare'+i+'[]">';
    //       col2 +='</div>';
    //       col2 +='</div>';
    //     }

    //     $("#divspare"+substrthis).append(col2);
    //     $('.sparepart').select2({
    //         placeholder: "--Select Spare Part--",
    //         width:'100%',
    //         theme: 'bootstrap4',
    //       }); 
    //     col2 = '';
      
    //     }
    //   }
    //   else{
    //     swal.fire({
    //                   position: 'top-end',
    //                   icon: 'error',
    //                   title: 'Spare part cannot exceed 10 item',
    //                   toast: true,
    //                   showConfirmButton: false,
    //                   timer: 2000,
    //         })
    //   }
  // })



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
  //             col +='<label class="col-md-12 col-form-label text-md-left">Repair code : '+temprepair[p]+'</label>';
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

//------------------------------------------------------------------------------------------------------------------
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
      
    // alert(substrthis);
    var col2 = '';
    if(intid != 0 && intid <11){
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
        col2+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rphspare'+substrthis+'[]" min=1 value=1 step="0.1" style="border:0px;width:100%"></td>';
 
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
          width:'150px',
          theme: 'bootstrap4',
        }); 
        $(nameinsnow).select2({
          placeholder: "--Select Spare Part--",
          width:'150px',
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
        console.log(result[0]);
        console.log(result);
        var len        = result.length;
        var col        = '';
        var currenttype;
        var currentnum = 1;
        if(len >0){
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
          
          // alert(result[i].spm_desc);
          col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+(i+1)+'</b></p></td>';
          if(result[i].ins_code == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
            col+='<input type="hidden" name="ins1[]" value="">';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
            col+='<input type="hidden" name="ins1[]" value="'+result[i].ins_code+'">';
          }
          if(result[i].spm_desc == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
            col+='<input type="hidden" name="spm1[]" value="">';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
            col+='<input type="hidden" name="spm1[]" value="'+result[i].spm_code+'">';  
          }
          
          
          if(result[i].ins_check == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
            col+='<input type="hidden" name="std1[]" value="">';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check+'</b></p></td>';
            col+='<input type="hidden" name="std1[]" value="'+result[i].ins_check+'">';
          }
          col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="qty1[]" min=1 value=1 style="border:0px;width:100%;height:100%"></td>';
          col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph1[]" min=1 value=1 step="0.1" style="border:0px;width:100%;height:100%"></td>';
          
          col+='<input type="hidden" name="group1['+i+']" value="n'+i+'">';
          col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group1['+i+']" id="item'+i+'" value="y'+i+'"></td>';
          col+='<input type="hidden" name="group11['+i+']" value="n'+i+'">';
          col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group11['+i+']" id="item'+i+'" value="y'+i+'"></td>';
          col+='<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><textarea name="note1['+i+']" id="note'+i+'" style="border:0;width:100%"></textarea></td>';
          col+='</tr>';
        }
        col+='</tbody>';
        col+='</table>';
        col+='</div>';
        col +='<div class="form-group row col-md-12 divrepcode" >';
        col +='<label for="sparepartnum1" class="col-md-4 col-form-label text-md-left">Repair Code 1 New Instructions </label>';
        col +='<div class="col-md-6">';
        col +='<input id="sparepartnum1" type="number" class="form-control sparepartnum" name="sparepartnum1"  min ="0" max="100">';
        col +='</div>';
        col +='</div>';
        col +='<div class="divspare" id="divspare1">'
        col +='</div>';
        col += '<div class="hr">';
        col += '<hr class="new1">';
        col += '</div>';
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
            col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph2[]" min=1 value=1 step="0.1" style="border:0px;width:100%;height:100%"></td>';

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
        col +='<label for="sparepartnum2" class="col-md-4 col-form-label text-md-left">Repair Code 2 New Instructions </label>';
        col +='<div class="col-md-6">';
        col +='<input id="sparepartnum2" type="number" class="form-control sparepartnum" name="sparepartnum2"  min ="0" max="100">';
        col +='</div>';
        col +='</div>';
        col +='<div class="divspare" id="divspare2">'
        col +='</div>';
        col += '<div class="hr">';
        col += '<hr class="new1">';
        col += '</div>';
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
            col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph3[]" min=1 value=1 step="0.1" style="border:0px;width:100%;height:100%"></td>';
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
        col +='<label for="sparepartnum3" class="col-md-4 col-form-label text-md-left">Repair Code 3 New Instructions </label>';
        col +='<div class="col-md-6">';
        col +='<input id="sparepartnum3" type="number" class="form-control sparepartnum" name="sparepartnum3"  min ="0" max="100">';
        col +='</div>';
        col +='</div>';
        col +='<div class="divspare" id="divspare3">'
        col +='</div>';
        col += '<div class="hr">';
        col += '<hr class="new1">';
        col += '</div>';
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
      col +='<table class="table table-borderless mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
      col +='<thead>';
      col +='<tr style="text-align: center;style="border:2px solid"">';
      col+='<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Instruksi</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">Sparepart</p></th>';
              col+='<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard</p></th>';
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
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph4['+p+']['+counter+']" min=0 value=1 step="0.1" style="border:0px;width:100%;height:100%"></td>';
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
                  col +='<label for="sparepartnum'+(p+1)+'" class="col-md-4 col-form-label text-md-left">Repair Code '+(p+1)+' New Instructions </label>';
                  col +='<div class="col-md-6">';
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
                

            $("#testdivgroup").append(col);
            col='';
        
          }  
        
      })
    }
  })


  $(document).on('click','.aprint',function(event){
    var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
    var wotype = $(this).closest('tr').find('input[name="wotypee"]').val();

    if (wotype == 'auto') {
      var url = "{{url('openprint2','id')}}";
    } else {
      var url = "{{url('openprint','id')}}";
    }

    url = url.replace('id', wonbr);

    window.open(url,'_blank')

  });

  function uploadImage() {
    var button = $('.images .pic')
    var uploader = $('<input type="file" accept="image/jpeg, image/png, image/jpg" />')
    var images = $('.images')
    var potoArr = [];
    var initest = $('.images .img span #imgname')
        
    button.on('click', function () {
      uploader.click();
    })
        
    uploader.on('change', function () {
      var reader = new FileReader();
      i = 0;

      reader.onload = function(event) {
      images.prepend('<div id="img" class="img" style="background-image: url(\'' + event.target.result + '\');" rel="'+ event.target.result  +
      '"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
        document.getElementById('imgname').value = uploader[0].files.item(0).name+','+event.target.result; 
        document.getElementById('hidden_var').value = 1;

    }

    reader.readAsDataURL(uploader[0].files[0])
    
    })

    images.on('click', '.img', function () {        
      $(this).remove();
    })      
  }

  /* Upload type Other */
  function uploadImage_oth() {
    var button_oth = $('.images_oth .pic_other')
    var uploader_oth = $('<input type="file" accept="image/jpeg, image/png, image/jpg" />')
    var images_oth = $('.images_oth')
    var potoArr = [];
    var initest = $('.images_oth .img_oth span #imgname')

    button_oth.on('click', function () {
      uploader_oth.click();
    })
        
    uploader_oth.on('change', function () {
      var reader = new FileReader();
      i = 0;

      reader.onload = function(event) {
      images_oth.prepend('<div id="img_oth" class="img_oth" style="background-image: url(\'' + event.target.result + '\');" rel="'+ event.target.result  +
      '"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
        document.getElementById('imgname').value = uploader_oth[0].files.item(0).name+','+event.target.result; 
        document.getElementById('hidden_var').value = 1;

    }

    reader.readAsDataURL(uploader_oth[0].files[0])
    
    })

    images_oth.on('click', '.img_oth', function () {        
      $(this).remove();
    })      
  }



$(document).ready(function(){
  // submit();
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