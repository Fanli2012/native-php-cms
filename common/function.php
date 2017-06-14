<?php
//获取分页数据及分页导航
function pageList($modelname, $where = '', $orderby = '', $pageindex = 1, $pagesize = 15, $field = '')
{
    $db = new db();
    
    if(!empty($orderby))
    {
        $where['order'] = $orderby;
    }
    
    //取得满足条件的记录总数
    $count = $db->count($modelname, $where);
    
    if($count > 0)
    {
        $where['limit'] = ($pageindex-1)*$pagesize.','.$pagesize;
        
        return $db->select($modelname,$where);
    }
    else
    {
        
    }
}

//pc前台栏目、标签、内容页面地址生成
function url(array $param)
{
    $url='';
    if($param['type'] == 'list')
    {
        //列表页
        $url .= '/cat'.$param['catid'];
    }
    else if($param['type'] == 'content')
    {
        //内容页
        $url .= '/p/'.$param['id'];
    }
    else if($param['type'] == 'tags')
    {
        //tags页面
        $url .= '/tag'.$param['tagid'];
    }
    else if($param['type'] == 'page')
    {
        //单页面
        $url .= '/'.$param['pagename'];
    }
    else if($param['type'] == 'productlist')
    {
        //商品列表页
        $url .= '/product'.$param['catid'];
    }
    else if($param['type'] == 'productdetail')
    {
        //商品内容页
        $url .= '/goods/'.$param['id'];
    }
    
    return $url;
}

//wap前台栏目、标签、内容页面地址生成
function murl(array $param)
{
    if($param['type'] == 'list')
    {
        //列表页
        $url .= '/cat'.$param['catid'].'.html';
    }
    else if($param['type'] == 'content')
    {
        //内容页
        $url .= '/cat'.$param['catid'].'/id'.$param['id'].'.html';
    }
    else if($param['type'] == 'tags')
    {
        //tags页面
        $url .= '/tag'.$param['tagid'].'.html';
    }
    else if($param['type'] == 'page')
    {
        //单页面
        $url .= '/'.$param['pagename'].'.html';
    }
    
    return $url;
}

/**
 * 获取文章列表
 * @param int $tuijian=0 推荐等级
 * @param int $typeid=0 分类
 * @param int $image=1 是否存在图片
 * @param int $row=10 需要返回的数量
 * @param string $orderby='id desc' 排序，默认id降序，随机rand()
 * @param string $limit='0,10' 如果存在$row，$limit就无效
 * @return string
 */
function arclist(array $param)
{
	if(!empty($param['tuijian'])){$map['tuijian']=$param['tuijian'];}
	if(!empty($param['typeid'])){$map['typeid']=$param['typeid'];}
	if(!empty($param['image'])){$map['litpic']=array('NEQ','');}
	if(!empty($param['limit'])){$limit=$param['limit'];}else{if(!empty($param['row'])){$limit="0,".$param['row'];}else{$limit='0,'.cms_pagesize;}}
	if(!empty($param['orderby'])){$orderby=$param['orderby'];}else{$orderby='id desc';}
	
	if(!empty($param['sql']))
	{
		$Artlist = M("Article")->field('body',true)->where($param['sql'])->order($orderby)->limit($limit)->select();
	}
	else
	{
		$Artlist = M("Article")->field('body',true)->where($map)->order($orderby)->limit($limit)->select();
	}
	
	return $Artlist;
}

/**
 * 获取tag标签列表
 * @param int $row=10 需要返回的数量，如果存在$limit,$row就无效
 * @param string $orderby='id desc' 排序，默认id降序，随机rand()
 * @param string $limit='0,10'
 * @return string
 */
function tagslist(array $param)
{
	if(!empty($param['limit'])){$limit=$param['limit'];}else{if(!empty($param['row'])){$limit=$param['row'];}}
	if(!empty($param['orderby'])){$orderby=$param['orderby'];}else{$orderby='id desc';}
	
	$Taglist = M("Tagindex")->field('content',true)->where($map)->order($orderby)->limit($limit)->select();
	
	return $Taglist;
}

