<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 *
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @author Hedii
	 * @return void
	 */
	public function __construct() {

		parent::__construct();
		$this->load->database();

	}

	/**
	 * create_user adds a new user to the users database
	 *
	 * @access public
	 * @author Hedii
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($username, $email, $password) {

		$data = array(
			'username'   => $username,
			'email'      => $email,
			'password'   => $this->hash_password($password),
			'created_at' => date('Y-m-j H:i:s'),
		);

		return $this->db->insert('users', $data);

	}

	/**
	 * resolve_user_login compares the password of the user to determine if the credentials match
	 *
	 * @access public
	 * @author Hedii
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($username, $password) {

		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('username', $username);
		$hash = $this->db->get()->row('password');

		return $this->verify_password_hash($password, $hash);

	}

	/**
	 * get_user_id_from_username gets the user's id from username
	 *
	 * @access public
	 * @author Hedii
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {

		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);

		return $this->db->get()->row('id');

	}

	/**
	 * get_user gets the user's information based on $user_id
	 *
	 * @access public
	 * @author Hedii
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {

		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();

	}

	/**
	 * hash_password hashes the password
	 *
	 * @access private
	 * @author Hedii
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password){

		return password_hash($password, PASSWORD_BCRYPT);

	}

	/**
	 * verify_password_hash verfies that $password will be hashed
	 *
	 * @access private
	 * @author Hedii
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash){

		return password_verify($password, $hash);

	}

	/**
	 * update_login_data updates the last_login and num_logins in the users table
	 *
	 * @access public
	 * @author Peter Kaufman
	 *
	 */
	public function update_login_data(){

		$date = new DateTime();
		$data = array(
				'num_logins'		=> $_SESSION['num_logins'] + 1,
				'last_login'		=> $date->format('Y-m-d H:i:s')
		);
		$this->db->where('username', $_SESSION['username']);
		$this->db->update('users',  $data);
		$_SESSION['last_login']		= (string)$data['last_login'];
		$_SESSION['num_logins']		= (int)$data['num_logins'];

	}
}
