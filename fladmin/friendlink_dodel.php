<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];}else{redirect("friendlink_list.php",3,"删除失败！请重新提交");}if(preg_match('/[0-9]*/',$id)){}else{exit;}

$db =  new db();
$where['where'] = "id=".$id;
if($db->delete("friendlink", $where))
{
    redirect("friendlink_list.php", 1, "删除成功");
}
else
{
    redirect("friendlink_list.php", 3, "删除失败！请重新提交");
}
?>