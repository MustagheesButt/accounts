<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function index()
	{
		$this->require_login();

		$data['title'] = 'Dashboard';
		$data['description'] = 'You can manage your account from dashboard.';

		$this->load->view('templates/head', $data);
		$this->load->view('templates/header', $data);
		$this->load->view('dashboard');
		$this->load->view('templates/footer');
	}
}
