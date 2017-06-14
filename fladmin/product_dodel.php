<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];}else{redirect("product_list.php",3,"删除失败！请重新提交");}
$db =  new db();
$where['where'] = "id in ($id)";
if($db->delete("product", $where))
{
    redirect("product_list.php", 1, "$id ,删除成功");
}
else
{
    redirect("product_list.php", 3, "$id ,删除失败！请重新提交");
}
?>