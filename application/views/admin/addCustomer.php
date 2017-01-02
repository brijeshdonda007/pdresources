<?php
	$flag=true;
	if($cust_id =='')
		$flag=false;
?>
<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/customer/index/s'); ?>" class="root_link">Customer List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Customer</span>
  <div class="clear"></div>
</div>

<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Customer</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	<tr>
              <td width="15%">First Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $cust_fname; ?>" name="cust_fname" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('cust_fname');?></td>
            </tr>
            <tr>
              <td width="15%">Last Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $cust_lname; ?>" name="cust_lname" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('cust_lname');?></td>
            </tr>
            <tr>
        	  <td width="15%">Profession :-</td>
	          <td width="25%" align="left" valign="top"> <?php echo form_dropdown('cust_profession',$profession,$cust_profession,'style="width:150px"'); ?></td>
		      <td width="60%" align="left" valign="top" class="error"><?php echo form_error('cust_profession'); ?></td>
      		</tr>
             <tr>
              <td width="15%">Address : </td>
              <td width="25%" align="left" valign="top"><textarea name="cust_address" class="textarea"><?php echo $cust_address;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('cust_address'); ?></td>
            </tr>
            <tr>
        	  <td width="15%">State :-</td>
	          <td width="25%" align="left" valign="top"> <?php echo form_dropdown('cust_state',$state,$cust_state,'style="width:150px"'); ?></td>
		      <td width="60%" align="left" valign="top" class="error"><?php echo form_error('cust_state'); ?></td>
      		</tr>
            <tr>
              <td width="15%">Image : </td>
              <td width="25%" align="left" valign="top"><input type="file" id="cust_avatar" name="cust_avatar" /></td>
              <td width="60%" align="left" valign="top" class="error">
			  	<?php echo form_error('cust_avatar'); ?>
					<?php if($cust_avatar !='') echo '<input type="hidden" name="pre_avatar_image" id="pre_avatar_image" value="'.$cust_avatar.'" />'; ?>
                        <img src="<?php echo base_url().$cust_avatar; ?>" height="75" width="75" />
              </td>
            </tr>
             <tr>
        		<td width="15%">User name/Email :- <?php if(!$flag) echo '<span class="star"> *</span>'; ?></td>
		        <td width="25%" align="left" valign="top"><input type="text" id="cust_email" class="input" name="cust_email" value="<?php echo $cust_email;?>" <?php if($flag) echo 'disabled="disabled"'; ?>  /></td>
        		<td width="60%" align="left" valign="top" class="error"><?php echo form_error('cust_email'); ?></td>
		     </tr>
             <tr>
              <td width="15%">Password : <?php if(!$flag) echo '<span class="star"> *</span>'; ?></td>
              <td width="25%" align="left" valign="top"><input type="password" id="cust_passwd" name="cust_passwd" class="input" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('cust_passwd'); ?></td>
            </tr>
            <tr>
              <td width="15%">Confirm Password : <?php if(!$flag) echo '<span class="star"> *</span>'; ?></td>
              <td width="25%" align="left" valign="top"><input type="password" id="cust_cpasswd" name="cust_cpasswd" class="input" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('cust_cpasswd'); ?></td>
            </tr>           
              <td width="15%"> Is active user? <span class="star"> *</span></td>
              <?php
					if($is_active == 'Y')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Y" name="is_active" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="N" name="is_active" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>                  
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
	            <?php if($flag) echo '<input type="hidden" name="cust_id" class="submit_btn" value="'.$cust_id.'" />'; ?>
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
