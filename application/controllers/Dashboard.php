<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_CONTROLLER
{

	function __construct()
	{
		parent::__construct();

		is_logged_in();
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard'
		];
		$this->render('v_dashboard_index', $data);
	}
}
