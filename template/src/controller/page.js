define(function(require){
    /* 默认controller */
    var BaseController = require('core/BaseController');
    var o = new BaseController('page');
    
    o._before_action=function(erurl){};
    o._after_action=function(erurl){};

    o.indexAction=function(erurl) {
        require('view/pageform/page').execute('frame-body',erurl.getQuery());
/*
        var code = '<div>'+
            '<ul class="mwt-nav mwt-nav-tabs">'+
            '<li class="mwt-active"><a href="javascript:void(0);">首页</a></li>'+
      <li><a href="javascript:void(0);">产品页</a></li>
      <li><a href="javascript:void(0);">联系我们</a></li>
      <li><a href="http://www.baidu.com/" target="_blank">百度</a></li>
    </ul>
  </div>';

        var code = 'aaa';
        frame.showpage(code);

//        var query = erurl.getQuery();
//        print_r(query);
//        alert('aa');
*/
    };  

    return o;
});
