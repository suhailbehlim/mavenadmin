<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>maven - @yield('title')</title>


  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('/public/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }} ">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/public/dist/css/adminlte.min.css') }}">



  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('/public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }} ">



  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">




  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('/public/plugins/jqvmap/jqvmap.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  <!-- Bootstrap CSS -->
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">  

  <link rel="stylesheet" href="{{ asset('/public/assets/custom.css') }}">  
  

    </head>
<body class="hold-transition sidebar-mini layout-fixed">
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
   <center> <a href="#" class="brand-link">
      <img src="{{ asset('/public/dist/img/maven.png') }}" alt="maven-logo" height="50%" width="50%"> </a></center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/public/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{url('')}}/admin/updateProfile" class="d-block">Maven</a>
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
			<!-- <li class="nav-item">
				<?php 
					$activeCls = '';
					if($active_link == 'roles') {
					  $activeCls = 'active';
					}
				  ?>
				<a href="{{ route('admin.roles') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-user-circle"></i>
				  <p>
					roles
				  </p>
				</a>
			</li> -->
       
         <!--  <li class="nav-item">
            <?php
                $activeCls = '';
                if($active_link == 'student-list') {
                  $activeCls = 'active';
                }
              ?>
            <a href="{{ route('admin.customers') }}" class="nav-link {{ $activeCls }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Students
              </p>
            </a>
          </li> -->
			{{-- <li class="nav-item">
            <?php 
                $activeCls = '';
                if($active_link == 'educator-list') {
                  $activeCls = 'active';
                }
              ?>
            <a href="{{ route('admin.dealers') }}" class="nav-link {{ $activeCls }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Educators
              </p>
            </a>
          </li> --}}
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
        
        <a href="{{ route('admin.blogindex') }}" class="nav-link {{ $activeCls }}">
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
				  <i class="nav-icon fas fa-rocket"></i>
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
              Enquires			  </p>
				</a>
			</li> 
      <li class="nav-item">
        <?php 
          $activeCls = '';
          if($active_link == 'order') {
            $activeCls = 'active';
          }
          ?>
        <a href="{{ route('admin.order','order') }}" class="nav-link {{ $activeCls }}">
          <i class="nav-icon fas fa-address-book"></i>
          <p>
            Orders        </p>
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
				<a href="{{ route('admin.faqindex') }}" class="nav-link {{ $activeCls }}">
				  <i class="nav-icon fas fa-question"></i>
				  <p>
              FAQ				  </p>
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
      @yield('content')
  </div>


  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="#">Maven</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>
      
    <!-- jQuery -->
    <script src="//code.jquery.com/jquery.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('/public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>    
    
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>        


<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('/public/plugins/sparklines/sparkline.js') }}"></script>

<script src="{{ asset('/public/plugins/jqvmap/jquery.vmap.min.js') }}"></script>

<script src="{{ asset('/public/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>



<!-- jQuery Knob Chart -->
<script src="{{ asset('/public/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('/public/plugins/moment/moment.min.js') }}"></script>

<script src="{{ asset('/public/plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('/public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>


<!-- Summernote -->
<script src="{{ asset('/public/plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- overlayScrollbars -->
<script src="{{ asset('/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>


<!-- AdminLTE App -->
<script src="{{ asset('/public/dist/js/adminlte.js') }}"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
 -->
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/dist/js/demo.js') }}"></script>

        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- App scripts -->

        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
<script type="text/javascript" src="{{asset('/public/plugins/ckeditor/ckeditor.js')}}"></script>

 <!-- <script src="https://ckeditor.com/docs/vendors/4.18.0/ckeditor/ckeditor.js"></script> -->
 
    <script>
        CKEDITOR.replace('ckeditor', { 
           extraPlugins: 'autogrow,embed,uicolor,menubutton,colordialog,dialog,dialogui,panelbutton,floatpanel,panel,button,simplebutton,colorbutton',
          removePlugins: 'resize,widget,embedbase,embed',
          embed_provider : '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
          enterMode: CKEDITOR.ENTER_BR,
          
         
          filebrowserImageUploadUrl : "{{route('upload.image', ['_token' => csrf_token()])}}",
      filebrowserUploadMethod: 'xhr',
      //uploadUrl: '{{route('upload.image', ['_token' => csrf_token() ])}}',

          // Remove the redundant buttons from toolbar groups defined above.
          // removeButtons: 'Subscript,Superscript,Anchor,Styles,Specialchar',
        });
 var data = CKEDITOR.instances.description.getData();
    </script>
  
<script>
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
     var x = 1; //Initial field counter is 1
    var fieldHTML = '<div class="row "><div class="col-md-12 mt-3" style="margin-bottom: 10px;">  <div class="controls"> <input type="text" name="courseDetailsFaqquestion[]" class="form-control" placeholder="Question" required > </div></div><div class="col-md-12 mt-3" style="margin-bottom: 10px;"><div class="controls"><textarea onclick="addeditor('+x+')" id="Answereditor'+a+'" name="courseDetailsFaqanswer[]"  class="answer form-control ckeditor" required></textarea></div></div><div class="col-md-2"><div class="controls"><button class="remove_button"> Remove</button></div> </div></div>'; //New input field html 
   
    var fieldHTMLProgress = '<div class="row "><div class="col-md-12 mt-3" style="margin-bottom: 10px;">  <div class="controls"> <input type="text" name="question[]" class="form-control" placeholder="Question" required > </div></div><div class="col-md-12 mt-3" style="margin-bottom: 10px;"><div class="controls"><textarea onclick="addeditor('+x+')" id="Answereditor'+a+'" name="answer[]"  class="answer form-control ckeditor" required></textarea></div></div><div class="col-md-2"><div class="controls"><button class="remove_button"> Remove</button></div> </div></div>'; //New input field html 
    //Once add button is clicked
    $(addButton).click(function(){ 
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    $('.addButtonprogress').click(function(){ 
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTMLProgress); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        
        $(this).closest('.row').remove(); //Remove field html
        x--; //Decrement field counter
    });


});
var a =0;
function addeditor(){ 

 $('.answer:last-child').attr('id','last'+a);
CKEDITOR.replace('last'+a);
a++;
                            }
</script>

        @stack('scripts')
    </body>
</html>



