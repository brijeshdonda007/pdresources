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
              <td width="15%">Type of Course <span class="star"> *</span></td>
              <?php
			  $yes=$no=$inter='';
					if($course_type== 'Shared')
						$no='checked="checked"';
					else if($course_type == 'Test Only')
						$inter='checked="checked"';					
					else
						$yes='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_type" <?php echo $yes;?> />Online </label><label><input type="radio" style="width:20px !important;"  value="No" name="course_type" <?php echo $no;?>/>Shared </label><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_type" <?php echo $inter;?> />Test Only </label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
          	<tr>
              <td width="15%">Course Name : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_name; ?>" name="course_name" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_name');?></td>
            </tr>
            <tr>
              <td width="15%">Date for Release : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" maxlength="2" class="input" value="<?php echo $course_release_date; ?>" id="course_release_date" name="course_release_date" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_release_date');?></td>
            </tr>
            <tr>
              <td width="15%"> Course Number : <span class="star"> *</span></td>
              <td width="30%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_main_course_id; ?>" name="course_main_course_id" /> In (xx-xx) format</td>
              <td width="55%" align="left" valign="top" class="error"><?php echo form_error('course_main_course_id');?></td>
            </tr>
            <tr>
              <td width="15%">Learning Level<span class="star"> *</span></td>
              <?php
			  $t1=$t2=$t3='';
					if($course_learning_level == 'Advanced')
						$t3='checked="checked"';
					else if($course_learning_level == 'Intermediate')
						$t2='checked="checked"';
					else
						$t1='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Introductory" name="course_learning_level" <?php echo $yes;?> />Introductory</label><label><input type="radio" style="width:20px !important;"  value="Intermediate" name="course_is_active" <?php echo $t2;?>/>Intermediate</label><label><input type="radio" style="width:20px !important;"  value="Advanced" name="course_is_active" <?php echo $t3;?>/>Advanced</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Credit HoursAmount : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_ce_ceus; ?>" name="course_ce_ceus" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_ce_ceus');?></td>
            </tr>
            <tr>
              <td width="15%">Online Price : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_online_price; ?>" name="course_online_price" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_online_price');?></td>
            </tr>
            <tr>
              <td width="15%">Sale Price : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_sale_price; ?>" name="course_sale_price" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_sale_price');?></td>
            </tr>
            <tr>
              <td width="15%">Almost Expired Price : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_expired_price; ?>" name="course_expired_price" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_expired_price');?></td>
            </tr>
			<tr>
              <td width="15%"> Author : <!--<span class="star"> *</span>--></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_author; ?>" name="course_author" id="course_author" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_author');?></td>
            </tr>
			<tr>
              <td width="16%">Course Description : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_desc" class="textarea tinymce"><?php echo $course_desc;?></textarea></td>
              <td width="59%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Target Audiance : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_target_audiance" class="textarea"><?php echo $course_target_audiance;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Course Objectives : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_objective" id="course_objective" class="textarea tinymce"><?php echo $course_objective;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>           
            <tr>
              <td>Upload Course PDF File : <!--<span class="star"> *</span>--></td>
              <td align="left" valign="top"><input type="file" name="course_pdf_content" /></td>
              <td align="left" valign="top" class="error">
                    <?php if($course_image !='') echo '<input type="hidden" name="pre_course_pdf_content" value="'.$course_pdf_content.'" />'; ?>                  
                    <?php if($course_pdf_content){ 
								echo 'Uploaded File:-'.$course_pdf_content; 
								echo '   <label><input type="checkbox" name="delete_pdf" id="delete_pdf" value="delete_pdf" />   Delete PDF File</label>';
					} ?>
                    
              </td>
            </tr>
           <!-- <tr>
              <td width="16%">Or PDF Content : </td>
              <td width="25%" align="left" valign="top"><textarea name="pdf_content" class="textarea tinymce"><?php // echo $pdf_content;?></textarea></td>
              <td width="59%" align="left" valign="top" class="error"></td>
            </tr>  -->      
            <tr>
              <td width="15%">Amazon Link : <!--<span class="star"> *</span>--></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_amazon_link; ?>" name="course_amazon_link" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_amazon_link');?></td>
            </tr>   
            <tr>
                  <td>Branding Module : <!--<span class="star"> *</span>--></td>
                  <td align="left" valign="top"><input type="file" name="course_image" /></td>
                  <td align="left" valign="top" class="error">
                  		<?php if($course_image !='')
						{ 
							echo '<input type="hidden" name="pre_course_image" value="'.$course_image.'" />'; 
							echo '<img src="'.base_url().$course_image.'" height="40" width="40" />';
						}
						echo $file_error; ?>
                  </td>
                </tr>      
            <tr>
              <td width="15%"> Course Test  : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_test; ?>" name="course_test" id="course_test" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_test');?></td>
            </tr>
            <tr>
              <td width="15%">Course Expiry Date : <span class="star"> *</span></td>
              <td width="25%" align="left" valign="top"><input type="text" maxlength="2" class="input" value="<?php echo $course_expiry_date; ?>" id="course_expiry_date" name="course_expiry_date" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_expiry_date');?></td>
            </tr>
            <tr>
              <td width="15%"> Accreditations  : <!--<span class="star"> *</span>--></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_accreditations; ?>" name="course_accreditations" id="course_accreditations" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_accreditations');?></td>
            </tr>
            
            <tr>
              <td width="15%"> Certificate  : <!--<span class="star"> *</span>--></td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_certificate; ?>" name="course_certificate" id="course_certificate" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_certificate');?></td>
            </tr>                                                
			<tr>
              <td width="15%">Allow RE-ENROLLMENT?<span class="star"> *</span></td>
              <?php
			  $yes=$no='';
					if($course_reenrolment== 'Y')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Y" name="course_reenrolment" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="N" name="course_reenrolment" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Is demo course?<span class="star"> *</span></td>
              <?php
			  $yes=$no='';
					if($course_is_demo == 'Y')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Y" name="course_is_demo" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="N" name="course_is_demo" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="15%">Is active?<span class="star"> *</span></td>
              <?php
			  $yes=$no='';
					if($course_is_active == 'N')
						$no='checked="checked"';
					else
						$yes='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Y" name="course_is_active" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="N" name="course_is_active" <?php echo $no;?>/>No</label></td>
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
	$(function(){	$("#course_expiry_date").datepicker({changeMonth: true,changeYear: true,dateFormat:'dd-mm-yy',showOn:'button',buttonImageOnly: true,yearRange: '1900:<?php echo date('Y')+10; ?>',buttonImage: '<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});
					$("#course_release_date").datepicker({changeMonth: true,changeYear: true,dateFormat:'dd-mm-yy',showOn:'button',buttonImageOnly: true,yearRange: '1900:<?php echo date('Y')+10; ?>',buttonImage: '<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});
		 });

	$(document).ready(function() {  $("#course_objective").tokenInput("<?php echo site_url('admin/course/GetObjective'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,//tokenLimit: 1,
														<?php if($objective_arr){ ?>
														prePopulate: <?php echo $objective_arr;  } ?>
													});	
									$("#course_author").tokenInput("<?php echo site_url('admin/course/GetAuthour'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,//tokenLimit: 1,
														<?php if($author_arr){ ?>
														prePopulate: <?php echo $author_arr;  } ?>
													});	
									$("#course_test").tokenInput("<?php echo site_url('admin/course/GetTest'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,tokenLimit: 1,
														<?php if($test_arr){ ?>
														prePopulate: <?php echo $test_arr;  } ?>
													});	
									$("#course_accreditations").tokenInput("<?php echo site_url('admin/course/GetAccreditations'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,
														<?php if($accreditation_arr){ ?>
														prePopulate: <?php echo $accreditation_arr;  } ?>
													});	
									$("#course_certificate").tokenInput("<?php echo site_url('admin/course/GetCertificate'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,tokenLimit: 1,
														<?php if($certificate_arr){ ?>
														prePopulate: <?php echo $certificate_arr;  } ?>
													});	
									/*$("#course_profession").tokenInput("<?php echo site_url('admin/course/GetProfession'); ?>", 
													{
														theme: "facebook",preventDuplicates: true,tokenLimit: 1,
														<?php if($profession_arr){ ?>
														prePopulate: <?php echo $profession_arr;  } ?>
													});	*/									

								});
