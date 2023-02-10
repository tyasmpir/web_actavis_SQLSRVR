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

    <!--Box Nbr-->
    @if(str_contains( Session::get('menu_access'), 'HO01'))
    

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="card-title mb-2" style="text-align:center;"></h4>
                    </div>
                    <div class="col-sm-12 hidden-sm-down" >
                        <div  role="toolbar" style="text-align:center !important;">
                            <div class="btn-group mr-3" data-toggle="buttons" aria-label="First group">
                                <label class="btn btn-outline-secondary active">
                                    <input type="radio" name="options" id="option1" value="1" checked="">
                                    <span class="full-txt">
                                        Customer
                                    </span>
                                    <span class="min-txt">
                                        Cust.
                                    </span>
                                </label>
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" name="options" id="option2"  value="2"> 
                                    <span class="full-txt">
                                        Item
                                    </span>
                                    <span class="min-txt">
                                        Item
                                    </span>
                                </label>
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" name="options" id="option3"  value="3"> 
                                    <span class="full-txt">
                                        Region
                                    </span>
                                    <span class="min-txt">
                                        Region
                                    </span>
                                </label>
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" name="options" id="option4"  value="4"> 
                                    <span class="full-txt">
                                        Total
                                    </span>
                                    <span class="min-txt">
                                        Total
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->
                </div>
                <!--/.row-->
                <div class="chart-wrapper mt-4">
                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                    <canvas id="trafficChart" style="height: 536px; display: block; width: 804px;" height="670" width="1005" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection


@section('scripts')
<script src="vendors/chart.js/dist/Chart.bundle.min.js"></script>

<script type="text/javascript">
    phpVars = new Array();
    topSales = new Array();
    topSalesName = new Array();
    topItem = new Array();
    topItemName = new Array();
    topRegion = new Array();
    topRegionName = new Array();

    topYear = new Array();
    topYearPrev = new Array();
    
    <?php foreach($topsales as $topsales)
            echo 'topSalesName.push("'.$topsales->cust_desc.'");topSales.push('.$topsales->g_total.');';
    ?>

    <?php foreach($topitem as $topitem)
            echo 'topItemName.push("'.$topitem->itemdesc.'");topItem.push('.$topitem->g_total.');';
    ?>

    <?php foreach($topregion as $topregion)
            echo 'topRegionName.push("'.$topregion->region.'");topRegion.push('.$topregion->g_total.');';
    ?>

    <?php foreach($topyear as $topyear)
            if($topyear->year == date('Y')){
                echo 'topYear.push('.$topyear->g_total.');';    
            }else{
                echo 'topYearPrev.push('.$topyear->g_total.');';    
            }
    ?>




</script>

<script src="assets/js/dashboard.js"></script>
<script src="assets/js/widgets.js"></script>
@endsection