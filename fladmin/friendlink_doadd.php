<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

$db =  new db();
if($_REQUEST['webname']!="" && $_REQUEST['url']!="" && $db->insert("friendlink", $_REQUEST)) //成功返回mysql_insert_id,最新插入的id
{
    redirect("friendlink_list.php",1,"添加成功");
}
else
{
    redirect("friendlink_list.php",3,"添加失败");
}
?>