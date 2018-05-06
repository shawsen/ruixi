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
        'companyAddr' => '浙江省余姚市丰锐路366-4号',
        'companyContact' => '0574-62828223',
        'copyright' => '版权所有© 2017 睿熙科技。保留所有权利。 ',
        'privacy' => '隐私权政策',

        'home' => '主页',
        'how_to_buy' => '购买方式',
        'companyIntroduction' => '公司简介',
        'contact' => '联系我们',

        'productSearch' => '产品搜索',

    );/*}}}*/

    // 英文
    private $lang_en = array 
    (/*{{{*/
        'companyName' => 'Ruixi Sience Company',
        'companyIntroduction' => 'Company',

        'home' => 'Home',
        'how_to_buy' => 'How To Buy',
        'contact' => 'Contact',

        'productSearch' => 'Product Search',
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
