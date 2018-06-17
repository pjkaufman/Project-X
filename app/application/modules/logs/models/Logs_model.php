<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Log_model class.
 * @extends CI_Model
 */
class Logs_model extends CI_Model
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
     * gets data from the logins table of the database.
     * @author Peter Kaufman
     * @since 8-25-17
     * @version 5-31-18
     * @return array full of login data
     */
    public function get_logs()
    {
        $sql = "SELECT `username` AS `Username`, `datestamp` AS `Date`, login AS `Login`, `logout` AS `Logout` FROM `logins` WHERE `datestamp` BETWEEN '" . $_SESSION['sql']['start'] . "' AND '" . $_SESSION['sql']['end'] . "';";
        $query = $this->db->query($sql);

        return $query->result();
    }
}
