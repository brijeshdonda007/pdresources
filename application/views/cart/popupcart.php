	<div class="cart_slider_space">
	<div class="cart_slider_outer">
    	<div class="cart_slider_title">proffessional development resources</div>
        <div class="popup_msg signup_msg success" style="display:none;width: 300px;position: absolute;top: 0px;left: 310px;">
          	Success: <span></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close">
          </div>
          <div class="popup_msg signup_msg warning" style="display:none;width: 300px;position: absolute;top: 0px;left: 310px;">
          	Warning: <span></span><img src="<?php echo base_url(); ?>images/close.png" alt="" class="signup_msg_close">
          </div>
        <div class="cart_slider_inner">
        	<p class="psychology_title" style="border-bottom-style:dotted;border-color:#000;">Your Shopping Cart, <?php if($this->session->userdata('cust_id')) echo $this->session->userdata('cust_fname').' '.$this->session->userdata('cust_lname');else echo 'Guest'; ?></p>
            <a href="javascript:void(0);" class="cart_slider_close"></a> 
            	<div id="updated_data_cart">
				<?php if($this->cart->total_items() > 0){ ?>  
                <!--start[cart table box]-->
                <div class="cart_table_box">
                    <div class="cart_table_title_raw">
                        <p class="cart_slider_subtitle course">Course</p>
                        <p class="cart_slider_subtitle credits">cost</p>
                        <p class="cart_slider_subtitle cost">Discount</p>
                        <p class="cart_slider_subtitle cost">Total</p>
                        <div class="clear"></div>
                    </div>
                    
                    <div class="cart_item_box">
                        <?php 
                        
                            foreach($this->cart->contents() as $key=>$val)
                            {
									if($val['image'])
										$small_name=base_url().$val['image'];
									else
										$small_name=base_url().'image/course_image.jpg';					
                        ?>   
                                    <!--start[cart item raw]-->
                                    <div class="cart_item_raw">                            
                                        <div class="cart_item_img"><img src="<?php echo $small_name; ?>" width="75" height="109" alt="" /></div>
                                        <div class="cart_item_disc">
                                            <p class="cart_item_title"><?php echo $val['name']; ?></p>
                                            <!--<p class="cart_item_subtitle">Stanislas Dehaene</p>-->
                                        </div>
                                        <!--<div class="cart_item_credits"><?php echo $val['qty']; ?></div>-->
                                        <div class="cart_item_cost">$<?php echo $val['price']; ?></div>
                                        <div class="cart_item_credits">$<?php echo $val['discount']?$val['discount']:0; ?></div>                                                                        
                                        <div class="cart_item_cost">$<?php echo $val['total']; ?></div>
                                        <a href="javascript:void(0);" onclick="Removefromcart('<?php echo $val['rowid'] ?>','popup');" class="remove_link">REMOVE</a>
                                        <div class="clear"></div>
                                    </div>
                                    <!--end[cart item raw]-->                    
                        <?php  } ?>
                    </div>
                    <!--start[cart total raw]-->
                    <div class="cart_total_raw" >
                        <p class="sub_total_text" style="font-size:10px;">SUB-TOTAL</p>
                        <p class="totla_payment_text" style="font-size:11px;">$<?php echo $this->cart->sub_total(); ?></p>
                        <div class="clear"></div>
                    </div>
                    <!--end[cart total raw]-->
                    <div class="clear"></div>
                    <!--start[cart total raw]-->
                    <div class="cart_total_raw">
                        <p class="sub_total_text" style="font-size:10px;">Discount Amount</p>
                        <p class="totla_payment_text" style="font-size:11px;">$<?php echo $this->cart->discount_total(); ?></p>
                        <div class="clear"></div>
                    </div>
                    <!--end[cart total raw]-->
                    <div class="clear"></div>
                    <!--start[cart total raw]-->
                    <div class="cart_total_raw">
                        <p class="sub_total_text">Total</p>
                        <p class="totla_payment_text">$<?php echo $this->cart->total(); ?></p>
                        <div class="clear"></div>
                    </div>
                    <!--end[cart total raw]-->
                    <div class="clear"></div>
                    <div class="bottom_btn_raw">
                	<a href="<?php echo site_url('proceedcheckout'); ?>" class="proceed_checkout_btn"></a>
                	<a href="<?php echo $this->session->userdata('continue_url')?$this->session->userdata('continue_url'):site_url('home'); ?>" class="continue_shopping_btn"></a>
                        <div class="clear"></div>
                    </div>
                </div>
                <!--end[cart table box]-->
                <?php } else echo '<p style="font-size:24px;height:100px;line-height:100px;text-align:center;">'.$this->mdl_constants->CartMessages(1).'</p>'; ?> 
                </div>               	           
        </div>
    </div>
    </div>
