<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';
session_start();

if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];unset($_REQUEST["id"]);}else{$id="";exit;}
unset($_REQUEST['editorValue']);
$litpic="";if(!empty($_REQUEST["litpic"])){$litpic = $_REQUEST["litpic"];}else{$_REQUEST['litpic']="";} //缩略图
if(empty($_REQUEST["description"])){if(!empty($_REQUEST["body"])){$_REQUEST['description']=cut_str($_REQUEST["body"]);}} //description
$content="";if(!empty($_REQUEST["body"])){$content = $_REQUEST["body"];}
$_REQUEST['pubdate'] = time();//更新时间&添加时间
$_REQUEST['user_id'] = $_SESSION['admin_user_info']['id']; // 发布者id
//关键词
if(!empty($_REQUEST["keywords"]))
{
    $_REQUEST['keywords']=str_replace("，",",",$_REQUEST["keywords"]);
}
else
{
    if(!empty($_REQUEST["title"]))
    {
        $title=$_REQUEST["title"];
        $title=str_replace("，","",$title);
        $title=str_replace(",","",$title);
        $_REQUEST['keywords']=get_keywords($title);//标题分词
    }
}

$_REQUEST['body']=$content;

$db =  new db();
$where['where']="id=$id";
if($db->update("product", array_filter($_REQUEST), $where)) //成功返回mysql_insert_id,最新插入的id
{
    redirect("product_list.php",1,"修改成功");
}
else
{
    redirect("product_list.php",3,"修改失败");
}
?>