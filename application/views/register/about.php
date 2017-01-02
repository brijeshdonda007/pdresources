<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tokeninput.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/token-input-facebook_about.css" />
<script type="text/javascript">	
	$(document).ready(function() {
					/*$("#signup_profession").tokenInput("<?php echo site_url('home/getProession'); ?>", 
									{
										theme: "facebook",preventDuplicates: true,tokenLimit: 1
										<?php if($selectedprof){ ?>
										,prePopulate: <?php echo $selectedprof; } ?>
									});	*/
					$('#signup_name').focus();
				});
	function validatesignupform()
	{		
		var msg='';
		var name=$('#signup_name').val();
		var email=$('#signup_email').val();
		var passwd=$('#signup_password').val();
		var prof=$('#signup_profession').val();		
		if(name == '' || name.length <= 0)
		{
			msg='Please enter Name';
			$('.success span').html(msg);
			$('.warning span').html(msg);
			$('.success').stop( true, true).fadeOut();
			$('.warning').stop( true, true).fadeIn();
			$('#signup_name').focus();
			return false;
		}
		else if(email == '' || email.length <= 0)
		{
			msg='Please enter Email';
			$('.success span').html(msg);
			$('.warning span').html(msg);
			$('.success').stop( true, true).fadeOut();
			$('.warning').stop( true, true).fadeIn();
			$('#signup_email').focus();
			return false;			
		}
		else if(!email_validation(email))
		{
			msg='Please enter Valid Email';
			$('.success span').html(msg);
			$('.warning span').html(msg);
			$('.success').stop( true, true).fadeOut();
			$('.warning').stop( true, true).fadeIn();
			$('#signup_email').focus();			
			return false;			
		}
		else if(passwd == '' || passwd.length <= 0)
		{
			msg='Please enter Password';
			$('.success span').html(msg);
			$('.warning span').html(msg);
			$('.success').stop( true, true).fadeOut();
			$('.warning').stop( true, true).fadeIn();
			$('#signup_password').focus();			
			return false;			
		}
		/*else if(prof == '' || prof.length <= 0)
		{
			msg='Please Select Profession';
			$('.success span').html(msg);
			$('.warning span').html(msg);
			$('.success').stop( true, true).fadeOut();
			$('.warning').stop( true, true).fadeIn();
			$('#signup_profession').focus();			
			return false;			
		}*/
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
                        <p>Sign Up</p>
                        </div>
                        <div class="line_1"></div>
            <!--              error massage              -->   
            			<div class="error_msg_space_signup">
	                    	<div class="signup_msg success" <?php if(trim($sucMsg)) echo 'style="display:block"'; ?> >Success: <span><?php echo $sucMsg; ?></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close"><div class="clear"></div></div>
    	                    <div class="signup_msg warning" <?php if(trim($errorMsg)) echo 'style="display:block"'; ?>>Warning: <span><?php echo $errorMsg; ?></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close"><div class="clear"></div></div>
        	            </div>           <!--                 error massage                  -->   
                        <div class="text_box">
                            <p class="line_2">NAME</p>
                            <span class="input_box_space"><input name="signup_name" id="signup_name" value="<?php echo $signup_name; ?>" type="text" class="input_box"></span>
                            <div class="clear"></div>
                        </div>
                        <div class="text_box">
                            <p class="line_2">EMAIL</p>
                            <span class="input_box_space"><input name="signup_email" id="signup_email" value="<?php echo $signup_email; ?>" type="text" class="input_box"></span>
                            <div class="clear"></div>
                        </div>
                        <div class="text_box">
                            <p class="line_2">PASSWORD</p>
                            <span class="input_box_space"><input name="signup_password" id="signup_password" type="password" class="input_box"></span>
                            <div class="clear"></div>
                        </div>
                       <!-- <div class="text_box">
                            <p class="line_2">PROFESSION</p>
                            <span class="input_box_space"><input name="signup_profession" id="signup_profession" type="text" class="input_box"></span>
                            <div class="clear"></div>
                        </div>-->
                        
                         <div style="padding-top:11px;">
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