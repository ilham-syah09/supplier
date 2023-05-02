<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{
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
        $this->db->select('orders.*, barang.namaBarang, barang.kodeBarang, user.name');
        $this->db->join('barang', 'barang.id = orders.idBarang', 'inner');
        $this->db->join('user', 'user.id = orders.idUser', 'inner');

        $this->db->where('orders.status', 1);

        $this->db->group_by('orders.idKhusus');
        $this->db->order_by('orders.createdAt', 'desc');

        return $this->db->get('orders')->result();
    }

    public function getListProgres($where)
    {
        $this->db->where($where);
        $this->db->order_by('tanggal', 'desc');

        return $this->db->get('progres')->result();
    }
}

/* End of file M_admin.php */
