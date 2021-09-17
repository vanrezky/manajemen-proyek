<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $D = $this->db->get('barang')->result_array();
        $data = [
            'title' => 'Daftar Barang',
            'data' => $D,
        ];
        $this->render('v_barang_index', $data);
    }


    public function data($id = "")
    {
        $barangData = $this->db->get_where('barang', ['id_barang' => $id])->row_array();

        $data = [
            'title' => empty($barangData) ? 'Tambah Barang' : 'Update Barang',
            'data' => $barangData,
            'empty' => empty($barangData) ? true : false,
        ];

        $this->render('v_barang_data', $data);
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;
            $validation->set_rules("nama", "Nama Barang", "trim|required", [
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

                if ($this->db->insert('barang', $data)) {
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
                        'nama' => form_error('nama')
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
            $validation->set_rules("nama", "Nama Barang", "trim|required", [
                'required' => "{field} tidak boleh kosong",
            ]);

            if ($validation->run() === true) {

                $timeStamp = current_timestamp();
                $data = [
                    'nama' => $input['nama'],
                    'deskripsi' => $input['deskripsi'],
                    'updated_at' => $timeStamp,
                ];

                $update = $this->db->where('id_barang', $id)->update('barang', $data);

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
                        'telp' => form_error('telp')
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

            $barang = $this->db->get_where('barang', ['id_barang' => $id])->row_array();

            if ($barang) {

                $delete = $this->db->where('id_barang', $id)->delete('barang');

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
