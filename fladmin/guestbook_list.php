<?php
header("Content-type: text/html; charset=utf-8");
require '../common/config.php';$db = new db();
$where['where'] = array();

$page = 1;$pagesize = 15;
if(isset($_REQUEST["page"]) && $_REQUEST["page"]>1)
{
    $page = $_REQUEST["page"];
}
if(isset($_REQUEST["keyword"]))
{
    $where['like'] = " title like '%".$_REQUEST['keyword']."%'";
}

$counts = $db->count("guestbook",$where); //计算符合跳转的文章数量
$posts = pageList('guestbook',$where,'id desc',$page,$pagesize);

if(isset($_REQUEST["delid"]))
{
    $db =  new db();
    $where2['where'] = "id=".$_REQUEST["delid"];
    if($db->delete("guestbook", $where2))
    {
        success("guestbook_list.php", 1, "删除成功");
    }
    else
    {
        error("guestbook_list.php", 3, "删除失败！请重新提交");
    }
}
?>
<!DOCTYPE html><html><head><title>留言列表_<?php echo CMS_WEBNAME; ?>后台管理</title><?php include 'header.php'; ?>
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar"><?php include 'leftmenu.php'; ?></div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">

<form id="searcharc" class="navbar-form" action="guestbook_list.php" method="get">
<div class="form-group"><input type="text" name="keyword" id="keyword" class="form-control required" placeholder="搜索关键词..."></div>
<button type="submit" class="btn btn-info" value="Submit">搜索一下</button></form>

<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
	<tr>
	  <th>ID</th>
	  <th width=25%>标题</th>
	  <th>留言时间</th>
	  <th width=45%>内容</th><th>操作</th>
	</tr>
  </thead>
  <tbody>
  <?php if(!empty($posts)){foreach($posts as $row){ ?>
	<tr>
	  <td><?php echo $row["id"]; ?></td>
	  <td><?php echo $row["title"]; ?></td>
	  <td><?php echo date('Y-m-d H:i:s',$row["addtime"]); ?></td>
	  <td><?php echo $row["msg"]; ?></td><td>&nbsp;<a onclick="confirmbox('guestbook_list.php?delid=<?php echo $row["id"]; ?>','确定删除吗')" href="javascript:;">删除</a></td>
	</tr>
  <?php }} ?>
  </tbody>
</table>
</div><!-- 表格结束 -->

<div class="pages"><ul><?php echo dynamiclistnav(array("url"=>$_SERVER['REQUEST_URI'],"pagenow"=>$page,"counts"=>$counts,"pagesize"=>$pagesize)); ?></ul><div class="cl"></div></div>

<script>
//推荐文章
function tjArc(aid)
{
	var checkvalue=getItems();
	
	if(checkvalue=='')
	{
		alert('必须选择一个或多个文档！');
		return;
	}
	
	if(confirm("确定要推荐吗"))
	{
		location="recommend.php?tab=article&url=article_list.php&id="+checkvalue;
	}
	else
	{
		
	}
}

//批量删除文章
function delArc(aid)
{
	var checkvalue=getItems();
	
	if(checkvalue=='')
	{
		alert('必须选择一个或多个文档！');
		return;
	}
	
	if(confirm("确定删除吗"))
	{
		location="article_dodel.php?id="+checkvalue;
	}
	else
	{
		
	}
}

$(function(){
	$('.required').on('focus', function() {
		$(this).removeClass('input-error');
	});
	
    $("#searcharc").submit(function(e){
		$(this).find('.required').each(function(){
			if( $(this).val() == "" )
			{
				e.preventDefault();
				$(this).addClass('input-error');
			}
			else
			{
				$(this).removeClass('input-error');
			}
		});
    });
});
</script>

</div></div><!-- 右边结束 --></div></div>
</body></html>