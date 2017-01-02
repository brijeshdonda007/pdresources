<script type="text/javascript">
	$(document).ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo base_url(); ?>js/tiny_mce/tiny_mce_src.js',

			// General options
			mode:"specific_textareas", editor_selector:"theEditor", 
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,pagebreak,|,fullscreen,preview",
			theme_advanced_buttons2 : "formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,image,media,charmap,emotions,|,outdent,indent,|,undo,redo,help",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			document_base_url : "<?php echo base_url(); ?>",
			relative_urls : false,

			// Example content CSS (should be your site CSS)
			content_css : "<?php echo base_url(); ?>css/admin/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	});

</script>
<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/course/index/s'); ?>" class="root_link">Course List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if($course_id=='') echo 'Add';else echo 'Edit';  ?> Course</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if($course_id=='') echo 'Add';else echo 'Edit';  ?> Course</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	<tr>
              <td width="15%">Course Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_name; ?>" name="course_name" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_name');?></td>
            </tr>
            <tr>
              <td width="15%">Course Hours : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_ce_hours; ?>" name="course_ce_hours" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_ce_hours');?></td>
            </tr>
             <tr>
              <td width="15%">Target Audiance : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_target_audiance" class="textarea"><?php echo $course_target_audiance;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Course Expiry Date : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" maxlength="2" class="input" value="<?php echo $course_expiry_date; ?>" id="course_expiry_date" name="course_expiry_date" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_expiry_date');?></td>
            </tr>
             <tr>
              <td width="15%">Course Description : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_desc" class="textarea tinymce"><?php echo $course_desc;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Course Learning Objective : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_about_author" class="textarea tinymce"><?php echo $course_about_author;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="16%">Course Online Description : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_online_desc" class="textarea tinymce"><?php echo $course_online_desc;?></textarea></td>
              <td width="59%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="17%">Course Test Only Description : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_testonly_desc" class="textarea tinymce"><?php echo $course_testonly_desc;?></textarea></td>
              <td width="58%" align="left" valign="top" class="error"></td>
            </tr>

            <tr>
              <td width="15%">About author : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_learning_objactive" class="textarea"><?php echo $course_learning_objactive;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%"> Author : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_author; ?>" name="course_author" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_author');?></td>
            </tr>
            <tr>
              <td width="15%"> Main Course Id : <span class="star"> *</span></td>
              <td width="30%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_main_course_id; ?>" name="course_main_course_id" /> In (xx-xx) format</td>
              <td width="55%" align="left" valign="top" class="error"><?php echo form_error('course_main_course_id');?></td>
            </tr>            
           	<tr>
                  <td>Course Image : <span class="star"> *</span></td>
                  <td align="left" valign="top"><input type="file" name="course_image" /></td>
                  <td align="left" valign="top" class="error">
                  		<?php if($course_image !='') echo '<input type="hidden" name="pre_course_image" value="'.$course_image.'" />'; ?>
                    	<img src="<?php echo base_url().$course_image; ?>" height="40" width="40" />
                        <?php echo $file_error; ?>
                  </td>
                </tr>            
             <tr>
              <td width="15%"> Search online <span class="star"> *</span></td>
              <?php
					if($course_search_on_line == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_search_on_line" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_search_on_line" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
             <tr>
              <td width="15%"> Search test only <span class="star"> *</span></td>
              <?php
					if($course_search_test_only == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_search_test_only" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_search_test_only" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Is New Course? <span class="star"> *</span></td>
              <?php
					if($course_is_new == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_is_new" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_is_new" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>           
            <tr>
              <td width="15%">Is Best Seller? <span class="star"> *</span></td>
              <?php
					if($course_is_best_seller == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_is_best_seller" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_is_best_seller" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>   
            <tr>
              <td width="15%">Is On Sale? <span class="star"> *</span></td>
              <?php
					if($course_is_sell == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_is_sell" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_is_sell" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>     
            <tr>
              <td width="15%">Is Closeout? <span class="star"> *</span></td>
              <?php
					if($course_is_closeout == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_is_closeout" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_is_closeout" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>  
            <tr>
              <td width="15%">Is Ethics? <span class="star"> *</span></td>
              <?php
					if($course_is_ethics == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_is_ethics" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_is_ethics" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>     
            <tr>
              <td width="15%">Is Medical Errors? <span class="star"> *</span></td>
              <?php
					if($course_is_medical_error == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_is_medical_error" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_is_medical_error" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>         

            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
	            <?php if($course_id !='') echo '<input type="hidden" name="course_id" class="submit_btn" value="'.$course_id.'" />'; ?>
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
	$(function(){	$("#course_expiry_date").datepicker({changeMonth: true,changeYear: true,dateFormat:'mm-dd-yy',showOn:'button',buttonImageOnly: true,buttonImage: '<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});	 });
</script>
