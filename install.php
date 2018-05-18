<?php
/*******************************************************
 * 此脚本文件用于插件的安装
 * 提示：可使用runquery() 函数执行SQL语句
 *       表名可以直接写“cdb_”
 * 注意：需在导出的 XML 文件结尾加上此脚本的文件名
 *******************************************************/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$addtime = $modtime = date('Y-m-d H:i:s');

// 用户权限表
$table = DB::table('ruixi_auth');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'DZ用户ID',
`auth` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '权限(0:无权限,1:普通用户,2:高级用户)',
`ctime` datetime NOT NULL DEFAULT "0000-00-00 00:00:00" comment '创建日期',
`mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
PRIMARY KEY (`uid`)
) ENGINE=MyISAM COMMENT '用户权限表'
EOF;
runquery($sql);
$sql="INSERT IGNORE INTO $table (uid,auth,ctime) VALUES (1,2,'$addtime')";
runquery($sql);
/*}}}*/

// 用户日志
$table = DB::table('ruixi_log');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`logid` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID(自增主键)', 
`logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '日志时间',
`uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
`client_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '来访IP',
`log_content` varchar(4096) NOT NULL DEFAULT '' COMMENT '日志内容',
PRIMARY KEY (`logid`),
KEY `idx_logtime_uid` (`logtime`,`uid`)
) ENGINE=InnoDB
EOF;
runquery($sql);
runquery("ALTER TABLE `$table` ENGINE=INNODB");
/*}}}*/

// 配置表
$table = DB::table('ruixi_setting');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`skey` varchar(255) NOT NULL DEFAULT '' COMMENT '键',
`svalue` text NOT NULL COMMENT '值', 
`mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
PRIMARY KEY (`skey`)
) ENGINE=MyISAM COMMENT '配置表'
EOF;
runquery($sql);
// 默认配置
$home_banner = array (
    array('img'=>'http://img.shawsen.com/banner/001.jpg','link'=>''),
    array('img'=>'http://img.shawsen.com/banner/002.jpg','link'=>''),
    array('img'=>'http://img.shawsen.com/banner/003.jpg','link'=>''),
);
$home_banner = serialize($home_banner);
$sql = "INSERT IGNORE INTO $table (skey,svalue) VALUES ".<<<EOF
('home_banner','$home_banner'),
('common_banner','http://img.shawsen.com/banner/004.jpg'),
('career_email','info@rayseasc.com'),
('sales_email','sales@rayseasc.com'),
('resume_downurl','http://img.shawsen.com/file/简历模板.docx')
EOF;
runquery($sql);
/*}}}*/

// 模块
$table = DB::table('ruixi_module');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`mid` varchar(64) NOT NULL DEFAULT '' COMMENT '模块ID', 
`mname` varchar(64) NOT NULL DEFAULT '' COMMENT '模块名',
`mname_zh` varchar(64) NOT NULL DEFAULT '' COMMENT '中文名',
`mname_en` varchar(64) NOT NULL DEFAULT '' COMMENT '英文名',
`ctime` datetime NOT NULL DEFAULT "0000-00-00 00:00:00" comment '创建日期',
`mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
`isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标志(0:未删,1:已删)',
PRIMARY KEY (`mid`)
) ENGINE=MyISAM COMMENT '模块表'
EOF;
runquery($sql);
$sql="INSERT IGNORE INTO $table (mid,mname,mname_zh,mname_en,ctime) VALUES ". <<<EOF
('product','产品','产品','Products','$addtime'),
('news','新闻发布','新闻发布','News','$addtime'),
('company','公司简介','公司简介','Company','$addtime'),
('career','招贤纳士','招贤纳士','Careers','$addtime')
EOF;
runquery($sql);
/*}}}*/

// 模块页面
$table = DB::table('ruixi_page');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`pid` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID(自增主键)', 
`pkey` varchar(64) NOT NULL DEFAULT '' COMMENT '标志符',
`lan` varchar(4) NOT NULL DEFAULT '' COMMENT '语言',
`mid` varchar(64) NOT NULL DEFAULT '' COMMENT '模块ID',
`title` varchar(128) NOT NULL DEFAULT '' COMMENT '标题',
`content` text NOT NULL DEFAULT '' COMMENT '内容',
`views` int unsigned NOT NULL DEFAULT '0' COMMENT '阅读次数',
`url` varchar(128) NOT NULL DEFAULT '' COMMENT 'URL',
`displayorder` smallint NOT NULL DEFAULT '255' comment '显示顺序',
`enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用标志(1:启用)',
`ctime` datetime NOT NULL DEFAULT "0000-00-00 00:00:00" comment '创建日期',
`mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
`isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标志(0:未删,1:已删)',
PRIMARY KEY (`pid`),
UNIQUE KEY `uk_pkey_lan` (`pkey`,`lan`),
KEY `idx_mid_enabled_isdel` (`mid`,`enabled`,`isdel`)
) ENGINE=MyISAM COMMENT '模块页面'
EOF;
runquery($sql);
$sql="INSERT IGNORE INTO $table (pid,pkey,lan,mid,title,content,url,ctime) VALUES ". <<<EOF
(1,'company_introduction','zh','company','公司简介','','company','$addtime'),
(2,'company_introduction','en','company','Company Overview','','company','$addtime'),
(3,'company_business','zh','company','主要业务','宁波睿熙科技有限公司的主要业务','company&mod=company_business','$addtime'),
(4,'company_business','en','company','What We Do','company_business','company&mod=company_business','$addtime')
EOF;
runquery($sql);
/*}}}*/

