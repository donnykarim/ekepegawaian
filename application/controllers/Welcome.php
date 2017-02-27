<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
{
        parent::__construct();


		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth'); 
/* Standard Libraries */
$this->load->database();
$this->load->helper('url');

/* ------------------ */    
 
$this->load->library('grocery_CRUD');    
}

	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('users/sidebar');
		$this->load->view('users/content');
		$this->load->view('footer');	 		
	}

	public function report()
	{
			$crud = new grocery_CRUD();
			
			//$crud->where('status',0);
			//$crud->unset_jquery();
			$crud->set_table('test');
			
			//$crud->order_by('kd_unor','ASC');
            $crud->columns('id','nama');
            $crud->display_as('id','ID')
            	 ->display_as('nama','NAMA');
            $crud->fields('id','nama');
 
        $output = $crud->render();
        $this->_report_output($output);
	}
	public function _report_output($output = null)
    { 
		$this->load->view('welcome_message',$output);            
    }


}
