<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin panel</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin/default.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>js/calendar/jquery-ui-1.8.2.custom.css" />

<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin/ie6.css" media="all" /><![endif]-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tablesorter.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/artoon_ready.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/artoon_function.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendar/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tiny_mce/jquery.tinymce.js"></script>
<?php  if($is_autofill){ ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/jquery.tokeninput.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin/token-input-facebook.css" />
<?php } ?>
</head>

<body>
<center>
  <!--Start [ Layout ]-->
  <div class="layout">
    <!--Start [ Logo Space ]-->
    <div class="site_top">
      <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="logo" title="Artoon Solutions"></a>
      <div class="login_info_space">
      	<strong style="padding-right:2px;">Welcome, </strong>
        <span class="login_name"><?php echo $this->session->userdata('user_name'); ?>  <img src="<?php echo base_url(); ?>images/admin/logout_arrow.png" width="10" height="10" alt="logout_arrow" class="logout_img" /></span>
        <div class="logout_block_space">
          
          <a href="<?php echo site_url('admin/admin/change_pwd'); ?>" class="logout_link">Change Password</a>
          <a href="<?php echo site_url('admin/admin/logout'); ?>" class="logout_link">Logout</a>
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <!--End [ Logo Space ]-->
    <!--Start [ Nav ]-->
    <div class="menu_nav">
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/user/index/s'); ?>" class="menu_nav_item">Users</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/user/addUser'); ?>" class="menu_nav_box_link">add User</a>
          <a href="<?php echo site_url('admin/user/index/s'); ?>" class="menu_nav_box_link">User List</a>
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/customer/index/s'); ?>" class="menu_nav_item">Customer</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/customer/addCustomer'); ?>" class="menu_nav_box_link">Add Customer</a>
          <a href="<?php echo site_url('admin/customer/index/s'); ?>" class="menu_nav_box_link">Customer List</a>                   
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/config/index/s'); ?>" class="menu_nav_item">Configration</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/config/addConfig'); ?>" class="menu_nav_box_link">Add Configration</a>
          <a href="<?php echo site_url('admin/config/index/s'); ?>" class="menu_nav_box_link">Configration List</a>                   
        </div>
      </div>
       <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/page/index/s'); ?>" class="menu_nav_item">Cms Page</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/page/addPage'); ?>" class="menu_nav_box_link">Add Page</a>
          <a href="<?php echo site_url('admin/page/index/s'); ?>" class="menu_nav_box_link">Page List</a>                   
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/pramotion/index/s'); ?>" class="menu_nav_item">Promotions</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/pramotion/addPramotion'); ?>" class="menu_nav_box_link">Add Home Page Pramotions</a>
          <a href="<?php echo site_url('admin/pramotion/index/s'); ?>" class="menu_nav_box_link">Home Page Pramotions List</a>                   
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/profession/index/s'); ?>" class="menu_nav_item">Profession</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/profession/addProfession'); ?>" class="menu_nav_box_link">Add Profession</a>
          <a href="<?php echo site_url('admin/profession/index/s'); ?>" class="menu_nav_box_link">Profession List</a>
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="javascrit:void(0);" class="menu_nav_item">Basic Infomation</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/state/index/s'); ?>" class="menu_nav_box_link">State List</a>
          <a href="<?php echo site_url('admin/city/index/s'); ?>" class="menu_nav_box_link">City List</a>
          <a href="<?php echo site_url('admin/zipcode/index/s'); ?>" class="menu_nav_box_link">ZipCode List</a>
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/course/index/s'); ?>" class="menu_nav_item">Course</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/course/addCourse'); ?>" class="menu_nav_box_link">Add Course</a>
          <a href="<?php echo site_url('admin/course/index/s'); ?>" class="menu_nav_box_link">Course List</a>       
          <a href="<?php echo site_url('admin/courseobjective/index/s'); ?>" class="menu_nav_box_link">Course Objectives</a>                             
          <a href="<?php echo site_url('admin/author/index/s'); ?>" class="menu_nav_box_link">Author</a>     
          <a href="<?php echo site_url('admin/accreditations/index/s'); ?>" class="menu_nav_box_link">Accreditations</a>              
          <a href="<?php echo site_url('admin/coupon/index/s'); ?>" class="menu_nav_box_link">Coupon</a>                   
        </div>
      </div>
      
       <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/employee/index/s'); ?>" class="menu_nav_item">Employee</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/employee/addEmployee'); ?>" class="menu_nav_box_link">Add Employee</a>
          <a href="<?php echo site_url('admin/employee/index/s'); ?>" class="menu_nav_box_link">Employee List</a>                   
        </div>
      </div>
       
      
<!--      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/author/index/s'); ?>" class="menu_nav_item">Author</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/author/addAuthor'); ?>" class="menu_nav_box_link">Add Author</a>
          <a href="<?php echo site_url('admin/author/index/s'); ?>" class="menu_nav_box_link">Author List</a>                   
        </div>
      </div>
-->	<!-- <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/accreditations/index/s'); ?>" class="menu_nav_item">Accreditations</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/accreditations/addAccreditations'); ?>" class="menu_nav_box_link">Add Accreditations</a>
          <a href="<?php echo site_url('admin/accreditations/index/s'); ?>" class="menu_nav_box_link">Accreditations List</a>                   
        </div>
      </div>-->
	 <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/certificate/index/s'); ?>" class="menu_nav_item">Certificate</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/certificate/addCertificate'); ?>" class="menu_nav_box_link">Add Certificate</a>
          <a href="<?php echo site_url('admin/certificate/index/s'); ?>" class="menu_nav_box_link">Certificate List</a>                   
        </div>
      </div>
	 <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/test/index/s'); ?>" class="menu_nav_item">Test Builder</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/test/addTest'); ?>" class="menu_nav_box_link">Add Test</a>
          <a href="<?php echo site_url('admin/test/index/s'); ?>" class="menu_nav_box_link">Test List</a>                   
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/evaluation/index/s'); ?>" class="menu_nav_item">Evaluations</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/evaluation/addEvaluation'); ?>" class="menu_nav_box_link">Add Evaluations</a>
          <a href="<?php echo site_url('admin/evaluation/index/s'); ?>" class="menu_nav_box_link">Evaluations List</a>                   
        </div>
      </div>
     <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/order/index/s'); ?>" class="menu_nav_item">Order</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/order/index/s'); ?>" class="menu_nav_box_link">Order List</a>
        </div>
      </div>
    
     
    </div>
    <!--End [ Nav ]-->