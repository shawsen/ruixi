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
        'companyAddr' => '浙江省余姚市丰悦路366-4号&nbsp;&nbsp;浙江省杭州市滨江区滨安路1190号智汇中心A座23楼',
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

        'down_resume' => '下载简历模板',

        'home_banner_title' => '技术创新者|全面的产品组合|值得信赖的合作伙伴|',
        'home_banner_content' => '宁波睿熙科技有限公司是全球技术领先的 VCSEL 供应商。核心团队成员拥有 20 年在世界一流 VCSEL 公司领导产品设计和生产制造的经验, 涵盖外延生长、工 艺制程、芯片设计与模拟、倒片封装、封装、高频测试与设计、大数据分析、失 效分析等所有 VCSEL 设计、制造管理领域。公司严格按照世界 500 强质量管理体 系要求约束,在生产管理和质量与可靠性上具有国际先进水平的核心竞争力。',
    );/*}}}*/

    // 英文
    private $lang_en = array 
    (/*{{{*/
        'companyName' => 'Raysea Technology Company',
        'companyAddr' => 'No. 366-4 Fengyue Road, Yuyao, Zhejiang&nbsp;&nbsp;23 floor, block A, Zhihui center, 1190 Binan Road, Binjiang District, Hangzhou, Zhejiang.',
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

        'news' => 'Company News',
        'applyJob' => 'Apply The Job',
        'search' => 'Search',
        'empty' => 'Get Nothing',
        'buyNow' => 'Buy Now',
        'clearCart' => 'Clear Cart',

        'down_resume' => 'Download Resume Template',

        'home_banner_title' => 'Technology Innovator | Comprehensive product portfolio | Reliable Partner |',
        'home_banner_content' => 'Ningbo RaySea Technology co., LTD is a global technology-leading VCSEL suppliers. Core team members with 20 years in the world-class VCSEL company leading product design and manufacturing experience, and cover the epitaxial growth, technological process, chip design and simulation, rewinds to packaging, packaging, high frequency test and design, data analysis, failure analysis, etc. All the VCSEL design, manufacturing management field. The company strictly complies with the requirements of the world top 500 quality management system and has the core competitiveness of international advanced level in production management, quality and reliability.',
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
