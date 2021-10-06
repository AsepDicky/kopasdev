<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 * lokasi : application/controllers/Logout.php
	 */

	public function __construct()
	{
		parent::__construct(true);
		
        $this->session->sess_destroy();
		redirect('login','refresh');
	}
}

/* End of file Logout.php */
/* Location: ./application/controllers/Logout.php */