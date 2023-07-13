<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{
    public function getCount($where = null, $table)
    {
        if ($where) {
            $this->db->where($where);
        }

        return $this->db->get($table)->num_rows();
    }

    public function getBarang()
    {
        $this->db->order_by('namaBarang', 'asc');
        return $this->db->get('barang')->result();
    }

    public function getCustomer()
    {
        $this->db->where('role_id', 2);
        $this->db->order_by('name', 'asc');

        return $this->db->get('user')->result();
    }

    public function getOrders()
    {
        $this->db->select('orders.*, barang.namaBarang, barang.kodeBarang, user.name, rekening.namaBank, rekening.noRek, ongkir.kota');
        $this->db->join('barang', 'barang.id = orders.idBarang', 'inner');
        $this->db->join('user', 'user.id = orders.idUser', 'inner');
        $this->db->join('rekening', 'rekening.id = orders.idRekening', 'inner');
        $this->db->join('ongkir', 'ongkir.id = orders.idOngkir', 'inner');

        $this->db->where('orders.status', 1);

        $this->db->group_by('orders.idKhusus');
        $this->db->order_by('orders.createdAt', 'desc');

        return $this->db->get('orders')->result();
    }

    public function getKeranjang($where)
    {
        $this->db->select('orders.*, barang.kodeBarang, barang.namaBarang, barang.gambar, barang.harga, ongkir.kota, ongkir.harga as hargaOngkir');
        $this->db->join('barang', 'barang.id = orders.idBarang', 'inner');
        $this->db->join('ongkir', 'ongkir.id = orders.idOngkir', 'inner');

        $this->db->where($where);

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

/* End of file M_admin.php */
