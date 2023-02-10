@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Work Order Reporting</h1>
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
            <label for="c_wonbr" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
            <input id="c_wonbr" type="text" class="form-control c_wonbr" name="c_wonbr" autofocus readonly>
              <!-- <input type="hidden" id="c_assetcode"> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_srnbr" class="col-md-5 col-form-label text-md-left">SR Number</label>
            <div class="col-md-7">
            <input id="c_srnbr" type="text" class="form-control c_srnbr" name="c_srnbr" autofocus readonly>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
            <input id="c_asset" type="text" class="form-control c_asset" name="c_asset" autofocus readonly>
            </div>
          </div>
          <div class="form-group row col-md-12 ">
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

          <div class="col-md-12 p-0" id="divgroup" style="display: none;">
            <div class="form-group row col-md-12 divrepgroup" >
                <label for="repairgroup" class="col-md-5 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
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

          <div class="col-md-12 p-0" id="divrepair" style="display: none;">
            <div class="form-group row col-md-12 divrepcode" >
              <label for="repaircode1" class="col-md-5 col-form-label text-md-left">Repair Code 1 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
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
            <label for="repaircode2" class="col-md-5 col-form-label text-md-left">Repair Code 2</label>
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
            <label for="repaircode3" class="col-md-5 col-form-label text-md-left">Repair Code 3</label>
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
          <div class="form-group row col-md-12 c_engineerdiv">
            <label for="c_repairhour" class="col-md-5 col-form-label text-md-left">Repair Hour <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input id="c_repairhour" type="number" class="form-control c_repairhour" name="c_repairhour" min='1'  autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_finishdate" class="col-md-5 col-form-label text-md-left">Finish Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
            <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_finishtime" class="col-md-5 col-form-label text-md-left">Finish Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
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
            <label for="c_note" class="col-md-5 col-form-label text-md-left">Reporting Note <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
            <textarea id="c_note" class="form-control c_note" name="c_note" autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <!-- <label class="col-md-12 col-form-label text-md-center"><b>Completed</b></label> -->
            <label class="col-md-12 col-form-label text-md-left">Photo Upload :  </label>
          </div>
          <div class="form-group row justify-content-center" style="margin-bottom: 10%;">
              <div class="col-md-12 images">
                  <div class="pic">
                      add
                  </div>
              </div>
          </div>
          <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
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
        <button type="button" class="close" id='deletequit' data-dismiss="modal" aria-label="Close">
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
  $(document).on('change','#arccheck',function(e){
  document.getElementById('divrepair').style.display='';
  $("#repairgroup").val(null).trigger('change');
  $("#repaircode1").val(null).trigger('change');
  $("#repaircode2").val(null).trigger('change');
  $("#repaircode3").val(null).trigger('change');
  document.getElementById('divgroup').style.display='none';  
  document.getElementById('repairtype').value= 'code';
  });
  $(document).on('change','#argcheck',function(e){
  document.getElementById('divgroup').style.display='';
  document.getElementById('divrepair').style.display='none';
  $("#repairgroup").val(null).trigger('change');
  $("#repaircode1").val(null).trigger('change');
  $("#repaircode2").val(null).trigger('change');
  $("#repaircode3").val(null).trigger('change');
  document.getElementById('repairtype').value= 'group';
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
    // event.preventDefault();
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
        }   
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

  function fetch_data(page, sort_type, sort_by, wonumber, woengineer, wostatus) {
    $.ajax({
      url: "/womaint/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woengineer=" + woengineer+ "&wostatus=" + wostatus,
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
          var wostatus   = result[0].wo_status;
          var repair1    = result[0].rr11;
          var repair2    = result[0].rr22;
          var repair3    = result[0].rr33;
          var rprstatus  = result[0].wo_repair_type;
          var rprgroup   = result[0].wo_repair_group;
          
          var event = new Event('change',{"bubbles": true});
          document.getElementById('statuswo').value = wostatus;
          // alert(repair1);
          document.getElementById('v_counter').value     = counter;
          document.getElementById('c_wonbr').value       = wonbr;
          document.getElementById('c_srnbr').value       = srnbr;
          document.getElementById('c_asset').value       = asset;
          document.getElementById('repaircode1').value   = repair1;
          document.getElementById('repaircode2').value   = repair2;
          document.getElementById('repaircode3').value   = repair3;
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
          uploadImage();
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
    var engineer = $('#s_engineer').val();
    var status   = $('#s_status').val();

    fetch_data(page, reverse_order, column_name, username, divisi);
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

  $(document).on('change','.sparepartnum',function(){
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

    var newval = parseInt(object.spare1) + parseInt(object.spare2) + parseInt(object.spare3);
    if(newval < 11){
    var substrthis = parseInt(thisid.substr(12,1));
    var intid = document.getElementById(thisid).value;
    var col2 = '';
    if(intid != 0 && intid <6){
      $('.divspare'+substrthis).remove();
      // $('.sparepart').select2('destroy');
      for(var i = 1; i<=intid; i++){
        col2 +='<div class="form-group row col-md-12 divspare'+substrthis+'" >';
        col2 +='<label class="col-md-5 col-form-label text-md-left">Spare Part '+i+'</label>';
        col2 +='<div class="col-md-5 maman">';
        col2 +='<select type="text" class="form-control sparepart" name="sparepart'+substrthis+'[]" required autofocus>';
        col2 +='<option value="" selected disabled>--Select Sparepart--</option>';
        @foreach ($sparepart as $sparepart2)
        col2 +='<option value="{{$sparepart2->spm_code}}">{{$sparepart2->spm_desc}}</option>';
        @endforeach
        col2 +='</select>';
        
        col2 +='</div>';
        col2 +='<div class="col-md-2">';
        col2 +='<input type="number"  min="1" class="form-control qtyspare" name="qtyspare'+i+'[]">';
        col2 +='</div>';
        col2 +='</div>';
      }

      $("#divspare"+substrthis).append(col2);
      $('.sparepart').select2({
          placeholder: "--Select Spare Part--",
          width:'100%',
          theme: 'bootstrap4',
        }); 
      col2 = '';
    
      }
    }
    else{
      swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Spare part cannot exceed 10 item',
                    toast: true,
                    showConfirmButton: false,
                    timer: 2000,
          })
    }
  })
  $(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    $('#hidden_page').val(page);
    var column_name = $('#hidden_column_name').val();
    var sort_type   = $('#hidden_sort_type').val();
    var wonumber    = $('#tmpwo').val();
    var engineer    = $('#tmpengineer').val();
    var status      = $('#tmpstatus').val();
    fetch_data(page, sort_type, column_name, wonumber, engineer,status);
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
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Tools</p></th>';
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
        col+='<td style="height: 20px;border:2px solid"></td>'; 
        col+='</tr>';
        for(i =0; i<len;i++){
          if(currenttype !== result[i].insg_desc){
            if(result[i].insg_desc == null){
              col+='<tr >';
              col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'Lain-lain</b></p></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';  
              col+='</tr>';
              currenttype = result[i].insg_desc;
              currentnum +=1;
            }
            else{
              
        // console.log('aaaa');
              col+='<tr>';  
              col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'.'+result[i].insg_desc+'</b></p></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>'; 
              col+='</tr>';
              currenttype = result[i].insg_desc;
              currentnum +=1;
            }
          }
          col+='<tr>';
          col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
          col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
          if(result[i].ins_check_mea == null){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check_mea+'</b></p></td>';
          }
          if(result[i].ins_tool == ''){
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
          }
          else{
            col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_tool+'</b></p></td>';
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
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Tools</p></th>';
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
        col+='<td style="height: 20px;border:2px solid"></td>'; 
        col+='</tr>';
        for(i =0; i<len;i++){
          if(currenttype !== result[i].insg_desc){
            if(result[i].insg_desc == null){
              col+='<tr >';
              
              col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'Lain-lain</b></p></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';  
              col+='</tr>';
              currenttype = result[i].insg_desc;
              currentnum +=1;
            }
            else{
              col+='<tr>';  
              col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'.'+result[i].insg_desc+'</b></p></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>'; 
              col+='</tr>';
              currenttype = result[i].insg_desc;
              currentnum +=1;
            }
          }
          col+='<tr>';
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
                      if(result[i].ins_check_mea == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check_mea+'</b></p></td>';
                      }
                      if(result[i].ins_tool == ''){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_tool+'</b></p></td>';
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
        col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Tools</p></th>';
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
        col+='<td style="height: 20px;border:2px solid"></td>'; 
        col+='</tr>';
        for(i =0; i<len;i++){
          if(currenttype !== result[i].insg_desc){
            if(result[i].insg_desc == null){
              col+='<tr >';
              col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'Lain-lain</b></p></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';  
              col+='</tr>';
              currenttype = result[i].insg_desc;
              currentnum +=1;
            }
            else{
              col+='<tr>';  
              col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'.'+result[i].insg_desc+'</b></p></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>';
              col+='<td style="height: 20px;border:2px solid"></td>'; 
              col+='</tr>';
              currenttype = result[i].insg_desc;
              currentnum +=1;
            }
          }
          col+='<tr>';
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
                      if(result[i].ins_check_mea == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check_mea+'</b></p></td>';
                      }
                      if(result[i].ins_tool == ''){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_tool+'</b></p></td>';
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
          var len        = result.length;
          var col        = '';
          var currenttype;
          var currentnum = 1;
          var temprepair = new Array();
          
          var countrepair = 0;
          var repairnow = '';
          for(j =0; j<len;j++){
            if(!temprepair.includes(result[j].xxrepgroup_rep_code)){
              temprepair.push(result[j].xxrepgroup_rep_code);
              countrepair += 1;
            }
          }
          // alert(temprepair);
          // alert(countrepair);
          // var currentrepair;
          if(len >0){
            for(p = 0; p<countrepair; p++){
              col +='<div class="form-group row col-md-12 divrepgroup'+p+'" >';
              col +='<input type="hidden" id="repaircodeselection" name="repaircodeselection[]" value="'+temprepair[p]+'" >';
              col +='<input type="hidden" id="repairtypereport" name="repairtypereport" value="group" >';
              col +='<label class="col-md-12 col-form-label text-md-left">Repair group : '+result[0].xxrepgroup_nbr+'</label>';
              col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
              col +='</div>';
              col+='<div class="table-responsive col-12">';
              col+='<table class="table table-borderless mt-4" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
              col+='<thead>';
              col+='<tr style="text-align: center;style="border:2px solid"">';
              col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Kode</p></th>';
              col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Deskripsi</p></th>';
              col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Standard</p></th>';
              col+='<th rowspan="2" style="border:2px solid"><p style="height:100%">Tools</p></th>';
              col+='<th colspan="2" style="border:2px solid"><p style="height:100%">kondisi</p></th>';
              col+='</tr>';
              col+='<tr style="text-align: center;">';
              col+='<th style="border:2px solid">Baik</th>';
              col+='<th style="border:2px solid">Tidak</th>';
              col+='</tr>';
              col+='</thead>';
              col+='<tbody style="border:2px solid" >';
              col+='<tr>';
                          col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+temprepair[p]+'</b></p></td>';
                          col+='<td style="height: 20px;border:2px solid"></td>';
                          col+='<td style="height: 20px;border:2px solid"></td>';
                          col+='<td style="height: 20px;border:2px solid"></td>';
                          col+='<td style="height: 20px;border:2px solid"></td>';
                          col+='<td style="height: 20px;border:2px solid"></td>'; 
                          col+='</tr>';
              for(i =0; i<len;i++){
                if(result[i].xxrepgroup_rep_code == temprepair[p]){
                    if(currenttype !== result[i].insg_desc){
                      if(result[i].insg_desc == null){
                        
                        col+='<tr>';
                        col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'Lain-lain</b></p></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>'; 
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='</tr>';
                        currenttype = result[i].insg_desc;
                        currentnum +=1;
                      }
                      else{
                        
                        col+='<tr>';
                          
                        col+='<td style="height: 20px;border:2px solid"><p style="margin:0px"><b>'+currentnum+'.'+result[i].insg_desc+'</b></p></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='<td style="height: 20px;border:2px solid"></td>';
                        col+='</tr>';
                        currenttype = result[i].insg_desc;
                        currentnum +=1;
                      }
                    }
                      col+='<tr>';
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].spm_desc+'</b></p></td>';
                      col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_desc+'</b></p></td>';
                      if(result[i].ins_check_mea == null){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_check_mea+'</b></p></td>';
                      }
                      if(result[i].ins_tool == ''){
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                      }
                      else{
                        col+='<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>'+result[i].ins_tool+'</b></p></td>';
                      }
                      col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+p+']['+i+']" id="item'+p+i+'" value="y'+i+'"></td>';
                      col+='<td style="text-align:center;margin-top:0;border:2px solid"><input type="radio" name="group4['+p+']['+i+']" id="item'+p+i+'" value="n'+i+'"></td>';
                      col+='</tr>';
                    }
                  }
                
                  col+='</tbody>';
                  col+='</table>';
                  col+='</div>';
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

  $(document).on('click','#aprint',function(event){
    var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
    var url = "{{url('openprint2','id')}}";
        // var newo = JSON.stringify(wonbr);
        url = url.replace('id', wonbr);
        // alert(url);
        document.getElementById('aprint').href=url;
        // alert('aa');
  });

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