<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Maven | Admin Dashboard </title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="resources\css\app.css">
  <link rel="stylesheet" href="{{url('/public')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('/public')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/public')}}/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheetr
  <!----- Google Font : monsterrat  ----->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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

   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
   <center> <a href="" class="brand-link">
<img src="{{ asset('/public/dist/img/maven.png') }}" alt="maven-logo" height="50%" width="50%"> </a></center>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('/public')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Hi Maven</a>
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
            <?php 
                $activeCls = '';
                if($active_link == 'courses-list') {
                  $activeCls = 'active';
                }
              ?>
            <a href="{{ route('admin.courses') }}" class="nav-link {{ $activeCls }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Courses
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
				<a href="{{ route('admin.categoryList') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-list-alt"></i>
				  <p>
					Categories
				  </p>
				</a>
			</li>
      <li class="nav-item">
        <?php 
        $activeCls = '';
        if($active_link == 'blog') {
          $activeCls = 'active';
        }
        ?>
				<a href="{{ route('admin.blogindex') }}" class="nav-link  ">
				  <i class="nav-icon fas fa-blog"></i>
				  <p>
					Blog
				  </p>
				</a>
			</li>
      <li class="nav-item">
				<?php 
				  $activeCls = '';
				  if($active_link == 'Blog_category') {
					$activeCls = 'active';
				  }
				?> 
				<a href="{{ route('admin.blogcategories') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-list-alt"></i>
				  <p>
					Blog Categories
				  </p>
				</a>
			</li>
       <li class="nav-item">
        <?php 
          $activeCls = '';
          if($active_link == 'cms_section') {
          $activeCls = 'active';
          }
        ?> 
        <a href="{{ route('admin.cms-section') }}" class="nav-link {{ $activeCls }}">
          <i class="nav-icon fas fa-list-alt"></i>
          <p>
          CMS Section
          </p>
        </a>
      </li>
      <li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'freeVLSI') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.vlsiList') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-rocket "></i>
				  <p>
					Free VLSI resources
				  </p>
				</a>
			</li>
      <li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'workshoplist') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.workshopindex') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-brain "></i>
				  <p>
					Free VLSI Workshop
				  </p>
				</a>
			</li>
      <li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'career_list') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.careerlist') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-briefcase"></i>
				  <p>
					Career
				  </p>
				</a>
			</li>
      <li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'testomonialList') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.testomonialList') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-quote-right"></i>
				  <p>
					Testimonial
				  </p>
				</a>
			</li>
      <li class="nav-item">
        <?php 
          $activeCls = '';
          if($active_link == 'partnerList') {
            $activeCls = 'active';
          }
          ?>
        <a href="{{ route('admin.partner') }}" class="nav-link {{ $activeCls }}">
          <i class="nav-icon fas fa-users"></i>
          <p>
          Partners
          </p>
        </a>
      </li>
       <li class="nav-item">
        <?php 
          $activeCls = '';
          if($active_link == 'placement_update') {
            $activeCls = 'active';
          }
          ?>
        <a href="{{ route('admin.placement') }}" class="nav-link {{ $activeCls }}">
          <i class="nav-icon fas fa-star"></i>
          <p>
          Placement 
          </p>
        </a>
      </li>
       <li class="nav-item">
        <?php 
          $activeCls = '';
          if($active_link == 'features') {
            $activeCls = 'active';
          }
          ?>
        <a href="{{ route('admin.features') }}" class="nav-link {{ $activeCls }}">
          <i class="nav-icon fas fa-brain"></i>
          <p>
          Features 
          </p>
        </a>
      </li>
       <li class="nav-item">
        <?php 
          $activeCls = '';
          if($active_link == 'programme') {
            $activeCls = 'active';
          }
          ?>
        <a href="{{ route('admin.programme') }}" class="nav-link {{ $activeCls }}">
          <i class="nav-icon fas fa-book"></i>
          <p>
          Programme Offer
          </p>
        </a>
      </li>
       <li class="nav-item">
        <?php 
          $activeCls = '';
          if($active_link == 'our progress') {
            $activeCls = 'active';
          }
          ?>
        <a href="{{ route('admin.ourprogress') }}" class="nav-link {{ $activeCls }}">
          <i class="nav-icon fas fa-book"></i>
          <p>
          our progress
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
          if($active_link == 'course_cataloge') {
            $activeCls = 'active';
          }
          ?>
        <a href="{{ route('admin.course_cataloge') }}" class="nav-link {{ $activeCls }}">
          <i class="nav-icon fas fa-images"></i>
          <p>
          Course Cataloge
          </p>
        </a>
      </li>
      <li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'contactus') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.enquiryindex') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-address-book"></i>
				  <p>
              Enquiries		  </p>
				</a>
			</li>
			
			 <li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'subscriber') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.subsindex') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-address-book"></i>
				  <p>
              Subscribers			  </p>
				</a>
			</li>
			
      <li class="nav-item">
        <?php 
        $activeCls = '';
        if($active_link == 'FAQ') {
          $activeCls = 'active';
        }
        ?>
				<a href="{{ route('admin.faqindex') }}" class="nav-link  ">
				  <i class="nav-icon fas fa-question"></i>
				  <p>
					FAQ
				  </p>
				</a>
			</li>
     
			
          <?php 
            if($active_link == 'change_password' || $active_link == 'update_profile' || $active_link == "update_charges" || $active_link  =="notification_list"  ) {
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

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Admin Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">


      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>    
          <strong>{{ $message }}</strong>
      </div>
      @endif
        
      @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>    
          <strong>{{ $message }}</strong>
      </div>
      @endif



      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Students</span>
                <span class="info-box-number">
                  {{ $totalCustomers }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          {{-- <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Educators</span>
                <span class="info-box-number">{{ $totalDealers }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div> --}}
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Categories</span>
                <span class="info-box-number">{{$totalCat}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Courses</span>
                <span class="info-box-number">{{$totalCour}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
		  <div class="clearfix hidden-md-up"></div>
		  <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-dark elevation-1"><i class="fas fa-blog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Blog</span>
                <span class="info-box-number">
                  {{ $totalblog }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
       
        
        <div class="row">
     
          

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-briefcase"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Career</span>
                <span class="info-box-number">{{$totalCareer}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-quote-right"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Testimonial</span>
                <span class="info-box-number">{{$totaltest}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        
      </div><!--/. container-fluid -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="#"> Maven</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{url('/public')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{url('/public')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{url('/public')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/public')}}/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{url('/public')}}/dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{url('/public')}}/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="{{url('/public')}}/plugins/raphael/raphael.min.js"></script>
<script src="{{url('/public')}}/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="{{url('/public')}}/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="{{url('/public')}}/plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
{{-- <script src="{{url('/public')}}/dist/js/pages/dashboard2.js"></script> --}}
</body>
</html>