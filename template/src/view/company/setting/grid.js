define(function(require){
    /* grid.js, (c) 2018 mawentao */
    var gridid,grid,store;

    var o={};

    o.init = function(domid) {
        gridid = domid;
        store = new mwt.Store({
            proxy: new mwt.MemoryProxy({
                data: [
                    {pkey:'company_introduction',title:'公司简介',url:'http://localhost:8888/discuz/plugin.php?id=ruixi:company&mod=company_business'}
                ]
            })  
        }); 
        grid = new MWT.Grid({
            render   : domid,
            store    : store,
            pagebar  : true,  // false 表示不分页
            pageSize : 20,
            bordered : false,  // false 不显示列边框
            striped  : true,    
            noheader : true,
            position : 'fixed',
            cm: new MWT.Grid.ColumnModel([
                {head:"页面", dataIndex:"pkey", align:'left', sort:true,width:100},
                {head:"页面", dataIndex:"title", align:'left', sort:true,render:function(v){
                    return v;
                }},
                {head:"页面", dataIndex:"pkey", align:'right',width:100,render:function(v,item){
                    var viewbtn = '<a class="grida" href="'+item.url+'" target="_blank">预览</a>';
                    var editbtn = '<a class="grida" href="javascript:;" name="editbtn-'+domid+'" data-id="'+item.pkey+'">编辑</a>';
                    var btns = [editbtn,viewbtn];
                    return btns.join('&nbsp;&nbsp;');
                }},
            ]),
            tbar: [
                '<label>页面列表<label>',
                '->',
                {type:"search",id:"so-key",width:140,placeholder:'查询关键词',handler:query},
                {label:"Add",handler:function(){alert("Add");}}
            ]
        }); 
        grid.create();
        store.on('load',function(){
            mwt.popinit();
            // 编辑按钮
            jQuery('[name=editbtn-'+gridid+']').unbind('click').click(editbtnClick);
            // 删除按钮
            jQuery('[name=delbtn-'+gridid+']').unbind('click').click(delbtnClick);
            // 启用开关
            jQuery('[name=adenable]').unbind('change').change(function(){
                var id = jQuery(this).data('dtname');
                var enable = jQuery(this).is(':checked') ? 1 : 0;
                ajax.post('t_ruixi_page&action=setEnable',{id:id,enabled:enable},function(res){
                    if (res.retcode!=0) mwt.notify(res.retmsg,1500,'danger');
                    mwt.notify('已保存',1500,'success');
                });
            });
        });
        store.load();
    };

    function query() {

    };

    return o;
});
