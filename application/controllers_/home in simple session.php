<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Home extends CI_Controller
{
	function Home()
	{
		parent::__construct();
		$this->load->model('mdl_test');
	}	
	function index($course_id='',$test_id='',$offset='')
	{
		$course_id=0;
		$res=$this->mdl_test->get_test($course_id);
		$TestInfo = $res->row_array();
		$TestAllQuestion=$this->mdl_test->get_AllTotal($TestInfo['test_id']);
		$res1=$this->mdl_test->get_Question($TestInfo['test_id'],$offset);
		$TestQuestion=$res1->row_array();
		$totalQuestions=$TestAllQuestion->num_rows();
		$res2=$this->mdl_test->get_Option($TestQuestion['question_id']);				
		$TestOptions=$res2->result();
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
		//session_destroy();	
		if($_REQUEST['question_id'])
		{
			$oldInfo=$_SESSION['Question_Info'];				
			$count=$_SESSION['count'];
			$selectedOption=$_REQUEST['selected'][0];
			$rightOption=$_REQUEST['rightOption'];	
			if($selectedOption == $rightOption)
				$status=true;
			else
				$status=false;		
			$question_id=$_REQUEST['question_id'];
			$SessionQuestion['selectedOption']=$selectedOption;
			$SessionQuestion['rightOption']=$rightOption;			
			$SessionQuestion['status']=$status;				
			if(!$count)
				$count=0;
			if(!array_key_exists($question_id,$oldInfo))
			{			
				$count=$count+1;
			}									
			$oldInfo[$question_id]=$SessionQuestion;
			$Question_Info=$oldInfo;
						
			$_SESSION['count']=$count;
			$_SESSION['Question_Info']=$oldInfo;						
		}
	echo '<pre>';
print_r($_SESSION);
echo '</pre>';
		$data['completed']=floor(($_SESSION['count']*100)/$totalQuestions);
		if(array_key_exists($TestQuestion['question_id'],$_SESSION['Question_Info']))
		{
			$data['cheaked']=$_SESSION['Question_Info'][$TestQuestion['question_id']]['selectedOption'];
		}
		$data['TestInfo']=$TestInfo;
		$data['TestOptions']=$TestOptions;
		$data['TestQuestion']=$TestQuestion;
		$data['prev']=$prev;
		$data['next']=$next;
		$data['offset']=$offset;
		$this->load->view('test_view',$data);
	}		
}
?>