<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {
	 /**
		* __construct function.
		* @access public
		* @return void
		*/
	 public function __construct() {

		 parent::__construct();
		 $this->load->helper(array('url'));
		 $this->set_module($this);
		 $this->logged_in();
	 }
	 /**
	 * index function calls get_essentials and loads the home view
	 * @access public
	 * @author Peter Kaufman
	 * @example base_url() . 'index.php/home'
	 */
	public function index()
	{
		$this->update_title('Home');
    $this->get_essentials();
		$this->load->view('home');
	}
}
