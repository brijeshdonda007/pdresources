            
					<?php if($this->cart->total_items() > 0){ ?>  
                        <div class="a_cource_cradit_part">
                            <p class="a_corse_text" style="margin-right:512px;">Course</p>
                            <p class="a_corse_text" style="margin-right:35px;">cost</p>
                            <p class="a_corse_text" style="margin-right:20px">Discount</p>
                            <p class="a_corse_text">Total</p>
                            <div class="clear"></div>
                        </div>
                        <div class="shoping_cart_box">
                             <?php                             
                                    foreach($this->cart->contents() as $key=>$val)
                                    {							
                                        if($val['image'])
                                            $small_name=base_url().$val['image'];
                                        else
                                            $small_name=base_url().'image/course_image.jpg';					
                                ?>   
                                    <!--start[shoping cart raw]-->
                                    <div class="a_img_content_part">
                                        <div class="a_img_box"><img src="<?php  echo $small_name; ?>"></div>
                                        <div class="a_raeding_text_part">
                                            <p class="a_reading_text"><?php echo $val['name']; ?></p>
                                            <!--<p class="a_stanislas_text">Stanislas Dehaene</p>-->
    <!--                                        <p class="a_short_text">Notepad is a basic text-editing program and it's most commonly used to view or edit text files.Notepad is a basic text-editing program and it's most commonly A text file is a file type typically identified by the .txt file name extension.
                    
                    </p>
    -->                                    </div>
                                        <div class="a_no_part" style="margin-right:25px;">
                                            <p class="a_short_text">$<?php echo $val['price']; ?></p>
                                        </div>
                                        <div class="a_no_part" style="margin-right:20px;">
                                            <p class="a_short_text">$<?php echo $val['discount']?$val['discount']:0; ?></p>
                                        </div>
                                        <div class="a_no_part" style="margin-right:15px;">
                                            <p class="a_short_text">$<?php echo $val['total']; ?></p>
                                        </div>

                                        <div class="a_no_part">
                                            <a href="javascript:void(0);" onclick="javascript:Removefromcart('<?php echo $val['rowid'] ?>',true);" class="a_remove_text">remove</a>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <!--end[shoping cart raw]-->                    
                                <?php } ?>                                        
                        </div>
                        
                        <!--start[cart total raw]-->
                        <div class="cart_total_raw">
                            <p class="sub_total_text" style="text-align:right;">SUB-TOTAL</p>
                            <p class="totla_payment_text" style="font-size: 14px;width:100px;padding-top:4px;">$<?php echo $this->cart->sub_total(); ?></p>
                            <div class="clear" style="height:10px;"></div>
                            <p class="sub_total_text" style="text-align:right;">Discount Amount</p>
                            <p class="totla_payment_text" style="font-size: 14px;width:100px;padding-top:4px;">$<?php echo $this->cart->discount_total(); ?></p>
                            <div class="clear" style="height:10px;"></div>
                            <p class="sub_total_text" style="text-align:right;">Promotion code</p>
                            <input type="text" value="" name="promo_code" class="promo_code_input" />
                            <input type="button" value="update" name="update_price" class="update_price_btn" />
                            <div class="clear"></div>
                        </div>
                        <!--end[cart total raw]-->
                        <div class="clear"></div>
                        <!--start[cart total raw]-->
                        <div class="cart_total_raw">
                            <p class="sub_total_text" style="text-align:right; ">TOTAL</p>
                            <p class="totla_payment_text">$<?php echo $this->cart->total(); ?></p>
                            <div class="clear"></div>
                            <p class="code_applied_text">Special 30% psychology courses promotion code applied</p>
                            <div class="clear"></div>
                        </div>
                        <!--end[cart total raw]-->
                        <div class="clear"></div>
                        <div class="bottom_btn_raw">
			               	<a href="<?php echo site_url('proceedcheckout'); ?>" class="proceed_checkout_btn"></a>
            		    	<a href="<?php echo $this->session->userdata('continue_url')?$this->session->userdata('continue_url'):site_url('home'); ?>" class="continue_shopping_btn"></a>
                            <div class="clear"></div>
                        </div>
                    <?php } else echo '<p style="font-size:24px;height:100px;line-height:100px;text-align:center;">'.$this->mdl_constants->CartMessages(1).'</p>'; ?>                 
