<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#memeber_form").validate();
	
	$('#artoon_menu').lavaLamp(
	{
		fx: "linear",
		speed: 300,
		click: function(event, menuItem)
		{
			//return false;
		}
	});

	$('#artoon_menu li a').bind(
	{
		click: function()
		{
			$('#artoon_menu li').removeClass('current');
			$(this).parent('li').addClass('current');
		},
		mouseenter: function()
		{
			var imgAddress = $(this).attr('class');
			$('.lavaLampWithImage li.back').css({background: 'url(<?php echo base_url(); ?>images/'+imgAddress+'_right.png) no-repeat right 0'});
			$('.lavaLampWithImage li.back .left').css({background: 'url(<?php echo base_url(); ?>images/'+imgAddress+'_left.png) no-repeat 0 0'});
			$('#artoon_menu li a').css('color', '#2e2e2e');
			$(this).css('color', '#fff');
		},
		mouseleave: function()
		{
			menu_leave();
			$('#artoon_menu li a').css('color', '#2e2e2e');
		}
	});
	$('#artoon_menu').bind(
	{
		mouseleave: function()
		{
			$('#artoon_menu li.current a').css('color', '#fff');
		}
	});
	$('.login_username').bind(
	{
		mouseenter: function()
		{
			var getText = $(this).val();
			if (getText == 'username')
			{
				$(this).val('');
			}
		},
		keypress: function()
		{
			var getText = $(this).val();
			if (getText == 'username')
			{
				$(this).val('');
			}
		},
		mouseleave: function()
		{
			var getText = $(this).val();
			if (getText == '')
			{
				$(this).val('username');
			}
		}
	});

	$('.login_password').bind(
	{
		mouseenter: function()
		{
			var getText = $(this).val();
			if (getText == 'password')
			{
				$(this).val('');
			}
		},
		keypress: function()
		{
			var getText = $(this).val();
			if (getText == 'password')
			{
				$(this).val('');
			}
		},
		mouseleave: function()
		{
			var getText = $(this).val();
			if (getText == '')
			{
				$(this).val('password');
			}
		}
	});

	$('.game_search_input').bind(
	{
		focusin: function()
		{
			$(this).val('');
			$('.search_game_list').css('display', 'none').removeClass('select');
			$('.default_text').css('display', 'block');
			$('.search_show_all').addClass('select');
		},
		mouseenter: function()
		{
			var getText = $(this).val();
			if (getText == 'GAME SEARCH')
			{
				$(this).val('');
			}
		},
		keypress: function()
		{
			var getText = $(this).val();
			if (getText == 'GAME SEARCH')
			{
				$(this).val('');
			}
		},
		mouseleave: function()
		{
			var getText = $(this).val();
			if (getText == '')
			{
				$(this).val('GAME SEARCH');
			}
		},
		keyup: function()
		{
			var getText = $(this).val();
			if (getText == '') {
				$('.search_game_list').css('display', 'none').removeClass('select');
				$('.default_text').css('display', 'block');
				$('.notfound').css('display', 'none');
				$('.search_show_all').addClass('select');
			}
			else
			{
				$.ajax(
				{
					url: "<?php echo base_url().'home/gameSearch'; ?>/"+getText,
					success: function(msg)
					{
						$('.search_slider_space').html(msg);   //showing search result
						
						$('.search_game_list').css('display', 'block');
						$('.search_game_list:first').addClass('select');
						$('.default_text').css('display', 'none');
						$('.search_show_all').removeClass('select');
					}
				});
			}
		}
	});

	$('.search_game_list').bind(
	{
		mouseenter: function()
		{
			$('.search_game_list').removeClass('select');
		}
	});

	$('.game_search_input').click(function()
	{
		$('.search_slider_space').stop(true, true).slideDown(300);
	});

	$(document).bind('click', function(e)
	{
		var $clicked = $(e.target);
		if (!($clicked.parents().is(".search_parent")))
		{
			$('.search_slider_space').stop(true, true).slideUp(300);
		}
	});

	//For Combo
	$('#my-dropdown1, #my-dropdown2, #my-dropdown3, #my-dropdown4, #my-dropdown5, #monthDrop, #dayDrop,#genderDrop, #country,#fav_game,#boring_game,#my-dropdown12, #my-dropdown13, #my-dropdown14, #my-dropdown15').sSelect();
	
	$('div.combo_1_space').hover(function()	{
		$('.newList', this).addClass('combo1');
	});
	
	$('div.combo_2_space').hover(function()	{
		$('.newList', this).addClass('combo2');
	});
	
	$('div.combo_3_space').hover(function()	{
		$('.newList', this).addClass('combo3');
	});
	
	$('div.combo_4_space').hover(function()	{
		$('.newList', this).addClass('combo4');
	});
	
	$('div.combo_5_space').hover(function()	{
		$('.newList', this).addClass('combo5');
	});
	
	$('div.combo_6_space').mouseenter(function()	{
		$('.newList', this).addClass('combo6');
	});
	
	$('div.combo_7_space').mouseenter(function() {
		$('.newList', this).addClass('combo7');
	});
	
	$('.combo_1_space .selectedTxt', this).css('text-transform', 'uppercase');
	$('.combo_2_space .selectedTxt', this).css('text-transform', 'uppercase');
	$('.combo_3_space .selectedTxt', this).css('padding-left', '10px');
	$('.combo_4_space .selectedTxt', this).css('padding-left', '10px');
	$('.combo_5_space .selectedTxt', this).css('padding-left', '10px');
	$('.combo_6_space .selectedTxt', this).css('padding-left', '10px');
	$('.combo_7_space .selectedTxt', this).css('padding-left', '10px');

	//For Home Game Thumbs Slider
	$('.home_slider_btn_next, .home_slider_btn_prev, .home_slider_btn, .home_list_btn_list, .home_list_btn_thumb').css('display', 'none');

	$('.home_slider_btn_next').click(function()
	{
		var get_home_thumb_size = $('.home_game_thumbs_absolute .home_game_thumbs_relative').size();
		$('.home_game_thumbs_absolute').width(get_home_thumb_size * 617);

		var Prev = $('.home_slider_btn_prev').attr('rel');
		var Next = $('.home_slider_btn_next').attr('rel');

		if (Next < get_home_thumb_size && Prev < get_home_thumb_size)
		{
			Prev++;
			Next++;

			$('.home_thumb_paging_link').removeClass('home_thumb_paging_active');
			$('.home_thumb_paging_link[rel=' + Next + ']').addClass('home_thumb_paging_active');

			$('.home_slider_btn_next').attr('rel', Next);
			$('.home_slider_btn_prev').attr('rel', Prev);

			$('.home_game_thumbs_absolute').stop(true, true).animate(
			{
				left: '-=617'
			}, "slow","easeOutSine");
			$('.home_slider_btn_prev').stop(true, true).fadeIn();
			if (Next == get_home_thumb_size)
			{
				$('.home_slider_btn_next').css('display', 'none');
			}
		}
	});

	$('.home_slider_btn_prev').click(function()
	{
		var get_home_thumb_size = $('.home_game_thumbs_absolute .home_game_thumbs_relative').size();
		$('.home_game_thumbs_absolute').width(get_home_thumb_size * 617);
		var Prev = $('.home_slider_btn_prev').attr('rel');
		var Next = $('.home_slider_btn_next').attr('rel');

		if (Prev > 1 && Next > 1)
		{
			Prev--;
			Next--;

			$('.home_thumb_paging_link').removeClass('home_thumb_paging_active');
			$('.home_thumb_paging_link[rel=' + Prev + ']').addClass('home_thumb_paging_active');

			$('.home_slider_btn_prev').attr('rel', Prev);
			$('.home_slider_btn_next').attr('rel', Next);


			$('.home_game_thumbs_absolute').stop(true, true).animate(
			{
				left: '+=617'
			}, 'slow',"easeOutSine");
			$('.home_slider_btn_next').stop(true, true).fadeIn();
			if (Prev == 1)
			{
				$('.home_slider_btn_prev').css('display', 'none');
			}
		}
	});

	$('.home_list_btn_list').click(function()
	{
		$(this).css('display', 'none');
		homeList($('#searchOption').html());
	});

	$('.home_list_btn_thumb').click(function()
	{
		$(this).css('display', 'none');
		homeThumb($('#searchOption').html());
	});

	//Home Game Thumbs Paging Create
	$('.home_thumb_paging_link').live('click', function()
	{
		var getRel = $(this).attr('rel');
		$('.home_slider_btn_prev').attr('rel', getRel);
		$('.home_slider_btn_next').attr('rel', getRel);

		$('.home_thumb_paging_link').removeClass('home_thumb_paging_active');
		$(this).addClass('home_thumb_paging_active');
		var get_home_thumb_size = $('.home_game_thumbs_absolute .home_game_thumbs_relative').size();
		$('.home_game_thumbs_absolute').width(get_home_thumb_size * 617);

		if (get_home_thumb_size == getRel)
		{
			$('.home_slider_btn_next').css('display', 'none');
			$('.home_slider_btn_prev').fadeIn();
		}
		else if (getRel == 1)
		{
			$('.home_slider_btn_prev').css('display', 'none');
			$('.home_slider_btn_next').fadeIn();
		}
		else
		{
			$('.home_slider_btn_prev, .home_slider_btn_next').fadeIn();
		}
		getRel = getRel - 1;
		getRel = -getRel * 617;
		$('.home_game_thumbs_absolute').stop(true, true).animate(
		{
			left: getRel
		}, 'slow',"easeOutSine");


	});
	
	//Sign Up Radio Set Up
	signup_radio();
	
	$('.sign_up_radio').click(function(){
		$('.sign_up_radio_set').attr('value',$(this).attr('rel'));
		signup_radio();
	});

	//For Small Box Default Hover Effect
	$('.box_sm_link_default').bind({
		mouseenter: function()
		{
			$(this).parent('div.box_sm_link_default_space').addClass('box_sm_link_default_space_active');
		},
		mouseleave: function()
		{
			$(this).parent('div.box_sm_link_default_space').removeClass('box_sm_link_default_space_active');
		}
	});
	
	
    //All Game Right Menu Setting	
	$('.all_game_menu_item').click(function(){
			var old_img_call = $('.local_store .all_game_menu_active').text();
			var old_id_call = $('.local_store .all_game_menu_id').text();
			
			if(old_img_call!='' && old_id_call!='')
			{
				$('#'+old_id_call).children('span').attr('style',old_img_call);
			}
			
			var old_img_store = $(this).children('span').attr('style');
			var old_id_store = $(this).attr('id');
			
			$('.local_store .all_game_menu_active').text(old_img_store);
			$('.local_store .all_game_menu_id').text(old_id_store);
			
			var new_img = $(this).attr('rel');
			$(this).children('span').css({background:'url('+new_img+') no-repeat 11px 5px'});
			$('.all_game_menu_item').removeClass('all_game_menu_item_active');
			$(this).addClass('all_game_menu_item_active');		
		});
	
	all_game_menu();
	menu_leave();
	
	//Facts Row
	$('.facts_row:even').addClass('facts_row_even');
	
	//ToolTip
	$('.logout_big_icon').bind({
		
		mouseenter:function(){
			var tipText = $(this).attr('rel');
			var offset = $(this).offset();
			$('.tool_tip_text').text(tipText);
			
			var getLeft = offset.left;
			var getWgt = $(this).width()/2;
			var tipLeft = parseInt(getLeft+getWgt);
			var tipWgt = $('.tool_tip_space').width()/2;
				tipLeft = parseInt(tipLeft-tipWgt)+'px';
				
			var getTop = offset.top;
			var getHgt = $(this).height();
			var tipTop = parseInt(getTop+getHgt+10)+'px';
				
			$('.tool_tip_space').css({
				left:tipLeft,
				top:tipTop
			}).stop(true, true).fadeIn();
		},
		mouseleave:function(){
			$('.tool_tip_space').stop(true, true).fadeOut();
		}
	});
	
	//my game page
	
	$('.box_sm_link_default_dif').bind({
		mouseenter:function(){
			$(this).parent('.link_box_1').addClass('link_box_1_active');
		},
		mouseleave:function(){
			$('.box_sm_link_default_dif').parent('.link_box_1').removeClass('link_box_1_active');
		}
	});
	
	//game category slide text
	$('.headto_title_link').click(function(){
		$(this).parent().children('div.slide_text_space').stop(true, true).slideToggle();
	});
	$('.slide_text_space_btn').click(function(){
		$(this).parent('div.slide_text_space').stop(true, true).slideToggle();
	});
	
	//for tournament view info
	$('.tour_view_info_span').click(function(){
		$(this).parent().children('.tour_view_info_detail').stop(true, true).slideToggle();
	});
	$('.slide_text_space_btn').click(function(){
		$(this).parent('div.tour_view_info_detail').stop(true, true).slideToggle();
	});
	//for tournament view info bottom
	$('.tour_view_info_span').click(function(){
		$(this).parent().children('.tour_detail_bottom').stop(true, true).slideToggle();
	});
	$('.slide_text_space_btn').click(function(){
		$(this).parent().parent('div.tour_detail_bottom').stop(true, true).slideToggle();
	});
	
});
</script>