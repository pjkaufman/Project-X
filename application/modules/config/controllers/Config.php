<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Config extends MX_Controller
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('config_model');
        $this->loggedIn();
        $this->updateView('config');
    }

    /**
     * loads the config view and essentials
     * @author Peter Kaufman
     * @example base_url() . 'index.php/config'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function index()
    {
        $this->updateTitle('Configuration');
        $this->getEssentials();
        $this->loadView();
    }

    /**
     * returns a list of timezones
     * @author Peter Kaufman
     * @example base_url() . 'index.php/config/timeZones'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function timeZones()
    {
        $cities = array(
         'EST',
         'AST',
         'CST',
         'MST',
         'PDT',
         'HST',
         'HAST',
         'SST',
         'CVT',
         'SDT',
         'AKDT',
         'CHST',
         'GMT',
     );
        $time_zones = array();

        foreach ($cities as $time_zone) {
            $time_zones[$time_zone] = timezone_name_from_abbr($time_zone);
        }
        exit(json_encode($time_zones));
    }

    /**
     * updates a setting in the config table
     * @author Peter Kaufman
     * @example base_url() . 'index.php/config/updateSetting'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function updateTimezone()
    {
        $this->config_model->update_timezone($_POST['time_zone']);
        exit();
    }
}
