<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Compare extends MX_Controller
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('compare_model');
        $this->set_module($this);
        $this->logged_in();
        $this->DB1 = $this->load->database('dev', true); // load the source/development database
        $this->DB2 = $this->load->database('live', true); // load the destination/live database
        $_SESSION['dev'] = array();
        $_SESSION['live'] = array();
        $_SESSION['exclude'] = array();
        $_SESSION['result'] = array(
          'title' => '',
          'sql' => array(),
        );
        $_SESSION['update'] = array();
        $_SESSION['dev']['views'] = array();
        $_SESSION['live']['views'] = array();
        $_SESSION['compare'] = 2;
    }

    /**
     * sets up the view for the user
     * @author Peter Kaufman
     * @example base_url() . 'index.php/db_compare'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function index()
    {
        $this->update_title('Compare');
        $this->get_essentials();
        $this->load->view('compare');
    }

    /**
     * takes a database snapshot of the live database connection and saves it to a file
     * @author Peter Kaufman
     * @example base_url() . 'index.php/db_compare/take_snapshot'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function take_snapshot()
    {
        $this->set_dev('false');
        $_SESSION['dev']['tables_list'] = $this->compare_model->table_list($this->DB1);
        $this->compare_model->fill_out_tables($_SESSION['dev'], $this->DB1);
        $this->compare_model->get_views($this->DB1, $_SESSION['dev']['views']);
        $this->compare_model->create_db_snapshot();
    }

    /**
     * compares two databases and exits with the SQL statements that are to be returned
     * @author Peter Kaufman
     * @example base_url() . 'index.php/db_compare/db_compare'
     * @since 8-25-17
     * @version 5-31-18
     */
    public function db_compare()
    {
        if (array_key_exists('num', $this->input->post())) {
            $this->set_dev($this->input->post()['num']);
        }
        /*
         * This will become a list of SQL Commands to run on the Live database to bring it up to date
         */
        $sql_commands_to_run = array();
        /*
         * list the tables from both databases
         */
        if ($_SESSION['compare'] != 1) {
            $_SESSION['dev']['tables_list'] = $this->compare_model->table_list($this->DB1);
        }

        $_SESSION['live']['tables_list'] = $this->compare_model->table_list($this->DB2);
        /*
         * list any tables that need to be created or dropped
         */
        $tables_to_create = array_diff($_SESSION['dev']['tables_list'], $_SESSION['live']['tables_list']);
        $tables_to_drop = array_diff($_SESSION['live']['tables_list'], $_SESSION['dev']['tables_list']);

        if ($_SESSION['compare'] != 1) {
            $this->compare_model->fill_out_tables($_SESSION['dev'], $this->DB1);
        }
        $this->compare_model->fill_out_tables($_SESSION['live'], $this->DB2);
        $this->update_array($tables_to_create, $tables_to_create, $tables_to_create);
        $this->update_array($tables_to_drop, $tables_to_drop, $tables_to_drop);
        /**
         * Create/Drop any tables that are not in the Live database.
         */
        $results = (is_array($tables_to_create) && !empty($tables_to_create)) ? $this->compare_model->manage_tables($tables_to_create, 'create') : array();
        $sql_commands_to_run = array_merge($sql_commands_to_run, $results);
        $results = (is_array($tables_to_drop) && !empty($tables_to_drop)) ? $this->compare_model->manage_tables($tables_to_drop, 'drop') : array();
        $sql_commands_to_run = array_merge($sql_commands_to_run, $results);
        $this->compare_model->compare_table_structures();
        /*
         * Before comparing tables, remove any tables from the list that will be created or dropped in the $tables_to_create array
         */
        $_SESSION['update'] = array_diff($_SESSION['update'], $tables_to_create);
        $_SESSION['update'] = array_diff($_SESSION['update'], $tables_to_drop);
        $_SESSION['exclude'] = array_merge($_SESSION['exclude'], array_merge($tables_to_drop, $tables_to_create));
        /*
         * update tables, add/update/remove columns
         */
        $results = (is_array($_SESSION['update']) && !empty($_SESSION['update'])) ? $this->compare_model->update_existing_tables() : array();
        $sql_commands_to_run = array_merge($sql_commands_to_run, $results);
        /*
         * add, and or drop indices
         */
        $results = $this->compare_model->manage_indices($_SESSION['dev']['indices'], $_SESSION['live']['indices'], $_SESSION['exclude']);
        $sql_commands_to_run = array_merge($sql_commands_to_run, $results);

        // get the vies and drop all the one that are in live and create all of those in dev
        if ($_SESSION['compare'] != 1) {
            $this->compare_model->get_views($this->DB1, $_SESSION['dev']['views']);
        }
        $this->compare_model->get_views($this->DB2, $_SESSION['live']['views']);
        $results = $this->compare_model->view_results();
        $sql_commands_to_run = array_merge($sql_commands_to_run, $results);
        $results = $this->compare_model->get_first_steps();
        $sql_commands_to_run = array_merge($results, $sql_commands_to_run);
        $results = $this->compare_model->fix_AI();

        $sql_commands_to_run = array_merge($sql_commands_to_run, $results);

        if (is_array($sql_commands_to_run) && !empty($sql_commands_to_run)) {
            $_SESSION['result']['title'] = 'The database is out of Sync!';
            $_SESSION['result']['sql'] = $sql_commands_to_run;
        } else {
            $_SESSION['result']['title'] = 'The database appears to be up to date';
            $_SESSION['result']['sql'] = array();
        }

        exit(json_encode($_SESSION['result']));
    }

    /**
     * sets the dev database based on an integer.
     * @author Peter Kaufman
     * @example base_url() . 'index.php/db_compare/set_dev'
     * @since 8-25-17
     * @version 5-31-18
     * @param type determines whether to get a dbSnapshot or load the dev database connection
     */
    public function set_dev($type)
    {
        if ($type == 'true' && file_exists('dbsnapshot.json')) {
            $this->compare_model->get_db_snapshot();
            $_SESSION['compare'] = 1;
        }
    }

    /**
     * turns an array into an associative array
     * @author Peter Kaufman 
     * @example base_url() . 'index.php/db_compare/update_array'
     * @since 8-25-17
     * @version 5-31-18
     * @param array is the array to be modified
     */
    public function update_array(&$array)
    {
        $temp = array();

        foreach ($array as $tName) {
            $temp["$tName"] = $tName;
        }
        $array = $temp;
    }
}
