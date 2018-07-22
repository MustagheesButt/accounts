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
		//$_SESSION = [];
		//$this->session->sess_destroy();
		if ($this->is_logged_in())
		{
			redirect(base_url() . "dashboard");
		}

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
			$this->login_view();
			return;
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

		if ($this->form_validation->run() == FALSE)
		{
			$this->login_view();
			return;
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
		$this->load->model('Access_tokens_model');

		$result = $this->db->where('id', $client_id)->get('oauth_clients')->result();

		if (sizeof($result) < 1)
		{
			die("Invalid client ID.</br>");
		}

		// check session
		if (isset($this->session->email))
		{
			$user_id = $this->User_model->get_user_by_email($this->session->email)[0]->id;
			$access_token = "";

			// An active token exists
			if (
				count($access_token_info = $this->Access_tokens_model->get_by_user_id($user_id)) > 0 &&
				date($access_token_info['expires_on']) > date('Y-M-d h:i:s')
			)
			{
				$access_token = $access_token_info['access_token'];
			}
			// A token for the current user does not exist or has expired
			else
			{
				$access_token = bin2hex(openssl_random_pseudo_bytes(16));

				// TODO: check if the generated access_token doesn't already exists

				$data_new_token = [
					'access_token' => $access_token,
					'user_id' => $user_id,
					'revoked' => '0'
				];
				$this->Access_tokens_model->insert($data_new_token);
			}

			redirect($result[0]->redirect . '?access_token=' . $access_token . '&callback=' . $this->input->get('callback'));
		}

		// verify origin
		$redirect = parse_url($result[0]->redirect); // components of given URL
		$origin = parse_url($_SERVER['HTTP_REFERER']); // components of request URL
		if ($redirect['scheme'] != $origin['scheme'] || $redirect['host'] != $origin['host'])
		{
			//echo "db redirect: " . $result[0]->redirect . "</br>";
			//echo "origin: " . $origin;
			die("</br>Origin not allowed.</br>");
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
