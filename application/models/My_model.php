<?php


class My_model extends CI_Model
{

    public function get_beli_barang($id_proyek = "", $id_suplier = "")
    {
        $DB = $this->db;
        $DB->select('beli_barang.*, proyek.nama nama_proyek');
        $DB->join('proyek', 'proyek.id_proyek = beli_barang.id_proyek', 'LEFT');
        if (!empty($id_proyek)) {
            $DB->where('beli_barang.id_proyek', $id_proyek);
        }
        if (!empty($id_suplier)) {
            $DB->where('beli_barang.id_suplier', $id_suplier);
        }
        return $DB->get('beli_barang')->result_array();
    }


    public function beli_barang_id($data)
    {

        $this->db->insert('beli_barang', $data);
        return $this->db->insert_id();
    }
}
