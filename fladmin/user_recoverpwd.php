<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

$data["username"] = "admin888";
$data["pwd"] = "21232f297a57a5a743894a0e4a801fc3";

$db =  new db();
$where['where']="id=1";
if($db->update("user", $data, $where))
{
    success_jump("密码恢复成功！","login.php");
}
else
{
    error_jump("密码恢复失败！","login.php");
}
?>