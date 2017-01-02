<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script language="javascript">
	function Addtocart(key)
	{
		var data='course_id='+key;
		  $.ajax({
			  url: "<?php echo site_url('cart_demo/CartManage/add'); ?>",
			  type:'POST',
			  data:data,
			  //data:$('form').serialize(),
			  //dataType: "json",
			  success: Success
		  });
	}
	function RemoveFromcart(key)
	{
		var data='course_id='+key;
		  $.ajax({
			  url: "<?php echo site_url('cart_demo/CartManage/remove'); ?>",
			  type:'POST',
			  data:data,
			  //data:$('form').serialize(),
			  //dataType: "json",
			  success: Success
		  });
	}
	function Success(responseData)
	{
		//alert(responseData);
		document.getElementById('cartInfo').innerHTML=responseData;
	}
	function ShowhideCartContent()
	{
		var cart_content = document.getElementById('cart_content').style;
		if (cart_content.display == 'none') {
			cart_content.display = 'block'
		} else {
			cart_content.display = 'none'
		}
	}
</script>
</head>

<body>
<div>
	<div align="left">
    	<h1>Cart Demo</h1>
    </div>
    <div align="center" id="cartInfo">
    	<h4>Shopping Cart</h4>
        <a href="javascript:void(0);" onclick="javascript:ShowhideCartContent()"><?php echo $count;?>Item(s)-<?php echo $total;?></a>
        <div id="cart_content" style="display:none;">
        	<?php
				if(count($Basket['Course']) > 0)
				{
					echo '<table width="370" border="1">';
					foreach($Basket['Course'] as $key=>$val)
					{
						echo '<tr>';
						echo '<td>'.$val['course_name'].'</td>';
						echo '<td>'.$val['course_price'].'</td>';
						echo '<td><a href="javascript:void(0);" onclick="javascript:RemoveFromcart('.$key.')">Remove</a></td>';						
						echo '</tr>';
					}
					echo '</table>';
				}
				else
					echo 'Sorry your shopping cart is empty.';
			?>
        </div>
    </div>
</div>
<table width="370" border="1">
  <tr>
    <td width="216">Course Name</td>
    <td width="66">Price in USD</td>
    <td width="80"></td>
  </tr>
<?php
foreach($CourseData as $key=>$val)
{
	echo '<tr>';	
	echo '<td>'.$val['course_name'].'</td>';	
	echo '<td>'.$val['course_price'].'</td>';	
	echo '<td><a href="javascript:void(0);" onclick="javascript:Addtocart('.$val['course_id'].')">Add To cart</a></td>';			
	echo '<tr>';	
}
?>  
</table>

</body>
</html>