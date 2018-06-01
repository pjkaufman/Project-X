<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Account_model class.
 * @extends CI_Model
 */
class Account_model extends CI_Model
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    /**
     * updates the user's avatar in the database.
     * @author Peter Kaufman
     * @example update_avatar('blob.jpg');
     * @since 8-25-17
     * @version 5-31-18
     * @param avatar is an array
     */
    public function update_avatar($avatar)
    {
        $sql = "UPDATE `users` SET `avatar`='" . $avatar['avatar'] . "' WHERE `username` = '" . $_SESSION['username'] . "';";
        $this->db->query($sql);
    }
}
