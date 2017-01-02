<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><span class="root_link_remove">Change Password</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->



<!-- Start [ Page ]-->
<div class="page">
  
  <!--Start [ Left Nav ]-->
  <div class="left_nav">
    <div class="left_nav_space"></div>
  </div>
  <!--End [ Left Nav ]-->
  
  
  <!--Start [ Right Nav ]-->
  <div class="right_nav">
    <h2>Change Password</h2>
    <div class="login_work_area">
    <div class="clear"></div>
        <form name="frmchkpwd" action="<?php echo base_url();?>admin/admin/change_pwd" method="post">
          <table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td colspan="3" class="message"><?php if($error) echo $error;?></td>
            </tr>
            <tr>
              <td width="16%">Old Password : <span class="message">*</span></td>
              <td width="15%" align="left" valign="top"><input type="password" class="textbox" value="<?php echo $oldPassword; ?>" name="oldPassword" id="oldPassword"  /></td>
              <td width="69%" align="left" valign="top" class="message"><?php echo form_error('oldPassword');?></td>
            </tr>
            <tr>
              <td width="16%">New Password : <span class="message">*</span></td>
              <td align="left" valign="top"><input type="password" class="textbox" name="newPassword" value="<?php echo $newPassword; ?>" /></td>
              <td align="left" valign="top" class="message"><?php echo form_error('newPassword');?></td>
            </tr>
            <tr>
              <td width="16%">Retype Password : <span class="message">*</span></td>
              <td align="left" valign="top"><input type="password" class="textbox" name="retypePassword" value="<?php echo $retypePassword; ?>" /></td>
              <td align="left" valign="top" class="message"><?php echo form_error('retypePassword');?></td>
            </tr>
            <tr>
              <td width="16%" >&nbsp;</td>
              <td align="left" valign="top"><input type="submit" name="submit" class="btn_login_form" value="Submit" /></td>
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