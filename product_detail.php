<?php
require 'common/config.php';
$db = new db();
if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}if(preg_match('/[0-9]*/',$id)){}else{exit;}
$post = $db->find("product",['where'=>['id'=>$id]]);
$cat = $post["typeid"];
$where['where']="id=$cat";
$catinfo = $db->find("product_type",$where);
//$where2['where']="typeid=$cat";
//$where2['order']="rand()";
//$where2['limit']=5;
//$posts = $db->select("product",$where2);
$pre = $db->find("product",["where"=>"id<$id and typeid=$cat"]); //上一商品
?>
<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $post["title"]; ?>_<?php echo CMS_WEBNAME; ?></title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/style.css"><script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script><script src="<?php echo CMS_BASEHOST; ?>/js/ad.js"></script></head><body>
<?php include("header.php"); ?>
<div class="container"><div class="row row-offcanvas row-offcanvas-right"><div class="col-xs-12 col-sm-9">
<div class="bread"><a href="<?php echo CMS_BASEHOST; ?>"><?php echo CMS_INDEXNAME; ?></a> > <a href="<?php echo url(array("catid"=>$cat,"type"=>'productlist')); ?>"><?php echo $catinfo["typename"]; ?></a></div>
<h1 class="page-header"><?php echo $post["title"]; ?></h1>
<div class="content"><?php echo $post["body"]; ?>
<div class="dinfo"><span class="addtime"><?php echo date("Y-m-d",$post["pubdate"]); ?></span>
<br><br>下一篇：<?php if($pre){ ?><a href="<?php echo url(array("id"=>$pre['id'],"catid"=>$cat,"type"=>'productdetail')); ?>"><?php echo $pre["title"]; ?></a><?php }else{echo '没有了';} ?><div class="cl"></div></div>
</div>
</div><!--/.col-xs-12.col-sm-9-->

<div class="col-xs-12 col-sm-3 sidebar-offcanvas" id="sidebar">
<div class="panel panel-info">
<div class="panel-heading"><strong>商品详情</strong></div>

<ul class="list-group">
<?php if($post["litpic"]){ ?><li class="list-group-item"><img src="<?php echo $post["litpic"]; ?>" width=100% height=auto></li><?php } ?>
<li class="list-group-item"><span class="badge ">￥ <?php echo $post["price"]; ?></span>商品价格</li>
<li class="list-group-item"><span class="badge"><del>￥ <?php echo $post["origin_price"]; ?></del></span>原价</li>
<li class="list-group-item"><span class="badge"><?php echo $post["sales"]; ?></span>销量</li>
</ul>
</div></div><!--/.sidebar-offcanvas--></div><!--/row--></div><!-- /.container -->
<?php include("footer.php"); ?></body></html>