/**
 * 获取友情链接
 * @param string $orderby='id desc' 排序，默认id降序，随机rand()
 * @param int||string $limit='0,10'
 * @return string
 */
function flinklist(array $param)
{
	if(!empty($param['row'])){$limit=$param['row'];}else{$limit="";}
	if(!empty($param['orderby'])){$orderby=$param['orderby'];}else{$orderby='id desc';}
	
	$Friendlink = M("Friendlink")->where()->order($orderby)->limit($limit)->select();
	
	return $Friendlink;
}

/**
 * 获取文章上一篇，下一篇id
 * @param $param['aid'] 当前文章id
 * @param $param['typeid'] 当前文章typeid
 * @param string $type 获取类型
 *       pre:上一篇 next:下一篇
 * @return array
 */
function get_article_prenext(array $param)
{
    $sql = $typeid = $res = '';
    $sql='id='.$param["aid"];
    
    if(!empty($param["typeid"]))
    {
        $typeid = $param["typeid"];
    }
    else
    {
        $Article = M("Article")->field('typeid')->where($sql)->find();
        $typeid = $Article["typeid"];
    }
    
    if($param["type"]=='pre')
    {
        $sql='id<'.$param['aid'].' and typeid='.$typeid;
        $res = M("Article")->field('id,typeid,title')->where($sql)->order('id desc')->find();
    }
    else if($param["type"]=='next')
    {
        $sql='id>'.$param['aid'].' and typeid='.$typeid;
        $res = M("Article")->field('id,typeid,title')->where($sql)->order('id asc')->find();
    }
    
    return $res;
}

/**
 * 获取列表分页
 * @param $param['pagenow'] 当前第几页
 * @param $param['counts'] 总条数
 * @param $param['pagesize'] 每页显示数量
 * @param $param['catid'] 栏目id
 * @param $param['offset'] 偏移量
 * @return array
 */
function get_listnav(array $param)
{
	$catid=$param["catid"];
	$pagenow=$param["pagenow"];
	$prepage = $nextpage = '';
    $prepagenum = $pagenow-1;
    $nextpagenum = $pagenow+1;
	
	$counts=$param["counts"];
	$totalpage=get_totalpage(array("counts"=>$counts,"pagesize"=>$param["pagesize"]));
	
	if($totalpage<=1 && $counts>0)
	{
		return "<li><span class=\"pageinfo\">共1页/".$counts."条记录</span></li>";
	}
	if($counts == 0)
	{
		return "<li><span class=\"pageinfo\">共0页/".$counts."条记录</span></li>";
	}
	$maininfo = "<li><span class=\"pageinfo\">共".$totalpage."页".$counts."条</span></li>";
    
	if(!empty($param["urltype"]))
    {
        $urltype = $param["urltype"];
    }
	else
	{
		$urltype = 'cat';
	}
	
	//获得上一页和下一页的链接
	if($pagenow != 1)
	{
		if($pagenow == 2)
		{
			$prepage.="<li><a href='/".$urltype.$catid."'>上一页</a></li>";
		}
		else
		{
			$prepage.="<li><a href='/".$urltype.$catid."/$prepagenum'>上一页</a></li>";
		}
		
		$indexpage="<li><a href='/".$urltype.$catid."'>首页</a></li>";
	}
	else
	{
		$indexpage="<li><a>首页</a></li>";
	}
	if($pagenow!=$totalpage && $totalpage>1)
	{
		$nextpage.="<li><a href='/".$urltype.$catid."/$nextpagenum'>下一页</a></li>";
		$endpage="<li><a href='/".$urltype.$catid."/$totalpage'>末页</a></li>";
	}
	else
	{
		$endpage="<li><a>末页</a></li>";
	}
	
	//获得数字链接
	$listdd="";
	if(!empty($param["offset"])){$offset=$param["offset"];}else{$offset=2;}
	
	$minnum=$pagenow-$offset;
	$maxnum=$pagenow+$offset;
	
	if($minnum<1){$minnum=1;}
	if($maxnum>$totalpage){$maxnum=$totalpage;}
	
	for($minnum;$minnum<=$maxnum;$minnum++)
	{
		if($minnum==$pagenow)
		{
			$listdd.= "<li class=\"thisclass\"><a>$minnum</a></li>";
		}
		else
		{
			if($minnum==1)
			{
				$listdd.="<li><a href='/".$urltype.$catid."'>$minnum</a></li>";
			}
			else
			{
				$listdd.="<li><a href='/".$urltype.$catid."/$minnum'>$minnum</a></li>";
			}
		}
	}
    
    $plist = '';
	$plist .= $indexpage; //首页链接
	$plist .= $prepage; //上一页链接
	$plist .= $listdd; //数字链接
	$plist .= $nextpage; //下一页链接
	$plist .= $endpage; //末页链接
	$plist .= $maininfo;
	
	return $plist;
}

