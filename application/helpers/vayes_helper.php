<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Vayes Helper
 *
 * @package Vayes Core
 * @subpackage Helpers
 * @author Yahya A. Erturan
 * @copyright Copyright (c) 2013, Yahya A. Erturan
 * @link http://www.yahyaerturan.com
 * @access public
 */

/**
 * ------------------------------------------------------------------------
 * JSON HELPERS
 * ------------------------------------------------------------------------
 * validateJSON ($str)
 * ------------------------------------------------------------------------
 * AUTH HELPERS
 * ------------------------------------------------------------------------
 * is_logged()
 * ------------------------------------------------------------------------
 * PATH & URI HELPERS
 * ------------------------------------------------------------------------
 * vayes_url_title ($str)
 * vayes_string_to_slug ($str,$separator='-',$lowercase=FALSE)
 * enable_third_party ($library_name)
 * ------------------------------------------------------------------------
 * STRING & TEXT HELPERS
 * ------------------------------------------------------------------------
 * replace_chars ($str,$replace_array=array())
 * starts_with ($haystack, $needle)
 * ends_with ($haystack, $needle)
 * text_limiter ($str='',$limit='16',$continue='&hellip;')
 * nbs ($num)
 * ------------------------------------------------------------------------
 * DATE & TIME HELPERS
 * ------------------------------------------------------------------------
 * is_invalid_date ($dateortimestring)
 * reformat_datetime (datetime=null,$target_format='d.m.Y')
 * get_datetime ()
 * insert_timestamp ($prefix='created',$include_by=false)
 * ------------------------------------------------------------------------
 * SECURITY HELPERS
 * ------------------------------------------------------------------------
 * e ($str)
 * hash ($str,$crypter='md5')
 * ------------------------------------------------------------------------
 * ARRAY HELPERS
 * ------------------------------------------------------------------------
 * modify_object ($value,&$data)
 * modify_array ($element,&$data=array())
 * array_all_true ($arr)
 * isset_true ($key,$data=FALSE)
 * multidimensional_array_comparer ()
 * multidimensional_object_comparer ()
 * reverse_array (&$data=array(),$preserve_keys=true)
 * ------------------------------------------------------------------------
 * HTML HELPERS
 * ------------------------------------------------------------------------
 * clear-fix($height)
 * ------------------------------------------------------------------------
 * FORM HELPERS
 * ------------------------------------------------------------------------
 * vset_value ($field_name,$default_value='',$db_data=NULL,$xss_clean=TRUE)
 * vset_checkbox ($field_name,$default_value=FALSE,$db_data=NULL)
 * build_data_from_form ($post_data=[],$fields=[],$fallback='0')
 * set_ml_form_rules ($fields=array(),$rules_data=array())
 * vset_value_ml ($field_name,$default_value='',$db_array=array())
 * vset_checkbox_ml ($field_name,$default_value=FALSE,$db_array='')
 * ml_convert_form_to_data ($data,$required_fields,$enabled_languages)
 * ml_form_array_trim ($data,$ignore_fields=array())
 * ml_convert_data_to_form ($data,$required_fields,$enabled_languages)
 * ------------------------------------------------------------------------
 * THIRD PARTY HELPERS :: BOOTSTRAP 3
 * ------------------------------------------------------------------------
 * btn_edit ($uri)
 * btn_delete ($uri)
 * bs_label ($str,$label_type='info')
 * glyphicon ($icon_name)
 * fa_icon ($icon_name,$size="",$fixed_width=false,$list_icon=false,$custom_class='')
 * bs_get_menu ($array,$child=false)
 * clearfix ($height='')
 * ------------------------------------------------------------------------
 * THIRD PARTY HELPERS :: IMAGE MOO LIBRARY
 * ------------------------------------------------------------------------
 * get_image ($src='',$width='200',$height='200',$target='vcached/moo_images')
 * human_filesize ($bytes,$decimals=2)
 * is_image ($file_type)
 * ------------------------------------------------------------------------
 * THIRD PARTY HELPERS :: JAVASCRIPT LIBRARIES & PLUGINS
 * ------------------------------------------------------------------------
 * Toastr ($method='',$heading='',$message='')            // jQuery Toastr Plugin
 * set_Toastr ($method='success',$message='N/A')
 * Interact($message=null,$fa_icon='envelope-o',$ttl=4E3) // Vayes Interact Object
 * set_Interact($message);
 * ------------------------------------------------------------------------
 */

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * JSON HELPERS
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::validateJSON
 *
 * @param string $str
 * @return boolean
 */
