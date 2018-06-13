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
        $this->loggedIn();
        $this->updateView('users');
    }

    /**
     * loads the home view and essentials
     * @author Peter Kaufman
     * @example base_url() . 'index.php/versions'
     * @since 5-31-18
     * @version 6-12-18
     */
    public function index()
    {
        $this->updateTitle('Database Users');
        $this->getEssentials();
        $this->loadView();
    }

    /**
     * calls to get_users to get the list.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/getUserData'
     * @since 5-31-18
     * @version 6-12-18
     */
    public function getUserData()
    {
        exit(json_encode(['data' => $this->users_model->get_users()]));
    }
}
