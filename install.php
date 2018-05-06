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

// 模块页面
$table = DB::table('ruixi_page');
/*{{{*/
$sql = "CREATE TABLE IF NOT EXISTS $table ". <<<EOF
(
`pid` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID(自增主键)', 
`pkey` varchar(64) NOT NULL DEFAULT '' COMMENT '标志符',
`lan` varchar(4) NOT NULL DEFAULT '' COMMENT '语言',
`title` varchar(128) NOT NULL DEFAULT '' COMMENT '标题',
`content` text NOT NULL DEFAULT '' COMMENT '内容',
`views` int unsigned NOT NULL DEFAULT '0' COMMENT '阅读次数',
`url` varchar(128) NOT NULL DEFAULT '' COMMENT 'URL',
`ctime` datetime NOT NULL DEFAULT "0000-00-00 00:00:00" comment '创建日期',
`mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
PRIMARY KEY (`pid`),
UNIQUE KEY `uk_pkey_lan` (`pkey`,`lan`)
) ENGINE=MyISAM COMMENT '模块页面'
EOF;
runquery($sql);
$sql="INSERT IGNORE INTO $table (pid,pkey,lan,title,content,url,ctime) VALUES ". <<<EOF
(1,'company_introduction','zh','公司简介','宁波睿熙科技有限公司是光通信领域的全球技术领导者。我们的世界级产品可在网络、存储、无线和有线电视应用中实现语音、视频和数据高速通信的高速通讯。25 年来，我们在光学技术领域不断创造重大技术突破，并为系统制造商提供了所需的大批量产品，以满足网络带宽的爆炸式增长需求。Finisar 业界领先的产品包括光纤收发器、光引擎、有源光缆、光器件、光学仪器、ROADM 和WSS波长管理器、光放大器和光载射频模块。','company','$addtime'),
(2,'company_introduction','en','Company Overview','','company','$addtime'),

(3,'company_business','zh','主要业务','宁波睿熙科技有限公司的主要业务','company&mod=company_business','$addtime'),
(4,'company_business','en','What We Do','company_business','company&mod=company_business','$addtime')

EOF;
runquery($sql);
/*}}}*/

$finish = TRUE;
?>
