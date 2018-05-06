define(function(require){
    var BasePage = require('core/BasePage');
    var grid = require('./grid');
    var page = null;

    var o = {};
	o.execute = function(domid,query) {
        if (!page) {
            page = new BasePage({container:domid,pageid:'company_setting',query: {
            }});
        }
        //1. 格式化请求参数&初始化页面元素(如果pageid存在不会重复初始化)
        var params = page.formatQuery(query);
        page.init('left:10px;right:10px;top:10px;bottom:10px;','mwt-layout-fill',function(pageid,params){
            new mwt.BorderLayout({
                render : pageid,
                items : [ 
                    {id:'frame-west-'+pageid,region:'west',width:400,collapsible:true,split:true,html:'west'},
                    {id:'frame-center-'+pageid,region:'center',style:'',html:'center'}
                ]   
            }).init();
            // 初始化grid
            grid.init('frame-west-'+pageid);
        });
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
