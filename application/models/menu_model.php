<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Menu_model extends CI_Model
{

    public function get_access_menu($level)
    {
        $this->db->join('menu M', 'M.id_menu = MG.id_menu', 'INNER');
        $this->db->where('MG.level', $level);
        $this->db->order_by('MG.urutan_menu', 'ASC');
        $info = $this->db->get('menu_group MG');
        return $info->result_array();
    }
}
