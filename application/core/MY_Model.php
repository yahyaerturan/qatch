<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Model
 *
 * @package Vayes Core
 * @subpackage Model
 * @author Yahya A. Erturan
 * @copyright Copyright (c) 2014, Yahya A. Erturan
 * @link http://www.yahyaerturan.com
 * @version 1.01
 * @access public
 */

/**
 * ------------------------------------------------------------------------
 * MY_Model at Galance
 * ------------------------------------------------------------------------
 * save     ($table_name,$data_array,$where_array=array(),$whitelist=array(),$blacklist=array())
 * insert   ($table_name,$data_array,$whitelist=array(),$blacklist=array())
 * fetch    ($result_type='result',$callback_function)
 * get      ($table_name=NULL,$where_array = array(),$order_str='',$limit_array=array(),$result_type='result')
 * get_by   ($table_name,$where_array = array(),$result_type='row')
 * get_field  ($table_name,$return_field='id',$where_array=array(),$result_type='row')
 * get_paired ($table_name,$pair_array,$where_array,$order_str,$limit_array,$option_zero='',$result_type)
 * get_joined ($table_name_1,$table_name_2,$join_field,$where_array,$order_str,$limit_array,$result_type)
 * get_joined_by  ($table_name_1,$table_name_2,$join_field,$where_array=array(),$result_type='row')
 * get_column_max ($table_name,$field='ordering',$where_array=array())
 * build_paired_array($data=array(),$pair_keys=array(),$option_zero='')
 * dataTables     ($data)
 * update   ($table_name,$data_array,$where_array,$whitelist=array(),$blacklist=array())
 * delete   ($table_name, $where_array)
 * delete_relational ($tables, $where_array)
 * array_whitelist ($fields,$post_data = array())
 * array_blacklist ($fields,$post_data = array())
 * _sort_multi_array_by_key ($array,$sortby,$direction='asc')
 * get_field_names ($table_name)
 * build_multidimensional_array($id_field,$parent_field,$data)
 */

// ------------------------------------------------------------------------

class MY_Model extends CI_Model {