if(!function_exists('validateJSON')) {
  function validateJSON ($str='/') {
    $str = (string) $str;
    if((starts_with($str,'{')==TRUE) AND (ends_with($str,'}')==TRUE)):
      json_decode($str);
      return (json_last_error() == JSON_ERROR_NONE);
    else:
      return false;
    endif;
  }
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * AUTH HELPERS
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::is_logged
 *
 * @return integer
 */
if(!function_exists('is_logged')) {
  function is_logged () {
    $CI = &get_instance();
    return ($CI->session->userdata('is_logged')) ? $CI->session->userdata('uuid') : FALSE;
  }
}

// ------------------------------------------------------------------------



/**
 *---------------------------------------------------------------
 * PATH & URI HELPERS
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::vayes_url_title
 *
 * @param string $str
 * @param boolean $underscore
 * @return string
 */
if(!function_exists('vayes_url_title')) {
  function vayes_url_title ($str,$lowercase=TRUE) {
    return  ($slug = vayes_string_to_slug(convert_accented_characters($str),'-',$lowercase))
            ? $slug
            : vayes_url_title($_SERVER['SERVER_NAME'].'-'.do_hash(get_datetime(),'md5'),'-',$lowercase);
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::vayes_string_to_slug
 *
 * @param  string  $str
 * @param  string  $separator
 * @param  boolean $lowercase
 * @return string
 */
if(!function_exists('vayes_string_to_slug')) {
  function vayes_string_to_slug ($str,$separator='-',$lowercase=FALSE) {
    if ($separator=='dash') $separator = '-';
    else if ($separator=='underscore') $separator = '_';
    $q_separator = preg_quote($separator);
    $trans = array('\.'=>$separator,'\_'=>$separator,'&.+?;'=>'','[^a-z0-9 _-]'=>'','\s+'=>$separator,'('.$q_separator.')+'=>$separator);
    $str = strip_tags($str);
    foreach ($trans as $key => $val) $str = preg_replace("#".$key."#i", $val, $str);
    if ($lowercase === TRUE) $str = strtolower($str);
    return trim($str, $separator);
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::enable_third_party
 *
 * Theme Folder Access Helper with base_url()
 *
 * @access  public
 * @param string $library_name
 * @return  string
 */
if(!function_exists('enable_third_party')) {
  function enable_third_party ($library_name) {
    if(file_exists(APPPATH .'third_party/'.$library_name.'.php')){
      require_once APPPATH .'third_party/'.$library_name.'.php';
    } else {
      show_error($library_name . ' library is missing or inaccessible.');
    }
  }
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * STRING & TEXT HELPERS
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::replace_chars
 *
 * @param string $str
 * @param mixed $replace_array
 * @return string
 */
if(!function_exists('replace_chars')) {
  function replace_chars ($str,$replace_array=array()) {
    if(!empty($replace_array)) {
      foreach ($replace_array as $k => $v) {
        $str = str_replace($k,$v,$str);
      }
    }
    return $str;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::starts_with
 *
 * @param  string $haystack
 * @param  string $needle
 * @return boolean
 */
if(!function_exists('starts_with')) {
  function starts_with ($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::ends_with
 *
 * @param  string $haystack
 * @param  string $needle
 * @return boolean
 */
if(!function_exists('ends_with')) {
  function ends_with ($haystack, $needle) {
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::text_limiter
 *
 *  UTF-8 Text Limiter
 *
 * @access  public
 * @param string $str
 * @param integer $limit
 * @param string $continue
 * @return  string
 */
if(!function_exists('text_limiter')) {
  function text_limiter ($str='',$limit='16',$continue='&hellip;') {
    if(intval(mb_strlen($str)) <= intval($limit)) {
      return $str;
    } else {
      return mb_substr($str,0,intval($limit)) . $continue;
    }
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::nbs
 *
 * Generates non-breaking space entities based on number supplied
 *
 * @param int
 * @return  string
 */
if(!function_exists('nbs')) {
  function nbs ($num = 1) {
    return str_repeat('&nbsp;',$num);
  }
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * DATE & TIME HELPERS
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::is_invalid_date
 *
 * @param mixed $dateortimestring
 * @return string
 */
if (!function_exists('is_invalid_date')) {
  function is_invalid_date ($dateortimestring) {
    try {
      $date = new DateTime($dateortimestring);
      return FALSE;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::reformat_datetime
 *
 * @param mixed $datetime
 * @param string $target_format
 * @return string
 */
if (!function_exists('reformat_datetime')) {
  function reformat_datetime ($datetime=null , $target_format = 'Y-m-d H:i:s') {
    if($datetime) {
      if(is_int($datetime)):
        $date = new DateTime('now', new DateTimeZone('Europe/Istanbul'));
        $date->setTimestamp($datetime);
      else:
        $date = new DateTime($datetime, new DateTimeZone('Europe/Istanbul'));
      endif;
      if($target_format == 'datetime')            return $date->format('Y-m-d H:i:s');
      else if ($target_format == 'date_tr')       return $date->format('d.m.Y');
      else if ($target_format == 'time_tr')       return $date->format('H:i:s');
      else if ($target_format == 'datetime_tr')   return $date->format('d.m.Y H:i:s');
      else if ($target_format == 'timestamp')     return $date->getTimestamp();
      else                                        return $date->format($target_format);
    } else {
      return $datetime;
    }
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::get_datetime
 *
 * Returns current datetime in MYSQL DATETIME format
 * @param   $timestamp FALSE
 * @return string
 */
if (!function_exists('get_datetime')) {
  function get_datetime ($timestamp=FALSE) {
    $n = new DateTime('now', new DateTimeZone('Europe/Istanbul'));
    return ($timestamp) ? $n->getTimestamp() : $n->format('Y-m-d H:i:s');
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::insert_timestamp
 *
 * @param string $prefix
 * @param boolean $include_by
 * @return mixed
 */
if (!function_exists('insert_timestamp')) {
  function insert_timestamp ($prefix='created',$include_by=false) {
    $date = new DateTime('NOW', new DateTimeZone('Europe/Istanbul'));
    $result = array($prefix.'_at'=>$date->format('Y-m-d H:i:s'));
    if($include_by) $result += array($prefix.'_by'=>is_logged());
    return $result;
  }
}

// ------------------------------------------------------------------------

function relative_time($datetime){
  $timestamp = reformat_datetime($datetime,'timestamp');
  $CI = &get_instance();
  $difference = time()-$timestamp;
  $periods = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year','decade');
  $lengths = array('60','60','24','7','4.35','12','10000');
  if ($difference > 0):
    $suffix = 'ago';
  else:
    $difference = -$difference;
    $suffic = 'to_go';
  endif;
  $j = 0;
  $c = count($lengths);
  while ($difference >= $lengths[$j] && $j < count($lengths)):
    $difference /= $lengths[$j];
    $j++;
  endwhile;
  $difference = round($difference);
  $translation = ($difference == 1) ? $CI->lang->line('i18n_'.$periods[$j]) : $CI->lang->line('i18n_'.$periods[$j].'s');
  return $difference.nbs(1).$translation.nbs(1).$CI->lang->line('i18n_'.$suffix);
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * SECURITY HELPERS
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::e
 *
 * Escapes output.
 *
 * @param string $str
 * @return string
 */
if(!function_exists('e')) {
  function e ($str) {
    return htmlentities($str,ENT_QUOTES|ENT_HTML5);
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::vayes_hash
 *
 * Hashes given string by salting with CI's encryption_key
 *
 * @param  string $str
 * @param  string $crypter md5 returns 32 chars or sha512 returns 128 chars
 * @return string
 */
if(!function_exists('vayes_hash')) {
  function vayes_hash ($str,$crypter='md5') {
    $CI = &get_instance();
    return hash($crypter,$str.$CI->config->item('encryption_key'));
  }
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * ARRAY HELPERS
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::modify_object
 *
 * Modify an object property, add if not exists
 *
 * @param mixed $value
 * @param mixed $data
 * @return mixed
 */
if(!function_exists('modify_object')) {
  function modify_object ($value,&$data) {
    $data = $value;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::modify_array
 *
 * Add element to array
 *
 * @param mixed $element
 * @param mixed $data
 * @return mixed
 */
if(!function_exists('modify_array')) {
  function modify_array ($element,&$data=array()) {
    isset($data)        || $data = array();
    is_array($element)  || (array) $element;

    if(!empty($element)) {
      $c = count($data);
      foreach ($element as $k => $v) {
        if (array_key_exists($k,$data)) {
          if(is_integer($k)) {
            $data += array($c=>$v);
          } else {
            $data[$k] = $v;
          }
        } else $data += array($k=>$v);
        $c++;
      }
    }
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::array_all_true
 *
 * Check all values array if they are true
 *
 * @param mixed $element
 * @param mixed $data
 * @return mixed
 */
if(!function_exists('array_all_true')) {
  function array_all_true ($array) {
    foreach ($array as $element):
      if(empty($element)):
        return false;
      endif;
    endforeach;
    return true;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::isset_true
 *
 * Check if key exists and value is true
 *
 * @param mixed $element
 * @param mixed $data
 * @return mixed
 */
if(!function_exists('isset_true')) {
  function isset_true ($key,$data=FALSE) {
    if(!$data) {
      if((isset($key)) AND ($key)) return TRUE;
      else return FALSE;
    }
    if(is_object($data)) {
      if((isset($data->$key)) AND ($data->$key)) return TRUE;
      else return FALSE;
    } elseif (is_array($data)) {
      if((isset($data[$key])) AND ($data[$key]))  return TRUE;
      else return FALSE;
    } else return FALSE;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::multidimensional_array_comparer
 *
 * Sorts multidimensional array
 *
 * $data = array(
 *  array('zz', 'name' => 'Jack', 'number' => 22, 'birthday' => '12/03/1980'),
 *  array('xx', 'name' => 'Adam', 'number' => 16, 'birthday' => '01/12/1979'),
 *  array('aa', 'name' => 'Paul', 'number' => 16, 'birthday' => '03/11/1987'),
 *  array('cc', 'name' => 'Helen', 'number' => 44, 'birthday' => '24/06/1967'),
 * )
 *
 * usort($data, make_comparer('name'));
 * usort($data, make_comparer(0)); // 0 = first numerically indexed column
 * usort($data, make_comparer('number', 0)); // sort by "number" and then by the zero­indexed column:
 * usort($data, make_comparer(['name', SORT_DESC]));
 * usort($data, make_comparer(['number', SORT_DESC], ['name', SORT_DESC]));
 *
 * @return mixed
 */
if(!function_exists('multidimensional_array_comparer')) {
  function multidimensional_array_comparer () {
    // Normalize criteria up front so that the comparer finds everything tidy
    $criteria = func_get_args();
    foreach ($criteria as $index => $criterion) {
      $criteria[$index] = is_array($criterion)
        ? array_pad($criterion, 3, null)
        : array($criterion, SORT_ASC, null);
    }

    return function($first, $second) use (&$criteria) {
      foreach ($criteria as $criterion) {
        // How will we compare this round?
        list($column, $sortOrder, $projection) = $criterion;
        $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

        // If a projection was defined project the values now
        if ($projection) {
          $lhs = call_user_func($projection, $first[$column]);
          $rhs = call_user_func($projection, $second[$column]);
        }
        else {
          $lhs = $first[$column];
          $rhs = $second[$column];
        }

        // Do the actual comparison; do not return if equal
        if ($lhs < $rhs) {
          return -1 * $sortOrder;
        }
        else if ($lhs > $rhs) {
          return 1 * $sortOrder;
        }
      }
      return 0; // tiebreakers exhausted, so $first == $second
    };
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::multidimensional_object_comparer
 *
 * Sorts multidimensional array of objects
 *
 * usort($data, make_comparer('name'));
 * usort($data, make_comparer(0)); // 0 = first numerically indexed column
 * usort($data, make_comparer('number', 0)); // sort by "number" and then by the zero­indexed column:
 * usort($data, make_comparer(['name', SORT_DESC]));
 * usort($data, make_comparer(['number', SORT_DESC], ['name', SORT_DESC]));
 *
 * @return mixed
 */

if(!function_exists('multidimensional_object_comparer')) {
  function multidimensional_object_comparer () {
    // Normalize criteria up front so that the comparer finds everything tidy
    $criteria = func_get_args();
    foreach ($criteria as $index => $criterion) {
      $criteria[$index] = is_array($criterion)
        ? array_pad($criterion, 3, null)
        : array($criterion, SORT_ASC, null);
    }

    return function($first, $second) use (&$criteria) {
      foreach ($criteria as $criterion) {
        // How will we compare this round?
        list($column, $sortOrder, $projection) = $criterion;
        $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

        // If a projection was defined project the values now
        if ($projection) {
          $lhs = call_user_func($projection, $first->$column);
          $rhs = call_user_func($projection, $second->$column);
        }
        else {
          $lhs = $first->$column;
          $rhs = $second->$column;
        }

        // Do the actual comparison; do not return if equal
        if ($lhs < $rhs) {
          return -1 * $sortOrder;
        }
        else if ($lhs > $rhs) {
          return 1 * $sortOrder;
        }
      }
      return 0; // tiebreakers exhausted, so $first == $second
    };
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::reverse_array
 *
 * Reverses array using reference. Useful in breadcrumb.
 *
 * @param mixed $data
 * @param boolean $preserve_keys
 * @return mixed
 */
if(!function_exists('reverse_array')) {
  function reverse_array (&$data=array(),$preserve_keys=true) {
    $data = array_reverse($data,$preserve_keys);
  }
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * HTML HELPERS
 *---------------------------------------------------------------
 */

 /**
 * Inserts clearfix div based on CSS Framework
 *
 * @access  public
 * @return  string
 */
if(!function_exists('clearfix')) {
  function clearfix ($height='') {
    if($height==''):
      return '<div class="clear-fix" style="clear:both"></div>'."\n";
    else:
      return '<div class="clear-fix" style="clear:both;height:'.$height.'px;"></div>'."\n";
    endif;
  }
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * FORM HELPERS
 *---------------------------------------------------------------
 */

// ------------------------------------------------------------------------

/**
 * vayes_helper::vset_value
 *
 * Handles input|textarea|select value in forms
 *
 * @param  string  $field_name
 * @param  string  $default_value
 * @param  mixed   $db_data
 * @param  boolean $xss_clean
 * @return mixed
 */
if(!function_exists('vset_value')) {
  function vset_value ($field_name,$default_value='',$db_data=NULL,$xss_clean=TRUE) {
    //return TRUE;
    $CI = &get_instance();
    $value = $default_value;
    if($CI->input->post()):
      $value = $CI->input->post($field_name,$xss_clean);
    else:
      if(is_object($db_data)) {
        //vdebug($db_data->publish_on,TRUE);
        $value = (isset($db_data->$field_name)) ? $db_data->$field_name : $default_value;
      } else if((is_array($db_data)) AND (!empty($db_data)) AND (array_key_exists($field_name,$db_data))) {
        $value = (isset($db_data[$field_name])) ? $db_data[$field_name] : $default_value;
      }
    endif;
    return $value;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::vset_checkbox
 *
 * Handles checkbox state in forms
 *
 * @param  string  $field_name
 * @param  boolean $default_value
 * @param  mixed   $db_data
 * @return mixed
 */
if(!function_exists('vset_checkbox')) {
  function vset_checkbox ($field_name,$default_value=FALSE,$db_data=NULL) {
    $CI = &get_instance();
    $value = $default_value;
    if(!$CI->input->post()) {
      if(is_object($db_data) && isset($db_data->$field_name)) {
        $value = ($db_data->$field_name >0) ? TRUE : FALSE;
      } else if (is_array($db_data) && array_key_exists($field_name,$db_data)) {
        $value = ($db_data[$field_name] >0) ? TRUE : FALSE;
      }
    } else {
      $value = ($CI->input->post($field_name)) ? TRUE : FALSE;
    }
    return $value;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::build_data_from_form
 *
 * Match posted values with requested fields.
 * Adds non-existed fields to result array with fallback value
 *
 * @param  mixed  $post_data
 * @param  mixed  $fields
 * @param  string $fallback
 * @return mixed
 */
if (!function_exists('build_data_from_form')) {
  function build_data_from_form ($post_data=[],$fields=[],$fallback='0') {
    $result = array();
    foreach ($fields as $field) {
      if(isset($post_data[$field])) $result[$field] = $post_data[$field];
      else $result[$field] = $fallback;
    }
    return $result;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::set_ml_form_rules
 *
 * Set Form Rules for MultiLanguage Form Fields
 *
 * @param array $fields
 * @param array $rules_data
 */
if(!function_exists('set_ml_form_rules')) {
  function set_ml_form_rules ($fields=array(),$rules_data=array()) {
    $CI       = &get_instance();
    $rules    = array();
    $iterator = 0;
    if((!empty($fields) == TRUE) OR (!empty($rules_data) == TRUE)):
      foreach ($CI->enabled_languages as $row):
        foreach ($fields as $key => $value):
          $tmp[] = [
            'field' => $key.'['.$row->lang.']',
            'label' => '<span class="flag-icon flag-icon-'.$row->flag.'"></span> '.$value
          ];
          if(!$rules_data[$key]=='') $tmp[$iterator] += array('rules'=>$rules_data[$key]);
          $rules += $tmp;
          $iterator++;
        endforeach;
      endforeach;
      if($CI->form_validation->set_rules($rules)) return TRUE;
      else return FALSE;
    else:
      return FALSE;
    endif;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::vset_value_ml
 *
 * Handles input|textarea|select value for multilanguage field in forms
 *
 * @param  string $field_name
 * @param  string $default_value
 * @param  array  $db_array
 * @return mixed
 */
if(!function_exists('vset_value_ml')) {
  function vset_value_ml ($field_name,$default_value='',$db_array=array()) {
    $CI    = &get_instance();
    $field = substr($field_name, 0, -4);         // removes [tr] from the end of the name
    $lang  = substr(substr($field_name,-4),1,2); // returns [tr] then returns tr
    $value = $default_value;
    if($post_array = $CI->input->post()):
      $value = $post_array[$field][$lang];
    else:
      if(!empty($db_array)):
        foreach ($db_array as $row):
          if(isset($row[$field])) $value = (isset($row[$field][$lang])) ? $row[$field][$lang] : $default_value;
        endforeach;
      endif;
    endif;
    return $value;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::vset_checkbox_ml
 *
 * Handles checkbox state for multilanguage fields in forms
 *
 * @param  [type]  $field_name    [description]
 * @param  boolean $default_value [description]
 * @param  string  $db_array      [description]
 * @return [type]                 [description]
 */
if (!function_exists('vset_checkbox_ml')) {
  function vset_checkbox_ml ($field_name,$default_value=FALSE,$db_array='') {
    $CI    = &get_instance();
    $field = substr($field_name, 0, -4);         // removes [tr] from the end of the name
    $lang  = substr(substr($field_name,-4),1,2); // returns [tr] then returns tr
    $value = $default_value;
    if(!$post_array = $CI->input->post()):
      if(!empty($db_array)):
        foreach ($db_array as $row):
          if(isset($row[$field][$lang])):
            $value = ($row[$field][$lang] > 0) ? TRUE : FALSE;
          endif;
        endforeach;
      endif;
    else:
      $value = isset($post_array[$field][$lang]) ? TRUE : FALSE;
    endif;
    return $value;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::ml_convert_form_to_data
 *
 * @param  array $data
 * @param  array $required_fields
 * @param  array $enabled_languages
 * @param  mixed $default
 * @return array
 */
if (!function_exists('ml_convert_form_to_data')) {
  function ml_convert_form_to_data ($data,$required_fields,$enabled_languages,$default=0) {
    $result = array();
    $iterator = 0;
    foreach ($enabled_languages as $row):
      $result[$iterator]['lang'] = $row->lang;
      foreach ($required_fields as $field):
        $result[$iterator][$field] = isset($data[$field][$row->lang]) ? $data[$field][$row->lang] : $default;
      endforeach;
      $iterator++;
    endforeach;
    return $result;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::ml_form_array_trim
 *
 * @param  array $data
 * @param  array $ignore_fields
 * @return array
 */
if (!function_exists('ml_form_array_trim')) {
  function ml_form_array_trim ($data,$ignore_fields=array()) {
    $result = array();
    foreach ($data as $item):
      $has_values = false;
      foreach ($item as $key => $value):
        if (in_array($key, $ignore_fields)):
          continue;
        endif;
        if (!$value == ''): // if a value was set
          $has_values = true; // don't search for other values
          break;
        endif;
      endforeach;
      if ($has_values):
        $result[] = $item; // if the array has values, save the row in the result
      endif;
    endforeach;
    return $result;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::ml_convert_data_to_form
 *
 * @param  array $data
 * @param  array $required_fields
 * @param  array $enabled_languages
 * @return array
 */
if (!function_exists('ml_convert_data_to_form')) {
  function ml_convert_data_to_form ($data,$required_fields,$enabled_languages){
    $result = array();
    $languages = array();
    foreach ($enabled_languages as $row):
      $languages[] = $row->lang;
    endforeach;

    foreach ($data as $item):
      $iterator=0;
      foreach ($required_fields as $field):
        if (in_array($item['lang'], $languages))
        $result[$iterator][$field][$item['lang']] = $item[$field];
      endforeach;
      $iterator++;
    endforeach;
    return $result;
  }
}

// ------------------------------------------------------------------------


/**
 *---------------------------------------------------------------
 * THIRD PARTY HELPERS :: BOOTSTRAP 3
 *---------------------------------------------------------------
 */

// ------------------------------------------------------------------------

/**
 * vayes_helper::build_alert
 *
 * Returns Bootstrap-styled DELETE link
 * @param string $uri
 * @return string
 */
if(!function_exists('build_alert')) {
  function build_alert ($msg='',$type='info',$attributes='') {
    if($msg) {
      return '<div class="alert alert-'.$type.' fade in alert-dismissable'.(($attributes) ? ' '.$attributes : NULL).'" role="alert"><button type="button" class="close js-bind-event-close-btn" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$msg.'</div>';
    } else return FALSE;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::btn_edit
 *
 * Returns Bootstrap-styled EDIT link
 *
 * @param string $uri
 * @return string
 */
if(!function_exists('btn_edit')) {
  function btn_edit ($uri) {
    return anchor($uri,'<span class="glyphicon glyphicon-edit"></span>');
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::btn_delete
 *
 * Returns Bootstrap-styled DELETE link
 * @param string $uri
 * @return string
 */
if(!function_exists('btn_delete')) {
  function btn_delete ($uri) {
    return anchor($uri,'<span class="glyphicon glyphicon-remove"></span>',array(
      'onclick'=>"return confirm('Kaydı silmek üzeresiniz. Bu işlem geri alınamaz.\\nDevam etmek istediğinize emin misiniz?');"
    ));
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::bs_label
 *
 * Returns Bootstrap-styled label
 *
 * @param string $str
 * @param string $label_type success,warning,important,info,inverse
 * @return string
 */
if(!function_exists('bs_label')) {
  function bs_label ($str,$label_type='info') {
    return '<span class="label label-' . $label_type . '">'.$str.'</span>';
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::glyphicon
 *
 * Returns <i class="icon-*"></i>
 *
 * @param string icon_name
 * @return string
 */
if(!function_exists('glyphicon')) {
  function glyphicon ($icon_name) {
    return '<span class="glyphicon glyphicon-'. $icon_name.'"></span>';
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::fa_icon
 *
 * Returns <i class="icon-*"></i>
 *
 * @param string icon_name
 * @return string
 */
if(!function_exists('fa_icon')) {
  function fa_icon ($icon_name,$size="",$fixed_width=false,$list_icon=false,$custom_class='') {
    $class = 'fa fa-'.$icon_name;
    if($list_icon)    $class  = 'fa-li '. $class;
    if($size)         $class .= ' fa-' . $size;
    if($fixed_width)  $class .= ' fa-fw';
    if($custom_class) $class .= ' ' . $custom_class;
    return '<i class="'. $class . '"></i>&nbsp;';
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::bs_get_menu
 *
 * Creates bootstrap-2 styled navigation menu with given source.
 *
 * @param  array  $array
 * @param  boolean $child
 * @return string
 */
if(!function_exists('bs_get_menu')) {
  function bs_get_menu ($array,$child=false) {
    $CI =& get_instance();
    $str = '';
    if (count($array)) {
      $str .= $child == false ? '<ul class="nav">' . PHP_EOL : '<ul class="dropdown-menu">' . PHP_EOL;
      foreach ($array as $item) {
        $active = $CI->uri->segment(1) == $item['slug'] ? true : false;
        if (isset($item['children']) && count($item['children'])) {
          $str .= $active ? '<li class="dropdown active">' : '<li class="dropdown">';
          $str .= '<a  class="dropdown-toggle" data-toggle="dropdown" href="' . site_url(e($item['slug'])) . '">' . e($item['title']);
          $str .= '<b class="caret"></b></a>' . PHP_EOL;
          $str .= bs_get_menu($item['children'], true);
        } else {
          $str .= $active ? '<li class="active">' : '<li>';
          $str .= '<a href="' . site_url($item['slug']) . '">' . e($item['title']) . '</a>';
        }
        $str .= '</li>' . PHP_EOL;
      }
      $str .= '</ul>' . PHP_EOL;
    }
    return $str;
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::clearfix
 *
 * @param string $height
 * @return
 */
if(!function_exists('clearfix')) {
  function clearfix ($height='') {
    if($height == '') {
      $string  = '<div class="clearfix"></div>' . "\n";
    } else {
      $string  = '<div style="clear:both; height:' . $height . 'px;"></div>' . "\n";
    }
    return $string;
  }
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * THIRD PARTY HELPERS :: IMAGE MOO LIBRARY
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::get_image
 *
 * Displays resize_cropped (image_moo) image.
 *
 * @access  public
 * @param string $src     Image Source File i.e. "files/image.jpg"
 * @param string $width   Width of the requested image
 * @param string $height  Height of the requested image
 * @param string $action  resize_crop or resize
 * @param string $target  Target directory for saving requested image
 * @return  string
 */
if(!function_exists('get_image')) {
  function get_image ($src='',$width='200',$height='200',$action='resize_crop',$target='vcached/moo_images') {
    $CI = &get_instance();
    if(file_exists($src)) {
      $ext  = pathinfo($src, PATHINFO_EXTENSION);
      $dir  = dirname($src);
      $file = basename($src, '.'.$ext);

      $suffix = null;
      switch ($action) {
        case 'resize':
          $suffix = '_r';
          break;
        case 'resize_crop':
          $suffix = '_rc';
          break;
        default:
          $suffix = '_rc';
          break;
      }
      if(file_exists($cached_path = $target.'/'.$file.'_'.$width.'_by_'.$height.$suffix.'.'.$ext)) {
        return site_url($cached_path);
      } else {
        $CI->image_moo->load('./'.$src)
                      ->$action($width,$height)
                      ->save('./'.$target.'/'.$file.'_'.$width.'_by_'.$height.$suffix.'.'.$ext,TRUE);
        if($CI->image_moo->errors) {
          $CI->image_moo->clear();
          return json_encode($CI->image_moo->display_errors());
        } else {
          $CI->image_moo->clear();
          return site_url($target.'/'.$file.'_'.$width.'_by_'.$height.$suffix.'.'.$ext);
        }
      }
    } else return 'ERR :: '.$target.'/'.$file.'_'.$width.'_by_'.$height.$suffix.'.'.$ext. ' NOT FOUND!';
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::human_filesize
 *
 * @param integer $bytes
 * @param integer $decimals
 * @return string
 */
if(!function_exists('human_filesize')) {
  function human_filesize ($bytes, $decimals = 2) {
    $size = array('bytes','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::is_image
 *
 * Check if is image after CI upload
 *
 * @param string $file_type
 * @return  bool
 */
if(!function_exists('is_image')) {
  function is_image ($file_type) {
    $png_mimes  = array('image/x-png');
    $jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');
    if (in_array($file_type, $png_mimes)) {
      $file_type = 'image/png';
    }

    if (in_array($file_type, $jpeg_mimes)) {
      $file_type = 'image/jpeg';
    }

    $img_mimes = array('image/gif','image/jpeg','image/png');

    return (in_array($file_type, $img_mimes, TRUE)) ? TRUE : FALSE;
  }
}

// ------------------------------------------------------------------------

/**
 *---------------------------------------------------------------
 * THIRD PARTY HELPERS :: JAVASCRIPT LIBRARIES & PLUGINS
 *---------------------------------------------------------------
 */

/**
 * vayes_helper::Toastr
 *
 * @access  public
 * @param string $method   success,info,warning,error
 * @param string $heading
 * @param string $message
 * @return  string
 */

if(!function_exists('Toastr')) {
  function Toastr ($method='',$heading='',$message='') {
    $CI = &get_instance();
    if(!$method){
      if($CI->session->userdata('toastr-method')){
        $method  = $CI->session->userdata('toastr-method');
        $heading = $CI->session->userdata('toastr-message');
        $CI->session->unset_userdata('toastr-method');
        $CI->session->unset_userdata('toastr-message');
      } else {
        return NULL;
      }
    }

    if($message) {
      return "toastr.".$method."('".trim(preg_replace('/\s+/', ' ', $message))."','".trim(preg_replace('/\s+/', ' ', $heading))."');";
    } else {
      return "toastr.".$method."('".trim(preg_replace('/\s+/', ' ', $heading))."');";
    }
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::set_Toastr
 *
 * @param string $method
 * @param string $message
 * @return mixed
 */
if(!function_exists('set_Toastr')) {
  function set_Toastr ($message='Success!!',$method='success') {
    $CI = &get_instance();
    return $CI->session->set_userdata(['toastr-message'=>$message,'toastr-method'=>$method]);
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::Interact
 *
 * @param string  $message
 * @param string  $fa_icon
 * @param integer $ttl
 * @return mixed
 */
if(!function_exists('Interact')) {
  function Interact ($message=null,$fa_icon='',$ttl=4E3) {
    $CI = &get_instance();
    $icon = ($fa_icon) ? '<i class="v_mrm fa fa-'.$fa_icon.'"></i> ' : NULL;
    if($message) {
      return "Interact.show('".$icon.$message."',".$ttl.");";
    } else if($message = $CI->session->userdata('Interact')) {
      $CI->session->unset_userdata('Interact');
      return "Interact.show('".$icon.$message."',".$ttl.");";
    } else {
      return NULL;
    }
  }
}

// ------------------------------------------------------------------------

/**
 * vayes_helper::set_Interact
 *
 * @param string $message
 * @return mixed
 */
if(!function_exists('set_Interact')) {
  function set_Interact ($message='N/A') {
    $CI = &get_instance();
    return $CI->session->set_userdata(['Interact'=>$message]);
  }
}

// ------------------------------------------------------------------------


// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------

/* End of file vayes_helper.php */
/* Location: ./application/helpers/vayes_helper.php */
