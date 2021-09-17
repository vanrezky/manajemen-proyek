<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kas_masuk extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $id_proyek = $this->input->get('id_proyek');
        $D = $this->db->get_where('kas_masuk', ['id_proyek' => $id_proyek])->result_array();
        $data = [
            'title' => 'Daftar Kas Masuk',
            'data' => $D,
            'proyek' => $this->db->get('proyek')->result_array(),
            'filter' => [
                'id_proyek' => $id_proyek
            ]
        ];
        $this->render('v_kas_masuk_index', $data);
    }


    public function data($id = "")
    {
        $kas_masuk = $this->db->get_where('kas_masuk', ['id_kas_masuk' => $id])->row_array();

        $data = [
            'title' => empty($kas_masuk) ? 'Tambah Kas Masuk' : 'Update Kas Masuk',
            'data' => $kas_masuk,
            'proyek' => $this->db->get('proyek')->result_array(),
            'empty' => empty($kas_masuk) ? true : false,
        ];

        $this->render('v_kas_masuk_data', $data);
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;

            $validation->set_rules("jumlah", "Jumlah Kas Masuk", "trim|required|numeric", [
                'required' => "{field} tidak boleh kosong",
                'numeric' => "{field} harus angka!",
            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                $timeStamp = current_timestamp();
                $data = [
                    'id_proyek' => $input['id_proyek'],
                    'jumlah' => $input['jumlah'],
                    'deskripsi' => $input['deskripsi'],
                    'tgl_kas_masuk' => $input['tgl_kas_masuk'],
                    'created_at' => $timeStamp,
                    'updated_at' => $timeStamp,
                ];

                if ($this->db->insert('kas_masuk', $data)) {
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
                        'jumlah' => form_error('jumlah')
                    ],
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
            $validation->set_rules("jumlah", "Jumlah Kas Masuk", "trim|required|numeric", [
                'required' => "{field} tidak boleh kosong",
                'numeric' => "{field} harus angka!",
            ]);

            if ($validation->run() === true) {

                $timeStamp = current_timestamp();
                $data = [
                    'id_proyek' => $input['id_proyek'],
                    'jumlah' => $input['jumlah'],
                    'deskripsi' => $input['deskripsi'],
                    'tgl_kas_masuk' => $input['tgl_kas_masuk'],
                    'updated_at' => $timeStamp,
                ];

                $update = $this->db->where('id_kas_masuk', $id)->update('kas_masuk', $data);

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
                        'jumlah' => form_error('jumlah'),
                    ],
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

            $kas_masuk = $this->db->get_where('kas_masuk', ['id_kas_masuk' => $id])->row_array();

            if ($kas_masuk) {

                $delete = $this->db->where('id_kas_masuk', $id)->delete('kas_masuk');

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