  public $rules = array();

/**
 * MY_Model::__construct()
 *
 * @return void
 */
  function __construct() {
    parent::__construct();
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::save()
 *
 * @param string $table_name
 * @param mixed $data_array
 * @param mixed $where_array
 * @param mixed $whitelist
 * @param mixed $blacklist
 * @return mixed
 */
  function save ($table_name,$data_array,$where_array=array(),$whitelist=array(),$blacklist=array()) {
    if ((empty($whitelist) === false) and (empty($blacklist) === true)) {
      foreach ($data_array as $field => $value) {
        if (in_array($field, $whitelist) === false) {
          unset($data_array[$field]);
        }
      }
    }

    if ((empty($whitelist) === true) and (empty($blacklist) === false)) {
      foreach ($data_array as $field => $value) {
        if (in_array($field, $blacklist)) {
          unset($data_array[$field]);
        }
      }
    }

    if(empty($where_array)):
      if(is_array(reset($data_array))):
        if(count($data_array)>1):
          return ($this->db->insert_batch($table_name,$data_array)) ? TRUE : FALSE;
        else:
          $this->db->set($data_array[0]);
          if($this->db->insert($table_name)):
            return ($r=$this->db->insert_id()) ? $r : TRUE;
          else:
            return FALSE;
          endif;
        endif;
      else:
        $this->db->set($data_array);
        if($this->db->insert($table_name)):
          return ($r=$this->db->insert_id()) ? $r : TRUE;
        else:
          return FALSE;
        endif;
      endif;
    else:
      $this->db->set($data_array);
      $this->db->where($where_array);
      return ($this->db->update($table_name)) ? TRUE : FALSE;
    endif;
    return false;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::insert()
 *
 * @param string $table_name
 * @param mixed $data_array
 * @param mixed $whitelist
 * @param mixed $blacklist
 * @return boolean
 */
  function insert ($table_name,$data_array,$whitelist=array(),$blacklist=array()) {
    if ((empty($whitelist) === false) and (empty($blacklist) === true)) {
      foreach ($data_array as $field => $value) {
        if (in_array($field, $whitelist) === false) {
          unset($data_array[$field]);
        }
      }
    }

    if ((empty($whitelist) === true) and (empty($blacklist) === false)) {
      foreach ($data_array as $field => $value) {
        if (in_array($field, $blacklist)) {
          unset($data_array[$field]);
        }
      }
    }

    return ($this->db->insert($table_name, $data_array)) ? TRUE : FALSE;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::fetch()
 *
 * Quickly returns requested result type of prepared active record statement
 *
 * @param  string $result_type
 * @param  string $callback_function
 * @return mixed
 */
  function fetch ($result_type='result',$callback_function=NULL)
  {
    !$callback_function || call_user_func($callback_function);
    $r = $this->db->get();
    if($r->num_rows())
      return $r->$result_type();
    return false;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::get()
 *
 * @param string $table_name
 * @param mixed $where_array
 * @param string $order_str
 * @param mixed $limit_array  First requested result number, seconds is starting offset
 * @param string $result_type
 * @return mixed
 */
  function get ($table_name=NULL,$where_array = array(),$order_str='',$limit_array=array(),$result_type='result')
  {
    $r = NULL;
    if (!empty($where_array))   $this->db->where($where_array);
    if ($order_str)             $this->db->order_by($order_str);
    if (!empty($limit_array)) {
      if (isset($limit_array[1]))
        $this->db->limit($limit_array[0], $limit_array[1]);
      else
        $this->db->limit($limit_array[0]);
    }

    if($table_name) $r = $this->db->get($table_name);
    else $r = $this->db->get();

    if($r->num_rows())
      return $r->$result_type();

    return false;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::get_by()
 *
 * Alias for returning single result as row() or row_array()
 *
 * @param string $table_name
 * @param mixed $where_array
 * @param string $result_type
 * @return
 */
  function get_by ($table_name,$where_array = array(),$result_type='row')
  {
    return $this->get($table_name,$where_array,'',array(),$result_type);
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::get_field()
 *
 * Returns required field from row fetched through get_by
 *
 * @param string $table_name
 * @param string $return_field
 * @param mixed $where_array
 * @param string $result_type
 * @return mixed
 */
  function get_field ($table_name,$return_field='id',$where_array=array(),$result_type='row') {
    $r = $this->get($table_name,$where_array,'',array(),$result_type);
    if($r) {
      if($result_type == 'row') return ($r->$return_field) ? $r->$return_field : FALSE;
      else return (isset($r[$return_field])) ? $r[$return_field] : FALSE;
    } else {
      return FALSE;
    }
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::get_paired()
 *
 * @param string $table_name
 * @param mixed $pair_array
 * @param mixed $where_array
 * @param string $order_str
 * @param mixed $limit_array
 * @param string $option_zero
 * @param string $result_type
 * @return mixed
 */
  function get_paired ($table_name,$pair_array,$where_array=array(),$order_str='',$limit_array=array(),$option_zero='',$result_type='result') {
    $r = array();

    if (!empty($where_array)) $this->db->where($where_array);
    if ($order_str) $this->db->order_by($order_str);
    if (!empty($limit_array)) {
      if (isset($limit_array[1])) $this->db->limit($limit_array[0], $limit_array[1]);
      else $this->db->limit($limit_array[0]);
    }
    $q = $this->db->get($table_name);
    if ($option_zero) $r[0] = $option_zero;
    foreach ($q->$result_type() as $row) $r[$row->$pair_array[0]] = $row->$pair_array[1];
    return $r;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::get_joined()
 *
 * @param string $table_name_1
 * @param string $table_name_2
 * @param string $join_field
 * @param mixed $where_array
 * @param string $order_str
 * @param mixed $limit_array
 * @param string $result_type
 * @return mixed
 */
  function get_joined ($table_name_1,$table_name_2,$join_field,$where_array=array(),$order_str='',$limit_array=array(),$result_type='result')
  {
    $r = array();

    $this->db->from($table_name_1);
    if (!empty($where_array))
      $this->db->where($where_array);
    if ($order_str)
      $this->db->order_by($order_str);
    if (!empty($limit_array)) {
      if (isset($limit_array[1]))
        $this->db->limit($limit_array[0], $limit_array[1]);
      else
        $this->db->limit($limit_array[0]);
    }

    $this->db->join($table_name_2,$table_name_1.'.'.$join_field.' = '.$table_name_2 .
      '.' . $join_field);
    $q = $this->db->get();

    return $q->$result_type();
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::get_joined_by()
 *
 * Alias for returning single result as row() or row_array()
 *
 * @param string $table_name_1
 * @param string $table_name_2
 * @param string $join_field
 * @param mixed $where_array
 * @param string $result_type
 * @return mixed
 */
  function get_joined_by ($table_name_1,$table_name_2,$join_field,$where_array=array(),$result_type='row') {
    return $this->get_joined($table_name_1,$table_name_2,$join_field,$where_array,'',array(),$result_type);
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::get_column_max()
 *
 * Returns max value
 *
 * @param string $table_name
 * @param string $field
 * @param mixed $where_array
 * @return
 */
  function get_column_max ($table_name,$field='ordering',$where_array=array())
  {
    $this->db->select_max($field);
    if (!empty($where_array)) $this->db->where($where_array);
    if($r=$this->get_by($table_name)) return $r->$field;
    else return FALSE;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::build_paired_array()
 *
 * @param mixed $data
 * @param mixed $pair_keys
 * @param string $option_zero
 * @return mixed
 *
 * Array of Objects: Array([0] => stdClass Object(...),[1] => stdClass Object(...),
 * Array of Arrays : Array([0] => Array(...),[1] => Array(...),
 */
  function build_paired_array($data=array(),$pair_keys=array(),$option_zero='') {
    $r = array(); // Define result array
    $d = $data; // Define processed data array

    if ($option_zero) $r[0] = $option_zero;
      foreach ($d as $row):
        if(is_object($row)):
          $r[$row->$pair_keys[0]] = $row->$pair_keys[1];
        else:
          $r[$row[$pair_keys[0]]] = $row[$pair_keys[1]];
        endif;
      endforeach;
    return $r;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::dataTables()
 *
 * @param mixed $data
 * @return boolean
 * @todo @unused Consider removing dataTables() function
 */
  function dataTables($data) {
    $result = false;
    $result['aaData'] = $data;
    return $result;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::update()
 *
 * @param string $table_name
 * @param mixed $data_array
 * @param mixed $where_array
 * @param mixed $whitelist
 * @param mixed $blacklist
 * @return boolean
 */
  function update ($table_name,$data_array,$where_array,$whitelist=array(),$blacklist=array()) {
    if (empty($where_array))
      return false;

    if ((empty($whitelist) === false) and (empty($blacklist) === true)) {
      foreach ($data_array as $field => $value) {
        if (in_array($field, $whitelist) === false) {
          unset($data_array[$field]);
        }
      }
    }

    if ((empty($whitelist) === true) and (empty($blacklist) === false)) {
      foreach ($data_array as $field => $value) {
        if (in_array($field, $blacklist)) {
          unset($data_array[$field]);
        }
      }
    }

    $this->db->where($where_array);
    return ($this->db->update($table_name, $data_array)) ? TRUE : FALSE;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::delete()
 *
 * @param mixed $table_name
 * @param mixed $where_array
 * @return boolean
 */
  function delete ($table_name,$where_array)
  {
    if (empty($where_array)) return FALSE;
    $this->db->delete($table_name, $where_array);
    return ($this->db->affected_rows()) ? TRUE : FALSE;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::delete_relational()
 *
 * @param mixed $tables
 * @param mixed $where_array
 * @return boolean
 */
  function delete_relational ($tables,$where_array) {
    if (empty($where_array)) return FALSE;
    $this->db->where($where_array);
    return ($this->db->delete($tables)) ? TRUE : FALSE;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::array_whitelist()
 *
 * Whitelists post array or supplied array with fields array.
 *
 * @param mixed $fields
 * @param mixed $post_data
 * @return mixed
 */
  function array_whitelist ($fields,$post_data=array()) {
    $data_array = array();
    $post_array = ($post_data) ? $post_data : $this->input->post();
    foreach ($fields as $field) $data_array[$field] = $post_array[$field];
    return $data_array;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::array_blacklist()
 *
 * Blacklists post array or supplied array with fields array.
 *
 * @param mixed $fields
 * @param mixed $post_data
 * @return mixed
 */
  function array_blacklist ($fields,$post_data=array()) {
    $data_array = ($post_data) ? $post_data : $this->input->post();
    foreach ($fields as $field) unset($data_array[$field]);
    return $data_array;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::_sort_multi_array_by_key()
 *
 * Sort a multi dimensional array by given key.
 * Format : $arr = array([0]=>array('name'=>'john','age'=>29),[1]=>array('name'=>'susan','age'=>24))
 * Usage  : $sorted = $this->vayes->_sort_multi_array_by_key($arr, 'age', 'desc');
 *
 * @param mixed $array
 * @param string $sortby
 * @param string $direction
 * @return mixed
 */
  function _sort_multi_array_by_key ($array,$sortby,$direction='asc') {
    $sorted_array = array();
    $temp_array = array();
    foreach ($array as $k => $v) $temp_array[] = strtolower($v[$sortby]);
    if ($direction == 'asc') asort($temp_array);
    else arsort($temp_array);
    foreach ($temp_array as $k => $tmp) $sorted_array[] = $array[$k];
    return $sorted_array;
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::get_field_names()
 *
 * For quicker development, returns table's field in array formed string.
 *
 * @param string $table_name
 * @return string
 */
  function get_field_names ($table_name) {
    $q = $this->db->list_fields($table_name);
    $r = "array(";
    foreach ($q as $i) $r .= "'$i',";
    $r  = substr($r,0,-1);
    $r .= ");";
    return vdebug($r);
  }

// ------------------------------------------------------------------------

/**
 * MY_Model::build_multidimensional_array()
 *
 * Builds multidimensional array from data array
 *
 * @param string $id_field
 * @param string $parent_field
 * @param mixed $data
 * @return string
 */
  public function build_multidimensional_array($id_field,$parent_field,$data) {
    $phases = $data;
    $treearr = array('0' => array('children'=> array()));

    foreach($phases as $phase) {
      $treearr[$phase[$id_field]] = $phase;
      if(!isset($treearr[$phase[$parent_field]])) $treearr[$phase[$parent_field]] = array('children'=> array());
      $treearr[$phase[$parent_field]]['children'][$phase[$id_field]] = &$treearr[$phase[$id_field]];
    }
    $tree = $treearr[0]['children'];
    unset($treearr);

    return $tree;
  }

// ------------------------------------------------------------------------
function get_param_names($function_name,$format='string',$glue='::') {
  $f = new ReflectionFunction($function_name);
  $result = array();
  foreach ($f->getParameters() as $param):
      $result[] = $param->name;
  endforeach;
  if ($format == 'string'):
    return implode($glue,$result);
  elseif($format == 'object'):
    return (object) $result;
  elseif($format == 'array'):
    return $result;
  else:
    return false;
  endif;
}

// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */
