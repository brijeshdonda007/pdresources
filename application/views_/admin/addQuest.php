<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <a href="<?php echo site_url('admin/course/index/s'); ?>" class="root_link">Course List</a><span class="root_vr">/</span>
  <a href="<?php echo site_url('admin/test/index/'.$this->session->userdata['course_id']); ?>" class="root_link">Test List</a><span class="root_vr">/</span>  
  <a href="<?php echo site_url('admin/test/question/'.$test_id.'/s'); ?>" class="root_link">Question List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if($test_questid=='') echo 'Add';else echo 'Edit';  ?> Question</span>
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
  	<div class="page_title" style="margin-left:15px;"><?php if($test_questid=='') echo 'Add';else echo 'Edit';  ?> Question</div>
    <div style="height:10px; display:block;"></div>
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">          	   
             <tr>
              <td width="15%">Question : </td>
              <td width="25%" align="left" valign="top"><textarea name="question_text" class="textarea"><?php echo $question_text;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('question_text');?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
              	<input type="hidden" name="test_id" value="<?php echo $test_id; ?>" />
	            <?php if($question_id !='') echo '<input type="hidden" name="question_id" class="submit_btn" value="'.$question_id.'" />'; ?>
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
