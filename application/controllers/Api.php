<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	public function user($scope)
	{
		$this->require_login();

		$user = $this->User_model->get_user_by_email($this->session->email);

		if (sizeof($user) < 1)
		{
			die("Something went wrong. The logged in user could not be found!");
		}

		$user = $user[0];

		// remove anything not in the scope
		$scope = explode('.', $scope);
		foreach ($user as $key => $value)
		{
			if (!in_array($key, $scope))
			{
				unset($user->$key);
			}
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header(500)
			->set_output(json_encode(
				$user
			));
	}
}