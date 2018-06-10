<?php

class Access_tokens_model extends CI_Model
{
	public $fields = [
		'access_token' => null,
		'user_id' => null,
		'revoked' => null,
		'expires_on' => null,
		'created_at' => null
	];

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insert($data)
	{
		$this->fields['access_token'] = $data['access_token'];
		$this->fields['revoked'] = $data['revoked'];
		$this->fields['expires_on'] = date('Y-m-d h:i:s', strtotime('+1 day'));

		// Insert new
		if (count($this->get_user_id($data['access_token'])) < 1)
		{
			$this->fields['user_id'] = $data['user_id'];
			$this->fields['created_at'] = date('Y-m-d h:i:s');

			$this->db->insert('access_tokens', $this->fields);
		}
		// Refresh already existing
		else
		{
			$this->db->where('user_id', $data['user_id'])->update('access_tokens', $this->fields);
		}
	}

	public function get_user_id($access_token)
	{
		return $this->db->select('user_id')->where('access_token', $access_token)->get('access_tokens')->result()[0]->user_id;
	}

	public function get_by_user_id($user_id)
	{
		return $this->db->select('access_token')->where('user_id', $user_id)->get('access_tokens')->result();
	}

	public function has_expired($access_token)
	{
		return date('Y-m-d h:i:s', strtotime($this->db->select('expires_on')->where('access_token', $access_token)->get('access_tokens')->result()[0]->expires_on)) < date('Y-m-d h:i:s');
	}
}