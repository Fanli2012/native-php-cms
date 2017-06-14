<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1"><script src="js/jquery.min.js"></script><script src="js/ad.js"></script>
<?php
require_once("flDb.php");$db =  new DB();
?>
<title>后台登录</title><link rel="stylesheet" href="css/bootstrap.min.css"><link rel="stylesheet" href="css/style.css"></head><body>
<div class="container-fluid"><form class="form-signin">
<a href="/" title="后台登录" class="center-block text-center" style="margin-top:40px;margin-bottom:20px;"><img src="images/logo.png" alt="" /></a>
<h2 class="text-center">后台·登录</h2>
<label for="inputEmail" class="sr-only">用户名</label>
<input type="text" id="inputEmail" class="form-control" placeholder="用户名" required autofocus>
<label for="inputPassword" class="sr-only">密码</label>
<input type="password" id="inputPassword" class="form-control" placeholder="密码" required>
<div class="foup" style="margin-bottom:10px;">
    <span>验证码</span>
    <input type="text" name="validate" class="" id="" style="width:70px;">
	<img src="ValidateCode.php" id="validatecode" style="vertical-align:top;cursor:pointer;">
	<a href="javascript:;"><small>看不清?</small></a>
</div>
<!-- <div class="checkbox"><label><input type="checkbox" value="remember-me"> Remember me</label></div> -->
<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form></div><!-- /container -->

<script>
$(function(){
	$("#validatecode,.foup a").click(function(){
		$("#validatecode").attr("src",'ValidateCode.php?' + Math.random());
	});
});
</script>
</body></html>
