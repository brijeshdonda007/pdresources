<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a><span class="root_vr">/</span>
  <a href="<?php echo site_url('admin/course/'); ?>" class="root_link">Course List</a><span class="root_vr">/</span>  
  <span class="root_link_remove">Review List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title">Review List</div>

     <form name="search_form" id="search_form" action="<?php echo site_url('admin/managereview/index'); ?>" method="post">
        <div class="page_btn_space_left" style="350px;background:none !important;">
        </div>                      
     </form>
    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="<?php echo site_url('admin/managereview/deleteReview'); ?>" method="post" onsubmit="return giveNotation();" >
     
     <div class="page_btn_space_right">
      <div style="float:left; padding-top:5px;">
        <a href="<?php echo site_url('admin/managereview/addManagereview'); ?>" class="page_btn">Add</a>
        <a onclick="javascript:$('#del_btn').trigger('click');" class="page_btn">Delete</a>
        <input type="submit" name="submit" id="del_btn" value="Delete" style="display:none;" />
      </div>
     </div>
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">
                  <th width="3%"><input type="checkbox" value="select" onclick="javascript:checkAll()" name="allbox" class="table_ckbox" /></th>
                  <th width="23%" > Review </th>
                  <th width="18%" >Edit</th>
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php
            foreach($listArr as $list) {
              echo '<tr id="row_'.$list['comment_id'].'">';
              echo '<td><input type="checkbox" value="'.$list['comment_id'].'" name="employee[]" /></td>';
              echo '<td>'.substr(strip_tags($list['comment_description']),0,150).'</td>';			 
			  			  
              echo '<td><a href="'.site_url('admin/managereview/addManagereview/'.$list['comment_id']).'"> Edit </a> | ';
              if($list['comment_approved'] == "publish") {
	          	echo '<a href="javascript:activeReview(\''.$list['comment_id'].'\',\'draft\',this)" id="link_'.$list['comment_id'].'" title="Inactivate Review">Active </a> | ';
			  }
			  else
				echo '<a href="javascript:activeReview(\''.$list['comment_id'].'\',\'publish\',this)" id="link_'.$list['comment_id'].'" title="Acviate Review">In-active </a> | ';
              echo '<a href="javascript:deleteReview(\''.$list['comment_id'].'\')"> Delete </a></td>';
			  
              echo '</tr>';
            }
			if(count($listArr) == 0)
				echo "<tr align='center'><td colspan='5'>No Records Found</td></tr>";
          ?>
          </tbody>
      </table>
    </form>
    <!--Start [ Right Nav Part 2 ]-->
    
    <!--Start [ Right Nav Part 3 ]-->
    <div id="pager" class="pager">
    <form name="paging_form" action="" method="post">
       <?php echo $links; ?>
       <?php echo form_dropdown('per_page',$per_page_drop,set_value('per_page',$this->session->userdata('per_page')),' class="pagesize" id="pageValue" onchange="javascript:updatePerPage(this.value);"'); ?>
    </form>
    <div class="clear"></div>
    </div>
    <!--End [ Right Nav Part 3 ]-->

  </div>
  <!--End [ Right Nav ]-->
  
  <div class="clear"></div>
</div>

<script type="text/javascript">
	$('#search_btn').click(function() {  $('#search_form').submit();  });
	
	function deleteReview(id)
	{
		if(confirm("Are You Sure?"))
		{
			$.ajax({
				url: "<?php echo site_url('admin/managereview/deleteManagereview'); ?>/"+id,
				success: function(msg) {
					$('#row_'+id).remove();
				}
			});
		}
	}
	
	function activeReview(id,isActive,linkObj)
	{
		$.ajax({
			url: "<?php echo site_url('admin/managereview/updateActive'); ?>/"+id+"/"+isActive,
			success: function(msg) {
				if(isActive == "publish")
				{
					$('#link_'+id).attr("href","javascript:activeReview('"+id+"','draft',this)");
					$('#link_'+id).html('Active');
					alert("Review is active.");
				}
				else
				{
					$('#link_'+id).attr("href","javascript:activeReview('"+id+"','publish',this)");
					$('#link_'+id).html('In-active');
					alert("Review is in-active.");
				}
			}
		});
	}
</script>