<?php
/**
 * 疾病
 *
 */
class Historys extends  Application{

	protected  $_tablename = 'search_history'; //绑定数据库



	/**
	 * 获取联想词
	 *
	 */
	function think_list($word,$number){
		$condition = array();
		$order = array();
		$order['count'] = 'desc';
		$condition['number'] = "{ >0 }";
		$condition['{sql}'] = " ( `name` like '%$word%' )";
		$lists = $this->item('id,`name`,`count`,`number`')->lists($condition,$order,0,$number);
		
		return $lists;
	}

	/**
	 * 获取热门词
	 *
	 */
	function hot_list($number){
		$condition = array();
		$order = array();
		$order['count']='desc';
		$condition['number'] = "{ >0 }";
		$lists = $this->item('id,`name`,`count`,`number`')->lists($condition,$order,0,$number);
		return $lists;
	}

	/**
	 * 获取一个词在符合的记录数
	 *
	 * @param unknown_type $word
	 * @return unknown
	 */
	function think_word_ill_count($word){
		$ill = new Illnesses();
		return $ill->ill_count(0,$word);
	}
	/**
	 * 刷新一个词
	 *
	 * @param unknown_type $word
	 */
	function touch($word){
		if( $word){
			$info = $this->view( array('name'=>$word));
			if( $info ){
				//更新记录
				$condition = array('id'=>$info['id']);
				//			$this->update( $condition ,array('number'=>$this->think_word_ill_count($word)));
				return $this->increase($condition , array('count'=>1));
			}else{
				$il = new Illnesses();
				$word_tyc = $il->get_tyc($word);
				$word_tyc = ($word_tyc)?$word_tyc:$word;
				$ill = new Illnesses();
				$number =$ill->count(array('konwledge_active'=>1,'{sql}'=>'( knowledge_title like "%'.$word_tyc.'%" or knowledge_zz like "%'.$word_tyc.'%" )'),'knowledge_id');
				return $this->add(array(
				'name'=>$word,
				'count'=>1,
				'number'=>$number,
				));
			}
		}
	}

}