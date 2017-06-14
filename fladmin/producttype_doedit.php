<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

if(!empty($_REQUEST["id"])){ $id = $_REQUEST["id"]; }else{ $id="";exit; }
$_REQUEST['addtime'] = time();//添加时间
unset($_REQUEST["id"]);
unset($_REQUEST['editorValue']);

$db =  new db();
$where['where']=array("id"=>$id);

if($db->update("product_type", $_REQUEST, $where)) //成功返回true
{
    redirect("producttype_list.php",1,"更新成功");
}
else
{
    redirect("producttype_list.php",3,"更新失败");
}
?>