<?php
/**
 * v9会员模型
 *
 */
class Members extends Application{

	protected  $_tablename = 'v9_member'; //绑定数据库


	/**
	 * 是否已经注册此邮箱
	 *
	 * @param unknown_type $mail
	 * @return unknown
	 */
	function is_exist_user_email($mail){
		$result =  $this->view(array(
			'email'=>$mail
		));
		return ($result)?true:false;
	}


	/**
	 * 用户登录逻辑
	 *
	 * @param string $username 用户名
	 * @param string $password 密码
	 * @return array 返回用户信息
	 */
	function login($username,$password){


		$msg = array(
		'code'=>0,
		'msg'=>'',
		'userinfo'=>null
		);
		$appLogs = 	new appLogs();
		$is_below_error_login_count = $appLogs->is_below_error_login_count($username);
		if( !$is_below_error_login_count ) {
			$msg['msg'] = '错误次数太多，禁止登录!';
			return $msg;
		}
		$condition = array();
		if( !Members::is_mail( $username ) )  {
			$condition['username'] = $username;
		}else{
			$condition['email'] = $username;
		}
		$userinfo = $this->view($condition);
		if( $userinfo ){

			if( $userinfo['islock'] ){
				$msg['msg'] = '用户账户被锁定了!';
				return $msg;
			}else  if( $userinfo['password'] !=md5(md5(trim($password)).$userinfo['encrypt'])  ){
				$msg['msg'] = '密码错误!';
				return $msg;
			}

		}
		$msg['msg'] = '登录成功!';
		$msg['msg']=1;
		$msg['userinfo']=array(
		'userid'=>$userinfo['userid'],
		'email'=>$userinfo['email'],
		'username'=>$userinfo['username'],
		'nickname'=>$userinfo['nickname']
		);
		$appLogs->login($username, ($msg['msg']==1) ?1 :2 );
		//islock
		return $msg;
	}

	/**
	 * 用户注册逻辑
	 *
	 * @param unknown_type $username
	 * @param unknown_type $password
	 * @return array 返回用户信息
	 */
	function register($username,$nickname,$cname,$mobile,$duty,$rtype,$password,$email,$idno){

		$msg = array(
		'status'=>0,
		'msg'=>'',
		'member_info'=>null
		);
		$appLogs = 	new appLogs();
		$is_below_sucess_login_count = $appLogs->is_below_sucess_login_count();
		if(!$is_below_sucess_login_count){
			$msg['msg'] = '单位时间内注册次数过多!';
			return $msg;
		}
		$phpsso = new phpsso();
		$userinfo=  array();
		$time = time();
		$userinfo['username'] = $username;
		$userinfo['encrypt'] = $this->create_randomstr(6);
		$userinfo['password']= md5(md5(trim($password)).$userinfo['encrypt']);
		$userinfo['regip'] = get_client_ip();
		$userinfo['email'] = $email;

		$info = $this->view(array('username'=>$userinfo['username']));
		if($info){
			$msg['msg'] = '用户名已经存在！';
			return $msg;
		}else{

			if( $userinfo['phpssouid'] = $phpsso->reg($userinfo['username'],$userinfo['password'],$userinfo['email'],$userinfo['regip'],	$userinfo['encrypt']) ){

				$userinfo['nickname'] = $nickname;
				$userinfo['regdate'] = $time;
				$userinfo['lastdate'] = $time;
				$userinfo['lastip'] = '';
				$userinfo['groupid'] =2;
				$userinfo['modelid'] = 10;
				$userinfo['connectid'] = '';
				$userinfo['from'] = '';

				if(  $this->add($userinfo,false,false) ){
					//					if($rtype==2){
					$companys = new Companys();
					$companys->register($this->_last_insert_id,$duty,$cname,$mobile,$idno,$rtype);
					//					}
					$accessTokens = new accessTokens();
					$msg['status'] = 1;
					$msg['msg'] = '注册成功！';
					$token =  $accessTokens->get($userinfo['username'],$password);
					$msg['member_info']=$token['member_info'];
				}
			}
		}
		$appLogs->register($username, ($msg['msg']==1) ?1 :2);
		return $msg;
	}

