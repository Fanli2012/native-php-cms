<?php 
/**
 *   分页处理类
 */
defined('FLi') or exit();
class page{
    private $num;                    //总条数
    private $pagesize;               //每页显示条数
    private $url;                    //地址
    private $pagenum;                //总页数
    private $limit;                  //limit
    private $page;                   //当前页码
    private $bothnum;                //俩边页码偏移
    private $pagecon;                //分页参数 array ishome:显示首页和尾页,isprev:显示上一页和下一页  暂时去掉了此功能
    
    public function __construct($num,$pagesize,array $pagecon=array()){
        //初始化参数
        $this->num=$num ? $num : 1;
        $this->pagesize=$pagesize;
        $this->url=$this->geturl();
        $this->pagenum=ceil($this->num / $this->pagesize);
        $this->page=$this->getPage();
        $this->limit=($this->page-1) * $this->pagesize .",$this->pagesize";
        $this->bothnum=4;
        $this->pagecon = array('ishome'=>1,'isprev'=>1);
        foreach($pagecon as $k=>$v){
            $this->pagecon[$k] = $v;
        }
    }
    
    //返回当前页码
    public function returnPage(){
        return $this->page;
    }
    
    //返回limit
    public function returnLimit(){
        return $this->limit;
    }
    
    //获取url地址
    private function geturl(){
        $Yurl= request_url();
        $url=parse_url($Yurl);
        parse_str($url['query'],$query);
        if($GLOBALS['public']['ishtml'] == 2 && (RUN_TYPE=='index' || RUN_TYPE == 'extend') && strtolower($_GET['m']) != 'search' && strtolower($_GET['m']) != 'Book'){
            $url['path'] = preg_replace('/\/page\/([\d]+)/','',$url['path']);
            $xurl = $url['path'].'/page/';
        }else{
            unset($query['page']);
            $xurl = $url['path'].'?'.http_build_query($query).'&page=';
        }
        return $xurl;
    }
    
    //获取当前页码
    private function getPage(){
        $page=(int)$_GET['page'];
        if(!isset($page) || empty($page) || !$page){
            return 1;
        }
        if($page > $this->pagenum){
            return $this->pagenum;
        }
        if($page < 1){
            return 1;
        }
        return $page;
    }
    
    //返回动态页码
    private function listpage(){
        $pageList='';
        //计算上偏移
        if($this->page + $this->bothnum >= $this->pagenum){
            $s = $this->bothnum + ($this->page + $this->bothnum - $this->pagenum);
        }else{
            $s = $this->bothnum;
        }
        //计算下偏移
        if($this->page <= $this->bothnum){
            $h = $this->bothnum - $this->page + $this->bothnum+1;
        }else{
            $h = $this->bothnum;
        }
        for($i=$s;$i>=1;$i--){
            $page=$this->page-$i;
            if($page < 1){
                continue;
            }
            $pageList .= '<a href="'.$this->url.$page.'">'.$page.'</a>';
        }
        $pageList.="<span class='curr'>$this->page</span>";
        for($i=1;$i<=$h;$i++) {
            $page = $this->page+$i;
            if ($page > $this->pagenum) break;
            $pageList .= '<a href="'.$this->url.$page.'">'.$page.'</a>';
        }
        return $this->home().$this->prev().$pageList.$this->next().$this->last();
    }
    
