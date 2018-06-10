<?php

class Api_errors_model extends CI_Model
{
	public $errors = [
		'1' => 'Authentication error.',
		'2' => 'Access token required.',
		'3' => 'Access token expired.',
		'4' => null
	];

	function __construct()
	{
		parent::__construct();
	}
}