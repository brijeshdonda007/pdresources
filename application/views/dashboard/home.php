<!--Calendar css and js-->
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>js/calendar/jquery-ui-1.8.19.custom.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendar/jquery-ui-1.8.19.custom.min.js"></script>
<!--Autocomplete css and js-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.autocomplete.js"></script>

<!--File css and js-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/enhanced.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/enhance.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jQuery.fileinput.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>js/jqueryBlockNew.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.user_menu_space .user_menu_item').click(function(){
			if(!$(this).hasClass('user_menu_item_active'))
			{
				var storeRel= $(this).attr('rel');
				$('.user_info').stop(true, true).hide();
				$('.user_menu_space .user_menu_item').removeClass('user_menu_item_active');
				$('.user_info#'+storeRel).stop(true, true).show();
				$(this).addClass('user_menu_item_active');	
				
				if(storeRel!='activity')	{
					$('.activity_screen_bottom').stop(true,true).hide();
				}else{
					$('.activity_screen_bottom').stop(true,true).show();
				}
			}
		});
		
		$('.upload_img').click(function(){	user_img();	 });
		$('.xcancel_btn').click(function(){	 unBlockUI();  });
		$("#cust_dob").datepicker({changeMonth: true,changeYear: true,dateFormat:'dd-mm-yy',dateFormat:'yy-mm-dd',yearRange: '1900:2022',showAnim: 'fadeIn'});
		
		$("#cust_city").autocomplete("<?php echo base_url(); ?>dashboard/getCity",	{ delay:10,minChars:1,	matchSubset:1, matchContains:1,	cacheLength:10, width: 420,	onItemSelect:selectItem, onFindValue:findValue,	formatItem:formatItem }	);
		$("#cust_state").autocomplete("<?php echo base_url(); ?>dashboard/getState",	{ delay:10,minChars:1,	matchSubset:1, matchContains:1,	cacheLength:10, width: 150,	onItemSelect:selectItem, onFindValue:findValue,	formatItem:formatItem }	);
		$("#cust_zip").autocomplete("<?php echo base_url(); ?>dashboard/getZip",	{ delay:10,minChars:1,	matchSubset:1, matchContains:1,	cacheLength:10, width: 180,	onItemSelect:selectItem, onFindValue:findValue,	formatItem:formatItem }	);
				
		
		$('#popup_close').click(function(){	
			unBlockUI();
		});
		$(window).resize(function() { setOverlayPos(); });
	});
	
	function key_skill()
	{
		$.blockUI({message: $('#upload_profile')});		
		setOverlayPos();
	}
	
	var base_url = "<?php echo base_url(); ?>";
	
	function formatItem(row) { return row[0]; }
	function selectItem(li,inp) { findValue(li,inp); $(inp).focus(); } 
	function findValue(li,input) {
		if( li == null ) 
		{
			$(input).next().val('');	
			return alert("No match!");
		}
		if( !!li.extra )
			var sValue = li.extra[0];
		else 
			var sValue = li.selectValue;
		
		$(input).next().val(sValue);	
	}
	
	function user_img()
	{
		$('#profile_upload_image').attr('src','<?php echo site_url('dashboard/ChangeImage/'); ?>');		
		$.blockUI({message: $('#user_img')});		
		setOverlayPos();
	}
	
	function unBlockUI()
	{	
		$.ajax({
				url:'<?php echo site_url('dashboard/GetProfileImage') ?>',
				type: 'POST',
				success:function(msg) {
							$('#user_dashbord_image').attr('src',msg);		
					}
			});
		$.unblockUI();
		$('#profile_upload_image').attr('src','');	
		$('#submit_review_iframe').attr('src','');	
		//$('.dashboard_iframe_class').attr('style','display:none;');	
	}
	function closebox(img_src)
	{
		$('#user_dashbord_image').attr('src',img_src);
		$.unblockUI();
		//$('.dashboard_iframe_class').attr('style','display:none;');
		$('#profile_upload_image').attr('src','');	
		$('#submit_review_iframe').attr('src','');		
	}
	function ShowActivity(flag)
	{
		if(flag == 'more')
		{		
			$('#more_activity').fadeIn();
			$('#less_activity').fadeOut();
		}
		else
		{
			$('#less_activity').fadeIn();
			$('#more_activity').fadeOut();
		}
	}
	
	function CloseReview()
	{
		$.unblockUI();
		$('.cart_add_suc_msg').html('Thank you for giving review.');
		$('.cart_add_error_msg').html('');
		$('.cart_add_suc_msg').stop( true, true).fadeIn();
		$('.cart_add_error_msg').stop( true, true).fadeOut();
		setTimeout('HideMessages()',3000);
		
	}
	
	function SubmitReview(course_id)
	{
		//alert(course_id);
		$('#submit_review_iframe').attr('src','<?php echo site_url('dashboard/submitreview/'); ?>'+'/'+course_id);	
		$.blockUI({message: $('#submit_review_div')});		
		setOverlayPos();
	}
