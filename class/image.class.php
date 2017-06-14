<?php 
/**
 *   图片类
 */
defined('FLi') or exit();
class image{
    static function getImageInfo($img) {
    $imageInfo = getimagesize($img);
    if ($imageInfo !== false) {
        $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
        $imageSize = filesize($img);
        $info = array(
            "width" => $imageInfo[0],
            "height" => $imageInfo[1],
            "type" => $imageType,
            "size" => $imageSize,
            "mime" => $imageInfo['mime']
        );
            return $info;
        } else {
            return false;
        }
    }
    //把不是jpg的图片转换成jpg图片
    static function img2jpg($img,$forgin='file/p/test.jpg'){
        $forgin = ROOT_PATH.$forgin;
        $infoImg = pathinfo($img);
        if($infoImg['extension']== 'png'){
            $im = imagecreatefrompng($img);
        }else if($infoImg['extension'] == 'gif'){
            $im = imagecreatefromgif($img);
        }
        imagejpeg($im,$forgin,90);
        imagedestroy($im);
    }
    
    //加水印   背景图片 水印图片 保存图片路径不填覆盖原图 水印图片透明度
    static function addWater($img,$water,$savename=null,$alpha=80){
        if(!file_exists($img) || !file_exists($water)){
            return false;
        }
        //GIF图片禁止加水印
        $fname = $img;
        $is_tojpge = false;
        $imageInfo = pathinfo($img);
        if($imageInfo['extension'] != 'jpg' && $imageInfo['extension'] != 'jpeg'){
            //如果上传的图片不是jpg图片，则转换为jpg图片在加水印，然后在转为上传的图片格式
            self::img2jpg($img);
            $fname = $img;
            $img = ROOT_PATH.'file/p/test.jpg';
            $is_tojpge = true;
        }
        $img_info = self::getImageInfo($img);
        $water_info = self::getImageInfo($water);
         //如果图片小于水印图片，不生成图片
        if ($img_info["width"] < $water_info["width"] || $img_info['height'] < $water_info['height']){
            return false;
        }
        
        //建立图像
        $sCreateFun = "imagecreatefrom" . $img_info['type'];
        $sImage = $sCreateFun($img);
        $wCreateFun = "imagecreatefrom" . $water_info['type'];
        $wImage = $wCreateFun($water);
        //设定图像的混色模式
        imagealphablending($wImage,true);
        //图像位置,默认为右下角右对齐
        $posY = $img_info["height"] - $water_info["height"];
        $posX = $img_info["width"] - $water_info["width"];
        
        //生成混合图像
        if($water_info['type'] == 'png'){
            imagecopy($sImage,$wImage,$posX,$posY,0,0,$water_info['width'], $water_info['height']);
        }else{
            imagecopymerge($sImage,$wImage,$posX,$posY,0,0,$water_info['width'],$water_info['height'], $alpha);
        }
        
        //输出图像
        $ImageFun = 'image'. $img_info['type'];
        //如果没有给出保存文件名，默认为原图像名
        if(!$savename) {
            $savename = $fname;
            @unlink($img);
        }
        //保存图像
        if ($img_info['type'] == 'jpg' || $img_info['type'] == 'jpeg') {
            imagejpeg($sImage,$savename,90);
        }else{
            $ImageFun($sImage,$savename);
        }
        imagedestroy($sImage);
        return true;
    }
    
    //生成缩略图   原图  缩略图宽度 缩略图高度
    static function smallImage($name,$width=300,$height=200,$height_bl=false,$pre='small_'){
        $src_img = $name;
        $ytinfo = self::getImageInfo($src_img);// 获取原图信息
        $height =  $height_bl ? $ytinfo['height'] * ($width / $ytinfo['width']) : $height;
        $dst_scale = $height/$width; //目标图像长宽比 
        $src_scale = $ytinfo['height']/$ytinfo['width']; // 原图长宽比 
        if($src_scale>=$dst_scale){ 
            // 过宽 
            $w = intval($ytinfo['width']); 
            $h = $height_bl ? $ytinfo['height'] : intval($dst_scale*$w); 
            $x = 0; 
            $y = 0; 
        }else{ 
            // 过高 
            $h = intval($ytinfo['height']); 
            $w = intval($h/$dst_scale); 
            $x = ($ytinfo['width'] - $w)/2; 
            $y = 0; 
        } 
        // 剪裁 
        $imagecreate = 'imagecreatefrom'.$ytinfo['type'];
        $source=$imagecreate($src_img); 
        $croped=imagecreatetruecolor($w,$h); 
        imagecopy($croped,$source,0,0,$x,$y,$ytinfo['width'],$ytinfo['height']); 
        // 缩放 
        $scale = $width/$w; 
        $target = imagecreatetruecolor($width,$height); 
        $final_w = intval($w*$scale); 
        $final_h = intval($h*$scale)+1; 
        imagecopyresampled($target,$croped,0,0,0,0,$final_w,$final_h,$w,$h); 
        //保存 
        //获取文件名
        $path = pathinfo($name);
        $dirname = $path['dirname']!='.' ? $path['dirname'].'/' : '';
        $filename = $dirname.$pre.$path['filename'].'.jpg';
        imagejpeg($target,$filename,90); 
        imagedestroy($target);
        return $filename;
    }
}
?>