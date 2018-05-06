<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';

$params = array (
	'siteurl' => ruixi_env::get_siteurl(),
);
$tplVars = array(
    'siteurl'     => ruixi_env::get_siteurl(),
    'plugin_path' => ruixi_env::get_plugin_path(),
	'plugin_dir'  => dirname(__FILE__),
	'php_bin'     => PHP_BINDIR."/php",
);
ruixi_utils::loadtpl(dirname(__FILE__).'/template/views/z_about.tpl', $params, $tplVars);
ruixi_env::getlog()->trace("show admin page [z_about] success");
