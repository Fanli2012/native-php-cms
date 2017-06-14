<?php
require '../common/config.php';
?>
<!DOCTYPE html><html><head><title>栏目列表_后台管理</title><?php include 'header.php'; ?>
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar"><?php include 'leftmenu.php'; ?></div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">网站栏目管理</h2>[ <a href="cat_add.php?reid=0">增加顶级栏目</a> ] [ <a href="article_add.php">发布文章</a> ]<br><br>

<form name="listarc"><div class="table-responsive">
<table class="table table-striped table-hover">
<thead><tr><th>ID</th><th>名称</th><th>文章数</th><th>别名</th><th>更新时间</th><th>操作</th></tr></thead>
<tbody id="cat-list">
<?php $catlist = tree(get_category('arctype',0));if(!empty($catlist)){foreach($catlist as $row){ ?>
<tr id="cat-<?php echo $row["id"]; ?>">
<td><?php echo $row["id"]; ?></td>
<td><a href="article_list.php?id=<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "— ";}echo $row["typename"]; ?></a></td><td><?php echo catarcnum($row["id"],'Article'); ?></td><td><?php echo $row["typedir"]; ?></td><td><?php echo date('Y-m-d',$row["addtime"]); ?></td>
<td><a href="/cat<?php echo $row["id"]; ?>" target="_blank">预览</a> | <a href="article_add.php?catid=<?php echo $row["id"]; ?>">发布文章</a> | <a href="cat_add.php?reid=<?php echo $row["id"]; ?>">增加子类</a> | <a href="cat_edit.php?id=<?php echo $row["id"]; ?>">更改</a> | <a onclick="confirmbox('cat_dodel.php?id=<?php echo $row["id"]; ?>','确认要删除吗？')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->
</div></div><!-- 右边结束 --></div></div>
</body></html>