<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="registration" id="registration" method="post" enctype="multipart/form-data">
    <table width="50%" border="0">
      <tr>
        <td>First Name :-</td>
        <td><input type="text" id="cust_fname" name="cust_fname" value="<?php echo $cust_fname;?>" /></td>
        <td style="color:#F00;"><?php echo form_error('cust_fname'); ?></td>
      </tr>
      <tr>
        <td>Last Name :-</td>
        <td><input type="text" id="cust_lname" name="cust_lname" value="<?php echo $cust_lname;?>" /></td>
        <td style="color:#F00;"><?php echo form_error('cust_lname'); ?></td>
      </tr>
      <tr>
        <td>Profession :-</td>
        <td> <?php echo form_dropdown('cust_profession',$profession,$cust_profession,'style="width:150px"'); ?></td>
        <td style="color:#F00;"><?php echo form_error('cust_profession'); ?></td>
      </tr>
      <tr>
        <td>Address :-</td>
        <td><textarea name="cust_address" id="cust_address"><?php echo $cust_address;?></textarea></td>
        <td style="color:#F00;"><?php echo form_error('cust_address'); ?></td>
      </tr>
      <tr>
        <td>State :-</td>
        <td> <?php echo form_dropdown('cust_state',$state,$cust_state,'style="width:150px"'); ?></td>
        <td style="color:#F00;"><?php echo form_error('cust_state'); ?></td>
      </tr>
      <tr>
        <td>Image :-</td>
        <td><input type="file" id="cust_avatar" name="cust_avatar" /></td>
        <td style="color:#F00;"><?php echo form_error('cust_avatar'); ?></td>
      </tr>
      <tr>
        <td>Email :-</td>
        <td><input type="text" id="cust_email" name="cust_email" value="<?php echo $cust_email;?>" /></td>
        <td style="color:#F00;"><?php echo form_error('cust_email'); ?></td>
      </tr>
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
        <td><input type="submit" id="submit" name="submit" value="Submit" />&nbsp;&nbsp;<input type="button" value="Back" class="submit_btn" onclick="javascript:history.go(-1);" /></td>
        <td> </td>
      </tr>    
    </table>
</form>
</body>
</html>