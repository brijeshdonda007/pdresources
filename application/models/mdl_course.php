<?php
class mdl_course extends CI_Model
{
	function get_courseInfoByid($id='')
	{
		$this->db->where('course_id',$id);	
		$this->db->where('course_is_active','Y');	
		$this->db->where('is_deleted','N');			
		$res = $this->db->get('pdr_course_master');	
		return $res->row_array();
	}
		
	function get_courseByProfId($id='')
	{
		$this->db->where('pdr_course_master.course_pro_prof_id',$id);	
		$this->db->where('UNIX_TIMESTAMP(course_expiry_date)>=',time());					
		$this->db->join('pdr_course_profession_master', 'pdr_course_master.course_id = pdr_course_profession_master.course_pro_course_id', 'left');
		$res = $this->db->get('course_master');
		return $res->result_array();
	}
		
	function getNewArrival()
	{
		$this->db->where('is_deleted','N');
		$this->db->where('course_is_new','Yes');			
		$this->db->where('course_is_active','Y');					
		$this->db->where('UNIX_TIMESTAMP(course_expiry_date)>=',time());					
		$this->db->order_by("course_timestamp", "desc"); 
		$this->db->limit(15);
		$res=$this->db->get('pdr_course_master');
		//echo $this->db->last_query();
		return $res->result_array();
	}		
	
	function GetCourseInfos($ids,$order_by='',$is_all='')
	{

		if($order_by =='popular')
			$sql='select *,(select IFNULL(avg(comment_rate),0) as rating from pdr_user_comments where comment_course_id=course_id and comment_approved like "publish") as rating from pdr_course_master where course_is_active like "Y" and UNIX_TIMESTAMP(course_expiry_date)>='.time().' and course_id in('.$ids.') order by rating desc ';
		else
		{
			$sql='select * from pdr_course_master where course_is_active like "Y" and UNIX_TIMESTAMP(course_expiry_date)>='.time().' and course_id in('.$ids.') '.$param.'order by course_is_new desc';
		}
		if(!$is_all)
			$sql .=" LIMIT 0,15";
		$res=$this->db->query($sql);		
		if($is_all)
			return $res;
		else
			return $res->result_array();
	}
	
	function getcourseCommentCount($course_id)
	{
		$this->db->where('comment_course_id',$course_id);
		$this->db->where('comment_approved','publish');		
		$this->db->from('pdr_user_comments');
		return $this->db->count_all_results();
	}
	
	function GetCourseComments($course_id)
	{
		$sql="select uc.*,ud.cust_fname,ud.cust_lname,ud.cust_avatar from pdr_user_comments as uc left join pdr_customer_detail as ud on ud.cust_id =uc.comment_user_id where comment_approved like 'publish' and comment_course_id=$course_id order by uc.comment_date";
		$res=$this->db->query($sql);
		return $res->result_array();
	}
	
	function AddActivity($desc='')
	{
		$data['activity_uid']=$this->session->userdata('cust_id');
		$data['activity_desc']=$desc;
		$this->db->insert('pdr_user_activity',$data);
		return true;
	}
	
	function GetAllOldCourse($flag=NULL)
	{
		$uid=$this->session->userdata['cust_id'];
		$sql="select ocd_course_id as course_id,order_id from pdr_order_details right join pdr_order_course_detail on ocd_order_id=order_id where order_status like 'Completed' and order_visibility='publish' and order_cust_id=".$uid." order by order_date desc";
		$res=$this->db->query($sql);
		$data=$res->result_array($sql);
		$returnarr=$$returnarr2='';
		foreach($data as $key=>$val)
		{
			$temp['course_id']=$val['course_id'];
			$temp['cust_id']=$uid;
			$temp['order_id']=$val['order_id'];
			$temp['check_status_flag']=true;
			$Responce=$this->mdl_test->GetTestResponce($temp);
			if(is_array($Responce) && $Responce)
				$returnarr[]=$val['course_id'];
			$returnarr2[]=$val['course_id'];
		}
		if($returnarr2 && $flag)
			return $returnarr2;
		else if($returnarr && !$flag)
			return $returnarr;
		else
			return false; //and UNIX_TIMESTAMP(course_expiry_date)>=".time()." 		
	}
}
