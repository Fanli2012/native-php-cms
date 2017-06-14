<?php
require '../common/config.php';
$posts = pageList('slide','','is_show asc,rank desc');
?>
<!DOCTYPE html><html><head><title>轮播图列表_后台管理</title><?php include 'header.php'; ?>
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar"><?php include 'leftmenu.php'; ?></div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">轮播图管理</h2>[ <a href="slide_add.php">添加轮播图</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr>
<th>图片</th>
<th>标题</th>
<th>链接网址</th>
<th>排序</th>
<th>是否显示</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if(!empty($posts)){foreach($posts as $row){ ?><tr>
<td><img style="<?php if(empty($row["pic"]) || !imgmatch($row["pic"])){ echo "display:none;"; } ?>" src="<?php if(imgmatch($row["pic"])){echo $row["pic"];} ?>" width="90" height="60"></td>
<td><?php echo $row["title"]; ?></td>
<td><?php echo $row["url"]; ?></td>
<td><?php echo $row["rank"]; ?></td>
<td><?php if($row["is_show"]==0){echo "是";}else{echo "<font color=red>否</font>";} ?></td>
<td><a href="slide_edit.php?id=<?php echo $row["id"]; ?>">修改</a> | <a onclick="confirmbox('slide_dodel.php?id=<?php echo $row["id"]; ?>','确定要删除吗')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

</div></div><!-- 右边结束 --></div></div>
</body></html>