<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Proceedcheckout extends CI_Controller
{
	function Proceedcheckout()
	{
		parent::__construct();
		$this->mdl_common->checkUserSession();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_employee');		
		$this->load->model('mdl_coupon');		
		$this->load->model('mdl_author');				
	}	
	
	function index()
	{
		if($_POST)
		{
			if($_POST['update_price'] == 'Remove Coupon')
			{
				$CouponInfo=$this->cart->has_coupon();
				$this->mdl_coupon->RemoveToUsageCoupon($CouponInfo['coupon_id']);
				$this->cart->delete_coupon();
				$header['SucMsg']=$this->mdl_constants->CartMessages(18);
			}
			else
			{
				if(!trim($_POST['promo_code']))
					$header['ErrMsg']=$this->mdl_constants->CartMessages(4);
				else
				{
					$CouponInfo=$this->mdl_coupon->GetCouponInfoByCode(trim($_POST['promo_code']));
					if($CouponInfo['coupon_id'])
					{
						//Check for the expiry date of coupon
						if(strtotime($CouponInfo['coupon_expiry_date']) >= time()) 
						{
							//Check for the coupon usage limit
							if($CouponInfo['coupon_usage_limit'])
							{
								$usage_count=$this->mdl_coupon->GetCouponUsageCount($CouponInfo['coupon_id']);
								if($usage_count>$CouponInfo['coupon_usage_limit'])
									$header['ErrMsg']=$this->mdl_constants->CartMessages(7);	
								else
								{
									//Check wheather coupon is for the user or not
									if($CouponInfo['coupon_users'])
									{
										$userarr=explode(',',$CouponInfo['coupon_users']);
										//Check if it is for the valid user or not
										if(in_array($this->session->userdata('cust_id'),$userarr))
										{
											$this->mdl_coupon->AddToUsageCoupon($CouponInfo['coupon_id']);
											if(trim($CouponInfo['coupon_course']))
												$ItemInfo=explode(',',$CouponInfo['coupon_course']);								
											$CouponInfo=array(
														'Type'		=>	$CouponInfo['coupon_type'],
														'amount'	=>	$CouponInfo['coupon_discount_amt'],
														'coupon_id'	=>	$CouponInfo['coupon_id'],
														'Item_ids'	=>	$ItemInfo
											);
											$this->cart->coupon($CouponInfo);	
											$header['SucMsg']=$this->mdl_constants->CartMessages(19);
										}
										else
											$header['ErrMsg']==$this->mdl_constants->CartMessages(8);	
									}
									else
									{
										$this->mdl_coupon->AddToUsageCoupon($CouponInfo['coupon_id']);
										if(trim($CouponInfo['coupon_course']))
											$ItemInfo=explode(',',$CouponInfo['coupon_course']);								
										$CouponInfo=array(
													'Title'		=>	$CouponInfo['coupon_name'],
													'Code'		=>	$CouponInfo['coupon_code'],										
													'Type'		=>	$CouponInfo['coupon_type'],
													'amount'	=>	$CouponInfo['coupon_discount_amt'],
													'coupon_id'	=>	$CouponInfo['coupon_id'],
													'Item_ids'	=>	$ItemInfo
										);
										$this->cart->coupon($CouponInfo);	
										$header['SucMsg']=$this->mdl_constants->CartMessages(14);										
									}
								}									
							}
							else
							{
								//Check wheather coupon is for the user or not
								if($CouponInfo['coupon_users'])
								{
									$userarr=explode(',',$CouponInfo['coupon_users']);
									//Check if it is for the valid user or not
									if(in_array($this->session->userdata('cust_id'),$userarr))
									{
										$this->mdl_coupon->AddToUsageCoupon($CouponInfo['coupon_id']);
										if(trim($CouponInfo['coupon_course']))
											$ItemInfo=explode(',',$CouponInfo['coupon_course']);								
										$CouponInfo=array(
													'Title'		=>	$CouponInfo['coupon_name'],
													'Code'		=>	$CouponInfo['coupon_code'],
													'Type'		=>	$CouponInfo['coupon_type'],
													'amount'	=>	$CouponInfo['coupon_discount_amt'],
													'coupon_id'	=>	$CouponInfo['coupon_id'],
													'Item_ids'	=>	$ItemInfo
										);
										$this->cart->coupon($CouponInfo);	
										$header['SucMsg']=$this->mdl_constants->CartMessages(14);
									}
									else
										$header['ErrMsg']==$this->mdl_constants->CartMessages(8);
								}
								else
								{
									$this->mdl_coupon->AddToUsageCoupon($CouponInfo['coupon_id']);
									if(trim($CouponInfo['coupon_course']))
										$ItemInfo=explode(',',$CouponInfo['coupon_course']);								
									$CouponInfo=array(
												'Title'		=>	$CouponInfo['coupon_name'],	
												'Code'		=>	$CouponInfo['coupon_code'],									
												'Type'		=>	$CouponInfo['coupon_type'],
												'amount'	=>	$CouponInfo['coupon_discount_amt'],
												'coupon_id'	=>	$CouponInfo['coupon_id'],
												'Item_ids'	=>	$ItemInfo
									);
									$this->cart->coupon($CouponInfo);	
									$header['SucMsg']=$this->mdl_constants->CartMessages(14);										
								}
							}										
						}
						else
							$header['ErrMsg']=$this->mdl_constants->CartMessages(6);
					}
					else
						$header['ErrMsg']=$this->mdl_constants->CartMessages(5);
				}
			}
		}
		
		#To get All page links
		$this->load->view('header',$header);
		$this->load->view('cart/proceedcheckout');
		$this->load->view('footer',$footer);
	}	
	
}
?>