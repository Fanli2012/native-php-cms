<?php 
/**
 * 数据库操作
 */
defined('FLi') or exit();
class db
{
    static private $conn=null;
    private $link_id;
    private $time;
    
    static public function getConn()
    {
        if(self::$conn == null)
        {
            self::$conn = new self();
        }
        return self::$conn;
    }
    
    public function __construct()
    {
        $this->time = $this->microtime_float();
        
        $port      = DB_PORT;
        $localhost = $port ? DB_HOST.':'.$port : DB_HOST;
        
        $this->connect($localhost, DB_USER, DB_PWD, DB_NAME, 1, DB_CHAR);
    }
    
    /**
     * $param 条件数组
     * array(
     *      '条件名字' => array('条件参数','条件参数','...') ? 参数,
     * )
     */
    public function where($param)
    {
        $We=$limit=$order=$like='';
        //判断参数是否存在
        if(isset($param))
        {
            //条件
            if(isset($param['where']) && !empty($param['where']))
            {
                if(is_array($param['where']))
                {
                    foreach($param['where'] as $k=>$v)
                    {
						// 如果不是数字则加引号
						if (!is_numeric($v))
						{
							$v = "'" . mysql_real_escape_string($v) . "'";
						}
						
                        $We[] = $k.'='.$v;
                    }
                    $We = ' WHERE '.implode(' AND ',$We);
                }
                else
                {
                    $We = ' WHERE '.$param['where'];
                }
            }
            //数量
            if(isset($param['limit']))
            {
                $limit=' LIMIT '.$param['limit'];
            }
            //排序
            if(isset($param['order']))
            {
                $order=' ORDER BY '.$param['order'];
            }
            //搜索
            if(isset($param['like']))
            {
                $like = $param['where'] ? ' AND '.$param['like'] : ' WHERE '.$param['like'];
            }
        }
        
        return $We.' '.$like.' '.$order.' '.$limit;
    }
    
    //查询记录数
    public function count($tab,$param)
    {
		if(isset($param['limit'])){unset($param['limit']);}
        $We = $this->where($param);
        $sql="SELECT count(1) FROM ".DB_PRE."$tab $We";
        $result=$this->query($sql);
        $data = mysql_fetch_row($result);
        $this->result($result);
        return $data['0'];
    }
    
    //查询
    public function select($tab ,$param ,$field='*')
    {
        $arr = array();
        $force = '';
        //强制进入某个索引
        if(isset($param['force'])) $force = ' force index('.$param['force'].')';
        if(isset($param['ignore'])) $force = ' ignore index('.$param['ignore'].')';
        $sqlStr = $this->where($param);
        $sql    = "SELECT $field FROM ".DB_PRE."$tab $force $sqlStr";
        $result = $this->query($sql);
        
        while(!!$a = mysql_fetch_assoc($result))
        {
			foreach ($a as $key => $value)
			{
                $a[$key] = stripslashes($value); // 去除斜杠
            }
			
            $arr[] = $a;
        }
        
        $this->result($result);
        return $arr;
    }
    
    //查询一条数据
    public function find($tab, $param, $field='*')
    {
        $force = '';
        //强制进入某个索引
        if(isset($param['force'])) $force = ' force index('.$param['force'].')';
        if(isset($param['ignore'])) $force = ' ignore index('.$param['ignore'].')';
        $We = $this->where($param);
        $sql="SELECT ".$field." FROM ".DB_PRE."$tab $force $We limit 1";
        $result=$this->query($sql);
        $data = mysql_fetch_assoc($result);
        if(!empty($data))
        {
            foreach ($data as $key => $value)
            {
                $data[$key] = stripslashes($value); // 去除斜杠
            }
        }
		
        return $data ? $data : array();
    }
    
    //删除
    public function delete($tab,$param=array())
    {
        if(isset($param))
        {
            //条件
            if(isset($param['where']))
            {
                $We = $this->where($param);
                $sql="DELETE FROM ".DB_PRE."$tab $We";
                return $this->query($sql);
            }
        }
    }
    
    //更新
    public function update($tab, Array $updateData, $param)
    {
        foreach($updateData as $key=>$v)
        {
			// 如果不是数字则加引号
			if (!is_numeric($v))
			{
				$v = "'" . addslashes(mysql_real_escape_string($v)) . "'";
			}
			
            $uD[]="$key=$v";
        }
        
        $We = $this->where($param);
        
        if(!$We)
        {
            return;
        }
        
        $uds=implode(',',$uD);
        $sql="UPDATE ".DB_PRE."$tab SET $uds $We";
        return $this->query($sql);
    }
    
    //增加
    public function insert($tab,$data)
    {
        foreach($data as $key => $v)
        {
			// 如果不是数字则加引号
			if (!is_numeric($v))
			{
				$v = "'" . addslashes(mysql_real_escape_string($v)) . "'";
			}
			
			$field[] = $key;
			$value[] = "$v";
        }
        
        $field = implode(',',$field);
        $value = implode(",",$value);
        $sql="INSERT INTO ".DB_PRE."$tab($field) VALUES($value)";
        $this->query($sql);
        
        return mysql_insert_id();
    }
    
