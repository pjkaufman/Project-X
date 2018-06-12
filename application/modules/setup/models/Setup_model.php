<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Setup_model class.
 * @extends CI_Model
 */
class Setup_model extends CI_Model
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
     * setup all of the tables that are needed for the application to run.
     * @author Peter Kaufman
     * @example setup;
     * @since 6-9-17
     * @version 6-9-18
     */
    public function setup()
    {
        // create the users table
        echo "create the users table";
        $this->db->query("CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL DEFAULT '',
            `email` varchar(255) NOT NULL DEFAULT '',
            `password` varchar(255) NOT NULL DEFAULT '',
            `avatar` varchar(255) DEFAULT 'default.jpg',
            `created_at` datetime NOT NULL,
            `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `is_confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `last_login` datetime DEFAULT NULL,
            `num_logins` int(11) DEFAULT '0',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1");
        // create the ci_sessions table
        echo "create the ci_sessions table";
        $this->db->query("CREATE TABLE IF NOT EXISTS `ci_sessions` (
            `id` varchar(40) NOT NULL,
            `ip_address` varchar(45) NOT NULL,
            `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
            `data` blob NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
        // create the logins table
        echo "create the logins table";
        $this->db->query("CREATE TABLE IF NOT EXISTS `logins` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL DEFAULT '',
            `login` datetime DEFAULT NULL,
            `logout` datetime DEFAULT NULL,
            `datestamp` date DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;");
        // create the versions table
        echo "create the versions table";
        $this->db->query("CREATE TABLE IF NOT EXISTS `versions` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL DEFAULT '',
            `version` varchar(10) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;");
        // create the config table
        echo "create the config table";
        $this->db->query("CREATE TABLE IF NOT EXISTS `config` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL DEFAULT '',
            `value` varchar(20) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;");
        // create the links table
        echo "create the links table";
        $this->db->query("CREATE TABLE IF NOT EXISTS `links` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `linkName` varchar(100) DEFAULT NULL,
            `linkJS` varchar(45) DEFAULT NULL,
            `link` varchar(45) DEFAULT NULL,
            `linkID` int(11) DEFAULT NULL,
            `code` int(1) DEFAULT NULL,
            `access` int(1) DEFAULT NULL,
            PRIMARY KEY (`ID`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;");
        // insert data into the links table
        $this->db->query("INSERT INTO `links` (`linkName`, `linkJS`, `link`, `linkID`, `code`, `access`, `linkText` )
        VALUES ('<i class=\"fa fa-fw fa-home\"></i> Home', 'home', 'home', 1, 3, 0, 'Home');");
        $this->db->query("INSERT INTO `links` (`linkName`, `linkJS`, `link`, `linkID`, `code`, `access`, `linkText` )
        VALUES ('<i class=\"fa fa-fw fa-wrench\"></i> Administartion<i class=\"fa fa-fw fa-caret-down\"></i>', '', '', 2, 1, 1, 'Administration');");
        $this->db->query("INSERT INTO `links` (`linkName`, `linkJS`, `link`, `linkID`, `code`, `access`, `linkText` )
        VALUES ('<i class=\"fa fa-fw fa-cog\"></i> Configuration', 'config', 'config', 2, 0, 1, 'Configuration');");
        $this->db->query("INSERT INTO `links` (`linkName`, `linkJS`, `link`, `linkID`, `code`, `access`, `linkText` )
        VALUES ('<i class=\"fa fa-fw fa-info-circle\"></i> Version Info', 'versions', 'versions', 2, 0, 1, 'Version Info');");
        $this->db->query("INSERT INTO `links` (`linkName`, `linkJS`, `link`, `linkID`, `code`, `access`, `linkText` )
        VALUES ('<i class=\"fa fa-fw fa-file\"></i> Logs', 'logs', 'logs', 2, 0, 1, 'Logs');");
        $this->db->query("INSERT INTO `links` (`linkName`, `linkJS`, `link`, `linkID`, `code`, `access`, `linkText` )
        VALUES ('<i class=\"glyphicon glyphicon-duplicate\"></i> Compare', 'compare', 'compare', 2, 0, 1, 'Compare');");
        $this->db->query("INSERT INTO `links` (`linkName`, `linkJS`, `link`, `linkID`, `code`, `access`, `linkText` )
        VALUES ('<i class=\"glyphicon glyphicon-list-alt\"></i> User List', 'users', 'users', 2, 0, 1, 'User List');");
        $this->db->query("INSERT INTO `links` (`linkName`, `linkJS`, `link`, `linkID`, `code`, `access`, `linkText`) 
        VALUES ('<i class=\"fa fa-fw fa-user\"></i> Profile', 'account', 'account', 0, 4, 0, 'Profile');");  
  }
}
