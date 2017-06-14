<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

$_REQUEST['pubdate'] = time();//更新时间
$_REQUEST['click'] = rand(200,500);//点击
unset($_REQUEST['editorValue']);

$db =  new db();
if($db->insert("page", $_REQUEST)) //成功返回mysql_insert_id,最新插入的id
{
    redirect("page_list.php",1,"添加成功");
}
else
{
    redirect("page_list.php",3,"添加失败");
}
?>