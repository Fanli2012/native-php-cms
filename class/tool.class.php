<?php 
/**
 * 工具类
 */
defined('FLi') or exit();
class tool{
    //二维数组某个key按照数字升序和降序排序
    static function array_sort($arr,$keys,$type='asc'){
        if(!$arr) return array();
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysvalue);
        }else{
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k=>$v){
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
    
    //把数组中某个键的值改变为的k值
    public static function arrV2K($arr,$v){
       if(is_array($arr) && $v){
            $newarr=array();
            foreach($arr as $value){
                $newarr[$value[$v]] = $value;
            }
        }
        return $newarr;
    }
    
    //去掉数组中的空值
    public static function unArrNull($arr){
        foreach($arr as $k => $v){
            if($v) $newarr[] = $v;
        }
        return $newarr;
    }
}
?>