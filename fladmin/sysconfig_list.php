<?php
require '../common/config.php';
$posts = pageList('sysconfig','','id desc');
?>
<!DOCTYPE html><html><head><title>系统配置参数_后台管理</title><?php include 'header.php'; ?>
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar"><?php include 'leftmenu.php'; ?></div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">系统配置参数</h2>[ <a href="sysconfig_add.php">添加参数</a> ] [ <a href="<?php echo CMS_ADMIN; ?>upconfig.php">更新配置缓存</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr>
<th>编号</th>
<th>参数说明</th>
<th>参数值</th>
<th>变量名</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if(!empty($posts)){foreach($posts as $row){ ?><tr>
<td><?php echo $row["id"]; ?></td>
<td><?php echo $row["info"]; ?></td>
<td><?php echo mb_strcut($row["value"],0,80,'utf-8'); ?></td>
<td><?php echo $row["varname"]; ?></td>
<td><a href="sysconfig_edit.php?id=<?php echo $row["id"]; ?>">修改</a> | <a onclick="confirmbox('sysconfig_dodel.php?id=<?php echo $row["id"]; ?>','确定要删除吗')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

</div></div><!-- 右边结束 --></div></div>
</body></html>