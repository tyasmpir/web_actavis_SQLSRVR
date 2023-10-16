@extends('layout.newlayout')
@section('content-header')

	  	  <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Number of order statuses</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        {{--  <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Site Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->  --}}
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<div class="col-md-12"><hr></div>
<div class="table-responsive col-6">
    <table class="table table-bordered" id="dataTable" width="50%" cellspacing="0">
        <thead>
            <tr>
                <th width="30%">Status<span id="location_id_icon"></span></th>
                <th width="35%">Jumlah WO</th>  
                <th width="35%">Jumlah PM</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('report.table-wostat')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="site_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

@endsection

@section('scripts')
    <script>
       $(document).on('click', '#editdata', function(e){
           $('#editModal').modal('show');

           var sitecode = $(this).data('sitecode');
           var desc = $(this).data('desc');

           document.getElementById('te_sitecode').value = sitecode;
           document.getElementById('te_sitedesc').value = desc;
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var sitecode = $(this).data('sitecode');
            var desc = $(this).data('desc');

            document.getElementById('d_sitecode').value = sitecode;
            document.getElementById('td_sitecode').innerHTML = sitecode;
            document.getElementById('td_sitedesc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc){
            $.ajax({
                url:"sitemaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc,
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
			fetch_data(page, sort_type, column_name, code, desc);
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

            var code = '';
            var desc = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;
            document.getElementById('s_code').value = code;
            document.getElementById('s_desc').value = desc;

            fetch_data(page, sort_type, column_name, code, desc);
        });

        $(document).on('change','#t_sitecode',function(){

            var code = $('#t_sitecode').val();
            var desc = $('#t_sitedesc').val();

            $.ajax({
              url: "/ceksite?code=" + code + "&desc=" + desc,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Site Already Regitered!!");
                  document.getElementById('t_sitecode').value = '';
                  document.getElementById('t_sitecode').focus();
                }
                console.log(data);
              
              }
            })
       });

       $(document).on('change','#t_sitedesc',function(){

            var code = $('#t_sitecode').val();
            var desc = $('#t_sitedesc').val();

            $.ajax({
              url: "/ceksite?code=" + code + "&desc=" + desc,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Description Site Already Regitered!!");
                  document.getElementById('t_sitedesc').value = '';
                  document.getElementById('t_sitedesc').focus();
                }
                console.log(data);
              
              }
            })
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