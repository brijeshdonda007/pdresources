<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/state/index/s'); ?>" class="root_link">State List</a>
  <span class="root_vr">/</span><span class="root_link_remove">Edit State</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;">Edit State</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" method="post">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	<tr>
              <td width="15%">State Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $state_name; ?>" name="state_name" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('state_name');?></td>
            </tr>
            <tr>
              <td width="15%">State Code : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" maxlength="2" value="<?php echo $state_code; ?>" name="state_code" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('state_code');?></td>
            </tr>           
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
              	<input type="hidden" name="state_id" value="<?php echo $state_id;?>" />
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
