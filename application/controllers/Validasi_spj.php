<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validasi_spj extends MY_CONTROLLER
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {

        $data = $this->db
            ->select('*, P.nama nama_proyek, V.nama nama_vendor, PV.id_proyek_vendor')
            ->join('vendor V', 'PV.id_vendor = V.id_vendor', 'INNER')
            ->join('proyek P', 'P.id_proyek = PV.id_proyek', 'INNER')
            ->join('spj S', 'S.id_proyek_vendor = PV.id_proyek_vendor', 'INNER')
            ->where('PV.status', 'proses')
            ->get('proyek_vendor PV')->result_array();

        $D = [
            'title' => 'Validasi SPJ',
            'data' => $data
        ];

        $this->render('v_validasi_spj_index', $D);
    }


    public function detail($id = "")
    {

        $result = $this->db
            ->select('*, P.nama nama_proyek, V.nama nama_vendor, PV.id_proyek_vendor, P.alamat alamat_proyek, V.alamat alamat_vendor, P.nilai_kontrak nilai_kontrak_proyek, S.nilai_kontrak nilai_kontrak_spj')
            ->join('vendor V', 'PV.id_vendor = V.id_vendor', 'INNER')
            ->join('proyek P', 'P.id_proyek = PV.id_proyek', 'INNER')
            ->join('spj S', 'S.id_proyek_vendor = PV.id_proyek_vendor', 'INNER')
            ->where('PV.id_proyek_vendor', $id)
            ->get('proyek_vendor PV')->row_array();



        if ($result) {

            $proyek = [
                'Nomor SPK' => $result['no_spk'],
                'Nama Proyek' => $result['nama_proyek'],
                'Alamat' => $result['alamat_proyek'],
                'Tanggal Proyek' => tanggal($result['mulai']) .  ' >>> ' . tanggal($result['selesai']),
                'nilai Kontrak' => rupiah($result['nilai_kontrak_proyek']),
            ];

            $vendor = [
                'Nama Vendor' => $result['nama_vendor'],
                'PIC' => $result['pic'],
                'Alamat' => $result['alamat_vendor'],
                'Telp' => $result['telp'],
                'Fax' => $result['fax'],
                'Email' => $result['email'],
            ];

            $spj = [
                'Nomor Surat' => $result['no_surat'],
                'Tanggal Surat' => tanggal($result['tgl_surat']),
                'Tanggal Pelaksanaan' => tanggal($result['tgl_mulai']) . ' >>>> ' . tanggal($result['tgl_selesai']),
                'Nilai Kontrak' => rupiah($result['nilai_kontrak_spj']) . ' (' . terbilang($result['nilai_kontrak_spj']) .  ')'
            ];
            $D = [
                'title' => 'Validasi SPJ Proyek ' . $result['nama_proyek'],
                'data' => [
                    'proyek' => $proyek,
                    'vendor' => $vendor,
                    'spj' => $spj,
                    'id_proyek_vendor' => $result['id_proyek_vendor']
                ],
            ];

            $this->render('v_validasi_spj_detail', $D);
        } else {
            show_404();
        }
    }

    public function setuju($id = "")
    {

        if ($this->input->is_ajax_request()) {

            $msg = [
                'success' => false,
                'message' => 'Gagal menyimpan data!'
            ];
            $proyek_vendor = $this->db->get_where('proyek_vendor', ['id_proyek_vendor' => $id])->row_array();

            if ($proyek_vendor) {

                $data = [
                    'status' => 'aktif',
                    'tgl_validasi' => date('Y-m-d'),
                ];

                $update = $this->db->where('id_proyek_vendor', $id)->update('proyek_vendor', $data);

                if ($update) {
                    $msg = [
                        'success' => true,
                        'message' => 'Berhasil menyentujui SPJ!'
                    ];
                }
            }

            echo json_encode($msg);
            exit();
        } else {
            show_404();
        }
    }
}
