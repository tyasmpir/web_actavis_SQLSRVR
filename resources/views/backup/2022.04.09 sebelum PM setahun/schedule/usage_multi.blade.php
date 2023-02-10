@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Asset Multi Batch</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Asset Batch Reporting</li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection

@section('content')
<!-- Flash Menu -->

<div class="col-12 form-group row">
  
  <!--FORM Search Disini-->
  <label for="s_nomorwo" class="col-md-2 col-form-label text-md-left">{{ __('Asset') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <select name="asset" id="asset" class="form-control">
            <option value="">-- All--</option>
        @foreach($asset as $asset)
            <option value="{{$asset->asset_code}}">{{$asset->asset_code}} - {{$asset->asset_desc}}</option>
        @endforeach
    </select>
  </div>
  <label for="" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" style="float:right" />
  </div>
  <!-- <div class="col-md-2 col-sm-12 mb-2 input-group">
    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
  </div> -->
</div>
<hr>

<div class="table-responsive col-12">
    <form method="post" action="batchwo">
      {{csrf_field()}}
      <table class="table table-bordered mt-4 mini-table" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr style="text-align: center;">
            <th width="15%">Asset Code</th>
            <th width="35%">Asset Description</th>
            <th width="10%">Last Measurement</th>
            <th width="10%">Tolerance</th>
            <th width="10%">Next MT (Month/Meter)</th>
            <th width="5%">Asset Type</th>
            <th width="10%">PM In Use</th>
            <th width="5%">Action</th>
          </tr>
        </thead>
          <tbody id="bodyasset">
            <!-- <tr>
              <td colspan="7" style="color:red;text-align: center;">No Data Available</td>
            </tr> -->
            @include('schedule.table-usage_multi')
          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
                <input type="submit" value="Generate WO" class="btn btn-success" style="float:right">
              </td>
            </tr>
          </tfoot>
  </table>
    </form>
    
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="asset_mstr.asset_code" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!--Modal Edit-->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Asset Usage Reporting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form method="post" action="/updateusagemulti">
          {{csrf_field()}}
          <input type="hidden" name="asset_code" id="asset_code">
          <div class="modal-body" id="multiusage">
        		Create WO Preventive ?  
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
</div>


<div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>      
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#asset').select2({
        placeholder: "Select Data",
        width:'100%',
        theme: 'bootstrap4',
    });
    
    $("#new").submit(function() {
        document.getElementById('btnclose').style.display = 'none';
        document.getElementById('btnconf').style.display = 'none';
        document.getElementById('btnloading').style.display = '';
    });

    function clear_icon() {
        $('#id_icon').html('');
        $('#post_title_icon').html('');
    }

    function fetch_data(page, sort_type, sort_by, asset) {

        $.ajax({
        url: "/usagemulti?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&asset=" + asset,
        success: function(data) {
            console.log(data);
            $('tbody').html('');
            $('tbody').html(data);
        }
        })
    }

    $(document).on('click', '#btnsearch', function() {
        var asset    = $('#asset').val(); 
        var column_name = $('#hidden_column_name').val();
        var sort_type   = $('#hidden_sort_type').val();
        var page = 1;

        fetch_data(page, sort_type, column_name, asset);
    });
    
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        var column_name = $('#hidden_column_name').val();
        var sort_type   = $('#hidden_sort_type').val();
        var wonumber    = $('#tmpwo').val();
        var asset       = $('#asset').val();
        var status      = $('#tmpstatus').val();

        //alert(wonumber);
        fetch_data(page, sort_type, column_name, asset);
    });

    $(document).on('click', '#btnrefresh', function() {
        var asset    = ''; 
        var column_name = $('#hidden_column_name').val();
        var sort_type   = $('#hidden_sort_type').val();
        var page = 1;

        fetch_data(page, sort_type, column_name, asset);
    });

    $(document).on('click', '.editmodal',function(){
        $asset = $(this).data('asset');
        onuse = $(this).data('assetonuse');

        if(onuse){
        	document.getElementById('btnconf').style.display = 'none';
        	document.getElementById('multiusage').innerHTML = 'Currently under WO number : ' + onuse;
        }else{
        	document.getElementById('btnconf').style.display = '';
        	document.getElementById('multiusage').innerHTML = 'Generate WO Batch ?';
        }

        document.getElementById('asset_code').value = $asset;

    });

    $(document).on('change', '.qaddel', function() {
      var checkbox = $(this), // Selected or current checkbox
        value = checkbox.val(); // Value of checkbox

      if (checkbox.is(':checked')) {
        // alert('y');
        $(this).closest("tr").find('.defdel').val('Y');
      } else {
        // alert('n');
        $(this).closest("tr").find('.defdel').val('N');
      }
    });

</script>
@endsection