/**
 * 获取动态列表分页
 * @param $param['url'] 当前url
 * @param $param['pagenow'] 当前第几页
 * @param $param['counts'] 总条数
 * @param $param['pagesize'] 每页显示数量
 * @param $param['catid'] 栏目id
 * @param $param['offset'] 偏移量
 * @return array
 */
function dynamiclistnav(array $param)
{
	$url = $param['url'];
	$page_one = "";
	
	if(!preg_match("/page=[0-9]+/i",$url))
	{
		if(strstr($url,"?"))
		{
			$url = $url."&page=1";
		}
		else
		{
			$url = $url."?page=1";
		}
	}
	else
	{
		$page_one = preg_replace("/page=[0-9]+/i","page=1",$url);
	}
	
	$pagenow     = $param["pagenow"];
	$prepage     = $nextpage = '';
    $prepagenum  = $pagenow-1;
    $nextpagenum = $pagenow+1;
	
	$counts=$param["counts"];
	$totalpage=get_totalpage(array("counts"=>$counts,"pagesize"=>$param["pagesize"]));
	
	if($totalpage<=1 && $counts>0)
	{
		return "<li><span class=\"pageinfo\">共1页/".$counts."条记录</span></li>";
	}
	if($counts == 0)
	{
		return "<li><span class=\"pageinfo\">共0页/".$counts."条记录</span></li>";
	}
	$maininfo = "<li><span class=\"pageinfo\">共".$totalpage."页".$counts."条</span></li>";
    
	//获得上一页和下一页的链接
	if($pagenow != 1)
	{
		if($pagenow == 2)
		{
			$prepage.="<li><a href='".str_replace("&page=1","",str_replace("?page=1","",$page_one))."'>上一页</a></li>";
		}
		else
		{
			$prepage.="<li><a href='".preg_replace("/page=[0-9]+/i","page=$prepagenum",$url)."'>上一页</a></li>";
		}
		
		$indexpage="<li><a href='".str_replace("&page=1","",str_replace("?page=1","",$page_one))."'>首页</a></li>";
	}
	else
	{
		$indexpage="<li><a>首页</a></li>";
	}
	
	if($pagenow!=$totalpage && $totalpage>1)
	{
		$nextpage.="<li><a href='".preg_replace("/page=[0-9]+/i","page=$nextpagenum",$url)."'>下一页</a></li>";
		$endpage="<li><a href='".preg_replace("/page=[0-9]+/i","page=$totalpage",$url)."'>末页</a></li>";
	}
	else
	{
		$endpage="<li><a>末页</a></li>";
	}
	
	//获得数字链接
	$listdd="";
	if(!empty($param["offset"])){$offset=$param["offset"];}else{$offset=2;}
	
	$minnum=$pagenow-$offset;
	$maxnum=$pagenow+$offset;
	
	if($minnum<1){$minnum=1;}
	if($maxnum>$totalpage){$maxnum=$totalpage;}
	
	for($minnum;$minnum<=$maxnum;$minnum++)
	{
		if($minnum==$pagenow)
		{
			$listdd.= "<li class=\"thisclass\"><a>$minnum</a></li>";
		}
		else
		{
			if($minnum==1)
			{
				$listdd.="<li><a href='".str_replace("&page=1","",str_replace("?page=1","",$page_one))."'>$minnum</a></li>";
			}
			else
			{
				$listdd.="<li><a href='".preg_replace("/page=[0-9]+/i","page=$minnum",$url)."'>$minnum</a></li>";
			}
		}
	}
    
    $plist = '';
	$plist .= $indexpage; //首页链接
	$plist .= $prepage; //上一页链接
	$plist .= $listdd; //数字链接
	$plist .= $nextpage; //下一页链接
	$plist .= $endpage; //末页链接
	$plist .= $maininfo;
	
	return $plist;
}

