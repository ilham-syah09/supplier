<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
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
			'title'      => 'List Order',
			'page'       => 'user/orders',
			'orders'	=> $this->customer->getOrders([
				'orders.idUser'	=> $this->dt_user->id,
				'orders.status' => 1
			])
		];

		$this->load->view('user/index', $data);
	}

	public function getListProgres()
	{
		$progres = $this->customer->getListProgres([
			'idUser'   => $this->dt_user->id,
			'idKhusus' => $this->input->get('idKhusus'),
		]);

		$result = [
			'data' => ($progres) ? $progres : null
		];

		echo json_encode($result);
	}

	public function getListBarang()
	{
		$barang = $this->customer->getKeranjang([
			'idUser'   => $this->dt_user->id,
			'idKhusus' => $this->input->get('idKhusus'),
		]);

		$result = [
			'data' => ($barang) ? $barang : null
		];

		echo json_encode($result);
	}

	public function upload()
	{
		$file = $_FILES['file']['name'];

		if ($file) {
			$this->load->library('upload');
			$config['upload_path']   = './uploads/bukti';
			$config['allowed_types'] = 'jpg|jpeg|png';
			// $config['max_size']             = 3072; // 3 mb
			$config['remove_spaces'] = TRUE;
			$config['detect_mime']   = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('file')) {
				$this->session->set_flashdata('toastr-error', $this->upload->display_errors());

				redirect('user/orders', 'refresh');
			} else {
				$upload_data = $this->upload->data();

				$data = [
					'statusPembayaran' => 3,
					'bukti'  => $upload_data['file_name']
				];
			}
		} else {
			$this->session->set_flashdata('toastr-error', 'File tidak boleh kosong');

			redirect('user/orders', 'refresh');
		}

		$where = [
			'idUser'   => $this->dt_user->id,
			'idKhusus' => $this->input->post('idKhusus')
		];

		$this->db->where($where);
		$order = $this->db->get('orders')->row();

		$this->db->where($where);
		$update = $this->db->update('orders', $data);

		if ($update) {
			if ($order->bukti != null) {
				unlink(FCPATH . 'uploads/bukti/' . $order->bukti);
			}

			$this->session->set_flashdata('toastr-success', 'Bukti transfer berhasil diupload');
		} else {
			$this->session->set_flashdata('toastr-error', 'Bukti transfer gagal diupload');
		}

		redirect('user/orders', 'refresh');
	}
}

  /* End of file Orders.php */
