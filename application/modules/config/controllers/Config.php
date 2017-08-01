<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MX_Controller {
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
	 * @example base_url() . 'index.php/config'
	 */
	public function index()
	{
		$this->update_title('Configuration');
    $this->get_essentials();
		$this->load->view('config');
	}
	/**
	* time_zones function returns a list of timezones
	* @access public
	* @author Peter Kaufman
	* @example base_url() . 'index.php/config/time_zones'
	*/
 public function time_zones()
 {
	 $cities = array(
		 "EST",
		 "AST",
		 "CST",
		 "MST",
		 "PDT",
		 "HST",
		 "HAST",
		 "SST",
		 "CVT",
		 "SDT",
		 "AKDT",
		 "CHST",
		 "GMT",
	 );
	 $time_zones = array();
	 foreach($cities as $time_zone){
		$time_zones[] = timezone_name_from_abbr($time_zone);
	 }

	 exit(json_encode($time_zones));
 }
}
