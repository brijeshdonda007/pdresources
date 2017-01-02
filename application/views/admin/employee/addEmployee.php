<?php
	$flag=true;
	if($employee_id =='')
		$flag=false;
?>
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
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/employee/index/s'); ?>" class="root_link">Employee List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Employee</span>
  <div class="clear"></div>
</div>

<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Employee</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	<tr>
              <td width="15%">Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $employee_fname; ?>" name="employee_fname" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('employee_fname');?></td>
            </tr>
            <tr>
              <td width="15%">Email : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $employee_email; ?>" name="employee_email" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('employee_email');?></td>
            </tr>         
             <tr>
              <td width="15%">Title : <?php //if(!$flag) echo '<span class="star"> *</span>'; ?></td>
              <td width="25%" align="left" valign="top"><input type="text" id="employee_title" name="employee_title" value="<?php echo $employee_title; ?>" class="input" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('employee_title'); ?></td>
            </tr>
            <tr>
              <td width="15%">Linked in url: <?php //if(!$flag) echo '<span class="star"> *</span>'; ?></td>
              <td width="25%" align="left" valign="top"><input type="text" id="employee_title" name="employee_linkedin_url" value="<?php echo $employee_linkedin_url; ?>" class="input" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('employee_linkedin_url'); ?></td>
            </tr>
             <tr>
              <td width="16%">Biodata : </td>
              <td width="25%" align="left" valign="top"><textarea name="employee_description" class="textarea tinymce"><?php echo $employee_description;?></textarea></td>
              <td width="59%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Image : </td>
              <td width="25%" align="left" valign="top"><input type="file" id="employee_avatar" name="employee_avatar" /></td>
              <td width="60%" align="left" valign="top" class="error">
			  	<?php echo form_error('employee_avatar'); ?>
					<?php if($employee_avatar !='') echo '<input type="hidden" name="pre_avatar_image" id="pre_avatar_image" value="'.$employee_avatar.'" />'; ?>
                        <img src="<?php echo base_url().$employee_avatar; ?>" height="75" width="75" />
              </td>
            </tr>
            <tr>
              <td width="15%"> Is diplay on home page? <span class="star"> *</span></td>
              <?php
			  	$yes=$no='';
					if($employee_active == 'No')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="employee_diplay_home" <?php echo $no;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="employee_diplay_home" <?php echo $yes;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>                  
            <tr>
              <td width="15%"> Is active? <span class="star"> *</span></td>
              <?php
			  	$yes=$no='';			  
					if($employee_active == 'draft')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="publish" name="employee_active" <?php echo $no;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="draft" name="employee_active" <?php echo $yes;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>                  
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
	            <?php if($flag) echo '<input type="hidden" name="employee_id" class="submit_btn" value="'.$employee_id.'" />'; ?>
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
