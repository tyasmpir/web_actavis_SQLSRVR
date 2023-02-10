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
   
    }
      .empat {
   font-size: 25px; 
   font-weight:500px;   
   color:red;
   background-color:#F0E68C;
   }  

   
      .dua {
   font-size: 15px !IMPORTANT;
   color:black !IMPORTANT;
   font-weight:500px;
   color:black !IMPORTANT;
   
   
   }
   
   #divpie{

          background-color:#2F4F4F;
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
        </style>

  <!-- <iframe width="100%" height="950" src="https://datastudio.google.com/embed/reporting/10AcjQX5oOui-cHXFL6B-k5YxcdMeFWqy/page/aY0VB" frameborder="0" style="border:0" allowfullscreen></iframe> -->
	
     <div class="row">
		<div class="col-xl-4 col-md-3 mb-4" onclick="location.href='{{ url('startwo') }}';" style="cursor:pointer;">
	      <div class="card border-bottom-primary test shadow h-100 py-2 divbutton">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="font-weight-bold text-color mb-1">Under Maintenance</div>
	              <div class="font-weight-bold dua mb-1">{{ $invbr3 }}</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	   </div>
        <div class="col-xl-4 col-md-3 mb-4" onclick="location.href='{{ url('planwo') }}';" style="cursor:pointer;">
	      <div class="card border-bottom-primary shadow h-100 py-2 divbutton1">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="font-weight-bold text-color mb-1"><b>Planned Maintenance</b></div>
                <div class="font-weight-bold dua mb-1">{{ $invbr2 }}</div>
	            </div>
	            <div class="col-auto">
	              <i class="fa fa-location-arrow fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
         
	    <div class="col-xl-4 col-md-3 mb-4" onclick="location.href='{{ url('srbrowseopen') }}';" style="cursor:pointer;">
	      <div class="card border-bottom-primary shadow h-100 py-2 divbutton2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="font-weight-bold text-color mb-1">Open Service</div>
                <div class="font-weight-bold dua mb-1">{{ $opensr }}</div>	             
	            </div>
	            <div class="col-auto">
	             <i class="fa fa-archive fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	</div>
         
     <div class="row">	  
       <div class="col-xl-6 col-lg-6 col-md-6 mb-4">    
         <p class="header-text m-0 font-weight-bold text-primary">
           <center><b>Top 10 : most problematic assets</b></center>
         </p>
	    <div id='divpie'>
            <div class="satux card-body">
                <div class="no-gutters align-items-center">
                    <div class="chart-pie pt-4 pb-2"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div></div></div>
                       <div class="chartjs-size-monitor-shrink"></div></div>                
                            <canvas background-color:"black" width="200" height="00" class="chartjs-render-monitor" id="topten" style="display: block; height: 220px; width: 640px;" ></canvas>    
                    </div>
                </div>       
            </div>            
          </div>        
       </div>
       
    </div>
       
    </body>

@endsection
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
          $b = $desc->asset_desc;
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
          backgroundColor: ["red","green","black","orange","blue","yellow","pink","brown","silver","purple"],
          hoverBorderColor: "#000000",
          data: topdata,
      }]
    },
      options: {
		 
        maintainAspectRatio: false,
        layout: {
			backgroundColor: "#000000",
          padding: {
            left: 10,
            right: 55,
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
			        fontSize : 20,
			        fontColor :"white",
            },
            maxBarThickness: 55,
          }],
          yAxes: [{
            ticks: {
              min: 0,              
              maxTicksLimit: 7,
              padding: 10,
			        fontSize : 18,
			        fontColor :"white",
            },
            gridLines: {
              color: "#FF4500",
              zeroLineColor: "#FF4500",
              drawBorder: false,
              borderDash: [8],
              zeroLineBorderDash: [8]
            }
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
      }
    });
    
    var ctx = document.getElementById("osr");
    var myMachineDown = new Chart(ctx, {
      type: 'bar',
	  	  
      data: {	  
        labels: ["0 days", "3 days", "7 days", " > 7 days"],       
		  datasets: [{
          label: "Total",
          backgroundColor: ["red","green","black","orange"],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
		  
          data: [
           <?php $obj = json_decode($invdx1,true);echo $obj ?>
          ,<?php $obj = json_decode($invdx2,true);echo $obj ?>
          ,<?php $obj = json_decode($invdx3,true);echo $obj ?>		   
          , <?php $obj = json_decode($invdx4,true);echo $obj ?>],
        }],
      },
       options: {
		 
        maintainAspectRatio: false,
        layout: {
			backgroundColor: "#000000",
          padding: {
            left: 10,
            right: 55,
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
              maxTicksLimit: 6,
			  fontSize : 20,
			  fontColor :"black",
            },
            maxBarThickness: 55,
          }],
          yAxes: [{
            ticks: {
              min: 0,              
              maxTicksLimit: 7,
              padding: 10,
			  fontSize : 18,
			  fontColor :"black",
            },
            gridLines: {
              color: "white",
              zeroLineColor: "white",
              drawBorder: false,
              borderDash: [8],
              zeroLineBorderDash: [8]
            }
          }],
        },
        legend: {
          display: false
        },
      }
    });
    
    var ctx = document.getElementById("owm");
    var myMachineDown = new Chart(ctx, {
      type: 'line',
      data: {	  
        labels: ["0 days", "3 days", "7 days", " > 7 days"],       
		  datasets: [{
          label: "Total",
          backgroundColor: ["red","green","black","orange"],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
		  
          data: [
           <?php $obj = json_decode($invwo1,true);echo $obj ?>
		   ,<?php $obj = json_decode($invwo2,true);echo $obj ?>
		   ,<?php $obj = json_decode($invwo3,true);echo $obj ?>		   
		   , <?php $obj = json_decode($invwo4,true);echo $obj ?>],
        }],
      },
      
    options: {
         enable3D: true,
        onClick: belowStockClickEvent,
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 60,
      },
    });

    
</script>
@endsection