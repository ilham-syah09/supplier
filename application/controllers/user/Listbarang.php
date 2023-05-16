<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Listbarang extends CI_Controller
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
		$page = $this->uri->segment(3);
		$per_page = 6;

		$barang = $this->customer->getBarang($per_page, $this->_paging_offset($page, $per_page));

		$total_rows = $this->customer->getCountbarang();

		$data = [
			'title'      => 'List Barang',
			'page'       => 'user/listbarang',
			'barang'     => $barang,
			'paging'     => $this->_paging(base_url('user/listbarang'), $total_rows, $per_page),
			'total_rows' => $total_rows
		];

		$this->load->view('user/index', $data);
	}

	public function addToCart()
	{
		$idBarang = $this->input->post('idBarang');

		$cek = $this->customer->getOneOrder([
			'idUser'   => $this->dt_user->id,
			'idBarang' => $idBarang,
			'status'   => 0
		]);

		if (!$cek) {
			$data = [
				'idUser'   => $this->dt_user->id,
				'idBarang' => $idBarang
			];

			$insert = $this->db->insert('orders', $data);

			if ($insert) {
				$this->session->set_flashdata('toastr-success', 'Berhasil ditambahkan ke keranjang');
			} else {
				$this->session->set_flashdata('toastr-error', 'Gagal ditambahkan ke keranjang');
			}
		} else {
			$this->session->set_flashdata('toastr-error', 'Barang sudah ada di keranjang');
		}

		redirect($_SERVER['HTTP_REFERER'], 'refresh');
	}

	private function _paging_offset($page, $limit)
	{
		if ($page > 1) {
			$offset = ($page - 1) * $limit;
		} else {
			$offset = $page;
		}

		return $offset;
	}

	private function _paging_tag()
	{
		$config['full_tag_open']    = "<ul class='pagination justify-content-center mb-3 my-auto'>";
		$config['full_tag_close']   = "</ul>";
		$config['first_tag_open']   = "<li class='page-link'>";
		$config['first_tag_close']  = "</li>";
		$config['next_tag_open']    = "<li class='page-link'>";
		$config['next_tag_close']   = "</li>";
		$config['cur_tag_open']     = "<li class='page-link active bg-primary text-white'><a>";
		$config['cur_tag_close']    = "</a></li>";
		$config['num_tag_open']     = "<li class='page-link'>";
		$config['num_tag_close']    = "</li>";
		$config['prev_tag_open']    = "<li class='page-link'>";
		$config['prev_tag_close']   = "</li>";
		$config['last_tag_open']    = "<li class='page-link'>";
		$config['last_tag_close']   = "</li>";
		$config['first_link']       = "First";
		$config['last_link']        = "Last";
		$config['next_link']        = "&raquo;";
		$config['prev_link']        = "&laquo;";

		return $config;
	}

	private function _paging($base_url, $total_rows, $per_page)
	{
		$this->load->library('pagination');
		$config                             = $this->_paging_tag();
		$config['base_url']                 = $base_url;
		$config['total_rows']               = $total_rows;
		$config['per_page']                 = $per_page;
		$config['use_page_numbers']         = TRUE;
		$config['reuse_query_string']       = TRUE;

		$this->pagination->initialize($config);

		return $this->pagination->create_links();
	}
}

  /* End of file Listbarang.php */
