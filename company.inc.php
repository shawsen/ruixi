<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
/**
 * 公司简介
 **/
require_once dirname(__FILE__)."/class/env.class.php";
$plugin_path = ruixi_env::get_plugin_path();
$auth = C::t('#ruixi#ruixi_auth')->getByUid($_G['uid']);
$filename = basename(__FILE__);
list($controller) = explode('.',$filename);
include template("ruixi:company/index");
ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
C::t('#ruixi#ruixi_log')->write("visit ruixi:$controller");

