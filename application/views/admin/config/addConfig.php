<?php
	$flag=true;
	if($config_id =='')
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
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/config/index/s'); ?>" class="root_link">Config List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Config</span>
  <div class="clear"></div>
</div>

<!--End [ Root Link ]-->


<!-- Start [ Configration ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if(!$flag) echo 'Add';else echo 'Edit';  ?> Configration</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
                    
             <tr>
              <td width="15%">Title : <?php if(!$flag) echo '<span class="star"> *</span>'; ?></td><?php //if($config_id) echo 'readonly="readonly"'; ?>
              <td width="25%" align="left" valign="top"><input type="text" id="config_title" name="config_title" class="input"   value="<?php echo $config_title; ?>" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('config_title'); ?></td>
            </tr>
            <?php if($config_type == 'url'){ ?>
                <tr>
                  <td width="15%">Desciption : <?php if(!$flag) echo '<span class="star"> *</span>'; ?></td>
                  <td width="25%" align="left" valign="top"><input type="text" id="config_description" name="config_description" class="input" value="<?php echo $config_description; ?>" /></td>
                  <td width="60%" align="left" valign="top" class="error"><?php echo form_error('config_description'); ?></td>
                </tr>
            <?php }else{ ?>
             <tr>
              <td width="16%">Desciption : </td>
              <td width="25%" align="left" valign="top"><textarea name="config_description" class="textarea tinymce"><?php echo $config_description;?></textarea></td>
              <td width="59%" align="left" valign="top" class="error"></td>
            </tr>
            <?php } 
			if($is_default != 'Yes')
			{
			?>
            <tr>
              <td width="15%"> Is active? <span class="star"> *</span></td>
              <?php
					if($config_active == 'draft')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="publish" name="config_active" <?php echo $no;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="draft" name="config_active" <?php echo $yes;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>                  
           <?php } ?>
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">
	            <?php if($flag) echo '<input type="hidden" name="config_id" class="submit_btn" value="'.$config_id.'" />'; ?>
   	            <?php if($config_type == 'url') echo '<input type="hidden" name="config_type" class="submit_btn" value="'.$config_type.'" />'; ?>
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
