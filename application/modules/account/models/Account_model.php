<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Account_model class.
 * @extends CI_Model
 */
class Account_model extends CI_Model {
    /**
     * __construct function.
     */
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    /**
     * function updates the user's avatar in the db.
     * @author Peter Kaufman
     * @param avatar is an array
     */
    public function update_avatar($avatar) {
        $this->db->where('username', $_SESSION['username']);
        $this->db->update('users', $avatar);
    }
}
