@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-8">
            <div class="d-flex justify-content-between">
                <h1 class="m-0 text-dark">Engineer Report</h1>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<style type="text/css">
  img {
      display:block;
      margin-left: auto;
      margin-right: auto;
      max-width: 180px;
      height: 200px;
      margin-top:10px;
  }
  canvas {
      width: 100% !important;
      max-width: 800px;
      height: auto !important;
  }

  .chart-pie {
    position: relative;
    margin: auto;
    height: 65vh;
    width: 80vh;
  }
</style>

<div class="row">
  @php($line = 1)
  @foreach($dataeng as $de)
      
      @if($line == 1)
        <div class="card-deck mb-2 col-12">
      @endif
      
      @php($woeng1 = $datawo->where('wo_engineer1','=',$de->eng_code)->count())
      @php($woeng2 = $datawo->where('wo_engineer2','=',$de->eng_code)->count())
      @php($woeng3 = $datawo->where('wo_engineer3','=',$de->eng_code)->count())
      @php($woeng4 = $datawo->where('wo_engineer4','=',$de->eng_code)->count())
      @php($woeng5 = $datawo->where('wo_engineer5','=',$de->eng_code)->count())
      @php($jmlwo = $woeng1 + $woeng2 + $woeng3 + $woeng4 + $woeng5)

      <div class="col-xl-2 col-lg-4 col-md-6 col-xs-12 pl-0 pr-0">
        <div class="card">
          <a href="" class="editarea2" id='editdata' data-toggle="modal" data-target="#editModal"
            data-code="{{$de->eng_code}}" data-desc="{{$de->eng_desc}}" data-email="{{$de->eng_email}}"
            data-skill="{{$de->eng_skill}}">
            <img class="card-img-top" src="/upload/{{$de->eng_photo}}" alt="Card image cap">
          </a>
          <div class="card-body">
            <p class="card-text">
              <small class="font-weight-bold">{{$de->eng_desc}}
              <br>Work Order : {{$jmlwo}}
              </small>
            </p>
          </div>
        </div>
      </div>
      
      @php($line++)
      
      @if($line == 7)
        </div>
        
        @php($line = 1)
      @endif
  @endforeach
    </div>
</div>

<!-- Modal Engineering -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-center" id="exampleModalLabel">Engineering Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    	</div>
     	<div class="panel-body">
      	<div class="modal-body"  style="overflow-x: auto;">
        	<div class="form-group row col-md-12">
            <label for="e_code" class="col-md-1 col-form-label text-md-right">{{ __('ID') }}</label>
            <div class="col-md-4">
                <input id="e_code" type="text" class="form-control" name="e_code" readonly="true">
            </div>
            <label for="e_desc" class="col-md-1 col-form-label text-md-right">{{ __('Name') }}</label>
            <div class="col-md-6">
                <input id="e_desc" type="text" class="form-control" name="e_desc" readonly="true">
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="e_email" class="col-md-1 col-form-label text-md-right">{{ __('Email') }}</label>
            <div class="col-md-4">
                <input id="e_email" type="text" class="form-control" name="e_email" readonly="true">
            </div>
            <label for="e_skill" class="col-md-1 col-form-label text-md-right">{{ __('Skill') }}</label>
            <div class="col-md-6">
                <textarea id="e_skill" type="text" class="form-control" name="e_skill" readonly="true" ></textarea>
            </div>
        	</div>

            <div class="col-md-12">
              <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                <thead>
                  <tr id='full'>
                    <th width="15%">WO Number</th>
                    <th width="30%">Asset</th>
                    <th width="15%">Engineer</th>
                    <th width="15%">WO Schedule</th>
                    <th width="15%">WO Finish</th>
                    <th width="10%">Status</th>
                  </tr>
                </thead>
                <tbody id='detailapp'>
                </tbody>
              </table>
          </div>
          
          <div class="chart-pie pt-4 pb-2 col-12">
               <canvas id="myexpitm" width="568" height="400"></canvas>
          </div>
      	</div>										
      </div>
      
       
                  
      	<div class="modal-footer">
	        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
	    </div>
		</div>
	</div>
</div>


@endsection('content')

