<?php
/**
 * 症状分类
 *
 */
class Version extends Controller{
	
	/**
	 * 标识此接口版本
	 *
	 */
	function info(){
		$data = array(
			'ver'=>'1.7',
			'url'=>'http://www.freeradio.cn/pet/html5/17.apk',
 			//'url'=>'http://www.missmis.com/public/pet/html5/17.apk',
			'note'=>"更新内容：\r\n1、接口地址迁移，增强接口稳定。\r\n2、搜索联想词更快的响应速度",
		);
		$this->sucess($data);
	}
}
