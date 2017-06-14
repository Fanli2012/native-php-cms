<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

$db = new db();
$id = $_REQUEST['id'];
if(preg_match('/[0-9]*/',$id)){}else{exit;}

$where['where'] = "reid=".$id;
if($db->find("product_type",$where))
{
    redirect("producttype_list.php",3,"删除失败！请先删除子栏目");
}
else
{
    $where2['where'] = "id=".$id;
    if($db->delete("product_type", $where2))
    {
        $where3['where'] = "typeid=".$id;
        if($db->count("product", $where3)>0) //判断该分类下是否有商品，如果有把该分类下的商品也一起删除
        {
            if($db->delete("product", $where3))
            {
                redirect("producttype_list.php", 1, "删除成功");
            }
            else
            {
                redirect("producttype_list.php", 3, "栏目下的商品删除失败！");
            }
        }
        else
        {
            redirect("producttype_list.php", 1, "删除成功");
        }
    }
    else
    {
        redirect("producttype_list.php", 3, "删除失败！请重新提交");
    }
}
?>