<?php 
/**
 * 我的收藏				
 *
 */
class Favarites extends Application{

	protected  $_tablename = 'app_favarites'; //绑定数据库

	/**
	 * 是否收藏
	 *
	 * @param int $uid 用户ID
	 * @param int $sid 帖子源ID
	 * @param int $type 类型
	 * @return array
	 */
	function is_favorite($uid,$sid,$type){
		if(!$uid) return false;
		return $this->view(array(
		'userid'=>$uid,
		'sid'=>$sid,
		'type'=>$type
		));
	}
	/**
	 * 添加收藏
	 *
	 * @param int $id 原帖ID
	 * @param int $type 类型 1为新闻 2为产品
	 * @return bool
	 */
	function saves($id,$uid,$type){
		if( !$this->is_favorite($uid,$id,$type) ){
			$data = array();
			$data['sid'] = $id;
			$data['type'] = $type;
			$data['userid'] = $uid;
			return 	$this->add($data);
		}
	}

	/**
	 * 删除收藏
	 *
	 * @param int $id 原帖ID
	 * @return bool
	 */
	function remove($id,$sid,$uid,$type){
		$condition = array();
		if($id){
			$condition['id'] = $id;
		}else{
			$condition['sid'] = $sid;
		}
		$condition['userid'] = $uid ;
		if($type) $condition['type'] = $type;
		return 	$this->delete( $condition );
	}

	/**
	 * 我收藏的列表
	 *
	 * @param int $uid
	 * @param int $start
	 * @param int $limit
	 * @return array
	 */
	function fav_lists($uid,$start,$limit){
		$condition = array();
		$condition['userid'] = $uid;
		$count = $this->count($condition);
		$is_end = ($count > $start+$limit ) ?  0 :1;
		$list = $this->lists($condition,array('id'=>'desc'),$start,$limit);
		$json = array();
		$articles = new articles();
		$trade = new Trade();
		foreach ( $list as $k=>$v){

			if( $v['type']==1){
				$info =  $articles->article_info($v['sid'],$uid);
				$json[$k] = $info;
				$json[$k]['sid'] = (int)$info['id'];
			}else{
				$info =$trade->trade_info($v['sid'],$uid);
				$json[$k] = $info;
				$json[$k]['sid'] = (int)$info['id'];
			}
			
			$json[$k]['id'] = (int)$v['id'];
		}
		return array(
		'is_end'=>$is_end,
		'data'=>$json
		);
	
	}


}
?>