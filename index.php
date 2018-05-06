<?php
/**
 * api入口
 **/
define("IN_RUIXI_API", 1);
define("RUIXI_PLUGIN_PATH", dirname(__FILE__));
chdir("../../../");

////////////////////////////////////////////////////////
// table类适配API
if (preg_match('/^t_/i',$_GET['module'])) {
    require './source/class/class_core.php';
    $discuz = C::app();
    $discuz->init();
    require_once RUIXI_PLUGIN_PATH."/class/env.class.php";
    try {
        $t = '#ruixi#'.substr($_GET['module'],2);
        $action = isset($_GET['action']) ? $_GET['action'] : ""; 
        $res = C::t($t)->$action();
        ruixi_env::result(array('data'=>$res));
        //die($t);
    } catch (Exception $e) {
        ruixi_env::result(array('retcode'=>100010,'retmsg'=>$e->getMessage()));
    }   
}
////////////////////////////////////////////////////////


$modules = array (
    'seccode','uc','dict',
    'admin',
);

if(!in_array($_GET['module'], $modules)) {
    module_not_exists();
}
$module  = $_GET['module'];
$version = !empty($_GET['version']) ? intval($_GET['version']) : 1;
if($version>4) $version=4;
while ($version>=1) {
    $apifile = RUIXI_PLUGIN_PATH."/api/$version/$module.php";
    if(file_exists($apifile)) {
        require_once $apifile;
        exit(0);
    }
    --$version;    
}
module_not_exists();

function module_not_exists()
{
	header("Content-type: application/json");
    echo json_encode(array('error' => 'module_not_exists'));
    exit;
}
?>
