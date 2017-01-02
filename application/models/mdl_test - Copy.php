<?php
class mdl_test extends CI_Model
{
	function get_test($test_course_id ='')
	{
		$sql = "select * from pdr_test_master where is_deleted ='N' and is_active='Y' and test_course_id=".$test_course_id;
		$res= $this->db->query($sql);
		return $res->row_array();
	}
	
	function getTestInfo($test_id ='')
	{
		$sql = "select * from pdr_test_master where test_id=".$test_id;
		$res= $this->db->query($sql);
		return $res->row_array();
	}
	
	function GetTestView($test_id,$test_attampt='',$cust_id='',$course_id='')
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
					$sql3="select responce from pdr_customer_test_response_detail where test_attampt=".$test_attampt." and cust_id=".$cust_id." and question_id=".$val['question_id']." and course_id=".$course_id;
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
		$this->db->not_like('current_responce','Running');
		$res=$this->db->get('pdr_customer_test_response');
		$data['test_attampt']=$res->num_rows+1;		
		$this->db->insert('pdr_customer_test_response',$data);
		return $data['test_attampt'];	
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
	
	function UpdateTestStatus($data,$status='Stop')
	{
		$update['current_responce']=$status;
		$update['current_page_no']=$data['current_page_no'];
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		$this->db->update('pdr_customer_test_response',$update);				
		return true;		
	}
	
	function GetTestResponce($data)
	{
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('cust_id',$data['cust_id']);		
		$res=$this->db->get('pdr_customer_test_response');
		return $res->row_array();
	}
}







/*class mdl_test extends CI_Model
{
	function get_test($test_course_id ='')
	{
		$sql = "select * from pdr_test_master where is_deleted ='N' and is_active='Y' and test_course_id=".$test_course_id;
		return $this->db->query($sql);
	}
	function get_Question($test_id ='',$offset='')
	{
		if($offset >0)
			$param='Limit '.$offset.' ,1';		
		$sql = "select * from pdr_question_master where is_deleted ='N' and is_active='Y' and question_test_id=".$test_id ." order by question_order ".$param;
		return $this->db->query($sql);
	}
	function get_AllTotal($test_id ='')
	{
		$sql = "select * from pdr_question_master where is_deleted ='N' and is_active='Y' and question_test_id=".$test_id;
		return $this->db->query($sql);
	}
	function get_Option($question_id ='')
	{
		$sql = "select * from pdr_option_master where is_deleted ='N' and is_active='Y' and option_question_id=".$question_id." order by option_order";
		return $this->db->query($sql);
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
	function GenrateResult($data)
	{
		$update['current_responce']='Completed';
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		$this->db->update('pdr_customer_test_response',$update);	
				
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		$final_res=$this->db->get('pdr_customer_test_response_detail');
		return $final_res->result_array();	
	}
	function StopTest($data)
	{
		$update['current_responce']='Stop';
		$update['current_page_no']=$data['current_page_no'];
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		$this->db->update('pdr_customer_test_response',$update);		
		return true;		
	}
	function PendingTest($cust_id)
	{
		$this->db->where('cust_id',$cust_id);
		$this->db->like('current_responce','Stop');
		$this->db->join('pdr_test_master', 'pdr_test_master.test_id = pdr_customer_test_response.test_id', 'left');
		$res=$this->db->get('pdr_customer_test_response');			
		//echo $this->db->last_query();die;			
		return $res->result_array();	
	}
	function UpdateStatus($data)
	{
		$update['current_responce']='Running';		
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		$this->db->update('pdr_customer_test_response',$update);		
		return true;		
	}
	function GetAllContent($data)
	{
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('test_id',$data['test_id']);		
		$this->db->where('test_attampt',$data['test_attampt']);				
		$final_res=$this->db->get('pdr_customer_test_response_detail');
		return $final_res->result_array();	
	}
}*/