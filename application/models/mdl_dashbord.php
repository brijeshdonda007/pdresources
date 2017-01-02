<?php
class mdl_dashbord extends CI_Model
{
	function GetRecentActivity()
	{
		$this->db->where('activity_uid',$this->session->userdata['cust_id']);
		$this->db->order_by('activity_timestamp','desc');
		//$this->db->limit(3);
		$res=$this->db->get('pdr_user_activity');
		return $res->result_array();
	}
	
	function GetLoggedUserInfo($uid='')
	{
		if(!$uid)
			$uid=$this->session->userdata('cust_id');
		
		$this->db->where('cust_id',$uid);		
		$res=$this->db->get('pdr_customer_detail');
		
		$row = $res->row_array();
		$row['cust_city_name'] = $this->mdl_common->getField('city_name', 'pdr_city_master', 'city_id', $row['cust_city']);
		$row['cust_state_name'] = $this->mdl_common->getField('state_name', 'pdr_state_master', 'state_id', $row['cust_state']);
		$row['cust_zip_code'] = $this->mdl_common->getField('zipcode_name', 'pdr_zipcode_master', 'zipcode_id', $row['cust_zip']);
			
		return $row;
	}
	
	function chaangedateformat($data)
	{
		$date=strtotime($data);
		$Today=date('d',time());
		$activity_date=date('d',$date);

		if($Today == $activity_date)
		{
			$disp_date='Today, '.date('g:i a',$date);
		}
		else
			$disp_date=date('F d, Y, g:i a',$date);			
			
		return $disp_date;
	}
	
	function GetUserCorseInfo($flag='')
	{		
		$uid=$this->session->userdata['cust_id'];
		$sql="select ocd_course_id as course_id,ocd_id as detail_id,order_id,order_date from pdr_order_details right join pdr_order_course_detail on ocd_order_id=order_id where order_status like 'Completed' and order_visibility='publish' and order_cust_id=".$uid." order by order_date desc";
		$res=$this->db->query($sql);
		$data=$res->result_array($sql);
		$returnarr='';
		foreach($data as $key=>$val)
		{
			$TempCourse='';
			$sql2="select *
							,(select max(ctr.test_attampt) from pdr_customer_test_response as ctr where cust_id=".$uid." and order_id=".$val['order_id']." and ctr.course_id=course_id and (current_responce like 'Completed')) as no_of_attempt 
							,(select responce_status from pdr_customer_test_response as ctr where cust_id=".$uid." and order_id=".$val['order_id']." and ctr.course_id=course_id and (current_responce like 'Completed') order by test_attampt desc limit 0,1) as responce_status
							from pdr_course_master where is_deleted='N' and course_is_active='Y' and UNIX_TIMESTAMP(course_expiry_date)>=".time()." and course_id=".$val['course_id'];
			$sql2 .=$param;
			$res2=$this->db->query($sql2);
			$TempCourse=$res2->row_array();
			if($TempCourse)
			{
				$temp['course_id']=$val['course_id'];
				$temp['cust_id']=$uid;
				$temp['order_id']=$val['order_id'];
				$Responce=$this->mdl_test->GetTestResponce($temp);				
				$TempCourse['detail_id']=$val['detail_id'];
				$TempCourse['cur_responce']=$Responce;
				$TempCourse['order_id']=$val['order_id'];
				$TempCourse['order_date']=$val['order_date'];	
				if($flag)
				{
					if($Responce['responce_status'] == 'Passed' || $Responce['responce_status'] == 'Failed')
						$returnarr[]=$TempCourse;							
				}
				else
				{
					if(($Responce['responce_status'] != 'Passed' || $Responce['responce_status'] != 'Failed') && $TempCourse['no_of_attempt'] <3)					
						$returnarr[]=$TempCourse;
				}
				/*if($Responce['responce_status'] == 'Passed' || $Responce['responce_status'] == 'Failed')
				{
					if($flag)
						$returnarr[]=$TempCourse;							
				}
				else
					$returnarr[]=$TempCourse;*/
			}
		}
		if($returnarr)
			return $returnarr;
		else
			return false; //and UNIX_TIMESTAMP(course_expiry_date)>=".time()." 
	}
	
	function GetUserProfInfo()
	{
		$uid=$this->session->userdata['cust_id'];
		$sql="select *,(select profession_name from pdr_profession_master where profession_id = cust_prof_prof_id and profession_is_deleted ='N') as profession_name,(select state_name from pdr_state_master where state_id=cust_prof_state_id) as state_name from pdr_customer_prof_detail where cust_prof_cust_id=".$uid." and cust_prof_status like 'publish'";
		$res=$this->db->qyery($sql);
		return $res->result_array();
	}
	
	/*function GetUserCorseInfo()
	{		
		$uid=$this->session->userdata('cust_id');
		$sql="select * from pdr_order_details where order_status like 'Completed' and order_visibility='publish' and order_cust_id =".$uid." order by order_date desc";
		$res=$this->db->query($sql);
		$OrderInfo=$res->result_array();
		if($OrderInfo)
		{
			foreach($OrderInfo as $key=>$val)
			{
				$sql1="select * from pdr_order_course_detail as od left join pdr_course_master as cm on cm.course_id=od.ocd_course_id where od.ocd_order_id=".$val['order_id']." and UNIX_TIMESTAMP(cm.course_expiry_date)>=".time()."";
				$res1=$this->db->query($sql1);
				$CourseInfo=$res1->result_array();
				foreach($CourseInfo as $key1=>$val1)
				{
					$data=array(
								'course_id'	=>	$val1['course_id'],
								'cust_id'	=>	$uid,
								'order_id'	=>	$val['order_id'],
								);
					$Responce=$this->mdl_test->GetTestResponce($data);
					$val['cur_responce']=$Responce;
					$val1['order_id']=$val['order_id'];
					$val1['order_date']=$val['ocd_date'];
					$returnarr[]=$val1;
				}								
			}
			if($returnarr)
				return $returnarr;
			else
				return false;
		}	
		else
			return false;
	}*/
}