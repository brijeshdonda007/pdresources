<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pdfdemo extends CI_Controller
{
	function pdfdemo()
	{
		parent::__construct();		
	}
	
	function index()
	{
		$data['str']=$this->session->userdata('PdfContent');
		//$data['str']='';
		$this->load->view('pdf/createpdf.php',$data);
	}	
}
?>