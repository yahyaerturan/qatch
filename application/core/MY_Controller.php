<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      Yahya A. Erturan
 * @copyright   Copyright (c) 2015, Yahya A. Erturan
 * @link        http://www.yahyaerturan.com
 * @access public
 */

class MY_Controller extends CI_Controller {

  public $data;

  public function __construct()
  {
    parent::__construct();

    // Load Configs
    $this->load->config('vayes_config',TRUE);
    $this->config->item('sess_use_database',TRUE);

    // Load Caching Driver
    $this->load->driver('cache',array('adapter'=>'memcached','backup'=>'file'));

    // Declarations
    $this->data = new stdClass();
    $this->data->errors     = array();
    $this->data->msg        = '';
    $this->data->subview    = '';
  }

// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
