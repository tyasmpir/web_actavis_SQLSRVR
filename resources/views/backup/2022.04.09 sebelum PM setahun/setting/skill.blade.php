@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Skill Maintenance</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<style type="text/css">
   
</style>
	
	<!-- Page Heading -->
	@if(session()->has('updated'))
	    <div class="alert alert-success">
	        {{ session()->get('updated') }}
	    </div>
	@endif
	@if(session()->has('deleted'))
	    <div class="alert alert-success">
	        {{ session()->get('deleted') }}
	    </div>
	@endif
 	<div class="mb-4">
	    <div class="card-body">
      <button  class="btn btn-info bt-action deleteUser" data-toggle="modal" data-target="#myModal">
      Create Site</button>
      <br><br>
	      <div class="table-responsive col-lg-12 col-md-12">
	        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
	          <thead>
	            <tr>
				  <th>Skill Code</th>				  
			       <th>Description</th>  			
			       <th width="8%">Edit</th>
			       <th width="8%">Delete</th>
			    </tr>
		       </thead>
                 <tbody>					
				@foreach ($sitemt as $show)
					<tr>
						<td>{{ $show->skill_code }}</td>
                              <td>{{ $show->skill_desc }}</td>	
                              <td>
                				<a href="" class="editModal"  
                					data-code= "{{$show->skill_code}}" data-desc= "{{$show->skill_desc}}" data-toggle='modal' data-target="#editModal"><i class="fas fa-edit"></i></button>
                              </td>
                              <td>                			
                				<a href="" class="deleteRole" data-code="{{$show->skill_code}}"  data-toggle='modal' data-target="#deleteModal"><i class="fas fa-trash-alt"></i></button>               			
                              </td>
					</tr>
				@endforeach			                 
	          </tbody>
	        </table>
	      </div>
	    </div>
	</div>


<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<div class="modal-header">
			        <h5 class="modal-title text-center" id="exampleModalLabel">Create Skill</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
		      	</div>
	         	<div class="panel-body">
					<!-- heading modal -->
					<form class="form-horizontal" role="form" method="POST" action="/skillcreate">
						    {{ csrf_field() }}
	                    <div class="modal-body">	                    
							<div class="form-group row">
		                        <label for="code" class="col-md-3 col-form-label text-md-right">{{ __('Skill Code') }}</label>
				                <div class="col-md-7">
				                    <input id="code" type="text" class="form-control" name="code" value="">
				                </div>
							</div>
                                   
		                    <div class="form-group row">
		                        <label for="desc" class="col-md-3 col-form-label text-md-right">{{ __('Description') }}</label>
				                <div class="col-md-7">
				                    <input id="desc" type="textarea" class="form-control" name="desc" value="">
				                </div>
							</div>
							
	                    </div>
	                     
	                    <div class="modal-footer">
					          <button type="button" class="btn btn-info bt-action" data-dismiss="modal">Close</button>
					          <button type="submit" class="btn btn-success bt-action">Save</button>
					    </div>
					</form> 
	            </div>
			</div>
		</div>
</div>

<div class="modal fade" id="editModal"  tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<div class="modal-header">
			        <h5 class="modal-title text-center" id="exampleModalLabel">Edit Data</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
		      	</div>
	         	<div class="panel-body">
					<!-- heading modal -->
					<form class="form-horizontal" role="form" method="POST" action="/skillupdate">
						
						    {{ csrf_field() }}
	                    <div class="modal-body">
	                    	<div class="form-group row">                                         	
							<div class="form-group row">
                                        <label for="e_code" class="col-md-3 col-form-label text-md-right">{{ __('Site') }}</label>
                                        <div class="col-md-7">
                                             <input id="e_code" type="text" class="form-control" name="e_code" readonly="true">
                                        </div>
							</div>
                                   <div class="form-group row">
		                        <label for="e_desc" class="col-md-3 col-form-label text-md-right">{{ __('Description') }}</label>
				                <div class="col-md-7">
				                    <input id="e_desc" type="textarea" class="form-control" name="e_desc">
				                </div>
							</div>							
	                    </div>
	                     
	                    <div class="modal-footer">
					          <button type="button" class="btn btn-info bt-action" data-dismiss="modal">Close</button>
					          <button type="submit" class="btn btn-success bt-action">Save</button>
					    </div>
					</form> 
	            </div>
			</div>
		</div>
</div>
      
<script type="text/javascript">
	$(document).on('click','.deleteRole',function(){ // Click to only happen on announce links
     
     //alert('tst');
     var uid = $(this).data('domain');
     var site = $(this).data('site');
     document.getElementById("temp_dom").value = uid;
     document.getElementById("temp_site").value = site;

     });

	$(document).on('click','.editModal',function(){ // Click to only happen on announce links
     
     //alert('tst');

     var site = $(this).data('site');
     var desc = $(this).data('desc');
     var act = $(this).data('act');

     
     document.getElementById("e_domain").value = uid;
     document.getElementById("e_site").value = site;
     document.getElementById("e_desc").value = desc;
	 if(act = "true"){ 
     document.getElementById("e_act").checked = true;
	 }
	 else
	 {document.getElementById("e_act").checked = false;
	 }
     });
</script>


@endsection