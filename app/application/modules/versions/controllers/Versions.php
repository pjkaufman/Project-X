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
        $this->loggedIn();
        $this->updateView('versions');
    }

    /**
     * loads the version view and essentials
     * @author Peter Kaufman
     * @example base_url() . 'index.php/versions'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function index()
    {
        $this->updateTtitle('Version Info');
        $this->getEssentials();
        $this->loadView();
    }

    /**
     * calls to get_versions to get version data.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/getVersionData'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function getVersionData()
    {
        exit(json_encode($this->versions_model->get_versions()));
    }

    /**
     * calls to update_version to update version data.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/updateVersion'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function updateVersion()
    {
        if ($_POST['version'] != '') {
            $this->versions_model->update_version($_POST['name'], $_POST['version']);
        }
        exit();
    }

    /**
     * calls to update_version to remove version data.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/updateVersionTable'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function updateVersionTable()
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
