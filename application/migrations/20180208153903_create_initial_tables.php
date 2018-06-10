<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_initial_tables extends CI_Migration
{
	public function up()
	{
		/* Globals */
		$attributes = array('ENGINE', 'InnoDB');

		/* Create Table: users */
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),

			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '120'
			),
			'middle_name' => array(
				'type' => 'VARCHAR',
				'null' => TRUE,
				'constraint' => '120'
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '120'
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '191',
				'unique' => TRUE
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '191',
				'unique' => TRUE
			),
			'password' => array(
				'type' => 'TEXT'
			),
			'birthdate' => array(
				'type' => 'DATE'
			),
			'gender' => array(
				'type' => 'VARCHAR',
				'constraint' => '1'
			),

			'mobile_number' => array(
				'type' => 'VARCHAR',
				'constraint' => '191',
				'null' => TRUE
			),
			'email_verified' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'linked_FB' => array(
				'type' => 'TEXT',
				'null' => TRUE,
				'default' => null
			),
			'linked_GP' => array(
				'type' => 'TEXT',
				'null' => TRUE,
				'default' => null
			),

			'created_at' => array(
				'type' => 'DATETIME'
			),
			'updated_at' => array(
				'type' => 'DATETIME'
			),

			'last_login_at' => array(
				'type' => 'DATETIME'
			),
			'last_login_from_system' => array(
				'type' => 'TEXT'
			),
			'last_login_from_ip' => array(
				'type' => 'VARCHAR',
				'constraint' => '45'
			)
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users', TRUE, $attributes);

		/* Create Table: ouath_clients */
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'BIGINT',
				'unsigned' => TRUE
			),
			'name' => array(
				'type' => 'TEXT',
				'constraint' => '120'
			),
			'secret' => array(
				'type' => 'TEXT'
			),
			'redirect' => array(
				'type' => 'TEXT'
			),
			'revoked' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'created_at' => array(
				'type' => 'DATETIME'
			),
			'updated_at' => array(
				'type' => 'DATETIME'
			)
		));

		$this->dbforge->add_key('id', TRUE); // TRUE for primary key
		$this->dbforge->create_table('oauth_clients', TRUE, $attributes); // TRUE for adding IF NOT EXISTS

		/* Create Table: access_tokens */
		$this->dbforge->add_field(array(
			'access_token' => array(
				'type' => 'VARCHAR',
				'constraint' => '32'
			),
			'user_id' => array(
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'unique' => TRUE
			),
			'revoked' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'expires_on' => array(
				'type' => 'DATETIME'
			),
			'created_at' => array(
				'type' => 'DATETIME'
			)
		));

		$this->dbforge->add_key('access_token', TRUE); // TRUE for primary key
		$this->dbforge->create_table('access_tokens', TRUE, $attributes); // TRUE for adding IF NOT EXISTS
	}

	public function down()
	{
		$this->dbforge->drop_table('users');
		$this->dbforge->drop_table('oauth_clients');
		$this->dbforge->drop_table('access_tokens');
	}
}
