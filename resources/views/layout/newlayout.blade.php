<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">


  <title>eAMS Module</title>
  <link rel="icon" type="image/gif/jpg" href="images/imgheadxx.png">
  <link rel="stylesheet" href="{{url('assets/css/bootstrap-select.min.css')}}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.css')}}">


  <!-- IonIcons -->
  <!-- <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->

  <!--table mobile -->
  <link rel="stylesheet" type="text/css" href="{{url('assets/css/so_mobile.css')}}">
  <!-- <link rel="stylesheet" type="text/css" href="{{url('assets/css/tablestyle.css')}}"> -->

  <link rel="stylesheet" href="{{url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->

  <link href="{{url('plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{url('assets/css/checkbox.css')}}">
  <!-- select2 bootstrap theme -->
  <link rel="stylesheet" href="{{url('plugins/select2-bootstrap4-theme/select2-bootstrap4.css')}}">
  <link rel="stylesheet" href="{{url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('plugins/jquery-ui-themes-1.12.1/jquery-ui.css')}}">

  <!--sweetalert-->
  <link rel="stylesheet" href="{{url('plugins\sweetalert2\sweetalert2.min.css')}}">

  <!--animatecss-->
  <link rel="stylesheet" href="{{url('plugins\animate.css-4.1.1\animate.min.css')}}" />


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
      <div class="om-menu ml-auto">
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
              <a id="bell" href="{{$notif->data['url']}}" data-id="{{$notif->id}}" data-link="{{$notif->data['url']}}" class="dropdown-item mark-as-read" style="word-wrap:break-word">
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
              <a class="dropdown-item d-flex align-items-center" href="">
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
        <span class="brand-text font-weight-light">eAMS IMI</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <div class="form-inline mt-2">
          <div class="input-group" data-widget="sidebar-search" data-min-length='1' data-not-found-text='No results' data-highlight-class='text-green' data-max-results='10' data-highlight-name='true' data-highlight-path='true' data-arrow-sign='=>'>
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <!-- <li class="nav-header">SETTING</li> -->
            <li class="nav-item ">
              <a href="/traininghome" class="nav-link ">
                <i class="nav-icon fas fa-book-open"></i>
                <p>Introduction</p>
              </a>
            </li>

            @if(str_contains( Session::get('menu_access'), 'RC01'))
            <li class="nav-item ">
              <a href="/myroutine" class="nav-link ">
                <i class="nav-icon fas fa-user-clock"></i>
                <p>My Routine Check</p>
              </a>
            </li>
            @endif

            @if(str_contains( Session::get('menu_access'), 'SR'))
            <li class="nav-item has-treeview">
              <a href="javascript:void(0)" class="nav-link">
                <i class="nav-icon fas fa-dolly"></i>
                <p>
                  Service Request
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(str_contains( Session::get('menu_access'), 'SR01'))
                <li class="nav-item has-treeview">
                  <a href="/servicerequest" class="nav-link ">
                    <p>Service Request Create</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SR03'))
                <li class="nav-item has-treeview">
                  <a href="/srbrowse" class="nav-link ">
                    <p>Service Request Maintenance</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SR06'))
                <li class="nav-item has-treeview">
                  <a href="/srbrowseonly" class="nav-link ">
                    <p>Service Request Browse</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SR02'))
                <li class="nav-item has-treeview">
                  <a href="/srapproval" class="nav-link ">
                    <p>Service Request Approval</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SR05'))
                <li class="nav-item has-treeview">
                  <a href="/srapprovaleng" class="nav-link ">
                    <p>Service Request Approval Engineer</p>
                  </a>
                </li>
                @endif
                {{-- Dua Kelinci tidak menggunakan user acceptance
                  @if(str_contains( Session::get('menu_access'), 'SR04'))
                <li class="nav-item">
                  <a href="/useracceptance" class="nav-link ">
                      <p>User Acceptance</p>
                  </a>
                </li>
                @endif  --}}
                @if(str_contains( Session::get('menu_access'), 'SR04'))
                <li class="nav-item">
                  <a href="/useracceptance" class="nav-link ">
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
                {{-- Ditutup karena tidak digunakan lagi, bisa menggunakan create WO
                @if(str_contains( Session::get('menu_access'), 'WO06'))
                <li class="nav-item ">
                  <a href="/wocreatedirectmenu" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                      <p>WO Create Without Approval</p>
                  </a>
                </li>
                @endif  --}}
                @if(str_contains( Session::get('menu_access'), 'WO01'))
                <li class="nav-item ">
                  <a href="/womaint" class="nav-link ">
                    <p>Work Order Maintenance</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO05'))
                <li class="nav-item ">
                  <a href="/wobrowse" class="nav-link ">
                    <p>Work Order Browse</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO09'))
                <li class="nav-item ">
                  <a href="/worelease" class="nav-link ">
                    <p>Work Order Release</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO10'))
                <li class="nav-item ">
                  <a href="/woreleaseapprovalbrowse" class="nav-link ">
                    <p>Work Order Release Approval</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO07'))
                <li class="nav-item ">
                  <a href="/wotransfer" class="nav-link ">
                    <p>Work Order Transfer</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO02'))
                <li class="nav-item ">
                  <a href="/wojoblist" class="nav-link ">
                    <p>Work Order Start</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO03'))
                <li class="nav-item">
                  <a href="/woreport" class="nav-link ">
                    <p>Work Order Reporting</p>
                  </a>
                </li>
                @endif
                {{-- @if(str_contains( Session::get('menu_access'), 'WO08'))
                <li class="nav-item">
                  <a href="/woqc" class="nav-link ">
                      <p>WO QC Approval</p>
                  </a>
                </li>
                @endif --}}
                @if(str_contains( Session::get('menu_access'), 'WO08'))
                <li class="nav-item">
                  <a href="/woapprovalbrowse" class="nav-link ">
                    <p>Work Order Approval</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'WO04'))
                <li class="nav-item">
                  <a href="/returnbacksp" class="nav-link ">
                    <p>Return Sparepart</p>
                  </a>
                </li>
                @endif

                <!-- <li class="nav-item ">
                    <a href="/confeng" class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>
                        Engineer Confirm
                      </p>
                    </a>
                  </li> -->

              </ul>
            </li>
            @endif

            @if(str_contains(Session::get('menu_access'), 'SP'))
            <li class="nav-item has-treeview">
              <a href="javascript:void(0)" class="nav-link">
                <i class="nav-icon fa fa-cubes"></i>
                <p>
                  Sparepart Transactions
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(str_contains( Session::get('menu_access'), 'SP03'))
                <li class="nav-item has-treeview">
                  <a href="{{url('/reqsp')}}" class="nav-link">
                    <p>Request Sparepart</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SP06'))
                <li class="nav-item has-treeview">
                  <a href="{{url('/reqspapproval')}}" class="nav-link">
                    <p>Request Sparepart Approval</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SP04'))
                <li class="nav-item has-treeview">
                  <a href="{{url('/trfsp')}}" class="nav-link">
                    <p>Transfer Sparepart</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SP05'))
                <li class="nav-item has-treeview">
                  <a href="/accutransfer" class="nav-link">
                    <p>Accumulative Sparepart Transfer</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SP07'))
                <li class="nav-item has-treeview">
                  <a href="/retsp" class="nav-link">
                    <p>Return Sparepart</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'SP08'))
                <li class="nav-item has-treeview">
                  <a href="/retspwhs" class="nav-link">
                    <p>Return Sparepart Warehouse</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            @endif

            @if(str_contains(Session::get('menu_access'), 'US'))
            <li class="nav-item has-treeview">
              <a href="javascript:void(0)" class="nav-link">
                <i class="nav-icon fas fa-link"></i>
                <p>
                  Asset Usage
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(str_contains( Session::get('menu_access'), 'US01'))
                <li class="nav-item has-treeview">
                  <a href="/usagemt" class="nav-link ">
                    <p>Asset Measurement Reporting</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'US04'))
                <li class="nav-item has-treeview">
                  <a href="{{route('usbrowse')}}" class="nav-link ">
                    <p>Usage Browse</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'US08'))
                <li class="nav-item has-treeview">
                  <a href="{{route('pmmeter')}}" class="nav-link ">
                    <p>PM Planning for Meter</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'US02'))
                <li class="nav-item has-treeview">
                  <a href="/usagemulti" class="nav-link ">
                    <p>Asset Multi Batch</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'US03'))
                <li class="nav-item has-treeview">
                  <a href="/viewwogenerator" class="nav-link ">
                    <p>PM Planning</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'US05'))
                <li class="nav-item has-treeview">
                  <a href="/pmconf" class="nav-link ">
                    <p>PM Confirm</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'US06'))
                <li class="nav-item has-treeview">
                  <a href="/pmmssg" class="nav-link ">
                    <p>PM Action Message</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'US06'))
                <li class="nav-item has-treeview">
                  <a href="{{url('/needsp')}}" class="nav-link ">
                    <p>Sparepart Planning</p>
                  </a>
                </li>
                @endif


              </ul>
            </li>
            @endif


            @if(str_contains(Session::get('menu_access'), 'BO'))
            <li class="nav-item has-treeview">
              <a href="javascript:void(0)" class="nav-link">
                <i class="nav-icon fa fa-list-alt"></i>
                <p>
                  Another Transactions
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(str_contains( Session::get('menu_access'), 'BO01'))
                <li class="nav-item has-treeview">
                  <a href="{{url('/booking')}}" class="nav-link">
                    <p>Asset Booking</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'BO02'))
                <li class="nav-item has-treeview">
                  <a href="{{url('/whyhist')}}" class="nav-link">
                    <p>5 Why Transaction</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'MT30'))
                <li class="nav-item has-treeview">
                  <a href="/assetmove" class="nav-link">
                    <p>Asset Movement</p>
                  </a>
                </li>
                @endif
              </ul>
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
                @if(str_contains( Session::get('menu_access'), 'RT08'))
                <li class="nav-item">
                  <a href="/rptdetwo" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Detail WO Report</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'RT09'))
                <li class="nav-item">
                  <a href="/rptcost" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Cost Report</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'RT05'))
                <li class="nav-item">
                  <a href="/assetrpt" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Asset Report</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'RT04'))
                <li class="nav-item">
                  <a href="/engrpt" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Engineer Report</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'RT15'))
                <li class="nav-item">
                  <a href="/downrpt" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Downtime Report</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'RT14'))
                <li class="nav-item">
                  <a href="/renewrpt" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                      <p>Asset Renewal Report</p>
                  </a>
                </li>
                @endif
                @if(str_contains( Session::get('menu_access'), 'RT16'))
                <li class="nav-item">
                  <a href="/sptrpt" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                      <p>Sparepart Report</p>
                  </a>
                </li>
                @endif
                {{-- Ditutup karena sama dengan menu Sparepart Planning
                  @if(str_contains( Session::get('menu_access'), 'RT10'))
                <li class="nav-item">
                  <a href="/remsp" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                      <p>Remaining Sparepart</p>
                  </a>
                </li>
                @endif  --}}

                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Schedule
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    {{-- <li class="nav-item">
                      <a href="/allrpt" class="nav-link ">
                          <p>All Asset Schedule</p>
                      </a>
                    </li>  --}}
                    @if(str_contains( Session::get('menu_access'), 'RT03'))
                    <li class="nav-item">
                      <a href="/assetsch" class="nav-link ">
                        <p>Asset Schedule</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'RT07'))
                    <li class="nav-item">
                      <a href="/assetyear" class="nav-link ">
                        <p>Asset Schedule (Year)</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'RT01'))
                    <li class="nav-item">
                      <a href="/engsch" class="nav-link ">
                        <p>Engineer Schedule</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'RT02'))
                    <li class="nav-item">
                      <a href="/bookcal" class="nav-link ">
                        <p>Asset Booking Schedule</p>
                      </a>
                    </li>
                    @endif
                  </ul><!-- ul Schedule -->
                </li> <!-- li Schedule -->

                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      View Transactions
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(str_contains( Session::get('menu_access'), 'RT13'))
                    <li class="nav-item">
                      <a href="/viewwhy" class="nav-link ">
                        <p>5 Why View</p>
                      </a>
                    </li>
                    @endif
                  </ul><!-- ul Schedule -->
                </li> <!-- li Schedule -->

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
                @if(str_contains( Session::get('menu_access'), 'MTA')) <!-- if access users -->
                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      User
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(str_contains( Session::get('menu_access'), 'MTA21'))
                    <li class="nav-item">
                      <a href="/deptmaster" class="nav-link ">
                        <p>Department</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTA22'))
                    <li class="nav-item">
                      <a href="/skillmaster" class="nav-link ">
                        <p>Engineer Skills</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTA02'))
                    <li class="nav-item">
                      <a href="/rolemaster" class="nav-link ">
                        <p>Role</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTA01'))
                    <li class="nav-item">
                      <a href="/engmaster" class="nav-link ">
                        <p>User</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTA38'))
                    <li class="nav-item">
                      <a href="/enggroup" class="nav-link ">
                        <p>Engineer Group</p>
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
                @endif <!-- endif access users -->

                @if(str_contains( Session::get('menu_access'), 'MTB')) <!-- if access Control File -->
                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Control File
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(str_contains(Session::get('menu_access'), 'MTB99'))
                    <li class="nav-item">
                      <a href="/runningmstr" class="nav-link ">
                        <p>Running Number</p>
                      </a>
                    </li>
                    @endif
                    {{-- Belum Digunakan
                      @if(str_contains(Session::get('menu_access'), 'MT30'))
                    <li class="nav-item">
                      <a href="/picklogic" class="nav-link ">
                        <p>Picking Logic</p>
                      </a>
                    </li>
                    @endif  --}}
                    @if(str_contains(Session::get('menu_access'), 'MTB20'))
                    <li class="nav-item">
                      <a href="/qxwsa" class="nav-link ">
                        <p>WSA Qxtend Maintenance</p>
                      </a>
                    </li>
                    @endif

                  </ul><!-- ul Control File -->
                </li> <!-- li Control File -->
                @endif <!-- endif Control File -->

                @if(str_contains( Session::get('menu_access'), 'MTC')) <!-- if access Failure -->
                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Failure
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(str_contains(Session::get('menu_access'), 'MTC32'))
                    <li class="nav-item">
                      <a href="/wotyp" class="nav-link ">
                        <p>Failure Type Maintenance</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTC33'))
                    <li class="nav-item">
                      <a href="/fnmaster" class="nav-link ">
                        <p>Failure Code</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains(Session::get('menu_access'), 'MTC34'))
                    <li class="nav-item">
                      <a href="/imp" class="nav-link ">
                        <p>Impact Maintenance</p>
                      </a>
                    </li>
                    @endif
                  </ul>
                </li>
                @endif <!-- endif Failure -->

                @if(str_contains( Session::get('menu_access'), 'MTD')) <!-- if access Sparepart -->
                <!-- start li sparepart -->
                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Sparepart
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    {{-- @if(str_contains( Session::get('menu_access'), 'MT10'))
                      <li class="nav-item">
                        <a href="/sptmaster" class="nav-link ">
                          <p>Sparepart Type</p>
                        </a>
                      </li>
                      @endif
                      @if(str_contains( Session::get('menu_access'), 'MT11'))
                      <li class="nav-item">
                        <a href="/spgmaster" class="nav-link ">
                          <p>Sparepart Group</p>
                        </a>
                      </li>
                      @endif  --}}
                    @if(str_contains( Session::get('menu_access'), 'MTD27'))
                    <li class="nav-item">
                      <a href="/sitemaster" class="nav-link ">
                        <p>Sparepart Site</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTD29'))
                    <li class="nav-item">
                      <a href="/areamaster" class="nav-link ">
                        <p>Sparepart Location</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTD12'))
                    <li class="nav-item">
                      <a href="/spmmaster" class="nav-link ">
                        <p>Sparepart Maintenance</p>
                      </a>
                    </li>
                    @endif
                  </ul><!-- ul sparepart -->
                </li> <!-- li sparepart -->
                @endif <!-- endif Sparepart -->

                @if(str_contains( Session::get('menu_access'), 'MTF')) <!-- if access Instruction -->
                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Instruction
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(str_contains( Session::get('menu_access'), 'MTF35'))
                    <li class="nav-item">
                      {{--  <a href="/insmaster" class="nav-link ">  --}}
                      <a href="/inslist" class="nav-link ">
                        <p>Instruction List</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTF41'))
                    <li class="nav-item">
                      {{--  <a href="/insmaster" class="nav-link ">  --}}
                      <a href="/splist" class="nav-link ">
                        <p>Sparepart List</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTF40'))
                    <li class="nav-item">
                      <a href="/qcspec" class="nav-link ">
                        <p>QC Spesification</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTF39'))
                      <li class="nav-item">
                        <a href="/pmcode" class="nav-link">
                          <p>Maintenance Code</p>
                        </a>
                      </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTF48'))
                      <li class="nav-item">
                        <a href="/notmssg" class="nav-link">
                          <p>Message Maintenance</p>
                        </a>
                      </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTF43'))
                      <li class="nav-item">
                        <a href="/rcmmstr" class="nav-link">
                          <p>Routine Check Maintenance</p>
                        </a>
                      </li>
                    @endif
                  </ul><!-- ul Instruction -->
                </li> <!-- li Instruction --> 
                @endif <!-- endif Instruction -->

                @if(str_contains( Session::get('menu_access'), 'MTE')) <!-- if access asset -->
                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Asset
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(str_contains( Session::get('menu_access'), 'MTE05'))
                    <li class="nav-item">
                      <a href="/assettypemaster" class="nav-link ">
                        <p>Asset Type</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTE06'))
                    <li class="nav-item">
                      <a href="/assetgroupmaster" class="nav-link ">
                        <p>Asset Group</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTE07'))
                    <li class="nav-item">
                      <a href="/suppmaster" class="nav-link ">
                        <p>Supplier</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTE26'))
                    <li class="nav-item">
                      <a href="/assetsite" class="nav-link ">
                        <p>Asset Site</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTE28'))
                    <li class="nav-item">
                      <a href="/assetloc" class="nav-link">
                        <p>Asset Location</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTE36'))
                    <li class="nav-item">
                      <a href="/um" class="nav-link">
                        <p>UM Maintenance</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTE08'))
                    <li class="nav-item">
                      <a href="/assetmaster" class="nav-link">
                        <p>Asset Maintenance</p>
                      </a>
                    </li>
                    @endif

                    {{-- <li class="nav-item">
                    <a href="/pmdets" class="nav-link">
                      <p>Asset PM Details</p>
                    </a>
                  </li>  --}}
                    @if(str_contains( Session::get('menu_access'), 'MTE09'))
                    <li class="nav-item">
                      <a href="/asparmaster" class="nav-link">
                        <p>Asset Hierarchy</p>
                      </a>
                    </li>
                    @endif

                    <!-- @if(str_contains( Session::get('menu_access'), 'MTE31'))
                  <li class="nav-item">
                    <a href="/pmeng" class="nav-link">
                      <p>Engineer For PM</p>
                    </a>
                  </li>
                  @endif  -->
                  @if(str_contains( Session::get('menu_access'), 'MTE37'))
                  <li class="nav-item">
                    <a href="/asfn" class="nav-link">
                      <p>Mapping Asset - Failure</p>
                    </a>
                  </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MTE42'))
                  <li class="nav-item">
                    <a href="/pmasset" class="nav-link">
                      <p>Preventive Maintenance</p>
                    </a>
                  </li>
                  @endif
                  
                </ul><!-- ul asset -->
              </li> <!-- li asset -->
              @endif <!-- endif asset -->
              
              @if(str_contains( Session::get('menu_access'), 'MTF')) <!-- if access Instruction -->
              <li class="nav-item has-treeview">
                <a href="javascript:void(0)" class="nav-link ">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Instruction
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @if(str_contains( Session::get('menu_access'), 'MTF35'))
                  <li class="nav-item">
                    {{--  <a href="/insmaster" class="nav-link ">  --}}
                    <a href="/inslist" class="nav-link ">
                      <p>Instruction List</p>
                    </a>
                  </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MTF41'))
                  <li class="nav-item">
                    {{--  <a href="/insmaster" class="nav-link ">  --}}
                    <a href="/splist" class="nav-link ">
                      <p>Sparepart List</p>
                    </a>
                  </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MTF40'))
                  <li class="nav-item">
                    <a href="/qcspec" class="nav-link ">
                      <p>QC Spesification</p>
                    </a>
                  </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MTF39'))
                    <li class="nav-item">
                      <a href="/pmcode" class="nav-link">
                        <p>Maintenance Code</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MTF48'))
                    <li class="nav-item">
                      <a href="/notmssg" class="nav-link">
                        <p>Message Maintenance</p>
                      </a>
                    </li>
                  @endif
                  @if(str_contains( Session::get('menu_access'), 'MTF43'))
                    <li class="nav-item">
                      <a href="/rcmmstr" class="nav-link">
                        <p>Routine Check Maintenance</p>
                      </a>
                    </li>
                  @endif
                </ul><!-- ul Instruction -->
              </li> <!-- li Instruction --> 
              @endif <!-- endif Instruction -->

                @if(str_contains( Session::get('menu_access'), 'MTG')) <!-- if access Approval -->
                <!-- start li Approval -->
                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Approval
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(str_contains( Session::get('menu_access'), 'MTG44'))
                    <li class="nav-item">
                      <a href="/appsr" class="nav-link ">
                        <p>Approval SR</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTG45'))
                    <li class="nav-item">
                      <a href="/appwo" class="nav-link ">
                        <p>Approval WO</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTG49'))
                    <li class="nav-item">
                      <a href="/appsp" class="nav-link ">
                        <p>Approval SP</p>
                      </a>
                    </li>
                    @endif
                  </ul><!-- ul Approval -->
                </li> <!-- li Approval -->
                @endif <!-- endif Approval -->

                @if(str_contains( Session::get('menu_access'), 'MTH')) <!-- if access Inventory -->
                <!-- start li Inventory -->
                <li class="nav-item has-treeview">
                  <a href="javascript:void(0)" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Inventory
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(str_contains( Session::get('menu_access'), 'MTH46'))
                    <li class="nav-item">
                      <a href="/invso" class="nav-link ">
                        <p>Inventory Source</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTH47'))
                    <li class="nav-item">
                      <a href="/invsu" class="nav-link ">
                        <p>Inventory Supply</p>
                      </a>
                    </li>
                    @endif
                    @if (str_contains( Session::get('menu_access'), 'MTH48'))
                    <li class="nav-item">
                      <a href="/spstockbrowse" class="nav-link ">
                        <p>Inventory Check Stock</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTH51'))
                    <li class="nav-item">
                      <a href="/accmstr" class="nav-link ">
                        <p>Account Maintenance</p>
                      </a>
                    </li>
                    @endif
                    @if(str_contains( Session::get('menu_access'), 'MTH50'))
                      <li class="nav-item">
                        <a href="/costcenter" class="nav-link ">
                          <p>Cost Center</p>
                        </a>
                      </li>
                    @endif
                  </ul><!-- ul Inventory -->
                </li> <!-- li Inventory -->
                @endif <!-- endif Inventory -->

                {{-- Belum perlu digunakan
                  @if(str_contains( Session::get('menu_access'), 'MT19'))
                <li class="nav-item">
                  <a href="/inv" class="nav-link ">
                    <i class="nav-icon far fa-circle"></i>
                      <p>Inventory Data</p>
                  </a>
                </li>
                @endif  --}}
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
    <div class="content-wrapper">

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
            <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
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
  <!-- <script src="{{url('dist/js/demo.js')}}"></script> -->
  <!-- <script src="dist/js/pages/dashboard3.js"></script> -->
  <script src="{{url('plugins/chart.js/Chart.bundle.min.js')}}"></script>

  <script src="{{url('assets/js/bootstrap-select.min.js')}}"></script>

  @yield('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      if (window.innerWidth <= 576) {
        document.querySelector('body').classList.remove('open');
      } else {
        document.querySelector('body').classList.add('open');
      }


      window.addEventListener("resize", myFunction);

      function myFunction() {
        if (window.innerWidth <= 576) {
          document.querySelector('body').classList.remove('open');
        } else {
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
          "_token": "{{csrf_token()}}",
          "id": id
        }
      });
    }

    function sendMarkAllRequest(id = null) {
      return $.ajax("{{ route('notifreadall') }}", {
        method: 'POST',
        data: {
          "_token": "{{csrf_token()}}",
          "id": id
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

      $('.mark-as-read-all').click(function() {
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