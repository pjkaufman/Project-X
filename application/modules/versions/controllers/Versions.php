<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Versions extends MX_Controller
{
    /**
       * __construct function.
       * @access public
       * @return void
       */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->model('versions_model');
        $this->set_module($this);
        $this->logged_in();
    }
    /**
     * index function calls get_essentials and loads the home view
     * @access public
     * @author Peter Kaufman
     * @example base_url() . 'index.php/versions'
     */
    public function index()
    {
        $this->update_title('Version Info');
        $this->get_essentials();
        $this->load->view('versions');
    }
    /**
     * get_versions_data function calls to get_versions to get version data
     * @access public
     * @author Peter Kaufman
     * @example base_url() . 'index.php/get_version_data'
     * @return json object
     */
    public function get_version_data()
    {
        exit(json_encode($this->versions_model->get_versions()));
    }
    /**
     * update_version function calls to update_version to update version data
     * @access public
     * @author Peter Kaufman
     * @example base_url() . 'index.php/update_version'
     * @return void
     */
    public function update_version()
    {
        if ($_POST['version'] != '') {
            $this->versions_model->update_version($_POST['name'], $_POST['version']);
        }
        exit();
    }
}
