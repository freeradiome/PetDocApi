<?php
/**
 * V9新闻
 *
 */
class Positions extends Application{

	protected  $_tablename = 'v9_position_data'; //绑定数据库

	//模型对应id
	private $_posid = 18;

	function slide_lists($catid=array(),$module= 'content'){
		$condtion = array();
		$condtion['module'] = $module;
		$condtion['thumb'] = "{ <>0 }";
		$condtion['siteid'] = 1;
		if($catid){
			$condtion['catid'] =  "{ in (".implode(',',$catid).") }";
		}
		$lists = $this->item('id,data')->lists($condtion,array('id'=>'desc'),0,10);
		return $lists;
	}

}