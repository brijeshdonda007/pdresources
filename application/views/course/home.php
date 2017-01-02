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
            	<div class="content_box_left">
                	<div class="illusion_img_space"><img src="<?php echo $small_name; ?>" width="197" height="300" title="<?php echo $CourseInfo['course_name']; ?>" /></div>
                    <a href="javascript:void(0);" onclick="AddTocart(<?php echo $CourseInfo['course_id']; ?>);" class="enroll_now_btn"></a>
                    <!--<a href="#" class="send_link">&middot; Send to Friend</a>-->
                    <!--<a class="send_link" href="<?php echo site_url('test/index/'.$CourseInfo['course_id']); ?>">&middot; Take a test</a>-->
                    <?php if($CommentCount > 0) echo '<a href="#customer_review" class="read_review_btn"></a>'; ?>                    
                </div>
                <div class="content_box_right"  style="position:relative;">
	                <div class="product_like_btn">	
						<div class="fb-like" data-href="<?php echo current_url(); ?>" data-send="false" data-layout="button_count" data-width="80" data-show-faces="false"></div>
                    </div>
                    <div class="clear"></div>
                	<div class="box_title_raw">
                    	<p class="box_title"><?php echo $CourseInfo['course_name']; ?></p>
                        <p class="user_name"><?php echo $AuthourInfo['author_title']; ?></p>
                    </div>
                    <div class="box_title_raw" style="padding-top:12px;">
                    	<p class="user_disc"><strong>CE Credit:</strong> <?php echo $CourseInfo['course_ce_hours']; ?> Hours (0.3 CEUs)</p>
                        <p class="user_disc"><strong>Target Audience:</strong> <?php echo $CourseInfo['course_target_audiance']; ?> </p>
                        <p class="user_disc"><strong>Learning Level:</strong> <?php echo $CourseInfo['course_learning_level']; ?></p>
                    </div> 
                    <p class="course_title">Course Abstract</p>
                    <p class="course_para"><?php echo $CourseInfo['course_desc']; ?></p>
                    <p class="course_info">Course #<?php echo $CourseInfo['course_main_course_id']; ?> | 2011 | 33 pages | 15 posttest questions</p>
                    <div class="objective_box">
                    	<div class="objective_left">
                        	<p class="course_title">Learning objectives</p>
							<?php echo $CourseInfo['course_learning_objective']; ?>
                        </div>
                        <div class="objective_right">
                        	<p class="course_title">Accreditation Statement</p>
                            <p>Professional Development Resources is approved by the American Psychological Association (APA) to sponsor continuing education for psychologists. Professional Development Resources maintains responsibility for this program and its content. Professional Development Resources is also approved by the Florida Board of Psychology and the Office of School Psychology and is CE Broker compliant (#50-1635).</p>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <!--end[content box]-->
            <?php if(count($AuthourInfo) > 0){ ?>
            <!--start[content box blue]-->
            <div class="content_box_blue">
            	<p class="course_title" style="padding-top:0px;">About the Author(s)</p>
                <p class="blue_content_para">
                <?php 
					foreach($AuthourInfo as $key=>$val)
					{
						echo $val['author_description'].'<br />';	
					}
				?>
                </p>
            </div>
             <!--end[content box blue]-->
             <?php } ?>
             
             <?php if($CommentCount > 0) { ?>                    
                 <div class="content_box" id="customer_review">
                    <p class="review_title">Customer Reviews</p>
                    <div class="review_box" style="min-height:100px;width:890px;position:relative;"></div>
                 </div>
             <?php } ?>
        </div>
    </div>
    <!--start[part content]-->
</div>
<!--End [ part2 ]-->
<div class="cart_add_suc_msg" style="display:none;"></div>
<div class="cart_add_error_msg" style="display:none;"></div>

<script type="text/javascript">

$(document).ready(function() {
	<?php if($CommentCount > 0) echo 'CheckComments();';?> 		    
});

function CheckComments()
{
	if(!$('.review_box').html())
	{
		var form_data={id : <?php echo $CourseInfo['course_id']; ?>}
		$('.review_box').html('<div class="slider_loader"></div>');
		common_ajax('<?php echo site_url('ajax_courselisting/GetCourseComments/');?>',form_data,'homeCheckComments');
	}
}
function homeCheckComments(data)
{	
	$('.review_box').html(data).trigger('update');
}

function common_ajax(dest_url,Cdata,functionName)
{
	$.ajax({
			url: dest_url,
			type: 'POST',
			//async:false,
			data: Cdata,
			success: function(msg) {
									slider_callbackfunction(functionName,msg)
								},
		});
}
function slider_callbackfunction(functionName,data)
{
	switch(functionName)
	{
		case 'homeCheckComments':
						homeCheckComments(data);
						break;	
	}
}
</script>