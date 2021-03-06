<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__)."/class/env.class.php";
$plugin_path = ruixi_env::get_plugin_path();
$auth = C::t('#ruixi#ruixi_auth')->getByUid($_G['uid']);
$lan = C::m('#ruixi#ruixi_lang')->getLanguage();

try {
    // 公司新闻列表
    $newsList = C::m('#ruixi#ruixi_page')->getPagesByModule('news',0,8,'ctime','DESC');

    // 产品类型列表
    $productCateList = C::t('#ruixi#ruixi_product_cate')->getAll();

    // 公司简介模块页面列表
    $companyIntroductionPageList = C::m('#ruixi#ruixi_page')->getPagesByModule('company');

    $filename = basename(__FILE__);
    list($controller) = explode('.',$filename);
    include template("ruixi:".strtolower($controller));
    ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
    C::t('#ruixi#ruixi_log')->write("visit ruixi:index");
} catch (Exception $e) {
    $msg = $e->getMessage();
    include template("ruixi:Error");    
}