// 产品分类表
$table = DB::table('ruixi_product_cate');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID', 
`name` varchar(64) NOT NULL DEFAULT '' COMMENT '分类名称',
`name_zh` varchar(64) NOT NULL DEFAULT '' COMMENT '中文名称',
`name_en` varchar(64) NOT NULL DEFAULT '' COMMENT '英文名',
`desc_zh` text NOT NULL DEFAULT '' COMMENT '中文介绍', 
`desc_en` text NOT NULL DEFAULT '' COMMENT '英文介绍',
`imgurl` varchar(1024) NOT NULL DEFAULT '' COMMENT '图片地址',
`displayorder` smallint NOT NULL DEFAULT '255' comment '显示顺序',
`ctime` datetime NOT NULL DEFAULT "0000-00-00 00:00:00" comment '创建日期',
`mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
`isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标志(0:未删,1:已删)',
PRIMARY KEY (`id`)
) ENGINE=MyISAM COMMENT '产品分类表'
EOF;
runquery($sql);
$sql="INSERT IGNORE INTO $table (id,name,name_zh,name_en,desc_zh,desc_en,ctime) VALUES ". <<<EOF
('1','光纤收发器','光纤收发器','Optical Transceivers','','','$addtime'),
('2','光引擎','光引擎','Optical Engines','','','$addtime'),
('3','有源光缆','有源光缆','Active Optical Cables','','','$addtime'),
('4','光器件','光器件','Communication Components','','','$addtime'),
('5','光学仪器','光学仪器','Optical Instrumentation','','','$addtime')
EOF;
runquery($sql);
/*}}}*/

// 产品表
$table = DB::table('ruixi_product');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '产品ID', 
`cateid` int unsigned NOT NULL DEFAULT '0' COMMENT '产品分类ID',
`sn` varchar(64) NOT NULL DEFAULT '' COMMENT '产品型号/序列号', 
`name` varchar(64) NOT NULL DEFAULT '' COMMENT '分类名称',
`name_zh` varchar(64) NOT NULL DEFAULT '' COMMENT '中文名称',
`name_en` varchar(64) NOT NULL DEFAULT '' COMMENT '英文名',
`desc_zh` text NOT NULL DEFAULT '' COMMENT '中文介绍', 
`desc_en` text NOT NULL DEFAULT '' COMMENT '英文介绍',
`ctime` datetime NOT NULL DEFAULT "0000-00-00 00:00:00" comment '创建日期',
`mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
`isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标志(0:未删,1:已删)',
PRIMARY KEY (`id`),
KEY `idx_cateid_isdel` (`cateid`,`isdel`)
) ENGINE=MyISAM COMMENT '产品表'
EOF;
runquery($sql);
/*}}}*/

// 图片表
$table = DB::table('ruixi_images');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '图片ID', 
`item_type` varchar(32) NOT NULL DEFAULT 'product' COMMENT '关联类型',
`item_id` bigint unsigned NOT NULL DEFAULT '0' COMMENT '关联ID',
`url` varchar(1024) NOT NULL DEFAULT '' COMMENT '图片URL',
`ctime` datetime NOT NULL DEFAULT "0000-00-00 00:00:00" comment '创建日期',
`mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
`isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标志(0:未删,1:已删)',
PRIMARY KEY (`id`),
KEY `idx_item_type_item_id` (`item_type`,`item_id`)
) ENGINE=MyISAM COMMENT '图片表'
EOF;
runquery($sql);
runquery("ALTER TABLE `$table` ENGINE=INNODB");
/*}}}*/



$finish = TRUE;
?>
