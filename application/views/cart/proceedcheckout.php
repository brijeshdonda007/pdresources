<!--Srart [ part2 ]-->
<div class="part2">
	<!--start[part content]-->
	<div class="part2_content_outer">
 
    	<!--start[white box]-->
    	<div class="part2_contnet_inner">
        	<div class="content_box" style="position:relative;">
        		<p class="a_shopping_title">Your Shopping Cart,  <?php if($this->session->userdata('cust_id')) echo $this->session->userdata('cust_fname').' '.$this->session->userdata('cust_lname');else echo 'Guest'; ?></p>
				<div id="updated_data_cart">                
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
										$authour_name=$sort_desc='';
                                        if($val['image'])
                                            $small_name=base_url().$val['image'];
                                        else
                                            $small_name=base_url().'image/course_image.jpg';					
										$CourseInfo=$this->mdl_course->get_courseInfoByid($val['id']);																		
										$sort_desc=substr(strip_tags($CourseInfo['course_desc']),0,100);
										if($CourseInfo['course_author'])
										{
											$AuthourInfo=$this->mdl_author->getAuthuonfoById($CourseInfo['course_author']);
											$authour_name=$AuthourInfo['author_fname'].' '.$AuthourInfo['author_lname'];
										}
                                ?>   
                                    <!--start[shoping cart raw]-->
                                    <div class="a_img_content_part">
                                        <div class="a_img_box"><img src="<?php  echo $small_name; ?>"></div>
                                        <div class="a_raeding_text_part">
                                            <p class="a_reading_text"><?php echo $val['name']; ?></p>
                                            <p class="a_stanislas_text"><?php echo $authour_name; ?></p>
                                            <span class="a_short_text"><?php echo $sort_desc; ?></span>
                                        </div>
                                        <div class="a_no_part" style="margin-right:25px;">
                                            <p class="a_short_text">$<?php echo $val['price']?$val['price']:0; ?></p>
                                        </div>
                                        <div class="a_no_part" style="margin-right:20px;">
                                            <p class="a_short_text">$<?php echo $val['discount']?$val['discount']:0; ?></p>
                                        </div>
                                        <div class="a_no_part" style="margin-right:15px;">
                                            <p class="a_short_text">$<?php echo $val['total']?$val['total']:0; ?></p>
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
                            <form name="Coupon" id="Coupon" method="post">
							<?php if($this->cart->has_coupon()){ ?>                            
	                            	<input type="submit" value="Remove Coupon" name="update_price" id="update_price" class="update_price_btn" style="float:right;" />
                            <?php }else{ ?>
                                <p class="sub_total_text" style="text-align:right;">Promotion code</p>
                                <input type="text" value="" name="promo_code" id="promo_code" class="promo_code_input" />
                                <input type="submit" value="Update" name="update_price" id="update_price" class="update_price_btn" />
                            <?php } ?>
                            </form>
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
		                	<a href="<?php echo site_url('order'); ?>" class="proceed_checkout_btn"></a>
        		        	<a href="<?php echo $this->session->userdata('continue_url')?$this->session->userdata('continue_url'):site_url('home'); ?>" class="continue_shopping_btn"></a>
                            <div class="clear"></div>
                        </div>
                    <?php } else echo '<p style="font-size:24px;height:100px;line-height:100px;text-align:center;">'.$this->mdl_constants->CartMessages(1).'</p>'; ?>                 
                </div>
            </div>           
        </div>
        <!--end[white box]-->
        <div class="h_ruler"></div>
        <div class="home_title_raw">
        	<p class="about_team_title">SHOP WITH CONFIDENCE</p>
            <div class="about_team_disc">This can talk about the professional experience and dedication and quality you’ll receive purchasing classes through PDR. Satisfaction gauranteed paragraph goes here. This can talk about the professional experience and dedication and quality you’ll receive purchasing classes through PDR. Satisfaction gauranteed paragraph goes here.</div>
            <div class="team_box">
            	<p class="shop_with_text">Forms of payment accepted. Paypal verified and accepted and other things along these lines of payment can go here.</p>
                <div class="paypal_veryfy_icon"><img src="<?php echo base_url(); ?>images/paypal_verified.png" width="300" height="125" alt="" /></div>
            </div>
            <!--end[team box]-->
            <div class="clear"></div>
        </div>
        <div class="h_ruler"></div>
    </div>
    
    <!--start[part content]-->
</div>
<!--End [ part2 ]-->