/**
 * 获取列表上一页、下一页
 * @param $param['pagenow'] 当前第几页
 * @param $param['counts'] 总条数
 * @param $param['pagesize'] 每页显示数量
 * @param $param['catid'] 栏目id
 * @return array
 */
function get_prenext(array $param)
{
	$counts=$param['counts'];
	$pagenow=$param["pagenow"];
	$prepage = $nextpage = '';
	$prepagenum = $pagenow-1;
    $nextpagenum = $pagenow+1;
	$cat=$param['catid'];
    
	if(!empty($param["urltype"]))
    {
        $urltype = $param["urltype"];
    }
	else
	{
		$urltype = 'cat';
	}
    
	$totalpage=get_totalpage(array("counts"=>$counts,"pagesize"=>$param["pagesize"]));
	
	//获取上一页
	if($pagenow == 1)
	{
		
	}
	elseif($pagenow==2)
	{
		$prepage='<a class="prep" href="/'.$urltype.$cat.'.html">上一页</a> &nbsp; ';
	}
	else
	{
		$prepage='<a class="prep" href="/'.$urltype.$cat.'/'.$prepagenum.'.html">上一页</a> &nbsp; ';
	}
	
	//获取下一页
	if($pagenow<$totalpage && $totalpage>1)
	{
		$nextpage='<a class="nextp" href="/'.$urltype.$cat.'/'.$nextpagenum.'.html">下一页</a>';
	}
	
	$plist = '';
	$plist .= $indexpage; //首页链接
	$plist .= $prepage; //上一页链接
	$plist .= $nextpage; //下一页链接
	
	return $plist;
}
/**
 * 获取分页列表
 * @access    public
 * @param     string  $list_len  列表宽度
 * @param     string  $list_len  列表样式
 * @return    string
 */
function pagenav(array $param)
{
    $prepage = $nextpage = '';
    $prepagenum = $param["pagenow"]-1;
    $nextpagenum = $param["pagenow"]+1;
    
	if(!empty($param['tuijian'])){$map['tuijian']=$param['tuijian'];}
	if(!empty($param['typeid'])){$map['typeid']=$param['typeid'];}
	if(!empty($param['image'])){$map['litpic']=array('NEQ','');}
	if(!empty($param['row'])){$limit="0,".$param['row'];}else{if(!empty($param['limit'])){$limit=$param['limit'];}else{$limit='0,8';}}
	if(!empty($param['orderby'])){$orderby=$param['orderby'];}else{$orderby='id desc';}
	
	$Artlist = M("Article")->field('body',true)->where($map)->order($orderby)->limit($limit)->select();
	
    return $Artlist;
}

//根据总数与每页条数，获取总页数
function get_totalpage(array $param)
{
	if(!empty($param['pagesize'] || $param['pagesize']==0)){$pagesize=$param["pagesize"];}else{$pagesize=cms_pagesize;}
	$counts=$param["counts"];
	
	//取总数据量除以每页数的余数
    if($counts % $pagesize)
	{
		$totalpage = intval($counts/$pagesize) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一,如果没有余数，则页数等于总数据量除以每页数的结果
	}
	else
	{
		$totalpage = $counts/$pagesize;
	}
	
	return $totalpage;
}

