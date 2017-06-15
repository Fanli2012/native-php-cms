<?php
require 'common/config.php';
$db = new db();
if(!empty($_GET["id"])){$id = $_GET["id"];}else{header("Location:".CMS_BASEHOST.'/404.html');}
$post = $db->find("page",['where'=>['filename'=>$id]]);
?>
<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php if(empty($post["seotitle"])){echo $post["title"];}else{echo $post["seotitle"];} ?>_<?php echo CMS_WEBNAME; ?></title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/style.css"><script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script></head><body>

<?php include("header.php"); ?>
<div class="container">
<div class="row row-offcanvas row-offcanvas-right">
<div class="col-xs-12 col-sm-9">
<div class="bread"><a href="/">首页</a> > <?php echo $post["title"]; ?></div>

<h1 class="page-header"><?php echo $post["title"]; ?></h1>
<div class="content"><?php echo $post["body"]; ?></div>
</div><!--/.col-xs-12.col-sm-9-->

<div class="col-xs-12 col-sm-3 sidebar-offcanvas" id="sidebar">

<div class="panel panel-info">
<div class="panel-heading">相关推荐</div>

<div class="list-group"><?php $posts = $db->select("page",['order'=>'rand()']);foreach($posts as $row){ ?>
<a class="list-group-item" href="<?php echo url(array("pagename"=>$row['filename'],"type"=>'page')); ?>"><?php echo $row['title']; ?></a><?php } ?>
</div>

</div>
</div><!--/.sidebar-offcanvas-->
</div><!--/row-->

</div><!-- /.container -->
<?php include("footer.php"); ?></body></html>