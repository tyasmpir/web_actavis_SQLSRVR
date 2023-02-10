<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  

  <title>MMS - Home</title>
  <link rel="icon" type="image/gif/jpg" href="images/actavis-logo.png">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

   <!--table mobile -->
   <link rel="stylesheet" type="text/css" href="{{url('assets/css/so_mobile.css')}}">
   <!-- <link rel="stylesheet" type="text/css" href="{{url('assets/css/tablestyle.css')}}"> -->

   <link rel="stylesheet" href="{{url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}"> 
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="{{url('plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{url('assets/css/checkbox.css')}}" >
  <!-- select2 bootstrap theme -->
  <link rel="stylesheet" href="{{url('plugins/select2-bootstrap4-theme/select2-bootstrap4.css')}}">
  <link rel="stylesheet" href="{{url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <!--sweetalert-->
  <link rel="stylesheet" href="{{url('plugins\sweetalert2\sweetalert2.min.css')}}">

<!--animatecss-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/home')}}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <div class="navbar-custom-menu ml-auto">
      <ul class="nav navbar-nav">
        <li class=" nav-item dropdown notifications-menu ">
            <a class="nav-link" data-toggle="dropdown" id="alertsDropdown" href="" aria-expanded="false">
              <i class="fas fa-bell"></i>
              <span class="badge badge-warning">{{ auth()->user()->unreadNotifications->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right" aria-labelledby="alertsDropdown" style="left: inherit; right: 0px; overflow-y:auto; max-height: 250px; overflow-x:hidden;">
              <a class="dropdown-item text-center small font-weight-bold mark-as-read-all" href="" data-id="{{ Session::get('userid') }}">Mark All as Read</a>
                <div class="dropdown-divider"></div>
              @forelse(Auth::User()->unreadNotifications as $notif)
                <a id="bell"  href="{{$notif->data['url']}}" data-id="{{$notif->id}}" data-link="{{$notif->data['url']}}" class="dropdown-item mark-as-read" style="word-wrap:break-word">
                  <div class="media">
                    <i class="fas fa-envelope mr-2"></i>
                    <div class="media-body">
                      <h3 class="dropdown-item-title">{{$notif->data['data']}}</h3>
                      <p class="font-weight-bold">{{$notif->data['nbr']}}</p>
                      <p class="">{{$notif->data['note']}}</p>
                    </div>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
              @empty
                <a class="dropdown-item d-flex align-items-center" href="" >
                  <div class="mr-3">
                    <i class="fas fa-times"></i>
                  </div>
                  <div class="">
                    <span class="font-weight-bold">No New Notifications</span>
                  </div>
                </a>
              @endforelse
            </div>
        </li>


        <li class="nav-item dropdown user user-menu">
              <a href="" class="nav-link" data-toggle="dropdown" aria-expanded="false">
                <img src="{{asset('images/icon.jpg')}}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{Session::get('name')}}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{asset('images/icon.jpg')}}" class="img-circle" alt="User Image">

                  <p>
                    {{Session::get('name')}}
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <a class="nav-link text-center" href="{{url('/changepassword')}}" style="cursor: pointer;">
                    <i class="fas fa-user-lock"></i>
                    Change Password
                  </a>
                  <a class="nav-link text-center" data-toggle="modal" data-target="#logoutModal" style="cursor: pointer;">
                    <i class="fa fa-power-off"></i>
                    Logout
                  </a>
                </li>
              </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/home')}}" class="brand-link">
      <span class="brand-text font-weight-light">PT Actavis Indonesia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-header">SETTING</li> -->

          @if(str_contains( Session::get('menu_access'), 'SR'))
            <li class="nav-item has-treeview">
              <a href="javascript:void(0)" class="nav-link">
                <i class="nav-icon fas fa-concierge-bell"></i>
                <p>
                  Service Request
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              @if(str_contains( Session::get('menu_access'), 'SR01'))
                <li class="nav-item">
                  <a href="/servicerequest" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Service Request Create
                    </p>
                  </a>
                </li>
              @endif
              @if(str_contains( Session::get('menu_access'), 'SR03'))
                <li class="nav-item">
                    <a href="/srbrowse" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>Service Request Browse</p>
                    </a>
                </li>
              @endif            
              @if(str_contains( Session::get('menu_access'), 'SR02'))
                <li class="nav-item">
                    <a href="/srapproval" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>Service Request Approval</p>
                    </a>
                </li>
              @endif
              @if(str_contains( Session::get('menu_access'), 'SR04'))
                <li class="nav-item">
                    <a href="/useracceptance" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>User Acceptance</p>
                    </a>
                </li>
              @endif
              </ul>
            </li>
          @endif
          
          @if(str_contains( Session::get('menu_access'), 'WO'))
            <li class="nav-item has-treeview">
              <a href="javascript:void(0)" class="nav-link">
                <i class="nav-icon fas fa-people-carry"></i>
                <p>
                  Work Order
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              
              <!--   @if(str_contains( Session::get('menu_access'), 'WO04'))
                <li class="nav-item ">
                <a href="/wocreatemenu" class="nav-link">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>
                    Work Order Engineer
                  </p>
                </a>
                </li>
                @endif -->
                @if(str_contains( Session::get('menu_access'), 'WO06'))
                  <li class="nav-item ">
                    <a href="/wocreatedirectmenu" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>
                        WO Create Without Approval
                      </p>
                    </a>
                  </li>
                @endif
                 @if(str_contains( Session::get('menu_access'), 'WO01'))
                  <li class="nav-item ">
                    <a href="/womaint" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>
                        Work Order Maintenance
                      </p>
                    </a>
                  </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO05'))
                  <li class="nav-item ">
                    <a href="/wobrowse" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>
                        Work Order Browse
                      </p>
                    </a>
                  </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO02'))
                  <li class="nav-item ">
                    <a href="/wojoblist" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>
                        Work Order Start
                      </p>
                    </a>
                  </li>
                @endif

                @if(str_contains( Session::get('menu_access'), 'WO03'))
                  <li class="nav-item">
                    <a href="/woreport" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>
                        Work Order Finish
                      </p>
                    </a>
                  </li>
                @endif
                
               
              </ul>
            </li>
          @endif

          @if(str_contains(Session::get('menu_access'), 'US'))
            <li class="nav-item has-treeview">
              <a href="javascript:void(0)" class="nav-link">
                <i class="nav-icon fas fa-dolly"></i>
                <p>
                  Asset Usage
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              @if(str_contains( Session::get('menu_access'), 'US01'))
                <li class="nav-item has-treeview">
                      <a href="{{url('/usagemt')}}" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          Asset PM Calculate
                        </p>
                      </a>
                    </li>
              @endif
              @if(str_contains( Session::get('menu_access'), 'US02'))
                <li class="nav-item has-treeview">
                      <a href="{{url('/usagemulti')}}" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          Asset Multi Batch
                        </p>
                      </a>
                    </li>
              @endif
              </ul>
            </li>
          @endif
		  
          @if(str_contains( Session::get('menu_access'), 'BO'))
            <li class="nav-item has-treeview">
              <a href="{{url('/booking')}}" class="nav-link">
                <i class="nav-icon fas fa-bookmark"></i>
                <p>
                  Asset Booking
                </p>
              </a>
            </li>
          @endif
          

          @if(str_contains(Session::get('menu_access'), 'RT'))
            <li class="nav-item has-treeview">
              <a href="javascript:void(0)" class="nav-link">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>
                  Reports
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              
                <li class="nav-item has-treeview">
                  <a href="{{url('/allrpt')}}" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      All Asset Schedule
                    </p>
                  </a>
                </li>
                @if(str_contains( Session::get('menu_access'), 'RT03'))
                  <li class="nav-item has-treeview">
                        <a href="{{url('/assetsch')}}" class="nav-link">
                          <i class="nav-icon far fa-circle"></i>
                          <p>
                            Asset Schedule
                          </p>
                        </a>
                      </li>
                @endif
                
              @if(str_contains( Session::get('menu_access'), 'RT01'))
                <li class="nav-item has-treeview">
                      <a href="{{url('/engsch')}}" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          Engineer Schedule
                        </p>
                      </a>
                    </li>
              @endif
              
              @if(str_contains( Session::get('menu_access'), 'RT02'))
                <li class="nav-item has-treeview">
                      <a href="{{url('/bookcal')}}" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          Asset Booking Schedule
                        </p>
                      </a>
                    </li>
              @endif
              @if(str_contains( Session::get('menu_access'), 'RT05'))
                <li class="nav-item has-treeview">
                      <a href="{{url('/assetrpt')}}" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          Asset Report
                        </p>
                      </a>
                    </li>
              @endif
              @if(str_contains( Session::get('menu_access'), 'RT04'))
                <li class="nav-item has-treeview">
                      <a href="{{url('/engrpt')}}" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          Engineer Report
                        </p>
                      </a>
                    </li>
              @endif
              
              </ul>
            </li>
          @endif

          @if(str_contains( Session::get('menu_access'), 'MT'))
            <li class="nav-item has-treeview">
            <a href="javascript:void(0)" class="nav-link" data-toggle="tooltip" title="Menu ini berisi kumpulan sub-menu agar user dapat mengatur data set awal">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    User
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @if(str_contains( Session::get('menu_access'), 'MT21'))
                    <li class="nav-item">
                      <a href="/deptmaster" class="nav-link">
                        <p>Department</p>
                      </a>
                    </li>
                  @endif
                   @if(str_contains( Session::get('menu_access'), 'MT22'))
                    <li class="nav-item">
                      <a href="/skillmaster" class="nav-link">
                        <p>Engineer Skills</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MT20'))
                    <li class="nav-item">
                      <a href="/engmaster" class="nav-link">
                        <p>User</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MT02'))
                    <li class="nav-item">
                      <a href="/rolemaster" class="nav-link">
                        <p>Role</p>
                      </a>
                    </li>
                  @endif                 
                  
                  <!-- @if(str_contains( Session::get('menu_access'), 'MT01'))
                    <li class="nav-item">
                      <a href="{{url('/usermt')}}" class="nav-link">
                        <p>User</p>
                      </a>
                    </li>
                  @endif -->
                </ul> <!-- ul users -->
              </li> <!-- li users -->
              @if(str_contains( Session::get('menu_access'), 'MT03'))
                <li class="nav-item">
                  <a href="/sitemaster" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Site</p>
                  </a>
                </li>
              @endif
              @if(str_contains( Session::get('menu_access'), 'MT04'))
                <li class="nav-item">
                  <a href="/areamaster" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Location</p>
                  </a>
                </li>
              @endif            
              @if(str_contains( Session::get('menu_access'), 'MT07'))
                <li class="nav-item">
                  <a href="/suppmaster" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Supplier</p>
                  </a>
                </li>
              @endif
              @if(str_contains(Session::get('menu_access'), 'MT99'))
                <li class="nav-item">
                  <a href="{{url('/runningmstr')}}" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Running Number</p>
                  </a>
                </li>
              @endif
                @if(str_contains(Session::get('menu_access'), 'MT13'))
                <li class="nav-item">
                  <a href="{{url('/wotyp')}}" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>WO Type Maintenance</p>
                  </a>
                </li>
              @endif
               @if(str_contains(Session::get('menu_access'), 'MT14'))
                <li class="nav-item">
                  <a href="{{url('/imp')}}" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Impact Maintenance</p>
                  </a>
                </li>
              @endif
              <li class="nav-item has-treeview">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Asset
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @if(str_contains( Session::get('menu_access'), 'MT05'))
                    <li class="nav-item">
                      <a href="/assettypemaster" class="nav-link">
                        <p>Asset Type</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MT06'))
                    <li class="nav-item">
                      <a href="/assetgroupmaster" class="nav-link">
                        <p>Asset Group</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MT13'))
                    <li class="nav-item">
                      <a href="/fnmaster" class="nav-link">
                        <p>Failure Code</p>
                      </a>
                    </li>
                  @endif
                    
                  @if(str_contains( Session::get('menu_access'), 'MT08'))
                  <li class="nav-item">
                    <a href="/assetmaster" class="nav-link">
                      <p>Asset Maintenance</p>
                    </a>
                  </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MT09'))
                  <li class="nav-item">
                    <a href="/asparmaster" class="nav-link">
                      <p>Asset Hierarchy</p>
                    </a>
                  </li>
                  @endif
                </ul><!-- ul asset -->
              </li> <!-- li asset -->
              <li class="nav-item has-treeview">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Spare Part
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @if(str_contains( Session::get('menu_access'), 'MT10'))
                    <li class="nav-item">
                      <a href="/sptmaster" class="nav-link">
                        <p>Spare Part Type</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MT11'))
                    <li class="nav-item">
                      <a href="/spgmaster" class="nav-link">
                        <p>Spare Part Group</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MT12'))
                    <li class="nav-item">
                      <a href="/spmmaster" class="nav-link">
                        <p>Spare Part Maintenance</p>
                      </a>
                    </li>
                  @endif
                </ul><!-- ul spare part -->
              </li> <!-- li spare part -->
              <li class="nav-item has-treeview">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Repair
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">	
                  <!-- @if(str_contains( Session::get('menu_access'), 'MT15'))
                    <li class="nav-item">
                      <a href="/repmaster" class="nav-link">
                        <p>Repair Code</p>
                      </a>
                    </li>
                  @endif -->
                  @if(str_contains( Session::get('menu_access'), 'MT26'))
                    <li class="nav-item">
                      <!-- <a href="/repmasterb" class="nav-link"> -->
                      <!-- <a href="/repdet" class="nav-link"> -->
                      <a href="/repcode" class="nav-link">
                        <p>Repair Code</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MT13')) 
					         <li class="nav-item">
                      <a href="/repgroup" class="nav-link">
                        <p>Repair Group</p>
                      </a>
                    </li>
				          @endif
                  @if(str_contains( Session::get('menu_access'), 'MT16'))
                    <li class="nav-item">
                      <a href="/insmaster" class="nav-link">
                        <p>Instruction Code</p>
                      </a>
                    </li>
                  @endif
                  <!-- @if(str_contains( Session::get('menu_access'), 'MT24'))
                    <li class="nav-item">
                      <a href="/insgroup" class="nav-link">
                        <p>Instruction Group</p>
                      </a>
                    </li>
                  @endif -->
                <!--  @if(str_contains( Session::get('menu_access'), 'MT17'))
                    <li class="nav-item">
                      <a href="/reppart" class="nav-link">
                        <p>Repair Part</p>
                      </a>
                    </li>
                  @endif-->
                  <!-- @if(str_contains( Session::get('menu_access'), 'MT25'))
                    <li class="nav-item">
                      <a href="/reppartgroup" class="nav-link">
                        <p>Repair Part Group</p>
                      </a>
                    </li>
                  @endif -->
                  <!-- @if(str_contains( Session::get('menu_access'), 'MT18'))
                    <li class="nav-item">
                      <a href="/repins" class="nav-link">
                        <p>Repair Instruction</p>
                      </a>
                    </li>
                  @endif			 -->		  
                  @if(str_contains( Session::get('menu_access'), 'MT14'))
                    <li class="nav-item">
                      <a href="/toolmaster" class="nav-link">
                        <p>Tools</p>
                      </a>
                    </li>
                  @endif			  			  
                <!-- @if(str_contains( Session::get('menu_access'), 'MT17'))
                    <li class="nav-item">
                      <a href="/reppart" class="nav-link">
                        <p>Repair Part</p>
                      </a>
                    </li>
                  @endif  -->
				  
                  <!-- @if(str_contains( Session::get('menu_access'), 'MT23'))
                    <li class="nav-item">
                      <a href="/repdet" class="nav-link">
                        <p>Repair Detail</p>
                      </a>
                    </li>
                  @endif -->
                </ul><!-- ul repair -->
              </li> <!-- li repair -->
              
              @if(str_contains( Session::get('menu_access'), 'MT19'))
                <li class="nav-item">
                  <a href="/inv" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Inventory Data</p>
                  </a>
                </li>
              @endif
            </ul> <!-- ul setting -->
            </li> <!-- li setting -->
        
          @endif
          
          <!-- end li -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  @include('sweetalert::alert')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      @yield('content-header')
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       
          @yield('content')
        
      </div>
    </div>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Are you sure want to Logout now?</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <a class="btn btn-primary" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }} </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </div>
        </div>
  </div>

  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark"> -->
    <!-- Control sidebar content goes here -->
  <!-- </aside> -->
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="https://www.ptimi.co.id/">PT. Intelegensia Mustaka Indonesia</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 0.0.1
    </div>
  </footer> -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!--sweetalert-->
