define(function(require){
    var BasePage = require('core/BasePage');
    var params,page = null;
    var form;

    function initPage(pageid,params)
    {/*{{{*/
        // menu
        var menu = [
            {id:'zh',name:'中文'},
            {id:'en',name:'English'}
        ];
        var lis = [];
        for (var i=0;i<menu.length;++i) {
            var im = menu[i];
            var cls = im.id==params.lan ? ' class="mwt-active"' : '';
            lis.push('<li'+cls+'><a href="#/page~pkey=company_introduction&lan='+im.id+'">'+im.name+'</a></li>');
        }
        var code = '<h1 style="margin:0 0 10px;padding:0;font:normal 14px \'microsoft yahei\';">编辑页面 (#'+params.pkey+')</h1>'+
            '<div style="margin-bottom:10px;"><ul class="mwt-nav mwt-nav-tabs">'+lis.join('')+'</div>'+
            '<table class="mwt-formtab">'+
                '<tr>'+
                    '<td width="60">标 题:</td>'+
                    '<td width="50%"><div id="fm-title"></div></td>'+
                    '<td class="tips">不超过64个字符</td>'+
                '</tr>'+
                '<tr><td colspan="3">'+get_html_editor()+'</td></tr>'+
                '<tr><td></td><td colspan="2">'+
                    '<button id="subbtn" class="mwt-btn mwt-btn-primary mwt-btn-sm">保存</button>'+
                '</td></tr>'+
            '</table>';
        jQuery('#'+pageid).html(code);
        //
        form = new MWT.Form();
        form.addField('title',new MWT.TextField({
            type        : 'text',
            render      : 'fm-title',
            value       : '', 
            placeholder : '请输入标题',
            empty       : false,
            errmsg      : "请输入标题,不超过64个字符",
            checkfun    : function(v){return v.length<=64;}
        }));
        form.create();
        // 
        jQuery('#subbtn').unbind('click').click(submit);
    }/*}}}*/

    function submit() 
    {/*{{{*/
        var data = form.getData();
        /////////////////////////////////////////////////////
        var content = get_editor_bbcode();
        data['content'] = dz_post_encode(content);
        if (data['content']=='') {
            mwt.notify('内容不能为空',1500,'danger');
            return;
        }
        /////////////////////////////////////////////////////
        data['pkey'] = params.pkey;
        data['lan'] = params.lan;
        ajax.post('admin&action=savePageContent',data,function(res){
            if (res.retcode!=0) mwt.alert(res.retmsg);
            else mwt.notify('已保存',1500,'success');
        });
    }/*}}}*/


    var o = {};
	o.execute = function(domid,query) {
        if (!page) {
            page = new BasePage({container:domid,pageid:'pageform',query: {
                pkey : '',
                lan  : 'zh'
            }});
        }
        //1. 格式化请求参数&初始化页面元素(如果pageid存在不会重复初始化)
        params = page.formatQuery(query);
        page.init('left:20px;right:20px;top:10px;bottom:10px;','mwt-layout-fill',initPage);
        //2. 
        ajax.post('admin&action=getPageContent',params,function(res){
            if (res.retcode!=0) mwt.alert(res.retmsg);
            else {
                form.set(res.data);
                set_editor_bbcode(res.data.content);
            }
        });
    };

    return o;
});
