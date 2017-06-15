<?php
require 'common/config.php';
$db = new db();
if(!empty($_GET["id"])){$id = $_GET["id"];}else {$id="";}if(preg_match('/[0-9]*/',$id)){}else{exit;}
$post = $db->find("article",['where'=>['id'=>$id]]);
$cat = $post["typeid"];
$where['where']="id=$cat";
$catinfo = $db->find("arctype",$where);
$where2['where']="typeid=$cat";
$where2['order']="rand()";
$where2['limit']=5;
$posts = $db->select("article",$where2);
$pre = $db->find("article",["where"=>"id<$id and typeid=$cat"]); //上一篇文章
?>
<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $post["title"]; ?>_<?php echo CMS_WEBNAME; ?></title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/style.css"><script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script></head><body>
<?php include("header.php"); ?>
<div class="container"><div class="row row-offcanvas row-offcanvas-right"><div class="col-xs-12 col-sm-9">
<div class="bread"><a href=""><?php echo CMS_INDEXNAME; ?></a> > <?php echo get_cat_path($post["typeid"]); ?></div>
<h1 class="page-header"><?php echo $post["title"]; ?></h1>
<div class="content"><?php echo $post["body"]; ?>
<div class="dinfo"><span class="addtime"><?php echo date("Y-m-d",$post["pubdate"]); ?></span>
<br><br>下一篇：<?php if($pre){ ?><a href="<?php echo url(array("id"=>$pre['id'],"catid"=>$pre["typeid"],"type"=>'content')); ?>"><?php echo $pre["title"]; ?></a><?php }else{echo '没有了';} ?><div class="cl"></div></div>
</div>
</div><!--/.col-xs-12.col-sm-9-->

<div class="col-xs-12 col-sm-3 sidebar-offcanvas" id="sidebar">
		
<div class="panel panel-info">
  <div class="panel-heading">热门推荐</div>

  <div class="list-group"><?php foreach($posts as $row){ ?>
  <a class="list-group-item" href="<?php echo url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a><?php } ?>
  </div>
</div>
</div><!--/.sidebar-offcanvas--></div><!--/row--></div><!-- /.container -->
<?php include("footer.php"); ?></body></html>