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
		elseif (!$this->ion_auth->in_group('new')) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must not be here.');
		}
		$this->load->library('grocery_CRUD');	
	}

	// redirect if needed, otherwise display the user list
	public function index()
	{
		// mengambil data user yang login
		//$user = $this->ion_auth->user()->row();
        //$data['user_kd_unor'] = $user->kd_unor;

			$crud = new grocery_CRUD();
			
			$crud->set_language("indonesian");
			$crud->set_theme('bootstrap');

			//$crud->where('kd_unor',$this->uri->segment(3, 0));
			//$crud->like('kd_unor',$user->kd_unor);
			$crud->where("kd_stathkm = 14"); // pegawai baru

			$crud->set_table('pns');
			
			$crud->order_by('kd_unor','ASC');
            
            $crud->columns('nip','glrdpn','nama','glrblk','kd_kablhr','tgllhr','kd_sex','kd_agm','kd_statnkh','alamat','kdpos','telp','kd_gol','tmtgol','kd_unor','kd_tkpddk','kd_pddk','nm_sklh','thn_lls','nik','pic');
            $crud->display_as('nip','NIP')
            	 ->display_as('nama','NAMA')
            	 ->display_as('glrdpn','GELAR DPN')
            	 ->display_as('glrblk','GELAR BLK')
            	 ->display_as('kd_gol','GOL')
            	 ->display_as('tmtgol','TMT')
            	 ->display_as('kd_unor','UNIT KERJA')
            	 ->display_as('kd_kablhr','KAB LHR')
            	 ->display_as('tgllhr','TGL LHR')
            	 ->display_as('kd_sex','JENIS KEL')
            	 ->display_as('kd_agm','AGAMA')
            	 ->display_as('kd_statnkh','STATUS')
            	 ->display_as('kdpos','KODEPOS')
            	 ->display_as('telp','TELP')
            	 ->display_as('kd_tkpddk','PENDIDIKAN')
            	 ->display_as('kd_pddk','NAMA PEND')
            	 ->display_as('nm_sklh','SEKOLAH')
            	 ->display_as('thn_lls','LULUS')
            	 ->display_as('nik','NIK')
            	 ->display_as('pic','FOTO')
            	 ->display_as('alamat','ALAMAT');
            	 //->display_as('kd_dikpim','DIKLATPIM')
            	 //->display_as('thn_dikpim','TAHUN')
            	 //->display_as('stat_data','STATUS DATA')
            	 //->display_as('item_salah','ITEM SALAH')
            	 //->display_as('ket_salah','KET SALAH')
            	 //->display_as('kd_jnsjab','JENIS JAB');

            $crud->fields('pic','nip','glrdpn','nama','glrblk','kd_kablhr','tgllhr','kd_sex','kd_agm','kd_statnkh','alamat','kdpos','telp','kd_gol','tmtgol','kd_unor','kd_tkpddk','kd_pddk','nm_sklh','thn_lls','nik');
            
            $crud->set_relation('kd_kablhr','refkab','nm_kab');
            $crud->set_relation('kd_sex','refsex','nm_sex');
            $crud->set_relation('kd_agm','refagm','nm_agm');
            $crud->set_relation('kd_statnkh','refstatnkh','nm_statnkh');
            $crud->set_relation('kd_tkpddk','reftkpddk','nm_tkpddk');
            $crud->set_relation('kd_pddk','refpddk','nm_pddk');
            $crud->set_relation('kd_jabfung','refjabfung','nm_jabfung');
            $crud->set_relation('kd_unor','refunor','nm_skpd');
            $crud->set_relation('kd_gol','refgol','nm_gol');
            $crud->set_relation('kd_jnsjab','refjnsjab','nm_jnsjab');
            //$crud->set_relation('kd_dikpim','refdikpim','nm_dikpim');
            //$crud->set_relation('kd_jnsjab','refjnsjab','nm_jnsjab');

            //$crud->field_type('stat_data','dropdown',array('1' => 'BENAR', '2' => 'SALAH'));
            $crud->required_fields('pic','kd_sex','kd_agm','kd_statnkh','alamat','kdpos','telp','kd_tkpddk','kd_pddk','nm_sklh','thn_lls','nik');

            //$crud->callback_edit_field('nip',array($this,'edit_nip_callback'));
            //$crud->callback_edit_field('glrdpn',array($this,'edit_glrdpn_callback'));
            //$crud->callback_edit_field('nama',array($this,'edit_nama_callback'));
            //$crud->callback_edit_field('glrblk',array($this,'edit_glrblk_callback'));
            //$crud->callback_edit_field('kd_gol',array($this,'edit_kd_gol_callback'));
            //$crud->callback_edit_field('tmtgol',array($this,'edit_tmtgol_callback'));
            //$crud->callback_edit_field('kd_unor',array($this,'edit_kd_unor_callback'));
            //$crud->callback_edit_field('kd_dikpim',array($this,'edit_kd_dikpim_callback'));
            //$crud->callback_edit_field('thn_dikpim',array($this,'edit_thn_dikpim_callback'));

            $crud->set_field_upload('pic','assets/uploads/photopns');

            $crud->field_type('nip','readonly');
            $crud->field_type('glrdpn','readonly');
            $crud->field_type('nama','readonly');
            $crud->field_type('glrblk','readonly');
            $crud->field_type('kd_gol','readonly');
            $crud->field_type('kd_kablhr','readonly');
            $crud->field_type('tgllhr','readonly');
            $crud->field_type('kd_gol','readonly');
            $crud->field_type('tmtgol','readonly');
            $crud->field_type('kd_unor','readonly');

            $crud->unset_jquery();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->unset_read();
            $crud->unset_export();
            $crud->unset_print();
            
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
		$this->load->view('new/sidebar',$data);
		$this->load->view('new/datainduk_datainti_content',$output);
		$this->load->view('footer_gc');             
    }
	public function rwypend()
    {
		// mengambil data user yang login
		$user = $this->ion_auth->user()->row();
        $data['fname'] = $user->first_name;
        $data['lname'] = $user->last_name;
        $data['company'] = $user->company;
        $data['user_kd_unor'] = $user->kd_unor;
		
		$this->load->model('new/Datainduk_model', '', TRUE);
		$get_pns_baru = $this->Datainduk_model->get_pns_baru();
		$data['get_pns_baru'] = $get_pns_baru->result();

		//$output->data = $data;

		//$this->load->helper('url');
		$this->load->view('header_table');
		$this->load->view('new/sidebar',$data);
		$this->load->view('new/datainduk_rwypddk_content',$data);
		$this->load->view('footer_table');
		$this->load->view('new/datainduk_rwypddk_script_content');             
    }
    public function rwypend_entri()
    {
    		$crud = new grocery_CRUD();
			
			$crud->set_language("indonesian");
			$crud->set_theme('bootstrap');

			//$crud->where('kd_unor',$this->uri->segment(3, 0));
			//$crud->like('kd_unor',$user->kd_unor);

			$get_uri = explode('-',$this->uri->segment(4, 0));
			$crud->where("pns_id = $get_uri[0]"); // pegawai baru

			$crud->set_table('rwypddk');
			
			$crud->order_by('kd_tkpddk','ASC');

           	$crud->columns('pns_id','kd_tkpddk','jur','lembaga','thn_lls');

           	$crud->display_as('pns_id','ID')
            	 ->display_as('kd_tkpddk','TINGKAT')
            	 ->display_as('jur','JURUSAN')
            	 ->display_as('lembaga','LEMBAGA')
            	 ->display_as('thn_lls','TAHUN');

           	$crud->fields('pns_id','kd_tkpddk','jur','lembaga','thn_lls');
            
            $crud->set_relation('kd_tkpddk','reftkpddk','nm_tkpddk');

            $crud->required_fields('pns_id','kd_tkpddk','jur','lembaga','thn_lls');

            $crud->callback_edit_field('pns_id',array($this,'edit_pns_id_callback'));
            $crud->callback_add_field('pns_id',array($this,'add_pns_id_callback'));

            $crud->unset_jquery();
            //$crud->unset_add();
            //$crud->unset_delete();
            $crud->unset_read();
            $crud->unset_export();
            $crud->unset_print();
            
            //$crud->field_type('pns_id','readonly',null);
 
        $output = $crud->render();
        $this->_rwypend_entri_output($output);
    }
	public function _rwypend_entri_output($output = null)
    {
		// mengambil data user yang login
		$user = $this->ion_auth->user()->row();
        $data['fname'] = $user->first_name;
        $data['lname'] = $user->last_name;
        $data['company'] = $user->company;
        $data['user_kd_unor'] = $user->kd_unor;
		
		$output->data = $data;

		//$this->load->helper('url');
		$this->load->view('header_gc',$output);
		$this->load->view('new/sidebar',$data);
		$this->load->view('new/datainduk_rwypddk_entri_content',$output);
		$this->load->view('footer_gc');             
    }
   	public function rwyistri()
    {
		// mengambil data user yang login
		$user = $this->ion_auth->user()->row();
        $data['fname'] = $user->first_name;
        $data['lname'] = $user->last_name;
        $data['company'] = $user->company;
        $data['user_kd_unor'] = $user->kd_unor;
		
		$this->load->model('new/Datainduk_model', '', TRUE);
		$get_pns_baru = $this->Datainduk_model->get_pns_baru();
		$data['get_pns_baru'] = $get_pns_baru->result();

		//$output->data = $data;

		//$this->load->helper('url');
		$this->load->view('header_table');
		$this->load->view('new/sidebar',$data);
		$this->load->view('new/datainduk_rwyistri_content',$data);
		$this->load->view('footer_table');
		$this->load->view('new/datainduk_rwypddk_script_content');             
    }
    public function rwyistri_entri()
    {
    		$crud = new grocery_CRUD();
			
			$crud->set_language("indonesian");
			$crud->set_theme('bootstrap');

			//$crud->where('kd_unor',$this->uri->segment(3, 0));
			//$crud->like('kd_unor',$user->kd_unor);

			$get_uri = explode('-',$this->uri->segment(4, 0));
			$crud->where("pns_id = $get_uri[0]"); // pegawai baru

			$crud->set_table('rwyistri');
			
			$crud->order_by('tgl_nkh','ASC');

           	$crud->columns('pns_id','nama','tgllhr','kab_lhr','profesi','tgl_nkh','nm_tkpddk');

           	$crud->display_as('pns_id','ID')
            	 ->display_as('nama','NAMA')
            	 ->display_as('tgllhr','TGL LAHIR')
            	 ->display_as('kab_lhr','TEMPAT LAHIR')
            	 ->display_as('profesi','PROFESI')
            	 ->display_as('tgl_nkh','TGL NIKAH')
            	 ->display_as('nm_tkpddk','TINGKAT PEND')
            	 ;

           	$crud->fields('pns_id','nama','tgllhr','kab_lhr','profesi','tgl_nkh','nm_tkpddk');

           	$crud->required_fields('pns_id','nama','tgllhr','kab_lhr','profesi','tgl_nkh','nm_tkpddk');
            
            //$crud->set_relation('kd_tkpddk','reftkpddk','nm_tkpddk');

            $crud->callback_edit_field('pns_id',array($this,'edit_pns_id_callback'));
            $crud->callback_add_field('pns_id',array($this,'add_pns_id_callback'));

            $crud->unset_jquery();
            //$crud->unset_add();
            //$crud->unset_delete();
            $crud->unset_read();
            $crud->unset_export();
            $crud->unset_print();
            
            //$crud->field_type('pns_id','readonly',null);
 
        $output = $crud->render();
        $this->_rwyistri_entri_output($output);
    }
	public function _rwyistri_entri_output($output = null)
    {
		// mengambil data user yang login
		$user = $this->ion_auth->user()->row();
        $data['fname'] = $user->first_name;
        $data['lname'] = $user->last_name;
        $data['company'] = $user->company;
        $data['user_kd_unor'] = $user->kd_unor;
		
		$output->data = $data;

		//$this->load->helper('url');
		$this->load->view('header_gc',$output);
		$this->load->view('new/sidebar',$data);
		$this->load->view('new/datainduk_rwyistri_entri_content',$output);
		$this->load->view('footer_gc');             
    }
   	public function rwyanak()
    {
		// mengambil data user yang login
		$user = $this->ion_auth->user()->row();
        $data['fname'] = $user->first_name;
        $data['lname'] = $user->last_name;
        $data['company'] = $user->company;
        $data['user_kd_unor'] = $user->kd_unor;
		
		$this->load->model('new/Datainduk_model', '', TRUE);
		$get_pns_baru = $this->Datainduk_model->get_pns_baru();
		$data['get_pns_baru'] = $get_pns_baru->result();

		//$output->data = $data;

		//$this->load->helper('url');
		$this->load->view('header_table');
		$this->load->view('new/sidebar',$data);
		$this->load->view('new/datainduk_rwyanak_content',$data);
		$this->load->view('footer_table');
		$this->load->view('new/datainduk_rwypddk_script_content');             
    }
    public function rwyanak_entri()
    {
    		$crud = new grocery_CRUD();
			
			$crud->set_language("indonesian");
			$crud->set_theme('bootstrap');

			//$crud->where('kd_unor',$this->uri->segment(3, 0));
			//$crud->like('kd_unor',$user->kd_unor);

			$get_uri = explode('-',$this->uri->segment(4, 0));
			$crud->where("pns_id = $get_uri[0]"); // pegawai baru

			$crud->set_table('rwyanak');
			
			$crud->order_by('tgllhr','ASC');

           	$crud->columns('pns_id','nama','tgllhr','kablhr','status','sex');

           	$crud->display_as('pns_id','ID')
            	 ->display_as('nama','NAMA')
            	 ->display_as('tgllhr','TGL LAHIR')
            	 ->display_as('kablhr','TEMPAT LAHIR')
            	 ->display_as('status','STATUS')
            	 ->display_as('sex','JNS KELAMIN')
            	 //->display_as('nm_tkpddk','TINGKAT PEND')
            	 ;

           	$crud->fields('pns_id','nama','tgllhr','kablhr','status','sex');
            
            //$crud->set_relation('kd_tkpddk','reftkpddk','nm_tkpddk');

            $crud->required_fields('pns_id','nama','tgllhr','kablhr','status','sex');

            $crud->callback_edit_field('pns_id',array($this,'edit_pns_id_callback'));
            $crud->callback_add_field('pns_id',array($this,'add_pns_id_callback'));

            $crud->unset_jquery();
            //$crud->unset_add();
            //$crud->unset_delete();
            $crud->unset_read();
            $crud->unset_export();
            $crud->unset_print();
            
            //$crud->field_type('pns_id','readonly',null);
 
        $output = $crud->render();
        $this->_rwyanak_entri_output($output);
    }
	public function _rwyanak_entri_output($output = null)
    {
		// mengambil data user yang login
		$user = $this->ion_auth->user()->row();
        $data['fname'] = $user->first_name;
        $data['lname'] = $user->last_name;
        $data['company'] = $user->company;
        $data['user_kd_unor'] = $user->kd_unor;
		
		$output->data = $data;

		//$this->load->helper('url');
		$this->load->view('header_gc',$output);
		$this->load->view('new/sidebar',$data);
		$this->load->view('new/datainduk_rwyanak_entri_content',$output);
		$this->load->view('footer_gc');             
    }

    public function edit_pns_id_callback($value, $primary_key) {
    	//$get_uri = explode('-',$this->uri->segment(4, 0));
		return '<input type="text" value="'.$value.'" name="pns_id" readonly>';
	}
	public function add_pns_id_callback($value, $primary_key) {
    	$get_uri = explode('-',$this->uri->segment(4, 0));
		return '<input type="text" value="'.$get_uri[0].'" name="pns_id" readonly>';
	}

}