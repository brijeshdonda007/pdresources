$(document).ready(function() {
	$('.signup_msg_close').off('click').on('click',function(){ 
		$(this).parent().stop(true, true).fadeOut();
	});	

/*	var whats_slide_size= $('#whats_new_st_horizontal .st_tabs li').size();
	var whats_total_width= parseInt(whats_slide_size*20);
	$('#whats_new_st_horizontal .pagging_frame').width(whats_total_width);
	//for what's new slider slider
	if($('.whats_new_slider #whats_new_st_horizontal .st_tabs li').size()>0)
	{
		$('.whats_new_slider #whats_new_st_horizontal').slideTabs({
			contentAnim: 'slideH',
			contentAnimTime: 600,
			contentEasing: 'easeInOutExpo',
			orientation: 'horizontal',
			tabsAnimTime: 300,
			buttonsFunction: 'click',
			changeSlide:function(){}
		});
	}
	//for new course slider
	var course_slide_size= $('#new_courses_st_horizontal .st_tabs li').size();
	var course_total_width= parseInt(course_slide_size*20);
	$('#new_courses_st_horizontal .pagging_frame').width(course_total_width);
	if($('.whats_new_slider #new_courses_st_horizontal .st_tabs li').size()>0)
	{
		$('.whats_new_slider #new_courses_st_horizontal').slideTabs({
			contentAnim: 'slideH',
			contentAnimTime: 600,
			contentEasing: 'easeInOutExpo',
			orientation: 'horizontal',
			tabsAnimTime: 300,
			buttonsFunction: 'click',
			changeSlide:function(){}
		});
	}
	
	//for most popular slider
	var popular_slide_size= $('#most_popular_st_horizontal .st_tabs li').size();
	var popular_total_width= parseInt(popular_slide_size*20);
	$('#most_popular_st_horizontal .pagging_frame').width(popular_total_width);
	if($('.whats_new_slider #most_popular_st_horizontal .st_tabs li').size()>0)
	{
		$('.whats_new_slider #most_popular_st_horizontal').slideTabs({
			contentAnim: 'slideH',
			contentAnimTime: 600,
			contentEasing: 'easeInOutExpo',
			orientation: 'horizontal',
			tabsAnimTime: 300,
			buttonsFunction: 'click',
			changeSlide:function(){}
		});
	}
*/
	//for show help slider
	$('.help_slider .help_slider_link').click(function(){
		if($(this).hasClass('open'))
		{
			$(this).removeClass('open');
			$('.help_slider').stop(true,true).animate({right:'-312px'},'fast');
		}else{
			$(this).addClass('open');
			$('.help_slider').stop(true,true).animate({right:'0'},'slow');
		}
	});
	$('.help_slider_title_space .help_slider_title').click(function(){
		if($(this).hasClass('open'))
		{
			$(this).removeClass('open');
			$('.buggie_disc').stop(true,true).slideUp('fast');
		}else{
			$(this).addClass('open');
			$('.buggie_disc').stop(true,true).slideDown('fast');
		}
	});
	
	//for hide show ribben
	$('.ribben_mark').click(function(){
		if($(this).hasClass('open'))
		{
			$(this).removeClass('open');
			$(this).parent('.user_info_ribben').stop(true,true).animate({width:'0px'});
		}else{
			$(this).addClass('open');
			$(this).parent('.user_info_ribben').stop(true,true).animate({width:'641px'});
		}
	});
});

function update_account()  {
	var form_data = $("#update_account_form").serialize();
	$.ajax({
		url : base_url+"dashboard/update_account",
		data : form_data,
		type : "post",
		success : function(msg)	{
			alert(msg);
		}
	});
}

function showCartItem(){
	//for close cart item overlay
	$('.cart_slider_close').off('click').on('click',function(){		
		showCartItem();
	});	
	if($('.cart_slider_overlay').hasClass('open'))
	{
		$('.cart_slider_overlay').removeClass('open').stop(true,true).fadeOut().addClass('close');
		$('.cart_slider_outer').stop(true,true).animate({top:'-800px'});
		
	}else{
		$('.cart_slider_overlay').removeClass('close').stop(true,true).fadeIn().addClass('open');
		$('.cart_slider_outer').stop(true,true).animate({top:'0px'});
	}
}
