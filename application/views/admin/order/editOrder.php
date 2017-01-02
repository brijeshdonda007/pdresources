<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><a href="<?php echo site_url('admin/order/index/s'); ?>" class="root_link">Order List</a>
  <span class="root_vr">/</span><span class="root_link_remove">Edit Order</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<!-- Start [ Page ]-->
<div class="page">  
  
  <!--Start [ Right Nav ]-->
  	<div class="page_title" style="margin-left:15px;">Edit Order</div>
    <div style="height:10px; display:block;"></div>
    
	<div class="right_nav" style="width:98%">
      <div class="form_parent" style="float:left;width:46%;margin-right:3%;">
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%" style="padding:0;">
            <tr>
            <th style="background:#2E2E2E;color:#fff;padding:10px;">Order # <?php echo $order_id; ?></th>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
            <tr>
              <td>Order Date</td>
              <td><b><?php echo date('M d,Y h:m:i A',strtotime($order_date)); ?></b></td>
            </tr>
            <tr>
              <td>Order Status</td>
              <td><b><?php echo $order_status;?></b></td>
            </tr>
        </table>
      </div>
      
      <div class="form_parent" style="float:left;width:46%;">
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%" style="padding:0;">
            <tr>
            <th style="background:#2E2E2E;color:#fff;padding:10px;">Account Information</th>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
            <tr>
              <td>Customer Name</td>
              <td><b><?php echo $CustomerInfo['cust_fname'].' '.$CustomerInfo['cust_lname'] ?></b></td>
            </tr>
            <tr>
              <td>Email</td>
              <td><b><?php echo $CustomerInfo['cust_email'] ?></b></td>
            </tr>
        </table>
      </div>
      <div class="clear"></div>
  </div>
  
  	<div class="right_nav" style="width:98%">
      <div class="form_parent" style="float:left;width:46%;margin-right:3%;">
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%" style="padding:0;">
            <tr>
            <th style="background:#2E2E2E;color:#fff;padding:10px;">Payment Information</th>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
            <tr>
              <td>Order Date</td>
              <td><b>Apr 28, 2012 4:20:44 AM</b></td>
            </tr>
            <tr>
              <td>Order Status</td>
              <td><b>Complete</b></td>
            </tr>
        </table>
      </div>
      <div class="clear"></div>
  </div>
  
  	<div class="right_nav" style="width:96.5%">
      <div class="form_parent">
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%" style="padding:0;">
            <tr>
            <th style="background:#2E2E2E;color:#fff;padding:10px;">Items Ordered</th>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
            <tr style="background:#8e8e8e;">
              <th width="70%" style="padding:5px;">Product</th>
              <th width="10%" style="padding:5px;">Sub Total</th>
              <th width="10%" style="padding:5px;">Discount Amount</th>
              <th width="10%" style="padding:5px;">Total</th>
            </tr>
            <?php 
				$flag=0;
				foreach($CourseInfo as $key=>$val)
				{
					if($flag)
					{
						$style="background:#cccccc;";
						$flag=0;
					}
					else
					{
						$style="background:#fff;";
						$flag=1;
					}
					echo '<tr style="'.$style.'">
							  <td style="padding:5px;">'.$val['course_name'].'</td>
							  <td style="padding:5px;">'.$val['ocd_course_sub_total'].'</td>
							  <td style="padding:5px;">'.$val['ocd_discount_amt'].'</td>
							  <td style="padding:5px;">'.$val['ocd_course_total'].'</td>
						 </tr>';					
				}
			?>
            <!--<tr style="background:#fff;">
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
            </tr>
            <tr style="background:#cccccc;">
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
            </tr>
            <tr style="background:#fff;">
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
            </tr>
            <tr style="background:#cccccc;">
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
            </tr>
            <tr style="background:#fff;">
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
            </tr>
            <tr style="background:#cccccc;">
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
              <td style="padding:5px;">Order Status</td>
              <td style="padding:5px;">Complete</td>
            </tr>-->
        </table>
      </div>
  </div>
  
  	<div class="right_nav" style="width:98%">
      <div class="form_parent" style="float:left;width:46%;margin-right:3%;">      
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%" style="padding:0;">
            <tr>
            <th style="background:#2E2E2E;color:#fff;padding:10px;">Comments History</th>
            </tr>
        </table>
        <form action="" id="form" name="form" method="post" enctype="multipart/form-data">
            <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
                <tr>
                  <th style="padding:5px;font-size:14px;" colspan="3">Add Order Comments</th>
                </tr>
                <tr>
                  <td style="padding:5px;" width="10%">Status</td>
                  <td style="padding:5px;" width="80%">
                    <select name="order_status" id="order_status" style="padding:3px;width:291px;">                    
                        <option value="Completed" <?php if($order_status == 'Completed') echo 'selected="selected"';?>>Completed</option>            
                        <option value="Processing" <?php if($order_status == 'Processing') echo 'selected="selected"';?>>Processing</option>
                        <option value="Canceled" <?php if($order_status == 'Canceled') echo 'selected="selected"';?>>Canceled</option>
                    </select> 
                  </td>
                  <td width="10%"></td>
                </tr>
                <tr>
                  <td style="padding:5px;">Comment</td>
                  <td style="padding:5px;"><textarea name="comment_text" id="comment_text" class="textarea"></textarea></td>
                  <td width="10%" align="left" style="color:#FF0000;"><?php  echo form_error('comment_text');?></td>
                </tr>
                <tr>
                  <td style="padding:5px;"></td>	
                  <td style="padding:5px;"><label><input type="checkbox" value="comment_notify" name="comment_notify" <?php if($comment_notify) echo 'checked="checked"'; ?> style="position:relative;display:inline-block;margin-right:10px;top:1px;" />Notify Customer by Email</label></td>
                </tr>
