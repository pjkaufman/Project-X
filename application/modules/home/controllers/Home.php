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
        $this->loggedIn();
        $this->getLinks();
        $this->updateView('home');
    }

    /**
     * loads the home view and essentials
     * @author Peter Kaufman
     * @example base_url() . 'index.php/home'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function index()
    {
        $this->updateTitle('Home');
        $this->getEssentials();
        $this->loadView();
    }
}
