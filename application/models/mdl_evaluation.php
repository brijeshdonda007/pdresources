<?php
class mdl_evaluation extends CI_Model
{
	function get_evaluation($course_id ='')
	{
		$sql = "select EV.* from pdr_evaluation_master as EV left join pdr_course_master on course_evaluation=evaluation_id where EV.is_deleted ='N' and EV.is_active='Y' and course_id=".$course_id;
		$res= $this->db->query($sql);
		return $res->row_array();
	}
	
	function GetEvaluationView($evaluation_id,$cust_id='',$course_id='',$order_id='')
	{
		$sql="select * from pdr_evaluation_question_master where is_active ='Y' and is_deleted='N' and question_evaluation_id=".$evaluation_id." order by question_order";
		$res=$this->db->query($sql);
		$data=$res->result_array();
		
		if(is_array($data) && $data)
		{
			foreach($data as $key=>$val)
			{
				$res2='';
				$sql2="select * from pdr_evaluation_option_master where is_active='Y' and is_deleted='N' and option_question_id=".$val['question_id']." order by option_order";
				$res2=$this->db->query($sql2);
				$data[$key]['options']=$res2->result_array();				
			}
			return $data;
		}
		else
			return false;
	}
	
	function SaveEvaluationResponce($data)
	{		
		$this->db->like('current_responce','Running');
		$this->db->or_like('current_responce','Stop');		
		$this->db->where('course_id',$data['course_id']);
		$this->db->where('order_id',$data['order_id']);
		$this->db->where('evaluation_id',$data['evaluation_id']);		
		$res=$this->db->get('pdr_customer_evaluation_response');		
		$temp=$res->row_array();
		if($res->num_rows > 0)
			return $temp['evaluation_attampt'];
		else
		{
			$this->db->not_like('current_responce','Running');
			$this->db->or_not_like('current_responce','Stop');		
			$this->db->where('course_id',$data['course_id']);
			$this->db->where('order_id',$data['order_id']);
			$this->db->where('evaluation_id',$data['evaluation_id']);				
			$res=$this->db->get('pdr_customer_evaluation_response');
			$data['evaluation_attampt']=$res->num_rows+1;		
			$this->db->insert('pdr_customer_evaluation_response',$data);
			return $data['evaluation_attampt'];	
		}
	}

	function RemoveOldEvaluationResponce($data)
	{
		$udata['status']='trash';		
		$this->db->like('current_responce','Completed');
		$this->db->where('course_id',$data['course_id']);
		$this->db->where('order_id',$data['order_id']);
		$this->db->where('evaluation_id',$data['evaluation_id']);		
		$this->db->where('cust_id',$data['cust_id']);				
		$res=$this->db->update('pdr_customer_evaluation_response',$udata);						
	}
	
	function IsOldEvaluationResponce($data)
	{		
		$this->db->like('current_responce','Completed');
		$this->db->where('course_id',$data['course_id']);
		$this->db->where('order_id',$data['order_id']);
		$this->db->where('evaluation_id',$data['evaluation_id']);		
		$this->db->where('cust_id',$data['cust_id']);				
		$res=$this->db->get('pdr_customer_evaluation_response');						
		return $res->row_array();
	}
	
	function SaveEvaluationResponceDetail($data)
	{
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('evaluation_id',$data['evaluation_id']);		
		$this->db->where('question_id',$data['question_id']);
		$this->db->where('evaluation_attampt',$data['evaluation_attampt']);				
		$res=$this->db->get('pdr_customer_evaluation_response_detail');
		if($res->num_rows > 0)
		{
			$update['responce']=$data['responce'];
			$update['is_correct']=$data['is_correct'];
			$this->db->where('cust_id',$data['cust_id']);
			$this->db->where('course_id',$data['course_id']);		
			$this->db->where('evaluation_id',$data['evaluation_id']);		
			$this->db->where('question_id',$data['question_id']);
			$this->db->where('evaluation_attampt',$data['evaluation_attampt']);				
			$this->db->update('pdr_customer_evaluation_response_detail',$update);	
		}
		else
		{
			$this->db->insert('pdr_customer_evaluation_response_detail',$data);
		}
		return true;
	}		
	
	function UpdateEvaluationStatus($data,$status='Stop',$responce_status='')
	{
		$update['responce_status']=$responce_status;	
		$update['current_responce']=$status;	
		$update['evaluation_passing_date']=date('Y-m-d');
		$this->db->where('cust_id',$data['cust_id']);
		$this->db->where('course_id',$data['course_id']);		
		$this->db->where('evaluation_id',$data['evaluation_id']);		
		$this->db->where('order_id',$data['order_id']);					
		$this->db->update('pdr_customer_evaluation_response',$update);				
		echo $this->db->last_query();
		return true;		
	}
}