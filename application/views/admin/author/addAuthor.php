<?php
	$flag=true;
	if($author_id =='')
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
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/author/index/s'); ?>" class="root_link">Author List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Author</span>
  <div class="clear"></div>
</div>

<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Author</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
          
          	<tr>
              <td width="15%">First Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $author_fname; ?>" name="author_fname" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('author_fname');?></td>
            </tr>
            <tr>
              <td width="15%">Last Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $author_lname; ?>" name="author_lname" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('author_lname');?></td>
            </tr>         
             <tr>
              <td width="15%">Title : <?php //if(!$flag) echo '<span class="star"> *</span>'; ?></td>
              <td width="25%" align="left" valign="top"><input type="text" id="author_title" name="author_title" value="<?php echo $author_title; ?>" class="input" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('author_title'); ?></td>
            </tr>
             <tr>
              <td width="16%">Biodata : </td>
              <td width="25%" align="left" valign="top"><textarea name="author_description" class="textarea tinymce"><?php echo $author_description;?></textarea></td>
              <td width="59%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Image : </td>
              <td width="25%" align="left" valign="top"><input type="file" id="author_avatar" name="author_avatar" /></td>
              <td width="60%" align="left" valign="top" class="error">
			  	<?php echo form_error('author_avatar'); ?>
					<?php if($author_avatar !='') echo '<input type="hidden" name="pre_avatar_image" id="pre_avatar_image" value="'.$author_avatar.'" />'; ?>
                        <img src="<?php echo base_url().$author_avatar; ?>" height="75" width="75" />
              </td>
            </tr>
              <td width="15%"> Is active? <span class="star"> *</span></td>
              <?php
					if($author_active == 'draft')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="publish" name="author_active" <?php echo $no;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="draft" name="author_active" <?php echo $yes;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>                  
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
	            <?php if($flag) echo '<input type="hidden" name="author_id" class="submit_btn" value="'.$author_id.'" />'; ?>
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
