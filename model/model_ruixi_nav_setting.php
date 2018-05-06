<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 导航设置 
 * C::m('#ruixi#ruixi_nav_setting')->get()
 **/
class model_ruixi_nav_setting
{
    private $cfgkey = "ruixi_navmenu";

	// 获取默认配置
    public function get_default_setting()
    {
        $setting = array (
            // 导航菜单
            'navmenu' => array (
/*
                array('displayorder'=>1, 'text'=>'首页', 'icon'=>'fa fa-home', 'href'=>'#/',
                      'newtab'=>0, 'enable'=>1),
*/
            )
        );
		return $setting;
    }

    // 获取导航菜单列表
    public function get_navmenu() {
        $setting = $this->get();
        $navlist = array();
        foreach ($setting['navmenu'] as &$im) {
            if ($im['enable']!=1) { continue; }
            unset($im['enable']);
            unset($im['displayorder']);
            if (!empty($im['subitems'])) {
                $subitems = array();
                foreach ($im['subitems'] as $k => &$sim) {
                    if ($sim['enable']!=1) continue;
                    unset($sim['enable']);
                    unset($sim['displayorder']);
                    $subitems[] = $sim;
                }
                $im['subitems'] = $subitems;
            }
            if (empty($im['subitems'])) unset($im['subitems']);
            $navlist[] = $im;
        }
        return $navlist;
    }

    // 获取配置
    public function get() {
        $setting = $this->get_default_setting();
        global $_G;
        $cfgkey = $this->cfgkey;
        if (isset($_G['setting'][$cfgkey])) {
            $config = unserialize($_G['setting'][$cfgkey]);
            foreach ($setting as $k => &$v) {
                if (isset($config[$k])) {
                    $v = $config[$k];
                }
            }
        }
        return $setting;
    }

    // 恢复默认配置
    public function reset()
    {
        C::t('common_setting')->delete($this->cfgkey);
        updatecache('setting');
    }

    // 保存配置
    public function set(&$setting)
    {
        C::t('common_setting')->update($this->cfgkey,$setting);
        updatecache('setting');
    }
	
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
