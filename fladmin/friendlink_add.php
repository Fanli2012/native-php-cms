<?php
require '../common/config.php';
?>
<!DOCTYPE html><html><head><title>添加友情链接_后台管理</title><?php include 'header.php'; ?>
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar"><?php include 'leftmenu.php'; ?></div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h5 class="sub-header"><a href="friendlink_list.php">友情链接列表</a> > 添加友情链接</h5>

<form id="addarc" method="post" action="friendlink_doadd.php" role="form" enctype="multipart/form-data" class="table-responsive">
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td>链接名称：</td>
        <td><input name="webname" type="text" id="webname" value="" class="required" style="width:30%" placeholder="在此输入链接名称"></td>
    </tr>
    <tr>
        <td>链接网址：</td>
        <td><input name="url" type="text" id="url" value="http://" style="width:60%" class="required"> (请用绝对地址)</td>
    </tr>
    <tr>
        <td colspan="2"><button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button>&nbsp;&nbsp;<button type="reset" class="btn btn-default" value="Reset">重置(Reset)</button><input type="hidden"></input></td>
    </tr>
</tbody></table></form><!-- 表单结束 -->
</div></div><!-- 右边结束 --></div></div>

<script>
$(function(){
    $(".required").blur(function(){
        var $parent = $(this).parent();
        $parent.find(".formtips").remove();
        if(this.value=="")
        {
            $parent.append(' <small class="formtips onError"><font color="red">不能为空！</font></small>');
        }
        else
        {
            $parent.append(' <small class="formtips onSuccess"><font color="green">OK</font></small>');
        }
    });

    //重置
    $('#addarc input[type="reset"]').click(function(){
            $(".formtips").remove(); 
    });

    $("#addarc").submit(function(){
        $(".required").trigger('blur');
        var numError = $('#addarc .onError').length;
        
        if(numError){return false;}
    });
});
</script>
</body></html>