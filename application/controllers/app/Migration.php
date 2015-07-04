<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index()
  {
    $this->load->library('migration');
    if ( ! $this->migration->current())
    {
      show_error($this->migration->error_string());
    }
    else
    {
      exit('<strong>Migration to current version successfully completed!</strong>');
    }
  }

  public function version($n = 1)
  {
    $migration_files = @scandir(APPPATH.'migrations');
    $files_array = false;
    if($migration_files){
      // Remove '.' and '..' from array
      unset($migration_files[0]);unset($migration_files[1]);
      foreach($migration_files as $k => $v){
        $files_array['file_'.substr($v,0,3)] = $v;
      }
    }

    $this->load->library('migration');
    $this->config->load('migration');
    $current_version = $this->config->item('migration_version');
    echo '<style type="text/css">p,a{font-family: "Calibri";font-size: 10pt;}a,a:visited,a.active{color:#A70000}a:hover{color:#00620C;}</style>';
    if($n == 'latest')
    {
      if ( ! $this->migration->current())
      {
        show_error($this->migration->error_string());
      }
      else
      {
        echo '<p>'.'<strong>Migration to current version successfully completed!</strong>'.'</p>';
        echo '<p>'.anchor('app/migration/version/','» Migrate to base version now').'</p>';
        echo '<hr />';
        echo '<ul>';
        for($i=1; $i <= $current_version; $i++) {
          $highlight = ($n==$i) ? ' style="font-weight:bold;"' : NULL;
          echo '<li'.$highlight.'>'.anchor('app/migration/version/'.$i,'Go to migrate version ' . $i).' <small style="margin-left:15px;font-size:10px;color:#444;">'.$files_array['file_'.$this->prepend_zero($i)].'</small></li>';
        }
        echo '</ul>';
        exit;
      }
    }
    else
    {
      if ( ! $this->migration->version($n))
      {
        show_error($this->migration->error_string());
      }
      else
      {
        if(intval($n) == 1) {
          $this->db->truncate('ci_sessions');
        }
        echo '<p>'.'<strong>Migration to ' . $n . ' version successfully completed!</strong>'.'</p>';
        echo '<p>'.anchor('app/migration/version/latest','» Migrate to latest version now').'</p>';
        echo '<hr />';
        echo '<ul>';
        for($i=1; $i <= $current_version; $i++) {
          $highlight = ($n==$i) ? ' style="font-weight:bold;"' : NULL;
          echo '<li'.$highlight.'>'.anchor('app/migration/version/'.$i,'Go to migrate version ' . $i).' <small style="margin-left:15px;font-size:10px;color:#444;">'.$files_array['file_'.$this->prepend_zero($i)].'</small></li>';
        }
        echo '</ul>';
        exit;
      }
    }
  }

  public function prepend_zero($number,$total_digit=3) {
    return str_pad((string)$number, $total_digit, "0", STR_PAD_LEFT);
  }
}

/* End of file Migration.php */
/* Location: ./application/controllers/app/Migration.php */
