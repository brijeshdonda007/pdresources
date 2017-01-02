<?php
	$flag=true;
	if($pramotion_id =='')
		$flag=false;
?>

<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/pramotion/index/s'); ?>" class="root_link">Pramotion List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Pramotion</span>
  <div class="clear"></div>
</div>

<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Pramotion</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	
             <tr>
              <td width="15%">Url : <?php if(!$flag) echo '<span class="star"> *</span>'; ?></td>
              <td width="25%" align="left" valign="top"><input type="text" id="pramotion_url" name="pramotion_url" value="<?php echo $pramotion_url; ?>" class="input" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('pramotion_url'); ?></td>
            </tr>
            <tr>
              <td width="15%">Image : <?php if(!$flag) echo '<span class="star"> *</span>'; ?></td>
              <td width="25%" align="left" valign="top"><input type="file" id="pramotion_avatar" name="pramotion_avatar" /></td>
              <td width="60%" align="left" valign="top" class="error">
			  	<?php echo form_error('pramotion_avatar'); ?>
					<?php if($pramotion_avatar !='') echo '<input type="hidden" name="pre_avatar_image" id="pre_avatar_image" value="'.$pramotion_avatar.'" />'; ?>
                        <img src="<?php echo base_url().$pramotion_avatar; ?>" height="75" width="75" />
              </td>
            </tr>
              <td width="15%"> Is active? <span class="star"> *</span></td>
              <?php
					if($pramotion_active == 'draft')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="publish" name="pramotion_active" <?php echo $no;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="draft" name="pramotion_active" <?php echo $yes;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>                  
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
	            <?php if($flag) echo '<input type="hidden" name="pramotion_id" class="submit_btn" value="'.$pramotion_id.'" />'; ?>
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
