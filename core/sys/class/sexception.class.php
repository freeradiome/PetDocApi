<?php 
/**
 * 说明：系统异常处理
 * 作者：RobertZeng <zeng444@163.com>
 * 日期：2011-09-01
 * 版本：1.0
 */
class sException extends Exception {

	/**
	 * 抛出异常
	 *
	 * @param array $error_array
	 * @param string $errstr
	 * @param int $errno
	 */
	public static function __exception_handler($e){
		$errno = 400 ;
		if(debug==true){
			$errstr = $e->getMessage();
			self::__display( $errno,  array() , $errstr );
			exit();
		}else{
			$errstr='内部服务错误';
			self::__display( $errno, array(),$errstr );
		}
	}

	/**
	 * 抛出错误
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 */
	public static function __error_handler($errno,$errstr,$errfile,$errline){
		$errno = 500 ;
		if( debug==true ){
			if( $errno==E_NOTICE||$errno==E_WARNING||$errno==E_STRICT ){
//							if( $errno==E_WARNING||$errno==E_STRICT ){
				return;
			}
			
			self::__display( $errno, array(),$errfile.$errline.$errstr );
			exit();
		}else{
			$errstr='内部服务错误';
			self::__display( $errno, array(),$errstr );
			//echo '没有开启调试!';
			//die();
		}
	}


	/**
	 * 记录错误或者异常到日志
	 *
	 * @param unknown_type $message
	 * @return unknown
	 */
	public static function save_error_log($error_array,$errstr,$errno){
		return true;
	}


	/**
	 * 渲染模板
	 *
	 * @param array $error_array
	 * @param string $errstr
	 * @param int $errno
	 */
//	public static function __display($error_array,$errstr,$errno){
//
//		define( 'debug_tpl',CORE_PATH.'sys/class/exceptionfile/error.html' ); //错误日志调试
//		if(defined('logged') && logged){
//			self::save_error_log($error_array,$errstr,$errno);
//		}
//		if( defined('debug_tpl') && file_exists(debug_tpl) ){
//			include_once( debug_tpl );
//		}else {
//				
//			die('没有定义处理异常的渲染模板！');
//		}
//
//	}
	public static function __display($status,$results,$message='',$token=array()){
		$result  = array();
		$result['message'] = $message;
		$result['results'] = ( $results ) ? $results : array();
		$result['status'] = $status;
		if($token ){
			$result['token'] = $token;
		}
//		require(ROOT_PATH.'core/util/json.class.php');
//		echo jsonEncode($message);
		if( isset( $_GET['debug'] ) ){
			echo '<pre>';
			print_r($result);
			echo '</pre>';
		}else{
			
			$json =  json_encode($result);
//		$json = str_replace('\r\n','\n',$json);
			if(isset($_GET['callback'])){
				$json = $_GET['callback'].'('.$json.')';
			}
			echo $json;
		}
		exit();
	}


}

?>