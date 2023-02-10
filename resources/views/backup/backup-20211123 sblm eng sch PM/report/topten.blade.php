@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<head>
    <title>Chart</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
</head>
<body>
<style type="text/css">
	span.b {
	  display: inline-block;
	  padding: 5px;
	  border: 1px solid blue;    
	}
</style>

<div class="row">
    <div class="col-sm-4">
        <div class="card border-success" style="max-width: 25rem;">
            <div class="card-header bg-success">Top 10 : Most Problematic Assets</div>
            <div class="card-body text-success">
            <table>  
            @php($i = 1)
            @foreach($topprob as $tp)
                @php($ds = $dataasset->where('asset_code','=',$tp->wo_asset)->first())
                <tr>
                    <td><a href="" class="viewdata" id='viewdata' data-toggle="modal" data-target="#viewModal"> {{$i}}. {{$ds->asset_desc}}</a></td>
                    <input type="hidden" name="ascode" id="ascode" value="{{$tp->wo_asset}}">
                    <input type="hidden" name="asdesc" id="asdesc" value="{{$ds->asset_desc}}">
                </tr>
                @php($i += 1)
            @endforeach  
            </table>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card border-warning mb-3" style="max-width: 25rem;">
            <div class="card-header bg-warning">Top 10 : Most Costly Assets</div>
            <div class="card-body text-warning">
                <p class="card-text"></p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-info mb-3" style="max-width: 25rem;">
            <div class="card-header bg-info">Top 10 : Healthy Assets</div>
            <div class="card-body text-info">
                <table>
                @php($i = 1)
                @foreach($tophealthy as $th)
                    <tr>
                        <td>{{$i}}. {{$th->asset_desc}}</td>
                    </tr>
                    @php($i += 1)
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
	
<!--Modal View-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

    <div class="modal-body">

        <h4 class="mb-3" style="margin-left:5px;"><strong>Detail Asset Problem <div id='v_code'></div></strong></h4>

        <table id='suppTable' class='table table-bordered dataTable no-footer order-list mini-table'>
            <thead class="table-primary">
                <tr id='full'>
                    <th>Work Order Number</th>
                    <th>Service Request Number</th>
                    <th>Failure Code</th>
                    <th>Note</th>
                    <th>Start Date</th>
                    <th>Finish Date</th> 
                </tr>
            </thead>
            <tbody id='e_detailapp'>
            </tbody>
        </table>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Close</button>
    </div>
    </div>
</div>  
</div>
</body>

@endsection('content')

@section('script')
<script>
    $(document).on('click', '.viewdata', function() {
      alert('test');
      var code      = $(this).data('ascode');
      var desc      = $(this).data('asdesc');

      document.getElementById('v_code').innerHTML  = code + ' - ' + desc;

      $.ajax({
          url:"/detailtopprob",
          data:{
            code : code,
          },
          success:function(data){
              console.log(data);
              $('#e_detailapp').html('');
              $('#e_detailapp').html(data);
          }
      })
    });


    $(document).on('click', '#btnclose', function(){
            alert('haallo');
            console.log('masuk');
    });
</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection
