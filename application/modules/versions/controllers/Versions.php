<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Versions extends MX_Controller
{
    /**
       * __construct function.
       */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('versions_model');
        $this->set_module($this);
        $this->logged_in();
    }

    /**
     * calls get_essentials and loads the home view.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/versions'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function index()
    {
        $this->update_title('Version Info');
        $this->get_essentials();
        $this->load->view('versions');
    }

    /**
     * calls to get_versions to get version data.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/get_version_data'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function get_version_data()
    {
        exit(json_encode($this->versions_model->get_versions()));
    }

    /**
     * calls to update_version to update version data.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/update_version'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function update_version()
    {
        if ($_POST['version'] != '') {
            $this->versions_model->update_version($_POST['name'], $_POST['version']);
        }
        exit();
    }

    /**
     * calls to update_version to update version data.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/update_version_table'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function update_version_table()
    {
        $data = array(
        'name'  => $_POST['name'],
        'version' => '',
      );
        if ($_POST['id'] != '' && $_POST['name'] != '') {
            if ($_POST['id'] == 'add' && $_POST['version'] != '') {
                $data['version'] = $_POST['version'];
            }
            $this->versions_model->update_version_table($_POST['id'], $data);
        }

        exit();
    }
}
