<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/coupon/index/s'); ?>" class="root_link">Coupon List</a>
  <span class="root_vr">/</span><span class="root_link_remove">Add Coupon</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;">Add Coupon</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" method="post">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	<tr>
              <td width="15%">Coupon Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $coupon_name; ?>" name="coupon_name" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('coupon_name');?></td>
            </tr>
            <tr>
              <td width="15%">Coupon Code : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $coupon_code; ?>" name="coupon_code" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('coupon_code');?></td>
            </tr>
            <tr>
              <td width="15%">Users : </td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $coupon_users; ?>" name="coupon_users" id="coupon_users" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('coupon_users');?></td>
            </tr>
            <tr>
              <td width="15%">Item : </td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $coupon_course; ?>" name="coupon_course" id="coupon_course" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('coupon_name');?></td>
            </tr>
			<tr>
              <td width="15%"> Type? <span class="star"> *</span></td>
              <?php
			  	$yes=$no='';			  
					if($coupon_type == 'Percentage')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Fix" name="coupon_type" <?php echo $no;?> />Fix</label><label><input type="radio" style="width:20px !important;"  value="Percentage" name="coupon_type" <?php echo $yes;?>/>Percentage</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>            
            <tr>
              <td width="15%">Amount/Percentage : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $coupon_discount_amt; ?>" name="coupon_discount_amt" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('coupon_discount_amt');?></td>
            </tr>
            <tr>
              <td width="15%">Expiry Date : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $coupon_expiry_date; ?>" name="coupon_expiry_date" id="coupon_expiry_date" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('coupon_expiry_date');?></td>
            </tr>           
			<tr>
              <td width="15%">Usage Limit : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $coupon_usage_limit; ?>" name="coupon_usage_limit" /></td>
              <td width="60%" align="left" valign="top" class="error">(Leave blank or 0 for the unlimited usage)<?php echo form_error('coupon_usage_limit');?></td>
            </tr>
            <tr>
              <td width="15%"> Is active? <span class="star"> *</span></td>
              <?php
			  	$yes=$no='';			  
					if($coupon_status == 'draft')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="publish" name="coupon_status" <?php echo $no;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="draft" name="coupon_status" <?php echo $yes;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>            
            <tr>
              <td>&nbsp;</td>
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
	$(function(){	$("#coupon_expiry_date").datepicker({changeMonth: true,changeYear: true,dateFormat:'yy-mm-dd',showOn:'button',buttonImageOnly: true,yearRange: '1900:<?php echo date('Y')+10; ?>',buttonImage: '<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});
		 });
		$(document).ready(function() {  $("#coupon_users").tokenInput("<?php echo site_url('admin/coupon/GetUser'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,//tokenLimit: 1,
														<?php if($user_arr){ ?>
														prePopulate: <?php echo $user_arr;  } ?>
													});	
									$("#coupon_course").tokenInput("<?php echo site_url('admin/coupon/GetCourse'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,//tokenLimit: 1,
														<?php if($course_arr){ ?>
														prePopulate: <?php echo $course_arr;  } ?>
													});	
			});
</script>