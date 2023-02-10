@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Instruction Code Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Instruction Code Create</button>
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
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Code</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_code" class="form-control" name="s_code">
            <option value=""></option>
            @foreach($datains as $sins)
                <option value="{{$sins->ins_code}}">{{$sins->ins_code}} - {{$sins->ins_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Description</label>
    <div class="col-md-4 mb-2 input-group">
        <input id="s_desc" type="text" class="form-control" name="s_desc" value="" autofocus autocomplete="off"/>
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
                <th width="15%">Code<span id="location_id_icon"></span></th>
                <th width="30%">Description</th>
                <th width="15%">Reference</th>
                <th width="30%">Part</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-instruction')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="ins_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Instruction Code Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createins">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Code
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_code" type="text" class="form-control" name="t_code" autocomplete="off" autofocus maxlength="10" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_desc" class="col-md-4 col-form-label text-md-right"> Description
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <textarea id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" autofocus maxlength="200" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_ref" class="col-md-4 col-form-label text-md-right">Reference</label>
                        <div class="col-md-6">
                            <input id="t_ref" type="text" class="form-control" name="t_ref" autocomplete="off" autofocus maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_part" class="col-md-4 col-form-label text-md-right">Part Code</label>
                        <div class="col-md-6">
                            <select id="t_part" name="t_part[]" class="form-control" multiple="multiple">
                              <option value="">--Select Parts--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_tool" class="col-md-4 col-form-label text-md-right">Tools Code</label>
                        <div class="col-md-6">
                            <select id="t_tool" name="t_tool[]" class="form-control" multiple="multiple" >
                              <option value="">--Select Tools--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="t_hour" class="col-md-4 col-form-label text-md-right">Standard Hour</label>
                        <div class="col-md-6">
                            <input id="t_hour" type="number" step="any" class="form-control" name="t_hour" autocomplete="off" autofocus/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_check" class="col-md-4 col-form-label text-md-right">Standard Condition</label>
                        <div class="col-md-6">
                            <input id="t_check" type="text" class="form-control" name="t_check" autocomplete="off" autofocus maxlength="100" />
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="t_check_desc" class="col-md-4 col-form-label text-md-right">Check Description</label>
                        <div class="col-md-6">
                            <input id="t_check_desc" type="text" class="form-control" name="t_check_desc" autocomplete="off" autofocus maxlength="100" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_check_mea" class="col-md-4 col-form-label text-md-right">Check Measurement</label>
                        <div class="col-md-6">
                            <input id="t_check_mea" type="text" class="form-control" name="t_check_mea" autocomplete="off" autofocus maxlength="100"  />
                        </div>
                    </div> -->
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btncreate">Save</button> 
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Instruction Code Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editins">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">Code</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" autocomplete="off" autofocus readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-4 col-form-label text-md-right">Description
                    <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <textarea id="te_desc" type="text" class="form-control" name="te_desc" autocomplete="off" autofocus maxlength="200" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_ref" class="col-md-4 col-form-label text-md-right">Reference</label>
                    <div class="col-md-6">
                        <input id="te_ref" type="text" class="form-control" name="te_ref" autocomplete="off" autofocus maxlength="50"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_part" class="col-md-4 col-form-label text-md-right">Parts Code</label>
                    <div class="col-md-6">
                        <select id="te_part" name="te_part[]" class="form-control" multiple="multiple">
                           <option value="">--Select Parts--</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_tool" class="col-md-4 col-form-label text-md-right">Tools Code</label>
                    <div class="col-md-6">
                        <select id="te_tool" name="te_tool[]" class="form-control" multiple="multiple" >
                          <option value="">--Select Tools--</option>
                        </select>
                        <input type="hidden" name="hd_tool" id="hd_tool">
                        <input type="hidden" name="hd_part" id="hd_part">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="te_hour" class="col-md-4 col-form-label text-md-right">Standard Hour</label>
                    <div class="col-md-6">
                        <input id="te_hour" type="number" step="any" class="form-control" name="te_hour" autocomplete="off" autofocus/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_check" class="col-md-4 col-form-label text-md-right">Standard Condition</label>
                    <div class="col-md-6">
                        <input id="te_check" type="text" class="form-control" name="te_check" autocomplete="off" autofocus maxlength="100" />
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="te_check_desc" class="col-md-4 col-form-label text-md-right">Check Description</label>
                    <div class="col-md-6">
                        <input id="te_check_desc" type="text" class="form-control" name="te_check_desc" autocomplete="off" autofocus maxlength="100" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_check_mea" class="col-md-4 col-form-label text-md-right">Check Measurement</label>
                    <div class="col-md-6">
                        <input id="te_check_mea" type="text" class="form-control" name="te_check_mea" autocomplete="off" autofocus maxlength="100"  />
                    </div>
                </div> -->
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Instruction Code Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteins">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code"> Delete Instruction Code <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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

           var code       = $(this).data('code');
           var desc       = $(this).data('desc');
           var ref        = $(this).data('ref');
           var tool       = $(this).data('tool');
           var part       = $(this).data('part');
           var hour       = $(this).data('hour');
           var check      = $(this).data('check');
           // var check_desc = $(this).data('check_desc');
           // var check_mea  = $(this).data('check_mea');

           document.getElementById('te_code').value       = code;
           document.getElementById('te_desc').value       = desc;
           document.getElementById('te_ref').value        = ref;
           document.getElementById('hd_tool').value       = tool;
           document.getElementById('hd_part').value       = part;
           document.getElementById('te_hour').value       = hour;
           document.getElementById('te_check').value      = check;
           // document.getElementById('te_check_desc').value = check_desc;
           // document.getElementById('te_check_mea').value  = check_mea;

            $("#te_tool").select2({
                width : '100%',
                placeholder : 'Select Tools',
                closeOnSelect : false,
                allowClear : true,
            });

            $("#te_part").select2({
                width : '100%',
                placeholder : 'Select Parts',
                closeOnSelect : false,
                allowClear : true,
            });

            viewtool();
            viewpart();
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

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

       function fetch_data(page, sort_type, sort_by, code, desc){
            $.ajax({
                url:"insmaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc,
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
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;

            fetch_data(page, sort_type, column_name, code, desc);
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
			fetch_data(page, reverse_order, column_name, code, desc);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            fetch_data(page, sort_type, column_name, code, desc);
       });

       $(document).on('click', '#btnrefresh', function() {

            var code  = ''; 
            var desc = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_desc').value  = '';
            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmpdesc').value  = desc;

            fetch_data(page, sort_type, column_name, code, desc);

            $("#s_code").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });
        });


        $(document).on('change','#t_code',function(){

            var code = $('#t_code').val();
            var desc = $('#t_desc').val();

            $.ajax({
              url: "/cekins?code=" + code + "&desc=" + desc,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Instruction Already Registered!!");
                  document.getElementById('t_code').value = '';
                  document.getElementById('t_code').focus();
                }
                console.log(data);
              
              }
            })
        });

        $("#t_tool").select2({
            width : '100%',
            placeholder : 'Select Tools',
            closeOnSelect : false,
            allowClear : true,
        });

        $("#t_part").select2({
            width : '100%',
            placeholder : 'Select Parts',
            closeOnSelect : false,
            allowClear : true,
        });

        function viewtool(){

            $('#t_tool').html(''); 
            $('#te_tool').html(''); 

            var tool = $('#hd_tool').val();
            if (tool == '') {
                var a = '';
            } else {
                var a = tool.split(",");
            }

            $.ajax({
                url:"/viewtool",
                success: function(data) {
                    var jmldata = data.length;

                    var tool_code = [];
                    var tool_desc = [];
                    var test = [];

                    test += '<option value="">--Select Tools--</option>';

                    for(i = 0; i < jmldata; i++){
                        tool_code.push(data[i].tool_code);
                        tool_desc.push(data[i].tool_desc);
 
                        if (a.includes(tool_code[i])) {
                            test += '<option value=' + tool_code[i] + ' selected>' + tool_code[i] + '--' + tool_desc[i] + '</option>';
                        } else {    
                            test += '<option value=' + tool_code[i] + '>' + tool_code[i] + '--' + tool_desc[i] + '</option>';
                        }                   
                    }
                   
                    $('#t_tool').html('').append(test); 
                    $('#te_tool').html('').append(test); 
                }
            })
        }

        function viewpart(){
            $('#t_part').html('')
            $('#te_part').html('')

            var part = $('#hd_part').val();
            var edit = 0;

            if (part == '') {
                var a = '';
            } else {
                var a = part.split(",");
            }
           
            $.ajax({
                url:"/viewpart",
                success: function(data) {
                    var jmldata = data.length;

                    var spm_code = [];
                    var spm_desc = [];
                    var test = [];

                    test += '<option value="">--Select Parts--</option>';

                    for(i = 0; i < jmldata; i++){
                        spm_code.push(data[i].spm_code);
                        spm_desc.push(data[i].spm_desc);
 
                        if (a.includes(spm_code[i])) {
                            test += '<option value=' + spm_code[i] + ' selected>' + spm_code[i] + '--' + spm_desc[i] + '</option>';
                            edit = 1;
                        } else {    
                            test += '<option value=' + spm_code[i] + '>' + spm_code[i] + '--' + spm_desc[i] + '</option>';
                        }                   
                    }
                   
                    
                    $('#t_part').html('').append(test); 
                    $('#te_part').html('').append(test); 
                  
                }
            })
        }

        viewpart();
        viewtool();

        $("#s_code").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection