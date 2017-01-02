<html>
    <head>
        <!--File css and js-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/default.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/enhance.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/enhanced.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/enhance.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jQuery.fileinput.js"></script>
        <script type="text/javascript">
			$(document).ready(function(){
					//input type file
					$('#new_image').customFileInput();	
					parent.$(".dashboard_iframe_class").attr("style", 'width:381px;height:254px;display:block;');
				parent.setOverlayPos();
			});
		</script>
    </head>
    <body>
    	<?php 
			if($UserInfo['cust_avatar'])
				$small_name=base_url().$UserInfo['cust_avatar'];
			else
				$small_name=base_url().'images/user_default_logo.png';
		?>
        <!--popup start]-->
        <div class="up_profile_space" id="upload_profile">            
            <div class="up_profile_inner">
                <div class="popup_header">Upload Profile Image</div>
                <p class="popup_text" >Click Browse to add your own photo for your</p>
                <p class="popup_text_1">Dashboard Profile page.</p>
                <span class="popup_error"><?php echo form_error('new_image');?></span>                
                <form name="updateImage" id="updateImage" action="" method="post" enctype="multipart/form-data">
                    <div class="pop_inner_space">            
                      <input type="file" name="new_image" id="new_image" />
                      <input type="hidden" name="old_image" id="old_image" value="<?php echo $UserInfo['cust_avatar'];?>" />
                    </div>
                    <!--<a href="#" class="browse_btn"></a>-->
                    <div class="pop_inner_space">
                        <input type="submit" name="submit" id="submit" class="submit_btn" value="" />
                    </div>
                </form>
              </div>
        </div>
        <!--popup end]-->
    </body>
</html>
