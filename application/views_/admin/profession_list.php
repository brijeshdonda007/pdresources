<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><span class="root_link_remove">Profession List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title">Profession List</div>
	 <div class="page_btn_space_left" style="350px; background:none !important;"></div>
     
    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="<?php echo site_url('admin/profession/deleteProfession'); ?>" method="post" onsubmit="return giveNotation();" >
     
     <div class="page_btn_space_right">
      <div style="float:left; padding-top:5px;">
        <a href="<?php echo site_url('admin/profession/addProfession'); ?>" class="page_btn">Add</a>
        <a onclick="javascript:$('#del_btn').trigger('click');" class="page_btn">Delete</a>
        <input type="submit" name="submit" id="del_btn" value="Delete" style="display:none;" />
      </div>
     </div>
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">
                  <th width="3%"><input type="checkbox" value="select" onclick="javascript:checkAll()" name="allbox" class="table_ckbox" /></th>
                  <th width="23%" > Profession Name </th>
                  <th width="23%" > Profession Description </th>
                  <th width="18%" >Edit</th>
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php
            foreach($listArr as $list) {
              echo '<tr id="row_'.$list['profession_id'].'">';
              echo '<td><input type="checkbox" value="'.$list['profession_id'].'" name="profession_id[]" /></td>';
              echo '<td>'.$list['profession_name'].'</td>';
              echo '<td>'.$list['profession_description'].'</td>';			  
			  
              echo '<td><a href="'.site_url('admin/profession/editProfession/'.$list['profession_id']).'"> Edit </a> | ';
              if($list['profession_is_active '] == "Y") {
	          	echo '<a href="javascript:activeProfession(\''.$list['profession_id'].'\',\'N\',this)" id="link_'.$list['profession_id'].'" title="Inactivate Profession">Active </a> | ';
			  }
			  else
				echo '<a href="javascript:activeProfession(\''.$list['profession_id'].'\',\'Y\',this)" id="link_'.$list['profession_id'].'" title="Acviate Profession">In-active </a> | ';
              echo '<a href="javascript:deleteProfession(\''.$list['profession_id'].'\')"> Delete </a></td>';
			  
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
	
	function deleteProfession(id)
	{
		if(confirm("Are You Sure?"))
		{
			$.ajax({
				url: "<?php echo site_url('admin/profession/deleteProfession'); ?>/"+id,
				success: function(msg) {
					$('#row_'+id).remove();
				}
			});
		}
	}
	
	function activeProfession(id,isActive,linkObj)
	{
		$.ajax({
			url: "<?php echo site_url('admin/profession/updateActive'); ?>/"+id+"/"+isActive,
			success: function(msg) {
				if(isActive == "Y")
				{
					$('#link_'+id).attr("href","javascript:activeProfession('"+id+"','N',this)");
					$('#link_'+id).html('Active');
					alert("Profession is active.");
				}
				else
				{
					$('#link_'+id).attr("href","javascript:activeProfession('"+id+"','Y',this)");
					$('#link_'+id).html('In-active');
					alert("Profession is in-active.");
				}
			}
		});
	}
</script>