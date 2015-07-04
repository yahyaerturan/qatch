<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets extends Backend_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    return TRUE;
  }

  public function app_style() {
    $this->load->view('assets/php/app-css',$this->data);
  }

  public function vayes_scripts() {
    $this->data->csrf_name = $this->security->get_csrf_token_name();
    $this->data->csrf_hash = $this->security->get_csrf_hash();
    $this->load->view($this->theme.'assets/php/vayes-js',$this->data);
  }
}

/* End of file Assets.php */
/* Location: ./application/controllers/app/Assets.php */
