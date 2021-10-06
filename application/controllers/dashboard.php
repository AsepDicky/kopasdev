<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model("model_dashboard");
	}

	public function index()
	{
		$date = date("Y-m-d"); //sekarang
		$tgl = date("Y-m-d", strtotime($date.'-2 day'));
		$branch_code			= $this->session->userdata('branch_code');
		$flag_all_branch		= $this->session->userdata('flag_all_branch');
		if($flag_all_branch==0)
		{
			$data['petugas']	= $this->model_dashboard->get_petugas($branch_code);
			$data['anggota']	= $this->model_dashboard->get_anggota($branch_code);
		}
		else
		{
			$data['petugas']		= $this->model_dashboard->get_all_petugas();
			$data['anggota']		= $this->model_dashboard->get_all_anggota();
		}
		$data['jumlah_pengajuan_pembiayaan'] = $this->model_dashboard->jumlah_pengajuan_pembiayaan();
		$data['jumlah_proses_pembiayaan'] = $this->model_dashboard->jumlah_proses_pembiayaan();
		$data['jumlah_cair_pembiayaan'] = $this->model_dashboard->jumlah_cair_pembiayaan();
		$data['outstanding'] = $this->model_dashboard->outstanding();
		$data['proses_terlambat'] = $this->model_dashboard->jumlah_proses_terlambat($tgl);
		$data['terlambat'] = $this->model_dashboard->sum_proses_terlambat($tgl);
		$data['view_terlambat'] = $this->model_dashboard->view_proses_terlambat($tgl);
		$data['view_pengajuan1'] = $this->model_dashboard->view_pengajuan_pembiayaan();
		$data['view_pengajuan2'] = $this->model_dashboard->view_proses_pembiayaan();
		$data['view_pengajuan3'] = $this->model_dashboard->view_cair_pembiayaan();
		$data['peruntukan'] = $this->model_dashboard->count_peruntukan();
		$data['rekenig_aktif'] = $this->model_dashboard->count_rekenig_aktif();
		$data['rembug']		= $this->model_dashboard->get_all_rembug();
		$data['container'] 	= 'd1';
		$data['show_unapproved'] = $this->model_dashboard->show_unapproved();
		$data['pengajuan_unapproved'] = $this->model_dashboard->jumlah_pengajuan_unapproved();
		$data['spb_unapproved'] = $this->model_dashboard->jumlah_spb_unapproved();
		$data['view_spb_unapproved'] = $this->model_dashboard->view_spb_unapproved();
		$data['view_pengajuan_unapproved'] = $this->model_dashboard->view_pengajuan_unapproved();

		//chart
		$data_chart		= $this->model_dashboard->chart_peruntukan();
			$rows = array();
			//flag is not needed
			$flag = true;
			$table = array();
			$table['cols'] = array(			 
			    // Labels for your chart, these represent the column titles
			    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
			    array('label' => 'people', 'type' => 'string'),
			    array('label' => 'total', 'type' => 'number')
			 
			);
			 
			$rows = array();
			for ($i=0; $i <count($data_chart) ; $i++) 
			{ 
			    $temp = array();
			    // the following line will be used to slice the Pie chart
			    $temp[] = array('v' => (string) $data_chart[$i]['display_text'].' ('.number_format($data_chart[$i]['count']).')');
			    // Values of each slice
			    $temp[] = array('v' => (float) $data_chart[$i]['count']);
			    $rows[] = array('c' => $temp);
			}
			 
			$table['rows'] = $rows;
			$data['jsonPie'] = json_encode($table);

		$data_chartColoum		= $this->model_dashboard->chart_product();
			$rows = array();
			//flag is not needed
			$flag = true;
			$table = array();
			$table['cols'] = array(			 
			    // Labels for your chart, these represent the column titles
			    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
			    array('label' => 'people', 'type' => 'string'),
			    array('label' => 'total', 'type' => 'number')
			 
			);
			 
			$rows = array();
			for ($i=0; $i <count($data_chartColoum) ; $i++) 
			{ 
			    $temp = array();
			    // the following line will be used to slice the Pie chart
			    $temp[] = array('v' => (string) $data_chartColoum[$i]['product_name'].' '.$data_chartColoum[$i]['count'].' Rekening'); 			 
			    // Values of each slice
			    $temp[] = array('v' => (float) $data_chartColoum[$i]['saldo_pokok']);
			    $rows[] = array('c' => $temp);
			}
			 
			$table['rows'] = $rows;
			$data['jsonColoum'] = json_encode($table);
		//end chart

		$this->load->view('core_d1',$data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */