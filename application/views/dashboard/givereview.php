<html>
    <head>
        <!--File css and js-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/default.css" />
    </head>
    <body>
       <!--popup start]-->
        <div class="review_space" id="review_reading">
            <div class="review_inner">
            	<form name="GiveReview" id="GiveReview" action="" method="post" enctype="multipart/form-data">
                    <div class="reviewpopup_header">Review “Reading in the Brain”</div>
                    <div class="popup_error" style="margin-top:5px;margin-bottom:0px;height:16px;"><?php echo form_error('comment_description');?></div>                
                    <div class="review_inner_space">
                    	<textarea class="review_field" id="comment_description" name="comment_description"></textarea>
                    </div>
                    <div class="review_submit_space">
	                    <input type="submit" name="submit" value="" class="submit_big_btn" />
                    </div>
				</form>
             </div>
        </div>
        <!--popup end]-->    
     </body>
</html>