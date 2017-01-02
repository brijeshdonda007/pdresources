<?php
class mdl_evaluation extends CI_Model
{
	function get_evaluation($evaluation_id ='')
	{
		if($evaluation_id == '')
		{		
			$sql = "select * from pdr_evaluation_master where is_deleted ='N'";
		}
		else
		{
			$sql = "select * from pdr_evaluation_master where evaluation_id=".$evaluation_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteEvaluation($id)
	{
		$question_ids=$this->get_questions('',' and question_evaluation_id='.$id);				
		foreach($question_ids->result_array() as $key=>$val)
		{
			$this->deleteQuse($val['question_id']);
		}		
		$data['is_deleted'] = "Y";
		$this->db->where('evaluation_id',$id);
		$this->db->update('pdr_evaluation_master',$data);						
	}
	
	function saveEvaluation($evaluation_id,$data)
	{
		if($evaluation_id == "")
		{
			$this->db->insert('pdr_evaluation_master',$data);
			$course_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('evaluation_id',$evaluation_id);
			$this->db->update('pdr_evaluation_master',$data);
		}
		return $course_id;
	}
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Evaluation Question part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#		
	function get_questions($question_id ='',$param='')
	{
		if($question_id == '')
		{
			$sql = "select * from pdr_evaluation_question_master where is_deleted ='N'".$where.$param;
		}
		else
		{
			$sql = "select * from pdr_evaluation_question_master where question_id=".$question_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteQuse($id)
	{
		$data['is_deleted'] = "Y";
		$this->db->where('option_question_id',$id);
		$this->db->update('pdr_evaluation_option_master',$data);
										
		$this->db->where('question_id',$id);
		$this->db->update('pdr_evaluation_question_master',$data);						
	}
	
	function saveQuse($question_id,$data)
	{
		if($question_id == "")
		{
			$this->db->insert('pdr_evaluation_question_master',$data);
			$question_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('question_id',$question_id);
			$this->db->update('pdr_evaluation_question_master',$data);
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
			$sql = "select * from pdr_evaluation_option_master where is_deleted ='N'".$param;
		}
		else
		{
			$sql = "select * from pdr_evaluation_option_master where option_id=".$option_id;
		}

		return $this->db->query($sql);
	}
	function deleteOpt($id)
	{						
		$data['is_deleted'] = "Y";
		$this->db->where('option_id',$id);
		$this->db->update('pdr_evaluation_option_master',$data);						
	}
	function saveOpt($option_id,$data)
	{
		if($option_id == "")
		{
			$this->db->insert('pdr_evaluation_option_master',$data);
			$option_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('option_id',$option_id);
			$this->db->update('pdr_evaluation_option_master',$data);
		}
		return $option_id;
	}		
}