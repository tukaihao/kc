<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

//错误级别
error_reporting(E_ERROR | E_PARSE );

/*是否微信*/
function is_weixin()
{ 
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }  
        return false;
}


// 应用公共文件
/*
function U($url = '', $vars = '', $suffix = true, $domain = false){
	
	return \think\Url::build($url, $vars, $suffix, $domain);
}*/


/*
二维码名片
*/
function parse_to_qrcode($contarr){

	$qrtxt = '';
	$contarr['type'] = 'mecard';
	
	if($contarr['type'] == 'mecard')
	{
		$qrtxt = "BEGIN:VCARD\r\nVERSION:3.0";
		if($contarr['cdname'])
		{
			$qrtxt .= "\r\nN:".$contarr['cdname'];
		}
		if($contarr['cdtel'])
		{
			$qrtxt .= "\r\nTEL:".$contarr['cdtel'];
		}
		if($contarr['cdemail'])
		{
			$qrtxt .= "\r\nEMAIL:".$contarr['cdemail'];
		}
		if($contarr['cdadr'])
		{
			$qrtxt .= "\r\nADR;TYPE=WORK:".$contarr['cdadr'];
		}
		if($contarr['cdorg'])
		{
			$qrtxt .= "\r\nORG:".$contarr['cdorg'];
		}
		if($contarr['cdurl'])
		{
			$qrtxt .= "\r\nURL:".$contarr['cdurl'];
		}
		if($contarr['cdtel1'])
		{
			$qrtxt .= "\r\nTEL;TYPE=WORK,VOICE:".$contarr['cdtel1'];
		}
		if($contarr['cdtel2'])
		{
			$qrtxt .= "\r\nTEL;TYPE=HOME,VOICE:".$contarr['cdtel2'];
		}
		if($contarr['cdtitle'])
		{
			$qrtxt .= "\r\nTITLE:".$contarr['cdtitle'];
		}
		if($contarr['cdadrhome'])
		{
			$qrtxt .= "\r\nADR;TYPE=HOME:".$contarr['cdadrhome'];
		}
		/*if($contarr['cdname'])
		{
			$qrtxt .= "\r\nADR;TYPE=HOME:".$contarr['cdname'];
		}*/
		if($contarr['cdnote'])
		{
			$qrtxt .= "\r\nNOTE:".$contarr['cdnote'];
		}
		$qrtxt .= "\r\nEND:VCARD";
	}
	

	return $qrtxt;

}


/**
 * 将返回的数据集转换成树
 * @param  array   $list  数据集
 * @param  string  $pk    主键
 * @param  string  $pid   父节点名称
 * @param  string  $child 子节点名称
 * @param  integer $root  根节点ID
 * @return array          转换后的树
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root=0) {
    $tree = array();// 创建Tree
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[$data[$pk]] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}




/*识别手机访问*/
function is_mobile()
{
    $browsers = array (
			'MicroMessenger',
			'Windows Phone',
            'Googlebot-Mobile',
            'Opera Mini',
            'iPhone',
            'BlackBerry',
            'iPod',
            'Android',
            'Bolt',
            'IEMobile',
            'GoBrowser',
            'Skyfire',
            'TeaShark',
            'UC Browser',
            'UCWEB',
            'Opera Mobi',
            'Mobile Safari',
            'SEMC-Browser',
            'Teleca',
            'Series60',
            'Doris',
            '2.0 MMP',
            '240x320',
            '400X240',
            'AvantGo',
            'Blazer',
            'Cellphone',
            'Danger',
            'DoCoMo',
            'Elaine 3.0',
            'EudoraWeb',
            'hiptop',
            'KYOCERA WX310K',
            'LG U990',
            'MIDP-2.',
            'MMEF20',
            'MOT-V',
            'NetFront',
            'Newt',
            'Nintendo Wii',
            'Nitro',
            'Nokia',
            'Palm',
            'PlayStation Portable',
            'ProxiNet',
            'SHARP-TQ-GX10',
            'SHG-i900',
            'Small',
            'SonyEricsson',
            'Fennec',
            'TS21i-10',
            'UP.Browser',
            'UP.Link',
            'Windows CE',
            'WinWAP',
            'LG-TU915 Obigo',
            'LGE VX',
            'Iris',
            'Maemo Browser',
            'MIB',
            'Kindle Basic Web',
            'Myriad Browser',
            'Obigo Browser',
            'Polaris Browser',
            'uZardWeb',
            'WebOS',
            'Deepfish',
            'Dolphin',
            'Firefox Mobile',
            'ibisBrowser',
            'JOCA',
            'Links',
            'Minimo',
            'Pixo',
            'Skweezer',
            'Steel',
            'Tristit',
            'Vision Mobile Browser',
            'Dorothy',
            'Ovi Browser'
        );
	$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
    foreach($browsers as $browser) 
	{ 
        if (preg_match("/".$browser."/i",$useragent)) {
            return true;
        }
    }
	return false;
}



