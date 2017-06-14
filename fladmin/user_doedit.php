<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';$db =  new db();
$id=1;
/* if(isset($_REQUEST["id"]) && !empty($_REQUEST["id"])){$id = $_REQUEST["id"];unset($_REQUEST["id"]);}else{$id="";exit;} */
$where['where']="id=$id";

if(isset($_REQUEST["username"]) && !empty($_REQUEST["username"])){$data['username'] = $map['where']['username'] = $_REQUEST["username"];}else{error("user_index.php", 3 , "用户名不能为空");exit;}//用户名
if(isset($_REQUEST["oldpwd"]) && !empty($_REQUEST["oldpwd"])){$map['where']['pwd'] = md5($_REQUEST["oldpwd"]);}else{error("user_index.php", 3 , "旧密码错误");exit;}
if($_REQUEST["newpwd"]==$_REQUEST["newpwd2"]){$data['pwd'] = md5($_REQUEST["newpwd"]);}else{error("user_index.php", 3 , "密码错误");exit;}
if($_REQUEST["oldpwd"]==$_REQUEST["newpwd"]){error("user_index.php", 3 , "新旧密码不能一致！");exit;}

$user = $db->find("user",$map);

if(!empty($user))
{
	if($db->update("user", $data, $where)){session_start();session_unset();session_destroy();success("login.php",1,"修改成功，请重新登录");}
}
else
{
	error("user_index.php", 3 , "修改失败！旧用户名或密码错误");
}
?>