<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }


    private function generate($param = [], $view = "", $data = [], $name = "", $param2 = [], $cetak = FALSE, $download = FALSE)
    {
        ob_clean();
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load([
            "format" => isset($param[4]) ? $param[4] : "A4-L",
            # "format" => [215, 329], # F4 Size (mm)
            "orientation" => isset($param[5]) ? $param[5] : "L",
            "mgl"    => isset($param[3]) ? $param[3] : 0,
            "mgr"    => isset($param[1]) ? $param[1] : 0,
            "mgt"    => isset($param[0]) ? $param[0] : 0,
            "mgb"    => isset($param[2]) ? $param[2] : 0,
        ]);


        $out = $this->load->view($view, ["data" => $data], true);
        $pdf->WriteHTML($out);
        $pdf->Output("$name.pdf", "I");

        # I => browser output
        # F => local save
        # S => return as string
        # D => download
        // $pdf->Output("$name.pdf", "D");
    }

    public function proyek($id)
    {
        $proyekData = $this->db->get_where('proyek', ['id_proyek' => $id])->row_array();
        if ($proyekData) {
            $detail_pekerjaan = $this->db->get_where('proyek_detail_pekerjaan', ['id_proyek' => $id])->result_array();
            $parent = [];
            foreach ($detail_pekerjaan as $key => $value) {

                if ($value['parent_detail'] == 0) {
                    $parent[] = $value;
                }
            }

            $data = [
                'title' => 'Daftar Proyek',
                'data' => $proyekData,
                'parent' => $parent,
                'detail' => $detail_pekerjaan
            ];
            $this->generate(
                [40, 5, 5, 5, "A4-P", "P"],
                "pdf/v_pdf_proyek",
                $data,
                $data['title']
            );
        } else {
            show_404();
        }
    }


    public function proyek_massal($param)
    {

        $param = decode($param);

        $D = $this->db;
        if (!empty($param['s'])) {
            $D = $D->group_start()
                ->like('nama', $param['s'], 'both')
                ->or_like('alamat', $param['s'], 'both')
                ->group_end();
        }
        $D = $D->get('proyek')->result_array();

        if ($D) {
            $data_array = [];
            foreach ($D as $key => $value) {

                $detail_pekerjaan = $this->db->get_where('proyek_detail_pekerjaan', ['id_proyek' => $value['id_proyek']])->result_array();
                $parent = [];
                foreach ($detail_pekerjaan as $k => $v) {

                    if ($v['parent_detail'] == 0) {
                        $parent[] = $v;
                    }
                }

                $data_array[] = [
                    'data' => $value,
                    'detail' => $detail_pekerjaan,
                    'parent' => $parent
                ];
            }



            $data = [
                'title' => 'Daftar Proyek',
                'data' => $data_array,
            ];

            $this->generate(
                [40, 5, 5, 5, "A4-P", "P"],
                "pdf/v_pdf_proyek_massal",
                $data,
                $data['title']
            );
        } else {
            show_404();
        }
    }


    public function kas_masuk($param)
    {

        $param = decode($param);
        $id_proyek = $param['id_proyek'];
        $D = $this->db->get_where('kas_masuk', ['id_proyek' => $id_proyek])->result_array();
        if ($D) {
            $proyek = $this->db->get_where('proyek', ['id_proyek' => $id_proyek])->row_array();
            $data = [
                'title' => 'Daftar Kas Masuk',
                'detail' => $D,
                'data' => $proyek,
            ];

            $this->generate(
                [40, 5, 5, 5, "A4-P", "P"],
                "pdf/v_pdf_kas_masuk",
                $data,
                $data['title']
            );
        } else {
            show_404();
        }
    }


    public function pinjam_alat($param)
    {

        $param = decode($param);
        $id_proyek = $param['id_proyek'];
        $D = $this->db
            ->join('alat', 'alat.id_alat = pinjam_alat.id_alat', 'left')
            ->get_where('pinjam_alat', ['id_proyek' => $id_proyek])->result_array();
        if ($D) {
            $proyek = $this->db->get_where('proyek', ['id_proyek' => $id_proyek])->row_array();
            $data = [
                'title' => 'Daftar Kas Masuk',
                'detail' => $D,
                'data' => $proyek,
            ];

            $this->generate(
                [40, 5, 5, 5, "A4-P", "P"],
                "pdf/v_pdf_pinjam_alat",
                $data,
                $data['title']
            );
        } else {
            show_404();
        }
    }

    public function beli_barang($id)
    {

        $beli_barang = $this->db
            ->select('BB.*, P.nama nama_proyek, P.alamat alamat_proyek, S.nama nama_suplier, S.alamat alamat_suplier')
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
            ];

            $this->generate(
                [40, 5, 5, 5, "A4-P", "P"],
                "pdf/v_pdf_beli_barang",
                $data,
                $data['title']
            );
        } else {
            show_404();
        }
    }
}
