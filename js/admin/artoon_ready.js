$(document).ready(function()
{
	$('.logout_img').mouseenter(function()
	{
		$('.logout_block_space').stop(true, true).fadeIn(300);
	});
	$('.site_top').bind('mouseleave click', function()
	{
		$('.logout_block_space').stop(true, true).fadeOut(300);
	});
	$('.input_search').bind(
	{
		mouseenter: function()
		{
			var getText = $(this).val();
			if (getText == 'Search')
			{
				$(this).val('');
			}
		},
		mouseleave: function()
		{
			var getText = $(this).val();
			if (getText == '')
			{
				$(this).val('Search');
			}
		}
	});
	$('.menu_nav_item').mouseenter(function()
	{
		$(this).css('background', 'url(../images/menu_bg_hover.png) repeat-x 0 0').parent().children('.menu_nav_box').stop(true, true).fadeIn(300);
	});
	$('.menu_nav_list').mouseleave(function()
	{
		$(this).children('.menu_nav_item').css('background', 'none');
		$(this).children('.menu_nav_box').stop(true, true).fadeOut(300);
	});


	$('.left_nav_menu .title').click(function()
	{
		var old_active_left_menu = getCookie('active_left_menu');
		var active_left_menu = $(this).parent().attr('id');
		setCookie('active_left_menu', active_left_menu, 5);
		if (old_active_left_menu != active_left_menu) left_menu_controller();
	});
	left_menu_controller();
	
	$('.item_parent .item').click(function(){
		var active_left_menu_item = $(this).attr('id');
		setCookie('active_left_menu_item', active_left_menu_item, 5);
		left_menu_controller_item();
	});
	left_menu_controller_item();
});