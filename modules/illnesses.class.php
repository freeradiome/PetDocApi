<?php
/**
 * 疾病
 *
 */
class Illnesses extends  Application{

	protected  $_tablename = 'knowledge'; //绑定数据库

	static public $_master_type_list = array(
	'0'=>'犬类',
	'1'=>'猫类',
	'2'=>'犬猫',
	'4'=>'其他动物'
	);
	/**
	 * 获取分类下的疾病列表
	 *
	 * @param unknown_type $id
	 */
	function ill_count($id,$word=''){
		$condition = array();
		if($id){
			$condition['kmowledge_smalltype'] = $id;
		}
		$condition['konwledge_active'] = 1;
		if( $word ){
			$condition['{sql}'] ='( knowledge_title like "%'.$word.'%" or knowledge_zz like "%'.$word.'%" )';
		}
		//order by knowledge_see_num desc,knowledge_bbs_num desc
		$info = $this->count($condition,'knowledge_id');

		return $info ;
	}
	
	/**
	 * 得到某词的同义词
	 *
	 * @param unknown_type $word
	 */
	public  function get_tyc($word){
		$tyck = new Tyck();
		$info = 	$tyck->item('tyck_cname as name')->view(array('tyck_illname'=>$word));
		return $info['name'];
	}
	/**
	 * 获取分类下的疾病列表
	 *
	 * @param unknown_type $id
	 */
	function ill_list($id,$start,$limit,$word=''){
		//order by knowledge_see_num desc,knowledge_bbs_num desc
		$condition = array();
		if($id){
			$condition['kmowledge_smalltype'] = $id;
		}
		$condition['konwledge_active'] = 1;
		if( $word ){
			$word_cyck = $this->get_tyc($word);
			if( $word_cyck ){
				$word = $word_cyck;
			}
			
			$condition['{sql}'] ='( knowledge_title like "%'.$word.'%" or knowledge_zz like "%'.$word.'%" )';
		}
		$info = $this->item('knowledge_id as id,kmowledge_smalltype as catname,knowledge_title as title,knowledge_tags as other_name,knowledge_middlertype as master,knowledge_bigtype as normal')->lists($condition,array('knowledge_bigtype'=>'desc','knowledge_see_num'=>' desc'),$start,$limit);
		
		return $info ;
	}
	/**
	 * 获取分类下的疾病信息
	 *
	 * @param unknown_type $id
	 */
	function ill_info($id){
		$info = $this->item('knowledge_id as id,knowledge_title as title,knowledge_tags as other_name,knowledge_content as content,knowledge_middlertype as master,kmowledge_smalltype as catname')->view(array('knowledge_id'=>$id,'konwledge_active'=>1));
		$info['content'] =htmlspecialchars_decode( $info['content'] ) ;

		return $info ;
	}
}