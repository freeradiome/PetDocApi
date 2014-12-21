<?php
/**
 * 用户收藏
 *
 */
class Favs extends  Application{

	protected  $_tablename = 'user_favs'; //绑定数据库
	
	/**
	 * 读取列表
	 */
	function fav_list($uid){
		
		return $this->item('id,ill_id,created_at')->lists(array('unqiue_device_id'=>$uid),array('id'=>'desc'),0,200);
	}
	
	/**
	 * 添加一条
	 *
	 */
	function add_fav($illid,$uid){
		$info = $this->item('id')->view(array('unqiue_device_id'=>$uid,'ill_id'=>$illid));
		if( !$info ){
			return $this->add(array(
				'unqiue_device_id'=>$uid,
				'ill_id'=>$illid
			));
		}
	}
	
	/**
	 * 删除一条
	 *
	 */
	function delete_fav($illid,$uid){
		return $this->delete(array(
				'unqiue_device_id'=>$uid,
				'ill_id'=>$illid
			));
	}
	
}