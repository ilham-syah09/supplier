<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
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
			'title'   => 'Pesanan Customer',
			'sidebar' => 'admin/sidebar',
			'page'    => 'admin/orders',
			'orders'  => $this->admin->getOrders()
		];

		$this->load->view('index', $data);
	}

	public function getListBarang()
	{
		$barang = $this->admin->getKeranjang([
			'idUser'   => $this->input->get('idUser'),
			'idKhusus' => $this->input->get('idKhusus')
		]);

		$result = [
			'data' => ($barang) ? $barang : null
		];

		echo json_encode($result);
	}

	public function getListProgres()
	{
		$progres = $this->admin->getListProgres([
			'idUser'   => $this->input->get('idUser'),
			'idKhusus' => $this->input->get('idKhusus'),
		]);

		$result = [
			'data' => ($progres) ? $progres : null
		];

		echo json_encode($result);
	}

	public function addProgres()
	{
		$data = [
			'idUser'   => $this->input->post('idUser'),
			'idKhusus' => $this->input->post('idKhusus'),
			'status'   => $this->input->post('status'),
			'tanggal'  => $this->input->post('tanggal'),
			'ket'      => $this->input->post('ket'),
		];

		$insert = $this->db->insert('progres', $data);

		if ($insert) {
			$this->session->set_flashdata('toastr-success', 'Sukses tambah data');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal tambah data');
		}

		redirect('admin/orders', 'refresh');
	}

	public function deleteProgres($id)
	{
		$this->db->delete('progres', ['id' => $id]);

		$this->session->set_flashdata('toastr-success', 'Sukses hapus data');

		redirect('admin/orders', 'refresh');
	}

	public function editStatusPembayaran()
	{
		$data = [
			'statusPembayaran'     => $this->input->post('statusPembayaran')
		];

		$this->db->where('idUser', $this->input->post('idUser'));
		$this->db->where('idKhusus', $this->input->post('idKhusus'));
		$update = $this->db->update('orders', $data);

		if ($update) {
			if ($data['statusPembayaran'] == 1) {
				$progres = [
					'idUser'   => $this->input->post('idUser'),
					'idKhusus' => $this->input->post('idKhusus'),
					'status'   => 'Menunggu',
					'tanggal' => date('Y-m-d')
				];

				$this->db->insert('progres', $progres);
			} else {
				$this->db->where('idUser', $this->input->post('idUser'));
				$this->db->where('idKhusus', $this->input->post('idKhusus'));

				$this->db->delete('progres');
			}

			$this->session->set_flashdata('toastr-success', 'Sukses edit status pembayaran');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal edit status pembayaran');
		}

		redirect('admin/orders', 'refresh');
	}

	public function delete($idKhusus)
	{
		$delete = $this->db->delete('orders', ['idKhusus' => $idKhusus]);

		if ($delete) {
			$this->db->delete('progres', ['idKhusus' => $idKhusus]);
			$this->session->set_flashdata('toastr-success', 'Sukses hapus data');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal hapus data');
		}

		redirect('admin/orders', 'refresh');
	}
}

    /* End of file Orders.php */
