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
     * function updates data from the Versions table of the db
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
    /**
     * function removes or adds data from the versions table of the db
     * @access public
     * @author Peter Kaufman
     * @param id determines which query to execute
     * @param data contains the necessary information to change the table
     * @return void
     */
    public function update_version_table($id, $data)
    {
      if( $id == 'remove'){
        $sql = "DELETE FROM versions WHERE name = '" . $data['name'] . "' ;";
      }else{
        $sql = "INSERT INTO versions (name, version)VALUES ('" . $data['name'] . "', '" . $data['version']  . "');";
      }

      $this->db->query($sql);

      exit();
    }
}
