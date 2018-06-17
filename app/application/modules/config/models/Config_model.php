<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Config_model class.
 * @extends CI_Model
 */
class Config_model extends CI_Model {
    /**
     * __construct function.
     */
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    /**
     * updates data from the Config table of the db.
     * @author Peter Kaufman
     * @example update_timezone('UTC');
     * @since 8-25-17
     * @version 6-12-18
     * @param value the new value of the desired configuration setting
     */
    public function update_timezone($value) {
        $_SESSION['timezone'] = $value;
        $sql = "UPDATE `config` SET `value` = '" . $value . "' WHERE `name` = 'timezone'";
        $this->db->query($sql);
        exit();
    }
}
