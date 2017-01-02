function setCookie(c_name, value, expiredays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" + escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toUTCString() + ";path=/");
}

function getCookie(c_name)
{
	if (document.cookie.length > 0)
	{
		c_start = document.cookie.indexOf(c_name + "=");
		if (c_start != -1)
		{
			c_start = c_start + c_name.length + 1;
			c_end = document.cookie.indexOf(";", c_start);
			if (c_end == -1) c_end = document.cookie.length;
			return unescape(document.cookie.substring(c_start, c_end));
		}
	}
	return "";
}

//Function Left Nav Menu Controller
function left_menu_controller()
{
	var active_left_menu = getCookie('active_left_menu');
	if (active_left_menu)
	{	
		$('.left_nav_menu .title').removeClass('left_nav_menu_active');
		$('#'+active_left_menu+ ' .title').addClass('left_nav_menu_active');
		$('.left_nav_menu .item_parent').stop(true, true).slideUp();
		$('#'+active_left_menu).children('.item_parent').stop(true, true).slideDown();//alert(active_left_menu);
	}	
}


//Function Left Nav Menu Item Controller
function left_menu_controller_item()
{
	var active_left_menu_item = getCookie('active_left_menu_item');
	if (active_left_menu_item)
	{
		$('.item_parent .item').removeClass('item_active');
		$('.item_parent #'+active_left_menu_item).addClass('item_active');
	}	
}