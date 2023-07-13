<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ongkir extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('log_admin'))) {
			$this->session->set_flashdata('toastr-error', 'Anda Belum Login');
			redirect('auth', 'refresh');
		}

		$this->db->where('id', $this->session->userdata('id'));
		$this->dt_user = $this->db->get('user')->row();

		$this->load->model('M_admin', 'admin');
	}

	public function index()
	{
		$data = [
			'title'   => 'List Ongkir',
			'sidebar' => 'admin/sidebar',
			'page'    => 'admin/ongkir',
			'ongkir'  => $this->admin->getOngkir()
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$data = [
			'kota'  => $this->input->post('kota'),
			'harga' => $this->input->post('harga')
		];

		$insert = $this->db->insert('ongkir', $data);

		if ($insert) {
			$this->session->set_flashdata('toastr-success', 'Sukses tambah ongkir');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal tambah ongkir');
		}

		redirect('admin/ongkir', 'refresh');
	}

	public function edit()
	{
		$data = [
			'kota'  => $this->input->post('kota'),
			'harga' => $this->input->post('harga')
		];

		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('ongkir', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Sukses edit ongkir');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal edit ongkir');
		}

		redirect('admin/ongkir', 'refresh');
	}

	public function delete($id)
	{
		$this->db->delete('ongkir', ['id' => $id]);

		$this->session->set_flashdata('toastr-success', 'Sukses delete ongkir');

		redirect('admin/ongkir', 'refresh');
	}
}

  /* End of file Ongkir.php */
