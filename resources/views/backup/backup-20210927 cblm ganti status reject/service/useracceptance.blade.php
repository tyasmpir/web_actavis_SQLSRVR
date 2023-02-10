@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">User Acceptance</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Picking Warehouse</li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <hr>
@endsection

@section('content')
<style>
/* img {
  width: 25%;
  margin: 10px;
  cursor: pointer;
} */

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

<!-- modal picking warehouse -->
<!-- <input type="hidden" id="sessionusernow" name="sessionusernow" value="{{Session::get('username')}}"> -->

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
                <option value="">Select Asset</option>
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
            <label for="s_period" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('') }}</label>
            <div class="col-md-3 col-sm-4 mb-2 input-group">
              <input type="button" class="btn btn-primary" id="btnsearch" value="Search" style="float:right" />
              <button type="button" class="btn btn-primary ml-2" id="btnrefresh"><i class="fas fa-redo-alt"></i></button>
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

<div class="table-responsive col-12">
  <table class="table table-bordered mt-4 no-footer mini-table" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" data-sorting_type="asc" data-column_name="so_nbr"  width="10%">SR Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust"  width="10%">WO Number<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust"  width="20%">Asset<span id="username_icon"></span></th>
        <!-- <th class="sorting" data-sorting_type="asc" data-column_name="so_cust"  width="10%">Status<span id="username_icon"></span></th> -->
        <th width="10%">Department</th>
        <th width="10%">Priority</th>
        <th width="10%">Requested Date</th>
        <th width="5%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('service.table-ua')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>
<!-- Flash Menu -->

    <div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">User Acceptance Maintenance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="acceptance" method="post" action="/acceptance" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="hiddensr" name="hiddensr" value="" />
                        <input type="hidden" id="hiddenwo" name="hiddenwo" value="" />
                        <!-- <h6 style="text-align: center;"><b>Completed</b></h6>
                        <hr>
                        <div class="form-group row" style="margin-bottom: 10%;">
                            <label for="t_name" class="col-md-5 col-form-label text-md-right">File Name</label>
                            <div class="col-md-6">
                                <input id="t_name" name="t_name" type="text" class="form-control" required value="{{ old('t_name') }}">
                            </div>
                        </div> -->
                        <!-- <div class="form-group row" style="margin-bottom: 10%;">
                            <label for="t_photo" class="col-md-5 col-form-label text-md-right">Photo</label>
                            <div class="col-md-6">
                                <input id="t_photo" name="t_photo" type="file" class="form-control-file" required value="{{ old('t_photo') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-12 col-form-label text-md-left">Upload Photo: </label>
                        </div>

                        <div class="form-group row" style="margin-bottom: 10%;">
                          <div class="col-md-12 images">
                            <div class="pic">
                              select photo
                            </div>
                          </div>
                        </div>

                        <!-- <button type="button" class="btn btn-info bt-action" id="btntest">Test</button> -->
                        <!-- <div class="form-group row">
                          <label class="col-md-12 col-form-label text-md-left">Upload Photo: </label>
                        </div>

                        <div class="form-group row" style="margin-bottom: 10%;">
                          <div class="col-md-12 images">
                            <div class="pic">
                              select photo
                            </div>
                          </div>
                        </div> -->

                        <!-- <div class="form-group row" style="margin-bottom: 10%;">
                          <input type="file" id="file-input" multiple="multiple" name="photocomplete[]" />
                          <span class="text-danger">{{ $errors->first('image') }}</span>
                          <div id="thumb-output" class="col-md-12 images"></div>
                        </div> -->
                        <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
                        <div class="form-group row">
                          <label for="uncompletenote" class="col-md-3 col-form-label text-md-left">Reason Uncompleted</label>
                          <div class="col-md-7">
                              <textarea id="uncompletenote" type="text" class="form-control" name="uncompletenote" rows="6" maxlength="250" autocomplete="off" autofocus></textarea>
                          </div>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                      <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-danger" name="action" value="uncompleted" id="btnreject">Uncompleted</button>
                      <button type="submit" class="btn btn-success" name="action" value="completed" id="btnapprove">Completed</button> 
                      <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
                        <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
                      </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection


@section('scripts')
<script type="text/javascript">

$("#acceptance").submit(function() {
    document.getElementById('btnclose').style.display = 'none';
    document.getElementById('btnreject').style.display = 'none';
    document.getElementById('btnapprove').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
});

$(document).on('click', '.view', function(event){
  $('#viewModal').modal('show');
  uploadImage();
  var srnumber = $(this).data('srnumber');
  var wonumber = $(this).data('wonumber');
  // alert(wonumber);
  document.getElementById('hiddensr').value = srnumber;
  document.getElementById('hiddenwo').value = wonumber;
});

