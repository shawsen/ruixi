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
                {name:'首页Banner',action:'banner'},
            ]},
            {name:'模块管理', icon:'fa fa-bars', submenu:[
                {name:'模块列表',action:'modules'},
                {name:'页面列表',action:'pages'}
            ]}
        ]
    };

    o.indexAction=function() {
        window.location = '#/index/modules';
    };  

    // 模块列表
    o.modulesAction=function(erurl) {
        require('view/modules/page').execute('frame-center',erurl.getQuery());
    };
    // 页面列表
    o.pagesAction=function(erurl) {
        require('view/pages/page').execute('frame-center',erurl.getQuery());
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
