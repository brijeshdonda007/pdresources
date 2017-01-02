<?php
class mdl_coupon extends CI_Model
{
	var $Basket;
	
	function mdl_coupon()
	{
		parent::__construct();		
	}	
	
	function GetCouponInfoByCode($code='',$id='')
	{
		if($id)
			$this->db->where('coupon_id',$id);
		if($code)
			$this->db->where('coupon_code',$code);
		$res=$this->db->get('pdr_coupon_master');
		return $res->row_array();
	}
	
	function GetCouponUsageCount($coupon_id)
	{
		$this->db->where('usage_coupon_id',$coupon_id);
		$this->db->where('usage_status','Used');
		$this->db->from('pdr_coupon_usage_master');
		return $this->db->count_all_results();
	}

	function GetCouponUsedByUser($coupon_id,$user_id)
	{		
		$this->db->where('usage_coupon_id',$coupon_id);
		$this->db->where('usage_user_id',$user_id);		
		$this->db->where('usage_status','Used');
		$this->db->from('pdr_coupon_usage_master');
		return $this->db->count_all_results();
	}
	
	function GetCouponForUser()
	{
		$user_id=$this->session->userdata('cust_id');
		$sql="select * from pdr_coupon_master where FIND_IN_SET($user_id,coupon_users) and UNIX_TIMESTAMP(coupon_expiry_date)>=".strtotime(date('Y-m-d'));
		$res=$this->db->query($sql);
		if($res->num_rows()>0)
		{
			$CouponInfo=$res->result_array();
			return $this->GetSuitableCoupon($CouponInfo);							
		}
		else
		{
			$sql1="select * from pdr_coupon_master where UNIX_TIMESTAMP(coupon_expiry_date)>=".strtotime(date('Y-m-d'));
			$res1=$this->db->query($sql1);
			if($res1->num_rows()>0)
			{
				$CouponInfo=$res1->result_array();
				return $this->GetSuitableCoupon($CouponInfo);				
			}
			else
				return false;
		}
	}
	
	function GetSuitableCoupon($CouponInfo)
	{
		$user_id=$this->session->userdata('cust_id');
		$ReturnCouponInfo='';		
		foreach($CouponInfo as $key=>$val)
		{
			if($val['coupon_usage_limit']>0)
			{
				$coupon_count=0;
				$coupon_count=$this->GetCouponUsageCount($val['coupon_id']);
				if($coupon_count > $val['coupon_usage_limit'])
					return false;
				else
				{
					$usage_flag=$this->GetCouponUsedByUser($val['coupon_id'],$user_id);
					if(!$usage_flag)
					{
						$ReturnCouponInfo=$val;
						break;
					}
					else
						continue;												
				}
			}
			else
			{
				$usage_flag=$this->GetCouponUsedByUser($val['coupon_id'],$user_id);
				if(!$usage_flag)
				{
					$ReturnCouponInfo=$val;
					break;
				}	
				else
					continue;							
			}			
		}		
		if(is_array($ReturnCouponInfo))
			return $ReturnCouponInfo;
		else
			return false;
	}
	
	function AddToUsageCoupon($coupoun_id)
	{
		$user_id=$this->session->userdata('cust_id');
		$data['usage_coupon_id']=$coupoun_id;
		$data['usage_user_id']=$user_id;
		$data['usage_status']='Used';
		$this->db->insert('pdr_coupon_usage_master',$data);			
	}
	
	function RemoveToUsageCoupon($coupoun_id)
	{
		$user_id=$this->session->userdata('cust_id');
		$data['usage_status']='Cancel';
		$this->db->where('usage_coupon_id',$coupoun_id);
		$this->db->like('usage_date',date('Y-m-d'));
		$this->db->update('pdr_coupon_usage_master',$data);
	}
	
	function ApplyCouponUser()
	{
		if($this->cart->has_coupon)
		{
			return $this->cart->has_coupon;
		}
		else
		{
			$CouponInfo=$this->GetCouponForUser();			
			if($CouponInfo)
			{
				$this->AddToUsageCoupon($CouponInfo['coupon_id']);
				$ItemInfo=array();
				$data['CouponInfo']=$CouponInfo;						
				if(trim($CouponInfo['coupon_course']))
					$ItemInfo=explode(',',$CouponInfo['coupon_course']);
				
				$CartCouponInfo=array(
							'Title'		=>	$CouponInfo['coupon_name'],
							'Code'		=>	$CouponInfo['coupon_code'],
							'Type'		=>	$CouponInfo['coupon_type'],							
							'amount'	=>	$CouponInfo['coupon_discount_amt'],
							'coupon_id'	=>	$CouponInfo['coupon_id'],
							'Item_ids'	=>	$ItemInfo
				);				
				$this->cart->coupon($CartCouponInfo);
				return $CartCouponInfo;
			}
			else
				return '';

		}
			
	}
	
	function RemoveUnusedCoupoun()
	{
		$CouponInfo=$this->cart->has_coupon();		
		$this->mdl_coupon->RemoveToUsageCoupon($CouponInfo['coupon_id']);
		$this->Clearunusedcoupon();
	}
	
	function Clearunusedcoupon()
	{
		$timelimit=strtotime('-1 day');
		$sql="select * from pdr_coupon_usage_master where usage_order_id=0 and usage_status like 'Used' and UNIX_TIMESTAMP(usage_date)<=".$timelimit;
		$res=$this->db->query($sql);
		$data=$res->result_array();
		foreach($data as $key=>$val)
		{
			$udata['usage_status']='Cancel';
			$this->db->where('usage_id',$val['usage_id']);
			$this->db->update('pdr_coupon_usage_master',$udata);
		}
		return true;
	}	
}