</script>

<script type="text/javascript">
// for local 377294372316766 //for demo 167057113421719 //
var isLoaded = false;
var faceboolid=false;
<?php 
	$host= strtoupper($_SERVER['HTTP_HOST']);
	if($host == 'LOCALHOST')
	{
?>
	faceboolid=377294372316766;
<?php
	}
	else
	{
?>
	faceboolid=167057113421719;
<?php
	}
?>
window.fbAsyncInit = function() {
	FB.init({appId: faceboolid, status: true, cookie: true, xfbml: true,oauth : true});
	isLoaded = true;   
};

// Load the SDK Asynchronously
(function(d){
var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = "//connect.facebook.net/en_US/all.js";
d.getElementsByTagName('head')[0].appendChild(js);
}(document));


function facebook_login() {
   if(!isLoaded) {
       alert("JS-SDK is not yet loaded. Try again after few seconds.");	  
       return false;
   }
   FB.login(function(response) {
       if (response.authResponse) {
           var fb_access_token = response.authResponse.accessToken;
           FB.api('/me', function(response) {
                var fullName =  response.name;
                                var uname =fullName;
                                var email = response.email;
                                var id=response.id;
								//alert("hiiiii");
								//var fb_token=FB.getSession();
								//alert(fb_token.access_token);
								//return false;
								 document.getElementById('fb_facebook_id').value = response.id;
								 document.getElementById('fb_facebook_offline_token').value = fb_access_token;
								 document.facebook_login_form.submit();
           });
       }
   },{scope: 'offline_access'});
}
</script>
<form method="post" name="facebook_login_form" action="<?php echo site_url('dashboard/facebookLogin/');?>">
<input type="hidden" name="fb_facebook_id" id="fb_facebook_id" value="" />
<input type="hidden" name="fb_facebook_offline_token" id="fb_facebook_offline_token" value="" />
</form>
<?php 
	if($UserInfo['cust_avatar'])
		$small_name=base_url().$UserInfo['cust_avatar'];
	else
		$small_name=base_url().'images/user_default_logo.png';