/**
 * 获得当前的页面文件的url
 * @access public
 * @return string
 */
function GetCurUrl()
{
    if(!empty($_SERVER['REQUEST_URI']))
    {
        $nowurl = $_SERVER['REQUEST_URI'];
        $nowurls = explode('?', $nowurl);
        $nowurl = $nowurls[0];
    }
    else
    {
        $nowurl = $_SERVER['PHP_SELF'];
    }
    return $nowurl;
}

/**
 * 获取单页列表
 * @param int $row=8 需要返回的数量
 * @param string $orderby='id desc' 排序，默认id降序，随机rand()
 * @param string $limit='0,8' 如果存在$row，$limit就无效
 * @return string
 */
/* function pagelist(array $param)
{
	if(!empty($param['row'])){$limit="0,".$param['row'];}else{if(!empty($param['limit'])){$limit=$param['limit'];}else{$limit='0,8';}}
	if(!empty($param['orderby'])){$orderby=$param['orderby'];}else{$orderby='id desc';}
	
	$Pagelist = M("Page")->field('body',true)->where($map)->order($orderby)->limit($limit)->select();
	
    return $Pagelist;
} */

/**
 * 截取中文字符串
 * @param string $string 中文字符串
 * @param int $sublen 截取长度
 * @param int $start 开始长度 默认0
 * @param string $code 编码方式 默认UTF-8
 * @param string $omitted 末尾省略符 默认...
 * @return string
 */
function cut_str($string, $sublen=250, $omitted = '', $start=0, $code='UTF-8')
{
	$string = strip_tags($string);
	$string = str_replace("　","",$string);
	$string = mb_strcut($string,$start,$sublen,$code);
	$string.= $omitted;
	return $string;
}

//PhpAnalysis获取中文分词
function get_keywords($keyword)
{
    require_once '../class/phpAnalysis/phpAnalysis.class.php'; //引入配置文件
	//初始化类
	phpAnalysis::$loadInit = false;
    $pa = new phpAnalysis('utf-8', 'utf-8', false);
	//载入词典
	$pa->LoadDict();
	//执行分词
    $pa->SetSource($keyword);
    $pa->StartAnalysis( false );
    $keywords = $pa->GetFinallyResult(',');
	
    return ltrim($keywords, ",");
}

//根据栏目id获取栏目信息
function typeinfo($typeid)
{
    $db = new db();
    $where['where']="id=$typeid";
    return $db->select("arctype",$where);
}

//根据栏目id获取该栏目下文章/商品的数量
function catarcnum($typeid,$modelname='article')
{
    $db = new db();
    $where['where']="typeid=$typeid";
    return $db->count($modelname,$where);
}

//根据Tag id获取该Tag标签下文章的数量
function tagarcnum($tagid)
{
    if(!empty($tagid)){$map['tid']=$tagid;}
    $Taglist = M("Taglist")->where($map);
    $counts = $Taglist->count();
    return $counts;
}

