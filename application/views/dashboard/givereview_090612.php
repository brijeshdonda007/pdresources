<form name="GiveReview" id="GiveReview" action="" method="post" enctype="multipart/form-data">
	<div class="text_box">
        <p class="line_2">Review :-</p>        
        <span class="input_box_space">        
        <textarea id="comment_description" name="comment_description"></textarea>
        <?php echo form_error('comment_description');?>
        </span>
        <input type="submit" name="submit" value="Submit" />
        <div class="clear"></div>
    </div>
</form>