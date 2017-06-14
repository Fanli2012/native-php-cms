<?php
require '../common/config.php';
?>
<!DOCTYPE html><html><head><title>用户_后台管理</title><?php include 'header.php'; ?>
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar"><?php include 'leftmenu.php'; ?></div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">用户管理</h2>

<a href="user_edit.php" class="btn btn-success">修改密码</a>

</div></div><!-- 右边结束 --></div></div>
</body></html>