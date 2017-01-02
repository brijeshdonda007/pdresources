<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div align="left"><h1> Welcome <?php echo $this->session->userdata('user_name'); ?></h1></div>
<div align="right"><a href="<?php echo site_url('home/logout'); ?>">Logout</a></div>
<div align="right"><a href="<?php echo site_url('user_manage/EditProfile'); ?>">Edit/Update Profile</a></div>
<div align="right"><a href="<?php echo site_url('user_manage/ChangePassword'); ?>">Change Password</a></div>
<form name="registration" id="registration" method="post" enctype="multipart/form-data">
	<div style="color:#0C6;"><?php echo $success; ?></div>
    <table width="50%" border="0">
       <tr>
        <td>User Name/Email :-</td>
        <td><input type="text" id="cust_email" name="cust_email" disabled="disabled" value="<?php echo $cust_email;?>" /></td>
        <td style="color:#F00;"></td>
      </tr>
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
        <td><input type="file" id="cust_avatar" name="cust_avatar" /><br />        	
        </td>
        <td style="color:#F00;"><?php echo form_error('cust_avatar'); ?>
			<?php if($cust_avatar !='') echo '<input type="hidden" name="pre_avatar_image" id="pre_avatar_image" value="'.$cust_avatar.'" />'; ?>
            	<img src="<?php echo base_url().$cust_avatar; ?>" height="75" width="75" />            
        </td>
      </tr>           
      <tr>    
        <td><input type="submit" id="submit" name="submit" value="Submit" />&nbsp;&nbsp;<input type="button" value="Back" class="submit_btn" onclick="javascript:history.go(-1);" /></td>
        <td> </td>
      </tr>    
    </table>
</form>
</body>
</html>