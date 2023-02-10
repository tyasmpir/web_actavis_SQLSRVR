@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Started Work Order</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>        
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
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">WO Number</label>
    <div class="col-md-2 col-sm-4 mb-2 input-group">
        <input id="s_code" type="text" class="form-control" name="s_code"
        value="" autofocus autocomplete="off"/>
    </div>
    <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset</label>
    <div class="col-md-2 col-sm-4 mb-2 input-group">
        <input id="s_desc" type="text" class="form-control" name="s_desc"
        value="" autofocus autocomplete="off"/>
    </div>
    <input type="hidden" id="tmpcode"/>
    <input type="hidden" id="tmpdesc"/>
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
                <th class="sorting" data-sorting_type="asc" >Work Order Number</th>
                <th>Service Request Number </th>
                <th>Departement </th>
                <th>Asset </th>
                <th>Schedule Date</th>    
                <th>Due Date</th>
            </tr>
        </thead>
            <!-- untuk isi table -->
            <tbody>                  
                   @foreach($openwo as $show)
                    <tr>
                       <td>{{ $show->wo_nbr }}</td> 
                       <td>{{ $show->wo_sr_nbr }}</td> 
                       <td>{{ $show->wo_dept }}</td>
                       <td>{{ $show->asset_desc  }}</td>
                       <td>{{ $show->wo_schedule }}</td>
                       <td>{{ $show->wo_duedate }}</td>
                    </tr>
                   @endforeach  
                </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="aspar_par"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>


@endsection

