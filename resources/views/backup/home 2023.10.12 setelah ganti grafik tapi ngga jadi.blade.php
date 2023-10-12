@extends('layout.newlayout')


@section('content')
    <!-- Flash Menu -->
    @if(session()->has('updated'))
          <div class="alert alert-success  alert-dismissible fade show"  role="alert">
              {{ session()->get('updated') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
    @endif

    @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" id="getError" role="alert">
              {{ session()->get('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
    @endif

    <ul>    
    @if(count($errors) > 0)
         <div class = "alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </ul>
         </div>
    @endif
    </ul>

    <head>
    <title>Chart</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <style type="text/css">
        .content-header{
          padding-top:5px;
          padding-bottom: 5px;
        }
            span.b {
            display: inline-block;
            padding: 5px;
            border: 1px solid blue;    
            }
            
            .satux {
   font-size: 15px !IMPORTANT;
   color:blue !IMPORTANT;
   text-align: center !IMPORTANT;
   
   }
    
      .empat {
   font-size: 25px; 
   font-weight:500px;   
   color:red;
   background-color:#F0E68C;
   }  

   
      .dua {
   font-size: 15px !IMPORTANT;
   color:white !IMPORTANT;
   font-weight:500px;
   
   
   }
   
   #divpie{
     border:1px solid black;

          background-color:transparent;
		color:red !important;
	}
     
      #divpiex{

          background-color:#F5F5F5;
		color:red !important;
          
          
	}
     
     .divbutton{
			background: #A8E9FF;
		}
          
          .divbutton1{
			background: #66CDAA;
		}
          
          .divbutton2{
			background: #F5F5F5;
		}
    @media screen and (max-width: 992px) {
      .allchart{
        height:100% !important;
        width:100% !important;
      }
      
    }
        </style>

  <!-- <iframe width="100%" height="950" src="https://datastudio.google.com/embed/reporting/10AcjQX5oOui-cHXFL6B-k5YxcdMeFWqy/page/aY0VB" frameborder="0" style="border:0" allowfullscreen></iframe> -->
	
     
         
     <div class="row">	  
      
       <div class="col-md-6">
        <div class="card card-danger">
                <div class="card-header" style="background-color: #800000;">
                  <h3 class="card-title">Top 10 : most problematic assets</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                  <canvas background-color:"black" width="100%" height="30%" class="chartjs-render-monitor" id="topten" style="display: block; height: 60%; width: 100%;" ></canvas>    
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
    <div class="col-md-6">
      <div class="card card-success">
            <div class="card-header" style="background-color: #228B22;"> 
              {{--  2022.11.18 <h3 class="card-title">Top 10 : most problematic assets</h3>  --}}
              <h3 class="card-title">Top 10 : breakdown problematic assets</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
              <canvas  width="100%" height="30%" class="chartjs-render-monitor" id="toptenheal" style="display: block; height: 60%; width: 100%;" ></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        </div>
        <div class="row">
       <div class="col-md-6">
        <div class="card card-primary">
                <div class="card-header" style="background-color: black;">
                  <h3 class="card-title">Work order Type</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                  
                    <canvas width="100%" height="60%" class="chartjs-render-monitor " id="wotype" style=" height:60%; width:50%" ></canvas>    
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <div class="col-md-6">
        <div class="card card-secondary">
                <div class="card-header" style="background-color:black">
                  <h3 class="card-title">Top 10 Engineer xxxxxxxxxxx</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    {{--  2023.10.10 Merubah grafik Top 10 Engineer menjadi jumlah status transaksi  --}}
                    <canvas width="100%" height="60%" class="chartjs-render-monitor " id="engchart" style=" height:60%; width:50%; display: none;" ></canvas>    
                    <canvas width="100%" height="60%" class="chartjs-render-monitor " id="jmlstatus" style=" height:60%; width:50%" ></canvas>    
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
      </div>
      <!-- <div class="row">
		<div class="col-xl-4 col-md-4 mb-0 h-50" onclick="location.href='{{ url('startwo') }}';" style="cursor:pointer;">
	      <div class="card border-bottom-primary test shadow-lg h-50  divbutton" style="border: 0px;">
	        <div class="card-body" style="background-color: #800000;">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2 mt-0 pt-0">
	              <div class="font-weight-bold text-light mb-1">Under Maintenance : </div>
	              
	            </div>
	            <div class="col-auto">
                <div class="font-weight-bold text-light dua mb-1">{{ $invbr3 }}</div>
	            </div>
	          </div>
	        </div>
	      </div>
	   </div>
        <div class="col-xl-4 col-md-4 mb-0 h-50" onclick="location.href='{{ url('planwo') }}';" style="cursor:pointer;">
	      <div class="card border-bottom-primary shadow-lg h-50  divbutton1">
	        <div class="card-body shadow-lg" style="background-color: #228B22;">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="font-weight-bold text-light mb-1"><b>Planned Maintenance : </b></div>
                
	            </div>
	            <div class="col-auto">
              <div class="font-weight-bold dua mb-1">{{ $invbr2 }}</div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
         
	    <div class="col-xl-4 col-md-4 mb-0 h-50" onclick="location.href='{{ url('srbrowseopen') }}';" style="cursor:pointer;">
	      <div class="card border-bottom-primary shadow-lg h-50 divbutton2">
	        <div class="card-body" style="background-color: #800000;">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="font-weight-bold text-light mb-1">Open Service Request</div>
                	             
	            </div>
	            <div class="col-auto">
              <div class="font-weight-bold dua mb-1">{{ $opensr }}</div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	</div>   -->


<div class="row">   
  <div class="col-md-6">
    <div class="card card-danger">
      <div class="card-header" style="background-color: #800000;">
        <div class="row">
          <!-- 10.08.21 grafik per bulan -->
          <h3 class="card-title col-md-4">WO Per Month</h3>
          <div class="col-md-7">
              <h5 class="m-0 text-light text-center">
                  <a href="javascript:void(0)" id="mundur"><i class="fas fa-angle-left"></i></a>
                  &ensp;&ensp;<span id="bulandisplay">{{$bulan}}</span>&ensp;&ensp;
                  <input type='hidden' name='bulan' id='bulan' value='{{$bulan}}'>
                  <a href="javascript:void(0)" id="maju" ><i class="fas fa-angle-right"></i></a>
              </h5>
          </div>
          <div class="card-tools col-md-1">
             <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas background-color:"black" width="100%" height="30%" class="chartjs-render-monitor" id="grafwo" style="display: block; height: 60%; width: 100%;" ></canvas>    
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card card-success">
      <div class="card-header" style="background-color: #228B22;"> 
        <!-- 10.08.21 grafik per tahun -->
        <h3 class="card-title">WO Per Year</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas  width="100%" height="30%" class="chartjs-render-monitor" id="grafytdwo" style="display: block; height: 60%; width: 100%;" ></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">   
  <div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header" style="background-color: black;">
        <h3 class="card-title">Work Order Status</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas width="100%" height="60%" class="chartjs-render-monitor " id="wostatus" style=" height:60%; width:50%" ></canvas>    
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card card-success">
      <div class="card-header" style="background-color: #228B22;"> 
        <!-- 16.08.21 grafik total jam WO per tahun -->
        <h3 class="card-title">WO Hour Per Year</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas  width="100%" height="30%" class="chartjs-render-monitor" id="grafhourwo" style="display: block; height: 60%; width: 100%;" ></canvas>
        </div>
      </div>
    </div>
  </div>
</div>


</body>

@endsection
@section('scripts')
<script src="{{url('vendors\chart-js-datalabel\chartjs-plugin-datalabels-new.js')}}"></script>
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
    
    function belowStockClickEvent(event, array){
        if(array[0]){
            let element = this.getElementAtEvent(event);
            if (element.length > 0) {
                //var series= element[0]._model.datasetLabel;
                //var label = element[0]._model.label;
                //var value = this.data.datasets[element[0]._datasetIndex].data[element[0]._index];
                window.location = "/bstock";
                //console.log()
            }
        }
    }
</script>
<script>

    var toplabel = new Array();
    var topdata = new Array();

    <?php foreach($topprob as $topprob) {
        $a = $dataasset->where('asset_code','=',$topprob->wo_asset)->count();
        if ($a == 0) {
          $b = "";
        } else {
          $desc = $dataasset->where('asset_code','=',$topprob->wo_asset)->first();
          $b = $desc->asset_desc . ' (' . $desc->asset_code . ')';
        }
        
        echo 'toplabel.push("'.$b.'");topdata.push("'.$topprob->jmlasset.'");';
      }
    ?>
    // alert(toplabel);
    var ctx = document.getElementById("topten");
    var myMachineDown = new Chart(ctx, {
      type: 'bar',
      data: {	  
        labels: toplabel,       
		  datasets: [{
          label: "Total",
          backgroundColor: ["#FFD729","#146EB4","#E94C39","#9F0047","#439D45","#2DBFF8","#08AAE3","#E4C083","#CEA968","#B25F4A"],
          hoverBorderColor: "#000000",
          data: topdata,
          
      }]
    },
      options: {
        onClick: function(evt,element){
          var activePoints = myMachineDown.getElementAtEvent(evt);
          var clickedElementindex = activePoints[0]._index;
          var currentlabel = myMachineDown.data.labels[clickedElementindex];
          var code = currentlabel.substring(currentlabel.lastIndexOf('(') +1, currentlabel.lastIndexOf(')'));
          var code = code + '(Problematic)';
          var url = "{{url('problemwo','id')}}";
          // var newo = JSON.stringify(wonbr);
          url = url.replace('id', code);

          // window.open(url,'_blank');
          // alert(url);
          window.location.href = url;
          
          // alert(activePoints[0]._model.datasetLabel);
        }, 
        // indexAxis: 'y',
        maintainAspectRatio: false,
        layout: {
			backgroundColor: "#000000",
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              callback: function(t) {
                        var maxLabelLength = 5;
                        if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '..';
                        else return t;
                    },
              maxTicksLimit: 6,
              fontSize : 11,
              fontColor :"black",
              fontstyle:'bold',
            },
            maxBarThickness: 55,
          }],
          yAxes: [{
            ticks: {
              min: 0,              
              maxTicksLimit: 7,
              padding: 10,
			  fontSize : 14,
			  fontColor :"black",
            },
            
          }],
        },
        legend: {
          display: false
        },
        tooltips:{
          callbacks: {
            label: function(tooltipItem, data) {
                return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            title: function(t, d) {
                return d.labels[t[0].index];
            }
          }
        },
        plugins:{
          labels: {
            render:'value',
          }     
        },
        
      }
    });
    // ctx.onclick = function(event){ 
    //       const datasetIndex = myMachineDown.getElementAtEvent(event)[0]._datasetIndex;
    //       const model = myMachineDown.getElementsAtEvent(event)[datasetIndex]._model;
    //       // onBarClicked(model.datasetLabel, model.label);
    //       // testevent()
    //       alert(datasetIndex);
    //     };


    var toplabel2 = new Array();
    var topdata2 = new Array();

    <?php foreach($topheal as $topheal) {
        $a = $dataasset->where('asset_code','=',$topheal->wo_asset)->count();
        if ($a == 0) {
          $b = "";
        } else {
          $desc = $dataasset->where('asset_code','=',$topheal->wo_asset)->first();
          $b = $desc->asset_desc . ' (' . $desc->asset_code . ')';
        }
        
        echo 'toplabel2.push("'.$b.'");topdata2.push("'.$topheal->jmlasset.'");';
      }
    ?>

        // alert(toplabel2);
        var ctx2 = document.getElementById("toptenheal");
        
        var myMachineDown2 = new Chart(ctx2, {
      type: 'bar',
      data: {	  
        labels: toplabel2,       
		  datasets: [{
          label: "Total",
          backgroundColor: ["#FFD729","#146EB4","#E94C39","#9F0047","#439D45","#2DBFF8","#08AAE3","#E4C083","#CEA968","#B25F4A"],
          hoverBorderColor: "#000000",
          data: topdata2,
      }]
    },
      options: {
        onClick: function(evt,element){
          var activePoints = myMachineDown.getElementAtEvent(evt);
          var clickedElementindex = activePoints[0]._index;
          var currentlabel = myMachineDown.data.labels[clickedElementindex];
          var code = currentlabel.substring(currentlabel.lastIndexOf('(') +1, currentlabel.lastIndexOf(')'));
          var code = code + '(Healthy)';
          var url = "{{url('problemwo','id')}}";
          // var newo = JSON.stringify(wonbr);
          url = url.replace('id', code);

          // window.open(url,'_blank');
          // alert(url);
          window.location.href = url;
          
          // alert(activePoints[0]._model.datasetLabel);
        },
        maintainAspectRatio: false,
        
        layout: {
			    backgroundColor: "#000000",
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              callback: function(t) {
                        var maxLabelLength = 5;
                        if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '..';
                        else return t;
                    },
              maxTicksLimit: 6,
              fontSize : 11,
              fontColor :"black",
            },
            maxBarThickness: 55,
          }],
          yAxes: [{
            ticks: {
              min: 0,              
              maxTicksLimit: 7,
              padding: 10,
			      fontSize : 14,
			      fontColor :"black",
            },
            
          }],
        },
        legend: {
          display: false
        },
        tooltips:{
          callbacks: {
            label: function(tooltipItem, data) {
                return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            title: function(t, d) {
                return d.labels[t[0].index];
            }
          }
        },
        plugins:{
          labels: {
            render:'value',
          }     
        },
        
      }    
    });

    var toplabel3 = new Array();
    var topdata3 = new Array();

    <?php
    echo 'toplabel3.push("WO from SR");topdata3.push("'.$countwosr->countwosr.'");';
    echo 'toplabel3.push("WO Automatic");topdata3.push("'.$countwoauto->countwoauto.'");';
    echo 'toplabel3.push("WO Direct");topdata3.push("'.$countwodirect->countdirect.'");';
    echo 'toplabel3.push("Other WO");topdata3.push("'.$countwoother->countother.'");';
    //  
    ?>
    // alert(toplabel3);

    var ctx3 = document.getElementById("wotype");
    var myMachineDown3 = new Chart(ctx3, {
      type: 'pie',
      data: {
        labels: toplabel3,
        datasets: [{
            fill: true,
            backgroundColor: [
              "#439D45","#146EB4","#E94C39","#9F0047"],
            data: topdata3,
            

            borderWidth: [2,2]
        }],
      },
      options : {
        onClick: function(evt,element){
            // alert('aaa');
          var activePoints = myMachineDown3.getElementAtEvent(evt);
          var clickedElementindex = activePoints[0]._index;
          var currentlabel = myMachineDown3.data.labels[clickedElementindex];
          // var code = currentlabel.substring(currentlabel.lastIndexOf('(') +1, currentlabel.lastIndexOf(')'));
          // var code = code + '(Problematic)';
          var url = "{{url('wotype','id')}}";
          // var newo = JSON.stringify(wonbr);
          url = url.replace('id', currentlabel);
            // alert(currentlabel);
          // window.open(url,'_blank');
          // alert(url);
          window.location.href = url;
          
          // alert(activePoints[0]._model.datasetLabel);
        },
        maintainAspectRatio: false,
        legend:{
            position:'right'
          },
        plugins:{
          
          labels: {
            render:'value',
            fontColor:'white'
          },
          
               
        },
        rotation: -0.7 * Math.PI,
         
      },
      
    });

    var topkey = new Array();
    var topval = new Array();

    <?php 
      $counter = 0;
      // dd($arrayname);    
      foreach($arrayname as $key =>$value){
        if($counter < 10){

          echo 'topkey.push("'.$key.'");topval.push("'.$value.'");';
          $counter +=1;
        }
          
        }
    ?>
    // alert(toplabel);
    var ctx4 = document.getElementById("engchart");
    var myMachineDown4 = new Chart(ctx4, {
      type: 'bar',
      data: {	  
        labels: topkey,       
		  datasets: [{
          label: "Total",
          backgroundColor: ["#FFD729","#146EB4","#E94C39","#9F0047","#439D45","#2DBFF8","#08AAE3","#E4C083","#CEA968","#B25F4A"],
          hoverBorderColor: "#000000",
          data: topval,
      }]
    },
      options: {
        onClick: function(evt,element){
            // alert('aaa');
          var activePoints = myMachineDown4.getElementAtEvent(evt);
          var clickedElementindex = activePoints[0]._index;
          var currentlabel = myMachineDown4.data.labels[clickedElementindex];
          var code = currentlabel.substring(currentlabel.lastIndexOf('(') +1, currentlabel.lastIndexOf(')'));
          // var code = code + '(Problematic)';
          var url = "{{url('woeng','id')}}";
          // var newo = JSON.stringify(wonbr);
          url = url.replace('id', code);
            // alert(currentlabel);
          // window.open(url,'_blank');
          // alert(url);
          window.location.href = url;
          
          // alert(activePoints[0]._model.datasetLabel);
        },
        maintainAspectRatio: false,
        layout: {
			backgroundColor: "#000000",
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              callback: function(t) {
                        var maxLabelLength = 5;
                        if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '..';
                        else return t;
                    },
              maxTicksLimit: 6,
              fontSize : 11,
              fontColor :"black",
              fontstyle:'bold',
            },
            maxBarThickness: 55,
          }],
          yAxes: [{
            ticks: {
              min: 0,              
              maxTicksLimit: 7,
              padding: 10,
			  fontSize : 14,
			  fontColor :"black",
            },
            
          }],
        },
        legend: {
          display: false
        },
        tooltips:{
          callbacks: {
            label: function(tooltipItem, data) {
                return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            title: function(t, d) {
                return d.labels[t[0].index];
            }
          }
        },
        plugins:{
          labels: {
            render:'value',
          }     
        },
        
      }
    });


    // 10.08.21 grafwo
    var toplabel5 = new Array();
    var topdatapm5 = new Array();
    var topdata5 = new Array();

    <?php
      echo 'toplabel5.push("In Month");topdata5.push("'.$countwomonth->countwomonth.'");topdatapm5.push("'.$countwopmmonth->countwopmmonth.'");';
      echo 'toplabel5.push("Open");topdata5.push("'.$countwoopen->countwoopen.'");topdatapm5.push("'.$countwopmopen->countwopmopen.'");';
      echo 'toplabel5.push("Started");topdata5.push("'.$countwoopen->countwoopen.'");topdatapm5.push("'.$countwopmopen->countwopmopen.'");';
      echo 'toplabel5.push("Finish");topdata5.push("'.$countwofinish->countwofinish.'");topdatapm5.push("'.$countwopmfinish->countwopmfinish.'");';
      echo 'toplabel5.push("Completed");topdata5.push("'.$countwocomplete->countwocomplete.'");topdatapm5.push("'.$countwopmcomplete->countwopmcomplete.'");';
      echo 'toplabel5.push("Closed");topdata5.push("'.$countwopmmonth->countwopmmonth.'");topdatapm5.push("'.$countwopmclosed->countwopmclosed.'");';
    //  
    ?>

    var ctx5 = document.getElementById("grafwo");
    var myMachineDown5 = new Chart(ctx5, {
      type: 'bar',
      data: {          
        datasets: [
          {
            label: "WO",
            backgroundColor: ["#FFD729","#FFD729","#FFD729","#FFD729","#FFD729","#FFD729"],
            hoverBorderColor: "#000000",
            data: topdata5,  
          },
          {
            label: "PM",
            backgroundColor: ["#439D45","#439D45","#439D45","#439D45","#439D45","#439D45"],
            hoverBorderColor: "#000000",
            data: topdatapm5,  
          }
        ],
        labels: toplabel5,
      },
      options: {
        onClick: function(evt,element){
          var wotypeclick = '';
          var activePoints = myMachineDown5.getElementAtEvent(evt);
          var clickedElementindex = activePoints[0]._index;
          var datasetIndex = activePoints[0]._datasetIndex;
          if(datasetIndex == 0 || datasetIndex == 2 || datasetIndex == 4 || datasetIndex == 5 || datasetIndex == 7 || datasetIndex == 9){
            wotypeclick = 'WO';
          }
          else if(datasetIndex == 1 || datasetIndex == 3 || datasetIndex == 5 || datasetIndex == 6 || datasetIndex == 8 || datasetIndex == 10){
            wotypeclick = 'PM';
          }
          var currentlabel = wotypeclick + "&" + myMachineDown5.data.labels[clickedElementindex] + "&" + document.getElementById("bulan").value;
          // alert(currentlabel);
          var url = "{{url('datagrafwo','id')}}";
          url = url.replace('id', currentlabel);
          window.location.href = url;
        }, 
        maintainAspectRatio: false,
        layout: {
      backgroundColor: "#000000",
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              callback: function(t) {
                        var maxLabelLength = 10;
                        if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '..';
                        else return t;
                    },
              maxTicksLimit: 6,
              fontSize : 11,
              fontColor :"black",
              fontstyle:'bold',
            },
            maxBarThickness: 55,
          }],
          yAxes: [{
            ticks: {
              min: 0,              
              maxTicksLimit: 7,
              padding: 10,
        fontSize : 14,
        fontColor :"black",
            },
            
          }],
        },
        legend: {
          display: true
        },
        tooltips:{
          callbacks: {
            label: function(tooltipItem, data) {
                return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            title: function(t, d) {
                return d.labels[t[0].index];
            }
          }
        },
        plugins:{
          labels: {
            render:'value',
          }     
        },
        
      }
    }); /* grafwo */

    /* grafytdwo*/
    var topdata6 = new Array();
    var topdatapm6 = new Array();

    <?php 
      foreach($ytdwo as $key =>$value){
          echo 'topdata6.push("'.$value.'");';
      }

      foreach($ytdwopm as $key =>$value){
          echo 'topdatapm6.push("'.$value.'");';
      }
    ?>

    var ctx6 = document.getElementById("grafytdwo");
    var myMachineDown6 = new Chart(ctx6, {
      type: 'bar',
      data: {   
        labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],       
      datasets: [
        {
          label: "WO",
          backgroundColor: ["#FFD729","#FFD729","#FFD729","#FFD729","#FFD729","#FFD729","#FFD729","#FFD729","#FFD729","#FFD729","#FFD729","#FFD729"],
          hoverBorderColor: "#000000",
          data: topdata6,    
        },
        {
          label: "PM",
          backgroundColor: ["#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45"],
          hoverBorderColor: "#000000",
          data: topdatapm6,    
        },
      ]
    },
      options: {
        onClick: function(evt,element){
          var activePoints = myMachineDown6.getElementAtEvent(evt);
          var clickedElementindex = activePoints[0]._index;
          var datasetIndex = activePoints[0]._datasetIndex;
          var wotypeclick = '';

          switch (datasetIndex) {
            case 0: wotypeclick = "WO"; break;
            case 1: wotypeclick = "PM"; break;
            case 2: wotypeclick = "WO"; break;
            case 3: wotypeclick = "PM"; break;
            case 4: wotypeclick = "WO"; break;
            case 5: wotypeclick = "PM"; break;
            case 6: wotypeclick = "WO"; break;
            case 7: wotypeclick = "PM"; break;
            case 8: wotypeclick = "WO"; break;
            case 9: wotypeclick = "PM"; break;
            case 10: wotypeclick = "WO"; break;
            case 11: wotypeclick = "PM"; break;
            case 12: wotypeclick = "WO"; break;
            case 13: wotypeclick = "PM"; break;
            case 14: wotypeclick = "WO"; break;
            case 15: wotypeclick = "PM"; break;
            case 16: wotypeclick = "WO"; break;
            case 17: wotypeclick = "PM"; break;
            case 18: wotypeclick = "WO"; break;
            case 19: wotypeclick = "PM"; break;
            case 20: wotypeclick = "WO"; break;
            case 21: wotypeclick = "PM"; break;
            case 22: wotypeclick = "WO"; break;
            case 23: wotypeclick = "PM"; break;
          }

          var currentlabel = wotypeclick + "&" +myMachineDown6.data.labels[clickedElementindex];
          var url = "{{url('datagrafytdwo','id')}}";
          url = url.replace('id', currentlabel);
          window.location.href = url;
        }, 
        maintainAspectRatio: false,
        layout: {
      backgroundColor: "#000000",
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              callback: function(t) {
                        var maxLabelLength = 3;
                        if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '..';
                        else return t;
                    },
              maxTicksLimit: 12,
              fontSize : 11,
              fontColor :"black",
              fontstyle:'bold',
            },
            maxBarThickness: 55,
          }],
          yAxes: [{
            ticks: {
              min: 0,              
              maxTicksLimit: 7,
              padding: 10,
        fontSize : 14,
        fontColor :"black",
            },
            
          }],
        },
        legend: {
          display: true
        },
        tooltips:{
          callbacks: {
            label: function(tooltipItem, data) {
                return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            title: function(t, d) {
                return d.labels[t[0].index];
            }
          }
        },
        plugins:{
          labels: {
            render:'value',
          }     
        },
        
      }
    }); /* grafytdwo */

    $(document).on('click','#mundur',function(){
      var bulan = document.getElementById('bulan').value;

      $.ajax({
        url: "/homegraf?bulan="+bulan+"&stat=mundur",
        success: function(data) {
          console.log(data);
          myMachineDown5.destroy();
          newgrafwo(data);
          
        }
      })
    })
    $(document).on('click','#maju',function(){
      var bulan = document.getElementById('bulan').value;
        $.ajax({
        url: "/homegraf?bulan="+bulan+"&stat=maju",
        success: function(data) {
          // console.log(data);
          myMachineDown5.destroy();
          newgrafwo(data);
          
        }
      })
    })

  function newgrafwo(data){
    
    document.getElementById('bulan').value =data[8];
    document.getElementById('bulandisplay').innerHTML=data[8];
    var toplabel5 = new Array();
    var topdata5 = new Array();
    var topdatapm5 = new Array();

    toplabel5.push("WO in Month");topdata5.push(data[0].countwomonth);topdatapm5.push(data[4].countwopmmonth);
    toplabel5.push("WO Open");topdata5.push(data[1].countwoopen);topdatapm5.push(data[5].countwopmopen);
    toplabel5.push("WO in Progress");topdata5.push(data[2].countwostart);topdatapm5.push(data[6].countwopmstart);
    toplabel5.push("WO Finish");topdata5.push(data[3].countwofinish);topdatapm5.push(data[7].countwopmfinish);
    // console.log(topdata5);
    console.log(topdatapm5);
    // setTimeout(10000);

    ctx5 = document.getElementById("grafwo");
    myMachineDown5 = new Chart(ctx5, {
      type: 'bar',
      data: {   
        labels: toplabel5,       
      datasets: [
        {
          label: "WO",
          backgroundColor: ["#FFD729","#FFD729","#FFD729","#FFD729"],
          hoverBorderColor: "#000000",
          data: topdata5,
        },
        {
          label: "PM",
          backgroundColor: ["#439D45","#439D45","#439D45","#439D45"],
          hoverBorderColor: "#000000",
          data: topdatapm5,
        },
      ]
    },
      options: {
        onClick: function(evt,element){
          var wotypeclick = '';
          var activePoints = myMachineDown5.getElementAtEvent(evt);
          var clickedElementindex = activePoints[0]._index;
          var datasetIndex = activePoints[0]._datasetIndex;
          if(datasetIndex == 0 || datasetIndex == 2 || datasetIndex == 4 || datasetIndex == 5){
            wotypeclick = 'WO';
          }
          else if(datasetIndex == 1 || datasetIndex == 3 || datasetIndex == 5 || datasetIndex == 6){
            wotypeclick = 'PM';
          }
          var currentlabel = wotypeclick + "&" + myMachineDown5.data.labels[clickedElementindex] + "&" + document.getElementById("bulan").value;
          // alert(currentlabel);
          var url = "{{url('datagrafwo','id')}}";
          url = url.replace('id', currentlabel);
          window.location.href = url;
        }, 
        maintainAspectRatio: false,
        layout: {
      backgroundColor: "#000000",
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              callback: function(t) {
                        var maxLabelLength = 10;
                        if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '..';
                        else return t;
                    },
              maxTicksLimit: 6,
              fontSize : 11,
              fontColor :"black",
              fontstyle:'bold',
            },
            maxBarThickness: 55,
          }],
          yAxes: [{
            ticks: {
              min: 0,              
              maxTicksLimit: 7,
              padding: 10,
        fontSize : 14,
        fontColor :"black",
            },
            
          }],
        },
        legend: {
          display: true
        },
        tooltips:{
          callbacks: {
            label: function(tooltipItem, data) {
                return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            title: function(t, d) {
                return d.labels[t[0].index];
            }
          }
        },
        plugins:{
          labels: {
            render:'value',
          }     
        },
        
      }
    }); /* grafwo */
  }

  /* grafhourwo*/
  var topdata7 = new Array();
  var topdata7pm = new Array();

  <?php 
    $counter = 0;
    foreach($hourwo as $key =>$value){
        echo 'topdata7.push("'.$value.'");';
    }
    foreach($hourpm as $key =>$value){
        echo 'topdata7pm.push("'.$value.'");';
    }
  ?>

  var ctx7 = document.getElementById("grafhourwo");
  var myMachineDown7 = new Chart(ctx7, {
    type: 'bar',
    data: {   
      labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],       
    datasets: [
      {
        label: "WO",
        backgroundColor: ["#FFD729","#146EB4","#E94C39","#9F0047","#439D45","#2DBFF8","#08AAE3","#E4C083","#CEA968","#B25F4A","#8F00FF","#7788aa"],
        hoverBorderColor: "#000000",
        data: topdata7,
        
      },
      {
        label: "PM",
        backgroundColor: ["#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45","#439D45"],
        hoverBorderColor: "#000000",
        data: topdata7pm,
        
      },
    ]
  },
    options: {
      onClick: function(evt,element){
        var activePoints = myMachineDown7.getElementAtEvent(evt);
        var clickedElementindex = activePoints[0]._index;
        var datasetIndex = activePoints[0]._datasetIndex;
        var wotypeclick = '';

        switch (datasetIndex) {
          case 0: wotypeclick = "WO"; break;
          case 1: wotypeclick = "PM"; break;
          case 2: wotypeclick = "WO"; break;
          case 3: wotypeclick = "PM"; break;
          case 4: wotypeclick = "WO"; break;
          case 5: wotypeclick = "PM"; break;
          case 6: wotypeclick = "WO"; break;
          case 7: wotypeclick = "PM"; break;
          case 8: wotypeclick = "WO"; break;
          case 9: wotypeclick = "PM"; break;
          case 10: wotypeclick = "WO"; break;
          case 11: wotypeclick = "PM"; break;
          case 12: wotypeclick = "WO"; break;
          case 13: wotypeclick = "PM"; break;
          case 14: wotypeclick = "WO"; break;
          case 15: wotypeclick = "PM"; break;
          case 16: wotypeclick = "WO"; break;
          case 17: wotypeclick = "PM"; break;
          case 18: wotypeclick = "WO"; break;
          case 19: wotypeclick = "PM"; break;
          case 20: wotypeclick = "WO"; break;
          case 21: wotypeclick = "PM"; break;
          case 22: wotypeclick = "WO"; break;
          case 23: wotypeclick = "PM"; break;
        }

        var currentlabel = wotypeclick + "&" + myMachineDown7.data.labels[clickedElementindex];
        var url = "{{url('datagrafhourwo','id')}}";
        url = url.replace('id', currentlabel);
        window.location.href = url;
      }, 
      maintainAspectRatio: false,
      layout: {
    backgroundColor: "#000000",
        padding: {
          left: 0,
          right: 0,
          top: 0,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'month'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            callback: function(t) {
                      var maxLabelLength = 3;
                      if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '..';
                      else return t;
                  },
            maxTicksLimit: 12,
            fontSize : 11,
            fontColor :"black",
            fontstyle:'bold',
          },
          maxBarThickness: 55,
        }],
        yAxes: [{
          ticks: {
            min: 0,              
            maxTicksLimit: 7,
            padding: 10,
      fontSize : 14,
      fontColor :"black",
          },
          
        }],
      },
      legend: {
        display: true
      },
      tooltips:{
        callbacks: {
          label: function(tooltipItem, data) {
              return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
          },
          title: function(t, d) {
              return d.labels[t[0].index];
          }
        }
      },
      plugins:{
        labels: {
          render:'value',
        }     
      },
      
    }
  }); /* end grafhourwo */

  /* wo status */
  var toplabel8 = new Array();
  var topdata8 = new Array();

  <?php
  echo 'toplabel8.push("Under Maintenance");topdata8.push("'.$invbr3.'");';
  echo 'toplabel8.push("Planned Maintenance");topdata8.push("'.$invbr2.'");';
  echo 'toplabel8.push("Request Maintenance");topdata8.push("'.$invbr1.'");';
  ?>
  // {{ url('startwo') }}{{ url('planwo') }}{{ url('srbrowseopen') }}
  var ctx8 = document.getElementById("wostatus");
  var myMachineDown8 = new Chart(ctx8, {
    type: 'pie',
    data: {
      labels: toplabel8,
      datasets: [{
        fill: true,
        backgroundColor: ["#439D45","#146EB4","#E94C39"],
        data: topdata8,
        borderWidth: [2,2]
      }],
    },
    options : {
      onClick: function(evt,element){
        var activePoints = myMachineDown8.getElementAtEvent(evt);
        var clickedElementindex = activePoints[0]._index;
        var currentlabel = myMachineDown8.data.labels[clickedElementindex];
        var url = "{{url('wostatus','id')}}";
        url = url.replace('id', currentlabel);
        window.location.href = url;
      },
      maintainAspectRatio: false,
      legend:{
        position:'right'
      },
      plugins:{
        labels: {
          render:'value',
          fontColor:'white'
        },         
      },
      rotation: -0.7 * Math.PI,   
    },  
  });
  /* end wo status */

  /* Grafik jumlah setiap status WO */

  var toplabel9 = new Array();
  var topdata9 = new Array();

  <?php
    foreach($countstatus as $dc) {
      echo 'toplabel9.push("'.$dc->wo_status.'");topdata9.push("'.$dc->jmlstatus.'");';
    }
  ?>
  
  var ctx9 = document.getElementById("jmlstatus");
    var myMachineDown9 = new Chart(ctx9, {
      type: 'pie',
      data: {
        labels: toplabel9,
        datasets: [{
            fill: true,
            backgroundColor: [
              "#439D45","#146EB4","#E94C39","#9F0047","#439D45","#146EB4","#E94C39","#9F0047"],
            data: topdata9,
            

            borderWidth: [2,2]
        }],
      },
      options : {
        onClick: function(evt,element){
            // alert('aaa');
          var activePoints = myMachineDown9.getElementAtEvent(evt);
          var clickedElementindex = activePoints[0]._index;
          var currentlabel = myMachineDown9.data.labels[clickedElementindex];
          // var code = currentlabel.substring(currentlabel.lastIndexOf('(') +1, currentlabel.lastIndexOf(')'));
          // var code = code + '(Problematic)';
          var url = "{{url('wotype','id')}}";
          // var newo = JSON.stringify(wonbr);
          url = url.replace('id', currentlabel);
            // alert(currentlabel);
          // window.open(url,'_blank');
          // alert(url);
          window.location.href = url;
          
          // alert(activePoints[0]._model.datasetLabel);
        },
        maintainAspectRatio: false,
        legend:{
            position:'right'
          },
        plugins:{
          
          labels: {
            render:'value',
            fontColor:'white'
          },
          
               
        },
        rotation: -0.7 * Math.PI,
         
      },
      
    });
    /* End Grafik jumlah setiap status WO */
      
</script>
@endsection