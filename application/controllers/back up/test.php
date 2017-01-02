<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Test extends CI_Controller
{
	function Test()
	{
		parent::__construct();
		$this->load->model('mdl_test');
	}	
	function index($course_id='',$test_id='',$offset=0,$test_attampt='')
	{
		$course_id=6;
		$res=$this->mdl_test->get_test($course_id);
		if($res->num_rows > 0)
		{
			$TestInfo = $res->row_array();		
			$TestAllQuestion=$this->mdl_test->get_Question($TestInfo['test_id']);
			$res1=$this->mdl_test->get_Question($TestInfo['test_id'],$offset);
			if($TestAllQuestion->num_rows > 0)
			{			
				$TestQuestion=$res1->row_array();
				$totalQuestions=$TestAllQuestion->num_rows();
				$res2=$this->mdl_test->get_Option($TestQuestion['question_id']);				
				if($res2->num_rows > 0)
				{				
					$TestOptions=$res2->result();
				}
				else
					$data['error']='Sorry no option related Information is available for current question';				
			}
			else
				$data['error']='Sorry no question related Information is available for current test';
		}
		else
			$data['error']='Sorry no test related Information is there';
		$prev=$offset-1;
		$next=$offset+1;
		if($prev >0)
			$prev=$prev;
		else
			$prev=0;
		if($next >= $totalQuestions)
			$next=0;
		else
			$next=$next;
		$userInfo['cust_id']=0;
		$userInfo['cust_name']='Test';
		$this->session->set_userdata('userInfo',$userInfo);	
		if($this->session->userdata('test_attampt') == '' && $test_attampt !='')
		{
			$responce['cust_id']		=	$this->session->userdata['userInfo']['cust_id'];		
			$responce['course_id']		=	$course_id;		
			$responce['test_id']		=	$TestInfo['test_id'];		
			$responce['test_attampt']	=	$test_attampt;
			$flag=$this->mdl_test->UpdateStatus($responce);			
			$this->session->set_userdata('test_attampt',$test_attampt);	
		}

		//$this->session->unset_userdata('test_attampt');	
		if(is_array($TestInfo) && $totalQuestions > 0 && $course_id > 0 && $this->session->userdata('test_attampt') == '')
		{						
			$responce['cust_id']		=	$this->session->userdata['userInfo']['cust_id'];		
			$responce['course_id']		=	$course_id;		
			$responce['test_id']		=	$TestInfo['test_id'];		
			$responce['no_of_question']	=	$totalQuestions;
			$responce['current_responce']=	'Running';
			$test_attampt=$this->mdl_test->SaveTestResponce($responce);
			$this->session->set_userdata('test_attampt',$test_attampt);	
		}
		
		//$this->session->unset_userdata('count');	
		//$this->session->unset_userdata('Question_Info');	
		$test_attampt=$this->session->userdata('test_attampt');
		if($_REQUEST['question_id'])
		{
			$question_id=$_REQUEST['question_id'];
			$selected_option=$_REQUEST['selected'][0];			
			$responceDetail['cust_id']		=	$this->session->userdata['userInfo']['cust_id'];		
			$responceDetail['course_id']	=	$course_id;		
			$responceDetail['test_id']		=	$TestInfo['test_id'];		
			$responceDetail['test_attampt']	=	$test_attampt;
			$responceDetail['question_id']	=	$question_id;
			$responceDetail['responce']		=	$selected_option;
			$selectedOption=$_REQUEST['selected'][0];
			$rightOption=$_REQUEST['rightOption'];	
			if($selectedOption == $rightOption)
				$responceDetail['is_correct']=true;
			else
				$responceDetail['is_correct']=false;						
			$this->mdl_test->saveTestResponceDetail($responceDetail);// Insert/update data for current timestamp						
		}
		$responceDetail['cust_id']		=	$this->session->userdata['userInfo']['cust_id'];		
		$responceDetail['course_id']	=	$course_id;		
		$responceDetail['test_id']		=	$TestInfo['test_id'];		
		$responceDetail['test_attampt']	=	$test_attampt;
		$responceDetail['question_id']	=	$question_id;				
			
		$Question_Info=$this->mdl_test->GetAllContent($responceDetail);// Insert/update data for current timestamp			
		$count=count($Question_Info);												
		$data['completed']=floor(($count*100)/$totalQuestions);
			
		foreach($Question_Info as $key=>$val)
		{
			if($val['question_id'] == $TestQuestion['question_id'])
				$data['cheaked']=$val['responce'];	
		}
		$data['course_id']=$course_id;
		$data['test_attampt']=$test_attampt;		
		$data['TestInfo']=$TestInfo;
		$data['TestOptions']=$TestOptions;
		$data['TestQuestion']=$TestQuestion;
		$data['prev']=$prev;
		$data['next']=$next;
		$data['offset']=$offset;
		
		$this->load->view('test_view',$data);
	}	
	function result($course_id='',$test_id='')
	{		
		$test_attampt=$this->session->userdata('test_attampt');
		$this->session->unset_userdata('test_attampt');	
		$cust_id=$this->session->userdata['userInfo']['cust_id'];
		$TestInfo['course_id']		= $course_id;
		$TestInfo['test_id']		= $test_id;
		$TestInfo['test_attampt']	= $test_attampt;
		$TestInfo['cust_id']		= $cust_id;				
		$Result=$this->mdl_test->GenrateResult($TestInfo);// Insert/update data for current timestamp			
		$count=count($Result);
		$counter=0;
		foreach($Result as $key=>$val)
		{
			if($val['is_correct'] == 1)
				$counter++;
		}
		$completed=floor(($counter*100)/$count);		
		$data['completed']=$completed;
		$data['false']=100-$completed;		
		$data['course_id']=$course_id;
		$data['test_id']=$test_id;
		$this->session->unset_userdata('count');	
		$this->session->unset_userdata('Question_Info');	
		$this->load->view('result_view',$data);		
	}
	function StopTest($course_id='',$test_id='',$offset=0,$test_attampt='')
	{		
		$cust_id=$this->session->userdata['userInfo']['cust_id'];		
		$data['cust_id']=$cust_id;
		$data['course_id']=$course_id;
		$data['test_id']=$test_id;
		$data['test_attampt']=$test_attampt;
		$data['current_page_no']=$offset;
		
		$this->mdl_test->StopTest($data);			
		$this->session->unset_userdata('test_attampt');	
		redirect('test/PendingTest');
	}
	function PendingTest()
	{
		$cust_id=$this->session->userdata['userInfo']['cust_id'];
		$Result=$this->mdl_test->PendingTest($cust_id);					
		$data['result']=$Result;
		$this->load->view('pending_test',$data);
	}
}
?>