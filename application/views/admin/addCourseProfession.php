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
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/course/profession/'); ?>" class="root_link">Course Profession List</a>
  <span class="root_vr">/</span><span class="root_link_remove"><?php if($course_pro_id=='') echo 'Add';else echo 'Edit';  ?> Course Profession</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;"><?php if($course_pro_id=='') echo 'Add';else echo 'Edit';  ?> Course Profession</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent">
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
          <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">             

          <tr>
              <td width="15%"> Profession : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_pro_prof_id; ?>" name="course_pro_prof_id" id="course_pro_prof_id" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_pro_prof_id');?></td>
            </tr>          
          	<tr>
              <td width="15%">CE Information : </td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_pro_ce; ?>" name="course_pro_ce" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_pro_ce');?></td>
            </tr>
			  <tr>
              <td width="15%">Is active?<span class="star"> *</span></td>
              <?php
			  $yes=$no='';
					if($is_active == 'N')
						$no='checked="checked"';
					else
						$yes='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Y" name="is_active" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="N" name="is_active" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
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
<script type="text/javascript">
	$(function(){	$("#course_expiry_date").datepicker({changeMonth: true,changeYear: true,dateFormat:'dd-mm-yy',showOn:'button',buttonImageOnly: true,yearRange: '1900:<?php echo date('Y')+10; ?>',buttonImage: '<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});
					$("#course_release_date").datepicker({changeMonth: true,changeYear: true,dateFormat:'dd-mm-yy',showOn:'button',buttonImageOnly: true,yearRange: '1900:<?php echo date('Y')+10; ?>',buttonImage: '<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});
		 });

	$(document).ready(function() {  $("#course_pro_prof_id").tokenInput("<?php echo site_url('admin/course/GetProfession'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,tokenLimit: 1,
														<?php if($profession_arr){ ?>
														prePopulate: <?php echo $profession_arr;  } ?>
													});	

								});
</script>
