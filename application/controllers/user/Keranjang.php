<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('log_user'))) {
			$this->session->set_flashdata('toastr-eror', 'Anda Belum Login');
			redirect('auth', 'refresh');
		}

		$this->db->where('id', $this->session->userdata('id'));
		$this->dt_user = $this->db->get('user')->row();

		$this->load->model('M_Customer', 'customer');
	}

	public function index()
	{
		$data = [
			'title'      => 'List Barang',
			'page'       => 'user/keranjang',
			'keranjang'	=> $this->customer->getKeranjang([
				'orders.idUser'	=> $this->dt_user->id,
				'orders.status' => 0
			])
		];

		$this->load->view('user/index', $data);
	}

	public function checkout()
	{
		$idKhusus = $this->dt_user->id . date('-YmdHis');
		$data = [
			'status'   => 1,
			'idKhusus' => $idKhusus,
			'namaPT'   => $this->input->post('namaPT'),
			'alamat'   => $this->input->post('alamat'),
			'nohp'     => $this->input->post('nohp')
		];

		$this->db->where([
			'idUser' => $this->dt_user->id,
			'status' => 0
		]);
		$update = $this->db->update('orders', $data);

		if ($update) {
			$progres = [
				'idUser'   => $this->dt_user->id,
				'idKhusus' => $idKhusus,
				'status'   => 'Menunggu'
			];

			$this->db->insert('progres', $progres);

			$this->session->set_flashdata('toastr-success', 'Berhasil dicheckout');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal checkout');
		}

		redirect('user/orders', 'refresh');
	}
}

  /* End of file Keranjang.php */
