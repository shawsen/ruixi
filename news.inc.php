<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
/**
 * 新闻页面
 **/
require_once dirname(__FILE__)."/class/env.class.php";
$plugin_path = ruixi_env::get_plugin_path();
$auth = C::t('#ruixi#ruixi_auth')->getByUid($_G['uid']);
$lan = C::m('#ruixi#ruixi_lang')->getLanguage();

try {
/*
    //1. 获取页面信息
    $pkey = isset($_GET['p']) ? $_GET['p'] : '';
    if ($pkey=='') {
        throw new Exception("找不到页面 (Page Not Found)");
    }
    $page = C::m('#ruixi#ruixi_page')->getPage($pkey);
    if (empty($page)) {
        throw new Exception("找不到页面 (Page Not Found)");
    }
*/
    //2. 获取模块信息
    $mid = 'news';
    $module = C::t('#ruixi#ruixi_module')->get_by_pk($mid);
    $sideTitle = isset($module['mname_'.$lan]) ? $module['mname_'.$lan] : $module['mname'];
    $sideList = C::m('#ruixi#ruixi_page')->getPagesByModule($mid,0,10,'ctime','DESC');
    //99.
    $filename = basename(__FILE__);
    list($controller) = explode('.',$filename);
    include template("ruixi:news/index");
    ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
    C::t('#ruixi#ruixi_log')->write("visit ruixi:$controller");

} catch (Exception $e) {
    $msg = $e->getMessage();
    include template("ruixi:Error");    
}

