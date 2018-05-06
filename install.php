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
('company','公司简介','公司简介','Company','$addtime'),
('career','工作机会','工作机会','Careers','$addtime')
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
`displayorder` tinyint unsigned NOT NULL DEFAULT '255' comment '显示顺序',
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

$finish = TRUE;
?>
