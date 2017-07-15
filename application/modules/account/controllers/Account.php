<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
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
	 }

	public function index(){
    $this->get_essentials();
    $this->load->view('account', array('error' => ' ' ));
	}

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
