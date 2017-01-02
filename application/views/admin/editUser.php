<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/user/index/s'); ?>" class="root_link">User List</a>
  <span class="root_vr">/</span><span class="root_link_remove">Edit User</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;">Edit User</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" method="post">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
         
          	<tr>
              <td width="15%">User Email : <span class="error">*</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $user_email; ?>" name="user_email" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('user_email');?></td>
            </tr>
            <tr>
              <td>User Name : <span class="error">*</span></td>
              <td align="left" valign="top"><input type="text" class="input" name="user_name" value="<?php echo $user_name; ?>" /></td>
              <td align="left" valign="top" class="error"><?php echo form_error('user_name');?></td>
            </tr>
            <tr>
              <td>password : <span class="error">*</span></td>
              <td align="left" valign="top"><input type="password" class="input" name="password" value="<?php echo $password; ?>" /></td>
              <td align="left" valign="top" class="error"><?php echo form_error('password');?></td>
            </tr>
            <tr>
              <td>Re-type Password : <span class="error">*</span></td>
              <td align="left" valign="top"><input type="password" class="input" name="retypePassword" value="<?php echo $retypePassword; ?>" /></td>
              <td align="left" valign="top" class="error"><?php echo form_error('retypePassword');?></td>
            </tr>
            <tr>
              <td>Birth Date : <span class="error">*</span></td>
              <td align="left" valign="top"><input type="text" class="input" name="birth_date" value="<?php echo $birth_date; ?>" id="birth_date" /></td>
              <td align="left" valign="top" class="error"><?php echo form_error('birth_date');?></td>
            </tr>
            <tr>
              <td>Gender : <span class="error">*</span></td>
              <td align="left" valign="top">
                <?php 
					if($gender == "Male")
						$male = 'checked = "checked"';
					else if($gender == "Female")
						$female = 'checked = "checked"';
				?>
              	Male <input type="radio" name="gender" value="Male" <?php echo $male; ?> /> &nbsp;
                Female <input type="radio" name="gender" value="Female" <?php echo $female; ?> />
              </td>
              <td align="left" valign="top" class="error"><?php echo form_error('gender');?></td>
            </tr>
            <tr>
              <td>Is admin user: </td>
              <td align="left" valign="top">
              	<input type="checkbox" name="is_admin_user" value="Y" <?php if($is_admin == 'Y'){ echo 'checked="checked"';}?>  />
              </td>
            </tr>
            <tr>
              <td><input type="hidden" name="editUser" value="edit" /><input type="hidden" name="user_id" value="<?php echo $id; ?>" /></td>
              <td align="left" valign="top">
              	<input type="submit" name="submit" class="submit_btn" value="Submit" />
                <input type="button" value="Back" class="submit_btn" onclick="javascript:history.go(-1);" />
              </td>
              <td align="left" valign="top"></td>
            </tr>
           </table>
          </form>
      </div>
  </div>
  <!--End [ Right Nav ]-->
  
  <div class="clear"></div>
</div>
<!-- End [ Page ]-->

<script type="text/javascript">
	$(function(){	$("#birth_date").datepicker({changeMonth: true,changeYear: true,dateFormat:'mm-dd-yy',showOn:'button',buttonImageOnly:true,buttonImage:'<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});	 });
</script>