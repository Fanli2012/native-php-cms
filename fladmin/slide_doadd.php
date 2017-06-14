<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';
unset($_REQUEST['editorValue']);

$db =  new db();
if($_REQUEST['title']!="" && $_REQUEST['url']!="" && $db->insert("slide", $_REQUEST)) //成功返回mysql_insert_id,最新插入的id
{
    redirect("slide_list.php",1,"添加成功");
}
else
{
    redirect("slide_list.php",3,"添加失败");
}
?>