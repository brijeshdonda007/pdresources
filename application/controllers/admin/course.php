<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller
{
	function Course()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_course');
		$this->load->model('admin/mdl_test');							
	}
	
	function index($start='0')
	{	
		$this->session->unset_userdata('course_id');		
		if($_POST || $start=='s')
		{
			$start = 0;
			$searchKey = $this->input->post('searchText');						
			$this->session->set_userdata('searchKey',$searchKey);
		}
		else
		{
			$searchKey = $this->session->userdata('searchKey');
		}
			
		$res = $this->mdl_course->get_course('',$searchKey);
		
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/course/index/',$res->num_rows(),$start,'4');
		
		$this->session->set_userdata('start',$start);									
		if($searchKey == "")
			$searchKey = "Search";
		
		$data['searchText'] = $searchKey;
		
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/course_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addCourse($course_id='')
	{		
		$this->form_validation->set_rules('course_name','Course Name','trim|required');
	//	$this->form_validation->set_rules('course_release_date','Course Release Date','trim|required');
		$this->form_validation->set_rules('course_main_course_id','Main Course Id','trim|required|callback_match_course');		
		$this->form_validation->set_rules('course_online_price','Online Price','trim|required|callback_validate_float');
		$this->form_validation->set_rules('course_sale_price','Sale Price','trim|required|callback_validate_float');
		$this->form_validation->set_rules('course_expired_price','Expired Price','trim|required|callback_validate_float');		
		//$this->form_validation->set_rules('course_author','Course Author','trim|required');	
		if($this->input->post('course_amazon_link'))
			$this->form_validation->set_rules('course_amazon_link','Amazon Link','trim|required|callbacj_validate_url');				
		$this->form_validation->set_rules('course_pdf_content','Pdf Content File','callback_validate_file');
		$this->form_validation->set_rules('course_test','Course Test','trim|required');		
		$this->form_validation->set_rules('course_evaluation','Course Evaluation','trim|required');		
		$this->form_validation->set_rules('course_expiry_date','Course Expiry Date','trim|required');
		//$this->form_validation->set_rules('course_ce_hours','Course Hours','trim|required|numeric');
		//$this->form_validation->set_rules('course_ce_ceus','Course CEUs','trim|required|callback_validate_float');
		if($course_id == '')
		{	
			if($_FILES['course_image']['error'] != 0)
			{
				$file_error = "Please select Course Image";
			}
		}
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['course_type'] = $this->input->post('course_type');
			$data['course_name'] = $this->input->post('course_name');				
			$data['course_release_date'] = $this->input->post('course_release_date');
			$data['course_main_course_id'] = $this->input->post('course_main_course_id');			
			$data['course_learning_level'] = $this->input->post('course_learning_level');
			$data['course_ce_ceus'] = $this->input->post('course_ce_ceus');						
			$data['course_online_price'] = $this->input->post('course_online_price');
			$data['course_sale_price'] = $this->input->post('course_sale_price');				
			$data['course_expired_price'] = $this->input->post('course_expired_price');
			$data['course_author'] = $this->input->post('course_author');			
			$data['course_desc'] = $this->input->post('course_desc');	
			$data['course_objective'] = $this->input->post('course_objective');				
			
			$data['course_amazon_link'] = $this->input->post('course_amazon_link');
			
			$data['course_test'] = $this->input->post('course_test');				
			$data['course_expiry_date'] = $this->input->post('course_expiry_date');
			$data['course_accreditations'] = $this->input->post('course_accreditations');			
			$data['course_state'] = $this->input->post('course_state');
			$data['course_city'] = $this->input->post('course_city');						
			$data['course_zipcode'] = $this->input->post('course_zipcode');
			$data['course_certificate'] = $this->input->post('course_certificate');	
			$data['course_reenrolment'] = $this->input->post('course_reenrolment');					
			$data['course_is_demo'] = $this->input->post('course_is_demo');		
			$data['course_is_active'] = $this->input->post('course_is_active');												
			
			//$data['course_id'] = $course_id;			
			if(!$_POST && $course_id != '')
			{
				$res = $this->mdl_course->get_course($course_id);
				$data = $res->row_array();								
			}
			if($data['course_objective'])
				$data['objective_arr']=$this->GetObjectiveById($data['course_objective']);	
			if($data['course_author'])
				$data['author_arr']=$this->GetAuthourById($data['course_author']);	
			if($data['course_test'])
				$data['test_arr']=$this->GetTestById($data['course_test']);					
			if($data['course_evaluation'])
				$data['evaluation_arr']=$this->GetEvaluationById($data['course_evaluation']);									
			if($data['course_accreditations'])
				$data['accreditation_arr']=$this->GetAccreditationsById($data['course_accreditations']);	
			if($data['course_certificate'])
				$data['certificate_arr']=$this->GetCertificateById($data['course_certificate']);				


			$header['is_autofill']=true;			
			$data['file_error']=$file_error;
			$this->load->view('admin/header',$header);
			$this->load->view('admin/addCourse',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$data['course_type'] = $this->input->post('course_type');
			$data['course_name'] = $this->input->post('course_name');				
			$data['course_release_date'] = $this->input->post('course_release_date');
			$data['course_main_course_id'] = $this->input->post('course_main_course_id');			
			$data['course_learning_level'] = $this->input->post('course_learning_level');
			$data['course_ce_ceus'] = $this->input->post('course_ce_ceus');						
			$data['course_online_price'] = $this->input->post('course_online_price');
			$data['course_sale_price'] = $this->input->post('course_sale_price');				
			$data['course_expired_price'] = $this->input->post('course_expired_price');
			$data['course_author'] = $this->input->post('course_author');			
			$data['course_desc'] = $this->input->post('course_desc');	
			$data['course_objective'] = $this->input->post('course_objective');							
			$data['course_amazon_link'] = $this->input->post('course_amazon_link');			
			$data['course_test'] = $this->input->post('course_test');				
			$data['course_evaluation'] = $this->input->post('course_evaluation');				
			$data['course_expiry_date'] = $this->input->post('course_expiry_date');
			$data['course_accreditations'] = $this->input->post('course_accreditations');			
			$data['course_state'] = $this->input->post('course_state');
			$data['course_city'] = $this->input->post('course_city');						
			$data['course_zipcode'] = $this->input->post('course_zipcode');
			$data['course_certificate'] = $this->input->post('course_certificate');	
			$data['course_reenrolment'] = $this->input->post('course_reenrolment');					
			$data['course_is_demo'] = $this->input->post('course_is_demo');		
			$data['course_is_active'] = $this->input->post('course_is_active');		
					
			if($course_id != "")
			{
				$res1 = $this->mdl_course->get_course($courseid);
				$row1 = $res1->row_array();				
				$image=$row1;
			}
			if($_FILES['course_pdf_content']['error'] == 0)
			{
				if($course_id != "") {
					@unlink('./'.$row1['course_pdf_content']);
				}																															
					$res = $this->mdl_common->uploadFile('course_pdf_content','pdf','course');					
				if($res['success'])
				{						
					$data['course_pdf_content'] = $res['path'];
				}
			}								

			if($_FILES['course_image']['error'] == 0)
			{
				if($course_id != "") {
					@unlink('./'.$row1['course_image']);
				}																															
					$res = $this->mdl_common->uploadFile('course_image','img','course');					
				if($res['success'])
				{						
					$data['course_image'] = $res['path'];
				}
			}		
			if($_REQUEST['delete_pdf'] == "delete_pdf") 
				@unlink('./'.$row1['course_pdf_content']);						
			/*if(strlen(trim($_POST['pdf_content'])))
			{
				@unlink('./'.$row1['course_pdf_content']);
				$data['course_pdf_content'] = $this->CreatePdf($_POST['pdf_content']);				
			}*/
			$courseid = $this->mdl_course->saveCourse($course_id,$data);
			$start = $this->session->userdata('start');
			if($course_id != '')
				redirect('admin/course/index/'.$start);
			else
				redirect('admin/course/index/s');
		}
	}			
	
	function CreatePdf($str)
	{
		$this->session->set_userdata('PdfContent',$str);
		$no=rand(1,100000);
		$uploadpath='./uploads/course/'.$no.'.pdf';	
		$returnpath='uploads/course/'.$no.'.pdf';	
		$src=site_url('pdfdemo');	
		$dest=$uploadpath;
		$filedata=file_get_contents(base_url().'uploads/course/saga.pdf');
		$handle = fopen($uploadpath, 'w+'); 
echo '<pre>';
print_r($filedata);
echo '</pre>';die;
    	// Write $somecontent to our opened file.
	    if (fwrite($handle, $filedata) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }
		$filedata=file_get_contents($uploadpath);
		
		echo '<pre>';
print_r($filedata);
echo '</pre>';
		//copy($src,$dest);
	//	$this->session->unset_userdata('PdfContent');
		echo '<pre>';
print_r($src);
echo '</pre>';
echo '<pre>';
print_r($dest);
echo '</pre>';
		echo 'called';die;
		return $returnpath;
	}
	
	function deleteCourse($id='')
	{
		if($id == "")
			$users = $this->input->post('course_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_course->deleteCourse($id);
		}
		
		$start = $this->session->userdata('start');
				
			redirect('admin/course/index/'.$start);
	}
	
	function updateActive($course_id,$is_active)
	{
		$data['course_is_active'] = $is_active;
		$this->db->where('course_id',$course_id);
		$this->db->update('pdr_course_master',$data);
	}	
	
	function validate_float($str)
	{	
		if(preg_match('/^[\d]+(\.[\d]+){0,1}$/',$str))
		{
			return TRUE;
		}
		else		
		{
			$this->form_validation->set_message('validate_float', 'Unvalid course ceus');
			return FALSE;
		}
	}
	
	function match_course($str)
	{
		$arr=explode('-',$str);		
		
		if(count($arr) == 2 && is_numeric($arr[0]) && strlen($arr[0]) == 2 && is_numeric($arr[1]) && strlen($arr[1]) == 2 )
		{
			return TRUE;
		}
		else		
		{
			$this->form_validation->set_message('match_course', 'Unvalid course master id');
			return FALSE;
		}
	}
		
	function validate_url($str)
	{
		if(strlen(trim($str)) != 0)
		{
			if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $str))
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('validate_url', 'Please enter valid Link');
				return false;
			}
		}
		else
			return TRUE;
	}

	function validate_file()
	{
		if($_FILES['course_pdf_content']['error'] == 0)
		{
			$ext=strtolower(end(explode('.',$_FILES['course_pdf_content']['name'])));									
			if($ext == 'pdf')
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('validate_file', 'Please select valid content file');
				return false;
			}
		}
		else
			return TRUE;
	}
	
	
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Course Profesion part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#	
	function profession($course_id='',$start=0)
	{
		if($_POST || $start=='s')
			$start = 0;			

		if($course_id)
			$this->session->set_userdata('course_id',$course_id);
		else
			$course_id=$this->session->userdata('course_id');
		
		if(!$course_id)
			redirect('admin/course');
		
		$res = $this->mdl_course->get_course_profession('',$course_id);
		
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/course/profession/',$res->num_rows(),$start,'4');
		
		$this->session->set_userdata('start',$start);									
		$data['profession']=$this->mdl_course->GetProfessionInf();

		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$data['course_id']=$course_id;
		$this->load->view('admin/header');
		$this->load->view('admin/course_prof_list',$data);
		$this->load->view('admin/footer');											
	}
	
	function addProfession($course_pro_id='')
	{		
		$course_id=$this->session->userdata('course_id');
		if(!$course_id)
			redirect('admin/course');

		$this->form_validation->set_rules('course_pro_prof_id','Profession','trim|required');
		//$this->form_validation->set_rules('course_release_date','Course Release Date','trim|required');

		if($this->form_validation->run() == FALSE || $file_error!='')
		{			$data['course_type'] = $this->input->post('course_type');
			
			//$data['course_id'] = $course_id;			
			if(!$_POST && $course_pro_id != '')
			{
				$res = $this->mdl_course->get_course_profession($course_pro_id);
				$data = $res->row_array();								
			}
			if($data['course_pro_prof_id'])
				$data['profession_arr']=$this->GetProfessionById($data['course_pro_prof_id']);	
			$header['is_autofill']=true;			
			$data['file_error']=$file_error;
			$this->load->view('admin/header',$header);
			$this->load->view('admin/addCourseProfession',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$data['course_pro_prof_id'] = $this->input->post('course_pro_prof_id');
			$data['course_pro_ce'] = $this->input->post('course_pro_ce');				
			$data['is_active'] = $this->input->post('is_active');							
			$data['course_pro_course_id']=$course_id;		
			$courseid = $this->mdl_course->saveProf($course_pro_id,$data);
			$start = $this->session->userdata('start');
			if($course_id != '')
				redirect('admin/course/profession/');
			else
				redirect('admin/course/profession/');
		}
	
	}
	
	function updateProfActive($course_pro_id,$is_active)
	{
		$data['is_active'] = $is_active;
		$this->db->where('course_pro_id',$course_pro_id);
		$this->db->update('pdr_course_profession_master',$data);
	}	
	
	function deleteProf($id='')
	{
		if($id == "")
			$users = $this->input->post('course_pro_id');
		else
			$users = array($id);
		foreach($users as $id)
		{
			$this->mdl_course->deleteProf($id);
		}						
		redirect('admin/course/profession/');
	}
	
	
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Course Restriction part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#	
	function restriction($course_id='',$start=0)
	{
		if($_POST || $start=='s')
			$start = 0;			

		if($course_id)
			$this->session->set_userdata('course_id',$course_id);
		else
			$course_id=$this->session->userdata('course_id');
		
		if(!$course_id)
			redirect('admin/course');
		
		$res = $this->mdl_course->get_course_restriction('',$course_id);
		
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/course/restriction/',$res->num_rows(),$start,'4');
		
		$this->session->set_userdata('start',$start);									
		$data['profession']=$this->mdl_course->GetProfessionInf();
		$data['state']=$this->mdl_course->GetStateInf();
		$data['city']=$this->mdl_course->GetCityInf();
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$data['course_id']=$course_id;
		$this->load->view('admin/header');
		$this->load->view('admin/course_restriction_list',$data);
		$this->load->view('admin/footer');											
	}
	
	function addRestriction($restriction_id='')
	{		
		$course_id=$this->session->userdata('course_id');
		if(!$course_id)
			redirect('admin/course');
		
		$this->form_validation->set_rules('restriction_profession','Profession','trim|required');

		if($this->form_validation->run() == FALSE || $file_error!='')
		{	
			if(!$_POST && $restriction_id != '')
			{
				$res = $this->mdl_course->get_course_restriction($restriction_id);
				$data = $res->row_array();								
			}
			if($data['restriction_profession'])
				$data['profession_arr']=$this->GetProfessionById($data['restriction_profession']);					
			if($data['restriction_state'])
				$data['state_arr']=$this->GetStateById($data['restriction_state']);	
			if($data['restriction_city'])
				$data['city_arr']=$this->GetCityById($data['restriction_city']);	
				
			$header['is_autofill']=true;			
			$data['file_error']=$file_error;
			$this->load->view('admin/header',$header);
			$this->load->view('admin/addCourseRestriction',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$data['restriction_state'] = $this->input->post('restriction_state');
			$data['restriction_city'] = $this->input->post('restriction_city');				
			$data['restriction_zipcode'] = $this->input->post('restriction_zipcode');
			$data['restriction_profession'] = $this->input->post('restriction_profession');				
			$data['restriction_visiblity'] = $this->input->post('restriction_visiblity');							
			$data['restriction_course_id']=$course_id;		
			
			$courseid = $this->mdl_course->saveRestriction($restriction_id,$data);
			$start = $this->session->userdata('start');
			if($course_id != '')
				redirect('admin/course/restriction/'.$course_id);
			else
				redirect('admin/course/restriction/');
		}
	
	}
	
	function updateRestrictionActive($restriction_id,$is_active)
	{
		$data['restriction_visiblity'] = $is_active;
		$this->db->where('restriction_id',$restriction_id);
		$this->db->update('pdr_course_restriction_master',$data);
	}	
	
	function deleteRestriction($id='')
	{
		if($id == "")
			$users = $this->input->post('restriction_id');
		else
			$users = array($id);
		foreach($users as $id)
		{
			$this->mdl_course->deleteRestriction($id);
		}						
		redirect('admin/course/restriction/');
	}
	
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Course Auto suggest function		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#	
	
	function GetAuthour()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT author_id,author_fname,author_lname from pdr_author_detail WHERE (author_fname LIKE '%$param%' or author_lname LIKE '%$param%') and author_active Like 'publish' ORDER BY author_fname ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['author_id'];
			$temp['name']=$val['author_fname'].' '.$val['author_lname'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetAuthourById($author_id)
	{
		$sql = "SELECT author_id,author_fname,author_lname from pdr_author_detail WHERE author_id In (".$author_id.") and author_active Like 'publish' ORDER BY author_fname";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['author_id'];
			$temp['name']=$val['author_fname'].' '.$val['author_lname'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
	
	function GetTest()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT test_id,test_name from pdr_test_master WHERE (test_name LIKE '%$param%') and is_deleted like 'N' and is_active like 'Y' ORDER BY test_name ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['test_id'];
			$temp['name']=$val['test_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetTestById($author_id)
	{
		$sql = "SELECT test_id,test_name from pdr_test_master WHERE test_id In (".$author_id.") and is_deleted like 'N' and is_active like 'Y' ORDER BY test_name";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['test_id'];
			$temp['name']=$val['test_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
	
	function GetEvaluation()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT evaluation_id,evaluation_name from pdr_evaluation_master WHERE (evaluation_name LIKE '%$param%') and is_deleted like 'N' and is_active like 'Y' ORDER BY evaluation_name ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['evaluation_id'];
			$temp['name']=$val['evaluation_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetEvaluationById($evaluation_id)
	{
		$sql = "SELECT evaluation_id,evaluation_name from pdr_evaluation_master WHERE evaluation_id In (".$evaluation_id.") and is_deleted like 'N' and is_active like 'Y' ORDER BY evaluation_name";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['evaluation_id'];
			$temp['name']=$val['evaluation_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
	
	function GetAccreditations()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT accreditations_id,accreditations_title from pdr_accreditations_detail WHERE (accreditations_title LIKE '%$param%') and accreditations_active Like 'publish' ORDER BY accreditations_title ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['accreditations_id'];
			$temp['name']=$val['accreditations_title'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetAccreditationsById($author_id)
	{
		$sql = "SELECT accreditations_id,accreditations_title from pdr_accreditations_detail WHERE accreditations_id In (".$author_id.") and accreditations_active Like 'publish' ORDER BY accreditations_title";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['accreditations_id'];
			$temp['name']=$val['accreditations_title'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
	
	function GetCertificate()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT certificate_id,certificate_title from pdr_certificate_detail WHERE (certificate_title LIKE '%$param%') and certificate_active Like 'publish' ORDER BY certificate_title ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['certificate_id'];
			$temp['name']=$val['certificate_title'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetCertificateById($author_id)
	{
		$sql = "SELECT certificate_id,certificate_title from pdr_certificate_detail WHERE certificate_id In (".$author_id.") and certificate_active Like 'publish' ORDER BY certificate_title";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['certificate_id'];
			$temp['name']=$val['certificate_title'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
	
	function GetProfession()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT profession_id,profession_name from pdr_profession_master WHERE (profession_name LIKE '%$param%') and profession_is_deleted like 'N' and profession_is_active like 'Y' ORDER BY profession_name ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['profession_id'];
			$temp['name']=$val['profession_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetProfessionById($author_id)
	{
		$sql = "SELECT profession_id,profession_name from pdr_profession_master WHERE profession_id In (".$author_id.") and profession_is_deleted like 'N' and profession_is_active like 'Y' ORDER BY profession_name";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['profession_id'];
			$temp['name']=$val['profession_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
	
	function GetState()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT state_id,state_name from pdr_state_master WHERE (state_name LIKE '%$param%') and state_is_deleted like 'N' and state_is_active like 'Y' ORDER BY state_name ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['state_id'];
			$temp['name']=$val['state_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetStateById($author_id)
	{
		$sql = "SELECT state_id,state_name from pdr_state_master WHERE state_id In (".$author_id.") and state_is_deleted like 'N' and state_is_active like 'Y' ORDER BY state_name";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['state_id'];
			$temp['name']=$val['state_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
	
	function GetCity()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT city_id,city_name from pdr_city_master WHERE (city_name LIKE '%$param%') and city_status like 'publish' ORDER BY city_name ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['city_id'];
			$temp['name']=$val['city_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetCityById($author_id)
	{
		$sql = "SELECT city_id,city_name from pdr_city_master WHERE city_id In (".$author_id.") and city_status like 'publish' ORDER BY city_name";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['city_id'];
			$temp['name']=$val['city_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
		
	function GetZipcode()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT zipcode_id,zipcode_name from pdr_zipcode_master WHERE (zipcode_name LIKE '%$param%') and zipcode_status like 'publish' ORDER BY zipcode_name ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['zipcode_id'];
			$temp['name']=$val['zipcode_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetZipcodeById($author_id)
	{
		$sql = "SELECT zipcode_id,zipcode_name from pdr_zipcode_master WHERE zipcode_id In (".$author_id.") and zipcode_status like 'publish' ORDER BY zipcode_name";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['zipcode_id'];
			$temp['name']=$val['zipcode_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
	
	function GetObjective()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT objective_id,objective_name from pdr_courseobjective_master WHERE (objective_name LIKE '%$param%') and objective_status like 'publish' ORDER BY objective_name ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['objective_id'];
			$temp['name']=$val['objective_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetObjectiveById($author_id)
	{
		$sql = "SELECT objective_id,objective_name from pdr_courseobjective_master WHERE objective_id In (".$author_id.") and objective_status like 'publish' ORDER BY objective_name";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['objective_id'];
			$temp['name']=$val['objective_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}
}
?>