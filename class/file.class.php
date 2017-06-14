<?php 
/**
 *   文件、文件夹操作类
 */
defined('FLi') or exit();
class file{
    
    //删除文件
    public static function unLink($path){
        if($path == ROOT_PATH) return;
        if(is_file($path)){
            if(!@unlink($path)) rewrite::js_back('删除文件失败，请检查'.$path.'文件权限');
            return true;
        }
    }
    
    //保存文件
    public static function put($path,$data){
        if(file_put_contents($path,$data) === false)
            rewrite::js_back('请检查【'.$path.'】是否有读写权限');
    }
    
    //获取文件内容
    public static function getcon($path){
        if(is_file($path)){
            if(!$content = file_get_contents($path)){
                rewrite::js_back('请检查【'.$path.'】是否有读取权限');
            }else{
                return $content;
            }
        }else{
            rewrite::js_back('请检查【'.$path.'】文件是否存在');
        }
    }
    
    /* 获取模板列表
     * $type:search,list,content,single   4种类型
     */
    public static function getTem($type){
        $dir = '';
        switch($type){
            case 'content' : $dir = 'content'; break;
            case 'search' : $dir = 'search'; break;
            case 'list' : $dir = 'column'; break;
            case 'single' : $dir = 'single'; break;
            case 'zt' : $dir = 'zt'; break;
            case 'tags' : $dir = 'tags'; break;
        }
        if($dir){
            $data = self::getDirAllFile(ROOT_PATH.'template/'.$GLOBALS['public']['default_temdir'].'/'.$dir,'html');
            $filename = array();
            if($data){
                foreach($data as $v){
                    $data = pathinfo($v);
                    $filename[] = $data['filename'];
                }
            }
            return $filename;
        }
    }
    
    /* 获取某个文件夹下某个后缀的所有文件
     * $path:文件路径
     * $fix:后缀
     */
    public static function getDirAllFile($path,$fix){
        if(file_exists($path)){
            $fp = opendir($path);
            //阅读目录
            while(false != $file = readdir($fp)){
                //列出所有文件并去掉'.'和'..'
                if($file != '.' && $file != '..'){
                    $file = "$file";
                    //赋值给数组
                    $fix = trim($fix,'.');
                    $regular = '\.'.$fix;
                    if(preg_match("/$regular$/",$file)){
                        $arr[]=$file;
                    }
                }
            }
            closedir($fp);
            return $arr;
        }
    }
    
    //检测文件是否存在
    public static function isFile($path){
        clearstatcache();
        return is_file($path);
    }
    
    //检测目录是否存在
    public static function isDir($path){
        clearstatcache();
        return is_dir($path);
    }
    
    //创建目录
    public static function mkDir($path){
        if(!is_dir($path)){
            if(!@mkdir($path,0777,true)){
                rewrite::js_back('创建目录失败，请检查'.$path.'目录权限');
            }
        }
    }
    
    //修改文件或者文件夹名字
    public static function renames($name,$newname){
        if(file_exists($name)){
            if(!@rename($name,$newname)){
                rewrite::js_back('请检查'.$name.'文件或目录是否有更改名字权限');
            }
        }
    }
    
    //删除空目录
    public static function rmDir($path){
        if(self::isDir($path)){
            if(!@rmdir($path)) rewrite::js_back('删除目录失败，请检查'.$path.'目录权限');
            return true;
        }
    }
    
    //删除非空目录
    public static function delDir($dir){
        if(self::isDir($dir) && $dir != ROOT_PATH){
            if($handle = opendir("$dir")) {
                while(false!==($item=readdir($handle))) {
                      if($item != "." && $item != "..") {
                        if (is_dir("$dir/$item")) {
                          self::delDir("$dir/$item");
                        }else{
                          self::unLink("$dir/$item");
                        }
                      }
                }
                closedir($handle);
                self::rmDir($dir);
            }
        }
    }
    
    
    //返回目录权限结果
    public static function dir_chomd($path){
        if(!$path) return 0;
	$filename = $path."/chomd_test.txt";
	$fp = @fopen($filename,"wb");
	if($fp){
            @fclose($fp);
            @unlink($filename);
            return 1;
	}else{
            return 0;
	}
    }
    
    //返回文件权限结果
    public static function file_chomd($filename){
        if(!$filename) return 0;
        return is_writable($filename);
    }
    
    //返回目录或者文件是否可读可写
    public static function is_chmod($path){
        if(!file_exists($path) || !$path) return false;
        if(is_dir($path)){
            //检测目录
            return self::dir_chomd($path);
	}else{
            return self::file_chomd($path);
	}
        return false;
    }
}
?>