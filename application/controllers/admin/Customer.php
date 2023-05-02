<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
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
			'title'    => 'List Customer',
			'sidebar'  => 'admin/sidebar',
			'page'     => 'admin/customer',
			'customer' => $this->admin->getCustomer()
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$data = [
			'name'         => $this->input->post('name'),
			'username'     => $this->input->post('username'),
			'password'     => password_hash('customer123', PASSWORD_BCRYPT),
			'role_id'      => 2
		];

		$insert = $this->db->insert('user', $data);

		if ($insert) {
			$this->session->set_flashdata('toastr-success', 'Sukses tambah admin');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal tambah admin');
		}

		redirect('admin/customer', 'refresh');
	}

	public function edit()
	{
		$data = [
			'name'     => $this->input->post('name'),
			'username' => $this->input->post('username'),
			'status'   => $this->input->post('status')
		];

		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('user', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Sukses edit admin');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal edit admin');
		}

		redirect('admin/customer', 'refresh');
	}

	public function delete($id)
	{
		$this->db->delete('user', ['id' => $id]);

		$this->session->set_flashdata('toastr-success', 'Sukses tambah admin');

		redirect('admin/customer', 'refresh');
	}

	public function resetPwd($id)
	{
		$data = [
			'password' => password_hash('customer123', PASSWORD_BCRYPT)
		];

		$this->db->where('id', $id);
		$reset = $this->db->update('user', $data);

		if ($reset) {
			$this->session->set_flashdata('toastr-success', 'Sukses reset password');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal reset password');
		}

		redirect('admin/customer', 'refresh');
	}
}

  /* End of file Customer.php */
