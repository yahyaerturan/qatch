<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * vdebug()
 *
 * Debug Helper.
 *
 * Functions to print/dump variables to the screen with CI style formatting
 * and additional debug data.
 *
 * Inspired by the works of Joost van Veen[1] and Kevin Wood-Friend[2].
 * [1] http://github.com/joostvanveen/
 * [2] http://github.com/kwoodfriend/
 *
 * @author Yahya ERTURAN <root@yahyaerturan.com>
 * @version 1.0
 * @license https://github.com/yahyaerturan/codeigniter-developers-debug-helper/blob/master/LICENSE MIT License
 *
 *
 */
if ( ! function_exists('vdebug'))
{
  /**
   * vdebug()
   *
   * @param mixed $data
   * @param bool $die FALSE
   * @param bool $add_var_dump FALSE
   * @param bool $add_last_query TRUE
   * @return void
   */
  function vdebug($data, $die = false, $add_var_dump = false, $add_last_query = true)
  {
    $CI = &get_instance();
    $CI->load->library('unit_test');

    $bt = debug_backtrace();
    $src = file($bt[0]["file"]);
    $line = $src[$bt[0]['line'] - 1];
    # Match the function call and the last closing bracket
    preg_match('#' . __FUNCTION__ . '\((.+)\)#', $line, $match);
    $max = strlen($match[1]);
    $varname = NULL;
    $c = 0;
    for ($i = 0; $i < $max; $i++) {
      if ($match[1]{$i} == "(" ) $c++;
      elseif ($match[1]{$i} == ")" ) $c--;
      if ($c < 0) break;
      $varname .= $match[1]{$i};
    }

    if(is_object($data))     $message = 'Variable holds an OBJECT';
    elseif(is_array($data))  $message = 'Variable holds an ARRAY';
    elseif(is_string($data)) $message = 'Variable holds a  STRING';
    elseif(is_int($data))    $message = 'Variable holds a  INTEGER';
    elseif(is_true($data))   $message = 'Variable holds a  TRUE BOOLEAN';
    elseif(is_false($data))  $message = 'Variable holds a  FALSE BOOLEAN';
    elseif(is_null($data))   $message = 'Variable is NULL';
    elseif(is_float($data))  $message = 'Variable is FLOAT';
    else                     $message = 'N/A';

    $output  = '<div style="clear:both;"></div>';
    $output .= '<meta charset="UTF-8" />';
    $output .= '<style>::selection{background-color:#E13300!important;color:#fff}::moz-selection{background-color:#E13300!important;color:#fff}::webkit-selection{background-color:#E13300!important;color:#fff}div.debugbody{background-color:#fff;margin:40px;font:9px/12px normal;font-family:Arial,Helvetica,sans-serif;color:#4F5155;min-width:500px}a.debughref{color:#039;background-color:transparent;font-weight:400}h1.debugheader{color:#444;background-color:transparent;border-bottom:1px solid #D0D0D0;font-size:12px;line-height:14px;font-weight:700;margin:0 0 14px;padding:14px 15px 10px;font-family:\'Ubuntu Mono\',Consolas}code.debugcode{font-family:\'Ubuntu Mono\',Consolas,Monaco,Courier New,Courier,monospace;font-size:12px;background-color:#f9f9f9;border:1px solid #D0D0D0;color:#002166;display:block;margin:10px 0;padding:5px 10px 15px}pre.debugpre{display:block;padding:0;margin:0;color:#002166;font:12px/14px normal;font-family:\'Ubuntu Mono\',Consolas,Monaco,Courier New,Courier,monospace;background:0;border:0}div.debugcontent{margin:0 15px}p.debugp{margin:0;padding:0}.debugitalic{font-style:italic}.debutextR{text-align:right;margin-bottom:0;margin-top:0}.debugbold{font-weight:700}p.debugfooter{text-align:right;font-size:11px;border-top:1px solid #D0D0D0;line-height:32px;padding:0 10px;margin:20px 0 0}div.debugcontainer{margin:10px;border:1px solid #D0D0D0;-webkit-box-shadow:0 0 8px #D0D0D0}code.debug p{padding:0;margin:0;width:100%;text-align:right;font-weight:700;text-transform:uppercase;border-bottom:1px dotted #CCC;clear:right}code.debug span{float:left;font-style:italic;color:#CCC}</style>';
    $output .= '<div class="debugbody"><div class="debugcontainer">';
    $output .= '<h1 class="debugheader">'.$varname.'</h1>';
    $output .= '<div class="debugcontent">';
    $output .= '<code class="debugcode"><p class="debugp debugbold debutextR">:: Variable Type</p>' . $message . '</code>';
    if($add_last_query) {
      if($CI->db->last_query()) {
        $output .= '<code class="debugcode"><p class="debugp debugbold debutextR">:: $CI->db->last_query()</p>';
        $output .= $CI->db->last_query();
        $output .= '</code>';
      }
    }

    $output .= '<code class="debugcode"><p class="debugp debugbold debutextR">:: print_r</p><pre class="debugpre">';
    ob_start();
    print_r($data);
    $output .= trim(ob_get_clean());
    $output .= '</pre></code>';

    if($add_var_dump) {
      $output .= '<code class="debugcode"><p class="debugp debugbold debutextR">:: var_dump</p><pre class="debugpre">';
      ob_start();
      var_dump($data);
      $vardump = trim(ob_get_clean());
      $vardump = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $vardump);
      $output .=  $vardump;
      $output .= '</pre></code>';
    }

    $output .= '</div><p class="debugfooter">Vayes Debug Helper © Yahya A. Erturan</p></div></div>';
    $output .= '<div style="clear:both;"></div>';

    if (PHP_SAPI == 'cli') {
      echo $varname . ' = ' . PHP_EOL . $output . PHP_EOL . PHP_EOL;
      return;
    }

    echo $output;
    if ($die) exit;
  }
}

