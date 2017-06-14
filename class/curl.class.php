<?php 
/**
 * 采集类
 */
defined('FLi') or exit();
class curl{
    private $url;
    private $ch;
    public $succ = false; 
    public $error; //错误信息
    private $timeout = 15;
    private $ip;
    public function __construct(){
        $this->ch = curl_init();
        $this->ip = '220.181.108.91';
    }
    
    //GET方式返回目标页面内容
    public function getContent($url){
        curl_setopt($this->ch,CURLOPT_URL,$url);
        curl_setopt($this->ch,CURLOPT_TIMEOUT,0);
        //伪造百度蜘蛛IP  
        curl_setopt($this->ch,CURLOPT_HTTPHEADER,array('X-FORWARDED-FOR:'.$this->ip.'','CLIENT-IP:'.$this->ip.'')); 
        //伪造百度蜘蛛头部
        curl_setopt($this->ch,CURLOPT_USERAGENT,"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)");
        curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($this->ch,CURLOPT_HEADER,0);
        curl_setopt($this->ch,CURLOPT_CONNECTTIMEOUT,$this->timeout);
        $content = curl_exec($this->ch);
        if($content === false){//输出错误信息
            $no = curl_errno($this->ch);
            switch(trim($no)){
                case 28 : $this->error = '访问目标地址超时'; break;
                default : $this->error = curl_error($this->ch); break;
            }
            return $this->error;
        }else{
            $this->succ = true;
            return $content;
        }
    }
    //下载图片到本地  传入原图片网址，保存地址，不包包含图片后缀
    public function downImg($imgUrl,$path){
        $imgUrl = preg_replace_callback('/[\x{4e00}-\x{9fa5}A-Za-z0-9_]/u',"preg_callback_chinaese",$imgUrl);
        curl_setopt($this->ch,CURLOPT_URL,$imgUrl);
        curl_setopt($this->ch,CURLOPT_TIMEOUT,0);
        curl_setopt($this->ch,CURLOPT_HEADER,1);
        //伪造百度蜘蛛IP
        curl_setopt($this->ch,CURLOPT_HTTPHEADER,array('X-FORWARDED-FOR:'.$this->ip.'','CLIENT-IP:'.$this->ip.''));
        //伪造百度蜘蛛头部
        curl_setopt($this->ch,CURLOPT_USERAGENT,"Mozilla/5.0 (compatible; Baiduspider-image/2.0; +http://www.baidu.com/search/spider.html)");
        curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($this->ch,CURLOPT_NOBODY,1);
        curl_setopt($this->ch,CURLOPT_CONNECTTIMEOUT,$this->timeout);
        $zt = curl_exec($this->ch);
        if(strpos($zt,'200') === false) return false;
        curl_setopt($this->ch,CURLOPT_NOBODY,0);
        curl_setopt($this->ch,CURLOPT_HEADER,0);
        $img = curl_exec($this->ch);
        $imgInfo = pathinfo($imgUrl);
        file_put_contents($path.'.'.$imgInfo['extension'],$img);
        return str_replace(ROOT_PATH,'',$path.'.'.$imgInfo['extension']);
    }
    
    public function __destruct() {
        curl_close($this->ch);
    }
}
?>