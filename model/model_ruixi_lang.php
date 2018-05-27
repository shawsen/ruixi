<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 语言包 
 **/
class model_ruixi_lang
{
    // 中文
    private $lang_zh = array 
    (/*{{{*/
        'companyName' => '宁波睿熙科技有限公司',
        'companyAddr' => '浙江省余姚市丰悦路366-4号',
        'companyContact' => '0574-62828223',
        'companyFax' => '0574-62828189',
        'copyright' => '版权所有 © 2018 睿熙科技有限公司 保留所有权利。 ',
        'privacy' => '隐私权政策',
        'address' => '公司地址',
        'contact' => '联系我们',
        'fax' => '传真',
        'viewMore' => '查看更多',

        'home' => '主页',
        'product' => '产品',
        'companyIntroduction' => '公司介绍',
        'careers' => '招贤纳士',
        'shoppingCart' => '采购车',

        'how_to_buy' => '购买方式',
        'productSearch' => '产品搜索',

        'news' => '公司新闻',
        'applyJob' => '申请职位',
        'search' => '搜索',
        'empty' => '没有相关数据',
        'buyNow' => '立即采购',
        'clearCart' => '清空采购车',
    );/*}}}*/

    // 英文
    private $lang_en = array 
    (/*{{{*/
        'companyName' => 'Raysea Technology Company',
        'companyAddr' => 'No. 366-4 Fengyue Road, Yuyao, Zhejiang',
        'companyContact' => '0574-62828223',
        'companyFax' => '0574-62828189',
        'copyright' => 'Copyright © 2018 Raysea Technology Co.,Ltd. All rights reserved.',
        'privacy' => 'Privacy',
        'address' => 'Address',
        'contact' => 'Contact',
        'fax' => 'Fax',
        'viewMore' => 'View More',

        'home' => 'Home',
        'product' => 'Product',
        'companyIntroduction' => 'Company',
        'careers' => 'Careers',
        'shoppingCart' => 'Shopping Cart',

        'how_to_buy' => 'How To Buy',
        'productSearch' => 'Product Search',

        'news' => 'News',
        'applyJob' => 'Apply The Job',
        'search' => 'Search',
        'empty' => 'Get Nothing',
        'buyNow' => 'Buy Now',
        'clearCart' => 'Clear Cart',
    );/*}}}*/

    // 获取选择的语言
    public function getLanguage()
    {/*{{{*/
        global $_G;
        return isset($_G['cookie']['lang']) ? $_G['cookie']['lang'] : 'zh';
    }/*}}}*/

    // 获取语言包
	public function get()
	{/*{{{*/
        $res = $this->lang_zh;
        $language = $this->getLanguage();
        if ($language=='en') {
            $target = &$this->lang_en;
            foreach ($res as $k => &$v) {
                if (isset($target[$k])) $v = $target[$k];
            }
        }
        return $res;
	}/*}}}*/
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
