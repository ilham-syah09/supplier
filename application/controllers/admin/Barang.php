<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
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
			'title'    => 'List Barang',
			'sidebar'  => 'admin/sidebar',
			'page'     => 'admin/barang',
			'barang'    => $this->admin->getBarang()
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$gambar = $_FILES['gambar']['name'];

		if ($gambar) {
			$this->load->library('upload');
			$config['upload_path']   = './uploads/gambar';
			$config['allowed_types'] = 'jpg|jpeg|png';
			// $config['max_size']             = 3072; // 3 mb
			$config['remove_spaces'] = TRUE;
			$config['detect_mime']   = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('gambar')) {
				$this->session->set_flashdata('toastr-error', $this->upload->display_errors());

				redirect('admin/barang', 'refresh');
			} else {
				$upload_data = $this->upload->data();

				$kodeBarang = $this->_kodeBarang();

				$data = [
					'kodeBarang' => $kodeBarang,
					'namaBarang' => $this->input->post('namaBarang'),
					'deskripsi'  => $this->input->post('deskripsi'),
					'harga'      => $this->input->post('harga'),
					'stok'       => $this->input->post('stok'),
					'gambar'     => $upload_data['file_name'],
				];

				$insert = $this->db->insert('barang', $data);

				if ($insert) {
					$this->session->set_flashdata('toastr-success', 'Sukses tambah data');
				} else {
					$this->session->set_flashdata('toastr-error', 'Gagal tambah data');
				}
			}
		} else {
			$this->session->set_flashdata('toastr-error', 'Gambar harus ada');
		}

		redirect('admin/barang', 'refresh');
	}

	public function edit()
	{
		$id = $this->input->post('id');

		$this->db->where('id', $id);
		$dataSebelumnya = $this->db->get('barang')->row();

		$gambar = $_FILES['gambar']['name'];

		if ($gambar) {
			$this->load->library('upload');
			$config['upload_path']   = './uploads/gambar';
			$config['allowed_types'] = 'jpg|jpeg|png';
			// $config['max_size']             = 3072; // 3 mb
			$config['remove_spaces'] = TRUE;
			$config['detect_mime']   = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('gambar')) {
				$this->session->set_flashdata('toastr-error', $this->upload->display_errors());

				redirect('admin/barang', 'refresh');
			} else {
				$upload_data = $this->upload->data();

				if ($dataSebelumnya->gambar != null) {
					unlink(FCPATH . 'uploads/gambar/' . $dataSebelumnya->gambar);
				}

				$data = [
					'namaBarang' => $this->input->post('namaBarang'),
					'deskripsi'  => $this->input->post('deskripsi'),
					'harga'      => $this->input->post('harga'),
					'stok'       => $this->input->post('stok'),
					'gambar'     => $upload_data['file_name']
				];
			}
		} else {
			$data = [
				'namaBarang' => $this->input->post('namaBarang'),
				'deskripsi'  => $this->input->post('deskripsi'),
				'harga'      => $this->input->post('harga'),
				'stok'       => $this->input->post('stok'),
			];
		}

		$this->db->where('id', $id);
		$update = $this->db->update('barang', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Sukses edit data');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal edit data');
		}

		redirect('admin/barang', 'refresh');
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$dataSebelumnya = $this->db->get('barang')->row();

		$delete =    $this->db->delete('barang', ['id' => $id]);

		if ($delete) {
			if ($dataSebelumnya->gambar != null) {
				unlink(FCPATH . 'uploads/gambar/' . $dataSebelumnya->gambar);
			}

			$this->session->set_flashdata('toastr-success', 'Sukses hapus data');
		} else {
			$this->session->set_flashdata('toastr-error', 'Gagal hapus data');
		}

		redirect('admin/barang', 'refresh');
	}

	private function _kodeBarang()
	{

		$this->db->order_by('kodeBarang', 'desc');
		$cek = $this->db->get('barang')->row();

		if ($cek) {
			$a = $cek->kodeBarang;
			$newstring = substr($a, -4);
			$urut = (int)$newstring;

			$urut += 1;
			if (strlen($urut) == 1) {
				$urut = '000' . ($urut);
			} else if ((strlen($urut) == 2)) {
				$urut = '00' . ($urut);
			} else if ((strlen($urut) == 3)) {
				$urut = '0' . ($urut);
			} else {
				$urut = $urut;
			}
		} else {
			$urut = '0001';
		}

		return 'SPR-' . $urut;
	}
}

/* End of file Barang.php */
