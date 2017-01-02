<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/course/index/s'); ?>" class="root_link">Course List</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/test/index/'.$course_id); ?>" class="root_link">Test List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if($test_id=='') echo 'Add';else echo 'Edit';  ?> Test</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if($test_id=='') echo 'Add';else echo 'Edit';  ?> Test</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	<tr>
              <td width="15%">Test Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $test_name; ?>" name="test_name" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('test_name');?></td>
            </tr>           
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
	            <?php if($test_id !='') echo '<input type="hidden" name="test_id" class="submit_btn" value="'.$test_id.'" />'; ?>
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

