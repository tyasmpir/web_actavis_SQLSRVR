@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark">Engineer</h1>
          </div><!-- /.col -->
          <div class="col-sm-3">
          <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">
    Create Engineer</button>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection

@section('content')
<!-- Bagian Searching -->
<div class="container-fluid mb-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<li class="nav-item has-treeview bg-green">
<a href="#" class="nav-link mb-0 p-0"> 
<p>
  <label class="col-md-2 col-form-label text-md-left" style="color:black;">{{ __('Click here to search') }}</label>
  <i class="right fas fa-angle-left"></i>
</p>
</a>
<ul class="nav nav-treeview">
<li class="nav-item">
    <div class="col-12 form-group row">
        <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Engineer Code</label>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <input id="s_code" type="text" class="form-control" name="s_code"
            value="" autofocus autocomplete="off"/>
        </div>
        <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Engineer Description</label>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <input id="s_desc" type="text" class="form-control" name="s_desc"
            value="" autofocus autocomplete="off"/>
        </div>
    </div>
    <div class="col-12 form-group row">
        <label for="s_dept" class="col-md-2 col-sm-2 col-form-label text-md-right">Departemen</label>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <select id="s_dept" class="form-control" name="s_dept" required>
                <option value="">--Select Data--</option>
                @foreach($dataeng as $de)
                  <option value="{{$de->dept_code}}">{{$de->dept_code}} -- {{$de->dept_desc}}</option>
                @endforeach
            </select>
        </div>
        <label for="s_role" class="col-md-2 col-sm-2 col-form-label text-md-right">Role</label>
        <div class="col-md-2 col-sm-4 mb-2 input-group">
            <select id="s_role" class="form-control" name="s_role" >
                <option value="">--Select Data--</option>
                @foreach($datarole as $dr)
                  <option value="{{$dr->role_code}}">{{$dr->role_code}} -- {{$dr->role_desc}}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" id="tmpcode"/>
        <input type="hidden" id="tmpdesc"/>
        <input type="hidden" id="tmpdept"/>
        <input type="hidden" id="tmprole"/>
    </div>
    <div class="col-12 form-group row justify-content-center">    
        <div class="col-md-1 col-sm-4 offset-md-2 offset-lg-0">
          <input type="button" class="btn btn-block btn-primary" 
          id="btnsearch" value="Search"  style="float:right; width: 100px !important"/> 
        </div>
        <div class="col-md-1 col-sm-4 offset-md-2 offset-lg-0">
          <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
        </div>
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
                    <th class="sorting" data-sorting_type="asc" data-column_name="eng_code" style="cursor: pointer;" style="width: 15%;">Engineer Code<span id="location_id_icon"></span></th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 20%;">Departemen</th>
                    <th style="width: 20%;">Role</th>
                    <th style="width: 15%;">Appover</th>
                    <th style="width: 10%;">Action</th>  
                </tr>
            </thead>
            <tbody>
                <!-- untuk isi table -->
                @include('setting.table-engineer')
            </tbody>
        </table>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>`
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="eng_code"/>
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Create Engineer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="post" action="/createeng" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="t_code" class="col-md-4 col-form-label text-md-right">Engineer Code</label>
                            <div class="col-md-6">
                                <input id="t_code" type="text" class="form-control" name="t_code"
                                autocomplete="off" autofocus maxlength="8" required pattern="{0,8}" title="Maks.8" value="{{ old('t_code') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_desc" class="col-md-4 col-form-label text-md-right">Engineer Name</label>
                            <div class="col-md-6">
                                <input id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" autofocus maxlength="30" required value="{{ old('t_desc') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_dept" class="col-md-4 col-form-label text-md-right">Departemen</label>
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
                            <label for="t_app" class="col-md-4 col-form-label text-md-right">Approver</label>
                            <div class="col-md-6">
                               <select id="t_app" class="form-control" name="t_app" required value="{{ old('t_app') }}">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_brt_date" class="col-md-4 col-form-label text-md-right">Birth Date</label>
                            <div class="col-md-6">
                                <input id="t_brt_date" type="date" class="form-control" name="t_brt_date" placeholder="yy-mm-dd" autocomplete="off" autofocus required value="{{ old('t_brt_date') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_active" class="col-md-4 col-form-label text-md-right">Active</label>
                            <div class="col-md-6">
                               <select id="t_active" class="form-control" name="t_active" required value="{{ old('t_active') }}">
                                    <option value="">--Select Data--</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_join" class="col-md-4 col-form-label text-md-right">Join Date</label>
                            <div class="col-md-6">
                                <input id="t_join" type="date" class="form-control" name="t_join" placeholder="yy-mm-dd"  autocomplete="off" autofocus required value="{{ old('t_join') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_rate" class="col-md-4 col-form-label text-md-right">Rate / Hour</label>
                            <div class="col-md-6">
                                <input id="t_rate" type="number" step="any" class="form-control" name="t_rate"
                                autocomplete="off" autofocus maxlength="7" required pattern="[0-9]{0,7}" title="Masukan hanya angka 0-9. Maks.7" value="{{ old('t_rate') }}"/>
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
                        <div class="form-group row">
                            <label for="enjiners" class="col-md-4 col-form-label text-md-right">Skill</label>
                            <div class="col-md-6">
                                <select id="enjiners" name="enjiners[]" class="form-control" multiple="multiple" required>
                                  <option value="">--Select Skill--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input id="t_email" type="email" class="form-control" name="t_email" autocomplete="off" autofocus required value="{{ old('t_email') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_photo" class="col-md-4 col-form-label text-md-right">Photo</label>
                            <div class="col-md-6">
                                <input id="t_photo" name="t_photo" type="file" class="form-control-file" id="exampleFormControlFile1" required value="{{ old('t_photo') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_role" class="col-md-4 col-form-label text-md-right">Role Access</label>
                            <div class="col-md-6">
                                <select id="t_role" class="form-control" name="t_role" >
                                    <option value="">--Select Data--</option>
                                    @foreach($datarole as $dr)
                                      <option value="{{$dr->role_code}}">{{$dr->role_code}} -- {{$dr->role_desc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                              <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                            <div class="col-md-6">
                              <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success bt-action btncreate" id="btncreate">Create</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center" id="exampleModalLabel">Edit Engineer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/editeng" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="te_code" class="col-md-4 col-form-label text-md-right">Engineer Code</label>
                        <div class="col-md-6">
                            <input id="te_code" type="text" class="form-control" name="te_code" readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_desc" class="col-md-4 col-form-label text-md-right">Engineer Description</label>
                        <div class="col-md-6">
                            <input id="te_desc" type="text" class="form-control" name="te_desc" autocomplete="off" autofocus maxlength="30" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_dept" class="col-md-4 col-form-label text-md-right">Departemen</label>
                        <div class="col-md-6">
                            <select id="te_dept" class="form-control" name="te_dept" >
                                @foreach($dataeng as $de)
                                  <option value="{{$de->dept_code}}">{{$de->dept_code}} -- {{$de->dept_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_app" class="col-md-4 col-form-label text-md-right">Approver</label>
                        <div class="col-md-6">
                           <select id="te_app" class="form-control" name="te_app" required value="{{ old('te_app') }}">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_brt_date" class="col-md-4 col-form-label text-md-right">Birth Date</label>
                        <div class="col-md-6">
                            <input id="te_brt_date" type="date" class="form-control" name="te_brt_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_active" class="col-md-4 col-form-label text-md-right">Active</label>
                        <div class="col-md-6">
                            <select id="te_active" class="form-control" name="te_active" required>
                                <option value="">--Select Data--</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_join" class="col-md-4 col-form-label text-md-right">Join Date</label>
                        <div class="col-md-6">
                            <input id="te_join" type="date" class="form-control" name="te_join" placeholder="yy-mm-dd"  autocomplete="off" autofocus >
                        </div>
                    </div>
                    <div class="form-group row">
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
                    <div class="form-group row">
                        <label for="te_enjiners" class="col-md-4 col-form-label text-md-right">Skill</label>
                        <div class="col-md-6">
                            <select class="form-select" multiple="multiple" size="3" id="te_enjiners" name="te_enjiners[]" >
                            </select>
                            <input type="hidden" id="te_skill" name="te_skill">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_email" class="col-md-4 col-form-label text-md-right">Email</label>
                        <div class="col-md-6">
                            <input id="te_email" type="email" class="form-control" name="te_email" autocomplete="off" autofocus required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_photo" class="col-md-4 col-form-label text-md-right">Photo</label>
                        <div class="col-md-6">
                            <input id="te_photo" name="te_photo" type="file" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="foto1" class="col-md-4 col-form-label text-md-right">Photo</label>
                        <div class="col-md-6">
                            <img src="\upload\1.jpg" class="rounded" width="150px" id="foto1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_role" class="col-md-4 col-form-label text-md-right">Role</label>
                        <div class="col-md-6">
                            <select id="te_role" class="form-control" name="te_role" >
                                <option value="">--Select Data--</option>
                                @foreach($datarole as $dr)
                                  <option value="{{$dr->role_code}}">{{$dr->role_code}} -- {{$dr->role_desc}}</option>
                                @endforeach
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Delete Engineer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form class="form-horizontal" method="post" action="/deleteeng">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="d_code" name="d_code">
                        Anda yakin ingin menghapus Engineer <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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
           var dept      = $(this).data('dept');

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

           ambilenjiner();

            // $.ajax({
            //     url:"/engskill?skill=" + skill,
            //     success:function(data){
            //         console.log(data);
            //         $('#te_skill').html('').append(data);
            //     }
            // }) 
           
       });

       $(document).on('click', '.deletedata', function(e){
            var code = $(this).data('code');
            var desc = $(this).data('desc');

            document.getElementById('d_code').value          = code;
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