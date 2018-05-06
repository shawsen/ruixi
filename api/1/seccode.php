<?php
if (!defined('IN_RUIXI_API')) {
    exit('Access Denied');
}
/**
 * 图文验证码
 * URL: dzroot/source/plugin/ruixi/index.php?version=1&module=seccode
 **/
require './source/class/class_core.php';
$discuz = C::app();
$discuz->init();
require_once RUIXI_PLUGIN_PATH."/class/env.class.php";
$sc = C::m('#ruixi#ruixi_seccode');
/*
//debug
if (isset($_GET['seccode'])) {
	var_dump($sc->check($_GET['seccode']));
	die(0);
}
//*/
$code = $sc->mkcode(4,false);
$sc->display($code,120,40);
?>
