<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{

    public function getdatasensor()
    {
        $this->db->order_by('date', 'desc');
        return $this->db->get('sensor')->result();
    }

    public function get($table)
    {
        return $this->db->get($table);
    }

    public function getTinggi()
    {
        $this->db->select('tinggi_auto,tinggi_manual');
        $this->db->order_by('id', 'desc');
        return $this->db->get('sensor', 1)->row();
    }

    public function getpH()
    {
        $this->db->select('pH');
        $this->db->order_by('id', 'desc');
        return $this->db->get('sensor', 1)->row();
    }

    public function getDebit()
    {
        $this->db->select('debit');
        $this->db->order_by('id', 'desc');
        return $this->db->get('sensor', 1)->row();
    }

    public function getPpm()
    {
        $this->db->select('ppm');
        $this->db->order_by('id', 'desc');
        return $this->db->get('sensor', 1)->row();
    }

    public function countTinggi()
    {
        $this->db->select('tinggi_manual,tinggi_auto');
        return $this->db->get('sensor')->num_rows();
    }

    public function countpH()
    {
        $this->db->select('pH');
        return $this->db->get('sensor')->num_rows();
    }

    public function countDebit()
    {
        $this->db->select('debit');
        return $this->db->get('sensor')->num_rows();
    }

    public function countPpm()
    {
        $this->db->select('ppm');
        return $this->db->get('sensor')->num_rows();
    }
}

/* End of file M_admin.php */
