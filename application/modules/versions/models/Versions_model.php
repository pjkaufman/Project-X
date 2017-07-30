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
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**
       * function gets data from the Versions table of the db
       * @access public
     * @author Peter Kaufman
       * @return json object full of version data
       */
    public function get_versions()
    {
        $this->db->Select('name, version');
        $this->db->From('versions');
        $query = $this->db->get();
        return $query->result();
    }
    /**
     * function gets data from the Versions table of the db
     * @access public
     * @author Peter Kaufman
     * @param name the name of the version to update_version
     * @param version the new version of the desired plugin/dependency
     * @return void
     */
    public function update_version($name, $version)
    {
        $this->db->query("UPDATE versions SET version = '". $version. "WHERE name = '" . $name ."'");
        exit();
    }
}
