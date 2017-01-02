<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel&nbsp;&nbsp;/&nbsp;&nbsp;</a>
  <a href="<?php echo site_url('admin/course/index/s'); ?>" class="root_link">Course List</a><span class="root_vr">/</span>
  <a href="<?php echo site_url('admin/test/index/'.$this->session->userdata('course_id')); ?>" class="root_link">Test List</a><span class="root_vr">/</span>
  <a href="<?php echo site_url('admin/test/question/'.$test_id.'/s'); ?>" class="root_link">Question List</a>  
  <span class="root_vr">/</span><span class="root_link_remove"><?php if($ques_option_id=='') echo 'Add';else echo 'Edit';  ?> Option</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  <?php
		if($course_pro_prof_id)
			$selected=$course_pro_prof_id;
		else
			$selected='0';
		if($course_pro_id)
			$cur=$course_pro_id;
		else
			$cur='0';
?>
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if($ques_option_id=='') echo 'Add';else echo 'Edit';  ?> Option</div>
    <div style="height:10px; display:block;"></div>
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">          	   
             <tr>
              <td width="15%">Option :<span class="star"> *</span> </td>
              <td width="25%" align="left" valign="top"><textarea name="option_text" class="textarea"><?php echo $option_text;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('option_text');?></td>
            </tr>
            <tr>
              <td width="15%"> Is Option Right?</td>
              <?php
					if($is_right_option == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="is_right_option" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="is_right_option" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
              	<input type="hidden" name="test_id" value="<?php echo $test_id; ?>" />
              	<input type="hidden" name="question_id" value="<?php echo $question_id; ?>" />                
	            <?php if($option_id !='') echo '<input type="hidden" name="option_id" class="submit_btn" value="'.$option_id.'" />'; ?>
                 <?php if($is_active !='') echo '<input type="hidden" name="is_active" class="submit_btn" value="'.$is_active.'" />'; ?>
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
