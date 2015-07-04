<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Frontend_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->load->view('home_view');
  }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
