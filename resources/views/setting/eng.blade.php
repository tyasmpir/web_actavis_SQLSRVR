@extends('layout.newlayout')
@section('content-header')
	  
	  <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">User Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">User Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection

@section('content')
<!-- Bagian Searching -->
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
        <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">User ID</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="s_code" type="text" class="form-control" name="s_code"
            value="" autofocus autocomplete="off"/>
        </div>
        <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">User Name</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <input id="s_desc" type="text" class="form-control" name="s_desc"
            value="" autofocus autocomplete="off"/>
        </div>
    </div>
    <div class="col-12 form-group row">
        <label for="s_dept" class="col-md-2 col-sm-2 col-form-label text-md-right">Department</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <select id="s_dept" class="form-control" name="s_dept" required>
                <option value="">--Select Data--</option>
                @foreach($dataeng as $de)
                  <option value="{{$de->dept_code}}">{{$de->dept_code}} -- {{$de->dept_desc}}</option>
                @endforeach
            </select>
        </div>
        <label for="s_role" class="col-md-2 col-sm-2 col-form-label text-md-right">Role</label>
        <div class="col-md-4 col-sm-4 mb-2 input-group">
            <select id="s_role" class="form-control" name="s_role" >
                <option value="">--Select Data--</option>
                @foreach($datarole as $dr)
                  <option value="{{$dr->role_code}}">{{$dr->role_code}} -- {{$dr->role_desc}}</option>
                @endforeach
            </select>
        </div>
        <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search"/> 
        </div>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
        </div>
        <input type="hidden" id="tmpcode"/>
        <input type="hidden" id="tmpdesc"/>
        <input type="hidden" id="tmpdept"/>
        <input type="hidden" id="tmprole"/>
    </div>
</li>
</ul>
</li>
</ul>
</div>

