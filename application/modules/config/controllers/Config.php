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
        $this->load->helper(array('url'));
        $this->load->model('config_model');
        $this->set_module($this);
        $this->logged_in();
    }

    /**
     * loads the home view.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/config'
     * @since 8-25-17
     * @version 6-10-18
     */
    public function index()
    {
        $this->update_title('Configuration');
        $this->load->view('config');
    }

    /**
     * returns a list of timezones.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/config/time_zones'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function time_zones()
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
     * updates a setting in the config table.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/config/update_setting'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function update_timezone()
    {
        $this->config_model->updateTimezone($_POST['time_zone']);
        exit();
    }
}
