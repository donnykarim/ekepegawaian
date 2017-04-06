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
			
			$crud->set_language("indonesian");
			$crud->set_theme('bootstrap');

			//$crud->where('kd_unor',$this->uri->segment(3, 0));
			//$crud->like('kd_unor',$user->kd_unor);
			$crud->where("pns.kd_unor LIKE '".$user->kd_unor."%' AND kd_stathkm = 01");

			$crud->set_table('pns');
			
			$crud->order_by('kd_unor','ASC');
            
            $crud->columns('nip','glrdpn','nama','glrblk','kd_gol','tmtgol','kd_unor','kd_jnsjab','kd_dikpim','thn_dikpim','stat_data');
            $crud->display_as('nip','NIP')
            	 ->display_as('nama','NAMA')
            	 ->display_as('glrdpn','GELAR DPN')
            	 ->display_as('glrblk','GELAR BLK')
            	 ->display_as('kd_gol','GOL')
            	 ->display_as('tmtgol','TMT')
            	 ->display_as('kd_unor','UNIT KERJA')
            	 ->display_as('kd_dikpim','DIKLATPIM')
            	 ->display_as('thn_dikpim','TAHUN')
            	 ->display_as('stat_data','STATUS DATA')
            	 ->display_as('item_salah','ITEM SALAH')
            	 ->display_as('ket_salah','KET SALAH')
            	 ->display_as('kd_jnsjab','JENIS JAB');

            $crud->fields('nip','glrdpn','nama','glrblk','stat_data','item_salah','ket_salah');
            $crud->unset_jquery();
            $crud->set_relation('kd_unor','refunor','{Jab_unor} / ({nm_esel}) - {nm_skpd}');
            $crud->set_relation('kd_gol','refgol','nm_gol');
            $crud->set_relation('kd_dikpim','refdikpim','nm_dikpim');
            $crud->set_relation('kd_jnsjab','refjnsjab','nm_jnsjab');

            $crud->field_type('stat_data','dropdown',array('1' => 'BENAR', '2' => 'SALAH'));

            $crud->callback_edit_field('nip',array($this,'edit_nip_callback'));
            $crud->callback_edit_field('glrdpn',array($this,'edit_glrdpn_callback'));
            $crud->callback_edit_field('nama',array($this,'edit_nama_callback'));
            $crud->callback_edit_field('glrblk',array($this,'edit_glrblk_callback'));
            $crud->callback_edit_field('kd_gol',array($this,'edit_kd_gol_callback'));
            $crud->callback_edit_field('tmtgol',array($this,'edit_tmtgol_callback'));
            $crud->callback_edit_field('kd_unor',array($this,'edit_kd_dikpim_callback'));
            $crud->callback_edit_field('kd_dikpim',array($this,'edit_kd_dikpim_callback'));
            $crud->callback_edit_field('thn_dikpim',array($this,'edit_thn_dikpim_callback'));

            $crud->unset_add();
            $crud->unset_delete();
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
  	public function edit_nip_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nip" readonly>';
	}
	public function edit_glrdpn_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="glrdpn" readonly>';
	}
	public function edit_nama_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="nama" readonly>';
	}
	public function edit_glrblk_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="glrblk" readonly>';
	}
	public function edit_kd_gol_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="kd_gol" readonly>';
	}
	public function edit_tmtgol_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="tmtgol" readonly>';
	}
	public function edit_kd_unor_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="kd_unor" readonly>';
	}
	public function edit_kd_dikpim_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="kd_dikpim" readonly>';
	}
	public function edit_thn_dikpim_callback($value, $primary_key) {
		return '<input type="text" value="'.$value.'" name="thn_dikpim" readonly>';
	}


}
