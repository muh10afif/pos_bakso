<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('username') == "")
        {
            $this->session->set_flashdata('danger', '<div class="alert alert-danger">Anda belum Log in</div>');
            redirect(base_url(), 'refresh');
		}
		
		$this->id_user = $this->session->userdata('id_user');
	}

	public function index()
	{
		$data 	= [
			'title'			=> 'Dashboard',
			'kategori'		=> $this->kategori->cari_data('mst_kategori', ['id_user' => $this->id_user])->num_rows(),
			'produk'		=> $this->produk->cari_data('mst_product', ['id_user' => $this->id_user])->num_rows(),
			'user'			=> $this->user->get()->num_rows(),
			'pendapatan'	=> $this->transaksi->get_total_hari_ini(),
			'dt_profit'		=> $this->transaksi->get_profit()->result(),
			'isi'			=> 'dashboard'
		];

		$this->load->view('template/wrapper', $data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */