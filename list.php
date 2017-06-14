<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<?php
require 'common/config.php';
$db = new db();
if(!empty($_GET["cat"])){$cat = $_GET["cat"];}else{exit;}
if(isset($_GET["page"])){$page = $_GET["page"];}else{$page = 1;}
$where['where']="id=$cat";
$catinfo = $db->find("arctype",$where);
$pagesize=15;
$where2['where']="typeid=$cat and ischeck=0";
$where2['order']="id desc";
$counts = $db->count("article",$where2);
$where2['limit']=$pagesize*($page-1).",".$pagesize;
$posts = $db->select("article",$where2);
?>
<title><?php if(!empty($catinfo["seotitle"])){ echo $catinfo["seotitle"]; }else{ echo $catinfo['typename'].'_'.CMS_WEBNAME; } ?></title>
<meta name="keywords" content="<?php echo $catinfo['keywords']; ?>">
<meta name="description" content="<?php echo $catinfo['description']; ?>">
<link href="/css/bootstrap.css" rel="stylesheet">
<link href="/css/bxslider.css" rel="stylesheet">
<link href="/css/style.css" rel="stylesheet">
<script src="/js/jquery.min.js"></script>
<script src="/js/bxslider.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/bootstrap.js"></script><link rel="stylesheet" href="/css/share_style0_16.css"></head><body>
<script type="text/javascript">try {var urlhash = window.location.hash;if (!urlhash.match("fromapp")){if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i))){window.location="wap_index.asp";}}}catch(err){}</script>
<link href="/css/lanrenzhijia.css" rel="stylesheet" type="text/css">
<script src="/js/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<div id="online_qq_layer" style="z-index:1000;"><div id="online_qq_tab"><div class="online_icon"><a title="" id="floatShow" style="display:none" href="javascript:void(0);">&nbsp;</a><a title="" id="floatHide" style="display:block" href="javascript:void(0);">&nbsp;</a></div></div><div id="onlineService" style="display: block;"><div class="online_windows overz"><div class="online_w_top"></div><div class="online_w_c overz"><div class="online_bar expand" id="onlineSort1"><h2><a onclick="changeOnline(1)">在线客服</a></h2><div class="online_content overz" id="onlineType1" style="display: block;"><ul class="overz"><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=12345678&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">售前咨询</a></li><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=987654321&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">售后服务</a></li><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=11223344&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">加盟代理</a></li><li><a title="点击这里给我发消息" href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=taobao&amp;siteid=cntaobao&amp;status=1&amp;charset=utf-8" target="_blank" class="ww_icon">淘宝客服</a></li></ul></div></div><div class="online_bar collapse2" id="onlineSort2"><h2><a onclick="changeOnline(2)">电话客服</a></h2><div class="online_content overz" id="onlineType2" style="display: none;"><ul class="overz"><li>010-10086</li><li>010-10010</li></ul></div></div><div class="online_bar collapse2" id="onlineSort3"><h2><a onclick="changeOnline(3)">网站二维码</a></h2><div class="online_content overz" id="onlineType3" style="display: none;"><ul class="overz"><img src="images/index.png" width="120"></ul></div></div><div class="online_bar collapse2" id="onlineSort4"><h2><a onclick="changeOnline(4)">微信公众号</a></h2><div class="online_content overz" id="onlineType4" style="display: none;"><ul class="overz"><img src="images/20150921144410012.jpg" width="120"></ul></div></div></div><div class="online_w_bottom"></div></div></div></div>
<div class="toolbar"><a href="http://s66.demo.s-cms.cn/member" class="toolbar-item toolbar-item-feedback"></a><a href="javascript:scroll(0,0)" class="toolbar-item toolbar-item-top"></a></div>
<link href="/css/language-selector.css" rel="stylesheet" type="text/css">
<div id="lang_sel" style="right:20px;POSITION: fixed;top:20px;z-index:10000; ">
<ul><li class="icl-zh-hans"><a href="http://s66.demo.s-cms.cn/" class="lang_sel_sel"><img class="iclflag" src="images/0.png" alt="China" title="简体中文"> 简体中文</a><ul><li class="icl-en"><a href="http://s66.demo.s-cms.cn/indexe.html"><img class="iclflag" src="images/1.png" alt="en" title="English">    English</a></li></ul></li></ul><script src="images/lang-select.asp.下载"></script>
</div>