    //伪静态页码
    private function listpage_2(){
        $pageList='';
        //计算上偏移
        if($this->page + $this->bothnum >= $this->pagenum){
            $s = $this->bothnum + ($this->page + $this->bothnum - $this->pagenum);
        }else{
            $s = $this->bothnum;
        }
        //计算下偏移
        if($this->page <= $this->bothnum){
            $h = $this->bothnum - $this->page + $this->bothnum+1;
        }else{
            $h = $this->bothnum;
        }
        for($i=$s;$i>=1;$i--){
            $page=$this->page-$i;
            if($page < 1){
                continue;
            }
            $pageList .= '<a href="'.$this->url.$page.'">'.$page.'</a>';
        }
        $pageList.="<span class='curr'>$this->page</span>";
        for($i=1;$i<=$h;$i++) {
            $page = $this->page+$i;
            if ($page > $this->pagenum) break;
            $pageList .= '<a href="'.$this->url.$page.'">'.$page.'</a>';
        }
        if($this->page > 1){
            $prevNum = ($this->page-1) < 1 ? 1 : $this->page - 1;
            $prev = '<a href="'.$this->url.$prevNum.'">上一页</a>';
        }
        if($this->page+1 <= $this->pagenum){
            $nextNum = ($this->page + 1) > $this->pagenum ? $this->pagenum : $this->page + 1;
            $next = '<a href="'.$this->url.$nextNum.'">下一页</a>';
        }
        if($this->page > 1){
            $home = '<a href="'.$this->url.'1">首页</a>';
        }
        if($this->page+1 <= $this->pagenum){
            $last = '<a href="'.$this->url.$this->pagenum.'">尾页</a>';
        }
        if($this->pagenum > 1){
            return $home.$prev.$pageList.$next.$last;
        }
    }
    
    //返回纯静态页码
    private function listpage_1(){
        //静态分页，程序内部生成所需
        $this->pagenum = $_GET['count'];
        $this->page = $_GET['curr'];
        if($this->pagenum <= 1) return; //如果只有一页则不显示页码
        $url = $GLOBALS['public']['weburl'].$_GET['path'].'/';
        if($this->page > 1){
            $str = "<a href='".$url."index.html'>首页</a>";
            $prev = $this->page - 1 <= 1 ? '' : '_'.($this->page - 1);
            $str .= "<a href='".$url."index".$prev.".html'>上一页</a>";
        }
        //计算上偏移
        if($this->page + $this->bothnum >= $this->pagenum){
            $s = $this->bothnum + ($this->page + $this->bothnum - $this->pagenum);
        }else{
            $s = $this->bothnum;
        }
        //计算下偏移
        if($this->page <= $this->bothnum){
            $h = $this->bothnum - $this->page + $this->bothnum+1;
        }else{
            $h = $this->bothnum;
        }
        for($i=$s;$i>=1;$i--){
            $page=$this->page-$i;
            if($page < 1){
                continue;
            }
            $str .= '<a href="'.$url.'index'.($page == 1 ? '' : '_'.$page).'.html">'.$page.'</a>';
        }
        $str.="<span class='curr'>$this->page</span>";
        for($i=1;$i<=$h;$i++) {
            $page = $this->page+$i;
            if ($page > $this->pagenum) break;
            $str .= '<a href="'.$url.'index_'.$page.'.html">'.$page.'</a>';
        }
        if($this->page < $this->pagenum){
            $str .= "<a href='".$url."index_".($this->page+1).".html'>下一页</a>";
            $str .= "<a href='".$url."index_".$this->pagenum.".html'>尾页</a>";
        }
        return $str;
    }
    
    //返回首页
    private function home(){
        if($this->page > 1){
            return '<a href="'.$this->url.'1">首页</a>';
        }
    }
    
    //返回尾页
    private function last(){
        if($this->page+1 <= $this->pagenum){
            return '<a href="'.$this->url.$this->pagenum.'">尾页</a>';
        }
    }
    
    //返回上一页
    private function prev(){
        if($this->page > 1){
            $prevNum = ($this->page-1) < 1 ? 1 : $this->page - 1;
            return '<a href="'.$this->url.$prevNum.'">上一页</a>';
        }
    }
    
    //返回下一页
    private function next(){
        if($this->page+1 <= $this->pagenum){
            $nextNum = ($this->page + 1) > $this->pagenum ? $this->pagenum : $this->page + 1;
            return '<a href="'.$this->url.$nextNum.'">下一页</a>';
        }
    }
    
    //返回整个页码
    public function html(){
        if(isset($_GET['ishtml']) && $GLOBALS['public']['ishtml'] == 1){ //纯静态
            return $this->listpage_1();
        }else if($GLOBALS['public']['ishtml'] == 2){ //伪静态
            return $this->listpage_2();
        }else{//动态页码
            if($this->pagenum > 1){
                return $this->listpage();
            }
        }
    }
}
?>