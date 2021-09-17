<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suplier extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $D = $this->db->get('suplier')->result_array();
        $data = [
            'title' => 'Daftar Suplier',
            'data' => $D,
        ];
        $this->render('v_suplier_index', $data);
    }


    public function data($id = "")
    {
        $suplier = $this->db->get_where('suplier', ['id_suplier' => $id])->row_array();

        $data = [
            'title' => empty($suplier) ? 'Tambah Suplier' : 'Update Suplier',
            'data' => $suplier,
            'empty' => empty($suplier) ? true : false,
        ];

        $this->render('v_suplier_data', $data);
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;
            $validation->set_rules("telp", "No Telp", "trim|numeric", [
                'required' => "{field} tidak boleh kosong",
                'numeric' => "{field} harus berupa angka",

            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                $timeStamp = current_timestamp();
                $data = [
                    'nama' => $input['nama'],
                    'pic' => $input['pic'],
                    'alamat' => $input['alamat'],
                    'telp' => $input['telp'],
                    'fax' => $input['fax'],
                    'email' => $input['email'],
                    'created_at' => $timeStamp,
                    'updated_at' => $timeStamp,
                ];

                if ($this->db->insert('suplier', $data)) {
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
                        'telp' => form_error('telp'),
                        'email' => form_error('email'),
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
            $validation->set_rules("telp", "No Telp", "trim|required|numeric", [
                'required' => "{field} tidak boleh kosong",
                'numeric' => "{field} harus berupa angka",
            ]);

            if ($validation->run() === true) {

                $timeStamp = current_timestamp();
                $data = [
                    'nama' => $input['nama'],
                    'pic' => $input['pic'],
                    'alamat' => $input['alamat'],
                    'telp' => $input['telp'],
                    'fax' => $input['fax'],
                    'updated_at' => $timeStamp,
                ];

                $update = $this->db->where('id_suplier', $id)->update('suplier', $data);

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

            $suplier = $this->db->get_where('suplier', ['id_suplier' => $id])->row_array();

            if ($suplier) {

                $delete = $this->db->where('id_suplier', $id)->delete('suplier');

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
