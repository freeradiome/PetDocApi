<?php
/**
 * 用户收藏
 *
 */
class Fav extends Controller{
	
	/**
	 * 获取收藏列表
	 *
	 */
	function lists(){
		$uid = trim(_g('uid'));
		if(!$uid){
			$this->get_params_error('设备号为空!');
		}
		$fav = new Favs();
		$list = $fav->fav_list($uid);
		$data = array();
		$ill = new Illnesses();
 
		foreach ($list as $k=>$v){
			$info = $ill->item('knowledge_id as id,knowledge_title as title,knowledge_middlertype as master')->view(array('knowledge_id'=>$v['ill_id']));
			$info['master'] = Illnesses::$_master_type_list[$info['master']];
			$info['created_at'] = date('Y-m-d', strtotime($v['created_at']) );
			$info['pic'] = PUBLIC_ROOT.'kownpic/'.$info['id'].'.jpg';
			$data[$k] = $info;
		}
		$this->sucess($data);
	}
	
	/**
	 * 添加一条
	 *
	 */
	function add(){
		$uid = trim(_g('uid'));
		$id = trim(_g('id'));
		if(!$uid || !$id){
			$this->get_params_error('参数为空!');
		}
		$fav = new Favs();
		
		$result =$fav->add_fav($id,$uid);
		
		$this->sucess($result);
	}
	/**
	 * 删除一条
	 *
	 */
	function delete(){
		$uid = trim(_g('uid'));
		$id = trim(_g('id'));
		if(!$uid || !$id){
			$this->get_params_error('参数为空!');
		}
		$fav = new Favs();
		$result =$fav->delete_fav($id,$uid);
		$this->sucess($result);
	}
}
?>