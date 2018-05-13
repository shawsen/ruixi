<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
/**
 * 购物车模块
 **/
require_once dirname(__FILE__)."/class/env.class.php";
$plugin_path = ruixi_env::get_plugin_path();
$auth = C::t('#ruixi#ruixi_auth')->getByUid($_G['uid']);
$lan = C::m('#ruixi#ruixi_lang')->getLanguage();
$lang = C::m('#ruixi#ruixi_lang')->get();

try {
    // 边栏区域
    $mid = 'product';
    $sideTitle = $lang['product'];
    $sideList = C::t('#ruixi#ruixi_product_cate')->getAll();

    include template("ruixi:cart/index");
    ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
    C::t('#ruixi#ruixi_log')->write("visit ruixi:cart/index");
} catch (Exception $e) {
    $msg = $e->getMessage();
    include template("ruixi:Error");    
}

