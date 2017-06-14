<?php
/**
 * 文件上传类
 */
defined('FLi') or exit();
class upload{
    private $config = array(
        'maxSize' => 5, //上传文件最大值 M 为单位
        'fix' => array(), //允许上传的文件后缀  如：jpg,gif
        'type' => array(), //允许上传的文件类型 如: image/jpeg
        'path' => 'file/p', //上传文件保存路径
        'childDir' => true, //是否子目录保存
        'childNameType' => 'Ymd', //子目录保存形式  必须在开启 childDir 后启用
        'field' => false, //需要上传的字段 假等于全部字段都上传
    );
    private $success; //上传文件成功信息 array
    private $error; //失败信息 string
    private $file; //存放上传文件的信息 array
    //初始化参数
    public function __construct(){
        global $config;
        $this->config['maxSize'] = $config['update_max_size'];
    }
    
    
    //改变配置参数
    public function setConfig($name,$value){
        $this->config[$name] = $value; 
    }
    
    public function __get($name){
        if(isset($this->config)){
            return $this->config;
        }
    }
    //上传单个文件
    public function uploadOne($file,$path,$config,$formName){
        $this->file = $file;
        //检测文件
        if(!$this->check()){
            return false;
        }
        //移动文件
        $newFileName = $this->getfilename().'.'.$this->getFix($this->file['name']);
        $zuhe = ROOT_PATH.$path.'/'.$newFileName;
        if(!move_uploaded_file($this->file['tmp_name'],$zuhe)){
            $this->error('文件保存错误');
            return false;
        }
        $this->success['name'] = $this->file['name'];
        $this->success['filename'] = $newFileName;
        $this->success['dir'] = $config['dirname'];
        //判断是否生成子目录
        if($this->config['childDir']){
            $this->success['file'] = $config['dirname'].'/'.$newFileName;
        }else{
            $this->success['file'] = $newFileName;
        }
        $this->success['pre'] = $config['pre'];
        $this->success['url'] = $GLOBALS['public']['weburl'].$this->success['pre'].'/'.$this->success['file'];
        $this->success['type'] = $this->file['type'];
        $this->success['size'] = $this->file['size'];
        $this->success['formname'] = $formName;
        return true;
    }
    //上传所有文件
    public function upload($path=''){
        set_time_limit(0);//php执行无时间限制
        $pre = $path;
        //判断保存路径
        if(!$path){
            $path = $this->config['path'];
        }else{
            $path = trim($path,'/');
        }
        
        //判断是否保存子目录
        $dirname = $this->getdirname();
        if($this->config['childDir']){
            $path = $path.'/'.$dirname;
        }
        //检测目录
        if(!is_dir(ROOT_PATH.$path)){
            if(!mkdir(ROOT_PATH.$path,0777,true)){
                $this->error('创建目录失败，请检测'.$path.'目录权限');
                return false;
            }
        }
        $config['dirname'] = $dirname;
        $config['pre'] = $pre;
        //获取文件信息
        $file = $this->getfile();
        foreach($file as $k => $filename){
            //过滤无效的上传
            if(!empty($filename['name'])){
                if(!$this->uploadOne($filename,$path,$config,$k)){ return false;};
                $success[] = $this->success;
                $this->success = array();
                $this->error = '';
                $isUpload = true;
            }
        }
        if($isUpload){
            $this->success = $success;
            return true;
        }else{
            $this->error = '没有选择上传文件';
            return false;
        }
        return true;
    }
    //获取上传成功信息
    public function getSucc(){
        return $this->success;
    }
    //接收表单
    private function getfile(){
        $files = $_FILES;
        $fileArray = array();
        $n = 0;
        foreach($files as $key=>$file){
            if(is_array($file['name'])) {
                $keys = array_keys($file);
                $count = count($file['name']);
                for ($i=0; $i<$count; $i++) {
                    $fileArray[$n]['key'] = $key;
                    foreach ($keys as $_key){
                        $fileArray[$n][$_key] = $file[$_key][$i];
                    }
                    $n++;
                }
            }else{
               $fileArray[$key] = $file;
            }
       }
       //只上传某个表单的文件
       if($this->config['field']){
           foreach($fileArray as $k => $v){
               if(!in_array($k,$this->config['field'])) unset($fileArray[$k]);
           }
       }
       return $fileArray;
    }
    //设置文件名
    private function getfilename(){
        return date('YmdHis').rand(1000,9999);
    }
    //设置子目录名
    private function getdirname(){
        return date($this->config['childNameType']);
    }
    //检测上传的文件
    private function check(){
        if($this->file['error'] == 1){
            $this->error(1);
            return false;
        }
        if($this->file['error'] == 2){
            $this->error(2);
            return false;
        }
        if($this->file['error'] == 3){
            $this->error(3);
            return false;
        }
        if($this->file['error'] == 4){
            $this->error(4);
            return false;
        }
        if(!$this->checkSize()){
            $this->error(8);
            return false;
        }
        if(!$this->isUpload($this->file['tmp_name'])) {
            $this->error = '非法上传文件！';
            return false;
        }
        if(!$this->checkType()){
           $this->error = '上传的文件类型不合法'; 
           return false;
        }
        if(!$this->checkFix()){
           $this->error = '上传的文件类型不合法'; 
           return false;
        }
        return true;
    }
    
    public function getMsg(){
        return $this->error;
    }
    
    //赋值上传错误信息
    private function error($errorNo) {
         switch($errorNo) {
            case 1:
                $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
                break;
            case 2:
                $this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                break;
            case 3:
                $this->error = '文件只有部分被上传';
                break;
            case 4:
                $this->error = '没有文件被上传';
                break;
            case 6:
                $this->error = '找不到临时文件夹';
                break;
            case 7:
                $this->error = '文件写入失败';
                break;
            case 8:
                $this->error = '文件超过了'.$this->config['maxSize'].'M，不能上传';
                break;
            default:
                $this->error = '未知上传错误！';
        }
        return;
    }
    
    //检查文件是否非法提交
    private function isUpload($filename) {
        return is_uploaded_file($filename);
    }
    //检测文件类型
    private function checkType() {
        if($this->config['type']){
            return in_array(strtolower($this->file['type']),$this->config['type']);
        }else{
            return true;
        }
    }
    //检测文件后缀
    private function checkFix(){
        if($this->config['fix']){
            $fix = $this->getFix($this->file['name']);
            if(!$fix){
                return false;
            }
            return in_array($fix,$this->config['fix']);
        }else{
            return true;
        }
    }
    //获取文件后缀
    private function getFix($file){
        return pathinfo($file,PATHINFO_EXTENSION);
    }
    //检测文件是否超过指定大小
    private function checkSize(){
        if($this->config['maxSize']){
            if($this->file['size'] > ($this->config['maxSize'] * 1024 * 1024)){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
    
}
