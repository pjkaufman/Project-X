<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MX_Controller {

	 /**
		* __construct function.
		*
		* @access public
		* @return void
		*/
	 public function __construct() {

		  parent::__construct();
		  $this->load->helper(array('form', 'url'));
		  $this->load->model('account_model');
		  $this->set_module($this);
			$this->logged_in();
	 }

	 /**
 	 *  index calls get_essentials and loads account view
 	 *
 	 * @access public
	 * @author Peter Kaufman
 	 * @example base_url() . 'index.php/account'
 	 */
	public function index(){
		$this->update_title('Profile');
    $this->get_essentials();
    $this->load->view('account', array('error' => ' ' ));
	}

	 /**
 	 *  do_upload uploads a photo to assets/images/
 	 *
 	 * @access public
	 * @author Peter Kaufman
 	 * @example base_url() . 'index.php/account/do_upload'
 	 */
	public function do_upload(){

  	$config['upload_path']          = 'assets/images/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['max_size']             = 1000;
    $config['max_width']            = 1024;
    $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('userfile')){
    	$error = array('error' => $this->upload->display_errors());
			$this->get_essentials();
      $this->load->view('account', $error);
    }else{
			$upload_data = $this->upload->data();
			$file_name = array('avatar' => $upload_data['file_name']);
			$this->account_model->update_avatar($file_name);
    	$data = array('upload_data' => $this->upload->data());
			$this->get_essentials();
			$this->load->view('account', $data);
    }
  }
}
