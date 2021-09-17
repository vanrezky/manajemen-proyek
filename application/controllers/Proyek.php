<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proyek extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {


        $D = $this->db->get('proyek')->result_array();
        $data = [
            'title' => 'Daftar Proyek',
            'data' => $D,
        ];

        $this->render('v_proyek_index', $data);
    }


    public function data($id = "")
    {
        $proyekData = $this->db->get_where('proyek', ['id_proyek' => $id])->row_array();

        $data = [
            'title' => empty($proyekData) ? 'Tambah Proyek' : 'Update Proyek',
            'data' => $proyekData,
            'empty' => empty($proyekData) ? true : false,
        ];

        $this->render('v_proyek_data', $data);
    }


    public function detail($id)
    {
        $data = $this->db->get_where('proyek', ['id_proyek' => $id])->row_array();

        if ($data) {

            $D = [
                'title' => 'Detail Proyek',
                'data' => $data
            ];
            $this->render('v_proyek_detail', $D);
        } else {
            show_404();
        }
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;
            $validation->set_rules("nama", "Nama Proyek", "trim|required", [
                'required' => "{field} tidak boleh kosong",

            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                $timeStamp = current_timestamp();
                $data = [
                    'nama' => $input['nama'],
                    'no_spk' => $input['no_spk'],
                    'alamat' => $input['alamat'],
                    'mulai' => $input['mulai'],
                    'selesai' => $input['selesai'],
                    'nilai_kontrak' => $input['nilai_kontrak'],
                    'status' => $input['status'],
                    'created_at' => $timeStamp,
                    'updated_at' => $timeStamp,
                ];

                if ($this->db->insert('proyek', $data)) {
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
            $validation->set_rules("nama", "Nama Proyek", "trim|required", [
                'required' => "{field} tidak boleh kosong",
                'numeric' => "{field} harus berupa angka",
            ]);
            if ($validation->run() === true) {

                $timeStamp = current_timestamp();
                $data = [
                    'nama' => $input['nama'],
                    'no_spk' => $input['no_spk'],
                    'alamat' => $input['alamat'],
                    'mulai' => $input['mulai'],
                    'selesai' => $input['selesai'],
                    'nilai_kontrak' => $input['nilai_kontrak'],
                    'status' => $input['status'],
                    'updated_at' => $timeStamp,
                ];

                $update = $this->db->where('id_proyek', $id)->update('proyek', $data);

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


    public function delete($id)
    {
        if ($this->input->is_ajax_request()) {
            $msg = [
                'success' => false,
                'message' => 'Data tidak ditemukan!'
            ];

            $proyek = $this->db->get_where('proyek', ['id_proyek' => $id])->row_array();

            if ($proyek) {

                $delete = $this->db->where('id_proyek', $id)->delete('proyek');

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


    public function detail_pekerjaan($id = "")
    {


        $proyek = $this->db->get_where('proyek', ['id_proyek' => $id])->row_array();

        if ($proyek) {

            $detail_pekerjaan = $this->db->get_where('proyek_detail_pekerjaan', ['id_proyek' => $id])->result_array();
            $parent = [];
            foreach ($detail_pekerjaan as $key => $value) {

                if ($value['parent_detail'] == 0) {
                    $parent[] = $value;
                }
            }

            $data = [
                'title' => 'Daftar Detail Pekerjaan Proyek',
                'data' => $proyek,
                'parent' => $parent,
                'detail' => $detail_pekerjaan
            ];

            $this->render('v_proyek_detail_pekerjaan', $data);
        } else {
            show_404();
        }
    }

    public function detail_pekerjaan_save()
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;
            $validation->set_rules("deskripsi", "Deskripsi", "trim|required", [
                'required' => "{field} tidak boleh kosong",

            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                if ($input['tipe'] == 'header') {
                    $data  = [
                        'id_proyek' => $input['id_proyek'],
                        'deskripsi' => $input['deskripsi'],
                        'tipe' => 'header',
                        'summary' => $input['summary'],
                    ];
                } else {
                    $data = [
                        'id_proyek' => $input['id_proyek'],
                        'deskripsi' => $input['deskripsi'],
                        'qty' => $input['qty'],
                        'satuan' => $input['satuan'],
                        'harga_satuan' => $input['harga_satuan'],
                        'total_harga' => $input['total_harga'],
                        'tipe' => 'detail',
                        'parent_detail' => $input['parent_detail'],
                    ];
                }


                if ($this->db->insert('proyek_detail_pekerjaan', $data)) {
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
                        'deskripsi' => form_error('deskripsi')
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

    public function detail_pekerjaan_data($id = "")
    {

        $detail = $this->db
            ->join('proyek P', 'P.id_proyek = DP.id_proyek', 'INNER')
            ->get_where('proyek_detail_pekerjaan DP', ['DP.id_detail' => $id])->row_array();

        $parent = $this->db->get_where('proyek_detail_pekerjaan', ['tipe' => 'header'])->result_array();

        $data = [
            'title' => 'Update Detail Pekerjaan',
            'data' => $detail,
            'parent' => $parent
        ];

        $this->render('v_proyek_detail_pekerjaan_data', $data);
    }

    public function detail_pekerjaan_update($id)
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;
            $validation->set_rules("deskripsi", "Deskripsi", "trim|required", [
                'required' => "{field} tidak boleh kosong",

            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                if ($input['tipe'] == 'header') {
                    $data  = [
                        'deskripsi' => $input['deskripsi'],
                        'summary' => $input['summary'],
                    ];
                } else {
                    $data = [
                        'deskripsi' => $input['deskripsi'],
                        'qty' => $input['qty'],
                        'satuan' => $input['satuan'],
                        'harga_satuan' => $input['harga_satuan'],
                        'total_harga' => $input['total_harga'],
                        'parent_detail' => $input['parent_detail'],
                    ];
                }
                $update = $this->db->where('id_detail', $id)->update('proyek_detail_pekerjaan', $data);

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
                    'message' => 'Periksa kembali data yang ingin anda update',
                    'errors' => [
                        'deskripsi' => form_error('deskripsi')
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

    public function detail_pekerjaan_delete($id)
    {
        if ($this->input->is_ajax_request()) {
            $msg = [
                'success' => false,
                'message' => 'Data tidak ditemukan!'
            ];

            $detail_pekerjaan = $this->db->get_where('proyek_detail_pekerjaan', ['id_detail' => $id])->row_array();

            if ($detail_pekerjaan) {

                $delete = $this->db->where('id_detail', $id)->delete('proyek_detail_pekerjaan');

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
            exit();
        }
    }
}