@section('scripts')
<script>
function noexpitm(event, array){
        if(array[0]){
            let element = this.getElementAtEvent(event);
            if (element.length > 0) {
                //var series= element[0]._model.datasetLabel;
                //var label = element[0]._model.label;
                //var value = this.data.datasets[element[0]._datasetIndex].data[element[0]._index];
                window.location = "/expitem";

                //console.log()
            }
        }
    }
</script>

    <script>
       $(document).on('click', '#editdata', function(e){
           var code = $(this).data('code');
           var desc = $(this).data('desc');
           var email = $(this).data('email');
           var skill = $(this).data('skill');

           var a = skill.split(",");

           var code = $(this).data('code');
            var desc = $(this).data('desc');

           $.ajax({
                url:"/engskill",
                success: function(data) {
                    var jmldata = data.length;

                    var skill_code = [];
                    var skill_desc = [];
                    var test = [];

                    test += '';

                    for(i = 0; i < jmldata; i++){
                        skill_code.push(data[i].skill_code);
                        skill_desc.push(data[i].skill_desc);

                        if (a.includes(skill_code[i])) {
                            test += skill_desc[i] + "\n" ;
                        } else {    
                            test += "";
                        }                        
                    }

                    document.getElementById('e_skill').value = test;
                }
            })

           $.ajax({
              url:"engrptview?code="+code,
              success: function(data) {
              console.log(data);
              //alert(data);
              $('#detailapp').html('').append(data);
            }
          })

           document.getElementById('e_code').value = code;
           document.getElementById('e_desc').value = desc;
           document.getElementById('e_email').value = email;

       });

       $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        var canvas = modal.find('.chart-pie canvas');

        // Chart initialisieren
        var ctx = canvas[0].getContext("2d");
        var chart = new Chart(ctx, {
            type: 'bar',
            responsive: false,
            data: {    
              labels: <?php echo json_encode($arraynewdate); ?>,       
              datasets: [
                {
                  label: 'assign work order.',
                  backgroundColor: 'red',
                  pointHoverBackgroundColor: '#fff',
                  borderWidth: 2,
                  data: ['10','30','40','25','35','5','3','4','9','10','11','7']    
                },
              
                {
                  label: 'Complete work order',
                  backgroundColor: 'Blue',
                  pointHoverBackgroundColor: '#fff',
                  borderWidth: 2,
                  data: ['10','15','20','25','35','4','4','4','7','13','11','7']  
                }
              ]
            },
        }); /* Chart */

        var code = $(event.relatedTarget).data('code');
        console.log(code);

        $.ajax({
            url:"enggraf?code="+code,
            success: function(data) {
              console.log(data.message);
              console.log(data.close);

              var arr_tmp1 = data.message.split(',');
              var arr_tmp2 = data.close.split(',');
              console.log(arr_tmp1);
              console.log(arr_tmp2);

              chart.data.datasets[0].data = arr_tmp1;
              chart.data.datasets[1].data = arr_tmp2;
              
              chart.update();
          }
        }) /* ajax */
      }); /* editModal */
       
        
	   // var ctx = document.getElementById("myexpitm");
	   //  var myMachineDown = new Chart(ctx, {
	   //    type: 'horizontalBar',
		  	  
	   //    data: {	  
	   //      labels: ["0 days", "30 days", "90 days", "180 days"],       
			 //  datasets: [{
	   //        label: "Total",
	   //        backgroundColor: ["red","green","black","orange"],
	   //        hoverBorderColor: "rgba(234, 236, 244, 1)",
			  
	   //        data: [
	   //         10
			 //   ,8
			 //   ,12		   
			 //   ,16],
	   //      }],
	   //    },
	   //     options: {
	   //       enable3D: true,
	   //      onClick: noexpitm,
	   //      maintainAspectRatio: false,
	   //      tooltips: {
	   //        backgroundColor: "rgb(255,255,255)",
	   //        bodyFontColor: "#858796",
	   //        borderColor: '#dddfeb',
	   //        borderWidth: 1,
	   //        xPadding: 15,
	   //        yPadding: 15,
	   //        displayColors: false,
	   //        caretPadding: 10,
	   //      },
	   //      legend: {
	   //        display: false
	   //      },
	   //      cutoutPercentage: 60,
	   //    },
	   //  });
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
@endsection