<script src="{{url('plugins\sweetalert2\sweetalert2.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{url('dist/js/adminlte.js')}}"></script>
<script src="{{url('plugins/select2/js/select2.min.js')}}"></script>
<script src="{{url('assets/css/jquery-ui.js')}}"></script>
<!-- OPTIONAL SCRIPTS -->
<!-- <script src="plugins/chart.js/Chart.min.js"></script> -->
<script src="{{url('dist/js/demo.js')}}"></script>
<!-- <script src="dist/js/pages/dashboard3.js"></script> -->
<script src="{{url('vendors/chart.js/dist/Chart.bundle.min.js')}}"></script>

@yield('scripts')
<script type="text/javascript">


  $(document).ready(function() {
            if(window.innerWidth <= 576){
                document.querySelector('body').classList.remove('open');
              }else{
                document.querySelector('body').classList.add('open');   
              }

            
            window.addEventListener("resize", myFunction);

            function myFunction() {
              if(window.innerWidth <= 576){
                document.querySelector('body').classList.remove('open');
              }else{
                document.querySelector('body').classList.add('open');   
              }
            }

            // $(".modal-body").click(function () {
            //   alert("Hello!");
            //   // $(".hide_div").hide();
            // });
  });


  /** add active class and stay opened when selected */
  var url = window.location;

  // for sidebar menu entirely but not cover treeview
  $('ul.nav-sidebar a').filter(function() {
      return this.href == url;
  }).addClass('active');

  // for treeview
  $('ul.nav-treeview a').filter(function() {
      return this.href == url;
  }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');



  // Notification

  function sendMarkRequest(id = null) {
        return $.ajax("{{ route('notifread') }}", {
            method: 'POST',
            data: {
                "_token" : "{{csrf_token()}}" ,
                "id" : id
            }
        });
  }
  
  function sendMarkAllRequest(id = null) {
         return $.ajax("{{ route('notifreadall') }}", {
               method: 'POST',
               data: {
                        "_token" : "{{csrf_token()}}",
                        "id" : id
               }
         });
  }

  $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));
            request.done(() => {
                $(this).parents('div.alert').remove();
            });
        });
        
        $('.mark-as-read-all').click(function(){
            // alert('hello');
            let request = sendMarkAllRequest($(this).data('id'));
            request.done(() => {
                $(this).parents('div.alert').remove();
                window.location.reload();
            });
        });
  });



</script>
</body>
</html>
