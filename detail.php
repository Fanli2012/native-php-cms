<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<?php
require 'common/config.php';
$db = new db();
if(!empty($_GET["id"])){$id = $_GET["id"];}else {$id="";}if(preg_match('/[0-9]*/',$id)){}else{exit;}
$where['where']="id=$id";
$post = $db->find("article",$where);
$cat = $post["typeid"];
$where['where']="id=$cat";
$catinfo = $db->find("arctype",$where);
$where['where']="typeid=$cat";
$where['order']="rand()";
$where['limit']=5;
$posts = $db->select("article",$where);
?>
<title><?php if(!empty($post["seotitle"])){ echo $post["seotitle"]; }else{ echo $post["title"]; } ?>-您的网站名称</title>
<meta name="description" content="<?php echo $post["description"]; ?>">
<meta name="keywords" content="<?php echo $post["keywords"]; ?>">
<link href="<?php echo CMS_WEBSITE; ?>/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo CMS_WEBSITE; ?>/css/bxslider.css" rel="stylesheet">
<link href="<?php echo CMS_WEBSITE; ?>/css/style.css" rel="stylesheet">
<script src="<?php echo CMS_WEBSITE; ?>/js/jquery.min.js"></script>
<script src="<?php echo CMS_WEBSITE; ?>/js/bxslider.min.js"></script>
<script src="<?php echo CMS_WEBSITE; ?>/js/common.js"></script>
<script src="<?php echo CMS_WEBSITE; ?>/js/bootstrap.js"></script><link rel="stylesheet" href="<?php echo CMS_WEBSITE; ?>/css/share_style0_16.css"></head><body>
<script type="text/javascript">try {var urlhash = window.location.hash;if (!urlhash.match("fromapp")){if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i))){window.location="wap_index.asp";}}}catch(err){}</script>
<link href="<?php echo CMS_WEBSITE; ?>/css/lanrenzhijia.css" rel="stylesheet" type="text/css">
<script src="<?php echo CMS_WEBSITE; ?>/js/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<div id="online_qq_layer" style="z-index:1000;"><div id="online_qq_tab"><div class="online_icon"><a title="" id="floatShow" style="display:none" href="javascript:void(0);">&nbsp;</a><a title="" id="floatHide" style="display:block" href="javascript:void(0);">&nbsp;</a></div></div><div id="onlineService" style="display: block;"><div class="online_windows overz"><div class="online_w_top"></div><div class="online_w_c overz"><div class="online_bar expand" id="onlineSort1"><h2><a onclick="changeOnline(1)">在线客服</a></h2><div class="online_content overz" id="onlineType1" style="display: block;"><ul class="overz"><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=12345678&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">售前咨询</a></li><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=987654321&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">售后服务</a></li><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=11223344&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">加盟代理</a></li><li><a title="点击这里给我发消息" href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=taobao&amp;siteid=cntaobao&amp;status=1&amp;charset=utf-8" target="_blank" class="ww_icon">淘宝客服</a></li></ul></div></div><div class="online_bar collapse2" id="onlineSort2"><h2><a onclick="changeOnline(2)">电话客服</a></h2><div class="online_content overz" id="onlineType2" style="display: none;"><ul class="overz"><li>010-10086</li><li>010-10010</li></ul></div></div><div class="online_bar collapse2" id="onlineSort3"><h2><a onclick="changeOnline(3)">网站二维码</a></h2><div class="online_content overz" id="onlineType3" style="display: none;"><ul class="overz"><img src="/images/index.png" width="120"></ul></div></div><div class="online_bar collapse2" id="onlineSort4"><h2><a onclick="changeOnline(4)">微信公众号</a></h2><div class="online_content overz" id="onlineType4" style="display: none;"><ul class="overz"><img src="/images/20150921144410012.jpg" width="120"></ul></div></div></div><div class="online_w_bottom"></div></div></div></div>
<div class="toolbar"><a href="http://s66.demo.s-cms.cn/member" class="toolbar-item toolbar-item-feedback"></a><a href="javascript:scroll(0,0)" class="toolbar-item toolbar-item-top"></a></div>
<link href="<?php echo CMS_WEBSITE; ?>/css/language-selector.css" rel="stylesheet" type="text/css">
<div id="lang_sel" style="right:20px;POSITION: fixed;top:20px;z-index:10000; ">
<ul><li class="icl-zh-hans"><a href="/" class="lang_sel_sel"><img class="iclflag" src="/images/0.png" alt="China" title="简体中文"> 简体中文</a><ul><li class="icl-en"><a href="http://s66.demo.s-cms.cn/indexe.html"><img class="iclflag" src="/images/1.png" alt="en" title="English">    English</a></li></ul></li></ul><script src="/images/lang-select.asp"></script>
</div>
<header>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-9 col-md-9"> <a href="/"><img src="<?php echo CMS_WEBSITE; ?>/images/20160820232652166.png" class="logo" alt=""></a> </div>
      <div id="topsearch" class="col-xs-12 col-sm-3 col-md-3">
        <form id="searchform" name="formsearch" action="" method="post">
        
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
        <span id="small_search" class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="glyphicon glyphicon-home home-btn" style="cursor: pointer"></span> <a class="navbar-brand" href="<?php echo CMS_WEBSITE; ?>/">导航菜单</a> </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav"><li class="dropdown"> <a href="<?php echo CMS_WEBSITE; ?>/">网站首页</a></li>
		<li class="dropdown"> <a href="<?php echo url(['type'=>'productlist','catid'=>1]); ?>">产品展示</a></li>
		<li class="dropdown"> <a href="<?php echo url(['type'=>'list','catid'=>2]); ?>">案例中心</a></li>
		<li class="dropdown"> <a href="<?php echo url(['type'=>'list','catid'=>1]); ?>">新闻中心</a></li>
		<li class="dropdown"> <a href="<?php echo url(['type'=>'page','pagename'=>'contact']); ?>">联系我们</a></li></ul>
      </div>
       
    </div>
  </nav>
