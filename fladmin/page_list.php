<?php
require '../common/config.php';
$posts = pageList('page','','id desc');
?>
<!DOCTYPE html><html><head><title>单页面列表_后台管理</title><?php include 'header.php'; ?>
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar"><?php include 'leftmenu.php'; ?></div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">单页文档管理</h2>[ <a href="page_add.php">增加一个页面</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead>
<tr>
  <th>编号</th>
  <th>页面名称</th>
  <th>别名</th>
  <th>更新时间</th>
  <th>管理</th>
</tr>
</thead>
<tbody>
<?php if(!empty($posts)){foreach($posts as $row){ ?>
<tr>
  <td><?php echo $row["id"]; ?></td>
  <td><a href="page_edit.php?id=<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></a></td>
  <td><?php echo $row["filename"]; ?></td>
  <td><?php echo date('Y-m-d',$row["pubdate"]); ?></td>
  <td><a target="_blank" href="<?php echo url(array("type"=>"page","pagename"=>$row["filename"])); ?>">预览</a>&nbsp;<a href="page_edit.php?id=<?php echo $row["id"]; ?>">修改</a>&nbsp;<a onclick="confirmbox('page_dodel.php?id=<?php echo $row["id"]; ?>','确定要删除吗')" href="javascript:;">删除</a></td>
</tr>
<?php }} ?>
</tbody>
</table></div><!-- 表格结束 --></form><!-- 表单结束 -->

</div></div><!-- 右边结束 --></div></div>
</body></html>