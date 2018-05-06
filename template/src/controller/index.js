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
            {name:'页面模块', icon:'fa fa-bars', submenu:[
                {name:'公司简介',action:'company'},
            ]},
        ]
    };

    o.indexAction=function() {
        window.location = '#/index/banner';
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
