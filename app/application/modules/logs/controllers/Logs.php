<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends MX_Controller
{
    /**
      * __construct function.
      */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('logs_model');
        $this->loggedIn();
        $this->updateView('logs');
    }

    /**
      * loads logs view and essentials
      * @author Peter Kaufman
      * @example base_url() . 'index.php/logs'
      * @since 8-25-17
      * @version 6-12-18
      */
    public function index()
    {
        $this->updateTitle('Logs');
        $this->getEssentials();
        $this->loadView();
    }

    /**
      * gets the data desired
      * @author Peter Kaufman
      * @example base_url() . 'index.php/logs/getData'
      * @since 8-25-17
      * @version 6-12-18
      */
    public function getData()
    {
        $data = $this->logs_model->get_logs();
        exit(json_encode(['data' => $data]));
    }
    
    /**
      * updates the avialable sql data.
      * @author Peter Kaufman
      * @example base_url() . 'index.php/logs/updateSqlData'
      * @since 8-25-17
      * @version 6-12-18
      */
    public function updateSqlData()
    {
        $start = new DateTime($_POST['start']);
        $start = $start->format('Y-m-d');
        $end = new DateTime($_POST['end']);
        $end = $end->format('Y-m-d');
        $_SESSION['sql'] = array(
         'start'    => $start,
         'end'        => $end
     );
        return;
    }
}
