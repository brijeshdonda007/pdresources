<?php
class mdl_cart extends CI_Model
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
}