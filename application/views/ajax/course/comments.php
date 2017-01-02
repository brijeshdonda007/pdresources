<?php 
	if($CommentInfo)
	{			
		foreach($CommentInfo as $key=>$val)
		{
			if($val['cust_avatar'])
				$small_name=base_url().$val['cust_avatar'];
			else
				$small_name=base_url().'images/reviewuser_default.jpg';
			echo '<!--start[review raw]-->
                  <div class="review_raw">
                  		<div class="review_img_box"><img src="'.$small_name.'" width="81" height="81" alt="" /></div>
                        <div class="review_user_info">
                                <p class="review_user_name">'.$val['cust_fname'].' '.$val['cust_lname'].'</p>
                                <p class="review_user_status">'.$val['profession_name'].'</p>
                        </div>
                        <div class="review_disc_space">
                                <p class="review_disc">'.$val['comment_description'].'</p>
                        </div>
                        <div class="clear"></div>
                  </div>
                  <!--end[review raw]-->';
		}
?>
<?php } else {echo '<div class="no_record_found">Sorry No Record Found</div>';}  ?>
