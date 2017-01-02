<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin panel</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin/default.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>js/calendar/jquery-ui-1.8.2.custom.css" />

<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin/ie6.css" media="all" /><![endif]-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.5.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tablesorter.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/artoon_ready.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/artoon_function.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendar/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tiny_mce/jquery.tinymce.js"></script>
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
        <a href="<?php echo site_url('admin/profession/index/s'); ?>" class="menu_nav_item">Profession</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/profession/addProfession'); ?>" class="menu_nav_box_link">Add Profession</a>
          <a href="<?php echo site_url('admin/profession/index/s'); ?>" class="menu_nav_box_link">Profession List</a>
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/state/index/s'); ?>" class="menu_nav_item">State</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/state/addState'); ?>" class="menu_nav_box_link">Add State</a>
          <a href="<?php echo site_url('admin/state/index/s'); ?>" class="menu_nav_box_link">State List</a>
        </div>
      </div>
      <span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/course/index/s'); ?>" class="menu_nav_item">Course</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/course/addCourse'); ?>" class="menu_nav_box_link">Add Course</a>
          <a href="<?php echo site_url('admin/course/index/s'); ?>" class="menu_nav_box_link">Course List</a>                   
        </div>
      </div>
      <!--<span class="menu_nav_vr"></span>
      <div class="menu_nav_list">
        <a href="<?php echo site_url('admin/test/index/s'); ?>" class="menu_nav_item">Test</a>
        <div class="menu_nav_box">
          <a href="<?php echo site_url('admin/test/addTest'); ?>" class="menu_nav_box_link">Add Test</a>
          <a href="<?php echo site_url('admin/test/index/s'); ?>" class="menu_nav_box_link">Test List</a>                   
        </div>
      </div>-->
     
    </div>
    <!--End [ Nav ]-->