<header>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-9 col-md-9"> <a href="http://s66.demo.s-cms.cn/"><img src="/images/20160820232652166.png" class="logo" alt=""></a> </div>
      <div id="topsearch" class="col-xs-12 col-sm-3 col-md-3">
        <form id="searchform" name="formsearch" action="http://s66.demo.s-cms.cn/search.asp?action=search" method="post">
        
          <div class="input-group search_group">
            <input type="text" name="keyword" class="form-control input-sm" placeholder="在这里搜索">
            <span class="input-group-btn"> <a href="javascript:searchform.submit();" class="btn btn-sm mysearch_btn" type="button">搜 索</a> </span> </div>
        </form>
      </div>
    </div>
  </div>
  
  
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <span id="small_search" class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="glyphicon glyphicon-home home-btn" aria-hidden="true" onclick="location.href=&#39;/&#39;" style="cursor: pointer"></span> <a class="navbar-brand" href="http://s66.demo.s-cms.cn/">导航菜单</a> </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav"><li class="dropdown"> <a href="http://s66.demo.s-cms.cn/index.html">网站首页</a> <a href="http://s66.demo.s-cms.cn/index.html" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a></li><li class="dropdown"> <a href="http://s66.demo.s-cms.cn/html/about/1.html">关于我们</a> <a href="http://s66.demo.s-cms.cn/html/about/1.html" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a><ul class="dropdown-menu nav_small" role="menu"><li><a href="http://s66.demo.s-cms.cn/html/about/1.html">公司简介</a></li><li><a href="http://s66.demo.s-cms.cn/html/about/2.html">公司文化</a></li></ul></li><li class="dropdown"> <a href="http://s66.demo.s-cms.cn/html/product/list-1.html">产品展示</a> <a href="http://s66.demo.s-cms.cn/html/product/list-1.html" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a><ul class="dropdown-menu nav_small" role="menu"><li><a href="http://s66.demo.s-cms.cn/html/product/list-3.html">尼康</a></li><li><a href="http://s66.demo.s-cms.cn/html/product/list-2.html">佳能</a></li><li><a href="http://s66.demo.s-cms.cn/html/product/list-4.html">莱卡</a></li></ul></li><li class="dropdown"> <a href="http://s66.demo.s-cms.cn/html/product/list-6.html">案例中心</a> <a href="http://s66.demo.s-cms.cn/html/product/list-6.html" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a><ul class="dropdown-menu nav_small" role="menu"><li><a href="http://s66.demo.s-cms.cn/html/product/list-7.html">成功案例</a></li></ul></li><li class="dropdown"> <a href="http://s66.demo.s-cms.cn/html/news/list-1.html">新闻中心</a> <a href="http://s66.demo.s-cms.cn/html/news/list-1.html" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a><ul class="dropdown-menu nav_small" role="menu"><li><a href="http://s66.demo.s-cms.cn/html/news/list-2.html">行业动态</a></li><li><a href="http://s66.demo.s-cms.cn/html/news/list-1.html">公司新闻</a></li><li><a href="http://s66.demo.s-cms.cn/html/news/list-7.html">专业常识</a></li></ul></li><li class="dropdown"> <a href="http://s66.demo.s-cms.cn/html/form/9.html">万能表单</a> <a href="http://s66.demo.s-cms.cn/html/form/9.html" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a><ul class="dropdown-menu nav_small" role="menu" style="display: none;"><li><a href="http://s66.demo.s-cms.cn/html/form/7.html">服务预约</a></li><li><a href="http://s66.demo.s-cms.cn/html/form/8.html">KTV预定</a></li><li><a href="http://s66.demo.s-cms.cn/html/form/9.html">简历提交</a></li></ul></li><li class="dropdown"> <a href="http://s66.demo.s-cms.cn/html/contact/">联系我们</a> <a href="http://s66.demo.s-cms.cn/html/contact/" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a><ul class="dropdown-menu nav_small" role="menu" style="display: none;"><li><a href="http://s66.demo.s-cms.cn/html/contact/">联系方式</a></li><li><a href="http://s66.demo.s-cms.cn/html/guestbook/">在线留言</a></li></ul></li></ul>
      </div>
       
    </div>
  </nav>

<div class="flash">
    <ul class="bxslider"><li><a href="#"><img src="/images/20161108163633172.jpg" /></a></li><li><a href="#"><img src="/images/20161108163616914.jpg" /></a></li></ul>
</div>
<script type="text/javascript">
$('.bxslider').bxSlider({
	adaptiveHeight: true,
	infiniteLoop: true,
	hideControlOnEnd: true,
	auto:true
});
</script>
</header>
 


<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-md-9" style="float:right">
      <div class="list_box">
        <h1 class="left_h1"><?php echo $catinfo['typename']; ?></h1>
        <ul class="list_news">
