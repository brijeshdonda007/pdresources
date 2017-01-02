<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/default.css" />
<?php 
	if($UserInfo['cust_avatar'])
		$small_name=base_url().$UserInfo['cust_avatar'];
	else
		$small_name=base_url().'images/user_default_logo.png';
?>
<form name="updateImage" id="updateImage" action="" method="post" enctype="multipart/form-data">
	<div class="text_box">
        <p class="line_2"><img src="<?php echo $small_name; ?>" name="<?php echo $UserInfo['cust_fname']; ?>" alt="<?php echo $UserInfo['cust_fname']; ?>" height="100" width="100" /></p>        
        <span class="input_box_space">
        <input type="file" name="new_image" id="new_image" />
        <input type="hidden" name="old_image" id="old_image" value="<?php echo $UserInfo['cust_avatar'];?>" />
        <?php echo form_error('new_image');?>
        </span>
        <input type="submit" name="submit" value="Update" />
        <div class="clear"></div>
    </div>
</form>

<div class="up_profile_space">
     <div class="up_profile_inner">
	<div class="popup_header">Upload Profile Image</div>
	<p class="popup_text" >Click Browse to add your own photo for your</p>
	<p class="popup_text_1">Dashboard Profile page.</p>
	<a href="#" class="browse_btn"></a>
     </div>
</div>