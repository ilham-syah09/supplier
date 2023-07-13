<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
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
			'title'    => 'List Rekening',
			'sidebar'  => 'admin/sidebar',
			'page'     => 'admin/rekening',
			'rekening' => $this->admin->getRekening()
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$data = [
			'namaBank' => $this->input->post('namaBank'),
			'noRek'    => $this->input->post('noRek')
		];

		$insert = $this->db->insert('rekening', $data);

		if ($insert) {
			$this->session->set_flashdata('toastr-success', 'Sukses tambah rekening');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal tambah rekening');
		}

		redirect('admin/rekening', 'refresh');
	}

	public function edit()
	{
		$data = [
			'namaBank' => $this->input->post('namaBank'),
			'noRek'    => $this->input->post('noRek')
		];

		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('rekening', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Sukses edit rekening');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal edit rekening');
		}

		redirect('admin/rekening', 'refresh');
	}

	public function delete($id)
	{
		$this->db->delete('rekening', ['id' => $id]);

		$this->session->set_flashdata('toastr-success', 'Sukses delete rekening');

		redirect('admin/rekening', 'refresh');
	}
}

  /* End of file Rekening.php */
