@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark">User Maintenance</h1>
          </div><!-- /.col -->
          <div class="col-sm-3">
          <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">
    User Create</button>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<!--FORM Search Disini -->
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
    <div class="col-12 form-group row">
        <label for="s_username" class="col-md-2 col-sm-2 col-form-label text-md-right">User ID</label>
        <div class="col-md-4 mb-2 input-group">
            <input id="s_username" type="text" class="form-control" name="s_username"
            value="" autofocus autocomplete="off"/>
        </div>
        <label for="s_div" class="col-md-2 col-sm-2 col-form-label text-md-right">Department</label>
        <div class="col-md-4 mb-2 input-group">
            <select id="s_div" class="form-control" name="s_div">
              <option value="">--Select Data--</option>
              @foreach($datadept as $dd)
                <option value="{{$dd->dept_code}}">{{$dd->dept_desc}}</option>
              @endforeach
            </select>
        </div>
        <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('') }}</label>
        <div class="col-md-2 mb-2 input-group">
            <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" />
        </div>
        <div class="col-md-2 col-sm-12 mb-2 input-group">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
        </div>
        <input type="hidden" id="tmpusername" value=""/>
        <input type="hidden" id="tmpdiv" value=""/>
    </div>
</div>
</li>
</ul>
</li>
</ul>
</div>

