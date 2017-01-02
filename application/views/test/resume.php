<script type="text/javascript" src="<?php echo base_url(); ?>js/jqueryBlockNew.js"></script>
<script language="javascript" type="application/javascript">
	$(document).ready(function() {
		var total = ($('.te_slider_part #testing_slider_st_horizontal .st_tabs li').size()>1)? $('.te_slider_part #testing_slider_st_horizontal .st_tabs li').size()-1:CheckCompletion();
		$('.st_next').click(function(){												
				if(!$(this).hasClass('st_btn_disabled')){				
					UpdateInfo();						
				}	
				if(total == $('.st_tab_view.st_active_view').find('.questposions').val())								
					CheckCompletion();				
			});
				
		$('.st_prev').click(function(){		
				$('.te_pause_test').show();
				$('.te_complete_test').hide();					
				if(!$(this).hasClass('st_btn_disabled'))
				{					
					UpdateInfo();											
				}
			});	
			
		//te progress slider
		if($('.te_slider_part #testing_slider_st_horizontal .st_tabs li').size()>0)
		{		
			$('.te_slider_part #testing_slider_st_horizontal').slideTabs({
				contentAnim: 'slideH',
				contentAnimTime: 600,
				contentEasing: 'easeInOutExpo',
				orientation: 'horizontal',
				tabsAnimTime: 300,
				offsetBR:3,
				buttonsFunction: 'click',
				changeSlide:function(){
					countSlide();
					progressBar();
					
				}
			});
			countSlide();
			progressBar();
		}
		
		$('.upload_img').click(function(){	popup_block();	 });
		$('.xcancel_btn').click(function(){	 unBlockUI();  });
		
		<?php if($is_passed) echo 'UserPassouttest()'; ?>
		<?php if($is_failed) echo 'UserFailedtest()'; ?>	
		<?php if(count($TestQuestionInfo)<1 || !$TestQuestionInfo) echo "$('.responce_hidden_part').fadeOut();"; ?>						
	});
	
	function popup_block()
	{
		$('#profile_upload_image').attr('src','<?php echo site_url('dashboard/ChangeImage/'); ?>');		
		$.blockUI({message: $('#user_img')});		
		setOverlayPos();
	}
	
	function unBlockUI()
	{	
		$.unblockUI();
		$('#profile_upload_image').attr('src','');	
	}
	
	function UpdateInfo()
	{
		var question_id=$('.st_tab_view.st_active_view').find('.questionsids').val();
		var cust_id=$('#cust_id').val();
		var course_id=$('#course_id').val();
		var test_id=$('#test_id').val();
		var order_id=$('#order_id').val();
		var test_attampt=$('#test_attampt').val();
		if($('.st_tab_view.st_active_view').find('.testoptions:radio:checked').val() > 0)						
			var selected_option=$('.st_tab_view.st_active_view').find('.testoptions:radio:checked').val();
		else
			var selected_option=0;
		var rightoption=$('.st_tab_view.st_active_view').find('.is_right_option').val();
		
		var formdata={
			question_id:question_id,
			cust_id:cust_id,
			course_id:course_id,
			order_id:order_id,
			test_id:test_id,
			test_attampt:test_attampt,
			selected_option:selected_option,
			rightoption:rightoption,
		};
		common_ajax('<?php echo site_url('test/saveTestResponceDetail/');?>',formdata);		
	}
	
	function common_ajax(dest_url,Cdata)
	{
		$.ajax({
				url: dest_url,
				type: 'POST',
				async:false,
				data: Cdata,
				success: function(msg) {										
									},
			});
	}
	
	function CheckCompletion()
	{
			$('.te_pause_test').hide();
			$('.te_complete_test').show();
	}
	
	var total_slide='';
	var active_slide_tab='';
	var active_no='';
	var new_active_slide_tab='';
	
	function countSlide(){
		total_slide= $('#testing_slider_st_horizontal .st_tabs li').size();
		active_slide_tab= $('#testing_slider_st_horizontal ul.st_tabs li a.st_tab_active').attr('rel');
		new_active_slide_tab= $('#testing_slider_st_horizontal ul.st_tabs li a.st_tab_active').parent('li').index();
		active_no= active_slide_tab.replace('tab_','');
		$('.te_bottom_left').html(active_no+'/'+total_slide);
	}
	
	function progressBar(){
		var progressWidth= (100*new_active_slide_tab)/total_slide;
		$('.progress_btn_inner .progress_btn_un').animate({width:progressWidth+'%'});
		var percentage= Math.round(progressWidth);
		$('.te_percentage_part .proegress_count_text').text(percentage+'%');
	}
	
	function PauseTest()
	{
		UpdateInfo();											
		var cust_id=$('#cust_id').val();
		var course_id=$('#course_id').val();
		var test_id=$('#test_id').val();
		var order_id=$('#order_id').val();
		var test_attampt=$('#test_attampt').val();		
		var cur_position=$('.st_tab_view.st_active_view').find('.questposions').val();
		var formdata={
			cust_id:cust_id,
			course_id:course_id,
			test_id:test_id,
			order_id:order_id,
			test_attampt:test_attampt,
			cur_position:cur_position
		};
		
		$.ajax({
				url: '<?php echo site_url('test/StopTest/');?>',
				type: 'POST',
				async:false,
				data: formdata,
				success: function(msg) {										
					//alert(msg);
					if(msg)
						window.location="<?php echo site_url('dashboard'); ?>";
					else
					{
						$('.warning span').html('Error in processing.Please retry again.');					
						$('.warning').stop( true, true).fadeIn();
					}
				},
			});	
	}

	function CompleteTest()
	{	
		UpdateInfo();												
		var cust_id=$('#cust_id').val();
		var course_id=$('#course_id').val();
		var order_id=$('#order_id').val();
		var test_id=$('#test_id').val();
		var test_attampt=$('#test_attampt').val();		
		var cur_position=$('.st_tab_view.st_active_view').find('.questposions').val();
		var formdata={
			cust_id:cust_id,
			course_id:course_id,
			test_id:test_id,
			order_id:order_id,
			test_attampt:test_attampt,
			cur_position:cur_position
		};
		
		$.ajax({
				url: '<?php echo site_url('test/CompleteTest/');?>',
				type: 'POST',
				async:false,
				dataType:'json',
				data: formdata,
				success: function(msg) {										
					//alert(msg[0]);
					if(msg[0] == 'Passed')
					{
						$('#exam_pass_space .user_bg_smily').fadeIn();
						//window.location="<?php echo site_url('dashboard'); ?>";
					}
					else if(msg[0] == 'Failed')
					{
						if(test_attampt == 1)
						{
							$('.responce_hidden_part').fadeOut();
							$('.te_slider_part').fadeOut();
							$('#test_attemp_fail_1').fadeIn();
							$('#test_attemp_fail_1 .user_detail_space .title_text span').html(msg[1]);
						}
						else if(test_attampt == 2)
						{
							$('.responce_hidden_part').fadeOut();
							$('.te_slider_part').fadeOut();
							$('#test_attemp_fail_2').fadeIn();
						}
						else
						{
							$('.responce_hidden_part').fadeOut();							
							$('.exam_faild_space').fadeIn();										
						}
					}
					else
					{
						$('.warning span').html('Error in processing.Please retry again.');					
						$('.warning').stop( true, true).fadeIn();
					}
				},
			});		
	}
			
	function SubmitReview(course_id,current_url)
	{
		//alert(course_id);
		$('#submit_review_iframe').attr('src','<?php echo site_url('test/submitreview/'); ?>'+'/'+course_id+'/'+current_url);	
		$.blockUI({message: $('#submit_review_div')});		
		setOverlayPos();
	}
	
	function CloseReview()
	{
		$.unblockUI();
		$('.cart_add_suc_msg').html('Thank you for reporting us.');
		$('.cart_add_error_msg').html('');
		$('.cart_add_suc_msg').stop( true, true).fadeIn();
		$('.cart_add_error_msg').stop( true, true).fadeOut();
		setTimeout('HideMessages()',3000);
		
	}
	
		
	function UserPassouttest()
	{
		$('.responce_hidden_part').fadeOut();
		$('#exam_pass_space .user_bg_smily').fadeIn();
	}

	function UserFailedtest()
	{
		$('.responce_hidden_part').fadeOut();
		$('.exam_faild_space').fadeIn();
	}
	