</script>
<!--<tr>
              <td width="15%"> Proessions  : </td>
              <td width="25%" align="left" valign="top"><input type="text" class="input" value="<?php echo $course_profession; ?>" name="course_profession" id="course_profession" /></td>
              <td width="60%" align="left" valign="top" class="error"><?php echo form_error('course_profession');?></td>
            </tr>-->
<!--<tr>
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
              <td width="15%">Course Abstract : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_desc" class="textarea tinymce"><?php echo $course_desc;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>
            <tr>
              <td width="17%">Course Test Only Description : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_testonly_desc" class="textarea tinymce"><?php echo $course_testonly_desc;?></textarea></td>
              <td width="58%" align="left" valign="top" class="error"></td>
            </tr>

            <tr>
              <td width="15%">About author : </td>
              <td width="25%" align="left" valign="top"><textarea name="course_learning_objactive" class="textarea tinymce"><?php echo $course_learning_objactive;?></textarea></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>           
            <tr>
              <td width="15%"> Search online <span class="star"> *</span></td>
              <?php
			  $yes=$no='';
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
			  $yes=$no='';
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
			  $yes=$no='';
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
			  $yes=$no='';
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
			  $yes=$no='';
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
			  $yes=$no='';
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
			  $yes=$no='';
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
			  $yes=$no='';
					if($course_is_medical_error == 'Yes')
						$yes='checked="checked"';
					else
						$no='checked="checked"';
			  ?>
              <td width="10%" align="left" valign="top"><label><input type="radio" style="width:20px !important;"  value="Yes" name="course_is_medical_error" <?php echo $yes;?> />Yes</label><label><input type="radio" style="width:20px !important;"  value="No" name="course_is_medical_error" <?php echo $no;?>/>No</label></td>
              <td width="60%" align="left" valign="top" class="error"></td>
            </tr>         -->
