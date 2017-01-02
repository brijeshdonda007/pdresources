<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><span class="root_link_remove">Test List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title">Test List</div>                        
     <form name="search_form" id="search_form" action="<?php echo site_url('admin/test/index'); ?>" method="post">
        <div class="page_btn_space_left" style="350px;">
          <input type="button" class="btn_search" name="btn_search" id="search_btn" />
          <input type="text" value="<?php echo $searchText ?>" name="searchText" id="searchText" class="input_search" />
        </div>                      
     </form>

     
    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="<?php echo site_url('admin/test/deleteTest'); ?>" method="post" onsubmit="return giveNotation();" >
     
     <div class="page_btn_space_right">
      <div style="float:left; padding-top:5px;">
        	<a href="<?php echo site_url('admin/test/addTest/'); ?>" class="page_btn">Add</a>
        <a onclick="javascript:$('#del_btn').trigger('click');" class="page_btn">Delete</a>
        <input type="submit" name="submit" id="del_btn" value="Delete" style="display:none;" />
      </div>
     </div>
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">
                  <th width="3%"><input type="checkbox" value="select" onclick="javascript:checkAll()" name="allbox" class="table_ckbox" /></th>
                  <th width="23%" > Test Name </th>                  
                  <th width="18%" >Edit</th>
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php
            foreach($listArr as $list) {
              echo '<tr id="row_'.$list['test_id'].'">';
              echo '<td><input type="checkbox" value="'.$list['test_id'].'" name="test_id[]" /></td>';
              echo '<td>'.$list['test_name'].'</td>';
              echo '<td><a href="'.site_url('admin/test/addTest/'.$list['test_id']).'"> Edit </a> | ';
             /* if($list['profession_is_active '] == "Y") {
	          	echo '<a href="javascript:activeTest(\''.$list['test_id'].'\',\'N\',this)" id="link_'.$list['test_id'].'" title="Inactivate Test">Active </a> | ';
			  }
			  else
				echo '<a href="javascript:activeTest(\''.$list['test_id'].'\',\'Y\',this)" id="link_'.$list['test_id'].'" title="Acviate Test">In-active </a> | ';*/
			  echo '<a href="'.site_url('admin/test/deleteTest/'.$list['test_id']).'"> Delete </a> | ';	              
			  //echo '<a href="javascript:deleteTest('.$course_id.','.$list['test_id'].')"> Delete </a> |';
			  echo '<a href="'.site_url('admin/test/question/'.$list['test_id']).'"> Add Questions </a> </td>';
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
	
	function deleteTest(id)
	{
		if(confirm("Are You Sure?"))
		{
			$.ajax({
				url: "<?php echo site_url('admin/test/deleteTest'); ?>/"+id,
				success: function(msg) {
					$('#row_'+id).remove();
				}
			});
		}
	}
	
	function activeTest(id,isActive,linkObj)
	{
		$.ajax({
			url: "<?php echo site_url('admin/test/updateActive'); ?>/"+id+"/"+isActive,
			success: function(msg) {
				if(isActive == "Y")
				{
					$('#link_'+id).attr("href","javascript:activeTest('"+id+"','N',this)");
					$('#link_'+id).html('Active');
					alert("Test is active.");
				}
				else
				{
					$('#link_'+id).attr("href","javascript:activeTest('"+id+"','Y',this)");
					$('#link_'+id).html('In-active');
					alert("Test is in-active.");
				}
			}
		});
	}
</script>