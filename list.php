<?php
require 'common/config.php';
$db = new db();
if(!empty($_GET["cat"])){$cat = $_GET["cat"];}else{exit;}
if(isset($_GET["page"])){$page = $_GET["page"];}else{$page = 1;}
$where['where']="id=$cat";
$post = $db->find("arctype",$where);
$pagesize=15;
$where2['where']="typeid=$cat and ischeck=0";
$where2['order']="id desc";
$counts = $db->count("article",$where2);
$where2['limit']=$pagesize*($page-1).",".$pagesize;
$posts = $db->select("article",$where2);
?>
<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php if(empty($post["seotitle"])){echo $post["typename"];}else{echo $post["seotitle"];} ?></title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/style.css"><script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script></head><body>

<?php include("header.php"); ?>
<div class="container">
<div class="row row-offcanvas row-offcanvas-right">
<div class="col-xs-12 col-sm-9">
<div class="bread"><a href="/"><?php echo CMS_INDEXNAME; ?></a> > <?php echo get_cat_path($post["id"]); ?></div>
<h1 class="page-header"><?php echo $post["typename"]; ?></h1>

<?php foreach($posts as $row){ ?><div class="list"><?php if(!empty($row['litpic'])){echo '<a class="limg" href="'.url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')).'"><img alt="'.$row["title"].'" src="'.$row["litpic"].'"></a>';} ?>
<strong class="tit"><a href="<?php echo url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>" target="_blank"><?php echo $row['title']; ?></a></strong><p><?php echo mb_strcut($row['description'],0,160,'utf-8'); ?></p>
<div class="info"><span class="fl"><?php $taglist=$db->select("taglist",['where'=>['aid'=>$row['id']]]);if($taglist){foreach($taglist as $v){$tag=$db->find("tagindex",['where'=>['id'=>$v['tid']]]); ?><a target="_blank" href="<?php echo url(array("tagid"=>$tag['id'],"type"=>'tags')); ?>"><?php echo $tag['tag']; ?></a><?php }} ?><em><?php echo date("Y-m-d",$row["pubdate"]); ?></em></span><span class="fr"><em><?php echo $row['click']; ?></em>人阅读</span></div><div class="cl"></div></div><?php } ?>

<div class="pages"><ul><?php echo get_listnav(array("urltype"=>"cat","catid"=>$cat,"pagenow"=>$page,"counts"=>$counts,"pagesize"=>$pagesize)); ?></ul><div class="cl"></div></div>

</div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-12 col-sm-3 sidebar-offcanvas" id="sidebar">
		
		<div class="panel panel-info">
  <div class="panel-heading">热门推荐</div>
  <div class="list-group"><?php $posts = $db->select("article",['limit'=>5,'order'=>'rand()','where'=>['typeid'=>$post["id"]]]);foreach($posts as $row){ ?>
  <a class="list-group-item" href="<?php echo url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a><?php } ?>
  </div>
</div>
</div><!--/.sidebar-offcanvas--></div><!--/row-->

</div><!-- /.container -->
<?php include("footer.php"); ?></body></html>