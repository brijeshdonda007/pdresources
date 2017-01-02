<?php
class mdl_managereview extends CI_Model
{
	function get_reviews($comment_id='',$course_id='')
	{
		if($comment_id == "")
		{
			$where  = " and comment_course_id = ".$course_id;		
			$sql = "select * from pdr_user_comments  where 1 ".$where." and comment_approved <>'trash'";
		}
		else
			$sql = "select * from pdr_user_comments  where comment_id='".mysql_escape_string($comment_id)."'";

		return $this->db->query($sql);
	}
	
	function deleteManagereview($id)
	{
		$data['comment_approved'] = "trash";
		$this->db->where('comment_id',$id);
		$this->db->update('pdr_user_comments',$data);						
	}
	function saveManagereview($comment_id,$data)
	{
		if($comment_id == "")
		{
			$this->db->insert('pdr_user_comments',$data);
			$comment_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('comment_id',$comment_id);
			$this->db->update('pdr_user_comments',$data);
		}
		return $comment_id;
	}
}