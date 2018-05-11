<?php

class User_model extends CI_Model
{
	private $protected = ['password'];
	public $fields = [
		'first_name' => null,
		'middle_name' => null,
		'last_name' => null,
		'email' => null,
		'username' => null,
		'password' => null,
		'birthdate' => null,
		'gender' => null,
		'mobile_number' => null,
		'email_verified' => null,
		'linked_FB' => null,
		'linked_GP' => null,
		'created_at' => null,
		'updated_at' => null
	];

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insert($data)
	{
		$this->fields['first_name'] = $data['first_name'];
		$this->fields['middle_name'] = $data['middle_name'];
		$this->fields['last_name'] = $data['last_name'];
		$this->fields['email'] = $data['email'];
		$this->fields['username'] = $data['email'];

		$this->fields['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

		$this->fields['birthdate'] = $data['birthdate'];
		$this->fields['gender'] = $data['gender'];
		
		$this->fields['mobile_number'] = $data['mobile_number'];
		$this->fields['email_verified'] = FALSE;
		
		$this->fields['created_at'] = date('Y-m-d h:i:s');
		$this->fields['updated_at'] = date('Y-m-d h:i:s');

		/* TODO: set last_login_*** fields **/
		
		$this->db->insert('users', $this->fields);
	}

	public function get_user_by_email($email)
	{
		return $this->filter($this->db->where('email', $email)->get('users')->result());
	}

	public function get_user_by_username($username)
	{	
		return $this->filter($this->db->where('username', $username)->get('users')->result());
	}

	public function get_user_by_email_or_username($emailOrUsername)
	{
		$user;
		if (sizeof($user = $this->get_user_by_email($emailOrUsername)) > 0)
		{
			return $user;
		}

		return $this->get_user_by_username($emailOrUsername);
	}

	public function filter($user)
	{
		foreach ($this->protected as $filter_out)
		{
			unset($user[0]->$filter_out);
		}

		return $user;
	}

	public function get_user_password($emailOrUsername)
	{
		return $this->db->select('password')->where('email', $emailOrUsername)->or_where('username', $emailOrUsername)->get('users')->result()[0]->password;
	}
}