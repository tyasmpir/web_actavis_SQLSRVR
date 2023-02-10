<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>MAA - PICKLIST BROWSE</title>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

   <!--table mobile -->
   <link rel="stylesheet" type="text/css" href="{{url('assets/css/so_mobile.css')}}">
   <!-- <link rel="stylesheet" type="text/css" href="{{url('assets/css/tablestyle.css')}}"> -->

   <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> 
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{url('assets/css/checkbox.css')}}" >
  <!-- select2 bootstrap theme -->
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <!--sweetalert-->
  <link rel="stylesheet" href="plugins\sweetalert2\sweetalert2.min.css">
</head>
<body>
<div class="container-fluid my-auto" style="height: 100vh; width: 100vw; overflow: hidden;">
  <div class="row" style="padding-top: 1%; padding-bottom: 1%;">
    <h2 class="mx-auto my-auto"><b>Picklist Browse</b></h2>
  </div>
  <table class="table table-bordered shadow-lg" style="height: fit-content; width: 100%;">
    <thead style="background-color: gold;">
      <th style="text-align: center; width: 25%; border-bottom:solid 3px"><h2>SO</h2></th>
      <th style="text-align: center; width: 25%; border-bottom:solid 3px"><h2>Customer</h2></th>
      <th style="text-align: center; width: 15%; border-bottom:solid 3px"><h2>Total Line</h2></th>
      <th style="text-align: center; width: 15%; border-bottom:solid 3px"><h2>Status</h2></th>
      <th style="text-align: center; width: 20%; border-bottom:solid 3px"><h2>PIC WH</h2></th>
    </thead>
    <tbody>
      @include('picklistbrowse.table-browsetv')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
</div>



<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!--sweetalert-->
<script src="plugins\sweetalert2\sweetalert2.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{url('assets/css/jquery-ui.js')}}"></script>
<!-- OPTIONAL SCRIPTS -->
<!-- <script src="plugins/chart.js/Chart.min.js"></script> -->
<script src="dist/js/demo.js"></script>

<script>
  function nextpage(){
    document.getElementById('autonext').click();
  }

  $(document).on('click', '#autonext' , function(e){
    e.preventDefault();

    var nextbut = document.getElementById('autonext');
    if(nextbut){
      var page = $(this).attr('href').split('page=')[1];

    }else if(!nextbut){
      var page = 1;
    }

    $('#hidden_page').val(page);

    fetch_data(page);
  });

  $(function(e){
    setInterval(nextpage,5000);
  });

  function fetch_data(page) {
    $.ajax({
      url: "/pickbrowsetv/pagination?page=" + page,
      success: function(data) {
        console.log(data);
        $('tbody').html('');
        $('tbody').html(data);

      }
    })
  }
</script>
</body>
</html>