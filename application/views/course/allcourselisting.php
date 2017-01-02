<?php 
	if($ProfInfo['profession_avatar'])
		$prof_image=base_url().$ProfInfo['profession_avatar'];
	else
		$prof_image=base_url().'images/prof_default.jpg';
?>
<!--Srart [ part2 ]-->
<div class="part2">
	<!--start[part content]-->
	<div class="part2_content_outer" style="">
    	<?php 
			foreach($ProfInfo as $key=>$val)
			{
				$url=site_url('profession/index/'.$val['profession_id']);
				echo '<div class="whats_new_slider">
		          	  		<a href="'.$url.'" style="z-index:10001;" class="What_new_title">'.$val['profession_name'].'</a>
				            <div id="whats_new'.$val['profession_id'].'"></div>
			          </div>';
        		if($key+1 !=count($ProfInfo))
			        echo '<div class="h_ruler"></div>';
			}
		?>          
    	
    </div>
    <!--start[part content]-->
</div>
<!--End [ part2 ]-->
<script type="text/javascript">

$(document).ready(function() {
		<?php 
			foreach($ProfInfo as $key=>$val)
			{
				echo 'Check_'.$val['profession_id'].'();';
			}
		?>          
});

<?php 
	  foreach($ProfInfo as $key=>$val)
	  {
?>
		function Check_<?php echo $val['profession_id']; ?>()
		{
			if(!$('#whats_new<?php  echo $val['profession_id']; ?>').html())
			{
				$('#whats_new<?php  echo $val['profession_id']; ?>').html('<div class="slider_loader"></div>');
				var form_data={prof_id:<?php echo $val['profession_id']; ?>}		
				common_ajax('<?php echo site_url('ajax_courselisting/GetNewCourseByProfId/');?>',form_data,'home_<?php echo $val['profession_id']; ?>');
			}
		}
		function home_<?php echo $val['profession_id']; ?>(data)
		{
			$('#whats_new<?php echo $val['profession_id']; ?>').html(data).trigger('update');
			var whats_slide_size= $('#whats_new<?php echo $val['profession_id']; ?> #whats_new_st_horizontal .st_tabs li').size();
			var whats_total_width= parseInt(whats_slide_size*20);
			$('#whats_new<?php echo $val['profession_id']; ?> #whats_new_st_horizontal .pagging_frame').width(whats_total_width);
			//for what's new slider slider
			if($('#whats_new<?php echo $val['profession_id']; ?> #whats_new_st_horizontal .st_tabs li').size()>0)
			{
				$('#whats_new<?php echo $val['profession_id']; ?> #whats_new_st_horizontal').slideTabs({
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
<?php	
	  }
?>   

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
		<?php 
			foreach($ProfInfo as $key=>$val)
			{
		?>
				case 'home_<?php echo $val['profession_id']; ?>':
								home_<?php echo $val['profession_id']; ?>(data);
								break;						
		<?php				
			}
		?>     
	}
}
</script>