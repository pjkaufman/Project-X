<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends MX_Controller
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->set_module($this);
        $this->default_time_zone();
    }

    /**
     * creates a user and redirect to login page.
     * @author Hedii & Peter Kaufman
     * @example base_url() . 'index.php/user/register'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function register()
    {
        // create the data object
        $this->update_title('Register');
        $data = new stdClass();
        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

        if ($this->form_validation->run() === false) {
            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('register/register', $data);
        } else {
            // set variables from the form
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->user_model->create_user($username, $email, $password)) {
                // user creation ok
                header('location: ' . base_url() . 'index.php/user/login');
            } else {
                // user creation failed, this should never happen
                $data->error = 'There was a problem creating your new account. Please try again.';
                // send error to the view
                $this->load->view('header');
                $this->load->view('register/register', $data);
            }
        }
    }

    /**
     * takes in information from the login form, validates it, and redirects to the appropriate page.
     * @author Hedii & Peter Kaufman
     * @example base_url() . 'index.php/user/login'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function login()
    {
        // create the data object
        $this->update_title('Login');
        $data = new stdClass();
        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('login/login');
        } else {
            // set variables from the form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->user_model->resolve_user_login($username, $password)) {
                $user_id = $this->user_model->get_user_id_from_username($username);
                $user = $this->user_model->get_user($user_id);
                // set session user datas
                $_SESSION['user_id'] = (int)$user->id;
                $_SESSION['username'] = (string)$user->username;
                $_SESSION['logged_in'] = (bool)true;
                $_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
                $_SESSION['is_admin'] = (bool)$user->is_admin;
                $_SESSION['email'] = (string)$user->email;
                $_SESSION['avatar'] = (string)$user->avatar;
                $_SESSION['num_logins'] = (int)$user->num_logins;
                // user login ok
                $this->user_model->update_login_data();
                header('location: ' . base_url() . 'index.php/home/get_essentials');
                
            } else {
                // login failed
                $data->error = 'Wrong username or password.';
                // send error to the view
                $this->load->view('header');
                $this->load->view('login/login', $data);
            }
        }
    }

    /**
     * logs the user out and redirects to the login page.
     * @author Hedii & Peter Kaufman
     * @example base_url() . 'index.php/user/logout'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function logout()
    {
        // create the data object
        $data = new stdClass();
        $this->user_model->update_logout_data();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // remove session datas
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            header('location: ' . base_url() . 'index.php/user/login');
        } else {
            // there user was not logged in, we cannot logged him out,
            // redirect him to site root
            redirect('/');
        }
    }
}
