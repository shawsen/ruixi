define(function(require){
    var BasePage = require('core/BasePage');
    // var grid = require('./grid');
    var page = null;

    function initPage(pageid,params) {
        var code = '<h1>公司信息设置</h1>'+
            '<table class="mwt-formtab">'+
            '</table>';

        jQuery('#'+pageid).html(code);
    }

    var o = {};
	o.execute = function(domid,query) {
        if (!page) {
            page = new BasePage({container:domid,pageid:'company_info',query: {
            }});
        }
        //1. 格式化请求参数&初始化页面元素(如果pageid存在不会重复初始化)
        var params = page.formatQuery(query);
        page.init('left:10px;right:10px;top:10px;bottom:10px;','mwt-layout-fill',initPage);

        //2.
/*
        ajax.post('t_cache_log_pbs_bubble_data&action=queryPageList',params,function(res){
            if (res.retcode!=0) {
                mwt.alert(res.retmsg);
            } else {
//                print_r(res.data);
                citymap.setHeatData(res.data);
                queryStation(params);
            }   
        });
*/
    };

    return o;
});
