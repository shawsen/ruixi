<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
/**
 * generated by mengma
 * @create: 2018-05-12 14:10
 * @usage: C::t('#ruixi#ruixi_product')->fun();
 **/
class table_ruixi_product extends discuz_table
{
    public function __construct() {
        $this->_table = 'ruixi_product';
        $this->_pk = 'id';
        parent::__construct();
    }

    // 搜索
    public function search($cateId,$key,$page=1,$limit=5,$sort='ctime',$dir='DESC')
    {/*{{{*/
        $return = array (
            'totalProperty' => 0,
            'root' => array(),
            'annex' => array('pages'=>array()),
        );
        $lan = C::m('#ruixi#ruixi_lang')->getLanguage();
        $start = ($page-1) * $limit;
        if ($start<0) $start = 0;
        $where = "a.isdel=0";
        if ($cateId>0) $where.= " AND cateid='$cateId'";
        if ($key!='') $where.= " AND a.name_$lan like '%$key%'";
        $table = DB::table('ruixi_product');
        $table_cate = DB::table('ruixi_product_cate');
        $sql = <<<EOF
SELECT SQL_CALC_FOUND_ROWS 
a.id,a.cateid,a.name_$lan as title,a.desc_$lan as 'desc',a.ctime,
b.name_$lan as catename
FROM $table as a
LEFT JOIN $table_cate as b ON a.cateid=b.id
WHERE $where
ORDER BY a.$sort $dir
LIMIT $start,$limit
EOF;
        $res = DB::fetch_all($sql);
        $row = DB::fetch_first("SELECT FOUND_ROWS() AS total");
        if (empty($res)) return $res;
        $return["totalProperty"] = intval($row["total"]);

        // 封装列表
        $siteurl = ruixi_env::get_siteurl();
        $ids = array();
        foreach ($res as &$im) {
            $ctime = strtotime($im['ctime']);
            $ids[] = $im['id'];
            $return['root'][] = array (
                'productId' => $im['id'],
                'title' => $im['title'],
                'summary' => ruixi_utils::get_summary($im['desc']),
                'url' => $siteurl."/plugin.php?id=ruixi:product&mod=view&pid=".$im['id'],
                'ctime' => date('Y/m/d',$ctime),
                'cateId' => $im['cateid'],
                'cateName' => $im['catename'],
            );
        }

        // 获取产品一张图片
        $imgmap = C::t('#ruixi#ruixi_images')->getImagesMap('product',$ids);
        foreach ($return['root'] as &$im) {
            $productId = $im['productId'];
            if (!empty($imgmap[$productId])) {
                $im['imgurl'] = $imgmap[$productId][0];
            } else {
                $im['imgurl'] = 'http://img.shawsen.com/gray/pic.png';
            }
        }

        // 分页列表
        $return['annex']['pages'] = ruixi_utils::get_pages($page,$limit,$return["totalProperty"]);
        return $return;
    }/*}}}*/


    // 根据主键获取记录
    public function get_by_pk($id) {
        $sql = "SELECT * FROM ".DB::table($this->_table)." WHERE ".$this->_pk."='$id' AND isdel=0";
        return DB::fetch_first($sql);
    }

    // 获取全部
    public function getOptions() {   
        $sql = "SELECT id as value,name as text FROM ".DB::table($this->_table)." WHERE isdel=0";
        return DB::fetch_all($sql);
    }

    // 查询接口
    public function query()
    {/*{{{*/
        $return = array(
            "totalProperty" => 0,
            "root" => array(),
        );
        $key   = ruixi_validate::getNCParameter('key','key','string');
        $sort  = ruixi_validate::getOPParameter('sort','sort','string',1024,'id');
        $dir   = ruixi_validate::getOPParameter('dir','dir','string',1024,'DESC');
        $start = ruixi_validate::getOPParameter('start','start','integer',1024,0);
        $limit = ruixi_validate::getOPParameter('limit','limit','integer',1024,20);
        $where = "isdel=0";
        if ($key!="") $where.=" AND (name like '%$key%')";
        $table = DB::table($this->_table);
        $sql = <<<EOF
SELECT SQL_CALC_FOUND_ROWS a.*
FROM $table as a
WHERE $where
ORDER BY $sort $dir
LIMIT $start,$limit
EOF;
        $return["root"] = DB::fetch_all($sql);
        $row = DB::fetch_first("SELECT FOUND_ROWS() AS total");
        $return["totalProperty"] = $row["total"];
        return $return;
    }/*}}}*/

    // 保存记录
    public function save()
    {/*{{{*/
        global $_G;
        $uid = $_G['uid'];
        $id = ruixi_validate::getNCParameter('id','id','integer');
        $record = array (
            'cateid' => ruixi_validate::getNCParameter('cateid','cateid','integer',1024),
            'name' => ruixi_validate::getNCParameter('name','name','string',1024),
            'name_zh' => ruixi_validate::getNCParameter('name_zh','name_zh','string',1024),
            'name_en' => ruixi_validate::getNCParameter('name_en','name_en','string',1024),
            'desc_zh' => ruixi_validate::getNCParameter('desc_zh','desc_zh','string',1024),
            'desc_en' => ruixi_validate::getNCParameter('desc_en','desc_en','string',1024),
        ); 
        if ($id==0) {
            $record['ctime'] = date('Y-m-d H:i:s');
            return $this->insert($record);
        } else {
            return $this->update($id,$record);
        }
    }/*}}}*/

    // 删除记录
    public function remove()
    {/*{{{*/
        $id = ruixi_validate::getNCParameter('id','id','integer');
        return $this->update($id,array('isdel'=>1));
    }/*}}}*/

    // 设置保存
    public function setEnable()
    {/*{{{*/
        $id = ruixi_validate::getNCParameter('id','id','integer');
        $enable = ruixi_validate::getNCParameter('enabled','enabled','integer');
        return $this->update($id,array('enabled'=>$enable));
    }/*}}}*/


}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
