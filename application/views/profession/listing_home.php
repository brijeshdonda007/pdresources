<?php 
	if($ProfInfo['profession_avatar'])
		$prof_image=base_url().$ProfInfo['profession_avatar'];
	else
		$prof_image=base_url().'<?php echo base_url(); ?><?php echo base_url(); ?><?php echo base_url(); ?>images/prof_default.jpg';
		$url=site_url('profession/index/'.$ProfInfo['profession_id']);
?>
<!--Srart [ part2 ]-->
<div class="part2"> 
  <!--start[part content]-->
  <div class="part2_content_outer"> 
        <div class="part2_contnet_inner">
          <p class="about_team_title" style="padding-bottom:0px;padding-left:50px;padding-top:40px;"><a href="<?php echo $url;?>" style="color:#B3B0A4;" ><?php echo $ProfInfo['profession_name'] ?></a></p>
          <!-- Start HTML - Horizontal tabs -->
          <div class="content_box" style="padding-top:0px;">
             <?php 
                                    if($total_rows > 0)
                                    {							
                                        foreach($listArr as $key=>$val)
                                        {
                                            $append=$small_name='';
                                            if($key%5==0)
                                            {
                                                if($key > 0)
                                                    echo '<div class="clear"></div>
                                                     </div>';
                                                echo '<div class="psychology_box">';									
                                            }
                                            if($val['course_image'])
                                                $small_name=base_url().$val['course_image'];
                                            else
                                            {								
                                                $small_name=base_url().'images/small_default.png';										
                                            }
                                            if($key > 0 && ($key+1)%5==0)
                                                $append='style="margin-right:0px;"';	
                                            $name=url_title($val['course_name']);	
                                            $url=site_url('course/index/').'/'.$val['course_id'].'/'.url_title($val['course_name']);																				
                                            if(strlen($val['course_name']) < 20)
                                                $course_name=$val['course_name'];
                                            else
                                                $course_name=str_pad(substr($val['course_name'],0,17),20,'.', STR_PAD_RIGHT);											
                                            
											echo '<div class="high_new_slide_box" '.$append.'>
                                                    <div class="high_new_slide_img_space"><a href="'.$url.'" title="'.$val['course_name'].'"><img src="'.$small_name.'" width="150" height="218" alt="" /></a></div>
                                                    <a href="'.$url.'" title="'.$val['course_name'].'"><p>'.$course_name.'</p></a>
                                                  </div>';	
                                        }
										 echo '<div class="clear"></div>
                                                     </div>';
                                    }
                                ?>                                 
          </div>
          <!-- End HTML - Horizontal tabs --> 
         </div> 
    </div>
    <!--end[whats_new_slider]-->    
  <!--start[part content]--> 
</div>
<!--End [ part2 ]-->