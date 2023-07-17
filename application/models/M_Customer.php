<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Customer extends CI_Model
{
	public function getCount($where = null, $table)
	{
		if ($where) {
			$this->db->where($where);
		}

		return $this->db->get($table)->num_rows();
	}

	public function getBarang($limit = null, $offset = null)
	{
		// $this->db->where($where);
		// $this->db->like('nama_menu', $like);

		$this->db->order_by('namaBarang', 'asc');

		return $this->db->get('barang', $limit, $offset)->result();
	}

	public function getOneOrder($where)
	{
		$this->db->where($where);
		return $this->db->get('orders')->row();
	}

	public function getCountBarang()
	{
		// $this->db->where($where);
		// $this->db->like('nama_menu', $like);

		return $this->db->get('barang')->num_rows();
	}

	public function getKeranjang($where)
	{
		$this->db->select('orders.*, barang.kodeBarang, barang.namaBarang, barang.gambar, barang.stok, barang.harga, ongkir.kota, ongkir.harga as hargaOngkir');
		$this->db->join('barang', 'barang.id = orders.idBarang', 'inner');
		$this->db->join('ongkir', 'ongkir.id = orders.idOngkir', 'left');

		$this->db->where($where);

		$this->db->order_by('barang.namaBarang', 'asc');

		return $this->db->get('orders')->result();
	}

	public function getOrders($where)
	{
		$this->db->select('orders.*, barang.kodeBarang, barang.namaBarang, barang.gambar, rekening.namaBank, rekening.noRek, ongkir.kota');
		$this->db->join('barang', 'barang.id = orders.idBarang', 'inner');
		$this->db->join('rekening', 'rekening.id = orders.idRekening', 'left');
		$this->db->join('ongkir', 'ongkir.id = orders.idOngkir', 'left');

		$this->db->where($where);

		$this->db->group_by('orders.idKhusus');
		$this->db->order_by('barang.namaBarang', 'asc');

		return $this->db->get('orders')->result();
	}

	public function getListProgres($where)
	{
		$this->db->where($where);
		$this->db->order_by('tanggal', 'desc');

		return $this->db->get('progres')->result();
	}

	public function getRekening()
	{
		$this->db->order_by('namaBank', 'asc');
		return $this->db->get('rekening')->result();
	}

	public function getOngkir()
	{
		$this->db->order_by('kota', 'asc');
		return $this->db->get('ongkir')->result();
	}
}

/* End of file M_Customer.php */