<div class="table-responsive col-12">
  <table class="table table-bordered mt-4" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th>User ID</th>
        <th width="25%">Name</th>
        <th width="15%">Email</th>
        <th width="20%">Department</th>
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('setting.table-usermaint')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!--Modal Create-->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">User Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="new" method="post" action="createuser" autocomplete="off">
          {{ csrf_field() }}

          <div class="form-group row col-md-12">
            <label for="username" class="col-md-5 col-form-label text-md-left">User ID</label>
            <div class="col-md-7 {{ $errors->has('uname') ? 'has-error' : '' }}">
              <input id="username" type="text" class="form-control username" name="username" value="{{ old('username') }}" autocomplete="off" maxlength="6" required autofocus>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="name" class="col-md-5 col-form-label text-md-left">Full Name</label>
            <div class="col-md-7">
              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="email" class="col-md-5 col-form-label text-md-left">Email</label>
            <div class="col-md-7">
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <select id="dept" class="form-control" name="dept" required>
                <option value="">--Select Data--</option>
                @foreach($datadept as $dd)
                  <option value="{{$dd->dept_code}}">{{$dd->dept_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="password" class="col-md-5 col-form-label text-md-left">Password</label>
            <div class="col-md-7">
              <input id="password" type="password" class="form-control" name="password" autocomplete="new-password" required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="password-confirm" class="col-md-5 col-form-label text-md-left">Confirm Password</label>
            <div class="col-md-7">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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
        <h5 class="modal-title text-center" id="exampleModalLabel">User Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="newedit" method="post" action="edituser">
        {{ csrf_field() }}

        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="e_username" class="col-md-5 col-form-label text-md-left">User ID</label>
            <div class="col-md-7">
              <input id="e_username" type="text" class="form-control" name="e_username" value="{{ old('e_username') }}" autocomplete="off" maxlength="6" readonly autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_name" class="col-md-5 col-form-label text-md-left">Full Name</label>
            <div class="col-md-7">
              <input id="e_name" type="text" class="form-control" name="e_name" value="{{ old('e_name') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_email" class="col-md-5 col-form-label text-md-left">Email</label>
            <div class="col-md-7">
              <input id="e_email" type="email" class="form-control" name="e_email" value="{{ old('e_name') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_active" class="col-md-5 col-form-label text-md-left">Active</label>
            <div class="col-md-7">
              <select id="e_active" class="form-control" name="e_active" required>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <select id="e_dept" class="form-control" name="e_dept" required>
                <option value="">--Select Data--</option>
                @foreach($datadept as $dd)
                  <option value="{{$dd->dept_code}}">{{$dd->dept_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_password" class="col-md-5 col-form-label text-md-left">Password</label>
            <div class="col-md-7">
              <input id="e_password" type="password" class="form-control" name="e_password" autocomplete="new-password" autocomplete="off" autofocus >
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_password-confirm" class="col-md-5 col-form-label text-md-left">Confirm Password</label>
            <div class="col-md-7">
              <input id="e_password-confirm" type="password" class="form-control" name="e_password_confirmation" autocomplete="off" autofocus >
            </div>
          </div>
          
          <div class="modal-footer">
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

<!--Modal Delete-->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">User Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="delete" method="post" action="deleteuser">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="tmp_username" id="tmp_username">
          Delete User <b> <span id="d_username"></span> -- <span id="d_name"></span> </b> ?
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
  $('#divisi').select2({
    placeholder: "Select Data",
    width:'100%',
    theme: 'bootstrap4',
  });

  $('#dept').select2({
    placeholder: "Select Data",
    width:'100%',
    theme: 'bootstrap4',
  });


  $("#new").submit(function() {
    document.getElementById('btnclose').style.display = 'none';
    document.getElementById('btnconf').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
  });

  $("#newedit").submit(function() {
    document.getElementById('e_btnclose').style.display = 'none';
    document.getElementById('e_btnconf').style.display = 'none';
    document.getElementById('e_btnloading').style.display = '';
    
  });

  $("#delete").submit(function() {
    //alert('test');
    document.getElementById('d_btnclose').style.display = 'none';
    document.getElementById('d_btnconf').style.display = 'none';
    document.getElementById('d_btnloading').style.display = '';
  });

  $(document).on('click', '.edituser', function() {

    $('#editModal').modal('show');

    var name      = $(this).data('name');
    var username  = $(this).data('username');
    var email     = $(this).data('email');
    var divisi    = $(this).data('divisi');

    document.getElementById('e_name').value     = name;
    document.getElementById('e_username').value = username;
    document.getElementById('e_email').value    = email;
    document.getElementById('e_divisi').value   = divisi;

    document.getElementById('hidden_divisi').value = divisi;

    $('#e_divisi').select2({
      theme: 'bootstrap4',
      e_divisi,
    });
    
  });

  // flag tunggu semua menu


  $(document).on('click', '.deleteuser', function() {
    $('#deleteModal').modal('show');

    var name = $(this).data('name');
    var username = $(this).data('username');

    document.getElementById('d_name').innerHTML = name;
    document.getElementById('d_username').innerHTML = username;
    document.getElementById('tmp_username').value = username;

    // flag tunggu semua menu
  });

  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function fetch_data(page, sort_type, sort_by, username, divisi) {
    $.ajax({
      url: "/usermt/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&username=" + username + "&divisi=" + divisi,
      success: function(data) {
        console.log(data);
        $('tbody').html('');
        $('tbody').html(data);
      }
    })
  }

  $(document).on('click', '#btnsearch', function() {
    var username  = $('#s_username').val(); 
    var divisi    = $('#s_div').val(); 

    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();
    var page = 1;

    document.getElementById('tmpusername').value  = username;
    document.getElementById('tmpdiv').value       = divisi;

    fetch_data(page, sort_type, column_name, username, divisi);
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

    var page = $('#hidden_page').val();
    var username = $('#s_username').val();
    var divisi = $('#s_div').val();

    fetch_data(page, reverse_order, column_name, username, divisi);
  });

  
  $(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    $('#hidden_page').val(page);
    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();

    var username = $('#tmpusername').val();
    var divisi = $('#tmpdiv').val();
    
    fetch_data(page, sort_type, column_name, username, divisi);
  });

  $(document).on('click', '#btnrefresh', function() {
    var username  = ''; 
    var divisi    = ''; 

    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();
    var page = 1;

    document.getElementById('s_username').value     = '';
    document.getElementById('s_div').value          = '';
    document.getElementById('tmpusername').value   = username;
    document.getElementById('tmpdiv').value        = divisi;

    fetch_data(page, sort_type, column_name, username, divisi);
  });

  $(document).on('change','#username',function(){
    var username = $('#username').val();

    $.ajax({
      url: "/cekuser?username=" + username,
      success: function(data) {
        if (data == "ada") {
          alert("User Sudah Terdaftar!!");
          document.getElementById('username').value = '';
          document.getElementById('username').focus();
        }
        console.log(data);
      }
    })
     
  });
  
</script>
@endsection