	/**
	 * 通过token获取用户的信息
	 *
	 * @param strng $token token值
	 * @return array 
	 */
	function userinfo($token){
		$accessTokens = new accessTokens();
		$token_info = $accessTokens->info($token);
		$result = array();
		if( $token_info ){
			$uid = $token_info['userid'];
			$member_info = $this->view(array('userid'=>$uid));
			$memberdetail = new Memberdetail();
			$member_info_detail = $memberdetail->info($uid);
			$result['userid'] = intval($uid); //用户名
			$result['username'] = $member_info['username']; //用户名
			$result['nickname'] = $member_info['nickname']; //昵称
			$city = new Citys();
			$city_info = $city->view(array('linkageid'=>$member_info_detail['larea']));
			$result['city'] =str_replace('市','',$city_info['name']); //城市
			$result['sex'] = strval($member_info_detail['psex']); //性别
			$result['birthday'] = strval($member_info_detail['birthday']); //生日
			$result['weibo'] = strval($member_info_detail['weibo']); //微博
			$company = new Companys();
			$company_info = $company->get_info($uid);
			$result['web'] = strval($company_info['web_url']); //官网
			$result['realname'] = strval($company_info['linkman']); //官网
			$result['mobile'] = strval($company_info['mobile']); //手机号码
			$result['email'] = strval($member_info['email']); //邮箱
			$result['company'] = strval($company_info['companyname']); //公司名
			$result['products'] = strval($company_info['products']); //经营范围
			$result['intro'] = strval($member_info_detail['pcontent']); //个人介绍


		}
		return $result;
	}

	/**
	 * 修改用户信息
	 *
	 * @param unknown_type $token
	 * @param unknown_type $nickname
	 * @param unknown_type $realname
	 * @param unknown_type $city
	 * @param unknown_type $sex
	 * @param unknown_type $birthday
	 * @param unknown_type $weibo
	 * @param unknown_type $web
	 * @param unknown_type $mobile
	 * @param unknown_type $company
	 * @param unknown_type $products
	 * @param unknown_type $pcontent
	 * @return unknown
	 */
	function update_info( $token ,$nickname,$realname,$city,$sex,$birthday,$weibo,$web,$mobile,$company,$products,$pcontent){
		$accessTokens = new accessTokens();
		$token_info = $accessTokens->info($token);
		if($token_info){
			$condition = array('userid'=> $token_info['userid']);
			$uid = $token_info['userid'];
			$data = array();
			if( $nickname ) $data['nickname'] = $nickname;
			if($data )  $this->update($condition,$data,false);
			$data = array();
			if( $sex ) $data['psex'] = $sex;

			$city_obj = new Citys();
			$city_info = $city_obj->view(array('name'=>$city.'市'));

			if( $city ) $data['larea'] = $city_info['linkageid'];
			if( $birthday ) $data['birthday'] = $birthday;
			if( $weibo ) $data['weibo'] = $weibo;
			if( $pcontent ) $data['pcontent'] = $pcontent;
			if( $data ){
				$memberdetail = new Memberdetail();
				if( $memberdetail->view($condition) ){
					$memberdetail->update($condition,$data,false);
				}else{
					$data['userid'] = $token_info['userid'];
					$memberdetail->add($data,false,false);
				}
			}

			$data = array();
			if( $web ) $data['web_url'] = $web;
			if( $realname ) $data['linkman'] = $realname;
			if( $mobile ) $data['mobile'] = $mobile;
			if( $company ) $data['companyname'] = $company;
			if( $products ) $data['products'] = $products;
			if( $data ){
				$company_obj = new Companys();
				$company_obj->update($condition,$data,false);
			}

			return true;
		}

	}


	/**
	 * 检查是否为手机号码
	 *
	 * @param string $mobile 手机号码
	 * @return bool
	 */
	public static 	function  is_mobile($mobile){
		$regexp = "/^(1)[0-9]{10}$/";
		if( preg_match($regexp,$mobile)){
			return true;
		}
	}

	public static function is_mail($mail){
		return preg_match( '/^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/',$mail);
	}
	/**
	 * V9_生成随机字符串
	 * @param string $lenth 长度
	 * @return string 字符串
	 */
	private function create_randomstr($lenth = 6) {
		return $this->random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
	}

	/**
	* V9_产生随机字符串
	*
	* @param    int        $length  输出长度 
	* @param    string     $chars   可选的 ，默认为 0123456789
	* @return   string     字符串
	*/
	private function random($length, $chars = '0123456789') {
		$hash = '';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
		return $hash;
	}

}
?>