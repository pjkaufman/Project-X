<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MX_Controller
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->set_module($this);
        $this->logged_in();
    }

    /**
     * index calls get_essentials and loads the home view.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/home'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function index()
    {
        $this->update_title('Home');
        $this->get_essentials();
        $this->load->view('home');
    }
}
