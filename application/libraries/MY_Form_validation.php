<?php 
	class MY_Form_validation extends CI_Form_validation
	{
		function is_value($str,$value)
		{
			$this->CI->form_validation->set_message('is_value','Please select %s.');
			if($str == $value)
			{
				return false;
			}
			return true;
		}
	}