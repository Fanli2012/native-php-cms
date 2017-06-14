<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';
unset($_REQUEST['editorValue']);

if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];unset($_REQUEST["id"]);}else {$id="";exit;}

$db =  new db();
$where['where']="id=$id";
if($db->update("slide", $_REQUEST, $where)) //成功返回mysql_insert_id,最新插入的id
{
    redirect("slide_list.php",1,"修改成功");
}
else
{
    redirect("slide_list.php",3,"修改失败");
}
?>