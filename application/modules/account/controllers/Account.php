<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Account extends MX_Controller
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('account_model');
        $this->set_module($this);
        $this->logged_in();
    }

    /**
     * loads account view.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/account'
     * @since 8-25-17
     * @version 6-10-18
     */
    public function index()
    {
        $this->update_title('Profile');
        $this->load->view('account', array('error' => ' '));
    }

    /**
     * uploads a photo to assets/images/ and sets the image as the profile image of the user.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/account/do_upload'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function do_upload()
    {
        $config['upload_path'] = 'assets/images/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 1000;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);
        // determine if an error occurred or not
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            $this->get_essentials();
            $this->load->view('account', $error);
        } else {
            $upload_data = $this->upload->data();
            $file_name = array('avatar' => $upload_data['file_name']);
            $this->account_model->update_avatar($file_name);
            $data = array('upload_data' => $this->upload->data());
            $this->get_essentials();
            $this->load->view('account', $data);
        }
    }
}
