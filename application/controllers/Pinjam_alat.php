<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pinjam_alat extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $id_proyek = $this->input->get('id_proyek');
        $D = $this->db
            ->select('*, pinjam_alat.deskripsi')
            ->join('alat', 'alat.id_alat = pinjam_alat.id_alat', 'LEFT')->get_where('pinjam_alat', ['id_proyek' => $id_proyek])->result_array();
        $data = [
            'title' => 'Daftar Peminjaman Alat',
            'data' => $D,
            'proyek' => $this->db->get('proyek')->result_array(),
            'filter' => [
                'id_proyek' => $id_proyek
            ]
        ];
        $this->render('v_pinjam_alat_index', $data);
    }


    public function data($id = "")
    {
        $pinjam_alat = $this->db->get_where('pinjam_alat', ['id_pinjam_alat' => $id])->row_array();

        $data = [
            'title' => empty($pinjam_alat) ? 'Tambah Kas Masuk' : 'Update Kas Masuk',
            'data' => $pinjam_alat,
            'proyek' => $this->db->get('proyek')->result_array(),
            'alat' => $this->db->get('alat')->result_array(),
            'empty' => empty($pinjam_alat) ? true : false,
        ];

        $this->render('v_pinjam_alat_data', $data);
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {

            $csrf = csrf_hash();

            $validation = $this->form_validation;

            $validation->set_rules("id_proyek", "Proyek", "trim|required", [
                'required' => "{field} tidak boleh kosong",
            ]);
            $validation->set_rules("id_alat", "Alat", "trim|required", [
                'required' => "{field} tidak boleh kosong",
            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                $timeStamp = current_timestamp();
                $data = [
                    'id_proyek' => $input['id_proyek'],
                    'id_alat' => $input['id_alat'],
                    'deskripsi' => $input['deskripsi'],
                    'status' => $input['status'],
                    'created_at' => $timeStamp,
                    'updated_at' => $timeStamp,
                ];

                if ($this->db->insert('pinjam_alat', $data)) {
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
                        'id_proyek' => form_error('id_proyek'),
                        'id_alat' => form_error('id_alat')
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
            $validation->set_rules("id_proyek", "Proyek", "trim|required", [
                'required' => "{field} tidak boleh kosong",
            ]);
            $validation->set_rules("id_alat", "Alat", "trim|required", [
                'required' => "{field} tidak boleh kosong",
            ]);

            if ($validation->run() === true) {

                $timeStamp = current_timestamp();
                $data = [
                    'id_proyek' => $input['id_proyek'],
                    'id_alat' => $input['id_alat'],
                    'deskripsi' => $input['deskripsi'],
                    'status' => $input['status'],
                    'updated_at' => $timeStamp,
                ];

                $update = $this->db->where('id_pinjam_alat', $id)->update('pinjam_alat', $data);

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
                        'id_proyek' => form_error('id_proyek'),
                        'id_alat' => form_error('id_alat'),
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

            $pinjam_alat = $this->db->get_where('pinjam_alat', ['id_pinjam_alat' => $id])->row_array();

            if ($pinjam_alat) {

                $delete = $this->db->where('id_pinjam_alat', $id)->delete('pinjam_alat');

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
