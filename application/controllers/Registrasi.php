<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
	public function index()
	{
		$data = [
			'title'     => 'Registrasi',
		];

		$this->load->view('registrasi/index', $data);
	}

	public function proses()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('toastr-error', validation_errors());
			redirect('registrasi');
		} else {
			$username   = $this->input->post('username');
			$name   = $this->input->post('name');

			$this->db->insert('user', [
				'name' => $name,
				'username' => $username,
				'password' => password_hash('customer123', PASSWORD_BCRYPT),
				'role_id' => 2
			]);

			$insert_id = $this->db->insert_id();

			if ($insert_id) {
				$this->_sendEmail([
					'id'       => $insert_id,
					'name'     => $name,
					'username' => $username,
					'password' => 'customer123'
				]);

				$this->session->set_flashdata('toastr-success', 'Registrasi berhasil');
			} else {
				$this->session->set_flashdata('toastr-error', 'Registrasi gagal');
			}

			redirect('auth');
		}
	}

	public function aktifasi($id)
	{
		$this->db->where('id', $id);
		$user = $this->db->get('user')->row();

		if ($user) {
			if ($user->status == 0) {
				$this->db->where('id', $id);
				$update = $this->db->update('user', [
					'status' => 1
				]);

				if ($update) {
					$this->session->set_flashdata('toastr-success', 'Akun berhasil diaktifasi, silakan login');
				} else {
					$this->session->set_flashdata('toastr-error', 'Server Error');
				}
			} else {
				$this->session->set_flashdata('toastr-error', 'Akun Anda sudah aktif, silakan login');
			}
		} else {
			$this->session->set_flashdata('toastr-error', 'Akun tidak ditemukan');
		}

		redirect('auth');
	}

	private function _sendEmail($data)
	{
		$this->load->library('email');
		$config = array();
		$config['charset'] = 'utf-8';
		$config['useragent'] = 'Codeigniter';
		$config['protocol'] = "smtp";
		$config['mailtype'] = "html";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_timeout'] = "5";
		$config['priority'] = 3;
		$config['smtp_user'] = "maykomputer2019@gmail.com";
		$config['smtp_pass'] = 'qnslsfcdcgwwlitg';
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from($config['smtp_user'], 'Supplier');
		$this->email->to($data['username']);
		$this->email->subject('Registrasi Akun');
		$message = $this->load->view('v_email', $data, TRUE);
		$this->email->message($message);
		$this->email->set_mailtype("html");

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
		}
	}
}

/* End of file Registrasi.php */
