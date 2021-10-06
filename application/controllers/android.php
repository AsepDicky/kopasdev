<?php
Class Android extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("model_android");
	}

	public function get_data_profile_anggota()
	{
		$CIFNO = $this->uri->segment(3);
		if($CIFNO=="") $CIFNO='';
		$data['content'] = $this->model_android->get_data_profile_anggota($CIFNO);
        
        $this->load->view('android/ParseJSONcreator',$data);
		
	}

	public function insert_data_profile_anggota()
	{
		$cif_no = $this->uri->segment(3);
		$Tanggal = $this->uri->segment(4);
		$Deskripsi = $this->uri->segment(5);

		$data = array(
				'id' => uuid(false),
				'cif_no' => $cif_no,
				'date' => $Tanggal,
				'deskripsi' => $Deskripsi
			);

		$this->db->trans_begin();
		$this->model_android->insert_data_profile_anggota($data);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			echo "Profile Anggota Telah Disimpan";
		}else{
			$this->db->trans_rollback();
			echo "Something Wrong, We Will Going to Fixed as soon as !";
		}
	}

}
?>