<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Versions_model class.
 * @extends CI_Model
 */
class Versions_model extends CI_Model
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
     * gets data from the Versions table of the database.
     * @author Peter Kaufman
     * @example get_versions();
     * @since 8-25-17
     * @version 5-31-18
     * @return json object full of version data
     */
    public function get_versions()
    {
        $sql = "SELECT `name`, `version` FROM `versions`;";
        $query = $this->db->query($sql);

        return $query->result();
    }

    /**
     * updates data from the Versions table of the database.
     * @author Peter Kaufman
     * @example update_version( 'foo', '2.3.4' );
     * @since 8-25-17
     * @version 5-31-18
     * @param name the name of the version to update_version
     * @param version the new version of the desired plugin/dependency
     */
    public function update_version($name, $version)
    {
        $this->db->query("UPDATE `versions` SET `version` = '" . $version . "WHERE `name` = '" . $name . "'");
        exit();
    }

    /**
     * removes or adds data from the versions table of the database.
     * @author Peter Kaufman
     * @example update_version_table(1, $data);
     * @since 8-25-17
     * @version 5-31-18
     * @param id determines which query to execute
     * @param data contains the necessary information to change the table
     */
    public function update_version_table($id, $data)
    {
        if ($id == 'remove') {
            $sql = "DELETE FROM `versions` WHERE `name` = '" . $data['name'] . "' ;";
        } else {
            $sql = "INSERT INTO `versions` (`name`, `version`)VALUES ('" . $data['name'] . "', '" . $data['version'] . "');";
        }

        $this->db->query($sql);

        exit();
    }
}
