<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('my_model', 'model');
    }

    public function index()
    {
        redirect(base_url());
    }

    public function proyek()
    {
        $D = $this->db;
        if (!empty($this->input->get('s'))) {
            $D = $D->group_start()
                ->like('nama', $this->input->get('s'), 'both')
                ->or_like('alamat', $this->input->get('s'), 'both')
                ->group_end();
        }
        $D = $D->get('proyek')->result_array();


        $data = [
            'title' => 'Daftar Proyek',
            'data' => $D,
            'filter' => [
                's' => $this->input->get('s'),
            ]
        ];

        $this->render('v_laporan_proyek', $data);
    }

    public function kas_masuk()
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

        $this->render('v_laporan_kas_masuk', $data);
    }


    public function pinjam_alat()
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
        $this->render('v_laporan_pinjam_alat', $data);
    }

    public function beli_barang()
    {
        $id_proyek = $this->input->get('id_proyek');
        $id_suplier = $this->input->get('id_suplier');

        $D = [
            'title' => 'Daftar Pembelian Barang',
            'data' => $this->model->get_beli_barang($id_proyek, $id_suplier),
            'proyek' => $this->db->get('proyek')->result_array(),
            'suplier' => $this->db->get('suplier')->result_array(),
            'filter' => [
                'id_proyek' => $id_proyek,
                'id_suplier' => $id_suplier,
            ]
        ];

        $this->render('v_laporan_beli_barang', $D);
    }
}
