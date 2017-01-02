<div id="most_popular_st_horizontal" class="st_horizontal" style="min-height:300px;">
	<?php if($CourseInfo) {
				$Adddata['course_id']='Additional';
				$Adddata['course_name']='Show All';				
				array_push($CourseInfo,$Adddata);	
				$count=count($CourseInfo);
				$count =$count+1;
				$slider=ceil($count/4);							
	?>
              <a href="#prev" class="st_prev st_btn_disabled"></a>
              <a href="#next" class="st_next <?php if($slider == 1) echo "st_btn_disabled"; ?>"></a>
              <div class="pagging_frame">
                  <div class="st_tabs_container">
                    <div class="st_slide_container">
                      <ul class="st_tabs">
                       <?php 							
						  if($slider >= 1)
						  {
							  for($i=1;$i<$slider;$i++)
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
						$start=1;
						foreach($CourseInfo as $key=>$val)
						{
							if($key <=15)
							{
								$no=$key+1;
								$append=$small_name='';
								
								if($val['course_image'])
									$small_name=base_url().$val['course_image'];
								else
								{
									if($val['course_id'] == 'Additional')
										$small_name=base_url().'images/showall_default.jpg';
									else
										$small_name=base_url().'images/small_default.png';										
								}
									
								if($no%4 == 1)
								{
									if($no > 1)
										echo '<div class="clear"></div></div>';
									echo '<div id="st_content_'.$start.'" class="st_tab_view">';
									$start++;
								}
								if($key > 0 && $no%4 == 0)
									$append='margin_right0px';	
								$name=url_title($val['course_name']);		
								if($val['course_id'] == 'Additional')	
									$url=site_url('courselisting/index/1/');										
								else
									$url=site_url('course/index/').'/'.$val['course_id'].'/'.url_title($val['course_name']);								
								if(strlen($val['course_name']) < 20)
									$course_name=$val['course_name'];
								else
									$course_name=str_pad(substr($val['course_name'],0,17),20,'.', STR_PAD_RIGHT);											

								echo '<div class="what_new_slide_box '.$append.'">
                    					<div class="what_new_slide_img_space"><a href="'.$url.'" title="'.$val['course_name'].'"><img src="'.$small_name.'"  alt="" /></a></div>
				                        <a href="'.$url.'" title="'.$val['course_name'].'"><p>'.$course_name.'</p></a>
                				    </div>';									
							}
							else
								break;
						}						
						echo '<div class="clear"></div>                                
							</div>';			 	
				 ?>                 
                </div>
                <!-- /.st_view --> 
              </div>
              <!-- /.st_view_container --> 
	<?php } else {echo '<div class="no_record_found">Sorry No Record Found</div>';}  ?>    
</div>
