<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 *
 * @extends CI_Model
 */
class Account_model extends CI_Model {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

  /**
	 * function updates the user's avatar in the db
	 *
	 * @access public
   * @author Peter Kaufman
   * @param avatar is an array
	 *
	 */
	public function update_avatar($avatar){

    $this->db->where('username', $_SESSION['username']);
    $this->db->update('users',  $avatar);
		
	}
}
