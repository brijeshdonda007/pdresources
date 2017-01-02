<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $page_title?$page_title:'Home :: PDR'; ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/default.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/slidingtabs-horizontal.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.slidingtabs.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.easing.1.3.js"></script>
<script language="javascript" type="text/javascript">
	var base_url='<?php echo base_url(); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/default.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/cart.js"></script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		$('.signup_msg_close').off('click').on('click',function(){
			$(this).parent().stop(true, true).fadeOut();
		});
		//for show cart bucket overlay
		$('.cart_bucket, .cart_item_count').click(function(){		
			GetCartContent();
		});
		//for the  autosuggest			
		$("#header_course_name").autocomplete("<?php echo base_url(); ?>home/GetCourseHeader",
			{
				delay:10,
				minChars:1,	
				matchSubset:1,	
				matchContains:1,
				cacheLength:10,	
				onItemSelect:selectItem, 
				onFindValue:findValue,	
				formatItem:formatItem 
		//			autoFill:true,
		//			formId:'#search_book'
			}			
		);
		//for the success and error message in the header		
		<?php if($SucMsg){
	?>
		$('.header_msgs.success span').html('<?php echo $SucMsg; ?>');
		$('.header_msgs.warning span').html('');
		$('.header_msgs.success').stop( true, true).fadeIn();
		$('.header_msgs.warning').stop( true, true).fadeOut();
	<?php
		} 
		elseif($ErrMsg)
		{
	?>
		$('.header_msgs.warning span').html('<?php echo $ErrMsg; ?>');
		$('.header_msgs.success span').html('');
		$('.header_msgs.warning').stop( true, true).fadeIn();
		$('.header_msgs.success').stop( true, true).fadeOut();
	<?php
		}
	?>
	
	});
	//for the autosuggest
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
		else var sValue = li.selectValue;
		
		$(input).next().val(sValue);		
	}

	//To Autologout funcitonality
	var t;
	function setTimeOfSite()
	{
		clearTimeout(t);
		t=setTimeout("LogoutProcess()",6480000);//6480000 //30000
	}
	function LogoutProcess()
	{
		window.location="<?php echo site_url('login/logout'); ?>";
	}		
	//For the buggy related
	function SubmitBuggy()
	{
		var msg='';
		var buggy_email=$('#buggy_email').val();
		var buggy_msg=$('#buggy_msg').val();
		if(buggy_email == '' || buggy_email.length <= 0)
		{
			msg='Please enter Email';
			$('.buggy_msgs.success span').html(msg);
			$('.buggy_msgs.warning span').html(msg);
			$('.buggy_msgs.success').stop( true, true).fadeOut();
			$('.buggy_msgs.warning').stop( true, true).fadeIn();
			$('#buggy_email').focus();
			return false;			
		}
		else if(!email_validation(buggy_email))
		{
			msg='Please enter Valid Email';
			$('.buggy_msgs.success span').html(msg);
			$('.buggy_msgs.warning span').html(msg);
			$('.buggy_msgs.success').stop( true, true).fadeOut();
			$('.buggy_msgs.warning').stop( true, true).fadeIn();
			$('#buggy_email').focus();			
			return false;			
		}
		else if(buggy_msg == '' || buggy_msg.length <= 0)
		{
			msg='Please enter Message';
			$('.buggy_msgs.success span').html(msg);
			$('.buggy_msgs.warning span').html(msg);
			$('.buggy_msgs.success').stop( true, true).fadeOut();
			$('.buggy_msgs.warning').stop( true, true).fadeIn();
			$('#buggy_msg').focus();			
			return false;			
		}
		else
		{
			$.ajax({
				type:'post',
				url:"<?php echo site_url('home/buggyMail'); ?>",
				data:$('#buggie_email_form').serialize(),
				success:function(msg){					
					if(msg ==1)
					{
						msg='Please enter Email';
						$('.buggy_msgs.success span').html(msg);
						$('.buggy_msgs.warning span').html(msg);
						$('.buggy_msgs.success').stop( true, true).fadeOut();
						$('.buggy_msgs.warning').stop( true, true).fadeIn();
						$('#buggy_email').focus();			
					}
					else if(msg == 2)
					{
						msg='Please enter Valid Email';
						$('.buggy_msgs.success span').html(msg);
						$('.buggy_msgs.warning span').html(msg);
						$('.buggy_msgs.success').stop( true, true).fadeOut();
						$('.buggy_msgs.warning').stop( true, true).fadeIn();
						$('#buggy_email').focus();			
						return false;			
					}
					else if(msg == 3)
					{
						msg='Please enter Message';
						$('.buggy_msgs.success span').html(msg);
						$('.buggy_msgs.warning span').html(msg);
						$('.buggy_msgs.success').stop( true, true).fadeOut();
						$('.buggy_msgs.warning').stop( true, true).fadeIn();
						$('#buggy_msg').focus();			
						return false;			
					}			
					else
					{
						$('#buggy_email').val('');			
						$('#buggy_msg').val('');			
						msg='<?php echo $this->mdl_constants->Messages(25); ?>';
						$('.buggy_msgs.success span').html(msg);
						$('.buggy_msgs.warning span').html(msg);
						$('.buggy_msgs.success').stop( true, true).fadeIn();
						$('.buggy_msgs.warning').stop( true, true).fadeOut();												
					}
				}
			});		
		}
		return false;
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
<!--[if IE]>
<link href="<?php echo base_url(); ?>css/ie.css" rel="stylesheet" type="text/css" media="all">
<![endif]-->
</head>

<body <?php if($this->session->userdata('cust_id')) echo 'onLoad="javascript:setTimeOfSite()"'; ?>>

<div id="fb-root"></div>
<!--start[cart slider]-->
<div class="cart_slider_overlay">
</div>
<!--end[cart slider]-->


<!--Srart [ part1 ]-->
<div class="part1">
	<div class="part1_content">
    	<a href="<?php echo site_url(); ?>" class="pdr_logo"></a>
        
        <div class="cart_bucket_space">
            <span class="cart_bucket"></span>
            <span class="cart_item_count" style="cursor:pointer;"><?php echo $this->cart->total_items(); ?></span>
            <div class="clear"></div>
        </div>
            
	      <div class="header_msgs signup_msg success" style="display:none;width: 300px;position: absolute;top: 0px;left: 310px;">
          	Success: <span></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close">
          </div>
          <div class="header_msgs signup_msg warning" style="display:none;width: 300px;position: absolute;top: 0px;left: 310px;">
          	Warning: <span></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close">
          </div>
	      <div class="signin_register_space">
	        <p class="logedin_username"><span style="color:#7c7c7c;font-weight:normal;">Welcome back,</span> <?php if($this->session->userdata('cust_id')) echo $this->session->userdata('cust_fname').' '.$this->session->userdata('cust_lname');else echo 'Guest'; ?></p>
        	<?php if($this->session->userdata('cust_id')){?>
	            	<a href="<?php echo site_url('dashboard'); ?>" class="login_link">Dashboard</a> <span style="color:#7c7c7c;"> • </span> <a href="<?php echo site_url('login/logout'); ?>" class="login_link">Logout</a>
            <?php }else{ ?>
       	        	<a href="<?php echo site_url('login'); ?>" class="login_link">Sign in</a> <span style="color:#7c7c7c;"> • </span> <a href="<?php echo site_url('signup'); ?>" class="login_link">Register</a>
            <?php } ?>
        </div>
        <div class="clear"></div>
        <!--start[menu]-->
        <div class="menu_space">
        	<?php 
				$page_link=$this->mdl_page->get_header_page();
				
			 	if($page_link)
				{
					foreach($page_link as $key=>$val)
					{
						if($key == 0)
							$addclass="menu_item_first";
						else
							$addclass='';
						$url=site_url('page/index/'.$val['page_id']);//$val['page_id'];						
						echo '<a href="'.$url.'" class="menu_item '.$addclass.'">'.$val['page_title'].'</a>';
					}
				}
			?>
           	<?php if($this->session->userdata('cust_id')){?>
            	<a href="<?php echo site_url('dashboard'); ?>" class="menu_item">Dashboard</a>
            <?php } ?>
            <span class="menu_item_last_seprate"></span>
            
            <!--start[search from]-->
            <div class="search_space">
            	<form name="search_form" action="<?php echo site_url('course/SearchCourse/'); ?>" method="post">
                	<input id="header_course_name" name="header_course_name" type="text" value="Search" class="search_input_field" onFocus="if(this.value=='Search')this.value=''" onblur="if(this.value=='')this.value='Search'" />
                    <input type="hidden" id="header_course_id" name="header_course_id">
                    <input type="submit" value="" class="search_sub_btn" />
                </form>
            </div>
            <!--end[search from]-->
            
            <div class="clear"></div>
        </div>
        <!--end[menu]-->
    </div>
</div>
<!--End [ part1 ]-->

<!--start[help popup]-->
<div class="help_slider">
    <a href="javascript:void(0);" class="help_slider_link"></a>
    <div class="buggy_msgs signup_msg success" style="display:none;width: 300px;position: absolute;top: -37px;left: 10px;">
        Success: <span></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close">
    </div>
    <div class="buggy_msgs signup_msg warning" style="display:none;width: 300px;position: absolute;top: -37px;left: 10px;">
        Warning: <span></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close">
    </div>
    <div class="help_slider_container">
    	<div class="help_slider_title_space">
        	<p class="help_slider_title open">BUGGIE</p>
        	<div class="buggie_disc" style="display:block;">You can report any issues or bugs with our always active window. Just click on the question mark and a form window will open and it will record the page where you are and allow you to enter your message or issue found. We will work diligently to fix the issue.</div>
        </div>
        <div class="buggie_email_form_space">
        	<form name="buggie_email_form" id="buggie_email_form" action="<?php echo site_url('home/buggyMail')?>" method="post" onSubmit="return SubmitBuggy();">	            
            	<div class="buggie_form_raw">
                	<p class="buggie_form_lbl">Email</p>
                    <input type="text" name="buggy_email" id="buggy_email" class="buggie_form_input" />
                </div>
                <div class="buggie_form_raw">
                	<p class="buggie_form_lbl">Message</p>
                    <div class="buggie_form_area_bg">
                    <textarea name="buggy_msg" name="buggy_msg" id="buggy_msg" class="buggie_form_area"></textarea>
                    </div>
                </div>
                <input type="submit" value="SUBMIT TO BUGGIE" name="buggie_submit" class="buggie_sub_btn" />
                <input type="hidden" name="current_location" id="current_location" value="<?php echo current_url(); ?>">
                <div class="clear"></div>
            </form>
        </div>
    </div>
</div>
<!--end[help popup]-->