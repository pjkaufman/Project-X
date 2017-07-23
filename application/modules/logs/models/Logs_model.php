<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 *
 * @extends CI_Model
 */
class Logs_model extends CI_Model {

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
	 * function gets data from the logins table of the db
	 *
	 * @access public
   * @author Peter Kaufman
	 * @return array full of login data
   *
	 */
	public function get_logs(){
    $this->db->select('username as Username, datestamp as Date, login as Login, logout as Logout');
    $this->db->from('logins');
    $query = $this->db->get();
    return $query->result();
	}
}
