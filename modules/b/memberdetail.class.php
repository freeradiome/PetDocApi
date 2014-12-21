<?php
/**
 * v9会员模型
 *
 */
class Memberdetail extends Application{

	protected  $_tablename = 'v9_member_detail'; //绑定数据库

	
	
	function info($uid){
		return $this->view(array(
		'userid'=>$uid));
	}
}