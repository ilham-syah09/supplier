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
		$ktp = $_FILES['ktp']['name'];

		if ($ktp) {
			$this->load->library('upload');
			$config['upload_path']   = './uploads/ktp';
			$config['allowed_types'] = 'jpg|jpeg|png';
			// $config['max_size']             = 3072; // 3 mb
			$config['remove_spaces'] = TRUE;
			$config['detect_mime']   = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('ktp')) {
				$this->session->set_flashdata('toastr-error', $this->upload->display_errors());

				redirect('admin/customer', 'refresh');
			} else {
				$upload_data = $this->upload->data();

				$data = [
					'name'     => $this->input->post('name'),
					'username' => $this->input->post('username'),
					'noHp'     => $this->input->post('noHp'),
					'alamat'   => $this->input->post('alamat'),
					'password' => password_hash('customer123', PASSWORD_BCRYPT),
					'role_id'  => 2,
					'status'   => 1,
					'ktp'      => $upload_data['file_name'],
				];

				$insert = $this->db->insert('user', $data);

				if ($insert) {
					$this->session->set_flashdata('toastr-success', 'Sukses tambah user');
				} else {
					$this->session->set_flashdata('toastr-error', 'Gagal tambah user');
				}
			}
		} else {
			$this->session->set_flashdata('toastr-error', 'KTP harus ada');
		}

		redirect('admin/customer', 'refresh');
	}

	public function edit()
	{
		$ktp = $_FILES['ktp']['name'];

		if ($ktp) {
			$this->load->library('upload');
			$config['upload_path']   = './uploads/ktp';
			$config['allowed_types'] = 'jpg|jpeg|png';
			// $config['max_size']             = 3072; // 3 mb
			$config['remove_spaces'] = TRUE;
			$config['detect_mime']   = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('ktp')) {
				$this->session->set_flashdata('toastr-error', $this->upload->display_errors());

				redirect('admin/customer', 'refresh');
			} else {
				$upload_data = $this->upload->data();

				$data = [
					'name'     => $this->input->post('name'),
					'username' => $this->input->post('username'),
					'noHp'     => $this->input->post('noHp'),
					'alamat'   => $this->input->post('alamat'),
					'status'   => $this->input->post('status'),
					'ktp'      => $upload_data['file_name'],
				];

				$this->db->where('id', $this->input->post('id'));
				$user = $this->db->get('user')->row();

				$this->db->where('id', $this->input->post('id'));
				$update = $this->db->update('user', $data);

				if ($update) {
					if ($user->ktp != null) {
						unlink(FCPATH . 'uploads/ktp/' . $user->ktp);
					}

					$this->session->set_flashdata('toastr-success', 'Sukses edit user');
				} else {
					$this->session->set_flashdata('toastr-error', 'Gagal edit user');
				}
			}
		} else {
			$data = [
				'name'     => $this->input->post('name'),
				'username' => $this->input->post('username'),
				'noHp'     => $this->input->post('noHp'),
				'alamat'   => $this->input->post('alamat'),
				'status'   => $this->input->post('status'),
			];

			$this->db->where('id', $this->input->post('id'));
			$update = $this->db->update('user', $data);

			if ($update) {
				$this->session->set_flashdata('toastr-success', 'Sukses edit user');
			} else {
				$this->session->set_flashdata('toastr-error', 'Gagal edit user');
			}
		}

		redirect('admin/customer', 'refresh');
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$user = $this->db->get('user')->row();

		$delete = $this->db->delete('user', ['id' => $id]);

		if ($delete) {
			if ($user->ktp != null) {
				unlink(FCPATH . 'uploads/ktp/' . $user->ktp);
			}

			$this->session->set_flashdata('toastr-success', 'Sukses delete user');
		}
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
