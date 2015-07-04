<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * vCaptcha Library
 *
 * Based on CI's default Captcha Helper.
 *
 * Version 0.2
 *
 * Supports text, border, grid, background and shadow color
 * Range selection support for text color.
 *
 * Added in v.0.2
 * Transparent image support
 * Inline text color selection by short/long hex code and color name.
 *
 * @author Mohamed Tahhan
 * @author Yahya A. ERTURAN <root@yahyaerturan.com> [contributer]
 */

if ( ! function_exists('insert_captcha')) {
  function insert_captcha($transparent=false,$text_color='',$data='',$img_path='',$img_url='',$font_path='') {
    $CI             =& get_instance();
    $allowed_chars  = $CI->config->item('allowed_chars');
    $captcha_length = $CI->config->item('captcha_length');
    $font_size      = $CI->config->item('font_size');
    $word           = $CI->config->item('word');
    $img_path       = $CI->config->item('img_path');
    $img_url        = $CI->config->item('img_url');
    $font_path      = $CI->config->item('font_path');
    $img_width      = $CI->config->item('img_width');
    $img_height     = $CI->config->item('img_height');
    $expiration     = $CI->config->item('expiration');

    if($text_color) {
      $hex_to_rgb   = hex2rgb($text_color,true);
      $font_color_r = $hex_to_rgb[0];
      $font_color_g = $hex_to_rgb[1];
      $font_color_b = $hex_to_rgb[2];
    } else {
      $font_color_r = $CI->config->item('font_color_r');
      $font_color_g = $CI->config->item('font_color_g');
      $font_color_b = $CI->config->item('font_color_b');
    }

    $con_bg_color_r     = $CI->config->item('bg_color_r');
    $con_bg_color_g     = $CI->config->item('bg_color_g');
    $con_bg_color_b     = $CI->config->item('bg_color_b');
    $con_border_color_r = $CI->config->item('border_color_r');
    $con_border_color_g = $CI->config->item('border_color_g');
    $con_border_color_b = $CI->config->item('border_color_b');
    $con_grid_color_r   = $CI->config->item('grid_color_r');
    $con_grid_color_g   = $CI->config->item('grid_color_g');
    $con_grid_color_b   = $CI->config->item('grid_color_b');
    $con_shadow_color_r = $CI->config->item('shadow_color_r');
    $con_shadow_color_g = $CI->config->item('shadow_color_g');
    $con_shadow_color_b = $CI->config->item('shadow_color_b');
    $session_message    = $CI->config->item('session_message');

    $defaults = array('word'=>$word,'img_path'=>$img_path,'img_url'=>$img_url,'img_width'=>$img_width,'img_height'=>$img_height,'font_path'=>$font_path,'expiration'=>$expiration );

    foreach ($defaults as $key => $val) {
      if ( ! is_array($data)) {
        if ( ! isset($$key) OR $$key == '') {
          $$key = $val;
        }
      } else $$key = ( ! isset($data[$key])) ? $val : $data[$key];
    }

    if ($img_path == '' OR $img_url == '')  return FALSE;
    if ( ! @is_dir($img_path))              return FALSE;
    if ( ! is_writable($img_path))          return FALSE;
    if ( ! extension_loaded('gd'))          return FALSE;

    // -----------------------------------
    // Remove old images
    // -----------------------------------

    list($usec, $sec) = explode(' ', microtime());
    $now = ((float)$usec + (float)$sec);
    $current_dir = @opendir($img_path);
    while ($filename = @readdir($current_dir)) {
      if ($filename != '.' AND $filename != '..' AND $filename != 'index.html' AND $filename != '.gitignore') {
        $name = str_replace('.jpg','',$filename);
        if (($name + $expiration) < $now) {
          @unlink($img_path.$filename);
        }
      }
    }
    @closedir($current_dir);

    // -----------------------------------
    // Do we have a "word" yet?
    // -----------------------------------

    if ($word == '') {
      $pool = $allowed_chars;
      $str  = '';
      for ($i = 0; $i < $captcha_length; $i++) {
        $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
      }
      $word = $str;
    }

    // -----------------------------------
    // Determine angle and position
    // -----------------------------------

    $length = strlen($word);
    $angle  = ($length >= 6) ? rand(-($length-6), ($length-6)) : 0;
    $x_axis = rand(6, (360/$length)-16);
    $y_axis = ($angle >= 0 ) ? rand($img_height, $img_width) : rand(6, $img_height);

    // -----------------------------------
    // Create image
    // -----------------------------------

    // PHP.net recommends imagecreatetruecolor(), but it isn't always available
    if (function_exists('imagecreatetruecolor')) $im = imagecreatetruecolor($img_width, $img_height);
    else $im = imagecreate($img_width, $img_height);
    ! $transparent || imagealphablending($im, false);

    // -----------------------------------
    //  Assign colors
    // -----------------------------------

    if($transparent) {
      $bg_color     = imagecolorallocatealpha ($im, $con_bg_color_r , $con_bg_color_g , $con_bg_color_b, 127 );
      $border_color = imagecolorallocatealpha ($im, $con_border_color_r , $con_border_color_g , $con_border_color_b,127);
      $grid_color   = imagecolorallocatealpha ($im, $con_grid_color_r , $con_grid_color_g , $con_grid_color_b,127);
      $shadow_color = imagecolorallocate($im, $con_shadow_color_r , $con_shadow_color_g , $con_shadow_color_b);
    } else {
      $bg_color     = imagecolorallocate ($im, $con_bg_color_r , $con_bg_color_g , $con_bg_color_b );
      $border_color = imagecolorallocate ($im, $con_border_color_r , $con_border_color_g , $con_border_color_b);
      $grid_color   = imagecolorallocate ($im, $con_grid_color_r , $con_grid_color_g , $con_grid_color_b);
      $shadow_color = imagecolorallocate($im, $con_shadow_color_r , $con_shadow_color_g , $con_shadow_color_b);
    }

    // -----------------------------------
    //  Create the rectangle
    // -----------------------------------

    ImageFilledRectangle($im, 0, 0, $img_width, $img_height, $bg_color);
    ! $transparent || imagealphablending($im,true);

    // -----------------------------------
    //  Create the spiral pattern
    // -----------------------------------

    $theta    = 1;
    $thetac   = 7;
    $radius   = 16;
    $circles  = 20;
    $points   = 32;

    for ($i = 0; $i < ($circles * $points) - 1; $i++) {
      $theta = $theta + $thetac;
      $rad = $radius * ($i / $points );
      $x = ($rad * cos($theta)) + $x_axis;
      $y = ($rad * sin($theta)) + $y_axis;
      $theta = $theta + $thetac;
      $rad1 = $radius * (($i + 1) / $points);
      $x1 = ($rad1 * cos($theta)) + $x_axis;
      $y1 = ($rad1 * sin($theta )) + $y_axis;
      imageline($im, $x, $y, $x1, $y1, $grid_color);
      $theta = $theta - $thetac;
    }

    // -----------------------------------
    //  Write the text
    // -----------------------------------

    $use_font = ($font_path != '' AND file_exists($font_path) AND function_exists('imagettftext')) ? TRUE : FALSE;

    if ($use_font == FALSE) {
      $font_size = 6;
      $x = rand(0, $img_width/($length/3));
      $y = 0;
    } else {
      $x = rand(0, $img_width/($length/1.5));
      $y = $font_size+2;
    }

    for ($i = 0; $i < strlen($word); $i++) {
      if ($use_font == FALSE) {
        $y = rand(0 , $img_height/2);
        imagestring($im, $font_size, $x, $y, substr($word, $i, 1),imagecolorallocate ($im, $font_color_r, $font_color_g, $font_color_b));
        $x += ($font_size*2);
      } else {
        $y = rand($img_height/2, $img_height-3);
        imagettftext($im, $font_size, $angle, $x, $y, imagecolorallocate ($im, $font_color_r, $font_color_g, $font_color_b), $font_path, substr($word, $i, 1));
        $x += $font_size;
      }
    }

    // -----------------------------------
    //  Create the border
    // -----------------------------------

    imagerectangle($im, 0, 0, $img_width-1, $img_height-1, $border_color);

    // -----------------------------------
    //  Generate the image
    // -----------------------------------

    $img_name = $now.'.png';
    ! $transparent || imagesavealpha($im,true);
    imagepng($im, $img_path.$img_name);

    $img = "<img src=\"$img_url$img_name\" width=\"$img_width\" height=\"$img_height\" style=\"border:0;\" alt=\" \" id=\"captcha\" />";

    ImageDestroy($im);

    // Set user_data for capthcha word
    $CI->session->set_userdata('captcha_word',$word);
    if ( $CI->session->userdata('captcha_word') != $word) {
      $CI->session->set_flashdata('session_message',$session_message);
      echo $session_message;
    } else return array('word' => $word, 'time' => $now, 'image' => $img);
  }
}

