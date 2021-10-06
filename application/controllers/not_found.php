<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Not_found extends CI_Controller {

	public function index()
	{
		$data['title']		= "Not Found";
		$data['container'] 	= '_404/not_found_';
		$this->load->view('core',$data);
	}
}

