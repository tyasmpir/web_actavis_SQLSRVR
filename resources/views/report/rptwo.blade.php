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
              <li class="breadcrumb-item active">Report Status</li>
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
	<div >
		<a href="/engmaster">
		<span class="b">
			{!! $chartsr->container() !!}

        	{!! $chartsr->script() !!}
		</span>
		</a>
    	<a href="/engmaster">
		<span class="b">
			{!! $chart->container() !!}

        	{!! $chart->script() !!}
		</span>
		</a>
		<a href="/engmaster">
		<span class="b">
			{!! $chartasset->container() !!}

        	{!! $chartasset->script() !!}
		</span>
		</a>
	</div> 
	
</body>

@endsection('content')