<div class="col-md-12"><hr></div>
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">ID</th>
                <th width="25%">User Name</th>
                <th width="15%">Department</th>
                <th width="10%">Access As</th>
                <th width="10%">Role</th>
                <th width="10%">Active</th>
                <th width="10%">Approver</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-eng')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="eng_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">User Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createeng" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">User ID 
                            <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_code" type="text" class="form-control" name="t_code"
                            autocomplete="off" autofocus maxlength="10" required pattern="{0,8}" title="Maks.10" value="{{ old('t_code') }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_desc" class="col-md-4 col-form-label text-md-right">User Name 
                            <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" autofocus maxlength="50" required value="{{ old('t_desc') }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_email" class="col-md-4 col-form-label text-md-right">Email <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_email" type="email" class="form-control" name="t_email" autocomplete="off" autofocus required value="{{ old('t_email') }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_dept" class="col-md-4 col-form-label text-md-right">Department <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_dept" class="form-control" name="t_dept" required>
                                <option value="">--Select Data--</option>
                                @foreach($dataeng as $de)
                                  <option value="{{$de->dept_code}}">{{$de->dept_code}} -- {{$de->dept_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_active" class="col-md-4 col-form-label text-md-right">Active <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                           <select id="t_active" class="form-control" name="t_active" required value="{{ old('t_active') }}">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_acc" class="col-md-4 col-form-label text-md-right">Access As <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                           <select id="t_acc" class="form-control" name="t_acc" required value="{{ old('t_acc') }}" required>
                                <option value="">--Select Data--</option>
                                <option value="User">User</option>
                                <option value="Engineer">Engineer</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_role" class="col-md-4 col-form-label text-md-right">Role <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_role" class="form-control" name="t_role" >
                               
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                          <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group row divapp" id="divapp" style="display: none;">
                        <label for="t_app" class="col-md-4 col-form-label text-md-right" >Approver <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                           <select id="t_app" class="form-control" name="t_app" required value="{{ old('t_app') }}">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row divbrt" id="divbrt" style="display: none;">
                        <label for="t_brt_date" class="col-md-4 col-form-label text-md-right">Birth Date</label>
                        <div class="col-md-6">
                            <input id="t_brt_date" type="date" class="form-control" name="t_brt_date" placeholder="yy-mm-dd" autocomplete="off" autofocus  value="{{ old('t_brt_date') }}">
                        </div>
                    </div>
                    <div class="form-group row divjoin" id="divjoin" style="display: none;">
                        <label for="t_join" class="col-md-4 col-form-label text-md-right">Join Date</label>
                        <div class="col-md-6">
                            <input id="t_join" type="date" class="form-control" name="t_join" placeholder="yy-mm-dd"  autocomplete="off" autofocus  value="{{ old('t_join') }}">
                        </div>
                    </div>
                    <div class="form-group row divrate" id="divrate" style="display: none;">
                        <label for="t_rate" class="col-md-4 col-form-label text-md-right">Rate / Hour</label>
                        <div class="col-md-6">
                            <input id="t_rate" type="number" step="any" class="form-control" name="t_rate" autocomplete="off" autofocus maxlength="7"  pattern="[0-9]{0,7}" title="Masukan hanya angka 0-9. Maks.7" value="{{ old('t_rate') }}"/>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="t_skill" class="col-md-4 col-form-label text-md-right">Skill</label>
                        <div class="col-md-6">
                            <select class="form-select" multiple size="3" id="t_skill" name="t_skill[]" required>
                              <option selected>Open this select menu</option>
                              @foreach($dataskill as $ds)
                                  <option value="{{$ds->skill_code}}">{{$ds->skill_desc}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div> -->
                    <div class="form-group row divskill" id="divskill" style="display: none;">
                        <label for="enjiners" class="col-md-4 col-form-label text-md-right">Engineer Skills</label>
                        <div class="col-md-6">
                            <select id="enjiners" name="enjiners[]" class="form-control" multiple="multiple" >
                              <option value="">--Select Skills--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row divfoto" id="divfoto" style="display: none;">
                        <label for="t_photo" class="col-md-4 col-form-label text-md-right">Photo</label>
                        <div class="col-md-6">
                            <input id="t_photo" name="t_photo" type="file" class="form-control-file" id="exampleFormControlFile1"  value="{{ old('t_photo') }}">
                        </div>
                    </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action btncreate" id="btncreate">Save</button> 
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">User Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editeng" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">User ID</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-4 col-form-label text-md-right">User Name 
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <input id="te_desc" type="text" class="form-control" name="te_desc" autocomplete="off" autofocus maxlength="50" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_email" class="col-md-4 col-form-label text-md-right">Email <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <input id="te_email" type="email" class="form-control" name="te_email" autocomplete="off" autofocus required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_dept" class="col-md-4 col-form-label text-md-right" >Department <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="te_dept" class="form-control" name="te_dept" required >
                            @foreach($dataeng as $de)
                              <option value="{{$de->dept_code}}">{{$de->dept_code}} -- {{$de->dept_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_active" class="col-md-4 col-form-label text-md-right">Active <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <!-- 2024.04.01 Perubahan aktif hanya tidak hanya bisa dilakukan oleh IMI
							Karena untuk mengatur login yang aktif sesuai license
						<select id="te_active" class="form-control" name="te_active" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select> -->
						<input id="te_active" type="input" class="form-control" name="te_active" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_acc" class="col-md-4 col-form-label text-md-right">Access As <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="te_acc" class="form-control" name="te_acc" required value="{{ old('te_acc') }}" required>
                            <option value="">--Select Data--</option>
                            <option value="User">User</option>
                            <option value="Engineer">Engineer</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_role" class="col-md-4 col-form-label text-md-right">Role <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="te_role" class="form-control" name="te_role" required>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_pass" class="col-md-4 col-form-label text-md-right">Password</label>
                    <div class="col-md-6">
                      <input id="te_pass" type="password" class="form-control" name="te_pass" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_pass-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                    <div class="col-md-6">
                      <input id="te_pass-confirm" type="password" class="form-control" name="te_pass_confirmation">
                    </div>
                </div>  
                <div class="form-group row diveapp" id="diveapp" style="display: none;">
                    <label for="te_app" class="col-md-4 col-form-label text-md-right">Approver <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                       <select id="te_app" class="form-control" name="te_app"  value="{{ old('te_app') }}">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row divebrt" id="divebrt" style="display: none;">
                    <label for="te_brt_date" class="col-md-4 col-form-label text-md-right">Birth Date</label>
                    <div class="col-md-6">
                        <input id="te_brt_date" type="date" class="form-control" name="te_brt_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                    </div>
                </div>
                
                <div class="form-group row divejoin" id="divejoin" style="display: none;">
                    <label for="te_join" class="col-md-4 col-form-label text-md-right">Join Date</label>
                    <div class="col-md-6">
                        <input id="te_join" type="date" class="form-control" name="te_join" placeholder="yy-mm-dd"  autocomplete="off" autofocus >
                    </div>
                </div>
                <div class="form-group row diverate" id="diverate" style="display: none;">
                    <label for="te_rate" class="col-md-4 col-form-label text-md-right">Rate / Hour</label>
                    <div class="col-md-6">
                        <input id="te_rate" type="number" step="any" class="form-control" name="te_rate" autocomplete="off" autofocus max="99999.99"/>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="te_skill" class="col-md-4 col-form-label text-md-right">Skill</label>
                    <div class="col-md-6">
                        <select class="form-select" multiple size="3" id="te_skill" name="te_skill[]" required>
                         
                        </select>
                    </div>
                </div> -->
                <div class="form-group row diveskill" id="diveskill" style="display: none;">
                    <label for="te_enjiners" class="col-md-4 col-form-label text-md-right">Engineer Skills</label>
                    <div class="col-md-6">
                        <select class="form-select" multiple="multiple" size="3" id="te_enjiners" name="te_enjiners[]" >
                        </select>
                        <input type="hidden" id="te_skill" name="te_skill">
                    </div>
                </div>
                
                <div class="form-group row divefoto" id="divefoto" style="display: none;">
                    <label for="te_photo" class="col-md-4 col-form-label text-md-right">Photo</label>
                    <div class="col-md-6">
                        <input id="te_photo" name="te_photo" type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </div>
                <div class="form-group row divefoto1" id="divefoto1" style="display: none;">
                    <label for="foto1" class="col-md-4 col-form-label text-md-right">Photo</label>
                    <div class="col-md-6">
                        <img src="\upload\1.jpg" class="rounded" width="150px" id="foto1">
                    </div>
                </div>
                
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success bt-action" id="btnedit">Save</button>
            </div>
        </form>
    </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center" id="exampleModalLabel">User Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteeng">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Delete User <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btndelete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
       $(document).on('click', '#editdata', function(e){
           $('#editModal').modal('show');

           var code     = $(this).data('code');
           var desc     = $(this).data('desc');
           var birth    = $(this).data('birth');
           var active   = $(this).data('active');
           var join     = $(this).data('join');
           var rate     = $(this).data('rate');
           var skill    = $(this).data('skill');
           var email    = $(this).data('email');
           var photo    = $(this).data('photo');
           var url      = '/upload/' + photo;
           var role     = $(this).data('role');
           var app      = $(this).data('app');
           var dept     = $(this).data('dept');
           var acc      = $(this).data('acc');

           if (app == 'No') {
                app = 0;
           } else {
                app = 1;
           }

           document.getElementById('foto1').src         = url;
           document.getElementById('te_code').value     = code;
           document.getElementById('te_desc').value     = desc;
           document.getElementById('te_brt_date').value = birth;
           document.getElementById('te_active').value   = active;
           document.getElementById('te_join').value     = join;
           document.getElementById('te_rate').value     = rate;
           document.getElementById('te_email').value    = email;
           document.getElementById('te_role').value     = role;
           document.getElementById('te_app').value      = app;
           document.getElementById('te_dept').value     = dept;
           document.getElementById('te_skill').value    = skill;
           document.getElementById('te_acc').value      = acc;

           ambilenjiner();

            $.ajax({
                url:"/engrole2?code=" + code + "&acc=" + acc,
                success:function(data){
                    console.log(data);
                    $('#te_role').html('').append(data);
                }
            }) 

            if(acc == 'Engineer'){
                document.getElementById('diveapp').style.display='';
                document.getElementById('divebrt').style.display='';
                document.getElementById('divejoin').style.display='';
                document.getElementById('diverate').style.display='';
                document.getElementById('diveskill').style.display='';
                document.getElementById('divefoto').style.display='';
                document.getElementById('divefoto1').style.display='';
            }
            else{ 
                document.getElementById('diveapp').style.display='none';
                document.getElementById('divebrt').style.display='none';
                document.getElementById('divejoin').style.display='none';
                document.getElementById('diverate').style.display='none';
                document.getElementById('diveskill').style.display='none';
                document.getElementById('divefoto').style.display='none';
                document.getElementById('divefoto1').style.display='none';
            }
           
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');

            document.getElementById('d_code').value      = code;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc, dept, role){
            $.ajax({
                url:"engmaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc+"&dept="+dept+"&role="+role,
                success:function(data){
                    console.log(data);

                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){

            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            var dept = $('#s_dept').val();
            var role = $('#s_role').val();

            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;
            document.getElementById('tmpdept').value = dept;
            document.getElementById('tmprole').value = role;

            fetch_data(page, sort_type, column_name, code, desc, dept, role);
        });

       $(document).on('click', '.sorting', function(){
			var column_name = $(this).data('column_name');
			var order_type = $(this).data('sorting_type');
			var reverse_order = '';
			if(order_type == 'asc')
			{
			$(this).data('sorting_type', 'desc');
			reverse_order = 'desc';
			clear_icon();
			$('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
			}
			if(order_type == 'desc')
			{
			$(this).data('sorting_type', 'asc');
			reverse_order = 'asc';
			clear_icon();
			$('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
			}
			$('#hidden_column_name').val(column_name);
			$('#hidden_sort_type').val(reverse_order);
            var page = $('#hidden_page').val();
            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            var dept = $('#s_dept').val();
            var role = $('#s_role').val();
			fetch_data(page, reverse_order, column_name, code, desc, dept, role);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var reverse_order = 'asc';
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            var dept = $('#s_dept').val();
            var role = $('#s_role').val();
            fetch_data(page, reverse_order, column_name, code, desc, dept, role);
       });

       $(document).on('click', '#btnrefresh', function() {

            var code  = ''; 
            var desc = '';
            var dept = '';
            var role = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_desc').value  = '';
            document.getElementById('s_dept').value  = '';
            document.getElementById('s_role').value  = '';
            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmpdesc').value  = desc;
            document.getElementById('tmpdept').value  = dept;
            document.getElementById('tmprole').value  = role;

            fetch_data(page, sort_type, column_name, code, desc, dept, role);
        });

        $(document).on('change','#t_code',function(){
            var code = $('#t_code').val();

            $.ajax({
              url: "/cekeng?code=" + code,
              success: function(data) {
                if (data == "ada") {
                  alert("Engineer is Already Registerd!!");
                  document.getElementById('t_code').value = '';
                  document.getElementById('t_code').focus();
                }
                console.log(data);
              }
            })
             
        });

        $("#enjiners").select2({
            width : '100%',
            placeholder : 'Select Skill',
            maximumSelectionLength : 5,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
        });

        function ambilenjiner(){
            var skill = $('#te_skill').val();
            var a = skill.split(",");

            $.ajax({
                url:"/engskill",
                success: function(data) {
                    var jmldata = data.length;

                    var skill_code = [];
                    var skill_desc = [];
                    var test = [];

                    test += '<option value="">--Select Skill--</option>';

                    for(i = 0; i < jmldata; i++){
                        skill_code.push(data[i].skill_code);
                        skill_desc.push(data[i].skill_desc);

                        if (a.includes(skill_code[i])) {
                            test += '<option value=' + skill_code[i] + ' selected>' + skill_code[i] + '--' + skill_desc[i] + '</option>';
                        } else {    
                            test += '<option value=' + skill_code[i] + '>' + skill_code[i] + '--' + skill_desc[i] + '</option>';
                        }                        
                    }

                    $('#te_enjiners').html('').append(test); 
                }
            })
        }

        $("#te_enjiners").select2({
            width : '100%',
            maximumSelectionLength : 5,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
        });

        function createskill(){

            $.ajax({
                url:"/engskill",
                success: function(data) {
                    var jmldata = data.length;

                    var skill_code = [];
                    var skill_desc = [];
                    var test = [];

                    test += '<option value="">--Select Skill--</option>';

                    for(i = 0; i < jmldata; i++){
                        skill_code.push(data[i].skill_code);
                        skill_desc.push(data[i].skill_desc);
 
                        test += '<option value=' + skill_code[i] + '>' + skill_code[i] + '--' + skill_desc[i] + '</option>';                   
                    }
                   
                    $('#enjiners').html('').append(test); 
                }
            })
        }

        createskill();

        $(document).on('change','#t_acc',function(){
            var acc = $('#t_acc').val();

            $.ajax({
                url:"/engrole?code="+acc,
                success:function(data){
                    console.log(data);
                    $('#t_role').html('').append(data);
                }
            }) 
        });

        $(document).on('change','#te_acc',function(){
            var acc = $('#te_acc').val();

            $.ajax({
                url:"/engrole?code="+acc,
                success:function(data){
                    console.log(data);
                    $('#te_role').html('').append(data);
                }
            }) 
        });

        $(document).on('change','#t_acc',function(){
            var acc = document.getElementById('t_acc').value;

            if(acc == 'Engineer'){
                document.getElementById('divapp').style.display='';
                document.getElementById('divbrt').style.display='';
                document.getElementById('divjoin').style.display='';
                document.getElementById('divrate').style.display='';
                document.getElementById('divskill').style.display='';
                document.getElementById('divfoto').style.display='';
            }
            else{ 
                document.getElementById('divapp').style.display='none';
                document.getElementById('divbrt').style.display='none';
                document.getElementById('divjoin').style.display='none';
                document.getElementById('divrate').style.display='none';
                document.getElementById('divskill').style.display='none';
                document.getElementById('divfoto').style.display='none';
            }
        });

        $(document).on('change','#te_acc',function(){
            var acc = document.getElementById('te_acc').value;

            if(acc == 'Engineer'){
                document.getElementById('diveapp').style.display='';
                document.getElementById('divebrt').style.display='';
                document.getElementById('divejoin').style.display='';
                document.getElementById('diverate').style.display='';
                document.getElementById('diveskill').style.display='';
                document.getElementById('divefoto').style.display='';
                document.getElementById('divefoto1').style.display='';
            }
            else{ 
                document.getElementById('diveapp').style.display='none';
                document.getElementById('divebrt').style.display='none';
                document.getElementById('divejoin').style.display='none';
                document.getElementById('diverate').style.display='none';
                document.getElementById('diveskill').style.display='none';
                document.getElementById('divefoto').style.display='none';
                document.getElementById('divefoto1').style.display='none';
            }
        });
        
    </script>

    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script> -->

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection