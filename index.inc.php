<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__)."/class/env.class.php";
$plugin_path = ruixi_env::get_plugin_path();
$filename = basename(__FILE__);
list($controller) = explode('.',$filename);
include template("ruixi:".strtolower($controller));
ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
C::t('#ruixi#ruixi_log')->write("visit ruixi:index");
