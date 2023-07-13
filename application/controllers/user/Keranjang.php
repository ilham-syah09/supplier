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
			'title'     => 'List Barang',
			'page'      => 'user/keranjang',
			'rekening'  => $this->customer->getRekening(),
			'ongkir'    => $this->customer->getOngkir(),
			'keranjang' => $this->customer->getKeranjang([
				'orders.idUser'	=> $this->dt_user->id,
				'orders.status' => 0
			])
		];

		$this->load->view('user/index', $data);
	}

	public function updateJumlah()
	{
		$id = $this->input->post('id');
		$jumlah = $this->input->post('jumlah');
		$harga = $this->input->post('harga');

		$data = [
			'jumlah' => $jumlah
		];

		$this->db->where('id', $id);
		$update = $this->db->update('orders', $data);

		if ($update) {
			$this->db->select('SUM(barang.harga * orders.jumlah) AS total');
			$this->db->join('barang', 'barang.id = orders.idBarang', 'inner');

			$this->db->where([
				'orders.idUser' => $this->dt_user->id,
				'orders.status' => 0
			]);

			$keranjang = $this->db->get('orders')->row();

			$res = [
				'status'     => true,
				'total'      => 'Rp. ' . number_format($keranjang->total, 0, ',', '.'),
				'subTotal'   => 'Rp. ' . number_format(($jumlah * $harga), 0, ',', '.'),
				'totalBiaya' => $keranjang->total
			];
		} else {
			$res = [
				'status' => false
			];
		}

		echo json_encode($res);
	}

	public function checkout()
	{
		$idKhusus = $this->dt_user->id . date('-YmdHis');
		$data = [
			'totalBiaya' => $this->input->post('totalBiaya'),
			'idRekening' => $this->input->post('idRekening'),
			'idOngkir'   => $this->input->post('idOngkir'),
			'status'     => 1,
			'idKhusus'   => $idKhusus,
			'namaPT'     => $this->input->post('namaPT'),
			'alamat'     => $this->input->post('alamat'),
			'nohp'       => $this->input->post('nohp')
		];

		$this->db->where([
			'idUser' => $this->dt_user->id,
			'status' => 0
		]);
		$update = $this->db->update('orders', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Berhasil dicheckout');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal checkout');
		}

		redirect('user/orders', 'refresh');
	}
}

  /* End of file Keranjang.php */
