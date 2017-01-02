<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>home page</title>
<style type="text/css">
body, div, ol, ul, li, a, form, span, p, h1, h2, h3, h4, h5, h6 {
	margin : 0;
	padding : 0;
}
body {
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size : 12px;
	font-weight : normal;
	background : #f2f2f2;
	position : relative;
	z-index : 0;
}
.clear {
	clear : both;
}
.a {
	cursor : pointer;
}
.login_layout {
	width:570px;
	margin:15% auto;
	text-align:left;
}

.login_layout_left {
	width:170px;
	height:100%;
	text-align:center;
	border-right:#e1e1e1 1px solid;
}
.login_layout_right {
	width:400px;
}

.login_logo_space {
	padding:0 0 10px 20px;
}
.powered {
	color:#646464;
	padding:10px 10px 10px 10px;
	bottom:0px;
	text-shadow:#fff 0px 1px 0px;
}
.powered a {
	color:#447099;
	text-decoration:none;
}
.login_bg {
	box-shadow:#dedede 0px 1px 2px 0px;
	border:#e1e1e1 1px solid;
	border-top:#c4c4c4 1px solid;
	border-bottom:#c4c4c4 1px solid;
	color:#333;
	padding-bottom:10px;
	background-color:#fff;
	border-radius:5px;
	-khtml-border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	-o-border-radius:5px;
	-ms-border-radius:5px;
}
.login_title {
	background:url(<?php echo base_url(); ?>images/admin/login_header.jpg) repeat-x 0 0;
	padding:7px 20px 22px 20px;
	font-size:15px;
	text-shadow:#fff 0px 1px 0px;
	border-top-left-radius:5px;
	border-top-right-radius:5px;
	-webkit-border-top-left-radius:5px;
	-webkit-border-top-right-radius:5px;
	-moz-border-top-left-radius:5px;
	-moz-border-top-right-radius:5px;
	-o-border-top-left-radius:5px;
	-o-border-top-right-radius:5px;
	-ms-border-top-left-radius:5px;
	-ms-border-top-right-radius:5px;
	-khtml-border-top-left-radius:5px;
	-khtml-border-top-right-radius:5px;
}
.login_table {
	vertical-align:baseline;
	text-align:left;
}
.login_table td {
	padding-top:7px;
	padding-bottom:7px;
}
.login_label {
	height:40px;
	padding-left:26px;
	width:90px;
	font-size:13px;
	font-weight:bold;
}
.login_label_2 {
	height:40px;
	padding-left:26px;
	padding-top:7px;
	text-align:right;
	font-size:13px;
	font-weight:bold;
}
.login_imput {
	width:244px;
	height:24px;
	line-height:24px;
	border:#abadb3 1px solid;
}
.login_error {
	text-align:center;
	color:#cc0000;
	line-height:150%;
	display:block;
}
.login_forgot {
	color:#0088cc;
	text-decoration:none;
	float:left;
}
.login_submit {
	background:url(<?php echo base_url(); ?>images/admin/login_btn.png) no-repeat 0 0;
	height:22px;
	width:76px;
	border:none;
	cursor:pointer;
	margin-right:36px;
}
</style>
</head>
<body>
<center>
  <!--Start [ Login ]-->
  <div class="login_layout">
    <div class="login_bg">
     <div class="login_title">Sign in to the Member Center</div>
     
   <table cellpadding="0" cellspacing="0" border="0" style="width:100%;"><tr><td class="login_layout_left"><a href="http://artoonsolutions.com" title="Artoon Solutions Pvt. Ltd."><img src="<?php echo base_url(); ?>images/admin/logo.png" width="77" height="99" alt="Logo" style="border:none;" /></a></td>
    <td class="login_layout_right">
     
      <form name="form_login" action="" method="post" class="login_form">
        <span class="login_error" style="display:block;"><?php if(isset($error)) { echo $error; } ?></span>
        <table class="login_table" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td class="login_label"> User Name : </td>
            <td><input type="text" value="<?php echo $username; ?>" name="username" id="username" class="login_imput" /></td>
          </tr>
          <tr>
            <td class="login_label"> Password : </td>
            <td><input type="password" value="<?php echo $password; ?>" name="password" class="login_imput" /></td>
          </tr>
        </table>
        <div class="login_label_2">         
          <input type="submit" value="" name="btn_submit" class="login_submit" />
          <div class="clear"></div>
        </div>
      </form>
      </td>
     </tr></table>
    </div>
    <div class="powered">Powered By :
      <a href="http://artoonsolutions.com">Artoon Solutions Pvt. Ltd.</a>
    </div>
  </div>
  <script type="text/javascript">
  	document.getElementById('username').focus();
  </script>
  <!--End [ Login ]-->
</center>
</body>
</html>

