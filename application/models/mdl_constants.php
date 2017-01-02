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
	
	
	function Image_ext()
	{
		$dropdown = array('gif'=>'gif',						  
						  'jpg'=>'jpg',
						  'jpeg'=>'jpeg',
						  'png'=>'png',
						  'bmp'=>'bmp',
						  );
		return $dropdown;
	}
	
	function Messages($id='')
	{
		$dropdown = array(	1  => 'Could not find activation key. Please try again.',// not found activation key                         
                            2  => "We could not find information about this activation key. Please verify your activation email.",//for wrong activation key   
                            3 =>  "Invalid username or password combination.", //wrong user name and password
                            4 =>  "Please activate your account first. You should have received activation link in your email.",//account without activation      
							5 =>  "We could not find information related to this email address. Kindly check your email address registered with us.",//for wrong email address in forgot password   
							6 =>  "Your account is already activated.Please login to your account or contact administrator.",//for wrong email address in forgot password   
							7 =>  "Invalid Course Information.Please retry again.",//Invalid coruse search or course listing is there
                            11 => "Your account is activated successfully.",//After activation
                            13 => "Your password information is sent to your email address. Please check your mailbox.",//In forgot password
                            14 => "Your password reset successfully.",    //reset password
                            15 => "Your profile updated successfully.",
                            16 => "Your password updated successfully.",                           
                            20 => "Account activation link is sent to your email. Please check your mailbox.",//simple register
                            21 => "You have successfully signed up with facebook. Your password details are sent to your email, please check your mailbox.",//signup through facebook
                            22 => "Your account information is updated successfully.",//edit profile
							23 => "Thank you for reporting issue(s). We would try to resolve them as soon as possible.",//Contact us reporting bug
							24 => "Thank you for contacting us. We would get in touch with you soon.",//Contact us Feed back or other	
							25 => "Your Message is submitted successfully",//Buggy message successfylly submitted 						
						  );
		if($id)
			return $dropdown[$id];
		else	
			return $dropdown;
	}
	
	function CartMessages($id='')
	{
		$dropdown = array(	1  	=>  'No product exist in cart.',// Empty Cart          
							2	=>	'Error in processing cart.Please retry again',//Genral processing error
							3	=>	'This Product is already exits in the cart.',//Already exits product         
							4	=>	'Please Enter Coupon Code.',//Enter Coupon Code
							5	=>	'Please Enter Valid Coupon Code.',//Invalid Coupon Code							               
							6	=>	'Coupoun has been expired.Please try another coupon code.',//Expired Coupon Code							               
							7	=>	'Coupoun usage limit is exceed.Please try another coupoun code.',//Expired Coupon Code							               
							8	=>	'You are not a valid user to use this coupoun.',//For user validation in the coupon
							9	=>	"This course is already active in your account",//To check is this course is already in there account or not
							10	=>	'This course is not allow reenrolling',//for non enrolling courses
							11	=>	'Following courses are already active in your account',//After login msg
							12	=>	'Following courses are not allow reenrolling',//After login validation
                         	16	=>	'Item Successfully Added to cart.',//Add in the cart
							17	=>	'Item Successfully Removed to cart.',//Add in the cart
							18	=>	'Coupon Successfully Removed.',//Delete Coupon
							19	=>	'Coupon Successfully Applied.',//Delete Coupon
						  );
		if($id)
			return $dropdown[$id];
		else	
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
	
	function AdminMail()
	{
		return 'errors@pdresources.org';
		//return 'brijesh.donda@artoonsolutions.com';
	}
}