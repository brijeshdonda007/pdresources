<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="login" id="login" method="post">
    <div style="color:#F00;"><?php echo $error; ?></div>
    <div style="color:#0C6;"><?php echo $success; ?></div>
    <table width="40%" border="0">
       <tr>
         <td>Username :</td>
         <td><input type="text" name="uname" id="uname" value="<?php echo $username; ?>" /></td>
         <td style="color:#F00;"><?php echo form_error('uname'); ?></td>
       </tr>
       <tr>
         <td>Password :</td>
         <td><input type="password" name="passwd" id="passwd" /> </td>
         <td style="color:#F00;"><?php echo form_error('passwd'); ?></td>
       </tr>
       <tr>
         <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Log in" /></td>
         <td></td>
       </tr>
       <tr>       
         <td align="center"><a href="<?php echo site_url('register/forgetpasswd');?>">Forgot your password?</a></td>
         <td><a href="<?php echo site_url('register/');?>">Sign up for pdr</a></td>
         <td></td>
       </tr>
    </table>
</form>
</body>
</html>
