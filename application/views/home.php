<script type="text/javascript" src="<?php echo base_url(); ?>js/jqueryBlockNew.js"></script>
<script type="text/javascript" language="javascript">
	function validateHomeSearch()
	{
		var searchtext=$('#sub_search').val();
		var searchtextLength=$('#sub_search').val().length;
		if(searchtext != 'What is your profession?' && searchtextLength > 0)
			return true;
		else
			return false;
	}
	var pastDef ='0';
	$(document).ready(function() {		
		$('#sub_search').focus();
		$("#sub_search").autocomplete("<?php echo base_url(); ?>home/getProessionHome",
		{
			delay:10,
			minChars:1,	
			matchSubset:1,	
			matchContains:1,
			cacheLength:10,	
			onItemSelect:selectItem, 
			onFindValue:findValue,	
			formatItem:formatItem 
//			autoFill:true,
//			formId:'#search_book'
		}			
		);
		$(window).resize(function() { setOverlayPos(); });
	});
		
	function clearText(field,flag) {
		if(flag==1)
			pastDef = $(field).next().val();
		
		if (field.defaultValue == field.value) { field.value = ''; $(field).next().val(''); }
		else if  (field.value == '') { field.value = field.defaultValue; $(field).next().val(pastDef);
		}
	}
	
	function SubmitReview(emplyee_id)
	{
		//alert(course_id);
		$('#employeeinfo_iframe').attr('src','<?php echo site_url('home/GetEmployeeInfo/'); ?>'+'/'+emplyee_id);	
		$.blockUI({message: $('#employeeinfo_div')});		
		setOverlayPos();
	}
	function unBlockUI(){
		$.unblockUI();
	}

</script>
<!--Srart [ part2 ]-->
<div class="part2">
	<!--start[part content]-->
	<div class="part2_content_outer">
    	<div class="home_title_raw">
        	<div class="new_sell_disc"><?php $temp=$this->mdl_config->get_allconfig(4); echo $temp['config_description']; ?></div>
            <?php if($PramotionInfo['pramotion_avatar']) 
					{
						$url=$PramotionInfo['pramotion_url'];
					  $style='style="background:url('.base_url().$PramotionInfo['pramotion_avatar'].') !important"';
					}
				  else
				  	{
						$url='';
				  	    $style='';
					}
			?>
            <a href="<?php echo $url?$url:'#';?>" <?php echo $url?'target="_blank"':'';?> class="new_year_logo" ></a>
            <div class="clear"></div>
        </div>
        <div class="h_ruler"></div>
    	<!--start[white box]-->
    	<div class="part2_contnet_inner">
        	<div class="content_box">
        	<form name="search_book" id="search_book"  action="<?php echo  site_url('profession'); ?>" method="post" onsubmit="return validateHomeSearch();">
            	<input type="text" name="sub_search" id="sub_search" value="What is your profession?" class="sub_search_input" onFocus="if(this.value=='What is your profession?')this.value=''" onblur="if(this.value=='' || $('#prof_id').val() == '')this.value='What is your profession?'"/>
                <input type="hidden" value="" id="prof_id" name="prof_id" />
                <input type="submit" name="submit" class="go_btn_submit" value="" />
                <div class="clear"></div>
            </form>
            </div>           
        </div>
        <!--end[white box]-->
        
        <div class="h_ruler"></div>
        <!--start[whats_new_slider]-->
        <div class="whats_new_slider">
        	<p class="What_new_title">What's New</p>
            <!-- Start HTML - Horizontal tabs -->
            <div id="whats_new"></div>            
            <!-- End HTML - Horizontal tabs -->
        </div>
        <!--end[whats_new_slider]-->
        <div class="h_ruler"></div>
        
        <div class="home_title_raw">
        	<p class="about_team_title">About Our Team</p>
            <div class="about_team_disc"><?php $temp=$this->mdl_config->get_allconfig(6); echo $temp['config_description']; ?></div>
            <!--start[team box]-->
            <div class="team_box">
            	<?php if($EmployeeInfo){ 
					foreach($EmployeeInfo as $key=>$val)
					{
						if($val['employee_avatar'])
							$smallname=base_url().$val['employee_avatar'];
						else				
							$smallname=base_url().'images/employee_default.jpg';
						?>
                        <!--start[team_raw]-->
                        <div class="team_raw">
                            <div class="team_img_box"><a href="javascript:SubmitReview(<?php echo $val['employee_id'] ?>);"><img src="<?php echo $smallname ?>" width="60" height="60" alt="<?php echo $val['employee_fname'].'&nbsp;'.$val['employee_lname'] ?>" /></a></div>
                            <div class="member_disc"><?php echo $val['employee_fname'].'&nbsp;'.$val['employee_lname'] ?>, <span><?php echo $val['employee_title'] ?></span></div>
                            <a href="javascript:SubmitReview(<?php echo $val['employee_id'] ?>);" class="team_link">&raquo;</a>
                            <div class="clear"></div>
                        </div>
                        <!--end[team_raw]-->
						<?php
					}
				} ?>            	
                                                
            </div>
            <!--end[team box]-->
            <div class="clear"></div>
        </div>
        
        <div class="h_ruler"></div>
    	
    </div>
    <!--start[part content]-->
</div>
<!--End [ part2 ]-->

<div class="home_employee_iframe" id="employeeinfo_div">
	<iframe src="" id="employeeinfo_iframe"  style="border:none; width:100%; height:100%;"></iframe>          
</div>
<script type="text/javascript">

$(document).ready(function() {
	CheckWhatsNew();
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
								}
		});
}

function slider_callbackfunction(functionName,data)
{
	switch(functionName)
	{
		case 'homeCheckWhatsNew':
						homeCheckWhatsNew(data);
						break;						
	}
}

function CheckWhatsNew()
{
	if(!$('#whats_new').html())
	{
		$('#whats_new').html('<div class="slider_loader"></div>');
		common_ajax('<?php echo site_url('home/GetNewArrivalCourse/');?>','','homeCheckWhatsNew');
	}
	//if()
}

function homeCheckWhatsNew(data)
{
	$('#sub_search').focus();
	$('#whats_new').html(data).trigger('update');
	var whats_slide_size= $('#whats_new_st_horizontal .st_tabs li').size();
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

}
</script>