<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
            'title'     => 'Dashboard',
            'page'      => 'user/dashboard',
            'keranjang' =>  $this->customer->getCount([
                'idUser' => $this->dt_user->id,
                'status' => 0
            ], 'orders'),
            'orders'    =>  $this->customer->getCount([
                'idUser' => $this->dt_user->id,
                'status' => 1
            ], 'orders')
        ];

        $this->load->view('user/index', $data);
    }
}

/* End of file Admin.php */
