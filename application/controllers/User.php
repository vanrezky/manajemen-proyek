<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $D = $this->db->get('user')->result_array();
        $data = [
            'title' => 'Daftar User',
            'data' => $D,
        ];
        $this->render('v_user_index', $data);
    }


    public function data($id = "")
    {
        $userData = $this->db->get_where('user', ['id_user' => $id])->row_array();

        $data = [
            'title' => empty($userData) ? 'Tambah User' : 'Update User',
            'data' => $userData,
            'empty' => empty($userData) ? true : false,
        ];

        $this->render('v_user_data', $data);
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;
            $validation->set_rules("username", "Username", "trim|required|is_unique[user.username]", [
                'required' => "{field} tidak boleh kosong",
                'is_unique' => "{field} sudah digunakan",
            ]);
            $validation->set_rules("password", "Password", "trim|required", [
                'required' => "{field} tidak boleh kosong"
            ]);
            $validation->set_rules("password2", "Konfirmasi password", "trim|required|matches[password]", [
                'required' => "{field} tidak boleh kosong",
                'matches' => "{field} tidak cocok dengan {param}"
            ]);
            $validation->set_rules("no_telp", "No Telp", "trim|required|numeric", [
                'required' => "{field} tidak boleh kosong",
                'numeric' => "{field} harus berupa angka",

            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                $timeStamp = current_timestamp();
                $data = [
                    'username' => $input['username'],
                    'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                    'level' => $input['level'],
                    'nama' => $input['nama'],
                    'alamat' => $input['alamat'],
                    'no_telp' => $input['no_telp'],
                    'created_at' => $timeStamp,
                    'updated_at' => $timeStamp,
                ];

                if ($this->db->insert('user', $data)) {
                    $msg = [
                        'success' => true,
                        'message' => 'Data berhasil disimpan!'
                    ];
                } else {
                    $msg = [
                        'success' => false,
                        'message' => 'Terjadi kesalahan saat menyimpan data'
                    ];
                }
            } else {
                $msg = [
                    'csrf' => $csrf,
                    'success' => false,
                    'message' => 'Periksa kembali data yang ingin anda simpan',
                    'errors' => [
                        'username' => form_error('username'),
                        'password' => form_error('password'),
                        'password2' => form_error('password2'),
                        'no_telp' => form_error('no_telp')
                    ],
                ];
            }

            echo json_encode($msg);
        } else {
            // exit
            notAllow();
        }
    }

    public function update($id)
    {
        if ($this->input->is_ajax_request()) {

            $input = $this->input->post();

            $csrf = csrf_hash();

            $validation = $this->form_validation;
            $validation->set_rules("no_telp", "No Telp", "trim|required|numeric", [
                'required' => "{field} tidak boleh kosong",
                'numeric' => "{field} harus berupa angka",
            ]);

            // jika password diisi
            if ($input['password']) {
                $validation->set_rules("password", "Password", "trim|required", [
                    'required' => "{field} tidak boleh kosong"
                ]);
                $validation->set_rules("password2", "Konfirmasi password", "trim|required|matches[password]", [
                    'required' => "{field} tidak boleh kosong",
                    'matches' => "{field} tidak cocok dengan {param}"
                ]);
            }

            if ($validation->run() === true) {

                $timeStamp = current_timestamp();
                $data = [
                    'level' => $input['level'],
                    'nama' => $input['nama'],
                    'alamat' => $input['alamat'],
                    'no_telp' => $input['no_telp'],
                    'updated_at' => $timeStamp,
                ];

                if (!empty($input['password'])) {
                    $data['password'] =  password_hash($input['password'], PASSWORD_DEFAULT);
                }

                $update = $this->db->where('id_user', $id)->update('user', $data);

                if ($update) {
                    $msg = [
                        'success' => true,
                        'message' => 'Data berhasil diupdate!'
                    ];
                } else {
                    $msg = [
                        'success' => false,
                        'message' => 'Terjadi kesalahan saat update data'
                    ];
                }
            } else {
                $msg = [
                    'csrf' => $csrf,
                    'success' => false,
                    'message' => 'Periksa kembali data yang ingin anda simpan',
                    'errors' => [
                        'password' => form_error('password'),
                        'password2' => form_error('password2'),
                        'no_telp' => form_error('no_telp')
                    ],
                ];
            }

            echo json_encode($msg);
        } else {
            // exit
            notAllow();
        }
    }


    public function delete($id)
    {
        if ($this->input->is_ajax_request()) {
            $msg = [
                'success' => false,
                'message' => 'Data tidak ditemukan!'
            ];

            $user = $this->db->get_where('user', ['id_user' => $id])->row_array();

            if ($user) {

                $delete = $this->db->where('id_user', $id)->delete('user');

                if ($delete) {
                    $msg = [
                        'success' => true,
                        'message' => 'Berhasil hapus data!',
                    ];
                } else {
                    $msg = [
                        'success' => false,
                        'message' => 'Terjadi kesalahan saat hapus data!',
                    ];
                }
            }

            echo json_encode($msg);
        }
    }
}
