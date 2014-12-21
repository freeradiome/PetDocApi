<?php 
/**
 * 说明：控制器基类(token失败后不阻止数据输出)
 * 作者：RobertZeng <zeng444@163.com>
 * 日期：2011-10-12
 */
class Controller extends cBase{
	
	protected $_token = array(); //当前用户登录状态token
 
	public function filter(){
		
		//当Content-Type不为multipart/form-data时$_POST为空，从流中获取数据
		//		if(!$_POST){
		//获取原生$_POST，Content-Type为application/x-www-form-urlencoded时，$_POST数据与php://input一致
		//			$_post_stream = ($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents("php://input");
		//			parse_str($_post_stream,$_POST);
		//		}
//		$token = trim(_g('token'));
//		$accessTokens = new accessTokens();
//		$this->_token =  $accessTokens->check( $token );

	}


	/**
	 * 终端输出
	 *
	 * @param int $status 状态码 200成功 500内部路由错误 60* 各种错误
	 * 错误码
	 * 600  默认的控制器错误
	 * 
	 * @param array $results 结果数据
	 * @param string $message 输出信息（错误信息等）
	 */
	protected  function response($status,$results,$message='',$token=array()){
		sException::__display($status,$results,$message,$token);
	}
	
	/**
	 * 快速终端输出成功的列表
	 *
	 * @param array $results 结果数据
	 */
	protected function sucess($results,$message='',$with_token=true){
		self::response(200,$results,$message,($with_token)?$this->_token:false);
	}
	
	
	
	/**
	 * 快速终端输出错误的信息
	 *
	 * @param int $error_code 错误码自动识别错误提示
	 */
	protected function error($message){
		self::response(600,array(),$message,array());
	}
	
	protected function get_params_error($msg=''){
		$msg = ($msg )?$msg:'接口参数不全';
		self::response(700,array(),$msg,array());
	}

}
?>