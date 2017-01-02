<?php
class mdl_user extends CI_Model
{
	function get_users($user_id='',$srchKey='',$country='',$onlineSearch='')
	{
		if($user_id == "")
		{
			$where  = "";
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and u.id in (select id from pdr_user where user_email like '%".$srchKey."%' or user_name like '%".$srchKey."%')";
			}
			
			if($country != '' && $country != 'Select')
			{
				$country = mysql_escape_string($country);
				$where .= " and p.country='$country'";
			}

			if($onlineSearch == "Y")
				$where .= " and u.id in (select user_id from current_session)";
			
			$sql = "select u.* from pdr_user as u,pdr_user_profile as p where u.id = p.user_id ".$where." and u.del_in='N'";
		}
		else
			$sql = "select * from pdr_user as u,pdr_user_profile as p where u.id='".mysql_escape_string($user_id)."' and u.id = p.user_id";

		return $this->db->query($sql);
	}
	
	function deleteUser($id)
	{
		$data['del_in'] = "Y";
		$this->db->where('id',$id);
		$this->db->update('pdr_user',$data);				
		
		$this->db->where('user_id',$id);
		$this->db->update('pdr_user_profile',$data);
	}
}