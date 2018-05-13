<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
/**
 * 产品模块
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

    // 产品首页
    $mod = isset($_GET['mod']) ? $_GET['mod'] : 'index';
    if ($mod=='index') {
        include template("ruixi:product/index");
        ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
        C::t('#ruixi#ruixi_log')->write("visit ruixi:product/index");
    }

    // 产品列表页
    else if ($mod=='list') {
        $cateId = isset($_GET['cate']) ? intval($_GET['cate']) : 0;
        $key = isset($_GET['key']) ? $_GET['key'] : '';
        $title = $lang['search']." '$key'";
        $desc = "";
        if ($cateId>0) {
            $productCateInfo = array();
            foreach ($sideList as &$pcim) {
                if ($pcim['id']==$cateId) {
                    $productCateInfo = &$pcim;
                }
            }
            if (empty($productCateInfo)) {
                throw new Exception("找不到页面 (Page Not Found)");
            }
            $title = $productCateInfo['title'];
            $desc = $productCateInfo['desc'];
        }

        include template("ruixi:product/list");
        ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
        C::t('#ruixi#ruixi_log')->write("visit ruixi:product/list");
    }

    // 产品详情页
    else {
        $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
        if ($pid==0) throw new Exception("找不到页面 (Page Not Found)");
        $product = C::m('#ruixi#ruixi_product')->getDetail($pid);
        if (empty($product)) throw new Exception("找不到页面 (Page Not Found)");

        include template("ruixi:product/detail");
        ruixi_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
        C::t('#ruixi#ruixi_log')->write("visit ruixi:product/detail");
    }

} catch (Exception $e) {
    $msg = $e->getMessage();
    include template("ruixi:Error");    
}

