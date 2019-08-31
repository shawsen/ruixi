宁波睿熙科技有限公司
===================================

# 一、软件部署

## 系统运行环境
- web服务器: Apache2 或 nginx
- PHP5.x
- MySQL5.x
- Discuz!X3.2及以上版本。

## Discuz!X3.2安装
- Discuz!X3.2下载: http://download.comsenz.com/DiscuzX/3.2/Discuz_X3.2_SC_UTF8.zip
- Discuz!官方论坛: http://www.discuz.net/forum.php

## 软件部署
- 第一步: 下载源码,把ruixi文件夹拷贝到discuz安装根目录/source/plugin
- 第二步: 进入discuz管理后台/应用, 找到睿熙科技应用,点击安装并启用


# 二、代码结构
网站所有页面由后端同步渲染输出，非单页式架构。页面模板代码位于templete目录下。各页面入口及模板文件如下图所示。
![](http://ankix.shawsen.com/data/gift/35/33/353388246c104299ded73ee621a7a9d1.png)

# 三、数据表
表名|表说明
--|--
pre_ruixi_setting|全局配置表,如首页banner图片配置等
pre_ruixi_product_cate|产品分类表
pre_ruixi_product|产品表
pre_ruixi_module|模块表,可以理解为是ruixi_page的分类
pre_ruixi_page|文章表,除产品有专门的表外,其他页面文章都是存储在此表中.增加或修改文章可以直接操作此表.
pre_ruixi_log|网站访问日志表