/*
生成普通二维码
\QRcode::png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false, $back_color = 0xFFFFFF, $fore_color = 0x000000) 

*/
function my_phpqrcode($text,$type_dir='record',$size=10,$level='M',$margin=1)
{
	\think\Loader::import('@.vendor.phpqrcode.phpqrcode');

	$uploadDir = SITE_DIR.'/uploads/'.$type_dir.'/';
	$ymd_dir = date('Y').'/'.date('m').'/'.date('d').'/';
	leipi_mkdirs( $uploadDir . $ymd_dir);

	$fileName = date('YmdHis').rand(1000,9999).leipi_rand_string().'.png';
	$uploadPath = $uploadDir . $ymd_dir . $fileName;
	$uploadUrl = '/uploads/'.$type_dir.'/' . $ymd_dir . $fileName;//保存数据库的

    if(!$text){
		$text = 'http://www.mobanma.com/';
	}
	if(!in_array($level,array('L','M','Q','H'))){
		$level = 'L';
	}

	\QRcode::png($text, $uploadPath, $level, $size, $margin);

	if(file_exists($uploadPath)){
		return $uploadUrl;
	}else{
		return '';
	}

	

}




function ids_parse($str,$dot_tmp=',')
{
    if(!$str) return '';
    if(is_array($str))
    {
        $idarr = $str;
    }else
    {
        $idarr = explode(',',$str);
    }
    $idarr = array_unique($idarr);
	$dot = $idstr = '';
    foreach($idarr as $id)
    {
        $id = intval($id);
        if($id>0)
        {
            $idstr.=$dot.$id;
            $dot = $dot_tmp;
        }
    }
    if(!$idstr) $idstr=0;
    return $idstr;
}


/*
是否图片
$is_img = is_img($_FILES["file"]["tmp_name"]);
*/
function is_img($filename) {
	$alltypes = '.png|.gif|.jpeg|.jpg|.bmp'; //定义检查的图片类型   
	if (file_exists($filename)) {
		$result = getimagesize($filename);
		if(!$result){
			return false;
		}
		else{
			return true;
		}
		
	} else {
		return false;
	} 
} 


/**
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 2大写字母 3小写字母  4中文  5大小写数字
 * @param string $addChars 额外字符
 * @return string
 */
function leipi_rand_string($len=6,$type='',$addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 4:
            $chars = "在这里可以输入一些随机的中文".$addChars;
            break;
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }
    if($len>10 ) {//位数过长重复字符串一定次数
        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
    }
    if($type!=4) {
        $chars   =   str_shuffle($chars);
        $str     =   substr($chars,0,$len);
    }else{
        // 中文随机字
        for($i=0;$i<$len;$i++){
          $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
        }
    }
    return $str;
}
//创建多级目录
function leipi_mkdirs($dirname, $ismkindex=1) {
    $mkdir = false;
    
    if(is_dir($dirname))
        return true;
	
	$dirname = str_replace(SITE_DIR .'/','',$dirname);
    $arr = explode('/',$dirname);
	
    $dirname= SITE_DIR.'/';
	$dot = '';
    foreach($arr as $val)
    {
        $dirname .=  $dot .$val;
	
        $dot= '/';
        if(!is_dir($dirname)) {
            if(@mkdir($dirname, 0777)) {
                if($ismkindex) {
                    @fclose(@fopen($dirname.'/index.html', 'w'));
                }
                $mkdir = true;
            }
        } else {
            $mkdir = true;
        }
    }

    return $mkdir;
}function get_extension($file)
{
    return strtolower(pathinfo($file, PATHINFO_EXTENSION));
}

/**
 * php md5加盐 SALT 函数 
 * 定义一个salt值，最好够长，或者随机
 */
function md5_salt($str,$salt='mobanma.com&ppsao.com') {
    return md5($str . $salt); //返回加salt后的散列
}



/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装） 
 * @return mixed
 */
function get_client_ip($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    $dot = '';
    if((strlen($str)/2)>$length) //cyf 超出才显示
        $dot = '...';
    return $suffix ? $slice.$dot : $slice;
}
//返回input数组中键值为column_key的列
if(!function_exists('array_column')){
    function array_column(array $input, $columnKey, $indexKey = null) {
        $result = array();
        if (null === $indexKey) {
            if (null === $columnKey) {
                $result = array_values($input);
            } else {
                foreach ($input as $row) {
                    $result[] = $row[$columnKey];
                }
            }
        } else {
            if (null === $columnKey) {
                foreach ($input as $row) {
                    $result[$row[$indexKey]] = $row;
                }
            } else {
                foreach ($input as $row) {
                    $result[$row[$indexKey]] = $row[$columnKey];
                }
            }
        }
        return $result;
    }
}