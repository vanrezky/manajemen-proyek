<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alat extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $D = $this->db->get('alat')->result_array();
        $data = [
            'title' => 'Daftar Alat',
            'data' => $D,
        ];
        $this->render('v_alat_index', $data);
    }


    public function data($id = "")
    {
        $alat = $this->db->get_where('alat', ['id_alat' => $id])->row_array();

        $data = [
            'title' => empty($alat) ? 'Tambah Alat' : 'Update Alat',
            'data' => $alat,
            'empty' => empty($alat) ? true : false,
        ];

        $this->render('v_alat_data', $data);
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;

            $validation->set_rules("nama", "Nama Alat", "trim|required", [
                'required' => "{field} tidak boleh kosong",
            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                $timeStamp = current_timestamp();
                $data = [
                    'nama' => $input['nama'],
                    'deskripsi' => $input['deskripsi'],
                    'created_at' => $timeStamp,
                    'updated_at' => $timeStamp,
                ];

                if ($this->db->insert('alat', $data)) {
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
                    'errors' => [],
                ];
            }

            echo json_encode($msg);
            exit();
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
            $validation->set_rules("nama", "Nama Alat", "trim|required", [
                'required' => "{field} tidak boleh kosong",
            ]);


            if ($validation->run() === true) {

                $timeStamp = current_timestamp();
                $data = [
                    'nama' => $input['nama'],
                    'deskripsi' => $input['deskripsi'],
                    'updated_at' => $timeStamp,
                ];

                $update = $this->db->where('id_alat', $id)->update('alat', $data);

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
                    'errors' => [],
                ];
            }

            echo json_encode($msg);
            exit();
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

            $alat = $this->db->get_where('alat', ['id_alat' => $id])->row_array();

            if ($alat) {

                $delete = $this->db->where('id_alat', $id)->delete('alat');

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
