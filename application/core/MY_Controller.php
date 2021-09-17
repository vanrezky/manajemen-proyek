<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_CONTROLLER extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('menu_model', 'menu');
	}

	public function render($view, $data = [])
	{
		$level = $this->session->userdata('user')['level'];

		$menu_array = array();
		$access_menu = $this->menu->get_access_menu($level);

		foreach ($access_menu as $row => $value) {
			if ($value['parent_menu'] == 0) {

				$sub_menu = [];
				foreach ($access_menu as $k => $v) {
					if ($value['id_menu'] == $v['parent_menu']) {
						$sub_menu[] = $v;
					}
				}

				if (!empty($sub_menu)) {
					$menu_array[] = [
						'parent' => $value,
						'sub' => $sub_menu,
					];
				} else {
					$menu_array[] = [
						'parent' => $value,
					];
				}
			}
		}
		$data['menu_array'] = $menu_array;
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/navbar');
		$this->load->view('layouts/sidebar');
		$this->load->view($view);
		$this->load->view('layouts/footer');
	}
}