?>
<!--Srart [ part2 ]-->
<div class="part2">
	<!--start[part content]-->
	<div class="part2_content_outer">
    	<div class="part2_contnet_inner">
        	
        	<div class="main_box">
	            <div class="user_image_space">
                	<div class="user_image_mask upload_img"></div>
                    <img src="<?php echo $small_name; ?>" id="user_dashbord_image" width="231" height="294" alt="<?php echo $UserInfo['cust_fname'].' '.$UserInfo['cust_lname'] ?>" />
                    <?php if(!$this->session->userdata('is_admin')) {?>
                        <a href="javascript:void(0);" onclick="javascript:facebook_login();" class="facebook_connect_btn"></a>
                        <a href="javascript:void(0);" class="upload_btn upload_img"></a>
					<?php } ?>
                </div>
                
                <div class="main_2">
                    <p class="high_black_text">Welcome back, <?php echo $UserInfo['cust_fname'].' '.$UserInfo['cust_lname'] ?></p>
                    <p  style="border-bottom:1px dotted #000;height:15px;"></p>
                    <!--start[menu]-->
                    <div class="user_menu_space">
                        <a class="user_menu_item user_menu_item_active" rel="activity">Activity</a>
                        <a class="user_menu_item" rel="courses">Courses</a>
                        <a class="user_menu_item" rel="profession">Professions</a>
                        <?php if(!$this->session->userdata('is_admin')) {?>
	                        <a class="user_menu_item" rel="account">Account</a>
                        <?php } ?>
                        <div class="clear"></div>
                    </div>
                    <!--end[menu]-->
                    
                     <!--start[menu Activity]-->
                    <div class="user_info" style="display:block;min-height:288px;" id="activity">
                    	<div class="user_info_ribben_outer">
                            <a class="aClick_btn"></a>
                            <div class="aAnimate_part"><div class="ribbin_round"></div><?php if($CouponInfo['coupon_name']) echo $CouponInfo['coupon_name'];else echo 'Sorry No Coupon Available For You.'; ?></div>
                            <span class="ribben_corner"></span>
                            <p class="account_form_title dash_tab_title">My Recent Activity</p>
                        </div>
                        <!--[bottom border]-->
                        <div class="account_form_raw"></div>
                        <!--[bottom border]-->
                    	
                    	<?php 
							foreach($RecentActivity as $key=>$val)
							{
								if($key <=2)
								{
								?>
								<div class="user_info_raw">
									<p class="user_status_lbl"><?php echo $this->mdl_dashbord->chaangedateformat($val['activity_timestamp']); ?></p>
									<p class="user_status_lbl2"><?php echo $val['activity_desc']; ?></p>
									<div class="clear"></div>
								</div>
								<?php
								}
							}	
							if(count($RecentActivity) > 3)					
								echo '<span id="less_activity"><a class="more_btn" onclick="ShowActivity(\'more\');"></a></span>';						
						?>                                      	                        
                    	<span id="more_activity" style="display:none;">
                    	<?php 
							foreach($RecentActivity as $key=>$val)
							{
								if($key > 2)
								{
								?>
								<div class="user_info_raw">
									<p class="user_status_lbl"><?php echo $this->mdl_dashbord->chaangedateformat($val['activity_timestamp']); ?></p>
									<p class="user_status_lbl2"><?php echo $val['activity_desc']; ?></p>
									<div class="clear"></div>
								</div>
								<?php
								}
							}	
							if(count($RecentActivity) > 3)					
								echo '<a class="less_btn" onclick="ShowActivity(\'less\');"></a>';						
						?>                                      
	                    </span>    
                     </div>
                    <!--end[menu Activity]-->
                    
                    <!--start[menu courses]-->
                    <div class="user_info" id="courses">
                    	<div class="user_info_ribben_outer">
                            <a class="aClick_btn"></a>
                            <div class="aAnimate_part"><div class="ribbin_round"></div><?php if($CouponInfo['coupon_name']) echo $CouponInfo['coupon_name'];else echo 'Sorry No Coupon Available For You.'; ?></div>
                            <span class="ribben_corner"></span>
                            <p class="account_form_title dash_tab_title">My Courses</p>
                        </div>                                                
                                 
                        <?php
						if($CompleteCourseInfo)
						{
							foreach($CompleteCourseInfo as $key=>$val)
							{
								if($val['course_image'])
									$small_name=base_url().$val['course_image'];
								else
									$small_name=base_url().'images/small_default.png';																			
								$url=site_url('course/index/').'/'.$val['course_id'].'/'.url_title($val['course_name']);								
								if($val['course_target_audiance'])
									$target_audiance='<p><b>Target Audience: </b></p>
											 <p>'.$val['course_target_audiance'].'</p>
											 <br />';	
								else
									$target_audiance='';							
								if($val['course_author'])							
								{
									$AuthourInfo=$this->mdl_author->getAuthuonfoById($val['course_author']);
									$authourname=$AuthourInfo['author_fname'].' '.$AuthourInfo['author_lname'];
								}
								else
									$authourname='';
								$OrderInfo=$this->mdl_order->GetOrderDate($val['order_id']);
								
								echo '<div class="account_form_raw padding_topbottom_20px">
									  	<a href="'.$url.'" title="'.$val['course_name'].'"><div class="dash_course_img_box"><img src="'.$small_name.'" width="150" height="218" alt="'.$val['course_name'].'" /></div></a>
										<div class="dash_course_right">
											<p class="profession_title">'.$val['course_name'].'</p>
											<p class="dash_course_subtitle">'.$authourname.'</p>
											<div class="dash_course_disc_space">
												<p><b>CE Credit:</b></p>
												<p>'.$val['course_ce_hours'].' Hours ('.$val['course_ce_hours'].' CEUs)</p>
												<br />'.$target_audiance.'
												<p><b>Learning Level: </b></p>
												<p>'.$val['course_learning_leve'].'</p>
											</div>
											<div class="dash_course_date_space">
												<p><b>Enrolled:</b></p>
												<p>'.date('m/d/Y',strtotime($OrderInfo['order_date'])).'</p>
												<br />
												<p><b>Completed: </b></p>
												<p>'.date('d/m/Y',strtotime($val['cur_responce']['test_passing_date'])).'</p>
											</div>
											<div class="clear"></div>
										</div>
										<div class="clear"></div>
									</div>';
									
							}
						}
						else
							echo ' <!--[bottom border]-->
			                       <div class="account_form_raw"></div>
            			           <!--[bottom border]-->
								   <div class="no_record_found" style="position:inherit !important;min-height:70px;" >Sorry No Record Found</div>';
						?>                                                     	                                                                                  
                        
                        <!--[bottom border]-->
                        <div class="account_form_raw"></div>
                        <!--[bottom border]-->
                     
                     </div>
                    <!--end[menu courses]-->
                    
                    <!--start[menu profession]-->
                    <div class="user_info" id="profession">
	                    <div class="user_info_ribben_outer">
                            <a class="aClick_btn"></a>
                            <div class="aAnimate_part"><div class="ribbin_round"></div><?php if($CouponInfo['coupon_name']) echo $CouponInfo['coupon_name'];else echo 'Sorry No Coupon Available For You.'; ?></div>
                            <span class="ribben_corner"></span>
                            <p class="account_form_title dash_tab_title">My Professions</p>
                        </div>
                        
                        <div class="account_form_raw padding_topbottom_40px">
                        	<div class="profession_left">
                            	<p class="profession_title">Counseling</p>
                                <div class="profession_disc">The definition of the profession goes here to explain what it is that this type of profession does. The definition of the profession goes here to explain what it is that this type of profession does. The definition of the profession goes here to explain what it is that this type of profession does.</div>
                            </div>
                            <div class="profession_right">
                            	<a href="#" class="backto_course_link view_coun_course_link">VIEW COUNSELING COURSES</a>
                            </div>
                            <div class="clear"></div>
                        </div>
                        
                        <div class="account_form_raw padding_topbottom_40px">
                        	<div class="profession_left">
                            	<p class="profession_title">Counseling</p>
                                <div class="profession_disc">The definition of the profession goes here to explain what it is that this type of profession does. The definition of the profession goes here to explain what it is that this type of profession does. The definition of the profession goes here to explain what it is that this type of profession does.</div>
                            </div>
                            <div class="profession_right">
                            	<a href="#" class="backto_course_link view_coun_course_link">VIEW COUNSELING COURSES</a>
                            </div>
                            <div class="clear"></div>
                        </div>
                        
                        <div class="account_form_raw padding_topbottom_40px">
                        	<div class="profession_left">
                            	<p class="profession_title">Counseling</p>
                                <div class="profession_disc">The definition of the profession goes here to explain what it is that this type of profession does. The definition of the profession goes here to explain what it is that this type of profession does. The definition of the profession goes here to explain what it is that this type of profession does.</div>
                            </div>
                            <div class="profession_right">
                            	<a href="#" class="backto_course_link view_coun_course_link">VIEW COUNSELING COURSES</a>
                            </div>
                            <div class="clear"></div>
                        </div>
                        
                     	<div class="account_form_raw" style="padding-top:20px;">
                        	<a href="#" class="add_profession_btn"></a>
                        </div>
                     </div>
                    <!--end[menu profession]-->
                    
                    <!--start[menu account]-->
                    <div class="user_info" id="account">
                    	<div class="user_info_ribben_outer">
                            <a class="aClick_btn"></a>
                            <div class="aAnimate_part"><div class="ribbin_round"></div><?php if($CouponInfo['coupon_name']) echo $CouponInfo['coupon_name'];else echo 'Sorry No Coupon Available For You.'; ?></div>
                            <span class="ribben_corner"></span>
                            <p class="account_form_title dash_tab_title">My Profile</p>
                        </div>
                        
                        <?php extract($UserInfo); ?>
                        
                        <form name="update_account_form" id="update_account_form" action="" method="post">
                        	<div class="account_form_raw">
                            	<p class="acc_form_lbl">First Name</p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_fname; ?>" name="cust_fname" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Last Name</p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_lname; ?>" name="cust_lname" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Email</p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_email; ?>" name="cust_email" readonly="readonly" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Company</p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_company; ?>" name="cust_company" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">City<?php echo $cust_city_name; ?></p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_city_name; ?>" name="cust_city" id="cust_city" class="acc_input_field" />
                                    <input type="hidden" value="<?php echo $cust_city; ?>" name="cust_city" class="cust_city" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">State</p>
                                <div class="acc_form_input_bg state">
                                	<input type="text" value="<?php echo $cust_state_name; ?>" name="cust_state" id="cust_state" class="acc_input_field" />
                                    <input type="hidden" value="<?php echo $cust_state; ?>" name="cust_state" class="cust_state" />
                                </div>
                                <p class="acc_form_lbl" style="width:184px;">Zip</p>
                                <div class="acc_form_input_bg zip">
                                	<input type="text" value="<?php echo $cust_zip_code; ?>" name="cust_zip" id="cust_zip" class="acc_input_field" />
                                    <input type="hidden" value="<?php echo $cust_zip; ?>" name="cust_zip" class="cust_zip" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Date of Birth</p>
                                <div class="acc_form_input_bg dob">
                                	<input type="text" value="<?php echo $cust_dob; ?>" name="cust_dob" id="cust_dob" readonly="readonly" class="acc_input_field" />
                                </div>
                                
                                <p class="acc_form_lbl">Gender</p>
                                <input type="radio" name="cust_gender" class="acc_radio" <?php echo ($cust_gender == "Male")?"checked":""; ?> value="Male" />
                                <p class="radio_lbl">Male</p>
                                
                                <input type="radio" name="cust_gender" class="acc_radio" <?php echo ($cust_gender == "Female")?"checked":""; ?> value="Female" />
                                <p class="radio_lbl">Female</p>
                                <div class="clear"></div>
                            </div>
                            
                            <p class="account_form_title">My Password</p>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Password</p>
                                <div class="acc_form_input_bg password">
                                	<input type="password" value="" name="cust_passwd" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">New Password</p>
                                <div class="acc_form_input_bg password">
                                	<input type="password" value="" name="cust_npasswd" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Confirm Password</p>
                                <div class="acc_form_input_bg password">
                                	<input type="password" value="" name="cust_rpasswd" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <p class="account_form_title">My Social Links</p>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Facebook</p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_facebook; ?>" name="cust_facebook" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Twitter</p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_twitter; ?>" name="cust_twitter" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">LinkedIn</p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_linkedin; ?>" name="cust_linkedin" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<p class="acc_form_lbl">Google+</p>
                                <div class="acc_form_input_bg">
                                	<input type="text" value="<?php echo $cust_google; ?>" name="cust_google" class="acc_input_field" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="account_form_raw">
                            	<input type="reset" value="" class="cancel_changes_btn" />
                            	<input type="button" value="" class="save_changes_btn" onclick="javascript:update_account()" />
                                <div class="clear"></div>
                            </div>
                        </form>
                     
                     </div>
                    <!--end[menu account]-->
                    
                </div>
                
                <div class="clear"></div>
            </div>
            
            <div class="activity_screen_bottom">
               <p style="height:30px;"></p>
               <p class="psychology_title" style="margin-left:25px;margin-right:25px;">Active Courses</p>                
                <!--start[active course_box]-->
                <div class="active_course_box">
					<?php 
                    if($ActiveCourseInfo)
                    {
                        foreach($ActiveCourseInfo as $key=>$val)
                        {
							$persocentage=0;
                            if($val['course_image'])
                                $small_name=base_url().$val['course_image'];
                            else
                                $small_name=base_url().'images/small_default.png';																			
                            $url=site_url('course/index/').'/'.$val['course_id'].'/'.url_title($val['course_name']);
                            $disp_url=$test_url=$text=$review_url='';							
                            if($val['cur_responce']['current_responce'] == "Stop" || $val['cur_responce']['current_responce'] == "Running")
                            {
                                $test_url=site_url('test/resume/'.$val['course_id'].'/'.$val['order_id']);							
								$disp_url='<a href="'.$test_url.'" class="text_space_in1">Resume Test</a>';
                            }
                            else
                            {						    
                                $test_url=site_url('test/index/'.$val['course_id'].'/'.$val['order_id']);
								$disp_url='<a href="'.$test_url.'" class="text_space_in1">Take A Test</a>';
                            }
							if($val['cur_responce']['responce_status'] == 'Passed')
									$disp_url='<div class="right_img" style="height:15px;"></div>
		                                        <p class="checkbox_lbl"><s>Pass out</s></p><div class="clear"></div>';
							else if($val['cur_responce']['responce_status'] == 'Failed' && $val['no_of_attempt']>2)
								$disp_url='<div class="wrong_img" style="height:15px;"></div>
											<p class="checkbox_lbl"><s>Failed</s></p><div class="clear"></div>';
							$passed_percentage='';
							
                            $review_url=site_url('course/index/'.$val['course_id'].'#customer_review');
							
							if($val['course_target_audiance'])
								$target_audiance='<p style="margin-top:8px;">Target Audience:</p>
					 							  <p><span>Psychology | Counseling | Social-Work |</span> </p>';
							else
								$target_audiance='';
							$TotalQuestion=$val['cur_responce']['no_of_question'];
							if(!isset($TotalQuestion))
								$TotalQuestion=1;
							$RightAns=$this->mdl_test->GetRightAnsCount($val['cur_responce']);
							if($RightAns<1)
								$RightAns=0;
							$persocentage=($RightAns*100)/$TotalQuestion;	
							if(!isset($persocentage))	
								$persocentage=0;
                            echo '<div class="content_box">
                                    <a href="'.$url.'" title="'.$val['course_name'].'"><div class="new_img_space"><img style="max-height:218px;max-width:150px;" src="'.$small_name.'" alt="" /></div></a>
                                    <div class="text_space">                                        
                                        <div class="text_space_in1">'.$disp_url;
										if($val['course_pdf_content'])
	                            			echo '<a href="'.base_url().$val['course_pdf_content'].'" target="_blank" class="text_space_in1">Download PDF</a>';											
                                       echo '<a class="text_space_in1">Online Reader</a>
                                        <a class="text_space_in1">Help</a> 
                                        <a href="javascript:void(0);" onclick="javascript:SubmitReview('.$val['course_id'].');" class="text_space_in1">Submit review</a>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
									<div class="text_1_space" style="border:none;">
										<div class="text_1_inner">
											<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="ExternalInterfaceExample" width="150" height="70" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab">
												 <param name="movie" value="'.base_url().'swf/percentage_slider.swf" />
												 <param name="quality" value="high" />
												 <param name="allowScriptAccess" value="sameDomain" />
												 <param name="flashvars" value="progress='.$persocentage.'" />
												 <param name="wmode" value="transparent" />
												 <embed src="'.base_url().'swf/percentage_slider.swf" wmode="transparent" quality="high" width="150" height="70" name="ExternalInterfaceExample" align="middle" play="true" loop="false" quality="high" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"                  pluginspage="http://www.macromedia.com/go/getflashplayer"  flashvars="progress='.$persocentage.'">
												 </embed>
											 </object>
										</div>
										<div class="text_1_inner" style="margin-top:28px;">
											<p>CE Credit:</p>
											<p><span>'.$val['course_ce_hours'].' Hours ('.$val['course_ce_ceus'].' CEUs)</span></p>
											'.$target_audiance.'
											<p style="margin-top:8px;">Learning Level:</p>
											<p><span>'.$val['course_learning_level'].'<span></p>
										
										</div>
									</div>
									<div class="clear"></div>
                                </div>';								
								/* Old Code
									<input name="" type="checkbox" value="" class="dot_img">
                                    <div class="text_1_space">
                                        <p style="color:#000000;"><strong>'.$val['course_name'].'</strong></p>
                                        <p>'.$val['course_name'].'</p>
                                        <br/>
                                        <p><strong>CE Credit:</strong> '.$val['course_ce_hours'].' Hours (0.3 CEUs)</p>
                                        <p><strong>Target Audience:</strong> '.substr(strip_tags($val['course_target_audiance']),0,100).'</p>
                                        <p><strong>Learning Level:</strong> '.$val['course_learning_level'].'</p>
                                    </div>
								*/
                        }
                    }
                    else
                        echo '<div class="no_record_found" style="position:inherit !important;min-height:70px;" >Sorry No Record Found</div>';
                    ?>                                                                     
                </div>
            </div>
        </div>
     </div>
</div>
<!--End [ part2 ]-->

<div class="cart_add_suc_msg" style="display:none;"></div>
<div class="cart_add_error_msg" style="display:none;"></div>
<!--popup start]-->
<div class="dashboard_iframe_class" id="user_img" style="display:none !important;">
     <iframe id="profile_upload_image" src="" style="border:none; width:100%; height:100%;"></iframe>          	
     <a class="popup_close" id="popup_close"></a>
</div>

<div class="dashboard_iframe_review" id="submit_review_div">
<iframe src="" id="submit_review_iframe"  style="border:none; width:100%; height:100%;"></iframe>          
<a class="cancel_btn xcancel_btn"></a>
</div>  
<!--popup end]-->