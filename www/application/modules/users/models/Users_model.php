<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Users_model class.
 * @extends CI_Model
 */
class Users_model extends CI_Model
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
     * gets data from the users table of the database.
     * @author Peter Kaufman
     * @example get_users();
     * @since 8-25-17
     * @version 5-31-18
     * @return json object full of version data
     */
    public function get_users()
    {
        $sql = "SELECT `id` AS `ID`, `username` AS `Username`, `email` AS `Email`, `created_at` AS `Created At`, CASE `is_admin` WHEN 1 THEN 'Admin' WHEN 0 THEN 'User' END AS `Status`, `last_login` AS `Last Login`, `num_logins` AS `Number of Logins` FROM `users`;";
        $query = $this->db->query($sql);

        return $query->result();
    }
}
