<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Maven - @yield('title')</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('/public/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }} ">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/public/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  <!-- Bootstrap CSS -->
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> 
  <link rel="stylesheet" href="{{ asset('/public/assets/custom.css') }}"> 

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('/public/dist/img/AdminLTELogo.png') }}" alt="Unominds" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/public/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Hi {{ ucwords(session('adminName')) }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
            <li class="nav-item ">
              <?php 
                $activeCls = '';
                if($active_link == 'dashboard') {
                  $activeCls = 'active';
                }
              ?>  
              <a href="{{ route('admin.') }}" class="nav-link {{ $activeCls }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

       
          <li class="nav-item">
            <a href="{{ route('admin.customers') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ route('admin.dealers') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Dealers
              </p>
            </a>
          </li>
		  
		  <li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'used_cars') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.used_cars') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-car"></i>
				  <p>
					Used Cars
				  </p>
				</a>
			</li>
			
			<li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'inspection') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.inspection_list') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-assistive-listening-systems"></i>
				  <p>
					Inspection
				  </p>
				</a>
			</li>
			
			<li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'banners') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.banners') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-images"></i>
				  <p>
					Banners
				  </p>
				</a>
			</li>
			
			<li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'badges') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.badges') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-certificate"></i>
				  <p>
					Badges
				  </p>
				</a>
			</li>

          <?php 
            if($active_link == 'change_password' || $active_link == 'update_profile' || $active_link == 'country_list' || $active_link ==  'category_list' || $active_link == 'company_list' || $active_link == 'model_list' || $active_link == "update_charges" || $active_link  =="notification_list"   ) {
              $menuOpenCls = 'menu-open';
            } else {
              $menuOpenCls = '';
            }
          ?>

          <li class="nav-item has-treeview {{ $menuOpenCls }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <?php 
                  $activeCls = '';
                  if($active_link == 'change_password') {
                    $activeCls = 'active';
                  }
                ?>             
                <a href="{{ route('admin.changePassword') }}" class="nav-link {{ $activeCls }}">
                  <i class="nav-icon fas fa-list-alt"></i>
                  <p>
                    Change Password
                  </p>
                </a>
              </li>             
    
            
              <li class="nav-item">
                <?php 
                  $activeCls = '';
                  if($active_link == 'update_profile') {
                    $activeCls = 'active';
                  }
                ?> 
                <a href="{{ route('admin.updateProfile') }}" class="nav-link {{ $activeCls }}">
                  <i class="nav-icon fas fa-list-alt"></i>
                  <p>
                    Update Profile
                  </p>
                </a>
              </li>                
             

              <li class="nav-item">
                <?php 
                  $activeCls = '';
                  if($active_link == 'update_charges') {
                    $activeCls = 'active';
                  }
                ?> 
                <a href="{{ route('admin.updateCharges') }}" class="nav-link {{ $activeCls }}">
                  <i class="nav-icon fas fa-list-alt"></i>
                  <p>
                    Update Charges
                  </p>
                </a>
              </li> 


              <li class="nav-item">
                <?php 
                  $activeCls = '';
                  if($active_link == 'category_list') {
                    $activeCls = 'active';
                  }
                ?> 
                <a href="{{ route('admin.categories') }}" class="nav-link {{ $activeCls }}">
                  <i class="nav-icon fas fa-list-alt"></i>
                  <p>
                    Categories
                  </p>
                </a>
              </li>  

              <li class="nav-item">
                <?php 
                  $activeCls = '';
                  if($active_link == 'company_list') {
                    $activeCls = 'active';
                  }
                ?> 
                <a href="{{ route('admin.companies') }}" class="nav-link {{ $activeCls }}">
                  <i class="nav-icon fas fa-list-alt"></i>
                  <p>
                    Companies
                  </p>
                </a>
              </li>          
              
              
              <li class="nav-item">
                <?php 
                  $activeCls = '';
                  if($active_link == 'model_list') {
                    $activeCls = 'active';
                  }
                ?> 
                <a href="{{ route('admin.car_models') }}" class="nav-link {{ $activeCls }}">
                  <i class="nav-icon fas fa-list-alt"></i>
                  <p>
                    Car Models
                  </p>
                </a>
              </li>                 


              <li class="nav-item">
                <?php 
                  $activeCls = '';
                  if($active_link == 'country_list') {
                    $activeCls = 'active';
                  }
                ?> 
                <a href="{{ route('admin.countries') }}" class="nav-link {{ $activeCls }}">
                  <i class="nav-icon fas fa-list-alt"></i>
                  <p>
                    Countries
                  </p>
                </a>
              </li>               

              <li class="nav-item">
                <?php 
                  $activeCls = '';
                  if($active_link == 'notification_list') {
                    $activeCls = 'active';
                  }
                ?> 
                <a href="{{ route('admin.notifications') }}" class="nav-link {{ $activeCls }}">
                  <i class="nav-icon fas fa-list-alt"></i>
                  <p>
                    Notifications
                  </p>
                </a>
              </li> 


              <li class="nav-item">
                <a href="{{ route('admin.logout') }}" class="nav-link">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>
                    Signout
                  </p>
                </a>
              </li>   

            </ul>
          </li>             


       
          
          
          
        
            

      
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      @yield('content')
  </div>
<!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="#">Maven</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="//code.jquery.com/jquery.js"></script>



<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('/public/dist/js/demo.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('/public/plugins/jquery-mousewheel/jquery.mousewheel.js') }} "></script>
<script src="{{ asset('/public/plugins/raphael/raphael.min.js') }} "></script>
<script src="{{ asset('/public/plugins/jquery-mapael/jquery.mapael.min.js') }} "></script>
<script src="{{ asset('/public/plugins/jquery-mapael/maps/usa_states.min.js') }} "></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }} "></script>

<!-- PAGE SCRIPTS -->
{{-- <script src="/public/dist/js/pages/dashboard2.js"></script> --}}

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- App scripts -->

<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


</body>
</html>
