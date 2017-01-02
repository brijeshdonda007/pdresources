<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel&nbsp;&nbsp;/&nbsp;&nbsp;</a>
  <a href="<?php echo site_url('admin/course/index/s'); ?>" class="root_link">Course List</a><span class="root_vr">/</span>
  <a href="<?php echo site_url('admin/test/index/'.$this->session->userdata('course_id')); ?>" class="root_link">Test List</a><span class="root_vr">/</span>
  <a href="<?php echo site_url('admin/test/question/'.$test_id.'/s'); ?>" class="root_link">Question List</a>
  <span class="root_vr">/</span><span class="root_link_remove">Question Option List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title">Question Option List</div>
        <div class="page_btn_space_left" style="350px;background:none;">
         
        </div>                      
     
    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="<?php echo site_url('admin/test/deleteOpt/'.$test_id.'/'.$question_id.'/'); ?>" method="post" onsubmit="return giveNotation();" >
     
     <div class="page_btn_space_right">
      <div style="float:left; padding-top:5px;">
        <a href="<?php echo site_url('admin/test/addOption/'.$test_id.'/'.$question_id.'/'); ?>" class="page_btn">Add</a>
        <a onclick="javascript:$('#del_btn').trigger('click');" class="page_btn">Delete</a>
        <input type="submit" name="submit" id="del_btn" value="Delete" style="display:none;" />
      </div>
     </div>
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">
                  <th width="3%"><input type="checkbox" value="select" onclick="javascript:checkAll()" name="allbox" class="table_ckbox" /></th>                
                  <th width="20%" > Option </th>
                  <th width="20%" > Is Right? </th>                  
                   <th width="8%" >Sort</th>
                  <th width="18%" >Edit</th>
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php		 
		  	$i = $start+1;
			$total = count($listArr); 
            foreach($listArr as $list) {
              echo '<tr id="row_'.$list['option_id'].'">';
              echo '<td><input type="checkbox" value="'.$list['option_id'].'" name="option_id[]" /></td>';          
              echo '<td>'.$list['option_text'].'</td>';
              echo '<td>'.$list['is_right_option'].'</td>';			  
			  echo '<td>';
				if($i != 1)	  {  if($i==$num) $style = "margin-left:20px; "; ?>
                    <a href="<?php echo site_url('admin/test/opt_sort/'.$test_id.'/'.$question_id.'/'.$list['option_order'].'/up'); ?>" style="<?php echo $style; ?> text-decoration:none;" title="Move Up" >
                        <img src="<?php echo base_url(); ?>images/admin/up_arrow.png" alt="Move Up" width="20" height="20" border="0" />
                    </a>
				<?php }  if($i != $num) { ?>
                    <a href="<?php echo site_url('admin/test/opt_sort/'.$test_id.'/'.$question_id.'/'.$list['option_order'].'/down'); ?>" style="margin-left:20px; text-decoration:none;" title="Move Down" >
                        <img src="<?php echo base_url(); ?>images/admin/down_arrow.png" alt="Move Down" width="20" height="20" border="0" />
                    </a>
				<?php }
				echo '</td>';			  			  
              echo '<td><a href="'.site_url('admin/test/addOption/'.$test_id.'/'.$question_id.'/'.$list['option_id']).'"> Edit </a> | ';
              if($list['is_active'] == "Y") {
				  echo '<a href="'.site_url('admin/test/updateOptActive/'.$test_id.'/'.$question_id.'/'.$list['option_id'].'/N').'" id="link_'.$list['option_id'].'" title="Inactivate Option"> Active </a> |';
			  }
			  else
			   	echo '<a href="'.site_url('admin/test/updateOptActive/'.$test_id.'/'.$question_id.'/'.$list['option_id'].'/Y').'" id="link_'.$list['option_id'].'" title="Acviate Option"> In-active </a> |';
 			  echo '<a href="'.site_url('admin/test/deleteOpt/'.$test_id.'/'.$question_id.'/'.$list['option_id']).'"> Delete </a> </td> ';             
              echo '</tr>';
			  $i++;
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
	
	function activeOpt(test_id,quest_id,id,isActive,linkObj)
	{
		$.ajax({
			url: "<?php echo site_url('admin/test/updateOptActive'); ?>/"+test_id+"/"+quest_id+"/"+id+"/"+isActive,
			success: function(msg) {
				if(isActive == "Y")
				{
					$('#link_'+id).attr("href","javascript:activeOpt('"+id+"','N',this)");
					$('#link_'+id).html('Active');
					alert("Test Option is active.");
				}
				else
				{
					$('#link_'+id).attr("href","javascript:activeOpt('"+id+"','Y',this)");
					$('#link_'+id).html('In-active');
					alert("Test Option is in-active.");
				}
			}
		});
	}
</script>