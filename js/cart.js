
function GetItemCount()
{
	$.ajax({
			url: base_url+'managecart/ItemCount',
			type: 'POST',
			success: function(msg) {
										$('.cart_item_count').html(msg);																				
								}
		});		
}
function GetCartContent(flag)
{	
	$.ajax({
				url: base_url+'home/Getpopupcart',
				type: 'POST',
				async:false,
				data:{flag:flag},
				success: function(msg) {
											if(flag)
											{
												$('#updated_data_cart').html(msg);
											}
											else	
											{
												$('.cart_slider_overlay').html(msg);										
												showCartItem();											
											}
									}
			});		
}
function AddTocart(id)
{
	$.ajax({
			url: base_url+'managecart/AddToCart',
			type: 'POST',
			data:{course_id:id},
			async:false,
			success: function(msg) {
									SetMessages(msg);
									GetItemCount();																														
								}
		});		
	
}
function Removefromcart(id,flag)
{
	$.ajax({
			url: base_url+'managecart/RemoveFromCart',
			type: 'POST',
			data:{course_id:id},
			async:false,
			success: function(msg) {		
									GetCartContent(flag);							
									SetMessages(msg,flag);									
									GetItemCount();																														
								}
		});
	return false;			
}

function SetMessages(msg_id,flag)
{
	if(flag == 'popup')
	{
		var base_class='popup_msg';
	}
	else
	{
		var base_class='header_msgs';
	}
	$.ajax({
			url: base_url+'managecart/GetCartMsg',
			type: 'POST',
			data:{msg_id:msg_id},
			success: function(msg) {
										if(msg_id > 15)
										{
											if(base_class == 'header_msgs')
											{
												$('.cart_add_suc_msg').html(msg);
												$('.cart_add_error_msg').html('');
												$('.cart_add_suc_msg').stop( true, true).fadeIn();
												$('.cart_add_error_msg').stop( true, true).fadeOut();
												setTimeout('HideMessages()',2000);
											}
											else
											{
												$('.'+base_class+'.success span').html(msg);
												$('.'+base_class+'.warning span').html('');
												$('.'+base_class+'.success').stop( true, true).fadeIn();
												$('.'+base_class+'.warning').stop( true, true).fadeOut();												
											}
										}										
										else
										{
											if(base_class == 'header_msgs')
											{
												$('.cart_add_suc_msg').html();
												$('.cart_add_error_msg').html(msg);
												$('.cart_add_suc_msg').stop( true, true).fadeOut();
												$('.cart_add_error_msg').stop( true, true).fadeIn();
												setTimeout('HideMessages()',2000);												
											}
											else
											{
												$('.'+base_class+'.success span').html(msg);
												$('.'+base_class+'.warning span').html('');
												$('.'+base_class+'.success').stop( true, true).fadeIn();
												$('.'+base_class+'.warning').stop( true, true).fadeOut();												
											}											
										}
											$('.signup_msg_close').off('click').on('click',function(){ 
												$(this).parent().stop(true, true).fadeOut();
											});	

								}
		});		
}

function HideMessages()
{
	$('.cart_add_suc_msg').stop( true, true).fadeOut();
	$('.cart_add_error_msg').stop( true, true).fadeOut();													
}