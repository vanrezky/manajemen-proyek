<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beli_barang extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('my_model', 'model');
    }

    public function index()
    {
        $id_proyek = $this->input->get('id_proyek');

        $D = [
            'title' => 'Daftar Pembelian Barang',
            'data' => $this->model->get_beli_barang($id_proyek),
            'proyek' => $this->db->get('proyek')->result_array(),
            'filter' => [
                'id_proyek' => $id_proyek
            ]
        ];

        $this->render('v_beli_barang_index', $D);
    }


    public function data($id = "")
    {
        $beli_barang = $this->db->get_where('beli_barang', ['id_beli_barang' => $id])->row_array();

        $data = [
            'title' => empty($beli_barang) ? 'Tambah Pembelian Barang' : 'Update Pembelian Barang',
            'data' => $beli_barang,
            'detail' => $this->db->get_where('beli_barang_detail', ['id_beli_barang' => $beli_barang['id_beli_barang']])->result_array(),
            'proyek' => $this->db->get('proyek')->result_array(),
            'barang' => $this->db->get('barang')->result_array(),
            'suplier' => $this->db->get('suplier')->result_array(),
            'empty' => empty($beli_barang) ? true : false,
        ];

        $this->render('v_beli_barang_data', $data);
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {


            $csrf = csrf_hash();

            $validation = $this->form_validation;

            $validation->set_rules("id_proyek", "Proyek", "trim|required", [
                'required' => "{field} tidak boleh kosong",
            ]);

            if ($validation->run() === true) {

                $input = $this->input->post();
                $timeStamp = current_timestamp();
                $data = [
                    'id_proyek' => $input['id_proyek'],
                    'id_suplier' => $input['id_suplier'],
                    'tgl_beli_barang' => $input['tgl_beli_barang'],
                    'deskripsi' => $input['deskripsi'],
                    'grand_total' => $input['grand_total'],
                    'created_at' => $timeStamp,
                    'updated_at' => $timeStamp,
                ];

                if ($id = $this->model->beli_barang_id($data)) {
                    $detail = $this->input->post('detail');
                    $d_insert = [];
                    foreach ($detail as $key => $value) {
                        $value['id_beli_barang'] = $id;
                        $d_insert[] = $value;
                    }

                    if ($this->db->insert_batch('beli_barang_detail', $d_insert)) {
                        $msg = [
                            'success' => true,
                            'message' => 'Data berhasil disimpan!'
                        ];
                    } else {
                        $this->db->where('id_beli_barang', $id)->delete('beli_barang');
                        $msg = [
                            'success' => false,
                            'message' => 'Terjadi kesalahan saat menyimpan data'
                        ];
                    }
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

            if ($validation->run() === true) {

                $timeStamp = current_timestamp();
                $data = [
                    'id_proyek' => $input['id_proyek'],
                    'id_suplier' => $input['id_suplier'],
                    'tgl_beli_barang' => $input['tgl_beli_barang'],
                    'deskripsi' => $input['deskripsi'],
                    'grand_total' => $input['grand_total'],
                    'updated_at' => $timeStamp,
                ];

                $update = $this->db->where('id_beli_barang', $id)->update('beli_barang', $data);
                $d_insert = [];
                if ($update) {

                    foreach ($input['detail'] as $key => $value) {
                        if (isset($value['id_beli_barang_detail'])) {

                            if (isset($value['beli_barang_deleted'])) {
                                $this->db->where('id_beli_barang_detail', $value['id_beli_barang_detail'])->delete('beli_barang_detail');
                            } else {
                                unset($value['id_beli_barang']);
                                $this->db->where('id_beli_barang_detail', $value['id_beli_barang_detail'])->update('beli_barang_detail', $value);
                            }
                        } else {
                            $value['id_beli_barang'] = $id;
                            $d_insert[] = $value;
                        }
                    }


                    if (!empty($d_insert)) {
                        $this->db->insert_batch('beli_barang_detail', $d_insert);
                    }
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

            $beli_barang = $this->db->get_where('beli_barang', ['id_beli_barang' => $id])->row_array();

            if ($beli_barang) {

                $delete = $this->db->where('id_beli_barang', $id)->delete('beli_barang');

                if ($delete) {
                    $this->db->where('id_beli_barang', $id)->delete('beli_barang_detail');
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


    public function detail($id = "")
    {
        $beli_barang = $this->db
            ->select('BB.*, P.nama nama_proyek, S.nama nama_suplier')
            ->join('proyek P', 'P.id_proyek = BB.id_proyek', 'LEFT')
            ->join('suplier S', 'S.id_suplier = BB.id_suplier', 'LEFT')
            ->get_where('beli_barang BB', ['BB.id_beli_barang' => $id])->row_array();

        $detail = $this->db
            ->join('barang B', 'B.id_barang = BBD.id_barang')
            ->get_where('beli_barang_detail BBD', ['BBD.id_beli_barang' => $beli_barang['id_beli_barang']])->result_array();

        if ($beli_barang) {
            $data = [
                'title' => 'Detail Pembelian Barang',
                'data' => $beli_barang,
                'detail' => $detail,
                'proyek' => $this->db->get('proyek')->result_array(),
                'barang' => $this->db->get('barang')->result_array(),
                'suplier' => $this->db->get('suplier')->result_array(),
                'empty' => empty($beli_barang) ? true : false,
            ];

            $this->render('v_beli_barang_detail', $data);
        } else {
            show_404();
        }
    }
}
