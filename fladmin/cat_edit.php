<?php
$id = $_REQUEST["id"];if(preg_match('/[0-9]*/',$id)){}else{exit;}
require '../common/config.php';
$db =  new db();
$where['where'] = "id=$id";
$post = $db->find("arctype",$where);
$reid = $post['reid'];
if($reid!=0){ $postone = $db->find("arctype","id=$reid"); }
?>
<!DOCTYPE html><html><head><title>修改栏目_后台管理</title><?php include 'header.php'; ?>
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar"><?php include 'leftmenu.php'; ?></div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h5 class="sub-header"><a href="cat_list.php">栏目管理</a> > 修改栏目</h5>

<form method="post" action="cat_doedit.php" role="form" id="addcat" class="table-responsive">
<table class="table table-striped table-bordered">
  <tbody>
    <tr>
      <td align="right">栏目名称：</td>
      <td><input name="typename" type="text" value="<?php echo $post["typename"]; ?>" id="typename" size="30" class="required"><input style="display:none;" type="text" name="id" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
    <td align="right">别名：</td>
    <td><input name="typedir" type="text" value="<?php echo $post["typedir"]; ?>" id="typedir" class="required" style="width:30%"> <small>(包含字母或数字，字母开头)</small></td>
    </tr>
    <tr>
      <td align="right">列表模板：</td>
      <td><input name="templist" id="templist" type="text" value="<?php echo $post["templist"]; ?>" class="required" size="20"></td>
    </tr>
    <tr>
      <td align="right">文章模板：</td>
      <td><input name="temparticle" id="temparticle" type="text" value="<?php echo $post["temparticle"]; ?>" class="required" size="20"></td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">缩略图：</td>
        <td style="vertical-align:middle;"><button type="button" onclick="upImage();">选择图片</button> <input name="litpic" type="text" id="litpic" value="<?php echo $post["litpic"]; ?>" style="width:40%"> <img style="margin-left:20px;<?php if(empty($post["litpic"]) || !imgmatch($post["litpic"])){ echo "display:none;"; } ?>" src="<?php if(imgmatch($post["litpic"])){echo $post["litpic"];} ?>" width="120" height="80" id="picview"></td>
    </tr>
<script type="text/javascript">
var _editor;
$(function() {
    //重新实例化一个编辑器，防止在上面的editor编辑器中显示上传的图片或者文件
    _editor = UE.getEditor('ueditorimg');
    _editor.ready(function () {
        //设置编辑器不可用
        _editor.setDisabled('insertimage');
        //隐藏编辑器，因为不会用到这个编辑器实例，所以要隐藏
        _editor.hide();
        //侦听图片上传
        _editor.addListener('beforeInsertImage', function (t, arg) {
            //将地址赋值给相应的input,只取第一张图片的路径
			$('#litpic').val(arg[0].src);
            //图片预览
            $('#picview').attr("src",arg[0].src).css("display","inline-block");
        })
    });
});
//弹出图片上传的对话框
function upImage()
{
    var myImage = _editor.getDialog("insertimage");
	myImage.render();
    myImage.open();
}
</script>
<script type="text/plain" id="ueditorimg"></script>
    <tr>
      <td align="right">SEO标题：</td>
      <td><input name="seotitle" type="text" style="width:70%" id="seotitle" class="alltxt" value="<?php echo $post["seotitle"]; ?>"></td>
    </tr>
    <tr>
      <td align="right">关键字：</td>
      <td><input name="keywords" type="text" style="width:50%" id="keywords" class="alltxt" value="<?php echo $post["keywords"]; ?>"> (用","分开)</td>
    </tr>
    <tr>
      <td align="right">SEO关键字：</td>
      <td><input name="seokeyword" type="text" style="width:50%" id="seokeyword" class="alltxt" value="<?php echo $post["seokeyword"]; ?>"> (用","分开)</td>
    </tr>
    <tr>
      <td align="right" style="vertical-align:middle;">栏目描述：</td>
      <td><textarea name="description" cols="70" style="height:70px;vertical-align:middle;width:70%" rows="3" id="description" class="alltxt"><?php echo $post["description"]; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><strong>栏目内容：</strong></td>
    </tr>
    <tr>
      <td colspan="2">
<!-- 加载编辑器的容器 --><script id="container" name="content" type="text/plain"><?php echo $post["content"]; ?></script>
<!-- 配置文件 --><script type="text/javascript" src="/other/flueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 --><script type="text/javascript" src="/other/flueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 --><script type="text/javascript">var ue = UE.getEditor('container',{maximumWords:100000,initialFrameHeight:320,enableAutoSave:false});</script>
      </td>
    </tr>
    
    <tr>
      <td colspan="2"><input type="submit" class="btn btn-success" value="保存(Submit)">&nbsp;&nbsp;<input type="reset" class="btn btn-default" value="重置(Reset)"></td>
    </tr>
  </tbody>
</table>
</form><!-- 表单结束 -->
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
            if( $(this).is('#typedir') ){
                var reg = /^[a-zA-Z]+[0-9]*[a-zA-Z0-9]*$/;//验证是否为字母、数字
                if(!reg.test($("#typedir").val()))
                {
                    $parent.append(' <small class="formtips onError"><font color="red">格式不正确！</font></small>');
                }
                else
                {
                    $parent.append(' <small class="formtips onSuccess"><font color="green">OK</font></small>');
                }
            }
            else
            {
                $parent.append(' <small class="formtips onSuccess"><font color="green">OK</font></small>');
            }
        }
    });

    //重置
    $('#addcat input[type="reset"]').click(function(){
            $(".formtips").remove(); 
    });
});

$('#addcat input[type="submit"]').click(function(){
    $(".required").trigger('blur');
    var numError = $('#addcat .onError').length;

    if(numError){
        return false;
    }
});
</script>
</body></html>