// ------------------------------------------------------------------------

/**
 * v_echo()
 *
 * @param mixed $var
 * @param string $custom_style
 * @return void
 */
if(!function_exists('v_echo')) {
  function v_echo ($var,$bgcolor='#3377CC',$custom_style='') {
    $style = 'font-family:\'Ubuntu Mono\';font-size:11pt;background:'.$bgcolor.';color:#FFF;border-radius:5px;padding:3px 6px;min-width:100px; max-width: 600px;word-wrap: break-word;';
    if($custom_style) $style = $custom_style;
    if((is_array($var)) OR (is_object($var))) {
      echo '<pre style="'.$style.'font-size:10pt;line-height:11pt;">'.json_encode($var, JSON_PRETTY_PRINT).'</pre>';
    } else {
      echo '<pre style="'.$style.'">'.$var.'</pre>';
    }
  }
}

if(!function_exists('terminal')) {
  function terminal($var,$die=TRUE){
    $CI = &get_instance();
    $CI->load->library('unit_test');

    $bt = debug_backtrace();
    $src = file($bt[0]["file"]);
    $line = $src[$bt[0]['line'] - 1];
    # Match the function call and the last closing bracket
    preg_match('#' . __FUNCTION__ . '\((.+)\)#', $line, $match);
    $max = strlen($match[1]);
    $varname = NULL;
    $c = 0;
    for ($i = 0; $i < $max; $i++) {
      if ($match[1]{$i} == "(" ) $c++;
      elseif ($match[1]{$i} == ")" ) $c--;
      if ($c < 0) break;
      $varname .= $match[1]{$i};
    }
    $str='
    <html><style type="text/css">body.ubuntu-terminal-body{margin:0;background:rgb(48,10,36);color:#fff;font-family:monospace;font-size:14px}div.ubuntu-terminal-container{width:100%;margin:0;padding:10px 5px 0px 5px}div.ubuntu-terminal-left{float:left;margin-right:10px}div.ubuntu-terminal-right{float:left}div.ubuntu-terminal-clearfix{display:block;clear:both;height:1px}span.ubuntu-terminal-variable-name{color:#0F0;font-weight:bold}hr.ubuntu-terminal-close-line{border:0;height:1px;background-image:-webkit-linear-gradient(left,rgba(200,200,200,0),rgba(200,200,200,0.75),rgba(200,200,200,0));background-image:-moz-linear-gradient(left,rgba(200,200,200,0),rgba(200,200,200,0.75),rgba(200,200,200,0));background-image:-ms-linear-gradient(left,rgba(200,200,200,0),rgba(200,200,200,0.75),rgba(200,200,200,0));background-image:-o-linear-gradient(left,rgba(200,200,200,0),rgba(200,200,200,0.75),rgba(200,200,200,0))}.ubuntu-cursor{float:left;margin-top:-2px;margin-left:4px;color:white;font-weight:bold;-webkit-animation:1s blink step-end infinite;-moz-animation:1s blink step-end infinite;-ms-animation:1s blink step-end infinite;-o-animation:1s blink step-end infinite;animation:1s blink step-end infinite}@keyframes "blink"{from,to{color:transparent}50%{color:#fff}}@-moz-keyframes blink{from,to{color:transparent}50%{color:#fff}}@-webkit-keyframes "blink"{from,to{color:transparent}50%{color:#fff}}@-ms-keyframes "blink"{from,to{color:transparent}50%{color:#fff}}@-o-keyframes "blink"{from,to{color:transparent}50%{color:#fff}}pre{color:#93AEFF;font-weight:bold;margin:5px}</style><body class="ubuntu-terminal-body"><div class="ubuntu-terminal-container"><div class="ubuntu-terminal-left">yahya@vayesweb:~$</div><div class="ubuntu-terminal-right"">cat ';
    $str.='<span class="ubuntu-terminal-variable-name">'.$varname.'</span>';
    $str.='</div><div class="ubuntu-cursor">█</div><div class="ubuntu-terminal-clearfix"></div></div>';

    if((is_array($var)) OR (is_object($var))) {
      $str.='<pre>'.json_encode($var, JSON_PRETTY_PRINT).'</pre>';
    } else {
      $str.='<pre>'.$var.'</pre>';
    }
    $str.='<hr class="ubuntu-terminal-close-line"/>';
    $str.='</body></html>';
    echo $str;
    if($die) exit;
  }
}

// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------

/* End of file vdebug_helper.php */
/* Location: ./application/helpers/vdebug_helper.php */
