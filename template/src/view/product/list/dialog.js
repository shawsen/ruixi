define(function(require){
    /* generated by mengma @2018-05-19 02:06 */
    var form,dialog,params,callback;
    
    function init_dialog() 
    {/*{{{*/
        //1. new form
        form = new MWT.Form();
        form.addField('cateid',new MWT.TextField({
            type        : 'number',
            render      : 'fm-cateid',
            value       : '0', 
            placeholder : '请输入产品分类ID',
            empty       : false,
            errmsg      : "请输入产品分类ID,不超过1024个字符",
            checkfun    : function(v){return v.length<=1024;}
        }));
        form.addField('name',new MWT.TextField({
            type        : 'text',
            render      : 'fm-name',
            value       : '', 
            placeholder : '请输入分类名称',
            empty       : false,
            errmsg      : "请输入分类名称,不超过1024个字符",
            checkfun    : function(v){return v.length<=1024;}
        }));
        form.addField('name_zh',new MWT.TextField({
            type        : 'text',
            render      : 'fm-name_zh',
            value       : '', 
            placeholder : '请输入中文名称',
            empty       : false,
            errmsg      : "请输入中文名称,不超过1024个字符",
            checkfun    : function(v){return v.length<=1024;}
        }));
        form.addField('name_en',new MWT.TextField({
            type        : 'text',
            render      : 'fm-name_en',
            value       : '', 
            placeholder : '请输入英文名',
            empty       : false,
            errmsg      : "请输入英文名,不超过1024个字符",
            checkfun    : function(v){return v.length<=1024;}
        }));
        form.addField('desc_zh',new MWT.TextField({
            type        : 'text',
            render      : 'fm-desc_zh',
            value       : '', 
            placeholder : '请输入中文介绍',
            empty       : false,
            errmsg      : "请输入中文介绍,不超过1024个字符",
            checkfun    : function(v){return v.length<=1024;}
        }));
        form.addField('desc_en',new MWT.TextField({
            type        : 'text',
            render      : 'fm-desc_en',
            value       : '', 
            placeholder : '请输入英文介绍',
            empty       : false,
            errmsg      : "请输入英文介绍,不超过1024个字符",
            checkfun    : function(v){return v.length<=1024;}
        }));

        //2. new dialog
        dialog = new MWT.Dialog({
            title     : '对话框',
            top       : 50,
            width     : 550,
            form      : form,
            bodyStyle : 'padding:10px;',
            body : '<table class="mwt-formtab">'+
               '<tr><td width="100">产品分类ID <b style="color:red">*</b></td><td><div id="fm-cateid"></div></td></tr>'+
               '<tr><td>分类名称 <b style="color:red">*</b></td><td><div id="fm-name"></div></td></tr>'+
               '<tr><td>中文名称 <b style="color:red">*</b></td><td><div id="fm-name_zh"></div></td></tr>'+
               '<tr><td>英文名 <b style="color:red">*</b></td><td><div id="fm-name_en"></div></td></tr>'+
               '<tr><td>中文介绍 <b style="color:red">*</b></td><td><div id="fm-desc_zh"></div></td></tr>'+
               '<tr><td>英文介绍 <b style="color:red">*</b></td><td><div id="fm-desc_en"></div></td></tr>'+
            '</table>',
            buttons : [
                {label:"确定",cls:'mwt-btn-primary',handler:submitClick},
                {label:"取消",type:'close',cls:'mwt-btn-default'}
            ]
        });
        //3. dialog open event
        dialog.on('open',function(){
            form.reset();
            if (params.id) {
                dialog.setTitle("编辑记录");
                form.set(params);
            } else {
                dialog.setTitle("添加记录");
            }
        });
    }/*}}}*/

    var o={};
    o.open=function(_params,_callback){
        params   = _params;
        callback = _callback;
        if (!dialog) init_dialog();
        dialog.open();
    };  

    /////////////////////////////////////
    // 提交按钮点击事件
    function submitClick() {
        var data = form.getData();
        try {
            data.id = params.id;
            ajax.post('t_ruixi_product&action=save',data,function(res){
                if (res.retcode!=0) mwt.notify(res.retmsg,1500,'danger');
                else {
                    dialog.close();
                    if (callback) callback();
                }   
            }); 
        } catch (e) {
            mwt.notify(e,1500,'danger');
        }
    }

    return o;
});
