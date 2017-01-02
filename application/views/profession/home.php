<?php 
	if($ProfInfo['profession_avatar'])
		$prof_image=base_url().$ProfInfo['profession_avatar'];
	else
		$prof_image=base_url().'images/prof_default.jpg';
?>
<!--Srart [ part2 ]-->
<div class="part2">
	<!--start[part content]-->
	<div class="part2_content_outer">
 
    	<!--start[white box]-->
    	<div class="part2_contnet_inner">
        	<div class="content_box" style="position:relative;">
        		<p class="psychology_title"><?php echo $ProfInfo['profession_name'];?></p>
                <div class="psychology_box">
                	<div class="psychology_left">
                    	<div class="psycho_img"><img src="<?php echo $prof_image; ?>"  alt="" /></div>
                    </div>
                    <div class="psychology_right">
                    	<a href="#" class="sub_navigation">• SUB-NAVIGATION ONE</a>
                        <a href="#" class="sub_navigation">• SUB-NAVIGATION TWO</a>
                        <a href="#" class="sub_navigation">• THIRD SUB NAVIGATION</a>
                        <a href="#" class="sub_navigation border_bottom_none"><em style="font-family:Georgia, 'Times New Roman', Times, serif;font-size:12px;text-transform:lowercase;">from</em> the blog</a>
                        <div class="blog_box">
                        	<p class="blog_title">Title of Article from the Blog</p>
                            <p class="blog_disc">Snippet pulled from the blog article up to a certain amount of words. Snippet pulled from the blog article up to a certain amount of words. Snippet pulled from the blog article up to a certain amount of words. Then dot dot dot...<a href="#">READ MORE ></a></p>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>           
        </div>
        <!--end[white box]-->
        
        <div class="h_ruler"></div>
        
        <!--start[new course slider]-->
        <div class="whats_new_slider">
        	<p class="What_new_title" >new courses</p>
            <div id="whats_new"></div>
            <!-- Start HTML - Horizontal tabs -->
            <!---->
            <!-- End HTML - Horizontal tabs -->
        </div>
        <!--end[new course slider]-->
        
        <div class="h_ruler"></div>
        
        <!--start[most popular slider]-->
        <div class="whats_new_slider">
        	<p class="What_new_title">most popular</p>
            <div id="most_popular"></div>
            <!-- Start HTML - Horizontal tabs -->
            <!---->
            <!-- End HTML - Horizontal tabs -->
        </div>
        <!--end[most popular slider]-->
        
        <div class="h_ruler"></div>
        
        <div class="home_title_raw">
        	<p class="about_team_title">About Psychology</p>
            <div class="about_team_disc">Definition and introduction of the profession done with an academic flair. Psychology is the scientific study of the human mind and its functions, esp. those affecting behavior in a given context.</div>
            <?php if($AuthorInfo) {
				if($AuthorInfo['author_avatar'])
					$small_name=base_url().$AuthorInfo['author_avatar'];
				else
					$small_name=base_url().'images/author_default.jpg';	
				if(strlen(strip_tags($AuthorInfo['author_description']))> 100)
					$viewMore='<a href="'.site_url('author/'.$AuthorInfo['author_id']).'">VIEW COURSES ></a>';			
				else
					$viewMore='';
				?>            
                <div class="team_box">
                    <div class="course_box">
                        <div class="course_img_box"><img src="<?php echo $small_name; ?>" width="121" height="90" alt="<?php echo $AuthorInfo['author_fname'] ?>" /></div>
                        <div class="course_disc"><span><?php echo $AuthorInfo['author_fname'].' '.$AuthorInfo['author_lname'] ?></span> <?php echo substr(strip_tags($AuthorInfo['author_description']),0,100);echo $viewMore; ?> </div>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            <!--end[team box]-->
            <div class="clear"></div>
        </div>
        
        <div class="h_ruler"></div>
    	
    </div>
    <!--start[part content]-->
</div>
<!--End [ part2 ]-->
<script type="text/javascript">

$(document).ready(function() {
	CheckWhatsNew();
	CheckMostPopular();
});

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
		case 'ReturnWhatsNew':
						ReturnWhatsNew(data);
						break;						
		case 'ReturnMostPopular':
						ReturnMostPopular(data);
						break;						

	}
}

function CheckWhatsNew()
{
	if(!$('#whats_new').html())
	{
		$('#whats_new').html('<div class="slider_loader"></div>');
		var form_data={prof_id:<?php echo $ProfInfo['profession_id']; ?>}		
		common_ajax('<?php echo site_url('ajax_profession/GetNewCourseByProfId/');?>',form_data,'ReturnWhatsNew');
	}
	//if()
}
function ReturnWhatsNew(data)
{
	$('#whats_new').html(data).trigger('update');
	var whats_slide_size= $('#whats_new_st_horizontal .st_tabs li').size();
	var whats_total_width= parseInt(whats_slide_size*20);
	$('#whats_new_st_horizontal .pagging_frame').width(whats_total_width);
	//for what's new slider slider
	if($('#whats_new #whats_new_st_horizontal .st_tabs li').size()>0)
	{
		$('#whats_new #whats_new_st_horizontal').slideTabs({
			contentAnim: 'slideH',
			contentAnimTime: 600,
			contentEasing: 'easeInOutExpo',
			orientation: 'horizontal',
			tabsAnimTime: 300,
			buttonsFunction: 'click',
			changeSlide:function(){}
		});
	}

}
function CheckMostPopular()
{
	if(!$('#most_popular').html())
	{
		$('#most_popular').html('<div class="slider_loader"></div>');
		var form_data={prof_id:<?php echo $ProfInfo['profession_id']; ?>}
		common_ajax('<?php echo site_url('ajax_profession/GetMostPopularCourseByProfId/');?>',form_data,'ReturnMostPopular');
	}
	//if()
}
function ReturnMostPopular(data)
{
	$('#most_popular').html(data).trigger('update');
	//for most popular slider
	var popular_slide_size= $('#most_popular_st_horizontal .st_tabs li').size();
	var popular_total_width= parseInt(popular_slide_size*20);
	$('#most_popular_st_horizontal .pagging_frame').width(popular_total_width);
	if($('#most_popular #most_popular_st_horizontal .st_tabs li').size()>0)
	{
		$('#most_popular #most_popular_st_horizontal').slideTabs({
			contentAnim: 'slideH',
			contentAnimTime: 600,
			contentEasing: 'easeInOutExpo',
			orientation: 'horizontal',
			tabsAnimTime: 300,
			buttonsFunction: 'click',
			changeSlide:function(){}
		});
	}

}
</script>