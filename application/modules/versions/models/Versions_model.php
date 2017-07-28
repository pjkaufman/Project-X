<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Versions_model class.
 * @extends CI_Model
 */
class Versions_model extends CI_Model {
	/**
	 * __construct function.
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
  /**
	 * function gets data from the Versions table of the db
	 * @access public
   * @author Peter Kaufman
	 * @return json object full of version data
	 */
	public function get_versions(){
		$this->db->Select('name, version');
		$this->db->From('versions');
		$query = $this->db->get();
		return $query->result();
	}
}
