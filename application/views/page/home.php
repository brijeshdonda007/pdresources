<?php 
	if($CourseInfo['course_image'])
		$small_name=base_url().$CourseInfo['course_image'];
	else
		$small_name=base_url().'image/course_image.jpg';
?>
<!--Srart [ part2 ]-->
<div class="part2">
	<!--start[part content]-->
	<div class="part2_content_outer">
    	<div class="part2_contnet_inner">
        	<!--start[content box]-->
        	<div class="content_box">            	
                	<div class="box_title_raw">
                    	<p class="box_title"><?php echo $PageInfo['page_title']; ?></p>
                    </div>
                    <div class="course_para"><?php echo $PageInfo['page_description']; ?></div>                    
                <div class="clear"></div>
            </div>
            <!--end[content box]-->                         
        </div>
    </div>
    <!--start[part content]-->
</div>
<!--End [ part2 ]-->