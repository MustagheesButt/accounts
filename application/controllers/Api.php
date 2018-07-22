<?php

defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class Api extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Api_errors_model');
		$this->load->model('Access_tokens_model');
	}

	public function user($scope)
	{
		if (!$this->input->get('access_token'))
		{
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(
					['error_code' => '2', 'error' => $this->Api_errors_model->errors['2']]
				));
		}

		// verify access token
		if ($this->Access_tokens_model->has_expired($this->input->get('access_token')))
		{
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(
					['error_code' => '3', 'error' => $this->Api_errors_model->errors['3']]
				));
		}

		$user_id = $this->Access_tokens_model->get_user_id($this->input->get('access_token'));
		$user = $this->User_model->get_user_by_id($user_id);

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
			->set_status_header(200)
			->set_output(json_encode(
				$user
			));
	}
}