</script>
<!--Srart [ part2 ]-->
<div class="part2"> 
  <!--start[part content]-->
  <div class="part2_content_outer">
    <div class="te_progress_part">
      <div class="te_here_is">Here is your online test module, you are able to move forward and backwards any time. Also, you can pause and resume your session for later review.</div>
      <div class="te_percentage_part responce_hidden_part">
        <div class="progras_text">PROGRESS</div>
        <div class="progress_btn">
          <div class="progress_btn_inner">
            <div class="progress_btn_un"></div>
          </div>
        </div>
        <p class="proegress_count_text"></p>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>
    
    <!--start[white box]-->
    <div class="part2_contnet_inner">
      <div class="content_box" style="position:relative;">     
          <!--start[exam pass space]-->                    
          <div class="user_space" id="exam_pass_space">
            <div class="user_bg_smily">
                <p style="height:80px;"></p>
                <p class="fail_heading">Congratulations, <?php echo $this->session->userdata('cust_fname').' '.$this->session->userdata('cust_lname'); ?>!!</p>
                <p class="fail_heading" style="padding-bottom:10px;">You have successfully passed the test!</p>
                <div style="width:250px;margin:auto;">
                    <p class="sub_navigation" style="margin-top:35px;width:340px;"></p>
                    <p class="title_navigation" style="border:none; margin-bottom:10px;width:340px;">• CONTINUE TO EVALUATION OF COURSE</p>
                    <a href="<?php echo site_url('test/evaluation/'.$course_id.'/'.$order_id);?>" class="continue_btn"></a>
                </div>
	        </div>          
        </div>
          <!--end[exam pass space]--> 
          
          <!--start[exam pass space]-->
          <div class="user_space" style="display:none;" id="test_attemp_fail_1">
                <div class="user_img"></div>
                <div class="user_detail_space">
                    <p class="title_text"><?php echo $this->session->userdata('cust_fname').' '.$this->session->userdata('cust_lname'); ?>...</p>
                    <p class="title_text">You did not pass the test. We have calculated that the following questions were the ones that got you : <span>7, 14, 16, 18, 20</span>.</p>
                    <div class="border_bottom">
                        <ul class="ul_ex">
                            <li class="li_ex"><a style="color:#252525;" href="<?php echo site_url('test/index/'.$course_id.'/'.$order_id); ?>">TRY AGAIN ? (<span>2 RETRIES LEFT</span>)</a></li>
                        </ul>
                    </div>
                    
                    <div class="border_bottom">
                        <ul class="ul_ex">
                            <li class="li_ex"><a style="color:#252525;" href="<?php echo site_url('dashboard'); ?>">TAKE ME TO THE DASHBOARD</a></li>
                        </ul>
                    </div>
                    
                    <div class="border_bottom" style="border:none;">
                        <ul class="ul_ex">
                            <li class="li_ex"><a style="color:#252525;" href="javascript:SubmitReview(<?php echo $course_id; ?>,'<?php echo addslashes('test++index++'.$course_id.'++'.$order_id); ?>');">REPORT A PROBLEM?</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
          <!--end[exam pass space]-->
          
          <!--start[exam pass space]-->
          <div class="user_space" style="display:none;" id="test_attemp_fail_2">
            <div class="user_img"></div>
            <div class="user_detail_space">
                <p class="title_text">NO way!</p>
                <p class="title_text">You did not pass the test. Take at the options below we addes a cheat for you!</p>
                
                <a href="javascript:SubmitShowChit();" class="hint_btn"></a>
                <form name="test_attempt_2" id="test_attempt_2" action="<?php echo site_url('test/showchits');?>" method="post">
                        <input type="hidden" id="test_attampt" name="test_attampt" value="<?php echo $test_attampt; ?>" />
                        <input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>" />
                        <input type="hidden" id="cust_id" name="cust_id" value="<?php echo $cust_id; ?>" />                            
                        <input type="hidden"  id="test_id"  name="test_id" value="<?php echo $TestInfo['test_id']; ?>" />
                        <input type="hidden"  id="order_id"  name="order_id" value="<?php echo $order_id; ?>" />                                                        
                </form>
                <div class="border_bottom">
                    <ul class="ul_ex">
                        <li class="li_ex"><a style="color:#252525;" href="<?php echo site_url('test/index/'.$course_id.'/'.$order_id); ?>">TRY AGAIN ? (<span>1 RETRIES LEFT</span>)</a></li>
                    </ul>
                </div>
                
                <div class="border_bottom">
                    <ul class="ul_ex">
                        <li class="li_ex"><a style="color:#252525;" href="<?php echo site_url('dashboard'); ?>">TAKE ME TO THE DASHBOARD</a></li>
                    </ul>
                </div>
                
                <div class="border_bottom" style="border:none;">
                    <ul class="ul_ex">
                        <li class="li_ex"><a style="color:#252525;" href="javascript:SubmitReview(<?php echo $course_id; ?>,'<?php echo addslashes('test++index++'.$course_id.'++'.$order_id); ?>');">REPORT A PROBLEM?</a></li>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        </div>
          <!--end[exam pass space]-->
      
          <!--start[exam fail space]-->
          <div class="exam_faild_space">
              <p style="height:75px;"></p>
              <p class="fail_heading">We’re sorry, <?php echo $this->session->userdata('cust_fname').' '.$this->session->userdata('cust_lname'); ?></p>
              <p class="fail_heading" style="padding-bottom:10px;">You did not pass the test successfully.</p>
              <div style="width:255px;margin:auto;">
                <?php if($reenrollflag) { ?>
              	<p class="sub_navigation">• <a href="javascript:AddTocart(<?php echo $course_id; ?>);" style="color:#252525;" href="">RE-ENROLL TO THIS COURSE</a></p>
              <?php } ?>
              <p class="sub_navigation">• <a  style="color:#252525;" href="<?php echo site_url('dashboard'); ?>">GO TO YOUR DASHBOARD</a></p>
              <p class="sub_navigation" style="border:none;">• <a style="color:#252525;" href="javascript:SubmitReview(<?php echo $course_id; ?>,'<?php echo addslashes('test++index++'.$course_id.'++'.$order_id); ?>');">REPORT A PROBLEM?</a></p>
              </div>
          </div>
          <!--end[exam fail space]-->          

        <div class="te_slider_part"> 
        	<?php if($TestQuestionInfo){
					$counter=count($TestQuestionInfo);					
					
			?>
                <!-- Start HTML - Horizontal tabs -->
                  <div id="testing_slider_st_horizontal" class="st_horizontal">
                  	 <a href="#prev" class="st_prev st_btn_disabled" rel="testing_slider_st_horizontal"></a> 
                     <a href="#next" class="st_next <?php if($counter<=1) echo 'st_btn_disabled'; ?>" rel="testing_slider_st_horizontal"></a>
                    <div class="pagging_frame">
                      <div class="st_tabs_container">
                        <div class="st_slide_container">
                          <ul class="st_tabs">
                          	<?php 
								for($i=1;$i<=$counter;$i++)
								{									
									echo '<li><a href="#st_content_'.$i.'" rel="tab_'.$i.'" class="st_tab"></a></li>';
								}
							?>
                          </ul>
                        </div>
                        <div class="clear"></div>
                      </div>
                    </div>
                    <div class="st_view_container">
                      <div class="st_view">
                      		<input type="hidden" id="responce_page_no" name="responce_page_no" value="<?php if($Responce['current_page_no'] > 1) echo ($Responce['current_page_no']-1);else echo 0; ?>" />
                            <input type="hidden" id="test_attampt" name="test_attampt" value="<?php echo $test_attampt; ?>" />
                            <input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>" />
                            <input type="hidden" id="cust_id" name="cust_id" value="<?php echo $cust_id; ?>" />                            
                            <input type="hidden"  id="test_id"  name="test_id" value="<?php echo $TestInfo['test_id']; ?>" />                            
                            <input type="hidden"  id="order_id"  name="order_id" value="<?php echo $order_id; ?>" />                            
                      		<?php 
								foreach($TestQuestionInfo as $key=>$val)
								{
									$counter=$key+1;
									$question_id=$val['question_id'];
									if($Responce['current_page_no'] > 0 && $Responce['current_page_no'] == $counter)	
										$active='active_slider';
									else
										$active='';
																		
									echo '<div id="st_content_'.$counter.'" class="st_tab_view '.$active.'"> 
											<span>'.$val['question_text'].'</span>';									
									echo '<div>';
									foreach($val['options'] as $key2=>$val2)
									{
										if($val['responce'] == $val2['option_id'])
											$flag='checked="checked"';
										else
											$flag='';
										echo '<p class="radio_parent"><label><input '.$flag.' name="options'.$question_id.'[]" class="testoptions" type="radio" value="'.$val2['option_id'].'">'.$val2['option_text'].'</label></p>';
										//echo '<em><label><input '.$flag.' name="options'.$question_id.'[]" class="testoptions" type="radio" value="'.$val2['option_id'].'">'.$val2['option_text'].'</label></em>';
										if($val2['is_right_option'] == 'Yes')
											echo '<input type="hidden" name="is_right_option" class="is_right_option" value="'.$val2['option_id'].'" >';
											 
									}
									echo '<input type="hidden" name="question_id" value="'.$question_id.'" class="questionsids">';
									echo '<input type="hidden" name="quest_posion" value="'.$counter.'" class="questposions">';									
									echo '</div></div>';
								}
							?>
                      </div>
                      <!-- /.st_view --> 
                    </div>
                    <!-- /.st_view_container --> 
                  </div>
	            <!-- End HTML - Horizontal tabs --> 
            <?php	
			}
			else
				echo '<div class="no_record_found">Sorry No Record Found</div>';
			?>  
          
          
        </div>
      </div>
    </div>
    <!--end[white box]-->
    
    <div class="te_bottom_part responce_hidden_part">
      <div class="te_bottom_left"></div>
      <div class="error_msg_space_signup">	                    	
           <div class="signup_msg warning" style="display:none;">Warning: <span></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close"><div class="clear"></div></div>
        	            </div>
      <?php if(count($TestQuestionInfo) == 1) 
	  		{
				$complete ='';
	  			$pause='style="display:none;"';
			}
			else
			{
				$complete='style="display:none;"';
				$pause='';				
			}
	   ?>
      <a <?php echo $pause; ?> onclick="PauseTest();" class="te_pause_test"></a>
      <a <?php echo $complete; ?> onclick="CompleteTest();" class="te_complete_test"></a>
      <div class="clear"></div>
    </div>
  </div>
  <!--start[part content]--> 
</div>
<!--End [ part2 ]-->

<div class="cart_add_suc_msg" style="display:none;"></div>
<div class="cart_add_error_msg" style="display:none;"></div>
<!--popup start]-->
<div class="dashboard_iframe_review" id="submit_review_div">
	<iframe src="" id="submit_review_iframe"  style="border:none; width:100%; height:100%;"></iframe>          
	<a class="cancel_btn xcancel_btn"></a>
</div>

<!--start[report issue tooltip]-->
<div class="report_issue_tooltip" style="display:none;">
	<div class="question_mark"></div>
    <div class="report_issue_text">You can report any issues or bugs with our always active window. Just click on the question mark and a form window will open and it will record the pagewhere you are and allow you to enter your message
    or issue found. We will work diligently to fix the issue.</div>
    <div class="clear"></div>
</div>
<!--end[report issue tooltip]-->
<script language="javascript" type="application/javascript">
	$(document).ready(function() {
		var curr = $('#responce_page_no').val();
		$('.te_slider_part #testing_slider_st_horizontal .st_tabs li:eq('+curr+') a').trigger('click')
		
	});
</script>