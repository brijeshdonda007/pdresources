<?php
class Mdl_constants extends CI_Model
{
	function per_page_drop()
	{
		$dropdown = array('20'=>'20 Per Page','40'=>'40 Per Page','60'=>'60 Per Page');
		return $dropdown;
	}
	
	function lastLoginIP($user_id)
	{
		$this->db->select('ip_address');
		$this->db->where('user_id',$user_id);
		$this->db->order_by('login_time','desc');
		$res = $this->db->get('pdr_session');
		
		if($res->num_rows() > 0)
		{
			$row = $res->row_array();
			return $row['ip_address'];
		}
		else
			return "";
	}
	
	function tournament_types()
	{
		$dropDown = array('Select'=>'Select','Head'=>'Head','Cup'=>'Cup','Jackpot'=>'Jackpot');
		return $dropDown;
	}
	
	function iLikeAry()
	{
		$dropdown = array('Select'=>'Select','Puzzle Games'=>'Puzzle Games','Word Games'=>'Word Games','Card Games'=>'Card Games','Sports Games'=>'Sports Games','Sleeping in'=>'Sleeping in','Enjoying good food'=>'Enjoying good food','Spending time with family and friends'=>'Spending time with family and friends','The outdoors'=>'The outdoors','Partying and fun'=>'Partying and fun','Exercise and sports'=>'Exercise and sports','Paying taxes'=>'Paying taxes','Surfing the Internet'=>'Surfing the Internet','Making new friends'=>'Making new friends','A good book'=>'A good book','Solving crosswords'=>'Solving crosswords','Chocolate'=>'Chocolate','Winning'=>'Winning','Diploma Hunts'=>'Diploma Hunts','Giving Gifts'=>'Giving Gifts','The Fool\'s blog'=>'The Fool\'s blog');
		return $dropdown;
	}
	
	function iDislikeAry()
	{
		$dropdown = array('Select'=>'Select','Puzzle Games'=>'Puzzle Games','Word Games'=>'Word Games','Card Games'=>'Card Games','Sports Games'=>'Sports Games','Losing'=>'Losing','Work'=>'Work','Crowds'=>'Crowds','Computer problems'=>'Computer problems','Bills in my mail'=>'Bills in my mail','Dieting'=>'Dieting','Begging for gifts'=>'Begging for gifts','Politicians'=>'Politicians','Racism'=>'Racism','Rainy days'=>'Rainy days','Updates'=>'Updates');
		return $dropdown;
	}
	
	function iplayAry()
	{
		$dropdown = array('Select'=>'Select','for the fun of it'=>'for the fun of it','to be the best'=>'to be the best','to win cash'=>'to win cash','to challenge my friends'=>'to challenge my friends','to meet other people'=>'to meet other people','Actually I just play'=>'Actually I just play','because there was nothing on TV'=>'because there was nothing on TV','too often'=>'too often');
		return $dropdown;
	}
	
	function starSignAry()
	{
		$dropdown = array('Select'=>'Select','Aries'=>'Aries','Taurus'=>'Taurus','Gemini'=>'Gemini','Cancer'=>'Cancer','Leo'=>'Leo','Virgo'=>'Virgo','Libra'=>'Libra','Scorpio'=>'Scorpio','Sagittarius'=>'Sagittarius','Capricorn'=>'Capricorn','Aquarius'=>'Aquarius','Pisces'=>'Pisces');
		return $dropdown;
	}
	
	function yearArray($select='Y')
	{
		if($select == "Y")
			$yearArray = array('Year'=>'Year');
			
		$curYear = date('Y',time())-8;
		for($i=0; $i<90; $i++)
		{
			$year = $curYear-$i;
			$yearArray[$year] = $year;
		}
		return $yearArray;
	}
	
	function monthArray($select='Y')
	{
		if($select == "Y")
			$monthArray = array('Month'=>'Month');
	
		for($month=1; $month<=12; $month++)
			$monthArray[$month] = $month;

		return $monthArray;
	}
	
	function dayArray($select='Y')
	{
		if($select == "Y")
			$dayArray = array('Day'=>'Day');
		
		for($day=1; $day<=31; $day++)
			$dayArray[$day] = $day;

		return $dayArray;
	}
}