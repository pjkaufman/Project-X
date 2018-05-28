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
     * function updates data from the Config table of the db.
     * @author Peter Kaufman
     * @param name the name of the setting to update
     * @param value the new value of the desired configuration setting
     */
    public function updateTimezone($value) {
        $_SESSION['timezone'] = $value;
        $sql = "UPDATE `config` SET `value` = '" . $value . "' WHERE `name` = 'timezone'";
        $this->db->query($sql);
        exit();
    }
}
