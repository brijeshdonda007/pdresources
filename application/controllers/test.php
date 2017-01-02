<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Test extends CI_Controller
{
	function Test()
	{		
		parent::__construct();
		$this->mdl_common->checkUserSession();
		$this->load->model('mdl_test');
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_employee');
		$this->load->model('mdl_dashbord');
		$this->load->model('mdl_evaluation');
	}	
	
	function index($course_id='',$order_id='')
	{
		if($course_id <=0)
			redirect('home');
		$TestInfo=$this->mdl_test->get_test($course_id);

		if(!is_array($TestInfo))
			redirect('home');
		$cust_id=$responce['cust_id']=$this->session->userdata('cust_id');		
		$TestQuestionInfo=$this->mdl_test->GetTestView($TestInfo['test_id'],$test_attampt,$cust_id,$course_id);

		$responce['course_id']		=	$course_id;		
		$responce['order_id']		=	$order_id;				
		$responce['test_id']		=	$TestInfo['test_id'];		
		$responce['no_of_question']	=	count($TestQuestionInfo);
		$responce['current_responce']=	'Running';
		$responce['test_date']=date('Y-m-d H:i:s',time());		
		$old_responce=$this->mdl_test->GetOldTestResponce($responce);		
		$data='';
		
		if($old_responce['responce_status'] == 'Passed')
			$data['is_passed']=true;
		else if($old_responce['responce_status'] == 'Failed' && $old_responce['test_attampt']>=3)
			$data['is_failed']=true;
		else
		{
			$test_attampt=$this->mdl_test->SaveTestResponce($responce);		
			$msg="Started Test of".$TestInfo['test_name'];	
			$this->mdl_course->AddActivity($msg);
		}
		
		$CourseInfo=$this->mdl_course->get_courseInfoByid($course_id);
		if($CourseInfo['course_reenrolment'] == 'Yes')
			$data['reenrollflag']=true;

		$header['page_title']=$TestInfo['test_name'];
		$data['TestInfo']=$TestInfo;
		$data['TestQuestionInfo']=$TestQuestionInfo;
		$data['test_attampt']=$test_attampt;
		$data['course_id']=$course_id;
		$data['cust_id']=$cust_id;
		$data['order_id']=$order_id;

		$this->load->view('header',$header);
		$this->load->view('test/home',$data);
		$this->load->view('footer',$footer);
	}
	
	function resume($course_id='',$order_id='')
	{
		if($course_id <=0)
			redirect('home');
		$TestInfo=$this->mdl_test->get_test($course_id);

		if(!is_array($TestInfo))
			redirect('home');
			
		$temp['cust_id']=$cust_id=$responce['cust_id']		=	$this->session->userdata('cust_id');		
		$temp['course_id']=$responce['course_id']=$course_id;	
		$temp['order_id']=$responce['order_id']=$order_id;	
		$Responce=$this->mdl_test->GetTestResponce($temp);
		$TestInfo=$this->mdl_test->getTestInfo($Responce['test_id']);						
		$responce['test_attampt']=$test_attampt=$Responce['test_attampt'];	
		$TestQuestionInfo=$this->mdl_test->GetTestView($TestInfo['test_id'],$test_attampt,$cust_id,$course_id,$order_id);
		$responce['test_id']		=	$TestInfo['test_id'];				
		$responce['no_of_question']	=	count($TestQuestionInfo);
		$responce['current_responce']=	'Running';
		$responce['current_page_no']=	$Responce['current_page_no'];
		$responce['test_date']=date('Y-m-d H:i:s',time());				

		$data='';
		$old_responce=$this->mdl_test->GetOldTestResponce($responce);	
		
		if($old_responce['responce_status'] == 'Passed')
			$data['is_passed']=true;
		else if($old_responce['responce_status'] == 'Failed' && $old_responce['test_attampt']>=3)
			$data['is_failed']=true;
		else
		{
			$this->mdl_test->UpdateTestStatus($responce,'Running');		
			$msg="Resume Test of".$TestInfo['test_name'];	
			$this->mdl_course->AddActivity($msg);		
		}				
		
		$CourseInfo=$this->mdl_course->get_courseInfoByid($course_id);
		if($CourseInfo['course_reenrolment'] == 'Yes')
			$data['reenrollflag']=true;
										
		$header['page_title']=$TestInfo['test_name'];
		$data['TestInfo']=$TestInfo;
		$data['TestQuestionInfo']=$TestQuestionInfo;
		$data['test_attampt']=$test_attampt;
		$data['course_id']=$course_id;
		$data['order_id']=$order_id;
		$data['cust_id']=$cust_id;
		$data['Responce']=$Responce;
						
		$this->load->view('header',$header);
		$this->load->view('test/resume',$data);
		$this->load->view('footer',$footer);
	}
	
	function saveTestResponceDetail()
	{
		$question_id=$_REQUEST['question_id'];
		$selected_option=$_REQUEST['selected_option'];			
		$responceDetail['cust_id']		=	$_REQUEST['cust_id'];			
		$responceDetail['course_id']	=	$_REQUEST['course_id'];		
		$responceDetail['test_id']		=	$_REQUEST['test_id'];	
		$responceDetail['order_id']		=	$_REQUEST['order_id'];	
		$responceDetail['test_attampt']	=	$_REQUEST['test_attampt'];
		$responceDetail['question_id']	=	$question_id;
		$responceDetail['responce']		=	$selected_option;
		$selectedOption=$_REQUEST['selected'][0];
		$rightOption=$_REQUEST['rightoption'];	
		if($selected_option == $rightOption)
			$responceDetail['is_correct']='right';
		else
		{
			if($selected_option > 0)
				$responceDetail['is_correct']='wrong';						
			else
				$responceDetail['is_correct']='skip';						
		}
		echo $this->mdl_test->saveTestResponceDetail($responceDetail);// Insert/update data for current timestamp
	}
	
	function StopTest()
	{		
		$data['cust_id']=$_REQUEST['cust_id'];
		$data['course_id']=$_REQUEST['course_id'];
		$data['test_id']=$_REQUEST['test_id'];
		$data['order_id']=$_REQUEST['order_id'];
		$data['test_attampt']=$_REQUEST['test_attampt'];
		$data['current_page_no']=$_REQUEST['cur_position'];
		$data['test_date']=date('Y-m-d H:i:s',time());		
		$flag=$this->mdl_test->UpdateTestStatus($data);					
		$TestInfo=$this->mdl_test->getTestInfo($_REQUEST['test_id']);
		if($flag)
		{
			$msg="Test Paused ".$TestInfo['test_name'];	
			$this->mdl_course->AddActivity($msg);
			echo true;
		}
		else
			echo false;
	}

	function CompleteTest()
	{		
		$data['cust_id']=$_REQUEST['cust_id'];
		$data['course_id']=$_REQUEST['course_id'];
		$data['test_id']=$_REQUEST['test_id'];
		$data['order_id']=$_REQUEST['order_id'];
		$data['test_attampt']=$_REQUEST['test_attampt'];
		$data['current_page_no']='0';		
		$data['test_date']=date('Y-m-d H:i:s',time());				
		
		$Rightans=$this->mdl_test->GetCorrectAns($data,true);
		$Totalans=$this->mdl_test->GetTestView($data['test_id'],$data['test_attampt'],$data['cust_id'],$data['course_id'],$data['order_id']);
		$Totalans=count($Totalans);
		$MinAnsToPass=($Totalans*80)/100;
		if($MinAnsToPass <= $Rightans)
			$responce_status='Passed';
		else
			$responce_status='Failed';
			
		$flag=$this->mdl_test->UpdateTestStatus($data,'Completed',$responce_status);		
		$TestInfo=$this->mdl_test->getTestInfo($data['test_id']);
		$returnflag=array();
		if($flag)
		{
			$msg="Completed Test ".$TestInfo['test_name'];	
			$this->mdl_course->AddActivity($msg);
			if($responce_status=='Passed')
				$returnflag[]='Passed';
			else
			{
				$returnflag[0]='Failed';				
				if($data['test_attampt'] == 1)
				{
					$Questions=$this->mdl_test->GetWrongAns($data);
					if($Questions->num_rows() > 0)
					{
						$counter=1;
						$QuestionInfo=$Questions->result_array();
						$TestQuestionInfo=$this->mdl_test->GetTestView($data['test_id'],$data['test_attampt'],$data['cust_id'],$data['course_id'],$data['order_id']);
						foreach($QuestionInfo as $key=>$val)
						{
							$QuestionsIds[]=$val['question_id'];
						}
						foreach($TestQuestionInfo as $key=>$val)
						{
							if(in_array($val['question_id'],$QuestionsIds))
								$falseans[]=$counter;								
							$counter++;								
						}
					}
					$returnflag[1]=implode(',',$falseans);
				}
			}
			
		}
		else
			$returnflag[]=false;

		echo json_encode($returnflag);	
	}
	
	function showchits()
	{				
		$data['cust_id']=$_REQUEST['cust_id'];
		$data['course_id']=$_REQUEST['course_id'];
		$data['test_id']=$_REQUEST['test_id'];
		$data['order_id']=$_REQUEST['order_id'];
		$data['test_attampt']=$_REQUEST['test_attampt'];
		if(isset($data['cust_id']) && isset($data['course_id']) && isset($data['test_id']) && isset($data['order_id']) && isset($data['test_attampt']) && isset($data['test_attampt']))
		{				
			$AllQuestionInfo=$this->mdl_test->GetTestView($data['test_id'],$data['test_attampt'],$data['cust_id'],$data['course_id'],$data['order_id']);				
			$QuestionsInfo=$this->mdl_test->GetWrongAns($data)->result_array();		
			foreach($QuestionsInfo as $key=>$val)
			{
				$QuestionsIds[]=$val['question_id'];
			}
			foreach($AllQuestionInfo as $key=>$val)
			{
				if(in_array($val['question_id'],$QuestionsIds))
					$TestQuestionInfo[]=$val;
			}
			
			$header['page_title']=$TestInfo['test_name'];
			$data['TestInfo']=$TestInfo;
			$data['TestQuestionInfo']=$TestQuestionInfo;
			$data['test_attampt']=$test_attampt;
			$data['course_id']=$course_id;
			$data['cust_id']=$cust_id;
			$data['order_id']=$order_id;
	
			$this->load->view('header',$header);
			$this->load->view('test/chits',$data);
			$this->load->view('footer',$footer);
		}
		else
			redirect('dashboard');
	}		
	
	function submitreview($course_id='',$current_page_url='')
	{
		$this->form_validation->set_rules('comment_description','Review','required|trim');
		if($this->form_validation->run() == FALSE)
		{
			$data['course_id']=$course_id;
			$this->load->view('test/reportproblem',$data);						
		}
		else
		{
			$current_page_url=str_replace('++','/',$current_page_url);
			$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();		
			$CourseInfo=$this->mdl_course->get_courseInfoByid($course_id);	
			$udata['msg']=$_POST['comment_description'];		
			$udata['user_name']=$UserInfo['cust_fname'].' '.$UserInfo['cust_lname'];
			$udata['user_email']=$UserInfo['cust_email'];
			$udata['current_page_url']=site_url($current_page_url);
			$udata['course_name']=$CourseInfo['course_name'];
			$this->ReportMailContent($udata);
			echo '<script language="javascript">window.parent.CloseReview();</script>';
		}		
	}
	
	function ReportMailContent($data)
	{		
		$subject = "Reporting issue";						
		$body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Reset Password</title>
				</head>
				
				<body>
				<div style=" width:596px; border:2px solid #131516; margin:auto;" >
				<table width="596" border="0" cellspacing="0" cellpadding="0" bordercolor="#131516" align="center">
				  <tr>
					<td width="596" style="margin:0px; padding:0px;"></td>
				  </tr>
				  <tr>
					 <td width="596" height="45" style="background:#2d3032; margin:0px; padding:0px; border-bottom:2px solid #131516; border-top:2px solid #131516; padding-left:18px; font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#FFF; font-weight:bold;"><span style="color:#00a4e8;">R</span>eporing about PDR</td>
				  </tr>
				  
				  <tr>
					<td width="596" bgcolor="#2d3032">					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					<td style="margin:0px; padding:5px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold;" >Hello Administrator,</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#9c9b9b;" > Following information is got for the reporting issue</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 8px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left:19px;">:</span> <span style="margin-left:10px;">'.$data['user_name'].'</span></td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 8px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Email Add &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left:19px;">:</span> <span style="margin-left:10px;">'.$data['user_email'].'</span></td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Course Name	<span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.$data['course_name'].'</span></td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Message	<span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.$data['msg'].'</span></td>
					</tr>
					<tr>
						<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Location: <span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.$data['current_page_url'].'</span></td>
					</tr>
					<tr>
						<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Report time: <span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.date('Y-m-d h:i:s',time()).'</span></td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 10px 20px; font-size:14px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Thank You,</td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#00b7ff;" ><a style="color:#00b7ff;" href="'.site_url().'">PDR</a><br /><br/><br/></td>
					</tr>
					<tr>
					</table>					
					</td>
				  </tr>
				</table>
				</div>
				</body>
				</html>';			
				//$toEmail=$this->mdl_constants->AdminMail();			
		$this->mdl_common->sendMail1('brijesh.donda@artoonsolutions.com',$subject,$body);  //send report mail
		//$this->mdl_common->sendMail($toEmail,$subject,$body);  //send report mail
		return true;
	}
	
	function evaluation($course_id='',$order_id='')
	{				
		if($course_id <=0)
			redirect('home');
		$EvaluationInfo=$this->mdl_evaluation->get_evaluation($course_id);

		if(!is_array($EvaluationInfo))
			redirect('home');
			
		$cust_id=$responce['cust_id']=$this->session->userdata('cust_id');		
		$EvaluationQuestionInfo=$this->mdl_evaluation->GetEvaluationView($EvaluationInfo['evaluation_id'],$cust_id,$course_id);

		$responce['course_id']		=	$course_id;		
		$responce['order_id']		=	$order_id;				
		$responce['evaluation_id']		=	$EvaluationInfo['evaluation_id'];		
		$responce['no_of_question']	=	count($EvaluationQuestionInfo);
		$responce['evaluation_date']=date('Y-m-d H:i:s',time());		
		$old_responce=$this->mdl_evaluation->IsOldEvaluationResponce($responce);		

		if(is_array($old_responce) && $old_responce)
		{
			$data['is_completed_evalutions']=true;
		}
		else
		{
			$responce['current_responce']='Running';
			$evaluation_attampt=$this->mdl_evaluation->SaveEvaluationResponce($responce);	
			$msg="Started Evaluation of".$EvaluationInfo['evaluation_name'];	
			$this->mdl_course->AddActivity($msg);			
		}

		
		$header['page_title']=$EvaluationInfo['evaluation_name'];
		$data['EvaluationInfo']=$EvaluationInfo;
		$data['EvaluationQuestionInfo']=$EvaluationQuestionInfo;
		$data['evaluation_attampt']=$evaluation_attampt;
		$data['course_id']=$course_id;
		$data['cust_id']=$cust_id;
		$data['order_id']=$order_id;

		$this->load->view('header',$header);
		$this->load->view('test/evaluation',$data);
		$this->load->view('footer',$footer);	
	}
	
	function saveEvaluationResponceDetail()
	{
		$question_id=$_REQUEST['question_id'];
		$selected_option=$_REQUEST['selected_option'];			
		$responceDetail['cust_id']		=	$_REQUEST['cust_id'];			
		$responceDetail['course_id']	=	$_REQUEST['course_id'];		
		$responceDetail['evaluation_id']=	$_REQUEST['evaluation_id'];	
		$responceDetail['order_id']		=	$_REQUEST['order_id'];	
		$responceDetail['evaluation_attampt']	=	$_REQUEST['evaluation_attampt'];
		$responceDetail['question_id']	=	$question_id;
		$responceDetail['responce']		=	$selected_option;
		$selectedOption=$_REQUEST['selected'][0];
		$rightOption=$_REQUEST['rightoption'];	
		if($selected_option == $rightOption)
			$responceDetail['is_correct']='right';
		else
		{
			if($selected_option > 0)
				$responceDetail['is_correct']='wrong';						
			else
				$responceDetail['is_correct']='skip';						
		}

		echo $this->mdl_evaluation->SaveEvaluationResponceDetail($responceDetail);// Insert/update data for current timestamp
	}
	
	function CompleteEvaluation()
	{		
		$data['cust_id']=$_REQUEST['cust_id'];
		$data['course_id']=$_REQUEST['course_id'];
		$data['evaluation_id']=$_REQUEST['evaluation_id'];
		$data['order_id']=$_REQUEST['order_id'];
		$data['test_date']=date('Y-m-d H:i:s',time());						
		$responce_status='Passed';		
		$flag=$this->mdl_evaluation->UpdateEvaluationStatus($data,'Completed',$responce_status);				
		echo json_encode($flag);	
	}
		
	/*function index($course_id='',$test_id='',$offset=0,$test_attampt='')
	{
		//$course_id=6;
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
	}*/
}
?>