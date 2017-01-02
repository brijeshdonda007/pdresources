<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="registration" id="registration" method="post" enctype="multipart/form-data">
	<div style="color:#0C6;"><?php echo $success; ?></div>
    <table width="30%" border="0">
      <tr>
        <td>Password :-</td>
        <td><input type="password" id="cust_passwd" name="cust_passwd" /></td>
        <td style="color:#F00;"><?php echo form_error('cust_passwd'); ?></td>
      </tr>
      <tr>
        <td>Confirm Password :-</td>
        <td><input type="password" id="cust_cpasswd" name="cust_cpasswd" /></td>
        <td style="color:#F00;"><?php echo form_error('cust_cpasswd'); ?></td>
      </tr>
      <tr>    
        <td><input type="submit" id="submit" name="submit" value="Submit" /></td>
        <td> </td>
      </tr>    
    </table>
</form>
</body>
</html>