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
				buttonsFunction: 'click',
				changeSlide:function(){
					countSlide();
					progressBar();
					
				}
			});
			countSlide();
			progressBar();
		}	
		
		<?php if($is_completed_evalutions) { ?>
			DisplayPrintScr();		
		<?php } ?>	
		});	
		
	function UpdateInfo()
	{
		var question_id=$('.st_tab_view.st_active_view').find('.questionsids').val();
		var cust_id=$('#cust_id').val();
		var course_id=$('#course_id').val();
		var evaluation_id=$('#evaluation_id').val();
		var order_id=$('#order_id').val();		
		var evaluation_attampt=$('#evaluation_attampt').val();
		if($('.st_tab_view.st_active_view').find('.testoptions:radio:checked').val() > 0)						
			var selected_option=$('.st_tab_view.st_active_view').find('.testoptions:radio:checked').val();
		else
			var selected_option=0;
		var rightoption=$('.st_tab_view.st_active_view').find('.is_right_option').val();
		
		var formdata={
			question_id:question_id,
			cust_id:cust_id,
			course_id:course_id,
			evaluation_id:evaluation_id,
			order_id:order_id,				
			evaluation_attampt:evaluation_attampt,
			selected_option:selected_option,
			rightoption:rightoption,
		};
		common_ajax('<?php echo site_url('test/saveEvaluationResponceDetail/');?>',formdata);		
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
			
	function CompleteEvaluation()
	{	
		UpdateInfo();	
		var cust_id=$('#cust_id').val();
		var course_id=$('#course_id').val();
		var evaluation_id=$('#evaluation_id').val();
		var order_id=$('#order_id').val();		
		
		var formdata={
			cust_id:cust_id,
			course_id:course_id,
			evaluation_id:evaluation_id,
			order_id:order_id,				
		};
		common_ajax('<?php echo site_url('test/CompleteEvaluation/');?>',formdata);												
		$('.responce_hidden_part').fadeOut();
		$('.te_slider_part').fadeOut();
		$('#print_certificate').fadeIn();	
	}		
	
	function DisplayPrintScr()
	{
		$('.responce_hidden_part').fadeOut();
		$('.te_slider_part').fadeOut();
		$('#print_certificate').fadeIn();			
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
        <div class="user_space" id="print_certificate" style="padding-top:50px;display:none;" >                                    
            <p class="ex_fail_heading" >Thank you for your answers for the Evalution ! Congrates and click below to print out your certificate. You earned it!</p>                                  
            <div style="width:465px; margin:auto;">
            <p class="title_navigation" >• THE PROFESSIONAL DEVLOPMENT RESOURCES TEAM ! </p>
            <div style="margin-top:50px;"> 
            	<a target="_blank" href="<?php echo site_url('certificate/printcertificate/'.$course_id.'/'.$order_id) ?>" class="print_btn"></a>
                <a target="_blank" href="<?php echo site_url('certificate/download/'.$course_id.'/'.$order_id) ?>" class="download_btn"></a>
                <div class="clear"></div>
            </div>
            </div>                                                                  
        </div>
        <!--end[exam pass space]-->          
        <div class="te_slider_part"> 
        	<?php if($EvaluationQuestionInfo){
					$counter=count($EvaluationQuestionInfo);					
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
                      		<input type="hidden" id="evaluation_attampt" name="evaluation_attampt" value="<?php echo $evaluation_attampt; ?>" />
                            <input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>" />
                            <input type="hidden" id="cust_id" name="cust_id" value="<?php echo $cust_id; ?>" />                            
                            <input type="hidden"  id="evaluation_id"  name="evaluation_id" value="<?php echo $EvaluationInfo['evaluation_id']; ?>" />
                            <input type="hidden"  id="order_id"  name="order_id" value="<?php echo $order_id; ?>" />                                                        
                      		<?php 
								foreach($EvaluationQuestionInfo as $key=>$val)
								{
									$counter=$key+1;
									$question_id=$val['question_id'];
									
									echo '<div id="st_content_'.$counter.'" class="st_tab_view"> 
											<span>'.$val['question_text'].'</span>';									
									echo '<div>';
									foreach($val['options'] as $key2=>$val2)
									{
										if($val['responce'] == $val2['option_id'])
											$flag='checked="checked"';
										else
											$flag='';
										echo '<p class="radio_parent"><label><input '.$flag.' name="options'.$question_id.'[]" class="testoptions" type="radio" value="'.$val2['option_id'].'">'.$val2['option_text'].'</label></p>';
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
      <?php if(count($EvaluationQuestionInfo) == 1) 
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
        <a <?php echo $complete; ?> onclick="CompleteEvaluation();" class="te_complete_test"></a>
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
<!--popup end]-->
