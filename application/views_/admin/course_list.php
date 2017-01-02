<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><span class="root_link_remove">Course List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title">Course List</div>
	<form name="search_form" id="search_form" action="<?php echo site_url('admin/course/index'); ?>" method="post">
        <div class="page_btn_space_left" style="350px;">
          <input type="button" class="btn_search" name="btn_search" id="search_btn" />
          <input type="text" value="<?php echo $searchText ?>" name="searchText" class="input_search" />
        </div>                      
     </form>
     
    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="<?php echo site_url('admin/course/deleteCourse'); ?>" method="post" onsubmit="return giveNotation();" >
     
     <div class="page_btn_space_right">
      <div style="float:left; padding-top:5px;">
        <a href="<?php echo site_url('admin/course/addCourse'); ?>" class="page_btn">Add</a>
        <a onclick="javascript:$('#del_btn').trigger('click');" class="page_btn">Delete</a>
        <input type="submit" name="submit" id="del_btn" value="Delete" style="display:none;" />
      </div>
     </div>
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">
                  <th width="3%"><input type="checkbox" value="select" onclick="javascript:checkAll()" name="allbox" class="table_ckbox" /></th>
                  <th width="23%" > Course Name </th>
                  <th width="10%" > Course Main Code </th>
                   <th width="15%" > Authour </th>
                  <th width="30%" >Edit</th>
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php
            foreach($listArr as $list) {
              echo '<tr id="row_'.$list['course_id'].'">';
              echo '<td><input type="checkbox" value="'.$list['course_id'].'" name="course_id[]" /></td>';
              echo '<td>'.$list['course_name'].'</td>';
              echo '<td>'.$list['course_main_course_id'].'</td>';			  
			  echo '<td>'.$list['course_author'].'</td>';	
              echo '<td><a href="'.site_url('admin/course/addCourse/'.$list['course_id']).'"> Edit </a> | ';
              if($list['profession_is_active '] == "Y") {
	          	echo '<a href="javascript:activeCourse(\''.$list['course_id'].'\',\'N\',this)" id="link_'.$list['course_id'].'" title="Inactivate Course">Active </a> | ';
			  }
			  else
				echo '<a href="javascript:activeCourse(\''.$list['course_id'].'\',\'Y\',this)" id="link_'.$list['course_id'].'" title="Acviate Course">In-active </a> | ';
              echo '<a href="javascript:deleteCourse(\''.$list['course_id'].'\')"> Delete </a> |';
			  echo '<a href="'.site_url('admin/course/profession/'.$list['course_id']).'"> Add Profession </a> |';			  
			  echo '<a href="'.site_url('admin/test/index/'.$list['course_id']).'"> Add Test </a> </td>';
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
	
	function deleteCourse(id)
	{
		if(confirm("Are You Sure?"))
		{
			$.ajax({
				url: "<?php echo site_url('admin/course/deleteCourse'); ?>/"+id,
				success: function(msg) {
					$('#row_'+id).remove();
				}
			});
		}
	}
	
	function activeCourse(id,isActive,linkObj)
	{
		$.ajax({
			url: "<?php echo site_url('admin/course/updateActive'); ?>/"+id+"/"+isActive,
			success: function(msg) {
				if(isActive == "Y")
				{
					$('#link_'+id).attr("href","javascript:activeCourse('"+id+"','N',this)");
					$('#link_'+id).html('Active');
					alert("Course is active.");
				}
				else
				{
					$('#link_'+id).attr("href","javascript:activeCourse('"+id+"','Y',this)");
					$('#link_'+id).html('In-active');
					alert("Course is in-active.");
				}
			}
		});
	}
</script>