<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><span class="root_link_remove">Order List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title">Order List</div>
    <form name="search_form" id="search_form" action="<?php echo site_url('admin/order/index/'.$cust_id); ?>" method="post">
	 <div class="page_btn_space_left" style="350px; background:none !important;"></div>
        <div style="float:left;">
            <span style="float:left;display:block;">Select Order Type:</span>
            <span style="float:left;display:block;">
            	<select name="ordertype" id="ordertype" style="height:29px;padding: 5px 5px 4px 0;position: relative;" onchange="javascript:document.search_form.submit();">
                    <option value="" <?php if($ordertype == '') echo 'selected="selected"';?> >All</option>
                    <option value="Completed" <?php if($ordertype == 'Completed') echo 'selected="selected"';?>>Completed</option>            
                    <option value="Processing" <?php if($ordertype == 'Processing') echo 'selected="selected"';?>>Processing</option>
                    <option value="Canceled" <?php if($ordertype == 'Canceled') echo 'selected="selected"';?>>Canceled</option>
                </select>   
			</span>
        <div class="clear"></div>
		</div>
        <div style="float:left;">
        	<span style="float:left;display:block;">Customer:</span>
            <span style="float:left;display:block;"><input type="text" id="order_cust" name="order_cust" /></span>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        Start Date:<input type="text" id="start_date" name="start_date" value="<?php echo $start_date; ?>" />
        End Date:<input type="text" id="end_date" name="end_date" value="<?php echo $end_date; ?>" />     
        <input type="submit" name="submit" id="submit" value="Search" />                    
     </form>
    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="<?php echo site_url('admin/order/deleteOrder'); ?>" method="post" onsubmit="return giveNotation();" >
     
     <div class="page_btn_space_right">
      <div style="float:left; padding-top:5px;">
        <a onclick="javascript:$('#del_btn').trigger('click');" class="page_btn">Delete</a>
        <input type="submit" name="submit" id="del_btn" value="Delete" style="display:none;" />
      </div>
     </div>
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">
                  <th width="3%"><input type="checkbox" value="select" onclick="javascript:checkAll()" name="allbox" class="table_ckbox" /></th>
                  <th width="5%" > Order No.</th>                  
                  <th width="15%" > Customer</th>                                    
                  <th width="10%" > Date</th>                                    
                  <th width="10%" > Status</th>                                    
                  <th width="18%" >Edit</th>
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php
            foreach($listArr as $list) {
              echo '<tr id="row_'.$list['order_id'].'">';
              echo '<td><input type="checkbox" value="'.$list['order_id'].'" name="orders[]" /></td>';
              echo '<td>'.$list['order_id'].'</td>';
              echo '<td>'.$list['customer_name'].'</td>';
              echo '<td>'.date('d-m-Y',strtotime($list['order_date'])).'</td>';			  
              echo '<td>'.$list['order_status'].'</td>';			  			  			  
              echo '<td><a href="'.site_url('admin/order/editOrder/'.$list['order_id']).'"> Edit </a> | ';
              echo '<a href="javascript:deleteOrder(\''.$list['order_id'].'\')"> Delete </a></td>';
			  
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
	
	function deleteOrder(id)
	{
		if(confirm("Are You Sure?"))
		{
			$.ajax({
				url: "<?php echo site_url('admin/order/deleteOrder'); ?>/"+id,
				success: function(msg) {
					$('#row_'+id).remove();
				}
			});
		}
	}
	
	function activeOrder(id,isActive,linkObj)
	{
		$.ajax({
			url: "<?php echo site_url('admin/order/updateActive'); ?>/"+id+"/"+isActive,
			success: function(msg) {
				if(isActive == "publish")
				{
					$('#link_'+id).attr("href","javascript:activeOrder('"+id+"','draft',this)");
					$('#link_'+id).html('Active');
					alert("Order is active.");
				}
				else
				{
					$('#link_'+id).attr("href","javascript:activeOrder('"+id+"','publish',this)");
					$('#link_'+id).html('In-active');
					alert("Order is in-active.");
				}
			}
		});
	}
			
	$(function() {
		var dates = $( "#start_date, #end_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			maxDate: "d",
			yearRange: '1900:<?php echo date('Y'); ?>',
			numberOfMonths: 1,
			dateFormat:'dd-mm-yy',
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
	$(document).ready(function() {  	
		$("#order_cust").tokenInput("<?php echo site_url('admin/order/GetCustomer'); ?>", 
		{
			theme: "facebook",preventDuplicates: true,//tokenLimit: 1,
			<?php if($customer_arr){ ?>
			prePopulate: <?php echo $customer_arr;  } ?>
		});	
	});
</script>