    //数据库连接
	private function connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0,$charset='utf8')
    {
		if( $pconnect==0 )
        {
			$this->link_id = @mysqli_connect($dbhost, $dbuser, $dbpw, true);
			if(!$this->link_id)
            {
				$this->halt("数据库连接失败");
			}
		}
        else
        {
			$this->link_id = @mysql_pconnect($dbhost, $dbuser, $dbpw);
			if(!$this->link_id)
            {
				$this->halt("数据库持久连接失败");
			}
		}
		if(!@mysql_select_db($dbname,$this->link_id))
        {
			$this->halt('数据库选择失败');
		}
		@mysql_query("set names ".$charset);
	}
    
    //执行sql
    public function query($sql)
    {
        $query = mysql_query($sql,$this->link_id);
        if(!$query)
        {
            exit('sql语句有误'.mysql_error());
        }
        return $query;
    }
    
    //根据自定义sql语句查询
    public function sql($sql)
    {
        $result=$this->query($sql);
        
        while(!!$a=mysql_fetch_assoc($result))
        {
            $arr[]=$a;
        }
        
        $this->result($result);
        return $arr;
    }
    
    //清理结果集
    private function result($result)
    {
        mysql_free_result($result);
    }
    
    //join $join=表和字段的数组  $param=其他参数的数组
    /*array( //join参数
     *      'fromTab' => 'from 表名',
     *      'field' => array('表名' => array('字段名')),
     *      'ON' => array(array('left | right ? join type','on tabname','条件')//一次join一个数组，条件全部写一起 用 and 连接条件),
     * )
     * $param = array( //其他条件参数 where 后面的
     *      'where' => array('条件','条件','...'),
     *      'limit' => array(),
     * )
     */
    public function joinDB($join,$param)
    {
        //遍历表和字段
        foreach($join['field'] as $fieldKey=>$field)
        {
            foreach($field as $v)
            {
                $allField[]=DB_PRE.$fieldKey.'.'.$v;
            }
        }
        //遍历join类型和条件
        foreach($join['on'] as $wc => $w)
        {
            //初始化条件
            $b = explode('and',$w[2]);
            foreach($b as $k=>$v)
            {
                preg_match('/\[(.*)\]/',$v,$match);
                $sign = $match[1];
                $c = trim($v);
                $e = explode($sign,$c);
                foreach($e as $s)
                {
                    $x =  str_replace(array('[',']'),'',$s);
                    $y[$wc][$k][] = DB_PRE.trim($x);
                }
                $arr[$wc][$k]= implode(' '.$sign.' ',$y[$wc][$k]);
                $on[$wc]=$w[0]." JOIN ".DB_PRE.$w[1].' ON '.implode(' and ', $arr[$wc]);
            }
            
        }
        $on = implode(' ',$on);
        $allField = implode(',',$allField);
        $we = $this->where($param);
        $sql="SELECT $allField FROM ".DB_PRE.$join['fromTab']." $on $we";
        $result=$this->query($sql);
        while(!!$a=mysql_fetch_assoc($result))
        {
            $data[]=$a;
        }
        $this->result($result);
        return $data ? $data : array();
    }
    
    //创建数据表
    public function createDB($tabname,array $fileArr,$charset,$engine)
    {
        $fileStr = implode(',',$fileArr);
        $sql = "CREATE TABLE ".DB_PRE."$tabname(";
        $sql .= $fileStr;
        $sql .= ")ENGINE=$engine DEFAULT CHARSET=$charset;";
        return $this->query($sql);
    }
    
    //增加字段
    public function fieldDB($tabname,$type,$fieldname,$default='')
    {
        if($default)
        {
            $default = " DEFAULT '$default'";
        }
        $sql = "ALTER TABLE `".DB_PRE."$tabname` ADD `$fieldname` $type NOT NULL$default";
        return $this->query($sql);
    }
    
    //删除字段
    public function delFieldDB($tab,$fieldName)
    {
        $sql = "ALTER TABLE `".DB_PRE."$tab` DROP `$fieldName`";
        return $this->query($sql);
    }
    
    //删除数据表
    public function delTabDB($tabname)
    {
        $sql = "DROP TABLE `".DB_PRE."$tabname`";
        return $this->query($sql);
    }
    
    //返回数据库中所有表名
    public function getAllTabDb()
    {
        $sql = "show tables";
        $result=$this->query($sql);
        
        while(!!$a=mysql_fetch_row($result))
        {
            $arr[]=$a[0];
        }
        
        $this->result($result);
        return $arr;
    }
    
	//获取最后插入的id
	public function insert_id()
    {
		$id = mysql_insert_id($this->link_id);
		return $id;
	}
    
    //释放结果集
	public function free_result()
    {
		$void = func_get_args();
		foreach($void as $query) {
			if(is_resource($query) && get_resource_type($query) === 'mysql result')
            {
				return mysql_free_result($query);
			}
		}
	}
    
    //关闭数据库连接
	protected function close()
    {
		return @mysql_close($this->link_id);
	}

	//错误提示
	private function halt($msg='')
    {
		$msg .= "\r\n".mysql_error();
		die($msg);
	}
    
	//析构函数
	public function __destruct()
    {
		$this->free_result();
		$use_time = ($this-> microtime_float())-($this->time);
	}
	
	//获取毫秒数
	public function microtime_float()
    {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
}
?>