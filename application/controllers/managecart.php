<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Managecart extends CI_Controller
{
	function Managecart()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_employee');		
		$this->load->model('mdl_test');		
	}	
	function index($msg_id='')
	{		
	}	
	
	function AddToCart()
	{
		$item_id=$_REQUEST['course_id'];
		$flag=$this->ValidateCourse($item_id);
		$CourseInfo=$this->mdl_course->get_courseInfoByid($item_id);
		if(is_array($CourseInfo))
		{
			if($flag)
			{
				if($this->session->userdata('cust_id')> 0)
				{
					$oldcourses=$this->mdl_course->GetAllOldCourse();					

					if(in_array($item_id,$oldcourses))
					{
						echo 9;
						exit();
					}
					else if($CourseInfo['course_reenrolment'] == 'No')
					{
						$AllCourses=$this->mdl_course->GetAllOldCourse(true);
						if(in_array($item_id,$AllCourses))
						{
							echo 10;																			
							exit();
						}
					}
				}
				$intimedate=strtotime($CourseInfo['course_expiry_date']);
				$timelimit=strtotime(date("Y-m-d",$intimedate)." -5 day");
				
				if(time()<=$timelimit && $CourseInfo['course_expired_price'])		
					$price=$CourseInfo['course_expired_price'];
				else if($CourseInfo['course_sale_price'] > 0)
					$price=$CourseInfo['course_sale_price'];
				else
					$price=$CourseInfo['course_online_price'];
					
				$data = array(
					   'id'      => $CourseInfo['course_id'],
					   'qty'     => 1,
					   'price'   => $price,
					   'name'    => $CourseInfo['course_name'],
					   'image'	=>	$CourseInfo['course_image'],
					);
	
				$this->cart->insert($data);
				echo 16;
			}
			else
				echo 3;
		}
		else
			echo 2;
	}
	
	function RemoveFromCart()
	{
		$item_id=$_REQUEST['course_id'];		
		
		if($item_id)
		{
			$data = array(
				   'rowid' => $item_id,
				   'qty'   => 0
				);
			$this->cart->update($data); 			
			echo 17;
		}
		else
			echo 2;
	}
	
	function ItemCount()
	{
		echo $this->cart->total_items();
	}
	
	function GetCartMsg()
	{
		$msg_id=$_REQUEST['msg_id'];
		echo $this->mdl_constants->CartMessages($msg_id);
	}
	
	function ValidateCourse($course_id)
	{
		foreach($this->cart->contents() as $key=>$val)
        {
			$item_id_array[]=$val['id'];
		}
		if(in_array($course_id,$item_id_array))
			return false;
		else
			return true;
	}
}
?>