// ------------------------------------------------------------------------

/**
 * vCaptcha
 *
 * @access  public
 * @param configration to create CAPTCHA function
 * @return string
 */
if ( ! function_exists('vCaptcha'))
{
  function vCaptcha($attributes = '',$text_color='',$transparent = false) {
    // Define verified color variable to be sent to insert_captcha()
    $hex_color = '';
    // Verify given hex code
    if(preg_match('/^#[a-f0-9]{6}$/i', $text_color)) {
      $hex_color = $text_color;
    } else if(preg_match('/^[a-f0-9]{6}$/i', $text_color)) {
      $hex_color = '#' . $text_color;
    } else if(preg_match('/^#[a-f0-9]{3}$/i', $text_color)) {
      $hex_color = $text_color;
    } else if(preg_match('/^[a-f0-9]{3}$/i', $text_color)) {
      $hex_color = '#' . $text_color;
    } else {
      $cn = color_names();
      $hex_color = (isset($cn[$text_color])) ? $cn[$text_color] : '';
    }

    $img = insert_captcha($transparent,$hex_color);
    $r   = '<div class="vCaptcha_wrapper">'."\n";
    $r  .= '<div class="vcaptcha_image">'."\n".$img['image']."\n".'</div>'."\n";
    $r  .= '<div class="vcaptcha_text">'."\n".form_input('vcaptcha','',$attributes)."\n".'</div>'."\n";
    $r  .= '</div>'."\n";
    return $r;
  }
}

