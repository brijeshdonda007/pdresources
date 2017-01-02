<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php if($this->session->userdata('cust_fb_profile_id') == 0){ ?>
 <div id="fb-root"></div>
      <script type="text/javascript">
		  window.fbAsyncInit = function() {
			  FB.init({appId: '195629827130936', status: true, cookie: true, xfbml: true});
		
			  /* All the events registered */
			  FB.Event.subscribe('auth.login', function(response) {
				  // do something with response
				  login();
			  });
			  FB.Event.subscribe('auth.logout', function(response) {
				  // do something with response
				  //logout();
			  });
		
			  FB.getLoginStatus(function(response) {
				  if (response.session) {
					  // logged in and connected user, someone you know
					  login();
				  }
			  });
		  };
		  (function() {
			  var e = document.createElement('script');
			  e.type = 'text/javascript';
			  e.src = document.location.protocol +
				  '//connect.facebook.net/en_US/all.js';
			  e.async = true;
			  document.getElementById('fb-root').appendChild(e);
		  }());
		  
		  function login()
		  {
			  FB.api('/me', function(response) {
				  window.location = "<?php echo site_url('user_manage/UpdateFacebookId'); ?>/"+response.id;
				  	//alert(response.id);				  	
				  });
		  }		
		</script>
<?php } ?>
</head>

<body>
<div align="left"><h1> Welcome <?php echo $this->session->userdata['user_name']; ?></h1></div>
<div align="right"><a href="<?php echo site_url('home/logout'); ?>">Logout</a></div>
<div align="right"><a href="<?php echo site_url('user_manage/EditProfile'); ?>">Edit/Update Profile</a></div>
<div align="right"><a href="<?php echo site_url('user_manage/ChangePassword'); ?>">Change Password</a></div>
<div align="right"><a href="<?php echo site_url('test/'); ?>">Give Test</a></div>
<?php if($this->session->userdata('cust_fb_profile_id') == 0) {?><div align="right"><fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,user_about_me,publish_stream"></fb:login-button></div>
<?php } ?>
<?php if($this->session->userdata('cust_lnk_profile_id') != 0) {?><div align="right"><a href="<?php echo site_url().'library/demo.php'; ?>">Linked in Login</a></div>
<?php } ?>
</body>
</html>