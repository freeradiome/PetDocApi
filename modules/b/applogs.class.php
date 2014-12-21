<?php
/**
 * app用户登录和注册日志
 *
 */
class appLogs extends  Application{

	protected  $_tablename = 'app_member_logs'; //绑定数据库
	
	private $_login_timezone = 1 ; //单位时间 分
	
	private $_login_timezone_count = 60 ; //单位时间内允许的用户错误登录数
	
	private $_reg_timezone = 1 ; //单位时间 分
	
	private $_reg_timezone_count = 60 ; //单位时间内允许的注册用户数
	/**
	 * 插入一条注册日志
	 *
	 * @param string $username 用户名
	 * @param bool $bool
	 * @return bool
	 */
	public function register($username,$bool){
		return $this->add(array(
			'username'=>$username,
			'type'=>'register',
			'iplong'=>get_client_ip(),
			'status'=> ($bool)?1:2
		));
	}
	
	/**
	 * 插入一条登录日志
	 *
	 * @param string $username
	 * @param bool $bool
	 * @return bool
	 */
	public function login($username,$bool){
		return $this->add(array(
			'username'=>$username,
			'type'=>'login',
			'iplong'=>get_client_ip(),
			'status'=> ($bool)?1:2
		));
	}

	
	/**
	 * 单位时间内登陆用户数检查，是否可登录
	 *
	 * @param string $username 用户名
	 * @return bool 
	 */
	public function is_below_error_login_count($username){
		$date = date('Y-m-d H:i:s',time()-60* $this->_login_timezone) ;
		$count =  $this->count(array('username'=>$username,'`type`'=>'login','status'=>2,'created_at'=>"{ > '.$date.' }")); //单位时间内登录次数
		if($count < $this->_login_timezone_count ){
			return true;
		}
	}
	
	/**
	 * 单位时间内注册成功用户数检查，是否可再注册
	 *
	 * @param string $username 用户名
	 * @return bool
	 */
	public function is_below_sucess_login_count(){
		$date = date('Y-m-d H:i:s',time()-60* $this->_reg_timezone) ;
		$count =  $this->count(array('iplong'=>get_client_ip(),'`type`'=>'register','status'=>1,'created_at'=>"{ > '.$date.' }")); //单位时间内登录次数
		if($count < $this->_reg_timezone_count ){
			return true;
		}
	}
	
}