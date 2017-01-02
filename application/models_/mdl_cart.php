<?php
/*class mdl_cart extends CI_Model
{
	function AddToCart($course_id)
	{
		$Basket=$this->session->userdata('Basket');
		$this->session->unset_userdata('Basket');
		if(!array_key_exists($course_id,$Basket['Course']))
		{
			$CourseInfo=$this->mdl_course->get_course($course_id);
			$data=array();
			$data['course_name']=$CourseInfo['course_name'];
			$data['course_price']=$CourseInfo['course_price'];
			$Basket['Course'][$CourseInfo['course_id']]=$data;			
		}
		$this->session->set_userdata('Basket',$Basket);
	}	
	function RemoveFromCart($course_id)
	{
		$Basket=$this->session->userdata('Basket');
		$this->session->unset_userdata('Basket');
		foreach($Basket['Course'] as $key=>$val)		
		{
			if($key == $course_id)
			{
				unset($Basket['Course'][$key]);
			}
		}		
		$this->session->set_userdata('Basket',$Basket);
	}	
}*/

class mdl_cart extends CI_Model
{
	var $Basket;
	function mdl_cart()
	{
		parent::__construct();
		$this->Basket=$this->session->userdata('Basket');
	}	
	function AddToCart($course_id)
	{		
		//$this->Basket=$this->session->userdata('Basket');
		//$this->session->unset_userdata('Basket');
		if(!array_key_exists($course_id,$this->Basket['Course']))
		{
			$CourseInfo=$this->mdl_course->get_course($course_id);
			$data=array();
			$data['course_name']=$CourseInfo['course_name'];
			$data['course_price']=$CourseInfo['course_price'];
			$this->Basket['Course'][$CourseInfo['course_id']]=$data;	
			$this->Basket['SubTotal']=	$this->Basket['SubTotal']+$CourseInfo['course_price'];	
		}
		$this->Calculate();
	}	
	function RemoveFromCart($course_id)
	{
		//$this->Basket=$this->session->userdata('Basket');
		//$this->session->unset_userdata('Basket');
		foreach($this->Basket['Course'] as $key=>$val)		
		{
			if($key == $course_id)
			{
				unset($this->Basket['Course'][$key]);
			}
		}		
		$this->Calculate();
		$this->SaveCart();
	}	
	function SaveCart()
	{				
		$this->session->set_userdata('Basket',$this->Basket);
	}
	function AddDiscount()
	{
		$this->Basket['Coupen_error']='';
		if($_REQUEST['submit'] == 'Apply Coupon')
		{
			if($_REQUEST['coupon_code'])
			{
				$this->db->like('coupon_code',$_REQUEST['coupon_code']);
				$res=$this->db->get('coupon_master');
				if($res->num_rows > 0)
				{
					$this->db->like('coupon_code',$_REQUEST['coupon_code']);					
					$this->db->where('date(coupon_expiry_date) >=',date('Y-m-d'));
					$res1=$this->db->get('coupon_master');
					//echo $this->db->last_query();
					if($res1->num_rows > 0)
					{
						$this->Basket['CoupenInfo']=$res->row_array();
					}
					else
						$this->Basket['Coupen_error']='This coupen is expired';						
				}
				else
					$this->Basket['Coupen_error']='Invalid coupen code Please try again';
			}
			else
				$this->Basket['Coupen_error']='Plese enter the coupon code';
		}
	}
	function CalculateDiscount()
	{
		$this->Basket['Dicount_amt']=0;
		if(is_array($this->Basket['CoupenInfo']))
		{
			$CoupenInfo=$this->Basket['CoupenInfo'];
			if($CoupenInfo['coupon_amt'] > 0)
			{
				$this->Basket['Dicount_amt']=$CoupenInfo['coupon_amt'];
			}
			else
			{
				$this->Basket['Dicount_amt']=floor(($this->Basket['SubTotal']*$CoupenInfo['coupon_percentage'])/100);
			}
		}
	}
	function CalculatetTotal()
	{
		$this->Basket['SubTotal']=0;
		foreach($this->Basket['Course'] as $key=>$val)
		{
			$this->Basket['SubTotal']+=$val['course_price'];
		}
		if($this->Basket['SubTotal'] > 0)			
			$this->Basket['Total']=$this->Basket['SubTotal']-$this->Basket['Dicount_amt'];
		else
		{
			$this->Basket['Dicount_amt']=$this->Basket['Total']=0;
		}
	}
	function RemoveCoupen()
	{
		unset($this->Basket['CoupenInfo']);
		$this->Calculate();
	}
	function Calculate()
	{
		$this->AddDiscount();
		$this->CalculateDiscount();	
		$this->CalculatetTotal();			
		$this->SaveCart();

	}
}