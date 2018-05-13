<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * C::m('#ruixi#ruixi_product')->func()
 **/
class model_ruixi_product
{
    // 获取产品详情
    public function getDetail($productId)
    {/*{{{*/
        $res = array();
        // 获取记录
        $product = C::t('#ruixi#ruixi_product')->get_by_pk($productId);
        if (empty($product)) return $res;
        $siteurl = ruixi_env::get_siteurl();
        $lan = C::m('#ruixi#ruixi_lang')->getLanguage();
        $res = array (
            'productId' => $product['id'],
            'title' => $product['name_'.$lan],
            'desc' => $product['desc_'.$lan],
            'url' => $siteurl."/plugin.php?id=ruixi:product&mod=view&pid=".$product['id'],
        );
        // 获取图片列表
        $imgmap = C::t('#ruixi#ruixi_images')->getImagesMap('product',$productId);
        $res['imgs'] = $imgmap[$productId];
        if (empty($res['imgs'])) {
            $res['imgs'][] = 'http://img.shawsen.com/gray/pic.png';
        }
        return $res;
    }/*}}}*/
    
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
