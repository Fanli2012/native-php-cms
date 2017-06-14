<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

$db = new db();
$id = $_REQUEST['id'];
if(preg_match('/[0-9]*/',$id)){}else{exit;}

$where['where'] = "reid=".$id;
if($db->find("arctype",$where))
{
    redirect("cat_list.php",3,"删除失败！请先删除子栏目");
}
else
{
    $where2['where'] = "id=".$id;
    if($db->delete("arctype", $where2))
    {
        $where3['where'] = "typeid=".$id;
        if($db->count("article", $where3)>0) //判断该分类下是否有文章，如果有把该分类下的文章也一起删除
        {
            if($db->delete("article", $where3))
            {
                redirect("cat_list.php", 1, "删除成功");
            }
            else
            {
                redirect("cat_list.php", 3, "栏目下的文章删除失败！");
            }
        }
        else
        {
            redirect("cat_list.php", 1, "删除成功");
        }
    }
    else
    {
        redirect("cat_list.php", 3, "删除失败！请重新提交");
    }
}
?>