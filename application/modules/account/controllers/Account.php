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
        $this->loggedIn();
        $this->updateView('account');
    }

    /**
     * loads account view and essentials
     * @author Peter Kaufman
     * @example base_url() . 'index.php/account'
     * @since 8-25-17
     * @version 6-12-18
     */
    public function index()
    {
        $this->updateTitle('Profile');
        $this->getEssentials();
        $this->loadView();
    }

    /**
     * uploads a photo to assets/images/ and sets the image as the profile image of the user.
     * @author Peter Kaufman & Yogesh Singh
     * @example base_url() . 'index.php/account/doUpload'
     * @since 8-25-17
     * @version 6-12-18
     * @see http://makitweb.com/how-to-upload-image-file-using-ajax-and-jquery/
     */
    public function doUpload()
    {
        /* Getting file name */
        $filename = $_FILES['file']['name'];
        /* Location */
        $location = "assets/images/" . $filename;
        $uploadOk = 1;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        // Check image format
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $uploadOk = 0;
        }

        if($uploadOk == 0){
            exit(json_encode(array('error' => 'The file is not of the right file type.')));
        }else{
            /* Upload file */
            if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
                $file_name = array('avatar' => $filename);
                $this->account_model->update_avatar($file_name);
                exit(json_encode(array('error' => null)));
            } else {
                exit(json_encode(array('error' => 'An error occurred while uploading the image.')));
            }
        }
    }
}
