<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';

class plugin_ruixi
{
    private $_enable_pluginids = array('ruixi');

    // 页面白名单
    private function isWhitePage() 
    {/*{{{*/
        $PHP_SELF = $_SERVER['PHP_SELF'];
        $mod = isset($_GET['mod']) ? $_GET['mod'] : '';
        //1. plugin模块
        if (strpos($PHP_SELF,'plugin.php')!==false && isset($_GET['id'])) {
            list($pluginId,$modId) = explode(':',$_GET['id']);
            if (in_array($pluginId,$this->_enable_pluginids)) {
                return true;
            }
        }
        //2. member模块
        if (strpos($PHP_SELF,'member.php')!==false) {
            //1-1. 登录页面不屏蔽
            if ($mod=='logging') return true;
        }
        //3. home模块
        if (strpos($PHP_SELF,"home.php")!==false) {
            //2-1. 编辑器页面不屏蔽
            if ($mod=='editor') return true;
        }

        return false;
    }/*}}}*/

    public function common()
    {
        global $_G;
        //1. 未开启屏蔽其他页面开关
        $setting = C::m('#ruixi#ruixi_setting')->get();
        if (!$setting['disable_discuz']) return;
        //2. 不屏蔽白名单页面 
        if ($this->isWhitePage()) return;
        //3. 跳转URL
        $jumpurl = ruixi_env::get_siteurl()."/plugin.php?id=ruixi:index";
        if (in_array('plugin',$_G['setting']['rewritestatus'])) {
            // 启用SEO设置的处理
            $jumpurl = ruixi_env::get_siteurl()."/ruixi-index.html";
            foreach ($this->_enable_pluginids as $plugin) {
                if (preg_match("/$plugin-[\w]*\.html$/i",$_SERVER['REQUEST_URI'])) {
                    return;
                }
            }
        }
        //4. 跳转到本插件页面
        header("Location: $jumpurl");
        exit(0);
    }
}

