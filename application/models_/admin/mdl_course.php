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
	function get_course_profession($course_pro_id ='',$srchKey='',$param='')
	{
		if($course_pro_id == '')
		{
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and course_id in (select course_id from pdr_course_master where course_name like '%".$srchKey."%' or course_author like '%".$srchKey."%')";
			}
			$sql = "select * from pdr_course_profession_master where is_deleted ='N'".$where.$param;
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
}