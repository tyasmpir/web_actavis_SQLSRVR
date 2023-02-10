@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Picklist Browse WH</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Picklist Browse WH</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <hr>
@endsection

@section('content')
<style type="text/css">
  @media screen and (max-width: 992px) {

    .mini-table {
      border: 0;
    }

    .mini-table thead {
      display: none;
    }

    .mini-table tr {
      margin-bottom: 10px;
      display: block;
      border-bottom: 2px solid #ddd;
    }

    .mini-table td {
      display: block;
      text-align: right;
      font-size: 13px;
      border-bottom: 1px dotted #ccc;
    }

    .mini-table td:last-child {
      border-bottom: 0;
    }

    .mini-table td:before {
      content: attr(data-label);
      float: left;
      text-transform: uppercase;
      font-weight: bold;
    }
  }
</style>

<!-- table picklist -->
<div class="table-responsive col-12">
  <table class="table table-bordered mt-4 text-center no-footer mini-table" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_nbr" style="cursor: pointer; text-align: center;" width="20%">No. SO<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust" style="cursor: pointer; text-align: center;" width="20%">Customer<span id="username_icon"></span></th>
        <th width="15%">Total Line</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="role_desc" style="cursor:pointer; text-align: center;" width="15%">Status</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="site_desc" style="cursor:pointer; text-align: center;" width="15%">PIC WH</th>
        <th style="text-align: center;" width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('picklistbrowse.table-picklistwh')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- modal picking warehouse -->

<!-- Flash Menu -->

@endsection


@section('scripts')
<script type="text/javascript">

</script>
@endsection