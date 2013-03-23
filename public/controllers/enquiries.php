<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiries extends MY_Controller
{

	// ------------------------ PUBLIC METHODS ------------------------ //
	
	/**
	 * I instantiate this class
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation'));		
		$this->load->model('Enquiry_class');
	}

	/**
	 * I display an enquiry form
	 */
	function index()
	{
		$data = $this->Enquiry_class->new_enquiry();
		$layout_data['content_body'] = $this->load->view('enquiries/index', $data, true);
		$this->load->view('layouts/index', $layout_data);
	}

	/**
	 * I send an enquiry
	 */	
	function send() 
	{
		$validation_rules = $this->get_validation_rules();
		$this->form_validation->set_rules($validation_rules);
		$data = parent::populate($this->input->post(), array('name', 'email', 'message'));
		// validation failure
		if ($this->form_validation->run() === FALSE) 
		{
			// flash data can only be used with redirects so we can't use it here
			$data['message'] = array('type'=>'error', 'text'=>'Please amend the highlighted fields.');
			$layout_data['content_body'] = $this->load->view('enquiries/index', $data, true);
			$this->load->view('layouts/index', $layout_data);			
		}
		// validation success
		else
		{
			
			$this->load->library('email');
			$this->email->from($data['email'], $data['name']);
			$this->email->to('smnbin@gmail.com');
			$this->email->subject('Enquiry Form Submission');
			$this->email->message($data['message']);
			$this->email->send();
			/*
			echo $this->email->print_debugger();
			die();
			*/			
			$this->Enquiry_class->save_enquiry($data);
			redirect('enquiries/thanks', 'refresh');
		}
	}
	
	/**
	 * I display a confirmation message
	 */
	function thanks()
	{
		$layout_data['content_body'] = $this->load->view('enquiries/thanks', array(), true);
		$this->load->view('layouts/index', $layout_data);
	}	
	
	// ------------------------ PRIVATE METHODS ------------------------ //
	
	/**
	 * I return the validation rules
	 *
	 * @access   private
	 * @return   array    validation rules
	 */
	private function get_validation_rules() 
	{
		$rules = array(
			array(
				'field' => 'name',
				'label' => 'name',
				'rules' => 'trim|required|max_length[150]|xss_clean'
			),
			array(
				'field' => 'email',
				'label' => 'email',
				'rules' => 'trim|required|max_length[150]|email|xss_clean'
			),
			array(
				'field' => 'message',
				'label' => 'message',
				'rules' => 'trim|required|xss_clean'
			)
		);
		return $rules;
	}

}