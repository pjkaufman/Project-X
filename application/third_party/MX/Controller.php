<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
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
class MX_Controller
{
	public $autoload = array();

	public function __construct()
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;

		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);

		/* autoload module items */
		$this->load->_autoloader($this->autoload);
	}

	public function __get($class)
	{
		return CI::$APP->$class;
	}
	/**
	 * get_essentials
	 * @author Peter Kaufman
	 *
	 *
	 **/
	public function get_essentials(){
		$this->load->view('header');
		$this->load->view('nav-bar');
	}

	/**
	 * set_module sets the name of the current module in the SESSION global variable
	 * @author Peter Kaufman
	 * @param $class is a MX_Controller oci_fetch_object
	 *
	 */
	public function set_module($class){
		$_SESSION['cmod'] =  strtolower(get_class($class));
	}

	/**
	 * logged_in checks to make sure the user is logged in, if not, the user is redirected to the login page
	 * @author Peter Kaufman
	 *
	 */
	public function logged_in(){
		if(!(isset($_SESSION['username'])))
		{
			header('Location:' . base_url() . 'index.php/user/login');
		}
	}

	/**
	 * update_title sets the title for the current page in the SESSION global variable
	 * @author Peter Kaufman
	 *
	 */
	public function update_title($title){

		$_SESSION['title'] = 'Project X - ' . $title;

	}
}
