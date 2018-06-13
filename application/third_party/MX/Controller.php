<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__) . '/Base.php';

/**
 * Modular Extensions - HMVC.
 *
 * Adapted from the CodeIgniter Core Classes
 * @see	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller {
    public $autoload = array();

    public function __construct() {
        $class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
        log_message('debug', $class . ' MX_Controller Initialized');
        Modules::$registry[strtolower($class)] = $this;

        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');
        $this->load->initialize($this);

        /* autoload module items */
        $this->load->_autoloader($this->autoload);
        $this->db = $this->load->database('default', true);
    }

    public function __get($class) {
        return CI::$APP->$class;
    }

     /**
     * updates the view name
     * @author Peter Kaufman
     * @example base_url() . any_module/updateView
     * @since 8-25-17
     * @version 6-12-18
     **/
    public function updateView($view) {
        $this->view = $view;
    }

    /**
     * loads the header and nav-bar files.
     * @author Peter Kaufman
     * @example base_url() . any_module/getEssentials
     * @since 8-25-17
     * @version 6-12-18
     **/
    public function getEssentials() {
        $this->load->view('header');
        $this->load->view('nav-bar');
    }

    /**
     * checks to make sure the user is logged in, if not, the user is redirected to the login page.
     * @author Peter Kaufman
     * @example base_url() . any_module/loggedIn
     * @since 8-25-17
     * @version 6-12-18
     */
    public function loggedIn() {
        if (!(isset($_SESSION['username']))) {
            header('Location:' . base_url() . 'index.php/user/login');
        }
    }

    /**
     * sets the title for the current page in the SESSION global variable.
     * @author Peter Kaufman
     * @example base_url() . any_module/updateTitle
     * @since 8-25-17
     * @version 6-12-18
     */
    public function updateTitle($title) {
        $_SESSION['title'] = 'Project X - ' . $title;
    }

    /**
     * gets the default time zone to use for the modules.
     * @author Peter Kaufman
     * @example base_url() . any_module/defaultTimeZone();
     * @since 8-25-17
     * @version 6-12-18
     */
    public function defaultTimeZone() {
        $sql = "SELECT `value` FROM `config` WHERE `name` = 'timezone';";
        $results = $this->db->query($sql)->result();
        if (!empty($results)) {
            $results = (array)array_shift($results);
            $_SESSION['timezone'] = $results['value'];
        } else {
            $_SESSION['timezone'] = 'America/New_York';
        }
    }

    /**
     * gets the timezone to use.
     * @author Peter Kaufman
     * @example base_url() . any_module/getTimezone
     * @since 8-25-17
     * @version 6-12-18 
     */
    public function getTimezone() {
        exit($_SESSION['timezone']);
    }

    /**
     * gets the link structure for the navigation page.
     * @author Peter Kaufman
     * @example base_url() . any_module/getLinks
     * @since 6-9-18
     * @version 6-12-18 
     */
    public function getLinks() {
        $_SESSION['links'] = array();
        $sql = "SELECT `*` FROM `links`;";
        $results = $this->db->query($sql)->result();
        foreach( $results as $result ) {
            $_SESSION['links'][$result->linkText] = array(
                'name'  => $result->linkName,
                'js'    => $result->linkJS,
                'link'  => $result->link,
                'ID'    => (int)$result->linkID,
                'code'  => (int)$result->code,
                'access'=> (int)$result->access,
                'text'  => $result->linkText
            );
        }
    }

    /**
     * gets the link for the given link name.
     * @author Peter Kaufman
     * @example base_url() . any_module/getLink
     * @since 6-10-18
     * @version 6-12-18
     * @return [string] is a string which is a link 
     */
    public function getLink() {
        $linkName = trim($_POST['link']);
        $link = base_url() . 'index.php/' . $_SESSION['links'][$linkName]['link'];
        exit(json_encode($link));
    }

     /**
     * loads the view that has been previosly specified
     * @author Peter Kaufman
     * @example base_url() . any_module/loadView
     * @since 6-12-17
     * @version 6-12-18
     **/
    public function loadView() {
        if (strcmp($this->view, '') != 0) {
            $this->load->view($this->view);
        }
    }
}
