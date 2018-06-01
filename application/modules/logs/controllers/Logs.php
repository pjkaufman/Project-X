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
        $this->set_module($this);
        $this->logged_in();
    }

    /**
      * calls get_essentials and loads logs view.
      * @author Peter Kaufman
      * @example base_url() . 'index.php/logs'
      * @since 8-25-17
      * @version 5-31-18
      */
    public function index()
    {
        $this->update_title('Logs');
        $this->get_essentials();
        $this->load->view('logs');
    }

    /**
      * gets the data desired
      * @author Peter Kaufman
      * @example base_url() . 'index.php/logs/get_data'
      * @since 8-25-17
      * @version 5-31-18
      */
    public function get_data()
    {
        $data = $this->logs_model->get_logs();
        exit(json_encode(['data' => $data]));
    }
    
    /**
      * updates the avialable sql data.
      * @author Peter Kaufman
      * @example base_url() . 'index.php/logs/update_sql_data'
      * @since 8-25-17
      * @version 5-31-18
      */
    public function update_sql_data()
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
