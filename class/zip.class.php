<?php
/**
 * 文件打包
 */
defined('FLi') or exit();
class zip
{
    //压缩文件   要压缩的文件路径数组   保存压缩文件的路径
    public static function toZip(array $fileArr,$savepath)
    {
        $zip = new ZipArchive();
        if($zip->open($savepath,ZipArchive::OVERWRITE) === true){ //创建一个空的zip文件
            foreach($fileArr as $v)
            {
                $filename = pathinfo($v);
                $zip->addFile($v,$filename['basename']);
            }
            $zip->close();
        }
        else
        {
            rewrite::js_back('压缩文件失败，请查看【'.$savepath.'】是否有写的权限');
        }
    }
    
    //要解压的文件路径    解压到哪的路径 不填为压缩文件所在路径，也就是解压到当前路径
    public static function openZip($zippath,$dir=false)
    {
        $zip = new ZipArchive();
        if($zip->open($zippath) === true)
        {
            if(!$dir) $dir = dirname($zippath);
            $zip->extractTo($dir);
            $zip->close();//关闭处理的zip文件
        }
        else
        {
            rewrite::js_back('解压文件失败，请查看【'.dirname($zippath).'】是否有读的权限');
        }
    }
    
    //根据压缩文件返回里面的文件数量
    public static function fileNum($zippath)
    {
        $zip = new ZipArchive();
        $zip->open($zippath);
        $num = $zip->numFiles;
        $zip->close();//关闭处理的zip文件
        return $num;
    }
}
?>
