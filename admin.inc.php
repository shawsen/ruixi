<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__)."/class/env.class.php";

// 登录检查
if(!$_G['uid']){
	$login = ruixi_env::get_siteurl()."/member.php?mod=logging&action=login";
    header("Location: $login");
    exit();
}
// 权限检查
$auth = C::t('#ruixi#ruixi_auth')->getByUid($_G['uid']);
if ($auth==0) {
    $msg = "很抱歉,您没有权限访问此页面!";
    include template("ruixi:Error");
	exit();
}

// 设置
$plugin_path = ruixi_env::get_plugin_path();
$filename = basename(__FILE__);
list($controller) = explode('.',$filename);
include template("ruixi:".strtolower($controller));
ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
C::t('#ruixi#ruixi_log')->write("visit ruixi:ruixi");
