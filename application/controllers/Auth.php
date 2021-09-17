<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_CONTROLLER
{

    public function index()
    {

        if ($this->session->has_userdata('user')) {
            redirect('/');
        }

        if ($this->input->is_ajax_request()) {
            $csrf = csrf_hash();
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $msg = [
                'success' => false,
                'csrf' => $csrf,
                'message' => 'Periksa kembali username dan password!'
            ];

            $validation = $this->form_validation;
            $validation->set_rules("username", "Username", "trim|required", [
                'required' => "{field} tidak boleh kosong"
            ]);
            $validation->set_rules("password", "Password", "trim|required", [
                'required' => "{field} tidak boleh kosong"
            ]);

            if ($validation->run() === true) {
                $msg = [
                    'success' => false,
                    'csrf' => $csrf,
                    'message' => 'Username atau password salah!'
                ];

                $user = $this->db->get_where('user', ['username' => $username])->row_array();
                $login_vendor = true;

                if ($user) {

                    if (password_verify($password, $user['password'])) {
                        $login_vendor = false;
                        $msg = [
                            'success' => true,
                            'message' => 'Berhasil Login, mohon tunggu!'
                        ];

                        $session = [
                            'id_user' => $user['id_user'],
                            'username' => $user['username'],
                            'level' => $user['level'],
                            'nama' => $user['nama'],
                            'alamat' => $user['alamat'],
                            'no_telp' => $user['no_telp'],
                        ];

                        $this->session->set_userdata('user', $session);
                    }
                }

                if ($login_vendor) {
                    $vendor = $this->db->get_where('vendor', ['email' => $username])->row_array();

                    if (password_verify($password, $vendor['password'])) {
                        $msg = [
                            'success' => true,
                            'message' => 'Berhasil Login, mohon tunggu!'
                        ];

                        $session = [
                            'id_user' => $vendor['id_vendor'],
                            'username' => $vendor['email'],
                            'level' => 'vendor',
                            'nama' => $vendor['nama'],
                            'alamat' => $vendor['alamat'],
                            'no_telp' => $vendor['telp'],
                        ];

                        $this->session->set_userdata('user', $session);
                    }
                }
            } else {
                $msg = [
                    'success' => false,
                    'csrf' => $csrf,
                    'message' => 'Periksa kembali username dan password!',
                    'errors' => [
                        'username' => form_error('username'),
                        'password' => form_error('password')
                    ]
                ];
            }

            echo json_encode($msg);
            exit();
        }

        $this->load->view('v_auth_login');
    }


    public function logout()
    {

        $this->session->unset_userdata('user');
        redirect('auth');
    }
}
