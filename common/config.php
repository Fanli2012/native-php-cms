<?php
date_default_timezone_set('PRC'); //设置中国时区
/**
 * 全站配置文件
 */
define('FLi',TRUE);
//网站绝对根路径
define('ROOT_PATH',str_replace('\\','/',substr(dirname(__FILE__),0,-6)));
require_once 'db.inc.php';
require_once 'common.inc.php'; //引入配置文件

//定义常量
define('CMS_ADMIN', '/fladmin/');    // 后台模块，首字母最好大写
define('CMS_PLUS', '/other/');       // 插件目录
define('CMS_VERSION', '1.1.0');                  // 插件目录

//系统相关
$config['tuijian'] = array("0"=>"不推荐","1"=>"一级推荐","2"=>"二级推荐","3"=>"三级推荐","4"=>"四级推荐"); //推荐等级
    
$config['template'] = ROOT_PATH.'template/'; //模板根路径
$config['page_list_num'] = 15; //后台信息列表每页显示 过多会影响后台速度
$config['template_edit'] = 0; //后台是否允许编辑模板文件 0：允许 1：不允许
$config['sc_group_num'] = 300; //后台生成html每组条数 过大会造成系统负担 建议300以内
$config['ad_extime'] = 5; //后台即将到期列表显示距离多少天到期的广告
$config['user_out_time'] = 30; //后台管理员登录超时时间
$config['login_num'] = 5; //后台登录错误最多次数
$config['login_out_time'] = 120; //单位：分钟 后台登录密码错误次数过多要间隔多长时间再次登录
$config['is_admin_log'] = 1; //是否开启后台管理员操作日志 1:开启 0:关闭
$config['search_isnull'] = 1; //前台搜索是否允许搜索空字符串 1:不允许 0:允许
$config['form_time'] = 10; //前台多少秒之内不允许再次提交自定义表单  搜索和留言板间隔时间在 “后台—系统管理—基本设置” 里面设置
$config['book_out_time'] = 3600; //前台留言时间范围内不允许过多留言
$config['book_out_time_num'] = 3; //前台留言时间范围内不允许1个ip超过多少条，和上面的时间范围配合

$config['is_tags_chinese'] = 0; //静态模式下tags地址是否启用中文路径 如果你的服务器不支持中文文件夹，则不要开启，否则tags页面会打不开
$config['system_coding'] = 'utf-8'; //操作系统编码，windows简体中文是gbk，linux一般是utf-8 ，如果开启了上面的tags中文路径，该编码必须正确填写，否则会出现路径乱码
$config['tags_page_num'] = 10; //tags列表页面默认每页显示 在增加信息的时候默认，可以在后台Tags管理中修改某一条为其他数值

$config['clickMax'] = array(10,100); //后台增加内容点击次数的随机范围
$config['search_time'] = 365; //前台搜索信息默认查询多少天之内信息 0:全部 
$config['is_lmxcms_update'] = 1; //后台是否开启系统更新提示
$config['q_dyform_filepath'] = 'file/dy'; //自定义表单前台上传文件保存路径

//Ueditor编辑器配置项
$config['ueditor_dir'] = 'other/ueditor/'; //编辑器路径
$config['ueditor_out_sub'] = array('snapscreen','wordimage','insertvideo','scrawl','help');//去掉编辑器中的某些按钮，这些是系统默认的，某些功能没有集成到本系统中

require ROOT_PATH.'class/db.class.php'; //数据库操作类
require 'function.php'; //公共函数
require 'userfun.php'; //引入用户自定义函数库




