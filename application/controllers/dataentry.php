<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Dataentry extends CI_Controller
{
	function Dataentry()
	{		
		parent::__construct();
		$this->load->model('mdl_test');
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_employee');
	}	
	
	function CourseEntry()
	{
		$sql="select * from temp_coursemaster";
		$res=$this->db->query($sql);
		$result=$res->result_array();
		foreach($result as $key=>$val)
		{
			$udata['course_id']=$val['CourseID']?$val['CourseID']:NULL;
			$udata['course_name']=$val['CourseName']?$val['CourseName']:NULL;
			$udata['course_is_new']=$val['IsNewCourse']?'Yes':'No';
			$udata['course_is_best_seller']=$val['IsBestSellers']?'Yes':'No';
			$udata['course_is_sell']=$val['IsSaleCourse']?'Yes':'No';
			$udata['course_is_closeout']=$val['IsCloseoutCourse']?'Yes':'No';
			$udata['course_is_ethics']=$val['IsEthics']?'Yes':'No';
			$udata['course_is_medical_error']=$val['IsMedicalErrors']?'Yes':'No';
			$udata['course_image']=$val['CourseImage']?'uploads/course/'.$val['CourseImage']:NULL;
			$udata['course_ce_hours']=$val['CEHours']?$val['CEHours']:NULL;
			$udata['course_learning_level']=$val['Level']?$val['Level']:NULL;
			$temp=explode('-',$val['CourseExpiryDate']);
			if($temp[0]<2038)
				$udata['course_expiry_date']=$val['CourseExpiryDate'];						
			else
				$udata['course_expiry_date']='2038-01-01 00:00:00';						
			$udata['course_online_price']=$val['OnlineRegularPrice'];
			$udata['course_sale_price']=$val['OnlineSalePrice'];
//			$udata['course_expiry_date']=date('Y-m-d h:s:i',strtotime($val['CourseExpiryDate']));			
			$udata['course_pdf_content']=$val['OnlineContent']?'uploads/course/'.$val['OnlineContent']:NULL;
			$udata['course_desc']=$val['CourseAbstract']?$val['CourseAbstract']:NULL;
			$udata['course_search_on_line']=$val['SearchOnline']?'Yes':'No';
			$udata['course_learning_objective']=$val['LearningObjectives']?$val['LearningObjectives']:NULL;									
			//$udata['course_author']=$this->GetAuthours($val['Author'],$val['AboutAuthor']);			
			$udata['course_timestamp']=date('Y-m-d h:s:i',strtotime($val['crt_ts']));			
			$udata['course_main_course_id']=$val['MainCourseID']?$val['MainCourseID']:NULL;
			$udata['course_test']=$val['CourseID']?$val['CourseID']:NULL;	
			$udata['course_is_active']='Y';	
			
			echo '<pre>';
print_r($val);
echo '</pre>';			
			//$this->db->insert('pdr_course_master',$udata);
		}
	}
	
	function TestCreation()
	{
		$sql="select * from temp_coursemaster";
		$res=$this->db->query($sql);
		$result=$res->result_array();
		foreach($result as $key=>$val)
		{
			$idata['test_id']=$val['CourseID'];
			$idata['test_name']=$val['CourseName'];
			$this->db->insert('tmp_test_master',$idata);
		}
	}
	
	function Customerentry()
	{
		$sql="select * from pdr_customer_detail limit 0,10000";
		$res=$this->db->query($sql);
		$result=$res->result_array();
		foreach($result as $key=>$val)
		{
			echo '<pre>';
print_r($val);
echo '</pre>';die;
		}
	}
	
	/*function GetAuthours($title,$description)
	{
		$this->db->where('author_title');
	}*/
}
?>