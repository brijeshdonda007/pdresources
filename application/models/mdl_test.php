<?php
class mdl_test extends CI_Model
{
	function get_test($test_course_id ='')
	{
		$sql = "select PT.* from pdr_test_master as PT left join pdr_course_master on course_test=test_id where PT.is_deleted ='N' and PT.is_active='Y' and course_id=".$test_course_id;
		$res= $this->db->query($sql);
		return $res->row_array();
	}
	
	function getTestInfo($test_id ='')
	{
		$sql = "select * from pdr_test_master where test_id=".$test_id;
		$res= $this->db->query($sql);
		return $res->row_array();
	}
	
	function GetTestView($test_id,$test_attampt='',$cust_id='',$course_id='',$order_id='')
	{
		$sql="select * from pdr_question_master where is_active ='Y' and is_deleted='N' and question_test_id=".$test_id." order by question_order";
		$res=$this->db->query($sql);
		$data=$res->result_array();

		if(is_array($data) && $data)
		{
			foreach($data as $key=>$val)
			{
				$res2='';
				$sql2="select * from pdr_option_master where is_active='Y' and is_deleted='N' and option_question_id=".$val['question_id']." order by option_order";
				$res2=$this->db->query($sql2);
				$data[$key]['options']=$res2->result_array();
				if($test_attampt > 0 && $cust_id && $course_id)
				{
					$sql3="select responce from pdr_customer_test_response_detail where test_attampt=".$test_attampt." and cust_id=".$cust_id." and question_id=".$val['question_id']." and course_id=".$course_id." and order_id=".$order_id;
					$res3=$this->db->query($sql3);
					if($res3->num_rows>0)
					{
						$temp=$res3->row_array();
						$data[$key]['responce']=$temp['responce'];
					}
				}
			}
			return $data;
		}
		else
			return false;
	}
	
	function SaveTestResponce($data)
	{		
		$this->db->like('current_responce','Running');
		$this->db->or_like('current_responce','Stop');		
		$this->db->where('course_id',$data['course_id']);
		$this->db->where('order_id',$data['order_id']);
		$this->db->where('test_id',$data['test_id']);		
		$res=$this->db->get('pdr_customer_test_response');		
		$temp=$res->row_array();
		if($res->num_rows > 0)
			return $temp['test_attampt'];
		else
		{
			$this->db->not_like('current_responce','Running');
			$this->db->or_not_like('current_responce','Stop');		
			$this->db->where('course_id',$data['course_id']);
			$this->db->where('order_id',$data['order_id']);
			$this->db->where('test_id',$data['test_id']);				
			$res=$this->db->get('pdr_customer_test_response');
			$data['test_attampt']=$res->num_rows+1;		
			$this->db->insert('pdr_customer_test_response',$data);
			return $data['test_attampt'];	
		}
	}

	function GetOldTestResponce($data)
	{		
		$this->db->like('current_responce','Completed');
		$this->db->where('course_id',$data['course_id']);
		$this->db->where('order_id',$data['order_id']);
		$this->db->where('test_id',$data['test_id']);		
		$this->db->order_by('test_attampt','desc');
		$res=$this->db->get('pdr_customer_test_response');				
		$temp=$res->row_array();
		if($res->num_rows > 0)
			return $temp;
		else
			return false;
	}
	
	function saveTestResponceDetail($data)
	{
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('question_id',$data['question_id']);
		$this->db->where('test_attampt',$data['test_attampt']);				
		$res=$this->db->get('pdr_customer_test_response_detail');
		if($res->num_rows > 0)
		{
			$update['responce']=$data['responce'];
			$update['is_correct']=$data['is_correct'];
			$this->db->where('cust_id',$data['cust_id']);
			$this->db->where('course_id',$data['course_id']);		
			$this->db->where('test_id',$data['test_id']);		
			$this->db->where('question_id',$data['question_id']);
			$this->db->where('test_attampt',$data['test_attampt']);				
			$this->db->update('pdr_customer_test_response_detail',$update);	
		}
		else
		{
			$this->db->insert('pdr_customer_test_response_detail',$data);
		}
		return true;
	}
	
	function UpdateTestStatus($data,$status='Stop',$responce_status='')
	{
		if($responce_status)
			$update['responce_status']=$responce_status;	
		$update['current_responce']=$status;
		$update['current_page_no']=$data['current_page_no'];
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('order_id',$data['order_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		$this->db->update('pdr_customer_test_response',$update);				
		return true;		
	}
	
	function GetCorrectAns($data,$flag='')
	{
		$this->db->where('cust_id',$data['cust_id']);	
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('order_id',$data['order_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		if($flag)
			$this->db->where('is_correct','right');				
		$res=$this->db->get('pdr_customer_test_response_detail');				
		return $res->num_rows();		
	}
	
	function GetWrongAns($data)
	{
		$this->db->where('cust_id',$data['cust_id']);	
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('order_id',$data['order_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		$this->db->where('is_correct','wrong');				
		$res=$this->db->get('pdr_customer_test_response_detail');				
		return $res;		
	}
	
	function GetTestResponce($data)
	{
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('cust_id',$data['cust_id']);		
		$this->db->where('order_id',$data['order_id']);
		if($data['check_status_flag'])
		{
			$this->db->not_like('current_responce','Completed');
			$this->db->not_like('current_responce','Failed');
		}
		$this->db->order_by('test_attampt','desc'); 
		$res=$this->db->get('pdr_customer_test_response');
		//echo $this->db->last_query();
		return $res->row_array();
	}
	
	function GetRightAnsCount($data)
	{
		$this->db->where('is_correct','right');								
		$this->db->where('test_attampt',$data['test_attampt']);						
		$this->db->where('test_id',$data['test_id']);
		$this->db->where('course_id',$data['course_id']);
		$this->db->where('order_id',$data['order_id']);
		$this->db->where('cust_id',$data['cust_id']);		
		$res=$this->db->get('pdr_customer_test_response_detail');
		return $res->num_rows();
	}
	
	function GetPassedTestResponce($data)
	{		
		$this->db->like('current_responce','Completed');
		$this->db->like('responce_status','Passed');
		$this->db->where('course_id',$data['course_id']);
		$this->db->where('order_id',$data['order_id']);
		$this->db->where('cust_id',$data['cust_id']);		
		$this->db->order_by('test_attampt','desc');
		$res=$this->db->get('pdr_customer_test_response');				
		$temp=$res->row_array();
		if($res->num_rows > 0)
			return $temp;
		else
			return false;
	}
}