// ------------------------------------------------------------------------

/**
 * hex2rgb
 *
 * Converts hex code to rgb
 *
 * @access  public
 *
 * @return mixed
 */
if ( ! function_exists('hex2rgb'))
{
  function hex2rgb($hex,$return_array=false) {
     $hex = str_replace('#','', $hex);

     if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
     } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
     }
     $rgb = array($r, $g, $b);

     if($return_array) return $rgb;
     else return implode(",", $rgb);
  }
}

// ------------------------------------------------------------------------

/**
 * color_names
 *
 * Returns color names array
 *
 * @access  public
 *
 * @return mixed
 */
if ( ! function_exists('color_names'))
{
  function color_names(){
    $cn = '{"aqua":"#00ffff","aliceblue":"#f0f8ff","antiquewhite":"#faebd7","black":"#000000","blue":"#0000ff","cyan":"#00ffff","darkblue":"#00008b","darkcyan":"#008b8b","darkgreen":"#006400","darkturquoise":"#00ced1","deepskyblue":"#00bfff","green":"#008000","lime":"#00ff00","mediumblue":"#0000cd","mediumspringgreen":"#00fa9a","navy":"#000080","springgreen":"#00ff7f","teal":"#008080","midnightblue":"#191970","dodgerblue":"#1e90ff","lightseagreen":"#20b2aa","forestgreen":"#228b22","seagreen":"#2e8b57","darkslategray":"#2f4f4f","darkslategrey":"#2f4f4f","limegreen":"#32cd32","mediumseagreen":"#3cb371","turquoise":"#40e0d0","royalblue":"#4169e1","steelblue":"#4682b4","darkslateblue":"#483d8b","mediumturquoise":"#48d1cc","indigo":"#4b0082","darkolivegreen":"#556b2f","cadetblue":"#5f9ea0","cornflowerblue":"#6495ed","mediumaquamarine":"#66cdaa","dimgray":"#696969","dimgrey":"#696969","slateblue":"#6a5acd","olivedrab":"#6b8e23","slategray":"#708090","slategrey":"#708090","lightslategray":"#778899","lightslategrey":"#778899","mediumslateblue":"#7b68ee","lawngreen":"#7cfc00","aquamarine":"#7fffd4","chartreuse":"#7fff00","gray":"#808080","grey":"#808080","maroon":"#800000","olive":"#808000","purple":"#800080","lightskyblue":"#87cefa","skyblue":"#87ceeb","blueviolet":"#8a2be2","darkmagenta":"#8b008b","darkred":"#8b0000","saddlebrown":"#8b4513","darkseagreen":"#8fbc8f","lightgreen":"#90ee90","mediumpurple":"#9370db","darkviolet":"#9400d3","palegreen":"#98fb98","darkorchid":"#9932cc","yellowgreen":"#9acd32","sienna":"#a0522d","brown":"#a52a2a","darkgray":"#a9a9a9","darkgrey":"#a9a9a9","greenyellow":"#adff2f","lightblue":"#add8e6","paleturquoise":"#afeeee","lightsteelblue":"#b0c4de","powderblue":"#b0e0e6","firebrick":"#b22222","darkgoldenrod":"#b8860b","mediumorchid":"#ba55d3","rosybrown":"#bc8f8f","darkkhaki":"#bdb76b","silver":"#c0c0c0","mediumvioletred":"#c71585","indianred":"#cd5c5c","peru":"#cd853f","chocolate":"#d2691e","tan":"#d2b48c","lightgray":"#d3d3d3","lightgrey":"#d3d3d3","thistle":"#d8bfd8","goldenrod":"#daa520","orchid":"#da70d6","palevioletred":"#db7093","crimson":"#dc143c","gainsboro":"#dcdcdc","plum":"#dda0dd","burlywood":"#deb887","lightcyan":"#e0ffff","lavender":"#e6e6fa","darksalmon":"#e9967a","palegoldenrod":"#eee8aa","violet":"#ee82ee","azure":"#f0ffff","honeydew":"#f0fff0","khaki":"#f0e68c","lightcoral":"#f08080","sandybrown":"#f4a460","beige":"#f5f5dc","mintcream":"#f5fffa","wheat":"#f5deb3","whitesmoke":"#f5f5f5","ghostwhite":"#f8f8ff","lightgoldenrodyellow":"#fafad2","linen":"#faf0e6","salmon":"#fa8072","oldlace":"#fdf5e6","bisque":"#ffe4c4","blanchedalmond":"#ffebcd","coral":"#ff7f50","cornsilk":"#fff8dc","darkorange":"#ff8c00","deeppink":"#ff1493","floralwhite":"#fffaf0","fuchsia":"#ff00ff","gold":"#ffd700","hotpink":"#ff69b4","ivory":"#fffff0","lavenderblush":"#fff0f5","lemonchiffon":"#fffacd","lightpink":"#ffb6c1","lightsalmon":"#ffa07a","lightyellow":"#ffffe0","magenta":"#ff00ff","mistyrose":"#ffe4e1","moccasin":"#ffe4b5","navajowhite":"#ffdead","orange":"#ffa500","orangered":"#ff4500","papayawhip":"#ffefd5","peachpuff":"#ffdab9","pink":"#ffc0cb","red":"#ff0000","seashell":"#fff5ee","snow":"#fffafa","tomato":"#ff6347","white":"#ffffff","yellow":"#ffff00"}';
    $cn = json_decode($cn,true);
    return $cn;
  }
}

// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------

/* End of file vcapthcha_helper.php */
/* Location: ./application/helpers/vcapthcha_helper.php */
