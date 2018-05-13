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
            'mid' => '',
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
                    'mid' => $page['mid'],
                );
                break;
            }
        }
        return $res;
	}/*}}}*/

    // 根据模块ID获取显示的页面列表
    public function getPagesByModule($mid,$start=0,$limit=0,$sort='displayorder',$dir='ASC')
    {/*{{{*/
        $pageList = array();
        $lan = C::m('#ruixi#ruixi_lang')->getLanguage();
        $table = DB::table('ruixi_page');
        $sql = "SELECT pkey,lan,title,url,ctime ".
               "FROM $table WHERE mid='$mid' AND lan='$lan' AND isdel=0 AND displayorder>=0 AND title!='' ".
               "ORDER BY $sort $dir";
        if ($limit>0) {
            $sql.=" LIMIT $start,$limit";
        }
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
        foreach ($map as $k => $im) {
            $im = $map[$k];
            $ctime = strtotime($im['ctime']);
            $pageList[] = array (
                'title' => $im['title'],
                'url' => $siteurl."/plugin.php?id=ruixi:page&p=".$im['pkey'],
                'ctime' => date('Y/m/d',$ctime),
            );
        }
        return $pageList; 
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

    // 搜索页面
    public function search($mid,$key='',$page=1,$limit=5,$sort='ctime',$dir='DESC')
    {/*{{{*/
        $return = array (
            'totalProperty' => 0,
            'root' => array(),
            'annex' => array('pages'=>array()),
        );
        $lan = C::m('#ruixi#ruixi_lang')->getLanguage();
        $start = ($page-1) * $limit;
        if ($start<0) $start = 0;
        $where = "mid='$mid' AND lan='$lan' AND isdel=0 ";
        if ($key!='') $where.= " AND title like '%$key%'";
        else $where.= " AND title!=''";
        $table = DB::table('ruixi_page');
        $sql = <<<EOF
SELECT SQL_CALC_FOUND_ROWS pkey,title,content,url,ctime
FROM $table
WHERE $where
ORDER BY $sort $dir
LIMIT $start,$limit
EOF;
        $res = DB::fetch_all($sql);
        $row = DB::fetch_first("SELECT FOUND_ROWS() AS total");
        if (empty($res)) return $res;
        $return["totalProperty"] = intval($row["total"]);

        // 封装列表
        $siteurl = ruixi_env::get_siteurl();
        foreach ($res as $im) {
            $ctime = strtotime($im['ctime']);
            $return['root'][] = array (
                'title' => $im['title'],
                'summary' => ruixi_utils::get_summary($im['content']),
                'url' => $siteurl."/plugin.php?id=ruixi:page&p=".$im['pkey'],
                'ctime' => date('Y/m/d',$ctime),
            );
        }
        // 分页列表
        $return['annex']['pages'] = ruixi_utils::get_pages($page,$limit,$return["totalProperty"]);
        return $return;
    }/*}}}*/

}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