<?php foreach($posts as $row){ ?>
<li><a href="/cat<?php echo $row['typeid']; ?>/id<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a><span class="news_time"><?php echo date('Y-m-d',$row['pubdate']); ?></span></li>
<?php } ?>
        </ul><div class="cl"></div>
        <div class="pages"><ul><?php echo get_listnav(array("urltype"=>"cat","catid"=>$cat,"pagenow"=>$page,"counts"=>$counts,"pagesize"=>$pagesize)); ?></ul><div class="cl"></div></div>
      </div>
    </div>
    
     
    <div class="col-xs-12 col-sm-4 col-md-3">
      <div class="left_nav" id="categories">
        <h3 class="left_h1">栏目导航</h3>
        <ul class="left_nav_ul" id="firstpane">
		<li> <a class="biglink" href="http://s66.demo.s-cms.cn/html/news/list-2.html">行业动态</a>            <ul class="left_snav_ul menu_body">            </ul>          </li><li> <a class="biglink" href="http://s66.demo.s-cms.cn/html/news/list-1.html">公司新闻</a>            <ul class="left_snav_ul menu_body">            </ul>          </li><li> <a class="biglink" href="http://s66.demo.s-cms.cn/html/news/list-7.html">专业常识</a>            <ul class="left_snav_ul menu_body">            </ul>          </li>
        </ul>
      </div>
      <div class="left_news">
        <h3 class="left_h1">新闻中心</h3>
        <ul class="index_news">
<?php foreach($posts as $row){ ?>
<li><a href="/cat<?php echo $row['typeid']; ?>/id<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a><span class="news_time"><?php echo date('Y-m-d',$row['pubdate']); ?></span></li>
<?php } ?>
        </ul>
        </div>
      <div class="index_contact">
        <h3 class="about_h1">联系我们</h3>
        <span class="about_span">CONTACT US</span>  
		<p style="padding-top:20px;">地址：上海市xx区xx路xx广场x号<br>
电话：86-021-xxxxxxxx<br>
传真：86-021-xxxxxxxxxxxxxxxx<br>
邮箱：xxxxxxxxx@qq.com<br>
网址：www.xxxxxx.com<br></p>
		</div>
    </div>
 </div>
</div>

<nav class="navbar navbar-default navbar-fixed-bottom footer_nav">
  <div class="foot_nav btn-group dropup"> <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="http://s66.demo.s-cms.cn/html/news/list-7.html#"> <span class="glyphicon glyphicon-share btn-lg" aria-hidden="true"></span> 分享</a>
    <div class="dropdown-menu webshare">
      <div class="bdsharebuttonbox bdshare-button-style0-16" style="display: inline-block" data-bd-bind="1483004650129"><a href="http://s66.demo.s-cms.cn/html/news/list-7.html#" class="bds_more" data-cmd="more"></a><a href="http://s66.demo.s-cms.cn/html/news/list-7.html#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="http://s66.demo.s-cms.cn/html/news/list-7.html#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="http://s66.demo.s-cms.cn/html/news/list-7.html#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="http://s66.demo.s-cms.cn/html/news/list-7.html#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="http://s66.demo.s-cms.cn/html/news/list-7.html#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
    </div>
  </div>
  <div class="foot_nav"><a href="tel:"><span class="glyphicon glyphicon-phone btn-lg" aria-hidden="true"></span>手机</a></div>
  <div class="foot_nav"><a id="gotocate" href="http://s66.demo.s-cms.cn/html/news/list-7.html#"><span class="glyphicon glyphicon-th-list btn-lg" aria-hidden="true"></span>分类</a></div>
  <div class="foot_nav"><a id="gototop" href="http://s66.demo.s-cms.cn/html/news/list-7.html#"><span class="glyphicon glyphicon-circle-arrow-up btn-lg" aria-hidden="true"></span>顶部</a></div>
</nav>
<footer>
  <div class="copyright">
    <p>COPYRIGHT © 2009-2011,WWW.YOURNAME.COM,ALL RIGHTS RESERVED版权所有 © 您的公司名称</p>
    <p class="copyright_p"><script language="javascript" type="text/javascript" src="images/18651498.js.下载"></script><a href="http://www.51.la/?18651498" target="_blank" title="51.La 网站流量统计系统"><img alt="51.La 网站流量统计系统" src="images/icon_0.gif" style="border:none"></a>

<noscript>&lt;a href="http://www.51.la/?18651498" target="_blank"&gt;&lt;img alt="我要啦免费统计" src="http://img.users.51.la/18651498.asp" style="border:none" /&gt;&lt;/a&gt;</noscript></p>
  </div>
</footer>


<link rel="stylesheet" type="text/css" href="images/online.css">

<script type="text/javascript" src="images/online.js.下载"></script> 
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>




</body></html>