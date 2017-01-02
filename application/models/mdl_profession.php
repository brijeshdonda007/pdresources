<?php
	class mdl_profession extends CI_Model
	{
		function get_profession($id='',$all='')
		{
			if($id !=0 && $id) 
				$this->db->where('profession_id',$id);					
			else
			{
				if(!$all)
				{
					$this->db->order_by('RAND()');
					$this->db->limit(1);
				}
			}
			$this->db->where('profession_is_active','Y');
			$this->db->where('profession_is_deleted','N');			
			$res = $this->db->get('pdr_profession_master');
			if($id)
				return $res->row_array();
			else
				return $res->result_array();
		}
		
		function GetCourseIdByProfId($prof_id)
		{
			$this->db->where('course_pro_prof_id',$prof_id);
			$this->db->where('is_active','Y');
			$this->db->where('is_deleted','N');
			$res=$this->db->get('pdr_course_profession_master');

			//$res=$this->db->query();
			$data=$res->result_array();
			
			if(is_array($data))
			{
				$course_id='';
				foreach($data as $key=>$val)
					$course_id[]=$val['course_pro_course_id'];				
				$returndata=implode(',',$course_id);
				if($returndata)
					return $returndata;
				else	
					return false;
			}
			else
				return false;
		}
	}