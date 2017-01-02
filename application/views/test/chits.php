<script language="javascript" type="application/javascript">
	$(document).ready(function() {							
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
	});
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
                      		<?php 
								foreach($TestQuestionInfo as $key=>$val)
								{
									$counter=$key+1;
									$class=$disp='';
									$question_id=$val['question_id'];
									
									echo '<div id="st_content_'.$counter.'" class="st_tab_view"> 
											<span>'.$val['question_text'].'</span>';									
									echo '<div>';
									foreach($val['options'] as $key2=>$val2)
									{
										$class=$disp='';
										if($val['responce'] == $val2['option_id'])
										{
											$class='hint_incorrect_ans';
											$flag='checked="checked"';
											$disp='<p class="incorrect_ans">< incorrect answer</p><div class="clear"></div>';
										}
										else
											$flag='';
										echo '<p class="radio_parent '.$class.'"><label><input '.$flag.' name="options'.$question_id.'[]" class="testoptions" type="radio" value="'.$val2['option_id'].'">'.$val2['option_text'].'</label></p>';
										echo $disp;
											 
									}
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
      <div class="clear"></div>
    </div>
  </div>
  <!--start[part content]--> 
</div>
<!--End [ part2 ]-->
<!--start[report issue tooltip]-->
<div class="report_issue_tooltip" style="display:none;">
	<div class="question_mark"></div>
    <div class="report_issue_text">You can report any issues or bugs with our always active window. Just click on the question mark and a form window will open and it will record the pagewhere you are and allow you to enter your message
    or issue found. We will work diligently to fix the issue.</div>
    <div class="clear"></div>
</div>
<!--end[report issue tooltip]-->
