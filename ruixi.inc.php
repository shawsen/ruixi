<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__)."/class/env.class.php";
$jumpurl = ruixi_env::get_siteurl()."/plugin.php?id=ruixi:index";
header("Location: $jumpurl");
