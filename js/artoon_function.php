<script type="text/javascript" language="javascript">
//Home Game Thumbs

function addMargin()
{
	$('.home_game_list_link:even').css('margin-right', '10px');
}

function homeThumb()
{
	var get_home_game_space = $('.home_game_space').hasClass('showThumbs')

	showloader('.home_game_space');

	$('.home_list_btn_list').css('display', 'block');
	$('.home_list_btn_list').css('display');
	$('.home_game_space').addClass('showThumbs').removeClass('showList');
	$('.home_slider_btn_prev').attr('rel', 1);
	$('.home_slider_btn_next').attr('rel', 1);

	var cateSearch = $('#searchOptionCate').html();
	var otherOption = $('#searchOptionOther').html();
	
	var form_data = {
		categorySearch : $('#searchOptionCate').html(),
		otherOption : $('#searchOptionOther').html()
	};

	$.ajax({
		url: "<?php echo base_url().'home/gameList/thumb'; ?>",
		data:form_data,
		type: 'POST',
		success: function(msg)
		{
			$('.home_game_space').html(msg);
			$('.home_show_all_game_link').html($('.home_game_space #noGames').val());
			
			$('.home_slider_btn_next, .home_slider_btn_prev').css('display', 'none');
			var get_home_thumb_size = $('.home_game_thumbs_absolute .home_game_thumbs_relative').size();

			if (get_home_thumb_size > 1)
			{
				$('.home_slider_btn').css('display', 'block');
				$('.home_slider_btn_next').css('display', 'block');
				homeThumb_create_paging();
			}
			
			removeloader('.home_game_space');
		}
	});
}

function homeList()
{
	var get_home_game_space = $('.home_game_space').hasClass('showList')

	showloader('.home_game_space');
	$('.home_slider_btn').css('display', 'none');
	$('.home_list_btn_thumb').css('display', 'block');
	$('.home_game_space').addClass('showList').removeClass('showThumbs');

	var form_data = {
		categorySearch : $('#searchOptionCate').html(),
		otherOption : $('#searchOptionOther').html()
	};

	$.ajax({
		url: "<?php echo base_url().'home/gameList/list'; ?>",
		data:form_data,
		type: 'POST',
		success: function(msg)
		{
			$('.home_game_space').html(msg);
			$('.home_show_all_game_link').html($('.home_game_space #noGames').val());
			addMargin();
			removeloader('.home_game_space');
		}
	});
}

function showloader(element)
{
	$(element).block({ 
		message: '<img src="<?php echo base_url().'images/Loader.gif'; ?>" />',
	}); 
}

function removeloader(element)
{
	$(element).unblock(); 
}

function searchCriteria()
{
	var get_home_list = $('.home_game_space').hasClass('showList');
	var get_home_thumb = $('.home_game_space').hasClass('showThumbs')
	
	$('#searchOptionCate').html($('#my-dropdown1').val());
	$('#searchOptionOther').html($('#my-dropdown2').val());
	
	if (get_home_thumb == true)
		homeThumb();

	if (get_home_list == true)
		homeList();
}

function homeThumb_create_paging()
{
	var get_home_thumb_size = $('.home_game_thumbs_absolute .home_game_thumbs_relative').size();
	$('.home_thumb_paging').width(get_home_thumb_size * 23);
	var pagingString = '';
	for (i = 0; i < get_home_thumb_size; i++)
	{
		var rel = i + 1;
		if (i == 0)
		{
			pagingString += '<a class="home_thumb_paging_link home_thumb_paging_active" rel="' + rel + '"></a>';
		}
		else
		{
			pagingString += '<a class="home_thumb_paging_link" rel="' + rel + '"></a>';
		}
		$('.home_thumb_paging').html(pagingString + '<div class="clear"></div>');
		var home_thumb_paging_parent = $('.home_thumb_paging').parent().width();
		var home_thumb_paging = $('.home_thumb_paging').width();
		var home_thumb_paging_parent = parseInt(home_thumb_paging_parent / 2)
		var home_thumb_paging = parseInt(home_thumb_paging / 2)
		var home_thumb_paging_left = parseInt(home_thumb_paging_parent - home_thumb_paging);

		$('.home_thumb_paging').css('left', home_thumb_paging_left + 6);

	}
}

//Sign Up Radio Set Up
	function signup_radio()
	{
		var signup_radio = $('.sign_up_radio_set').attr('value');
		$('.sign_up_radio').removeClass('sign_up_radio_active');
		$('.sign_up_radio[rel="'+signup_radio+'"]').addClass('sign_up_radio_active');
	}
//All Game Right Menu Setting
function all_game_menu()
{
	var old_img_store = $('.all_game_menu_item_active').children('span').attr('style');
	var old_id_store = $('.all_game_menu_item_active').attr('id');
	
	$('.local_store .all_game_menu_active').text(old_img_store);
	$('.local_store .all_game_menu_id').text(old_id_store);
	
	var new_img = $('.all_game_menu_item_active').attr('rel');
	$('.all_game_menu_item_active').children('span').css({background:'url('+new_img+') no-repeat 11px 5px'});
}

//Menu Mouse Leave 
function menu_leave()
{
	var imgAddress = $('#artoon_menu li.current a').attr('class');
	$('.lavaLampWithImage li.back').css({background: 'url(<?php echo base_url(); ?>images/'+imgAddress+'_right.png) no-repeat right 0'});
	$('.lavaLampWithImage li.back .left').css({background: 'url(<?php echo base_url(); ?>images/'+imgAddress+'_left.png) no-repeat 0 0'});
}
</script>