<script type="text/javascript">	
	$(document).ready(function() {					
		$('#login_email').focus();
	});
	function validatesignupform()
	{		
		var msg='';
		var email=$('#login_email').val();
		var passwd=$('#login_password').val();
		if(email == '' || email.length <= 0)
		{
			msg='Please enter Email';
			$('.success span').html(msg);
			$('.warning span').html(msg);
			$('.success').stop( true, true).fadeOut();
			$('.warning').stop( true, true).fadeIn();
			$('#login_email').focus();
			return false;			
		}
		else if(!email_validation(email))
		{
			msg='Please enter Valid Email';
			$('.success span').html(msg);
			$('.warning span').html(msg);
			$('.success').stop( true, true).fadeOut();
			$('.warning').stop( true, true).fadeIn();
			$('#login_email').focus();			
			return false;			
		}
		else if(passwd == '' || passwd.length <= 0)
		{
			msg='Please enter Password';
			$('.success span').html(msg);
			$('.warning span').html(msg);
			$('.success').stop( true, true).fadeOut();
			$('.warning').stop( true, true).fadeIn();
			$('#login_password').focus();			
			return false;			
		}		
		else
			return true;

	}
	function email_validation(email) 
	{
		var x = email;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
			return false;
		}
		return true;
	}

</script>
<!--Srart [ part2 ]-->
<div class="part2">
	<!--start[part content]-->
	<div class="part2_content_outer">
    	<div class="about_main">
        	<div class=" about_text_box">Welcome
                <div class=" about_box" style="margin-top:23px;"><?php $temp=$this->mdl_config->get_allconfig(7); echo $temp['config_description']; ?></div>
            </div>
            <div class="about_white_box" style="height:auto;">
            	<div class="box">
                	<form name="signup" id="signup" method="post" action="" onsubmit="return validatesignupform();"> 
                        <div class=" signup_text">
                        <p>Sign In</p>
                        </div>
                        <div class="line_1"></div>
                        <?php if($ResendActivation){?><br />In case if you don't have activation link, <a href="<?php echo site_url('signup/ResendActivationLink'); ?>" class="login_link">click here</a> to resend the activation email.<?php } ?>
            <!--              error massage              -->   
            			<div class="error_msg_space_signup">
	                    	<div class="signup_msg success" <?php if(trim($sucMsg)) echo 'style="display:block"'; ?> >Success: <span><?php echo $sucMsg; ?></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close"><div class="clear"></div></div>
    	                    <div class="signup_msg warning" <?php if(trim($errorMsg)) echo 'style="display:block"'; ?>>Warning: <span><?php echo $errorMsg; ?></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close"><div class="clear"></div></div>
        	            </div>
           <!--                 error massage                  -->   
                        <div class="text_box">
                            <p class="line_2" style="width:80px;">EMAIL</p>
                            <span class="input_box_space" style="width:320px;"><input name="login_email" id="login_email" value="<?php echo $login_email; ?>" type="text" class="input_box"></span>
                            <div class="clear"></div>
                        </div>
                        <div class="text_box">
                            <p class="line_2">PASSWORD</p>
                            <span class="input_box_space"><input name="login_password" id="login_password" type="password" class="input_box"></span>
                            <div class="clear"></div>
                        </div>
                        
                         <div style="padding-top:11px;">
                         	<a href="<?php echo site_url('signup/forgot_pass'); ?>" class="login_link">Forgot password</a>
                            
	                    	<input type="submit" name="submit" class="go_btn_submit" value="" />
    	                    <div class="clear"></div>
        	            </div>            
                        <div class="clear"></div>
					</form>
                </div> 
                
            </div>
            <div class="clear"></div>
        </div>
        
        
        <div class="h_ruler"></div>
    
        
     	<div class="about_main" style="margin-bottom:32px;">
        	<p class="about_team_title">WHO ARE WE</p>
            <div class="about_text_disc" style="margin-top:10px;"><?php $temp=$this->mdl_config->get_allconfig(8); echo $temp['config_description']; ?></div>
          <div class="about_text_disc" style="margin-top:10px;"><?php $temp=$this->mdl_config->get_allconfig(9); echo $temp['config_description']; ?></div>
            <div class="clear"></div>
        </div>
        
        
        
        <div class="h_ruler"></div>
        
        <div class="about_main">
        	<p class="about_team_title">About pdr certifications</p>
            <div class="about_text_disc"><?php $temp=$this->mdl_config->get_allconfig(10); echo $temp['config_description']; ?></div>
            
<div class="about_img_disc">
           		<div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <div class="certi_box"></div>
                <p class="about_absolute_18px">CERTIFICATION LOGO AREA</p>
				<div class="clear"></div>
           </div>
           
           <div class="clear"></div>
        </div>
        
        <div class="h_ruler"></div>
        
        <div class="about_main">
        	<div class="about_black">QUICK CONTACT AREA</div>
            <div class="about_black">CHAT LIVE AREA</div>
            <div class="clear"></div>
        </div>
    	
         <div class="h_ruler"></div>
        
    </div>
    
</div>
<!--End [ part2 ]-->