<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

//参数名称
if(!empty($_REQUEST["varname"]))
{
    preg_match("/^CMS_[a-z]+$/i", $_REQUEST["varname"]) ? "" : $_REQUEST['varname']="";
}
else
{
    $_REQUEST['varname']="";
}

$db =  new db();
if($_REQUEST['varname']!="" && $db->insert("sysconfig", $_REQUEST)) //成功返回mysql_insert_id,最新插入的id
{
    redirect("upconfig.php",1,"添加成功");
}
else
{
    redirect("sysconfig_list.php",3,"添加失败");
}
?>