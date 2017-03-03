<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Datainduk_datainti extends CI_Controller {

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
		elseif (!$this->ion_auth->in_group('usersopd')) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an Users OPD to view this page.');
		}
		$this->load->library('grocery_CRUD');	
	}

	// redirect if needed, otherwise display the user list
	public function index()
	{
		// mengambil data user yang login
		$user = $this->ion_auth->user()->row();
        $data['user_kd_unor'] = $user->kd_unor;

			$crud = new grocery_CRUD();
			
			$crud->set_theme('bootstrap');

			//$crud->where('kd_unor',$this->uri->segment(3, 0));
			//$crud->like('kd_unor',$user->kd_unor);
			$crud->where("kd_unor LIKE '".$user->kd_unor."%' AND kd_stathkm = 01");

			$crud->set_table('pns');
			
			$crud->order_by('kd_gol','DESC');
            
            $crud->columns('pns_id','kd_unor','nama');
            $crud->display_as('pns_id','ID')
            	 ->display_as('nama','NAMA');
            $crud->fields('pns_id','kd_unor','nama');
            $crud->unset_jquery();
/*          $crud->set_relation('kd_unor','refunor','nm_skpd');
            $crud->set_relation('kd_unor_br','refunor2016','nm_skpd',array('a_05' => '99'),'kd_unor');
            $crud->callback_add_field('pns_id',array($this,'add_pnsid_callback'));
            $crud->callback_edit_field('pns_id',array($this,'edit_pnsid_callback'));
            $crud->callback_add_field('nmglr',array($this,'add_nmglr_callback'));
            $crud->callback_edit_field('nmglr',array($this,'edit_nmglr_callback'));
            $crud->callback_add_field('nip',array($this,'add_nip_callback'));
            $crud->callback_edit_field('nip',array($this,'edit_nip_callback'));
            $crud->callback_add_field('nm_kab',array($this,'add_nmkab_callback'));
            $crud->callback_edit_field('nm_kab',array($this,'edit_nmkab_callback'));
            $crud->callback_add_field('tgllhr',array($this,'add_tgllhr_callback'));
            $crud->callback_edit_field('tgllhr',array($this,'edit_tgllhr_callback'));
            $crud->callback_add_field('nm_pddk',array($this,'add_nmpddk_callback'));
            $crud->callback_edit_field('nm_pddk',array($this,'edit_nmpddk_callback'));
            $crud->callback_add_field('nm_pkt',array($this,'add_nmpkt_callback'));
            $crud->callback_edit_field('nm_pkt',array($this,'edit_nmpkt_callback'));
            $crud->callback_add_field('nm_gol',array($this,'add_nmgol_callback'));
            $crud->callback_edit_field('nm_gol',array($this,'edit_nmgol_callback'));
            $crud->callback_add_field('tmtgol',array($this,'add_tmtgol_callback'));
            $crud->callback_edit_field('tmtgol',array($this,'edit_tmtgol_callback'));
            $crud->callback_add_field('nm_jab',array($this,'add_nmjab_callback'));
            $crud->callback_edit_field('nm_jab',array($this,'edit_nmjab_callback'));
            //$crud->callback_add_field('nm_skpd',array($this,'add_nmskpd_callback'));
            //$crud->callback_edit_field('nm_skpd',array($this,'edit_nmskpd_callback'));
            //$crud->callback_add_field('nm_skpd_p',array($this,'add_nmskpdp_callback'));
            //$crud->callback_edit_field('nm_skpd_p',array($this,'edit_nmskpdp_callback'));
            $crud->callback_add_field('kd_unor',array($this,'add_kdunor_callback'));
            $crud->callback_edit_field('kd_unor',array($this,'edit_kdunor_callback'));*/
            //$crud->callback_add_field('ttd',array($this,'add_ttd_callback'));
            //$crud->callback_edit_field('ttd',array($this,'edit_ttd_callback'));

            $crud->unset_read();
            
            //$crud->field_type('pns_id','readonly',null);
 
        $output = $crud->render();
        $this->_datainduk_output($output);
	}

	public function _datainduk_output($output = null)
    {
		// mengambil data user yang login
		$user = $this->ion_auth->user()->row();
        $data['fname'] = $user->first_name;
        $data['lname'] = $user->last_name;
        $data['company'] = $user->company;
        $data['user_kd_unor'] = $user->kd_unor;
		
		//$this->load->model('Entry_model', '', TRUE);
		//$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
		//$get_jml_cuti = $this->Entry_model->get_jml_cuti($this->uri->segment(3, 0));
		//$data['get_pns_entry'] = $get_pns_entry->result();
		//$data['get_jml_cuti'] = $get_jml_cuti->result();
		$output->data = $data;

		//$this->load->helper('url');
		$this->load->view('header_gc',$output);
		$this->load->view('users/sidebar',$data);
		$this->load->view('users/datainduk_datainti_content',$output);
		$this->load->view('footer_gc');             
    }
    public function add_pnsid_callback() {
        return '<input type="text" value="'.$this->uri->segment(3, 0).'" name="pns_id" readonly>';
	}
  	public function edit_pnsid_callback() {
        return '<input type="text" value="'.$this->uri->segment(3, 0).'" name="pns_id" readonly>';
	}
	public function add_nip_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->nip.'" name="nip" readonly>';
		}
	}
  	public function edit_nip_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nip" readonly>';
	}
	public function add_nmglr_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->nmglr.'" name="nmglr" readonly>';
		}
	}
  	public function edit_nmglr_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nmglr" readonly>';
	}	
	public function add_nmkab_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->nm_kab.'" name="nm_kab" readonly>';
		}
	}
  	public function edit_nmkab_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nm_kab" readonly>';
	}
	public function add_tgllhr_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->tgllhr.'" name="tgllhr" readonly>';
		}
	}
  	public function edit_tgllhr_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="tgllhr" readonly>';
	}
	public function add_nmgol_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->nm_gol.'" name="nm_gol" readonly>';
		}
	}
  	public function edit_nmgol_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nm_gol" readonly>';
	}
	public function add_tmtgol_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->tmtgol.'" name="tmtgol" readonly>';
		}
	}
  	public function edit_tmtgol_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="tmtgol" readonly>';
	}
	public function add_nmpddk_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->nm_pddk.'" name="nm_pddk" readonly>';
		}
	}
  	public function edit_nmpddk_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nm_pddk" readonly>';
	}
	public function add_nmpkt_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->nm_pkt.'" name="nm_pkt" readonly>';
		}
	}
  	public function edit_nmpkt_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nm_pkt" readonly>';
	}
	public function add_nmjab_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->jab.'" name="nm_jab" readonly>';
		}
	}
  	public function edit_nmjab_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nm_jab" readonly>';
	}
	public function add_kdunor_callback() {
        $this->load->model('Entry_model', '', TRUE);
		$get_pns_entry = $this->Entry_model->get_pns_entry($this->uri->segment(3, 0));
        foreach ($get_pns_entry->result() as $row)
		{
			return '<input type="text" value="'.$row->kd_unor.'" name="kd_unor" readonly>';
		}
	}
	public function edit_kdunor_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="kd_unor" readonly>';
	}
	public function selesai() {
		$this->load->model('Penjagaan_model', '', TRUE);
		$get_selesai = $this->Penjagaan_model->selesai($this->uri->segment(3, 0));
		redirect('/penjagaan/selesai');
	}
	public function selesaiall() {
		$this->load->model('Penjagaan_model', '', TRUE);
		$get_selesaiall = $this->Penjagaan_model->selesaiall();
		redirect('/penjagaan/selesai');
	}


}
