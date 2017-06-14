<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';

$str_tmp="<?php\r\n"; //得到php的起始符。$str_tmp将累加
$str_end="?>"; //php结束符
$str_tmp.="//全站配置文件\r\n";

$param = pageList('sysconfig','','id desc');
foreach($param as $row)
{
    $str_tmp.='define("'.$row['varname'].'","'.$row['value'].'"); // '.$row['info']."\r\n";
}

$str_tmp.=$str_end; //加入结束符
//保存文件
$sf="../common/common.inc.php"; //文件名
$fp=fopen($sf,"w"); //写方式打开文件
fwrite($fp,$str_tmp); //存入内容
fclose($fp); //关闭文件

redirect(CMS_ADMIN,1,"缓存更新成功！");
?>