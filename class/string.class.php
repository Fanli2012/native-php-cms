<?php 
/**
 * 字符串处理类
 */
defined('FLi') or exit();
class string{
    //转换实体并去掉俩边空格
    public static function html_char($str){
        return htmlspecialchars(trim($str),ENT_QUOTES);
    }
    
    //转换一维数组的字符串为实体
    public static function html_arr_char(array $data,$key = false){
        if($key){
            foreach($key as $v){
                $data[$v] = self::html_char($data[$v]);
            }
        }else{
            foreach($data as $k=>$v){
                $v = self::html_char($v);
                $data[$k] = $v;
            }
        }
        return $data;
    }
    
    //去掉html标签
    public static function delHtml($str){
        return strip_tags($str);
    }
    
    //去掉数组中的html标签
    public static function forDelhtml($arr){
        $new = array();
        if(!$arr) return;
        foreach($arr as $k => $v){
            if(is_array($v)){
                $new[$k] = self::forDelhtml($v);
            }else{
                $new[$k] = strip_tags($v);
            }
        }
        return $new;
    }
    //转换字符实体为字符串
    public static function html_char_dec($str){
        return htmlspecialchars_decode(trim($str),ENT_QUOTES);
    }
    
    //增加转义
    public static function addslashes($str){
        if(!get_magic_quotes_gpc()){
            return addslashes(trim($str));
        }
        return trim($str);
    }
    //去掉转义
    public static function stripslashes($str){
        return stripslashes(trim($str));;
    }
    
    //管理员密码加密
    public static function pwdmd5($str){
        return md5(sha1($str.$GLOBALS['public']['user_pwd_key']));
    }
    
    //生成拼音
    public static function scPinYin($str,$char='utf8'){
        return Pinyin($str,$char);
    }
    
    //根据字符串返回分词 str:字符串，num：分词最大数量 split分词间隔符号
    public static function split_word($str,$num,$split=','){
        return split_str($str,$num,$split);
    }
    //获取字符串中的文件、图片地址
    public static function getStringFileUrl($str){
        if($str){
            preg_match_all('/(\/file\/)([\w\/]+)(\.[a-zA-Z0-9]+)/i',$str,$newStr);
            foreach($newStr[0] as $v){
                $arr[] = ltrim($v,'/');
            }
            //去掉重复的值
            $arr = $arr ? array_unique($arr) : array();
            return $arr;
        }else{
            return false;
        }
    }
}
?>