$(document).on('click', '#btnreject', function(event){
      var uncompleted = document.getElementById('uncompletenote').value;
      
      // event.preventDefault();
      // $('#approval')
      
      if(uncompleted == ""){
          swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: "Reason cannot be empty",
                      toast: true,
                      showConfirmButton: false,
                      timer: 2000,
          })

          // event.preventDefault();
          // $("#t_photo").attr('required', false);
          $("#uncompletenote").attr('required', true);
          event.preventDefault();
      }else{
          // alert('masuk sini');
          // $("#t_photo").attr('required', false);
          $("#uncompletenote").attr(' ', true);
          $('#acceptance').submit();

      }

});

$(document).on('click', '#btnapprove', function(event){
      // var photo = document.getElementById('t_photo').value;
      // console.log(photo);
      // event.preventDefault();
        // confirmPhoto();
        // var validasi = document.getElementById('hidden_var').value;
        // var validasi2 = document.getElementById('img');


        // if(validasi2 === null){
        //   swal.fire({
        //               position: 'top-end',
        //               icon: 'error',
        //               title: "Please Upload Photo",
        //               toast: true,
        //               showConfirmButton: false,
        //               timer: 2000,
        //   })

        //   event.preventDefault();
        // }else{
        //   $("#rejectreason").attr('required', false);
        //   $('#acceptance').submit();
        // }

        $("#rejectreason").attr('required', false);
        $('#acceptance').submit();
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
            //tampilakn photo
            images.prepend('<div id="img" class="img" style="background-image: url(\'' + event.target.result + '\');" rel="'+ event.target.result  +'"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
            // alert(JSON.stringify(uploader));
            document.getElementById('imgname').value = uploader[0].files.item(0).name+','+event.target.result; 
            // document.getElementById('hidden_var').value = 1;
          }
          reader.readAsDataURL(uploader[0].files[0])
          // potoArr.push(uploader[0].files[0]);

          // console.log(potoArr);
      })


      images.on('click', '.img', function () {        
        $(this).remove(); //hapus foto
      })
      
      // confirmPhoto(potoArr);
}



$(document).ready(function(){
  // submit();

    $("#s_asset").select2({
      width : '100%',
      placeholder : "Select Asset",
      theme : 'bootstrap4',
    });

    function fetch_data(page, srnumber, asset, priority) {
      $.ajax({
        url: "/useracceptance/search?page=" + page + "&srnumber=" + srnumber + "&asset=" + asset + "&priority=" + priority,
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

      // var column_name = $('#hidden_column_name').val();
      // var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      document.getElementById('tmpsrnumber').value  = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;
      

      fetch_data(page, srnumber, asset, priority);
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
      
      
      fetch_data(page, srnumber, asset, priority);
    });

    $(document).on('click', '#btnrefresh', function() {
      var srnumber  = ''; 
      var asset    = '';
      var priority = '';
      var page = 1;

      document.getElementById('s_servicenbr').value     = '';
      document.getElementById('s_asset').value          = '';
      document.getElementById('s_priority').value = '';
      
      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;
      

      fetch_data(page, srnumber, asset, priority);

      $("#s_asset").select2({
        width : '100%',
        placeholder : "Select Asset",
        theme : 'bootstrap4',
        asset,
      });
    });



  // $('#file-input').on('change', function(){ //on file input change
  //   if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
  //   {
         
  //       var data = $(this)[0].files; //this file data
  //       console.log(data);
  //       $.each(data, function(index, file){ //loop though each file
  //           if(/(\.|\/)(jpe?g|png)$/i.test(file.type)){ //check supported file type
  //               var fRead = new FileReader(); //new filereader
  //               fRead.onload = (function(file){ //trigger function on successful read
  //               return function(e) {
  //                   var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
  //                   $('#thumb-output').append(img); //append image to output element
  //               };
  //               })(file);
  //               fRead.readAsDataURL(file); //URL representing the file's data.
  //           }
  //       });

  //       $("#thumb-output").on('click', '.thumb', function () {
  //         $(this).remove();
  //       })
         
  //   }else{
  //       // alert("Your browser doesn't support File API!");
  //       swal.fire({
  //                     position: 'top-end',
  //                     icon: 'error',
  //                     title: "Your browser doesn't support File API!",
  //                     toast: true,
  //                     showConfirmButton: false,
  //                     timer: 2000,
  //       }) //if File API is absent
  //   }
  // });
});

</script>
@endsection