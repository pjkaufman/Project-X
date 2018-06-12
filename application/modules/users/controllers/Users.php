<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MX_Controller
{
    /**
       * __construct function.
       */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->set_module($this);
        $this->logged_in();
    }

    /**
     * loads the home view.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/versions'
     * @since 5-31-18
     * @version 6-10-18
     */
    public function index()
    {
        $this->update_title('Database Users');
        $this->load->view('users');
    }

    /**
     * calls to get_versions to get version data.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/get_user_data'
     * @since 5-31-18
     * @version 5-31-18
     */
    public function get_user_data()
    {
        exit(json_encode(['data' => $this->users_model->get_users()]));
    }
}
