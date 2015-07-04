<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Site Config
 *
 * This page is manipulated by "settings" controller
 *
 * @package     Vayes EYS
 * @subpackage  Site Config Management
 * @author    Yahya A. Erturan
 * @copyright Copyright (c) 2014, Yahya A. Erturan
 * @link    http://www.yahyaerturan.com
 * @access public
*/
// ------------------------------------------------------------------------

//$config['allowed_chars']  = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$config['allowed_chars']  = '123456789';
//$config['allowed_chars']  = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
//$config['allowed_chars']  = 'abcdefghijklmnopqrstuvwxyz';
$config['captcha_length'] = '6';
$config['font_size']      = '18';
$config['word']           = '';
$config['img_path']       = './vcached/vcaptcha/';
$config['img_url']        =  BASE_URL.'vcached/vcaptcha/';
$config['font_path']      = './vcached/vfonts/StaticBuzz.ttf';
$config['img_width']      = '150';
$config['img_height']     = '50';
$config['expiration']     = '100';
//$config['color_r']      = rand('124','124');
$config['font_color_r']   = '116';
$config['font_color_g']   = '122';
$config['font_color_b']   = '128';
$config['bg_color_r']     = '242';
$config['bg_color_g']     = '242';
$config['bg_color_b']     = '242';
$config['border_color_r'] = '217';
$config['border_color_g'] = '217';
$config['border_color_b'] = '217';
$config['grid_color_r']   = '225';
$config['grid_color_g']   = '225';
$config['grid_color_b']   = '225';
$config['shadow_color_r'] = '252';
$config['shadow_color_g'] = '252';
$config['shadow_color_b'] = '252';
$config['session_message']= 'Cookie ayarlarınızı kontrol edin';

/* End of file vcaptcha.php */
/* Location: ./application/config/vcaptcha.php */
