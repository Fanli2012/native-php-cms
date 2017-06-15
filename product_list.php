<?php
require 'common/config.php';
$db = new db();
if(isset($_GET["cat"])){$cat = $_GET["cat"];}else{exit;}
if(isset($_GET["page"])){$page = $_GET["page"];}else{$page = 1;}
$where['where']="id=$cat";
$post = $db->find("product_type",$where);
$pagesize=16;
$where2['where']="typeid=$cat and status=0";
$where2['order']="id desc";
$counts = $db->count("product",$where2);
$where2['limit']=$pagesize*($page-1).",".$pagesize;
$posts = $db->select("product",$where2);
?>
<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php if(empty($post["seotitle"])){echo $post["typename"];}else{echo $post["seotitle"];} ?></title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/style.css"><script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script><script src="<?php echo CMS_BASEHOST; ?>/js/ad.js"></script></head><body>

<?php include("header.php"); ?>
<div class="container"><div class="row">
<div class="bread"><a href="<?php echo CMS_BASEHOST; ?>"><?php echo CMS_INDEXNAME; ?></a> > <?php echo $post["typename"]; ?></div>
<?php if($posts){foreach($posts as $row){ ?>
<div class="col-xs-6 col-sm-3" style="margin-top:20px;margin-bottom:10px;">
<a href="<?php echo url(array("id"=>$row['id'],"type"=>'productdetail')); ?>" target="_blank">
<img src="<?php echo $row['litpic']; ?>" alt="<?php echo $row['title']; ?>" class="imgzsy">
<p style="padding-top:10px;"><?php echo $row['title']; ?></p>
</a>
</div>
<?php }} ?>
<br class="cl">
<div class="pages"><ul><?php echo get_listnav(array("urltype"=>"product","catid"=>$cat,"pagenow"=>$page,"counts"=>$counts,"pagesize"=>$pagesize)); ?></ul><div class="cl"></div></div>
</div></div><!-- /.container -->
<script>
$(function(){
	$(".imgzsy").height(function(){return $(this).width()*2/3;});
});
</script>
<?php include("footer.php"); ?></body></html>