<div class="flash">
    <ul class="bxslider"><li><a href="#"><img src="<?php echo CMS_WEBSITE; ?>/images/20161108163633172.jpg" /></a></li><li><a href="#"><img src="<?php echo CMS_WEBSITE; ?>/images/20161108163616914.jpg" /></a></li></ul>
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
        <h2 class="left_h1"><?php echo $catinfo["typename"]; ?></h2>
        <div class="contents">
		<h1 class="contents_title"><?php echo $post["title"]; ?></h1>
        <?php echo $post["body"]; ?>
        </div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-4 col-md-3">
      <div class="left_nav" id="categories">
        <h3 class="left_h1">栏目导航</h3>
        <ul class="left_nav_ul" id="firstpane">
		<li><a class="biglink" href="/html/about/1.html">公司简介</a><ul class="left_snav_ul menu_body"></ul></li>
		<li><a class="biglink" href="/html/about/2.html">公司文化</a><ul class="left_snav_ul menu_body"></ul></li>
        </ul>
      </div>
      <div class="left_news">
        <h3 class="left_h1">新闻中心</h3>
        <ul class="index_news">
<?php foreach($posts as $row){ ?>
<li><a href="<?php echo url(['type'=>'content','id'=>$row['id']]); ?>"><?php echo $row['title']; ?></a><span class="news_time"><?php echo date('Y-m-d',$row['pubdate']); ?></span></li>
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
  <div class="foot_nav btn-group dropup"> <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="http://s66.demo.s-cms.cn/html/about/2.html#"> <span class="glyphicon glyphicon-share btn-lg" aria-hidden="true"></span> 分享</a>
    <div class="dropdown-menu webshare">
      <div class="bdsharebuttonbox bdshare-button-style0-16" style="display: inline-block" data-bd-bind="1482978575641"><a href="http://s66.demo.s-cms.cn/html/about/2.html#" class="bds_more" data-cmd="more"></a><a href="http://s66.demo.s-cms.cn/html/about/2.html#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="http://s66.demo.s-cms.cn/html/about/2.html#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="http://s66.demo.s-cms.cn/html/about/2.html#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="http://s66.demo.s-cms.cn/html/about/2.html#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="http://s66.demo.s-cms.cn/html/about/2.html#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
    </div>
  </div>
  <div class="foot_nav"><a href="tel:"><span class="glyphicon glyphicon-phone btn-lg" aria-hidden="true"></span>手机</a></div>
  <div class="foot_nav"><a id="gotocate" href="http://s66.demo.s-cms.cn/html/about/2.html#"><span class="glyphicon glyphicon-th-list btn-lg" aria-hidden="true"></span>分类</a></div>
  <div class="foot_nav"><a id="gototop" href="http://s66.demo.s-cms.cn/html/about/2.html#"><span class="glyphicon glyphicon-circle-arrow-up btn-lg" aria-hidden="true"></span>顶部</a></div>
</nav>

<footer>
  <div class="copyright">
    <p>COPYRIGHT © 2009-2011,WWW.YOURNAME.COM,ALL RIGHTS RESERVED版权所有 © 您的公司名称</p>
    <p class="copyright_p"><a href="" target="_blank" title="51.La 网站流量统计系统">站长统计</a></p>
  </div>
</footer>

<link rel="stylesheet" type="text/css" href="/images/online.css">
<script type="text/javascript" src="/images/online.js"></script> 
</body></html>