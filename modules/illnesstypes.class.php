<?php
/**
 * 疾病分类
 *
 */
class Illnesstypes extends  Application{
	
	protected  $_tablename = 'illnesstype'; //绑定数据库
	
	/**
	 * 获取疾病分类
	 *
	 */
	function cat_list(){
		return $this->item(array('illnesstype_id as id','illness_illtype as name',))->lists(array(),array('illnesstype_desc'=>'asc','illnesstype_num'=>'desc'),0,200);
	}
}