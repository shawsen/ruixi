<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * C::m('#ruixi#ruixi_page')->func()
 **/
class model_ruixi_page
{
	/**
	 * 获取页面标题内容
	 **/
	public function getPage($pkey)
	{/*{{{*/
        $res = array (
            'title' => $pkey,
            'content' => '',
            'views' => 0,
        );
        $pages = C::t('#ruixi#ruixi_page')->getByPkey($pkey);
        if (empty($pages)) return $res;

        require_once libfile('function/discuzcode');

        $res = $pages[0];  //!< 默认选择第一条
        $lan = C::m('#ruixi#ruixi_lang')->getLanguage();
        foreach ($pages as &$page) {
            if ($page['lan']==$lan) {
                $res = array (
                    'title' => $page['title'],
                    'content' => htmlspecialchars_decode(discuzcode($page['content'])),
                    'views' => $page['views'],
                );
                break;
            }
        }
        return $res;
	}/*}}}*/

    public function getPageList(array &$pkeys)
    {/*{{{*/
        $pageList = array();
        $lan = C::m('#ruixi#ruixi_lang')->getLanguage();

        $ks = array();
        foreach ($pkeys as $k) {
            $ks[] = "'$k'";
        }
        $table = DB::table('ruixi_page');
        $sql = "SELECT pkey,lan,title,url FROM $table WHERE pkey IN (".implode(',',$ks).")";
        $res = DB::fetch_all($sql);
        if (empty($res)) return $pageList;

        $map = array();
        foreach($res as &$im) {
            $pkey = $im['pkey'];
            if (!isset($map[$pkey])) $map[$pkey] = $im;
            else if ($im['lan']==$lan) $map[$pkey] = $im;
        }

        // 封装列表
        $siteurl = ruixi_env::get_siteurl();
        foreach ($pkeys as $k) {
            if (isset($map[$k])) {
                $im = $map[$k];
                $pageList[] = array (
                    'title' => $im['title'],
                    'url' => $siteurl."/plugin.php?id=ruixi:".$im['url'],
                );
            }
        }
        return $pageList; 
    }/*}}}*/

}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
