<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a><span class="root_vr">/</span>
  <a href="<?php echo site_url('admin/customer/index/'); ?>" class="root_link">Customer List</a><span class="root_vr">/</span>
  <span class="root_link_remove">Order List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title"><?php echo $Title.' Order'; ?> List</div>

        <form name="search_form" id="search_form" action="<?php echo site_url('admin/customer/order/'.$cust_id); ?>" method="post">
        <div class="page_btn_space_left" style="background:none;">          
        </div>   
        Select Order Type:<select name="ordertype" id="ordertype" style="height:29px;padding: 5px 5px 4px 0;position: relative;top:5px;left:10px;" onchange="javascript:document.search_form.submit();">
        	<option value="" <?php if($ordertype == '') echo 'selected="selected"';?> >All</option>
        	<option value="Completed" <?php if($ordertype == 'Completed') echo 'selected="selected"';?>>Completed</option>            
            <option value="Processing" <?php if($ordertype == 'Processing') echo 'selected="selected"';?>>Processing</option>
            <option value="Canceled" <?php if($ordertype == 'Canceled') echo 'selected="selected"';?>>Canceled</option>
        </select>                           
     </form>                   

    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="" method="post">
     
     <div class="page_btn_space_right">
      <div style="float:left; padding-top:5px;">

      </div>
     </div>
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">                  
                  <th width="25%"> Order No. </th>
                  <th width="25%" > Date </th>
	              <th width="25%" > Order Status </th>
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php
            foreach($listArr as $list) {
              echo '<tr id="row_'.$list['order_id'].'">';
              echo '<td>'.$list['order_id'].'</td>';
			  echo '<td>'.date('d M,Y',strtotime($list['order_date'])).'</td>';							  			  
              echo '<td>'.$list['order_status'].'</td>';
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
