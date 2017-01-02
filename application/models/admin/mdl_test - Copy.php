<?php
class mdl_test extends CI_Model
{
	function get_test($course_id='',$test_id ='')
	{
		if($test_id == '')
		{		
			$sql = "select * from pdr_test_master where is_deleted ='N' and test_course_id=".$course_id;
		}
		else
		{
			$sql = "select * from pdr_test_master where test_course_id=".$course_id." and  test_id=".$test_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteTest($id)
	{
		$question_ids=$this->get_questions('',' and question_test_id='.$id);				
		foreach($question_ids->result_array() as $key=>$val)
		{
			$this->deleteQuse($val['question_id']);
		}		
		$data['is_deleted'] = "Y";
		$this->db->where('test_id',$id);
		$this->db->update('pdr_test_master',$data);						
	}
	function saveTest($test_id,$data)
	{
		if($test_id == "")
		{
			$this->db->insert('pdr_test_master',$data);
			$course_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('test_id',$test_id);
			$this->db->update('pdr_test_master',$data);
		}
		return $course_id;
	}
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Test Question part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#		
	function get_questions($question_id ='',$param='')
	{
		if($question_id == '')
		{
			$sql = "select * from pdr_question_master where is_deleted ='N'".$where.$param;
		}
		else
		{
			$sql = "select * from pdr_question_master where question_id=".$question_id;
		}

		return $this->db->query($sql);
	}
	function deleteQuse($id)
	{
		$data['is_deleted'] = "Y";
		$this->db->where('option_question_id',$id);
		$this->db->update('pdr_option_master',$data);
										
		$this->db->where('question_id',$id);
		$this->db->update('pdr_question_master',$data);						
	}
	function saveQuse($question_id,$data)
	{
		if($question_id == "")
		{
			$this->db->insert('pdr_question_master',$data);
			$question_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('question_id',$question_id);
			$this->db->update('pdr_question_master',$data);
		}
		return $question_id;
	}	
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Question Option part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#		
	function get_option($option_id ='',$param='')
	{
		if($option_id == '')
		{
			$sql = "select * from pdr_option_master where is_deleted ='N'".$param;
		}
		else
		{
			$sql = "select * from pdr_option_master where option_id=".$option_id;
		}

		return $this->db->query($sql);
	}
	function deleteOpt($id)
	{						
		$data['is_deleted'] = "Y";
		$this->db->where('option_id',$id);
		$this->db->update('pdr_option_master',$data);						
	}
	function saveOpt($option_id,$data)
	{
		if($option_id == "")
		{
			$this->db->insert('pdr_option_master',$data);
			$option_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('option_id',$option_id);
			$this->db->update('pdr_option_master',$data);
		}
		return $option_id;
	}		
}