<!--                <tr>
                  <td style="padding:5px;"></td>
                  <td style="padding:5px;"><input type="checkbox" value="" name="" style="position:relative;display:inline-block;margin-right:10px;top:1px;" />Visible on Frontend</td>
                  <td width="10%"></td>
                </tr>
-->             <tr>
                  <td style="padding:5px;"></td>
                  <td style="padding:5px;">
                  <input type="submit" name="submit" class="submit_btn" value="Submit" style="display:block;float:left; margin-right:10px;" />
                  <input type="button" value="Back" class="submit_btn" onclick="javascript:history.go(-1);" style="display:block;float:left;width:67px;" />
                  <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id;?>" />
                  <input type="hidden" name="customer_email" id="customer_email" value="<?php echo $CustomerInfo['cust_email'] ?>" />
                  <div class="clear"></div>
                  </td>
                  <td width="10%"></td>
                </tr>
            </table>
		</form>
      </div>
      
      <div class="form_parent" style="float:left;width:46%;">
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%" style="padding:0;">
            <tr>
            <th style="background:#2E2E2E;color:#fff;padding:10px;">Order Totals</th>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
            <tr style="background:#fff;">
              <td width="80%" align="right" style="padding:5px;"><b>Subtotal</b></td>
              <td width="20%" align="right" style="padding:5px;">$<?php echo $order_sub_total ?></td>
            </tr>
            <tr style="background:#ccc;">
              <td width="80%" align="right" style="padding:5px;"><b>Total Discount</b></td>
              <td width="20%" align="right" style="padding:5px;">$<?php echo $order_discount_amt ?></td>
            </tr>
            <tr style="background:#fff;font-size:16px;">
              <td width="80%" align="right" style="padding:5px;"><b>Grand Total</b></td>
              <td width="20%" align="right" style="padding:5px;">$<?php echo $order_total ?></td>
            </tr>
        </table>
      </div>
      <div class="clear"></div>
  	</div>
    <?php if(is_array($CommentHistory) && $CommentHistory) {?>
        <div class="right_nav" style="width:98%">
          <div class="form_parent" style="float:left;width:46%;margin-right:3%;">
            <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%" style="padding:0;">
                <tr>
                <th style="background:#2E2E2E;color:#fff;padding:10px;">Comments History</th>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
                <tr>
                    <td>
                    	<?php 
							$flag=0;
							foreach($CommentHistory as $key=>$val)
							{
								if($flag)
								{
									$style="background:#cccccc;";
									$flag=0;
								}
								else
								{
									$style="background:#fff;";
									$flag=1;
								}
						?>
		                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="<?php echo $style; ?>">
                                    <tr>
                                    <td style="padding:5px;">
                                        <p><b>Apr 28, 2012<?php echo date('M d, Y',strtotime($val['comment_date'])); ?></b><span> <?php echo date('h:i:s A',strtotime($val['comment_date'])); ?></span> | <span><?php echo $$val['comment_status'] ?></span></p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td style="padding:5px;">
                                        <p>Customer <span style="color:#306375;"><b><?php echo $val['comment_notify'] ?></b></span></p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td style="padding:5px;">
                                        <p><?php echo $val['comment_text'] ?></p>
                                    </td>
                                    </tr>
                                </table>
                        <?php		
							}
						?>                                                                        
                    </td>
                </tr>
            </table>
          </div>
          <div class="clear"></div>
        </div>
    <?php } ?>
  <!--End [ Right Nav ]-->
  
  <div class="clear"></div>
</div>
<!-- End [ Page ]-->
