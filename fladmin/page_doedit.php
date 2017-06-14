<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];unset($_REQUEST["id"]);}else {$id="";exit;}
$_REQUEST['pubdate'] = time();//更新时间
unset($_REQUEST['editorValue']);

$db =  new db();
$where['where']="id=$id";
if($db->update("page", $_REQUEST, $where)) //成功返回mysql_insert_id,最新插入的id
{
    redirect("page_list.php",1,"修改成功");
}
else
{
    redirect("page_list.php",3,"修改失败");
}
?>