//判断是否是图片格式，是返回true
function imgmatch($url)
{
    $info = pathinfo($url);
    if (isset($info['extension']))
    {
        if (($info['extension'] == 'jpg') || ($info['extension'] == 'jpeg') || ($info['extension'] == 'gif') || ($info['extension'] == 'png'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

//将栏目列表生成数组
function get_category($modelname,$parent_id=0,$pad=0)
{
    $arr=array();
    
    $db = new db();
    $where['where']="reid=$parent_id";
    $where['order']="id asc";
    $cats = $db->select($modelname,$where);
    
    if($cats)
    {
        foreach($cats as $row)//循环数组
        {
            $row['deep'] = $pad;
            if(get_category($modelname,$row["id"]))//如果子级不为空
            {
                $row['child'] = get_category($modelname,$row["id"],$pad+1);
            }
            $arr[] = $row;
        }
        return $arr;
    }
}

function tree($list,$pid=0)
{
    global $temp;
    
    if(!empty($list))
    {
        foreach($list as $v)
        {
            $temp[] = array("id"=>$v['id'],"deep"=>$v['deep'],"typename"=>$v['typename'],"reid"=>$v['reid'],"typedir"=>$v['typedir'],"addtime"=>$v['addtime']);
            
            if(array_key_exists("child",$v))
            {
                tree($v['child'],$v['reid']);
            }
        }
    }
    
    return $temp;
}

//递归获取面包屑导航
function get_cat_path($cat)
{
    global $temp;
    
    $row = M("Arctype")->field('typename,reid,id')->where("id=$cat")->find();
    
    $temp = '<a href="'.cms_basehost.'/cat'.$row["id"].'">'.$row["typename"]."</a> > ".$temp;
    
    if($row["reid"]<>0)
    {
        get_cat_path($row["reid"]);
    }
    
    return $temp;
}

//根据文章id获得tag，$id表示文章id，$tagid表示要排除的标签id
function taglist($id,$tagid=0)
{
    $tags="";
    if($tagid!=0)
    {
        $Taglist = M("Taglist")->where("aid=$id and tid<>$tagid")->select();
    }
    else
    {
        $Taglist = M("Taglist")->where("aid=$id")->select();
    }
    
    foreach($Taglist as $row)
    {
        if($tags==""){$tags='id='.$row['tid'];}else{$tags=$tags.' or id='.$row['tid'];}
    }
	
    if($tags!=""){return M("Tagindex")->where($tags)->select();}
}

/**
 * 为文章内容添加内链, 排除alt title <a></a>直接的字符替换
 *
 * @param string $body
 * @return string
 */
function ReplaceKeyword($body)
{
	$karr = $kaarr = array();
    
	//暂时屏蔽超链接
	$body = preg_replace("#(<a(.*))(>)(.*)(<)(\/a>)#isU", '\\1-]-\\4-[-\\6', $body);
	
	if(S("keywordlist")){$posts=S("keywordlist");}else{$posts = M("Keyword")->cache("keywordlist",2592000)->select();}
    
	foreach($posts as $row)
	{
		$keyword = trim($row['keyword']);
		$key_url=trim($row['rpurl']);
		$karr[] = $keyword;
		$kaarr[] = "<a href='$key_url' target='_blank'><u>$keyword</u></a>";
	}
	
	asort($karr);
    
    $body = str_replace('\"', '"', $body);
    
	foreach ($karr as $key => $word)
	{
		$body = preg_replace("#".preg_quote($word)."#isU", $kaarr[$key], $body, 1);
	}
    
	//恢复超链接
	return preg_replace("#(<a(.*))-\]-(.*)-\[-(\/a>)#isU", '\\1>\\3<\\4', $body);
}

/**
 * 删除非站内链接
 *
 * @access    public
 * @param     string  $body  内容
 * @param     array  $allow_urls  允许的超链接
 * @return    string
 */
function replacelinks($body, $allow_urls=array())
{
    $host_rule = join('|', $allow_urls);
    $host_rule = preg_replace("#[\n\r]#", '', $host_rule);
    $host_rule = str_replace('.', "\\.", $host_rule);
    $host_rule = str_replace('/', "\\/", $host_rule);
    $arr = '';
	
    preg_match_all("#<a([^>]*)>(.*)<\/a>#iU", $body, $arr);
	
    if( is_array($arr[0]) )
    {
        $rparr = array();
        $tgarr = array();
		
        foreach($arr[0] as $i=>$v)
        {
            if( $host_rule != '' && preg_match('#'.$host_rule.'#i', $arr[1][$i]) )
            {
                continue;
            }
			else
			{
                $rparr[] = $v;
                $tgarr[] = $arr[2][$i];
            }
        }
		
        if( !empty($rparr) )
        {
            $body = str_replace($rparr, $tgarr, $body);
        }
    }
    $arr = $rparr = $tgarr = '';
    return $body;
}

/**
 * 获取文本中首张图片地址
 * @param  [type] $content
 * @return [type]
 */
function getfirstpic($content)
{
    if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches))
	{
        $file=$_SERVER['DOCUMENT_ROOT'].$matches[3][0];
		
		if(file_exists($file))
		{
			return $matches[3][0];
		}
    }
	else
	{
		return false;
	}
}

//清空文件夹
function dir_delete($dir)
{
    //$dir = dir_path($dir);
    if (!is_dir($dir)) return FALSE; 
    $handle = opendir($dir); //打开目录
    
    while(($file = readdir($handle)) !== false)
    {
        if($file == '.' || $file == '..')continue;
        $d = $dir.DIRECTORY_SEPARATOR.$file;
        is_dir($d) ? dir_delete($d) : @unlink($d);
    }
    
    closedir($handle);
    return @rmdir($dir);
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
function redirect($url, $time=0, $msg='')
{
	if ($url=='' && isset($_SERVER["HTTP_REFERER"]))
	{
		$url = $_SERVER["HTTP_REFERER"];
	}
	
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if(empty($msg)) $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if(!headers_sent())
    {
        if(0 === $time)
        {
            header('Location:'.$url);
        }
        else
        {
            header("refresh:{$time};url={$url}");
            echo $msg;
        }
        exit();
    }
    else
    {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if($time != 0) $str .= $msg;
        exit($str);
    }
}

/**
 * 操作错误跳转的快捷方法
 * @access protected
 * @param string $msg 错误信息
 * @param string $url 页面跳转地址
 * @param mixed $time 当数字时指定跳转时间
 * @return void
 */
function error_jump($msg='', $url='', $time=3)
{
	if ($url=='' && isset($_SERVER["HTTP_REFERER"]))
	{
		$url = $_SERVER["HTTP_REFERER"];
	}
	
	if(!headers_sent())
    {
        header("Location:".CMS_ADMIN."?error=$msg&url=$url&time=$time");
        exit();
    }
    else
    {
        $str = "<meta http-equiv='Refresh' content='URL=".CMS_ADMIN."?error=$msg&url=$url&time=$time"."'>";
        exit($str);
    }
}

/**
 * 操作成功跳转的快捷方法
 * @access protected
 * @param string $msg 提示信息
 * @param string $url 页面跳转地址
 * @param mixed $time 当数字时指定跳转时间
 * @return void
 */
function success_jump($msg='', $url='', $time=1)
{
	if ($url=='' && isset($_SERVER["HTTP_REFERER"]))
	{
		$url = $_SERVER["HTTP_REFERER"];
	}
	
	if(!headers_sent())
    {
		header("Location:".CMS_ADMIN."?message=$msg&url=$url&time=$time");
        exit();
    }
    else
    {
        $str = "<meta http-equiv='Refresh' content='URL=".CMS_ADMIN."?message=$msg&url=$url&time=$time"."'>";
        exit($str);
    }
}


//从HTML文档中获得全部图片
//如果你曾经希望去获得某个网页上的全部图片，这段代码就是你需要的，你可以轻松的建立一个图片下载机器人
//$images = array();
//preg_match_all('/(img|src)=("|')[^"'>]+/i', $data, $media);
//unset($data);
//$data=preg_replace('/(img|src)("|'|="|=')(.*)/i',"$3",$media[0]);
//foreach($data as $url)
//{
    //$info = pathinfo($url);
    //if (isset($info['extension']))
    //{
        //if (($info['extension'] == 'jpg') || ($info['extension'] == 'jpeg') || ($info['extension'] == 'gif') || ($info['extension'] == 'png'))  
        //array_push($images, $url);  
    //}  
//}















