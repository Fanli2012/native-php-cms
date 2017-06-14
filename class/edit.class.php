<?php 
/**
 *   获取百度编辑器 单例模式
 */
defined('FLi') or exit();
class edit{
    private static $editObj = null;
    public $sub;
    private $width;
    private $height;
    private $path;
    public static function getEditObj(){
        if(self::$editObj == null) self::$editObj = new self();
        return self::$editObj;
    }
    
    //初始化配置参数
    private function __construct() {
        $this->width= '100%';
        $this->height = '300px';
        $this->path = '?m=Edit&a=editUpload&path=';
    }
    
    //获取编辑器 $path:上传地址
    public function getEdit($path,$content=''){
        $this->sub();
        $path = '/'.trim($path,'/').'/';
        $url = $_SERVER['SCRIPT_NAME'].$this->path.$path;
        global $config;
        $str.="<script type='text/javascript' src='".$config['ueditor_dir']."ueditor.config.js'></script><script type='text/javascript' src='".$config['ueditor_dir']."ueditor.all.min.js'></script><script type='text/javascript' src='".$config['ueditor_dir']."lang/zh-cn/zh-cn.js'></script>";
        $str.="<textarea id='content' name='content'  style='width:100%;height:300px;'>$content</textarea>";
        $configs = implode("','",$this->sub);
        $configs = "'".$configs."'";
        $str.="<script type='text/javascript'>UE.getEditor('content',{toolbars:[[$configs]],imagePath:'".$GLOBALS['public']['weburl'].ltrim($path,'/')."',imageUrl:'".$url."',filePath:'".$GLOBALS['public']['weburl'].ltrim($path,'/')."',fileUrl:'".$url."'})</script>";
        return $str;
    }
    
    //配置按钮
    public function sub(){
        $sub = array('fullscreen','source','|','undo','redo','|','bold','italic','underline','fontborder','strikethrough','superscript','subscript','removeformat','formatmatch','autotypeset','blockquote','pasteplain','|','forecolor','backcolor','insertorderedlist','insertunorderedlist','selectall','cleardoc','|','rowspacingtop','rowspacingbottom','lineheight','|','customstyle','paragraph','fontfamily','fontsize','|','directionalityltr','directionalityrtl','indent','|','justifyleft','justifycenter','justifyright','justifyjustify','|','touppercase','tolowercase','|','link','unlink','anchor','|','imagenone','imageleft','imageright','imagecenter','|','insertimage','emotion','scrawl','insertvideo','music','attachment','map','gmap','insertframe','insertcode','webapp','pagebreak','template','background','|','horizontal','date','time','spechars','snapscreen','wordimage','|','inserttable','deletetable','insertparagraphbeforetable','insertrow','deleterow','insertcol','deletecol','mergecells','mergeright','mergedown','splittocells','splittorows','splittocols','charts','|','print','preview','searchreplace','help','drafts');
        global $config;
        foreach($sub as $k => $v){
            if(in_array($v,$config['ueditor_out_sub'])){
                unset($sub[$k]);
            }
        }
        $this->sub = $sub;
    }
    
    //图片附加上传类  上传地址  上传Upload类参数配置 配置具体查看 upload类
    public function upload($path,$config='') {
       if(isset($_GET['fetch'])) {
            header('Content-Type:text/javascript' );
            echo 'updateSavePath('.json_encode('file/p').');';
            return;
       }
       $upload = new upload();
       if($config && is_array($config)){
           foreach($config as $k => $v){
               $upload->setConfig($k,$v);
           }
       }else{
           $upload = new upload();
       }
       $is_upload = $upload->upload($path);
       if($is_upload){
            $info = $upload->getSucc();
            echo json_encode(array(
            'url' => $info[0]['file'],
            'title' => htmlspecialchars($_POST['pictitle'],ENT_QUOTES),
            'original' => $info[0]['name'],
            'state' => 'SUCCESS',
       ));
       }else{
            echo json_encode(array(
                'state' => $upload->getMsg(),
            ));
       }
   } 
}
?>