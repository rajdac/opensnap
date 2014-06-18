<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! class_exists('Opensnap'))
{
     require_once(APPPATH.'libraries/opensnap.php');
}


$obj =& get_instance();
$obj->opensnap = Opensnap::getInstance();

$obj->ci_is_loaded[] = 'opensnap';


?>