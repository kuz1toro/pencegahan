<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Disposisi extends CI_Controller {

	/**
	* name of the folder responsible for the views
	* which are manipulated by this controller
	* @constant string
	*/
	const VIEW_FOLDER = 'disposisi';

	/* pagination setting */
	private $per_page = 8;

	/**
	* Responsable for auto load the model
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->model('permohonan_model');
		$this->load->model('gedung_model');
		$this->load->library(array('ion_auth','form_validation'));
		$this->config->load('pagination', TRUE);
		$this->load->helper('site_helper');

		if ( ! $this->ion_auth->in_group('disposisi'))
		{
			redirect('auth/logout');
		}
	}

	public function home()
	{
		$this->load->view('disposisi/includes/header');
		$this->load->view('disposisi/home');
		$this->load->view('disposisi/includes/footer');
	}

	public function list_gedung()
	{
		//load gedung library
		$this->load->library('gedung');
		//all the posts sent by the view
		$search_string = $this->input->post('search_string');
		$search_in = $this->input->post('search_in');
		$order = $this->input->post('order');
		$order_type = $this->input->post('order_type');
		//console_log( var_dump($order_type) );

		//pagination settings
		$config['per_page'] = $this->per_page;
		$config['base_url'] = base_url().'disposisi/list_gedung';

		//limit end
		$page = $this->uri->segment(3);

		//use gedung lib untuk paginasi
		$data = $this->gedung->list_gedung($search_string, $search_in, $order, $order_type, $this->uri->segment(3), $config['per_page']);

		$config['total_rows'] = $data['count_gedungs'];

		//initializate the panination helper
		$this->pagination->initialize($config);

		//load the view
		$data['main_content'] = 'disposisi/gedung/list';
		$this->load->view('disposisi/includes/template', $data);

	}//list gedung

	public function update_gedung()
	{
		//product id
		$id = $this->uri->segment(3);

		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			//form validation
			$this->form_validation->set_rules('NamaGedung', 'NamaGedung', 'required');
			$this->form_validation->set_rules('Alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('Status', 'Status', 'required');
			$this->form_validation->set_rules('Fungsi', 'Fungsi', 'required');
			$this->form_validation->set_rules('JmlMasaBang', 'JmlMasaBang', 'required');
			$this->form_validation->set_rules('Lantai', 'Lantai', 'required');
			$this->form_validation->set_rules('Basement', 'Basement', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
			//if the form has passed through the validation
			if ($this->form_validation->run())
			{

				$data_to_store = array(
					'NamaGedung' => $this->input->post('NamaGedung'),
					'Alamat' => $this->input->post('Alamat'),
					'Kecamatan' => $this->input->post('Kecamatan'),
					'Kelurahan' => $this->input->post('Kelurahan'),
					'Wilayah' => $this->input->post('Wilayah'),
					'KodePos' => $this->input->post('KodePos'),
					'NoImb' => $this->input->post('NoImb'),
					'TglImb' => htmlDate2sqlDate($this->input->post('TglImb')),
					'NoRekomtekAkhir' => $this->input->post('NoRekomtekAkhir'),
					'TglRekomtekAkhir' => htmlDate2sqlDate($this->input->post('TglRekomtekAkhir')),
					'NoSlfAkhir' => $this->input->post('NoSlfAkhir'),
					'TglSlfAkhir' => htmlDate2sqlDate($this->input->post('TglSlfAkhir')),
					'NoSkkAkhir' => $this->input->post('NoSkkAkhir'),
					'TglSkkAkhir' => htmlDate2sqlDate($this->input->post('TglSkkAkhir')),
					'NoLhp' => $this->input->post('NoLhp'),
					'TglLhp' => htmlDate2sqlDate($this->input->post('TglLhp')),
					'Status' => $this->input->post('Status'),
					'Fungsi' => $this->input->post('Fungsi'),
					'JmlMasaBang' => $this->input->post('JmlMasaBang'),
					'Lantai' => $this->input->post('Lantai'),
					'LuasLantai' => $this->input->post('LuasLantai'),
					'Basement' => $this->input->post('Basement'),
					'Keterangan' => $this->input->post('Keterangan')
				);
				//if the insert has returned true then we show the flash message
				if($this->gedung_model->update_gedung($id, $data_to_store)){
					$this->session->set_flashdata('flash_message', 'updated');
				}else{
					$this->session->set_flashdata('flash_message', 'not_updated');
				}
				redirect('disposisi/update_gedung/'.$id.'');

			}//validation run

		}

		//if we are updating, and the data did not pass trough the validation
		//the code below wel reload the current data

		//product data
		$data['gedungs'] = $this->gedung_model->get_gedung_by_id($id);
		//load the view
		$data['main_content'] = 'disposisi/gedung/edit';
		$this->load->view('disposisi/includes/template', $data);

	}//update

	public function add_gedung()
	{
		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{

			//form validation
			$this->form_validation->set_rules('NamaGedung', 'NamaGedung', 'required');
			$this->form_validation->set_rules('Alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('Status', 'Status', 'required');
			$this->form_validation->set_rules('Fungsi', 'Fungsi', 'required');
			$this->form_validation->set_rules('JmlMasaBang', 'JmlMasaBang', 'required');
			$this->form_validation->set_rules('Lantai', 'Lantai', 'required');
			$this->form_validation->set_rules('Basement', 'Basement', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

			//$tglImb = $this->input->post('TglImb');
			//$tgl_imb = date('Y-m-d',strtotime("$tglImb"));


			//if the form has passed through the validation
			if ($this->form_validation->run())
			{
				$data_to_store = array(
					'NamaGedung' => $this->input->post('NamaGedung'),
					'Alamat' => $this->input->post('Alamat'),
					'Kecamatan' => $this->input->post('Kecamatan'),
					'Kelurahan' => $this->input->post('Kelurahan'),
					'Wilayah' => $this->input->post('Wilayah'),
					'KodePos' => $this->input->post('KodePos'),
					'NoImb' => $this->input->post('NoImb'),
					'TglImb' => htmlDate2sqlDate($this->input->post('TglImb')),
					'NoRekomtekAkhir' => $this->input->post('NoRekomtekAkhir'),
					'TglRekomtekAkhir' => htmlDate2sqlDate($this->input->post('TglRekomtekAkhir')),
					'NoSlfAkhir' => $this->input->post('NoSlfAkhir'),
					'TglSlfAkhir' => htmlDate2sqlDate($this->input->post('TglSlfAkhir')),
					'NoSkkAkhir' => $this->input->post('NoSkkAkhir'),
					'TglSkkAkhir' => htmlDate2sqlDate($this->input->post('TglSkkAkhir')),
					'NoLhp' => $this->input->post('NoLhp'),
					'TglLhp' => htmlDate2sqlDate($this->input->post('TglLhp')),
					'Status' => $this->input->post('Status'),
					'Fungsi' => $this->input->post('Fungsi'),
					'JmlMasaBang' => $this->input->post('JmlMasaBang'),
					'Lantai' => $this->input->post('Lantai'),
					'LuasLantai' => $this->input->post('LuasLantai'),
					'Basement' => $this->input->post('Basement'),
					'Keterangan' => $this->input->post('Keterangan')
				);
				//if the insert has returned true then we show the flash message
				if($this->gedung_model->store_gedung($data_to_store)){
					//$data['flash_message'] = TRUE;
					$this->session->set_flashdata('flash_message', 'added');
					$per_page = $this->per_page;
					$num_buiding = $this->gedung_model->count_gedung();
					$page = ceil($num_buiding/$per_page);
					redirect('disposisi/list_gedung/'.$page.'');
				}else{
					$this->session->set_flashdata('flash_message', 'not added');
				}

			}

		}
		//load the view
		$data['main_content'] = 'disposisi/gedung/add';
		$this->load->view('disposisi/includes/template', $data);
	}

	/**
	* Delete gedung by his id
	* @return void
	*/
	public function delete_gedung()
	{
		//product id
		$id = $this->uri->segment(3);
		if ($this->gedung_model->delete_gedung($id)){
			$this->session->set_flashdata('flash_message', 'deleted');
			$per_page = $this->per_page;
			$num_buiding = $this->gedung_model->count_gedung();
			$page = ceil($num_buiding/$per_page);
			redirect('disposisi/list_gedung/'.$page.'');
		}else{
			$this->session->set_flashdata('flash_message', 'not deleted');
		}
	}//delete

	/**
	* Load the main view with all the current model model's data.
	* @return void
	*/
	public function monitoring()
	{	$this->load->library('disposisi_permohonan');
		$for = 'monitoring';
		//all the posts sent by the view
		$search_string = $this->input->post('search_string');
		$search_in = $this->input->post('search_in');
		$order = $this->input->post('order');
		$order_type = $this->input->post('order_type');

		//pagination settings
		$config['per_page'] = $this->per_page;
		$config['base_url'] = base_url().'disposisi/monitoring';

		//limit end
		$page = $this->uri->segment(3);

		//use gedung lib untuk paginasi
		$data = $this->disposisi_permohonan->list_permohonan($search_string, $search_in, $order, $order_type, $this->uri->segment(3), $config['per_page'], $for);

		$config['total_rows'] = $data['count_permohonans'];

		//initializate the panination helper
		$this->pagination->initialize($config);

		//load the view
		$data['main_content'] = 'disposisi/permohonan/monitoring';
		$this->load->view('disposisi/includes/template', $data);
	}//monitoring

	public function update()
	{
		//product id
		$id = $this->uri->segment(3);

		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			//form validation
			$this->form_validation->set_rules('NamaPengelola', 'NamaPengelola', 'required');
			//$this->form_validation->set_rules('NoPermhn', 'NoPermhn', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
			//if the form has passed through the validation
			if ($this->form_validation->run())
			{
				$data_to_store = array(
					'NamaPengelola' => $this->input->post('NamaPengelola'),
					'KetPrainspeksi' => $this->input->post('KetPrainspeksi'),
					'NoTelpPengelola' => $this->input->post('NoTelpPengelola'),
					'AlamatPengelola' => $this->input->post('AlamatPengelola'),
					'NoPermhn' => $this->input->post('NoPermhn'),
					'TglSuratDiterima' => htmlDate2sqlDate($this->input->post('TglSuratDiterima')),
					'TglPermhn' => htmlDate2sqlDate($this->input->post('TglPermhn')),
					'TipePermhn' => $this->input->post('TipePermhn'),
					'SuratPermohonan' => $this->input->post('SuratPermohonan'),
					'DokTeknisGedung' => $this->input->post('DokTeknisGedung'),
					'DokInventarisApar' => $this->input->post('DokInventarisApar'),
					'DokMKKG' => $this->input->post('DokMKKG'),
					'FtcpGambarSchematic' => $this->input->post('FtcpGambarSchematic'),
					'FtcpSiteplan' => $this->input->post('FtcpSiteplan'),
					'FtcpRkkSlf' => $this->input->post('FtcpRkkSlf'),
					'FtcpIMB' => $this->input->post('FtcpIMB'),
					'FtcpSkkAkhir' => $this->input->post('FtcpSkkAkhir'),
					'TglDisKadis' => htmlDate2sqlDate($this->input->post('TglDisKadis')),
					'TglDisKabid' => htmlDate2sqlDate($this->input->post('TglDisKabid')),
					'TglDisKasi' => htmlDate2sqlDate($this->input->post('TglDisKasi')),
					'TglPerbalST' => htmlDate2sqlDate($this->input->post('TglPerbalST')),
					'Pokja' => $this->input->post('Pokja'),
					'KaInsp' => $this->input->post('KaInsp'),
					'StatusPermhn' => $this->input->post('StatusPermhn')
				);
				//if the insert has returned true then we show the flash message
				if($this->permohonan_model->update_permohonan($id, $data_to_store) == TRUE){
					$this->session->set_flashdata('flash_message', 'updated');
					//redirect('disposisi/permohonan');
				}else{
					$this->session->set_flashdata('flash_message', 'not_updated');
				}
				redirect('disposisi/update/'.$id.'');

			}//validation run

		}

		//if we are updating, and the data did not pass trough the validation
		//the code below wel reload the current data

		//product data
		//$data['manufacture'] = $this->permohonan_model->get_permohonan_dan_gedung_by_id($id);
		$data['permohonan'] = $this->permohonan_model->get_permohonan_by_id($id);
		$data['gedung'] = $this->gedung_model->get_gedung_by_id($data['permohonan'][0]['NamaGedung_id']);
		//load the view
		$data['main_content'] = 'disposisi/permohonan/edit';
		$this->load->view('disposisi/includes/template', $data);

	}//update

	/**
	* Delete product by his id
	* @return void
	*/
	public function delete()
	{
		//product id
		$id = $this->uri->segment(3);
		if ($this->permohonan_model->delete_permohonan($id)){
			$this->session->set_flashdata('flash_message', 'deleted');
			$per_page = $this->per_page;
			$num_permohonan = $this->permohonan_model->count_permohonan();
			$page = ceil($num_permohonan/$per_page);
			redirect('disposisi/monitoring/'.$page.'');
		}
	}//delete

	public function Add_disposisi_step1()
	{
		//all the posts sent by the view
		$this->load->library('disposisi_permohonan');
		$for = 'disposisi';
		//all the posts sent by the view
		$search_string = $this->input->post('search_string');
		$search_in = $this->input->post('search_in');
		$order = $this->input->post('order');
		$order_type = $this->input->post('order_type');

		//pagination settings
		$config['per_page'] = $this->per_page;
		$config['base_url'] = base_url().'disposisi/Add_disposisi_step1';

		//limit end
		$page = $this->uri->segment(3);

		//use gedung lib untuk paginasi
		$data = $this->disposisi_permohonan->list_permohonan($search_string, $search_in, $order, $order_type, $this->uri->segment(3), $config['per_page'], $for);

		$config['total_rows'] = $data['count_permohonans'];

		//initializate the panination helper
		$this->pagination->initialize($config);

		//load the view
		$data['main_content'] = 'disposisi/permohonan/step1';
		$this->load->view('disposisi/includes/template', $data);

	}

	public function Add_disposisi_step2()
	{
		//product id
		$id = $this->uri->segment(3);
		$data['permhn_n_gedung'] = $this->permohonan_model->get_permohonan_dan_gedung_by_id($id);
		//load the view
		$data['main_content'] = 'disposisi/permohonan/step2';
		$this->load->view('disposisi/includes/template', $data);
	}

	public function Add_disposisi_step3()
	{
		//echo "step 333333";
		//product id
		//$id = $this->uri->segment(4);
		//$id = "33";
		//$id = (string)$this->input->post('No_id');
		//$data['manufacture'] = $this->gedung_model->get_gedung_by_id($id);
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			//form validation
			$this->form_validation->set_rules('Pokja', 'Pokja', 'required');
			//$this->form_validation->set_rules('TglDisKabid', 'TglDisKabid', 'required');
			//$this->form_validation->set_rules('Kecamatan', 'Kecamatan', 'required');
			//$this->form_validation->set_rules('Kelurahan', 'Kelurahan', 'required');
			//$this->form_validation->set_rules('Wilayah', 'Wilayah', 'required');
			//$this->form_validation->set_rules('NoImb', 'NoImb', 'required');
			//$this->form_validation->set_rules('TglImb', 'TglImb', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');


			//if the form has passed through the validation
			if ($this->form_validation->run())
			{
				$data_to_store = array(
					'TglDisKadis' => htmlDate2sqlDate($this->input->post('TglDisKadis')),
					'TglDisKabid' => htmlDate2sqlDate($this->input->post('TglDisKabid')),
					'TglDisKasi' => htmlDate2sqlDate($this->input->post('TglDisKasi')),
					'TglPerbalST' => htmlDate2sqlDate($this->input->post('TglPerbalST')),
					'Pokja' => $this->input->post('Pokja'),
					'KaInsp' => $this->input->post('KaInsp'),
					'StatusPermhn' => $this->input->post('StatusPermhn')
				);
				$id = $this->input->post('No_id');
				//if the insert has returned true then we show the flash message
				if($this->permohonan_model->update_permohonan($id, $data_to_store) == TRUE){
					$data['myflash_message'] = TRUE;
				}else{
					$data['myflash_message'] = FALSE;
				}

			}

		}
		//load the view
		$data['main_content'] = 'disposisi/permohonan/result';
		$this->load->view('disposisi/includes/mytemplate', $data);
		//redirect('prainspeksi/Add_lhp_step1');
	}

	public function tes()
	{
		if((true && false)|| (true && false)){
			$var='true';
		}else{ $var='false';}
		$data['tes'] = $var;
		$data['main_content'] = 'disposisi/tes';
		$this->load->view('disposisi/includes/template', $data);
	}

	public function validasi()
	{

		//all the posts sent by the view
		$search_string = $this->input->post('search_string');
		$search_in = $this->input->post('search_in');
		$order = $this->input->post('order');
		$order_type = $this->input->post('order_type');

		//pagination settings
		$config['per_page'] = $this->per_page;

		$config['base_url'] = base_url().'disposisi/validasi';
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 10;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><span>';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_link'] = '&laquo;';
		$config['prev_link'] = '&lsaquo;';
		$config['last_link'] = '&raquo;';
		$config['next_link'] = '&rsaquo;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		//limit end
		$page = $this->uri->segment(3);

		//math to get the initial record to be select in the database
		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0){
			$limit_end = 0;
		}

		//if order type was changed
		if($order_type){
			$filter_session_data['order_type'] = $order_type;
		}
		else{
			//we have something stored in the session?
			if($this->session->userdata('order_type')){
				$order_type = $this->session->userdata('order_type');
			}else{
				//if we have nothing inside session, so it's the default "Asc"
				$order_type = 'Asc';
			}
		}
		//make the data type var avaible to our view
		$data['order_type_selected'] = $order_type;


		//we must avoid a page reload with the previous session data
		//if any filter post was sent, then it's the first time we load the content
		//in this case we clean the session filter data
		//if any filter post was sent but we are in some page, we must load the session data

		//filtered && || paginated
		if($search_string !== false && $order !== false || $this->uri->segment(3) == true){

			/*
			The comments here are the same for line 79 until 99

			if post is not null, we store it in session data array
			if is null, we use the session data already stored
			we save order into the the var to load the view with the param already selected
			*/
			if($search_string){
				$filter_session_data['search_string_selected'] = $search_string;
				$filter_session_data['search_in_field'] = $search_in;
			}else{
				$search_string = $this->session->userdata('search_string_selected');
				$search_in = $this->session->userdata('search_in_field');
			}
			$data['search_string_selected'] = $search_string;
			$data['search_in_field'] = $search_in;

			if($order){
				$filter_session_data['order'] = $order;
			}
			else{
				$order = $this->session->userdata('order');
			}
			$data['order'] = $order;

			//save session data into the session
			if(isset($filter_session_data)){
				$this->session->set_userdata($filter_session_data);
			}

			//fetch sql data into arrays
			$data['count_products']= $this->permohonan_model->count_permohonan_disposisi($search_string, $search_in, $order, 'validasi');
			$config['total_rows'] = $data['count_products'];

			//fetch sql data into arrays
			if($search_string){
				if($order){
					$data['manufacturers'] = $this->permohonan_model->get_permohonan_disposisi($search_string, $search_in, $order, $order_type, $config['per_page'],$limit_end, 'validasi');
				}else{
					$data['manufacturers'] = $this->permohonan_model->get_permohonan_disposisi($search_string, $search_in, '', $order_type, $config['per_page'],$limit_end, 'validasi');
				}
			}else{
				if($order){
					$data['manufacturers'] = $this->permohonan_model->get_permohonan_disposisi('', $search_in, $order, $order_type, $config['per_page'],$limit_end, 'validasi');
				}else{
					$data['manufacturers'] = $this->permohonan_model->get_permohonan_disposisi('', $search_in, '', $order_type, $config['per_page'],$limit_end, 'validasi');
				}
			}

		}else{

			//clean filter data inside section
			$filter_session_data['manufacture_selected'] = null;
			$filter_session_data['search_string_selected'] = null;
			$filter_session_data['search_in_field'] = null;
			$filter_session_data['order'] = null;
			$filter_session_data['order_type'] = null;
			$this->session->set_userdata($filter_session_data);

			//pre selected options
			$data['search_string_selected'] = '';
			$data['search_in_field'] = 'NamaPengelola';
			$data['order'] = 'id';

			//fetch sql data into arrays
			$data['count_products']= $this->permohonan_model->count_permohonan_disposisi('','','', 'validasi');
			$data['manufacturers'] = $this->permohonan_model->get_permohonan_disposisi('', 'NamaPengelola', '', $order_type, $config['per_page'],$limit_end, 'validasi');
			$config['total_rows'] = $data['count_products'];

		}//!isset($search_string) && !isset($order)

		//initializate the panination helper
		$this->pagination->initialize($config);

		//load the view
		$data['main_content'] = 'disposisi/permohonan/validasi';
		$this->load->view('disposisi/includes/template', $data);

	}

	public function validasi_step2()
	{
		//product id
		$id = $this->uri->segment(4);
		$data['manufacture'] = $this->permohonan_model->get_permohonan_dan_gedung_by_id($id);
		//load the view
		$data['main_content'] = 'disposisi/permohonan/validasi_step2';
		$this->load->view('disposisi/includes/template', $data);
	}

	public function validasi_step3()
	{
		//echo "step 333333";
		//product id
		//$id = $this->uri->segment(4);
		//$id = "33";
		//$id = (string)$this->input->post('No_id');
		//$data['manufacture'] = $this->gedung_model->get_gedung_by_id($id);
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			//form validation
			$this->form_validation->set_rules('StatusPermhn', 'StatusPermhn', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');


			//if the form has passed through the validation
			if ($this->form_validation->run())
			{
				$data_to_store = array(
					'StatusPermhn' => $this->input->post('StatusPermhn')

				);
				$id = $this->input->post('No_id');
				//if the insert has returned true then we show the flash message
				if($this->permohonan_model->update_permohonan($id, $data_to_store) == TRUE){
					$this->session->set_flashdata('flash_message', 'updated');
					$data['myflash_message'] = TRUE;
				}else{
					$this->session->set_flashdata('flash_message', 'not_updated');
					$data['myflash_message'] = FALSE;
				}

			}

		}
		//load the view
		$data['main_content'] = 'disposisi/permohonan/result_validasi';
		$this->load->view('disposisi/includes/template', $data);
		//redirect('prainspeksi/Add_lhp_step1');
	}

	public function validasi_yes()
	{
		$id = $this->uri->segment(3);
		$StatusPermhn = '5';
		$data_to_store = array(
			'StatusPermhn' => $StatusPermhn
		);
		if($this->permohonan_model->update_permohonan($id, $data_to_store) == TRUE){
			$this->session->set_flashdata('flash_message', 'updated');
		}else{
			$this->session->set_flashdata('flash_message', 'not_updated');
		}
		//$data['main_content'] = 'disposisi/validasi';
		//$this->load->view('disposisi/includes/mytemplate', $data);
		redirect('disposisi/validasi');
	}

	public function validasi_no()
	{
		$id = $this->uri->segment(3);
		$StatusPermhn = '3';
		$data_to_store = array(
			'StatusPermhn' => $StatusPermhn
		);
		if($this->permohonan_model->update_permohonan($id, $data_to_store) == TRUE){
			$this->session->set_flashdata('flash_message', 'updated');
		}else{
			$this->session->set_flashdata('flash_message', 'not_updated');
		}
		redirect('disposisi/validasi');
	}

	public function add_lantai()
	{
		$zero_lantai = $this->gedung_model->find_zero_lantai();
		foreach ($zero_lantai as $id)
		{
			$data_to_store = array(
				'Lantai' => '100'
			);
			$this->gedung_model->update_gedung($id['id'], $data_to_store);
		}
	}

}
