<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Setup extends MX_Controller
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('setup_model');
    }

    /**
     * sets up all of the tables that the application needs to run.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/setup'
     * @since 6-9-18
     * @version 6-9-18
     */
    public function index()
    {
        $this->setup_model->setup();
        header('location: ' . base_url() . 'index.php/user/login');
    }
}
