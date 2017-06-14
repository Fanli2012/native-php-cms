<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

$_REQUEST['addtime'] = time();//添加时间
unset($_REQUEST['editorValue']);

$db =  new db();
if($db->insert("product_type", $_REQUEST)) //成功返回mysql_insert_id,最新插入的id
{
    redirect("producttype_list.php",1,"添加成功");
}
else
{
    redirect("producttype_list.php",3,"添加失败");
}
?>