<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 * lokasi : application/controllers/login.php
	 */

	private $_salt = 'microfinance';

	public function __construct()
	{
		parent::__construct(false);
	}

	public function index()
	{
		$this->load->view('login2');
	}

	public function authentication()
	{	
		$this->load->model('model_login');
		$deviceID = getDeviceID();
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if ($username==false) {
			$username = '';
		}
		if ($password==false) {
			$password = '';
		}

		$cek = $this->model_login->authentication($username,$password,$this->_salt);

		if($cek==true)
		{
			$cek['is_logged_in'] = true;

			$rcount = $this->model_login->get_user_device($cek['user_id'], $deviceID);

			if($rcount > 0)
			{
				$this->session->set_userdata($cek);
				redirect('dashboard');
			}else{
				$this->session->set_flashdata('login_message','Browser anda belum terdaftar, harap lapor ke Administrator !');
				redirect('login');
			}
		}
		else
		{
			$this->session->set_flashdata('login_message','Incorrect Username or Password !');
			redirect('login');
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */