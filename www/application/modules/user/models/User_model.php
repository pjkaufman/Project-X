<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * User_model class.
 * @extends CI_Model
 */
class User_model extends CI_Model
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    /**
     * adds a new user to the users database.
     * @author Hedii
     * @example create_user( 'foo', 'foo@gmail.com', 'password');
     * @since 8-25-17
     * @version 5-31-18
     * @param  username  is a string which is the username of the user which is to be added to the database
     * @param  email  is a string which is the email of the user which is to be added to the database
     * @param  password is a string which is the password of the user which is to be added to the database
     * @return bool  true on success, false on failure
     */
    public function create_user($username, $email, $password)
    {
        $date->setTimezone(new DateTimeZone($_SESSION['timezone']));
        $date->sub(new DateInterval('PT3H'));
        $sql = "INSERT INTO `users` (`username`, `email`, `password`, `created_at`) VALUES ( " . $username . ", " . $email . ", " . $this->hash_password($password) . ", " . $date->format('Y-m-j H:i:s') . ");";

        return $this->db->query($sql);
    }

    /**
     * compares the password of the user to determine if the credentials match.
     * @author Hedii
     * @example resolve_user_login('foo', 'password');
     * @since 8-25-17
     * @version 5-31-18
     * @param  username is a string which is the username to search for in the database
     * @param  password is a string which is the password provided by the user
     * @return bool  true on success, false on failure
     */
    public function resolve_user_login($username, $password)
    {
        $sql = "SELECT `password` FROM `users` WHERE `username` = '" . $username . "';";
        $hash = $this->db->query($sql)->row('password');

        return $this->verify_password_hash($password, $hash);
    }

    /**
     * gets the user's id using the username.
     * @author Hedii
     * @example get_user_id_from_username( 'foo' );
     * @since 8-25-17
     * @version 5-31-18
     * @param  username is a string which is the username to search for in the database
     * @return int   the user id
     */
    public function get_user_id_from_username($username)
    {
        $sql = "SELECT `id` FROM `users` WHERE `username` = '" . $username . "';";

        return $this->db->query($sql)->row('id');
    }

    /**
     * gets the user's information based on the user's id.
     * @author Hedii
     * @example get_user(1);
     * @since 8-25-17
     * @version 5-31-18
     * @param  user_id is the id of the username specified by the user
     * @return object the user object
     */
    public function get_user($user_id)
    {
        $sql = "SELECT * FROM `users` WHERE `id` = " . $user_id . ";";

        return $this->db->query($sql)->row();
    }

    /**
     * hashes the password.
     * @author Hedii
     * @example hash_password('password');
     * @since 8-25-17
     * @version 5-31-18
     * @param  password is a string which is to be hashed
     * @return string|bool could be a string on success, or bool false on failure
     */
    private function hash_password($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * verfies that the provided password is the same as the one listed in the databse.
     * @author Hedii
     * @example verify_password_hash('password', $hash);
     * @since 8-25-17
     * @version 5-31-18
     * @param  password is a string which is the password of a specified user
     * @param  hash is the type of hash to be done in order to unhash the password
     * @return boolean is true if the passwords match and false if they do not
     */
    private function verify_password_hash($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * updates the last_login and num_logins in the users table.
     * @author Peter Kaufman
     * @example update_login_data();
     * @since 8-25-17
     * @version 5-31-18
     */
    public function update_login_data()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($_SESSION['timezone']));
        $date->sub(new DateInterval('PT3H'));
        $data = array(
                'num_logins' => $_SESSION['num_logins'] + 1,
                'last_login' => $date->format('Y-m-d H:i:s'),
        );
        $this->db->where('username', $_SESSION['username']);
        $this->db->update('users', $data);
        $_SESSION['last_login'] = (string)$data['last_login'];
        $_SESSION['num_logins'] = (int)$data['num_logins'];
    }

    /**
     * updates the logins table.
     * @author Peter Kaufman
     * @example update_logout_data();
     * @since 8-25-17
     * @version 5-31-18
     */
    public function update_logout_data()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($_SESSION['timezone']));
        $date->sub(new DateInterval('PT3H'));
        $sql = "INSERT INTO `logins` (`username`, `login`, `logout`, `datestamp`) VALUES ('" . $_SESSION['username'] . "', '" . $_SESSION['last_login'] . "', '" . $date->format('Y-m-d H:i:s') . "', '" .  $date->format('Y-m-d') . "');";
        $this->db->query($sql);
    }
}
