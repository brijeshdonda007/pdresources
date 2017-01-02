<?php
class mdl_course extends CI_Model
{
	function get_course($course_id ='',$srchKey='')
	{
		if($course_id == '')
		{
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and course_id in (select course_id from pdr_course_master where course_name like '%".$srchKey."%' or course_author like '%".$srchKey."%')";
			}
			$sql = "select * from pdr_course_master where is_deleted ='N'".$where;
		}
		else
		{
			$sql = "select * from pdr_course_master where course_id=".$course_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteCourse($id)
	{
		$data['is_deleted'] = "Y";	
		//To delete All test related data related to course
		$test=$this->mdl_test->get_test($id);
		$testInfo=$test->result_array();
		if(is_array($testInfo))
		{
			$testdata=$testInfo[0];
			$flag=$this->mdl_test->deleteTest($testdata['test_id']);
		}
		$profData=$this->get_course_profession('','',' and course_pro_course_id='.$id);		
		if($profData->num_rows > 0)
		{
			//To delete All the profession data related to course

			$this->db->where('course_pro_course_id',$id);
			$this->db->update('pdr_course_profession_master',$data);	
		}
		$res=$this->get_course($id);
		$arr=$res->result();		
		unlink($arr[0]->course_image);		
		$this->db->where('course_id',$id);
		$this->db->update('pdr_course_master',$data);						
	}
	
	function saveCourse($course_id,$data)
	{
		if($course_id == "")
		{
			$this->db->insert('pdr_course_master',$data);
			$course_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('course_id',$course_id);
			$this->db->update('pdr_course_master',$data);
		}
		return $course_id;
	}
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Course Profesion part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#		
	function get_course_profession($course_pro_id ='',$course_id)
	{
		if($course_pro_id == '')
		{
			$sql = "select * from pdr_course_profession_master where is_deleted ='N' and course_pro_course_id=".$course_id;
		}
		else
		{
			$sql = "select * from pdr_course_profession_master where course_pro_id=".$course_pro_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteProf($id)
	{						
		$data['is_deleted'] = "Y";
		$this->db->where('course_pro_id',$id);
		$this->db->update('pdr_course_profession_master',$data);						
		//echo $this->db->last_query();die;
	}
	
	function saveProf($course_pro_id,$data)
	{
		if($course_pro_id == "")
		{
			$this->db->insert('pdr_course_profession_master',$data);
			$course_pro_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('course_pro_id',$course_pro_id);
			$this->db->update('pdr_course_profession_master',$data);
		}
		return $course_pro_id;
	}
	
	function GetProfessionInf()
	{
		$sql="select * from pdr_profession_master where profession_is_deleted='N' and profession_is_active='Y'";
		$res=$this->db->query($sql);
		$data=$res->result_array();
		foreach($data as $key=>$val)
		{
			$returnArr[$val['profession_id']]=$val['profession_name'];
		}
		return $returnArr;
	}
	
	function GetStateInf()
	{
		$sql="select * from pdr_state_master where state_is_active='Y' and state_is_deleted='N'";
		$res=$this->db->query($sql);
		$data=$res->result_array();
		foreach($data as $key=>$val)
		{
			$returnArr[$val['state_id']]=$val['state_name'];
		}
		return $returnArr;
	}
	
	function GetCityInf()
	{
		$sql="select * from pdr_city_master where city_status like 'publish'";
		$res=$this->db->query($sql);
		$data=$res->result_array();
		foreach($data as $key=>$val)
		{
			$returnArr[$val['city_id']]=$val['city_name'];
		}
		return $returnArr;
	}
	
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Course Restriction part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#		
	function get_course_restriction($restriction_id ='',$course_id)
	{
		if($restriction_id == '')
		{
			$sql = "select * from pdr_course_restriction_master where restriction_visiblity <> 'trash' and restriction_course_id=".$course_id;
		}
		else
		{
			$sql = "select * from pdr_course_restriction_master where restriction_id=".$restriction_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteRestriction($id)
	{						
		$data['restriction_visiblity'] = "trash";
		$this->db->where('restriction_id',$id);
		$this->db->update('pdr_course_restriction_master',$data);						
		//echo $this->db->last_query();die;
	}
	
	function saveRestriction($restriction_id,$data)
	{
		if($restriction_id == "")
		{
			$this->db->insert('pdr_course_restriction_master',$data);
			$restriction_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('restriction_id',$restriction_id);
			$this->db->update('pdr_course_restriction_master',$data);
		}
		return $restriction_id;
	}
	
	
}