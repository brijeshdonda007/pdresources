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
					$('#professions').html(msg);
				}
			});
}
</script>
<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/profession/index/s'); ?>" class="root_link">Profession List</a>
  <span class="root_vr">/</span><span class="root_link_remove">Add User</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;">Add Profession</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	<tr>
              <td width="15%">Profession Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $profession_name; ?>" name="profession_name" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('profession_name');?></td>
            </tr>
            
            <tr>
              <td>Profession Description : <span class="star"> *</span></td>
              <td align="left" valign="top"><textarea name="profession_description" rows="3" class="textarea tinymce" ><?php echo $profession_description; ?></textarea></td>
              <td align="left" valign="top" class="error"><?php echo form_error('profession_description');?></td>
            </tr>
             <tr>
              <td width="15%">Image : </td>
              <td width="25%" align="left" valign="top"><input type="file" id="profession_avatar" name="profession_avatar" /></td>
              <td width="60%" align="left" valign="top" class="error">
			  	<?php echo form_error('profession_avatar'); ?>
					<?php if($profession_avatar !='') echo '<input type="hidden" name="pre_avatar_image" id="pre_avatar_image" value="'.$profession_avatar.'" />'; ?>
                        <img src="<?php echo base_url().$profession_avatar; ?>" height="75" width="75" />
              </td>
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
