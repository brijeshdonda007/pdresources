<html>
    <head>
        <!--File css and js-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/default.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jqueryBlockNew.js"></script>
        <script type="text/javascript">
			$(document).ready(function(){
				$('#popup_close1').click(function(){	
					window.parent.unBlockUI();
				});
			});
			</script>
    </head>
    <body>
		<?php 
			if($EmployeeInfo['employee_avatar'])
				$smallname=base_url().$EmployeeInfo['employee_avatar'];
			else				
				$smallname=base_url().'images/employee_default.jpg';
        ?>

        <!--popup start index page]-->
        <div class="emplyee_info_space" id="user_profile_space">
            <div class="user_profile_inner">
                <div class="userpopup_header"><?php echo $EmployeeInfo['employee_title'] ?></div>
                <div class="userpop_inner_space_1">
                    <div class="user_id_space">
                        <img src="<?php echo $smallname; ?>" />
                        <?php if($EmployeeInfo['employee_linkedin_url']) { ?>
	                        <a href="<?php echo $EmployeeInfo['employee_linkedin_url']; ?>" class="social_space"><img src="<?php echo base_url();?>images/linkin.png"/></a>
                        <?php } ?>
                        <a href="#" class="link_text"><?php echo $EmployeeInfo['employee_email']; ?></a>
                    </div>
                    <div class="user_detail"><?php echo $EmployeeInfo['employee_description']; ?></div>
                    <div class="clear"></div>
                </div>
                <!--<a href="#" class="browse_btn"></a>-->
                <div class="userpop_inner_space">
                   <a class="close_btn" id="popup_close1"></a>
                   <div class="clear"></div>
                </div>
            </div>
        </div>
        <!--popup end]-->
    </body>
</html>
