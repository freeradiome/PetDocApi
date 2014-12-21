<?php 
/**
 * 输出提示信息
 *
 * @param string $message 提示信息内容 
 * @param string $title 输出模版时的提示标题（输出模版时有效）
 * @param unknown_type 输出模版时的模版页（输出模版时有效）
 */
//function show_msg($message='',$title='',$html = 'message'){
//
//	$tpl = Tpl::getInstance();
//	$tpl->datas(array('title'=>$title,'message'=>$message));
//	$tpl->render($html);
//	exit();
//
//}
function show_msg($message='',$title='',$html = 'message'){

	sException::__display(700,array(),$message);
}
/**
 * 获取客户端IP地址
 *
 * @return string
 */
function get_client_ip(){
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
	$ip = getenv("HTTP_CLIENT_IP");
	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
	$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
	$ip = getenv("REMOTE_ADDR");
	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
	$ip = $_SERVER['REMOTE_ADDR'];
	else
	$ip = "unknown";
	return($ip);
}
/**
* 将字符串转换为数组
*
* @param	string	$data	字符串
* @return	array	返回数组格式，如果，data为空，则返回空数组
*/
function string2array($data) {
	if($data == '') return array();
	@eval("\$array = $data;");
	return $array;
}
/**
 * 补充函数用于字符地址转路由地址参数
 * 作者 时间
 * robert 2012-07-04
 * @param unknown_type $string
 */
function _run($string,$array=array()){
	$string= explode('/',$string);
	//	$url_this = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	//	$url_this =dirname($url_this).'/';
	$url_this =WEB_ROOT;
	$url = run($string[0],$string[1],$array,$url_this);
	echo $url;
}


/**
 * 曾维骐添加给获取字符真实长度
 *
 * @param string $str
 * @return string
 */
function strRealLen($str,$len,$bool=true,$ext='.'){
	if(!empty($str)){
		$i = 0;
		$tlen = 0;
		$tstr = '';
		while ($tlen < $len) {
			$chr = mb_substr($str, $i, 1, 'utf8');
			$chrLen = ord($chr) > 127 ? 2 : 1;
			if ($tlen + $chrLen > $len) break;
			$tstr .= $chr;
			$tlen += $chrLen;
			$i ++;
		}
		if ($tstr != $str && $bool==true) {
			$tstr .= $ext;
		}
		return $tstr;
	}else{
		return '';
	}
}
function str_len($str,$aLen=0)
{
	$length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
	if($aLen!=0){
		return strlen($str);
	}elseif($length>0){
		return strlen($str)- intval($length / 3);
	}else
	{
		return strlen($str);
	}
}

/**
 * 格式化日期为需要的格式
 *
 * @param date $date 日期
 * @return date 
 */
function f_t($date,$tag = "Y-m-d H:i"){
	return date( $tag,($date));
}

/**
	 * 过滤FCK等编辑器产生的样式信息
	 *
	 * @param string $html
	 * @return $html
	 */
function format_html_tags($html){
	if($html){
		$regexp = array(
		'/style="(.*)"/iU',
		'/class="(.*)"/iU',
		'/lang="(.*)"/iU',
		'/<([\s]+)?\/{0,1}([\s]+)?div(.*)>/iU',
		'/<([\s]+)?\/{0,1}([\s]+)?font(.*)>/iU',
		'/<([\s]+)?\/{0,1}([\s]+)?span(.*)>/iU',
		'/<([\s]+)?\/{0,1}([\s]+)?strong(.*)>/iU',
		'/<([\s]+)?\/{0,1}([\s]+)?em(.*)>/iU',
		'/<([\s]+)?\/{0,1}([\s]+)?b(.*)>/iU',
		'/<([\s]+)?hr(.*)[\s]+\/{0,1}>/iU',

		'/　　/iU',
		'/&nbsp;/iU',
		'/<([\s]+)?(\/)?([\s]+)?(h[\d]?)(.*)>/iU',
		);
		$value = array('','','','','','','','','','','','','<$2h1>');
		$html = preg_replace($regexp,$value,$html);
	}
	return $html;
}

/**
 * 删除所有HTML代码
 *
 * @param string $html
 * @return string
 */
function delete_html_tags($html){
	$html = strip_tags($html);
	$html =str_replace('&nbsp;','',$html);
	$html =str_replace('&quot;','',$html);
	$html =str_replace('&mdash;','',$html);
	$html =str_replace('&ldquo;','',$html);
	$html =str_replace('&rdquo;','',$html);
	$html =str_replace(' ','',$html);
	$html =str_replace('	','',$html);
	$order   = array("\r\n", "\n", "\r");
	$html=str_replace($order, '', $html);
	return $html;
}


/**
     * 对RSS内容content数据样式过滤(过滤掉h1-h6为p标签,过滤strong,过滤em,过滤b,过滤font)
     * 2012-6-27  robert Zeng
     *
     * @param string $html html代码
     * @return string html代码
     */
     function strip_rss_tags($html){
        if(!$html) return '';
        $regexp = array(
        '/style="(.*)"/iU',
        '/<([\s]+)?\/{0,1}([\s]+)?font(.*)>/iU',
        '/<([\s]+)?\/{0,1}([\s]+)?strong(.*)>/iU',
        '/<([\s]+)?\/{0,1}([\s]+)?em(.*)>/iU',
        '/<([\s]+)?\/{0,1}([\s]+)?b(.*)>/iU',
        '/<([\s]+)?(\/)?([\s]+)?(h[\d]?)(.*)>/iU',
        );

        $value = array('','','','','','<$2p>');
        $html = preg_replace($regexp,$value,$html);
        //$html = mysql_escape_string($html);
        //        $order = array("'\r\n'", "'\n'", "'\r'","'\s+'","'&nbsp;'");//正则匹配回车，换行，空格
        //        $replace = array('','','','','');
        //        $html = preg_replace($order,$replace,$html);//替换匹配
        return $html;
    }
?>
