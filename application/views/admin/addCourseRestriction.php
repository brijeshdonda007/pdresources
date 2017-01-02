
<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/course/index/s'); ?>" class="root_link">Course List</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/course/profession/'); ?>" class="root_link">Course Restriction List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if($course_pro_id=='') echo 'Add';else echo 'Edit';  ?> Course Restriction</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if($course_pro_id=='') echo 'Add';else echo 'Edit';  ?> Course Restriction</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">             

           <tr>
              <td width="15%"> Profession : </td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $restriction_profession; ?>" name="restriction_profession" id="restriction_profession" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('restriction_profession');?></td>
            </tr>          
          <tr>
              <td width="15%"> City : </td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $restriction_city; ?>" name="restriction_city" id="restriction_city" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('restriction_city');?></td>
           </tr>      
            <tr>
              <td width="15%"> State : </td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $restriction_state; ?>" name="restriction_state" id="restriction_state" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('restriction_state');?></td>
           </tr>   
            <tr>
              <td width="15%"> ZipCode : </td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $restriction_zipcode; ?>" name="restriction_zipcode" id="restriction_zipcode" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('restriction_zipcode');?></td>
           </tr>       

          	<tr>
              <td width="15%">Is active?<span class="star"> *</span></td>
              <?php
			  $yes=$no='';
					if($is_active == 'draft')
						$no='checked="checked"';
					else
						$yes='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="publish" name="is_active" <?php echo $yes;?> />publish</label><label><input type="radio" style="width:20px !important;"  value="draft" name="is_active" <?php echo $no;?>/>draft</label></td>
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
	$(document).ready(function() {  
											$("#restriction_profession").tokenInput("<?php echo site_url('admin/course/GetProfession'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,tokenLimit: 1,
														<?php if($profession_arr){ ?>
														prePopulate: <?php echo $profession_arr;  } ?>
													});	
											$("#restriction_state").tokenInput("<?php echo site_url('admin/course/GetState'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,tokenLimit: 1,
														<?php if($state_arr){ ?>
														prePopulate: <?php echo $state_arr;  } ?>
													});	
											$("#restriction_city").tokenInput("<?php echo site_url('admin/course/GetCity'); ?>", 
															{
																theme: "facebook",preventDuplicates: true,tokenLimit: 1,
																<?php if($city_arr){ ?>
																prePopulate: <?php echo $city_arr;  } ?>
															});	
											/*$("#restriction_zipcode").tokenInput("<?php echo site_url('admin/course/GetZipcode'); ?>", 
															{
																theme: "facebook",preventDuplicates: true,
																<?php if($zip_arr){ ?>
																prePopulate: <?php echo $zip_arr;  } ?>
															});	
*/
								});
</script>
