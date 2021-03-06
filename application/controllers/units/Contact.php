<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');			
		}
		elseif (!$this->ion_auth->in_group('units')) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an Unit users to view this page.');
		}
		//$this->load->library('grocery_CRUD');	
	}

	public function index()
	{
			$user = $this->ion_auth->user()->row();
        	$data['fname'] = $user->first_name;
        	$data['lname'] = $user->last_name;
        	$data['company'] = $user->company;
        	$data['user_kd_unor'] = $user->kd_unor;

			$this->load->view('header',$data);
			$this->load->view('units/sidebar');
			$this->load->view('units/contact_content');
			$this->load->view('footer');  
	}

}
