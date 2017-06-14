<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<?php
session_start();
if(!isset($_SESSION['admin_user_info']))
{
    redirect("/",3,"您访问的页面不存在或已被删除！");
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/admin.css">
<script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script><script src="/js/ad.js"></script></head><body>

<div class="blog-masthead clearfix"><nav class="blog-nav">
<a class="blog-nav-item active" href="<?php echo CMS_ADMIN; ?>"><span class="glyphicon glyphicon-star"></span> <strong>后台管理中心</strong> <span class="glyphicon glyphicon-star-empty"></span></a>
<a class="blog-nav-item" href="/" target="_blank"><span class="glyphicon glyphicon-home"></span> 网站主页</a>
<a class="blog-nav-item" href="<?php echo CMS_ADMIN; ?>Index/upcache"><span class="glyphicon glyphicon-refresh"></span> 更新缓存</a>
<a class="blog-nav-item" id="navexit" href="<?php echo CMS_ADMIN; ?>loginout.php"><span class="glyphicon glyphicon-off"></span> 注销</a>
<a class="blog-nav-item pull-right" href="javascript:;"><small>您好：<span class="glyphicon glyphicon-user"></span> <?php if(isset($_SESSION['admin_user_info'])){echo $_SESSION['admin_user_info']['username'].' ['.$_SESSION['admin_user_info']['rolename'].']';} ?></small></a>
</nav></div>