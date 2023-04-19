<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('log_admin'))) {
            $this->session->set_flashdata('toastr-eror', 'Anda Belum Login');
            redirect('auth', 'refresh');
        }

        $this->db->where('id', $this->session->userdata('id'));
        $this->dt_admin = $this->db->get('user')->row();
    }

    public function index()
    {
        $data = [
            'title'     => 'Profile',
            'sidebar'   => 'admin/sidebar',
            'page'      => 'admin/profile'
        ];

        $this->load->view('index', $data);
    }

    public function edit()
    {
        if ($this->input->post('password')) {

            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[retypepwd]');
            $this->form_validation->set_rules('retypepwd', 'Retype Password', 'trim|required|matches[password]');


            if ($this->form_validation->run() == FALSE) {

                redirect('admin/profile', 'refresh');
            } else {
                $img = $_FILES['image']['name'];

                if ($img) {
                    $config['upload_path']      = 'uploads/profile';
                    $config['allowed_types']    = 'jpg|jpeg|png';
                    $config['max_size']         = 2000;
                    $config['remove_spaces']    = TRUE;
                    $config['encrypt_name']     = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('image')) {
                        $this->session->set_flashdata('toastr-eror', $this->upload->display_errors());
                        redirect('admin/profile');
                    } else {
                        $upload_data = $this->upload->data();
                        $previmage = $this->input->post('previmage');

                        $data = [
                            'name'  => $this->input->post('name'),
                            'username'  => $this->input->post('username'),
                            'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                            'image'     => $upload_data['file_name']
                        ];

                        $this->db->where('id', $this->dt_admin->id);
                        $insert = $this->db->update('user', $data);

                        if ($insert) {
                            if ($previmage != 'default.png') {
                                unlink(FCPATH . 'uploads/profile/' . $previmage);
                            }
                            $this->session->set_flashdata('toastr-sukses', 'success !');
                            redirect('admin/profile');
                        } else {
                            $this->session->set_flashdata('toastr-eror', 'failed!');
                            redirect('admin/profile');
                        }
                    }
                }
            }
        } else {
            $img = $_FILES['image']['name'];

            if ($img) {
                $config['upload_path']      = 'uploads/profile';
                $config['allowed_types']    = 'jpg|jpeg|png';
                $config['max_size']         = 2000;
                $config['remove_spaces']    = TRUE;
                $config['encrypt_name']     = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('image')) {
                    $this->session->set_flashdata('toastr-eror', $this->upload->display_errors());
                    redirect('profile');
                } else {
                    $upload_data = $this->upload->data();
                    $previmage = $this->input->post('previmage');

                    $data = [
                        'name'  => $this->input->post('name'),
                        'username'  => $this->input->post('username'),
                        'image'     => $upload_data['file_name']
                    ];

                    $this->db->where('id', $this->dt_admin->id);
                    $insert = $this->db->update('user', $data);

                    if ($insert) {
                        if ($previmage != 'default.png') {
                            unlink(FCPATH . 'uploads/profile/' . $previmage);
                        }
                        $this->session->set_flashdata('toastr-sukses', 'success !');
                        redirect('admin/profile');
                    } else {
                        $this->session->set_flashdata('toastr-eror', 'failed!');
                        redirect('admin/profile');
                    }
                }
            }
        }
    }
}

/* End of file Admin.php */
