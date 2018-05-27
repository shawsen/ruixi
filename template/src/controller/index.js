define(function(require){
    /* 默认controller */
    var BaseController = require('core/BaseController');
    var o = new BaseController('index');
    
    o._before_action=function(erurl){};
    o._after_action=function(erurl){};
    o.conf = {
        controller: o.controller,
        // 左部菜单
        menu: [
            {name:'全局配置', icon:'fa fa-bars', submenu:[
                {name:'公司信息', action:'cominfo'},
                {name:'首页Banner',action:'banner'},
            ]},
            {name:'模块管理', icon:'fa fa-bars', submenu:[
                {name:'模块列表',action:'modules'},
                {name:'页面列表',action:'pages'}
            ]},
            {name:'产品管理', icon:'fa fa-bars', submenu:[
                {name:'产品分类',action:'productCate'},
                {name:'产品列表',action:'productList'}
            ]},
        ]
    };

    o.indexAction=function() {
        window.location = '#/index/modules';
    };  

    // 公司信息
    o.cominfoAction=function(erurl) {
        require('view/cominfo/page').execute('frame-center',erurl.getQuery());
    }

    // 模块列表
    o.modulesAction=function(erurl) {
        require('view/modules/page').execute('frame-center',erurl.getQuery());
    };
    // 页面列表
    o.pagesAction=function(erurl) {
        require('view/pages/page').execute('frame-center',erurl.getQuery());
    };

    // 产品分类
    o.productCateAction=function(erurl) {
        require('view/product/cate/page').execute('frame-center',erurl.getQuery());
    };

    // 产品列表
    o.productListAction=function(erurl) {
        require('view/product/list/page').execute('frame-center',erurl.getQuery());
    };


    o.bannerAction=function() {
        var code = '首页Banner';
        frame.showpage(code);
    };

    o.companyAction=function(erurl) {
        require('view/company/setting/page').execute('frame-center',erurl.getQuery());
    };

    return o;
});
