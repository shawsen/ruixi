define(function(require){
    var BasePage = require('core/BasePage');
    var page = null;
    var o = {};
	o.execute = function(domid,query) {
        if (!page) {
            page = new BasePage({container:domid,pageid:'modules_admin',query: {
            }});
        }
        //1. 格式化请求参数&初始化页面元素(如果pageid存在不会重复初始化)
        var params = page.formatQuery(query);
        page.init('left:10px;right:10px;top:10px;bottom:10px;','mwt-layout-fill',function(pageid,params){
            require('./grid').init(pageid);
        });
    };
    return o;
});
