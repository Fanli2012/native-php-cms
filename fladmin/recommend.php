<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

if(isset($_REQUEST["id"])){$id = $_REQUEST["id"];}else{exit;}
if(isset($_REQUEST["tab"])){}else{exit;}
if(isset($_REQUEST["url"])){}else{exit;}

$db =  new db();
$where['where'] = "id in ($id)";
$data['tuijian'] = 1;

if($db->update($_REQUEST["tab"], $data, $where))
{
    redirect($_REQUEST["url"], 1, "$id ,推荐成功");
}
else
{
    redirect($_REQUEST["url"], 3, "$id ,推荐失败！请重新提交");
}
?>