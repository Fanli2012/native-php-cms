<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];}else{error_jump("删除失败！请重新提交","article_list.php");}
$db =  new db();
$where['where'] = "id in ($id)";
if($db->delete("article", $where))
{
    success_jump("删除成功","article_list.php");
}
else
{
    error_jump("删除失败！请重新提交","article_list.php");
}
?>