<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];}else{redirect("article_list.php",3,"删除失败！请重新提交");}
$db =  new db();
$where['where'] = "id in ($id)";
if($db->delete("article", $where))
{
    redirect("article_list.php", 1, "$id ,删除成功");
}
else
{
    redirect("article_list.php", 3, "$id ,删除失败！请重新提交");
}
?>