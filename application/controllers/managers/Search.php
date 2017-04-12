<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

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
		elseif (!$this->ion_auth->in_group('managers')) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an Managers to view this page.');
		}
	}

	public function index()
	{
			//tampilkan halaman pencarian
			$user = $this->ion_auth->user()->row();
        	$data['fname'] = $user->first_name;
        	$data['lname'] = $user->last_name;
        	$data['company'] = $user->company;
        	$data['user_kd_unor'] = $user->kd_unor;

        	$this->load->model('managers/Search_model', '', TRUE);
			$get_cari = $this->Search_model->cari();
			$data['get_cari'] = $get_cari->result();


			$this->load->view('header_table',$data);
			$this->load->view('managers/sidebar');
			$this->load->view('managers/search_content',$data);
			$this->load->view('footer_table');
			$this->load->view('managers/search_footer_script');
	}
	public function profile()
	{
			$user = $this->ion_auth->user()->row();
        	$data['fname'] = $user->first_name;
        	$data['lname'] = $user->last_name;
        	$data['company'] = $user->company;
        	$data['user_kd_unor'] = $user->kd_unor; 

        	$this->load->model('managers/Search_model', '', TRUE);
			$get_profile = $this->Search_model->profile($this->uri->segment(4, 0));
			$data['get_profile'] = $get_profile->result();
			$get_rwyjab = $this->Search_model->riwayat($this->uri->segment(4, 0),'rwyjab','','ORDER BY tmt_jab DESC');
			$data['get_rwyjab'] = $get_rwyjab->result();
			$get_rwypddk = $this->Search_model->riwayat($this->uri->segment(4, 0),'rwypddk','LEFT JOIN reftkpddk ON rwypddk.kd_tkpddk=reftkpddk.kd_tkpddk', 'ORDER BY rwypddk.kd_tkpddk DESC');
			$data['get_rwypddk'] = $get_rwypddk->result();
			$get_rwydiklat = $this->Search_model->riwayat($this->uri->segment(4, 0),'rwydiklat','','ORDER BY tmt_diklat DESC');
			$data['get_rwydiklat'] = $get_rwydiklat->result();

			$this->load->view('header_table',$data);
			$this->load->view('managers/sidebar');
			$this->load->view('managers/search_profile_content',$data);
			$this->load->view('footer');
	}
	public function ajax_list()
	{
		$this->load->model('managers/Search_model');
		$list = $this->Search_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pns) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pns->pns_id;
			$row[] = $pns->nip;
			$row[] = $pns->nmglr;
			$row[] = $pns->nm_skpd_p;
			$row[] = $pns->nm_gol;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						//"recordsTotal" => $this->Search_model->count_all(),
						//"recordsFiltered" => $this->Search_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

}
