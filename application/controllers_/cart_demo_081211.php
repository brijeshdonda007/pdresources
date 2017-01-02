<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class cart_demo extends CI_Controller
{
	function cart_demo()
	{
		parent::__construct();
		$this->load->model('mdl_course');
		$this->load->model('mdl_cart');		
	}	
	function index()
	{
//		$this->session->unset_userdata('Basket');
		$Basket=$this->session->userdata('Basket');
		$data['count']=count($Basket['Course']);
		if(is_array($Basket['Course']))
		{
			$total=0;
			foreach($Basket['Course'] as $key=>$val)
			{
				$total=$total+$val['course_price'];
			}
		}
		else
			$total=0;
		$data['Basket']=$Basket;
		$data['total']=$total;
		$data['CourseData']=$this->mdl_course->get_course();
		$this->load->view('demo_page',$data);		
	}	
	function CartManage($action='')
	{
		switch($action)
		{
			case 'add':
						$this->mdl_cart->AddToCart($_REQUEST['course_id']);					
						break;
			case 'remove':
						$course_id=$_REQUEST['course_id'];
						if(is_array($course_id))
						{
							foreach($course_id as $key=>$val)
								$this->mdl_cart->RemoveFromCart($val);													
						}
						else
							$this->mdl_cart->RemoveFromCart($course_id);					
						break;
		}
		$Basket=$this->session->userdata('Basket');
		$this->SetData($action);
	}
	function SetData($action='')
	{
		$Basket=$this->session->userdata('Basket');
		if(is_array($Basket['Course']))
		{
			$total=0;
			foreach($Basket['Course'] as $key=>$val)
			{
				$total=$total+$val['course_price'];
			}
		}
		else
			$total=0;
		echo '<div align="center" id="cartInfo">
    	<h4>Shopping Cart</h4>
        <a href="javascript:void(0);" onclick="javascript:ShowhideCartContent()">'.count($Basket['Course']).' Item(s)-'.$total.'</a>';
		if($action == 'add')
			echo'<div id="cart_content" style="display:none;">';
		else
			echo'<div id="cart_content">';		
		if(count($Basket['Course']) > 0)
		{
			echo '<table width="370" border="1">';
			foreach($Basket['Course'] as $key=>$val)
			{
				echo '<tr>';
				echo '<td>'.$val['course_name'].'</td>';
				echo '<td>'.$val['course_price'].'</td>';
				echo '<td><a href="javascript:void(0);" onclick="javascript:RemoveFromcart('.$key.')">Remove</a></td>';			
				echo '</tr>';
			}
			echo '</table>';
		}
		else
			echo 'Sorry your shopping cart is empty.';
        echo '</div>
	    </div>';
	}
}
?>