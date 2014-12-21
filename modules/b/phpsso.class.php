<?php
/**
 * v9 php sso
 *
 */
class phpsso extends Application{

	protected  $_tablename = 'v9_sso_members'; //绑定数据库
			
	function reg($username,$password,$email,$regip,$encrypt){
		if(!$username || !$password || !$email){
			return false;
		}
		$time = time();
		$data = array();
		$data['username']=$username;
		$data['password']=$password;
		$data['email']=$email;
		$data['random']=$encrypt;
		$data['regip']=$regip;
		$data['regdate']=$time; 
		$data['lastip']=$regip; //need update
		$data['lastdate']=$time; //need update
		$data['appname']='phpcms v9'; //need update
		$data['type']='app'; //need update
		$data['avatar']='0'; //need update
		$data['ucuserid']='0'; //need update
		if ($this->add($data,false,false) ){
			return $this->_last_insert_id;
		}
		//insert into `v9_sso_members` (`uid`, `username`, `password`, `random`, `email`, `regip`, `regdate`, `lastip`, `lastdate`, `appname`, `type`, `avatar`, `ucuserid`) 
							   //values('1','zenggege','8dc2127bbc5c6e5017a061f0c867ef6f','JqHPnU','5@163.com','127.0.0.1','1369926971','0','1369926971','phpcms v9','app','0','0');

	}
	
	
}

?>