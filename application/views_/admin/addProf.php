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
function test(state,course,selected,current)
{
	$.ajax({
				url: "<?php echo site_url('admin/course/GetProfDropdown/'); ?>/"+state+"/"+course+"/"+selected+"/"+current,
				success: function(msg) {
					//alert(msg);
					$('#profession').html(msg);
				}
			});
}
</script>
<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/course/profession/'.$course_id.'/s'); ?>" class="root_link">Course Profession List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if($course_id=='') echo 'Add';else echo 'Edit';  ?> Course Profession</span>
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
  	<div class="page_title" style="margin-left:15px;"><?php if($course_id=='') echo 'Add';else echo 'Edit';  ?> Course Profession</div>
    <div style="height:10px; display:block;"></div>
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          	<tr>
              <td width="15%">State : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"> <?php echo form_dropdown('course_pro_state_id',$state,$course_pro_state_id,'style="width:150px" onchange="javascript:test(this.value,'.$course_id.','.$selected.','.$cur.');"'); ?></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_pro_state_id');?></td>
            </tr>  
            <tr>
              <td width="15%">Course Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"> 
               	  <input type="text" disabled="disabled" name="coursename" value="<?php echo $cousrsename;  ?>" />
	              <input type="hidden" name="course_pro_course_id" value="<?php echo $course_id; ?>" />
              </td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_pro_course_id');?></td>
            </tr>
            <tr>
              <td width="15%">Profession Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top" id="profession"> <?php echo form_dropdown('course_pro_prof_id',$profession,$course_pro_prof_id,'style="width:150px"'); ?></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_pro_prof_id');?></td>
            </tr>             
             <tr>
              <td width="15%">Description : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_pro_description" class="textarea tinymce"><?php echo $course_pro_description;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
              	<input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
	            <?php if($course_pro_id !='') echo '<input type="hidden" name="course_pro_id" class="submit_btn" value="'.$course_pro_id.'" />'; ?>
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
