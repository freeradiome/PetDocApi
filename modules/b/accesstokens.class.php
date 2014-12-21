<?php
/**
 * app的认证会话凭证
 *
 */
class accessTokens extends  Application{
	
	protected  $_tablename = 'app_access_tokens'; //绑定数据库
	
	private  $_token_tikect = 'lpSh_90$@('; //用于生成token的加密串
	
	private $_token_expire =6048000 ; //token过期时间 单位秒 70tian
		
	//token验证返回的状态信息
	private $_token_status_message = array(
		1=>'已经登录',
		2=>'身份验证失败',
		3=>'登录时间太长请重新登录',
		4=>'用户帐号被禁用',
		5=>'无身份凭证'
	);

	
	/**
	 * 检查token是否合法
	 *
	 * @param string $token  token值
	 * @return array 返回关联数组确认 array(result=>'信息号','msg'=>'提示信息')
	 */
	public function check($token){
		$msg = array(
			'code'=>1,
			'msg'=>$this->_token_status_message[1]
		);
		if(!$token){
			$msg['code'] = 5;
			$msg['msg']=$this->_token_status_message[5];
			return $msg; 
		}
		$token = $this->view(array( 'access_token'=>$token ));
		//没有登录或者密码已经被更改
		if( !$token ){ 
			$msg['code'] = 2;
			$msg['msg']=$this->_token_status_message[2];
			return $msg; 
		}
		//登录超时
		if( time() - strtotime($token['updated_at'])>$this->_token_expire ){
			$this->delete(array('userid'=>$token['userid']));
			$msg['code'] = 3;
			$msg['msg']=$this->_token_status_message[3];
			return $msg; 
		}
		//用户是否被锁定
		$Members = new Members();
		$member_info = $Members->view(array('userid'=>$token['userid']));
		if( $member_info['islock'] ){
			$msg['code'] = 4;
			$msg['msg']=$this->_token_status_message[4];
			return $msg; 
		}
		//无异常的回调update
		$this->update(array('access_token'=>$token['access_token'])) ; 
		return $msg;
	}
	
	/**
	 * 获取指定token下的用户信息
	 *
	 * @param string $token 用户token
	 * @return array token用户信息
	 */
	public function info($token){
		
		$result = $this->view(array('access_token'=>$token));	
		return $result ;
	}
	
	/**
	 * 检查用户密码下的用户是否存在
	 * 如果存在则生成token并返回用户信息
	 *
	 * @param string $username v9用户名
	 * @param string $password v9密码
	 * @return mixed 返回用户的信息或者false
	 */
	public function get($username,$password){
		
		//验证V9是否在的用户名
		$members = new Members();
		$member_info = $members->login($username,$password);
		
		$msg = array( 'status'=>0,'msg'=>'','member_info'=>null);
		
		if( $member_info['userinfo']['userid'] ) {
			
			//获得用户的token
			$token_info = $this->view( array('userid'=>$member_info['userinfo']['userid']) );
			if(  $token_info ){
				//更新最后使用时间
			
				$this->update(array('userid'=>$member_info['userinfo']['userid'])) ; 
			}else{
				//没有token信息时插入
				$token_info['access_token'] = $this->generate_token($username,$password);
				$this->add(array(
					'userid'=>$member_info['userinfo']['userid'],
					'iplong'=>get_client_ip(),
					'username'=>$member_info['userinfo']['username'],
					'access_token'=>$token_info['access_token'],
				));
			}
			$msg['status']=1;
			$msg['msg'] = $this->_token_status_message[1];
			$avatars = new Avatars();
			$trade = new Trade();
			//附加信息
			$member = new Members();
			$member_info_detail = $member->userinfo( $token_info['access_token'] );
			
			$msg['member_info']=array(
				'userid'=>intval($member_info['userinfo']['userid']),
				'email'=>$member_info['userinfo']['email'],
				'nickname'=>$member_info['userinfo']['nickname'],
				'username' =>$member_info['userinfo']['username'],
				'access_token'=>$token_info['access_token'],
				'is_checked'=> ( $trade->is_chekced_user($token_info['access_token']) ) ?1:0,
				'avatar'=>$avatars->get($member_info['userinfo']['userid']),
				'city'=>$member_info_detail['city'],
				'sex'=>$member_info_detail['sex'],
				'birthday'=>$member_info_detail['birthday'],
				'weibo'=>$member_info_detail['weibo'],
				'web'=>$member_info_detail['web'],
				'mobile'=>$member_info_detail['mobile'],
				'company'=>$member_info_detail['company'],
				'products'=>$member_info_detail['products'],
				'intro'=>$member_info_detail['intro'],
				'realname'=>$member_info_detail['realname'],
			);
			
			
		}else{
			$msg['status']=0;
			$msg['msg'] = $this->_token_status_message[2];
		}
		return $msg;
		
	}
	
	/**
	 * 通过用户名和密码生成token
	 *
	 * @param string $username 用户名
	 * @param string $password 密码
	 * @return string 
	 */
	private  function generate_token($username,$password){
		return md5( $username.$this->_token_tikect.$password );
	}
	
	/**
	 * 退出登录删除凭证
	 *
	 * @param string $token
	 * @return bool
	 */
	public function logout($token){
		return $this->delete(array(
			'access_token'=>$token
		));
	}
	
	
}
?>