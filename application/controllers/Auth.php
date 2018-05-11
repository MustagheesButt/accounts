<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library('form_validation');
	}

	public function login_view()
	{
		$_SESSION = [];
		$this->session->sess_destroy();

		$data['title'] = 'Login';
		$data['description'] = 'Login to your NotesNetwork account.';

		$this->load->view('templates/head', $data);
		$this->load->view('templates/header', $data);
		$this->load->view('auth/login');
		$this->load->view('templates/footer');
	}

	public function login()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		// Validating Email Field
		$this->form_validation->set_rules('emailOrUsername', 'Email Or Username', 'required|callback_user_exists'); // calls user_exists method
		$this->form_validation->set_message('user_exists', 'The username or email does not exist.');

		// Validating Password
		$this->form_validation->set_rules('password', 'Password', 'required|callback_authenticate[' . $this->input->post('emailOrUsername') . ']'); // calls authenticate method with 2nd parameter between []
		$this->form_validation->set_message('authenticate', 'Bad username/email and password combination.');

		if ($this->form_validation->run() == FALSE)
		{
			redirect(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY));
		}

		// Set session variables
		$result = $this->User_model->get_user_by_email_or_username($this->input->post('emailOrUsername'))[0];

		$this->session->username = $result->username;
		$this->session->email = $result->email;
		$this->session->first_name = $result->first_name;
		$this->session->last_name = $result->last_name;

		// TODO: set last_login_*** fields

		// Now redirect
		if ($this->input->post('continue'))
		{
			redirect($this->input->post('continue'));
		}

		redirect('dashboard');
	}

	public function register()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		// Validating Name Field
		$this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[2]|max_length[30]');

		// Validating Email Field
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');

		// Validating Password
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[50]');

		// Validating Password confirmation
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[password]');

		// Validating Mobile no. Field
		$this->form_validation->set_rules('mobile_number', 'Mobile/Phone Number', 'regex_match[/^[0-9]{10}$/]');

		if ($this->form_validation->run() == FALSE) {
			redirect(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY));
		}

		// Insert into table
		$this->User_model->insert($this->input->post());

		// Set session variables
		$this->session->username = $this->input->post('email');
		$this->session->email = $this->input->post('email');
		$this->session->first_name = $this->input->post('first_name');
		$this->session->last_name = $this->input->post('last_name');

		// TODO: Send verification email

		// Now redirect
		if ($this->input->post('continue'))
		{
			redirect($this->input->post('continue'));
		}

		redirect('dashboard');
	}

	public function logout()
	{
		$_SESSION = [];
		$this->session->sess_destroy();

		redirect(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)); // redirect back
	}

	public function service_login($client_id)
	{
		$this->load->database();

		$result = $this->db->where('id', $client_id)->get('oauth_clients')->result();

		if (sizeof($result) < 1)
		{
			die("Invalid client ID.</br>");
		}

		// check session
		if (isset($this->session->email))
		{
			$data_to_send = $this->User_model->get_user_by_email($this->session->email)[0];
			$data_to_send->sess_id = $this->input->get('sess_id');

			$ch = curl_init( $result[0]->redirect );
			curl_setopt( $ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_to_send);
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt( $ch, CURLOPT_HEADER, 0);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec( $ch );

			//die($response);

			redirect($this->input->get('next'));
		}

		$origin = $_SERVER['HTTP_REFERER'];

		// verify origin
		if (substr($result[0]->redirect, 0, strlen($origin)) !== $origin)
		{
			die("Origin not allowed.</br>");
		}

		$this->require_login();
	}

	/* Utility */
	public function user_exists($emailOrUsername)
	{
		$result = $this->User_model->get_user_by_email_or_username($emailOrUsername);

		if (sizeof($result) < 1)
		{
			return FALSE;
		}

		return TRUE;
	}

	public function authenticate($password, $emailOrUsername)
	{
		if ($this->user_exists($emailOrUsername))
		{
			$user_password = $this->User_model->get_user_password($emailOrUsername);

			if (password_verify($password, $user_password))
			{
				return TRUE;
			}
		}

		return FALSE;
	}
}
