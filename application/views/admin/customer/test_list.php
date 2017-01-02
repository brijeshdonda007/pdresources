<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a><span class="root_vr">/</span>
  <a href="<?php echo site_url('admin/customer/index/'); ?>" class="root_link">Customer List</a><span class="root_vr">/</span>
  <span class="root_link_remove">Test List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title"><?php echo $Title.' Test'; ?> List</div>

        <form name="search_form" id="search_form" action="<?php echo site_url('admin/customer/tests/'.$cust_id); ?>" method="post">
        <div class="page_btn_space_left" style="background:none;">          
        </div>   
        Select Test Type:<select name="testtype" id="testtype" style="height:29px;padding: 5px 5px 4px 0;position: relative;top:5px;left:10px;" onchange="javascript:document.search_form.submit();">
        	<option value="" <?php if($testtype == '') echo 'selected="selected"';?> >All</option>
        	<option value="Completed" <?php if($testtype == 'Completed') echo 'selected="selected"';?>>Completed</option>            
          	<option value="Failed" <?php if($testtype == 'Failed') echo 'selected="selected"';?>>Failed</option>            
            <option value="Running" <?php if($testtype == 'Running') echo 'selected="selected"';?>>Running</option>
            <option value="Stop" <?php if($testtype == 'Stop') echo 'selected="selected"';?>>Hold</option>
        </select>                           
     </form>                   

    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="<?php echo site_url('admin/customer/deleteCustomer'); ?>" method="post" onsubmit="return giveNotation();" >
     
     <div class="page_btn_space_right">
      <div style="float:left; padding-top:5px;">

      </div>
     </div>
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">                  
                  <th width="25%"> Test Name </th>
                  <th width="10%" > Right Answers </th>
	              <th width="10%" > Wrong Answers </th>
	              <th width="10%" > Skip Answers </th>                  
	              <th width="10%" > Date </th>                                    
                  <th width="10%" > Attempt Count </th>                                    
                  <th width="10%" > Exam Status</th>                                    
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php
            foreach($listArr as $list) {
              echo '<tr id="row_'.$list['cust_id'].'">';
              echo '<td>'.$list['test_name'].'</td>';
              echo '<td>'.$list['right_count'].'</td>';
			  echo '<td>'.$list['wrong_count'].'</td>';
			  echo '<td>'.$list['skip_count'].'</td>';				
			  echo '<td>'.date('d M,Y',strtotime($list['test_date'])).'</td>';							  
			  echo '<td>'.$list['test_attampt'].'</td>';				  			 
			  echo '<td>'.$list['current_responce'].'</td>';				  
              echo '</td></tr>';
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
